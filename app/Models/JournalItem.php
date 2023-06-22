<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalItem extends Model
{
    protected $fillable = [
        'journal',
        'account',
        'debit',
        'credit',
    ];

    public function accounts()
    {
        return $this->hasOne('App\Models\ChartOfAccount', 'id', 'account');
    }


}
