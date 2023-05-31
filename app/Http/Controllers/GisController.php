<?php

namespace App\Http\Controllers;

use App\File_manager;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\File_manager_category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GisController extends Controller
{
    public function index(Request $request)
    {
        //dd('yes');
        $categories = File_manager_category::where('parent_id', 29)->get();

        $files = DB::table('file_managers as fm')
            ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
            ->where('cat.parent_id', 29)
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
            return view('gis.table', compact('files', 'count'))->render();
        }

        $file_count_array = [];
        $file_count = DB::select("SELECT fm_category_id,COUNT(NAME) AS `count` FROM file_managers
        WHERE deleted_at IS NULL
        GROUP BY fm_category_id");
        if ($file_count) {
            foreach ($file_count as $r) {
                $file_count_array[$r->fm_category_id] = $r->count;
            }
        }
        return view('gis.index', compact('categories', 'files', 'file_count_array', 'count'));
    }

    public function manage(Request $request)
    {
        //$package_id= $request->package_id;
        $files = DB::table('file_managers as fm')
            ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
            ->where('cat.parent_id', 29)
            ->where('fm.deleted_at', null)
            ->select('fm.*', 'cat.title')
            ->orderby('fm.id', 'DESC')
            ->paginate(20);

        return view('gis.manage', compact('files'));
    }

    public function create()
    {
        //$categories= File_manager_category::where('parent_id',29)->get();
        $categories = File_manager_category::find([1, 40, 43]);
        //$component = Component::all();
        //dd($categories);
        return view('gis.create', compact('categories'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $file_data = array();
        $file_data['name'] = $request->name;
        $file_data['fm_category_id'] = $request->fm_category_id;
        $file_data['description'] = $request->description;
        $file_data['date'] = $request->date;
        $file_data['table_id'] = 29;
        $file_data['is_image'] = 1;
        $file_data['created_by'] = Auth::user()->id;

        $path = 'storage/gis/';
        for ($i = 1; $i < 20; $i++) {
            $key = "image_" . $i;
            if ($request->file($key)) {

                $fileName = Str::random(25) . '-.-' . $request->$key->getClientOriginalName();
                //$fileName =  "image-".Str::random(25).'.'.$request->$key->getClientOriginalExtension();
                request()->$key->move(public_path('storage/gis'), $fileName);
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
                request()->$key->move(public_path('storage/gis'), $fileName);
                $file_data['file_path'] = $path . $fileName;
                File_manager::create($file_data);
            }
        }
        // return redirect()->route('gis.index')->with('toast_success','Record Uploaded Successfully');
        return redirect('dashboard/upload/all_report')->with('toast_success', 'Record Uploaded Successfully');

    }

    public function edit($id)
    {
        $record = File_manager::find($id);
        //dd($record);
        //$categories = File_manager_category::where('parent_id', 29)->get();
        $categories = File_manager_category::find([1, 40]);
        //$component = Component::all();
        //return $record;
        return view('gis.edit', compact('categories', 'record'));
    }
    public function update(Request $request, $id)
    {
        //dd($request->all());
        $record = File_manager::findOrFail($id);

        $record->name = $request->name;
        $record->fm_category_id = $request->fm_category_id;
        $record->description = $request->description;
        $record->date = $request->date;
        $record->table_id = 29;
        $record->created_by = Auth::user()->id;

        $path = 'storage/gis/';
        if ($request->has('image')) {
            $image = $request->file('image');
            $record->is_image = 1;
            $fileName = "image-" . Str::random(25) . '-.-' . $image->getClientOriginalName();
            $image->move(public_path('storage/gis'), $fileName);
            $record->file_path = $path . $fileName;
        }

        if ($request->has('file')) {
            $file = $request->file('file');
            $record->is_image = 0;
            $fileName = "file_" . Str::random(25) . '-.-' . $file->getClientOriginalName();
            $file->move(public_path('storage/gis'), $fileName);
            $record->file_path = $path . $fileName;
        }

        $record->update();

        return redirect('dashboard/upload/all_report')->with('toast_success', 'Record Updated Successfully');

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

    public function get_table_data(Request $request, $id)
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

        return view('gis.table', compact('files', 'count'));
    }

    public function get_table_data_by_category_and_Date(Request $request)
    {
        $category = $request->catid;
        $date = $request->date;
        //$package_id= $request->package_id;
        // dd($request->all());
        if ($category && $date) {
            $files = DB::table('file_managers as fm')
                ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                ->where('fm.fm_category_id', $category)
            // ->where('fm.table_id',$package_id)
                ->where('fm.date', $date)
                ->where('fm.deleted_at', null)
                ->select('fm.*', 'cat.title')
                ->orderby('fm.id', 'DESC')
                ->paginate(20);

            //return view('gis.table',compact('files'));
        } else if ($category) {
            $files = DB::table('file_managers as fm')
                ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                ->where('fm.fm_category_id', $category)
            // ->where('fm.table_id',$package_id)
                ->where('fm.deleted_at', null)
                ->select('fm.*', 'cat.title')
                ->orderby('fm.id', 'DESC')
                ->paginate(20);

            //return view('gis.table',compact('files'));
        } else if ($date) {
            $files = DB::table('file_managers as fm')
                ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                ->where('cat.parent_id', 29)
            // ->where('fm.table_id',$package_id)
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
        return view('gis.table', compact('files', 'count'));
    }
}