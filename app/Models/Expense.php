<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'name',
        'date',
        'description',
        'amount',
        'attachment',
        'project_id',
        'task_id',
        'created_by',
    ];

    // Get Expense based task
    public function task()
    {
        return $this->hasOne('App\Models\ProjectTask', 'id', 'task_id');
    }

    // Get Expense based project
    public function project()
    {
        return $this->hasOne('App\Models\Project', 'id', 'project_id');
    }

}
