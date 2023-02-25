<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ClientDeal extends Model
{
    protected $fillable = [
        'client_id', 'deal_id'
    ];
}
