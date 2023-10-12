<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MicroTask;
use App\Models\MicroLink;
use App\Models\Project;
use Auth;
use Session;

class MicroLinkController extends Controller
{
    public function store(Request $request)
    {
        $max_id = MicroLink::where(['project_id' => Session::get('project_id')])->max('id');
        if ($max_id == null) {
            $max_id = 0;
        }
        $link = new MicroLink();
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

        MicroTask::where(['task_id' => $request->source, 'project_id' => Session::get('project_id')])
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
        $link = MicroLink::find($id);
        $link->where(['project_id' => Session::get('project_id'), 'instance_id' => Session::get('project_instance')]);
        $link->type = $request->type;
        $link->source = $request->source;
        $link->target = $request->target;
        $frezee = Project::where('id', Session::get('project_id'))->first();
        if ($frezee->freeze_status != 1) {
            $link->save();
        }

        MicroTask::where(['task_id' => $request->source, 'project_id' => Session::get('project_id')])
            ->update(['predecessors' => $request->target]);

        ActivityController::activity_store(Auth::user()->id,
            Session::get('project_id'), 'Update Predecessors', $request->target);

        return response()->json([
            'action' => 'updated',
        ]);
    }

    public function destroy($id)
    {
        $link = MicroLink::find($id);
        $link->where(['project_id' => Session::get('project_id'), 'instance_id' => Session::get('project_instance')]);
        $frezee = Project::where('id', Session::get('project_id'))->first();
        if ($frezee->freeze_status != 1) {
            $link->delete();
        }

        ActivityController::activity_store(Auth::user()->id,
            Session::get('project_id'), 'Deleted Predecessors', $id);

            MicroTask::where(['task_id' => $link->source, 'project_id' => Session::get('project_id')])->update(['predecessors' => 0]);

        return response()->json([
            'action' => 'deleted',
        ]);
    }
}
