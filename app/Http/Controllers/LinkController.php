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
        $link->target = $request->target;
 
        $link->save();
 
        return response()->json([
            "action"=> "inserted",
            "tid" => $link->id
        ]);
    }
 
    public function update($id, Request $request){
        $link = Link::find($id);
        $link->where('project_id',Session::get('project_id'));
        $link->type = $request->type;
        $link->source = $request->source;
        $link->target = $request->target;
        $link->save();
 
        return response()->json([
            "action"=> "updated"
        ]);
    }
 
    public function destroy($id){
        $project=Session::get('project_id');
        $link = Link::find($id);
        $link->where('project_id',Session::get('project_id'));
        $link->delete();
 
        return response()->json([
            "action"=> "deleted"
        ]);
    }
}
