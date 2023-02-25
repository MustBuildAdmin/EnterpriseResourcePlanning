<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'vender_id',
        'currency',
        'bill_date',
        'due_date',
        'bill_id',
        'order_number',
        'category_id',
        'created_by',
    ];

    public static $statues = [
        'Draft',
        'Sent',
        'Unpaid',
        'Partialy Paid',
        'Paid',
    ];

    public function vender()
    {
        return $this->hasOne('App\Models\Vender', 'id', 'vender_id');
    }

    public function tax()
    {
        return $this->hasOne('App\Models\Tax', 'id', 'tax_id');
    }

    public function items()
    {
        return $this->hasMany('App\Models\BillProduct', 'bill_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\BillPayment', 'bill_id', 'id');
    }
    

    public function getSubTotal()
    {
        $subTotal = 0;
        foreach($this->items as $product)
        {
            $subTotal += ($product->price * $product->quantity);
        }

        return $subTotal;
    }

    public function getTotalTax()
    {
        $totalTax = 0;
        foreach($this->items as $product)
        {
            $taxes = Utility::totalTaxRate($product->tax);

            $totalTax += ($taxes / 100) * ($product->price * $product->quantity);

        }

        return $totalTax;
    }

    public function getTotalDiscount()
    {
        $totalDiscount = 0;
        foreach($this->items as $product)
        {
            $totalDiscount += $product->discount;
        }

        return $totalDiscount;
    }

    public function getTotal()
    {
        return ($this->getSubTotal() + $this->getTotalTax()) - $this->getTotalDiscount();
    }

    public function getDue()
    {
        $due = 0;
        foreach($this->payments as $payment)
        {
            $due += $payment->amount;
        }

        return ($this->getTotal() - $due) - ($this->billTotalDebitNote());
    }

    public function category()
    {
        return $this->hasOne('App\Models\ProductServiceCategory', 'id', 'category_id');
    }

    public function debitNote()
    {
        return $this->hasMany('App\Models\DebitNote', 'bill', 'id');
    }

    public function billTotalDebitNote()
    {
        return $this->hasMany('App\Models\DebitNote', 'bill', 'id')->sum('amount');
    }

    public function lastPayments()
    {
        return $this->hasOne('App\Models\BillPayment', 'id', 'bill_id');
    }
    
    public function taxes()
    {
        return $this->hasOne('App\Models\Tax', 'id', 'tax');
    }
}
