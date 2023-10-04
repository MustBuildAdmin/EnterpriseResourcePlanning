<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use App\Models\Con_task;
use App\Models\Instance;
use Auth;

class MicroPorgramController extends Controller
{
    public function microprogram(Request $request){
        if (Session::has('project_id')) {
            $now           = Carbon::now();
            $weekStartDate = $now->startOfWeek()->format('Y-m-d');
            $weekEndDate   = $now->endOfWeek()->format('Y-m-d');
            $project_id    = Session::get('project_id');
            $instance_id   = Session::get('project_instance');
            
            $freezeCheck = Instance::where('project_id', $project_id)
                ->where('instance', Session::get('project_instance'))->pluck('freeze_status')->first();
            if($freezeCheck == 1){

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

                    return view('microprogram.index')->with('weekSchedule',$weekSchedule)
                        ->with('weekStartDate',$weekStartDate)
                        ->with('weekEndDate',$weekEndDate);
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
