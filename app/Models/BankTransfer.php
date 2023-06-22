<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankTransfer extends Model
{
    protected $fillable = [
        'from_account',
        'to_account',
        'amount',
        'date',
        'payment_method',
        'reference',
        'description',
        'created_by',
    ];

    public function fromBankAccount()
    {
        return $this->hasOne('App\Models\BankAccount', 'id', 'from_account')->first();
    }

    public function toBankAccount()
    {
        return $this->hasOne('App\Models\BankAccount', 'id', 'to_account')->first();
    }

}
