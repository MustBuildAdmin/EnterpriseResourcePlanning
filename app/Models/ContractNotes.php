<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractNotes extends Model
{
    protected $table = 'contract_notes';

    protected $fillable = [
        'contract_id',
        'user_id',
        'notes',
        'created_by',
    ];
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }
}
