<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDeal extends Model
{
    protected $fillable = [
        'user_id',
        'deal_id',
    ];

    public function getDealUser()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
