<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserToDo extends Model
{
    protected $fillable = [
        'title',
        'is_complete',
        'user_id',
    ];
}
