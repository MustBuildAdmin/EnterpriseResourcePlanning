<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Termination;
use App\Models\TerminationType;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TerminationController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('manage termination'))
        {
            if(Auth::user()->type == 'employee')
            {
                $emp          = Employee::where('user_id', '=', \Auth::user()->id)->first();
                $terminations = Termination::where('created_by', '=', \Auth::user()->creatorId())->where('employee_id', '=', $emp->id)->get();
            }
            else
            {
                $terminations = Termination::where('created_by', '=', \Auth::user()->creatorId())->get();
            }

            return view('termination.index', compact('terminations'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('create termination'))
        {
            $employees        = Employee::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $terminationtypes = TerminationType::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            return view('termination.create', compact('employees', 'terminationtypes'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('create termination'))
        {

            $validator = \Validator::make(
                $request->all(), [
                                   'employee_id' => 'required',
                                   'termination_type' => 'required',
                                   'notice_date' => 'required',
                                   'termination_date' => 'required',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $termination                   = new Termination();
            $termination->employee_id      = $request->employee_id;
            $termination->termination_type = $request->termination_type;
            $termination->notice_date      = $request->notice_date;
            $termination->termination_date = $request->termination_date;
            $termination->description      = $request->description;
            $termination->created_by       = \Auth::user()->creatorId();
            $termination->save();

            $setings = Utility::settings();
            if($setings['termination_send'] == 1)
            {
                $employee           = Employee::find($termination->employee_id);
//                $termination->name  = $employee->name;
//                $termination->email = $employee->email;
                $termination->type  = TerminationType::find($termination->termination_type);

                $terminationArr = [
                    'termination_name'=>$employee->name,
                    'termination_email'=>$employee->email,
                    'notice_date'=>$termination->notice_date,
                    'termination_date'=>$termination->termination_date,
                    'termination_type'=>$request->termination_type,
                ];

                $resp = Utility::sendEmailTemplate('termination_send', [$employee->id => $employee->email], $terminationArr);


                return redirect()->route('termination.index')->with('success', __('Termination  successfully created.') .(($resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));


            }

            return redirect()->route('termination.index')->with('success', __('Termination  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Termination $termination)
    {
        return redirect()->route('termination.index');
    }

    public function edit(Termination $termination)
    {
        if(\Auth::user()->can('edit termination'))
        {
            $employees        = Employee::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $terminationtypes = TerminationType::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            if($termination->created_by == \Auth::user()->creatorId())
            {

                return view('termination.edit', compact('termination', 'employees', 'terminationtypes'));
            }
            else
            {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, Termination $termination)
    {
        if(\Auth::user()->can('edit termination'))
        {
            if($termination->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'employee_id' => 'required',
                                       'termination_type' => 'required',
                                       'notice_date' => 'required',
                                       'termination_date' => 'required',
                                   ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }


                $termination->employee_id      = $request->employee_id;
                $termination->termination_type = $request->termination_type;
                $termination->notice_date      = $request->notice_date;
                $termination->termination_date = $request->termination_date;
                $termination->description      = $request->description;
                $termination->save();

                return redirect()->route('termination.index')->with('success', __('Termination successfully updated.'));
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

    public function destroy(Termination $termination)
    {
        if(\Auth::user()->can('delete termination'))
        {
            if($termination->created_by == \Auth::user()->creatorId())
            {
                $termination->delete();

                return redirect()->route('termination.index')->with('success', __('Termination successfully deleted.'));
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

    public function description($id)
    {
        $termination = Termination::find($id);

        return view('termination.description', compact('termination'));
    }

}
