<?php

namespace App\Http\Controllers;

use App\Models\Instance;
use App\Models\Project;
use App\Models\Project_holiday;
use Illuminate\Http\Request;
use Session;

class Project_holiday_Controller extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('manage project holiday'))
        {
            $project = Instance::where('project_id', Session::get('project_id'))
                ->where('instance', Session::get('project_instance'))->first();
            $holidays = Project_holiday::with(['project_name'])
                ->where(['project_id' => Session::get('project_id'),
                    'instance_id' => Session::get('project_instance')])->get();

            return view('project_holidays.index', compact('project', 'holidays'));
        }else{
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function create()
    {
        $projects = Project::where('id', Session::get('project_id'))->get();

        return view('project_holidays.create', compact('projects'));
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('create project holiday'))
        {
            $validator = \Validator::make(
                $request->all(), [
                    'project_id' => 'required',
                    'date' => 'required',
                    'description' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $project = Project::where('id', $request->project_id)->first();
            $checkHolidayExist=Project_holiday::where(['project_id'=> $request->project_id,
            'date' => $request->date])->count();
            if($checkHolidayExist!=0){
                return redirect()->back()->with('error', "Holiday already available for this date");
            }else{
                $Project_holiday = new Project_holiday();
                $Project_holiday['project_id'] = $request->project_id;
                $Project_holiday['date'] = $request->date;
                $Project_holiday['description'] = $request->description;
                $Project_holiday['created_by'] = \Auth::user()->creatorId();
                if (Session::has('project_instance')) {
                    $instanceId = Session::get('project_instance');
                } else {
                    $instanceId = $project->instance_id;
                }
                $Project_holiday['instance_id'] = $instanceId;
                $Project_holiday->save();
            
                return redirect()->route('project-holiday.index');
            }
        }else{
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function edit($id)
    {
        $project_holiday = Project_holiday::where('id', $id)->first();
        $projects = Project::where('id', Session::get('project_id'))->get();

        return view('project_holidays.edit', compact('projects', 'project_holiday'));

    }

    public function update(Request $request, $id)
    {
        if(\Auth::user()->can('edit project holiday'))
        {
            $validator = \Validator::make(
                $request->all(), [
                    'project_id' => 'required',
                    'date' => 'required',
                    'description' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $project = Project::where('id', $request->project_id)->first();
            $checkHolidayExist=Project_holiday::where(['project_id'=> $request->project_id,
            'date' => $request->date])->whereNotIn('id', [$id])->count();
            if($checkHolidayExist!=0){
                return redirect()->back()->with('error', "Holiday already available for this date");
            }else{
                $Project_holiday = Project_holiday::find($id);
                $Project_holiday['project_id'] = $request->project_id;
                $Project_holiday['date'] = $request->date;
                $Project_holiday['description'] = $request->description;
                $Project_holiday['created_by'] = \Auth::user()->creatorId();
                if (Session::has('project_instance')) {
                    $instanceId = Session::get('project_instance');
                } else {
                    $instanceId = $project->instance_id;
                }
                $Project_holiday['instance_id'] = $instanceId;
                $Project_holiday->save();

                return redirect()->route('project-holiday.index');
            }
        }else{
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function destroy($id)
    {
        if(\Auth::user()->can('delete project holiday'))
        {
            $project = Project_holiday::find($id)->delete();
            return redirect()->route('project-holiday.index');

        }else{

            return redirect()->back()->with('error', __('Permission denied.'));

        }

    }
}
