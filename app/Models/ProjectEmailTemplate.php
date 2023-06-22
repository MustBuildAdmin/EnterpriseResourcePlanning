<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectEmailTemplate extends Model
{
    protected $fillable = [
        'template_id',
        'project_id',
        'is_active',
    ];
}
