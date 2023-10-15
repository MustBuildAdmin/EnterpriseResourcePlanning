<?php
namespace App\Http\Controllers;
use App\Exports\task_reportExport;
use App\Jobs\Reportemail;
use App\Models\Con_task;
use App\Models\Milestone;
use App\Models\Project;
use App\Models\ProjectTask;
use App\Models\TaskStage;
use App\Models\Timesheet;
use App\Models\User;
use App\Models\Utility;
use Barryvdh\DomPDF\Facade\Pdf;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProjectReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $taskNotStarted="Task Not Started";
    public $notAssign="Not Assign a Report person";
    public $allProjects="projects.*";
    public $typeSuperAdmin='super admin';
    public $notFinish="Task Not Finish";
    public $daysString=" Days";
    public $norecord="NO Record Found";
    public $sheetRows='A2:K2';
    public $sheetRows1="A1:K1";
    public $sheetCol1="A1:I1";
    public $plannedStartDate="Planned Start Date";
    public $plannedFinish="Planned Finish";
    public $sheetbgColor="0f609b";
    public $findinSet="find_in_set('";
    public $usersSet="',users)";
    public function index(Request $request)
    {
        $user = \Auth::user();

        if ($user->type == 'client') {
            if (Session::has('project_id')) {
                $projects = Project::where('id', Session::get('project_id'))->where('client_id', '=', $user->id);
            } else {
                $projects = Project::where('client_id', '=', $user->id);
            }

            $users = [];
            $status = [];

        } elseif (\Auth::user()->type == 'company') {

            if (isset($request->all_users) && ! empty($request->all_users)) {
                $projects = Project::select($this->allProjects)
                    ->leftjoin('project_users', 'project_users.project_id', 'projects.id')
                    ->where('project_users.user_id', '=', $request->all_users);

            } else {
                $projects = Project::where('projects.created_by', '=', $user->id);
            }

            if (Session::has('project_id')) {
                $projects->where('projects.id', Session::get('project_id'));
            }

            if (isset($request->status) && ! empty($request->status)) {
                $projects->where('status', '=', $request->status);
            }
            if (isset($request->start_date) && ! empty($request->start_date)) {
                $projects->where('start_date', '=', $request->start_date);

            }
            if (isset($request->end_date) && ! empty($request->end_date)) {
                $projects->where('end_date', '=', $request->end_date);

            }

            $users = User::where('created_by', '=', $user->creatorId())->where('type', '!=', 'client')->get();
            $status = Project::$project_status;

        } else {
            $projects = Project::select($this->allProjects)
                ->leftjoin('project_users', 'project_users.project_id', 'projects.id')
                ->where('project_users.user_id', '=', $user->id);

            if (Session::has('project_id')) {
                $projects->where('id', Session::get('project_id'));
            }
        }

        $projects = $projects->orderby('id', 'desc')->get();

        return view('construction_project.report', compact('projects', 'users', 'status'));
    }

    public function show(Request $request, $id)
    {

        $user = \Auth::user();

        if (\Auth::user()->type == $this->typeSuperAdmin) {
            $users = User::where('created_by', '=', $user->creatorId())->where('type', '=', 'company')->get();
        } else {
            $users = User::where('created_by', '=', $user->creatorId())->where('type', '!=', 'client')->get();
        }

        if ($user->type == 'client') {
            $project = Project::where('client_id', '=', $user->id)->where('id', $id)->first();
        } elseif (\Auth::user()->type == 'employee') {

            $project = Project::select($this->allProjects)
                ->leftjoin('project_users', 'project_users.project_id', 'projects.id')
                ->where('project_users.user_id', '=', $user->id)->first();

        } else {
            $project = Project::where('created_by', '=', $user->id)->where('id', $id)->first();
        }

        if ($user) {
            $daysleft = round((((strtotime($user->end_date) - strtotime(date('Y-m-d'))) / 24) / 60) / 60);

            $project_status_task = TaskStage::join('project_tasks', 'project_tasks.stage_id', '=', 'task_stages.id')
                ->where('project_tasks.project_id', '=', $id)->groupBy('task_stages.name')
                ->selectRaw('count(project_tasks.stage_id) as count, task_stages.name as task_stages_name')
                ->pluck('count', 'task_stages_name');
            $totaltask = ProjectTask::where('project_id', $id)->count();

            $arrProcessPer_status_task = [];
            $arrProcess_Label_status_tasks = [];
            foreach ($project_status_task as $lables => $percentage_stage) {
                $arrProcess_Label_status_tasks[] = $lables;
                if ($totaltask == 0) {
                    $arrProcessPer_status_task[] = 0.00;
                } else {
                    $arrProcessPer_status_task[] = round(($percentage_stage * 100) / $totaltask, 2);
                }
            }

            $project_priority_task = ProjectTask::where('project_id', $id)->groupBy('priority')
                ->selectRaw('count(id) as count, priority')->pluck('count', 'priority');

            $arrProcessPer_priority = [];
            $arrProcess_Label_priority = [];
            foreach ($project_priority_task as $lable => $process) {
                $arrProcess_Label_priority[] = $lable;
                if ($totaltask == 0) {
                    $arrProcessPer_priority[] = 0.00;
                } else {
                    $arrProcessPer_priority[] = round(($process * 100) / $totaltask, 2);
                }
            }
            $arrProcessClass = [
                'text-success',
                'text-primary',
                'text-danger',
            ];

            $chartData = app('App\Http\Controllers\ProjectController')->getProjectChart([
                'created_by' => $id,
                'duration' => 'week',
            ]);

            $stages = TaskStage::all();
            $milestones = Milestone::where('project_id', $id)->get();
            $logged_hour_chart = 0;
            $total_hour = 0;
            $logged_hour = 0;

            $tasks = ProjectTask::where('project_id', $id)->get();
            foreach ($tasks as $task) {
                $timesheets_task = Timesheet::where('task_id', $task->id)->where('project_id', $id)->get();

                foreach ($timesheets_task as $timesheet) {

                    $hours = date('H', strtotime($timesheet->time));
                    $minutes = date('i', strtotime($timesheet->time));
                    $total_hour = $hours + ($minutes / 60);
                    $logged_hour += $total_hour;
                    $logged_hour_chart = number_format($logged_hour, 2, '.', '');

                }
            }

            //Estimated Hours
            $esti_logged_hour_chart = ProjectTask::where('project_id', $id)->sum('estimated_hrs');

            $tasks = ProjectTask::where('project_id', '=', $id)->get();

            return view('project_report.show', compact('user', 'users', 'arrProcessPer_status_task',
                'arrProcess_Label_priority', 'esti_logged_hour_chart', 'logged_hour_chart', 'arrProcessPer_priority',
                'arrProcess_Label_status_tasks', 'project', 'milestones', 'daysleft', 'chartData',
                'arrProcessClass', 'stages', 'tasks'));

        }
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

        foreach ($arrDuration as $date => $label) {
            $objProject = ProjectTask::select('stage_id', \DB::raw('count(*) as total'))
                ->whereDate('updated_at', '=', $date)->groupBy('stage_id');

            if (isset($arrParam['project_id'])) {
                $objProject->where('project_id', '=', $arrParam['project_id']);
            }
            if (isset($arrParam['created_by'])) {
                $objProject->whereIn(
                    'project_id', function ($query) use ($arrParam) {
                        $query->select('id')->from('projects')->where('created_by', '=', $arrParam['created_by']);
                    }
                );
            }
            $objProject->pluck('total', 'stage_id')->all();
            $arrTask['label'][] = __($label);

            return $arrTask;
        }
    }

    public function export($id)
    {
        $name = 'task_report_'.date('Y-m-d i:h:s');
        return Excel::download(new task_reportExport($id), $name.'.xlsx');
    }

    public function send_report_con(Request $request)
    {

        if (\Auth::user()->type == 'company' || \Auth::user()->type == $this->typeSuperAdmin) {
            $project      = Project::where('id', Session::get('project_id'))->first();
            $project_task = Con_task::where('project_id', Session::get('project_id'))
                ->where('instance_id', Session::get('project_instance'))
                ->whereIn('main_id', function ($query) {
                    $query->select('task_id')
                        ->from('task_progress')
                        ->where('instance_id', Session::get('project_instance'))
                        ->where('record_date', 'like', Carbon::now()->format('Y-m-d').'%');
                })->get();
            $actual_current_progress = Con_task::where('project_id', Session::get('project_id'))
                ->where('instance_id', Session::get('project_instance'))
                ->orderBy('id', 'ASC')
                ->pluck('progress')->first();
            $actual_current_progress   = round($actual_current_progress);
            $actual_remaining_progress = 100 - $actual_current_progress;
            $actual_remaining_progress = round($actual_remaining_progress);
            // current progress amount
            $taskdata = [];
            foreach ($project_task as $value) {
                $planned_start = date('d-m-Y', strtotime($value->start_date));
                $planned_end = date('d-m-Y', strtotime($value->end_date));

                $actual_start = DB::table('task_progress')->where('project_id', Session::get('project_id'))
                    ->where('instance_id', Session::get('project_instance'))
                    ->where('task_id', $value->main_id)->max('created_at');
                $actual_end = DB::table('task_progress')->where('project_id', Session::get('project_id'))
                    ->where('instance_id', Session::get('project_instance'))
                    ->where('task_id', $value->main_id)->min('created_at');
                if ($actual_start) {
                    $actual_start = date('d-m-Y', strtotime($actual_start));
                } else {
                    $actual_start = $this->taskNotStarted;
                }

                if ($actual_end) {
                    $actual_end = date('d-m-Y', strtotime($actual_end));
                } else {
                    $actual_end = $this->notFinish;
                }

                if ($actual_end < $planned_end) {
                    $actual_end = $this->notFinish;
                }
                //finding planned percentage
                //############## days finding ####################################################
                $date2 = date_create($value->end_date);
                // $diff=date_diff($date1,$date2);
                // $no_working_days=$diff->format("%a");
                $no_working_days = $value->duration; // include the last day
                //############## END ##############################

                //############## Remaining days ###################

                $remaining_working_days = Utility::remaining_duration_calculator($date2, $project->id);
                $remaining_working_days = $remaining_working_days - 1; // include the last day

                // $diff=date_diff($date1,$date2);
                // $remaining_working_days=$diff->format("%a");
                // $remaining_working_days=$remaining_working_days-1;// include the last day
                //############## Remaining days ##################

                $completed_days = $no_working_days - $remaining_working_days;

                // percentage calculator
                if ($no_working_days > 0) {
                    $perday = 100 / $no_working_days;
                } else {
                    $perday = 0;
                }

                $current_percentage = round($completed_days * $perday);
                if ($current_percentage > 100) {
                    $current_percentage = 100;
                }


                //####################################___END____#######################################
                //  // actual duration finding
                $taskdata[] = [
                    'title' => $value->text,
                    'planed_start' => $planned_start,
                    'planed_end' => $planned_end,
                    'duration' => $value->duration.$this->daysString,
                    'percentage_as_today' => round($current_percentage),
                    'actual_start' => $actual_start,
                    'actual_end' => $actual_end,
                    'actual_duration' => $value->duration.$this->daysString,
                    'remain_duration' => $value->duration.$this->daysString,
                    'actual_percent' => round($value->progress),
                ];
            }
            $taskdata2 = [];
            $today_task_update = DB::table('task_progress')->where('project_id', Session::get('project_id'))
                ->where('instance_id', Session::get('project_instance'))
                ->where('record_date', 'like', Carbon::now()->format('Y-m-d').'%')->get();
            $instance_id = Session::get('project_instance');

            foreach ($today_task_update as $value) {
                $main_task = Con_task::where(['main_id' => $value->task_id, 'instance_id' => $instance_id])->first();
                $user = User::find($value->user_id);
                if ($user) {
                    $user_name = $user->name;
                    $user_email = $user->email;
                } else {
                    $user_name = '';
                    $user_email = '';
                }

                $taskdata2[] = [
                    'title' => $main_task->text,
                    'planed_start' => date('d-m-Y', strtotime($main_task->start_date)),
                    'planed_end' => date('d-m-Y', strtotime($main_task->start_date)),
                    'duration' => $main_task->duration.$this->daysString,
                    'percentage' => $value->percentage.'%',
                    'progress_updated_date' => date('d-m-Y', strtotime($value->record_date)),
                    'description' => $value->description,
                    'user' => $user_name,
                    'email' => $user_email,

                ];
            }
            $to = [];
            $to_array = explode(',', $project->report_to);
            foreach ($to_array as  $value) {
                $to[] = DB::table('users')->where('id', $value)->pluck('email')->first();
            }

            if (! $to) {
                return redirect()->back()->with('error', __($this->notAssign));
            }
            $pdf = Pdf::loadView('project_report.email', compact('taskdata', 'project', 'project_task',
             'actual_current_progress', 'actual_remaining_progress', 'taskdata2'))
             ->setPaper('a4', 'landscape')->setWarnings(false);
            $pdf_name = $project->project_name.date('Y-m-d').'.pdf';

            return $pdf->download($pdf_name);
        }
    }
    public function pdf_report_onsearch(Request $request)
    {

        if (\Auth::user()->type == 'company' || \Auth::user()->type == $this->typeSuperAdmin) {
            $project      = Project::where('id', Session::get('project_id'))->first();
            $project_id     = Session::get('project_id');
            $instance_id    = Session::get('project_instance');
            $get_start_date = $request->start_date;
            $get_end_date   = $request->end_date;
            $status_task    = $request->status_task;
            $task_id_arr    = $request->task_id_arr;
            $user_id_arr    = $request->user_id;
    
            // 3 > Pending Task
            // 4 > Completed Task
            
            $tasks = Con_task::select('con_tasks.text', 'con_tasks.users', 'con_tasks.duration',
                'con_tasks.progress', 'con_tasks.start_date', 'con_tasks.end_date', 'con_tasks.id',
                'con_tasks.instance_id', 'con_tasks.main_id', 'pros.project_name',
                'pros.id as project_id', 'pros.instance_id as pro_instance_id')
                ->join('projects as pros', 'pros.id', 'con_tasks.project_id')
                ->whereNotNull('pros.instance_id')
                ->where('con_tasks.project_id', $project_id)
                ->where('con_tasks.instance_id', $instance_id);

            if (\Auth::user()->type != 'company') {
                $tasks->whereRaw($this->findinSet.\Auth::user()->id.$this->usersSet);
            }

            if($task_id_arr != null){
                $tasks->whereIn('con_tasks.id',$task_id_arr);
            }

            if($get_start_date != null && $get_end_date != null){
                $tasks->where(function ($query) use ($get_start_date, $get_end_date) {
                    $query->whereDate('con_tasks.start_date', '>=', $get_start_date);
                    $query->whereDate('con_tasks.end_date', '<', $get_end_date);
                });
            }

            if($user_id_arr != null){
                $tasks->where(function ($query) use ($user_id_arr) {
                    foreach($user_id_arr as $get_user_id){
                        if($get_user_id != ""){
                            $query->orwhereJsonContains('con_tasks.users', $get_user_id);
                        }
                    }
                });
            }

            if($status_task != null){
                if($status_task == "3"){
                    $tasks->where('progress','<','100')
                        ->whereDate('con_tasks.end_date', '<', date('Y-m-d'));
                }
                elseif($status_task == "4"){
                    $tasks->where('progress','>=','100');
                }
            }

            if($task_id_arr == null && $user_id_arr == null && $get_start_date == null &&
                $get_end_date == null && $status_task == null){

                        $tasks->whereIn('main_id', function ($query) {
                            $query->select('task_id')
                                ->from('task_progress')
                                ->where('record_date', 'like', Carbon::now()->format('Y-m-d').'%');
                        });

                $tasks->where(function($query) {
                    $query->whereRaw('"'.date('Y-m-d').'"
                        between date(`con_tasks`.`start_date`) and date(`con_tasks`.`end_date`)')
                        ->orwhere('progress', '<', '100')
                        ->whereDate('con_tasks.end_date', '<', date('Y-m-d'));
                })
                ->orderBy('con_tasks.end_date', 'DESC');
            }

            $project_task = $tasks->get();
            $actual_current_progress = Con_task::where('project_id', Session::get('project_id'))
            ->where('instance_id', Session::get('project_instance'))
            ->orderBy('id', 'ASC')
            ->pluck('progress')->first();
            $actual_current_progress   = round($actual_current_progress);
            $actual_remaining_progress = 100 - $actual_current_progress;
            $actual_remaining_progress = round($actual_remaining_progress);
            // current progress amount
            $taskdata = [];
            foreach ($project_task as  $value) {
                $planned_start = date('d-m-Y', strtotime($value->start_date));
                $planned_end = date('d-m-Y', strtotime($value->end_date));

                $actual_start = DB::table('task_progress')->where('project_id', Session::get('project_id'))
                    ->where('instance_id', Session::get('project_instance'))
                    ->where('task_id', $value->main_id)->max('created_at');
                $actual_end = DB::table('task_progress')->where('project_id', Session::get('project_id'))
                    ->where('instance_id', Session::get('project_instance'))
                    ->where('task_id', $value->main_id)->min('created_at');
                if ($actual_start) {
                    $actual_start = date('d-m-Y', strtotime($actual_start));
                } else {
                    $actual_start = $this->taskNotStarted;
                }

                if ($actual_end) {
                    $actual_end = date('d-m-Y', strtotime($actual_end));
                } else {
                    $actual_end = $this->notFinish;
                }

                if ($actual_end < $planned_end) {
                    $actual_end = $this->notFinish;
                }
                $date2 = date_create($value->end_date);
                $no_working_days = $value->duration; // include the last day
                $remaining_working_days = Utility::remaining_duration_calculator($date2, $project->id);
                $remaining_working_days = $remaining_working_days - 1; // include the last day


                $completed_days = $no_working_days - $remaining_working_days;

                // percentage calculator
                if ($no_working_days > 0) {
                    $perday = 100 / $no_working_days;
                } else {
                    $perday = 0;
                }

                $current_percentage = round($completed_days * $perday);
                if ($current_percentage > 100) {
                    $current_percentage = 100;
                }


                //####################################___END____#######################################
                //  // actual duration finding
                $taskdata[] = [
                    'title' => $value->text,
                    'planed_start' => $planned_start,
                    'planed_end' => $planned_end,
                    'duration' => $value->duration.$this->daysString,
                    'percentage_as_today' => round($current_percentage),
                    'actual_start' => $actual_start,
                    'actual_end' => $actual_end,
                    'actual_duration' => $value->duration.$this->daysString,
                    'remain_duration' => $value->duration.$this->daysString,
                    'actual_percent' => round($value->progress),
                ];
            }
            $taskdata2 = [];
            $today_task_update = DB::table('task_progress')->where('project_id', Session::get('project_id'))
                ->where('instance_id', Session::get('project_instance'))
                ->where('record_date', 'like', Carbon::now()->format('Y-m-d').'%')->get();
            $instance_id = Session::get('project_instance');

            foreach ($today_task_update as  $value) {
                $main_task = Con_task::where(['main_id' => $value->task_id, 'instance_id' => $instance_id])->first();
                $user = User::find($value->user_id);
                if ($user) {
                    $user_name = $user->name;
                    $user_email = $user->email;
                } else {
                    $user_name = '';
                    $user_email = '';
                }

                $taskdata2[] = [
                    'title' => $main_task->text,
                    'planed_start' => date('d-m-Y', strtotime($main_task->start_date)),
                    'planed_end' => date('d-m-Y', strtotime($main_task->start_date)),
                    'duration' => $main_task->duration.$this->daysString,
                    'percentage' => $value->percentage.'%',
                    'progress_updated_date' => date('d-m-Y', strtotime($value->record_date)),
                    'description' => $value->description,
                    'user' => $user_name,
                    'email' => $user_email,

                ];
            }
            $to = [];
            $to_array = explode(',', $project->report_to);
            foreach ($to_array as  $value) {
                $to[] = DB::table('users')->where('id', $value)->pluck('email')->first();
            }

            if (! $to) {
                return redirect()->back()->with('error', __($this->notAssign));
            }
            $pdf = Pdf::loadView('project_report.email', compact('taskdata', 'project', 'project_task',
            'actual_current_progress', 'actual_remaining_progress', 'taskdata2'))
            ->setPaper('a4', 'landscape')->setWarnings(false);
            $pdf_name = $project->project_name.date('Y-m-d').'.pdf';

            return $pdf->download($pdf_name);
            

        }
    }

    public function excel_report_onsearch(Request $request)
    {

        if (\Auth::user()->type == 'company' || \Auth::user()->type == $this->typeSuperAdmin) {
            $project      = Project::where('id', Session::get('project_id'))->first();
            $project_id     = Session::get('project_id');
            $instance_id    = Session::get('project_instance');
            $get_start_date = $request->start_date;
            $get_end_date   = $request->end_date;
            $status_task    = $request->status_task;
            $task_id_arr    = $request->task_id_arr;
            $user_id_arr    = $request->user_id;
    
            // 3 > Pending Task
            // 4 > Completed Task
            
            $tasks = Con_task::select('con_tasks.text', 'con_tasks.users', 'con_tasks.duration',
                'con_tasks.progress', 'con_tasks.start_date', 'con_tasks.end_date', 'con_tasks.id',
                'con_tasks.instance_id', 'con_tasks.main_id', 'pros.project_name',
                'pros.id as project_id', 'pros.instance_id as pro_instance_id')
                ->join('projects as pros', 'pros.id', 'con_tasks.project_id')
                ->whereNotNull('pros.instance_id')
                ->where('con_tasks.project_id', $project_id)
                ->where('con_tasks.instance_id', $instance_id);

            if (\Auth::user()->type != 'company') {
                $tasks->whereRaw($this->findinSet.\Auth::user()->id.$this->usersSet);
            }

            if($task_id_arr != null){
                $tasks->whereIn('con_tasks.id',$task_id_arr);
            }

            if($get_start_date != null && $get_end_date != null){
                $tasks->where(function ($query) use ($get_start_date, $get_end_date) {
                    $query->whereDate('con_tasks.start_date', '>=', $get_start_date);
                    $query->whereDate('con_tasks.end_date', '<', $get_end_date);
                });
            }

            if($user_id_arr != null){
                $tasks->where(function ($query) use ($user_id_arr) {
                    foreach($user_id_arr as $get_user_id){
                        if($get_user_id != ""){
                            $query->orwhereJsonContains('con_tasks.users', $get_user_id);
                        }
                    }
                });
            }

            if($status_task != null){
                if($status_task == "3"){
                    $tasks->where('progress','<','100')
                        ->whereDate('con_tasks.end_date', '<', date('Y-m-d'));
                }
                elseif($status_task == "4"){
                    $tasks->where('progress','>=','100');
                }
            }

            if($task_id_arr == null && $user_id_arr == null && $get_start_date == null &&
                $get_end_date == null && $status_task == null){

                        $tasks->whereIn('main_id', function ($query) {
                            $query->select('task_id')
                                ->from('task_progress')
                                ->where('record_date', 'like', Carbon::now()->format('Y-m-d').'%');
                        });

                $tasks->where(function($query) {
                    $query->whereRaw('"'.date('Y-m-d').'"
                        between date(`con_tasks`.`start_date`) and date(`con_tasks`.`end_date`)')
                        ->orwhere('progress', '<', '100')
                        ->whereDate('con_tasks.end_date', '<', date('Y-m-d'));
                })
                ->orderBy('con_tasks.end_date', 'DESC');
            }

            $project_task = $tasks->get();
            // current progress amount
            $taskdata = [];
            foreach ($project_task as $value) {
                $planned_start = date('d-m-Y', strtotime($value->start_date));
                $planned_end = date('d-m-Y', strtotime($value->end_date));

                $actual_start = DB::table('task_progress')->where('project_id', Session::get('project_id'))
                    ->where('instance_id', Session::get('project_instance'))
                    ->where('task_id', $value->main_id)->max('created_at');
                $actual_end = DB::table('task_progress')->where('project_id', Session::get('project_id'))
                    ->where('instance_id', Session::get('project_instance'))
                    ->where('task_id', $value->main_id)->min('created_at');
                if ($actual_start) {
                    $actual_start = date('d-m-Y', strtotime($actual_start));
                } else {
                    $actual_start = $this->taskNotStarted;
                }

                if ($actual_end) {
                    $actual_end = date('d-m-Y', strtotime($actual_end));
                } else {
                    $actual_end = $this->notFinish;
                }

                if ($actual_end < $planned_end) {
                    $actual_end = $this->notFinish;
                }
                $date2 = date_create($value->end_date);
                $no_working_days = $value->duration; // include the last day
                $remaining_working_days = Utility::remaining_duration_calculator($date2, $project->id);
                $remaining_working_days = $remaining_working_days - 1; // include the last day
                $completed_days = $no_working_days - $remaining_working_days;

                // percentage calculator
                if ($no_working_days > 0) {
                    $perday = 100 / $no_working_days;
                } else {
                    $perday = 0;
                }

                $current_percentage = round($completed_days * $perday);
                if ($current_percentage > 100) {
                    $current_percentage = 100;
                }
                //  // actual duration finding
                $taskdata[] = [
                    'title' => $value->text,
                    'planed_start' => $planned_start,
                    'planed_end' => $planned_end,
                    'duration' => $value->duration.$this->daysString,
                    'percentage_as_today' => round($current_percentage),
                    'actual_start' => $actual_start,
                    'actual_end' => $actual_end,
                    'actual_duration' => $value->duration.$this->daysString,
                    'remain_duration' => $value->duration.$this->daysString,
                    'actual_percent' => round($value->progress),
                ];
            }
            $taskdata2 = [];
            $today_task_update = DB::table('task_progress')->where('project_id', Session::get('project_id'))
                ->where('instance_id', Session::get('project_instance'))
                ->where('record_date', 'like', Carbon::now()->format('Y-m-d').'%')->get();
            $instance_id = Session::get('project_instance');

            foreach ($today_task_update as  $value) {
                $main_task = Con_task::where(['main_id' => $value->task_id, 'instance_id' => $instance_id])->first();
                $user = User::find($value->user_id);
                if ($user) {
                    $user_name = $user->name;
                    $user_email = $user->email;
                } else {
                    $user_name = '';
                    $user_email = '';
                }

                $taskdata2[] = [
                    'title' => $main_task->text,
                    'planed_start' => date('d-m-Y', strtotime($main_task->start_date)),
                    'planed_end' => date('d-m-Y', strtotime($main_task->start_date)),
                    'duration' => $main_task->duration.$this->daysString,
                    'percentage' => $value->percentage.'%',
                    'progress_updated_date' => date('d-m-Y', strtotime($value->record_date)),
                    'description' => $value->description,
                    'user' => $user_name,
                    'email' => $user_email,

                ];
            }
            
            $to = [];
            $to_array = explode(',', $project->report_to);
            foreach ($to_array as  $value) {
                $to[] = DB::table('users')->where('id', $value)->pluck('email')->first();
            }

            if (! $to) {
                return redirect()->back()->with('error', __($this->notAssign));
            }

            $spreadsheet = new Spreadsheet();
            $sheet=$spreadsheet;
            $spreadsheet->getProperties()->setCreator('PhpOffice')
                        ->setLastModifiedBy('PhpOffice')
                        ->setTitle('Schedule')
                        ->setSubject('Office 2007 XLSX Test Document')
                        ->setDescription('PhpOffice')
                        ->setKeywords('PhpOffice')
                        ->setCategory('PhpOffice');
    
                        $styleArray = array(            // font color
                            'font'  => array(
                                'bold'  => true,
                                'color' => array('rgb' => 'ffffff')
                            ));
            // Rename worksheet
            $sheet->getActiveSheet()->setTitle('Main Task List');
            $sheet->getActiveSheet()->getColumnDimension('A')->setWidth(30);
            $sheet->getActiveSheet()->getColumnDimension('B')->setWidth(30);
            $sheet->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $sheet->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $sheet->getActiveSheet()->getColumnDimension('E')->setWidth(50);
            $sheet->getActiveSheet()->getColumnDimension('F')->setWidth(50);
            $sheet->getActiveSheet()->getColumnDimension('G')->setWidth(50);
            $sheet->getActiveSheet()->getColumnDimension('H')->setWidth(50);
            $sheet->getActiveSheet()->getColumnDimension('I')->setWidth(50);
            $sheet->getActiveSheet()->getColumnDimension('J')->setWidth(50);
            $sheet->getActiveSheet()->getColumnDimension('K')->setWidth(50);
            $sheet->getActiveSheet()->setCellValue('A1','Title');
            $sheet->getActiveSheet()->setCellValue('B1',$this->plannedStartDate);
            $sheet->getActiveSheet()->setCellValue('C1',$this->plannedFinish);
            $sheet->getActiveSheet()->setCellValue('D1','Duration');
            $sheet->getActiveSheet()->setCellValue('E1','Planned % as of today');
            $sheet->getActiveSheet()->setCellValue('F1','Planned Value');
            $sheet->getActiveSheet()->setCellValue('G1','Actual Start Date');
            $sheet->getActiveSheet()->setCellValue('H1','Actual Finish');
            $sheet->getActiveSheet()->setCellValue('I1','Actual Duration');
            $sheet->getActiveSheet()->setCellValue('J1','Actual % as of Today');
            $sheet->getActiveSheet()->setCellValue('K1','Earned Value');
            $sheet->getActiveSheet()->getStyle($this->sheetRows1)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB($this->sheetbgColor); // cell color
            $sheet->getActiveSheet()->getStyle($this->sheetRows1)->applyFromArray($styleArray); 
            $sheet->getActiveSheet()->getStyle($this->sheetRows1)->getAlignment()->setHorizontal('center'); 
            $sheet->getActiveSheet()->getStyle($this->sheetRows1)->getAlignment()->setVertical('center'); 
           
            if(count($taskdata)>0){
                $row=2;
                foreach ($taskdata as  $value) {
                    $sheet->getActiveSheet()->setCellValue('A'.$row,$value['title']);
                    $sheet->getActiveSheet()->setCellValue('B'.$row,$value['planed_start']);
                    $sheet->getActiveSheet()->setCellValue('C'.$row,$value['planed_end']);
                    $sheet->getActiveSheet()->setCellValue('D'.$row,$value['duration']);
                    $sheet->getActiveSheet()->setCellValue('E'.$row,$value['percentage_as_today']);
                    $sheet->getActiveSheet()->setCellValue('F'.$row,'');
                    $sheet->getActiveSheet()->setCellValue('G'.$row,$value['actual_start']);
                    $sheet->getActiveSheet()->setCellValue('H'.$row,$value['actual_end']);
                    $sheet->getActiveSheet()->setCellValue('I'.$row,$value['actual_duration']);
                    $sheet->getActiveSheet()->setCellValue('J'.$row,$value['actual_percent']);
                    $sheet->getActiveSheet()->setCellValue('K'.$row,'');
                    $row++;
                    if($value['percentage_as_today'] != $value['actual_percent']){
                        $sheet->getActiveSheet()->getStyle($this->sheetRows1)->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('ffbfbd'); // cell color
                    }
                }
            }else{
                $sheet->getActiveSheet()->mergeCells($this->sheetRows);
                $sheet->getActiveSheet()->setCellValue('A2',$this->norecord);
                $sheet->getActiveSheet()->getStyle($this->sheetRows)->getAlignment()->setHorizontal('center');
                $sheet->getActiveSheet()->getStyle($this->sheetRows)->getAlignment()->setVertical('center');
            }
            $worksheet2 = $spreadsheet->createSheet();
            $worksheet2->setTitle('Today Updated Task List');
            $worksheet2->getColumnDimension('A')->setWidth(30);
            $worksheet2->getColumnDimension('B')->setWidth(30);
            $worksheet2->getColumnDimension('C')->setWidth(30);
            $worksheet2->getColumnDimension('D')->setWidth(30);
            $worksheet2->getColumnDimension('E')->setWidth(50);
            $worksheet2->getColumnDimension('F')->setWidth(50);
            $worksheet2->getColumnDimension('G')->setWidth(50);
            $worksheet2->getColumnDimension('H')->setWidth(50);
            $worksheet2->getColumnDimension('I')->setWidth(50);
            $worksheet2->getColumnDimension('J')->setWidth(50);
            $worksheet2->getColumnDimension('K')->setWidth(50);
            $worksheet2->setCellValue('A1','Title');
            $worksheet2->setCellValue('B1',$this->plannedStartDate);
            $worksheet2->setCellValue('C1',$this->plannedFinish);
            $worksheet2->setCellValue('D1','Duration');
            $worksheet2->setCellValue('E1','Percentage');
            $worksheet2->setCellValue('F1','Progress Updated Date');
            $worksheet2->setCellValue('G1','Description');
            $worksheet2->setCellValue('H1','User Name');
            $worksheet2->setCellValue('I1','User Email');
            $worksheet2->getStyle($this->sheetCol1)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB($this->sheetbgColor); // cell color
            $worksheet2->getStyle($this->sheetCol1)->applyFromArray($styleArray); 
            $worksheet2->getStyle($this->sheetCol1)->getAlignment()->setHorizontal('center'); 
            $worksheet2->getStyle($this->sheetCol1)->getAlignment()->setVertical('center'); 

            if(count($taskdata2)>0){
                $row=2;
                foreach ($taskdata2 as  $value) {
                    $worksheet2->setCellValue('A'.$row,$value['title']);
                    $worksheet2->setCellValue('B'.$row,$value['planed_start']);
                    $worksheet2->setCellValue('C'.$row,$value['planed_end']);
                    $worksheet2->setCellValue('D'.$row,$value['duration']);
                    $worksheet2->setCellValue('E'.$row,$value['percentage']);
                    $worksheet2->setCellValue('F'.$row,$value['progress_updated_date']);
                    $worksheet2->setCellValue('G'.$row,$value['description']);
                    $worksheet2->setCellValue('H'.$row,$value['user']);
                    $worksheet2->setCellValue('I'.$row,$value['email']);
                    $row++;

                }
            }else{
                $worksheet2->mergeCells('A2:I2');
                $worksheet2->setCellValue('A2',$this->norecord);
                $sheet->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setHorizontal('center'); 
                $sheet->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setVertical('center'); 
            }

            $download_directory = './Report_list.xlsx';
            $writer = IOFactory::createWriter($sheet, 'Xlsx');
			$writer->save($download_directory);
			$content = file_get_contents($download_directory);
			$filename= $project->project_name.'_Daily Site Workdone Producivity Report_'.date('Y-m-d H:i:s').'.xlsx';
			header("Content-Disposition: attachment; filename=".$filename);
			unlink($download_directory);
            exit($content);
             
        }
    }
    public function download_excel_report(Request $request)
    {

        if (\Auth::user()->type == 'company' || \Auth::user()->type == $this->typeSuperAdmin) {
            $project      = Project::where('id', Session::get('project_id'))->first();
            $project_task = Con_task::where('project_id', Session::get('project_id'))
                ->where('instance_id', Session::get('project_instance'))
                ->whereIn('main_id', function ($query) {
                    $query->select('task_id')
                        ->from('task_progress')
                        ->where('instance_id', Session::get('project_instance'))
                        ->where('record_date', 'like', Carbon::now()->format('Y-m-d').'%');
                })->get();
            $actual_current_progress = Con_task::where('project_id', Session::get('project_id'))
                ->where('instance_id', Session::get('project_instance'))
                ->orderBy('id', 'ASC')
                ->pluck('progress')->first();
            $actual_current_progress   = round($actual_current_progress);
            $actual_remaining_progress = 100 - $actual_current_progress;
            $actual_remaining_progress = round($actual_remaining_progress);
            // current progress amount
            $taskdata = [];
            foreach ($project_task as $value) {
                $planned_start = date('d-m-Y', strtotime($value->start_date));
                $planned_end = date('d-m-Y', strtotime($value->end_date));

                $actual_start = DB::table('task_progress')->where('project_id', Session::get('project_id'))
                    ->where('instance_id', Session::get('project_instance'))
                    ->where('task_id', $value->main_id)->max('created_at');
                $actual_end = DB::table('task_progress')->where('project_id', Session::get('project_id'))
                    ->where('instance_id', Session::get('project_instance'))
                    ->where('task_id', $value->main_id)->min('created_at');
                if ($actual_start) {
                    $actual_start = date('d-m-Y', strtotime($actual_start));
                } else {
                    $actual_start = $this->taskNotStarted;
                }

                if ($actual_end) {
                    $actual_end = date('d-m-Y', strtotime($actual_end));
                } else {
                    $actual_end = $this->notFinish;
                }

                if ($actual_end < $planned_end) {
                    $actual_end = $this->notFinish;
                }
                $date2 = date_create($value->end_date);
                $no_working_days = $value->duration; // include the last day
                $remaining_working_days = Utility::remaining_duration_calculator($date2, $project->id);
                $remaining_working_days = $remaining_working_days - 1; // include the last day
                $completed_days = $no_working_days - $remaining_working_days;
                // percentage calculator
                if ($no_working_days > 0) {
                    $perday = 100 / $no_working_days;
                } else {
                    $perday = 0;
                }
                $current_percentage = round($completed_days * $perday);
                if ($current_percentage > 100) {
                    $current_percentage = 100;
                }
                $taskdata[] = [
                    'title' => $value->text,
                    'planed_start' => $planned_start,
                    'planed_end' => $planned_end,
                    'duration' => $value->duration.$this->daysString,
                    'percentage_as_today' => round($current_percentage),
                    'actual_start' => $actual_start,
                    'actual_end' => $actual_end,
                    'actual_duration' => $value->duration.$this->daysString,
                    'remain_duration' => $value->duration.$this->daysString,
                    'actual_percent' => round($value->progress),
                ];
            }
            $taskdata2 = [];
            $today_task_update = DB::table('task_progress')->where('project_id', Session::get('project_id'))
                ->where('instance_id', Session::get('project_instance'))
                ->where('record_date', 'like', Carbon::now()->format('Y-m-d').'%')->get();
            $instance_id = Session::get('project_instance');

            foreach ($today_task_update as  $value) {
                $main_task = Con_task::where(['main_id' => $value->task_id, 'instance_id' => $instance_id])->first();
                $user = User::find($value->user_id);
                if ($user) {
                    $user_name = $user->name;
                    $user_email = $user->email;
                } else {
                    $user_name = '';
                    $user_email = '';
                }

                $taskdata2[] = [
                    'title' => $main_task->text,
                    'planed_start' => date('d-m-Y', strtotime($main_task->start_date)),
                    'planed_end' => date('d-m-Y', strtotime($main_task->start_date)),
                    'duration' => $main_task->duration.$this->daysString,
                    'percentage' => $value->percentage.'%',
                    'progress_updated_date' => date('d-m-Y', strtotime($value->record_date)),
                    'description' => $value->description,
                    'user' => $user_name,
                    'email' => $user_email,

                ];
            }
            $to = [];
            $to_array = explode(',', $project->report_to);
            foreach ($to_array as  $value) {
                $to[] = DB::table('users')->where('id', $value)->pluck('email')->first();
            }

            if (! $to) {
                return redirect()->back()->with('error', __($this->notAssign));
            }

            $spreadsheet = new Spreadsheet();
            $sheet=$spreadsheet;
            $spreadsheet->getProperties()->setCreator('PhpOffice')
                        ->setLastModifiedBy('PhpOffice')
                        ->setTitle('Schedule')
                        ->setSubject('Office 2007 XLSX Test Document')
                        ->setDescription('PhpOffice')
                        ->setKeywords('PhpOffice')
                        ->setCategory('PhpOffice');
    
                        $styleArray = array(            // font color
                            'font'  => array(
                                'bold'  => true,
                                'color' => array('rgb' => 'ffffff')
                            ));
            // Rename worksheet
            $sheet->getActiveSheet()->setTitle('Main Task List');
            $sheet->getActiveSheet()->getColumnDimension('A')->setWidth(30);
            $sheet->getActiveSheet()->getColumnDimension('B')->setWidth(30);
            $sheet->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $sheet->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $sheet->getActiveSheet()->getColumnDimension('E')->setWidth(50);
            $sheet->getActiveSheet()->getColumnDimension('F')->setWidth(50);
            $sheet->getActiveSheet()->getColumnDimension('G')->setWidth(50);
            $sheet->getActiveSheet()->getColumnDimension('H')->setWidth(50);
            $sheet->getActiveSheet()->getColumnDimension('I')->setWidth(50);
            $sheet->getActiveSheet()->getColumnDimension('J')->setWidth(50);
            $sheet->getActiveSheet()->getColumnDimension('K')->setWidth(50);
            $sheet->getActiveSheet()->setCellValue('A1','Title');
            $sheet->getActiveSheet()->setCellValue('B1',$this->plannedStartDate);
            $sheet->getActiveSheet()->setCellValue('C1',$this->plannedFinish);
            $sheet->getActiveSheet()->setCellValue('D1','Duration');
            $sheet->getActiveSheet()->setCellValue('E1','Planned % as of today');
            $sheet->getActiveSheet()->setCellValue('F1','Planned Value');
            $sheet->getActiveSheet()->setCellValue('G1','Actual Start Date');
            $sheet->getActiveSheet()->setCellValue('H1','Actual Finish');
            $sheet->getActiveSheet()->setCellValue('I1','Actual Duration');
            $sheet->getActiveSheet()->setCellValue('J1','Actual % as of Today');
            $sheet->getActiveSheet()->setCellValue('K1','Earned Value');
            $sheet->getActiveSheet()->getStyle($this->sheetRows1)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB($this->sheetbgColor); // cell color
            $sheet->getActiveSheet()->getStyle($this->sheetRows1)->applyFromArray($styleArray);
            $sheet->getActiveSheet()->getStyle($this->sheetRows1)->getAlignment()->setHorizontal('center');
            $sheet->getActiveSheet()->getStyle($this->sheetRows1)->getAlignment()->setVertical('center');
            
            if(count($taskdata)>0){
                foreach ($taskdata as  $value) {
                    $row=2;
                    $sheet->getActiveSheet()->setCellValue('A'.$row,$value['title']);
                    $sheet->getActiveSheet()->setCellValue('B'.$row,$value['planed_start']);
                    $sheet->getActiveSheet()->setCellValue('C'.$row,$value['planed_end']);
                    $sheet->getActiveSheet()->setCellValue('D'.$row,$value['duration']);
                    $sheet->getActiveSheet()->setCellValue('E'.$row,$value['percentage_as_today']);
                    $sheet->getActiveSheet()->setCellValue('F'.$row,'');
                    $sheet->getActiveSheet()->setCellValue('G'.$row,$value['actual_start']);
                    $sheet->getActiveSheet()->setCellValue('H'.$row,$value['actual_end']);
                    $sheet->getActiveSheet()->setCellValue('I'.$row,$value['actual_duration']);
                    $sheet->getActiveSheet()->setCellValue('J'.$row,$value['actual_percent']);
                    $sheet->getActiveSheet()->setCellValue('K'.$row,'');
                    $row++;
                    if($value['percentage_as_today'] != $value['actual_percent']){
                        $sheet->getActiveSheet()->getStyle($this->sheetRows1)->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('ffbfbd'); // cell color
                    }
                }
            }else{
                $sheet->getActiveSheet()->mergeCells($this->sheetRows);
                $sheet->getActiveSheet()->setCellValue('A2',$this->norecord);
                $sheet->getActiveSheet()->getStyle($this->sheetRows)->getAlignment()->setHorizontal('center');
                $sheet->getActiveSheet()->getStyle($this->sheetRows)->getAlignment()->setVertical('center');
            }

            $worksheet2 = $spreadsheet->createSheet();
            $worksheet2->setTitle('Today Updated Task List'); 
            $worksheet2->getColumnDimension('A')->setWidth(30);
            $worksheet2->getColumnDimension('B')->setWidth(30);
            $worksheet2->getColumnDimension('C')->setWidth(30);
            $worksheet2->getColumnDimension('D')->setWidth(30);
            $worksheet2->getColumnDimension('E')->setWidth(50);
            $worksheet2->getColumnDimension('F')->setWidth(50);
            $worksheet2->getColumnDimension('G')->setWidth(50);
            $worksheet2->getColumnDimension('H')->setWidth(50);
            $worksheet2->getColumnDimension('I')->setWidth(50);
            $worksheet2->getColumnDimension('J')->setWidth(50);
            $worksheet2->getColumnDimension('K')->setWidth(50);
            $worksheet2->setCellValue('A1','Title');
            $worksheet2->setCellValue('B1',$this->plannedStartDate);
            $worksheet2->setCellValue('C1',$this->plannedFinish);
            $worksheet2->setCellValue('D1','Duration');
            $worksheet2->setCellValue('E1','Percentage');
            $worksheet2->setCellValue('F1','Progress Updated Date');
            $worksheet2->setCellValue('G1','Description');
            $worksheet2->setCellValue('H1','User Name');
            $worksheet2->setCellValue('I1','User Email');
            $worksheet2->getStyle($this->sheetCol1)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB($this->sheetbgColor); // cell color
            $worksheet2->getStyle($this->sheetCol1)->applyFromArray($styleArray);
            $worksheet2->getStyle($this->sheetCol1)->getAlignment()->setHorizontal('center');
            $worksheet2->getStyle($this->sheetCol1)->getAlignment()->setVertical('center');

            if(count($taskdata2)>0){
                foreach ($taskdata2 as  $value) {
                    $row=2;
                    $worksheet2->setCellValue('A'.$row,$value['title']);
                    $worksheet2->setCellValue('B'.$row,$value['planed_start']);
                    $worksheet2->setCellValue('C'.$row,$value['planed_end']);
                    $worksheet2->setCellValue('D'.$row,$value['duration']);
                    $worksheet2->setCellValue('E'.$row,$value['percentage']);
                    $worksheet2->setCellValue('F'.$row,$value['progress_updated_date']);
                    $worksheet2->setCellValue('G'.$row,$value['description']);
                    $worksheet2->setCellValue('H'.$row,$value['user']);
                    $worksheet2->setCellValue('I'.$row,$value['email']);
                    $row++;

                }
            }else{
                $worksheet2->mergeCells('A2:I2');
                $worksheet2->setCellValue('A2',$this->norecord);
                $sheet->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setHorizontal('center');
                $sheet->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setVertical('center');
            }

            $download_directory = './Report_list.xlsx';
            $writer = IOFactory::createWriter($sheet, 'Xlsx');
			$writer->save($download_directory);
			$content = file_get_contents($download_directory);
			$filename= $project->project_name.'_Daily Site Workdone Producivity Report_'.date('Y-m-d H:i:s').'.xlsx';
			header("Content-Disposition: attachment; filename=".$filename);
			unlink($download_directory);
            exit($content);
             
        }
    }
    // cron email
    public function cronmail(Request $request)
    {
        // record
        $array = ['date' => date('d-m-Y H:i:s')];
        DB::table('cron_attempts')->insert($array);
        // recordend
        $time = Carbon::now()->format('H:i');
        $project = Project::where('end_date', '>=', Carbon::now()->format('Y-m-d'))->where('report_time', $time)->get();
        foreach ($project as  $value3) {
            $holidays = DB::table('project_holidays')->where(['project_id' => $value3->id,
                'instance_id' => $value3->instance_id])->where('date', Carbon::now()->format('Y-m-d'))->first();
            if (! $holidays) {
                if (! str_contains($value3->non_working_days, Carbon::now()->format('w'))) {
                    if ($value3->freeze_status == 1) {
                        Reportemail::dispatch($value3->id);
                    }
                }

            }

        }
    }

    public function fetch_user_details(Request $request)
    {

        try {

            $usr = \Auth::user();

            $user_projects = $usr->projects()->pluck('project_id', 'project_id')->toArray();

            $country = $request->country_id;

            if ($country != '') {
                $data = User::select('users.name', 'users.id')
                    ->leftjoin('project_users as project', 'project.user_id', '=', 'users.id')
                    ->where('project.project_id', $country)
                    ->groupBy('users.id')
                    ->get();
            } else {
                $data = User::select('users.name', 'users.id')
                    ->leftjoin('project_users as project', 'project.user_id', '=', 'users.id')
                    ->whereIn('project.project_id', $user_projects)
                    ->groupBy('users.id')
                    ->get();
            }

            $user = [];
            foreach ($data as $value) {
                $user[] = ['name' => $value->name, 'id' => $value->id];
            }

            return response()->json($user);

        } catch (Exception $e) {

            return $e->getMessage();

        }

    }

    public function fetch_task_details(Request $request)
    {

        try {
            $instance_id = Session::get('project_instance');
            $setting = Utility::settings(\Auth::user()->creatorId());
            if ($setting['company_type'] == 2) {
                $data = Con_task::whereRaw($this->findinSet.$request->state_id.$this->usersSet)
                    ->select('main_id as id', 'text as name')
                    ->where(['project_id' => $request->get_id, 'instance_id' => $instance_id])
                    ->get();
            } else {
                $data = ProjectTask::whereRaw("find_in_set('$request->state_id',project_tasks.assign_to)")
                    ->where('project_tasks.project_id', $request->get_id)
                    ->get();
            }

            return response()->json($data);

        } catch (Exception $e) {

            return $e->getMessage();

        }

    }
}
