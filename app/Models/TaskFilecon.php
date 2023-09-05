<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskFilecon extends Model
{
    protected $table = 'task_file_cons';

    protected $fillable = [
        'file',
        'name',
        'extension',
        'file_size',
        'task_id',
        'user_type',
        'created_by',
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }
}
