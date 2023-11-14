<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadDrawingsToTypes extends Model
{
    protected $fillable = [
        'drawing_type', 'revisions', 'status', 'drawing_path', 'created_by', 'created_at', 'updated_at',
    ];
}

