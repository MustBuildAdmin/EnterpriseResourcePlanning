<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use App\Models\Con_task;
use App\Models\Instance;
use App\Models\MicroProgramScheduleModal;
use Auth;

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
        return view('microprogram.create');
    }

    public function schedule_store(Request $request){
        $project_id    = Session::get('project_id');
        $instance_id   = Session::get('project_instance');
        $now           = Carbon::now();
        $weekStartDate = $now->startOfWeek()->format('Y-m-d');
        $weekEndDate   = $now->endOfWeek()->format('Y-m-d');
        $checkChedule = MicroProgramScheduleModal::where('project_id',$project_id)
            ->where('instance_id',$instance_id)
            ->where('status',1)
            ->where(function ($query) use ($weekStartDate, $weekEndDate) {
                $query->whereDate('insert_date', '>=', $weekStartDate);
                $query->whereDate('insert_date', '<=', $weekEndDate);
            })->first();
            
        if($checkChedule == null){
            $schedule = new MicroProgramScheduleModal;

            $schedule->schedule_name       = $request->schedule_name;
            $schedule->project_id          = $project_id;
            $schedule->instance_id         = $instance_id;
            $schedule->schedule_duration   = $request->schedule_duration;
            $schedule->schedule_start_date = $request->schedule_start_date;
            $schedule->schedule_end_date   = $request->schedule_end_date;
            $schedule->schedule_goals      = $request->schedule_goals;
            $schedule->insert_date         = date('Y-m-d');
            $schedule->save();

            return redirect()->back()->with('error', __('Schedule Created'));
        }
        else{
            return redirect()->back()->with('error', __('This Week Schedule already Created!'));
        }
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
                        ->with('scheduleGet',$scheduleGet);
            }
            else{
                return redirect()->back()->with('error', __('Project Not Freezed.'));
            }
        }
        else {
            return redirect()->route('construction_main')->with('error', __('Session Expired'));
        }
    }
}
