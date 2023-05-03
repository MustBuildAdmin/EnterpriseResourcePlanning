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
use App\Models\Document;
use App\Models\Employee;
use App\Models\EmployeeDocument;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Leave;

class MyDetailsController extends Controller
{

    public function info()
    {
      
            // $empId        = Crypt::decrypt($id);
            $empId= \Auth::user()->creatorId();
            $documents    = Document::where('created_by', \Auth::user()->creatorId())->get();
            $branches     = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $departments  = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $designations = Designation::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            $employee     = Employee::where('id',$empId)->first();

            $employeesId  = \Auth::user()->employeeIdFormat(!empty($employee) ? $employee->employee_id : '');

            return view('mydetails.info', compact('employee', 'employeesId', 'branches', 'departments', 'designations', 'documents'));
            // return view('employee.show', compact('employee', 'employeesId', 'branches', 'departments', 'designations', 'documents'));
      
    }
    public function leave()
    {
        // echo "<pre>"; 
        // print_r(\Auth::user()->type);
        // exit;
        if(\Auth::user()->type == 'employee')
        {
            $user     = \Auth::user();
            $employee = Employee::where('user_id', '=', $user->id)->first();
            $leaves   = Leave::where('employee_id', '=', $employee->id)->get();
        }
        else
        {
            $leaves = Leave::where('created_by', '=', \Auth::user()->creatorId())->get();
        }

        // return view('leave.index', compact('leaves'));
        return view('mydetails.leave', compact('leaves'));
    }
    public function payslip()
    {
        $empId= \Auth::user()->creatorId();
        $employees     = Employee::where('id',$empId)->first();
        $month = [
            '01' => 'JAN',
            '02' => 'FEB',
            '03' => 'MAR',
            '04' => 'APR',
            '05' => 'MAY',
            '06' => 'JUN',
            '07' => 'JUL',
            '08' => 'AUG',
            '09' => 'SEP',
            '10' => 'OCT',
            '11' => 'NOV',
            '12' => 'DEC',
        ];

        $year = [
            '2022' => '2022',
            '2023' => '2023',
            '2024' => '2024',
            '2025' => '2025',
            '2026' => '2026',
            '2027' => '2027',
            '2028' => '2028',
            '2029' => '2029',
            '2030' => '2030',
        ];

        return view('mydetails.payslip',compact('employees', 'month', 'year'));
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
