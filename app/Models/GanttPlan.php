<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

// Gantt
class GanttPlan extends Model
{
    protected $table = 'planning_temp';
    protected $fillable = [
        'task_id',
        'project_id',
        'text',
        'start_date',
        'end_date',
        'duration',
        'progress',
        'is_open',
        'parent',
        'is_active',
    ];


}
