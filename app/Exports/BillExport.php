<?php

namespace App\Exports;

use App\Models\Bill;
use App\Models\ProductServiceCategory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BillExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = Bill::get();

        foreach($data as $k => $bill)
        {
            unset( $bill->created_by, $bill->shipping_display,$bill->discount_apply);
            $data[$k]["bill_id"] = \Auth::user()->invoiceNumberFormat($bill->bill_id);
            $data[$k]["vender_id"] = \Auth::user()->customerNumberFormat($bill->vender_id);
            $data[$k]['category_id'] = ProductServiceCategory::where('type', 2)->first()->name;
            $data[$k]["status"]       = Bill::$statues[$bill->status];

        }

        return $data;
    }

    public function headings(): array
    {
        return [
            "ID",
            "Bill No",
            "Vender NO",
            "Bill Date",
            "Due Date",
            "Order No",
            "Status",
            "Send Date",
            "Category",
            "created_at",
            "updated_at",

        ];
    }
}
