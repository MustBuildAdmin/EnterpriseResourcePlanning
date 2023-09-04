<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonWorkingDaysModal extends Model
{
    use HasFactory;
    protected $table = 'non_working_days';
    protected $fillable = [
        'id',
        'project_id',
        'non_working_days',
        'instance_id',
        'created_by',
        'status'
    ];
}
