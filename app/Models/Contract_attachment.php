<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract_attachment extends Model
{
    protected $table = 'contract_attachment';

    protected $fillable = [
        'contract_id',
        'user_id',
        'files',
        'reated_by',
    ];
}
