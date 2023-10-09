<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use App\Models\Con_task;
use App\Models\Instance;
use App\Models\MicroProgramScheduleModal;
use App\Models\MicroTask;
use Carbon\CarbonPeriod;
use Auth;
use DB;

class MicroPorgramController extends Controller
{
    public function microprogram(Request $request){
        if (Session::has('project_id')) {
            $project_id  = Session::get('project_id');
            $instance_id = Session::get('project_instance');
            $freezeCheck = Instance::where('project_id', $project_id)
                ->where('instance', Session::get('project_instance'))->pluck('freeze_status')->first();
            if($freezeCheck == 1){
                $MicroProgramScheduleModal = MicroProgramScheduleModal::where('project_id',$project_id)
                    ->where('instance_id',$instance_id)
                    ->where('status',1)
                    ->get();
                    
                    return view('microprogram.index')
                        ->with('MicroProgramScheduleModal',$MicroProgramScheduleModal);
            }
            else{
                return redirect()->back()->with('error', __('Project Not Freezed.'));
            }
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

    public function cheange_schedule_status(Request $request){
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
    
        $schedule                      = new MicroProgramScheduleModal;
        $schedule->schedule_name       = $request->schedule_name;
        $schedule->project_id          = $project_id;
        $schedule->instance_id         = $instance_id;
        $schedule->schedule_duration   = $request->schedule_duration;
        $schedule->schedule_start_date = $request->schedule_start_date;
        $schedule->schedule_end_date   = $request->schedule_end_date;
        $schedule->schedule_goals      = $request->schedule_goals;
        $schedule->insert_date         = date('Y-m-d');
        $schedule->save();
        
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
            if($freezeCheck == 1){
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
                    ->where('micro_tasks.project_id', $project_id)
                    ->where('micro_tasks.instance_id', $instance_id)
                    ->where('micro_tasks.schedule_id',$secheduleId);

                    if (\Auth::user()->type != 'company') {
                        $microSchedule->whereRaw("find_in_set('".\Auth::user()->id."',users)");
                    }

                    $microSchedule = $microSchedule->orderBy('micro_tasks.schedule_order','ASC')->get();

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
                        $query->whereDate('con_tasks.start_date', '>=', $weekStartDate);
                        $query->whereDate('con_tasks.end_date', '<=', $weekEndDate);
                    });

                    if (\Auth::user()->type != 'company') {
                        $weekSchedule->whereRaw("find_in_set('".\Auth::user()->id."',users)");
                    }

                    $weekSchedule = $weekSchedule->orderBy('con_tasks.start_date','ASC')->get();

                    return view('microprogram.schedule_task_show')->with('weekSchedule',$weekSchedule)
                        ->with('weekStartDate',$weekStartDate)
                        ->with('weekEndDate',$weekEndDate)
                        ->with('scheduleGet',$scheduleGet)
                        ->with('microSchedule',$microSchedule);
            }
            else{
                return redirect()->back()->with('error', __('Project Not Freezed.'));
            }
        }
        else {
            return redirect()->route('construction_main')->with('error', __('Session Expired'));
        }
    }

    public function mainschedule_store(Request $request){
        $schedulearray = $request->schedulearray;
        $schedule_id   = $request->schedule_id;
        $project_id    = Session::get('project_id');
        $instance_id   = Session::get('project_instance');

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
                        $conTask = Con_task::where('project_id',$project_id)
                            ->where('instance_id',$instance_id)
                            ->where('main_id',$main_id)->first();

                        $store_array = array(
                            'task_id'        => $main_id,
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
                            'parent'         => $conTask->parent,
                            'sortorder'      => $conTask->sortorder,
                            'schedule_order' => $sort_number,
                            'custom'         => $conTask->custom,
                            'float_val'      => $conTask->float_val,
                            'type'           => $conTask->type,
                        );

                        MicroTask::insert($store_array);
                    }
                }
                echo 1;
            }
            else{
                echo 0;
            }
        }
        else{
            echo 2;
        }
        
    }
}
