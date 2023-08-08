<?php

namespace App\Http\Controllers;

use App\Models\Con_task;
use App\Models\Link;
use Illuminate\Http\Request;
use Session;

class LinkController extends Controller
{

    public function store(Request $request){
        $max_id=Link::where(['project_id'=>Session::get('project_id')])->max('id');
        if($max_id==null){
            $max_id=0;
        }
        $link = new Link();
        $link->id = $max_id+1;
        $link->type = $request->type;
        $link->source = $request->source;
        $link->project_id = Session::get('project_id');
        $link->instance_id = Session::get('project_instance');
        $link->target = $request->target;
        $link->save();
        Con_task::where(['id'=>$request->source,
        'project_id'=>Session::get('project_id'),
        'instance_id'=>Session::get('project_instance')])->update(['predecessors'=>$request->target]);
 
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
        Con_task::where(['id'=>$request->source,
        'project_id'=>Session::get('project_id'),
        'instance_id'=>Session::get('project_instance')])
        ->update(['predecessors'=>$request->target]);
        return response()->json([
            "action"=> "updated"
        ]);
    }
 
    public function destroy($id){
        $link = Link::find($id);
        $link->where(['project_id'=>Session::get('project_id'),'instance_id'=>Session::get('project_instance')]);
        $link->delete();

        Con_task::where(['id'=>$link->source,
        'project_id'=>Session::get('project_id'),
        'instance_id'=>Session::get('project_instance')])->update(['predecessors'=>0]);
        return response()->json([
            "action"=> "deleted"
        ]);
    }
}
