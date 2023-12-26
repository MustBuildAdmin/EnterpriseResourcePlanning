<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RFIPriority extends Model
{
    public $table = 'rfi_priority';

    protected $fillable = [
        'priority_type'
    ];
}
