<?php

namespace App\Http\Controllers;

use App\Component;
use App\Disapprove_details;
use App\File_manager;
use App\File_manager_category;
use App\PermissionRole;
use App\Validator\validatorForm;
use App\WorldBankCategory;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PackagewiseReportController extends Controller
{
    use validatorForm;
    public function package_home()
    {
        $goods = Component::where('type_id', 1)->orderby('package_no')->get();
        // dd($goods[0]->id);
        $works = Component::where('type_id', 2)->orderby('package_no')->get();
        $service = Component::where('type_id', 3)->orderby('package_no')->get();

        return view('all_report.home', compact('goods', 'works', 'service'));
    }

    public function index(Request $request)
    {
        //dd('yes');
        $package_id = $request->package_id;
        $user = Auth::user();
        //  dd($package_id = 1);
        $package_name = Component::find($package_id);
        $user = Auth::user();
        $permission = PermissionRole::where('role_id', $user->role)->where('permission_id', 221)->get();

        if ($user->role != 1 && !$permission->isEmpty()) {

            $package_category_order_id = WorldBankCategory::whereType_id($package_name->type_id)->first();
            $package_category_order_id = json_decode($package_category_order_id->category_id);
            $order_id = '';

            foreach ($package_category_order_id as $key => $value) {
                $order_id = $order_id . $value . ',';
            }
            $order_id = $order_id . '0';
            //return $order_id;
            $categories = File_manager_category::whereIn('id', $package_category_order_id)->orderByRaw("FIELD(id,$order_id)")->get();
            //return $categories;
            $file_count = DB::select("SELECT fm_category_id,COUNT(name) AS `count` FROM file_managers
                where ( table_id= $package_id AND is_approve=1)
                AND deleted_at IS NULL
                GROUP BY fm_category_id");

            $files = DB::table('file_managers as fm')
                ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                ->where('fm.table_id', $package_id)
                ->where('fm.is_approve', 1)
                ->where('cat.parent_id', 15)
                ->where('fm.deleted_at', null)
                ->select('fm.*', 'cat.title')
                ->orderby('fm.id', 'DESC')
                ->paginate(20);

        } else {

            /**
             * @for all user
             */

            $package_category_order_id = DB::select("SELECT * FROM package_report_category_order
                where  package_id=$package_id");

            if ($package_category_order_id) {
                $package_category_order_id = $package_category_order_id[0]->file_category_id;
                $package_category_order_id = json_decode($package_category_order_id);
                $order_id = '';
                foreach ($package_category_order_id as $key => $value) {
                    $order_id = $order_id . $value . ',';
                }
                $order_id = $order_id . '0';
                $categories = File_manager_category::whereIn('id', $package_category_order_id)->orderByRaw("FIELD(id,$order_id)")->get();

                // return $categories;
            } else {
                $categories = File_manager_category::where('parent_id', 15)->get();
            }

            $permission = PermissionRole::where('role_id', $user->role)->where('permission_id', 172)->get();

            if ($user->role != 1 && !$permission->isEmpty()) {
                //dd($user->id);
                $file_count = DB::select("SELECT fm_category_id,COUNT(name) AS `count` FROM file_managers
                    where ( table_id= $package_id AND is_approve=1 AND created_by=$user->id)
                    AND deleted_at IS NULL
                    GROUP BY fm_category_id");

                $files = DB::table('file_managers as fm')
                    ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                    ->where('fm.table_id', $package_id)
                    ->where('fm.is_approve', 1)
                    ->where('fm.created_by', $user->id)
                    ->where('cat.parent_id', 15)
                    ->where('fm.deleted_at', null)
                    ->select('fm.*', 'cat.title')
                    ->orderby('fm.id', 'DESC')
                    ->paginate(20);

            } else {
                $file_count = DB::select("SELECT fm_category_id,COUNT(name) AS `count` FROM file_managers
                    where ( table_id= $package_id AND is_approve=1)
                    AND deleted_at IS NULL
                    GROUP BY fm_category_id");

                $files = DB::table('file_managers as fm')
                    ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                    ->where('fm.table_id', $package_id)
                    ->where('fm.is_approve', 1)
                    ->where('cat.parent_id', 15)
                    ->where('fm.deleted_at', null)
                    ->select('fm.*', 'cat.title')
                    ->orderby('fm.id', 'DESC')
                    ->paginate(20);
            }
        }
        if ($request->page) {
            //dd($files);
            return view('all_report.table', compact('files', 'package_id'))->render();
        }
        // dd($files);
        //$package_name = Component::find($package_id);
        $package_name = $package_name->package_no . '-' . $package_name->name_en;
        //dd($package_name);
        $file_count_array = [];
        if ($file_count) {
            foreach ($file_count as $r) {
                $file_count_array[$r->fm_category_id] = $r->count;
            }
        }
        $package_name = Component::where('id', $package_id)->first();
        return view('all_report.package_report', compact('categories', 'files', 'file_count_array', 'package_id', 'package_name'));
    }
    public function home(Request $request)
    {

        $package_id = 1;

        $fm_array = array($request->reportId);

        //dd($package_id);

        $categories = File_manager_category::whereIn('id', [1, 40, 43])->get();
        $user = Auth::user();
        $permission = PermissionRole::where('role_id', $user->role)->where('permission_id', 173)->get();

        if ($user->role != 1 && !$permission->isEmpty()) {
            $file_count = DB::select("SELECT fm_category_id,COUNT(name) AS `count` FROM file_managers
                where ( deleted_at IS NULL AND created_by=$user->id and is_image=0 )
                GROUP BY fm_category_id");
            $files = DB::table('file_managers as fm')
                ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                ->whereIn('fm.fm_category_id', $fm_array)
                ->where('fm.created_by', $user->id)
                ->where('fm.is_image', '!=', 1)
                ->where('fm.deleted_at', null)
                ->select('fm.*', 'cat.title')
                ->orderby('fm.id', 'DESC')
                ->paginate(20);
            //dd($files);
        } else {

            $file_count = DB::select("SELECT fm_category_id,COUNT(name) AS `count` FROM file_managers
                where ( deleted_at IS NULL and is_image=0 )
                GROUP BY fm_category_id");
            $files = DB::table('file_managers as fm')
                ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                ->whereIn('fm.fm_category_id', $fm_array)
                ->where('fm.is_image', '!=', 1)
                ->where('fm.deleted_at', null)
                ->select('fm.*', 'cat.title')
                ->orderby('fm.id', 'DESC')
                ->paginate(20);
        }
        //dd($files);
        if ($request->ajax()) {
            // return 'ok';
            return view('all_report.dashboard_table', compact('files'))->render();
        }
        $file_count_array = [];
        $sum = 0;
        //return $file_count;
        $file_count_array = array();
        $file_count_array[2] = 0;
        $file_count_array[29] = 0;
        if ($file_count) {
            foreach ($file_count as $r) {
                if ($r->fm_category_id == 2 || $r->fm_category_id == 3 || $r->fm_category_id == 4 || $r->fm_category_id == 5) {
                    //$sum+= $r->count;
                    $file_count_array[2] += $r->count;
                } else if ($r->fm_category_id == 29 || $r->fm_category_id == 30 || $r->fm_category_id == 31 || $r->fm_category_id == 32) {
                    //$sum+= $r->count;
                    $file_count_array[29] += $r->count;
                } else {
                    $file_count_array[$r->fm_category_id] = $r->count;
                }

            }
        }
        $ount = File_manager::whereIn('fm_category_id', [29, 30, 31, 32])->get();
        //dd($ount->count());
        $by_categoty_id[0] = 0;
        $by_categoty_id[1] = $request->reportId;
        $file_count_array[29] = $ount->count();

        $pre = '';
        $index = 1;
        $ind = 0;
        $count = [];
        foreach ($files as $f) {
            $ind++;
            if ($pre == $f->name) {
                $count[$index] += 1;
            } else {
                $index = $ind;
                $count[$index] = 1;
            }

            $pre = $f->name;
        }


        return view('all_report.index', compact('categories', 'files', 'file_count_array', 'count','package_id','by_categoty_id'));
    }

    public function create(Request $request)
    {
        //dd('yes');
        $package_id = $request->package_id;
        $category_id = $request->category_id;

        $package_category_order_id = DB::select("SELECT * FROM package_report_category_order
        where  package_id=$package_id");
        //return $package_category_order_id;
        if ($package_category_order_id) {
            $package_category_order_id = $package_category_order_id[0]->file_category_id;
            $package_category_order_id = json_decode($package_category_order_id);
            $categories = File_manager_category::whereIn('id', $package_category_order_id)->get();
            //return $categories;
        } else {
            $categories = File_manager_category::where('parent_id', 15)->get();
        }
        $component = Component::all();
        //dd($component);
        $package_name = Component::find($package_id);
        $package_name = $package_name->package_no . '-' . $package_name->name_en;
        //return $categories;
        return view('all_report.create', compact('categories', 'component', 'package_id', 'package_name','category_id'));
    }

    public function show_all_upload_report()
    {
        //$package_id= $request->package_id;
        ///dd('yes');
        $files = DB::table('file_managers as fm')
            ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
            ->whereIn('cat.id', [1, 40])
            ->where('fm.deleted_at', null)
        //->where('fm.is_image', '!=', 1)
            ->select('fm.*', 'cat.title')
            ->orderby('fm.id', 'DESC')
            ->paginate(20);

        return view('all_report.show_all_upload_report', compact('files'));
    }

    public function get_category_list($id)
    {
        $package_id = $id;
        $package_category_order_id = DB::select("SELECT * FROM package_report_category_order
        where  package_id=$package_id");

        if ($package_category_order_id) {
            $package_category_order_id = $package_category_order_id[0]->file_category_id;
            $package_category_order_id = json_decode($package_category_order_id);
            $categories = File_manager_category::whereIn('id', $package_category_order_id)->get();
            //return $categories;
        } else {
            $categories = File_manager_category::where('parent_id', 15)->get();
        }
        //return $categories;
        return $this->responseWithSuccess('message', $categories);
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $file_data = array();
        $file_data['name'] = $request->name;
        $file_data['fm_category_id'] = $request->fm_category_id;
        $file_data['description'] = $request->description;
        $file_data['date'] = $request->date;
        $file_data['is_approve'] = 0;
        $file_data['table_id'] = $request->package;
        $file_data['is_image'] = 1;
        $file_data['created_by'] = Auth::user()->id;

        $path = 'storage/package_wise_report/';
        for ($i = 1; $i < 20; $i++) {
            $key = "image_" . $i;
            if ($request->file($key)) {

                $fileName = Str::random(25) . '-.-' . $request->$key->getClientOriginalName();
                //$fileName =  "image-".Str::random(25).'.'.$request->$key->getClientOriginalExtension();
                request()->$key->move(public_path('storage/package_wise_report'), $fileName);
                $file_data['file_path'] = $path . $fileName;
                File_manager::create($file_data);
            }
        }

        $file_data['is_image'] = 0;
        for ($i = 1; $i < 20; $i++) {
            $key = "file_" . $i;
            if ($request->file($key)) {

                $fileName = Str::random(25) . '-.-' . $request->$key->getClientOriginalName();
                //$fileName =  "image-".Str::random(25).'.'.$request->$key->getClientOriginalExtension();
                request()->$key->move(public_path('storage/package_wise_report'), $fileName);
                $file_data['file_path'] = $path . $fileName;
                File_manager::create($file_data);
            }
        }
        return redirect('dashboard/package-wise-report/manage?package_id=' . $request->package)->with('toast_success', 'Record Uploaded Successfully');
    }

    public function manage(Request $request)
    {
        //dd('yes');
        $user = Auth::user();
        $package_id = $request->package_id;
        $permission = PermissionRole::where('role_id', $user->role)->where('permission_id', 172)->get();

        if ($user->role != 1 && !$permission->isEmpty()) {
            $files = DB::table('file_managers as fm')
                ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                ->where('cat.parent_id', 15)
                ->where('fm.table_id', $package_id)
                ->where('fm.created_by', $user->id)
                ->where('fm.deleted_at', null)
                ->select('fm.*', 'cat.title')
                ->orderby('fm.id', 'DESC')
                ->paginate(20);

        } else {
            $files = DB::table('file_managers as fm')
                ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                ->where('cat.parent_id', 15)
                ->where('fm.table_id', $package_id)
                ->where('fm.deleted_at', null)
                ->select('fm.*', 'cat.title')
                ->orderby('fm.id', 'DESC')
                ->paginate(20);

        }
        //dd($files);
        // $package_name = Component::find($package_id);
        // $package_name = $package_name->package_no.'-'.$package_name->name_en;
        $package_name = Component::where('id', $package_id)->first();

        return view('all_report.manage', compact('files', 'package_id', 'package_name'));
    }

    public function edit($id)
    {
        //$categories = File_manager_category::where('parent_id', 15)->get();
        $record = File_manager::find($id);
        //dd($categories);
        $user = Auth::user();
        $permission = PermissionRole::where('role_id', $user->role)->where('permission_id', 172)->get();
        if ($user->role != 1 && !$permission->isEmpty() && $user->id != $record->created_by) {
            return redirect('dashboard/package-wise-report/manage?package_id=' . $record->table_id)->with('toast_success', 'You are not allowed to edit this report.');
        }
        $component = Component::all();
        $package_id = $record->table_id;
        $package_name = Component::find($package_id);
        $package_name = $package_name->package_no . '-' . $package_name->name_en;

        /*new code  */
        // $package_id = $request->package_id;
        $package_category_order_id = DB::select("SELECT * FROM package_report_category_order
        where  package_id=$package_id");
        //return $package_category_order_id;
        if ($package_category_order_id) {
            $package_category_order_id = $package_category_order_id[0]->file_category_id;
            $package_category_order_id = json_decode($package_category_order_id);
            $categories = File_manager_category::whereIn('id', $package_category_order_id)->get();
            //return $categories;
        } else {
            $categories = File_manager_category::where('parent_id', 15)->get();
        }

        return view('all_report.edit', compact('categories', 'record', 'component', 'package_id', 'package_name'));
    }
    public function update(Request $request, $id)
    {
        //dd($request->all());
        $file = File_manager::findOrFail($id);
        $record = array();
        $record['name'] = $request->name;
        $record['fm_category_id'] = $request->fm_category_id;
        $record['description'] = $request->description;
        $record['date'] = $request->date;
        $record['table_id'] = $request->package;
        $record['is_approve'] = $file->is_approve;
        $file_data['created_by'] = Auth::user()->id;
        $record['updated_by'] = Auth::user()->id;
        //dd($record);
        $path = 'storage/package_wise_report/';
        if ($request->has('image')) {
            $image = $request->file('image');
            $record['is_image'] = 1;
            $fileName = "image-" . Str::random(25) . '-.-' . $image->getClientOriginalName();
            $image->move(public_path('storage/package_wise_report'), $fileName);
            $record['file_path'] = $path . $fileName;
        }

        if ($request->has('file')) {
            $file = $request->file('file');
            $record['is_image'] = 0;
            $fileName = "file_" . Str::random(25) . '-.-' . $file->getClientOriginalName();
            $file->move(public_path('storage/package_wise_report'), $fileName);
            $record['file_path'] = $path . $fileName;
        }

        File_manager::updateOrCreate(['id' => $id], $record);

        /* new update*/
        $file_data = array();
        $file_data['name'] = $request->name;
        $file_data['fm_category_id'] = $request->fm_category_id;
        $file_data['description'] = $request->description;
        $file_data['date'] = $request->date;
        $file_data['is_approve'] = 0;
        $file_data['table_id'] = $request->package;
        $file_data['created_by'] = Auth::user()->id;

        $path = 'storage/package_wise_report/';
        $file_data['is_image'] = 0;
        for ($i = 1; $i < 20; $i++) {
            $key = "file_" . $i;
            if ($request->file($key)) {

                $fileName = Str::random(25) . '-.-' . $request->$key->getClientOriginalName();
                //$fileName =  "image-".Str::random(25).'.'.$request->$key->getClientOriginalExtension();
                request()->$key->move(public_path('storage/package_wise_report'), $fileName);
                $file_data['file_path'] = $path . $fileName;
                File_manager::create($file_data);
            }
        }

        return redirect('dashboard/package-wise-report/manage?package_id=' . $request->package)->with('toast_success', 'Record Updated Successfully');

    }
    public function show($id)
    {
        //$data = File_manager::where()->find($id);
        $record = File_manager::find($id);
        //dd($categories);
        $user = Auth::user();
        $permission = PermissionRole::where('role_id', $user->role)->where('permission_id', 172)->get();
        if ($user->role != 1 && !$permission->isEmpty() && $user->id != $record->created_by) {
            return redirect('dashboard/package-wise-report/manage?package_id=' . $record->table_id)->with('toast_success', 'You are not allowed to see this report.');
        }
        $data = DB::table('file_managers as fm')
            ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
            ->leftJoin('components as com', 'com.id', '=', 'fm.table_id')
            ->leftJoin('users as u', 'u.id', '=', 'fm.created_by')
            ->leftJoin('users as a', 'a.id', '=', 'fm.approval_by')
            ->where('cat.parent_id', 15)
            ->where('fm.id', $id)
        //->where('fm.table_id',$package_id)
            ->where('fm.deleted_at', null)
            ->select('fm.*', 'cat.title', 'com.package_no', 'com.name_en', 'u.name as created_by', 'a.name as approve_by')
            ->first();
        //dd($data);
        $dissapprove_data = Disapprove_details::where('table_id', 2)->where('indicator_data_id', $data->id)->first();
        return view('all_report.show', compact('data', 'dissapprove_data'));
    }

    public function delete($id)
    {
        $report = File_manager::find($id);
        //dd($report);
        if ($report) {
            $report->delete();
        }

        return redirect()->back()->with('toast_success', 'Record Deleted Successfully');
    }

    public function report_by_category(Request $request, $id)
    {

        $package_id = $request->package_id;
        $fm_id = $request->category_id;
        $user = Auth::user();
        $permission = PermissionRole::where('role_id', $user->role)->where('permission_id', 173)->get();

        $fm_array = array($id);
        if ($id == 2) {
            $fm_array = array(3, 4, 5);
        } else if ($id == 29) {
            $fm_array = array(29, 30, 31, 32);
        }

        if ($id == 29) {

            $files = DB::table('file_managers as fm')
                ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                ->where('cat.parent_id', 29)
                ->where('fm.deleted_at', null)
                ->select('fm.*', 'cat.title')
                ->orderby('fm.id', 'DESC')
                ->paginate(20);

            // $files = DB::table('file_managers as fm')
            //     ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
            //     ->whereIn('fm.fm_category_id', $fm_array)
            //     ->where('fm.deleted_at', null)
            //     //->where('fm.is_image', '!=', 1)
            //     //->where('fm.created_by', $user->id)
            //     ->select('fm.*', 'cat.title')
            //     ->orderby('fm.id', 'DESC')
            //     ->paginate(20);

            $by_categoty_id[0] = 0;
            $by_categoty_id[1] = $id;
            $pre = '';
            $index = 1;
            $ind = 0;
            $count = [];
            foreach ($files as $f) {
                $ind++;
                if ($pre == $f->name) {
                    $count[$index] += 1;
                } else {
                    $index = $ind;
                    $count[$index] = 1;
                }

                $pre = $f->name;
            }
            //dd($count);
            return view('gis.table', compact('files', 'count', 'by_categoty_id'))->render();

            //return view('all_report.dashboard_table', compact('files', 'by_categoty_id'))->render();
        }

        //dd($id);
        if ($user->role != 1 && !$permission->isEmpty()) {
            $files = DB::table('file_managers as fm')
                ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                ->whereIn('fm.fm_category_id', $fm_array)
                ->where('fm.deleted_at', null)
                ->where('fm.is_image', '!=', 1)
                ->where('fm.created_by', $user->id)
                ->select('fm.*', 'cat.title')
                ->orderby('fm.id', 'DESC')
                ->paginate(20);
            //dd($files);
        } else {
            $files = DB::table('file_managers as fm')
                ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                ->whereIn('fm.fm_category_id', $fm_array)
                ->where('fm.deleted_at', null)
                ->where('fm.is_image', '!=', 1)
                ->select('fm.*', 'cat.title')
                ->orderby('fm.id', 'DESC')
                ->paginate(20);
        }

        $by_categoty_id[0] = 0;
        $by_categoty_id[1] = $id;
        $pre = '';
        $index = 1;
        $ind = 0;
        $count = [];
        foreach ($files as $f) {
            $ind++;
            if ($pre == $f->name) {
                $count[$index] += 1;
            } else {
                $index = $ind;
                $count[$index] = 1;
            }

            $pre = $f->name;
        }

        $by_categoty_id[0] = 0;
        $by_categoty_id[1] = $id;
        //dd($count);
        return view('gis.table', compact('files', 'count', 'by_categoty_id'))->render();
        return view('all_report.dashboard_table', compact('files', 'by_categoty_id'))->render();
    }

    public function dashboard_report_filtering(Request $request)
    {
        //dd("yes");
        $category = $request->catid;
        $date = $request->date;
        $user = Auth::user();
        $permission = PermissionRole::where('role_id', $user->role)->where('permission_id', 173)->get();

        $fm_array = array($category);
        if ($category == 2) {
            $fm_array = array(3, 4, 5);
        } else if ($category == 29) {
            $fm_array = array(29, 30, 31, 32);
        }
        //dd($fm_array);
        if ($user->role != 1 && !$permission->isEmpty()) {

            $files = DB::table('file_managers as fm')
                ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                ->whereIn('fm.fm_category_id', $fm_array)
                ->where('fm.date', $date)
                ->where('fm.created_by', $user->id)
                ->where('fm.deleted_at', null)
                ->where('fm.is_image', '!=', 1)
                ->select('fm.*', 'cat.title')
                ->orderby('fm.id', 'DESC')
                ->paginate(20);
        } else {
            //dd('yes');
            $files = DB::table('file_managers as fm')
                ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                ->whereIn('fm.fm_category_id', $fm_array)
                ->where('fm.date', $date)
            //->where('fm.created_by',$user->id)
                ->where('fm.deleted_at', null)
                ->where('fm.is_image', '!=', 1)
                ->select('fm.*', 'cat.title')
                ->orderby('fm.id', 'DESC')
                ->paginate(20);
        }
        $is_filter[0] = 1;
        $is_filter[1] = $category;
        $is_filter[2] = $date;
        //dd($files);
        return view('all_report.dashboard_table', compact('files', 'is_filter'))->render();
    }
    public function package_wise_report_by_category(Request $request)
    {
        //dd($request->all());
        $package_id = $request->package_id;
        $fm_id = $request->category_id;
        $user = Auth::user();
        $permission = PermissionRole::where('role_id', $user->role)->where('permission_id', 172)->get();

        if ($user->role != 1 && !$permission->isEmpty()) {
            $files = DB::table('file_managers as fm')
                ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                ->where('fm.table_id', $package_id)
                ->where('fm.is_approve', 1)
                ->where('fm.fm_category_id', $fm_id)
                ->where('fm.created_by', $user->id)
                ->where('fm.deleted_at', null)
                ->select('fm.*', 'cat.title')
                ->orderby('fm.created_at', 'DESC')
                ->orderby('fm.name')
                ->paginate(20);
        } else {
            $files = DB::table('file_managers as fm')
                ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                ->where('fm.table_id', $package_id)
                ->where('fm.is_approve', 1)
                ->where('fm.fm_category_id', $fm_id)
                ->where('fm.deleted_at', null)
                ->select('fm.*', 'cat.title')
                ->orderby('fm.created_at', 'DESC')
                ->paginate(20);
        }
        //dd($files);
        $pre = '';
        $index = 1;
        $ind = 0;
        $count = [];
        foreach ($files as $f) {
            $ind++;
            if ($pre == $f->name) {
                $count[$index] += 1;
            } else {
                $index = $ind;
                $count[$index] = 1;
            }

            $pre = $f->name;
        }
        //dd($count);
        $by_categoty_id[0] = 0;
        $by_categoty_id[1] = 0;
        return view('all_report.gis_table', compact('files', 'count', 'by_categoty_id', 'package_id', 'fm_id'))->render();
        return view('all_report.table', compact('files', 'count', 'package_id', 'by_categoty_id'))->render();

    }
    /* package wise report page filtering */
    public function report_filter(Request $request)
    {
        $category = $request->catid;
        $date = $request->date;
        $package_id = $request->package_id;
        $user = Auth::user();
        $permission = PermissionRole::where('role_id', $user->role)->where('permission_id', 172)->get();
        if ($user->role != 1 && !$permission->isEmpty()) {

            $files = DB::table('file_managers as fm')
                ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                ->where('fm.fm_category_id', $category)
                ->where('fm.table_id', $package_id)
                ->where('fm.created_by', $user->id)
                ->where('fm.date', $date)
                ->where('fm.is_approve', 1)
                ->where('fm.deleted_at', null)
                ->where('fm.is_image', 0)
                ->select('fm.*', 'cat.title')
                ->orderby('fm.id', 'DESC')
                ->paginate(20);
        } else {
            $files = DB::table('file_managers as fm')
                ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                ->where('fm.fm_category_id', $category)
                ->where('fm.table_id', $package_id)
                ->where('fm.date', $date)
                ->where('fm.deleted_at', null)
                ->where('fm.is_image', 0)
                ->where('fm.is_approve', 1)
                ->select('fm.*', 'cat.title')
                ->orderby('fm.id', 'DESC')
                ->paginate(20);
        }
        $is_filter[0] = 1;
        $is_filter[1] = $category;
        $is_filter[2] = $date;
        // return 'ok';
        return view('all_report.table', compact('files', 'package_id', 'is_filter'));
    }

    public function choosePackage($id)
    {
        $packages = Component::whereType_id($id)->orderBy('package_no')->get();
        return view('all_report.choosePackageTable', compact('packages'));
        return $id;
    }

    // public function pagination(Request $request)
    // {
    //     if($request->ajax())
    //     {
    //         //dd($request->all());
    //         if($request->catid==1)
    //         {
    //             //$package= Common::get_total_package_data();
    //              $files= DB::table('file_managers as fm')
    //             ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
    //             ->where('fm.fm_category_id',1)
    //             ->where('fm.deleted_at',null)
    //             ->select('fm.*','cat.title')
    //             ->orderby('fm.id','DESC')
    //             ->paginate(20);
    //             return view('all_report.table',compact('files'))->render();
    //         }
    //         if($request->catid==2)
    //         {
    //             //$package= Common::get_total_package_data();
    //              $files= DB::table('file_managers as fm')
    //             ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
    //             ->whereIn('fm.fm_category_id',[3,4,5])
    //             ->where('fm.deleted_at',null)
    //             ->select('fm.*','cat.title')
    //             ->orderby('fm.id','DESC')
    //             ->paginate(20);
    //             return view('all_report.tablefinance',compact('files'))->render();
    //         }

    //     }
    // }

}
