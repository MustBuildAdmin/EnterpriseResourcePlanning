<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseProduct extends Model
{
    protected $fillable = [
        'warehouse_id',
        'product_id',
        'quantity',
        'created_by',
    ];


    public function product()
    {
        return $this->hasOne('App\Models\ProductService', 'id', 'product_id')->first();
    }
    public function warehouse()
    {
        return $this->hasOne('App\Models\warehouse', 'id', 'warehouse_id')->first();
    }

}
