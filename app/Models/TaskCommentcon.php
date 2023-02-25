<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskCommentcon extends Model
{
    protected $fillable = [
        'comment',
        'task_id',
        'user_id',
        'user_type',
        'created_by',
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }



}
