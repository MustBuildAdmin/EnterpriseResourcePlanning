<?php

namespace App\Exports;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\ProductServiceCategory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvoiceExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = Invoice::get();

        foreach($data as $k => $invoice)
        {
            unset( $invoice->created_by, $invoice->shipping_display,$invoice->discount_apply);
            $data[$k]["invoice_id"] = \Auth::user()->invoiceNumberFormat($invoice->invoice_id);
            $data[$k]["customer_id"] = \Auth::user()->customerNumberFormat($invoice->customer_id);
            $data[$k]['category_id'] = ProductServiceCategory::where('type', 2)->first()->name;
            $data[$k]["status"]       = Invoice::$statues[$invoice->status];

        }

        return $data;
    }

    public function headings(): array
    {
        return [
            "ID",
            "Invoice Id",
            "Customer No",
            "Issue Date",
            "Due Date",
            "Send Date",
            "Category",
            "Ref Number",
            "Status",
            "created_at",
            "updated_at",

        ];
    }
}
