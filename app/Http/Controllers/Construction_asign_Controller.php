<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Construction_project;
use App\Models\Construction_asign;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity_logs_con;


class Construction_asign_Controller extends Controller
{
    public function index()
    {
        // if(\Auth::user()->can('manage branch'))
        // {
            $projects = Construction_asign::with(['project_name'])->where('invited_by', \Auth::user()->creatorId())->get();

            return view('construction_asign.index', compact('projects'));
        // }
        // else
        // {
        //     return redirect()->back()->with('error', __('Permission denied.'));
        // }
    }

    public function create()
    {
            $projects = Construction_project::where('created_by', \Auth::user()->creatorId())->get();
            if(Auth::user()->type == 'employee')
            {
                $employees = Employee::where('user_id', '=', Auth::user()->id)->get();
            }
            else
            {
                $employees = Employee::where('created_by', \Auth::user()->creatorId())->get();
            }
            return view('construction_asign.create',compact('projects','employees'));
            
    }

    public function store(Request $request)
    {
            $validator = \Validator::make(
                $request->all(), [
                                   'project' => 'required',
                                   'employee'=>'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $authuser = Auth::user();
            Construction_asign::where('project_id',$request->project_id)->get();
            foreach ($request->employee as $key => $value) {
                // Make entry in project_user tbl
                if(Construction_asign::where(['project_id' => $request->project_id,
                'user_id' => $request->user_id,
                'invited_by' => $authuser->id,])->exists()){

                }else{
                    Construction_asign::create(
                        [
                            'project_id' => $request->project_id,
                            'user_id' => $request->user_id,
                            'invited_by' => $authuser->id,
                        ]
                    );
                    // Make entry in activity_log tbl
                    Activity_logs_con::create(
                        [
                            'user_id' => $authuser->id,
                            'project_id' => $request->project_id,
                            'log_type' => 'Invite User',
                            'remark' => json_encode(['title' => $authuser->name]),
                        ]
                    );
                }
               

                
            }
           
            if($check){
                $messages = __('Project Name already exit');

                return redirect()->back()->with('error', $messages);
            }
            $construction_asign = new Construction_asign();
            $construction_asign['project_id']= $request->project;
            $construction_asign['employe_id']= implode(",",$request->employee);
            $construction_asign['invited_by'] = 
            $construction_asign ->save();

            return redirect()->route('construction_asign.index')->with('success', __('Employee Asigned Successfully'));

    }
    public function edit($id)
    {       $projects = Construction_project::where('created_by', \Auth::user()->creatorId())->get();
            $construction_asign = Construction_asign::where('id',$id)->first();
            if(Auth::user()->type == 'employee')
            {
                $employees = Employee::where('user_id', '=', Auth::user()->id)->get();
            }
            else
            {
                $employees = Employee::where('created_by', \Auth::user()->creatorId())->get();
            }
            return view('construction_asign.edit', compact('construction_asign','projects','employees'));

    }
    public function show($id)
    {
            $projects = Construction_project::where('created_by', \Auth::user()->creatorId())->get();
            $construction_asign = Construction_asign::where('id',$id)->first();
            if(Auth::user()->type == 'employee')
            {
                $employees = Employee::where('user_id', '=', Auth::user()->id)->get();
            }
            else
            {
                $employees = Employee::where('created_by', \Auth::user()->creatorId())->get();
            }
            return view('construction_asign.view', compact('construction_asign','projects','employees'));

    }
    public function update(Request $request, $id)
    {
        $validator = \Validator::make(
            $request->all(), [
                               'project' => 'required',
                               'employee'=>'required',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $construction_asign = Construction_asign::find($id);
        $construction_asign['project_id']= $request->project;
        $construction_asign['employe_id']= implode(",",$request->employee);
        $construction_asign['invited_by'] = \Auth::user()->creatorId();
        $construction_asign ->save();

        return redirect()->route('construction_asign.index')->with('success', __('Update Successfully'));

    }
    public function destroy($id)
    {

            $project = Construction_asign::find($id)->delete();

            return redirect()->route('construction_asign.index')->with('success', __('Delete Successfully'));
        
    }
}
