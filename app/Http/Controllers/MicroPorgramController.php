<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use App\Models\MicroLink;
use App\Models\Instance;
use App\Models\MicroProgramScheduleModal;
use App\Models\MicroTask;
use App\Models\ProjectTask;
use App\Models\Project;
use App\Models\Utility;
use App\Models\Micro_Task_progress;
use App\Models\Project_holiday;
use App\Models\NonWorkingDaysModal;
use App\Models\Con_task;
use Carbon\CarbonPeriod;
use Auth;
use DB;
use Illuminate\Support\Str;
use Exception;
use DateTime;
class MicroPorgramController extends Controller
{
    public function microprogram(Request $request){
        if (Session::has('project_id')) {
            $project_id    = Session::get('project_id');
            $instance_id   = Session::get('project_instance');
            $now           = Carbon::now();
            $weekStartDate = $now->startOfWeek()->format('Y-m-d');
            $weekEndDate   = $now->endOfWeek()->format('Y-m-d');
            $freezeCheck   = Instance::where('project_id', $project_id)
                ->where('instance', Session::get('project_instance'))->pluck('freeze_status')->first();
            // if($freezeCheck == 1){
                $MicroProgramScheduleModal = MicroProgramScheduleModal::where('project_id',$project_id)
                    ->where('instance_id',$instance_id)
                    ->where('status',1)
                    ->orderBy('id','ASC')
                    ->get();
                    
                    return view('microprogram.index')
                        ->with('MicroProgramScheduleModal',$MicroProgramScheduleModal)
                        ->with('weekStartDate',$weekStartDate)
                        ->with('weekEndDate',$weekEndDate);
            // }
            // else{
            //     return redirect()->back()->with('error', __('Project Not Freezed.'));
            // }
        }
        else {
            return redirect()->route('construction_main')->with('error', __('Session Expired'));
        }
    }

    public function microprogram_create(Request $request){
        $all_dates = "";
        $project_id  = Session::get('project_id');
        $instance_id = Session::get('project_instance');

        $exist_shedule_date = MicroProgramScheduleModal::where('project_id',$project_id)
            ->where('instance_id',$instance_id)
            ->where('status',1)->get();

        if(!empty($exist_shedule_date)){
            foreach ($exist_shedule_date as $checkSchedule) {
                $startDate = Carbon::createFromFormat('Y-m-d', $checkSchedule->schedule_start_date);
                $endDate   = Carbon::createFromFormat('Y-m-d', $checkSchedule->schedule_end_date);
                $all_dates = array();
                while ($startDate->lte($endDate)){
                    $all_dates[] = $startDate->toDateString();
                    $startDate->addDay();
                }
            }

            $all_dates = json_encode($all_dates);
        }
    
        return view('microprogram.create')->with('all_dates',$all_dates);
    }

    public function change_schedule_status(Request $request){
        $schedule_data = $request->schedule_data;
        $project_id    = Session::get('project_id');
        $instance_id   = Session::get('project_instance');

        MicroProgramScheduleModal::where('project_id',$project_id)
            ->where('instance_id',$instance_id)
            ->update(['active_status'=>0]);

        MicroProgramScheduleModal::where('project_id',$project_id)
            ->where('instance_id',$instance_id)
            ->where('id',$schedule_data)
            ->update(['active_status'=>1]);

        return 1;
    }

    public function schedule_store(Request $request){
        $project_id    = Session::get('project_id');
        $instance_id   = Session::get('project_instance');

        $project = Project::select('id','project_name')->where('id',$project_id)->first();
        $projectName = str_split($project->project_name, 3);
        $uuid = $projectName['0'].'-'.substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 5);

        $date1 = new DateTime($request->schedule_start_date);
        $date2 = new DateTime($request->schedule_end_date);
        $interval = $date1->diff($date2);

        if($interval->days == 0){
            $intervalDays = $request->duration;
        }
        else{
            $intervalDays = $interval->days;
        }
    
        $schedule                      = new MicroProgramScheduleModal;
        $schedule->uid                 = $uuid;
        $schedule->schedule_name       = $request->schedule_name;
        $schedule->project_id          = $project_id;
        $schedule->instance_id         = $instance_id;
        $schedule->schedule_duration   = $intervalDays;
        $schedule->schedule_start_date = $request->schedule_start_date;
        $schedule->schedule_end_date   = $request->schedule_end_date;
        $schedule->schedule_goals      = $request->schedule_goals;
        $schedule->insert_date         = date('Y-m-d');
        $schedule->save();

        return redirect()->back()->with('success', __('Schedule Created.'));
    }

    public function schedule_task_show(Request $request){
        if (Session::has('project_id')) {
            $now           = Carbon::now();
            $secheduleId   = $request->id;
            $weekStartDate = $now->startOfWeek()->format('Y-m-d');
            $weekEndDate   = $now->endOfWeek()->format('Y-m-d');
            $project_id    = Session::get('project_id');
            $instance_id   = Session::get('project_instance');
            
            $freezeCheck = Instance::where('project_id', $project_id)
                ->where('instance', Session::get('project_instance'))->pluck('freeze_status')->first();
            // if($freezeCheck == 1){
                $scheduleGet = MicroProgramScheduleModal::where('project_id',$project_id)
                    ->where('id',$secheduleId)
                    ->where('instance_id',$instance_id)
                    ->where('status',1)
                    ->first();

                $microSchedule = MicroTask::select('micro_tasks.text', 'micro_tasks.users', 'micro_tasks.duration',
                    'micro_tasks.progress', 'micro_tasks.start_date', 'micro_tasks.end_date', 'micro_tasks.id',
                    'micro_tasks.instance_id', 'micro_tasks.task_id as main_id', 'pros.project_name',
                    'pros.id as project_id', 'pros.instance_id as pro_instance_id')
                    ->join('projects as pros', 'pros.id', 'micro_tasks.project_id')
                    ->whereNotNull('pros.instance_id')
                    ->where('micro_tasks.micro_flag',1)
                    ->where('micro_tasks.project_id', $project_id)
                    ->where('micro_tasks.instance_id', $instance_id)
                    ->where('micro_tasks.schedule_id',$secheduleId);

                    if (\Auth::user()->type != 'company') {
                        $microSchedule->whereRaw("find_in_set('".\Auth::user()->id."',users)");
                    }

                    $microSchedule = $microSchedule->orderBy('micro_tasks.schedule_order','ASC')->get();

                // DB::connection()->enableQueryLog();
                $weekSchedule = Con_task::select('con_tasks.text', 'con_tasks.users', 'con_tasks.duration',
                    'con_tasks.progress', 'con_tasks.start_date', 'con_tasks.end_date', 'con_tasks.id',
                    'con_tasks.instance_id', 'con_tasks.main_id', 'pros.project_name',
                    'pros.id as project_id', 'pros.instance_id as pro_instance_id')
                    ->join('projects as pros', 'pros.id', 'con_tasks.project_id')
                    ->whereNotNull('pros.instance_id')
                    ->where('con_tasks.project_id', $project_id)
                    ->where('con_tasks.instance_id', $instance_id)
                    ->where('con_tasks.type','task')
                    ->where(function ($query) use ($weekStartDate, $weekEndDate) {
                        $query->whereDate('con_tasks.end_date', '>=', $weekStartDate);
                        $query->whereDate('con_tasks.end_date', '<=', $weekEndDate);
                    });

                    if (\Auth::user()->type != 'company') {
                        $weekSchedule->whereRaw("find_in_set('".\Auth::user()->id."',users)");
                    }

                    $weekSchedule = $weekSchedule->orderBy('con_tasks.start_date','ASC')->get();
                    // $queries = \DB::getQueryLog();

                    $remaining_working_days = Utility::remaining_duration_calculator($scheduleGet->schedule_end_date,$project_id);
                    $remaining_working_days = $remaining_working_days != 0 ?
                    $remaining_working_days-1 : 0;// include the last day

                    ############### Remaining days ##################

                    $date1 = new DateTime($scheduleGet->schedule_start_date);
                    $date2 = new DateTime($scheduleGet->schedule_end_date);
                    $interval = $date1->diff($date2);

                    if($interval->days == 0){
                        $intervalDays = $scheduleGet->duration;
                    }
                    else{
                        $intervalDays = $interval->days;
                    }

                    $completed_days = $intervalDays - $remaining_working_days;
                    
                    if($intervalDays == 1){
                        $current_Planed_percentage = 100;
                    }
                    else{
                        // percentage calculator
                        if($intervalDays > 0){
                            $perday = 100/$intervalDays;
                        }else{
                            $perday = 0;
                        }

                        $current_Planed_percentage = round($completed_days*$perday);
                    }

                    return view('microprogram.schedule_task_show')->with('weekSchedule',$weekSchedule)
                        ->with('weekStartDate',$weekStartDate)
                        ->with('weekEndDate',$weekEndDate)
                        ->with('scheduleGet',$scheduleGet)
                        ->with('microSchedule',$microSchedule)
                        ->with('current_Planed_percentage',$current_Planed_percentage)
                        ->with('intervalDays',$intervalDays);
            // }
            // else{
            //     return redirect()->back()->with('error', __('Project Not Freezed.'));
            // }
        }
        else {
            return redirect()->route('construction_main')->with('error', __('Session Expired'));
        }
    }

    public function micro_taskboard(Request $request){
        if (Session::has('project_id')) {
            $project_id  = Session::get('project_id');
            $instance_id = Session::get('project_instance');
            $freezeCheck = Instance::where('project_id', $project_id)
                ->where('instance', Session::get('project_instance'))->pluck('freeze_status')->first();
            // if($freezeCheck == 1){
                // Session::put('task_filter',$request->status);
                $tasks = ProjectTask::where('created_by', \Auth::user()->creatorId())->get();
                return view('microprogram.micro_taskboard',
                    compact('tasks', 'project_id',));
                
                
            // }
            // else {
            //     return redirect()->back()->with('error', __('Project Not Freezed.'));
            // }
        } else {
            return redirect()->route('construction_main')->with('error', __('Session Expired'));
        }
    }

    public function micro_task_autocomplete(Request $request){
        $searchValue = $request['q'];
        if($request->filled('q')){
            $consTask = MicroTask::search($searchValue)
                ->where('project_id',Session::get('project_id'))
                ->where('instance_id',Session::get('project_instance'))
                ->where('type','task')
                ->orderBy('text','ASC')
                ->get();
        }

        $conData = array();
        if(count($consTask) > 0){
            foreach($consTask as $task){
                $setTask = [
                    'id' => $task->id,
                    'text' => $task->text
                ];
                $conData[] = $setTask;
            }
        }

        echo json_encode($conData);
    }

    public function micro_task_autocomplete_main(Request $request){
        $searchValue = $request['q'];
        if($request->filled('q')){
            $consTask = MicroTask::search($searchValue)
                ->where('project_id',Session::get('project_id'))
                ->where('instance_id',Session::get('project_instance'))
                ->where('type','project')
                ->orderBy('text','ASC')
                ->get();
        }

        $conData = array();
        if(count($consTask) > 0){
            foreach($consTask as $task){
                $setTask = [
                    'id' => $task->id,
                    'text' => $task->text
                ];
                $conData[] = $setTask;
            }
        }

        echo json_encode($conData);
    }

    public function micro_get_all_task(Request $request){
        $project_id     = Session::get('project_id');
        $instance_id    = Session::get('project_instance');
        $get_start_date = $request->start_date;
        $get_end_date   = $request->end_date;
        $status_task    = $request->status_task;
        $task_id_arr    = $request->task_id_arr;
        $user_id_arr    = $request->user_id;

        // 3 > Pending Task
        // 4 > Completed Task

        $setting = Utility::settings(\Auth::user()->creatorId());
        if ($setting['company_type'] == 2) {

            $tasks = MicroTask::select('micro_tasks.text', 'micro_tasks.users', 'micro_tasks.duration',
                'micro_tasks.progress', 'micro_tasks.start_date', 'micro_tasks.end_date', 'micro_tasks.task_id as id',
                'micro_tasks.instance_id', 'micro_tasks.id as main_id', 'pros.project_name',
                'pros.id as project_id', 'pros.instance_id as pro_instance_id')
                ->join('projects as pros', 'pros.id', 'micro_tasks.project_id')
                ->join('microprogram_schedule as micro', 'micro_tasks.schedule_id', 'micro.id')
                ->whereNotNull('pros.instance_id')
                ->where('micro.active_status', 1)
                ->where('micro_tasks.project_id', $project_id)
                ->where('micro_tasks.instance_id', $instance_id)
                ->where('micro_tasks.type', 'task');

            if (\Auth::user()->type != 'company') {
                $tasks->whereRaw("find_in_set('".\Auth::user()->id."',users)");
            }

            if($task_id_arr != null){
                $tasks->whereIn('micro_tasks.task_id',$task_id_arr);
            }

            if($get_start_date != null && $get_end_date != null){
                $tasks->where(function ($query) use ($get_start_date, $get_end_date) {
                    $query->whereDate('micro_tasks.start_date', '>=', $get_start_date);
                    $query->whereDate('micro_tasks.end_date', '<', $get_end_date);
                });
            }

            if($user_id_arr != null){
                $tasks->where(function ($query) use ($user_id_arr) {
                    foreach($user_id_arr as $get_user_id){
                        if($get_user_id != ""){
                            $query->orwhereJsonContains('micro_tasks.users', $get_user_id);
                        }
                    }
                });
            }

            if($status_task != null){
                if($status_task == "3"){
                    $tasks->where('progress','<','100')
                        ->whereDate('micro_tasks.end_date', '<', date('Y-m-d'));
                }
                elseif($status_task == "4"){
                    $tasks->where('progress','>=','100');
                }
            }

            if($task_id_arr == null && $user_id_arr == null && $get_start_date == null &&
                $get_end_date == null && $status_task == null){

                if(Session::get('task_filter')=='comp'){
                    $tasks->where(function($query) {
                        $query->orwhere('progress', '=', '100');
                    })
                        ->orderBy('micro_tasks.end_date', 'DESC');

                }elseif(Session::get('task_filter')=='ongoing'){
                    $tasks->where(function($query) {
                        $query->orwhere('progress', '>', '0')->where('progress', '!=', '100')
                        ->whereDate('micro_tasks.end_date', '>', date('Y-m-d'));
                    })
                        ->orderBy('micro_tasks.end_date', 'DESC');
                }elseif(Session::get('task_filter')=='remaning'){
                    $tasks->where(function($query) {
                        $query->orwhere('progress', '!=', '100');
                    })
                        ->orderBy('micro_tasks.end_date', 'DESC');
                }elseif(Session::get('task_filter')=='pending'){
                    $tasks->where(function($query) {
                        $query->orwhere('progress', '<', '100')
                        ->whereDate('micro_tasks.end_date', '<', date('Y-m-d'));
                    })
                        ->orderBy('micro_tasks.end_date', 'DESC');
                }else{
                    $tasks->where(function($query) {
                        $query->whereRaw('"'.date('Y-m-d').'"
                            between date(`micro_tasks`.`start_date`) and date(`micro_tasks`.`end_date`)')
                            ->orwhere('micro_tasks.progress', '<', '100')
                            ->whereDate('micro_tasks.end_date', '<', date('Y-m-d'));
                    })
                        ->orderBy('micro_tasks.end_date', 'ASC');
                }
            }

            $tasks = $tasks->get();

            $returnHTML = view('microprogram.micro_all_task_list', compact('tasks', 'get_end_date'))->render();

            return response()->json(
                [
                    'success' => true,
                    'all_task' => $returnHTML,
                ]
            );
        }
    }

    public function micro_main_task_list(Request $request){
        $project_id     = Session::get('project_id');
        $get_start_date = $request->start_date;
        $get_end_date   = $request->end_date;
        $status_task    = $request->status_task;
        $task_id_arr    = $request->task_id_arr;
        $instance_id    = Session::get('project_instance');

        // 3 > Pending Task
        // 4 > Completed Task

        $setting  = Utility::settings(\Auth::user()->creatorId());
        if($setting['company_type']==2){

            $show_parent_task = MicroTask::select('micro_tasks.text','micro_tasks.users','micro_tasks.duration',
                'micro_tasks.progress','micro_tasks.start_date','micro_tasks.end_date','micro_tasks.id as main_id',
                'micro_tasks.instance_id','micro_tasks.task_id as id','pros.project_name',
                'pros.id as project_id','pros.instance_id as pro_instance_id')
                ->join('projects as pros','pros.id','micro_tasks.project_id')
                ->join('microprogram_schedule as micro', 'micro_tasks.schedule_id', 'micro.id')
                ->where('micro.active_status', 1)
                ->where('micro_tasks.project_id', $project_id)
                ->where('micro_tasks.instance_id', $instance_id)
                ->where('micro_tasks.type','project');

            if(\Auth::user()->type != 'company'){
                $show_parent_task->whereRaw("find_in_set('" . \Auth::user()->id . "',users)");
            }

            if($task_id_arr != null){
                $show_parent_task->whereIn('micro_tasks.id',$task_id_arr);
            }

            if($get_start_date != null && $get_end_date != null){
                $show_parent_task->where(function ($query) use ($get_start_date, $get_end_date) {
                    $query->whereDate('micro_tasks.start_date', '>=', $get_start_date);
                    $query->whereDate('micro_tasks.end_date', '<', $get_end_date);
                });
            }

            if($status_task != null){
                if($status_task == "3"){
                    $show_parent_task->where('progress','<','100')
                        ->whereDate('micro_tasks.end_date', '<', date('Y-m-d'));
                }
                elseif($status_task == "4"){
                    $show_parent_task->where('progress','>=','100');
                }
            }

            if($task_id_arr == null && $get_start_date == null &&
                $get_end_date == null && $status_task == null){
                $show_parent_task->orderBy('micro_tasks.end_date','ASC');
            }

            $show_parent_task = $show_parent_task->get();
            
            $returnHTML = view('microprogram.micro_main_task_list', compact('show_parent_task'))->render();

            return response()->json(
                [
                    'success' => true,
                    'main_task' => $returnHTML,
                ]
            );
        }
    }

    public function micro_task_particular(Request $request){
        
        $projectId  = Session::get('project_id');
        $getProject = Project::find($projectId);
        $instanceId = Session::has('project_id') ?
            Session::get('project_instance') : $getProject->instance_id;
        $get_date   = $request['get_date'] == '' ?
            date('Y-m-d') : $request['get_date'];

        if (isset($request['task_id'])) {
            $task_id = $request['task_id'];
            $get_con_task = MicroTask::where('id', $task_id)->where('instance_id', $instanceId)->first();

            $get_popup_data_con = MicroTask::Select('micro_tasks.*', 'projects.project_name', 'projects.description')
                ->join('projects', 'projects.id', 'micro_tasks.project_id')
                ->where('micro_tasks.id', $task_id)
                ->where('micro_tasks.instance_id', $instanceId)
                ->where('micro_tasks.project_id',$projectId)
                ->first();

            if (\Auth::user()->type != 'company') {
                $get_task_progress = Micro_Task_progress::
                    select('micro_task_progress.*', \DB::raw('group_concat(file.filename) as filename'))
                    ->leftjoin('micro_task_progress_file as file',
                        \DB::raw('FIND_IN_SET(file.id,micro_task_progress.file_id)'), '>', \DB::raw("'0'"))
                    ->where('micro_task_progress.task_id', $task_id)
                    ->where('user_id', \Auth::user()->id)
                    ->where('micro_task_progress.project_id', $get_popup_data_con->project_id)
                    ->where('micro_task_progress.instance_id', $instanceId)
                    ->groupBy('micro_task_progress.id')
                    ->get();
            }
            else {
                $get_task_progress = Micro_Task_progress::
                    select('micro_task_progress.*', \DB::raw('group_concat(file.filename) as filename'))
                    ->leftjoin('micro_task_progress_file as file',
                        \DB::raw('FIND_IN_SET(file.id,micro_task_progress.file_id)'), '>', \DB::raw("'0'"))
                    ->where('micro_task_progress.task_id', $task_id)
                    ->where('micro_task_progress.project_id', $get_popup_data_con->project_id)
                    ->where('micro_task_progress.instance_id', $instanceId)
                    ->groupBy('micro_task_progress.id')
                    ->get();
            }

            if ($get_date <= date('Y-m-d')) {
                $get_popup_data = Micro_Task_progress::where('task_id', $task_id)
                    ->whereDate('created_at', $get_date)
                    ->where('instance_id', $instanceId)
                    ->select('percentage', 'description')->first();

                if ($get_popup_data != null) {
                    $data = [
                        'percentage' => $get_popup_data->percentage,
                        'desc' => $get_popup_data->description,
                        'get_date' => $get_date,
                        'con_data' => $get_popup_data_con,
                        'get_task_progress' => $get_task_progress,
                    ];
                } else {
                    $data = [
                        'percentage' => '',
                        'desc' => '',
                        'get_date' => $get_date,
                        'con_data' => $get_popup_data_con,
                        'get_task_progress' => $get_task_progress,
                    ];
                }
            } else {
                $data = [
                    'percentage' => '',
                    'desc' => '',
                    'get_date' => $get_date,
                    'con_data' => $get_popup_data_con,
                    'get_task_progress' => $get_task_progress,
                ];
            }
        }

        $total_count_of_task = Micro_Task_progress::where('task_id', $task_id)
            ->where('instance_id', $instanceId)
            ->groupBy('created_at')
            ->get()->count();

        $actualStartDate = Micro_Task_progress::where('task_id', $task_id)
            ->where('instance_id', $instanceId)
            ->orderBy('record_date','ASC')
            ->first();

        $actualEndDate = Micro_Task_progress::where('task_id', $task_id)
            ->where('instance_id', $instanceId)
            ->orderBy('record_date','DESC')
            ->first();

        $remaining_working_days = Utility::remaining_duration_calculator(
            $get_con_task->end_date, $get_con_task->project_id);
        $remaining_working_days = $remaining_working_days != 0 ? $remaining_working_days-1 : 0; // include the last day
        $completed_days = $get_con_task->duration - $remaining_working_days;

        if ($get_con_task->duration == 1) {
            $current_Planed_percentage = 100;
        } else {
            // percentage calculator
            $perday = $get_con_task->duration > 0 ?
                100 / $get_con_task->duration : 0;

            $current_Planed_percentage = round($completed_days * $perday);
        }


        return view('microprogram.micro_task_particular_list',
            compact('task_id', 'data', 'current_Planed_percentage','total_count_of_task',
            'actualStartDate','actualEndDate'));
    }

    public function micro_add_particular_task(Request $request){
        $projectId = Session::get('project_id');
        $getProject = Project::find($projectId);

        if (Session::has('project_id')) {
            $instanceId = Session::get('project_instance');
        } else {
            $instanceId = $getProject->instance_id;
        }

        $task_id = $request->task_id;
        $get_date = $request->get_date;
        $get_con_task = MicroTask::where('id', $task_id)
            ->where('instance_id', $instanceId)->first();

        $data = [
            'get_date' => $get_date,
            'con_data' => $get_con_task,
        ];

        $get_all_dates = [];

        if (\Auth::user()->type == 'company') {
            $getHoliday = Project_holiday::where('created_by', \Auth::user()->id)
                ->where('instance_id', $instanceId)->get();
        } else {
            $getHoliday = Project_holiday::where('created_by', \Auth::user()->creatorId())
                ->where('instance_id', $instanceId)->get();
        }

        if(!empty($getHoliday)){
            foreach ($getHoliday as $check_holiday) {
                $get_all_dates[] = $check_holiday->date;
            }
        }

        $get_all_dates = json_encode($get_all_dates);

        $nonWorkingDay = NonWorkingDaysModal::where('project_id', $projectId)
            ->where('instance_id', $instanceId)
            ->orderBy('id', 'DESC')->first();

        return view('microprogram.micro_add_particular_task', compact('data','task_id','nonWorkingDay'))
            ->with('get_all_dates',$get_all_dates);
    }

    public function micro_edit_particular_task(Request $request){
        $projectId  = Session::get('project_id');
        $getProject = Project::find($projectId);

        if (Session::has('project_id')) {
            $instanceId = Session::get('project_instance');
        } else {
            $instanceId = $getProject->instance_id;
        }

        $task_progress_id = $request->task_progress_id;
        $task_id = $request->task_id;
        $task = MicroTask::where('id', $task_id)->first();
        $check_data = Micro_Task_progress::select('micro_task_progress.*',
            \DB::raw('group_concat(file.filename) as filename, group_concat(file.id) as file_id'))
            ->leftjoin('micro_task_progress_file as file',
                \DB::raw('FIND_IN_SET(file.id,micro_task_progress.file_id)'), '>', \DB::raw("'0'"))
            ->where('micro_task_progress.id', $task_progress_id)
            ->where('micro_task_progress.task_id', $task_id)
            ->where('micro_task_progress.project_id', $task->project_id)
            ->where('micro_task_progress.instance_id', $instanceId)
            ->groupBy('micro_task_progress.id')
            ->first();

        if ($check_data != null) {
            $data = [
                'get_date' => date('Y-m-d', strtotime($check_data->created_at)),
                'percentage' => $check_data->percentage,
                'description' => $check_data->description,
                'filename' => $check_data->filename,
                'file_id' => $check_data->file_id,
                'con_data' => $task,
            ];
        } else {
            $data = [
                'get_date' => '',
                'percentage' => '',
                'description' => '',
                'filename' => '',
                'file_id' => '',
                'con_data' => $task,
            ];
        }

        $get_all_dates = [];

        if (\Auth::user()->type == 'company') {
            $getHoliday = Project_holiday::where('created_by', \Auth::user()->id)
                ->where('instance_id', $instanceId)->get();
        } else {
            $getHoliday = Project_holiday::where('created_by', \Auth::user()->creatorId())
                ->where('instance_id', $instanceId)->get();
        }

        if(!empty($getHoliday)){
            foreach ($getHoliday as $check_holiday) {
                $get_all_dates[] = $check_holiday->date;
            }
        }

        $get_all_dates = json_encode($get_all_dates);

        $nonWorkingDay = NonWorkingDaysModal::where('project_id', $projectId)
            ->where('instance_id', $instanceId)
            ->orderBy('id', 'DESC')->first();

        return view('microprogram.micro_edit_task_particular', compact('data', 'task_id','nonWorkingDay'))
            ->with('get_all_dates',$get_all_dates);
    }

    public function micro_con_taskupdate(Request $request){
        $projectId = Session::get("project_id");
        $getProject = Project::find($projectId);

        if (Session::has("project_id")) {
            $instanceId = Session::get("project_instance");
        } else {
            $instanceId = $getProject->instance_id;
        }

        $validator = \Validator::make($request->all(), [
            "task_id" => "required",
            "percentage" => "required",
            "description" => "required",
            "user_id" => "required",
        ]);

        if ($validator->fails()) {
            return redirect()
            ->back()
            ->with(
                "error",
                Utility::errorFormat($validator->getMessageBag())
            );
        }

        $get_all_dates    = [];
        $get_non_work_day = [];
        $fileNameToStore1 = "";
        $url              = "";
        $task_id          = $request->task_id;

        $task = MicroTask::where("id", $task_id)
            ->where("instance_id", $instanceId)
            ->first();
        $nonWorkingDay = NonWorkingDaysModal::where(
            "project_id",
            $task->project_id
        )
        ->where("instance_id", $instanceId)
        ->orderBy("id", "DESC")
        ->first();
        
        if (
            $nonWorkingDay != null &&
            $nonWorkingDay->non_working_days != null
        ) {
            $split_non_working = explode(",", $nonWorkingDay->non_working_days);
            foreach ($split_non_working as $non_working) {
                if ($non_working == 0) {
                    $get_non_work_day[] = "Sunday";
                } elseif ($non_working == 1) {
                    $get_non_work_day[] = "Monday";
                } elseif ($non_working == 2) {
                    $get_non_work_day[] = "Tuesday";
                } elseif ($non_working == 3) {
                    $get_non_work_day[] = "Wednesday";
                } elseif ($non_working == 4) {
                    $get_non_work_day[] = "Thursday";
                } elseif ($non_working == 5) {
                    $get_non_work_day[] = "Friday";
                } elseif ($non_working == 6) {
                    $get_non_work_day[] = "Saturday";
                }
            }
        }

        $getCurrentDay = date("l", strtotime($request->get_date));

        if (\Auth::user()->type == "company") {
            $getHoliday = Project_holiday::where(
                "created_by",
                \Auth::user()->id
            )
            ->where("instance_id", $instanceId)
            ->get();
        }
        else {
            $getHoliday = Project_holiday::where(
                "created_by",
                \Auth::user()->creatorId()
            )
            ->where("instance_id", $instanceId)
            ->get();
        }

        foreach ($getHoliday as $check_holiday) {
            $get_all_dates[] = $check_holiday->date;
        }

        $holiday_merge = $this->array_flatten($get_all_dates);
        $date1         = date_create($task->start_date);
        $date2         = date_create($task->end_date);
        $diff          = date_diff($date1, $date2);
        $file_id_array = [];

        $no_working_days = $diff->format("%a");
        $no_working_days = $task->duration;

        $checkPercentage = Micro_Task_progress::where("task_id", $task_id)
            ->where("project_id", $task->project_id)
            ->where("instance_id", $instanceId)
            ->whereDate("created_at", $request->get_date)
            ->first();
        $checkPercentageGet = isset($checkPercentage->percentage)
            ? $checkPercentage->percentage
            : 0;

        if (in_array($request->get_date, $holiday_merge)) {
            return redirect()
                ->back()
                ->with(
                    "error",
                    __(
                        $request->get_date .
                        " You have chosen a non-working day; if you want to update the progress, please select a working day."
                    )
                );
        } elseif (in_array($getCurrentDay, $get_non_work_day)) {
            return redirect()
                ->back()
                ->with("error", __("This day is a non-working day."));
        } elseif ($checkPercentageGet > $request->percentage) {
            return redirect()
                ->back()
                ->with(
                    "error",
                    __("This percentage is too low compare to old percentage.")
                );
        } else {
            if ($request->attachment_file_name != null) {
                foreach ($request->attachment_file_name as $file_req) {
                    $filenameWithExt1 = $file_req->getClientOriginalName();
                    $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                    $extension1 = $file_req->getClientOriginalExtension();
                    $fileNameToStore1 =
                        $filename1 . "_" . time() . "." . $extension1;
                    $dir = "uploads/micro_task_particular_list";
                    $image_path = $dir . $filenameWithExt1;

                    if (\File::exists($image_path)) {
                        \File::delete($image_path);
                    }

                    $path = Utility::multi_upload_file(
                        $file_req,
                        "file_req",
                        $fileNameToStore1,
                        $dir,
                        []
                    );

                    if ($path["flag"] == 1) {
                        $url = $path["url"];

                        $file_insert = [
                            "task_id" => $task_id,
                            "project_id" => $task->project_id,
                            "filename" => $fileNameToStore1,
                            "file_path" => $url,
                        ];
                        $file_insert_id = DB::table(
                            "micro_task_progress_file"
                        )->insertGetId($file_insert);
                        $file_id_array[] = $file_insert_id;
                    } else {
                        return redirect()
                            ->back()
                            ->with("error", __($path["msg"]));
                    }
                }
                $implode_file_id =
                    count($file_id_array) != 0
                        ? implode(",", $file_id_array)
                        : 0;

                if ($request->existing_file_id != "") {
                    $implode_file_id =
                        $request->existing_file_id . "," . $implode_file_id;
                }
            } else {
                $get_file_id = Micro_Task_progress::where("task_id", $task_id)
                    ->where("project_id", $task->project_id)
                    ->where("instance_id", $instanceId)
                    ->whereDate("created_at", $request->get_date)
                    ->first();
                if ($get_file_id != null) {
                    $implode_file_id = $get_file_id->file_id;
                } else {
                    $implode_file_id = 0;
                }
            }

            $date_status =
                strtotime($task->end_date) > time() ? "As Per Time" : "Overdue";

            if (\Auth::user()->type == "company") {
                $assign_to = $task->users != null ? $task->users : null;
            } else {
                $assign_to = \Auth::user()->id;
            }

            // insert details
            $array = [
                "task_id" => $task_id,
                "assign_to" => $assign_to,
                "percentage" => $request->percentage,
                "description" => $request->description,
                "user_id" => $request->user_id,
                "project_id" => $task->project_id,
                "instance_id" => $instanceId,
                "date_status" => $date_status,
                "file_id" => $implode_file_id,
                "created_at" => $request->get_date, //Planned Date
                "record_date" => date("Y-m-d H:m:s"), //Actual Date
            ];
            $revision_array = [
                "task_id" => $task_id,
                "task_name" => $task->text,
                "user_id" => $request->user_id,
                "project_id" => $task->project_id,
                "instance_id" => $instanceId,
            ];
            $check_data = Micro_Task_progress::where("task_id", $task_id)
                ->where("project_id", $task->project_id)
                ->where("instance_id", $instanceId)
                ->whereDate("created_at", $request->get_date)
                ->first();
            $record = DB::table("instance")
                ->where("project_id", $task->project_id)
                ->where("freeze_status", 0)
                ->first();
            if ($check_data == null) {
                Micro_Task_progress::insert($array);

                if ($record) {
                    DB::table("revision_task_progress")->insert(
                        $revision_array
                    );
                    MicroTask::where("project_id", $task->project_id)
                        ->where("instance_id", $record->instance)
                        ->where("task_id", $task->id)
                        ->update(["work_flag" => "1"]);
                }

                ActivityController::activity_store(
                    Auth::user()->id,
                    Session::get("project_id"),
                    "Added Micro Progress",
                    $task->text
                );
            } else {
                Micro_Task_progress::where("task_id", $task_id)
                    ->where("project_id", $task->project_id)
                    ->where("instance_id", $instanceId)
                    ->where("created_at", $request->get_date)
                    ->update($array);
                if ($record) {
                    DB::table("revision_task_progress")
                        ->where("project_id", $task->project_id)
                        ->where("instance_id", $instanceId)
                        ->where("created_at", $request->get_date)
                        ->update($revision_array);

                    MicroTask::where("project_id", $task->project_id)
                        ->where("instance_id", $record->instance)
                        ->where("task_id", $task->id)
                        ->update(["work_flag" => "1"]);
                }

                ActivityController::activity_store(
                    Auth::user()->id,
                    Session::get("project_id"),
                    "Updated Micro Progress",
                    $task->text
                );
            }

            $total_pecentage = Micro_Task_progress::where("task_id", $task_id)
                ->where("instance_id", $instanceId)
                ->sum("percentage");
            $per_percentage = $total_pecentage / $no_working_days;
            $per_percentage = round($per_percentage);
            MicroTask::where("id", $task_id)
                ->where("instance_id", $instanceId)
                ->update(["progress" => $per_percentage]);
            // update the  gantt

            $alltask = MicroTask::where([
                "project_id" => $task->project_id,
                "instance_id" => $instanceId,
            ])
            ->where("type", "project")
            ->get();

            foreach ($alltask as $key => $value) {
                $task_id = $value->id;
                $total_percentage = MicroTask::where([
                    "project_id" => $task->project_id,
                    "instance_id" => $instanceId,
                ])
                ->where("parent", $value->id)
                ->avg("progress");

                $total_percentage = round($total_percentage);
                if ($total_percentage != null) {
                    MicroTask::where("id", $task_id)
                    ->where([
                        "project_id" => $task->project_id,
                        "instance_id" => $instanceId,
                    ])
                    ->update(["progress" => $total_percentage]);
                }
            }
            //##################################################

            return redirect()
                ->back()
                ->with("success", __("Task successfully Updated."));
        }
    }

    public function micro_task_file_download(Request $request){
        $taskId = $request->task_id;
        $filename = $request->filename;
        $documentPath = \App\Models\Utility::get_file('uploads/micro_task_particular_list');

        $ducumentUpload = DB::table('micro_task_progress_file')
            ->where('task_id', $taskId)
            ->Where('filename', 'like', '%'.$filename.'%')
            ->where('status', 0)->first();

        if ($ducumentUpload != null) {
            $filePath = $documentPath.'/'.$ducumentUpload->filename;
            $filename = $ducumentUpload->filename;

            if (! Storage::disk('s3')->exists($filePath)) {
                $headers = [
                    'Content-Type' => 'your_content_type',
                    'Content-Description' => 'File Transfer',
                    'Content-Disposition' => "attachment; filename={$filename}",
                    'filename' => $filename,
                ];

                return response($filePath, 200, $headers);
            } else {
                return redirect()->back()->with('error', __('File is not exist.'));
            }
        } else {
            return redirect()->back()->with('error', __('File is not exist.'));
        }
    }

    public function schedule_complete(Request $request){
        $schedule_id   = $request->schedule_id;
        $project_id    = Session::get('project_id');
        $instance_id   = Session::get('project_instance');

        MicroProgramScheduleModal::where('id',$schedule_id)
        ->where('project_id',$project_id)
        ->where('instance_id',$instance_id)
        ->where('status',1)
        ->update(['active_status',2]);

        return array(
            '1', 'Schedule Completed'
        );
    }

    public function mainschedule_store(Request $request){
        $schedulearray = $request->schedulearray;
        $schedule_id   = $request->schedule_id;
        $project_id    = Session::get('project_id');
        $instance_id   = Session::get('project_instance');

        $checkActive        = MicroProgramScheduleModal::where('active_status',1)->where('status',1)->first();
        $checkActiveGet     = $checkActive != null ? 1 : 0;

        if($checkActiveGet == 1){
            return array(
                '0', 'Another Schedule is running please Complete that First'
            );
        }

        $checMicroProgress = MicroTask::where('project_id',$project_id)->where('instance_id',$instance_id)
                ->where('schedule_id',$schedule_id)
                ->where('progress','>',0)->first();
        if($checMicroProgress == null){

            if($schedulearray != null){
                foreach($schedulearray as $schedule){
                    $main_id     = $schedule['task_id'];
                    $sort_number = $schedule['sort_number'];

                    if(MicroTask::where('project_id',$project_id)->where('instance_id',$instance_id)
                    ->where('schedule_id',$schedule_id)
                    ->where('task_id',$main_id)->exists())
                    {
                        MicroTask::where('project_id',$project_id)->where('instance_id',$instance_id)
                            ->where('schedule_id',$schedule_id)->where('task_id',$main_id)
                            ->update(['schedule_order' => $sort_number]);
                    }
                    else{
                        MicroProgramScheduleModal::where('id',$schedule_id)->update(['active_status'=>1]);
                        $conTask = Con_task::where('project_id',$project_id)
                            ->where('instance_id',$instance_id)
                            ->where('main_id',$main_id)->first();

                        $store_array = array(
                            'task_id'        => $conTask->main_id,
                            'text'           => $conTask->text,
                            'project_id'     => $project_id,
                            'users'          => $conTask->users,
                            'duration'       => $conTask->duration,
                            'schedule_id'    => $schedule_id,
                            'start_date'     => $conTask->start_date,
                            'end_date'       => $conTask->end_date,
                            'predecessors'   => $conTask->predecessors,
                            'instance_id'    => $instance_id,
                            'achive'         => $conTask->achive,
                            'parent'         => 0,
                            'sortorder'      => 0,
                            'schedule_order' => $sort_number,
                            'custom'         => $conTask->custom,
                            'float_val'      => $conTask->float_val,
                            'type'           => 'project',
                            'micro_flag'     => 1
                        );

                        MicroTask::insert($store_array);
                    }
                }
                return array(
                    '1', 'Shedule Activated'
                );
            }
            else{
                return array(
                    '0', 'Please Drag and Drop the Task List into the Micro Planning'
                );
            }
        }
        else{
            return array(
                '0', 'OOPS! Your schedule is start runing, So cannot be modify'
            );
        }
        
    }

    public function array_flatten($array)
    {
        if (!is_array($array)) {
            return false;
        }
        $result = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, $this->array_flatten($value));
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }
    public function gantt($projectID, $duration = "Week"){
        try {
            if (\Auth::user()->can("view grant chart")) {
                $project = Project::find($projectID);
                $tasks = [];
                if (Session::has("project_instance")) {
                    $instanceId = Session::get("project_instance");
                } else {
                    $instanceId = $project->instance_id;
                }
                $freezeCheck = Instance::where("project_id", $projectID)
                    ->where("instance", $instanceId)
                    ->first();
    
                $projectname = Project::where("id", Session::get("project_id"))
                    ->pluck("project_name")
                    ->first();
    
                if ($project) {
                    $setting = Utility::settings(\Auth::user()->creatorId());
                    if ($setting["company_type"] == 2) {
                        $project_holidays = Project_holiday::select("date")
                            ->where([
                                "project_id" => $projectID,
                                "instance_id" => $instanceId,
                            ])
                            ->get();
    
                        $nonWorkingDay = NonWorkingDaysModal::where(
                            "project_id",
                            $projectID
                        )
                            ->where("instance_id", $instanceId)
                            ->pluck("non_working_days")
                            ->first();
    
                        return view(
                            "microprogram.gantt",
                            compact(
                                "project",
                                "tasks",
                                "duration",
                                "project_holidays",
                                "freezeCheck",
                                "nonWorkingDay",
                                "projectname"
                            )
                        );
                    } else {
                        $tasksobj = $project->tasks;
                        foreach ($tasksobj as $task) {
                            $tmp = [];
                            $tmp["id"] = "task_" . $task->id;
                            $tmp["name"] = $task->name;
                            $tmp["start"] = $task->start_date;
                            $tmp["end"] = $task->end_date;
                            $tmp["type"] = $task->type;
                            $tmp["custom_class"] = empty($task->priority_color)
                                ? "#ecf0f1"
                                : $task->priority_color;
                            $tmp["progress"] = str_replace(
                                "%",
                                "",
                                $task->taskProgress()["percentage"]
                            );
                            $tmp["extra"] = [
                                "priority" => ucfirst(__($task->priority)),
                                "comments" => count($task->comments),
                                "duration" =>
                                    Utility::getDateFormated($task->start_date) .
                                    " - " .
                                    Utility::getDateFormated($task->end_date),
                            ];
                            $tasks[] = $tmp;
                        }
                    }
                }
    
                //return view('projects.gantt', compact('project', 'tasks', 'duration'));
            } else {
                return redirect()
                    ->back()
                    ->with("error", __("Permission Denied."));
            }
          
          } catch (Exception $e) {
          
              return $e->getMessage();
          
          }
    }

    public function get_micro_freeze_status(Request $request)
    {
        try {
            return Instance::where("project_id", $request->project_id)
                ->where("instance", Session::get("project_instance"))
                ->pluck("freeze_status")
                ->first();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function get_micro_gantt_task_count(Request $request)
    {
        $instanceId = Session::get("project_instance");
        $task = MicroTask::where("project_id", $request->project_id)
            ->where("instance_id", $instanceId)
            ->get();

        return count($task);
    }

    public function micro_freeze_status(Request $request)
    {
        try {
            $instanceId = Session::get("project_instance");
            $conTask = MicroTask::where([
                "project_id" => $request->project_id,
                "instance_id" => $instanceId,
            ])
                ->orderBy("id", "ASC")
                ->first();
            $data = [
                "start_date" => $conTask->start_date,
                "end_date" => $conTask->end_date,
                "estimated_days" => $conTask->duration,
            ];
            $instanceData = [
                "freeze_status" => 1,
                "start_date" => $conTask->start_date,
                "end_date" => $conTask->end_date,
            ];

            $getPreviousInstance = MicroTask::where(
                "project_id",
                $request->project_id
            )
                ->where("instance_id", "!=", $instanceId)
                ->orderBy("id", "Desc")
                ->first();

            if ($getPreviousInstance != null) {
                $setPreviousInstance = $getPreviousInstance->instance_id;
                $getPreData = MicroTask::where(
                    "project_id",
                    $request->project_id
                )
                    ->where("instance_id", $setPreviousInstance)
                    ->get();
                foreach ($getPreData as $insertPre) {
                    MicroTask::where([
                        "project_id" => $request->project_id,
                        "instance_id" => $instanceId,
                        "id" => $insertPre->id,
                    ])->update(["progress" => $insertPre->progress]);
                }

                DB::select(
                    "INSERT INTO micro_task_progress(
                            task_id,assign_to,percentage,date_status,description,user_id,project_id,instance_id,
                            file_id,record_date,created_at,updated_at
                        )
                        SELECT task_id,assign_to,percentage,date_status,description,user_id,project_id,
                        '" .
                        $instanceId .
                        "' as instance_id,file_id,record_date,created_at,updated_at
                        FROM micro_task_progress WHERE project_id = " .
                        $request->project_id .
                        " AND
                        instance_id='" .
                        $setPreviousInstance .
                        "'"
                );

                DB::select(
                    "INSERT INTO micro_task_progress_file(
                            task_id,project_id,instance_id,filename,file_path,status
                        )
                        SELECT task_id,project_id,'" .
                        $instanceId .
                        "' as instance_id,
                        filename,file_path,status
                        FROM micro_task_progress_file WHERE project_id = " .
                        $request->project_id .
                        " AND
                        instance_id='" .
                        $setPreviousInstance .
                        "'"
                );

                $taskProgresskData = DB::table('micro_task_progress')->where(
                    "project_id",
                    $request->project_id
                )
                    ->where("instance_id", $instanceId)
                    ->get();

                $taskFileData = DB::table("micro_task_progress_file")
                    ->where("project_id", $request->project_id)
                    ->where("instance_id", $instanceId)
                    ->get();

                $taskProgressTaskId = [];
                $taskFileDataId = [];

                if (!empty($taskProgresskData)) {
                    foreach ($taskProgresskData as $taskProgress) {
                        if (
                            !in_array(
                                $taskProgress->task_id,
                                $taskProgressTaskId
                            )
                        ) {
                            $getCorrectData = MicroTask::select(
                                "id",
                                "text",
                                "duration",
                                "start_date",
                                "end_date",
                                "type"
                            )
                                ->where("main_id", $taskProgress->task_id)
                                ->first();

                            $getOrginalTask = MicroTask::where(
                                "id",
                                $getCorrectData->id
                            )
                                ->where("project_id", $request->project_id)
                                ->where(
                                    "start_date",
                                    $getCorrectData->start_date
                                )
                                ->where("end_date", $getCorrectData->end_date)
                                ->where("instance_id", $instanceId)
                                ->first();

                            if ($getOrginalTask != null) {
                                DB::table('micro_task_progress')->where(
                                    "project_id",
                                    $request->project_id
                                )
                                    ->where("instance_id", $instanceId)
                                    ->where("task_id", $taskProgress->task_id)
                                    ->update([
                                        "task_id" => $getOrginalTask->main_id,
                                    ]);
                            }
                            $taskProgressTaskId[] = $taskProgress->task_id;
                        }
                    }
                }

                if (!empty($taskFileData)) {
                    foreach ($taskFileData as $taskFileDataSet) {
                        if (
                            !in_array(
                                $taskFileDataSet->task_id,
                                $taskFileDataId
                            )
                        ) {
                            $getCorrectData = MicroTask::select(
                                "id",
                                "text",
                                "duration",
                                "start_date",
                                "end_date",
                                "type"
                            )
                                ->where("main_id", $taskFileDataSet->task_id)
                                ->first();

                            $getOrginalTask = MicroTask::where(
                                "id",
                                $getCorrectData->id
                            )
                                ->where("project_id", $request->project_id)
                                ->where(
                                    "start_date",
                                    $getCorrectData->start_date
                                )
                                ->where("end_date", $getCorrectData->end_date)
                                ->where("instance_id", $instanceId)
                                ->first();

                            if ($getOrginalTask != null) {
                                DB::table("micro_task_progress_file")
                                    ->where("project_id", $request->project_id)
                                    ->where("instance_id", $instanceId)
                                    ->where(
                                        "task_id",
                                        $taskFileDataSet->task_id
                                    )
                                    ->update([
                                        "task_id" => $getOrginalTask->main_id,
                                    ]);
                            }
                            $taskFileDataId[] = $taskFileDataSet->task_id;
                        }
                    }
                }
            }

            Project::where("id", $request->project_id)->update($data);
            Instance::where("project_id", $request->project_id)
                ->where("instance", $instanceId)
                ->update($instanceData);
            Session::put("current_revision_freeze", 1);

            return redirect()
                ->back()
                ->with("success", __("Baseline Status successfully changed."));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function micro_gantt_data($projectID, Request $request)
    {
        $project = Project::find($projectID);
        if ($project) {
            $instanceId = Session::get("project_instance");
            $task= DB::table('microprogram_schedule')
            ->join('micro_tasks', 'microprogram_schedule.id', '=', 'micro_tasks.schedule_id')
            ->select('micro_tasks.*', 'microprogram_schedule.schedule_name', 'microprogram_schedule.active_status')
            ->where('microprogram_schedule.active_status',1)
            ->where("micro_tasks.project_id", $projectID)
            ->where("micro_tasks.instance_id", $instanceId)
            ->orderBy("micro_tasks.id", "ASC")
            ->get();
        
            $link = MicroLink::where("project_id", $projectID)
                ->where("instance_id", $instanceId)
                ->orderBy("id", "ASC")
                ->get();

            return response()->json([
                "data" => $task,
                "links" => $link,
            ]);
        } else {
            return "";
        }
    }

}
