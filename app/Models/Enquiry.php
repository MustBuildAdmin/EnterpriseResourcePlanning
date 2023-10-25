<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $table = 'enquiries';

    protected $fillable = [
        'id',
        'name',
        'email',
        'subject',
        'message',
        'status',
        'created_at',
        'updated_at',
    ];

}
