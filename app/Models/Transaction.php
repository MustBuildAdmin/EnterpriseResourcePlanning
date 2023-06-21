<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'account',
        'type',
        'amount',
        'description',
        'date',
        'created_by',
        'customer_id',
        'payment_id',
    ];


    public function bankAccount()
    {
        return $this->hasOne('App\Models\BankAccount', 'id', 'account')->first();
    }


    public static function addTransaction($request)
    {

        $transaction              = new Transaction();
        $transaction->account     = $request->account;
        $transaction->user_id     = $request->user_id;
        $transaction->user_type   = $request->user_type;
        $transaction->type        = $request->type;
        $transaction->amount      = $request->amount;
        $transaction->description = $request->description;
        $transaction->date        = $request->date;
        $transaction->created_by  = $request->created_by;
        $transaction->payment_id  = $request->payment_id;
        $transaction->category    = $request->category;
        $transaction->save();
    }

    public static function editTransaction($request)
    {
        $transaction              = Transaction::where('payment_id', $request->payment_id)->where('type', $request->type)->first();
        $transaction->account     = $request->account;
        $transaction->amount      = $request->amount;
        $transaction->description = $request->description;
        $transaction->date        = $request->date;
        $transaction->category    = $request->category;
        $transaction->save();
    }

    public static function destroyTransaction($id, $type, $user)
    {

        Transaction::where('payment_id', $id)->where('type', $type)->where('user_type', $user)->delete();
    }

    public function payment()
    {
        return $this->hasOne('App\Models\InvoicePayment', 'id', 'payment_id');
    }

    public function billPayment()
    {
        return $this->hasOne('App\Models\BillPayment', 'id', 'payment_id');
    }
}
