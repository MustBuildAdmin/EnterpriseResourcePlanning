<?php
namespace App\Http\Controllers;

use App\Jobs\Projecttypetask;
use App\Models\ActivityLog;
use App\Models\Bug;
use App\Models\BugComment;
use App\Models\BugFile;
use App\Models\BugStatus;
use App\Models\Con_task;
use App\Models\Holiday;
use App\Models\Instance;
use App\Models\Link;
use App\Models\MicroTask;
use App\Models\Milestone;
use App\Models\NonWorkingDaysModal;
use App\Models\Project;
use App\Models\ProjectConsultant;
use App\Models\ProjectSubcontractor;
use App\Models\ProjectTask;
use App\Models\ProjectUser;
use App\Models\Project_holiday;
use App\Models\TaskStage;
use App\Models\Task_progress;
use App\Models\TimeTracker;
use App\Models\User;
use App\Models\Utility;
use Carbon\Carbon;
use Config;
use DateInterval;
use DatePeriod;
use DateTime;
use DB;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($view = "grid")
    {
        if (\Auth::user()->can("manage project")) {
            return view("projects.index", compact("view"));
        } else {
            return redirect()
                ->back()
                ->with("error", __("Permission Denied."));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Auth::user()->can("create project")) {
            $setting = Utility::settings(\Auth::user()->creatorId());
            $users = User::where("created_by", "=", \Auth::user()->creatorId())
                ->where("type", "!=", "client")
                ->get()
                ->pluck("name", "id");
            $clients = User::where(
                "created_by",
                "=",
                \Auth::user()->creatorId()
            )
                ->where("type", "=", "client")
                ->get()
                ->pluck("name", "id");
            $clients->prepend("Select Client", "");
            $repoter = User::where(
                "created_by",
                "=",
                \Auth::user()->creatorId()
            )
                ->where("type", "!=", "client")
                ->get()
                ->pluck("name", "id");
            $users->prepend("Select User", "");
            $country = Utility::getcountry();

            return view(
                "projects.create",
                compact("clients", "users", "setting", "repoter", "country")
            );
        } else {
            return redirect()
                ->back()
                ->with("error", __("Permission Denied."));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (\Auth::user()->can('create project')) {
            $validator = \Validator::make(
                $request->all(), [
                    'project_name' => 'required',
                    // 'project_image' => 'required',
                    // 'non_working_days'=>'required'
                    // 'status'=>'required'
                ]
            );
            if ($validator->fails()) {
                return redirect()->back()->with('error', Utility::errorFormat($validator->getMessageBag()));
            }

            $microProgram = $request->micro_program == "on" ? 1 : 0;
            $project = new Project();
            $project->project_name = $request->project_name;
            $project->start_date = date("Y-m-d H:i:s", strtotime($request->start_date));
            $project->end_date = date("Y-m-d H:i:s", strtotime($request->end_date));
            if ($request->hasFile('project_image')) {
                $filenameWithExt1 = $request->file("project_image")->getClientOriginalName();
                $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                $extension1 = $request->file("project_image")->getClientOriginalExtension();
                $fileNameToStore1 = $filename1 . "_" . time() . "." . $extension1;

                $dir = Config::get('constants.Projects_image');

                $imagepath = $dir . $filenameWithExt1;
                if (\File::exists($imagepath)) {
                    \File::delete($imagepath);
                }
                $url = "";
                $path = Utility::upload_file($request, "project_image", $fileNameToStore1, $dir, []);

                if ($path["flag"] == 1) {
                    $url = $path["url"];
                }

                $project->project_image = $url;
            }

            $setHolidays = $request->holidays == "on" ? 1 : 0;
            $project->holidays = $setHolidays;

            if (isset($request->non_working_days)) {
                $project->non_working_days = implode(',', $request->non_working_days);
            }

            $project->client_id = $request->client;
            $project->budget = !empty($request->budget) ? $request->budget : 0;
            $project->description = $request->description;
            $project->status = $request->status;
            $project->report_to = implode(',', $request->reportto);
            $project->report_time = $request->report_time;
            $project->tags = $request->tag;
            $project->estimated_days = $request->estimated_days;

            $project->created_by = \Auth::user()->creatorId();
            // instance creation------------------------
            $var = mt_rand(9, 999999999) . date('dmyhisa') . $request->client_id . $request->project_name;
            $instance_id = Hash::make($var);
            $project->instance_id = $instance_id;
            $project->country = $request->country;
            $project->state = $request->state;
            $project->otheraddress = $request->otheraddress;
            $project->city = $request->city;
            $project->zipcode = $request->zip;
            $project->latitude = $request->latitude;
            $project->longitude = $request->longitude;
            $project->micro_program = $microProgram;
            $project->status = "in_progress";
            if ($request->file_status != 'M') {

                $project->critical_update = 0;

            }
            ///---------end-----------------
            $project->save();

            if (isset($request->non_working_days)) {
                $nonWorkingDaysInsert = array(
                    'project_id' => $project->id,
                    'non_working_days' => implode(',', $request->non_working_days),
                    'instance_id' => $instance_id,
                    'created_by' => \Auth::user()->creatorId(),
                );
                DB::table('non_working_days')->insert($nonWorkingDaysInsert);
            }

            $insert_data = array(
                'instance' => $instance_id,
                'start_date' => date("Y-m-d H:i:s", strtotime($request->start_date)),
                'end_date' => date("Y-m-d H:i:s", strtotime($request->end_date)),
                'percentage' => '0',
                'achive' => 0,
                'project_id' => $project->id,
            );
            Instance::insert($insert_data);
            if ($setHolidays == 0) {
                $holidays_list = Holiday::where('created_by', '=', \Auth::user()->creatorId())->get();
                foreach ($holidays_list as $key => $value) {
                    $insert = array(
                        'project_id' => $project->id,
                        'date' => $value->date,
                        'description' => $value->occasion,
                        'created_by' => \Auth::user()->creatorId(),
                        'instance_id' => $instance_id,
                    );
                    Project_holiday::insert($insert);
                }

            }
            if (isset($request->file)) {
                if ($request->file_status == 'MP') {
                    $path = 'projectfiles/';
                    $filename = $_FILES["file"]["name"];
                    $name = $project->id . '.' . pathinfo($filename, PATHINFO_EXTENSION);
                    $pathname = 'projectfiles/' . $name;
                    $link = env('APP_URL') . '/' . $path . $name;
                    if (file_exists(public_path($pathname))) {
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
                        //   CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_SSL_VERIFYHOST => false,
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_POSTFIELDS => ['file' => new \CURLFILE($link), 'type' => 'msproject-parse'],
                    ));

                    $responseBody = curl_exec($curl);
                    curl_close($curl);
                    if (file_exists(public_path($pathname))) {
                        unlink(public_path($pathname));
                    }

                    $responseBody = json_decode($responseBody, true);

                    if (isset($responseBody['data']['data'])) {

                        foreach ($responseBody['data']['data'] as $key => $value) {
                            $task = new Con_task();
                            $task->project_id = $project->id;
                            $task->instance_id = $instance_id;
                            if (isset($value['text'])) {
                                $task->text = $value['text'];
                            }
                            if (isset($value['id'])) {
                                $task->id = $value['id'];
                            }
                            if (isset($value['start_date'])) {
                                $task->start_date = $value['start_date'];
                            }
                            if (isset($value['duration'])) {
                                $task->duration = $value['duration'] + 1;
                            }
                            if (isset($value['progress'])) {
                                $task->progress = $value['progress'];
                            }
                            if (isset($value['parent'])) {
                                $task->parent = $value['parent'];
                                $task->predecessors = $value['parent'];
                            }

                            if (isset($value['$raw'])) {
                                $raw = $value['$raw'];
                                if (isset($raw['Finish'])) {
                                    $task->end_date = $raw['Finish'];
                                }
                                $task->custom = json_encode($value['$raw']);
                            }

                            $task->save();
                        }

                        foreach ($responseBody['data']['links'] as $key => $value) {
                            $link = new Link();
                            $link->project_id = $project->id;
                            $link->instance_id = $instance_id;
                            $link->id = $value['id'];
                            $old_predis = Con_task::where(['id' => $value['target'],
                                'project_id' => $project->id,
                                'instance_id' => $instance_id])
                                ->pluck('predecessors')->first();
                            if ($old_predis != '') {
                                $predis = $old_predis . ',' . $value['source'];
                                if ($value['lag'] != 0) {
                                    if (str_contains($value['lag'], '-')) {
                                        $predis = $predis . $value['lag'] . ' days';
                                    } else {
                                        $predis = $predis . ' +' . $value['lag'] . ' days';
                                    }
                                }
                            } else {
                                $predis = $value['source'];
                                if ($value['lag'] != 0) {
                                    if (str_contains($value['lag'], '-')) {
                                        $predis = $predis . $value['lag'] . ' days';
                                    } else {
                                        $predis = $predis . ' +' . $value['lag'] . ' days';
                                    }
                                }
                            }
                            Con_task::where(['id' => $value['target'], 'project_id' => $project->id, 'instance_id' => $instance_id])
                                ->update(['predecessors' => $predis]);
                            if (isset($value['type'])) {
                                $link->type = $value['type'];
                            }
                            if (isset($value['source'])) {

                                $link->source = $value['source'];
                            }
                            if (isset($value['lag'])) {
                                $link->lag = $value['lag'];
                            }
                            if (isset($value['target'])) {
                                $link->target = $value['target'];
                            }
                            $link->save();
                        }
                    }

                } else {
                    /// primaverra
                    $path = 'projectfiles/';
                    $filename = $_FILES["file"]["name"];
                    $name = $project->id . '.' . pathinfo($filename, PATHINFO_EXTENSION);
                    $pathname = 'projectfiles/' . $name;
                    $link = env('APP_URL') . '/' . $path . $name;
                    if (file_exists(public_path($pathname))) {
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
                        //   CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_SSL_VERIFYHOST => false,
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_POSTFIELDS => ['file' => new \CURLFILE($link), 'type' => 'primaveraP6-parse'],
                    ));

                    $responseBody = curl_exec($curl);
                    curl_close($curl);
                    if (file_exists(public_path($pathname))) {
                        unlink(public_path($pathname));
                    }
                    $responseBody = json_decode($responseBody, true);
                    if (isset($responseBody['data']['data'])) {

                        foreach ($responseBody['data']['data'] as $key => $value) {
                            $task = new Con_task();
                            $task->project_id = $project->id;
                            $task->instance_id = $instance_id;
                            if (isset($value['text'])) {
                                $task->text = $value['text'];
                            }
                            if (isset($value['id'])) {
                                $task->id = $value['id'];
                            }
                            if (isset($value['start_date'])) {
                                $task->start_date = $value['start_date'];
                            }
                            if (isset($value['duration'])) {
                                $task->duration = $value['duration'];
                            }
                            if (isset($value['progress'])) {
                                $task->progress = $value['progress'];
                            }
                            if (isset($value['parent'])) {
                                $task->parent = $value['parent'];
                                $task->predecessors = $value['parent'];
                            }

                            if (isset($value['$raw'])) {
                                $raw = $value['$raw'];
                                if (isset($raw['Finish'])) {
                                    $task->end_date = $raw['Finish'];
                                }
                                $task->custom = json_encode($value['$raw']);
                            }

                            $task->save();

                        }

                        foreach ($responseBody['data']['links'] as $key => $value) {
                            $link = new Link();
                            $link->project_id = $project->id;
                            $link->instance_id = $instance_id;
                            $old_predis = Con_task::where(['id' => $value['target'], 'project_id' => $project->id,
                                'instance_id' => $instance_id])->pluck('predecessors')->first();
                            if ($old_predis != '') {
                                $predis = $old_predis . ',' . $value['source'];
                                if ($value['lag'] != 0) {
                                    if (str_contains($value['lag'], '-')) {
                                        $predis = $predis . $value['lag'] . ' days';
                                    } else {
                                        $predis = $predis . ' +' . $value['lag'] . ' days';
                                    }

                                }

                            } else {
                                $predis = $value['source'];
                                if ($value['lag'] != 0) {
                                    if (str_contains($value['lag'], '-')) {
                                        $predis = $predis . $value['lag'] . ' days';
                                    } else {
                                        $predis = $predis . ' +' . $value['lag'] . ' days';
                                    }
                                }
                            }
                            Con_task::where(['id' => $value['target'],
                                'project_id' => $project->id,
                                'instance_id' => $instance_id])
                                ->update(['predecessors' => $predis]);
                            $link->id = $value['id'];
                            if (isset($value['type'])) {
                                $link->type = $value['type'];
                            }
                            if (isset($value['lag'])) {
                                $link->type = $value['lag'];
                            }
                            if (isset($value['source'])) {

                                $link->source = $value['source'];
                            }
                            if (isset($value['target'])) {
                                $link->target = $value['target'];
                            }
                            $link->save();
                        }
                    }
                }

            }

            if (\Auth::user()->type == 'company') {

                ProjectUser::create(
                    [
                        'project_id' => $project->id,
                        'user_id' => Auth::user()->id,
                    ]
                );

                if ($request->reportto) {
                    foreach ($request->reportto as $key => $value) {
                        ProjectUser::create(
                            [
                                'project_id' => $project->id,
                                'user_id' => $value,
                            ]
                        );
                    }
                }

            } else {
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

                if ($request->reportto) {
                    foreach ($request->reportto as $key => $value) {
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
            $setting = Utility::settings(\Auth::user()->creatorId());
            if (isset($setting['project_notification']) && $setting['project_notification'] == 1) {
                $msg = $request->project_name . ' ' . __(" created by") . ' ' . \Auth::user()->name . '.';
                Utility::send_slack_msg($msg);
            }

            //Telegram Notification
            $setting = Utility::settings(\Auth::user()->creatorId());
            if (isset($setting['telegram_project_notification']) && $setting['telegram_project_notification'] == 1) {
                $msg = __("New") . ' ' . $request->project_name . ' ' . __("project");
                $msg = $msg . ' ' . __(" created by") . ' ' . \Auth::user()->name . '.';
                Utility::send_telegram_msg($msg);
            }

            return redirect()->route('construction_main')->with('success', __('Project Add Successfully'));

        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function boq_file(Request $request)
    {
        $project_id = $request->project_id;

        $get_code = DB::table("boq_email")
            ->where("project_id", $project_id)
            ->where("status", "1")
            ->first();
        if ($get_code != null) {
            $verify_date = $get_code->code_expires_at;
            if ($verify_date > date("Y-m-d H:i:s")) {
                return view("projects.boq_index", compact("project_id"));
            } else {
                return redirect()
                    ->route("construction_main")
                    ->with("error", __("Email is Expired!"));
            }
        } else {
            return redirect()
                ->route("construction_main")
                ->with("error", __("Your Security Code was not found!"));
        }
    }

    public function boq_code_verify(Request $request)
    {
        $project_id = $request->project_id;
        $security_code = $request->security_code;

        $verify_code = DB::table("boq_email")
            ->where("project_id", $project_id)
            ->where("security_code", $security_code)
            ->where("status", "1")
            ->first();
        if ($verify_code != null) {
            return 1;
        } else {
            return 0;
        }
    }

    public function boq_file_upload(Request $request)
    {
        $project_id = $request->project_id;
        $fileNameToStore1 = "";
        $url = "";

        if (!empty($request->boq_file)) {
            $filenameWithExt1 = $request
                ->file("boq_file")
                ->getClientOriginalName();
            $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
            $extension1 = $request
                ->file("boq_file")
                ->getClientOriginalExtension();
            $fileNameToStore1 = $filename1 . "_" . time() . "." . $extension1;
            $dir = "uploads/boq_file";
            $image_path = $dir . $filenameWithExt1;

            if (\File::exists($image_path)) {
                \File::delete($image_path);
            }

            $url = "";
            $path = Utility::upload_file(
                $request,
                "boq_file",
                $fileNameToStore1,
                $dir,
                []
            );

            if ($path["flag"] == 1) {
                $url = $path["url"];
            } else {
                return redirect()
                    ->route("construction_main")
                    ->with("error", __($path["msg"]));
            }
        }

        $save_data = [
            "boq_file_path" => $url,
            "boq_filename" => $fileNameToStore1,
        ];

        Project::where("id", $project_id)->update($save_data);

        return redirect()
            ->route("construction_main")
            ->with("success", __("BOQ File Uploaded Successfully"));
    }

    public function checkDuplicateProject(Request $request)
    {
        $form_name = $request->form_name;
        $check_name = $request->project_name;

        if ($form_name == "ProjectCreate") {
            $getCheckVal = Project::where(
                "created_by",
                \Auth::user()->creatorId()
            )
                ->whereRaw("LOWER(REPLACE(`project_name`, ' ' ,''))  = ?", [
                    strtolower(str_replace(" ", "", $check_name)),
                ])
                ->first();
        } else {
            $getCheckVal = "Not Empty";
        }

        if ($getCheckVal == null) {
            echo "true";
            // return 1; //Success
        } else {
            echo "false";
            // return 0; //Error
        }
    }

    public function loadproject(Project $project)
    {
        // Loading Project Function
    }

    public function check_instance($id)
    {
        $get_project_instances = Instance::where("project_id", $id)
            ->orderBy("id", "ASC")
            ->get();
        if (count($get_project_instances) > 1) {
            return view(
                "construction_project.instance_view",
                compact("get_project_instances")
            );
        } else {
            return redirect()->route("projects.instance_project", [
                $get_project_instances[0]["id"],
                $id,
            ]);
        }
    }

    public function check_instance_dairy($id)
    {
        $get_project_instances = Instance::where("project_id", $id)
            ->orderBy("id", "ASC")
            ->get();
        if (count($get_project_instances) > 1) {
            return view(
                "construction_project.instance_view_dairy",
                compact("get_project_instances")
            );
        } else {
            return redirect()->route("projects.instance_project_dairy", [
                $get_project_instances[0]["id"],
                $id,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Poject  $poject
     * @return \Illuminate\Http\Response
     */
    public function getActivityLog(Request $request, $project_id)
    {

        // Page Length
        $pageNumber = ($request->start / $request->length) + 1;
        $pageLength = $request->length;
        $skip = ($pageNumber - 1) * $pageLength;

        // get data from products table
        $query = \DB::table('activity_logs')->select('*', 'activity_logs.id as activitylogID',
            'activity_logs.created_at as activitylogcreatedAt')
            ->join('users', 'users.id', '=', 'activity_logs.user_id');

        // Search
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        if ($start_date != '' && $end_date != '') {
            $query = $query->where(function ($query) use ($start_date, $end_date) {
                $start_date = $start_date . ' 00:00:00.000000';
                $end_date = $end_date . ' 23:59:59.000000';
                $query->whereBetween(
                    'activity_logs.created_at', [
                        $start_date,
                        $end_date,
                    ]
                );

            });
        }

        $task_status = array();
        if (!empty($request->task_status)) {
            if (in_array("Create", $request->task_status)) {
                array_push($task_status, 'Added New Task');
            }
            if (in_array("Update", $request->task_status)) {
                array_push($task_status, 'Updated Task');
            }
            if (in_array("Delete", $request->task_status)) {
                array_push($task_status, 'Deleted Task');
            }
            if (!empty($task_status)) {
                $query->whereIn('log_type', $task_status);
            }
        }

        $query->where("project_id", $project_id);
        $recordsFiltered = $recordsTotal = $query->count();
        $users = $query->skip($skip)->take($pageLength)->get();

        return response()->json(["draw" => $request->draw, "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsFiltered, 'data' => $users, 'end_date' => $end_date, 'start_date' => $start_date], 200);
    }
    public function projectActivities(Request $request, $project_id)
    {

        $project = Project::where(["id" => $project_id])->first();
        $usr = Auth::user();
        if (\Auth::user()->type == "client") {
            $user_projects = Project::where("client_id", \Auth::user()->id)
                ->pluck("id", "id")
                ->toArray();
        } else {
            $user_projects = $usr->projects->pluck("id")->toArray();
        }
        if (in_array($project->id, $user_projects)) {
            return view("construction_project.activities", compact("project", "project_id"));
        } else {
            return redirect()
                ->back()
                ->with("error", __("Permission Denied."));
        }
    }
    public function projectTeamMembers(Request $request, $project_id)
    {
        $project = Project::where(["id" => $project_id])->first();
        $usr = Auth::user();
        if (\Auth::user()->type == "client") {
            $user_projects = Project::where("client_id", \Auth::user()->id)
                ->pluck("id", "id")
                ->toArray();
        } else {
            $user_projects = $usr->projects->pluck("id")->toArray();
        }
        if (in_array($project->id, $user_projects)) {
            return view("construction_project.teammembers", compact("project", "project_id"));
        } else {
            return redirect()
                ->back()
                ->with("error", __("Permission Denied."));
        }
    }
    public function projectConsultant(Request $request, $project_id)
    {
        $project = Project::where(["id" => $project_id])->first();
        $usr = Auth::user();
        if (\Auth::user()->type == "client") {
            $user_projects = Project::where("client_id", \Auth::user()->id)
                ->pluck("id", "id")
                ->toArray();
        } else {
            $user_projects = $usr->projects->pluck("id")->toArray();
        }
        if (in_array($project->id, $user_projects)) {
            return view("construction_project.consultant", compact("project", "project_id"));
        } else {
            return redirect()
                ->back()
                ->with("error", __("Permission Denied."));
        }
    }
    public function projectSubcontractor(Request $request, $project_id)
    {
        $project = Project::where(["id" => $project_id])->first();
        $usr = Auth::user();
        if (\Auth::user()->type == "client") {
            $user_projects = Project::where("client_id", \Auth::user()->id)
                ->pluck("id", "id")
                ->toArray();
        } else {
            $user_projects = $usr->projects->pluck("id")->toArray();
        }
        if (in_array($project->id, $user_projects)) {
            return view("construction_project.subcontractor", compact("project", "project_id"));
        } else {
            return redirect()
                ->back()
                ->with("error", __("Permission Denied."));
        }
    }
    public function show(Project $project)
    {
        if (\Auth::user()->can("view project")) {
            $usr = Auth::user();
            if (\Auth::user()->type == "client") {
                $user_projects = Project::where("client_id", \Auth::user()->id)
                    ->pluck("id", "id")
                    ->toArray();
            } else {
                $user_projects = $usr->projects->pluck("id")->toArray();
            }
            if (in_array($project->id, $user_projects)) {
                // test the holidays
                if ($project->holidays == 0) {
                    $holidays = Project_holiday::where([
                        "project_id" => $project->id,
                        "instance_id" => Session::get("project_instance"),
                    ])->first();
                    if (!$holidays) {
                        return redirect()
                            ->back()
                            ->with("error", __("No holidays are listed."));
                    }
                }

                // end
                $project_data = [];
                // Task Count
                $tasks = Con_task::where("project_id", $project->id)
                    ->where("instance_id", Session::get("project_instance"))
                    ->get();
                $project_task = $tasks->count();
                $completedTask = Con_task::where("project_id", $project->id)
                    ->where("instance_id", Session::get("project_instance"))
                    ->where("progress", 100)
                    ->get();

                $project_done_task = $completedTask->count();

                $project_data["task"] = [
                    "total" => number_format($project_task),
                    "done" => number_format($project_done_task),
                    "percentage" => Utility::getPercentage(
                        $project_done_task,
                        $project_task
                    ),
                ];

                // end Task Count

                // Expense
                $expAmt = 0;
                foreach ($project->expense as $expense) {
                    $expAmt += $expense->amount;
                }

                $project_data["expense"] = [
                    "allocated" => $project->budget,
                    "total" => $expAmt,
                    "percentage" => Utility::getPercentage(
                        $expAmt,
                        $project->budget
                    ),
                ];
                // end expense

                // Users Assigned
                $total_users = User::where(
                    "created_by",
                    "=",
                    $usr->id
                )->count();

                $project_data["user_assigned"] = [
                    "total" =>
                    number_format($total_users) .
                    "/" .
                    number_format($total_users),
                    "percentage" => Utility::getPercentage(
                        $total_users,
                        $total_users
                    ),
                ];
                // end users assigned

                // Day left
                $total_day = Carbon::parse($project->start_date)->diffInDays(
                    Carbon::parse($project->end_date)
                );
                $remaining_day = Carbon::parse(
                    $project->start_date
                )->diffInDays(now());
                if ($total_day < $remaining_day) {
                    $remaining_day = $total_day;
                }
                $project_data["day_left"] = [
                    "day" =>
                    number_format($remaining_day) .
                    "/" .
                    number_format($total_day),
                    "percentage" => Utility::getPercentage(
                        $remaining_day,
                        $total_day
                    ),
                ];
                // end Day left

                // Open Task
                $remaining_task = Con_task::where(
                    "project_id",
                    "=",
                    $project->id
                )
                    ->where("instance_id", Session::get("project_instance"))
                    ->where("progress", "=", 100)
                    ->count();
                $total_task = $project_data["task"]["total"];

                $project_data["open_task"] = [
                    "tasks" =>
                    number_format($remaining_task) .
                    "/" .
                    number_format($total_task),
                    "percentage" => Utility::getPercentage(
                        $remaining_task,
                        $total_task
                    ),
                ];
                // end open task

                // Milestone
                $total_milestone = $project->milestones()->count();
                $complete_milestone = $project
                    ->milestones()
                    ->where("status", "LIKE", "complete")
                    ->count();
                $project_data["milestone"] = [
                    "total" =>
                    number_format($complete_milestone) .
                    "/" .
                    number_format($total_milestone),
                    "percentage" => Utility::getPercentage(
                        $complete_milestone,
                        $total_milestone
                    ),
                ];
                // End Milestone

                // Time spent

                $times = $project
                    ->timesheets()
                    ->where("created_by", "=", $usr->id)
                    ->pluck("time")
                    ->toArray();
                $totaltime = str_replace(":", ".", Utility::timeToHr($times));
                $project_data["time_spent"] = [
                    "total" =>
                    number_format($totaltime) .
                    "/" .
                    number_format($totaltime),
                    "percentage" => Utility::getPercentage(
                        number_format($totaltime),
                        $totaltime
                    ),
                ];
                // end time spent

                // Allocated Hours
                $hrs = Project::projectHrs($project->id);
                $project_data["task_allocated_hrs"] = [
                    "hrs" =>
                    number_format($hrs["allocated"]) .
                    "/" .
                    number_format($hrs["allocated"]),
                    "percentage" => Utility::getPercentage(
                        $hrs["allocated"],
                        $hrs["allocated"]
                    ),
                ];
                // end allocated hours

                // Chart
                $seven_days = Utility::getLastSevenDays();
                $chart_task = [];
                $chart_timesheet = [];
                $cnt = 0;
                $cnt1 = 0;

                foreach (array_keys($seven_days) as $date) {
                    $task_cnt = $project
                        ->tasks()
                        ->where("is_complete", "=", 1)
                        ->whereRaw("find_in_set('" . $usr->id . "',assign_to)")
                        ->where("marked_at", "LIKE", $date)
                        ->count();
                    $arrTimesheet = $project
                        ->timesheets()
                        ->where("created_by", "=", $usr->id)
                        ->where("date", "LIKE", $date)
                        ->pluck("time")
                        ->toArray();

                    // Task Chart Count
                    $cnt += $task_cnt;

                    // Timesheet Chart Count
                    $timesheet_cnt = str_replace(
                        ":",
                        ".",
                        Utility::timeToHr($arrTimesheet)
                    );
                    $cn[] = $timesheet_cnt;
                    $cnt1 += $timesheet_cnt;

                    $chart_task[] = $task_cnt;
                    $chart_timesheet[] = $timesheet_cnt;
                }

                $project_data["task_chart"] = [
                    "chart" => $chart_task,
                    "total" => $cnt,
                ];
                $project_data["timesheet_chart"] = [
                    "chart" => $chart_timesheet,
                    "total" => $cnt1,
                ];

                // end chart

                $total_sub = Con_task::where("project_id", $project->id)
                    ->where("instance_id", Session::get("project_instance"))
                    ->where("type", "task")
                    ->count();
                $first_task = Con_task::where("project_id", $project->id)
                    ->where("instance_id", Session::get("project_instance"))
                    ->orderBy("id", "ASC")
                    ->first();
                if ($first_task) {
                    $workdone_percentage = $first_task->progress;
                    $actual_percentage = $first_task->progress;
                    $no_working_days = $first_task->duration; // include the last day
                    $date2 = date_create($first_task->end_date);
                } else {
                    $workdone_percentage = "0";
                    $actual_percentage = "0";
                    $no_working_days = $project->estimated_days; // include the last day
                    $date2 = date_create($project->end_date);
                }
                if ($actual_percentage > 100) {
                    $actual_percentage = 100;
                }
                if ($actual_percentage < 0) {
                    $actual_percentage = 0;
                }

                $cur = date("Y-m-d");
                //############## END ##############################
                //############## Remaining days ###################
                $remaining_working_days = Utility::remaining_duration_calculator(
                    $date2,
                    $project->id
                );
                $remaining_working_days = $remaining_working_days - 1; // include the last day
                //############## Remaining days ##################
                $completed_days = $no_working_days - $remaining_working_days;

                if ($no_working_days == 1) {
                    $current_Planed_percentage = 100;
                } else {
                    // percentage calculator
                    if ($no_working_days > 0) {
                        $perday = 100 / $no_working_days;
                    } else {
                        $perday = 0;
                    }

                    $current_Planed_percentage = round(
                        $completed_days * $perday
                    );
                }

                if ($current_Planed_percentage > 100) {
                    $current_Planed_percentage = 100;
                }
                if ($current_Planed_percentage < 0) {
                    $current_Planed_percentage = 0;
                }

                if ($current_Planed_percentage > 0) {
                    $workdone_percentage = $workdone_percentage =
                        $workdone_percentage / $current_Planed_percentage;
                } else {
                    $workdone_percentage = 0;
                }
                $workdone_percentage = $workdone_percentage * 100;
                if ($workdone_percentage > 100) {
                    $workdone_percentage = 100;
                }
                $remaing_percenatge = round(100 - $current_Planed_percentage);
                $project_task = Con_task::where(
                    "con_tasks.project_id",
                    Session::get("project_id")
                )
                    ->where("con_tasks.type", "task")
                    ->where("con_tasks.start_date", "like", $cur . "%")
                    ->get();
                $not_started = 0;
                foreach ($project_task as $value) {
                    $result = Task_progress::where(
                        "task_id",
                        $value->main_id
                    )->first();
                    if (!$result) {
                        $not_started = $not_started + 1;
                    }
                }
                if ($remaining_working_days < 0) {
                    $remaining_working_days = 0;
                }
                $notfinished = Con_task::where("project_id", $project->id)
                    ->where("instance_id", Session::get("project_instance"))
                    ->where("type", "task")
                    ->where("end_date", "<", $cur)
                    ->where("progress", "!=", "100")
                    ->count();
                $completed_task = Con_task::where("project_id", $project->id)
                    ->where("instance_id", Session::get("project_instance"))
                    ->where("type", "task")
                    ->where("end_date", "<", $cur)
                    ->where("progress", "100")
                    ->count();

                $ongoing_task = Con_task::where("project_id", $project->id)
                    ->where("instance_id", Session::get("project_instance"))
                    ->where("type", "task")
                    ->where("progress", "<", 100)
                    ->where("progress", ">", 0)
                    ->whereDate('end_date', '>', date('Y-m-d'))
                    ->count();

                $dependencycriticalcount = Con_task::where("project_id", $project->id)
                    ->where("instance_id", Session::get("project_instance"))
                    ->where("type", "task")
                    ->where("progress", "<", 100)
                    ->whereDate('dependency_critical', '>', date('Y-m-d'))
                    ->count();

                $entirecriticalcount = Con_task::where("project_id", $project->id)
                    ->where("instance_id", Session::get("project_instance"))
                    ->where("type", "task")
                    ->where("progress", "<", 100)
                    ->whereDate('entire_critical', '>', date('Y-m-d'))
                    ->count();

                $startDate = Carbon::now()->subWeeks(3);
                $endDate = Carbon::now();
                $datesBetween = [];
                $pending = [];
                $completed = [];
                while ($startDate->lte($endDate)) {
                    $datesBetween[] = $startDate->toDateString();

                    $search_date = $startDate->format('Y-m-d');
                    // completed task count
                    $completed[] = Task_progress::where('project_id', $project->id)
                        ->where('instance_id', Session::get("project_instance"))
                        ->where('record_date', 'like', $search_date . '%')
                        ->where('percentage', '100')->count();

                    // pending task count
                    $pending[] = Task_progress::where('project_id', $project->id)
                        ->where('instance_id', Session::get("project_instance"))
                        ->where('record_date', 'like', $search_date . '%')->where('percentage', '>', '100')->count();

                    $startDate->addDay();
                }
                $alldates = $datesBetween;

                // Micro task Start
                $microTaskCount = 0;
                $conTaskTaken = 0;
                $holidayCount = 0;
                $microWeekEndCount = 0;
                $totalWorkingDays = 0;
                $microProgram = null;
                $taskDates = [];
                $microallDate = [];
                $microProgramName = [];
                $micro_current_Planed_percentage = 0;
                $micro_planned_set = [];
                $micro_actual_percentage_set = [];
                $micro_actual_percentage = 0;

                $checkProject = Project::where('id', $project->id)->where('micro_program', 1)->first();
                if ($checkProject != null) {
                    $microProgram = DB::table('microprogram_schedule')
                        ->where('project_id', $project->id)
                        ->where("instance_id", Session::get("project_instance"))
                        ->where('active_status', 1)
                        ->first();

                    if ($microProgram != null) {
                        $microTaskCount = MicroTask::where('project_id', $project->id)
                            ->where('instance_id', Session::get("project_instance"))
                            ->where('schedule_id', $microProgram->id)
                            ->where('type', 'task')->get()->count();

                        $conTaskTaken = MicroTask::where('project_id', $project->id)
                            ->where('instance_id', Session::get("project_instance"))
                            ->where('schedule_id', $microProgram->id)
                            ->where('type', 'project')
                            ->where('micro_flag', 1)->get()->count();

                        $microallDate = MicroTask::select('micro_tasks.start_date',
                            'micro_tasks.end_date', 'micro_tasks.id')
                            ->join('projects as pros', 'pros.id', 'micro_tasks.project_id')
                            ->whereNotNull('pros.instance_id')
                            ->where('micro_tasks.micro_flag', 1)
                            ->where('micro_tasks.project_id', $project->id)
                            ->where('micro_tasks.instance_id', Session::get("project_instance"))
                            ->where('micro_tasks.schedule_id', $microProgram->id)
                            ->get();
                    }

                    if (\Auth::user()->type == "company") {
                        $getHoliday = Project_holiday::where("created_by", \Auth::user()->id)
                            ->where("project_id", $project->id)
                            ->where("instance_id", Session::get("project_instance"))
                            ->get();
                    } else {
                        $getHoliday = Project_holiday::where("created_by", \Auth::user()->creatorId())
                            ->where("project_id", $project->id)
                            ->where("instance_id", Session::get("project_instance"))
                            ->get();
                    }

                    if (count($microallDate) != 0) {
                        foreach ($microallDate as $getDate) {
                            $startDate = Carbon::createFromFormat('Y-m-d', $getDate->start_date);
                            $endDate = Carbon::createFromFormat('Y-m-d', $getDate->end_date);

                            while ($startDate->lte($endDate)) {
                                $taskDates[] = $startDate->copy()->format('Y-m-d');
                                $startDate->addDay();
                            }
                        }
                        if (count($getHoliday) != 0) {
                            foreach ($getHoliday as $holidaydate) {
                                if (in_array($holidaydate->date, $taskDates)) {
                                    $holidayCount++;
                                }

                            }
                        }

                        $countDates = count($taskDates);

                        $totalWorkingDays = ($countDates - $holidayCount);
                    }

                    $micro_get_non_work_day = [];
                    $nonWorkingDay = NonWorkingDaysModal::where("project_id", $project->id)
                        ->where("instance_id", Session::get("project_instance"))
                        ->orderBy("id", "DESC")
                        ->first();

                    if (
                        $nonWorkingDay != null &&
                        $nonWorkingDay->non_working_days != null
                    ) {
                        $split_non_working = explode(",", $nonWorkingDay->non_working_days);
                        foreach ($split_non_working as $non_working) {
                            if ($non_working == 0) {
                                $micro_get_non_work_day[] = "Sunday";
                            } elseif ($non_working == 1) {
                                $micro_get_non_work_day[] = "Monday";
                            } elseif ($non_working == 2) {
                                $micro_get_non_work_day[] = "Tuesday";
                            } elseif ($non_working == 3) {
                                $micro_get_non_work_day[] = "Wednesday";
                            } elseif ($non_working == 4) {
                                $micro_get_non_work_day[] = "Thursday";
                            } elseif ($non_working == 5) {
                                $micro_get_non_work_day[] = "Friday";
                            } elseif ($non_working == 6) {
                                $micro_get_non_work_day[] = "Saturday";
                            }
                        }
                    }

                    foreach ($taskDates as $split_dates) {
                        $getCurrentDay = date("l", strtotime($split_dates));
                        if (in_array($getCurrentDay, $micro_get_non_work_day)) {
                            $microWeekEndCount++;
                        }
                    }

                    $microProgramName = DB::table('microprogram_schedule')
                        ->where('project_id', $project->id)
                        ->where("instance_id", Session::get("project_instance"))
                        ->orderBy('id', 'DESC')
                        ->pluck('schedule_name');

                    $microProgramLoop = DB::table('microprogram_schedule')
                        ->where('project_id', $project->id)
                        ->where("instance_id", Session::get("project_instance"))
                        ->orderBy('id', 'DESC')
                        ->get();

                    foreach ($microProgramLoop as $micro_loop) {
                        $micro_no_working_days = $micro_loop->schedule_duration; // include the last day
                        $micro_date2 = date_create($micro_loop->schedule_end_date);
                        $micro_remaining_working_days = Utility::remaining_duration_calculator(
                            $micro_date2,
                            $project->id
                        );

                        $micro_remaining_working_days = $micro_remaining_working_days - 1;
                        $micro_completed_days = $micro_no_working_days - $micro_remaining_working_days;

                        if ($micro_no_working_days == 1) {
                            $micro_current_Planed_percentage = 100;
                        } else {
                            // percentage calculator
                            if ($micro_no_working_days > 0) {
                                $micro_perday = 100 / $micro_no_working_days;
                            } else {
                                $micro_perday = 0;
                            }

                            $micro_current_Planed_percentage = round(
                                $micro_completed_days * $micro_perday
                            );
                        }

                        if ($micro_current_Planed_percentage > 100) {
                            $micro_current_Planed_percentage = 100;
                        }
                        if ($micro_current_Planed_percentage < 0) {
                            $micro_current_Planed_percentage = 0;
                        }

                        $micro_planned_set[] = $micro_current_Planed_percentage;

                        $microProgramProgressSum = MicroTask::where('project_id', $project->id)
                            ->where("instance_id", Session::get("project_instance"))
                            ->where('schedule_id', $micro_loop->id)
                            ->where('type', 'project')
                            ->sum('progress');

                        if ($microProgram != null) {
                            $micro_duration = $microProgram->schedule_duration;
                            $micro_actual_percentage = round($microProgramProgressSum / $micro_duration);
                        } else {
                            $micro_actual_percentage = 0;
                        }

                        $micro_actual_percentage_set[] = $micro_actual_percentage;
                    }
                }

                $all_pending = Con_task::where("project_id", $project->id)
                    ->where("instance_id", Session::get("project_instance"))
                    ->where("type", "project")
                    ->where("end_date", "<", $cur)
                    ->where("progress", "!=", "100")
                    ->count();

                $all_completed = Con_task::where("project_id", $project->id)
                    ->where("instance_id", Session::get("project_instance"))
                    ->where("type", "project")
                    ->where("end_date", "<", $cur)
                    ->where("progress", "100")
                    ->count();

                $all_inprogress = Con_task::where("project_id", $project->id)
                    ->where("instance_id", Session::get("project_instance"))
                    ->where("type", "project")
                    ->where("progress", "<", 100)
                    ->where("progress", ">", 0)
                    ->whereDate('end_date', '>', date('Y-m-d'))
                    ->count();

                $all_upcoming = Con_task::where('project_id', $project->id)
                    ->where('instance_id', Session::get("project_instance"))
                    ->where("type", "project")
                    ->whereDate('start_date', '>', date('Y-m-d'))
                    ->count();

                // Micro task End
                return view(
                    "construction_project.construction_dashboard",
                    compact(
                        "project",
                        "ongoing_task",
                        "dependencycriticalcount",
                        "entirecriticalcount",
                        "project_data",
                        "total_sub",
                        "actual_percentage",
                        "workdone_percentage",
                        "current_Planed_percentage",
                        "not_started",
                        "notfinished",
                        "remaining_working_days",
                        "completed_task",
                        'alldates',
                        'completed',
                        'pending',
                        'microProgram',
                        'microTaskCount',
                        'conTaskTaken',
                        'holidayCount',
                        'microWeekEndCount',
                        'totalWorkingDays',
                        'checkProject',
                        'all_completed',
                        'all_upcoming',
                        'all_inprogress',
                        'all_pending',
                        'microProgramName',
                        'micro_planned_set',
                        'micro_actual_percentage_set'
                    )
                );
            } else {
                return redirect()
                    ->back()
                    ->with("error", __("Permission Denied."));
            }
        } else {
            return redirect()
                ->back()
                ->with("error", __("Permission Denied."));
        }
    }

    public function show_dairy($project_id)
    {
        if (\Auth::user()->can("view project")) {
            $usr = Auth::user();
            $project = Project::where('id', $project_id)->first();
            if (\Auth::user()->type == "client") {
                $user_projects = Project::where("client_id", \Auth::user()->id)
                    ->pluck("id", "id")
                    ->toArray();
            } else {
                $user_projects = $usr->projects->pluck("id")->toArray();
            }

            if (in_array($project->id, $user_projects)) {
                // test the holidays
                if ($project->holidays == 0) {
                    $holidays = Project_holiday::where([
                        "project_id" => $project->id,
                        "instance_id" => Session::get("project_instance"),
                    ])->first();
                    if (!$holidays) {
                        return redirect()
                            ->back()
                            ->with("error", __("No holidays are listed."));
                    }
                }

                // end
                $project_data = [];
                // Task Count
                $tasks = Con_task::where("project_id", $project->id)
                    ->where("instance_id", Session::get("project_instance"))
                    ->get();
                $project_task = $tasks->count();
                $completedTask = Con_task::where("project_id", $project->id)
                    ->where("instance_id", Session::get("project_instance"))
                    ->where("progress", 100)
                    ->get();

                $project_done_task = $completedTask->count();

                $project_data["task"] = [
                    "total" => number_format($project_task),
                    "done" => number_format($project_done_task),
                    "percentage" => Utility::getPercentage(
                        $project_done_task,
                        $project_task
                    ),
                ];

                // end Task Count

                // Expense
                $expAmt = 0;
                foreach ($project->expense as $expense) {
                    $expAmt += $expense->amount;
                }

                $project_data["expense"] = [
                    "allocated" => $project->budget,
                    "total" => $expAmt,
                    "percentage" => Utility::getPercentage(
                        $expAmt,
                        $project->budget
                    ),
                ];
                // end expense

                // Users Assigned
                $total_users = User::where(
                    "created_by",
                    "=",
                    $usr->id
                )->count();

                $project_data["user_assigned"] = [
                    "total" =>
                    number_format($total_users) .
                    "/" .
                    number_format($total_users),
                    "percentage" => Utility::getPercentage(
                        $total_users,
                        $total_users
                    ),
                ];
                // end users assigned

                // Day left
                $total_day = Carbon::parse($project->start_date)->diffInDays(
                    Carbon::parse($project->end_date)
                );
                $remaining_day = Carbon::parse(
                    $project->start_date
                )->diffInDays(now());
                if ($total_day < $remaining_day) {
                    $remaining_day = $total_day;
                }
                $project_data["day_left"] = [
                    "day" =>
                    number_format($remaining_day) .
                    "/" .
                    number_format($total_day),
                    "percentage" => Utility::getPercentage(
                        $remaining_day,
                        $total_day
                    ),
                ];
                // end Day left

                // Open Task
                $remaining_task = Con_task::where(
                    "project_id",
                    "=",
                    $project->id
                )
                    ->where("instance_id", Session::get("project_instance"))
                    ->where("progress", "=", 100)
                    ->count();
                $total_task = $project_data["task"]["total"];

                $project_data["open_task"] = [
                    "tasks" =>
                    number_format($remaining_task) .
                    "/" .
                    number_format($total_task),
                    "percentage" => Utility::getPercentage(
                        $remaining_task,
                        $total_task
                    ),
                ];
                // end open task

                // Milestone
                $total_milestone = $project->milestones()->count();
                $complete_milestone = $project
                    ->milestones()
                    ->where("status", "LIKE", "complete")
                    ->count();
                $project_data["milestone"] = [
                    "total" =>
                    number_format($complete_milestone) .
                    "/" .
                    number_format($total_milestone),
                    "percentage" => Utility::getPercentage(
                        $complete_milestone,
                        $total_milestone
                    ),
                ];
                // End Milestone

                // Time spent

                $times = $project
                    ->timesheets()
                    ->where("created_by", "=", $usr->id)
                    ->pluck("time")
                    ->toArray();
                $totaltime = str_replace(":", ".", Utility::timeToHr($times));
                $project_data["time_spent"] = [
                    "total" =>
                    number_format($totaltime) .
                    "/" .
                    number_format($totaltime),
                    "percentage" => Utility::getPercentage(
                        number_format($totaltime),
                        $totaltime
                    ),
                ];
                // end time spent

                // Allocated Hours
                $hrs = Project::projectHrs($project->id);
                $project_data["task_allocated_hrs"] = [
                    "hrs" =>
                    number_format($hrs["allocated"]) .
                    "/" .
                    number_format($hrs["allocated"]),
                    "percentage" => Utility::getPercentage(
                        $hrs["allocated"],
                        $hrs["allocated"]
                    ),
                ];
                // end allocated hours

                // Chart
                $seven_days = Utility::getLastSevenDays();
                $chart_task = [];
                $chart_timesheet = [];
                $cnt = 0;
                $cnt1 = 0;

                foreach (array_keys($seven_days) as $date) {
                    $task_cnt = $project
                        ->tasks()
                        ->where("is_complete", "=", 1)
                        ->whereRaw("find_in_set('" . $usr->id . "',assign_to)")
                        ->where("marked_at", "LIKE", $date)
                        ->count();
                    $arrTimesheet = $project
                        ->timesheets()
                        ->where("created_by", "=", $usr->id)
                        ->where("date", "LIKE", $date)
                        ->pluck("time")
                        ->toArray();

                    // Task Chart Count
                    $cnt += $task_cnt;

                    // Timesheet Chart Count
                    $timesheet_cnt = str_replace(
                        ":",
                        ".",
                        Utility::timeToHr($arrTimesheet)
                    );
                    $cn[] = $timesheet_cnt;
                    $cnt1 += $timesheet_cnt;

                    $chart_task[] = $task_cnt;
                    $chart_timesheet[] = $timesheet_cnt;
                }

                $project_data["task_chart"] = [
                    "chart" => $chart_task,
                    "total" => $cnt,
                ];
                $project_data["timesheet_chart"] = [
                    "chart" => $chart_timesheet,
                    "total" => $cnt1,
                ];

                // end chart

                $total_sub = Con_task::where("project_id", $project->id)
                    ->where("instance_id", Session::get("project_instance"))
                    ->where("type", "task")
                    ->count();
                $first_task = Con_task::where("project_id", $project->id)
                    ->where("instance_id", Session::get("project_instance"))
                    ->orderBy("id", "ASC")
                    ->first();
                if ($first_task) {
                    $workdone_percentage = $first_task->progress;
                    $actual_percentage = $first_task->progress;
                    $no_working_days = $first_task->duration; // include the last day
                    $date2 = date_create($first_task->end_date);
                } else {
                    $workdone_percentage = "0";
                    $actual_percentage = "0";
                    $no_working_days = $project->estimated_days; // include the last day
                    $date2 = date_create($project->end_date);
                }
                if ($actual_percentage > 100) {
                    $actual_percentage = 100;
                }
                if ($actual_percentage < 0) {
                    $actual_percentage = 0;
                }

                $cur = date("Y-m-d");
                //############## END ##############################
                //############## Remaining days ###################
                $remaining_working_days = Utility::remaining_duration_calculator(
                    $date2,
                    $project->id
                );
                $remaining_working_days = $remaining_working_days - 1; // include the last day
                //############## Remaining days ##################
                $completed_days = $no_working_days - $remaining_working_days;

                if ($no_working_days == 1) {
                    $current_Planed_percentage = 100;
                } else {
                    // percentage calculator
                    if ($no_working_days > 0) {
                        $perday = 100 / $no_working_days;
                    } else {
                        $perday = 0;
                    }

                    $current_Planed_percentage = round(
                        $completed_days * $perday
                    );
                }

                if ($current_Planed_percentage > 100) {
                    $current_Planed_percentage = 100;
                }
                if ($current_Planed_percentage < 0) {
                    $current_Planed_percentage = 0;
                }

                if ($current_Planed_percentage > 0) {
                    $workdone_percentage = $workdone_percentage =
                        $workdone_percentage / $current_Planed_percentage;
                } else {
                    $workdone_percentage = 0;
                }
                $workdone_percentage = $workdone_percentage * 100;
                if ($workdone_percentage > 100) {
                    $workdone_percentage = 100;
                }
                $project_task = Con_task::where(
                    "con_tasks.project_id",
                    Session::get("project_id")
                )
                    ->where("con_tasks.type", "task")
                    ->where("con_tasks.start_date", "like", $cur . "%")
                    ->get();
                $not_started = 0;
                foreach ($project_task as $value) {
                    $result = Task_progress::where(
                        "task_id",
                        $value->main_id
                    )->first();
                    if (!$result) {
                        $not_started = $not_started + 1;
                    }
                }
                if ($remaining_working_days < 0) {
                    $remaining_working_days = 0;
                }
                $notfinished = Con_task::where("project_id", $project->id)
                    ->where("instance_id", Session::get("project_instance"))
                    ->where("type", "task")
                    ->where("end_date", "<", $cur)
                    ->where("progress", "!=", "100")
                    ->count();
                $completed_task = Con_task::where("project_id", $project->id)
                    ->where("instance_id", Session::get("project_instance"))
                    ->where("type", "task")
                    ->where("end_date", "<", $cur)
                    ->where("progress", "100")
                    ->count();

                $ongoing_task = Con_task::where("project_id", $project->id)
                    ->where("instance_id", Session::get("project_instance"))
                    ->where("type", "task")
                    ->where("progress", "<", 100)
                    ->where("progress", ">", 0)
                    ->whereDate('end_date', '>', date('Y-m-d'))
                    ->count();

                $startDate = Carbon::now()->subWeeks(3);
                $endDate = Carbon::now();
                $datesBetween = [];
                $pending = [];
                $completed = [];
                while ($startDate->lte($endDate)) {
                    $datesBetween[] = $startDate->toDateString();

                    $search_date = $startDate->format('Y-m-d');
                    // completed task count
                    $completed[] = Task_progress::where('project_id', $project->id)
                        ->where('instance_id', Session::get("project_instance"))
                        ->where('record_date', 'like', $search_date . '%')
                        ->where('percentage', '100')->count();

                    // pending task count
                    $pending[] = Task_progress::where('project_id', $project->id)
                        ->where('instance_id', Session::get("project_instance"))
                        ->where('record_date', 'like', $search_date . '%')
                        ->where('percentage', '>', '100')->count();

                    $startDate->addDay();
                }
                $alldates = $datesBetween;
                return view(
                    "construction_project.construction_dashboard_dairy",
                    compact(
                        "project",
                        "ongoing_task",
                        "project_data",
                        "total_sub",
                        "actual_percentage",
                        "workdone_percentage",
                        "current_Planed_percentage",
                        "not_started",
                        "notfinished",
                        "remaining_working_days",
                        "completed_task",
                        'alldates',
                        'completed',
                        'pending'
                    )
                );
            } else {
                return redirect()
                    ->back()
                    ->with("error", __("Permission Denied."));
            }
        } else {
            return redirect()
                ->back()
                ->with("error", __("Permission Denied."));
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
        if (\Auth::user()->can("edit project")) {
            $clients = User::where(
                "created_by",
                "=",
                \Auth::user()->creatorId()
            )
                ->where("type", "=", "client")
                ->get()
                ->pluck("name", "id");
            $users = User::where("created_by", "=", \Auth::user()->creatorId())
                ->where("type", "!=", "client")
                ->get()
                ->pluck("name", "id");
            $users->prepend("Select User", "");
            $repoter = User::where(
                "created_by",
                "=",
                \Auth::user()->creatorId()
            )
                ->where("type", "!=", "client")
                ->get()
                ->pluck("name", "id");
            $project = Project::findOrfail($project->id);
            $setting = Utility::settings(\Auth::user()->creatorId());
            $country = Utility::getcountry();
            if (Session::has("project_instance")) {
                $instanceId = Session::get("project_instance");
            } else {
                $instanceId = $project->instance_id;
            }
            $project_holidays = Project_holiday::where([
                "project_id" => $project->id,
                "instance_id" => $instanceId,
            ])
                ->orderBy("date", "ASC")
                ->get();

            if ($project->country != null) {
                $statelist = Utility::getstate($project->country);
            } else {
                $statelist = [];
            }

            if ($project->created_by == \Auth::user()->creatorId()) {
                return view(
                    "projects.edit",
                    compact(
                        "project",
                        "clients",
                        "users",
                        "repoter",
                        "setting",
                        "country",
                        "statelist",
                        "project_holidays"
                    )
                );
            } else {
                return response()->json(
                    ["error" => __("Permission Denied.")],
                    401
                );
            }
        } else {
            return redirect()
                ->back()
                ->with("error", __("Permission Denied."));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Poject  $poject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        if (\Auth::user()->can("edit project")) {
            $validator = \Validator::make($request->all(), [
                "project_name" => "required",
                "status" => "required",
            ]);
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(
                        "error",
                        Utility::errorFormat($validator->getMessageBag())
                    );
            }

            $microProgram = $request->micro_program == "on" ? 1 : 0;
            $project = Project::find($project->id);
            $project->project_name = $request->project_name;
            $project->start_date = date(
                "Y-m-d H:i:s",
                strtotime($request->start_date)
            );
            $project->end_date = date(
                "Y-m-d H:i:s",
                strtotime($request->end_date)
            );

            if ($request->hasFile("project_image")) {
                if (\File::exists($project->project_image)) {
                    \File::delete($project->project_image);
                }

                $filenameWithExt1 = $request
                    ->file("project_image")
                    ->getClientOriginalName();
                $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                $extension1 = $request
                    ->file("project_image")
                    ->getClientOriginalExtension();
                $fileNameToStore1 =
                $filename1 . "_" . time() . "." . $extension1;
                $dir = Config::get("constants.Projects_image");
                $url = "";
                $path = Utility::upload_file(
                    $request,
                    "project_image",
                    $fileNameToStore1,
                    $dir,
                    []
                );

                if ($path["flag"] == 1) {
                    $url = $path["url"];
                }

                $project->project_image = $url;
            }

            $setHolidays = $request->holidays == "on" ? 1 : 0;
            $project->holidays = $setHolidays;

            if (isset($request->non_working_days)) {
                $project->non_working_days = implode(
                    ",",
                    $request->non_working_days
                );
            }

            $project->budget = $request->budget;
            $project->client_id = $request->client;
            $project->description = $request->description;
            $project->status = $request->status;
            $project->estimated_days = $request->estimated_days;
            $project->report_to = implode(",", $request->reportto);
            $project->report_time = $request->report_time;
            $project->tags = $request->tag;
            $project->country = $request->country;
            $project->state = $request->state;
            $project->city = $request->city;
            $project->zipcode = $request->zip;
            $project->latitude = $request->latitude;
            $project->longitude = $request->longitude;
            $project->micro_program = $microProgram;
            $project->save();
            if (Session::has("project_instance")) {
                $instanceId = Session::get("project_instance");
            } else {
                $instanceId = $project->instance_id;
            }
            if (isset($request->non_working_days)) {
                $checkNonWorkingDay = DB::table("non_working_days")
                    ->where("project_id", $project->id)
                    ->where("instance_id", $instanceId)
                    ->first();

                if ($checkNonWorkingDay == null) {
                    $nonWorkingDaysInsert = [
                        "project_id" => $project->id,
                        "non_working_days" => implode(
                            ",",
                            $request->non_working_days
                        ),
                        "instance_id" => $instanceId,
                        "created_by" => \Auth::user()->creatorId(),
                    ];
                    DB::table("non_working_days")->insert(
                        $nonWorkingDaysInsert
                    );
                } else {
                    $nonWorkingDaysUpdate = [
                        "project_id" => $project->id,
                        "non_working_days" => implode(
                            ",",
                            $request->non_working_days
                        ),
                        "created_by" => \Auth::user()->creatorId(),
                    ];
                    DB::table("non_working_days")
                        ->where("project_id", $project->id)
                        ->where("instance_id", $instanceId)
                        ->update($nonWorkingDaysUpdate);
                }
            }

            if ($setHolidays == 0) {
                $holiday_date = $request->holiday_date;

                foreach ($holiday_date as $holi_key => $holi_value) {
                    Holiday::where(
                        "created_by",
                        "=",
                        \Auth::user()->creatorId()
                    )
                        ->where("date", $holi_value)
                        ->first();
                    $project_holidays_list = Project_holiday::where([
                        "project_id" => $project->id,
                        "instance_id" => $instanceId,
                    ])
                        ->where("date", $holi_value)
                        ->first();
                    if ($project_holidays_list == null) {
                        $insert = [
                            "project_id" => $project->id,
                            "date" => $holi_value,
                            "description" =>
                            $request->holiday_description[$holi_key],
                            "created_by" => \Auth::user()->creatorId(),
                            "instance_id" => $instanceId,
                        ];
                        Project_holiday::insert($insert);
                    }
                }
            }

            return redirect()
                ->route("construction_main")
                ->with("success", __("Project Updated Successfully"));
        } else {
            return redirect()
                ->back()
                ->with("error", __("Permission Denied."));
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
        if (\Auth::user()->can("delete project")) {
            $projectID = $project->id;
            if (Session::has("project_instance")) {
                $instanceId = Session::get("project_instance");
            } else {
                $instanceId = $project->instance_id;
            }
            Con_task::where([
                "project_id" => $projectID,
                "instance_id" => $instanceId,
            ])->delete();
            Project_holiday::where([
                "project_id" => $projectID,
                "instance_id" => $instanceId,
            ])->delete();
            Instance::where("project_id", $projectID)->delete();

            if (!empty($project->image)) {
                Utility::checkFileExistsnDelete([$project->project_image]);
            }
            $project->delete();

            return redirect()
                ->back()
                ->with("success", __("Project Successfully Deleted."));
        } else {
            return redirect()
                ->back()
                ->with("error", __("Permission Denied."));
        }
    }

    public function inviteMemberView(Request $request, $project_id)
    {
        $project = Project::find($project_id);

        $user_project = $project->users->pluck("id")->toArray();

        $user_contact = User::where("created_by", \Auth::user()->creatorId())
            ->where("type", "!=", "client")
            ->whereNOTIn("id", $user_project)
            ->pluck("id")
            ->toArray();
        $arrUser = array_unique($user_contact);
        $users = User::whereIn("id", $arrUser)->get();

        return view("projects.invite", compact("project_id", "users"));
    }
    public function save_teammember(Request $request)
    {

        try {
            $authuser = Auth::user();
            $teammemberID = explode(',', $request->teammember_id);
            $project_id = explode(',', $request->project_id);
            $project = Project::find($project_id)->first();
            $type = $request->type;
            if (str_contains($type, 'subcontractor')) {
                foreach ($teammemberID as $id) {
                    $createConnection = ProjectSubcontractor::create([
                        "project_id" => $request->project_id,
                        "user_id" => $id,
                        "invited_by" => $authuser->id,
                        'invite_status' => 'requested',
                    ]);
                    $inviteUrl = url('') . Config::get('constants.INVITATION_URL_subcontractor_proj') . $createConnection->id;
                    $userArr = [
                        'invite_link' => $inviteUrl,
                        'user_name' => \Auth::user()->name,
                        'project_name' => $project->project_name,
                        'email' => \Auth::user()->email,
                    ];
                    Utility::sendEmailTemplate(Config::get('constants.INSR_PROJ'),
                        [$id => \Auth::user()->email], $userArr);
                }
                $msg = __('Sub Contractor Invitation to project sent successfully.');
                $routing = 'project.subcontractor';
            }
            if (str_contains($type, 'consultant')) {
                foreach ($teammemberID as $id) {
                    $createConnection = ProjectConsultant::create([
                        "project_id" => $request->project_id,
                        "user_id" => $id,
                        "invited_by" => $authuser->id,
                        'invite_status' => 'requested',
                    ]);
                    $inviteUrl = url('') . Config::get('constants.INVITATION_URL_consultant_proj') . $createConnection->id;
                    $userArr = [
                        'invite_link' => $inviteUrl,
                        'user_name' => \Auth::user()->name,
                        'project_name' => $project->project_name,
                        'email' => \Auth::user()->email,
                    ];
                    Utility::sendEmailTemplate(Config::get('constants.IN_CONSULTANT_PROJ'),
                        [$id => \Auth::user()->email], $userArr);
                }
                $msg = __('Consultant Invitation to project sent successfully.');
                $routing = 'project.consultant';

            }
            if (str_contains($type, 'teammember')) {
                foreach ($teammemberID as $id) {
                    $createConnection = ProjectUser::create([
                        "project_id" => $request->project_id,
                        "user_id" => $id,
                        "invited_by" => $authuser->id,
                        'invite_status' => 'requested',
                    ]);

                    $inviteUrl = url('') . Config::get('constants.INVITATION_URL_teammember') . $createConnection->id;
                    $userArr = [
                        'invite_link' => $inviteUrl,
                        'user_name' => \Auth::user()->name,
                        'project_name' => $project->project_name,
                        'email' => \Auth::user()->email,
                    ];
                    Utility::sendEmailTemplate(Config::get('constants.IN_TEAMMEMBER'),
                        [$id => \Auth::user()->email], $userArr);
                }
                $msg = __('Team Member Invitation Sent Successfully.');
                $routing = 'project.teammembers';

            }
            return redirect()->route($routing, $project_id)->with('success', $msg);

        } catch (Exception $e) {

            return $e->getMessage();

        }
    }
//    Team Member
    public function createConnection(Request $request)
    {
        // Need to check invitation link is valid or expired based on that need to redirect
        $checkConnection = ProjectUser::where(['id' => $request->id])->first();
        $project = Project::find($checkConnection->project_id)->first();
        $msg = 'valid';
        $type = "team member";
        return view('construction_project.invitation', compact('checkConnection', 'project', 'msg', 'type'));
    }

    public function submitConnection(Request $request)
    {
        $msg = $request->status;
        $type = "team member";
        ProjectUser::where(['id' => $request->id])->update(['invite_status' => $msg]);
        $checkConnection = ProjectUser::where(['id' => $request->id])->first();
        $project = Project::find($checkConnection->project_id)->first();
        return view('construction_project.invitation', compact('checkConnection', 'project', 'msg', 'type'));
    }
    //    Team Member
    public function createConnectionConsultant(Request $request)
    {
        // Need to check invitation link is valid or expired based on that need to redirect
        $checkConnection = ProjectConsultant::where(['id' => $request->id])->first();
        $project = Project::find($checkConnection->project_id)->first();
        $msg = 'valid';
        $type = "consultant";
        return view('construction_project.invitation', compact('checkConnection', 'project', 'msg', 'type'));
    }

    public function submitConnectionConsultant(Request $request)
    {
        $msg = $request->status;
        ProjectConsultant::where(['id' => $request->id])->update(['invite_status' => $msg]);
        $checkConnection = ProjectConsultant::where(['id' => $request->id])->first();
        $project = Project::find($checkConnection->project_id)->first();
        $type = "consultant";
        return view('construction_project.invitation', compact('checkConnection', 'project', 'msg', 'type'));
    }

    //    Team Member
    public function createConnectionSubcontractor(Request $request)
    {
        // Need to check invitation link is valid or expired based on that need to redirect
        $checkConnection = ProjectSubcontractor::where(['id' => $request->id])->first();
        $project = Project::find($checkConnection->project_id)->first();
        $msg = 'valid';
        $type = "sub contractor";
        return view('construction_project.invitation', compact('checkConnection', 'project', 'msg', 'type'));
    }

    public function submitConnectionSubcontractor(Request $request)
    {
        $msg = $request->status;
        ProjectSubcontractor::where(['id' => $request->id])->update(['invite_status' => $msg]);
        $checkConnection = ProjectSubcontractor::where(['id' => $request->id])->first();
        $project = Project::find($checkConnection->project_id)->first();
        $type = "sub contractor";
        return view('construction_project.invitation', compact('checkConnection', 'project', 'msg', 'type'));
    }
    public function inviteProjectUserMember(Request $request)
    {
        $authuser = Auth::user();

        // Make entry in project_user tbl
        ProjectUser::create([
            "project_id" => $request->project_id,
            "user_id" => $request->user_id,
            "invited_by" => $authuser->id,
        ]);

        // Make entry in activity_log tbl
        ActivityLog::create([
            "user_id" => $authuser->id,
            "project_id" => $request->project_id,
            "log_type" => "Invite User",
            "remark" => json_encode(["title" => $authuser->name]),
        ]);

        return json_encode([
            "code" => 200,
            "status" => "success",
            "success" => __("User invited successfully."),
        ]);
    }

    public function destroyProjectUser($id, $user_id)
    {
        $project = Project::find($id);
        if ($project->created_by == \Auth::user()->ownerId()) {
            ProjectUser::where("project_id", "=", $project->id)
                ->where("user_id", "=", $user_id)
                ->delete();

            return redirect()
                ->back()
                ->with("success", __("User successfully deleted!"));
        } else {
            return redirect()
                ->back()
                ->with("error", __("Permission Denied."));
        }
    }

    public function loadUser(Request $request)
    {
        if ($request->ajax()) {

            $project = Project::find($request->project_id);
            $type = $request->type;
            if (str_contains($type, 'subcontractor')) {
                $user_contact = ProjectSubcontractor::with('projectUsers')
                    ->where(['project_id' => $request->project_id])->get();
            }
            if (str_contains($type, 'consultant')) {
                $user_contact = ProjectConsultant::with('projectUsers')
                    ->where(['project_id' => $request->project_id])->get();

            }
            if (str_contains($type, 'teammember')) {
                $user_contact = ProjectUser::with('projectUsers')->where(['project_id' => $request->project_id])->get();
            }

            $returnHTML = view("projects.users", compact("project", "type", "user_contact"))->render();

            return response()->json([
                "success" => true,
                "html" => $returnHTML,
            ]);
        }
    }

    public function criticaltask_update(Request $request)
    {
        if ($request->ajax()) {
            $project = Project::find(Session::get("project_id"));

            if ($project->critical_update == 0) {

                foreach ($request->updatedTask as $value) {
                    if (isset($value['totalStack'])) {
                        $cleanedDateString = preg_replace('/\s\(.*\)/', '', $value['start_date']);
                        $carbonDate = Carbon::parse($cleanedDateString);
                        $carbonDate->addDays($value['totalStack']);
                        $total_slack = $carbonDate->format('Y-m-d');
                    } else {
                        $total_slack = null;
                    }
                    if (isset($value['freeSlack'])) {
                        $cleanedDateString = preg_replace('/\s\(.*\)/', '', $value['start_date']);
                        $carbonDate = Carbon::parse($cleanedDateString);
                        $carbonDate->addDays($value['freeSlack']);
                        $freeSlack = $carbonDate->format('Y-m-d');
                    } else {
                        $freeSlack = null;
                    }

                    Con_task::where('project_id', Session::get("project_id"))
                        ->where('instance_id', Session::get("project_instance"))
                        ->where('main_id', $value['main_id'])
                        ->update(['dependency_critical' => $freeSlack,
                            'entire_critical' => $total_slack,
                            'float_val' => $total_slack]);

                }

                Project::where('id', Session::get("project_id"))->update(['critical_update' => 1]);
            }
        }
    }

    public function get_member(Request $request)
    {
        if ($request->ajax()) {
            $user_array = [];
            $project = Project::find($request->project_id);

            if ($project != null) {
                foreach ($project->users as $user) {
                    if ($user->type != "company") {
                        $user_array[] = [
                            "key" => $user->id,
                            "label" => $user->name,
                        ];
                    }
                }
            }
            Session::put("project_member", $user_array);
            $returnHTML = view(
                "projects.get_member",
                compact("project")
            )->render();

            return [$user_array, $returnHTML];
        }
    }

    public function milestone($project_id)
    {
        if (\Auth::user()->can("create milestone")) {
            $project = Project::find($project_id);

            return view("projects.milestone", compact("project"));
        } else {
            return redirect()
                ->back()
                ->with("error", __("Permission Denied."));
        }
    }

    public function milestoneStore(Request $request, $project_id)
    {
        if (\Auth::user()->can("create milestone")) {
            $project = Project::find($project_id);
            $validator = Validator::make($request->all(), [
                "title" => "required",
                "status" => "required",
                "cost" => "required",
                "due_date" => "required",
                "start_date" => "required",
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(
                        "error",
                        Utility::errorFormat($validator->getMessageBag())
                    );
            }

            $milestone = new Milestone();
            $milestone->project_id = $project->id;
            $milestone->title = $request->title;
            $milestone->status = $request->status;
            $milestone->cost = $request->cost;
            $milestone->start_date = $request->start_date;
            $milestone->due_date = $request->due_date;
            $milestone->description = $request->description;
            $milestone->save();

            ActivityLog::create([
                "user_id" => \Auth::user()->id,
                "project_id" => $project->id,
                "log_type" => "Create Milestone",
                "remark" => json_encode(["title" => $milestone->title]),
            ]);

            return redirect()
                ->back()
                ->with("success", __("Milestone successfully created."));
        } else {
            return redirect()
                ->back()
                ->with("error", __("Permission Denied."));
        }
    }

    public function milestoneEdit($id)
    {
        if (\Auth::user()->can("edit milestone")) {
            $milestone = Milestone::find($id);

            return view("projects.milestoneEdit", compact("milestone"));
        } else {
            return redirect()
                ->back()
                ->with("error", __("Permission Denied."));
        }
    }

    public function milestoneUpdate($id, Request $request)
    {
        if (\Auth::user()->can("edit milestone")) {
            $validator = Validator::make($request->all(), [
                "title" => "required",
                "status" => "required",
                "cost" => "required",
                "due_date" => "required",
                "start_date" => "required",
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with(
                        "error",
                        Utility::errorFormat($validator->getMessageBag())
                    );
            }

            $milestone = Milestone::find($id);
            $milestone->title = $request->title;
            $milestone->status = $request->status;
            $milestone->cost = $request->cost;
            $milestone->progress = $request->progress;
            $milestone->due_date = $request->duedate;
            $milestone->start_date = $request->start_date;
            $milestone->description = $request->description;
            $milestone->save();

            return redirect()
                ->back()
                ->with("success", __("Milestone updated successfully."));
        } else {
            return redirect()
                ->back()
                ->with("error", __("Permission Denied."));
        }
    }

    public function milestoneDestroy($id)
    {
        if (\Auth::user()->can("delete milestone")) {
            $milestone = Milestone::find($id);
            $milestone->delete();

            return redirect()
                ->back()
                ->with("success", __("Milestone successfully deleted."));
        } else {
            return redirect()
                ->back()
                ->with("error", __("Permission Denied."));
        }
    }

    public function milestoneShow($id)
    {
        if (\Auth::user()->can("view milestone")) {
            $milestone = Milestone::find($id);

            return view("projects.milestoneShow", compact("milestone"));
        } else {
            return redirect()
                ->back()
                ->with("error", __("Permission Denied."));
        }
    }

    public function filterProjectView(Request $request)
    {
        if (\Auth::user()->can("manage project")) {
            $usr = Auth::user();
            if (\Auth::user()->type == "client") {
                $user_projects = Project::where("client_id", \Auth::user()->id)
                    ->where("created_by", \Auth::user()->creatorId())
                    ->pluck("id", "id")
                    ->toArray();
            } else {
                $user_projects = $usr
                    ->projects()
                    ->pluck("project_id", "project_id")
                    ->toArray();
            }

            $sort = explode("-", "created_at-desc");
            $projects = Project::whereIn(
                "id",
                array_keys($user_projects)
            )->orderBy($sort[0], $sort[1]);

            if (!empty($request->keyword)) {
                // $query='find_in_set("' . $request->keyword . '",tags)';
                // $projects->where('project_name', 'LIKE', $request->keyword . '%')
                // ->orWhereRaw($query);
            }
            if (!empty($request->status)) {
                $projects->whereIn("status", $request->status);
            }

            $projects = $projects->get();

            return view(
                "construction_project.construction_main",
                compact("projects", "user_projects")
            );
        } else {
            return redirect()
                ->back()
                ->with("error", __("Permission Denied."));
        }
    }

    // Project Gantt Chart
    public function gantt($projectID, $duration = "Week")
    {
        if (\Auth::user()->can("view grant chart")) {
            $project = Project::find($projectID);
            $tasks = [];
            if (Session::has("project_instance")) {
                $instanceId = Session::get("project_instance");
            } else {
                $instanceId = $project->instance_id;
            }
            $freezeCheck = Instance::where("project_id", $projectID)
                ->where("instance", $instanceId)
                ->first();

            $projectname = Project::where("id", Session::get("project_id"))
                ->pluck("project_name")
                ->first();

            if ($project) {
                $setting = Utility::settings(\Auth::user()->creatorId());
                if ($setting["company_type"] == 2) {
                    $project_holidays = Project_holiday::select("date")
                        ->where([
                            "project_id" => $projectID,
                            "instance_id" => $instanceId,
                        ])
                        ->get();

                    $nonWorkingDay = NonWorkingDaysModal::where(
                        "project_id",
                        $projectID
                    )
                        ->where("instance_id", $instanceId)
                        ->pluck("non_working_days")
                        ->first();
                    // critical bulk update
                    $critical_update = Project::where("id", Session::get("project_id"))
                        ->pluck('critical_update')->first();

                    return view(
                        "construction_project.gantt",
                        compact(
                            "project",
                            "tasks",
                            "duration",
                            "project_holidays",
                            "freezeCheck",
                            "nonWorkingDay",
                            "projectname",
                            'critical_update'
                        )
                    );
                } else {
                    $tasksobj = $project->tasks;
                    foreach ($tasksobj as $task) {
                        $tmp = [];
                        $tmp["id"] = "task_" . $task->id;
                        $tmp["name"] = $task->name;
                        $tmp["start"] = $task->start_date;
                        $tmp["end"] = $task->end_date;
                        $tmp["type"] = $task->type;
                        $tmp["custom_class"] = empty($task->priority_color)
                        ? "#ecf0f1"
                        : $task->priority_color;
                        $tmp["progress"] = str_replace(
                            "%",
                            "",
                            $task->taskProgress()["percentage"]
                        );
                        $tmp["extra"] = [
                            "priority" => ucfirst(__($task->priority)),
                            "comments" => count($task->comments),
                            "duration" =>
                            Utility::getDateFormated($task->start_date) .
                            " - " .
                            Utility::getDateFormated($task->end_date),
                        ];
                        $tasks[] = $tmp;
                    }
                }
            }

        } else {
            return redirect()
                ->back()
                ->with("error", __("Permission Denied."));
        }
    }

    public function gantt_data($projectID, Request $request)
    {
        $project = Project::find($projectID);
        if ($project) {
            $instanceId = Session::get("project_instance");
            $task = Con_task::where("project_id", $projectID)
                ->where("instance_id", $instanceId)
                ->orderBy("id", "ASC")
                ->get();

            $link = Link::where("project_id", $projectID)
                ->where("instance_id", $instanceId)
                ->orderBy("id", "ASC")
                ->get();

            return response()->json([
                "data" => $task,
                "links" => $link,
            ]);
        } else {
            return "";
        }
    }

    /**
     * Change a freezing status.
     *
     * @return \Illuminate\Http\Response
     */
    public function freeze_status_change(Request $request)
    {
        try {
            $instanceId = Session::get("project_instance");
            $conTask = Con_task::where([
                "project_id" => $request->project_id,
                "instance_id" => $instanceId,
            ])
                ->orderBy("id", "ASC")
                ->first();
            $data = [
                "start_date" => $conTask->start_date,
                "end_date" => $conTask->end_date,
                "estimated_days" => $conTask->duration,
            ];
            $instanceData = [
                "freeze_status" => 1,
                "start_date" => $conTask->start_date,
                "end_date" => $conTask->end_date,
            ];

            $getPreviousInstance = Con_task::where(
                "project_id",
                $request->project_id
            )
                ->where("instance_id", "!=", $instanceId)
                ->orderBy("id", "Desc")
                ->first();

            if ($getPreviousInstance != null) {
                $setPreviousInstance = $getPreviousInstance->instance_id;
                $getPreData = Con_task::where(
                    "project_id",
                    $request->project_id
                )
                    ->where("instance_id", $setPreviousInstance)
                    ->get();
                foreach ($getPreData as $insertPre) {
                    Con_task::where([
                        "project_id" => $request->project_id,
                        "instance_id" => $instanceId,
                        "id" => $insertPre->id,
                    ])->update(["progress" => $insertPre->progress]);
                }

                DB::select(
                    "INSERT INTO task_progress(
                            task_id,assign_to,percentage,date_status,description,user_id,project_id,instance_id,
                            file_id,record_date,created_at,updated_at
                        )
                        SELECT task_id,assign_to,percentage,date_status,description,user_id,project_id,
                        '" .
                    $instanceId .
                    "' as instance_id,file_id,record_date,created_at,updated_at
                        FROM task_progress WHERE project_id = " .
                    $request->project_id .
                    " AND
                        instance_id='" .
                    $setPreviousInstance .
                    "'"
                );

                DB::select(
                    "INSERT INTO task_progress_file(
                            task_id,project_id,instance_id,filename,file_path,status
                        )
                        SELECT task_id,project_id,'" .
                    $instanceId .
                    "' as instance_id,
                        filename,file_path,status
                        FROM task_progress_file WHERE project_id = " .
                    $request->project_id .
                    " AND
                        instance_id='" .
                    $setPreviousInstance .
                    "'"
                );

                $taskProgresskData = Task_progress::where(
                    "project_id",
                    $request->project_id
                )
                    ->where("instance_id", $instanceId)
                    ->get();

                $taskFileData = DB::table("task_progress_file")
                    ->where("project_id", $request->project_id)
                    ->where("instance_id", $instanceId)
                    ->get();

                $taskProgressTaskId = [];
                $taskFileDataId = [];

                if (!empty($taskProgresskData)) {
                    foreach ($taskProgresskData as $taskProgress) {
                        if (
                            !in_array(
                                $taskProgress->task_id,
                                $taskProgressTaskId
                            )
                        ) {
                            $getCorrectData = Con_task::select(
                                "id",
                                "text",
                                "duration",
                                "start_date",
                                "end_date",
                                "type"
                            )
                                ->where("main_id", $taskProgress->task_id)
                                ->first();

                            $getOrginalTask = Con_task::where(
                                "id",
                                $getCorrectData->id
                            )
                                ->where("project_id", $request->project_id)
                                ->where(
                                    "start_date",
                                    $getCorrectData->start_date
                                )
                                ->where("end_date", $getCorrectData->end_date)
                                ->where("instance_id", $instanceId)
                                ->first();

                            if ($getOrginalTask != null) {
                                Task_progress::where(
                                    "project_id",
                                    $request->project_id
                                )
                                    ->where("instance_id", $instanceId)
                                    ->where("task_id", $taskProgress->task_id)
                                    ->update([
                                        "task_id" => $getOrginalTask->main_id,
                                    ]);
                            }
                            $taskProgressTaskId[] = $taskProgress->task_id;
                        }
                    }
                }

                if (!empty($taskFileData)) {
                    foreach ($taskFileData as $taskFileDataSet) {
                        if (
                            !in_array(
                                $taskFileDataSet->task_id,
                                $taskFileDataId
                            )
                        ) {
                            $getCorrectData = Con_task::select(
                                "id",
                                "text",
                                "duration",
                                "start_date",
                                "end_date",
                                "type"
                            )
                                ->where("main_id", $taskFileDataSet->task_id)
                                ->first();

                            $getOrginalTask = Con_task::where(
                                "id",
                                $getCorrectData->id
                            )
                                ->where("project_id", $request->project_id)
                                ->where(
                                    "start_date",
                                    $getCorrectData->start_date
                                )
                                ->where("end_date", $getCorrectData->end_date)
                                ->where("instance_id", $instanceId)
                                ->first();

                            if ($getOrginalTask != null) {
                                DB::table("task_progress_file")
                                    ->where("project_id", $request->project_id)
                                    ->where("instance_id", $instanceId)
                                    ->where(
                                        "task_id",
                                        $taskFileDataSet->task_id
                                    )
                                    ->update([
                                        "task_id" => $getOrginalTask->main_id,
                                    ]);
                            }
                            $taskFileDataId[] = $taskFileDataSet->task_id;
                        }
                    }
                }
            }

            Project::where("id", $request->project_id)->update($data);
            Instance::where("project_id", $request->project_id)
                ->where("instance", $instanceId)
                ->update($instanceData);
            Session::put("current_revision_freeze", 1);

            return redirect()
                ->back()
                ->with("success", __("Baseline Status successfully changed."));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Get a freezing status.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_gantt_task_count(Request $request)
    {
        $instanceId = Session::get("project_instance");
        $task = Con_task::where("project_id", $request->project_id)
            ->where("instance_id", $instanceId)
            ->get();

        return count($task);
    }

    public function get_freeze_status(Request $request)
    {
        try {
            return Instance::where("project_id", $request->project_id)
                ->where("instance", Session::get("project_instance"))
                ->pluck("freeze_status")
                ->first();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function ganttPost($projectID, Request $request)
    {
        $project = Project::find($projectID);

        if ($project) {
            if (\Auth::user()->can("view project task")) {
                $id = trim($request->task_id, "task_");
                $task = ProjectTask::find($id);
                $task->start_date = $request->start;
                $task->end_date = $request->end;

                $task->save();

                return response()->json(
                    [
                        "is_success" => true,
                        "message" => __("Time Updated"),
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        "is_success" => false,
                        "message" => __("You can't change Date!"),
                    ],
                    400
                );
            }
        } else {
            return response()->json(
                [
                    "is_success" => false,
                    "message" => __("Something is wrong."),
                ],
                400
            );
        }
    }

    public function bug($project_id)
    {
        $user = Auth::user();
        if ($user->can("manage bug report")) {
            $project = Project::find($project_id);

            if (
                !empty($project) &&
                $project->created_by == Auth::user()->creatorId()
            ) {
                if ($user->type != "company") {
                    if (\Auth::user()->type == "client") {
                        $bugs = Bug::where("project_id", $project->id)->get();
                    } else {
                        $bugs = Bug::where("project_id", $project->id)
                            ->whereRaw(
                                "find_in_set('" . $user->id . "',assign_to)"
                            )
                            ->get();
                    }
                }

                if ($user->type == "company") {
                    $bugs = Bug::where("project_id", "=", $project_id)->get();
                }

                return view("projects.bug", compact("project", "bugs"));
            } else {
                return redirect()
                    ->back()
                    ->with("error", __("Permission Denied."));
            }
        } else {
            return redirect()
                ->back()
                ->with("error", __("Permission Denied."));
        }
    }

    public function bugCreate($project_id)
    {
        if (\Auth::user()->can("create bug report")) {
            $priority = Bug::$priority;
            $status = BugStatus::where(
                "created_by",
                "=",
                \Auth::user()->creatorId()
            )
                ->get()
                ->pluck("title", "id");
            $project_user = ProjectUser::where(
                "project_id",
                $project_id
            )->get();

            $users = [];
            foreach ($project_user as $key => $user) {
                $user_data = User::where("id", $user->user_id)->first();
                $key = $user->user_id;
                $user_name = !empty($user_data) ? $user_data->name : "";
                $users[$key] = $user_name;
            }

            return view(
                "projects.bugCreate",
                compact("status", "project_id", "priority", "users")
            );
        } else {
            return redirect()
                ->back()
                ->with("error", __("Permission Denied."));
        }
    }

    public function bugNumber()
    {
        $latest = Bug::where("created_by", "=", \Auth::user()->creatorId())
            ->latest()
            ->first();
        if (!$latest) {
            return 1;
        }

        return $latest->bug_id + 1;
    }

    public function bugStore(Request $request, $project_id)
    {
        if (\Auth::user()->can("create bug report")) {
            $validator = \Validator::make($request->all(), [
                "title" => "required",
                "priority" => "required",
                "status" => "required",
                "assign_to" => "required",
                "start_date" => "required",
                "due_date" => "required",
            ]);
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()
                    ->route("task.bug", $project_id)
                    ->with("error", $messages->first());
            }

            $usr = \Auth::user();
            $userProject = ProjectUser::where("project_id", "=", $project_id)
                ->pluck("user_id")
                ->toArray();
            $project = Project::where("id", "=", $project_id)->first();

            $bug = new Bug();
            $bug->bug_id = $this->bugNumber();
            $bug->project_id = $project_id;
            $bug->title = $request->title;
            $bug->priority = $request->priority;
            $bug->start_date = $request->start_date;
            $bug->due_date = $request->due_date;
            $bug->description = $request->description;
            $bug->status = $request->status;
            $bug->assign_to = $request->assign_to;
            $bug->created_by = \Auth::user()->creatorId();
            $bug->save();

            ActivityLog::create([
                "user_id" => $usr->id,
                "project_id" => $project_id,
                "log_type" => "Create Bug",
                "remark" => json_encode(["title" => $bug->title]),
            ]);

            $projectArr = [
                "project_id" => $project_id,
                "name" => $project->name,
                "updated_by" => $usr->id,
            ];

            return redirect()
                ->route("task.bug", $project_id)
                ->with("success", __("Bug successfully created."));
        } else {
            return redirect()
                ->back()
                ->with("error", __("Permission Denied."));
        }
    }

    public function bugEdit($project_id, $bug_id)
    {
        if (\Auth::user()->can("edit bug report")) {
            $bug = Bug::find($bug_id);
            $priority = Bug::$priority;
            $status = BugStatus::where(
                "created_by",
                "=",
                \Auth::user()->creatorId()
            )
                ->get()
                ->pluck("title", "id");
            $project_user = ProjectUser::where(
                "project_id",
                $project_id
            )->get();
            $users = [];
            foreach ($project_user as $user) {
                $user_data = User::where("id", $user->user_id)->first();
                $key = $user->user_id;
                $user_name = !empty($user_data) ? $user_data->name : "";
                $users[$key] = $user_name;
            }

            return view(
                "projects.bugEdit",
                compact("status", "project_id", "priority", "users", "bug")
            );
        } else {
            return redirect()
                ->back()
                ->with("error", __("Permission Denied."));
        }
    }

    public function bugUpdate(Request $request, $project_id, $bug_id)
    {
        if (\Auth::user()->can("edit bug report")) {
            $validator = \Validator::make($request->all(), [
                "title" => "required",
                "priority" => "required",
                "status" => "required",
                "assign_to" => "required",
                "start_date" => "required",
                "due_date" => "required",
            ]);
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()
                    ->route("task.bug", $project_id)
                    ->with("error", $messages->first());
            }
            $bug = Bug::find($bug_id);
            $bug->title = $request->title;
            $bug->priority = $request->priority;
            $bug->start_date = $request->start_date;
            $bug->due_date = $request->due_date;
            $bug->description = $request->description;
            $bug->status = $request->status;
            $bug->assign_to = $request->assign_to;
            $bug->save();

            return redirect()
                ->route("task.bug", $project_id)
                ->with("success", __("Bug successfully created."));
        } else {
            return redirect()
                ->back()
                ->with("error", __("Permission Denied."));
        }
    }

    public function bugDestroy($project_id, $bug_id)
    {
        if (\Auth::user()->can("delete bug report")) {
            $bug = Bug::find($bug_id);
            $bug->delete();

            return redirect()
                ->route("task.bug", $project_id)
                ->with("success", __("Bug successfully deleted."));
        } else {
            return redirect()
                ->back()
                ->with("error", __("Permission Denied."));
        }
    }

    public function bugKanban($project_id)
    {
        $user = Auth::user();
        if ($user->can("move bug report")) {
            $project = Project::find($project_id);

            if (
                !empty($project) &&
                $project->created_by == $user->creatorId()
            ) {
                if ($user->type != "company") {
                    $bugStatus = BugStatus::where(
                        "created_by",
                        "=",
                        Auth::user()->creatorId()
                    )
                        ->orderBy("order", "ASC")
                        ->get();
                }

                if ($user->type == "company" || $user->type == "client") {
                    $bugStatus = BugStatus::where(
                        "created_by",
                        "=",
                        Auth::user()->creatorId()
                    )
                        ->orderBy("order", "ASC")
                        ->get();
                }

                return view(
                    "projects.bugKanban",
                    compact("project", "bugStatus")
                );
            } else {
                return redirect()
                    ->back()
                    ->with("error", __("Permission Denied."));
            }
        } else {
            return redirect()
                ->back()
                ->with("error", __("Permission Denied."));
        }
    }

    public function bugKanbanOrder(Request $request)
    {
        //        dd($request->all());
        if (\Auth::user()->can("move bug report")) {
            $post = $request->all();
            $bug = Bug::find($post["bug_id"]);

            $status = BugStatus::find($post["status_id"]);

            if (!empty($status)) {
                $bug->status = $post["status_id"];
                $bug->save();
            }

            foreach ($post["order"] as $key => $item) {
                if (!empty($item)) {
                    $bug_order = Bug::find($item);
                    $bug_order->order = $key;
                    $bug_order->status = $post["status_id"];
                    $bug_order->save();
                }
            }
        } else {
            return redirect()
                ->back()
                ->with("error", __("Permission Denied."));
        }
    }

    public function bugShow($project_id, $bug_id)
    {
        $bug = Bug::find($bug_id);

        return view("projects.bugShow", compact("bug"));
    }

    public function bugCommentStore(Request $request, $project_id, $bug_id)
    {
        $post = [];
        $post["bug_id"] = $bug_id;
        $post["comment"] = $request->comment;
        $post["created_by"] = \Auth::user()->authId();
        $post["user_type"] = \Auth::user()->type;
        $comment = BugComment::create($post);
        $comment->deleteUrl = route("bug.comment.destroy", [$comment->id]);

        return response()->json(
            [
                "is_success" => true,
                "message" => __("Bug comment successfully created."),
            ],
            200
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
        $request->validate(["file" => "required"]);
        $fileName =
        $bug_id . time() . "_" . $request->file->getClientOriginalName();

        $request->file->storeAs("bugs", $fileName);
        $post["bug_id"] = $bug_id;
        $post["file"] = $fileName;
        $post["name"] = $request->file->getClientOriginalName();
        $post["extension"] = "." . $request->file->getClientOriginalExtension();
        $post["file_size"] =
            round($request->file->getSize() / 1024 / 1024, 2) . " MB";
        $post["created_by"] = \Auth::user()->authId();
        $post["user_type"] = \Auth::user()->type;

        $BugFile = BugFile::create($post);
        $BugFile->deleteUrl = route("bug.comment.file.destroy", [$BugFile->id]);

        return $BugFile->toJson();
    }

    public function bugCommentDestroyFile(Request $request, $file_id)
    {
        $commentFile = BugFile::find($file_id);
        $path = storage_path("bugs/" . $commentFile->file);
        if (file_exists($path)) {
            \File::delete($path);
        }
        $commentFile->delete();

        return "true";
    }

    public function tracker($id)
    {
        $treckers = TimeTracker::where("project_id", $id)->get();

        return view("time_trackers.index", compact("treckers"));
    }

    public function getProjectChart($arrParam)
    {
        $arrDuration = [];
        if ($arrParam["duration"] && $arrParam["duration"] == "week") {
            $previous_week = Utility::getFirstSeventhWeekDay(-1);
            foreach ($previous_week["datePeriod"] as $dateObject) {
                $arrDuration[
                    $dateObject->format("Y-m-d")
                ] = $dateObject->format("D");
            }
        }

        $arrTask = [
            "label" => [],
            "color" => [],
        ];
        $stages = TaskStage::where(
            "created_by",
            "=",
            $arrParam["created_by"]
        )->orderBy("order");

        foreach ($arrDuration as $date => $label) {
            $objProject = projectTask::select(
                "stage_id",
                \DB::raw("count(*) as total")
            )
                ->whereDate("updated_at", "=", $date)
                ->groupBy("stage_id");

            if (isset($arrParam["project_id"])) {
                $objProject->where("project_id", "=", $arrParam["project_id"]);
            }

            $data = $objProject->pluck("total", "stage_id")->all();

            foreach ($stages->pluck("name", "id")->toArray() as $id => $stage) {
                $arrTask[$id][] = isset($data[$id]) ? $data[$id] : 0;
            }
            $arrTask["label"][] = __($label);
        }
        $arrTask["stages"] = $stages->pluck("name", "id")->toArray();

        return $arrTask;
    }

    public function taskupdate(Request $request)
    {
        $projectId = Session::get("project_id");
        $getProject = Project::find($projectId);

        if (Session::has("project_id")) {
            $instanceId = Session::get("project_instance");
        } else {
            $instanceId = $getProject->instance_id;
        }

        $validator = \Validator::make($request->all(), [
            "task_id" => "required",
            "percentage" => "required",
            "description" => "required",
            "user_id" => "required",
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->with(
                    "error",
                    Utility::errorFormat($validator->getMessageBag())
                );
        }

        $get_all_dates = [];
        $fileNameToStore1 = "";
        $url = "";
        $task_id = $request->task_id;
        $task = Con_task::where("main_id", $task_id)
            ->where("instance_id", $instanceId)
            ->first();
        $nonWorkingDay = NonWorkingDaysModal::where(
            "project_id",
            $task->project_id
        )
            ->where("instance_id", $instanceId)
            ->orderBy("id", "DESC")
            ->first();
        $get_non_work_day = [];

        if (
            $nonWorkingDay != null &&
            $nonWorkingDay->non_working_days != null
        ) {
            $split_non_working = explode(",", $nonWorkingDay->non_working_days);
            foreach ($split_non_working as $non_working) {
                if ($non_working == 0) {
                    $get_non_work_day[] = "Sunday";
                } elseif ($non_working == 1) {
                    $get_non_work_day[] = "Monday";
                } elseif ($non_working == 2) {
                    $get_non_work_day[] = "Tuesday";
                } elseif ($non_working == 3) {
                    $get_non_work_day[] = "Wednesday";
                } elseif ($non_working == 4) {
                    $get_non_work_day[] = "Thursday";
                } elseif ($non_working == 5) {
                    $get_non_work_day[] = "Friday";
                } elseif ($non_working == 6) {
                    $get_non_work_day[] = "Saturday";
                }
            }
        }

        $getCurrentDay = date("l", strtotime($request->get_date));

        if (\Auth::user()->type == "company") {
            $getHoliday = Project_holiday::where(
                "created_by",
                \Auth::user()->id
            )
                ->where("instance_id", $instanceId)
                ->get();
        } else {
            $getHoliday = Project_holiday::where(
                "created_by",
                \Auth::user()->creatorId()
            )
                ->where("instance_id", $instanceId)
                ->get();
        }

        foreach ($getHoliday as $check_holiday) {
            $get_all_dates[] = $check_holiday->date;
        }

        $holiday_merge = $this->array_flatten($get_all_dates);
        $date1 = date_create($task->start_date);
        $date2 = date_create($task->end_date);
        $diff = date_diff($date1, $date2);
        $file_id_array = [];

        $no_working_days = $diff->format("%a");
        //$no_working_days  = $no_working_days+1; // include the last day
        $no_working_days = $task->duration;

        $checkPercentage = Task_progress::where("task_id", $task_id)
            ->where("project_id", $task->project_id)
            ->where("instance_id", $instanceId)
            ->whereDate("created_at", $request->get_date)
            ->first();
        $checkPercentageGet = isset($checkPercentage->percentage)
        ? $checkPercentage->percentage
        : 0;

        if (in_array($request->get_date, $holiday_merge)) {
            return redirect()
                ->back()
                ->with(
                    "error",
                    __(
                        $request->get_date .
                        " You have chosen a non-working day; if you want to update the progress, please select a working day."
                    )
                );
        } elseif (in_array($getCurrentDay, $get_non_work_day)) {
            return redirect()
                ->back()
                ->with("error", __("This day is a non-working day."));
        } elseif ($checkPercentageGet > $request->percentage) {
            return redirect()
                ->back()
                ->with(
                    "error",
                    __("This percentage is too low compare to old percentage.")
                );
        } else {
            if ($request->attachment_file_name != null) {
                foreach ($request->attachment_file_name as $file_req) {
                    $filenameWithExt1 = $file_req->getClientOriginalName();
                    $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                    $extension1 = $file_req->getClientOriginalExtension();
                    $fileNameToStore1 =
                    $filename1 . "_" . time() . "." . $extension1;
                    $dir = "uploads/task_particular_list";
                    $image_path = $dir . $filenameWithExt1;

                    if (\File::exists($image_path)) {
                        \File::delete($image_path);
                    }

                    $path = Utility::multi_upload_file(
                        $file_req,
                        "file_req",
                        $fileNameToStore1,
                        $dir,
                        []
                    );

                    if ($path["flag"] == 1) {
                        $url = $path["url"];

                        $file_insert = [
                            "task_id" => $task_id,
                            "project_id" => $task->project_id,
                            "filename" => $fileNameToStore1,
                            "file_path" => $url,
                        ];
                        $file_insert_id = DB::table(
                            "task_progress_file"
                        )->insertGetId($file_insert);
                        $file_id_array[] = $file_insert_id;
                    } else {
                        return redirect()
                            ->back()
                            ->with("error", __($path["msg"]));
                    }
                }
                $implode_file_id =
                count($file_id_array) != 0
                ? implode(",", $file_id_array)
                : 0;

                if ($request->existing_file_id != "") {
                    $implode_file_id =
                    $request->existing_file_id . "," . $implode_file_id;
                }
            } else {
                $get_file_id = Task_progress::where("task_id", $task_id)
                    ->where("project_id", $task->project_id)
                    ->where("instance_id", $instanceId)
                    ->whereDate("created_at", $request->get_date)
                    ->first();
                if ($get_file_id != null) {
                    $implode_file_id = $get_file_id->file_id;
                } else {
                    $implode_file_id = 0;
                }
            }

            $date_status =
            strtotime($task->end_date) > time() ? "As Per Time" : "Overdue";

            if (\Auth::user()->type == "company") {
                $assign_to = $task->users != null ? $task->users : null;
            } else {
                $assign_to = \Auth::user()->id;
            }

            // insert details
            $array = [
                "task_id" => $task_id,
                "assign_to" => $assign_to,
                "percentage" => $request->percentage,
                "description" => $request->description,
                "user_id" => $request->user_id,
                "project_id" => $task->project_id,
                "instance_id" => $instanceId,
                "date_status" => $date_status,
                "file_id" => $implode_file_id,
                "created_at" => $request->get_date, //Planned Date
                "record_date" => date("Y-m-d H:m:s"), //Actual Date
            ];
            $revision_array = [
                "task_id" => $task_id,
                "task_name" => $task->text,
                "user_id" => $request->user_id,
                "project_id" => $task->project_id,
                "instance_id" => $instanceId,
            ];
            $check_data = Task_progress::where("task_id", $task_id)
                ->where("project_id", $task->project_id)
                ->where("instance_id", $instanceId)
                ->whereDate("created_at", $request->get_date)
                ->first();
            $record = DB::table("instance")
                ->where("project_id", $task->project_id)
                ->where("freeze_status", 0)
                ->first();
            if ($check_data == null) {
                Task_progress::insert($array);

                if ($record) {
                    DB::table("revision_task_progress")->insert(
                        $revision_array
                    );
                    Con_task::where("project_id", $task->project_id)
                        ->where("instance_id", $record->instance)
                        ->where("id", $task->id)
                        ->update(["work_flag" => "1"]);
                }

                ActivityController::activity_store(
                    Auth::user()->id,
                    Session::get("project_id"),
                    "Added Progress",
                    $task->text
                );
            } else {
                Task_progress::where("task_id", $task_id)
                    ->where("project_id", $task->project_id)
                    ->where("instance_id", $instanceId)
                    ->where("created_at", $request->get_date)
                    ->update($array);
                if ($record) {
                    DB::table("revision_task_progress")
                        ->where("project_id", $task->project_id)
                        ->where("instance_id", $instanceId)
                        ->where("created_at", $request->get_date)
                        ->update($revision_array);
                    Con_task::where("project_id", $task->project_id)
                        ->where("instance_id", $record->instance)
                        ->where("id", $task->id)
                        ->update(["work_flag" => "1"]);
                }

                ActivityController::activity_store(
                    Auth::user()->id,
                    Session::get("project_id"),
                    "Updated Progress",
                    $task->text
                );
            }

            $total_pecentage = Task_progress::where("task_id", $task_id)
                ->where("instance_id", $instanceId)
                ->sum("percentage");
            $per_percentage = $total_pecentage / $no_working_days;
            $per_percentage = round($per_percentage);
            Con_task::where("main_id", $task_id)
                ->where("instance_id", $instanceId)
                ->update(["progress" => $per_percentage]);
            // update the  gantt
            // dd($task);
            //##################################################
            $alltask = Con_task::where([
                "project_id" => $task->project_id,
                "instance_id" => $instanceId,
            ])
                ->where("type", "project")
                ->get();
            foreach ($alltask as $key => $value) {
                $task_id = $value->main_id;
                $total_percentage = Con_task::where([
                    "project_id" => $task->project_id,
                    "instance_id" => $instanceId,
                ])
                    ->where("parent", $value->id)
                    ->avg("progress");
                $total_percentage = round($total_percentage);
                if ($total_percentage != null) {
                    Con_task::where("main_id", $task_id)
                        ->where([
                            "project_id" => $task->project_id,
                            "instance_id" => $instanceId,
                        ])
                        ->update(["progress" => $total_percentage]);
                }
            }
            //##################################################

            return redirect()
                ->back()
                ->with("success", __("Task successfully Updated."));
        }
    }

    public function taskpersentage_update($project_id)
    {
        $project = Project::find($project_id);
        if (Session::has("project_instance")) {
            $instanceId = Session::get("project_instance");
        } else {
            $instanceId = $project->instance_id;
        }

        $alltask = Con_task::where([
            "project_id" => $project_id,
            "instance_id" => $instanceId,
        ])->get();
        foreach ($alltask as $key => $value) {
            $task_id = $value->main_id;
            $total_percentage = Con_task::where([
                "project_id" => $project_id,
                "instance_id" => $instanceId,
            ])
                ->where("parent", $value->id)
                ->avg("progress");
            $total_percentage = round($total_percentage);
            if ($total_percentage != null) {
                Con_task::where("main_id", $task_id)
                    ->where(["instance_id" => $instanceId])
                    ->update(["progress" => $total_percentage]);
            }
        }
    }

    public function getBetweenDates($startDate, $endDate)
    {
        $array = [];
        $interval = new DateInterval("P1D");

        $realEnd = new DateTime($endDate);
        $realEnd->add($interval);

        $period = new DatePeriod(new DateTime($startDate), $interval, $realEnd);

        $array = [];
        foreach ($period as $date) {
            array_push($array, $date->format("Y-m-d"));
        }

        return $array;
    }

    public function array_flatten($array)
    {
        if (!is_array($array)) {
            return false;
        }
        $result = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, $this->array_flatten($value));
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }
    public function invite_teammember(Request $request, $project_id)
    {
        try {
            return view('construction_project.invite')->with('project_id', $project_id);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function search_member(Request $request, $project_id)
    {

        try {

            $searchValue = $request['q'];
            $type = $request['type'];

            if ($request->filled('q')) {

                if (str_contains($type, 'subcontractor')) {
                    $user_contact = User::where("created_by", \Auth::user()->creatorId())
                        ->whereIn("type", ["sub_contractor"])
                        ->pluck("id")
                        ->toArray();
                }
                if (str_contains($type, 'consultant')) {
                    $user_contact = User::where("created_by", \Auth::user()->creatorId())
                        ->whereIn("type", ["consultant"])
                        ->pluck("id")
                        ->toArray();
                }
                if (str_contains($type, 'teammembers')) {
                    $user_contact = User::where("created_by", \Auth::user()->creatorId())
                        ->whereNotIn("type", ["sub_contractor", "consultant", "admin", "client"])
                        ->pluck("id")
                        ->toArray();
                }

                $arrUser = array_unique($user_contact);

                if ($request->filled('q')) {
                    $userlist = User::search($searchValue)
                        ->whereIn("id", $arrUser)
                        ->orderBy('name', 'ASC')
                        ->get();

                }
            }

            $userData = array();
            if (count($userlist) > 0) {
                foreach ($userlist as $task) {
                    $setUser = [
                        'id' => $task->id,
                        'name' => $task->name . ' - ' . $task->email,
                    ];
                    $userData[] = $setUser;
                }
            }

            echo json_encode($userData);

        } catch (Exception $e) {

            return $e->getMessage();

        }

    }

    public function task_assignee_search(Request $request)
    {

        try {

            $searchValue = $request['q'];

            if ($request->filled('q')) {

                if (\Auth::user()->type != 'company') {
                    $userid = Auth::user()->creatorId();
                } else {
                    $userid = \Auth::user()->id;
                }

                $user_contact = User::where("created_by", $userid)
                    ->whereNotIn("type", ["sub_contractor", "consultant", "admin", "client"])
                    ->pluck("id")
                    ->toArray();

                $arrUser = array_unique($user_contact);

                if ($request->filled('q')) {
                    $userlist = User::search($searchValue)
                        ->whereIn("id", $arrUser)
                        ->orderBy('name', 'ASC')
                        ->get();

                }
            }

            $userData = array();
            if (count($userlist) > 0) {
                foreach ($userlist as $task) {
                    $setUser = [
                        'id' => $task->id,
                        'name' => $task->name . ' - ' . $task->email,
                    ];
                    $userData[] = $setUser;
                }
            }

            echo json_encode($userData);

        } catch (Exception $e) {

            return $e->getMessage();

        }

    }

    public function get_assignee_name(Request $request)
    {
        try {

            $getval = User::where('id', $request->id)->first();
            return json_decode($getval);

        } catch (Exception $e) {

            return $e->getMessage();

        }

    }

    public function get_reporter_name(Request $request)
    {

        try {

            $getname = User::where('id', $request->id)->first();
          
            return json_decode($getname);

        } catch (Exception $e) {

            return $e->getMessage();

        }

    }
}
