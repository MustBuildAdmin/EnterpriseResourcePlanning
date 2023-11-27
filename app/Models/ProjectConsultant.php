<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectConsultant extends Model
{
    protected $fillable = [
        'project_id',
        'user_id',
        'invited_by',
        'invite_status',
    ];
    
    protected $table = 'project_consultants';


    public function projectUsers()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
