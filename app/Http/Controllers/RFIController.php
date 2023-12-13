<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Resignation;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RFIController extends Controller
{
    public function index()
    {
        // dd("dd");
        return view('rfi.index');
    }
}