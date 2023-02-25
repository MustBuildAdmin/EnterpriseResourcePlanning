<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractComment extends Model
{
    protected $table = 'contract_comment';

    protected $fillable = [
        'contract_id',
        'user_id',
        'comment',
        'created_by',
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }
}
