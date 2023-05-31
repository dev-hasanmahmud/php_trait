<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PorcurementController extends Controller
{
    public function index()
    {
        return view('procurement.index');
    }
}
