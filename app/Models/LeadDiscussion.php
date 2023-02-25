<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadDiscussion extends Model
{
    protected $fillable = [
        'lead_id',
        'comment',
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }
}
