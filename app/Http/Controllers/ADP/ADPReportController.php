<?php

namespace App\Http\Controllers\ADP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ADPReportController extends Controller
{
    public function adp_report_template()
    {
      return view('adp.index');
    }

    public function get_formate_adp_report_template()
    {
      return view('adp.template');
    }
}
