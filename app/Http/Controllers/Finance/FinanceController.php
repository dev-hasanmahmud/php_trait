<?php

namespace App\Http\Controllers\Finance;

use DB;
use App\File_manager;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\File_manager_category;
use App\Validator\validatorForm;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{
    use validatorForm;

    public function dashboard(Request $request)
    {
        $categories = File_manager_category::where('parent_id', 2)->get();

        $files = DB::table('file_managers as fm')
            ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
            ->where('cat.parent_id', 2)
            ->where('fm.deleted_at', null)
            ->select('fm.*', 'cat.title')
            ->orderby('fm.id', 'DESC')
            ->paginate(20);

        if ($request->ajax()) {
            return view('finance.table', compact('files'))->render();
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

        return view('finance.dashboard', compact('categories', 'files', 'file_count_array'));
    }

    public function report_create()
    {
        $categories = File_manager_category::where('parent_id', 2)->get();
        return view('finance.create', compact('categories'));
    }

    public function report_store(Request $request)
    {
        //dd($request->all());
        $file_data = array();
        $file_data['name'] = $request->name;
        $file_data['fm_category_id'] = $request->fm_category_id;
        $file_data['description'] = $request->description;
        $file_data['date'] = $request->date;
        $file_data['table_id'] = 0;
        $file_data['is_image'] = 0;
        $file_data['created_by'] = Auth::user()->id;

        $path = 'storage/finance/';
        for ($i = 1; $i < 20; $i++) {
            $key = "file_" . $i;
            if ($request->file($key)) {

                $fileName = Str::random(25) . '-' . $request->$key->getClientOriginalName();
                //$fileName =  "image-".Str::random(25).'.'.$request->$key->getClientOriginalExtension();
                request()->$key->move(public_path('storage/finance'), $fileName);
                $file_data['file_path'] = $path . $fileName;
                File_manager::create($file_data);
            }
        }
        return redirect('/finance-dashboard')->with('toast_success', 'Financial Report Uploaded Successfully');

    }

    public function manage_Report()
    {
        $categories = File_manager_category::where('parent_id', 2)->get();
        $files = DB::table('file_managers as fm')
            ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
            ->where('cat.parent_id', 2)
            ->where('fm.deleted_at', null)
            ->select('fm.*', 'cat.title')
            ->paginate(20);
        //dd($files->toArray());
        return view('finance.manage', compact('categories', 'files'));
    }

    public function edit_Report($id)
    {
        $report = File_manager::find($id);
        $categories = File_manager_category::where('parent_id', 2)->get();
        return view('finance.edit', compact('categories', 'report'));
    }

    public function update_Report(Request $request, $id)
    {
        //dd($request->all());
        $report = File_manager::find($id);
        //dd($report);
        $report->name = $request->name;
        $report->fm_category_id = $request->fm_category_id;
        $report->description = $request->description;
        $report->date = $request->date;
        $report->table_id = 0;
        $report->is_image = 0;
        $report->created_by = Auth::user()->id;

        $path = 'storage/finance/';

        // $file = $request->file('file');
        // $fileName = "file_".Str::random(25).'-.-'.$file->getClientOriginalName();
        if ($request->has('file')) {
            $i = 1;
            $key = "file_" . $i;
            if ($request->file($key)) {
                $fileName = Str::random(25) . '-' . $request->$key->getClientOriginalName();
                request()->$key->move(public_path('storage/finance'), $fileName);
                $report->file_path = $path . $fileName;
                $report->update();
            }
        } else {
            $report->update();
        }
        // $file->move(public_path('storage/finance'), $fileName);

        return redirect()->route('manage')->with('toast_success', 'Financial Report Updated Successfully');

    }
    public function delete_Report($id)
    {
        $report = File_manager::find($id);
        //dd($report);
        if ($report) {
            $report->delete();
        }

        return redirect()->route('manage')->with('toast_success', 'Report Deleted Successfully');
    }
    public function show_file(Request $request)
    {
        $categories = File_manager_category::where('parent_id', 2)->get();
        $files = DB::table('file_managers as fm')
            ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
            ->where('cat.parent_id', 2)
            ->where('fm.deleted_at', null)
            ->select('fm.*', 'cat.title')
            ->orderby('fm.id', 'DESC')
            ->paginate(20);

        if ($request->ajax()) {
            return view('finance.table', compact('files'))->render();
        }
        //dd($files->toArray());
        return view('finance.show', compact('categories', 'files'));
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

        return view('finance.table', compact('files'));
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
                ->where('fm.date', $date)
            // ->where('fm.table_id',$package_id)
                ->where('fm.deleted_at', null)
                ->select('fm.*', 'cat.title')
                ->orderby('fm.id', 'DESC')
                ->paginate(20);
            return view('finance.table', compact('files'));
        }
        if ($category) {
            $files = DB::table('file_managers as fm')
                ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                ->where('fm.fm_category_id', $category)
            // ->where('fm.table_id',$package_id)
                ->where('fm.deleted_at', null)
                ->select('fm.*', 'cat.title')
                ->orderby('fm.id', 'DESC')
                ->paginate(20);
            return view('finance.table', compact('files'));
        }
        if ($date) {
            $files = DB::table('file_managers as fm')
                ->leftJoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                ->where('cat.parent_id', 2)
            // ->where('fm.table_id',$package_id)
                ->where('fm.date', $date)
                ->where('fm.deleted_at', null)
                ->select('fm.*', 'cat.title')
                ->orderby('fm.id', 'DESC')
                ->paginate(20);
            return view('finance.table', compact('files'));
        }
    }

}