<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLead extends Model
{
    protected $fillable = [
        'user_id',
        'lead_id',
    ];

    public function getLeadUser()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
