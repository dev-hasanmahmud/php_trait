<?php

namespace App\Http\Controllers\Admin;

use App\Approving_authority;
use App\Camp;
use App\Component;
use App\Contactor;
use App\Data_table;
use App\File_manager;
use App\Http\Controllers\Controller;
use App\Indicator;
use App\Package_working_progress;
use App\Proc_method;
use App\Settings;
use App\Source_of_fund;
use App\Type;
use App\Unit;
use App\Validator\validatorForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PackageController extends Controller
{

    use validatorForm;
    protected $rules = array(
        'package_no' => 'required|unique:components,package_no',
        'name_en' => 'required|min:3',
        'name_bn' => 'nullable|min:3',
        'type_id' => 'required|numeric',
        'dpp_head' => 'nullable',
        'economic_head' => 'nullable',
        'unit_id' => 'required|numeric',
        'quantity' => 'required',
        'proc_method_id' => 'nullable|numeric',
        'review' => 'nullable|numeric',

        'approving_authority_id' => 'nullable|numeric',
        'source_of_fund_id' => 'nullable',
        'cost_tk_est' => 'required',
        'cost_tk_act' => 'nullable',
        'cost_usd_est' => 'required',
        'cost_usd_act' => 'nullable',
        'invitation_for_tender_est' => 'nullable|date|date_format:Y-m-d',
        'invitation_for_tender_act' => 'nullable|date|date_format:Y-m-d',

        'invitation_bid_indicative_submission_date' => 'nullable|date|date_format:Y-m-d',
        'invitation_bid_act_submission_date' => 'nullable|date|date_format:Y-m-d',
        'Actual_eva_bid_date' => 'nullable|date|date_format:Y-m-d',
        'approve_eva_report_pd_date' => 'nullable|date|date_format:Y-m-d',
        'issue_notifi_award_date' => 'nullable|date|date_format:Y-m-d',

        'signing_of_contact_est' => 'nullable|date|date_format:Y-m-d',
        'signing_of_contact_act' => 'nullable|date|date_format:Y-m-d',
        'complition_of_contact_est' => 'nullable|date|date_format:Y-m-d',
        'complition_of_contact_act' => 'nullable|date|date_format:Y-m-d',

        'complition_date' => 'nullable|date|date_format:Y-m-d',
        'contactors' => 'nullable',
        'dpp_cost' => 'nullable',
        'assigned' => 'nullable',

        'contract_price_act_bdt' => 'nullable',
        'contract_price_act_usd' => 'nullable',

        'extension_day_count' => 'nullable',
        'extension_date_act' => 'nullable',

        'remark' => 'nullable',

    );

    protected $rule_for_progress = array(
        'package_id' => 'required',
        'area_of_activities' => 'required',
        'area_of_activity_details' => 'nullable',
        'contactors' => 'nullable',
        'key_indicators' => 'nullable',
    );

    protected $search_rule = array(
        'package_no' => 'nullable',
        'name_en' => 'nullable',
        'type_id' => 'nullable',
    );
    protected $file = array(
        'agreement_1' => 'nullable|max:8',
    );

    public function index()
    {
        $component = Component::with('type')->latest()->paginate(20); //orderby('package_no')->
        $type = Type::all();
        $type_id = 1;
        return view('admin.package.index', compact('component', 'type', 'type_id'));
    }

    public function create()
    {
        $approving_authority_id = Approving_authority::all();
        $source_of_fund_id = Source_of_fund::all();
        $type_id = Type::all();
        $unit_id = Unit::all();
        $proc_method_id = Proc_method::all();

        return view('admin.package.create', compact('approving_authority_id', 'source_of_fund_id', 'type_id', 'unit_id', 'proc_method_id'));
    }

    public function store(Request $request)
    {

        $this->amount_convert($request);
        $message = [
            'package_no.unique' => 'The Package Number has already been taken.',
        ];
        //$response = $this->validationWithJson($request->all(),$this->file,$message);
        $response = $this->validationWithJson($request->all(), $this->rules, $message);

        if ($response === true) {
            $component_data = $this->getFormData($request->all(), $this->rules);
            // $this->amount_convert($component_data);
            //dd($component_data);
            $component_data['source_of_fund_id'] = json_encode($component_data['source_of_fund_id'], true);
            $component_data['contactors'] = json_encode($component_data['contactors'], true);
            $component_data['assigned'] = json_encode($component_data['assigned'], true);
            Component::create($component_data);
            $component = Component::latest()->first();
            if ($request->has('value_1')) {
                $this->store_component_data($request, $component['id']);
            }
            $this->file_upload($request, $component['id']);

            $this->insertCategoryOrder($component['type_id'], $component['id']);

            return redirect('/package')->with('toast_success', 'Component Created Successfully');
        }
        return back()->with('toast_error', $response)->withInput();
        //return back()->withInput();
    }

    public function show($id)
    {
        $component = Component::with('type', 'unit', 'proc_method', 'approving_authority')->findOrFail($id);
        $data = Data_table::where('component_id', $component->id)->first();
        $lavel = Settings::where('type_id', $component->type_id)->where('procurement_method_id', $component->proc_method_id)->orderBy('ordering')->get();

        $contractor_id = json_decode($component['contactors']);
        $source_id = json_decode($component['source_of_fund_id']);
        $assigned_id = json_decode($component['assigned']);

        $contractor = Contactor::whereIn('id', (array) $contractor_id)->get();
        $source = Source_of_fund::whereIn('id', (array) $source_id)->get();
        $assigned = Contactor::whereIn('id', (array) $assigned_id)->get();
        $payment = DB::select("SELECT SUM(w.`amount`) as total FROM works_package_payments AS w WHERE w.package_id=$id");
        $agreement_file = DB::select(" SELECT * FROM file_managers AS f WHERE f.`table_id`=$component->id AND f.`fm_category_id`=14 ");
        //dd($agreement_file);
        $file_list = DB::select(" SELECT * FROM file_managers AS f WHERE f.`table_id`=$component->id AND f.`fm_category_id`=5 ");
        return view('admin.package.show', compact('component', 'data', 'lavel', 'file_list', 'source', 'contractor', 'assigned', 'payment', 'agreement_file'));
    }

    public function edit($id)
    {

        $component = Component::findOrFail($id);
        $approving_authority_id = Approving_authority::all();
        // $source_of_fund_id = Source_of_fund::all();
        $type_id = Type::all();
        $id = (string) $component->type_id;

        $unit_id = DB::table('units')->whereJsonContains('type_id', $id)->get();
        $source_of_fund_id = DB::table('source_of_funds')->whereJsonContains('type_id', $id)->get();
        //$id = (string) $component->proc_method_id;
        //dd($id);
        $proc_method_id = DB::table('proc_methods')->whereJsonContains('type_id', $id)->get();

        if ($component->review == "Prior Review") {
            $component->review = 1;
        }
        if ($component->review == "Post Review") {
            $component->review = 2;
        }
        //dd($component);
        $file_list = DB::select(" SELECT * FROM file_managers AS f WHERE f.`table_id`=$component->id AND f.`fm_category_id`=5 ");
        $agreement_file = DB::select(" SELECT * FROM file_managers AS f WHERE f.`table_id`=$component->id AND f.`fm_category_id`=14 ");
        $data = Data_table::where('component_id', $component->id)->first();
        $lavel = Settings::where('type_id', $component->type_id)->where('procurement_method_id', $component->proc_method_id)->orderBy('ordering')->get();

        // dd($agreement_file);
        return view('admin.package.edit', compact('approving_authority_id', 'source_of_fund_id', 'type_id', 'unit_id', 'proc_method_id', 'component', 'file_list', 'data', 'lavel', 'agreement_file'));
    }

    public function update(Request $request, $id)
    {
        //dd($request->all());
        $this->amount_convert($request);
        $this->rules = collect($this->rules)->merge([
            'package_no' => 'required|unique:components,package_no' . ($id ? ",$id" : ''),
        ])->toArray();

        $message = [
            'package_no.unique' => 'The Package Number has already been taken.',
        ];

        $response = $this->validationWithJson($request->all(), $this->rules, $message);
        if ($response === true) {
            $component_data = $this->getFormData($request->all(), $this->rules);
            //dd($component_data);
            $component_data['source_of_fund_id'] = json_encode($component_data['source_of_fund_id'], true);
            $component_data['contactors'] = json_encode($component_data['contactors'], true);
            $component_data['assigned'] = json_encode($component_data['assigned'], true);

            Component::updateOrCreate(['id' => $id], $component_data);

            if ($request->has('value_1')) {
                $this->store_component_data($request, $id, true);
            } else {
                $up_id = Data_table::where('component_id', $id)->first();
                if ($up_id) {
                    $data = Data_table::findOrFail($up_id['id']);
                    $data->delete();
                }
            }

            $this->file_upload($request, $id, true);

            return redirect('/package')->with('toast_success', 'Component Updated Successfully');
        }
        //dd('no');
        return back()->with('toast_error', $response);
    }

    public function destroy($id)
    {
        $source = Component::findOrFail($id);
        //$this->authorize('delete',$source);
        //return 'helo';
        $source->delete();
        return $this->responseWithSuccess('Data Deleted successfully', 'success');
    }

    public function store_component_data($request = [], $id, $isupdate = false)
    {
        $value = array();
        for ($i = 1;; $i++) {
            $key = "value_" . $i;
            if ($request->has($key)) {
                //dd($request->$key);
                $value[$i - 1] = $request->$key;
            } else {
                break;
            }
        }
        $data['component_id'] = $id;
        $data['value'] = json_encode($value, true);
        if ($isupdate) {
            $up_id = Data_table::where('component_id', $id)->first();
            Data_table::updateOrCreate(['id' => $up_id['id']], $data);
        } else {
            Data_table::create($data);
        }
    }

    public function file_upload($request = [], $id, $isupdate = false)
    {
        $file_data = array();

        $file_data['fm_category_id'] = 5;
        $file_data['table_id'] = $id;
        $file_data['is_image'] = 0;
        $file_data['created_by'] = Auth::user()->id;

        $fm_update_id = array();
        $index = 0;
        $path = 'storage/procurement/';

        for ($i = 1; $i < 20; $i++) {
            $key = "file_" . $i;
            $title = "file_title_" . $i;
            $fm_id = "file_id_" . $i;
            if ($request->file($key)) {
                // dd('yes');
                if ($request->has($fm_id) && $isupdate) {
                    $fm_id = $request->$fm_id;
                    $old_file = File_manager::findOrFail($fm_id);
                    if (file_exists(public_path($old_file->file_path))) {
                        unlink(public_path($old_file->file_path));
                    }
                    //DB::table('file_managers')->where('is_image', 1)->where('table_id',$id)->delete();
                    $fileName = Str::random(25) . '-.-' . $request->$key->getClientOriginalName();
                    //$fileName =  "image-".Str::random(25).'.'.$request->$key->getClientOriginalExtension();
                    request()->$key->move(public_path('storage/procurement'), $fileName);
                    $file_data['file_path'] = $path . $fileName;
                    $file_data['name'] = $request->$title;
                    File_manager::updateOrCreate(['id' => $fm_id], $file_data);
                    $fm_update_id[$index++] = $fm_id;

                } else {
                    $fileName = Str::random(25) . '-.-' . $request->$key->getClientOriginalName();
                    //$fileName =  "image-".Str::random(25).'.'.$request->$key->getClientOriginalExtension();
                    request()->$key->move(public_path('storage/procurement'), $fileName);
                    $file_data['file_path'] = $path . $fileName;
                    $file_data['name'] = $request->$title;
                    File_manager::create($file_data);
                }

            } else if ($request->has($fm_id) && $isupdate) {
                $fm_id = $request->$fm_id;
                $fm_update_id[$index++] = $fm_id;
                $old_file = File_manager::findOrFail($fm_id);
                $old_file->name = $request->$title;
                $old_file->save();

            }
        }
        if ($isupdate) {
            $get_request_id = $request->file_id;
            $get_request_id = json_decode($get_request_id, true);
            $get_request_id = (array) $get_request_id;
            $length = count($get_request_id);

            for ($i = 0; $i < $length; $i++) {
                if (!in_array($get_request_id[$i], $fm_update_id)) {
                    $old_file = File_manager::findOrFail($get_request_id[$i]);
                    if (file_exists(public_path($old_file->file_path))) {
                        unlink(public_path($old_file->file_path));
                        //dd('yes');
                    }
                    DB::table('file_managers')->where('id', $get_request_id[$i])->where('table_id', $id)->delete();
                }
            }
        }

        // dd($request->all());
        if ($request->file('agreement_1') && $isupdate && $request->agreement_id != null) {
            //dd('yes');
            $old_file = File_manager::findOrFail($request->agreement_id);
            if (file_exists(public_path($old_file->file_path))) {
                unlink(public_path($old_file->file_path));
            }
            $file_data['fm_category_id'] = 39;
            $fileName = Str::random(25) . '-.-' . $request->agreement_1->getClientOriginalName();
            request()->agreement_1->move(public_path('storage/procurement'), $fileName);
            $file_data['file_path'] = $path . $fileName;
            $file_data['name'] = "Contract Agreement Document";
            File_manager::updateOrCreate(['id' => $request->agreement_id], $file_data);
        } else if ($request->file('agreement_1') && $isupdate == false || $request->file('agreement_1') && $isupdate) {
            // dd('se');
            $file_data['fm_category_id'] = 39;
            $fileName = Str::random(25) . '-.-' . $request->agreement_1->getClientOriginalName();
            request()->agreement_1->move(public_path('storage/procurement'), $fileName);
            $file_data['file_path'] = $path . $fileName;
            $file_data['name'] = "Contract Agreement Document";
            File_manager::create($file_data);
        }
        ///dd('no');
        return true;
    }

    public function package_settings()
    {
        // $p = (int) 566312678;
        // $s = (string) $p;
        // $s = strrev($s);
        // $b = ['6', '7', '8', ','];
        // $j = 4;
        // $check = 0;
        // $len = strlen($s);
        // // return $len;
        // for ($i = 3; $i < $len; $i++) {
        //     if ($check == 2) {
        //         $b[$j++] = ',';
        //         $check = 0;
        //     } else {
        //         $b[$j++] = $s[$i];
        //         $check++;
        //     }

        // }
        // return join('', $b);
        return view('admin/package/package_settings');
    }

    public function package_progrss($id)
    {
        //dd($id);
        $component = Component::findOrFail($id);
        //return $component;
        $package_progress = Package_working_progress::where('package_id', $id)->get();
        $camp = Camp::all();
        $contactor = Contactor::all();
        $indicator = Indicator::where('component_id', $id)->get();

        return view('admin.package.package_working_progrss', compact('package_progress', 'component', 'camp', 'contactor', 'indicator'));
    }

    public function package_progrss_store(Request $request, $id)
    {
        //dd($request->all());
        $response = $this->validationWithJson($request->all(), $this->rule_for_progress);
        if ($response === true) {
            $progress_data = $this->getFormData($request->all(), $this->rule_for_progress);
            $progress_data['area_of_activities'] = json_encode($progress_data['area_of_activities'], true);
            $progress_data['contactors'] = json_encode($progress_data['contactors'], true);
            $progress_data['key_indicators'] = json_encode($progress_data['key_indicators'], true);

            //dd($progress_data);
            Package_working_progress::updateOrCreate(['id' => $id], $progress_data);
            return redirect('/package')->with('toast_success', 'Working Progress Updated Successfully');
        }
        return back()->with('toast_error', $response);
    }

    public function get_progress_indicator($id)
    {
        $progress_indicator = Package_working_progress::where('package_id', $id)->first();

        $indicator_id = json_decode($progress_indicator['key_indicators']);
        $contractor_id = json_decode($progress_indicator['contactors']);
        $contractor = Contactor::whereIn('id', $contractor_id)->get();

        //dd($contractor);
        $indicator = DB::table('indicators as in')
            ->select('in.name_en', 'd.progress_value')
            ->whereIn('in.id', $indicator_id)
            ->leftJoin('indicator_datas as d', 'in.id', '=', 'd.indicator_id')
            ->get();
        //dd($indicator);
        $data = array();
        $data['contractor'] = $contractor;
        $data['indicator'] = $indicator;
        //dd($data);
        return $this->responseWithSuccess('message', $data);
    }
    /**  filttering package for index page*/
    public function package_search(Request $request)
    {
        //dd($request->all());
        $response = $this->validationWithJson($request->all(), $this->search_rule);
        if ($response === true) {
            $search = $this->getFormData($request->all(), $this->search_rule);
        }
        $name = $search['name_en'];
        $package_no = $search['package_no'];
        $type_id = $search['type_id'];
        $component = DB::table('components as c')
            ->where('c.name_en', 'LIKE', "%{$name}%")
            ->where('c.package_no', 'LIKE', "%{$package_no}%")
            ->where('c.type_id', 'LIKE', "%{$type_id}%")
            ->where('c.deleted_at', null)
            ->leftJoin('types as t', 't.id', '=', 'c.type_id')
            ->select('c.id', 'c.name_en', 'c.package_no', 't.name_en as type')
            ->paginate(20);
        //dd($component);
        $type = Type::all();
        return view('admin.package.index', compact('component', 'type', 'type_id'));
    }

    /* for payment page to get get contractor list by package id  */
    public function get_contractor($id)
    {
        //$progress_indicator = Package_working_progress::where('package_id',$id)->first() ;
        $package = Component::findOrFail($id);

        // if($progress_indicator['contactors']===null){
        //     return $this->responseWithError('message',$package);
        // }
        $contractor_id = json_decode($package['contactors']);
        $source_id = json_decode($package['source_of_fund_id']);

        $contractor = Contactor::whereIn('id', (array) $contractor_id)->get();
        $source = Source_of_fund::whereIn('id', (array) $source_id)->get();

        $data = array();
        $data['contractor'] = $contractor;
        $data['package'] = $package;
        $data['source'] = $source;

        return $this->responseWithSuccess('message', $data);
    }

    public function amount_convert(&$request = [])
    {

        $amount = str_replace(",", '', $request['cost_tk_act']);
        $amount = explode('.', $amount);
        $tk = (int) $amount[0];
        if (isset($amount[1])) {
            $poisha = (int) $amount[1] / 100;
            $tk += $poisha;
        }
        $request['cost_tk_act'] = $tk;

        $amount = str_replace(",", '', $request['cost_tk_est']);
        $amount = explode('.', $amount);
        $tk = (int) $amount[0];
        if (isset($amount[1])) {
            $poisha = (int) $amount[1] / 100;
            $tk += $poisha;
        }
        $request['cost_tk_est'] = $tk;

        $amount = str_replace(",", '', $request['cost_usd_est']);
        $amount = explode('.', $amount);
        $tk = (int) $amount[0];
        if (isset($amount[1])) {
            $poisha = (int) $amount[1] / 100;
            $tk += $poisha;
        }
        $request['cost_usd_est'] = $tk;

        $amount = str_replace(",", '', $request['cost_usd_act']);
        $amount = explode('.', $amount);
        $tk = (int) $amount[0];
        if (isset($amount[1])) {
            $poisha = (int) $amount[1] / 100;
            $tk += $poisha;
        }
        $request['cost_usd_act'] = $tk;

        $amount = str_replace(",", '', $request['contract_price_act_bdt']);
        $amount = explode('.', $amount);
        $tk = (int) $amount[0];
        if (isset($amount[1])) {
            $poisha = (int) $amount[1] / 100;
            $tk += $poisha;
        }
        $request['contract_price_act_bdt'] = $tk;

        $amount = str_replace(",", '', $request['contract_price_act_usd']);
        $amount = explode('.', $amount);
        $tk = (int) $amount[0];
        if (isset($amount[1])) {
            $poisha = (int) $amount[1] / 100;
            $tk += $poisha;
        }
        $request['contract_price_act_usd'] = $tk;

        // dd( $request->all());
        return true;
    }

    public function insertCategoryOrder($type = 1, $packageId = null)
    {

        if ($type == 1) { //type 1 goods 2 works 3 service 4 non consulting
            $sql = "INSERT INTO `package_report_category_order` (`id`, `package_id`, `file_category_id`, `created_at`, `updated_at`) VALUES (NULL, '$packageId', '[\"39\",\"10\",\"18\"]', NULL, NULL);";
        } elseif ($type == 2) {
            $sql = "INSERT INTO `package_report_category_order` (`id`, `package_id`, `file_category_id`, `created_at`, `updated_at`) VALUES (NULL, '$packageId', '[\"39\",\"10\",\"23\",\"24\",\"27\",\"18\"]', NULL, NULL);";
        } else {
            $sql = "INSERT INTO `package_report_category_order` (`id`, `package_id`, `file_category_id`, `created_at`, `updated_at`) VALUES (NULL, '$packageId', '[\"39\",\"16\",\"17\",\"18\",\"19\",\"20\"]', NULL, NULL);";
        }

        DB::select($sql);
    }

}