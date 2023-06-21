<?php

namespace App\Exports;

use App\Models\ProductService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductServiceExport implements FromCollection, WithHeadings
{

    public function collection()
    {
        $data = ProductService::select('product_services.id', 'product_services.name as item',  'sku', 'sale_price', 'purchase_price', 'tax_id as tax', 'product_service_categories.name as category', 'product_service_units.name as unit', 'product_services.type', 'description');
//        $data->leftjoin('venders', 'product_services.assign_vendor', '=', 'venders.id');
        $data->leftjoin('product_service_categories', 'product_services.category_id', '=', 'product_service_categories.id');
        $data->leftjoin('product_service_units', 'product_services.unit_id', '=', 'product_service_units.id');
        $data = $data->get();
        foreach($data as $k => $item)
        {
            $taxes                      = ProductService::taxData($item->tax);
            $data[$k]["sale_price"]     = \Auth::user()->priceFormat($item->sale_price);
            $data[$k]["purchase_price"] = \Auth::user()->priceFormat($item->purchase_price);
            $data[$k]["tax"]            = $taxes;
//            $data[$k]["stock_status"]   = ProductService::$stockStatus[$item->stock_status];
//            $data[$k]["image"]          = asset(\Storage::url('uploads/product')) . '/' . $item->image;
        }


        return $data;
    }

    public function headings(): array
    {
        return [
            "ID",
            "Name",
            "SKU",
            "sale_price",
            "purchase_price",
            "Tax",
            "Category",
            "Unit",
            "Type",
            "Description",
        ];
    }
}
