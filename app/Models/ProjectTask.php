<?php

namespace App\Models;

use App\Models\User;
use App\Models\Utility;
use App\Models\TaskFile;
use App\Models\ActivityLog;
use App\Models\TaskComment;
use App\Models\TaskChecklist;
use Illuminate\Database\Eloquent\Model;

class ProjectTask extends Model
{
    protected $fillable = [
        'name',
        'description',
        'estimated_hrs',
        'start_date',
        'end_date',
        'priority',
        'priority_color',
        'assign_to',
        'project_id',
        'milestone_id',
        'stage_id',
        'order',
        'created_by',
        'is_favourite',
        'is_complete',
        'marked_at',
        'progress',
    ];

    public static $priority = [
        'critical' => 'Critical',
        'high' => 'High',
        'medium' => 'Medium',
        'low' => 'Low',
    ];

    public static $priority_color = [
        'critical' => 'danger',
        'high' => 'warning',
        'medium' => 'primary',
        'low' => 'info',
    ];

    public function milestone()
    {
        return $this->hasOne('App\Models\Milestone','id', 'milestone_id');
    }

    public function users()
    {
        return User::whereIn('id', explode(',', $this->assign_to))->get();
    }

    public function project()
    {
        return $this->hasOne('App\Models\Project', 'id', 'project_id');
    }

    public function stage()
    {
        return $this->hasOne('App\Models\TaskStage', 'id', 'stage_id');
    }

    public function taskProgress()
    {
        $project    = Project::find($this->project_id);
        $percentage = 0;

        $total_checklist     = $this->checklist->count();
        $completed_checklist = $this->checklist()->where('status', '=', '1')->count();

        if($total_checklist > 0)
        {
            $percentage = intval(($completed_checklist / $total_checklist) * 100);
        }

        $color = Utility::getProgressColor($percentage);

        return [
            'color' => $color,
            'percentage' => $percentage . '%',
        ];
    }
    public function task_user(){
        return $this->hasOne('App\Models\User','id','assign_to');
    }
    public function checklist()
    {
        return $this->hasMany('App\Models\TaskChecklist', 'task_id', 'id')->orderBy('id', 'DESC');
    }

    public function taskFiles()
    {
        return $this->hasMany('App\Models\TaskFile', 'task_id', 'id')->orderBy('id', 'DESC');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\TaskComment', 'task_id', 'id')->orderBy('id', 'DESC');
    }

    public function countTaskChecklist()
    {
        return $this->checklist->where('status', '=', 1)->count() . '/' . $this->checklist->count();
    }

    public static function deleteTask($task_ids)
    {
        $status = false;

        foreach($task_ids as $key => $task_id)
        {
            $task = ProjectTask::find($task_id);

            if($task)
            {
                // Delete Attachments
                $taskattachments = TaskFile::where('task_id', '=', $task->id);
                $attachmentfiles = $taskattachments->pluck('file')->toArray();
                Utility::checkFileExistsnDelete($attachmentfiles);
                $taskattachments->delete();

                // Delete Timesheets
                $task->timesheets()->delete();

                // Delete Checklists
                TaskChecklist::where('task_id', '=', $task->id)->delete();

                // Delete Comments
                TaskComment::where('task_id', '=', $task->id)->delete();

                // Delete Task
                $status = $task->delete();
            }
        }

        return true;
    }

    public function activity_log()
    {
        return ActivityLog::where('user_id', '=', \Auth::user()->id)->where('project_id', '=', $this->project_id)->where('task_id', '=', $this->id)->get();
    }

    // Return milestone wise tasks
    public static function getAllSectionedTaskList($request, $project, $filterdata = [], $not_task_ids = [])
    {
        $taskArray    = $sectionArray = [];
        $counter      = 1;
        $taskSections = $project->tasksections()->pluck('title', 'id')->toArray();
        $section_ids  = array_keys($taskSections);
        $task_ids     = Project::getAssignedProjectTasks($project->id, null, $filterdata)->whereNotIn('milestone_id', $section_ids)->whereNotIn('id', $not_task_ids)->orderBy('id', 'desc')->pluck('id')->toArray();
        if(!empty($task_ids) && count($task_ids) > 0)
        {
            $counter                              = 0;
            $taskArray[$counter]['section_id']    = 0;
            $taskArray[$counter]['section_name']  = '';
            $taskArray[$counter]['sectionsClass'] = 'active';
            foreach($task_ids as $task_id)
            {
                $task                            = ProjectTask::find($task_id);
                $taskCollectionArray             = $task->toArray();
                $taskCollectionArray['taskinfo'] = json_decode(app('App\Http\Controllers\ProjectTaskController')->getDefaultTaskInfo($request, $task->id), true);

                $taskArray[$counter]['sections'][] = $taskCollectionArray;
            }
            $counter++;
        }
        if(!empty($section_ids) && count($section_ids) > 0)
        {
            foreach($taskSections as $section_id => $section_name)
            {
                $tasks                               = Project::getAssignedProjectTasks($project->id, null, $filterdata)->where('project_tasks.milestone_id', $section_id)->whereNotIn('id', $not_task_ids)->orderBy('id', 'desc')->get()->toArray();
                $taskArray[$counter]['section_id']   = $section_id;
                $taskArray[$counter]['section_name'] = $section_name;
                $sectiontasks                        = $tasks;

                foreach($tasks as $onekey => $onetask)
                {
                    $sectiontasks[$onekey]['taskinfo'] = json_decode(app('App\Http\Controllers\ProjectTaskController')->getDefaultTaskInfo($request, $onetask['id']), true);
                }

                $taskArray[$counter]['sections']      = $sectiontasks;
                $taskArray[$counter]['sectionsClass'] = 'active';
                $counter++;
            }
        }

        return $taskArray;
    }

    public function timesheets()
    {
        return $this->hasMany('App\Models\Timesheet', 'task_id', 'id')->orderBy('id', 'desc');
    }
}
