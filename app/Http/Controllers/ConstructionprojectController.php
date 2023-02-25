<?php

namespace App\Http\Controllers;
use App\Models\Construction_project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Utility;
use App\Models\Construction_asign;
class ConstructionprojectController extends Controller
{
    public function index()
    {
        // if(\Auth::user()->can('manage branch'))
        // {
            $projects = Construction_project::where('created_by', \Auth::user()->creatorId())->get();

            return view('construction_project.index', compact('projects'));
        // }
        // else
        // {
        //     return redirect()->back()->with('error', __('Permission denied.'));
        // }
    }

    public function create()
    {
          $users   = User::where('created_by', '=', \Auth::user()->creatorId())->where('type', '!=', 'client')->get()->pluck('name', 'id');
          $clients = User::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 'client')->get()->pluck('name', 'id');
          $clients->prepend('Select Client', '');
          $users->prepend('Select User', '');
            return view('construction_project.create',compact('users','clients'));
    }

    public function store(Request $request)
    {
      
            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required|max:120|unique:construction_projects,name',
                                   'project_location'=>'required',
                                   'start_date'=>'required',
                                   'end_date'=>'required',
                                   'project_budget'=>'required',
                                   'non_working_days'=>'required',
                                   'status'=>'required',
                                   'client'=>'required'
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $companytype = new Construction_project();
            $companytype['name']= $request->name;
            $companytype['project_location']= $request->project_location;
            $companytype['start_date']     = $request->start_date;
            $companytype['end_date']       = $request->end_date;
            $companytype['project_budget'] = $request->project_budget;
            $companytype['client_id'] = $request->client;
            $companytype['status'] = $request->status;
            if(isset($request->holidays)){
                $project['holidays'] = $request->holidays;
            }
           
            $companytype['created_by'] = \Auth::user()->creatorId();
            if(!empty($request->non_working_days)){
                $companytype['non_working_days'] =implode(',',$request->non_working_days);
            }
            $companytype ->save();

            if(\Auth::user()->type=='company'){

                Construction_asign::create(
                    [
                        'project_id' => $companytype->id,
                        'user_id' => Auth::user()->id,
                    ]
                );

                if($request->user){
                    foreach($request->user as $key => $value) {
                        Construction_asign::create(
                            [
                                'project_id' => $companytype->id,
                                'user_id' => $value,
                            ]
                        );
                    }
                }


            }else{
                Construction_asign::create(
                    [
                        'project_id' => $companytype->id,
                        'user_id' => Auth::user()->creatorId(),
                    ]
                );

                Construction_asign::create(
                    [
                        'project_id' => $companytype->id,
                        'user_id' => Auth::user()->id,
                    ]
                );


            }


            //Slack Notification
            $setting  = Utility::settings(\Auth::user()->creatorId());
            if(isset($setting['project_notification']) && $setting['project_notification'] ==1){
                $msg = $request->project_name.' '.__(" created by").' ' .\Auth::user()->name.'.';
                Utility::send_slack_msg($msg);
            }

            //Telegram Notification
            $setting  = Utility::settings(\Auth::user()->creatorId());
            if(isset($setting['telegram_project_notification']) && $setting['telegram_project_notification'] ==1){
                $msg = __("New").' '.$request->project_name.' '.__("project").' '.__(" created by").' ' .\Auth::user()->name.'.';
                Utility::send_telegram_msg($msg);
            }
            if(isset($request->file)){
                // gant project data gathering
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://export.dhtmlx.com/gantt',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('file'=> new CURLFILE($request->file),),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                echo $response;
            }


            //end
            return redirect()->route('construction_project.index');
            

    }
    public function edit($id)
    {
            $projects = Construction_project::where('id',$id)->first();
            $clients = User::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 'client')->get()->pluck('name', 'id');
            return view('construction_project.edit', compact('projects','clients'));

    }
    public function show($id)
    {
            $projects = Construction_project::where('id',$id)->first();
            $clients = User::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 'client')->get()->pluck('name', 'id');
            return view('construction_project.view', compact('projects','clients'));

    }
    public function update(Request $request, $id)
    {
        $validator = \Validator::make(
            $request->all(), [
                               'name' => 'required|max:120',
                               'project_location'=>'required',
                               'start_date'=>'required',
                               'end_date'=>'required',
                               'project_budget'=>'required',
                               'non_working_days'=>'required',
                               'status'=>'required',
                               'client'=>'required'
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }
        $find=Construction_project::where('name',$request->name)->where('id','!=',$id)->first();
        if($find){
            $messages = __('Project Name already exit');

            return redirect()->back()->with('error', $messages);
        }
        $project = Construction_project::find($id);
        $project['name']= $request->name;
        $project['project_location']= $request->project_location;
        $project['start_date']     = $request->start_date;
        $project['end_date']       = $request->end_date;
        $project['project_budget'] = $request->project_budget;
        $project['status'] = $request->status;
        $project['client_id'] = $request->client;
        if(isset($request->holidays)){
            $project['holidays'] = $request->holidays;
        }
       
        $project['created_by'] = \Auth::user()->creatorId();
        if(!empty($request->non_working_days)){
            $project['non_working_days'] =implode(',',$request->non_working_days);
        }
        $project ->save();

        return redirect()->route('construction_project.index');

    }
    public function destroy($id)
    {

            $project = Construction_project::find($id)->delete();

            return redirect()->route('construction_project.index');
        
    }
    public function construction_name_presented(Request $request)
    {

            $project = Construction_project::where('name',$request->name)->first();
            if($project){
                echo 'in';
            }else{
                echo 'out';
            }

        
    }
    

}
