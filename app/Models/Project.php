<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use DB;
class Project extends Model
{
    protected $fillable = [
        'project_name',
        'start_date',
        'end_date',
        'client_id',
        'project_image',
        'budget',
        'estimated_hrs',
        'project_stage_id',
        'description',
        'status',
        'tags',
        'created_by',
        'otheraddress'
    ];

    public static $project_status = [
        'in_progress' => 'In Progress',
        'on_hold' => 'On Hold',
        'complete' => 'Completed',
        'canceled' => 'Canceled',
    ];

    public static $status_color = [
        'on_hold' => 'warning',
        'in_progress' => 'info',
        'complete' => 'success',
        'canceled' => 'danger',
    ];
    public static $freeze_status = [
        'on_hold' => 'In-Active',
        'complete' => 'Active',
    ];

    public function milestones()
    {
        return $this->hasMany('App\Models\Milestone', 'project_id', 'id');
    }

    protected $appends = ['img_image'];

    // Make new attribute for directly get image
    public function getImgImageAttribute()
    {
        if ($this->project_image != null) {
            if (\Storage::exists($this->project_image) && ! empty($this->project_image)) {
                return $this->attributes['img_image'] = 'src='.asset(\Storage::url($this->project_image));
            } else {
                return $this->attributes['img_image'] = 'avatar='.$this->project_name;
            }
        } else {
            return $this->attributes['img_image'] = 'avatar='.$this->project_name;
        }

    }

    public static function projectHrs($project_id, $task_id = '')
    {
        $project = Project::find($project_id);
        $tasks = ProjectTask::where('project_id', '=', $project_id)->get();
        $taskHrs = 0;

        foreach ($tasks as $task) {
            $taskHrs += $task->estimated_hrs;
        }

        return [
            'allocated' => $taskHrs,
        ];
    }

    public function project_progress()
    {

        $percentage = 0;
        $last_task = TaskStage::orderBy('order', 'DESC')->where('created_by', \Auth::user()->creatorId())->first();
        $total_task = $this->tasks->count();
        $completed_task = $this->tasks()->where('stage_id', '=', $last_task->id)->where('is_complete', '=', 1)->count();
        //dd($last_task,$total_task,$completed_task);
        if ($total_task > 0) {
            $percentage = intval(($completed_task / $total_task) * 100);
        }

        $color = Utility::getProgressColor($percentage);

        return [
            'color' => $color,
            'percentage' => $percentage.'%',
        ];
    }

    public function tasks()
    {
        return $this->hasMany('App\Models\ProjectTask', 'project_id', 'id')->orderBy('id', 'desc');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'project_users', 'project_id', 'user_id');
    }
    
    //for project-report
    public function client()
    {
        return $this->hasOne('App\Models\User', 'id', 'client_id');
    }

    public function projectAttachments()
    {
        $usr = Auth::user();
        $tasks = $this->tasks->pluck('id');

        return TaskFile::whereIn('task_id', $tasks)->get();
    }

    public function activities()
    {
        $usr = Auth::user();
        $activity = $this->hasMany('App\Models\ActivityLog', 'project_id', 'id')->orderBy('id', 'desc');

        return $activity;
    }

    public function expense()
    {
        return $this->hasMany('App\Models\Expense', 'project_id', 'id')->orderBy('id', 'desc');
    }

    // Return timesheet html in table format
    public static function getProjectAssignedTimesheetHTML($projects_timesheet = null,
     $timesheets = [], $days = [], $project_id = null)
    {

        $i = $k = 0;
        $allProjects = false;
        $timesheetArray = $totaltaskdatetimes = [];

        if ($project_id == '0') {
            $allProjects = true;
            foreach ($timesheets as $project_id => $timesheet) {
                $project = Project::find($project_id);
                if ($project) {
                    $timesheetArray[$k]['project_id'] = $project->id;
                    $timesheetArray[$k]['project_name'] = $project->project_name;
                    foreach ($timesheet as $task_id => $tasktimesheet) {
                        $task = ProjectTask::find($task_id);
                        if ($task) {
                            $timesheetArray[$k]['taskArray'][$i]['task_id'] = $task->id;
                            $timesheetArray[$k]['taskArray'][$i]['task_name'] = $task->name;
                            $new_projects_timesheet = clone $projects_timesheet;
                            $users = $new_projects_timesheet->where('task_id', $task->id)->groupBy('created_by')
                            ->pluck('created_by')->toArray();
                            foreach ($users as $count => $user_id) {
                                $times = [];
                                for ($j = 0; $j < 7; $j++) {
                                    $date = $days['datePeriod'][$j]->format('Y-m-d');
                                    $filtered_array = array_filter(
                                        $tasktimesheet, function ($val) use ($user_id, $date) {
                                            return $val['created_by'] == $user_id and $val['date'] == $date;
                                        }
                                    );
                                    $key = array_keys($filtered_array);
                                    $user = User::find($user_id);
                                    $timesheetArray[$k]['taskArray'][$i]['dateArray'][$count]['user_id'] =
                                     $user != null ? $user->id : '';
                                    $timesheetArray[$k]['taskArray'][$i]['dateArray'][$count]['user_name'] =
                                     $user != null ? $user->name : '';
                                    $timesheetArray[$k]['taskArray'][$i]['dateArray'][$count]['week'][$j]['date']
                                     = $date;
                                    if (! empty($key) && count($key) > 0) {
                                        $time = Carbon::parse($tasktimesheet[$key[0]]['time'])->format('H:i');
                                        $times[] = $time;
                                        $timesheetArray[$k]['taskArray'][$i]['dateArray'][$count]['week'][$j]['time']
                                         = $time;
                                        $timesheetArray[$k]['taskArray'][$i]['dateArray'][$count]['week'][$j]['type']
                                         = 'edit';
                                        $timesheetArray[$k]['taskArray'][$i]['dateArray'][$count]['week'][$j]['url']
                                         = route(
                                            'timesheet.edit', [
                                                $project_id,
                                                $tasktimesheet[$key[0]]['id'],
                                            ]
                                        );
                                    } else {
                                        $timesheetArray[$k]['taskArray'][$i]['dateArray'][$count]['week'][$j]['time']
                                         = '00:00';
                                        $timesheetArray[$k]['taskArray'][$i]['dateArray'][$count]['week'][$j]['type']
                                         = 'create';
                                        $timesheetArray[$k]['taskArray'][$i]['dateArray'][$count]['week'][$j]['url']
                                         = route('timesheet.create', $project_id);
                                    }
                                }
                                $calculatedtasktime = Utility::calculateTimesheetHours($times);
                                $totaltaskdatetimes[] = $calculatedtasktime;
                                $timesheetArray[$k]['taskArray'][$i]['dateArray'][$count]['totaltime'] = $calculatedtasktime;
                            }
                        }
                        $i++;
                    }
                }
                $k++;
            }
        } else {
            foreach ($timesheets as $task_id => $timesheet) {
                $times = [];
                $task = ProjectTask::find($task_id);
                if ($task) {
                    $timesheetArray[$i]['task_id'] = $task->id;
                    $timesheetArray[$i]['task_name'] = $task->name;
                    for ($j = 0; $j < 7; $j++) {
                        $date = $days['datePeriod'][$j]->format('Y-m-d');
                        $key = array_search($date, array_column($timesheet, 'date'));
                        $timesheetArray[$i]['dateArray'][$j]['date'] = $date;
                        if ($key !== false) {
                            $time = Carbon::parse($timesheet[$key]['time'])->format('H:i');
                            $times[] = $time;
                            $timesheetArray[$i]['dateArray'][$j]['time'] = $time;
                            $timesheetArray[$i]['dateArray'][$j]['type'] = 'edit';
                            $timesheetArray[$i]['dateArray'][$j]['url'] = route(
                                'timesheet.edit', [
                                    $project_id,
                                    $timesheet[$key]['id'],
                                ]
                            );
                        } else {
                            $timesheetArray[$i]['dateArray'][$j]['time'] = '00:00';
                            $timesheetArray[$i]['dateArray'][$j]['type'] = 'create';
                            $timesheetArray[$i]['dateArray'][$j]['url'] = route('timesheet.create', $project_id);
                        }
                    }
                    $calculatedtasktime = Utility::calculateTimesheetHours($times);
                    $totaltaskdatetimes[] = $calculatedtasktime;
                    $timesheetArray[$i]['totaltime'] = $calculatedtasktime;
                }
                $i++;
            }
        }

        $calculatedtotaltaskdatetime = Utility::calculateTimesheetHours($totaltaskdatetimes);

        foreach ($days['datePeriod'] as $key => $date) {
            $dateperioddate = $date->format('Y-m-d');
            $new_projects_timesheet = clone $projects_timesheet;
            $totalDateTimes[$dateperioddate] = Utility::calculateTimesheetHours($new_projects_timesheet->where('date', $dateperioddate)->pluck('time')->toArray());
        }
        $returnHTML = view('projects.timesheets.week', compact('timesheetArray', 'totalDateTimes', 'calculatedtotaltaskdatetime', 'days', 'allProjects'))->render();

        return $returnHTML;
    }

    // Get Mileston desc wise
    public function tasksections()
    {
        return $this->hasMany('App\Models\Milestone', 'project_id', 'id')->orderBy('id', 'desc');
    }

    public static function getAssignedProjectTasks($project_id = null, $stage_id = null, $filterdata = [])
    {
        $authuser = \Auth::user();
        $project = Project::find($project_id);
        $tasks = new ProjectTask();

        if ($project) {
            $task_ids = $authuser->tasks()->pluck('id')->toArray();
            $tasks = $tasks->whereIn('id', $task_ids);
            $tasks = $tasks->where('project_id', '=', $project_id);
        } else {
            $task_ids = $authuser->tasks()->pluck('id')->toArray();
            $tasks = $tasks->whereIn('id', $task_ids);
        }
        if ($stage_id) {
            $tasks = $tasks->where('stage_id', '=', $stage_id);
        }

        return $tasks;
    }

    // Get Project based it's Timesheet
    public function timesheets()
    {
        return $this->hasMany('App\Models\Timesheet', 'project_id', 'id')->orderBy('id', 'desc');
    }

    // For Delete project and it's based sub record
    public static function deleteProject($project_id)
    {
        $taskstatus = $projectstatus = false;

        $project = Project::find($project_id);

        if ($project) {
            Utility::checkFileExistsnDelete([$project->image]);

            $project->milestones()->delete();

            $project->activities()->delete();

            $project->timesheets()->delete();

            $project->users()->detach();

            //$project->taskstages()->delete();

            $task_ids = ProjectTask::where('project_id', $project->id)->pluck('id')->toArray();

            if (! empty($task_ids) && count($task_ids) > 0) {
                $taskstatus = ProjectTask::deleteTask($task_ids);
            }

            $projectstatus = $project->delete();
        }

        echo json_encode($projectstatus);
    }

    public function label()
    {
        return $this->hasOne('App\Models\Label', 'id', 'status')->first();
    }

    public function project_user()
    {
        return $this->hasMany('App\Models\ProjectUser', 'user_id', 'id');
    }

    // Get Project Task Count "completed/total"
    public function countTask($user_id = 0)
    {
        $auth_user = Auth::user();
        if ($auth_user->checkProject($this->id) == 'Owner') {
            $complete_task = $this->tasks->where('is_complete', '=', 1)->count();
            $total_task = $this->tasks->count();
        } else {
            $usr = $user_id;
            $complete_task = $this->tasks()->where('is_complete', '=', 1)->whereRaw("find_in_set('".$usr."',assign_to)")->count();
            $total_task = $this->tasks()->whereRaw("find_in_set('".$usr."',assign_to)")->count();
        }

        return $complete_task.'/'.$total_task;
    }

    public static function getProjectStatus()
    {

        $projectData = [];
        if (\Auth::user()->type == 'company') {
            $on_going = Project::where('status', '=', 'in_progress')->where('created_by', '=', \Auth::user()->id)->count();
            $on_hold = Project::where('status', '=', 'on_hold')->where('created_by', '=', \Auth::user()->id)->count();
            $completed = Project::where('status', '=', 'complete')->where('created_by', '=', \Auth::user()->id)->count();
            $canceled = Project::where('status', '=', 'canceled')->where('created_by', '=', \Auth::user()->id)->count();
            $total = $on_going + $on_hold + $completed;

            $projectData['on_going'] = ($total != 0 ? number_format(($on_going / $total) * 100, 2) : 0);
            $projectData['on_hold'] = ($total != 0 ? number_format(($on_hold / $total) * 100, 2) : 0);
            $projectData['completed'] = ($total != 0 ? number_format(($completed / $total) * 100, 2) : 0);
        } elseif (\Auth::user()->type == 'client') {
            $on_going = Project::where('status', '=', 'in_progress')->where('client_id', '=', \Auth::user()->id)->count();
            $on_hold = Project::where('status', '=', 'on_hold')->where('client_id', '=', \Auth::user()->id)->count();
            $completed = Project::where('status', '=', 'complete')->where('client_id', '=', \Auth::user()->id)->count();
            $canceled = Project::where('status', '=', 'canceled')->where('client_id', '=', \Auth::user()->id)->count();
            $total = $on_going + $on_hold + $completed + $canceled;

            $projectData['on_going'] = (int) ($total != 0 ? number_format(($on_going / $total) * 100, 2) : 0);
            $projectData['on_hold'] = (int) ($total != 0 ? number_format(($on_hold / $total) * 100, 2) : 0);
            $projectData['completed'] = (int) ($total != 0 ? number_format(($completed / $total) * 100, 2) : 0);
            $projectData['canceled'] = (int) ($total != 0 ? number_format(($canceled / $total) * 100, 2) : 0);
            //            dd($projectData);
        } else {

            $on_going = ProjectUser::join('projects', 'project_users.project_id', '=', 'projects.id')->where('projects.status', '=', 'in_progress')->where('user_id', '=', \Auth::user()->id)->count();
            $on_hold = ProjectUser::join('projects', 'project_users.project_id', '=', 'projects.id')->where('projects.status', '=', 'on_hold')->where('user_id', '=', \Auth::user()->id)->count();
            $completed = ProjectUser::join('projects', 'project_users.project_id', '=', 'projects.id')->where('projects.status', '=', 'complete')->where('user_id', '=', \Auth::user()->id)->count();
            $canceled = ProjectUser::join('projects', 'project_users.project_id', '=', 'projects.id')->where('projects.status', '=', 'canceled')->where('user_id', '=', \Auth::user()->id)->count();
            $total = $on_going + $on_hold + $completed + $canceled;

            $projectData['on_going'] = ($total != 0 ? number_format(($on_going / $total) * 100, 2) : 0);
            $projectData['on_hold'] = ($total != 0 ? number_format(($on_hold / $total) * 100, 2) : 0);
            $projectData['completed'] = ($total != 0 ? number_format(($completed / $total) * 100, 2) : 0);
            $projectData['canceled'] = ($total != 0 ? number_format(($canceled / $total) * 100, 2) : 0);
        }

        return $projectData;
    }

    public function project_last_stage()
    {
        return TaskStage::where('created_by', '=', \Auth::user()->creatorId())->orderBy('order', 'desc')->first();
    }

    public function project_total_task($project_id)
    {
        return ProjectTask::where('project_id', '=', $project_id)->count();
    }

    public function project_complete_task($project_id, $last_stage_id)
    {
        return ProjectTask::where('project_id', '=', $project_id)->where('stage_id', '=', $last_stage_id)->count();
    }

    public function project_milestone_progress()
    {
        $total_milestone = Milestone::where('project_id', '=', $this->id)->count();
        $total_progress_sum = Milestone::where('project_id', '=', $this->id)->sum('progress');
        //        dd($total_progress_sum);

        if ($total_milestone > 0) {
            $percentage = intval(($total_progress_sum / $total_milestone));

            return [
                'percentage' => $percentage.'%',
            ];
        } else {
            return [
                'percentage' => 0,
            ];

        }
    }

    public static function project_member($projectid)
    {
        return ProjectUser::whereNot('user_id',\Auth::user()->creatorId())
        ->where('project_id',$projectid)
        ->get();
    }

    public static function actual_progress($projectid){
        return Con_task::where('project_id',$projectid)
        ->orderBy('main_id', 'asc')
        ->pluck ('progress')
        ->first();
    }

    public static function get_user_name($userid){
        return User::where('id',$userid)->first();
    }
}
