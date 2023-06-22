<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Utility;
use App\Models\Task_file_con;
use App\Models\Task;
use App\Models\TaskStage;
use Carbon\Carbon;
use App\Models\ProjectTask;
use App\Models\Activity_logs_con;
use App\Models\Expenses_con;
use App\Models\Construction_project;
use Illuminate\Support\Facades\Auth;

class Construction_project extends Model
{
    use HasFactory;
    public static $project_status=[
        'in_progress' => 'In Progress',
        'on_hold' => 'On Hold',
        'complete' => 'Complete',
        'canceled' => 'Canceled'
    ];

    public static $status_color = [
        'on_hold' => 'warning',
        'in_progress' => 'info',
        'complete' => 'success',
        'canceled' => 'danger',
    ];

    public function users_details()
    {
        return $this->hasMany('App\Models\Construction_asign', 'project_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'construction_asigns', 'project_id', 'user_id');
    }

    public function activities()
    {
        $usr = Auth::user();
        $activity = $this->hasMany('App\Models\Activity_logs_con', 'project_id', 'id')->orderBy('id', 'desc');
        return $activity;
    }

    public function expense()
    {
        return $this->hasMany('App\Models\Expenses_con', 'project_id', 'id')->orderBy('id', 'desc');
    }

    public function tasks()
    {
        return $this->hasMany('App\Models\Project_tasks_con', 'project_id', 'id')->orderBy('id', 'desc');
    }

    public function milestones()
    {
        return $this->hasMany('App\Models\Milestone_con', 'project_id', 'id');
    }
    public function timesheets()
    {
        return $this->hasMany('App\Models\Timesheet_con', 'project_id', 'id')->orderBy('id', 'desc');
    }

    public static function projectHrs($project_id, $task_id = '')
    {
        $project = Project::find($project_id);
        $tasks   = ProjectTask::where('project_id', '=', $project_id)->get();
        $taskHrs = 0;

        foreach($tasks as $task)
        {
            $taskHrs += $task->estimated_hrs;
        }

        return [
            'allocated' => $taskHrs,
        ];
    }

    public function project_progress()
    {

        $percentage = 0;
        $last_task      = TaskStage::orderBy('order', 'DESC')->where('created_by',\Auth::user()->creatorId())->first();
        $total_task     = $this->tasks->count();
        $completed_task = $this->tasks()->where('stage_id', '=', $last_task->id)->where('is_complete', '=', 1)->count();
//dd($last_task,$total_task,$completed_task);
        if($total_task > 0)
        {
            $percentage = intval(($completed_task / $total_task) * 100);
        }

        $color = Utility::getProgressColor($percentage);

        return [
            'color' => $color,
            'percentage' => $percentage . '%',
        ];
    }

    public function projectAttachments()
    {
        $usr = Auth::user();
        $tasks = $this->tasks->pluck('id');
        return Task_file_con::whereIn('task_id', $tasks)->get();
    }

}
