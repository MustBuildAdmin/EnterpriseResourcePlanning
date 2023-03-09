<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Con_task extends Model
{
    use HasFactory;

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

    public function users()
    {
        return User::whereIn('id', explode(',', $this->users))->get();
    }

    public function project()
    {
        return $this->hasOne('App\Models\Project', 'id', 'project_id');
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

    public function checklist()
    {
        return $this->hasMany('App\Models\TaskChecklist', 'task_id', 'id')->orderBy('id', 'DESC');
    }
}
