<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Component;

class PackageProgressController extends Controller
{
    public function index()
    {
        $date=date('Y-m-d');
        $package_list=Component::order_by('id')->get();
        return view('packageProgress.index');
    }
}
