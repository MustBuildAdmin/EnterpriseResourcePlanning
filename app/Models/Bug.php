<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bug extends Model
{
    protected $fillable = [
        'bug_id',
        'project_id',
        'title',
        'priority',
        'start_date',
        'due_date',
        'description',
        'status',
        'assign_to',
        'created_by',
    ];

    public static $priority = [
        'low' => 'Low',
        'medium' => 'Medium',
        'high' => 'High',
    ];

    public function bug_status()
    {
        return $this->hasOne('App\Models\BugStatus', 'id', 'status');
    }

    public function assignTo()
    {
        return $this->hasOne('App\Models\User', 'id', 'assign_to');
    }

    public function createdBy()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\BugComment', 'bug_id', 'id')->orderBy('id', 'DESC');
    }

    public function bugFiles()
    {
        return $this->hasMany('App\Models\BugFile', 'bug_id', 'id')->orderBy('id', 'DESC');
    }
    public function project()
    {
        return $this->hasOne('App\Models\Project', 'id', 'project_id');
    }
    public function users()
    {
        return User::whereIn('id', explode(',', $this->assign_to))->get();
    }
}
