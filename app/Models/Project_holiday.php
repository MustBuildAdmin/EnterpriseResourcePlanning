<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project_holiday extends Model
{
    use HasFactory;
    public function project_name()
    {
        return $this->belongsTo('App\Models\Project', 'project_id', 'id');
    }
}
