<?php

namespace App\Http\Controllers;

use App\Models\MicroTask;
use App\Models\Project;
use Auth;
use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;
use App\Models\Instance;
use Exception;
use DB;
use Config;
class TaskMicroController extends Controller
{
    public function store(Request $request)
    {

        $maxid = MicroTask::where(['project_id' => Session::get('project_id'),
            'instance_id' => Session::get('project_instance')])->max('task_id');
        if ($maxid == null) {
            $maxid = 0;
        }

        $schedule_id= DB::table('microprogram_schedule')
        ->where('project_id',Session::get('project_id'))
        ->where('instance_id',Session::get('project_instance'))
        ->where('active_status',1)
        ->first();

        $task = new MicroTask();

        $task->text = $request->text;
        $task->task_id = $maxid + 1;
        $rowid = $maxid + 1;
        $task->project_id = Session::get('project_id');
        $task->instance_id = Session::get('project_instance');
        $task->start_date = date('Y-m-d', strtotime($request->start_date));
        $task->end_date = date('Y-m-d', strtotime($request->end_date));
        $task->duration = $request->duration;
        $task->progress = $request->has('progress') ? $request->progress : 0;
        $task->schedule_id = $schedule_id->id;
        $task->parent = $request->parent;
        if($request->totalStack!='undefined'){
            $task->float_val = $request->totalStack;
        }
        

        if(isset($request->totalStack)){
            $cleanedDateString = preg_replace(Config::get('constants.pregreplace'), '', $request->start_date);
            $carbonDate = Carbon::parse($cleanedDateString);
            $carbonDate->addDays($request->totalStack);
            $total_slack = $carbonDate->format('Y-m-d');
            $task->entire_critical = $total_slack;
        }

        if(isset($request->freeSlack)){
            $cleanedDateString = preg_replace(Config::get('constants.pregreplace'), '', $request->start_date);
            $carbonDate = Carbon::parse($cleanedDateString);
            $carbonDate->addDays($request->freeSlack);
            $freeSlack = $carbonDate->format('Y-m-d');
            $task->dependency_critical = $freeSlack;
        }

        if (isset($request->users)) {
            if (gettype($request->users) == 'array') {
                $implodeusers = implode(',', json_decode($request->users));
            } else {
                $implodeusers = $request->users;
            }
            $task->users = $implodeusers;
        }
        // update  the type
        MicroTask::where(['project_id' => Session::get('project_id'),
                          'instance_id' => Session::get('project_instance')])
            ->where('task_id', $request->parent)->update(['type' => 'project']);
        $checkparent = MicroTask::where(['project_id' => Session::get('project_id'),
            'instance_id' => Session::get('project_instance')])
            ->where(['parent' => $task->task_id])->get();
        if (count($checkparent) > 0) {
            $task->type = 'project';
        } else {
            $task->type = 'task';
        }
        $frezee = Project::where('id', Session::get('project_id'))->first();
        if ($frezee->freeze_status != 1) {
            $task->save();
        }

        ActivityController::activity_store(Auth::user()->id,
            Session::get('project_id'), 'Added New Task', $request->text);

        return response()->json([
            'action' => 'inserted',
            'tid' => $rowid,
        ]);
    }

    public function destroy($id , Request $request)
    {
       
        $row = MicroTask::where(['project_id' => Session::get('project_id'),
            'instance_id' => Session::get('project_instance'), 'task_id' => $id])->first();
        if ($row != null) {
            ActivityController::activity_store(Auth::user()->id,
                Session::get('project_id'), 'Deleted Task', $row->text);
        }
        $frezee = Project::where('id', Session::get('project_id'))->first();
        if ($frezee->freeze_status != 1) {
            MicroTask::where(['project_id' => Session::get('project_id'),
            'instance_id' => Session::get('project_instance'), 'task_id' => $id])->delete();
        }

        // checking whether its having parent or not
        $checkparent = MicroTask::where(['project_id' => Session::get('project_id'),
            'instance_id' => Session::get('project_instance')])
            ->where(['parent' => $row->parent])->first();
        if ($checkparent) {
            // update  the type
            MicroTask::where(['project_id' => Session::get('project_id'),
                'instance_id' => Session::get('project_instance')])
                ->where('task_id', $row->parent)->update(['type' => 'project']);
        } else {
            // update  the type
            MicroTask::where(['project_id' => Session::get('project_id'),
                'instance_id' => Session::get('project_instance')])
                ->where('task_id', $row->parent)->update(['type' => 'task']);
        }

        return response()->json([
            'action' => 'deleted',
        ]);
    }

    public function update($id, Request $request)
    {
        
       
            $task = MicroTask::where('task_id',$id)
                ->where(['project_id' => Session::get('project_id'),
                'instance_id' => Session::get('project_instance')])
                ->first();

            if($task->parent == 0){
                $setStartDate = $task->start_date;
                $setEndDate   = $task->end_date;
            }
            else{
                $parentId = $task->task_id;

                $ParentTask = MicroTask::where('task_id',$parentId)
                    ->where(['project_id' => Session::get('project_id'),
                    'instance_id' => Session::get('project_instance')])
                    ->first();

                $setStartDate = $ParentTask->start_date;
                $setEndDate   = $ParentTask->end_date;
            }

            if($request->start_date > $setStartDate || $request->end_date < $setEndDate){
                return response()->json(['success'=>false,'action' => 'Date restriction']);
            }
       
            if (isset($request->users)) {
                if (gettype($request->users) == 'array') {
                    $implodeusers = implode(',', json_decode($request->users));
                } else {
                    $implodeusers = $request->users;
                }
                $users = $implodeusers;
            }else{
                $users='';
            }

      
            if(isset($request->totalStack) && $request->totalStack!='undefined'){
                $float_val = $request->totalStack;
            }else{
                $float_val=null;
            }

            if(isset($request->totalStack) && $request->totalStack!='undefined'){
                $cleanedDateString = preg_replace(Config::get('constants.pregreplace'), '', $request->start_date);
                $carbonDate = Carbon::parse($cleanedDateString);
                $carbonDate->addDays($request->totalStack);
                $total_slack = $carbonDate->format('Y-m-d');
                $entire_critical = $total_slack;
            }else{
                $entire_critical=null;
            }

            if(isset($request->freeSlack) && $request->freeSlack!='undefined'){
                $cleanedDateString = preg_replace(Config::get('constants.pregreplace'), '', $request->start_date);
                $carbonDate = Carbon::parse($cleanedDateString);
                $carbonDate->addDays($request->freeSlack);
                $freeSlack = $carbonDate->format('Y-m-d');
                $dependency_critical = $freeSlack;
            }else{
                $dependency_critical=null;
            }

            $checkparent = MicroTask::where(['project_id' => Session::get('project_id'),
                'instance_id' => Session::get('project_instance')])->where(['parent' => $task->task_id])->get();
            // update  the type
            MicroTask::where(['project_id' => Session::get('project_id'),
                            'instance_id' => Session::get('project_instance')])
                ->where('task_id', $request->parent)->update(['type' => 'project']);
            if (count($checkparent) > 0) {
                $type = 'project';
            } else {
                $type = 'task';
            }
            // new update functionality
            $update_data=array(
                'text'=>$request->text,
                'start_date'=>date('Y-m-d', strtotime($request->start_date)),
                'end_date'=>date('Y-m-d', strtotime($request->end_date)),
                'duration'=>$request->duration,
                'parent'=>$request->parent,
                'users'=>$users,
                'entire_critical'=>$entire_critical,
                'dependency_critical'=>$dependency_critical,
                'type'=>$type,
                'float_val'=>$float_val,
            );
            

            MicroTask::where('task_id',$id)
                    ->where(['project_id' => Session::get('project_id'),
                    'instance_id' => Session::get('project_instance')])
                    ->update($update_data);

            ActivityController::activity_store(Auth::user()->id,
            Session::get('project_id'), 'Updated Task', $request->text);

            return response()->json([
                'action' => 'updated',
            ]);
    }
}
