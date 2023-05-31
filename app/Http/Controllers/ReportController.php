<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportViewExport;
use Illuminate\Http\Request;

class ReportController extends Controller
{
   
    public function index()
    {
        return view('report.index');
    }

    public function export($type)
    {
       return Excel::download(new ReportViewExport, 'report.' . $type);
    }
}
