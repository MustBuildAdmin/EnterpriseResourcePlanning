<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Con_task;
use App\Models\Task_progress;
use App\Models\User;
use App\Models\Task;
use App\Models\Utility;
use App\Models\TaskFile;
use App\Models\Bug;
use App\Models\BugStatus;
use App\Models\TaskStage;
use App\Models\ActivityLog;
use App\Models\ProjectTask;
use App\Models\TaskComment;
use App\Models\TaskChecklist;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use DB;
use Session;

class ProjectTaskController extends Controller
{
    public function index($project_id)
    {

        $usr = \Auth::user();
        if(\Auth::user()->can('manage project task'))
        {
            $project = Project::find($project_id);
            $stages  = TaskStage::orderBy('order')->where('created_by',\Auth::user()->creatorId())->get();
            foreach($stages as $status)
            {
                $stageClass[] = 'task-list-' . $status->id;
                $task         = ProjectTask::where('project_id', '=', $project_id);
                // check project is shared or owner

                //end
                $task->orderBy('order');
                $status['tasks'] = $task->where('stage_id', '=', $status->id)->get();
            }

            return view('project_task.index', compact('stages', 'stageClass', 'project'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function create($project_id, $stage_id)
    {
        if(\Auth::user()->can('create project task'))
        {
            $project = Project::find($project_id);
            $hrs     = Project::projectHrs($project_id);

            return view('project_task.create', compact('project_id', 'stage_id', 'project', 'hrs'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function store(Request $request, $project_id, $stage_id)
    {

        if(\Auth::user()->can('create project task'))
        {
            $validator = Validator::make(
                $request->all(), [
                                'name' => 'required',
                                'estimated_hrs' => 'required',
                                'priority' => 'required',
                            ]
            );

            if($validator->fails())
            {
                return redirect()->back()->with('error', Utility::errorFormat($validator->getMessageBag()));
            }

            $usr        = Auth::user();
            $project    = Project::find($project_id);
            $last_stage = $project->first()->id;
            $post               = $request->all();
            $post['project_id'] = $project->id;
            $post['stage_id']   = $stage_id;
            $post['assign_to'] = $request->assign_to;
            $post['created_by'] = \Auth::user()->creatorId();
            $post['start_date']=date("Y-m-d H:i:s", strtotime($request->start_date));
            $post['end_date']=date("Y-m-d H:i:s", strtotime($request->end_date));
            if($stage_id == $last_stage)
            {
                $post['marked_at']   = date('Y-m-d');
            }
            $task = ProjectTask::create($post);

            //Make entry in activity log
            ActivityLog::create(
                [
                    'user_id' => $usr->id,
                    'project_id' => $project_id,
                    'task_id' => $task->id,
                    'log_type' => 'Create Task',
                    'remark' => json_encode(['title' => $task->name]),
                ]
            );


            //Slack Notification
            $setting  = Utility::settings(\Auth::user()->creatorId());
            $project_name = Project::find($project_id);
            $project = Project::where('id',$project_name->id)->first();
            if(isset($setting['task_notification']) && $setting['task_notification'] ==1){
                $msg = $task->name .__("of").' '.$project->project_name .__(" created by").' '.\Auth::user()->name.'.';
                Utility::send_slack_msg($msg);
            }

            //Telegram Notification
            $setting  = Utility::settings(\Auth::user()->creatorId());
            $project_name = Project::find($project_id);
            $project = Project::where('id',$project_name->id)->first();
            if(isset($setting['telegram_task_notification']) && $setting['telegram_task_notification'] ==1){
                $msg = $task->name .__("of").' '.$project->project_name .__(" created by").' '.\Auth::user()->name.'.';
                Utility::send_telegram_msg($msg);
            }
            return redirect()->back()->with('success', __('Task added successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    // For Taskboard View
    public function taskBoard($view, Request $request)
    {
        if(Session::has('project_id')){
            $project_id = Session::get('project_id');
        
            $user_id    = $request->users;
            $start_date = $request->start_date;
            $end_date   = $request->end_date;

            $setting  = Utility::settings(\Auth::user()->creatorId());

            $user_data =  User::select("users.name", "users.id")
                    ->leftjoin('project_users as project','project.user_id', '=', 'users.id')
                    ->where('project.project_id',$project_id)
                    ->groupBy('users.id')
                    ->get();
            $result=Project::where('id',$project_id)->pluck('freeze_status')->first();
            if($result==1){
                if($view == 'list'){
                    $tasks = ProjectTask::where('created_by',\Auth::user()->creatorId())->get();
                    return view('construction_project.taskboard', compact('view','tasks','project_id','user_id','start_date','end_date','setting','user_data'));
                }else{
                    $tasks = ProjectTask::where('created_by',\Auth::user()->creatorId())->get();
                    return view('project_task.grid', compact('tasks','view','project_id','user_id','start_date','end_date','setting'));
                }
            }else{
                return redirect()->back()->with('error', __('Project Not Freezed.'));
            }
        }else{
            return redirect()->route('construction_main')->with('error', __('Session Expired'));
        }

    }

    public function get_all_task(Request $request){
        $project_id     = Session::get('project_id');
        $get_start_date = $request->start_date;
        $get_end_date   = $request->end_date;
        $status_task    = $request->status_task;
       

        if($request->user_id != null){
            $json_user_id = json_decode($request->user_id);
        }
        else{
            $json_user_id = array();
        }

        // 1 > Today Task
        // 3 > Pending Task
        // 4 > Completed Task

        $usr = Auth::user();

        $setting  = Utility::settings(\Auth::user()->creatorId());
        if($setting['company_type']==2){
           
            $tasks = Con_task::select('con_tasks.text','con_tasks.users','con_tasks.duration',
                'con_tasks.progress','con_tasks.start_date','con_tasks.end_date','con_tasks.id',
                'con_tasks.instance_id','con_tasks.main_id','pros.project_name',
                'pros.id as project_id','pros.instance_id as pro_instance_id')
                ->join('projects as pros','pros.id','con_tasks.project_id')
                ->whereNotNull('pros.instance_id')
                ->where('project_id', $project_id)
                ->where('type','task');

            if(\Auth::user()->type != 'company'){
                $tasks->whereRaw("find_in_set('" . \Auth::user()->id . "',users)");
            }

            if(count($json_user_id) != 0 && $get_start_date != null && $get_end_date != null && $status_task != null){
                $tasks->where(function ($query) use ($json_user_id) {
                    foreach($json_user_id as $get_user_id){
                        if($get_user_id != ""){
                            $query->orwhereJsonContains('con_tasks.users', $get_user_id);
                        }
                    }
                });

                $tasks->where(function ($query) use ($get_start_date, $get_end_date) {
                    $query->whereDate('con_tasks.start_date', '>=', $get_start_date);
                    $query->whereDate('con_tasks.end_date', '<', $get_end_date);
                });

                if($status_task == "3"){
                    $tasks->where('progress','<','100');
                }
                elseif($status_task == "4"){
                    $tasks->where('progress','>=','100');
                }
            }
            elseif($get_start_date != null && $get_end_date != null && $status_task != null){
                $tasks->where(function ($query) use ($get_start_date, $get_end_date) {
                    $query->whereDate('con_tasks.start_date', '>=', $get_start_date);
                    $query->whereDate('con_tasks.end_date', '<', $get_end_date);
                });

                if($status_task == "3"){
                    $tasks->where('progress','<','100');
                }
                elseif($status_task == "4"){
                    $tasks->where('progress','>=','100');
                }
            }
            elseif(count($json_user_id) != 0 && $get_start_date != null && $get_end_date != null){
                $tasks->where(function ($query) use ($json_user_id) {
                    foreach($json_user_id as $get_user_id){
                        if($get_user_id != ""){
                            $query->orwhereJsonContains('con_tasks.users', $get_user_id);
                        }
                    }
                });

                $tasks->where(function ($query) use ($get_start_date, $get_end_date) {
                    $query->whereDate('con_tasks.start_date', '>=', $get_start_date);
                    $query->whereDate('con_tasks.end_date', '<', $get_end_date);
                });
            }
            elseif(count($json_user_id) != 0 && $get_end_date != null){
                $tasks->where(function ($query) use ($json_user_id) {
                    foreach($json_user_id as $get_user_id){
                        if($get_user_id != ""){
                            $query->orwhereJsonContains('con_tasks.users', $get_user_id);
                        }
                    }
                });

                $tasks->whereDate('con_tasks.end_date', "<=", $get_end_date);
            }
            elseif(count($json_user_id) != 0 && $status_task != null){
                $tasks->where(function ($query) use ($json_user_id) {
                    foreach($json_user_id as $get_user_id){
                        if($get_user_id != ""){
                            $query->orwhereJsonContains('con_tasks.users', $get_user_id);
                        }
                    }
                });
                
                if($status_task == "3"){
                    $tasks->where('project_id', $project_id)->where('progress','<','100');
                }
                elseif($status_task == "4"){
                    $tasks->where('project_id', $project_id)->where('progress','=>','100');
                }
            }
            elseif($get_start_date != null && $get_end_date != null){
                $tasks->where(function ($query) use ($get_start_date, $get_end_date) {
                    $query->whereDate('con_tasks.start_date', '>=', $get_start_date);
                    $query->whereDate('con_tasks.end_date', '<', $get_end_date);
                });
            }
            elseif($get_end_date != null && $status_task != null){
                $tasks->where(function ($query) use ($get_start_date, $get_end_date) {
                    $query->whereDate('con_tasks.end_date', '>=', $get_end_date);
                });

                if($status_task == "3"){
                    $tasks->where('progress','<','100');
                }
                elseif($status_task == "4"){
                    $tasks->where('progress','>=','100');
                }
            }
            elseif(count($json_user_id) != 0){
                $tasks->where(function ($query) use ($json_user_id) {
                    foreach($json_user_id as $get_user_id){
                        if($get_user_id != ""){
                            $query->orwhereJsonContains('con_tasks.users', $get_user_id);
                        }
                    }
                });
            }
            elseif($get_end_date != null){
                $tasks->whereDate('con_tasks.end_date', "<=", $get_end_date);
            }
            elseif($status_task == "3"){
                $tasks->where('progress','<','100')->whereDate('con_tasks.end_date', "<", date('Y-m-d'));
            }
            elseif($status_task == "4"){
                $tasks->where('progress','>=','100');
            }
            else{
                $tasks->where(function($query) {
                    $query->whereRaw('"'.date('Y-m-d').'"
                        between date(`con_tasks`.`start_date`) and date(`con_tasks`.`end_date`)')
                        ->orwhere('progress','<','100')
                        ->whereDate('con_tasks.end_date', "<", date('Y-m-d'));
                })
                ->orderBy('con_tasks.end_date','DESC');
            }

            $tasks = $tasks->get();

            $returnHTML = view('project_task_con.all_task_list', compact('tasks','get_end_date'))->render();

            return response()->json(
                [
                    'success' => true,
                    'all_task' => $returnHTML,
                ]
            );
        }
    }

    public function main_task_list(Request $request){
        if(Session::has('project_id')){
            $project_id = Session::get('project_id');
        }
        else{
            $project_id = 0;
        }
        $setting  = Utility::settings(\Auth::user()->creatorId());
        if($setting['company_type']==2){
            
            if(\Auth::user()->type != 'company'){
                $show_parent_task = Con_task::select('con_tasks.text','con_tasks.users','con_tasks.duration','con_tasks.progress','con_tasks.start_date','con_tasks.end_date','con_tasks.id',
                'con_tasks.instance_id','con_tasks.main_id','pro.project_name','pro.id as project_id','pro.instance_id as pro_instance_id')
                ->join('projects as pro', function($join) use($project_id) {
                    $join->on('pro.id', '=', 'con_tasks.project_id')
                    ->on('pro.instance_id', '=', 'con_tasks.instance_id')
                    ->where('pro.id', $project_id);
                })
                ->whereNotNull('pro.instance_id')
                ->whereIn('con_tasks.project_id', $project_id)
                ->whereRaw("find_in_set('" . \Auth::user()->id . "',con_tasks.users)")
                ->where('type','project')
                ->orwhereNull('type')
                ->orderBy('con_tasks.main_id','ASC')
                ->get();
            }
            else{
                $show_parent_task = Con_task::select('con_tasks.text','con_tasks.users','con_tasks.duration','con_tasks.progress','con_tasks.start_date','con_tasks.end_date','con_tasks.id',
                    'con_tasks.instance_id','con_tasks.main_id','pro.project_name','pro.id as project_id','pro.instance_id as pro_instance_id')
                    ->join('projects as pro', function($join) use($project_id) {
                        $join->on('pro.id', '=', 'con_tasks.project_id')
                        ->on('pro.instance_id', '=', 'con_tasks.instance_id')
                        ->where('pro.id', $project_id);
                    })
                    ->whereNotNull('pro.instance_id')
                    ->where('con_tasks.project_id', $project_id)
                    ->where('type','project')
                    ->orwhereNull('type')
                    ->orderBy('con_tasks.main_id','ASC')
                    ->get();
            }

            $returnHTML = view('project_task_con.main_task_list', compact('show_parent_task'))->render();

            return response()->json(
                [
                    'success' => true,
                    'main_task' => $returnHTML,
                ]
            );
        }
    }

    public function edit_assigned_to(Request $request){
        if(Session::has('project_id')){
            $project_id = Session::get('project_id');
        }
        else{
            $project_id = 0;
        }
        $task_main_id = $request->task_id;
        $con_task = $get_popup_data_con = Con_task::Select('con_tasks.*','projects.project_name','projects.description')
                    ->join('projects','projects.id','con_tasks.project_id')
                    ->where('main_id',$task_main_id)->first();
    
        $assigned_to =  User::select("users.name", "users.id")
            ->leftjoin('project_users as project','project.user_id', '=', 'users.id')
            ->where('project.project_id',$project_id)
            ->groupBy('users.id')
            ->get();

        $total_pecentage = Task_progress::where('task_id',$task_main_id)->sum('percentage');

        return view('project_task_con.edit_assigned_to', compact('task_main_id','con_task','assigned_to','total_pecentage'));
    }

    public function update_assigned_to(Request $request){
        $task_main_id = $request->task_main_id; 
        if($request->users != null){
            $assigned_to = json_encode($request->users);
        }
        else{
            $assigned_to = null;
        }
        DB::table('con_tasks')->where('main_id',$task_main_id)->update(['users'=>$assigned_to]);
        return redirect()->back()->with('success', __('Assigned To Updated.'));
    }

    // For Taskboard View
    public function allBugList($view)
    {
          $bugStatus = BugStatus::where('created_by',\Auth::user()->creatorId())->get();
          if(Auth::user()->type == 'company'){
            $bugs = Bug::where('created_by',\Auth::user()->creatorId())->get();
          }
          elseif(Auth::user()->type != 'company'){
            if(\Auth::user()->type == 'client'){
              $user_projects = Project::where('client_id',\Auth::user()->id)->pluck('id','id')->toArray();
              $bugs = Bug::whereIn('project_id', $user_projects)->where('created_by',\Auth::user()->creatorId())->get();
            }
            else{
              $bugs = Bug::where('created_by',\Auth::user()->creatorId())->whereRaw("find_in_set('" . \Auth::user()->id . "',assign_to)")->get();
            }
          }
          if($view == 'list'){
            return view('projects.allBugListView', compact('bugs','bugStatus','view'));
          }else{
            return view('projects.allBugGridView', compact('bugs','bugStatus','view'));
          }
          return redirect()->back()->with('error', __('Permission Denied.'));
    }


    // For Load Task using ajax
    public function taskboardView(Request $request)
    { 
        if(Session::has('project_id')){
            $project_id = Session::get('project_id');
        }
        else{
            $project_id = 0;
        }

        $usr = Auth::user();
        if(\Auth::user()->type == 'client'){
            $user_projects = Project::where('client_id',\Auth::user()->id)->pluck('id','id')->toArray();
        }elseif(\Auth::user()->type != 'client'){
            $user_projects = $usr->projects()->pluck('project_id','project_id')->toArray();
        }

        if($project_id != 0){
            $get_user_data =  User::select("users.name", "users.id")
                    ->leftjoin('project_users as project','project.user_id', '=', 'users.id')
                    ->where("project.project_id", $project_id)
                    ->groupBy('users.id')
                    ->get();
        }
        else{
            $get_user_data = array();
        }
       
        if($request->ajax() && $request->has('view') && $request->has('sort'))
        {
            $sort  = explode('-', $request->sort);
            
            $project_select = Project::whereIn('id',$user_projects)->orderBy('id','DESC')->get();
            
            $setting  = Utility::settings(\Auth::user()->creatorId());
            if($setting['company_type']==2){
                $get_start_date = $_GET["start_date"];
                $get_end_date   = $_GET["end_date"];

                if(\Auth::user()->type != 'company'){
                    // Construction User
                    $tasks = Con_task::select('con_tasks.text','con_tasks.users','con_tasks.duration','con_tasks.progress','con_tasks.start_date','con_tasks.end_date','con_tasks.id',
                    'con_tasks.instance_id','con_tasks.main_id','pro.project_name','pro.id as project_id','pro.instance_id as pro_instance_id')
                            ->join('projects as pro','pro.id','con_tasks.project_id')
                            ->whereNotNull('pro.instance_id')
                            ->whereRaw("find_in_set('" . \Auth::user()->id . "',users)");

                    if($project_id != 0 && $_GET['end_date'] != ""){
                        $tasks->where('project_id', $project_id)
                            ->where(function ($query) use ($get_start_date, $get_end_date) {
                                $query->whereDate('con_tasks.end_date', '>', $get_end_date);
                            });
                    }
                    else{
                        $tasks->whereRaw('"'.date('Y-m-d').'" between date(`con_tasks`.`start_date`) and date(`con_tasks`.`end_date`)')->where('con_tasks.project_id', $project_id)->orderBy('con_tasks.start_date','ASC');
                    }
                    
                    if(isset($_GET['task_types'])){
                        if($_GET['task_types'] != ""){
                            if($_GET['task_types'] == 2){ //Pending Task
                                $tasks->where('progress','<','100');
                            }
                            else if($_GET['task_types'] == 3){ //Completed Task
                                $tasks->where('progress','>=','100');
                            }
                        }
                    }

                    $show_parent_task = Con_task::select('con_tasks.text','con_tasks.users','con_tasks.duration','con_tasks.progress','con_tasks.start_date','con_tasks.end_date','con_tasks.id',
                    'con_tasks.instance_id','con_tasks.main_id','pro.project_name','pro.id as project_id','pro.instance_id as pro_instance_id')
                                        ->join('projects as pro', function($join) {
                                            $join->on('pro.id', '=', 'con_tasks.project_id')
                                            ->on('pro.instance_id', '=', 'con_tasks.instance_id');
                                        })
                                        ->whereNotNull('pro.instance_id')
                                        ->whereIn('con_tasks.project_id', $user_projects)
                                        ->whereRaw("find_in_set('" . \Auth::user()->id . "',users)")
                                        ->orderBy('main_id','DESC')
                                        ->get();
                        
                }
                else{
                    // Construction Company
                    $tasks = Con_task::select('con_tasks.text','con_tasks.users','con_tasks.duration','con_tasks.progress','con_tasks.start_date','con_tasks.end_date','con_tasks.id',
                    'con_tasks.instance_id','con_tasks.main_id','pro.project_name','pro.id as project_id','pro.instance_id as pro_instance_id')
                            ->join('projects as pro','pro.id','con_tasks.project_id')
                            ->whereNotNull('pro.instance_id');

                    if($project_id != 0 && $_GET['user_id'] != "" && $_GET['start_date'] != "" && $_GET['end_date'] != ""){
                        $tasks->where('project_id', $project_id)
                            ->whereRaw("find_in_set('" . $_GET['user_id'] . "',users)")
                            ->where(function ($query) use ($get_start_date, $get_end_date) {
                                $query->whereDate('con_tasks.start_date', '>=', $get_start_date);
                                $query->whereDate('con_tasks.end_date', '<', $get_end_date);
                            });
                    }
                    else if($project_id != 0 && $_GET['start_date'] != "" && $_GET['end_date'] != ""){
                        $tasks->where('project_id', $project_id)
                            ->where(function ($query) use ($get_start_date, $get_end_date) {
                                $query->whereDate('con_tasks.start_date', '>=', $get_start_date);
                                $query->whereDate('con_tasks.end_date', '<', $get_end_date);
                            });
                    }
                    else if($project_id != 0 && $_GET['end_date'] != ""){
                        $tasks->whereDate('con_tasks.end_date', ">", $_GET['end_date'])->where('con_tasks.project_id', $project_id);
                    }
                    else if($project_id != 0){
                        $tasks->whereRaw('"'.date('Y-m-d').'" between date(`con_tasks`.`start_date`) and date(`con_tasks`.`end_date`)')->where('con_tasks.project_id', $project_id)
                        ->orderBy('con_tasks.end_date','ASC');
                    }
                    else{
                        $tasks->whereRaw('"'.date('Y-m-d').'" between date(`con_tasks`.`start_date`) and date(`con_tasks`.`end_date`)')->where('con_tasks.project_id', $project_id)
                        ->orderBy('con_tasks.end_date','ASC');
                    }

                    if(isset($_GET['task_types'])){
                        if($_GET['task_types'] != ""){
                            if($_GET['task_types'] == 2){ //Pending Task
                                $tasks->where('con_tasks.progress','<','100');
                            }
                            else if($_GET['task_types'] == 3){ //Completed Task
                                $tasks->where('con_tasks.progress','>=','100');
                            }
                        }
                    }
                    
                    $show_parent_task = Con_task::select('con_tasks.text','con_tasks.users','con_tasks.duration','con_tasks.progress','con_tasks.start_date','con_tasks.end_date','con_tasks.id',
                    'con_tasks.instance_id','con_tasks.main_id','pro.project_name','pro.id as project_id','pro.instance_id as pro_instance_id')
                                        ->join('projects as pro', function($join) {
                                            $join->on('pro.id', '=', 'con_tasks.project_id')
                                            ->on('pro.instance_id', '=', 'con_tasks.instance_id');
                                        })
                                        ->whereNotNull('pro.instance_id')
                                        ->where('con_tasks.project_id', $project_id)
                                        ->orderBy('main_id','DESC')
                                        ->get();
                    
                }
                
                $tasks = $tasks->get();

                $returnHTML = view('project_task_con.' . $request->view, compact('tasks','project_select','get_user_data','show_parent_task'))->render();
            }
            else{
                $task = ProjectTask::whereIn('project_id', $user_projects)->get();
                $tasks = ProjectTask::whereIn('project_id', $user_projects)->orderBy($sort[0], $sort[1]);

                if(\Auth::user()->type == 'client'){
                    $tasks->where('created_by',\Auth::user()->creatorId());
                }
                else{
                    $tasks->whereRaw("find_in_set('" . $usr->id . "',assign_to)");
                }

                if(!empty($request->keyword))
                {
                    $tasks->where('name', 'LIKE', $request->keyword . '%');
                }

                if(!empty($request->status))
                {
                    $todaydate = date('Y-m-d');

                    // For Optimization
                    $status = $request->status;
                    foreach($status as $k => $v)
                    {
                        if($v == 'due_today' || $v == 'over_due' || $v == 'starred' || $v == 'see_my_tasks')
                        {
                            unset($status[$k]);
                        }
                    }
                    // end

                    if(count($status) > 0)
                    {
                        $tasks->whereIn('priority', $status);
                    }

                    if(in_array('see_my_tasks', $request->status))
                    {
                        $tasks->whereRaw("find_in_set('" . $usr->id . "',assign_to)");
                    }

                    if(in_array('due_today', $request->status))
                    {
                        $tasks->where('end_date', $todaydate);
                    }

                    if(in_array('over_due', $request->status))
                    {
                        $tasks->where('end_date', '<', $todaydate);
                    }

                    if(in_array('starred', $request->status))
                    {
                        $tasks->where('is_favourite', '=', 1);
                    }
                }

                $tasks = $tasks->get();

                $returnHTML = view('project_task.' . $request->view, compact('tasks'))->render();
            }

            return response()->json(
                [
                    'success' => true,
                    'html' => $returnHTML,
                ]
            );
        }
    }

    public function task_particular(Request $request){
        if($request['get_date'] == ""){
            $get_date = date('Y-m-d');
        }
        else{
            $get_date = $request['get_date'];
        }

        if(isset($request['task_id'])){
            $task_id      = $request['task_id'];
            $get_con_task = Con_task::where('main_id',$task_id)->first();
            $end_date     = $get_con_task->end_date != null ? explode(" ",$get_con_task->end_date) : array();

            $get_popup_data_con = Con_task::Select('con_tasks.*','projects.project_name','projects.description')->join('projects','projects.id','con_tasks.project_id')->where('main_id',$task_id)->first();

            if(\Auth::user()->type != 'company'){
                $get_task_progress = Task_progress::select('task_progress.*',\DB::raw('group_concat(file.filename) as filename'))
                    ->leftjoin("task_progress_file as file",\DB::raw("FIND_IN_SET(file.id,task_progress.file_id)"),">",\DB::raw("'0'"))
                    ->where('task_progress.task_id',$task_id)->where('user_id',\Auth::user()->id)
                    ->where('task_progress.project_id',$get_popup_data_con->project_id)
                    ->groupBy('task_progress.id')
                    ->get();
                
            }else{
                $get_task_progress = Task_progress::select('task_progress.*',\DB::raw('group_concat(file.filename) as filename'))
                    ->leftjoin("task_progress_file as file",\DB::raw("FIND_IN_SET(file.id,task_progress.file_id)"),">",\DB::raw("'0'"))
                    ->where('task_progress.task_id',$task_id)
                    ->where('task_progress.project_id',$get_popup_data_con->project_id)
                    ->groupBy('task_progress.id')
                    ->get();
            }

            $total_pecentage = Task_progress::where('task_id',$task_id)->sum('percentage');

            if(date('Y-m-d') >= $get_date){
                $get_popup_data = Task_progress::where('task_id',$task_id)->whereDate('created_at',$get_date)->select('percentage','description')->first();

                if($get_popup_data != null){
                    $data = array(
                        'percentage' => $get_popup_data->percentage,
                        'desc'       => $get_popup_data->description,
                        'get_date'   => $get_date,
                        'con_data'   => $get_popup_data_con,
                        'get_task_progress' => $get_task_progress
                    );
                }
                else{
                    $data = array(
                        'percentage' => "",
                        'desc'       => "",
                        'get_date'   => $get_date,
                        'con_data'   => $get_popup_data_con,
                        'get_task_progress' => $get_task_progress
                    );
                }
            }else{
                $data = array(
                    'percentage' => "",
                    'desc'       => "",
                    'get_date'   => $get_date,
                    'con_data'   => $get_popup_data_con,
                    'get_task_progress' => $get_task_progress
                );
            }
        }

        $total_count_of_task = Task_progress::where('task_id',$task_id)->get()->count();

        $remaining_working_days=Utility::remaining_duration_calculator($get_con_task->end_date,$get_con_task->project_id);
        $remaining_working_days=$remaining_working_days-1;// include the last day

        $completed_days=$get_con_task->duration-$remaining_working_days;
        // percentage calculator
        if($get_con_task->duration>0){
            $perday=100/$get_con_task->duration;
        }else{
            $perday=0;
        }

        $current_Planed_percentage=round($completed_days*$perday);
        if($current_Planed_percentage > 100){
            $current_Planed_percentage=100;
        }
        
        return view('construction_project.task_particular_list',compact('task_id','data','total_pecentage', 'current_Planed_percentage'));
    }

    public function add_particular_task(Request $request){
        $task_id      = $request->task_id;
        $get_date     = $request->get_date;
        $get_con_task = Con_task::where('main_id',$task_id)->first();
       
        $data = array(
            'get_date'   => $get_date,
            'con_data'   => $get_con_task
        );

        return view("construction_project.add_task_particular",compact("data", "task_id"));
    }

    public function edit_particular_task(Request $request){
        
        $task_progress_id = $request->task_progress_id;
        $task_id          = $request->task_id;
        $user_id          = \Auth::user()->id;
        $project_id       = Session::get('project_id');
        $task             = Con_task::where('main_id',$task_id)->first();
        $check_data       = Task_progress::select('task_progress.*',\DB::raw('group_concat(file.filename) as filename, group_concat(file.id) as file_id'))
                                ->leftjoin("task_progress_file as file",\DB::raw("FIND_IN_SET(file.id,task_progress.file_id)"),">",\DB::raw("'0'"))
                                ->where('task_progress.id',$task_progress_id)
                                ->where('task_progress.task_id',$task_id)
                                ->where('task_progress.project_id',$task->project_id)
                                ->groupBy('task_progress.id')
                                ->first();

        if($check_data != null){
            $data = [
                'get_date'    => date('Y-m-d',strtotime($check_data->created_at)),
                'percentage'  => $check_data->percentage,
                'description' => $check_data->description,
                'filename'    => $check_data->filename,
                'file_id'     => $check_data->file_id,
                'con_data'    => $task
            ];
        }
        else{
            $data = [
                'get_date'    => "",
                'percentage'  => "",
                'description' => "",
                'filename'    => "",
                'file_id'     => "",
                'con_data'    => $task
            ];
        }

        return view("construction_project.edit_task_particular",compact("data", "task_id"));
    }

    public function edit_task_progress(Request $request){
        $taskprogress_id = $request->taskprogress_id;
        $task_id    = $request->task_id;
        $get_date   = $request->get_date;
        $user_id    = \Auth::user()->id;
        $project_id = Session::get('project_id');
        $task       = Con_task::where('main_id',$task_id)->first();
        $check_data = Task_progress::where('id',$taskprogress_id)->where('task_id',$task_id)->where('project_id',$task->project_id)->where('user_id',$user_id)->first();

        if($check_data != null){
            $get_data = [
                'get_date'    => date('Y-m-d',strtotime($check_data->created_at)),
                'percentage'  => $check_data->percentage,
                'description' => $check_data->description,
                'filename'    => $check_data->filename,
            ];
        }
        else{
            $get_data = [
                'get_date'    => "",
                'percentage'  => "",
                'description' => "",
                'filename'    => "",
            ];
        }

        return $get_data;
    }

    public function taskboard_get(Request $request){
        try {

            $usr = Auth::user();
            $user_projects = $usr->projects()->pluck('project_id','project_id')->toArray();

            $project_id = $request->project_id;

            if($project_id != ""){
                $data =  User::select("users.name", "users.id")
                    ->leftjoin('project_users as project','project.user_id', '=', 'users.id')
                    ->where("project.project_id", $project_id)
                    ->groupBy('users.id')
                    ->get();
            }
            else{
                $data =  User::select("users.name", "users.id")
                    ->leftjoin('project_users as project','project.user_id', '=', 'users.id')
                    ->whereIn('project.project_id',$user_projects)
                    ->groupBy('users.id')
                    ->get();
            }

            $user=array();
            foreach ($data as $key => $value) {
                $user[]=array('id'=>$value->id,'name'=>$value->name);
            }
            return response()->json($user);
        }
        catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function taskboardEdit(Request $request){
        if($request['get_date'] == ""){
            $get_date = date('Y-m-d');
        }
        else{
            $get_date = $request['get_date'];
        }

        if(isset($request['task_id'])){
            $task_id = $request['task_id'];
            $get_con_task = Con_task::where('main_id',$task_id)->first();
            $end_date = $get_con_task->end_date != null ? explode(" ",$get_con_task->end_date) : array();


            $get_popup_data_con = Con_task::where('main_id',$task_id)->first();

            if(date('Y-m-d') >= $get_date){
                //Previous
                $get_popup_data = Task_progress::where('task_id',$task_id)->whereDate('created_at',$get_date)->select('percentage','description')->first();

                if($get_popup_data != null){
                    $data = array(
                        'percentage' => $get_popup_data->percentage,
                        'desc'       => $get_popup_data->description,
                        'get_date'  => $get_date
                    );
                }
                else{
                    $data = array(
                        'percentage' => "",
                        'desc'       => "",
                        'get_date'  => $get_date
                    );
                }

            }else{
                //new
                $data = array(
                    'percentage' => "",
                    'desc'       => "",
                    'get_date'  => $get_date
                );
            }
        }

        return view('project_task_con.task_edit',compact('task_id','data'));
    }

    public function show($project_id, $task_id)
    {


        if(\Auth::user()->can('view project task'))
        {
            $allow_progress = Project::find($project_id)->task_progress;
            $task           = ProjectTask::find($task_id);

            return view('project_task.view', compact('task', 'allow_progress'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function edit($project_id, $task_id)
    {
        if(\Auth::user()->can('edit project task'))
        {
            $project = Project::find($project_id);
            $task    = ProjectTask::find($task_id);
            $hrs     = Project::projectHrs($project_id);

            return view('project_task.edit', compact('project', 'task', 'hrs'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function update(Request $request, $project_id, $task_id)
    {

        if(\Auth::user()->can('edit project task'))
        {
            $validator = Validator::make(
                $request->all(), [
                                'name' => 'required',
                                'estimated_hrs' => 'required',
                                'priority' => 'required',
                            ]
            );

            if($validator->fails())
            {
                return redirect()->back()->with('error', Utility::errorFormat($validator->getMessageBag()));
            }

            $post = $request->all();
            $task = ProjectTask::find($task_id);
            $task->update($post);

            return redirect()->back()->with('success', __('Task Updated successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function destroy($project_id, $task_id)
    {

        if(\Auth::user()->can('delete project task'))
        {
            ProjectTask::deleteTask([$task_id]);

            return redirect()->back()->with('success', __('Task Deleted successfully.'));

            echo json_encode(['task_id' => $task_id]);
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function getStageTasks(Request $request, $stage_id)
    {

        if(\Auth::user()->can('view project task'))
        {
            $count = ProjectTask::where('stage_id', $stage_id)->count();
            echo json_encode($count);
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function changeCom($projectID, $taskId)
    {

        if(\Auth::user()->can('view project task'))
        {
            $project = Project::find($projectID);
            $task    = ProjectTask::find($taskId);

            if($task->is_complete == 0)
            {
                $last_stage        = TaskStage::orderBy('order', 'DESC')->where('created_by',\Auth::user()->creatorId())->first();
                $task->is_complete = 1;
                $task->marked_at   = date('Y-m-d');
                $task->stage_id    = $last_stage->id;
            }
            else
            {
                $first_stage       = TaskStage::orderBy('order', 'ASC')->where('created_by',\Auth::user()->creatorId())->first();
                $task->is_complete = 0;
                $task->marked_at   = NULL;
                $task->stage_id    = $first_stage->id;
            }

            $task->save();

            return [
                'com' => $task->is_complete,
                'task' => $task->id,
                'stage' => $task->stage_id,
            ];
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function changeFav($projectID, $taskId)
    {
        if(\Auth::user()->can('view project task'))
        {
            $task = ProjectTask::find($taskId);
            if($task->is_favourite == 0)
            {
                $task->is_favourite = 1;
            }
            else
            {
                $task->is_favourite = 0;
            }

            $task->save();

            return [
                'fav' => $task->is_favourite,
            ];
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function changeProg(Request $request, $projectID, $taskId)
    {
        if(\Auth::user()->can('view project task'))
        {
            $task           = ProjectTask::find($taskId);
            $task->progress = $request->progress;
            $task->save();

            return ['task_id' => $taskId];
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function checklistStore(Request $request, $projectID, $taskID)
    {

        if(\Auth::user()->can('view project task'))
        {
            $request->validate(
                ['name' => 'required']
            );

            $post               = [];
            $post['name']       = $request->name;
            $post['task_id']    = $taskID;
            $post['user_type']  = 'User';
            $post['created_by'] = \Auth::user()->id;
            $post['status']     = 0;

            $checkList            = TaskChecklist::create($post);
            $user                 = $checkList->user;
            $checkList->updateUrl = route(
                'checklist.update', [
                                    $projectID,
                                    $checkList->id,
                                ]
            );
            $checkList->deleteUrl = route(
                'checklist.destroy', [
                                    $projectID,
                                    $checkList->id,
                                ]
            );

            return $checkList->toJson();
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function checklistUpdate($projectID, $checklistID)
    {

        if(\Auth::user()->can('view project task'))
        {
            $checkList = TaskChecklist::find($checklistID);
            if($checkList->status == 0)
            {
                $checkList->status = 1;
            }
            else
            {
                $checkList->status = 0;
            }
            $checkList->save();

            return $checkList->toJson();
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function checklistDestroy($projectID, $checklistID)
    {
        if(\Auth::user()->can('view project task'))
        {
            $checkList = TaskChecklist::find($checklistID);
            $checkList->delete();

            return "true";
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function commentStoreFile(Request $request, $projectID, $taskID)
    {


        if(\Auth::user()->can('view project task'))
        {
            $request->validate(
                ['file' => 'required']
            );
            $fileName = $taskID . time() . "_" . $request->file->getClientOriginalName();
            $request->file->storeAs('tasks', $fileName);
            $post['task_id']     = $taskID;
            $post['file']        = $fileName;
            $post['name']        = $request->file->getClientOriginalName();
            $post['extension']   = $request->file->getClientOriginalExtension();
            $post['file_size']   = round(($request->file->getSize() / 1024) / 1024, 2) . ' MB';
            $post['created_by']  = \Auth::user()->id;
            $post['user_type']   = 'User';
            $TaskFile            = TaskFile::create($post);
            $user                = $TaskFile->user;
            $TaskFile->deleteUrl = '';
            $TaskFile->deleteUrl = route(
                'comment.destroy.file', [
                                        $projectID,
                                        $taskID,
                                        $TaskFile->id,
                                    ]
            );

            return $TaskFile->toJson();
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function commentDestroyFile(Request $request, $projectID, $taskID, $fileID)
    {
        if(\Auth::user()->can('view project task'))
        {
            $commentFile = TaskFile::find($fileID);
            $path        = storage_path('tasks/' . $commentFile->file);
            if(file_exists($path))
            {
                \File::delete($path);
            }
            $commentFile->delete();

            return "true";
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function commentDestroy(Request $request, $projectID, $taskID, $commentID)
    {

        if(\Auth::user()->can('view project task'))
        {
            $comment = TaskComment::find($commentID);
            $comment->delete();

            return "true";
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function commentStore(Request $request, $projectID, $taskID)
    {

        if(\Auth::user()->can('view project task'))
        {
            $post               = [];
            $post['task_id']    = $taskID;
            $post['user_id']    = \Auth::user()->id;
            $post['comment']    = $request->comment;
            $post['created_by'] = \Auth::user()->creatorId();
            $post['user_type']  = \Auth::user()->type;

            $comment = TaskComment::create($post);
            $user    = $comment->user;
            $user_detail    = $comment->userdetail;

            $comment->deleteUrl = route(
                'comment.destroy', [
                                    $projectID,
                                    $taskID,
                                    $comment->id,
                                ]
            );

            //Slack Notification
            $setting  = Utility::settings(\Auth::user()->creatorId());
            $comments = ProjectTask::find($taskID);
            if(isset($setting['taskcomment_notification']) && $setting['taskcomment_notification'] ==1){
                $msg = __("New Comment added in").' '.$comments->name.'.';
                Utility::send_slack_msg($msg);
            }

            //Telegram Notification
            $setting  = Utility::settings(\Auth::user()->creatorId());
            $comments = ProjectTask::find($taskID);
            if(isset($setting['telegram_taskcomment_notification']) && $setting['telegram_taskcomment_notification'] ==1){
                $msg = __("New Comment added in").' '.$comments->name.'.';
                Utility::send_telegram_msg($msg);
            }
            $comment->current_time= $comment->created_at->diffForHumans();
            $comment->default_img= asset(\Storage::url("uploads/avatar/avatar.png"));
            return $comment->toJson();
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function updateTaskPriorityColor(Request $request)
    {
        if(\Auth::user()->can('view project task'))
        {
            $task_id = $request->input('task_id');
            $color   = $request->input('color');

            $task = ProjectTask::find($task_id);

            if($task && $color)
            {
                $task->priority_color = $color;
                $task->save();
            }
            echo json_encode(true);
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function taskOrderUpdate(Request $request, $project_id)
    {

        if(\Auth::user()->can('view project task'))
        {

            $user    = \Auth::user();
            $project = Project::find($project_id);
            // Save data as per order

            if(isset($request->sort))
            {
                foreach($request->sort as $index => $taskID)
                {
                    if(!empty($taskID))
                    {
                        echo $index . "-" . $taskID;
                        $task        = ProjectTask::find($taskID);

                        $task->order = $index;
                        $task->save();

                    }
                }
            }

            // Update Task Stage
            if($request->new_stage != $request->old_stage)
            {

                $new_stage  = TaskStage::find($request->new_stage);
                $old_stage  = TaskStage::find($request->old_stage);
                $last_stage = TaskStage::where('created_by',\Auth::user()->creatorId())->orderBy('order', 'DESC')->first();
                $last_stage = $last_stage->id;

                $task = ProjectTask::find($request->id);

                $task->stage_id = $request->new_stage;

                if($request->new_stage == $last_stage)
                {
                    $task->is_complete = 1;
                    $task->marked_at   = date('Y-m-d');
                }
                else
                {
                    $task->is_complete = 0;
                    $task->marked_at   = NULL;
                }
                $task->save();

                //Slack Notification
                $old_stage  = TaskStage::find($request->old_stage);
                $new_stage  = TaskStage::find($request->new_stage);
                $setting  = Utility::settings(\Auth::user()->creatorId());
                $task = ProjectTask::find($request->id);
                if(isset($setting['taskmove_notification']) && $setting['taskmove_notification'] ==1){
                    $msg = $task->name.' '. __("status changed from").' '. $old_stage->name .' '.__("to").' ' .$new_stage->name;
                    Utility::send_slack_msg($msg);
                }

                //Telegram Notification
                $old_stage  = TaskStage::find($request->old_stage);
                $new_stage  = TaskStage::find($request->new_stage);
                $setting  = Utility::settings(\Auth::user()->creatorId());
                $task = ProjectTask::find($request->id);
                if(isset($setting['telegram_taskmove_notification']) && $setting['telegram_taskmove_notification'] ==1){
                    $msg = $task->name.' '. __("status changed from").' '. $old_stage->name .' '.__("to").' ' .$new_stage->name;
                    Utility::send_telegram_msg($msg);
                }

                // Make Entry in activity log
                ActivityLog::create(
                    [
                        'user_id' => $user->id,
                        'project_id' => $project_id,
                        'task_id' => $request->id,
                        'log_type' => 'Move Task',
                        'remark' => json_encode(
                            [
                                'title' => $task->name,
                                'old_stage' => $old_stage->name,
                                'new_stage' => $new_stage->name,
                            ]
                        ),
                    ]

                );




                return $task->toJson();
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function taskGet($task_id)
    {
        if(\Auth::user()->can('view project task'))
        {
            $task        = ProjectTask::find($task_id);

            $html = '';
            $html .= '<div class="card-body"><div class="row align-items-center mb-2">';
            $html .= '<div class="col-6">';
            $html .= '<span class="badge badge-pill badge-xs badge-' . ProjectTask::$priority_color[$task->priority] . '">' . ProjectTask::$priority[$task->priority] . '</span>';
            $html .= '</div>';
            $html .= '<div class="col-6 text-end">';
            if(str_replace('%', '', $task->taskProgress()['percentage']) > 0)
            {
                $html .= '<span class="text-sm">' . $task->taskProgress()['percentage'] . '</span>';
            }
            if(\Auth::user()->can('view project task') || \Auth::user()->can('edit project task') || \Auth::user()->can('delete project task'))
            {
                $html .= '<div class="dropdown action-item">
                                                            <a href="#" class="action-item" data-toggle="dropdown"><i class="ti ti-ellipsis-h"></i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">';
                if(\Auth::user()->can('view project task'))
                {
                    $html .= '<a href="#" data-url="' . route(
                            'projects.tasks.show', [
                                                    $task->project_id,
                                                    $task->id,
                                                ]
                        ) . '" data-ajax-popup="true" class="dropdown-item">' . __('View') . '</a>';
                }
                if(\Auth::user()->can('edit project task'))
                {
                    $html .= '<a href="#" data-url="' . route(
                            "projects.tasks.edit", [
                                                    $task->project_id,
                                                    $task->id,
                                                ]
                        ) . '" data-ajax-popup="true" data-size="lg" data-title="' . __("Edit ") . $task->name . '" class="dropdown-item">' . __('Edit') . '</a>';
                }
                if(\Auth::user()->can('delete project task'))
                {
                    $html .= '<a href="#" class="dropdown-item del_task" data-url="' . route(
                            'projects.tasks.destroy', [
                                                        $task->project_id,
                                                        $task->id,
                                                    ]
                        ) . '">' . __('Delete') . '</a>';
                }
                $html .= '                                 </div>
                                                        </div>
                                                    </div>';
                $html .= '</div>';
            }
            $html .= '<a class="h6" href="#" data-url="' . route(
                    "projects.tasks.show", [
                                            $task->project_id,
                                            $task->id,
                                        ]
                ) . '" data-ajax-popup="true">' . $task->name . '</a>';
            $html .= '<div class="row align-items-center">';
            $html .= '<div class="col-12">';
            $html .= '<div class="actions d-inline-block">';
            if(count($task->taskFiles) > 0)
            {
                $html .= '<div class="action-item mr-2"><i class="ti ti-paperclip mr-2"></i>' . count($task->taskFiles) . '</div>';
            }
            if(count($task->comments) > 0)
            {
                $html .= '<div class="action-item mr-2"><i class="ti ti-brand-hipchart mr-2"></i>' . count($task->comments) . '</div>';
            }
            if($task->checklist->count() > 0)
            {
                $html .= '<div class="action-item mr-2"><i class="ti ti-tasks mr-2"></i>' . $task->countTaskChecklist() . '</div>';
            }
            $html .= '</div>';
            $html .= '</div>';
            $html .= '<div class="col-5">';
            if(!empty($task->end_date) && $task->end_date != '0000-00-00')
            {
                $clr  = (strtotime($task->end_date) < time()) ? 'text-danger' : '';
                $html .= '<small class="' . $clr . '">' . date("d M Y", strtotime($task->end_date)) . '</small>';
            }
            $html .= '</div>';
            $html .= '<div class="col-7 text-end">';

            if($users = $task->users())
            {
                $html .= '<div class="avatar-group">';
                foreach($users as $key => $user)
                {
                    if($key < 3)
                    {
                        $html .= ' <a href="#" class="avatar rounded-circle avatar-sm">';
                        $html .= '<img class="hweb" src="' . $user->getImgImageAttribute() . '" title="' . $user->name . '">';
                        $html .= '</a>';
                    }
                }

                if(count($users) > 3)
                {
                    $html .= '<a href="#" class="avatar rounded-circle avatar-sm"><img avatar="';
                    $html .= count($users) - 3;
                    $html .= '"></a>';
                }
                $html .= '</div>';
            }
            $html .= '</div></div></div>';

            print_r($html);
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function getDefaultTaskInfo(Request $request, $task_id)
    {
        if(\Auth::user()->can('view project task'))
        {
            $response = [];
            $task     = ProjectTask::find($task_id);
            if($task)
            {
                $response['task_name']     = $task->name;
                $response['task_due_date'] = $task->due_date;
            }

            return json_encode($response);
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
    // Calendar View
    public function calendarView($task_by, $project_id = NULL)
    {
        $usr = Auth::user();
        $transdate = date('Y-m-d', time());

        if($usr->type != 'admin')
        {
            if(\Auth::user()->type == 'client'){
              $user_projects = Project::where('client_id',\Auth::user()->id)->pluck('id','id')->toArray();
            }else{
              $user_projects = $usr->projects()->pluck('project_id','project_id')->toArray();
            }
            $user_projects = (!empty($project_id) && $project_id > 0) ? [$project_id] : $user_projects;
            if(\Auth::user()->type == 'company'){
              $tasks = ProjectTask::whereIn('project_id', $user_projects);
            }
            elseif(\Auth::user()->type != 'company'){
              if(\Auth::user()->type == 'client'){
                $tasks = ProjectTask::whereIn('project_id', $user_projects);
              }
              else{
                $tasks = ProjectTask::whereIn('project_id', $user_projects)->whereRaw("find_in_set('" . \Auth::user()->id . "',assign_to)");
              }
            }
            if(\Auth::user()->type  == 'client'){
              if($task_by == 'all')
              {
                  $tasks->where('created_by',\Auth::user()->creatorId());
              }
            }
            else{
              if($task_by == 'my')
              {
                  $tasks->whereRaw("find_in_set('" . $usr->id . "',assign_to)");
              }
            }
            $tasks    = $tasks->get();
            $arrTasks = [];

            foreach($tasks as $task)
            {
                $arTasks = [];
                if((!empty($task->start_date) && $task->start_date != '0000-00-00') || !empty($task->end_date) && $task->end_date != '0000-00-00')
                {
                    $arTasks['id']    = $task->id;
                    $arTasks['title'] = $task->name;

                    if(!empty($task->start_date) && $task->start_date != '0000-00-00')
                    {
                        $arTasks['start'] = $task->start_date;
                    }
                    elseif(!empty($task->end_date) && $task->end_date != '0000-00-00')
                    {
                        $arTasks['start'] = $task->end_date;
                    }

                    if(!empty($task->end_date) && $task->end_date != '0000-00-00')
                    {
                        $arTasks['end'] = $task->end_date;
                    }
                    elseif(!empty($task->start_date) && $task->start_date != '0000-00-00')
                    {
                        $arTasks['end'] = $task->start_date;
                    }

                    $arTasks['allDay']      = !0;
                    $arTasks['className']   = 'event-' . ProjectTask::$priority_color[$task->priority];
                    $arTasks['description'] = $task->description;
                    $arTasks['url']         = route('task.calendar.show', $task->id);
                    $arTasks['resize_url']  = route('task.calendar.drag', $task->id);

                    $arrTasks[] = $arTasks;


                }
            }

            return view('tasks.calendar', compact('arrTasks', 'project_id', 'task_by','transdate'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function new_calendar_view($task_by, $project_id = NULL)
    {

      try {

        $usr = Auth::user();
        $transdate = date('Y-m-d', time());

        if($usr->type != 'admin')
        {
            if(\Auth::user()->type == 'client'){
              $user_projects = Project::where('client_id',\Auth::user()->id)->pluck('id','id')->toArray();
            }else{
              $user_projects = $usr->projects()->pluck('project_id','project_id')->toArray();
            }

            $con_task=Con_task::whereIn('project_id',$user_projects)->get();

            return view('construction_project.task_calendar', compact('project_id','con_task','transdate'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }


      } catch (Exception $e) {

        return $e->getMessage();

      }

    }


    // Calendar Show
    public function calendarShow($id)
    {
        $task = ProjectTask::find($id);

        return view('tasks.calendar_show', compact('task'));
    }

    // Calendar Drag
    public function calendarDrag(Request $request, $id)
    {
        $task             = ProjectTask::find($id);
        $task->start_date = $request->start;
        $task->end_date   = $request->end;
        $task->save();
    }

    public function task_report(Request $request){
        try {

            $user = \Auth::user();

            $user_project_id=$request->id;

            // dd($request->all());
            $setting  = Utility::settings(\Auth::user()->creatorId());
            if($setting['company_type']==2){

                if(isset($_GET['project_list'])){
                    if($_GET['project_list'] != ""){
                        $get_user_data =  User::select("users.name", "users.id")
                                ->leftjoin('project_users as project','project.user_id', '=', 'users.id')
                                ->where("project.project_id", $_GET['project_list'])
                                ->groupBy('users.id')
                                ->get();
                    }
                    else{
                        $get_user_data = array();
                    }
                }else{
                    $get_user_data = array();
                }


                if(isset($_GET['all_users'])){
                    if($_GET['all_users'] != ""){
                        $get_user_id=$_GET['all_users'];
                        $get_all_user_data=Con_task::whereRaw("find_in_set('$get_user_id',users)")
                        ->where('project_id',$_GET['project_list'])
                        ->get();
                    }
                    else{
                        $get_all_user_data = array();
                    }
                }else{
                    $get_all_user_data = array();
                }

                if($user->type == 'client')
                {
                    $project_id=Project::where('client_id',$user->id)->pluck('id')->first();
                    $projects = Con_task::where('client_id', '=', $project_id);
                    $users=[];
                    $status=[];
                    $project_title=[];

                } elseif(\Auth::user()->type == 'company')
                {
                   if(isset($request->project_list)&& !empty($request->project_list)){
                        $projects = Con_task::select('con_tasks.*')
                            ->leftjoin('project_users', 'project_users.project_id', 'con_tasks.project_id')
                            ->where('con_tasks.project_id', '=', $request->project_list)
                            ->groupBy('con_tasks.id');

                        // $projects->whereIn('parent', function($query){
                        //     $query->select('main_id')
                        //     ->from('con_tasks');
                        // });
                        $projects->whereIn('main_id', function($query){
                            $query->select('task_id')
                            ->from('task_progress')
                            ->where('record_date','like',Carbon::now()->format('Y-m-d').'%');
                        });

                    }else{
                        $projects=Con_task::where('project_id',$request->id)->whereIn('main_id', function($query){
                            $query->select('task_id')
                            ->from('task_progress')
                            ->where('record_date','like',Carbon::now()->format('Y-m-d').'%');
                        });
                        // $projects = Con_task::where('con_tasks.project_id', '=', $request->id);
                    }

                    if(isset($request->all_users)&& !empty($request->all_users)){
                        $projects->whereRaw("find_in_set('$request->all_users',users)");
                    }

                    if(isset($request->start_date)&& !empty($request->start_date)){
                        $projects->where('con_tasks.start_date', '>=', $request->start_date);
                    }

                    if(isset($request->end_date)&& !empty($request->end_date)){
                        $projects->where('con_tasks.end_date', '<=', $request->end_date);
                    }
                    $projects = $projects->orderBy('id','desc')->get();

                    $users = User::where('created_by', '=', $user->creatorId())->where('type', '!=', 'client')->get();
                    $task_name = Con_task::select('main_id as id','text as name')->where('con_tasks.project_id', '=', $request->id)->get();
                    $status = Con_task::$priority;

                }
                else
                {
                    $projects = ProjectTask::select('project_tasks.*')->leftjoin('project_users', 'project_users.project_id', 'projects.id')
                    ->where('project_users.user_id', '=', $user->id);

                }
                $usr = Auth::user();
                $user_projects = $usr->projects()->pluck('project_id','project_id')->toArray();
                $project_title = Project::whereIn('id',$user_projects)->orderBy('id','DESC')->get();

                return view('project_report.view_task_report2', compact('projects','users','status','project_title','user_project_id','task_name','get_user_data','get_all_user_data'));

            }else{

                if(isset($_GET['project_list'])){
                    if($_GET['project_list'] != ""){
                        $get_user_data =  User::select("users.name", "users.id")
                                ->leftjoin('project_users as project','project.user_id', '=', 'users.id')
                                ->where("project.project_id", $_GET['project_list'])
                                ->groupBy('users.id')
                                ->get();
                    }
                    else{
                        $get_user_data = array();
                    }
                }else{
                    $get_user_data = array();
                }

                if(isset($_GET['all_users'])){

                    if($_GET['all_users'] != ""){
                        $get_user_id=$_GET['all_users'];
                        $get_all_user_data=ProjectTask::whereRaw("find_in_set('$get_user_id',project_tasks.assign_to)")
                        ->where('project_tasks.project_id',$_GET['project_list'])
                        ->where('project_tasks.id',$_GET['task_name'])
                        ->get();
                    }
                    else{
                        $get_all_user_data = array();
                    }
                }else{
                    $get_all_user_data = array();
                }

                if($user->type == 'client')
                {
                    $projects = ProjectTask::where('client_id', '=', $user->id);
                    $users=[];
                    $status=[];
                    $project_title=[];

                }
                elseif(\Auth::user()->type == 'company')
                {

                    if(isset($request->project_list)&& !empty($request->project_list)){
                        $projects = ProjectTask::select('project_tasks.*')
                            ->leftjoin('project_users', 'project_users.project_id', 'project_tasks.project_id')
                            ->where('project_tasks.project_id', '=', $request->project_list)
                            ->groupBy('project_tasks.id');

                    }else{

                        $projects = ProjectTask::where('project_tasks.created_by', '=', $user->id)->where('project_tasks.project_id', '=', $request->id);
                    }

                    if(isset($request->task_name)&& !empty($request->task_name)){
                        $projects->where('project_tasks.id', '=', $request->task_name);
                    }

                    if(isset($request->priority)&& !empty($request->priority)){
                        $projects->where('project_tasks.priority', '=', $request->priority);
                    }
                    if(isset($request->start_date)&& !empty($request->start_date)){
                        $projects->where('project_tasks.start_date', '>=', $request->start_date);

                    }
                    if(isset($request->end_date)&& !empty($request->end_date)){
                        $projects->where('project_tasks.end_date', '<=', $request->end_date);

                    }

                    $users = User::where('created_by', '=', $user->creatorId())->where('type', '!=', 'client')->get();
                    $task_name = ProjectTask::select('id','name')->where('project_tasks.project_id', '=', $request->id)->get();
                    $status = ProjectTask::$priority;


                }
                else
                {
                    $projects = ProjectTask::select('project_tasks.*')->leftjoin('project_users', 'project_users.project_id', 'projects.id')
                    ->where('project_users.user_id', '=', $user->id);


                }
                $projects = $projects->orderby('id','desc')->get();
                $usr = Auth::user();
                $user_projects = $usr->projects()->pluck('project_id','project_id')->toArray();
                $project_title = Project::whereIn('id',$user_projects)->orderBy('id','DESC')->get();

                return view('project_report.view_task_report2', compact('projects','users','status','project_title','user_project_id','task_name','get_user_data','get_all_user_data'));

            }


          } catch (Exception $e) {

              return $e->getMessage();

          }
    }
}
