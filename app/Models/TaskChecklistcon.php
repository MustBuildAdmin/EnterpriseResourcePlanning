<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskChecklistcon extends Model
{
    protected $fillable = [
        'name',
        'task_id',
        'user_type',
        'created_by',
        'status',
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }
}
