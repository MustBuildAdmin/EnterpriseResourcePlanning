<?php

namespace App\Http\Controllers;

use App\Models\Utility;
use App\Models\TaskStage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskStageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->can('manage project task stage'))
        {
            $task_stages = TaskStage::where('created_by', '=', \Auth::user()->creatorId())->orderBy('order','asc')->get();

            return view('task_stage.index',compact('task_stages'));
        }

        else
        {
            return redirect()->back()->with('errors', __('Permission Denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function storingValue(Request $request)
     {
       if(\Auth::user()->can('create project task stage'))
       {
         $validator = \Validator::make(
             $request->all(), [
                                'name' => 'required|max:20',
                            ]
         );

           if($validator->fails())
           {
               $messages = $validator->getMessageBag();
               return redirect()->back()->with('error', $messages->first());
           }
           $arrStages = TaskStage::orderBy('order')->pluck('name', 'id')->all();
           $order=TaskStage::where('created_by',\Auth::user()->ownerId())->get()->count();
           $obj = new TaskStage();
           $obj->name       = $request->name;
           $obj->order      = $order+1;
           $obj->color      = '#' . $request->color;
           $obj->created_by = \Auth::user()->creatorId();
           $obj->save();
           return redirect()->route('project-task-stages.index')->with('success', __('Project Task Stage Added Successfully'));
     }
   }
    public function create()
    {
      if(\Auth::user()->can('create project task stage'))
      {
          return view('task_stage.create');
      }
      else
      {
          return response()->json(['error' => __('Permission Denied.')], 401);
      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(\Auth::user()->can('create project task stage'))
        {
            $rules = [
                'stages' => 'required|present|array',
            ];

            $attributes = [];

            if($request->stages)
            {
                foreach($request->stages as $key => $val)
                {
                    $rules['stages.' . $key . '.name']      = 'required|max:255';
                    $attributes['stages.' . $key . '.name'] = __('Stage Name');
                }
            }

            $validator = Validator::make($request->all(), $rules, [], $attributes);
            if($validator->fails())
            {
                return redirect()->back()->with('errors', Utility::errorFormat($validator->getMessageBag()));
            }
            $arrStages = TaskStage::orderBy('order')->pluck('name', 'id')->all();
            $order=0;

            foreach($request->stages as $key => $stage)
            {
                $obj = new TaskStage();
                if(isset($stage['id']) && !empty($stage['id']))
                {
                    $obj = TaskStage::find($stage['id']);
                    unset($arrStages[$obj->id]);
                }
                $obj->name       = $stage['name'];
                $obj->order      = $order++;
                $obj->color      = '#' . $request->color;
                $obj->created_by = \Auth::user()->creatorId();
                $obj->save();
            }

            if($arrStages)
            {
                foreach($arrStages as $id => $name)
                {
                    TaskStage::find($id)->delete();
                }
            }
            return redirect()->route('project-task-stages.index')->with('success', __('Task Stage Add Successfully'));
        }

        else
        {
            return redirect()->back()->with('errors', __('Permission Denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TaskStage  $taskStage
     * @return \Illuminate\Http\Response
     */
    public function show(TaskStage $taskStage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TaskStage  $taskStage
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskStage $taskStage,$id)
    {
      $taskStage = TaskStage::findOrfail($id);
      if($taskStage->created_by == \Auth::user()->creatorId())
      {
          return view('task_stage.edit', compact('taskStage'));
      }
      else
      {
          return response()->json(['error' => __('Permission denied.')], 401);
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TaskStage  $taskStage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TaskStage $taskStage,$id)
    {
      $taskStage = TaskStage::findOrfail($id);
      if($taskStage->created_by == \Auth::user()->creatorId())
      {
          $validator = \Validator::make(
              $request->all(), [
                                 'name' => 'required|max:20',
                             ]
          );
          if($validator->fails())
          {
              $messages = $validator->getMessageBag();

              return redirect()->route('project-task-stages.index')->with('error', $messages->first());
          }

          $taskStage->name = $request->name;
          $taskStage->color      = '#' . $request->color;
          $taskStage->save();

          return redirect()->route('project-task-stages.index')->with('success', __('Bug status successfully updated.'));
      }
      else
      {
          return redirect()->back()->with('error', __('Permission denied.'));
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TaskStage  $taskStage
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskStage $taskStage,$id)
    {

        if(\Auth::user()->can('delete project task stage'))
        {
            $taskstage = TaskStage::find($id);
            $taskstage->delete();
            return redirect()->back()->with('success', __('Task Stage Successfully Deleted.'));
        }

        else
        {
            return redirect()->back()->with('errors', __('Permission Denied.'));
        }
    }
    public function order(Request $request)
    {
        $post = $request->all();
        foreach($post['order'] as $key => $item)
        {
            $status        = TaskStage::where('id', '=', $item)->first();
            $status->order = $key;
            $status->save();
        }
    }
}
