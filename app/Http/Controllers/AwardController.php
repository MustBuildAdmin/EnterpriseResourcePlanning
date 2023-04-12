<?php

namespace App\Http\Controllers;

use App\Models\Award;
use App\Models\AwardType;
use App\Models\Employee;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AwardController extends Controller
{
    public function index()
    {
        $usr = \Auth::user();
        if($usr->can('manage award'))
        {
            $employees  = Employee::where('created_by', '=', \Auth::user()->creatorId())->get();
            $awardtypes = AwardType::where('created_by', '=', \Auth::user()->creatorId())->get();

            if(Auth::user()->type == 'employee')
            {
                $emp    = Employee::where('user_id', '=', \Auth::user()->id)->first();
                $awards = Award::where('employee_id', '=', $emp->id)->get();
            }
            else
            {
                $awards = Award::where('created_by', '=', \Auth::user()->creatorId())->get();
            }

            return view('hrm.admin_setup.award.award', compact('awards', 'employees', 'awardtypes'));
            // return view('award.index', compact('awards', 'employees', 'awardtypes'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('create award'))
        {
            $employees  = Employee::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $awardtypes = AwardType::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            return view('hrm.admin_setup.award.award_create', compact('employees', 'awardtypes'));
            // return view('award.create', compact('employees', 'awardtypes'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('create award'))
        {

            $validator = \Validator::make(
                $request->all(), [
                                   'employee_id' => 'required',
                                   'award_type' => 'required',
                                   'date' => 'required',
                                   'gift' => 'required',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $award              = new Award();
            $award->employee_id = $request->employee_id;
            $award->award_type  = $request->award_type;
            $award->date        = $request->date;
            $award->gift        = $request->gift;
            $award->description = $request->description;
            $award->created_by  = \Auth::user()->creatorId();
            $award->save();

            //Slack Notification
            $setting  = Utility::settings(\Auth::user()->creatorId());
            $emp = Employee::find($request->employee_id);
            $award = AwardType::find($request->award_type);
            if(isset($setting['award_notification']) && $setting['award_notification'] ==1){
                $msg = $award->name . " created for ". $emp->name . " from ".  $request->date;
                Utility::send_slack_msg($msg);
            }

            //Telegram Notification
            $setting  = Utility::settings(\Auth::user()->creatorId());
            $emp = Employee::find($request->employee_id);
            $award = AwardType::find($request->award_type);
            if(isset($setting['telegram_award_notification']) && $setting['telegram_award_notification'] ==1){
                $msg = $award->name . " created for ". $emp->name . " from ".  $request->date;
                Utility::send_telegram_msg($msg);
            }


            // Send Email
            $setings = Utility::settings();

            if($setings['award_create'] == 1)
            {
                $employee     = Employee::find($request->employee_id);
                $awardArr = [
                    'award_name' => $employee->name,
                    'award_email' => $employee->email,
                ];


                $resp = Utility::sendEmailTemplate('award_send', [$employee->id => $employee->email], $awardArr);

                return redirect()->route('award.index')->with('success', __('Award successfully created.') . (($resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));


            }


            return redirect()->route('award.index')->with('success', __('Award  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Award $award)
    {
        return redirect()->route('award.index');
    }

    public function edit(Award $award)
    {
        if(\Auth::user()->can('edit award'))
        {
            if($award->created_by == \Auth::user()->creatorId())
            {
                $employees  = Employee::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $awardtypes = AwardType::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

                return view('hrm.admin_setup.award.award_edit', compact('award', 'awardtypes', 'employees'));
                // return view('award.edit', compact('award', 'awardtypes', 'employees'));
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

    public function update(Request $request, Award $award)
    {
        if(\Auth::user()->can('edit award'))
        {
            if($award->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'employee_id' => 'required',
                                       'award_type' => 'required',
                                       'date' => 'required',
                                       'gift' => 'required',
                                   ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                $award->employee_id = $request->employee_id;
                $award->award_type  = $request->award_type;
                $award->date        = $request->date;
                $award->gift        = $request->gift;
                $award->description = $request->description;
                $award->save();

                return redirect()->route('award.index')->with('success', __('Award successfully updated.'));
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

    public function destroy(Award $award)
    {
        if(\Auth::user()->can('delete award'))
        {
            if($award->created_by == \Auth::user()->creatorId())
            {
                $award->delete();

                return redirect()->route('award.index')->with('success', __('Award successfully deleted.'));
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
