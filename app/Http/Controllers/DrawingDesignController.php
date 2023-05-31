<?php

namespace App\Http\Controllers;

use DB;
use App\Component;
use App\File_manager;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\File_manager_category;
use Illuminate\Support\Facades\Auth;

class DrawingDesignController extends Controller
{
    public function home(Request $request)
    {
        $goods = Component::where('type_id', 1)->orderby('package_no')->get();
        // dd($goods[0]->id);
        $works = Component::where('type_id', 2)->orderby('package_no')->get();
        $service = Component::where('type_id', 3)->orderby('package_no')->get();

        return view('drawing_design.home', compact('goods', 'works', 'service'));
    }

    public function index(Request $request)
    {
        $package_id = $request->package_id;
        //dd($package_id);
        $categories = File_manager_category::where('parent_id', 7)->get();
        $files = DB::table('file_managers as fm')
            ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
            ->where('fm.table_id', $package_id)
            ->where('cat.parent_id', 7)
            ->where('fm.deleted_at', null)
            ->select('fm.*', 'cat.title')
            ->orderby('fm.id', 'DESC')
            ->paginate(30);

        if ($request->page) {
            //dd($files);
            return view('drawing_design.table', compact('files', 'package_id'))->render();
        }
        $file_count_array = [];
        $file_count = DB::select("SELECT fm_category_id,COUNT(NAME) AS `count` FROM file_managers
        where table_id= $package_id
        AND deleted_at IS NULL
        GROUP BY fm_category_id");
        if ($file_count) {
            foreach ($file_count as $r) {
                $file_count_array[$r->fm_category_id] = $r->count;
            }
        }
        //dd($file_count);
        $package_name = Component::where('id', $package_id)->first();
        return view('drawing_design.index', compact('categories', 'files', 'file_count_array', 'package_id', 'package_name'));
    }

    public function manage(Request $request)
    {
        $package_id = $request->package_id;
        $files = DB::table('file_managers as fm')
            ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
            ->where('cat.parent_id', 7)
            ->where('fm.table_id', $package_id)
            ->where('fm.deleted_at', null)
            ->select('fm.*', 'cat.title')
            ->orderby('fm.id', 'DESC')
            ->paginate(20);

        return view('drawing_design.manage', compact('files', 'package_id'));
    }

    public function create(Request $request)
    {
        $package_id = $request->package_id;
        $categories = File_manager_category::where('parent_id', 7)->get();
        $component = Component::all();
        //dd($component);
        return view('drawing_design.create', compact('categories', 'component', 'package_id'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $file_data = array();
        $file_data['name'] = $request->name;
        $file_data['fm_category_id'] = $request->fm_category_id;
        $file_data['description'] = $request->description;
        $file_data['date'] = $request->date;
        $file_data['table_id'] = $request->package;
        $file_data['is_image'] = 1;
        $file_data['created_by'] = Auth::user()->id;

        $path = 'storage/drawing_design/';
        for ($i = 1; $i < 20; $i++) {
            $key = "image_" . $i;
            if ($request->file($key)) {

                $fileName = Str::random(25) . '-.-' . $request->$key->getClientOriginalName();
                //$fileName =  "image-".Str::random(25).'.'.$request->$key->getClientOriginalExtension();
                request()->$key->move(public_path('storage/drawing_design'), $fileName);
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
                request()->$key->move(public_path('storage/drawing_design'), $fileName);
                $file_data['file_path'] = $path . $fileName;
                File_manager::create($file_data);
            }
        }
        //  return redirect()->back()->with('toast_success','Record Uploaded Successfully');
        return redirect('dashboard/drawing-design-report?package_id=' . $request->package)->with('toast_success', 'Record Uploaded Successfully');
    }

    public function edit($id)
    {
        $record = File_manager::find($id);
        //dd($record);
        $categories = File_manager_category::where('parent_id', 7)->get();
        $component = Component::all();
        return view('drawing_design.edit', compact('categories', 'record', 'component'));
    }
    public function update(Request $request, $id)
    {
        //dd($request->all());
        $record = File_manager::findOrFail($id);

        $record->name = $request->name;
        $record->fm_category_id = $request->fm_category_id;
        $record->description = $request->description;
        $record->date = $request->date;
        $record->table_id = $request->package;
        $record->created_by = Auth::user()->id;

        $path = 'storage/drawing_design/';
        if ($request->has('image')) {
            $image = $request->file('image');
            $record->is_image = 1;
            $fileName = "image-" . Str::random(25) . '-.-' . $image->getClientOriginalName();
            $image->move(public_path('storage/drawing_design'), $fileName);
            $record->file_path = $path . $fileName;
        }

        if ($request->has('file')) {
            $file = $request->file('file');
            $record->is_image = 0;
            $fileName = "file_" . Str::random(25) . '-.-' . $file->getClientOriginalName();
            $file->move(public_path('storage/drawing_design'), $fileName);
            $record->file_path = $path . $fileName;
        }

        $record->update();

        //return redirect()->back()->with('toast_success','Record Updated Successfully');
        return redirect('dashboard/drawing-design-report?package_id=' . $request->package)->with('toast_success', 'Record Updated Successfully');

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

    // public function get_table_data(Request $request,$id)
    // {
    //     $package_id= $request->package_id;

    //     $files= DB::table('file_managers as fm')
    //             ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
    //             ->where('fm.table_id',$package_id)
    //             ->where('fm.fm_category_id',$id)
    //             ->where('fm.deleted_at',null)
    //             ->select('fm.*','cat.title')
    //             ->orderby('fm.id','DESC')
    //             ->paginate(20);

    //     $by_categoty_id[0]=0;
    //     $by_categoty_id[1]=$id;

    //     return view('drawing_design.table',compact('files','package_id','by_categoty_id'))->render();
    // }

    public function get_table_data(Request $request, $id, $package_id)
    {
        //dd($request->package_id);
        $categories = File_manager_category::where('parent_id', 7)->get();
        $package_id = $request->package_id;

        $files = DB::table('file_managers as fm')
            ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
            ->where('fm.table_id', $package_id)
            ->where('fm.fm_category_id', $id)
            ->where('fm.deleted_at', null)
            ->select('fm.*', 'cat.title')
            ->orderby('fm.id', 'DESC')
            ->paginate(30);
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
        if ($request->ajax()) {
            // dd($count);
            return view('drawing_design.gisTable', compact('files', 'count'))->render();
        }

        // $file_count_array = [];
        // $file_count = DB::select("SELECT fm_category_id,COUNT(NAME) AS `count` FROM file_managers
        // WHERE deleted_at IS NULL
        // GROUP BY fm_category_id");
        // if ($file_count) {
        //     foreach ($file_count as $r) {
        //         $file_count_array[$r->fm_category_id] = $r->count;
        //     }
        // }
        return view('gis.index', compact('categories', 'files', 'file_count_array', 'count'));
    }

    public function get_table_data_by_category_and_Date(Request $request)
    {
        $category = $request->catid;
        $date = $request->date;
        $package_id = $request->package_id;
        // dd($request->all());
        if ($category) {
            $files = DB::table('file_managers as fm')
                ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                ->where('fm.fm_category_id', $category)
                ->where('fm.table_id', $package_id)
                ->where('fm.date', $date)
                ->where('fm.deleted_at', null)
                ->select('fm.*', 'cat.title')
                ->orderby('fm.id', 'DESC')
                ->paginate(20);
        }
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
        $is_filter[0] = 1;
        $is_filter[1] = $category;
        $is_filter[2] = $date;
        if ($request->ajax()) {
            // dd($count);
            return view('drawing_design.gisTable', compact('files', 'count', 'package_id', 'is_filter'))->render();
        }

        return view('drawing_design.gisTable', compact('files', 'package_id', 'is_filter'));
    }
}
