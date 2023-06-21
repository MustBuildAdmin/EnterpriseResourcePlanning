<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProductServiceCategory extends Model
{
    protected $fillable = [
        'name',
        'type',
        'created_by',
    ];

    public static $categoryType = [
        'Product & Service',
        'Income',
        'Expense',
    ];

    public function categories()
    {
        return $this->hasMany('App\Models\Revenue', 'category_id', 'id');
    }

    public function incomeCategoryRevenueAmount()
    {
        $year    = date('Y');
        $revenue = $this->hasMany('App\Models\Revenue', 'category_id', 'id')->where('created_by', \Auth::user()->creatorId())->whereRAW('YEAR(date) =?', [$year])->sum('amount');

        $invoices     = $this->hasMany('App\Models\Invoice', 'category_id', 'id')->where('created_by', \Auth::user()->creatorId())->whereRAW('YEAR(send_date) =?', [$year])->get();
        $invoiceArray = array();
        foreach($invoices as $invoice)
        {
            $invoiceArray[] = $invoice->getTotal();
        }
        $totalIncome = (!empty($revenue) ? $revenue : 0) + (!empty($invoiceArray) ? array_sum($invoiceArray) : 0);

        return $totalIncome;

    }

    public function expenseCategoryAmount()
    {
        $year    = date('Y');
        $payment = $this->hasMany('App\Models\Payment', 'category_id', 'id')->where('created_by', \Auth::user()->creatorId())->whereRAW('YEAR(date) =?', [$year])->sum('amount');

        $bills     = $this->hasMany('App\Models\Bill', 'category_id', 'id')->where('created_by', \Auth::user()->creatorId())->whereRAW('YEAR(send_date) =?', [$year])->get();
        $billArray = array();
        foreach($bills as $bill)
        {
            $billArray[] = $bill->getTotal();
        }

        $totalExpense = (!empty($payment) ? $payment : 0) + (!empty($billArray) ? array_sum($billArray) : 0);

        return $totalExpense;

    }
    public static function getallCategories()
    {

        $cat = ProductServiceCategory::select('product_service_categories.*', \DB::raw("COUNT(pu.category_id) product_services"))
            ->leftjoin('product_services as pu','product_service_categories.id' ,'=','pu.category_id')
            ->where('product_service_categories.created_by', '=', Auth::user()->creatorId())
            ->where('product_service_categories.type', 0)
            ->orderBy('product_service_categories.id', 'DESC')->groupBy('product_service_categories.id')->get();

        return $cat;
    }
}
