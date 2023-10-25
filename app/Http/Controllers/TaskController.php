<?php

namespace App\Http\Controllers;

use App\Models\Con_task;
use App\Models\Project;
use Auth;
use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;
use App\Models\Instance;

class TaskController extends Controller
{
    public function store(Request $request)
    {

        $maxid = Con_task::where(['project_id' => Session::get('project_id'),
            'instance_id' => Session::get('project_instance')])->max('id');
        if ($maxid == null) {
            $maxid = 0;
        }
        $task = new Con_task();

        $task->text = $request->text;
        $task->id = $maxid + 1;
        $rowid = $maxid + 1;
        $task->project_id = Session::get('project_id');
        $task->instance_id = Session::get('project_instance');
        $task->start_date = date('Y-m-d', strtotime($request->start_date));
        $task->end_date = date('Y-m-d', strtotime($request->end_date));
        $task->duration = $request->duration;
        $task->progress = $request->has('progress') ? $request->progress : 0;
        $task->parent = $request->parent;
        if($request->totalStack!='undefined'){
            $task->float_val = $request->totalStack;
        }
        

        if(isset($request->totalStack)){
            $cleanedDateString = preg_replace('/\s\(.*\)/', '', $request->start_date);
            $carbonDate = Carbon::parse($cleanedDateString);
            $carbonDate->addDays($request->totalStack);
            $total_slack = $carbonDate->format('Y-m-d');
            $task->entire_critical = $total_slack;
        }

        if(isset($request->freeSlack)){
            $cleanedDateString = preg_replace('/\s\(.*\)/', '', $request->start_date);
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
        Con_task::where(['project_id' => Session::get('project_id'), 'instance_id' => Session::get('project_instance')])
            ->where('id', $request->parent)->update(['type' => 'project']);
        $checkparent = Con_task::where(['project_id' => Session::get('project_id'),
            'instance_id' => Session::get('project_instance')])
            ->where(['parent' => $task->id])->get();
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
       
        $row = Con_task::where(['project_id' => Session::get('project_id'),
            'instance_id' => Session::get('project_instance'), 'id' => $id])->first();
        if ($row != null) {
            ActivityController::activity_store(Auth::user()->id,
                Session::get('project_id'), 'Deleted Task', $row->text);
        }
        $frezee = Project::where('id', Session::get('project_id'))->first();
        if ($frezee->freeze_status != 1) {
            Con_task::where(['project_id' => Session::get('project_id'),
            'instance_id' => Session::get('project_instance'), 'id' => $id])->delete();
        }

        // checking whether its having parent or not
        $checkparent = Con_task::where(['project_id' => Session::get('project_id'),
            'instance_id' => Session::get('project_instance')])
            ->where(['parent' => $row->parent])->first();
        if ($checkparent) {
            // update  the type
            Con_task::where(['project_id' => Session::get('project_id'),
                'instance_id' => Session::get('project_instance')])
                ->where('id', $row->parent)->update(['type' => 'project']);
        } else {
            // update  the type
            Con_task::where(['project_id' => Session::get('project_id'),
                'instance_id' => Session::get('project_instance')])
                ->where('id', $row->parent)->update(['type' => 'task']);
        }

        return response()->json([
            'action' => 'deleted',
        ]);
    }

    public function update($id, Request $request)
    {
        $task = Con_task::where('main_id',$request->main_id)
                            ->where(['project_id' => Session::get('project_id'),
                            'instance_id' => Session::get('project_instance')])
                            ->first();

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
            $cleanedDateString = preg_replace('/\s\(.*\)/', '', $request->start_date);
            $carbonDate = Carbon::parse($cleanedDateString);
            $carbonDate->addDays($request->totalStack);
            $total_slack = $carbonDate->format('Y-m-d');
            $entire_critical = $total_slack;
        }else{
            $entire_critical=null;
        }

        if(isset($request->freeSlack) && $request->freeSlack!='undefined'){
            $cleanedDateString = preg_replace('/\s\(.*\)/', '', $request->start_date);
            $carbonDate = Carbon::parse($cleanedDateString);
            $carbonDate->addDays($request->freeSlack);
            $freeSlack = $carbonDate->format('Y-m-d');
            $dependency_critical = $freeSlack;
        }else{
            $dependency_critical=null;
        }

        $checkparent = Con_task::where(['project_id' => Session::get('project_id'),
            'instance_id' => Session::get('project_instance')])->where(['parent' => $task->id])->get();
        // update  the type
        Con_task::where(['project_id' => Session::get('project_id'), 'instance_id' => Session::get('project_instance')])
            ->where('id', $request->parent)->update(['type' => 'project']);
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

        Con_task::where('main_id',$request->main_id)
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
