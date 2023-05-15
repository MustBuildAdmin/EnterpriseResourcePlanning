<?php

namespace App\Http\Controllers;
use App\Models\Con_task;
use App\Models\Link;
use Illuminate\Http\Request;
use Session;
class TaskController extends Controller
{
    public function store(Request $request){

        $max_id=Con_task::where(['project_id'=>Session::get('project_id')])->max('id');
        if($max_id==null){
            $max_id=0;
        }
        $task = new Con_task();

        $task->text = $request->text;
        $task->id = $max_id+1;
        $row_id=$max_id+1;
        $task->project_id = Session::get('project_id');
        $task->instance_id = Session::get('project_instance');
        $task->start_date = date('Y-m-d h:i',strtotime($request->start_date));
        $task->end_date = date('Y-m-d h:i',strtotime($request->end_date));
        $task->duration = $request->duration;
        $task->progress = $request->has("progress") ? $request->progress : 0;
        $task->parent = $request->parent;
        if(isset($request->users)){
            if(is_array($request->users)){
                $implode_users = implode(',', json_decode($request->users));
                $task->users = $implode_users;
            }else{
                $task->users = $request->users;
            }

        }

        $task->save();

        return response()->json([
            "action"=> "inserted",
            "tid" => $row_id
        ]);
    }

    public function update($id, Request $request){

        $task = Con_task::find($id);
        $task->where(['project_id'=>Session::get('project_id'),'instance_id'=>Session::get('project_instance')]);
        $task->text = $request->text;
        $task->start_date = date('Y-m-d h:i',strtotime($request->start_date));
        $task->end_date = date('Y-m-d h:i',strtotime($request->end_date));
        $task->duration = $request->duration;
        $task->progress = $request->has("progress") ? $request->progress : 0;
        $task->parent = $request->parent;
        if(isset($request->users)){
            if(is_array($request->users)){
                $implode_users = implode(',', json_decode($request->users));
                $task->users = $implode_users;
            }else{
                $task->users = $request->users;
            }
        }
        $task->save();

        return response()->json([
            "action"=> "updated"
        ]);
    }

    public function destroy($id){
        $project=Session::get('project_id');
        $task = Con_task::find($id);
        $task->where(['project_id'=>Session::get('project_id'),'instance_id'=>Session::get('project_instance')]);
        $task->delete();

        return response()->json([
            "action"=> "deleted"
        ]);
    }
}
