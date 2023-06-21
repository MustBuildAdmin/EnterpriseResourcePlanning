<?php

namespace App\Http\Controllers;
use App\Models\Branch;
use App\Models\Competencies;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Indicator;
use App\Models\PerformanceType;
use Illuminate\Http\Request;

class IndicatorController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('manage indicator'))
        {
            $user = \Auth::user();
            if($user->type == 'employee')
            {
                $employee = Employee::where('user_id', $user->id)->first();
                $indicators = Indicator::where('created_by', '=', $user->creatorId())->where('branch', $employee->branch_id)->where('department', $employee->department_id)->where('designation', $employee->designation_id)->get();
            }
            else
            {
                $indicators = Indicator::where('created_by', '=', $user->creatorId())->get();
            }

            return view('indicator.index', compact('indicators'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        $brances     = Branch::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $performance     = PerformanceType::where('created_by', '=', \Auth::user()->creatorId())->get();
        $departments = Department::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $departments->prepend('Select Department', '');
        return view('indicator.create', compact( 'brances', 'departments','performance'));
    }


    public function store(Request $request)
    {
        if(\Auth::user()->can('create indicator'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'branch' => 'required',
                                   'department' => 'required',
                                   'designation' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }


            $indicator              = new Indicator();
            $indicator->branch      = $request->branch;
            $indicator->department  = $request->department;
            $indicator->designation = $request->designation;

            $indicator->rating      = json_encode($request->rating, true);

            if(\Auth::user()->type == 'company')
            {
                $indicator->created_user = \Auth::user()->creatorId();
            }
            else
            {
                $indicator->created_user = \Auth::user()->id;
            }

            $indicator->created_by = \Auth::user()->creatorId();
            $indicator->save();

            return redirect()->route('indicator.index')->with('success', __('Indicator successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function show(Indicator $indicator)
    {
        $ratings = json_decode($indicator->rating,true);
        $performance     = PerformanceType::where('created_by', '=', \Auth::user()->creatorId())->get();

        return view('indicator.show', compact('indicator','ratings','performance'));
    }


    public function edit(Indicator $indicator)
    {
        if(\Auth::user()->can('edit indicator'))
        {

            $performance     = PerformanceType::where('created_by', '=', \Auth::user()->creatorId())->get();
            $brances        = Branch::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $departments    = Department::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $departments->prepend('Select Department', '');

            $ratings = json_decode($indicator->rating,true);

            return view('indicator.edit', compact( 'brances', 'departments','performance','indicator','ratings'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function update(Request $request, Indicator $indicator)
    {

        if(\Auth::user()->can('edit indicator'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'branch' => 'required',
                                   'department' => 'required',
                                   'designation' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }


            $indicator->branch      = $request->branch;
            $indicator->department  = $request->department;
            $indicator->designation = $request->designation;

            $indicator->rating = json_encode($request->rating, true);
            $indicator->save();

            return redirect()->route('indicator.index')->with('success', __('Indicator successfully updated.'));
        }
    }


    public function destroy(Indicator $indicator)
    {
        if(\Auth::user()->can('delete indicator'))
        {
            if($indicator->created_by == \Auth::user()->creatorId())
            {
                $indicator->delete();

                return redirect()->route('indicator.index')->with('success', __('Indicator successfully deleted.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
