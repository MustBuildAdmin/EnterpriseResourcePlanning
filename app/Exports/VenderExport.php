<?php

namespace App\Exports;

use App\Models\Vender;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VenderExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = Vender::get();

        foreach($data as $k => $vendor)
        {
            unset($vendor->password, $vendor->lang, $vendor->created_by, $vendor->email_verified_at, $vendor->remember_token);
            $data[$k]["vender_id"]        = \Auth::user()->venderNumberFormat($vendor->vender_id);
            $data[$k]["balance"]          = \Auth::user()->priceFormat($vendor->balance);
//            $data[$k]["location"]         = Vender::$country_array[$vendor->location];
//            $data[$k]["company_location"] = Vender::$country_array[$vendor->company_location];
            $data[$k]["avatar"]           = !empty($vendor->avatar) ? asset(\Storage::url('uploads/avatar')) . '/' . $vendor->avatar : '-';
//            $data[$k]["trade_license"]    = !empty($vendor->trade_license) ? asset(\Storage::url('uploads/product')) . '/' . $vendor->trade_license : '-';
//            $data[$k]["vat_license"]      = !empty($vendor->vat_license) ? asset(\Storage::url('uploads/product')) . '/' . $vendor->vat_license : '-';
//            $data[$k]["catalog"]          = !empty($vendor->catalog) ? asset(\Storage::url('uploads/product')) . '/' . $vendor->catalog : '-';
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            "ID",
            "Vendor ID",
            "Name",
            "Email",
            "Contact",
            "Avatar",
            "Billing Name",
            "Billing Country",
            "Billing State",
            "Billing City",
            "Billing Phone",
            "Billing Zip",
            "Billing Address",
            "Shipping Name",
            "Shipping Country",
            "Shipping State",
            "Shipping City",
            "Shipping Phone",
            "Shipping Zip",
            "Shipping Address",
            "Lang",
            "Balance",
            "Created At",
            "Updated At",
        ];
    }
}
