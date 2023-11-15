<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Drawing extends Model
{
    protected $fillable = [
        'reference_number', 'drawing_type', 'drawing_path','created_at','updated_at',
    ];
}
