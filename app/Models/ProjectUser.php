<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectUser extends Model
{
    protected $fillable = [
        'project_id',
        'user_id',
        'invited_by',
    ];

    public function projectUsers()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}


