<?php

namespace App\Http\Controllers;

use DB;
use App\File_manager;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\File_manager_category;
use Illuminate\Support\Facades\Auth;

class ProjectInformationController extends Controller
{
    public function index()
    {
        //return 'ok';
        $categories = File_manager_category::where('parent_id', 11)->orderByRaw("FIELD(id,13,12,35)")->get();

        $files = DB::table('file_managers as fm')
            ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
            ->where('cat.parent_id', 11)
            ->where('fm.deleted_at', null)
            ->select('fm.*', 'cat.title')
            ->orderby('fm.id', 'DESC')
            ->paginate(20);

        $file_count_array = [];
        $file_count = DB::select("SELECT fm_category_id,COUNT(NAME) AS `count` FROM file_managers where file_managers.deleted_at is null
        GROUP BY fm_category_id");

        $file_count_array[13] = 0;
        $file_count_array[12] = 0;
        $file_count_array[35] = 0;

        if ($file_count) {
            foreach ($file_count as $r) {
                if ($r->fm_category_id == 28 || $r->fm_category_id == 33 || $r->fm_category_id == 34 || $r->fm_category_id == 36) {
                    $file_count_array[13] += $r->count;
                } else if ($r->fm_category_id == 46 || $r->fm_category_id == 47 || $r->fm_category_id == 48 || $r->fm_category_id == 50) {
                    $file_count_array[12] += $r->count;
                } else if ($r->fm_category_id == 52) {
                    $file_count_array[35] += $r->count;
                }

            }
        }
        //return $file_count_array;

        return view('project_information.index', compact('categories', 'files', 'file_count_array'));
    }
    public function subCategory(Request $request, $id)
    {
        $mainCategory = File_manager_category::findOrfail($id);
        $subCategories = File_manager_category::where('parent_id', $id)->get();

        $file_count_array = [];
        $file_count = DB::select("SELECT fm_category_id,COUNT(NAME) AS `count` FROM file_managers where file_managers.deleted_at is null
        GROUP BY fm_category_id");
        if ($file_count) {
            foreach ($file_count as $r) {
                $file_count_array[$r->fm_category_id] = $r->count;
            }
        }
        //return $mainCategory;
        return view('project_information.subCategory', compact('subCategories', 'file_count_array', 'mainCategory'));
    }

    public function manage(Request $request, $id)
    {
        //return $id;
        $mainCategory = File_manager_category::findOrfail($id);
        $files = DB::table('file_managers as fm')
            ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
            ->where('cat.parent_id', $id)
            ->where('fm.deleted_at', null)
            ->select('fm.*', 'cat.title')
            ->orderby('fm.id', 'DESC')
            ->paginate(20);

        return view('project_information.manage', compact('files', 'mainCategory'));
    }

    public function create($id) //this is patent id

    {
        //return $id;
        $mainCategory = File_manager_category::findOrfail($id);
        $categories = File_manager_category::where('parent_id', $id)->get();
        //$component = Component::all();
        //dd($component);
        return view('project_information.create', compact('categories', 'mainCategory'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $file_data = array();
        $file_data['name'] = $request->name;
        $file_data['fm_category_id'] = $request->fm_category_id;
        $file_data['description'] = $request->description;
        $file_data['date'] = $request->date;
        $file_data['table_id'] = 5;
        $file_data['is_image'] = 1;
        $file_data['created_by'] = Auth::user()->id;

        $path = 'storage/project_information/';
        for ($i = 1; $i < 20; $i++) {
            $key = "image_" . $i;
            if ($request->file($key)) {

                $fileName = Str::random(25) . '-.-' . $request->$key->getClientOriginalName();
                //$fileName =  "image-".Str::random(25).'.'.$request->$key->getClientOriginalExtension();
                request()->$key->move(public_path('storage/project_information'), $fileName);
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
                request()->$key->move(public_path('storage/project_information'), $fileName);
                $file_data['file_path'] = $path . $fileName;
                File_manager::create($file_data);
            }
        }

        $mainCategory = File_manager_category::findOrfail($request->parent_id);
        return redirect()->route('project_info.subCategory', $mainCategory->id)->with('toast_success', 'Record Uploaded Successfully');
    }

    public function edit($id)
    {
        $record = File_manager::find($id);

        $Category = File_manager_category::findOrfail($record->fm_category_id);
        $mainCategory = File_manager_category::findOrfail($Category->parent_id);
        // return $mainCategory;
        $categories = File_manager_category::where('parent_id', $mainCategory->id)->get();
        //$component = Component::all();
        return view('project_information.edit', compact('categories', 'record', 'mainCategory'));
    }
    public function update(Request $request, $id)
    {
        //dd($request->all());
        $record = File_manager::findOrFail($id);

        $record->name = $request->name;
        $record->fm_category_id = $request->fm_category_id;
        $record->description = $request->description;
        $record->date = $request->date;
        $record->table_id = 5;

        $path = 'storage/project_information/';
        if ($request->has('image')) {
            $image = $request->file('image');
            $record->is_image = 1;
            $fileName = "image-" . Str::random(25) . '-.-' . $image->getClientOriginalName();
            $image->move(public_path('storage/project_information'), $fileName);
            $record->file_path = $path . $fileName;
        }

        if ($request->has('file')) {
            $file = $request->file('file');
            $record->is_image = 0;
            $fileName = "file_" . Str::random(25) . '-.-' . $file->getClientOriginalName();
            $file->move(public_path('storage/project_information'), $fileName);
            $record->file_path = $path . $fileName;
        }

        $record->update();

        $mainCategory = File_manager_category::findOrfail($request->parent_id);

        return redirect()->route('project_info.subCategory', $mainCategory->id)->with('toast_success', 'Record Updated Successfully');

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

    public function old_get_table_data(Request $request, $id)
    {
        //$package_id= $request->package_id;

        $files = DB::table('file_managers as fm')
            ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
        // ->where('fm.table_id',$package_id)
            ->where('fm.fm_category_id', $id)
            ->where('fm.deleted_at', null)
            ->select('fm.*', 'cat.title')
            ->orderby('fm.id', 'DESC')
            ->paginate(20);

        return view('project_information.table', compact('files'));
    }
    public function get_table_data(Request $request, $id)
    {
        //dd('yes');
        $categories = File_manager_category::where('parent_id', 29)->get();

        $files = DB::table('file_managers as fm')
            ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
        // ->where('fm.table_id',$package_id)
            ->where('fm.fm_category_id', $id)
            ->where('fm.deleted_at', null)
            ->select('fm.*', 'cat.title')
            ->orderby('fm.id', 'DESC')
            ->paginate(20);

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
        //dd($files);
        if ($request->ajax()) {
            //dd($count) ;
            return view('project_information.gisTable', compact('files', 'count'))->render();
        }
    }

    public function get_table_data_by_category_and_Date(Request $request)
    {
        $category = $request->catid;
        $date = $request->date;
        //$package_id= $request->package_id;
        // dd($request->all());

        $files = DB::table('file_managers as fm')
            ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
            ->where('fm.fm_category_id', $category)
        // ->where('fm.table_id',$package_id)
            ->where('fm.date', $date)
            ->where('fm.deleted_at', null)
            ->select('fm.*', 'cat.title')
            ->orderby('fm.id', 'DESC')
            ->paginate(20);

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
        //dd($files);
        if ($request->ajax()) {
            //dd($count) ;
            return view('project_information.gisTable', compact('files', 'count'))->render();
        }

    }
}