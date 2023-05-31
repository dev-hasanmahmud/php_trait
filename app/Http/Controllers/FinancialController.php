<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinancialController extends Controller
{
    public function pmis_report()
    {
        return view('report.financial_report');
    }
    public function set_ajax_view()
    {
        return view('report.report_view_for_financial_report');
        
    }
}
