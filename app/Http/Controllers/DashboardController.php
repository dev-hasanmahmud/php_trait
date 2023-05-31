<?php

namespace App\Http\Controllers;

use App\Common;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return Common::procurement_management_dashboard();
    }

    public function gallery(Request $request)
    {
        $category = DB::table('file_manager_categories')
            ->where('parent_id', 0)
            ->where('id', '!=', 29)
            ->where('id', '!=', 38)
            ->get();

        $images = DB::table('file_managers')
            ->where('is_image', 1)
            ->where('fm_category_id', '!=', 30)
            ->where('fm_category_id', '!=', 31)
            ->where('fm_category_id', '!=', 32)
            ->where('fm_category_id', '!=', 38)
            ->where('deleted_at', null)
            ->orderby('id', 'DESC')
            ->paginate(20);
        if ($request->package_id) {
            $images = DB::table('file_managers')
                ->where('is_image', 1)
                ->where('table_id', $request->package_id)
                ->where('deleted_at', null)
                ->where('fm_category_id', '!=', 30)
                ->where('fm_category_id', '!=', 31)
                ->where('fm_category_id', '!=', 32)
                ->where('fm_category_id', '!=', 38)
                ->orderby('id', 'DESC')
                ->paginate(20);
            // dd($images);
        }
        if ($request->fm_category_id) {
            $images = DB::table('file_managers as fm')
                ->leftjoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                ->where('is_image', 1)
                ->where('fm_category_id', '!=', 30)
                ->where('fm_category_id', '!=', 31)
                ->where('fm_category_id', '!=', 32)
                ->where('fm_category_id', '!=', 38)
                ->where('cat.parent_id', $request->fm_category_id)
                ->orderby('fm.id', 'DESC')
                ->paginate(20);
            if ($images->count() < 1) {
                $images = DB::table('file_managers as fm')
                    ->leftjoin('file_manager_categories as cat', 'cat.id', '=', 'fm.fm_category_id')
                    ->where('is_image', 1)
                    ->where('fm_category_id', '!=', 30)
                    ->where('fm_category_id', '!=', 31)
                    ->where('fm_category_id', '!=', 32)
                    ->where('fm_category_id', '!=', 38)
                    ->where('cat.id', $request->fm_category_id)
                    ->orderby('fm.id', 'DESC')
                    ->paginate(20);
            }
            //dd($images);
        }
        if ($request->date) {
            $images = DB::table('file_managers as fm')
                ->where('is_image', 1)
                ->where('fm_category_id', '!=', 30)
                ->where('fm_category_id', '!=', 31)
                ->where('fm_category_id', '!=', 32)
                ->where('fm_category_id', '!=', 38)
                ->where('fm.date', $request->date)
                ->orderby('fm.id', 'DESC')
                ->paginate(20);
        }
        return view('gallery.index', compact('category', 'images'));
    }
    public function report()
    {
        return view('all_report.index');
    }
}