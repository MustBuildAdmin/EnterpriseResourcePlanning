<?php

namespace App\Http\Controllers;

use App\Models\Con_task;
use App\Models\Instance;
use App\Models\NonWorkingDaysModal;
use App\Models\Project;
use App\Models\Project_holiday;
use App\Models\Task;
use App\Models\Task_progress;
use App\Models\User;
use App\Models\Utility;
use DB;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;

class RevisionController extends Controller
{
    public function revision(Request $request)
    {

        $projectId = Session::get('project_id');
        $instanceId = Session::get('project_instance');
        $getInstance = Instance::where('project_id', $projectId)
            ->orderBy('id', 'DESC')->first();

        $nonWorkingDays = NonWorkingDaysModal::where('instance_id', $getInstance->instance)
            ->orderBy('id', 'DESC')->first();

        $projectHolidays = Project_holiday::where('instance_id', $getInstance->instance)
            ->orderBy('id', 'DESC')->get();

        if ($nonWorkingDays != null) {
            $setNonWorkingDays = explode(',', $nonWorkingDays->non_working_days);
        } else {
            $setNonWorkingDays = [];
        }

        return view('revision.revision', compact('setNonWorkingDays', 'projectHolidays'));
    }

    public function revision_store(Request $request)
    {
        try {
            $projectId = Session::get('project_id');
            $instanceId = Session::get('project_instance');
            $holidayDateGet = $request->holiday_date;

            $var = random_int('100000', '555555').date('dmyhisa').\Auth::user()->creatorId().$projectId;
            $instanceIdSet = Hash::make($var);
            $getPro = DB::table('projects')->where('id', $projectId)->first();

            if (isset($request->non_working_days)) {
                if (gettype($request->non_working_days) == 'array') {
                    $nonWorkingDays = implode(',', $request->non_working_days);
                    $nonWorkingDaysInsert = [
                        'project_id' => $projectId,
                        'non_working_days' => $nonWorkingDays,
                        'instance_id' => $instanceIdSet,
                        'created_by' => \Auth::user()->creatorId(),
                    ];

                    DB::table('non_working_days')->insert($nonWorkingDaysInsert);
                }
            }

            if ($getPro != null) {
                $instanceStore = new Instance;
                $instanceStore->instance = $instanceIdSet;
                $instanceStore->start_date = $getPro->start_date;
                $instanceStore->end_date = $getPro->end_date;
                $instanceStore->project_id = $projectId;
                $instanceStore->save();
            }

            if ($holidayDateGet != null) {
                foreach ($holidayDateGet as $holi_key => $holi_value) {

                    $holidayInsert = [
                        'project_id' => $projectId,
                        'date' => $holi_value,
                        'description' => $request->holiday_description[$holi_key],
                        'instance_id' => $instanceIdSet,
                        'created_by' => \Auth::user()->creatorId(),
                    ];

                    Project_holiday::insert($holidayInsert);
                }
            }

            $getConInstance = DB::table('con_tasks')->select('instance_id', 'project_id')
                ->where(['project_id' => $projectId, 'instance_id' => $instanceId])
                ->orderBy('main_id', 'DESC')->first();

            if ($getConInstance != null) {
                $conInstanceGet = $getConInstance->instance_id;

                DB::select(
                    "INSERT INTO con_tasks(
                        id,text,project_id,users,duration,progress,start_date,end_date,predecessors,instance_id,achive,
                        parent,sortorder,custom,created_at,updated_at,float_val,type
                    )
                    SELECT id,text,project_id,users,duration,progress,start_date,end_date,predecessors,
                    '".$instanceIdSet."' as instance_id,achive,parent,sortorder,custom,created_at,updated_at,
                    float_val,type FROM con_tasks WHERE project_id = ".$projectId." AND
                    instance_id='".$conInstanceGet."'"
                );
            }

            return redirect()->route('construction_main')->with('success', __('Revision Added Successfully'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function instance_project($instance_id, $project_id)
    {

        $returnpermission = 0;
        $getInstance = Instance::where('project_id', $project_id)->where(['id' => $instance_id])->first();
        $instanceId = $getInstance->instance;
        $usr = Auth::user();

        Session::forget('project_id');
        Session::forget('project_instance');
        Session::forget('latest_project_instance');
        Session::forget('current_revision_freeze');

        if (\Auth::user()->can('view project')) {
            Session::put('project_id', $project_id);
            Session::put('project_instance', $instanceId);

            $tasks = Con_task::where('project_id', $project_id)->where('instance_id', $instanceId)->get();

            $checkInstanceFreeze = Instance::where('project_id', $project_id)->orderBy('id', 'DESC')->first();
            Session::put('latest_project_instance', $checkInstanceFreeze->instance);

            if ($getInstance->freeze_status == 1) {
                Session::put('current_revision_freeze', 1); //Freezed
            } else {
                Session::put('current_revision_freeze', 0); //Not Freeze
            }

            $instanceall = Instance::where('project_id', $project_id)->orderBy('id', 'DESC')->get();
            if (count($instanceall) > 1) {
                Session::put('revision_started', 1); //Not Freeze
            }

            $project = Project::where(['id' => $project_id])->first();

            $userProjects = \Auth::user()->type == 'client' ?
                Project::where('client_id', \Auth::user()->id)->pluck('id', 'id')->toArray() :
                $usr->projects->pluck('id')->toArray();

            if (in_array($project_id, $userProjects)) {

                // test the holidays
                if ($project->holidays == 0) {
                    $holidays = Project_holiday::where(['project_id' => $project->id,
                        'instance_id' => Session::get('project_instance')])
                        ->first();
                    if (! $holidays) {
                        return redirect()->back()->with('error', __('No holidays are listed.'));
                    }
                }

                // end
                $project_data = [];
                // Task Count
                $tasks = Con_task::where('project_id', $project->id)->where('instance_id', Session::get('project_instance'))->get();
                $project_task = $tasks->count();
                $completedTask = Con_task::where('project_id', $project->id)->where('instance_id', Session::get('project_instance'))
                    ->where('progress', 100)->get();

                $project_done_task = $completedTask->count();

                $project_data['task'] = [
                    'total' => number_format($project_task),
                    'done' => number_format($project_done_task),
                    'percentage' => Utility::getPercentage($project_done_task, $project_task),
                ];

                // end Task Count

                // Expense
                $expAmt = 0;
                foreach ($project->expense as $expense) {
                    $expAmt += $expense->amount;
                }

                $project_data['expense'] = [
                    'allocated' => $project->budget,
                    'total' => $expAmt,
                    'percentage' => Utility::getPercentage($expAmt, $project->budget),
                ];
                // end expense

                // Users Assigned
                $total_users = User::where('created_by', '=', $usr->id)->count();

                $project_data['user_assigned'] = [
                    'total' => number_format($total_users).'/'.number_format($total_users),
                    'percentage' => Utility::getPercentage($total_users, $total_users),
                ];
                // end users assigned

                // Day left
                $total_day = Carbon::parse($project->start_date)->diffInDays(Carbon::parse($project->end_date));
                $remaining_day = Carbon::parse($project->start_date)->diffInDays(now());
                if ($total_day < $remaining_day) {
                    $remaining_day = $total_day;
                }
                $project_data['day_left'] = [
                    'day' => number_format($remaining_day).'/'.number_format($total_day),
                    'percentage' => Utility::getPercentage($remaining_day, $total_day),
                ];
                // end Day left

                // Open Task
                $remaining_task = Con_task::where('project_id', '=', $project->id)
                    ->where('instance_id', Session::get('project_instance'))
                    ->where('progress', '=', 100)->count();
                $total_task = $project_data['task']['total'];

                $project_data['open_task'] = [
                    'tasks' => number_format($remaining_task).'/'.number_format($total_task),
                    'percentage' => Utility::getPercentage($remaining_task, $total_task),
                ];
                // end open task

                // Milestone
                $total_milestone = $project->milestones()->count();
                $complete_milestone = $project->milestones()->where('status', 'LIKE', 'complete')->count();
                $project_data['milestone'] = [
                    'total' => number_format($complete_milestone).'/'.number_format($total_milestone),
                    'percentage' => Utility::getPercentage($complete_milestone, $total_milestone),
                ];
                // End Milestone

                // Time spent

                $times = $project->timesheets()->where('created_by', '=', $usr->id)->pluck('time')->toArray();
                $totaltime = str_replace(':', '.', Utility::timeToHr($times));
                $project_data['time_spent'] = [
                    'total' => number_format($totaltime).'/'.number_format($totaltime),
                    'percentage' => Utility::getPercentage(number_format($totaltime), $totaltime),
                ];
                // end time spent

                // Allocated Hours
                $hrs = Project::projectHrs($project->id);
                $project_data['task_allocated_hrs'] = [
                    'hrs' => number_format($hrs['allocated']).'/'.number_format($hrs['allocated']),
                    'percentage' => Utility::getPercentage($hrs['allocated'], $hrs['allocated']),
                ];
                // end allocated hours

                // Chart
                $seven_days = Utility::getLastSevenDays();
                $chart_task = [];
                $chart_timesheet = [];
                $cnt = 0;
                $cnt1 = 0;

                foreach (array_keys($seven_days) as $k => $date) {
                    $task_cnt = $project->tasks()->where('is_complete', '=', 1)
                        ->whereRaw("find_in_set('".$usr->id."',assign_to)")
                        ->where('marked_at', 'LIKE', $date)->count();
                    $arrTimesheet = $project->timesheets()->where('created_by', '=', $usr->id)
                        ->where('date', 'LIKE', $date)->pluck('time')->toArray();

                    // Task Chart Count
                    $cnt += $task_cnt;

                    // Timesheet Chart Count
                    $timesheet_cnt = str_replace(':', '.', Utility::timeToHr($arrTimesheet));
                    $cn[] = $timesheet_cnt;
                    $cnt1 += $timesheet_cnt;

                    $chart_task[] = $task_cnt;
                    $chart_timesheet[] = $timesheet_cnt;
                }

                $project_data['task_chart'] = [
                    'chart' => $chart_task,
                    'total' => $cnt,
                ];
                $project_data['timesheet_chart'] = [
                    'chart' => $chart_timesheet,
                    'total' => $cnt1,
                ];

                // end chart

                $total_sub = Con_task::where('project_id', $project->id)->where('instance_id', Session::get('project_instance'))
                    ->where('type', 'task')->count();
                $first_task = Con_task::where('project_id', $project->id)->where('instance_id', Session::get('project_instance'))
                    ->orderBy('id', 'ASC')->first();
                if ($first_task) {
                    $workdone_percentage = $first_task->progress;
                    $actual_percentage = $first_task->progress;
                    $no_working_days = $first_task->duration; // include the last day
                    $date2 = date_create($first_task->end_date);
                } else {
                    $workdone_percentage = '0';
                    $actual_percentage = '0';
                    $no_working_days = $project->estimated_days; // include the last day
                    $date2 = date_create($project->end_date);
                }
                if ($actual_percentage > 100) {
                    $actual_percentage = 100;
                }
                if ($actual_percentage < 0) {
                    $actual_percentage = 0;
                }

                $cur = date('Y-m-d');
                //############## END ##############################
                //############## Remaining days ###################
                $remaining_working_days = Utility::remaining_duration_calculator($date2, $project->id);
                $remaining_working_days = $remaining_working_days - 1; // include the last day
                //############## Remaining days ##################
                $completed_days = $no_working_days - $remaining_working_days;

                if ($no_working_days == 1) {
                    $current_Planed_percentage = 100;
                } else {
                    // percentage calculator
                    if ($no_working_days > 0) {
                        $perday = 100 / $no_working_days;
                    } else {
                        $perday = 0;
                    }
                    $current_Planed_percentage = round($completed_days * $perday);
                }

                if ($current_Planed_percentage > 100) {
                    $current_Planed_percentage = 100;
                }
                if ($current_Planed_percentage < 0) {
                    $current_Planed_percentage = 0;
                }

                if ($current_Planed_percentage > 0) {
                    $workdone_percentage = $workdone_percentage = $workdone_percentage / $current_Planed_percentage;
                } else {
                    $workdone_percentage = 0;
                }
                $workdone_percentage = $workdone_percentage * 100;
                if ($workdone_percentage > 100) {
                    $workdone_percentage = 100;
                }
                $remaing_percenatge = round(100 - $current_Planed_percentage);
                $project_task = Con_task::where('con_tasks.project_id', Session::get('project_id'))
                    ->where('con_tasks.type', 'task')->where('con_tasks.start_date', 'like', $cur.'%')->get();
                $not_started = 0;
                foreach ($project_task as $value) {
                    $result = Task_progress::where('task_id', $value->main_id)->first();
                    if (! $result) {
                        $not_started = $not_started + 1;
                    }
                }
                if ($remaining_working_days < 0) {
                    $remaining_working_days = 0;
                }
                $notfinished = Con_task::where('project_id', $project->id)
                    ->where('instance_id', Session::get('project_instance'))
                    ->where('type', 'task')->where('end_date', '<', $cur)->where('progress', '!=', '100')->count();
                $completed_task = Con_task::where('project_id', $project->id)
                    ->where('instance_id', Session::get('project_instance'))
                    ->where('type', 'task')->where('end_date', '<', $cur)->where('progress', '100')->count();

                $ongoing_task = Con_task::where('project_id', $project->id)
                    ->where('instance_id', Session::get('project_instance'))
                    ->where('type', 'task')->where('progress', '<', 100)->where('progress', '>', 0)->count();

                return view('construction_project.dashboard', compact('project', 'ongoing_task', 'project_data',
                    'total_sub', 'actual_percentage', 'workdone_percentage', 'current_Planed_percentage',
                    'not_started', 'notfinished', 'remaining_working_days', 'completed_task'));

                // $project_data = [];

                // // Task Count
                // $projectTask     = $tasks->count();
                // $projectDoneTask = $tasks->where('progress',100)->count();

                // $project_data['task'] = [
                //     'done'       => number_format($projectDoneTask),
                //     'total'      => number_format($projectTask),
                //     'percentage' => Utility::getPercentage($projectDoneTask, $projectTask),
                // ];
                // // end Task Count

                // // Expense
                // $expAmt = 0;
                // foreach($project->expense as $expense)
                // {
                //     $expAmt += $expense->amount;
                // }

                // $project_data['expense'] = [
                //     'allocated'  => $project->budget,
                //     'total'      => $expAmt,
                //     'percentage' => Utility::getPercentage($expAmt, $project->budget),
                // ];
                // // end expense

                // // Users Assigned
                // $totalUsers = User::where('created_by', '=', $usr->id)->count();

                // $project_data['user_assigned'] = [
                //     'total'      => number_format($totalUsers) . '/' . number_format($totalUsers),
                //     'percentage' => Utility::getPercentage($totalUsers, $totalUsers),
                // ];
                // // end users assigned

                // // Day left
                // $totalDay     = Carbon::parse($project->start_date)->diffInDays(Carbon::parse($project->end_date));
                // $remainingDay = Carbon::parse($project->start_date)->diffInDays(now());

                // if($totalDay < $remainingDay){
                //     $remainingDay = $totalDay;
                // }
                // $project_data['day_left'] = [
                //     'day'        => number_format($remainingDay) . '/' . number_format($totalDay),
                //     'percentage' => Utility::getPercentage($remainingDay, $totalDay),
                // ];
                // // end Day left

                // // Open Task
                // $totalTask = $project_data['task']['total'];

                // $project_data['open_task'] = [
                //     'tasks'      => number_format($projectDoneTask) . '/' . number_format($totalTask),
                //     'percentage' => Utility::getPercentage($projectDoneTask, $totalTask),
                // ];
                // // end open task

                // // Milestone
                // $totalMilestone           = $project->milestones()->count();
                // $completeMilestone        = $project->milestones()->where('status', 'LIKE', 'complete')->count();
                // $project_data['milestone'] = [
                //     'total'      => number_format($completeMilestone) . '/' . number_format($totalMilestone),
                //     'percentage' => Utility::getPercentage($completeMilestone, $totalMilestone),
                // ];
                // // End Milestone

                // // Time spent
                // $times = $project->timesheets()->where('created_by', '=', $usr->id)->pluck('time')->toArray();
                // $totaltime = str_replace(':', '.', Utility::timeToHr($times));
                // $project_data['time_spent'] = [
                //     'total' => number_format($totaltime) . '/' . number_format($totaltime),
                //     'percentage' => Utility::getPercentage(number_format($totaltime), $totaltime),
                // ];
                // // end time spent

                // // Allocated Hours
                // $hrs = Project::projectHrs($project_id);
                // $project_data['task_allocated_hrs'] = [
                //     'hrs' => number_format($hrs['allocated']) . '/' . number_format($hrs['allocated']),
                //     'percentage' => Utility::getPercentage($hrs['allocated'], $hrs['allocated']),
                // ];
                // // end allocated hours

                // // Chart
                // $sevenDays      = Utility::getLastSevenDays();
                // $chartTask      = [];
                // $chartTimesheet = [];
                // $cnt            = 0;
                // $cnt1           = 0;

                // foreach(array_keys($sevenDays) as $k => $date)
                // {
                //     $taskCnt     = $project->tasks()->where('is_complete', '=', 1)
                //         ->whereRaw("find_in_set('" . $usr->id . "',assign_to)")
                //         ->where('marked_at', 'LIKE', $date)->count();

                //     $arrTimesheet = $project->timesheets()->where('created_by', '=', $usr->id)
                //         ->where('date', 'LIKE', $date)->pluck('time')->toArray();

                //     // Task Chart Count
                //     $cnt += $taskCnt;

                //     // Timesheet Chart Count
                //     $timesheetCnt = str_replace(':', '.', Utility::timeToHr($arrTimesheet));
                //     $cn[]         = $timesheetCnt;
                //     $cnt1         += $timesheetCnt;

                //     $chartTask[]      = $taskCnt;
                //     $chartTimesheet[] = $timesheetCnt;
                // }

                // $project_data['task_chart']      = [
                //     'chart' => $chartTask,
                //     'total' => $cnt,
                // ];
                // $project_data['timesheet_chart'] = [
                //     'chart' => $chartTimesheet,
                //     'total' => $cnt1,
                // ];
                // // end chart

                // $total_sub = $tasks->where('type','task')->count();
                // $firstTask = Con_task::where(['project_id'=>$project_id,'instance_id'=>$instanceId])
                //     ->orderBy('id','ASC')->first();
                // if($firstTask){
                //     $workdone_percentage = $firstTask->progress;
                //     $actual_percentage   = $firstTask->progress;
                //     $no_working_days     = $firstTask->duration;// include the last day
                //     $date2               = date_create($firstTask->end_date);
                // }else{
                //     $workdone_percentage = '0';
                //     $actual_percentage   = '0';
                //     $no_working_days     = $project->estimated_days;// include the last day
                //     $date2               = date_create($project->end_date);
                // }

                // if($actual_percentage > 100){
                //     $actual_percentage = 100;
                // }

                // if($actual_percentage < 0){
                //     $actual_percentage = 0;
                // }

                // $cur = date('Y-m-d');

                // ############### Remaining days ###################
                //     $remaining_working_days = Utility::remaining_duration_calculator($date2,$project_id);
                //     $remaining_working_days = $remaining_working_days-1; // include the last day
                // ############### Remaining days ##################

                // $completed_days = $no_working_days-$remaining_working_days;

                // // percentage calculator
                // if($no_working_days>0){
                //     $perday = 100/$no_working_days;
                // }else{
                //     $perday = 0;
                // }

                // $current_Planed_percentage = round($completed_days*$perday);
                // if($current_Planed_percentage > 100){
                //     $current_Planed_percentage = 100;
                // }
                // if($current_Planed_percentage < 0){
                //     $current_Planed_percentage = 0;
                // }
                // if($current_Planed_percentage > 0){
                //     $workdone_percentage=$workdone_percentage = $workdone_percentage/$current_Planed_percentage;
                // }else{
                //     $workdone_percentage = 0;
                // }

                // round(100-$current_Planed_percentage);
                // $projectTasks = Con_task::where('con_tasks.project_id',$project_id)
                //     ->where('con_tasks.instance_id',$instanceId)
                //     ->where('con_tasks.type','task')
                //     ->where('con_tasks.start_date','like',$cur.'%')->get();

                // $not_started = 0;
                // foreach ($projectTasks as $value) {
                //     $result = Task_progress::where('task_id',$value->main_id)->first();
                //     if(!$result){
                //         $not_started = $not_started+1;
                //     }
                // }

                // if($remaining_working_days<0){
                //     $remaining_working_days=0;
                // }

                // $notfinished=Con_task::where('project_id',$project_id)
                //     ->where('instance_id',$instanceId)->where('type','task')
                //     ->where('end_date','<',$cur)->where('progress','!=','100')->count();
                // $completed_task=Con_task::where('project_id',$project_id)
                //     ->where('instance_id',$instanceId)->where('type','task')
                //     ->where('end_date','<',$cur)->where('progress','100')->count();

                // $ongoing_task=Con_task::where('project_id',$project_id)
                //     ->where('instance_id',$instanceId)
                //     ->where('type','task')->where('progress','<',100)->where('progress','>',0)->count();

                // $returnpermission = 1;

                // return view('construction_project.dashboard',
                //     compact('project','ongoing_task','project_data','total_sub','actual_percentage',
                //     'workdone_percentage','current_Planed_percentage','not_started','notfinished',
                //     'remaining_working_days','completed_task'));
            }
        }

        if ($returnpermission != 1) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
}
