<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BugFile extends Model
{
    protected $fillable = [
        'file','name','extension','file_size','created_by','bug_id','user_type'
    ];
}
