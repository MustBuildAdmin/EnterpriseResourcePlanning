<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProposalProduct extends Model
{
    protected $fillable = [
        'product_id',
        'proposal_id',
        'quantity',
        'tax',
        'discount',
        'total',
    ];

    public function product()
    {
        return $this->hasOne('App\Models\ProductService', 'id', 'product_id');
    }
}
