<?php

namespace App\Http\Controllers;

use App\Models\Con_task;
use App\Models\Link;
use Illuminate\Http\Request;
use Session;

class LinkController extends Controller
{

    public function store(Request $request){
        $max_id=Link::max('id');
        $link = new Link();
        $link->id = $max_id+1;
        $link->type = $request->type;
        $link->source = $request->source;
        $link->project_id = Session::get('project_id');
        $link->instance_id = Session::get('project_instance');
        $link->target = $request->target;
        $link->save();
        Con_task::where(['main_id'=>$request->source,'project_id'=>Session::get('project_id')])->update(['predecessors'=>$request->target]);
 
        return response()->json([
            "action"=> "inserted",
            "tid" => $link->id
        ]);
    }
 
    public function update($id, Request $request){
        $link = Link::find($id);
        $link->where(['project_id'=>Session::get('project_id'),'instance_id'=>Session::get('project_instance')]);
        $link->type = $request->type;
        $link->source = $request->source;
        $link->target = $request->target;
        $link->save();
        Con_task::where(['main_id'=>$request->source,'project_id'=>Session::get('project_id')])->update(['predecessors'=>$request->target]);
        return response()->json([
            "action"=> "updated"
        ]);
    }
 
    public function destroy($id){
        $project=Session::get('project_id');
        $link = Link::find($id);
        $link->where(['project_id'=>Session::get('project_id'),'instance_id'=>Session::get('project_instance')]);
        $link->delete();
 
        return response()->json([
            "action"=> "deleted"
        ]);
    }
}
