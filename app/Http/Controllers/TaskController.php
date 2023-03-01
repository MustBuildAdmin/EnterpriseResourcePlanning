<?php

namespace App\Http\Controllers;
use App\Models\Con_task;
use App\Models\Link;
use Illuminate\Http\Request;
use Session;
class TaskController extends Controller
{
    public function store(Request $request){
 
        $implode_users = implode(',', json_decode($request->users));

        $max_id=Con_task::max('id');
        $task = new Con_task();
 
        $task->text = $request->text;
        $task->id = $max_id+1;
        $task->project_id = Session::get('project_id');
        $task->start_date = date('Y-m-d h:i',strtotime($request->start_date));
        $task->duration = $request->duration;
        $task->progress = $request->has("progress") ? $request->progress : 0;
        $task->parent = $request->parent;
        $task->users = $implode_users;
 
        $task->save();
 
        return response()->json([
            "action"=> "inserted",
            "tid" => $task->id
        ]);
    }
 
    public function update($id, Request $request){
        
        $implode_users = implode(',', json_decode($request->users));
        
        $task = Con_task::find($id);
        $task->where('project_id',Session::get('project_id'));
        $task->text = $request->text;
        $task->start_date = date('Y-m-d h:i',strtotime($request->start_date));
        $task->duration = $request->duration;
        $task->progress = $request->has("progress") ? $request->progress : 0;
        $task->parent = $request->parent;
        $task->users = $implode_users;
 
        $task->save();
 
        return response()->json([
            "action"=> "updated"
        ]);
    }
 
    public function destroy($id){
        $project=Session::get('project_id');
        $task = Con_task::find($id);
        $task->where('project_id', $project);

        $task->delete();
 
        return response()->json([
            "action"=> "deleted"
        ]);
    }
}
