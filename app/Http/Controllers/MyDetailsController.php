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
