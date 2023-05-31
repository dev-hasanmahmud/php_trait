<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Proc_method;
use App\Type;
use App\Validator\validatorForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcurementMethodController extends Controller
{
    use validatorForm;
    protected $rules = array(
        'name_en' => 'required',
        'name_bn' => 'nullable',
        'type_id' => 'nullable',
    );
    public function index()
    {
        $proc_method = Proc_method::latest()->paginate(20);

        $type = Type::all()->toArray();

        $ln = count($type);
        $unit_data = $proc_method->toArray();
        $unit_data = $unit_data['data'];
        $ln_u = count($unit_data);
        $ln2 = 0;
        for ($i = 0; $i < $ln_u; $i++) {
            $id = array();
            $id = json_decode($unit_data[$i]['type_id']);
            $unit_data[$i]['name'] = '';
            if ($id != null) {

                $ln2 = count($id);
            }
            for ($k = 0; $k < $ln2; $k++) {
                for ($j = 0; $j < $ln; $j++) {
                    if ($id[$k] == $type[$j]['id']) {
                        $unit_data[$i]['name'] = $type[$j]['name_en'] . '  ' . $unit_data[$i]['name'];
                        break;
                    }
                }
            }
        }

        return view('admin.procurement_method.index', compact('proc_method', 'unit_data'));
    }

    public function create()
    {
        return view('admin.procurement_method.create');
    }

    public function store(Request $request)
    {
        $response = $this->validationWithJson($request->all(), $this->rules);
        if ($response === true) {
            $data = $this->getFormData($request->all(), $this->rules);
            $data['type_id'] = json_encode($data['type_id'], true);
            //dd($data);
            Proc_method::create($data);
            return redirect('/procurement_method')->with('toast_success', 'Procurement Method Created Successfully');
        }
        return back()->with('toast_error', $response);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $source = Proc_method::findOrFail($id);
        return view('admin.procurement_method.edit', compact('source'));
    }

    public function update(Request $request, $id)
    {
        //return dd($id);

        $response = $this->validationWithJson($request->all(), $this->rules);
        if ($response === true) {
            $data = $this->getFormData($request->all(), $this->rules);
            $data['type_id'] = json_encode($data['type_id'], true);
            Proc_method::updateOrCreate(['id' => $id], $data);
            return redirect('/procurement_method')->with('toast_success', 'Procurement Method Updated Successfully');
        }
        return back()->with('toast_error', $response);
    }

    public function destroy($id)
    {
        $source = Proc_method::findOrFail($id);
        //$this->authorize('delete',$source);
        //return 'helo';
        $source->delete();
        return $this->responseWithSuccess('Data Deleted successfully', 'success');
        //return redirect('/procurement_method')->with('toast_success','Procurement Method Deleted Successfully');

    }

    public function get_input_group(Request $request)
    {

        // $type = Type::where('id',$request->type_id)->first();
        // $method = Proc_method::where('id',$request->method_id)->first();
        // if($type['name_en'] == 'Service' && $method['name_en'] =='CQS' || $method['name_en'] =='QCBS' ||  $method['name_en'] =='IC'){
        $data = DB::table('settings')
            ->where('type_id', $request->type_id)
            ->where('procurement_method_id', $request->method_id)
            ->orderBy('ordering')
            ->get();

        if (!$data->isEmpty()) {
            return view('admin.package.setting_group', compact('data'));
        } else {
            return view('admin.package.common_group');
        }

    }
}