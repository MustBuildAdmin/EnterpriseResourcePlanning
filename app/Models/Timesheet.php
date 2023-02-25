<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    protected $fillable = [
        'project_id',
        'task_id',
        'date',
        'time',
        'description',
        'created_by',
    ];

    public function project()
    {
        return $this->hasOne('App\Models\Project', 'id', 'project_id');
    }

    public function task()
    {
        return $this->hasOne('App\Models\ProjectTask', 'id', 'task_id');
    }
}
