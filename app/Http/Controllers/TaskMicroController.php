<?php

namespace App\Http\Controllers;

use App\Models\MicroTask;
use App\Models\Project;
use App\Models\Instance;
use Auth;
use Illuminate\Http\Request;
use Session;
use Exception;

class TaskMicroController extends Controller
{
    public function store(Request $request)
    {

   
        $maxid = MicroTask::where(['project_id' => Session::get('project_id'),
            'instance_id' => Session::get('project_instance')])->max('task_id');
        if ($maxid == null) {
            $maxid = 0;
        }
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
        $task->parent = $request->parent;

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
                  ->where('id', $request->parent)->update(['type' => 'project']);
        $checkparent = MicroTask::where(['project_id' => Session::get('project_id'),
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
    public function create(Request $request)
    {

     
        $maxid = MicroTask::where(['project_id' => Session::get('project_id'),
            'instance_id' => Session::get('project_instance')])->max('task_id');
        if ($maxid == null) {
            $maxid = 0;
        }
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
        $task->parent = $request->parent;

        if (isset($request->users)) {
            if (gettype($request->users) == 'array') {
                $implodeusers = implode(',', json_decode($request->users));
            } else {
                $implodeusers = $request->users;
            }
            $task->users = $implodeusers;
        }
        // update  the type
        MicroTask::where(['project_id' => Session::get('project_id'), 'instance_id' => Session::get('project_instance')])
            ->where('id', $request->parent)->update(['type' => 'project']);
        $checkparent = MicroTask::where(['project_id' => Session::get('project_id'),
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

    public function destroy($id)
    {
     
        $task = MicroTask::find($id);
        $row = MicroTask::where(['project_id' => Session::get('project_id'),
            'instance_id' => Session::get('project_instance'), 'id' => $id])->first();
        if ($row != null) {
            ActivityController::activity_store(Auth::user()->id,
                Session::get('project_id'), 'Deleted Task', $row->text);
        }
        $frezee = Project::where('id', Session::get('project_id'))->first();
        if ($frezee->freeze_status != 1) {
            $task->where(['project_id' => Session::get('project_id'), 'instance_id' => Session::get('project_instance')]);
            $task->delete();
        }

        // checking whether its having parent or not
        $checkparent = MicroTask::where(['project_id' => Session::get('project_id'),
            'instance_id' => Session::get('project_instance')])
            ->where(['parent' => $row->parent])->first();
        if ($checkparent) {
            // update  the type
            MicroTask::where(['project_id' => Session::get('project_id'),
                'instance_id' => Session::get('project_instance')])
                ->where('id', $row->parent)->update(['type' => 'project']);
        } else {
            // update  the type
            MicroTask::where(['project_id' => Session::get('project_id'),
                'instance_id' => Session::get('project_instance')])
                ->where('id', $row->parent)->update(['type' => 'task']);
        }

        return response()->json([
            'action' => 'deleted',
        ]);
    }

    public function update($id, Request $request)
    {
       
        $task = MicroTask::find($id);
    
        $task->where(['project_id' => Session::get('project_id'), 'instance_id' => Session::get('project_instance')]);
        $task->text = $request->text;
        $task->start_date = date('Y-m-d', strtotime($request->start_date));
        $task->end_date = date('Y-m-d', strtotime($request->end_date));
        $task->duration = $request->duration;
        $task->progress = $request->has('progress') ? $request->progress : 0;
        $task->parent = $request->parent;
        if (isset($request->users)) {
            if (gettype($request->users) == 'array') {
                $implodeusers = implode(',', json_decode($request->users));
            } else {
                $implodeusers = $request->users;
            }
            $task->users = $implodeusers;
        }
        $checkparent = MicroTask::where(['project_id' => Session::get('project_id'),
            'instance_id' => Session::get('project_instance')])->where(['parent' => $task->task_id])->get();
        // update  the type
        MicroTask::where(['project_id' => Session::get('project_id'), 'instance_id' => Session::get('project_instance')])
            ->where('id', $request->parent)->update(['type' => 'project']);
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
            Session::get('project_id'), 'Updated Task', $request->text);

        return response()->json([
            'action' => 'updated',
        ]);
    }

    

}
