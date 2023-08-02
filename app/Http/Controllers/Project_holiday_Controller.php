<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project_holiday;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Session;

class Project_holiday_Controller extends Controller
{
    public function index()
    {
        // if(\Auth::user()->can('manage branch'))
        // {
            $project = Project::where('id', Session::get('project_id') )->first();
            $holidays = Project_holiday::with(['project_name'])->where(['project_id'=> Session::get('project_id'),'instance_id'=>$project->instance_id])->get();
            return view('project_holidays.index', compact('project','holidays'));
        // }
        // else
        // {
        //     return redirect()->back()->with('error', __('Permission denied.'));
        // }
    }

    public function create()
    {
            $projects = Project::where('created_by', \Auth::user()->creatorId())->get();
            return view('project_holidays.create',compact('projects'));
    }

    public function store(Request $request)
    {
      
            $validator = \Validator::make(
                $request->all(), [
                                   'project_id' => 'required',
                                   'date'=>'required',
                                   'description'=>'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $project = Project::where('id', $request->project_id)->first();
            $Project_holiday = new Project_holiday();
            $Project_holiday['project_id']= $request->project_id;
            $Project_holiday['date']= $request->date;
            $Project_holiday['description']     = $request->description;
            $Project_holiday['created_by'] = \Auth::user()->creatorId();
            $Project_holiday['instance_id'] = $project->instance_id;
            $Project_holiday ->save();

            return redirect()->route('project_holiday.index');

    }
    public function edit($id)
    {
            $project_holiday = Project_holiday::where('id',$id)->first();
            $projects = Project::where('created_by', \Auth::user()->creatorId())->get();
            return view('project_holidays.edit', compact('projects','project_holiday'));

    }

    public function update(Request $request, $id)
    {
        
     
        $validator = \Validator::make(
            $request->all(), [
                               'project_id' => 'required',
                               'date'=>'required',
                               'description'=>'required',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }
        $project = Project::where('id', $request->project_id)->first();
        $Project_holiday =Project_holiday::find($id);
        $Project_holiday['project_id']= $request->project_id;
        $Project_holiday['date']= $request->date;
        $Project_holiday['description']     = $request->description;
        $Project_holiday['created_by'] = \Auth::user()->creatorId();
        $Project_holiday['instance_id'] = $project->instance_id;
        $Project_holiday ->save();

        return redirect()->route('project_holiday.index');

    }
    public function destroy($id)
    {

            $project = Project_holiday::find($id)->delete();

            return redirect()->route('project_holiday.index');
        
    }
}
