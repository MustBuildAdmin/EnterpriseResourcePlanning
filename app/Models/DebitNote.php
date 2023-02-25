<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DebitNote extends Model
{
    protected $fillable = [
        'bill',
        'vendor',
        'amount',
        'date',
    ];

    public function vendor()
    {
        return $this->hasOne('App\Models\Vender', 'vender_id', 'vendor');
    }
}
