<?php

namespace App\Http\Controllers;

use App\Models\Con_task;
use App\Models\Project;
use App\Models\Utility;
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
        $task->start_date = date('Y-m-d');
        $task->end_date = date("Y-m-d", strtotime("+ 1 day"));
        $task->duration = $request->duration;
        $task->progress = $request->has('progress') ? $request->progress : 0;
        $task->parent = $request->parent;
        $task->created_by = Auth::user()->id;
        $task->taskmode = 0;
        if($request->totalStack!='undefined'){
            $task->float_val = $request->totalStack;
        }
        

        if(isset($request->totalStack) && $request->totalStack!='undefined'){
            $n_total_slack = $request->totalStack;
            $cleanedDateString = preg_replace('/\s\(.*\)/', '', $request->end_date);
            $carbonDate = Carbon::parse($cleanedDateString);
            // $carbonDate->addDays($request->totalStack);
            $endate = $carbonDate->format('Y-m-d');
            $date=Utility::exclude_date_calculator($endate,$n_total_slack,Session::get('project_id'));
            $entire_critical = $date;
        }else{
            $entire_critical=null;
            $n_total_slack =null;
        }

        if(isset($request->freeSlack) && $request->freeSlack!='undefined'){
            $free_slack = $request->freeSlack;
            $cleanedDateString = preg_replace('/\s\(.*\)/', '', $request->end_date);
            $carbonDate = Carbon::parse($cleanedDateString);
            // $carbonDate->addDays($request->freeSlack);
            $endate2 = $carbonDate->format('Y-m-d');
            $date2=Utility::exclude_date_calculator($endate2,$free_slack,Session::get('project_id'));
            $dependency_critical = $date2;
        }else{
            $dependency_critical=null;
            $free_slack =null;
        }
        
        if (isset($request->users)) {
            if (gettype($request->users) == 'array') {
                $implodeusers = implode(',', json_decode($request->users));
            } else {
                $implodeusers = $request->users;
            }
            $task->users = $implodeusers;
        }

        if (isset($request->reported_to)) {
            if (gettype($request->reported_to) == 'array') {
                $implodereporter = implode(',', json_decode($request->reported_to));
            } else {
                $implodereporter = $request->reported_to;
            }
            $task->reported_to = $implodereporter;
        }

        if(isset($request->taskmode)){
            if($request->taskmode==0){
                $mode=0;
            }else{
                $mode=1;
            }
            $task->taskmode = $mode;
        }

        if (isset($request->subcontractor)) {
            if (gettype($request->subcontractor) == 'array') {
                $implodesubcontractor = implode(',', json_decode($request->subcontractor));
            } else {
                $implodesubcontractor = $request->subcontractor;
            }
            $task->subcontractor = $implodesubcontractor;
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
        
       
            $task = Con_task::where('id',$id)
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

        if (isset($request->reported_to)) {
            if (gettype($request->reported_to) == 'array') {
                $implodereportedto = implode(',', json_decode($request->reported_to));
            } else {
                $implodereportedto = $request->reported_to;
            }
            $reportedto = $implodereportedto;
        }else{
            $reportedto='';
        }
        
        if (isset($request->taskmode)) {
            
            if($request->taskmode==0){
                $mode=0;
            }else{
                $mode=1;
            }
        }else{
            $mode=0;
        }

        if (isset($request->subcontractor)) {
            if (gettype($request->subcontractor) == 'array') {
                $implodesubcontractor = implode(',', json_decode($request->subcontractor));
            } else {
                $implodesubcontractor = $request->subcontractor;
            }
            $subcontractor = $implodesubcontractor;
        }else{
            $subcontractor='';
        }
      
        if(isset($request->totalStack) && $request->totalStack!='undefined'){
            $float_val = $request->totalStack;
        }else{
            $float_val=null;
        }

        if(isset($request->totalStack) && $request->totalStack!='undefined'){
            $n_total_slack = $request->totalStack;
            $cleanedDateString = preg_replace('/\s\(.*\)/', '', $request->end_date);
            $carbonDate = Carbon::parse($cleanedDateString);
            // $carbonDate->addDays($request->totalStack);
            $endate = $carbonDate->format('Y-m-d');
            $date=Utility::exclude_date_calculator($endate,$n_total_slack,Session::get('project_id'));
            $entire_critical = $date;
        }else{
            $entire_critical=null;
            $n_total_slack =null;
        }

        if(isset($request->freeSlack) && $request->freeSlack!='undefined'){
            $free_slack = $request->freeSlack;
            $cleanedDateString = preg_replace('/\s\(.*\)/', '', $request->end_date);
            $carbonDate = Carbon::parse($cleanedDateString);
            // $carbonDate->addDays($request->freeSlack);
            $endate2 = $carbonDate->format('Y-m-d');
            $date2=Utility::exclude_date_calculator($endate2,$free_slack,Session::get('project_id'));
            $dependency_critical = $date2;
        }else{
            $dependency_critical=null;
            $free_slack =null;
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
            'total_slack'=> $n_total_slack,
            'free_slack'=> $free_slack,
            'type'=>$type,
            'float_val'=>$float_val,
            'reported_to'=>$reportedto,
            'subcontractor'=>$subcontractor,
            'taskmode'=>$mode,
            'created_by' => Auth::user()->id,
        );
        

        Con_task::where('id',$id)
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
