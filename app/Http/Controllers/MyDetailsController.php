<?php

namespace App\Http\Controllers;

use App\Exports\CustomerExport;
use App\Imports\CustomerImport;
use App\Models\Customer;
use App\Models\CustomField;
use App\Models\Transaction;
use App\Models\Utility;
use Auth;
use App\Models\User;
use App\Models\Plan;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class MyDetailsController extends Controller
{

    public function info()
    {

        return view('mydetails.info');
    }
    public function leave()
    {

        return view('mydetails.leave');
    }
    public function payslip()
    {

        return view('mydetails.payslip');
    }
    public function performance()
    {

        return view('mydetails.performance');
    }
    public function goals()
    {

        return view('mydetails.goals');
    }
    public function relief()
    {

        return view('mydetails.relief');
    }
    public function appraisal()
    {

        return view('mydetails.appraisal');
    }
}
