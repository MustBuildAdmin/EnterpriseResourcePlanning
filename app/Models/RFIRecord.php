<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RFIRecord extends Model
{
    public $table = 'rfi_record';

    protected $fillable = [
        'project_id',
        'responding_party_type',
        'rfi_dependency',
        'time_impact',
        'cost_impact',
        'submission_date',
        'rfi_priority'
    ];
}