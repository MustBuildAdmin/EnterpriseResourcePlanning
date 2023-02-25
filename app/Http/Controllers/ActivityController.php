<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Task;
use App\Models\Email;
use App\Models\Activity;
use App\Models\Schedule;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function activity()
    {
        if(\Auth::user()->can('view CRM activity'))
        {
            $notes = Note::where('created_by',\Auth::user()->creatorId())->orderBy('id','desc')->get();
            $tasks = Task::where('created_by',\Auth::user()->creatorId())->orderBy('id','desc')->get();
            $emails = Email::where('created_by',\Auth::user()->creatorId())->orderBy('id','desc')->get();
            $log_activities = LogActivity::where('created_by',\Auth::user()->creatorId())->orderBy('id','desc')->get();
            $schedules = Schedule::where('created_by',\Auth::user()->creatorId())->orderBy('id','desc')->get();
            $results=$results1=$results2=$results3=$results4=[];

            foreach($notes as $note)
            {
                $noteResult= Activity::get_activity($note->module_type,$note->module_id);
                $noteResult['note'] = $note->note;
                $noteResult['created_at'] = $note->created_at->format('Y-m-d H:m:s');
                $results[] = $noteResult;
            }
            foreach($tasks as $task)
            {
                $taskResult= Activity::get_activity($task->module_type,$task->module_id);
                $taskResult['note'] = $task->description;
                $taskResult['created_at'] = $task->created_at->format('Y-m-d H:m:s');
                $taskResult['agent_or_manager'] = $task->agent_or_manager;
                $results1[] = $taskResult;
            }
            foreach($emails as $email)
            {
                $emailResult= Activity::get_activity($email->module_type,$email->module_id);
                $emailResult['note'] = $email->description;
                $emailResult['created_at'] = $email->created_at->format('Y-m-d H:m:s');
                $emailResult['email'] = $email->email;
                $results2[] = $emailResult;
            }
            foreach($log_activities as $log_activity)
            {
                $logactivityResult= Activity::get_activity($log_activity->module_type,$log_activity->module_id);
                $logactivityResult['note'] = $log_activity->note;
                $logactivityResult['created_at'] = $log_activity->created_at->format('Y-m-d H:m:s');
                $logactivityResult['start_date'] = $log_activity->start_date;
                $logactivityResult['time'] = $log_activity->time;
                $logactivityResult['type'] = $log_activity->type;
                $results3[] = $logactivityResult;
            }
            foreach($schedules as $schedule)
            {
                $scheduleResult= Activity::get_activity($schedule->module_type,$schedule->module_id);
                $scheduleResult['note'] = $schedule->note;
                $scheduleResult['created_at'] = $schedule->created_at->format('Y-m-d H:m:s');
                $scheduleResult['start_date'] = $schedule->start_date;
                $scheduleResult['time'] = $schedule->start_time;
                $scheduleResult['type'] = $schedule->schedule_type;
                $results4[] = $scheduleResult;
            }
            return view('crm.activity.view',compact('results','results1','results2','results3','results4'));
        }
        else
        {
            return redirect()->back()->with('errors', __('Permission denied.'));
        }

    }
}
