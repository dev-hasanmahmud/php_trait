<?php

namespace App\Http\Controllers;

use App\Component;
use Illuminate\Http\Request;

class MonitorAndSuppervisionController extends Controller
{
    public function index()
    {
        $works= Component::where('type_id',2)->orderby('package_no')->get();
        return view('monitor_supervision_status.index',compact('works'));
    }
}
