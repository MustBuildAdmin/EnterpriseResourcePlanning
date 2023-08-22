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
use App\Models\GanttPlan;
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
use DateInterval;
use DateTime;
use DatePeriod;
use DB;
use App\Jobs\Projecttypetask;
use Mail;
use Carbon\CarbonPeriod;
use Config;

class ProjectController extends Controller
{
    public $permdin = 'Permission Denied.';
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
            return redirect()->back()->with('error', __($permdin));
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
            $users   = User::where('created_by', '=', \Auth::user()->creatorId())
            ->where('type', '!=', 'client')->get()->pluck('name', 'id');
            $clients = User::where('created_by', '=', \Auth::user()->creatorId())
            ->where('type', '=', 'client')->get()->pluck('name', 'id');
            $clients->prepend('Select Client', '');
            $repoter=User::where('created_by', '=', \Auth::user()->creatorId())
            ->where('type', '!=', 'client')->get()->pluck('name', 'id');
            $users->prepend('Select User', '');
            $country=Utility::getcountry();

            return view('projects.create', compact('clients','users','setting','repoter','country'));
        }
        else
        {
            return redirect()->back()->with('error', __($permdin));
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
                                'non_working_days'=>'required'
                                // 'status'=>'required'
                            ]
            );
            if($validator->fails())
            {
                return redirect()->back()->with('error', Utility::errorFormat($validator->getMessageBag()));
            }
            $project = new Project();
            $project->project_name = $request->project_name;
            $project->start_date = date("Y-m-d H:i:s", strtotime($request->start_date));
            $project->end_date = date("Y-m-d H:i:s", strtotime($request->end_date));
            if($request->hasFile('project_image'))
            {
                $filenameWithExt1 = $request->file("project_image")->getClientOriginalName();
                $filename1        = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                $extension1       = $request->file("project_image")->getClientOriginalExtension();
                $fileNameToStore1 = $filename1 . "_" . time() . "." . $extension1;

                $dir = Config::get('constants.Projects_image');

                $imagepath = $dir . $filenameWithExt1;
                if (\File::exists($imagepath)) {
                    \File::delete($imagepath);
                }
                $url = "";
                $path = Utility::upload_file($request,"project_image",$fileNameToStore1,$dir,[]);

                if ($path["flag"] == 1) {
                    $url = $path["url"];
                }

                $project->project_image = $url;
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
            $project->report_to = implode(',',$request->reportto);
            $project->report_time = $request->report_time;
            $project->tags = $request->tag;
            $project->estimated_days = $request->estimated_days;

            $project->created_by = \Auth::user()->creatorId();
            // instance creation------------------------
            $var=rand('100000','555555').date('dmyhisa').$request->client_id.$request->project_name;
            $instance_id=Hash::make($var);
            $project->instance_id=$instance_id;
            $project->country = $request->country;
            $project->state = $request->state;
            $project->city = $request->city;
            $project->zipcode = $request->zip;
            $project->latitude = $request->latitude;
            $project->longitude = $request->longitude;
            $project->status = "in_progress";
            ///---------end-----------------
            $project->save();

            if(isset($request->non_working_days)){
                $nonWorkingDaysInsert = array(
                    'project_id'       => $project->id,
                    'non_working_days' => implode(',',$request->non_working_days),
                    'instance_id'      => $instance_id,
                    'created_by'       => \Auth::user()->creatorId()
                );
                DB::table('non_working_days')->insert($nonWorkingDaysInsert);
            }

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
                        'created_by'=>\Auth::user()->creatorId(),
                        'instance_id'=>$instance_id
                    );
                    Project_holiday::insert($insert);
                }

                $holiday_date = $request->holiday_date;

                foreach($holiday_date as $holi_key => $holi_value){
                    $holidays_list = Holiday::where('created_by', '=', \Auth::user()->creatorId())
                    ->where('date',$holi_value)->first();
                    if($holidays_list == null){
                        $holiday_insert=array(
                            'project_id'=>$project->id,
                            'date'=>$holi_value,
                            'description'=>$request->holiday_description[$holi_key],
                            'created_by'=>\Auth::user()->creatorId(),
                            'instance_id'=>$instance_id
                        );

                        Project_holiday::insert($holiday_insert);
                    }
                    else{
                        if($holidays_list->date != $holi_value){
                            $holiday_insert=array(
                                'project_id'=>$project->id,
                                'date'=>$holi_value,
                                'description'=>$request->holiday_description[$holi_key],
                                'created_by'=>\Auth::user()->creatorId(),
                                'instance_id'=>$instance_id
                            );

                            Project_holiday::insert($holiday_insert);
                        }
                    }
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
                  CURLOPT_SSL_VERIFYPEER => false,
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
                            $task->duration=$value['duration']+1;
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
                        $old_predis=Con_task::where(['id'=>$value['target'],
                        'project_id'=>$project->id,
                        'instance_id'=>$instance_id])
                        ->pluck('predecessors')->first();
                        if($old_predis!=''){
                            $predis=$old_predis.','.$value['source'];
                            if($value['lag']!=0){
                                if (str_contains($value['lag'], '-')) {
                                    $predis=$predis.$value['lag'].' days';
                                } else {
                                    $predis=$predis.' +'.$value['lag'].' days';
                                }
                            }
                        }else{
                            $predis=$value['source'];
                            if($value['lag']!=0){
                                if (str_contains($value['lag'], '-')) {
                                    $predis=$predis.$value['lag'].' days';
                                } else {
                                    $predis=$predis.' +'.$value['lag'].' days';
                                }
                            }
                        }
                        Con_task::where(['id'=>$value['target'],'project_id'=>$project->id,'instance_id'=>$instance_id])
                        ->update(['predecessors'=>$predis]);
                        if(isset($value['type'])){
                            $link->type=$value['type'];
                        }
                        if(isset($value['source'])){

                            $link->source=$value['source'];
                        }
                        if(isset($value['lag'])){
                            $link->lag=$value['lag'];
                        }
                        if(isset($value['target'])){
                            $link->target=$value['target'];
                        }
                        $link->save();
                    }
                }

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
                      CURLOPT_SSL_VERIFYPEER => false,
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
                            $old_predis=Con_task::where(['id'=>$value['target'],'project_id'=>$project->id,'instance_id'=>$instance_id])->pluck('predecessors')->first();
                            if($old_predis!=''){
                                $predis=$old_predis.','.$value['source'];
                                if($value['lag']!=0){
                                    if (str_contains($value['lag'], '-')) {
                                        $predis=$predis.$value['lag'].' days';
                                    } else {
                                        $predis=$predis.' +'.$value['lag'].' days';
                                    }

                                }

                            }else{
                                $predis=$value['source'];
                                if($value['lag']!=0){
                                    if (str_contains($value['lag'], '-')) {
                                        $predis=$predis.$value['lag'].' days';
                                    } else {
                                        $predis=$predis.' +'.$value['lag'].' days';
                                    }
                                }
                            }
                            Con_task::where(['id'=>$value['target'],
                            'project_id'=>$project->id,
                            'instance_id'=>$instance_id])
                            ->update(['predecessors'=>$predis]);
                            $link->id=$value['id'];
                            if(isset($value['type'])){
                                $link->type=$value['type'];
                            }
                            if(isset($value['lag'])){
                                $link->type=$value['lag'];
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
               }

            }

            $get_project_name = $request->project_name;

            if(\Auth::user()->type=='company'){
                $get_user_id = Auth::user()->id;
                $receiver = Auth::user()->email;
            }else{
                $get_user_id = Auth::user()->creatorId();
                $get_email = DB::table('users')->where('id',Auth::user()->creatorId())->first();
                if($get_email != null){
                    $receiver = $get_email->email;
                }
                else{
                    $receiver = Auth::user()->email;
                }
            }

            $expires_at = date("Y-m-d H:i:s", strtotime("+30 minutes"));
            $settings   = Utility::settings();
            $sender     = $settings['company_email'] != "" ? $settings['company_email'] : "must-info@mustbuildapp.com";

            $boq_insert = array(
                'project_id'      => $project->id,
                'security_code'   => rand(10000000,99999999),
                'code_expires_at' => $expires_at,
                'user_id'         => $get_user_id,
                'sender'          => $sender,
                'receiver'        => 'must-info@mustbuildapp.com',
                'project_name'    => $request->project_name
            );

            DB::table('boq_email')->insert($boq_insert);

            Mail::send('projects.boq_email',$boq_insert, function($message) use($boq_insert) {
                $message->to($boq_insert['sender'])
                        ->subject($boq_insert['project_name']. " | BOQ File Upload")
                        ->from($boq_insert['receiver']);
            });

            if(\Auth::user()->type=='company'){

                ProjectUser::create(
                    [
                        'project_id' => $project->id,
                        'user_id' => Auth::user()->id,
                    ]
                );

                if($request->reportto){
                    foreach($request->reportto as $key => $value) {
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

                if($request->reportto){
                    foreach($request->reportto as $key => $value) {
                        ProjectUser::create(
                            [
                                'project_id' => $project->id,
                                'user_id' => $value,
                            ]
                        );
                    }
                }

            }
             // type project or task
            Projecttypetask::dispatch($project->id);
            // $project_task=Con_task::where('project_id',$project->id)->get();
            // foreach ($project_task as $key => $value) {
            //     $task = Con_task::where('main_id',$value->main_id);
            //     $check_parent=Con_task::where('project_id',$project->id)->where(['parent'=>$value->id])->first();
            //     if($check_parent){
            //         Con_task::where('main_id',$value->main_id)->update('type','project');
            //     }else{
            //         Con_task::where('main_id',$value->main_id)->update('type','task');
            //     }
            // }
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
                Session::put('project_id',$project->id);
                Session::put('project_instance',$project->instance_id);
                return redirect()->route('construction_main')->with('success', __('Project Add Successfully'));
            }

        }
        else
        {
            return redirect()->back()->with('error', __($permdin));
        }
    }

    public function boq_file(Request $request){
        $project_id = $request->project_id;

        $get_code = DB::table('boq_email')->where('project_id',$project_id)->where('status','1')->first();
        if($get_code != null){
            $verify_date = $get_code->code_expires_at;
            if($verify_date > date("Y-m-d H:i:s")){
                return view('projects.boq_index',compact('project_id'));
            }
            else{
                return redirect()->route('construction_main')->with('error', __('Email is Expired!'));
            }
        }
        else{
            return redirect()->route('construction_main')->with('error', __('Your Security Code was not found!'));
        }
    }

    public function boq_code_verify(Request $request){
        $project_id    = $request->project_id;
        $security_code = $request->security_code;

        $verify_code = DB::table('boq_email')->where('project_id',$project_id)
        ->where('security_code',$security_code)->where('status','1')->first();
        if($verify_code != null){
            return 1;
        }
        else{
            return 0;
        }
    }

    public function boq_file_upload(Request $request){
        $project_id       = $request->project_id;
        $fileNameToStore1 = '';
        $url              = '';

        if (!empty($request->boq_file)) {
            $filenameWithExt1 = $request->file("boq_file")->getClientOriginalName();
            $filename1        = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
            $extension1       = $request->file("boq_file")->getClientOriginalExtension();
            $fileNameToStore1 = $filename1 . "_" . time() . "." . $extension1;
            $dir              = "uploads/boq_file";
            $image_path       = $dir . $filenameWithExt1;

            if (\File::exists($image_path)) {
                \File::delete($image_path);
            }

            $url  = "";
            $path = Utility::upload_file($request,"boq_file",$fileNameToStore1,$dir,[]);

            if ($path["flag"] == 1) {
                $url = $path["url"];
            }
            else {
                return redirect()->route('construction_main')->with('error', __($path["msg"]));
            }
        }

        $save_data = [
            "boq_file_path" => $url,
            "boq_filename"  => $fileNameToStore1,
        ];

        Project::where('id',$project_id)->update($save_data);

        return redirect()->route('construction_main')->with('success', __('BOQ File Uploaded Successfully'));
    }

    public function checkDuplicateProject(Request $request){
        $form_name  = $request->form_name;
        $check_name = $request->project_name;

        if($form_name == "ProjectCreate"){
            $get_check_val = Project::where('project_name',$check_name)
            ->where('created_by',\Auth::user()->creatorId())->first();
        }
        else{
            $get_check_val = "Not Empty";
        }

        if($get_check_val == null){
            echo 'true';
            // return 1; //Success
        }
        else{
            echo 'false';
            // return 0; //Error
        }
    }



    public function loadproject(Project $project)
    {
        // Loading Project Function

    }
    public function instance_project($instance_id,$project_id){
        $getInstance=Instance::where(['id'=>$instance_id])->first();
        $instanceId=$getInstance->instance;
        Session::forget('project_id');
        Session::forget('project_instance');
        if(\Auth::user()->can('view project'))
        {
            Session::put('project_id',$project_id);
            Session::put('project_instance',$instanceId);
            
            $checkInstanceFreeze = Instance::where('project_id',$project_id)->orderBy('id','DESC')->first();
            Session::put('latest_project_instance',$checkInstanceFreeze->instance);

            if($checkInstanceFreeze->freeze_status == 1){
                Session::put('current_revision_freeze', 1); //Freezed
            }
            else{
                Session::put('current_revision_freeze', 0); //Not Freeze
            }

            $projectCheck = Con_task::where(['project_id'=>$project_id,'instance_id'=>$instanceId])->first();
            $project = Project::where(['id'=>$project_id])->first();
            if(isset($projectCheck)){
                $usr           = Auth::user();
                if(\Auth::user()->type == 'client'){
                $user_projects = Project::where('client_id',\Auth::user()->id)->pluck('id','id')->toArray();
                }else{
                $user_projects = $usr->projects->pluck('id')->toArray();
                }
                if(in_array($project_id, $user_projects))
                {
                    // end
                    $project_data = [];
                    // Task Count
                    $tasks = Con_task::where('project_id',$project_id)->where('instance_id',$instanceId)->get();
                    $project_task         = $tasks->count();
                    $completedTask = Con_task::where(['project_id'=>$project_id,
                    'instance_id'=>$instance_id])->where('progress',100)->get();

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
                    $total_day                = Carbon::parse($project->start_date)
                    ->diffInDays(Carbon::parse($project->end_date));
                    $remaining_day            = Carbon::parse($project->start_date)->diffInDays(now());
                    if($total_day<$remaining_day){
                        $remaining_day=$total_day;
                    }
                    $project_data['day_left'] = [
                        'day' => number_format($remaining_day) . '/' . number_format($total_day),
                        'percentage' => Utility::getPercentage($remaining_day, $total_day),
                    ];
                    // end Day left

                    // Open Task
                        $remaining_task = Con_task::where(['project_id'=> $project_id,'instance_id'=>$instance_id])
                        ->where('progress', '=', 100)->count();
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
                    $hrs = Project::projectHrs($project_id);
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
                            $task_cnt     = $project->tasks()->where('is_complete', '=', 1)
                            ->whereRaw("find_in_set('" . $usr->id . "',assign_to)")
                            ->where('marked_at', 'LIKE', $date)->count();
                            $arrTimesheet = $project->timesheets()->where('created_by', '=', $usr->id)
                            ->where('date', 'LIKE', $date)->pluck('time')->toArray();

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

                    $total_sub=Con_task::where(['project_id'=>$project_id,'instance_id'=>$instance_id])
                    ->where('type','task')->count();
                    $first_task=Con_task::where(['project_id'=>$project_id,'instance_id'=>$instance_id])
                    ->orderBy('id','ASC')->first();
                    if($first_task){
                        $workdone_percentage= $first_task->progress;
                        $actual_percentage= $first_task->progress;
                        $no_working_days=$first_task->duration;// include the last day
                        $date2=date_create($first_task->end_date);
                    }else{
                        $workdone_percentage= '0';
                        $actual_percentage= '0';
                        $no_working_days=$project->estimated_days;// include the last day
                        $date2=date_create($project->end_date);
                    }
                    if($actual_percentage > 100){
                        $actual_percentage=100;
                    }
                    if($actual_percentage < 0){
                        $actual_percentage=0;
                    }
                    $cur= date('Y-m-d');
                    ############### END ##############################
                    ############### Remaining days ###################
                    $remaining_working_days=Utility::remaining_duration_calculator($date2,$project_id);
                    $remaining_working_days=$remaining_working_days-1;// include the last day
                    ############### Remaining days ##################
                    $completed_days=$no_working_days-$remaining_working_days;
                    // percentage calculator
                    if($no_working_days>0){
                        $perday=100/$no_working_days;
                    }else{
                        $perday=0;
                    }
                    $current_Planed_percentage=round($completed_days*$perday);
                    if($current_Planed_percentage > 100){
                        $current_Planed_percentage=100;
                    }
                    if($current_Planed_percentage <0){
                        $current_Planed_percentage=0;
                    }
                    if($current_Planed_percentage>0){
                        $workdone_percentage=$workdone_percentage=$workdone_percentage/$current_Planed_percentage;
                    }else{
                        $workdone_percentage=0;
                    }
                    round(100-$current_Planed_percentage);
                    $project_task=Con_task::where('con_tasks.project_id',Session::get('project_id'))
                    ->where('con_tasks.instance_id',Session::get('project_instance'))
                    ->where('con_tasks.type','task')->where('con_tasks.start_date','like',$cur.'%')->get();
                    $not_started=0;
                    foreach ($project_task as $value) {
                        $result=Task_progress::where('task_id',$value->main_id)->first();
                        if(!$result){
                            $not_started=$not_started+1;
                        }
                    }
                    if($remaining_working_days<0){
                        $remaining_working_days=0;
                    }
                    $notfinished=Con_task::where('project_id',$project_id)
                    ->where('instance_id',Session::get('project_instance'))->where('type','task')
                    ->where('end_date','<',$cur)->where('progress','!=','100')->count();
                    $completed_task=Con_task::where('project_id',$project_id)
                    ->where('instance_id',Session::get('project_instance'))->where('type','task')
                    ->where('end_date','<',$cur)->where('progress','100')->count();

                    $ongoing_task=Con_task::where('project_id',$project_id)
                    ->where('instance_id',Session::get('project_instance'))
                    ->where('type','task')->where('progress','<',100)->where('progress','>',0)->count();

                    return view('construction_project.dashboard',
                    compact('project','ongoing_task','project_data','total_sub','actual_percentage',
                    'workdone_percentage','current_Planed_percentage','not_started','notfinished',
                    'remaining_working_days','completed_task'));
                }
                else
                {
                    return redirect()->back()->with('error', __($permdin));
                }
            }else{
                return redirect()->back()->with('error', __($permdin));
            }
        }
        else
        {
            return redirect()->back()->with('error', __($permdin));
        }
    }
    public function check_instance($id){
        $get_project_instances=Instance::where('project_id',$id)->get();
        return view('construction_project.instance_view', compact('get_project_instances'));
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Poject  $poject
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        Session::forget('project_id');
        Session::forget('project_instance');
        if(\Auth::user()->can('view project'))
        {
            Session::put('project_id',$project->id);
            
            Session::put('project_instance',$project->instance_id);

            $usr           = Auth::user();
            if(\Auth::user()->type == 'client'){
              $user_projects = Project::where('client_id',\Auth::user()->id)->pluck('id','id')->toArray();
            }else{
              $user_projects = $usr->projects->pluck('id')->toArray();
            }
            if(in_array($project->id, $user_projects))
            {
                // test the holidays
                    if($project->holidays==0){
                        $holidays=Project_holiday::where(['project_id'=>$project->id,
                        'instance_id'=>$project->instance_id])
                        ->first();
                        if(!$holidays){
                            return redirect()->back()->with('error', __('No holidays are listed.'));
                        }
                    }


                // end
                $project_data = [];
                // Task Count
                $tasks = Con_task::where('project_id',$project->id)->where('instance_id',$project->instance_id)->get();
                $project_task         = $tasks->count();
                $completedTask = Con_task::where('project_id',$project->id)->where('instance_id',$project->instance_id)
                ->where('progress',100)->get();

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
                $total_day = Carbon::parse($project->start_date)->diffInDays(Carbon::parse($project->end_date));
                $remaining_day = Carbon::parse($project->start_date)->diffInDays(now());
                if($total_day<$remaining_day){
                    $remaining_day=$total_day;
                }
                $project_data['day_left'] = [
                    'day' => number_format($remaining_day) . '/' . number_format($total_day),
                    'percentage' => Utility::getPercentage($remaining_day, $total_day),
                ];
                // end Day left

                // Open Task
                    $remaining_task = Con_task::where('project_id', '=', $project->id)
                    ->where('instance_id',$project->instance_id)
                    ->where('progress', '=', 100)->count();
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
                        $task_cnt     = $project->tasks()->where('is_complete', '=', 1)
                        ->whereRaw("find_in_set('" . $usr->id . "',assign_to)")
                        ->where('marked_at', 'LIKE', $date)->count();
                        $arrTimesheet = $project->timesheets()->where('created_by', '=', $usr->id)
                        ->where('date', 'LIKE', $date)->pluck('time')->toArray();

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

                $total_sub=Con_task::where('project_id',$project->id)->where('instance_id',$project->instance_id)
                ->where('type','task')->count();
                $first_task=Con_task::where('project_id',$project->id)->where('instance_id',$project->instance_id)
                ->orderBy('id','ASC')->first();
                if($first_task){
                    $workdone_percentage= $first_task->progress;
                    $actual_percentage= $first_task->progress;
                    $no_working_days=$first_task->duration;// include the last day
                    $date2=date_create($first_task->end_date);
                }else{
                    $workdone_percentage= '0';
                    $actual_percentage= '0';
                    $no_working_days=$project->estimated_days;// include the last day
                    $date2=date_create($project->end_date);
                }
                if($actual_percentage > 100){
                    $actual_percentage=100;
                }
                if($actual_percentage < 0){
                    $actual_percentage=0;
                }
                $cur= date('Y-m-d');
                ############### END ##############################
                ############### Remaining days ###################
                $remaining_working_days=Utility::remaining_duration_calculator($date2,$project->id);
                $remaining_working_days=$remaining_working_days-1;// include the last day
                ############### Remaining days ##################
                $completed_days=$no_working_days-$remaining_working_days;
                // percentage calculator
                if($no_working_days>0){
                    $perday=100/$no_working_days;
                }else{
                    $perday=0;
                }
                $current_Planed_percentage=round($completed_days*$perday);
                if($current_Planed_percentage > 100){
                    $current_Planed_percentage=100;
                }
                if($current_Planed_percentage <0){
                    $current_Planed_percentage=0;
                }
                if($current_Planed_percentage>0){
                    $workdone_percentage=$workdone_percentage=$workdone_percentage/$current_Planed_percentage;
                }else{
                    $workdone_percentage=0;
                }
                $workdone_percentage=$workdone_percentage*100;
                round(100-$current_Planed_percentage);
                $project_task=Con_task::where('con_tasks.project_id',Session::get('project_id'))
                ->where('con_tasks.instance_id',Session::get('project_instance'))->where('con_tasks.type','task')
                ->where('con_tasks.start_date','like',$cur.'%')->get();
                $not_started=0;
                foreach ($project_task as $value) {
                    $result=Task_progress::where('task_id',$value->main_id)->first();
                    if(!$result){
                        $not_started=$not_started+1;
                    }
                }
                if($remaining_working_days<0){
                    $remaining_working_days=0;
                }
                $notfinished=Con_task::where('project_id',$project->id)
                ->where('instance_id',Session::get('project_instance'))
                ->where('type','task')->where('end_date','<',$cur)->where('progress','!=','100')->count();
                $completed_task=Con_task::where('project_id',$project->id)
                ->where('instance_id',Session::get('project_instance'))
                ->where('type','task')->where('end_date','<',$cur)->where('progress','100')->count();

                $ongoing_task=Con_task::where('project_id',$project->id)
                ->where('instance_id',Session::get('project_instance'))
                ->where('type','task')->where('progress','<',100)->where('progress','>',0)->count();

                return view('construction_project.dashboard',compact('project','ongoing_task','project_data',
                'total_sub','actual_percentage','workdone_percentage','current_Planed_percentage',
                'not_started','notfinished','remaining_working_days','completed_task'));
            }
            else
            {
                return redirect()->back()->with('error', __($permdin));
            }
        }
        else
        {
            return redirect()->back()->with('error', __($permdin));
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
            $clients = User::where('created_by', '=', \Auth::user()->creatorId())
            ->where('type', '=', 'client')->get()->pluck('name', 'id');
            $users   = User::where('created_by', '=', \Auth::user()->creatorId())
            ->where('type', '!=', 'client')->get()->pluck('name', 'id');
            $users->prepend('Select User', '');
            $repoter=User::where('created_by', '=', \Auth::user()->creatorId())
            ->where('type', '!=', 'client')->get()->pluck('name', 'id');
            $project = Project::findOrfail($project->id);
            $setting  = Utility::settings(\Auth::user()->creatorId());
            $country  = Utility::getcountry();
            $project_holidays = Project_holiday::where(['project_id'=>$project->id,
            'instance_id'=>$project->instance_id])
            ->orderBy('date','ASC')->get();

            if($project->country != null){
                $statelist = Utility::getstate($project->country);
            }
            else{
                $statelist = array();
            }

            if($project->created_by == \Auth::user()->creatorId())
            {
                return view('projects.edit', compact('project', 'clients','users','repoter','setting',
                'country','statelist','project_holidays'));
            }
            else
            {
                return response()->json(['error' => __($permdin)], 401);
            }

        }
        else
        {
            return redirect()->back()->with('error', __($permdin));
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
                    if (\File::exists($project->project_image)) {
                        \File::delete($project->project_image);
                    }

                    $filenameWithExt1 = $request->file("project_image")->getClientOriginalName();
                    $filename1        = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                    $extension1       = $request->file("project_image")->getClientOriginalExtension();
                    $fileNameToStore1 = $filename1 . "_" . time() . "." . $extension1;
                    $dir              = Config::get('constants.Projects_image');
                    $url              = "";
                    $path             = Utility::upload_file($request,"project_image",$fileNameToStore1,$dir,[]);
    
                    if ($path["flag"] == 1) {
                        $url = $path["url"];
                    }
    
                    $project->project_image = $url;
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
                $project->estimated_days = $request->estimated_days;
                $project->report_to = implode(',',$request->reportto);
                $project->report_time=$request->report_time;
                $project->tags = $request->tag;
                $project->country = $request->country;
                $project->state = $request->state;
                $project->city = $request->city;
                $project->zipcode = $request->zip;
                $project->latitude = $request->latitude;
                $project->longitude = $request->longitude;
                $project->save();

                if(isset($request->non_working_days)){
                    $checkNonWorkingDay = DB::table('non_working_days')
                        ->where('project_id',$project->id)
                        ->where('instance_id',$project->instance_id)
                        ->first();

                    if($checkNonWorkingDay == null){
                        $nonWorkingDaysInsert = array(
                            'project_id'       => $project->id,
                            'non_working_days' => implode(',',$request->non_working_days),
                            'instance_id'      => $project->instance_id,
                            'created_by'       => \Auth::user()->creatorId()
                        );
                        DB::table('non_working_days')->insert($nonWorkingDaysInsert);
                    }
                    else{
                        $nonWorkingDaysUpdate = array(
                            'project_id'       => $project->id,
                            'non_working_days' => implode(',',$request->non_working_days),
                            'created_by'       => \Auth::user()->creatorId()
                        );
                        DB::table('non_working_days')
                            ->where('project_id',$project->id)
                            ->where('instance_id',$project->instance_id)
                            ->update($nonWorkingDaysUpdate);
                    }
                }

                if($project->holidays==0){
                    $holiday_date = $request->holiday_date;

                    foreach ($holiday_date as $holi_key => $holi_value) {
                        Holiday::where('created_by', '=', \Auth::user()->creatorId())
                        ->where('date',$holi_value)->first();
                        $project_holidays_list = Project_holiday::
                        where(['project_id'=>$project->id,'instance_id'=>$project->instance_id])
                        ->where('date',$holi_value)->first();
                        if($project_holidays_list == null){
                            $insert = array(
                                'project_id'=>$project->id,
                                'date'=>$holi_value,
                                'description'=>$request->holiday_description[$holi_key],
                                'created_by'=>\Auth::user()->creatorId(),
                                'instance_id'=>$project->instance_id

                            );
                            Project_holiday::insert($insert);
                        }
                    }
                }

                return redirect()->route('construction_main')->with('success', __('Project Updated Successfully'));
        }
        else
        {
            return redirect()->back()->with('error', __($permdin));
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
           
            $projectID=$project->id;
            $instance_id=$project->instance_id;
            Con_task::where(['project_id'=>$projectID,'instance_id'=>$instance_id])->delete();
            Project_holiday::where(['project_id'=>$projectID,
            'instance_id'=>$project->instance_id])->delete();
            Instance::where('project_id',$projectID)->delete();

            if(!empty($project->image))
            {
                Utility::checkFileExistsnDelete([$project->project_image]);
            }
            $project->delete();
            return redirect()->back()->with('success', __('Project Successfully Deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __($permdin));
        }
    }

    public function inviteMemberView(Request $request, $project_id)
    {
        $project      = Project::find($project_id);

        $user_project = $project->users->pluck('id')->toArray();

        $user_contact = User::where('created_by', \Auth::user()->creatorId())
        ->where('type','!=','client')->whereNOTIn('id', $user_project)
        ->pluck('id')->toArray();
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
                return redirect()->back()->with('error', __($permdin));
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

                    if($user->type!='company' || $user->type!='admin')
                    {
                        $user_array[] = [
                            'key' => $user->id,
                            'label' => $user->name
                        ];
                    }
                }
            }
            Session::put('project_member',$user_array);
            $returnHTML = view('projects.get_member', compact('project'))->render();

            
            return  array(
                $user_array,
                $returnHTML
            );

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
            return redirect()->back()->with('error', __($permdin));
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
            return redirect()->back()->with('error', __($permdin));
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
            return redirect()->back()->with('error', __($permdin));
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
            return redirect()->back()->with('error', __($permdin));
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
            return redirect()->back()->with('error', __($permdin));
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
            return redirect()->back()->with('error', __($permdin));
        }
    }

    public function filterProjectView(Request $request)
    {

        if(\Auth::user()->can('manage project'))
        {
            $usr           = Auth::user();
            if(\Auth::user()->type == 'client'){
              $user_projects = Project::where('client_id',\Auth::user()->id)
              ->where('created_by',\Auth::user()->creatorId())
              ->pluck('id','id')->toArray();;
            }else{
              $user_projects = $usr->projects()->pluck('project_id', 'project_id')->toArray();
            }

                $sort     = explode('-', 'created_at-desc');
                $projects = Project::whereIn('id', array_keys($user_projects))->orderBy($sort[0], $sort[1]);

                if(!empty($request->keyword))
                {
                    $projects->where('project_name', 'LIKE', $request->keyword . '%')
                    ->orWhereRaw('FIND_IN_SET("' . $request->keyword . '",tags)');
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
            return redirect()->back()->with('error', __($permdin));
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
                    $project_holidays=Project_holiday::select('date')
                    ->where(['project_id'=>$projectID,'instance_id'=>$project->instance_id])->get();
                    return view('construction_project.gantt',
                    compact('project', 'tasks', 'duration','project_holidays'));
                }else{
                    $tasksobj = $project->tasks;
                    foreach($tasksobj as $task)
                    {
                        $tmp                 = [];
                        $tmp['id']           = 'task_' . $task->id;
                        $tmp['name']         = $task->name;
                        $tmp['start']        = $task->start_date;
                        $tmp['end']          = $task->end_date;
                        $tmp['type']          = $task->type;
                        $tmp['custom_class'] = (empty($task->priority_color) ? '#ecf0f1' : $task->priority_color);
                        $tmp['progress']     = str_replace('%', '', $task->taskProgress()['percentage']);
                        $tmp['extra']        = [
                            'priority' => ucfirst(__($task->priority)),
                            'comments' => count($task->comments),
                            'duration' => Utility::getDateFormated($task->start_date) . ' - ' .
                            Utility::getDateFormated($task->end_date),
                        ];
                        $tasks[]             = $tmp;
                    }
                }

            }

            return view('projects.gantt', compact('project', 'tasks', 'duration'));
        }

        else
        {
            return redirect()->back()->with('error', __($permdin));
        }
    }

    public function gantt_data($projectID, Request $request)
    {
        $project = Project::find($projectID);
        if($project){
            $instance_id=Session::get('project_instance');
            $task=Con_task::where('project_id',$projectID)->where('instance_id',$instance_id)->get();
            $link=Link::where('project_id',$projectID)->where('instance_id',$instance_id)->get();
            return response()->json([
                "data" => $task,
                "links" => $link,
            ]);
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
            $instanceId  = Session::get('project_instance');
            $conTask     = Con_task::where(['project_id'=>$request->project_id,'instance_id'=>$instanceId])
                                ->orderBy('id', 'ASC')->first();
            $data        = array(
                                'start_date'=>$conTask->start_date,
                                'end_date'=>$conTask->end_date,
                                'estimated_days'=>$conTask->duration
                            );
            $instanceData = array('freeze_status'=>1,'start_date'=>$conTask->start_date,'end_date'=>$conTask->end_date);

            $getPreviousInstance = Con_task::where('project_id',$request->project_id)
                                        ->where('instance_id','!=',$instanceId)->orderBy('id', 'Desc')->first();

            if($getPreviousInstance != null){
                $setPreviousInstance = $getPreviousInstance->instance_id;
                $getPreData = Con_task::where('project_id',$request->project_id)
                    ->where('instance_id',$setPreviousInstance)->get();
                foreach($getPreData as $insertPre){
                    Con_task::where([
                                'project_id'=>$request->project_id,
                                'instance_id'=>$instanceId,
                                'id'=>$insertPre->id
                            ])
                    ->update(['progress' => $insertPre->progress]);
                }
            }

            Project::where('id',$request->project_id)->update($data);
            Instance::where('project_id',$request->project_id)->where('instance',$instanceId)->update($instanceData);
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
    public function get_gantt_task_count(Request $request){
        
         $instance_id=Session::get('project_instance');
         $task=Con_task::where('project_id',$request->project_id)->where('instance_id',$instance_id)->get();
         return count($task);
       
    }
    public function get_freeze_status(Request $request){
        try {
                
            return Instance::where('project_id',$request->project_id)
                    ->where('instance',Session::get('project_instance'))->pluck('freeze_status')->first();

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
                      $bugs = Bug::where('project_id',$project->id)
                      ->whereRaw("find_in_set('" . $user->id . "',assign_to)")->get();
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
                return redirect()->back()->with('error', __($permdin));
            }
        }
        else
        {
            return redirect()->back()->with('error', __($permdin));
        }
    }

    public function bugCreate($project_id)
    {
        if(\Auth::user()->can('create bug report'))
        {

            $priority     = Bug::$priority;
            $status       = BugStatus::where('created_by', '=', \Auth::user()->creatorId())
            ->get()->pluck('title', 'id');
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
            return redirect()->back()->with('error', __($permdin));
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
            return redirect()->back()->with('error', __($permdin));
        }
    }

    public function bugEdit($project_id, $bug_id)
    {
        if(\Auth::user()->can('edit bug report'))
        {
            $bug          = Bug::find($bug_id);
            $priority     = Bug::$priority;
            $status       = BugStatus::where('created_by', '=', \Auth::user()->creatorId())
            ->get()->pluck('title', 'id');
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
            return redirect()->back()->with('error', __($permdin));
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
            return redirect()->back()->with('error', __($permdin));
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
            return redirect()->back()->with('error', __($permdin));
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
                    $bugStatus = BugStatus::where('created_by', '=', Auth::user()->creatorId())
                    ->orderBy('order', 'ASC')->get();
                }

                if($user->type == 'company' || $user->type == 'client')
                {
                    $bugStatus = BugStatus::where('created_by', '=', Auth::user()->creatorId())
                    ->orderBy('order', 'ASC')->get();
                }

                return view('projects.bugKanban', compact('project', 'bugStatus'));
            }
            else
            {
                return redirect()->back()->with('error', __($permdin));
            }
        }
        else
        {
            return redirect()->back()->with('error', __($permdin));
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
            return redirect()->back()->with('error',__($permdin));
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
            $objProject = projectTask::select('stage_id', \DB::raw('count(*) as total'))
            ->whereDate('updated_at', '=', $date)->groupBy('stage_id');

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
        

        $get_all_dates    = [];
        $fileNameToStore1 = '';
        $url              = '';
        $task_id          = $request->task_id;
        $task             = Con_task::where('main_id',$task_id)->first();
        $project_get     = Project::where('id',$task->project_id)->first();
        $get_non_work_day = [];

        if($project_get->non_working_days != null){
            $split_non_working = explode(',',$project_get->non_working_days);
            foreach($split_non_working as $non_working){
                if($non_working == 0){$get_non_work_day[]     = "Sunday";}
                elseif($non_working == 1){$get_non_work_day[] = "Monday";}
                elseif($non_working == 2){$get_non_work_day[] = "Tuesday";}
                elseif($non_working == 3){$get_non_work_day[] = "Wednesday";}
                elseif($non_working == 4){$get_non_work_day[] = "Thursday";}
                elseif($non_working == 5){$get_non_work_day[] = "Friday";}
                elseif($non_working == 6){$get_non_work_day[] = "Saturday";}
            }
        }

        $getCurrentDay = date('l', strtotime($request->get_date));

        if(\Auth::user()->type == 'company'){
            $get_holiday = Holiday::where('created_by',\Auth::user()->id)->get();
        }
        else{
            $get_holiday = Holiday::where('created_by',\Auth::user()->creatorId())->get();
        }

        foreach($get_holiday as $check_holiday){
            $get_all_dates[] = $this->getBetweenDates($check_holiday->date, $check_holiday->end_date);
        }

        $holiday_merge    = $this->array_flatten($get_all_dates);
        $date1            = date_create($task->start_date);
        $date2            = date_create($task->end_date);
        $diff             = date_diff($date1,$date2);
        $file_id_array    = array();

        $no_working_days  = $diff->format("%a");
        //$no_working_days  = $no_working_days+1; // include the last day
        $no_working_days=$task->duration;

        $checkPercentage = Task_progress::where('task_id',$task_id)
        ->where('project_id',$task->project_id)
        ->whereDate('created_at',$request->get_date)->first();
        $checkPercentageGet = isset($checkPercentage->percentage) ? $checkPercentage->percentage : 0;

        if(in_array($request->get_date,$holiday_merge)){
            return redirect()->back()->with('error', __($request->get_date.' You have chosen a non-working day; if you want to update the progress, please select a working day.'));
        }
        else if(in_array($getCurrentDay,$get_non_work_day)){
            return redirect()->back()->with('error', __('This day is a non-working day.'));
        }
        else if($checkPercentageGet > $request->percentage){
            return redirect()->back()->with('error', __('This percentage is too low compare to old percentage.'));
        }
        else{
            if($request->attachment_file_name != null){
                foreach($request->attachment_file_name as $file_req){

                    $filenameWithExt1 = $file_req->getClientOriginalName();
                    $filename1        = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                    $extension1       = $file_req->getClientOriginalExtension();
                    $fileNameToStore1 = $filename1 . "_" . time() . "." . $extension1;
                    $dir              = "uploads/task_particular_list/";
                    $image_path       = $dir . $filenameWithExt1;

                    if (\File::exists($image_path)) {
                        \File::delete($image_path);
                    }

                    $path = Utility::multi_upload_file($file_req,"file_req",$fileNameToStore1,$dir,[]);

                    if ($path["flag"] == 1) {
                        $url = $path["url"];

                        $file_insert = array(
                            'task_id'    => $task_id,
                            'project_id' => $task->project_id,
                            'filename'   => $fileNameToStore1,
                            'file_path'  => $url
                        );
                        $file_insert_id = DB::table('task_progress_file')->insertGetId($file_insert);
                        $file_id_array[] = $file_insert_id;
                    }
                    else {
                        return redirect()->back()->with("error", __($path["msg"]));
                    }
                }
                $implode_file_id = count($file_id_array) != 0 ? implode(',',$file_id_array) : 0;

                if($request->existing_file_id != ""){
                    $implode_file_id = $request->existing_file_id.','.$implode_file_id;
                }
            }
            else{
                $get_file_id = Task_progress::where('task_id',$task_id)
                ->where('project_id',$task->project_id)->whereDate('created_at',$request->get_date)->first();
                if($get_file_id != null){
                    $implode_file_id = $get_file_id->file_id;
                }
                else{
                    $implode_file_id = 0;
                }
            }

            $date_status = strtotime($task->end_date) > time() ? 'As Per Time' : 'Overdue';

            if(\Auth::user()->type == 'company'){
                $assign_to = $task->users != null ? $task->users : null;
            }
            else{
                $assign_to  = \Auth::user()->id;
            }

            // insert details
            $array = array(
                'task_id'     => $task_id,
                'assign_to'   => $assign_to,
                'percentage'  => $request->percentage,
                'description' => $request->description,
                'user_id'     => $request->user_id,
                'project_id'  => $task->project_id,
                'date_status' => $date_status,
                'file_id'     => $implode_file_id,
                'created_at'  => $request->get_date, //Planned Date
                'record_date' => date('Y-m-d H:m:s') //Actual Date
            );

            $check_data = Task_progress::where('task_id',$task_id)->where('project_id',$task->project_id)
            ->whereDate('created_at',$request->get_date)->first();
            if($check_data == null){
                Task_progress::insert($array);
            }
            else{
                Task_progress::where('task_id',$task_id)->where('project_id',$task->project_id)
                ->where('created_at',$request->get_date)->update($array);
            }

            $total_pecentage = Task_progress::where('task_id',$task_id)->sum('percentage');
            $per_percentage  = $total_pecentage/$no_working_days;
            $per_percentage  = round($per_percentage);
            Con_task::where('main_id',$task_id)->update(['progress'=>$per_percentage]);
            // update the  gantt
            // dd($task);
            ###################################################
            $alltask =Con_task::where(['project_id'=>$task->project_id,'instance_id'=>$task->instance_id])
            ->where('type','project')->get();
            foreach ($alltask as $key => $value) {
                    $task_id=$value->main_id;
                    $total_percentage=Con_task::where(['project_id'=>$task->project_id,
                    'instance_id'=>$task->instance_id])
                    ->where('parent',$value->id)->avg('progress');
                    $total_percentage=round($total_percentage);
                    if($total_percentage!=null){
                        Con_task::where('main_id',$task_id)
                        ->where(['project_id'=>$task->project_id,'instance_id'=>$task->instance_id])
                        ->update(['progress'=>$total_percentage]);
                    }
            }
            ###################################################

            return redirect()->back()->with('success', __('Task successfully Updated.'));
        }
    }
    public function taskpersentage_update($project_id)
    {
        $project    = Project::find($project_id);

        $alltask =Con_task::where(['project_id'=>$project_id,'instance_id'=>$project->instance_id])->get();
        foreach ($alltask as $key => $value) {
                $task_id=$value->main_id;
                $total_percentage=Con_task::where(['project_id'=>$project_id,'instance_id'=>$project->instance_id])
                ->where('parent',$value->id)->avg('progress');
                $total_percentage=round($total_percentage);
                if($total_percentage!=NUll){
                    Con_task::where('main_id',$task_id)->where(['instance_id'=>$project->instance_id])
                    ->update(['progress'=>$total_percentage]);
                }
        }

    }

    public function getBetweenDates($startDate, $endDate) {
        $array = array();
        $interval = new DateInterval('P1D');

        $realEnd = new DateTime($endDate);
        $realEnd->add($interval);

        $period = new DatePeriod(new DateTime($startDate), $interval, $realEnd);

        $array = [];
        foreach($period as $date) {
            array_push($array,$date->format('Y-m-d'));
        }

        return $array;
    }

    public function array_flatten($array) {
        if (!is_array($array)) {
            return false;
        }
        $result = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, $this->array_flatten($value));
            }
            else {
                $result[$key] = $value;
            }
        }
        return $result;
    }

}
