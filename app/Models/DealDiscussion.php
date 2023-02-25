<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DealDiscussion extends Model
{
    protected $fillable = [
        'deal_id',
        'comment',
        'created_by',
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }
}
