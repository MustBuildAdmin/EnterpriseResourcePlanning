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

class ProjectReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
                $projects = Project::select('projects.*')
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
            $projects = Project::select('projects.*')
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

        if (\Auth::user()->type == 'super admin') {
            $users = User::where('created_by', '=', $user->creatorId())->where('type', '=', 'company')->get();
        } else {
            $users = User::where('created_by', '=', $user->creatorId())->where('type', '!=', 'client')->get();
        }

        if ($user->type == 'client') {
            $project = Project::where('client_id', '=', $user->id)->where('id', $id)->first();
        } elseif (\Auth::user()->type == 'employee') {

            $project = Project::select('projects.*')
                ->leftjoin('project_users', 'project_users.project_id', 'projects.id')
                ->where('project_users.user_id', '=', $user->id)->first();

            // dd($project);
        } else {
            $project = Project::where('created_by', '=', $user->id)->where('id', $id)->first();
        }

        if ($user) {
            $chartData = $this->getProjectChart(
                [
                    'project_id' => $id,
                    'duration' => 'week',
                ]
            );
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
            $data = [];
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
            $data = $objProject->pluck('total', 'stage_id')->all();
            $arrTask['label'][] = __($label);

            return $arrTask;
        }
    }

    public function export($id)
    {
        $name = 'task_report_'.date('Y-m-d i:h:s');
        $data = Excel::download(new task_reportExport($id), $name.'.xlsx');

        return $data;
    }

    public function send_report_con(Request $request)
    {

        if (\Auth::user()->type == 'company' || \Auth::user()->type == 'super admin') {
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
            foreach ($project_task as $key => $value) {
                $planned_start = date('d-m-Y', strtotime($value->start_date));
                $planned_end = date('d-m-Y', strtotime($value->end_date));

                $actual_start = DB::table('task_progress')->where('project_id', Session::get('project_id'))
                    ->where('instance_id', Session::get('project_instance'))
                    ->where('task_id', $value->main_id)->max('created_at');
                $actual_end = DB::table('task_progress')->where('project_id', Session::get('project_id'))
                    ->where('instance_id', Session::get('project_instance'))
                    ->where('task_id', $value->main_id)->min('created_at');
                $flag = 0;
                if ($actual_start) {
                    $flag = 1;
                    $actual_start = date('d-m-Y', strtotime($actual_start));
                } else {
                    $actual_start = 'Task Not Started';
                }

                if ($actual_end) {
                    $actual_end = date('d-m-Y', strtotime($actual_end));
                } else {
                    $actual_end = 'Task Not Finish';
                }

                if ($actual_end < $planned_end) {
                    $actual_end = 'Task Not Finish';
                }
                //finding planned percentage
                //############## days finding ####################################################
                $date1 = date_create($value->start_date);
                $date2 = date_create($value->end_date);
                $cur = date('Y-m-d');

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

                $remaing_percenatge = round(100 - $current_percentage);

                //####################################___END____#######################################
                //  // actual duration finding
                $taskdata[] = [
                    'title' => $value->text,
                    'planed_start' => $planned_start,
                    'planed_end' => $planned_end,
                    'duration' => $value->duration.' Days',
                    'percentage_as_today' => round($current_percentage),
                    'actual_start' => $actual_start,
                    'actual_end' => $actual_end,
                    'actual_duration' => $value->duration.' Days',
                    'remain_duration' => $value->duration.' Days',
                    'actual_percent' => round($value->progress),
                ];
            }
            $taskdata2 = [];
            $today_task_update = DB::table('task_progress')->where('project_id', Session::get('project_id'))
                ->where('instance_id', Session::get('project_instance'))
                ->where('record_date', 'like', Carbon::now()->format('Y-m-d').'%')->get();
            $instance_id = Session::get('project_instance');

            foreach ($today_task_update as $key => $value) {
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
                    'duration' => $main_task->duration.' Days',
                    'percentage' => $value->percentage.'%',
                    'progress_updated_date' => date('d-m-Y', strtotime($value->record_date)),
                    'description' => $value->description,
                    'user' => $user_name,
                    'email' => $user_email,

                ];
            }
            $to = [];
            $to_array = explode(',', $project->report_to);
            foreach ($to_array as $key => $value) {
                $to[] = DB::table('users')->where('id', $value)->pluck('email')->first();
            }

            if (! $to) {
                return redirect()->back()->with('error', __('Not Assign a Report person'));
            }
            // return Pdf::loadView('project_report.email', compact('taskdata','project','project_task','actual_current_progress','actual_remaining_progress','taskdata2'))->setPaper('a4', 'landscape')->setWarnings(false);
            $pdf = Pdf::loadView('project_report.email', compact('taskdata', 'project', 'project_task', 'actual_current_progress', 'actual_remaining_progress', 'taskdata2'))->setPaper('a4', 'landscape')->setWarnings(false);
            $pdf_name = $project->project_name.date('Y-m-d').'.pdf';

            return $pdf->download($pdf_name);
            // $data["email"] = $to;
            // $data["title"] = $project->project_name."- Daily Productivity Report";
            // $data["body"] = "Please find the attachment of the Today Productivity report";
            // try
            // {
            //     Mail::send('construction_project.mail',$data, function($message)use($data, $pdf) {
            //         $message->to($data["email"], $data["email"])
            //                 ->subject($data["title"])
            //                 ->attachData($pdf->output(),'Report.pdf');

            //     });

            // }catch(\Exception $e)
            // {
            //     $error = $e->getMessage();
            //     dd($error);

            // }
            // return redirect()->back()->with('success', __('Email send Successfully'));

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
        foreach ($project as $key => $value3) {
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
            foreach ($data as $key => $value) {
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
                $data = Con_task::whereRaw("find_in_set('".$request->state_id."',users)")
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
