<?php

namespace App\Http\Controllers;

use App\Models\ProjectStage;
use App\Models\TaskStage;
use App\Models\TimeTracker;
use App\Models\User;
use App\Models\Project;
use App\Models\Utility;
use App\Models\Bug;
use App\Models\BugStatus;
use App\Models\BugFile;
use App\Models\BugComment;
use App\Models\Project_holiday;
use App\Models\Holiday;
use App\Models\Con_task;
use App\Models\Link;
use App\Models\Milestone;
use Carbon\Carbon;
use App\Models\ActivityLog;
use App\Models\ProjectTask;
use App\Models\ProjectUser;
use App\Models\Task_progress;
use App\Models\Instance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;
use Hash;
class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($view = 'grid')
    {

        if(\Auth::user()->can('manage project'))
        {
            return view('projects.index', compact('view'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(\Auth::user()->can('create project'))
        {
          $setting  = Utility::settings(\Auth::user()->creatorId());
          $users   = User::where('created_by', '=', \Auth::user()->creatorId())->where('type', '!=', 'client')->get()->pluck('name', 'id');
          $clients = User::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 'client')->get()->pluck('name', 'id');
          $clients->prepend('Select Client', '');
          $users->prepend('Select User', '');
            return view('projects.create', compact('clients','users','setting'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
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

        if(\Auth::user()->can('create project'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                'project_name' => 'required',
                                // 'project_image' => 'required',
                                'non_working_days'=>'required',
                                'status'=>'required'
                            ]
            );
            if($validator->fails())
            {
                return redirect()->back()->with('error', Utility::errorFormat($validator->getMessageBag()));
            }
            // dd($request->all());
            $project = new Project();
            $project->project_name = $request->project_name;
            $project->start_date = date("Y-m-d H:i:s", strtotime($request->start_date));
            $project->end_date = date("Y-m-d H:i:s", strtotime($request->end_date));
            if($request->hasFile('project_image'))
            {
                $imageName = time() . '.' . $request->project_image->extension();
                $request->file('project_image')->storeAs('projects', $imageName);
                $project->project_image      = 'projects/'.$imageName;
            }
            if(isset($request->holidays)){
                $project->holidays= $request->holidays;
            }
            if(isset($request->non_working_days)){
                $project->non_working_days=implode(',',$request->non_working_days);
            }

            $project->client_id = $request->client;
            $project->budget = !empty($request->budget) ? $request->budget : 0;
            $project->description = $request->description;
            $project->status = $request->status;
            $project->estimated_hrs = $request->estimated_hrs;
            $project->report_to = $request->reportto;
            $project->report_time = $request->report_time;
            $project->tags = $request->tag;
            $project->created_by = \Auth::user()->creatorId();
            // instance creation------------------------
            $var=rand('100000','555555').date('dmyhisa').$request->client_id.$request->project_name;
            $instance_id=Hash::make($var);
            $project->instance_id=$instance_id;
            ///---------end-----------------
            $project->save();
            $insert_data=array(
                'instance'=>$instance_id,
                'start_date'=>date("Y-m-d H:i:s", strtotime($request->start_date)),
                'end_date'=>date("Y-m-d H:i:s", strtotime($request->end_date)),
                'percentage'=>'0',
                'achive'=>0,
                'project_id'=>$project->id,
            );
            Instance::insert($insert_data);
            if($request->holidays==0){
                $holidays_list=Holiday::where('created_by', '=', \Auth::user()->creatorId())->get();
                foreach ($holidays_list as $key => $value) {
                    $insert=array(
                        'project_id'=>$project->id,
                        'date'=>$value->date,
                        'description'=>$value->occasion,
                        'created_by'=>\Auth::user()->creatorId()
                    );
                    Project_holiday::insert($insert);
                }

            }
            if(isset($request->file)){
               if($request->file_status=='MP'){
                $path='projectfiles/';
                $filename =$_FILES["file"]["name"];
                $name = $project->id.'.'.pathinfo($filename, PATHINFO_EXTENSION);
                $pathname='projectfiles/'.$name;
                $link=env('APP_URL').'/'.$path.$name;
                if (file_exists(public_path($pathname))){
                    unlink(public_path($pathname));
                }

                $request->file->move(public_path($path), $name);

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
                  CURLOPT_POSTFIELDS => ['file'=> new \CURLFILE($link),'type'=>'msproject-parse'],
                ));

                $responseBody = curl_exec($curl);
                curl_close($curl);
                if (file_exists(public_path($pathname))){
                    unlink(public_path($pathname));
                }
                $responseBody = json_decode($responseBody, true);
                if(isset($responseBody['data']['data'])){
                    foreach($responseBody['data']['data'] as $key=>$value){
                        $task= new Con_task();
                        $task->project_id=$project->id;
                        $task->instance_id=$instance_id;
                        if(isset($value['text'])){
                            $task->text=$value['text'];
                        }
                        if(isset($value['id'])){
                            $task->id=$value['id'];
                        }
                        if(isset($value['start_date'])){
                            $task->start_date=$value['start_date'];
                        }
                        if(isset($value['duration'])){
                            $task->duration=$value['duration'];
                        }
                        if(isset($value['progress'])){
                            $task->progress=$value['progress'];
                        }
                        if(isset($value['parent'])){
                            $task->parent=$value['parent'];
                            $task->predecessors=$value['parent'];
                        }
                        if(isset($value['$raw'])){
                            $raw=$value['$raw'];
                            if(isset($raw['Finish'])){
                                $task->end_date=$raw['Finish'];
                            }
                            $task->custom=json_encode($value['$raw']);
                        }

                        $task->save();
                    }

                    foreach($responseBody['data']['links'] as $key=>$value){
                        $link= new Link();
                        $link->project_id=$project->id;
                        $link->instance_id=$instance_id;
                        $link->id=$value['id'];
                        // Con_task::where(['main_id'=>$value['source'],'project_id'=>$project->id])->update(['predecessors'=>$value['target']]);
                        if(isset($value['type'])){
                            $link->type=$value['type'];
                        }
                        if(isset($value['source'])){

                            $link->source=$value['source'];
                        }
                        if(isset($value['target'])){
                            $link->target=$value['target'];
                        }
                        $link->save();
                    }
                }

                // $project->project_json=json_encode($responseBody);
               }else{
                    /// primaverra
                    $path='projectfiles/';
                    $filename =$_FILES["file"]["name"];
                    $name = $project->id.'.'.pathinfo($filename, PATHINFO_EXTENSION);
                    $pathname='projectfiles/'.$name;
                    $link=env('APP_URL').'/'.$path.$name;
                    if (file_exists(public_path($pathname))){
                        unlink(public_path($pathname));
                    }

                    $request->file->move(public_path($path), $name);

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
                      CURLOPT_POSTFIELDS => ['file'=> new \CURLFILE($link),'type'=>'primaveraP6-parse'],
                    ));

                    $responseBody = curl_exec($curl);
                    curl_close($curl);
                    if (file_exists(public_path($pathname))){
                        unlink(public_path($pathname));
                    }
                    $responseBody = json_decode($responseBody, true);
                    if(isset($responseBody['data']['data'])){
                        foreach($responseBody['data']['data'] as $key=>$value){
                            $task= new Con_task();
                            $task->project_id=$project->id;
                            $task->instance_id=$instance_id;
                            if(isset($value['text'])){
                                $task->text=$value['text'];
                            }
                            if(isset($value['id'])){
                                $task->id=$value['id'];
                            }
                            if(isset($value['start_date'])){
                                $task->start_date=$value['start_date'];
                            }
                            if(isset($value['duration'])){
                                $task->duration=$value['duration'];
                            }
                            if(isset($value['progress'])){
                                $task->progress=$value['progress'];
                            }
                            if(isset($value['parent'])){
                                $task->parent=$value['parent'];
                                $task->predecessors=$value['parent'];
                            }
                            if(isset($value['$raw'])){
                                $raw=$value['$raw'];
                                if(isset($raw['Finish'])){
                                    $task->end_date=$raw['Finish'];
                                }
                                $task->custom=json_encode($value['$raw']);
                            }

                            $task->save();
                        }

                        foreach($responseBody['data']['links'] as $key=>$value){
                            $link= new Link();
                            $link->project_id=$project->id;
                            $link->instance_id=$instance_id;
                            // Con_task::where(['main_id'=>$value['source'],'project_id'=>$project->id])->update(['predecessors'=>$value['target']]);
                            $link->id=$value['id'];
                            if(isset($value['type'])){
                                $link->type=$value['type'];
                            }
                            if(isset($value['source'])){

                                $link->source=$value['source'];
                            }
                            if(isset($value['target'])){
                                $link->target=$value['target'];
                            }
                            $link->save();
                        }
                    }

                    // end


               }
            }



            if(\Auth::user()->type=='company'){

                ProjectUser::create(
                    [
                        'project_id' => $project->id,
                        'user_id' => Auth::user()->id,
                    ]
                );

                if($request->user){
                    foreach($request->user as $key => $value) {
                        ProjectUser::create(
                            [
                                'project_id' => $project->id,
                                'user_id' => $value,
                            ]
                        );
                    }
                }


            }else{
                ProjectUser::create(
                    [
                        'project_id' => $project->id,
                        'user_id' => Auth::user()->creatorId(),
                    ]
                );

                ProjectUser::create(
                    [
                        'project_id' => $project->id,
                        'user_id' => Auth::user()->id,
                    ]
                );

                if($request->user){
                    foreach($request->user as $key => $value) {
                        ProjectUser::create(
                            [
                                'project_id' => $project->id,
                                'user_id' => $value,
                            ]
                        );
                    }
                }

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
            if(isset($request->holidays)){
                return redirect()->route('construction_main')->with('success', __('Project Add Successfully'));
            }else{
                return redirect('project_holiday')->with('success', __('Project Add Successfully'));
            }
            
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }



    public function loadproject(Project $project)
    {


    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Poject  $poject
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {

        if(\Auth::user()->can('view project'))
        {

            $usr           = Auth::user();
            if(\Auth::user()->type == 'client'){
              $user_projects = Project::where('client_id',\Auth::user()->id)->pluck('id','id')->toArray();
            }else{
              $user_projects = $usr->projects->pluck('id')->toArray();
            }
            Session::put('project_id',$project->id);
            Session::put('project_instance',$project->instance_id);
            if(in_array($project->id, $user_projects))
            {
                // test the holidays
                    if($project->holidays==0){
                        $holidays=Project_holiday::where('project_id',$project->id)->first();
                        if(!$holidays){
                            return redirect()->back()->with('error', __('No holidays are listed.'));
                        }
                    }


                // end
                $project_data = [];
                // Task Count
                $tasks = Con_task::where('project_id',$project->id)->get();
                $project_task         = $tasks->count();
                $completedTask = Con_task::where('project_id',$project->id)->where('progress',100)->get();

                $project_done_task    = $completedTask->count();

                $project_data['task'] = [
                    'total' => number_format($project_task),
                    'done' => number_format($project_done_task),
                    'percentage' => Utility::getPercentage($project_done_task, $project_task),
                ];

                // end Task Count

                // Expense
                $expAmt = 0;
                foreach($project->expense as $expense)
                {
                    $expAmt += $expense->amount;
                }

                $project_data['expense'] = [
                    'allocated' => $project->budget,
                    'total' => $expAmt,
                    'percentage' => Utility::getPercentage($expAmt, $project->budget),
                ];
                // end expense


                // Users Assigned
                $total_users = User::where('created_by', '=', $usr->id)->count();


                $project_data['user_assigned'] = [
                    'total' => number_format($total_users) . '/' . number_format($total_users),
                    'percentage' => Utility::getPercentage($total_users, $total_users),
                ];
                // end users assigned

                // Day left
                $total_day                = Carbon::parse($project->start_date)->diffInDays(Carbon::parse($project->end_date));
                $remaining_day            = Carbon::parse($project->start_date)->diffInDays(now());
                $project_data['day_left'] = [
                    'day' => number_format($remaining_day) . '/' . number_format($total_day),
                    'percentage' => Utility::getPercentage($remaining_day, $total_day),
                ];
                // end Day left

                // Open Task
                    //$remaining_task = Con_task::where('project_id', '=', $project->id)->where('progress', '=', 100)->where('created_by',\Auth::user()->creatorId())->count();
                    // $remaining_task = Con_task::where('project_id', '=', $project->id)->where('progress', '=', 100)->count();
                    // $total_task     = $project->tasks->count();
                    $remaining_task = Con_task::where('project_id', '=', $project->id)->where('progress', '=', 100)->count();
                    $total_task     = $project_data['task']['total'];

                $project_data['open_task'] = [
                    'tasks' => number_format($remaining_task) . '/' . number_format($total_task),
                    'percentage' => Utility::getPercentage($remaining_task, $total_task),
                ];
                // end open task

                // Milestone
                $total_milestone           = $project->milestones()->count();
                $complete_milestone        = $project->milestones()->where('status', 'LIKE', 'complete')->count();
                $project_data['milestone'] = [
                    'total' => number_format($complete_milestone) . '/' . number_format($total_milestone),
                    'percentage' => Utility::getPercentage($complete_milestone, $total_milestone),
                ];
                // End Milestone

                // Time spent

                    $times = $project->timesheets()->where('created_by', '=', $usr->id)->pluck('time')->toArray();
                $totaltime                  = str_replace(':', '.', Utility::timeToHr($times));
                $project_data['time_spent'] = [
                    'total' => number_format($totaltime) . '/' . number_format($totaltime),
                    'percentage' => Utility::getPercentage(number_format($totaltime), $totaltime),
                ];
                // end time spent

                // Allocated Hours
                $hrs = Project::projectHrs($project->id);
                $project_data['task_allocated_hrs'] = [
                    'hrs' => number_format($hrs['allocated']) . '/' . number_format($hrs['allocated']),
                    'percentage' => Utility::getPercentage($hrs['allocated'], $hrs['allocated']),
                ];
                // end allocated hours

                // Chart
                $seven_days      = Utility::getLastSevenDays();
                $chart_task      = [];
                $chart_timesheet = [];
                $cnt             = 0;
                $cnt1            = 0;

                foreach(array_keys($seven_days) as $k => $date)
                {
                        $task_cnt     = $project->tasks()->where('is_complete', '=', 1)->whereRaw("find_in_set('" . $usr->id . "',assign_to)")->where('marked_at', 'LIKE', $date)->count();
                        $arrTimesheet = $project->timesheets()->where('created_by', '=', $usr->id)->where('date', 'LIKE', $date)->pluck('time')->toArray();

                    // Task Chart Count
                    $cnt += $task_cnt;

                    // Timesheet Chart Count
                    $timesheet_cnt = str_replace(':', '.', Utility::timeToHr($arrTimesheet));
                    $cn[]          = $timesheet_cnt;
                    $cnt1          += $timesheet_cnt;

                    $chart_task[]      = $task_cnt;
                    $chart_timesheet[] = $timesheet_cnt;
                }

                $project_data['task_chart']      = [
                    'chart' => $chart_task,
                    'total' => $cnt,
                ];
                $project_data['timesheet_chart'] = [
                    'chart' => $chart_timesheet,
                    'total' => $cnt1,
                ];

                // end chart

                return view('construction_project.dashboard',compact('project','project_data'));
               // return view('projects.view',compact('project','project_data'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Poject  $poject
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        if(\Auth::user()->can('edit project'))
        {
          $clients = User::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 'client')->get()->pluck('name', 'id');
          $users   = User::where('created_by', '=', \Auth::user()->creatorId())->where('type', '!=', 'client')->get()->pluck('name', 'id');
          $users->prepend('Select User', '');
          
          $project = Project::findOrfail($project->id);
          if($project->created_by == \Auth::user()->creatorId())
          {
              return view('projects.edit', compact('project', 'clients','users'));
          }
          else
          {
              return response()->json(['error' => __('Permission denied.')], 401);
          }
            return view('projects.edit',compact('project','users'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Poject  $poject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        if(\Auth::user()->can('edit project'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                'project_name' => 'required',
                                'status'=>'required'

                            ]
            );
            if($validator->fails())
            {
                return redirect()->back()->with('error', Utility::errorFormat($validator->getMessageBag()));
            }
            $project = Project::find($project->id);
            $project->project_name = $request->project_name;
            $project->start_date = date("Y-m-d H:i:s", strtotime($request->start_date));
            $project->end_date = date("Y-m-d H:i:s", strtotime($request->end_date));
            if($request->hasFile('project_image'))
            {
                Utility::checkFileExistsnDelete([$project->project_image]);
                $imageName = time() . '.' . $request->project_image->extension();
                $request->file('project_image')->storeAs('projects', $imageName);
                $project->project_image      = 'projects/'.$imageName;
            }
            if(isset($request->holidays)){
                $project->holidays= $request->holidays;
            }
            if(isset($request->non_working_days)){
                $project->non_working_days=implode(',',$request->non_working_days);
            }

            $project->budget = $request->budget;
            $project->client_id = $request->client;
            $project->description = $request->description;
            $project->status = $request->status;
            $project->estimated_hrs = $request->estimated_hrs;
            $project->report_to = $request->reportto;
            $project->report_time = $request->report_time;
            $project->tags = $request->tag;
            $project->save();
            if($project->holidays==0){
                $holidays_list=Holiday::where('created_by', '=', \Auth::user()->creatorId())->get();
                foreach ($holidays_list as $key => $value) {
                    $insert=array(
                        'project_id'=>$project->id,
                        'date'=>$value->date,
                        'description'=>$value->occasion,
                        'created_by'=>\Auth::user()->creatorId()
                    );
                    Project_holiday::insert($insert);
                }

            }
            return redirect()->route('construction_main')->with('success', __('Project Updated Successfully'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Poject  $poject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if(\Auth::user()->can('delete project'))
        {
            if(!empty($project->image))
            {
                Utility::checkFileExistsnDelete([$project->project_image]);
            }
            $project->delete();
            return redirect()->back()->with('success', __('Project Successfully Deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function inviteMemberView(Request $request, $project_id)
    {
        $usr          = Auth::user();
        $project      = Project::find($project_id);

        $user_project = $project->users->pluck('id')->toArray();

        $user_contact = User::where('created_by', \Auth::user()->creatorId())->where('type','!=','client')->whereNOTIn('id', $user_project)->pluck('id')->toArray();
        $arrUser      = array_unique($user_contact);
        $users        = User::whereIn('id', $arrUser)->get();

        return view('projects.invite', compact('project_id', 'users'));
    }

    public function inviteProjectUserMember(Request $request)
    {
        $authuser = Auth::user();

        // Make entry in project_user tbl
        ProjectUser::create(
            [
                'project_id' => $request->project_id,
                'user_id' => $request->user_id,
                'invited_by' => $authuser->id,
            ]
        );

        // Make entry in activity_log tbl
        ActivityLog::create(
            [
                'user_id' => $authuser->id,
                'project_id' => $request->project_id,
                'log_type' => 'Invite User',
                'remark' => json_encode(['title' => $authuser->name]),
            ]
        );

        return json_encode(
            [
                'code' => 200,
                'status' => 'success',
                'success' => __('User invited successfully.'),
            ]
        );
    }





    public function destroyProjectUser($id, $user_id)
    {
        $project = Project::find($id);
            if($project->created_by == \Auth::user()->ownerId())
            {
                ProjectUser::where('project_id', '=', $project->id)->where('user_id', '=', $user_id)->delete();

                return redirect()->back()->with('success', __('User successfully deleted!'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }

    }

    public function loadUser(Request $request)
    {
        if($request->ajax())
        {
            $project    = Project::find($request->project_id);
            $returnHTML = view('projects.users', compact('project'))->render();

            return response()->json(
                [
                    'success' => true,
                    'html' => $returnHTML,
                ]
            );
        }
    }

    public function get_member(Request $request){
        if($request->ajax())
        {
            $user_array = array();
            $project    = Project::find($request->project_id);

            if($project != null){
                foreach($project->users as $user){
                    $user_array[] = [
                        'key' => $user->id,
                        'label' => $user->name
                    ];
                }
            }

            $returnHTML = view('projects.get_member', compact('project'))->render();

            $total_data = array(
                $user_array,
                $returnHTML
            );

            return $total_data;

            return response()->json(
                [
                    'success' => true,
                    'html' => $returnHTML,
                ]
            );
        }
    }

    public function milestone($project_id)
    {
        if(\Auth::user()->can('create milestone'))
        {
            $project = Project::find($project_id);

            return view('projects.milestone', compact('project'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function milestoneStore(Request $request, $project_id)
    {
        if(\Auth::user()->can('create milestone'))
        {
            $project   = Project::find($project_id);
            $validator = Validator::make(
                $request->all(), [
                                    'title' => 'required',
                                    'status' => 'required',
                                    'cost' => 'required',
                                    'due_date' => 'required',
                                    'start_date'=>'required'
                               ]
            );

            if($validator->fails())
            {
                return redirect()->back()->with('error', Utility::errorFormat($validator->getMessageBag()));
            }

            $milestone              = new Milestone();
            $milestone->project_id  = $project->id;
            $milestone->title       = $request->title;
            $milestone->status      = $request->status;
            $milestone->cost        = $request->cost;
            $milestone->start_date  = $request->start_date;
            $milestone->due_date    = $request->due_date;
            $milestone->description = $request->description;
            $milestone->save();

            ActivityLog::create(
                [
                    'user_id' => \Auth::user()->id,
                    'project_id' => $project->id,
                    'log_type' => 'Create Milestone',
                    'remark' => json_encode(['title' => $milestone->title]),
                ]
            );

            return redirect()->back()->with('success', __('Milestone successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function milestoneEdit($id)
    {
        if(\Auth::user()->can('edit milestone'))
        {
            $milestone = Milestone::find($id);

            return view('projects.milestoneEdit', compact('milestone'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function milestoneUpdate($id, Request $request)
    {
        if(\Auth::user()->can('edit milestone'))
        {
            $validator = Validator::make(
                $request->all(), [
                                    'title' => 'required',
                                    'status' => 'required',
                                    'cost' => 'required',
                                    'due_date' => 'required',
                                    'start_date'=>'required'
                            ]
            );

            if($validator->fails())
                {
                    return redirect()->back()->with('error', Utility::errorFormat($validator->getMessageBag()));
                }

            $milestone              = Milestone::find($id);
            $milestone->title       = $request->title;
            $milestone->status      = $request->status;
            $milestone->cost        = $request->cost;
            $milestone->progress    = $request->progress;
            $milestone->due_date    = $request->duedate;
            $milestone->start_date  = $request->start_date;
            $milestone->description = $request->description;
            $milestone->save();

            return redirect()->back()->with('success', __('Milestone updated successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function milestoneDestroy($id)
    {
        if(\Auth::user()->can('delete milestone'))
        {
            $milestone = Milestone::find($id);
            $milestone->delete();

            return redirect()->back()->with('success', __('Milestone successfully deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function milestoneShow($id)
    {
        if(\Auth::user()->can('view milestone'))
        {
            $milestone = Milestone::find($id);

            return view('projects.milestoneShow', compact('milestone'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function filterProjectView(Request $request)
    {

        if(\Auth::user()->can('manage project'))
        {
            $usr           = Auth::user();
            if(\Auth::user()->type == 'client'){
              $user_projects = Project::where('client_id',\Auth::user()->id)->where('created_by',\Auth::user()->creatorId())->pluck('id','id')->toArray();;
            }else{
              $user_projects = $usr->projects()->pluck('project_id', 'project_id')->toArray();
            }

                $sort     = explode('-', 'created_at-desc');
                $projects = Project::whereIn('id', array_keys($user_projects))->orderBy($sort[0], $sort[1]);

                if(!empty($request->keyword))
                {
                    $projects->where('project_name', 'LIKE', $request->keyword . '%')->orWhereRaw('FIND_IN_SET("' . $request->keyword . '",tags)');
                }
                if(!empty($request->status))
                {
                    $projects->whereIn('status', $request->status);
                }

                $projects   = $projects->get();
                return view('construction_project.construction_main',compact('projects', 'user_projects'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    // Project Gantt Chart
    public function gantt($projectID, $duration = 'Week')
    {
        if(\Auth::user()->can('view grant chart'))
        {
            $project = Project::find($projectID);
            $tasks   = [];

            if($project)
            {
                $setting  = Utility::settings(\Auth::user()->creatorId());
                if($setting['company_type']==2){
                    $project_holidays=Project_holiday::select('date')->where('project_id',$projectID)->get();
                    return view('construction_project.gantt', compact('project', 'tasks', 'duration','project_holidays'));
                    //return view('projects.congantt', compact('project', 'tasks', 'duration'));
                }else{
                    $tasksobj = $project->tasks;
                    foreach($tasksobj as $task)
                    {
                        $tmp                 = [];
                        $tmp['id']           = 'task_' . $task->id;
                        $tmp['name']         = $task->name;
                        $tmp['start']        = $task->start_date;
                        $tmp['end']          = $task->end_date;
                        $tmp['custom_class'] = (empty($task->priority_color) ? '#ecf0f1' : $task->priority_color);
                        $tmp['progress']     = str_replace('%', '', $task->taskProgress()['percentage']);
                        $tmp['extra']        = [
                            'priority' => ucfirst(__($task->priority)),
                            'comments' => count($task->comments),
                            'duration' => Utility::getDateFormated($task->start_date) . ' - ' . Utility::getDateFormated($task->end_date),
                        ];
                        $tasks[]             = $tmp;
                    }
                }

            }

            return view('projects.gantt', compact('project', 'tasks', 'duration'));
        }

        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function gantt_data($projectID, Request $request)
    {
        $project = Project::find($projectID);
        if($project){
            $instance_id=Session::get('project_instance');
            $task=Con_task::where('project_id',$projectID)->where('instance_id',$instance_id)->orderBy('created_at','ASC')->get();
            $link=Link::where('project_id',$projectID)->where('instance_id',$instance_id)->orderBy('created_at','ASC')->get();
            return response()->json([
                "data" => $task,
                "links" => $link,
            ]);
            // $project_data=json_decode($project->project_json);
            // if(isset($project_data->data)){
            //     return json_encode($project_data->data);
            // }else{
            //     $project=array();
            //     return json_encode($project);
            // }

        }else{

            return '';
        }


    }

    /**
     * Change a freezing status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function freeze_status_change(Request $request)
    {
        try {

                $data = array('freeze_status'=>1);

                Project::where('id',$request->project_id)->update($data);

                return redirect()->back()->with('success', __('Freezed Status successfully changed.'));


        } catch (Exception $e) {

                return $e->getMessage();

        }
    }
    /**
     * Get a freezing status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_freeze_status(Request $request){
        try {


                $result=Project::where('id',$request->project_id)->pluck('freeze_status')->first();
                return $result;



        } catch (Exception $e) {

                return $e->getMessage();

        }
    }

    public function ganttPost($projectID, Request $request)
    {
        $project = Project::find($projectID);

        if($project)
        {
            if(\Auth::user()->can('view project task'))
            {
                $id               = trim($request->task_id, 'task_');
                $task             = ProjectTask::find($id);
                $task->start_date = $request->start;
                $task->end_date   = $request->end;
                $task->save();

                return response()->json(
                    [
                        'is_success' => true,
                        'message' => __("Time Updated"),
                    ], 200
                );
            }
            else
           {
                return response()->json(
                    [
                        'is_success' => false,
                        'message' => __("You can't change Date!"),
                    ], 400
                );
            }
        }
        else
        {
            return response()->json(
                [
                    'is_success' => false,
                    'message' => __("Something is wrong."),
                ], 400
            );
        }
    }

    public function bug($project_id)
    {


        $user = Auth::user();
        if($user->can('manage bug report'))
        {
            $project = Project::find($project_id);

            if(!empty($project) && $project->created_by == Auth::user()->creatorId())
            {

                if($user->type != 'company')
                {
                    if(\Auth::user()->type == 'client'){
                      $bugs = Bug::where('project_id',$project->id)->get();
                    }else{
                      $bugs = Bug::where('project_id',$project->id)->whereRaw("find_in_set('" . $user->id . "',assign_to)")->get();
                    }
                }

                if($user->type == 'company')
                {
                    $bugs = Bug::where('project_id', '=', $project_id)->get();
                }

                return view('projects.bug', compact('project', 'bugs'));
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

    public function bugCreate($project_id)
    {
        if(\Auth::user()->can('create bug report'))
        {

            $priority     = Bug::$priority;
            $status       = BugStatus::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('title', 'id');
            $project_user = ProjectUser::where('project_id', $project_id)->get();


            $users        = [];
            foreach($project_user as $key=>$user)
            {

                $user_data = User::where('id',$user->user_id)->first();
                $key = $user->user_id;
                $user_name = !empty($user_data)? $user_data->name:'';
                $users[$key] = $user_name;
            }

            return view('projects.bugCreate', compact('status', 'project_id', 'priority', 'users'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }

    }

    function bugNumber()
    {
        $latest = Bug::where('created_by', '=', \Auth::user()->creatorId())->latest()->first();
        if(!$latest)
        {
            return 1;
        }

        return $latest->bug_id + 1;
    }

    public function bugStore(Request $request, $project_id)
    {
        if(\Auth::user()->can('create bug report'))
        {
            $validator = \Validator::make(
                $request->all(), [

                                   'title' => 'required',
                                   'priority' => 'required',
                                   'status' => 'required',
                                   'assign_to' => 'required',
                                   'start_date' => 'required',
                                   'due_date' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->route('task.bug', $project_id)->with('error', $messages->first());
            }

            $usr         = \Auth::user();
            $userProject = ProjectUser::where('project_id', '=', $project_id)->pluck('user_id')->toArray();
            $project     = Project::where('id', '=', $project_id)->first();

            $bug              = new Bug();
            $bug->bug_id      = $this->bugNumber();
            $bug->project_id  = $project_id;
            $bug->title       = $request->title;
            $bug->priority    = $request->priority;
            $bug->start_date  = $request->start_date;
            $bug->due_date    = $request->due_date;
            $bug->description = $request->description;
            $bug->status      = $request->status;
            $bug->assign_to   = $request->assign_to;
            $bug->created_by  = \Auth::user()->creatorId();
            $bug->save();

            ActivityLog::create(
                [
                    'user_id' => $usr->id,
                    'project_id' => $project_id,
                    'log_type' => 'Create Bug',
                    'remark' => json_encode(['title' => $bug->title]),
                ]
            );

            $projectArr = [
                'project_id' => $project_id,
                'name' => $project->name,
                'updated_by' => $usr->id,
            ];

            return redirect()->route('task.bug', $project_id)->with('success', __('Bug successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function bugEdit($project_id, $bug_id)
    {
        if(\Auth::user()->can('edit bug report'))
        {
            $bug          = Bug::find($bug_id);
            $priority     = Bug::$priority;
            $status       = BugStatus::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('title', 'id');
            $project_user = ProjectUser::where('project_id', $project_id)->get();
            $users        = array();
            foreach($project_user as $user)
            {
              $user_data = User::where('id',$user->user_id)->first();
              $key = $user->user_id;
              $user_name = !empty($user_data) ? $user_data->name:'';
              $users[$key] = $user_name;
            }

            return view('projects.bugEdit', compact('status', 'project_id', 'priority', 'users', 'bug'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }


    }

    public function bugUpdate(Request $request, $project_id, $bug_id)
    {


        if(\Auth::user()->can('edit bug report'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'title' => 'required',
                                   'priority' => 'required',
                                   'status' => 'required',
                                   'assign_to' => 'required',
                                   'start_date' => 'required',
                                   'due_date' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->route('task.bug', $project_id)->with('error', $messages->first());
            }
            $bug              = Bug::find($bug_id);
            $bug->title       = $request->title;
            $bug->priority    = $request->priority;
            $bug->start_date  = $request->start_date;
            $bug->due_date    = $request->due_date;
            $bug->description = $request->description;
            $bug->status      = $request->status;
            $bug->assign_to   = $request->assign_to;
            $bug->save();

            return redirect()->route('task.bug', $project_id)->with('success', __('Bug successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function bugDestroy($project_id, $bug_id)
    {


        if(\Auth::user()->can('delete bug report'))
        {
            $bug = Bug::find($bug_id);
            $bug->delete();

            return redirect()->route('task.bug', $project_id)->with('success', __('Bug successfully deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function bugKanban($project_id)
    {

        $user = Auth::user();
        if($user->can('move bug report'))
        {

            $project = Project::find($project_id);

            if(!empty($project) && $project->created_by == $user->creatorId())
            {
                if($user->type != 'company')
                {
                    $bugStatus = BugStatus::where('created_by', '=', Auth::user()->creatorId())->orderBy('order', 'ASC')->get();
                }

                if($user->type == 'company' || $user->type == 'client')
                {
                    $bugStatus = BugStatus::where('created_by', '=', Auth::user()->creatorId())->orderBy('order', 'ASC')->get();
                }

                return view('projects.bugKanban', compact('project', 'bugStatus'));
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

    public function bugKanbanOrder(Request $request)
    {
//        dd($request->all());
        if(\Auth::user()->can('move bug report'))
        {
            $post   = $request->all();
            $bug    = Bug::find($post['bug_id']);

            $status = BugStatus::find($post['status_id']);

            if(!empty($status))
            {
                $bug->status = $post['status_id'];
                $bug->save();
            }

            foreach($post['order'] as $key => $item)
            {
                if(!empty($item)){
                    $bug_order         = Bug::find($item);
                    $bug_order->order  = $key;
                    $bug_order->status = $post['status_id'];
                    $bug_order->save();
                }

            }

        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }


    }

    public function bugShow($project_id, $bug_id)
    {
        $bug = Bug::find($bug_id);

        return view('projects.bugShow', compact('bug'));
    }

    public function bugCommentStore(Request $request, $project_id, $bug_id)
    {

        $post               = [];
        $post['bug_id']     = $bug_id;
        $post['comment']    = $request->comment;
        $post['created_by'] = \Auth::user()->authId();
        $post['user_type']  = \Auth::user()->type;
        $comment            = BugComment::create($post);
        $comment->deleteUrl = route('bug.comment.destroy', [$comment->id]);

        return response()->json(
            [
                'is_success' => true,
                'message' => __("Bug comment successfully created."),
            ], 200
        );
    }

    public function bugCommentDestroy($comment_id)
    {
        $comment = BugComment::find($comment_id);
        $comment->delete();

        return "true";
    }

    public function bugCommentStoreFile(Request $request, $bug_id)
    {
        $request->validate(
            ['file' => 'required']
        );
        $fileName = $bug_id . time() . "_" . $request->file->getClientOriginalName();

        $request->file->storeAs('bugs', $fileName);
        $post['bug_id']     = $bug_id;
        $post['file']       = $fileName;
        $post['name']       = $request->file->getClientOriginalName();
        $post['extension']  = "." . $request->file->getClientOriginalExtension();
        $post['file_size']  = round(($request->file->getSize() / 1024) / 1024, 2) . ' MB';
        $post['created_by'] = \Auth::user()->authId();
        $post['user_type']  = \Auth::user()->type;

        $BugFile            = BugFile::create($post);
        $BugFile->deleteUrl = route('bug.comment.file.destroy', [$BugFile->id]);

        return $BugFile->toJson();
    }

    public function bugCommentDestroyFile(Request $request, $file_id)
    {
        $commentFile = BugFile::find($file_id);
        $path        = storage_path('bugs/' . $commentFile->file);
        if(file_exists($path))
        {
            \File::delete($path);
        }
        $commentFile->delete();

        return "true";
    }

    public function tracker($id)
    {
        $treckers=TimeTracker::where('project_id',$id)->get();
        return view('time_trackers.index',compact('treckers'));
    }

    public function getProjectChart($arrParam)
    {
        $arrDuration = [];
        if ($arrParam['duration'] && $arrParam['duration'] == 'week') {
            $previous_week = Utility::getFirstSeventhWeekDay(-1);
            foreach ($previous_week['datePeriod'] as $dateObject) {
                $arrDuration[$dateObject->format('Y-m-d')] = $dateObject->format('D');
            }
        }

        $arrTask = [
            'label' => [],
            'color' => [],
        ];
        $stages = TaskStage::where('created_by', '=', $arrParam['created_by'])->orderBy('order');

        foreach ($arrDuration as $date => $label) {
            $objProject = projectTask::select('stage_id', \DB::raw('count(*) as total'))->whereDate('updated_at', '=', $date)->groupBy('stage_id');

            if (isset($arrParam['project_id'])) {
                $objProject->where('project_id', '=', $arrParam['project_id']);
            }


            $data = $objProject->pluck('total', 'stage_id')->all();

            foreach ($stages->pluck('name', 'id')->toArray() as $id => $stage) {
                $arrTask[$id][] = isset($data[$id]) ? $data[$id] : 0;
            }
            $arrTask['label'][] = __($label);
        }
        $arrTask['stages'] = $stages->pluck('name', 'id')->toArray();

        return $arrTask;
    }


    public function taskupdate(Request $request)
    {
        $validator = \Validator::make(
            $request->all(), [
                'task_id' => 'required',
                'percentage' => 'required',
                'description' => 'required',
                'user_id' => 'required',
            ]
        );

        if($validator->fails())
        {
            return redirect()->back()->with('error', Utility::errorFormat($validator->getMessageBag()));
        }

        $task_id=$request->task_id;
        $task =Con_task::where('main_id',$task_id)->first();
        // $date1=date_create($task->start_date);
        // $date2=date_create($task->end_date);

        // $diff=date_diff($date1,$date2);
        // $no_working_days=$diff->format("%a");
        // $no_working_days=$no_working_days+1;// include the last day
        $no_working_days=$task->duration;

        // insert details
        $array=array(
            'task_id'=>$task_id,
            'percentage'=>$request->percentage,
            'description'=>$request->description,
            'user_id'=>$request->user_id,
            'project_id'=>$task->project_id,
            'created_at'=>$request->get_date,
            'record_date'=>date('Y-m-d H:m:s')
        );

        $check_data = Task_progress::where('task_id',$task_id)->where('project_id',$task->project_id)->whereDate('created_at',$request->get_date)->where('user_id',$request->user_id)->first();
        if($check_data == null){
            Task_progress::insert($array);
        }
        else{
            Task_progress::where('task_id',$task_id)->where('user_id',$request->user_id)->where('project_id',$task->project_id)->where('created_at',$request->get_date)->update($array);
        }

        $total_pecentage=Task_progress::where('task_id',$task_id)->sum('percentage');
        $per_percentage=$total_pecentage/$no_working_days;
        $per_percentage=round($per_percentage);
        Con_task::where('main_id',$task_id)->update(['progress'=>$per_percentage]);
        // update the  gantt
        $this->taskpersentage_update($task->project_id);

        return redirect()->back()->with('success', __('Task successfully Updated.'));

    }
    public function taskpersentage_update($project_id)
    {
        $alltask =Con_task::where('project_id',$project_id)->get();
        foreach ($alltask as $key => $value) {
                $task_id=$value->main_id;
                $total_percentage=Con_task::where('project_id',$project_id)->where('parent',$value->id)->avg('progress');
                $total_percentage=round($total_percentage);
                if($total_percentage!=NUll){
                    Con_task::where('main_id',$task_id)->update(['progress'=>$total_percentage]);
                }
        }

    }

}
