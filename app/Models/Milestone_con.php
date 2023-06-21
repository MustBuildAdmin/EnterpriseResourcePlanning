<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milestone_con extends Model
{
    use HasFactory;

    public function tasks()
    {
        return $this->hasMany('App\Models\Project_tasks_con', 'milestone_id', 'id');
    }
}
