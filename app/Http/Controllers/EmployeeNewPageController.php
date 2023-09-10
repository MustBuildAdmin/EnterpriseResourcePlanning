<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

//use Faker\Provider\File;

class EmployeeNewPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::user()->can('manage employee')) {
            if (Auth::user()->type == 'employee') {
                $employees = Employee::where('user_id', '=', Auth::user()->id)->where('user_id', '!=', 1)
                    ->leftjoin('designations', 'employees.designation_id', '=', 'designations.id')
                    ->select('employees.*', 'designations.name as designation_name')
                    ->get();
            } else {
                $employees = Employee::where('employees.created_by', \Auth::user()->creatorId())->where('user_id', '!=', 1)
                    ->leftjoin('designations', 'employees.designation_id', '=', 'designations.id')
                    ->select('employees.*', 'designations.name as designation_name')
                    ->get();
            }

            // dd($employees);
            return view('hrm.employee_setup_new_page.employee', compact('employees'));
            // return view('employee.index', compact('employees'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display Employee details.
     *
     * @return \Illuminate\Http\Response
     */
    public function employee_details($user_id)
    {
        if (\Auth::user()->can('manage employee')) {
            $id = Crypt::decrypt($user_id);
            $user_details = User::join('employees', 'employees.user_id', '=', 'users.id')
                ->join('designations', 'employees.designation_id', '=', 'designations.id')
                ->where('users.id', '=', $id)
                ->select('users.*', 'employees.employee_id as employee_id', 'designations.name as designation_name')
                ->first();
            // dd($user_details);
            // dd($user_details->name);
            if ($user_details) {
                return view('hrm.employee_setup_new_page.employee_details', compact('user_details'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }
}
