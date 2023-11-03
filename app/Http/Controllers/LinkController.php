<?php

namespace App\Http\Controllers;

use App\Models\Con_task;
use App\Models\Link;
use App\Models\Project;
use Auth;
use Illuminate\Http\Request;
use Session;

class LinkController extends Controller
{
    public function store(Request $request)
    {
        $max_id = Link::where(['project_id' => Session::get('project_id')])->max('id');
        if ($max_id == null) {
            $max_id = 0;
        }
        $link = new Link();
        $link->id = $max_id + 1;
        $rowid = $max_id + 1;
        $link->type = $request->type;
        $link->source = $request->source;
        $link->project_id = Session::get('project_id');
        $link->instance_id = Session::get('project_instance');
        $link->target = $request->target;

        $frezee = Project::where('id', Session::get('project_id'))->first();
        if ($frezee->freeze_status != 1) {
            $link->save();
        }

        Con_task::where(['id' => $request->source, 'project_id' => Session::get('project_id')])
            ->update(['predecessors' => $request->target]);

        ActivityController::activity_store(Auth::user()->id,
            Session::get('project_id'), 'Store Predecessors', $request->target);

        return response()->json([
            'action' => 'inserted1',
            'tid' => $rowid,
        ]);
    }

    public function update($id, Request $request)
    {

        $frezee = Project::where('id', Session::get('project_id'))->first();
        if ($frezee->freeze_status != 1) {
            Link::where(['project_id' => Session::get('project_id'),
                                 'instance_id' => Session::get('project_instance'),'id'=>$id])
                                 ->update(['type'=>$request->type,
                                 'source'=>$request->source,
                                 'target'=>$request->target]);
        }

        ActivityController::activity_store(Auth::user()->id,
            Session::get('project_id'), 'Update Predecessors', $request->target);

        return response()->json([
            'action' => 'updated',
        ]);
    }

    public function destroy($id)
    {
        $frezee = Project::where('id', Session::get('project_id'))->first();
        if ($frezee->freeze_status != 1) {
            Link::where(['project_id' => Session::get('project_id'),
                                'instance_id' => Session::get('project_instance'),'id'=>$id])
                                ->delete();
        }

        ActivityController::activity_store(Auth::user()->id,
            Session::get('project_id'), 'Deleted Predecessors', $id);

        return response()->json([
            'action' => 'deleted',
        ]);
    }
}
