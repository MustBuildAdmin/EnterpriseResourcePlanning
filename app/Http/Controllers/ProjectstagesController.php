<?php

namespace App\Http\Controllers;

use App\Models\Projectstages;
use App\Models\Task;
use Auth;
use Illuminate\Http\Request;

class ProjectstagesController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('manage project stage'))
        {
            $projectstages = Projectstages::where('created_by', '=', \Auth::user()->creatorId())->orderBy('order')->get();

            return view('projectstages.index', compact('projectstages'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function create()
    {
        if(\Auth::user()->can('create project stage'))
        {
            return view('projectstages.create');
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('create project stage'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required|max:20',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->route('projectstages.index')->with('error', $messages->first());
            }
            $all_stage         = Projectstages::where('created_by', \Auth::user()->creatorId())->orderBy('id', 'DESC')->first();
            $stage             = new Projectstages();
            $stage->name       = $request->name;
            $stage->color      = '#' . $request->color;
            $stage->created_by = \Auth::user()->creatorId();
            $stage->order      = (!empty($all_stage) ? ($all_stage->order + 1) : 0);

            $stage->save();

            return redirect()->route('projectstages.index')->with('success', __('Project stage successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
        if(\Auth::user()->can('edit project stage'))
        {
            $leadstages = Projectstages::findOrfail($id);
            if($leadstages->created_by == \Auth::user()->creatorId())
            {
                return view('projectstages.edit', compact('leadstages'));
            }
            else
            {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function update(Request $request, $id)
    {
        if(\Auth::user()->can('edit project stage'))
        {
            $leadstages = Projectstages::findOrfail($id);
            if($leadstages->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required|max:20',
                                   ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->route('projectstages.index')->with('error', $messages->first());
                }

                $leadstages->name  = $request->name;
                $leadstages->color = '#' . $request->color;
                $leadstages->save();

                return redirect()->route('projectstages.index')->with('success', __('Project stage successfully updated.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {


        if(\Auth::user()->can('delete project stage'))
        {
            $projectstages = Projectstages::findOrfail($id);
            if($projectstages->created_by == \Auth::user()->creatorId())
            {
                $checkStage = Task::where('stage', '=', $projectstages->id)->get()->toArray();
                if(empty($checkStage))
                {
                    $projectstages->delete();

                    return redirect()->route('projectstages.index')->with('success', __('Project stage successfully deleted.'));
                }
                else
                {
                    return redirect()->route('projectstages.index')->with('error', __('Project task already assign this stage , so please remove or move task to other project stage.'));
                }
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function order(Request $request)
    {
        $post = $request->all();
        foreach($post['order'] as $key => $item)
        {
            $stage        = Projectstages::where('id', '=', $item)->first();
            $stage->order = $key;
            $stage->save();
        }
    }
}
