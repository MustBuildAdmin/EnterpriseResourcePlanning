<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductService extends Model
{
    protected $fillable = [
        'name',
        'sku',
        'sale_price',
        'purchase_price',
        'tax_id',
        'category_id',
        'unit_id',
        'type',
        'created_by',
    ];

    public function taxes()
    {
        return $this->hasOne('App\Models\Tax', 'id', 'tax_id')->first();
    }

    public function unit()
    {
        return $this->hasOne('App\Models\ProductServiceUnit', 'id', 'unit_id')->first();
    }

    public function category()
    {
        return $this->hasOne('App\Models\ProductServiceCategory', 'id', 'category_id');
    }

    public function tax($taxes)
    {
        $taxArr = explode(',', $taxes);

        $taxes = [];
        foreach ($taxArr as $tax) {
            $taxes[] = Tax::find($tax);
        }

        return $taxes;
    }

    public function taxRate($taxes)
    {
        $taxArr = explode(',', $taxes);
        $taxRate = 0;
        foreach ($taxArr as $tax) {
            $tax = Tax::find($tax);
            $taxRate += $tax->rate;
        }

        return $taxRate;
    }

    public static function taxData($taxes)
    {
        $taxArr = explode(',', $taxes);

        $taxes = [];
        foreach ($taxArr as $tax) {
            $taxesData = Tax::find($tax);
            $taxes[] = ! empty($taxesData) ? $taxesData->name : '';
        }

        return implode(',', $taxes);
    }

    public static function getallproducts()
    {

        return ProductService::select('product_services.*', 'c.name as categoryname')
            ->leftjoin('product_service_categories as c', 'c.id', '=', 'product_services.category_id')
            ->where('product_services.created_by', '=', Auth::user()->creatorId())
            ->orderBy('product_services.id', 'DESC');
    }

    public function getTotalProductQuantity()
    {
        $totalquantity = $purchasedquantity = $posquantity = 0;
        $authuser = Auth::user();
        $product_id = $this->id;
        $purchases = Purchase::where('created_by', $authuser->creatorId());

        if ($authuser->isUser()) {
            $purchases = $purchases->where('warehouse_id', $authuser->warehouse_id);
        }

        foreach ($purchases->get() as $purchase) {
            $purchaseditem = PurchaseProduct::select('quantity')->where('purchase_id', $purchase->id)->where('product_id', $product_id)->first();
            $purchasedquantity += $purchaseditem != null ? $purchaseditem->quantity : 0;
            //            dd($purchasedquantity);
        }

        $poses = Pos::where('created_by', $authuser->creatorId());
        //        dd($poses);

        if ($authuser->isUser()) {
            $pos = $poses->where('warehouse_id', $authuser->warehouse_id);
            //            dd($pos);
        }

        foreach ($poses->get() as $pos) {
            $positem = PosProduct::select('quantity')->where('pos_id', $pos->id)->where('product_id', $product_id)->first();
            $posquantity += $positem != null ? $positem->quantity : 0;
        }

        $totalquantity = $purchasedquantity - $posquantity;

        return $totalquantity;
    }

    public static function tax_id($product_id)
    {
        $results = DB::select(
            DB::raw("SELECT IFNULL( (SELECT tax_id from product_services where id = :id and created_by = :created_by limit 1),  '0') as tax_id"), ['id' => $product_id,  'created_by' => Auth::user()->creatorId()]
        );

        return $results[0]->tax_id;

    }
}
