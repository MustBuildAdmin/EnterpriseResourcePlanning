<?php

namespace App\Models;

use App\Mail\CommonEmailTemplate;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Twilio\Rest\Client;

use Exception;

class Utility extends Model
{
    public static function settings()
    {
        $data = DB::table('settings');
        if(\Auth::check())
        {
            $data=$data->where('created_by','=',\Auth::user()->creatorId())->get();
            if(count($data)==0){
                $data =DB::table('settings')->where('created_by', '=', 1 )->get();
            }
        }
        else
        {
            $data->where('created_by', '=', 1);
            $data = $data->get();
        }



        $settings = [
            'indiangst'=>'0',
            "site_currency" => "USD",
            "site_currency_symbol" => "$",
            "timezone"=>"Asia/Kolkata",
            "site_currency_symbol_position" => "pre",
            "site_date_format" => "M j, Y",
            "site_time_format" => "g:i A",
            "company_name" => "",
            "company_address" => "",
            "company_city" => "",
            "company_state" => "",
            "company_zipcode" => "",
            "company_country" => "",
            "company_telephone" => "",
            "company_email" => "",
            "company_email_from_name" => "",
            "invoice_prefix" => "#INVO",
            "journal_prefix" => "#JUR",
            "invoice_color" => "ffffff",
            "proposal_prefix" => "#PROP",
            "employee_prefix"=>"#EMP",
            "proposal_color" => "ffffff",
            "bill_prefix" => "#BILL",
            "bill_color" => "ffffff",
            "customer_prefix" => "#CUST",
            "vender_prefix" => "#VEND",
            "footer_title" => "",
            "footer_notes" => "",
            "invoice_template" => "template1",
            "bill_template" => "template1",
            "proposal_template" => "template1",
            "registration_number" => "",
            "vat_number" => "",
            "default_language" => "en",
            'employee_create' => '1',
            'payment_reminder' =>'1',
            "enable_stripe" => "",
            "enable_paypal" => "",
            "paypal_mode" => "",
            "paypal_client_id" => "",
            "paypal_secret_key" => "",
            "stripe_key" => "",
            "stripe_secret" => "",
            "decimal_number" => "2",
            "tax_type" => "",
            "shipping_display" => "on",
            "journal_prefix" => "#JUR",
            "display_landing_page" => "on",
            "employee_prefix" => "#EMP00",
            'create_user' => '1',
            'award_create' => '1',
            'lead_assign' => '1',
            'deal_assign' =>'1',
            'proposal_send' =>'1',
            'customer_invoice_send' =>'1',
            'bill_payment' =>'1',
            'invoice_payment' =>'1',
            'bill_resend' =>'1',
            'employee_resignation' => '1',
            'resignation_send' => '1',
            'employee_trip' => '1',
            'trip_send' => '1',
            'employee_promotion' => '1',
            'promotion_send' =>'1',
            'employee_complaints' => '1',
            'employee_warning' => '1',
            'warning_send' =>'1',
            'create_contract' =>'1',
            'employee_termination' => '1',
            'termination_send' =>'1',
            'leave_status' => '1',
            'employee_transfer' => '1',
            'transfer_send' =>'1',
            "bug_prefix" => "#ISSUE",
            'payroll_create' => '1',
            'payslip_send' => '1',
            'title_text' => '',
            'footer_text' => '',
            "company_start_time" => "09:00",
            "company_end_time" => "18:00",
            'gdpr_cookie' => 'off',
            "interval_time" => "",
            "zoom_apikey" =>"",
            "zoom_apisecret" => "",
            "slack_webhook" =>"",
            "telegram_accestoken" => "",
            "telegram_chatid" =>"",
            "enable_signup" => "on",
            "company_type"=>"",
            'cookie_text' => 'We use cookies to ensure that we give you the best experience on our website. If you continue to use this site we will assume that you are happy with it.
',
            "company_logo_light" => "logo-light.png",
            "company_logo_dark" =>  "logo-dark.png",
            "company_favicon" => "favicon.png",
            "cust_theme_bg" => "on",
            "cust_darklayout" => "off",
            "color" => "",
            "SITE_RTL" => "off",
            "purchase_prefix" => "#PUR",
            "purchase_color" => "ffffff",
            "purchase_template" => "template1",
            "pos_prefix" => "#POS",

            "storage_setting" => "local",
            "local_storage_validation" => ".jpg,.jpeg,.png,.xlsx,.xls,.csv,.pdf,.docx",
            "local_storage_max_upload_size" => "2048000",
            "s3_key" => "",
            "s3_secret" => "",
            "s3_region" => "",
            "s3_bucket" => "",
            "s3_url"    => "",
            "s3_endpoint" => "",
            "s3_max_upload_size" => "",
            "s3_storage_validation" => "",
            "wasabi_key" => "",
            "wasabi_secret" => "",
            "wasabi_region" => "",
            "wasabi_bucket" => "",
            "wasabi_url" => "",
            "wasabi_root" => "",
            "wasabi_max_upload_size" => "",
            "wasabi_storage_validation" => "",

            "purchase_logo" =>"",
            "proposal_logo" =>"",
            "invoice_logo" =>"",
            "contract_prefix" => "#CON",



        ];

        foreach($data as $row)
        {
            $settings[$row->name] = $row->value;
        }

        return $settings;
    }



    public static function settingsById($user_id)
    {

        $data =DB::table('settings')->where('created_by', '=', $user_id )->get();

        $settings = [
            "site_currency" => "USD",
            'indiangst'=>'0',
            "site_currency_symbol" => "$",
            "timezone"=>"Asia/Calcutta",
            "site_currency_symbol_position" => "pre",
            "site_date_format" => "M j, Y",
            "site_time_format" => "g:i A",
            "company_name" => "",
            "company_address" => "",
            "company_city" => "",
            "company_state" => "",
            "company_zipcode" => "",
            "company_country" => "",
            "company_telephone" => "",
            "company_email" => "",
            "company_email_from_name" => "",
            "invoice_prefix" => "#INVO",
            "journal_prefix" => "#JUR",
            "invoice_color" => "ffffff",
            "proposal_prefix" => "#PROP",
            "proposal_color" => "ffffff",
            "bill_prefix" => "#BILL",
            "bill_color" => "ffffff",
            "customer_prefix" => "#CUST",
            "vender_prefix" => "#VEND",
            "footer_title" => "",
            "footer_notes" => "",
            "invoice_template" => "template1",
            "bill_template" => "template1",
            "proposal_template" => "template1",
            "registration_number" => "",
            "vat_number" => "",
            "default_language" => "en",
            'employee_create' => '1',
            "enable_stripe" => "",
            "enable_paypal" => "",
            "paypal_mode" => "",
            "paypal_client_id" => "",
            "paypal_secret_key" => "",
            "stripe_key" => "",
            "stripe_secret" => "",
            "decimal_number" => "2",
            "tax_type" => "",
            "shipping_display" => "on",
            "journal_prefix" => "#JUR",
            "display_landing_page" => "on",
            "employee_prefix" => "#EMP00",
            'award_create' => '1',
            'lead_assign' => '1',
            'deal_assign' =>'1',
            'proposal_send' =>'1',
            'payment_reminder' =>'1',
            'customer_invoice_send' => '1',
            'bill_payment' =>'1',
            'invoice_payment' =>'1',
            'bill_resend' =>'1',
            'employee_resignation' => '1',
            'resignation_send' => '1',
            'employee_trip' => '1',
            'trip_send' => '1',
            'employee_promotion' => '1',
            'promotion_send' =>'1',
            'employee_complaints' => '1',
            'employee_warning' => '1',
            'warning_send' =>'1',
            'create_contract' =>'1',
            'employee_termination' => '1',
            'termination_send' =>'1',
            'leave_status' => '1',
            'employee_transfer' => '1',
            'transfer_send' =>'1',
            "bug_prefix" => "#ISSUE",
            'payroll_create' => '1',
            'payslip_send' => '1',
            'title_text' => '',
            'footer_text' => '',
            "company_start_time" => "09:00",
            "company_end_time" => "18:00",
            'gdpr_cookie' => 'off',
            "interval_time" => "",
            "zoom_apikey" =>"",
            "zoom_apisecret" => "",
            "slack_webhook" =>"",
            "telegram_accestoken" => "",
            "telegram_chatid" =>"",
            "enable_signup" => "on",
            'cookie_text' => 'We use cookies to ensure that we give you the best experience on our website. If you continue to use this site we will assume that you are happy with it.
',
            "company_logo_light" => "logo-light.png",
            "company_logo_dark" =>  "logo-dark.png",
            "company_favicon" => "favicon.png",
            "cust_theme_bg" => "on",
            "cust_darklayout" => "off",
            "color" => "",
            "SITE_RTL" => "off",
            "purchase_prefix" => "#PUR",
            "purchase_color" => "ffffff",
            "purchase_template" => "template1",
            "proposal_logo" =>"",
            "purchase_logo" =>"",
            'bill_logo'=>'',
            'invoice_logo'=>'',
            "storage_setting" => "local",
            "local_storage_validation" => ".jpg,.jpeg,.png,.xlsx,.xls,.csv,.pdf,.docx",
            "local_storage_max_upload_size" => "2048000",
            "s3_key" => "",
            "s3_secret" => "",
            "s3_region" => "",
            "s3_bucket" => "",
            "s3_url"    => "",
            "s3_endpoint" => "",
            "s3_max_upload_size" => "",
            "s3_storage_validation" => "",
            "wasabi_key" => "",
            "wasabi_secret" => "",
            "wasabi_region" => "",
            "wasabi_bucket" => "",
            "wasabi_url" => "",
            "wasabi_root" => "",
            "wasabi_max_upload_size" => "",
            "wasabi_storage_validation" => "",

        ];

        foreach($data as $row)
        {
            $settings[$row->name] = $row->value;
        }

        return $settings;
    }

    public static $emailStatus = [
        'create_user' => 'Create User',
        'create_client' =>'Create Client',
        'create_support' =>'Create Support',
        'lead_assign' =>'Lead Assign',
        'deal_assign' =>'Deal Assign',
        'award_send' => 'Award Send',
        'customer_invoice_send' => 'Customer Invoice Send',
        'invoice_payment' => 'Invoice Payment',
        'payment_reminder' => 'Payment Reminder',
        'bill_payment' => 'Bill Payment',
        'bill_resend' => 'Bill Resend',
        'proposal_send' =>'Proposal Send',
        'complaint_resend' => 'Complaint Resend',
        'leave_action_send' => 'Leave Action Send',
        'payslip_send' => 'Payslip Send',
        'promotion_send' => 'Promotion Send',
        'resignation_send' => 'Resignation Send',
        'termination_send' => 'Employee Termination',
        'transfer_send' => 'Transfer Send',
        'trip_send' => 'Trip Send',
        'vender_bill_send' => 'Vendor Bill Send',
        'warning_send' => 'Warning Send',
        'create_contract' => 'Create Contract',
    ];

    public static function languages()
    {
        $dir     = base_path() . '/resources/lang/';
        $glob    = glob($dir . "*", GLOB_ONLYDIR);
        $arrLang = array_map(
            function ($value) use ($dir){
                return str_replace($dir, '', $value);
            }, $glob
        );
        $arrLang = array_map(
            function ($value) use ($dir){
                return preg_replace('/[0-9]+/', '', $value);
            }, $arrLang
        );
        $arrLang = array_filter($arrLang);

        return $arrLang;
    }

    public static function getValByName($key)
    {
        $setting = Utility::settings();
        if(!isset($setting[$key]) || empty($setting[$key]))
        {
            $setting[$key] = '';
        }

        return $setting[$key];
    }

    public static function setEnvironmentValue(array $values)
    {
        $envFile = app()->environmentFilePath();
        $str     = file_get_contents($envFile);
        if(count($values) > 0)
        {
            foreach($values as $envKey => $envValue)
            {
                $keyPosition       = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine           = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                // If key does not exist, add it
                if(!$keyPosition || !$endOfLinePosition || !$oldLine)
                {
                    $str .= "{$envKey}='{$envValue}'\n";
                }
                else
                {
                    $str = str_replace($oldLine, "{$envKey}='{$envValue}'", $str);
                }
            }
        }
        $str = substr($str, 0, -1);
        $str .= "\n";
        if(!file_put_contents($envFile, $str))
        {
            return false;
        }

        return true;
    }

    public static function statecode()
    {
        $arr=array(
            'AN'=>35,
            'AP'=>28,
            'AD'=>37,
            'AR'=>12,
            'AS'=>18,
            'BH'=>10,
            'CH'=>04,
            'CT'=>22,
            'DN'=>26,
            'DD'=>25,
            'DL'=>07,
            'GA'=>30,
            'GJ'=>24,
            'HR'=>06,
            'HP'=>02,
            'JK'=>01,
            'JH'=>20,
            'KA'=>29,
            'KL'=>32,
            'LD'=>31,
            'MP'=>23,
            'MH'=>27,
            'MN'=>14,
            'ME'=>17,
            'MI'=>15,
            'NL'=>13,
            'OR'=>21,
            'PY'=>34,
            'PB'=>03,
            'RJ'=>"08",
            'SK'=>11,
            'TN'=>33,
            'TS'=>36,
            'TR'=>16,
            'UP'=>"09",
            'UT'=>05,
            'WB'=>19
        );
        return $arr;
    }
    public static function union_state()
    {
        $arr=array(
            'CH','LD','DN','AN','LA','JK'
        );
        return $arr;
    }

    public static function templateData()
    {
        $arr              = [];
        $arr['colors']    = [
            '003580',
            '666666',
            '6676ef',
            'f50102',
            'f9b034',
            'fbdd03',
            'c1d82f',
            '37a4e4',
            '8a7966',
            '6a737b',
            '050f2c',
            '0e3666',
            '3baeff',
            '3368e6',
            'b84592',
            'f64f81',
            'f66c5f',
            'fac168',
            '46de98',
            '40c7d0',
            'be0028',
            '2f9f45',
            '371676',
            '52325d',
            '511378',
            '0f3866',
            '48c0b6',
            '297cc0',
            'ffffff',
            '000',
        ];
        $arr['templates'] = [
            "template1" => "New York",
            "template2" => "Toronto",
            "template3" => "Rio",
            "template4" => "London",
            "template5" => "Istanbul",
            "template6" => "Mumbai",
            "template7" => "Hong Kong",
            "template8" => "Tokyo",
            "template9" => "Sydney",
            "template10" => "Paris",
            "template11" => "India",
        ];

        return $arr;
    }

    public static function priceFormat($settings, $price)
    {
        return (($settings['site_currency_symbol_position'] == "pre") ? $settings['site_currency_symbol'] : '') . number_format($price, Utility::getValByName('decimal_number')) . (($settings['site_currency_symbol_position'] == "post") ? $settings['site_currency_symbol'] : '');
    }

    public static function currencySymbol($settings)
    {
        return $settings['site_currency_symbol'];
    }

    public static function dateFormat($settings, $date)
    {
        return date($settings['site_date_format'], strtotime($date));
    }

    public static function timeFormat($settings, $time)
    {
        return date($settings['site_time_format'], strtotime($time));
    }
    public static function purchaseNumberFormat($number)
    {
        $settings = Utility::settings();

        return $settings["purchase_prefix"] . sprintf("%05d", $number);
    }
    public function posNumberFormat($number)
    {
        $settings = Utility::settings();

        return $settings["pos_prefix"] . sprintf("%05d", $number);
    }

    public static function contractNumberFormat($number)
    {

        $settings = self::settings();
        return $settings["contract_prefix"] . sprintf("%05d", $number);
    }


    public static function invoiceNumberFormat($settings, $number)
    {

        return $settings["invoice_prefix"] . sprintf("%05d", $number);
    }

    public static function proposalNumberFormat($settings, $number)
    {
        return $settings["proposal_prefix"] . sprintf("%05d", $number);
    }

    public static function customerProposalNumberFormat($number)
    {
        $settings = Utility::settings();

        return $settings["proposal_prefix"] . sprintf("%05d", $number);
    }

    public static function customerInvoiceNumberFormat($number)
    {
        $settings = Utility::settings();

        return $settings["invoice_prefix"] . sprintf("%05d", $number);
    }

    public static function billNumberFormat($settings, $number)
    {
        return $settings["bill_prefix"] . sprintf("%05d", $number);
    }

    public static function vendorBillNumberFormat($number)
    {
        $settings = Utility::settings();

        return $settings["bill_prefix"] . sprintf("%05d", $number);
    }

    public static function tax($taxes)
    {

        $taxArr = explode(',', $taxes);
        $taxes  = [];
        foreach($taxArr as $tax)
        {
            $taxes[] = Tax::find($tax);
        }

        return $taxes;
    }

    public static function taxRate($taxRate, $price, $quantity)
    {

        return ($taxRate / 100) * ($price * $quantity);
    }

    public static function totalTaxRate($taxes)
    {

        $taxArr  = explode(',', $taxes);
        $taxRate = 0;

        foreach($taxArr as $tax)
        {

            $tax     = Tax::find($tax);
            $taxRate += !empty($tax->rate) ? $tax->rate : 0;
        }

        return $taxRate;
    }

    public static function userBalance($users, $id, $amount, $type)
    {
        if($users == 'customer')
        {
            $user = Customer::find($id);
        }
        else
        {
            $user = Vender::find($id);
        }

        if(!empty($user))
        {
            if($type == 'credit')
            {
                $oldBalance    = $user->balance;
                $user->balance = $oldBalance + $amount;
                $user->save();
            }
            elseif($type == 'debit')
            {
                $oldBalance    = $user->balance;
                $user->balance = $oldBalance - $amount;
                $user->save();
            }
        }
    }

    public static function bankAccountBalance($id, $amount, $type)
    {
        $bankAccount = BankAccount::find($id);
        if($bankAccount)
        {
            if($type == 'credit')
            {
                $oldBalance                   = $bankAccount->opening_balance;
                $bankAccount->opening_balance = $oldBalance + $amount;
                $bankAccount->save();
            }
            elseif($type == 'debit')
            {
                $oldBalance                   = $bankAccount->opening_balance;
                $bankAccount->opening_balance = $oldBalance - $amount;
                $bankAccount->save();
            }
        }

    }

    // get font-color code accourding to bg-color
    public static function hex2rgb($hex)
    {
        $hex = str_replace("#", "", $hex);

        if(strlen($hex) == 3)
        {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        }
        else
        {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $rgb = array(
            $r,
            $g,
            $b,
        );

        return $rgb; // returns an array with the rgb values
    }

    public static function getFontColor($color_code)
    {
        $rgb = self::hex2rgb($color_code);
        $R   = $G = $B = $C = $L = $color = '';

        $R = (floor($rgb[0]));
        $G = (floor($rgb[1]));
        $B = (floor($rgb[2]));

        $C = [
            $R / 255,
            $G / 255,
            $B / 255,
        ];

        for($i = 0; $i < count($C); ++$i)
        {
            if($C[$i] <= 0.03928)
            {
                $C[$i] = $C[$i] / 12.92;
            }
            else
            {
                $C[$i] = pow(($C[$i] + 0.055) / 1.055, 2.4);
            }
        }

        $L = 0.2126 * $C[0] + 0.7152 * $C[1] + 0.0722 * $C[2];

        if($L > 0.179)
        {
            $color = 'black';
        }
        else
        {
            $color = 'white';
        }

        return $color;
    }

    public static function delete_directory($dir)
    {
        if(!file_exists($dir))
        {
            return true;
        }
        if(!is_dir($dir))
        {
            return unlink($dir);
        }
        foreach(scandir($dir) as $item)
        {
            if($item == '.' || $item == '..')
            {
                continue;
            }
            if(!self::delete_directory($dir . DIRECTORY_SEPARATOR . $item))
            {
                return false;
            }
        }

        return rmdir($dir);
    }

    public static $chartOfAccountType = [
        'assets' => 'Assets',
        'liabilities' => 'Liabilities',
        'expenses' => 'Expenses',
        'income' => 'Income',
        'equity' => 'Equity',
    ];


    public static $chartOfAccountSubType = array(
        "assets" => array(
            '1' => 'Current Asset',
            '2' => 'Fixed Asset',
            '3' => 'Inventory',
            '4' => 'Non-current Asset',
            '5' => 'Prepayment',
            '6' => 'Bank & Cash',
            '7' => 'Depreciation',
        ),
        "liabilities" => array(
            '1' => 'Current Liability',
            '2' => 'Liability',
            '3' => 'Non-current Liability',
        ),
        "expenses" => array(
            '1' => 'Direct Costs',
            '2' => 'Expense',
        ),
        "income" => array(
            '1' => 'Revenue',
            '2' => 'Sales',
            '3' => 'Other Income',
        ),
        "equity" => array(
            '1' => 'Equity',
        ),

    );

    public static function chartOfAccountTypeData($company_id)
    {
        $chartOfAccountTypes = Self::$chartOfAccountType;
        foreach($chartOfAccountTypes as $k => $type)
        {

            $accountType = ChartOfAccountType::create(
                [
                    'name' => $type,
                    'created_by' => $company_id,
                ]
            );

            $chartOfAccountSubTypes = Self::$chartOfAccountSubType;

            foreach($chartOfAccountSubTypes[$k] as $subType)
            {
                ChartOfAccountSubType::create(
                    [
                        'name' => $subType,
                        'type' => $accountType->id,
                    ]
                );
            }
        }
    }

    public static $chartOfAccount = array(

        [
            'code' => '120',
            'name' => 'Accounts Receivable',
            'type' => 1,
            'sub_type' => 1,
        ],
        [
            'code' => '160',
            'name' => 'Computer Equipment',
            'type' => 1,
            'sub_type' => 2,
        ],
        [
            'code' => '150',
            'name' => 'Office Equipment',
            'type' => 1,
            'sub_type' => 2,
        ],
        [
            'code' => '140',
            'name' => 'Inventory',
            'type' => 1,
            'sub_type' => 3,
        ],
        [
            'code' => '857',
            'name' => 'Budget - Finance Staff',
            'type' => 1,
            'sub_type' => 6,
        ],
        [
            'code' => '170',
            'name' => 'Accumulated Depreciation',
            'type' => 1,
            'sub_type' => 7,
        ],
        [
            'code' => '200',
            'name' => 'Accounts Payable',
            'type' => 2,
            'sub_type' => 8,
        ],
        [
            'code' => '205',
            'name' => 'Accruals',
            'type' => 2,
            'sub_type' => 8,
        ],
        [
            'code' => '150',
            'name' => 'Office Equipment',
            'type' => 2,
            'sub_type' => 8,
        ],
        [
            'code' => '855',
            'name' => 'Clearing Account',
            'type' => 2,
            'sub_type' => 8,
        ],
        [
            'code' => '235',
            'name' => 'Employee Benefits Payable',
            'type' => 2,
            'sub_type' => 8,
        ],
        [
            'code' => '236',
            'name' => 'Employee Deductions payable',
            'type' => 2,
            'sub_type' => 8,
        ],
        [
            'code' => '255',
            'name' => 'Historical Adjustments',
            'type' => 2,
            'sub_type' => 8,
        ],
        [
            'code' => '835',
            'name' => 'Revenue Received in Advance',
            'type' => 2,
            'sub_type' => 8,
        ],
        [
            'code' => '260',
            'name' => 'Rounding',
            'type' => 2,
            'sub_type' => 8,
        ],
        [
            'code' => '500',
            'name' => 'Costs of Goods Sold',
            'type' => 3,
            'sub_type' => 11,
        ],
        [
            'code' => '600',
            'name' => 'Advertising',
            'type' => 3,
            'sub_type' => 12,
        ],
        [
            'code' => '644',
            'name' => 'Automobile Expenses',
            'type' => 3,
            'sub_type' => 12,
        ],
        [
            'code' => '684',
            'name' => 'Bad Debts',
            'type' => 3,
            'sub_type' => 12,
        ],
        [
            'code' => '810',
            'name' => 'Bank Revaluations',
            'type' => 3,
            'sub_type' => 12,
        ],
        [
            'code' => '605',
            'name' => 'Bank Service Charges',
            'type' => 3,
            'sub_type' => 12,
        ],
        [
            'code' => '615',
            'name' => 'Consulting & Accounting',
            'type' => 3,
            'sub_type' => 12,
        ],
        [
            'code' => '700',
            'name' => 'Depreciation',
            'type' => 3,
            'sub_type' => 12,
        ],
        [
            'code' => '628',
            'name' => 'General Expenses',
            'type' => 3,
            'sub_type' => 12,
        ],
        [
            'code' => '460',
            'name' => 'Interest Income',
            'type' => 4,
            'sub_type' => 13,
        ],
        [
            'code' => '470',
            'name' => 'Other Revenue',
            'type' => 4,
            'sub_type' => 13,
        ],
        [
            'code' => '475',
            'name' => 'Purchase Discount',
            'type' => 4,
            'sub_type' => 13,
        ],
        [
            'code' => '400',
            'name' => 'Sales',
            'type' => 4,
            'sub_type' => 13,
        ],
        [
            'code' => '330',
            'name' => 'Common Stock',
            'type' => 5,
            'sub_type' => 16,
        ],
        [
            'code' => '300',
            'name' => 'Owners Contribution',
            'type' => 5,
            'sub_type' => 16,
        ],
        [
            'code' => '310',
            'name' => 'Owners Draw',
            'type' => 5,
            'sub_type' => 16,
        ],
        [
            'code' => '320',
            'name' => 'Retained Earnings',
            'type' => 5,
            'sub_type' => 16,
        ],
    );

    public static $chartOfAccount1 = array(

        [
            'code' => '120',
            'name' => 'Accounts Receivable',
            'type' => 'Assets',
            'sub_type' => 'Current Asset',
        ],
        [
            'code' => '160',
            'name' => 'Computer Equipment',
            'type' => 'Assets',
            'sub_type' => 'Fixed Asset',
        ],
        [
            'code' => '150',
            'name' => 'Office Equipment',
            'type' => 'Assets',
            'sub_type' => 'Fixed Asset',
        ],
        [
            'code' => '140',
            'name' => 'Inventory',
            'type' => 'Assets',
            'sub_type' => 'Inventory',
        ],
        [
            'code' => '857',
            'name' => 'Budget - Finance Staff',
            'type' => 'Assets',
            'sub_type' => 'Bank & Cash',
        ],
        [
            'code' => '170',
            'name' => 'Accumulated Depreciation',
            'type' => 'Assets',
            'sub_type' => 'Depreciation',
        ],
        [
            'code' => '200',
            'name' => 'Accounts Payable',
            'type' => 'Liabilities',
            'sub_type' => 'Current Liability',
        ],
        [
            'code' => '205',
            'name' => 'Accruals',
            'type' => 'Liabilities',
            'sub_type' => 'Current Liability',
        ],
        [
            'code' => '150',
            'name' => 'Office Equipment',
            'type' => 'Liabilities',
            'sub_type' => 'Current Liability',
        ],
        [
            'code' => '855',
            'name' => 'Clearing Account',
            'type' => 'Liabilities',
            'sub_type' => 'Current Liability',
        ],
        [
            'code' => '235',
            'name' => 'Employee Benefits Payable',
            'type' => 'Liabilities',
            'sub_type' => 'Current Liability',
        ],
        [
            'code' => '236',
            'name' => 'Employee Deductions payable',
            'type' => 'Liabilities',
            'sub_type' => 'Current Liability',
        ],
        [
            'code' => '255',
            'name' => 'Historical Adjustments',
            'type' => 'Liabilities',
            'sub_type' => 'Current Liability',
        ],
        [
            'code' => '835',
            'name' => 'Revenue Received in Advance',
            'type' => 'Liabilities',
            'sub_type' => 'Current Liability',
        ],
        [
            'code' => '260',
            'name' => 'Rounding',
            'type' => 'Liabilities',
            'sub_type' => 'Current Liability',
        ],
        [
            'code' => '500',
            'name' => 'Costs of Goods Sold',
            'type' => 'Expenses',
            'sub_type' => 'Direct Costs',
        ],
        [
            'code' => '600',
            'name' => 'Advertising',
            'type' => 'Expenses',
            'sub_type' => 'Expense',
        ],
        [
            'code' => '644',
            'name' => 'Automobile Expenses',
            'type' => 'Expenses',
            'sub_type' => 'Expense',
        ],
        [
            'code' => '684',
            'name' => 'Bad Debts',
            'type' => 'Expenses',
            'sub_type' => 'Expense',
        ],
        [
            'code' => '810',
            'name' => 'Bank Revaluations',
            'type' => 'Expenses',
            'sub_type' => 'Expense',
        ],
        [
            'code' => '605',
            'name' => 'Bank Service Charges',
            'type' => 'Expenses',
            'sub_type' => 'Expense',
        ],
        [
            'code' => '615',
            'name' => 'Consulting & Accounting',
            'type' => 'Expenses',
            'sub_type' => 'Expense',
        ],
        [
            'code' => '700',
            'name' => 'Depreciation',
            'type' => 'Expenses',
            'sub_type' => 'Expense',
        ],
        [
            'code' => '628',
            'name' => 'General Expenses',
            'type' => 'Expenses',
            'sub_type' => 'Expense',
        ],
        [
            'code' => '460',
            'name' => 'Interest Income',
            'type' => 'Income',
            'sub_type' => 'Revenue',
        ],
        [
            'code' => '470',
            'name' => 'Other Revenue',
            'type' => 'Income',
            'sub_type' => 'Revenue',
        ],
        [
            'code' => '475',
            'name' => 'Purchase Discount',
            'type' => 'Income',
            'sub_type' => 'Revenue',
        ],
        [
            'code' => '400',
            'name' => 'Sales',
            'type' => 'Income',
            'sub_type' => 'Revenue',
        ],
        [
            'code' => '330',
            'name' => 'Common Stock',
            'type' => 'Equity',
            'sub_type' => 'Equity',
        ],
        [
            'code' => '300',
            'name' => 'Owners Contribution',
            'type' => 'Equity',
            'sub_type' => 'Equity',
        ],
        [
            'code' => '310',
            'name' => 'Owners Draw',
            'type' => 'Equity',
            'sub_type' => 'Equity',
        ],
        [
            'code' => '320',
            'name' => 'Retained Earnings',
            'type' => 'Equity',
            'sub_type' => 'Equity',
        ],
    );

    public static function chartOfAccountData1($user)
    {
        $chartOfAccounts = Self::$chartOfAccount1;

        foreach($chartOfAccounts as $account)
        {

            $type=ChartOfAccountType::where('created_by',$user)->where('name',$account['type'])->first();
            $sub_type=ChartOfAccountSubType::where('type',$type->id)->where('name',$account['sub_type'])->first();

            ChartOfAccount::create(
                [
                    'code' => $account['code'],
                    'name' => $account['name'],
                    'type' => $type->id,
                    'sub_type' => $sub_type->id,
                    'is_enabled' => 1,
                    'created_by' => $user,
                ]
            );

        }
    }

    public static function chartOfAccountData($user)
    {
        $chartOfAccounts = Self::$chartOfAccount;
        foreach($chartOfAccounts as $account)
        {
            ChartOfAccount::create(
                [
                    'code' => $account['code'],
                    'name' => $account['name'],
                    'type' => $account['type'],
                    'sub_type' => $account['sub_type'],
                    'is_enabled' => 1,
                    'created_by' => $user->id,
                ]
            );

        }
    }

    public static function sendEmailTemplate($emailTemplate, $mailTo, $obj)
    {
        $usr = Auth::user();
        if($usr!=null && !empty($usr)){
            //Remove Current Login user Email don't send mail to them
            unset($mailTo[$usr->id]);

            $mailTo = array_values($mailTo);

            if($usr->type != 'Super Admin')
            {

                // find template is exist or not in our record
                $template = EmailTemplate::where('name', 'LIKE', $emailTemplate)->first();
                if(isset($template) && !empty($template))
                {

                    // check template is active or not by company
                    if($usr->type != 'super admin')
                    {
                        $is_active = UserEmailTemplate::where('template_id', '=', $template->id)->where('user_id', '=', $usr->creatorId())->first();

                    }
                    else{

                        $is_active = (object) array('is_active' => 1);
                    }

                    if($is_active->is_active == 1)
                    {
                        $settings = self::settings();

                        // get email content language base
                        $content = EmailTemplateLang::where('parent_id', '=', $template->id)->where('lang', 'LIKE', $usr->lang)->first();

                        $content->from = $template->from;
                        if(!empty($content->content))
                        {
                            $content->content = self::replaceVariable($content->content, $obj);


                            // send email
                            try
                            {
                                Mail::to($mailTo)->send(new CommonEmailTemplate($content, $settings));

                            }

                            catch(\Exception $e)
                            {
                                $error = $e->getMessage();
                            }

                            if(isset($error))
                            {
                                $arReturn = [
                                    'is_success' => false,
                                    'error' => $error,
                                ];
                            }
                            else
                            {
                                $arReturn = [
                                    'is_success' => true,
                                    'error' => false,
                                ];
                            }
                        }
                        else
                        {
                            $arReturn = [
                                'is_success' => false,
                                'error' => __('Mail not send, email is empty'),
                            ];
                        }

                        return $arReturn;
                    }
                    else
                    {
                        return [
                            'is_success' => true,
                            'error' => false,
                        ];
                    }
                }
                else
                {
                    return [
                        'is_success' => false,
                        'error' => __('Mail not send, email not found'),
                    ];
                }
            }
        }else{
             // find template is exist or not in our record
             $template = EmailTemplate::where('name', 'LIKE', $emailTemplate)->first();
             if(isset($template) && !empty($template))
             {



                $is_active = (object) array('is_active' => 1);

                 if($is_active->is_active == 1)
                 {
                     $settings = self::settings();

                     // get email content language base
                     $content = EmailTemplateLang::where('parent_id', '=', $template->id)->where('lang', 'LIKE', 'en')->first();

                     $content->from = $template->from;
                     if(!empty($content->content))
                     {
                         $content->content = self::replaceVariable($content->content, $obj);


                         // send email
                         try
                         {
                             Mail::to($mailTo)->send(new CommonEmailTemplate($content, $settings));

                         }

                         catch(\Exception $e)
                         {
                             $error = $e->getMessage();
                         }

                         if(isset($error))
                         {
                             $arReturn = [
                                 'is_success' => false,
                                 'error' => $error,
                             ];
                         }
                         else
                         {
                             $arReturn = [
                                 'is_success' => true,
                                 'error' => false,
                             ];
                         }
                     }
                     else
                     {
                         $arReturn = [
                             'is_success' => false,
                             'error' => __('Mail not send, email is empty'),
                         ];
                     }

                     return $arReturn;
                 }
                 else
                 {
                     return [
                         'is_success' => true,
                         'error' => false,
                     ];
                 }
             }
             else
             {
                 return [
                     'is_success' => false,
                     'error' => __('Mail not send, email not found'),
                 ];
             }
        }


    }

    public static function sendEmailwithattahcments($to,$filename)
    {
        $data["email"] = $to;
        $data["title"] = "Daily Prodcutivity Report";
        $data["body"] = "Please find the attachment of the Today Productivity report";

        $files = [
            public_path($pathname),
        ];

        try
        {
            Mail::send($data, function($message)use($data, $files) {
                $message->to($data["email"], $data["email"])
                        ->subject($data["title"]);

                foreach ($files as $file){
                    $message->attach($file);
                }

            });

        }

        catch(\Exception $e)
        {
            $error = $e->getMessage();
        }
        if(isset($error))
        {
            $arReturn = [
                'is_success' => false,
                'error' => $error,
            ];
        }else{
            $arReturn = [
                'is_success' => true,
                'error' => false,
            ];
        }
        return $arReturn;
    }
    public static function sendEmailTemplateHTML($emailTemplate, $mailTo, $obj)
    {
        $usr = Auth::user();
        if($usr!=null && !empty($usr)){
            //Remove Current Login user Email don't send mail to them
            unset($mailTo[$usr->id]);

            $mailTo = array_values($mailTo);

            if($usr->type != 'Super Admin')
            {

                // find template is exist or not in our record
                $template = EmailTemplate::where('name', 'LIKE', $emailTemplate)->first();
                if(isset($template) && !empty($template))
                {

                    // check template is active or not by company
                    if($usr->type != 'super admin')
                    {
                        $is_active = UserEmailTemplate::where('template_id', '=', $template->id)->where('user_id', '=', $usr->creatorId())->first();

                    }
                    else{

                        $is_active = (object) array('is_active' => 1);
                    }

                    if($is_active->is_active == 1)
                    {
                        $settings = self::settings();

                        // get email content language base
                        $content = EmailTemplateLang::where('parent_id', '=', $template->id)->where('lang', 'LIKE', $usr->lang)->first();

                        $content->from = $template->from;
                        if(!empty($content->content))
                        {
                            $content->content = self::replaceVariable($content->content, $obj);

                            // send email
                            try
                            {
                                // Mail::to($mailTo)->send(new CommonEmailTemplate($content, $settings));
                                Mail::to($mailTo)->send(new CommonEmailTemplate($content, $settings));

                            }

                            catch(\Exception $e)
                            {
                                $error = $e->getMessage();
                            }

                            if(isset($error))
                            {
                                $arReturn = [
                                    'is_success' => false,
                                    'error' => $error,
                                ];
                            }
                            else
                            {
                                $arReturn = [
                                    'is_success' => true,
                                    'error' => false,
                                ];
                            }
                        }
                        else
                        {
                            $arReturn = [
                                'is_success' => false,
                                'error' => __('Mail not send, email is empty'),
                            ];
                        }

                        return $arReturn;
                    }
                    else
                    {
                        return [
                            'is_success' => true,
                            'error' => false,
                        ];
                    }
                }
                else
                {
                    return [
                        'is_success' => false,
                        'error' => __('Mail not send, email not found'),
                    ];
                }
            }
        }else{
             // find template is exist or not in our record
             $template = EmailTemplate::where('name', 'LIKE', $emailTemplate)->first();
             if(isset($template) && !empty($template))
             {



                $is_active = (object) array('is_active' => 1);

                 if($is_active->is_active == 1)
                 {
                     $settings = self::settings();

                     // get email content language base
                     $content = EmailTemplateLang::where('parent_id', '=', $template->id)->where('lang', 'LIKE', 'en')->first();
                    //  Common template
                    $general_template_starting='';
                     $content->from = $template->from;
                     if(!empty($content->content))
                     {
                         $content->content = self::replaceVariable($content->content, $obj);

                         // send email
                         try
                         {
                             Mail::to($mailTo)->send(new CommonEmailTemplate($content, $settings));

                         }

                         catch(\Exception $e)
                         {
                             $error = $e->getMessage();
                         }

                         if(isset($error))
                         {
                             $arReturn = [
                                 'is_success' => false,
                                 'error' => $error,
                             ];
                         }
                         else
                         {
                             $arReturn = [
                                 'is_success' => true,
                                 'error' => false,
                             ];
                         }
                     }
                     else
                     {
                         $arReturn = [
                             'is_success' => false,
                             'error' => __('Mail not send, email is empty'),
                         ];
                     }

                     return $arReturn;
                 }
                 else
                 {
                     return [
                         'is_success' => true,
                         'error' => false,
                     ];
                 }
             }
             else
             {
                 return [
                     'is_success' => false,
                     'error' => __('Mail not send, email not found'),
                 ];
             }
        }


    }
    public static function replaceVariable($content, $obj)
    {
        $arrVariable = [
            '{app_name}',
            '{company_name}',
            '{app_url}',
            '{email}',
            '{password}',
            '{client_name}',
            '{client_email}',
            '{client_password}',
            '{support_name}',
            '{support_title}',
            '{support_priority}',
            '{support_end_date}',
            '{support_description}',
            '{lead_name}',
            '{lead_email}',
            '{lead_subject}',
            '{lead_pipeline}',
            '{lead_stage}',
            '{deal_name}',
            '{deal_pipeline}',
            '{deal_stage}',
            '{deal_status}',
            '{deal_price}',
            '{award_name}',
            '{award_email}',
            '{customer_name}',
            '{customer_email}',
            '{invoice_name}',
            '{invoice_number}',
            '{invoice_url}',
            '{invoice_payment_name}',
            '{invoice_payment_amount}',
            '{invoice_payment_date}',
            '{payment_dueAmount}',
            '{payment_reminder_name}',
            '{invoice_payment_number}',
            '{invoice_payment_dueAmount}',
            '{payment_reminder_date}',
            '{payment_name}',
            '{payment_bill}',
            '{payment_amount}',
            '{payment_date}',
            '{payment_method}',
            '{vender_name}',
            '{vender_email}',
            '{bill_name}',
            '{bill_number}',
            '{bill_url}',
            '{proposal_name}',
            '{proposal_number}',
            '{proposal_url}',

            '{complaint_name}',
            '{complaint_title}',
            '{complaint_against}',
            '{complaint_date}',
            '{complaint_description}',
            '{leave_name}',
            '{leave_status}',
            '{leave_reason}',
            '{leave_start_date}',
            '{leave_end_date}',
            '{total_leave_days}',
            '{employee_name}',
            '{employee_email}',
            '{payslip_name}',
            '{payslip_salary_month}',
            '{payslip_url}',
            '{promotion_designation}',
            '{promotion_title}',
            '{promotion_date}',
            '{resignation_email}',
            '{assign_user}',
            '{resignation_date}',
            '{notice_date}',
            '{termination_name}',
            '{termination_email}',
            '{termination_date}',
            '{termination_type}',
            '{transfer_name}',
            '{transfer_email}',
            '{transfer_date}',
            '{transfer_department}',
            '{transfer_branch}',
            '{transfer_description}',
            '{trip_name}',
            '{purpose_of_visit}',
            '{start_date}',
            '{end_date}',
            '{place_of_visit}',
            '{trip_description}',
            '{vender_bill_name}',
            '{vender_bill_number}',
            '{vender_bill_url}',
            '{employee_warning_name}',
            '{warning_subject}',
            '{warning_description}',
            '{contract_client}',
            '{contract_subject}',
            '{contract_start_date}',
            '{contract_end_date}',
            '{set_password_url}'


//            '{payment_name}',
//            '{payment_dueamount}',
//            '{payment_date}',
//            '{estimation_id}',
//            '{estimation_client}',
//            '{estimation_category}',
//            '{estimation_issue_date}',
//            '{estimation_expiry_date}',
//            '{estimation_status}',
//            '{project_title}',
//            '{project_category}',
//            '{project_price}',
//            '{project_client}',
//            '{project_assign_user}',
//            '{project_start_date}',
//            '{project_due_date}',
//            '{project_lead}',
//            '{project}',
//            '{task_title}',
//            '{task_priority}',
//            '{task_start_date}',
//            '{task_due_date}',
//            '{task_stage}',
//            '{task_assign_user}',
//            '{task_description}',
//            '{invoice_id}',
//            '{invoice_client}',
//            '{invoice_issue_date}',
//            '{invoice_due_date}',
//            '{invoice_status}',
//            '{invoice_total}',
//            '{invoice_sub_total}',
//            '{invoice_due_amount}',
//            '{payment_total}',
//            '{payment_date}',
//            '{credit_note_date}',
//            '{credit_amount}',
//            '{credit_description}',
//


        ];
        $arrValue    = [
            'app_name' => '-',
            'company_name' => '-',
            'app_url' => '-',
            'email' => '-',
            'password' => '-',
            'client_name' => '-',
            'client_email' => '-',
            'client_password' =>'-',
            'support_name' =>'-',
            'support_title' =>'-',
            'support_priority' =>'-',
            'support_end_date' =>'-',
            'support_description' =>'-',
            'lead_name' => '-',
            'lead_email' => '-',
            'lead_subject' => '-',
            'lead_pipeline' => '-',
            'lead_stage' => '-',
            'deal_name' => '-',
            'deal_pipeline' => '-',
            'deal_stage' => '-',
            'deal_status' => '-',
            'deal_price' => '-',
            'award_name' => '-',
            'award_email' => '-',
            'customer_name' => '-',
            'customer_email' =>'-',
            'invoice_name' => '-',
            'invoice_number' => '-',
            'invoice_url' =>'-',
            'invoice_payment_name' =>'-',
            'invoice_payment_amount' =>'-',
            'invoice_payment_date' =>'-',
            'payment_dueAmount' =>'-',
            'payment_reminder_name' =>'-',
            'invoice_payment_number' =>'-',
            'invoice_payment_dueAmount' =>'-',
            'payment_reminder_date' =>'-',


            'payment_name'=> '-',
            'payment_bill'=> '-',
            'payment_amount'=> '-',
            'payment_date'=> '-',
            'payment_method'=> '-',
            'vender_name'=> '-',
            'vender_email'=> '-',
            'bill_name' =>'-',
            'bill_number' =>'-',
            'bill_url' => '-',
            'proposal_name' =>'-',
            'proposal_number' => '-',
            'proposal_url' => '-',
            'complaint_name'=> '-',
            'complaint_title'=> '-',
            'complaint_against'=> '-',
            'complaint_date'=> '-',
            'complaint_description'=> '-',

            'leave_name' => '-',
            'leave_status' => '-',
            'leave_reason' => '-',
            'leave_start_date' => '-',
            'leave_end_date' => '-',
            'total_leave_days' => '-',
            'employee_name'=>'-',
            'employee_email' =>'-',
            'payslip_name'=>'-',
            'payslip_salary_month'=>'-',
            'payslip_url'=>'-',
            'promotion_designation' => '-',
            'promotion_title' => '-',
            'promotion_date' => '-',
            'resignation_email'=> '-',
            'assign_user' => '-',
            'resignation_date' => '-',
            'notice_date' => '-',
            'termination_name' => '-',
            'termination_email' => '-',
            'termination_date' => '-',
            'termination_type' => '-',
            'transfer_name' => '-',
            'transfer_email' => '-',
            'transfer_date' => '-',
            'transfer_department' => '-',
            'transfer_branch' => '-',
            'transfer_description' => '-',
            'trip_name' => '-',
            'purpose_of_visit' =>'-',
            'start_date' => '-',
            'end_date' => '-',
            'place_of_visit' => '-',
            'trip_description' => '-',
            'vender_bill_name' =>'-',
            'vender_bill_number' =>'-',
            'vender_bill_url' =>'-',
            'employee_warning_name' => '-',
            'warning_subject' => '-',
            'warning_description' => '-',
            'contract_client' => '-',
            'contract_subject' => '-',
            'contract_start_date' => '-',
            'contract_end_date' => '-',
            'set_password_url'=>'-'



        ];


        foreach($obj as $key => $val)
        {
            $arrValue[$key] = $val;
        }

//        dd($obj);
        $settings = Utility::settings();
        $company_name = $settings['company_name'];

        $arrValue['app_name']     =  $company_name;
        $arrValue['company_name'] = self::settings()['company_name'];
        $arrValue['app_url']      = '<a href="' . env('APP_URL') . '" target="_blank">' . env('APP_URL') . '</a>';

        // $arrValue['set_password_url']=  '<a class="btn bg-green border-green" href="' .$arrValue['set_password_url'] . '" target="_blank"><span class="btn-span">Set Password</span></a>';
        $arrValue['set_password_url']='<tr><td class="content text-center pt-0 pb-xl"><table cellspacing="0" cellpadding="0"><tbody><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" class="bg-green rounded w-auto"><tbody><tr><td align="center" valign="top" class="lh-1"><a href="'.$arrValue['set_password_url'].'" class="btn bg-green border-green"><span class="btn-span">Set Password</span></a></td></tr></tbody></table></td></tr></tbody></table></td></tr>';

//        dd($arrVariable);
//        dd(str_replace($arrVariable, array_values($arrValue), $content));

        return str_replace($arrVariable, array_values($arrValue), $content);
    }




    public static function pipeline_lead_deal_Stage($created_id)
    {
        $pipeline = Pipeline::create(
            [
                'name' => 'Sales',
                'created_by' => $created_id,
            ]
        );
        $stages   = [
            'Draft',
            'Sent',
            'Open',
            'Revised',
            'Declined',
        ];
        foreach($stages as $stage)
        {
            LeadStage::create(
                [
                    'name' => $stage,
                    'pipeline_id' => $pipeline->id,
                    'created_by' => $created_id,
                ]
            );
            Stage::create(
                [
                    'name' => $stage,
                    'pipeline_id' => $pipeline->id,
                    'created_by' => $created_id,
                ]
            );
        }

    }

    public static function project_task_stages($created_id)
    {
        $projectStages = [
            'To Do',
            'In Progress',
            'Review',
            'Done',
        ];
        foreach($projectStages as $key => $stage)
        {
            TaskStage::create(
                [
                    'name' => $stage,
                    'order' => $key,
                    'created_by' => $created_id,
                ]
            );
        }
    }

    public static function labels($created_id)
    {
        $stages = [
            [
                'name' => 'On Hold',
                'color' => 'primary',
            ],
            [
                'name' => 'New',
                'color' => 'info',
            ],
            [
                'name' => 'Pending',
                'color' => 'warning',
            ],
            [
                'name' => 'Loss',
                'color' => 'danger',
            ],
            [
                'name' => 'Win',
                'color' => 'success',
            ],
        ];
        foreach($stages as $stage)
        {
            Label::create(
                [
                    'name' => $stage['name'],
                    'color' => $stage['color'],
                    'pipeline_id' => 1,
                    'created_by' => $created_id,
                ]
            );
        }
        $bugStatus = [
            'Confirmed',
            'Resolved',
            'Unconfirmed',
            'In Progress',
            'Verified',
        ];
        foreach($bugStatus as $status)
        {
            BugStatus::create(
                [
                    'title' => $status,
                    'created_by' => $created_id,
                ]
            );
        }
    }

    public static function sources($created_id)
    {
        $stages = [
            'Websites',
            'Facebook',
            'Naukari.com',
            'Phone',
            'LinkedIn',
        ];
        foreach($stages as $stage)
        {
            Source::create(
                [
                    'name' => $stage,
                    'created_by' => $created_id,
                ]
            );
        }
    }

    public static function employeeNumber($user_id)
    {
        $latest = Employee::where('created_by', $user_id)->latest()->first();

        if(!$latest)
        {
            return 1;
        }

        return $latest->employee_id + 1;
    }

    public static function employeeDetails($user_id, $created_by)
    {
        $user = User::where('id', $user_id)->first();

        $employee = Employee::create(
            [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
                'employee_id' => Utility::employeeNumber($created_by),
                'created_by' => $created_by,
            ]
        );
    }

    public static function employeeDetailsUpdate($user_id, $created_by)
    {
        $user = User::where('id', $user_id)->first();

        $employee = Employee::where('user_id', $user->id)->update(
            [
                'name' => $user->name,
                'email' => $user->email,
            ]
        );


    }

    public static function jobStage($id)
    {
        $stages = [
            'Applied',
            'Phone Screen',
            'Interview',
            'Hired',
            'Rejected',
        ];
        foreach($stages as $stage)
        {

            JobStage::create(
                [
                    'title' => $stage,
                    'created_by' => $id,
                ]
            );
        }
    }

    public static function errorFormat($errors)
    {
        $err = '';

        foreach($errors->all() as $msg)
        {
            $err .= $msg . '<br>';
        }

        return $err;
    }

    // get date formated
    public static function getDateFormated($date)
    {
        if(!empty($date) && $date != '0000-00-00')
        {
            return date("d M Y", strtotime($date));
        }
        else
        {
            return '';
        }
    }

    // get progress bar color
    public static function getProgressColor($percentage)
    {
        $color = '';

        if($percentage <= 20)
        {
            $color = 'danger';
        }
        elseif($percentage > 20 && $percentage <= 40)
        {
            $color = 'warning';
        }
        elseif($percentage > 40 && $percentage <= 60)
        {
            $color = 'info';
        }
        elseif($percentage > 60 && $percentage <= 80)
        {
            $color = 'primary';
        }
        elseif($percentage >= 80)
        {
            $color = 'success';
        }

        return $color;
    }

    // Return Percentage from two value
    public static function getPercentage($val1 = 0, $val2 = 0)
    {
        $percentage = 0;
        if($val1 > 0 && $val2 > 0)
        {
            $percentage = intval(($val1 / $val2) * 100);
        }

        return $percentage;
    }

    public static function timeToHr($times)
    {
        $totaltime = self::calculateTimesheetHours($times);
        $timeArray = explode(':', $totaltime);
        if($timeArray[1] <= '30')
        {
            $totaltime = $timeArray[0];
        }
        $totaltime = $totaltime != '00' ? $totaltime : '0';

        return $totaltime;
    }

    public static function calculateTimesheetHours($times)
    {
        $minutes = 0;
        foreach($times as $time)
        {
            list($hour, $minute) = explode(':', $time);
            $minutes += $hour * 60;
            $minutes += $minute;
        }
        $hours   = floor($minutes / 60);
        $minutes -= $hours * 60;

        return sprintf('%02d:%02d', $hours, $minutes);
    }

    // Return Last 7 Days with date & day name
    public static function getLastSevenDays()
    {
        $arrDuration   = [];
        $previous_week = strtotime("-1 week +1 day");

        for($i = 0; $i < 7; $i++)
        {
            $arrDuration[date('Y-m-d', $previous_week)] = date('D', $previous_week);
            $previous_week                              = strtotime(date('Y-m-d', $previous_week) . " +1 day");
        }

        return $arrDuration;
    }

    // Check File is exist and delete these
    public static function checkFileExistsnDelete(array $files)
    {
        $status = false;
        foreach($files as $key => $file)
        {
            if(Storage::exists($file))
            {
                $status = Storage::delete($file);
            }
        }

        return $status;
    }

    // get project wise currency formatted amount
    public static function projectCurrencyFormat($project_id, $amount, $decimal = false)
    {
        $project = Project::find($project_id);
        if(empty($project))
        {
            $settings = Utility::settings();

            return (($settings['site_currency_symbol_position'] == "pre") ? $settings['site_currency_symbol'] : '') . number_format($price, Utility::getValByName('decimal_number')) . (($settings['site_currency_symbol_position'] == "post") ? $settings['site_currency_symbol'] : '');
        }


    }

    // Return Week first day and last day
    public static function getFirstSeventhWeekDay($week = null)
    {
        $first_day = $seventh_day = null;
        if(isset($week))
        {
            $first_day   = Carbon::now()->addWeeks($week)->startOfWeek();
            $seventh_day = Carbon::now()->addWeeks($week)->endOfWeek();
        }
        $dateCollection['first_day']   = $first_day;
        $dateCollection['seventh_day'] = $seventh_day;
        $period                        = CarbonPeriod::create($first_day, $seventh_day);
        foreach($period as $key => $dateobj)
        {
            $dateCollection['datePeriod'][$key] = $dateobj;
        }

        return $dateCollection;
    }

    public static function employeePayslipDetail($employeeId)
    {
//        dd($employeeId);
        $earning['allowance']         = Allowance::where('employee_id', $employeeId)->get();
//        dd($earning['allowance']);
        $employeesSalary = Employee::find($employeeId);

        $totalAllowance = 0 ;
        foreach($earning['allowance'] as $allowance)
        {
            if($allowance->type == 'fixed')
            {
                $totalAllowances  = $allowance->amount;
            }
            else
            {
                $totalAllowances  = $allowance->amount * $employeesSalary->salary / 100;
            }
            $totalAllowance += $totalAllowances ;
        }


//        $earning['totalAllowance']    = Allowance::where('employee_id', $employeeId)->where('type', 'fixed')->get()->sum('amount');
        $earning['commission']        = Commission::where('employee_id', $employeeId)->get();
        $totalCommisions = 0 ;
        foreach($earning['commission'] as $commission)
        {
            if($commission->type == 'fixed')
            {
                $totalCom  = $commission->amount;
            }
            else
            {
                $totalCom  = $commission->amount * $employeesSalary->salary / 100;
            }
            $totalCommisions += $totalCom ;
        }
//        $earning['totalCommission']   = Commission::where('employee_id', $employeeId)->where('type', 'fixed')->get()->sum('amount');
        $earning['otherPayment']      = OtherPayment::where('employee_id', $employeeId)->get();
        $totalOtherPayment = 0 ;
        foreach($earning['otherPayment'] as $otherPayment)
        {
            if($otherPayment->type == 'fixed')
            {
                $totalother  = $otherPayment->amount;
            }
            else
            {
                $totalother  = $otherPayment->amount * $employeesSalary->salary / 100;
            }
            $totalOtherPayment += $totalother ;
        }
//        $earning['totalOtherPayment'] = OtherPayment::where('employee_id', $employeeId)->where('type', 'fixed')->get()->sum('amount');
        $earning['overTime']          = Overtime::select('id', 'title')->selectRaw('number_of_days * hours* rate as amount')->where('employee_id', $employeeId)->get();
        $earning['totalOverTime']     = Overtime::selectRaw('number_of_days * hours* rate as total')->where('employee_id', $employeeId)->get()->sum('total');

        $deduction['loan']           = Loan::where('employee_id', $employeeId)->get();
        $totalLoan = 0 ;
        foreach($deduction['loan'] as $loan)
        {
            if($loan->type == 'fixed')
            {
                $totalloan  = $loan->amount;
            }
            else
            {
                $totalloan  = $loan->amount * $employeesSalary->salary / 100;
            }
            $totalLoan += $totalloan ;
        }
//        $deduction['totalLoan']      = Loan::where('employee_id', $employeeId)->where('type', 'fixed')->get()->sum('amount');
        $deduction['deduction']      = SaturationDeduction::where('employee_id', $employeeId)->get();
        $totalDeduction = 0 ;
        foreach($deduction['deduction'] as $deductions)
        {
            if($deductions->type == 'fixed')
            {
                $totaldeduction  = $deductions->amount;
            }
            else
            {
                $totaldeduction  = $deductions->amount * $employeesSalary->salary / 100;
            }
            $totalDeduction += $totaldeduction ;
        }
//        $deduction['totalDeduction'] = SaturationDeduction::where('employee_id', $employeeId)->where('type', 'fixed')->get()->sum('amount');

        $payslip['earning']        = $earning;
        $payslip['totalEarning']   = $totalAllowance + $totalCommisions + $totalOtherPayment + $earning['totalOverTime'];
        $payslip['deduction']      = $deduction;
        $payslip['totalDeduction'] = $totalLoan + $totalDeduction;

        return $payslip;
    }

    public static function companyData($company_id, $string)
    {
        $setting = DB::table('settings')->where('created_by', $company_id)->where('name', $string)->first();
        if(!empty($setting))
        {
            return $setting->value;
        }
        else
        {
            return '';
        }
    }

    public static function addNewData()
    {
        \Artisan::call('cache:forget spatie.permission.cache');
        \Artisan::call('cache:clear');
        $usr = \Auth::user();

        $arrPermissions = [
            'manage form builder',
            'create form builder',
            'edit form builder',
            'delete form builder',
            'manage form field',
            'create form field',
            'edit form field',
            'delete form field',
            'view form response',
            'manage performance type',
            'create performance type',
            'edit performance type',
            'delete performance type',
            'manage budget plan',
            'create budget plan',
            'edit budget plan',
            'delete budget plan',
            'view budget plan',
            'stock report',
            'manage warehouse',
            'create warehouse',
            'edit warehouse',
            'show warehouse',
            'delete warehouse',
            'manage purchase',
            'create purchase',
            'edit purchase',
            'show purchase',
            'delete purchase',
            'send purchase',
            'create purchase purchase',
            'manage pos',
            'manage contract type',
            'create contract type',
            'edit contract type',
            'delete contract type',

        ];
        foreach($arrPermissions as $ap)
        {
            // check if permission is not created then create it.
            $permission = Permission::where('name', 'LIKE', $ap)->first();
            if(empty($permission))
            {
                Permission::create(['name' => $ap]);
            }
        }
        $companyRole = Role::where('name', 'LIKE', 'company')->first();

        $companyPermissions   = $companyRole->getPermissionNames()->toArray();
        $companyNewPermission = [
            'manage form builder',
            'create form builder',
            'edit form builder',
            'delete form builder',
            'manage form field',
            'create form field',
            'edit form field',
            'delete form field',
            'view form response',
            'manage performance type',
            'create performance type',
            'edit performance type',
            'delete performance type',
            'manage budget plan',
            'create budget plan',
            'edit budget plan',
            'delete budget plan',
            'view budget plan',
            'stock report',
            'manage warehouse',
            'create warehouse',
            'edit warehouse',
            'show warehouse',
            'delete warehouse',
            'manage purchase',
            'create purchase',
            'edit purchase',
            'show purchase',
            'delete purchase',
            'send purchase',
            'create purchase purchase',
            'manage pos',
            'manage contract type',
            'create contract type',
            'edit contract type',
            'delete contract type',
        ];
        foreach($companyNewPermission as $op)
        {
            // check if permission is not assign to owner then assign.
            if(!in_array($op, $companyPermissions))
            {
                $permission = Permission::findByName($op);
                $companyRole->givePermissionTo($permission);
            }
        }


    }


    public static function getAdminPaymentSetting()
    {
        $data     = \DB::table('admin_payment_settings');
        $settings = [];
        if(\Auth::check())
        {
            $user_id = 1;
            $data    = $data->where('created_by', '=', $user_id);

        }
        $data = $data->get();
        foreach($data as $row)
        {
            $settings[$row->name] = $row->value;
        }

        return $settings;
    }

    public static function getCompanyPaymentSetting($user_id)
    {

        $data     = \DB::table('company_payment_settings');
        $settings = [];
        $data     = $data->where('created_by', '=', $user_id);
        $data     = $data->get();
        foreach($data as $row)
        {
            $settings[$row->name] = $row->value;
        }

        return $settings;
    }

    public static function getCompanyPayment()
    {

        $data     = \DB::table('company_payment_settings');
        $settings = [];
        if(\Auth::check())
        {
            $user_id = \Auth::user()->creatorId();
            $data    = $data->where('created_by', '=', $user_id);

        }
        $data = $data->get();
        foreach($data as $row)
        {
            $settings[$row->name] = $row->value;
        }

        return $settings;
    }



    public static function error_res($msg = "", $args = array())
    {
        $msg       = $msg == "" ? "error" : $msg;
        $msg_id    = 'error.' . $msg;
        $converted = \Lang::get($msg_id, $args);
        $msg       = $msg_id == $converted ? $msg : $converted;
        $json      = array(
            'flag' => 0,
            'msg' => $msg,
        );

        return $json;
    }

    public static function success_res($msg = "", $args = array())
    {
        $msg       = $msg == "" ? "success" : $msg;
        $msg_id    = 'success.' . $msg;
        $converted = \Lang::get($msg_id, $args);
        $msg       = $msg_id == $converted ? $msg : $converted;
        $json      = array(
            'flag' => 1,
            'msg' => $msg,
        );

        return $json;
    }

    public static function get_messenger_packages_migration()
    {
        $totalMigration = 0;
        $messengerPath  = glob(base_path() . '/vendor/munafio/chatify/database/migrations' . DIRECTORY_SEPARATOR . '*.php');
        if(!empty($messengerPath))
        {
            $messengerMigration = str_replace('.php', '', $messengerPath);
            $totalMigration     = count($messengerMigration);
        }

        return $totalMigration;

    }

    public static function getselectedThemeColor()
    {
        $color = env('THEME_COLOR');
        if($color == "" || $color == null)
        {
            $color = 'blue';
        }

        return $color;
    }

    public static function getAllThemeColors()
    {
        $colors = [
            'blue',
            'denim',
            'sapphire',
            'olympic',
            'violet',
            'black',
            'cyan',
            'dark-blue-natural',
            'gray-dark',
            'light-blue',
            'light-purple',
            'magenta',
            'orange-mute',
            'pale-green',
            'rich-magenta',
            'rich-red',
            'sky-gray',
        ];

        return $colors;
    }

    public static function diffance_to_time($start, $end)
    {
        $start         = new Carbon($start);
        $end           = new Carbon($end);
        $totalDuration = $start->diffInSeconds($end);

        return $totalDuration;
    }

    public static function second_to_time($seconds = 0)
    {
        $H = floor($seconds / 3600);
        $i = ($seconds / 60) % 60;
        $s = $seconds % 60;

        $time = sprintf("%02d:%02d:%02d", $H, $i, $s);

        return $time;
    }


    //Slack notification
    public static function send_slack_msg($msg,$created_id=0) {

        if($created_id==0){
            $settings  = Utility::settings(\Auth::user()->creatorId());
        }else{
            $settings  = Utility::settings($created_id);
        }

        try{
            if(isset($settings['slack_webhook']) && !empty($settings['slack_webhook'])){
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $settings['slack_webhook']);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['text' => $msg]));

                $headers = array();
                $headers[] = 'Content-Type: application/json';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $result = curl_exec($ch);
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }
                curl_close($ch);
            }
        }
        catch(\Exception $e){

        }

    }


    //Telegram Notification
    public static function send_telegram_msg($resp,$created_id=0) {
        if($created_id==0){
            $settings  = Utility::settings(\Auth::user()->creatorId());
        }else{
            $settings  = Utility::settings($created_id);
        }

       try{
           $msg = $resp;
           // Set your Bot ID and Chat ID.
           $telegrambot    = $settings['telegram_accestoken'];
           $telegramchatid = $settings['telegram_chatid'];
           // Function call with your own text or variable
           $url     = 'https://api.telegram.org/bot' . $telegrambot . '/sendMessage';
           $data    = array(
               'chat_id' => $telegramchatid,
               'text' => $msg,
           );
           $options = array(
               'http' => array(
                   'method' => 'POST',
                   'header' => "Content-Type:application/x-www-form-urlencoded\r\n",
                   'content' => http_build_query($data),
               ),
           );
           $context = stream_context_create($options);
           $result  = file_get_contents($url, false, $context);
           $url     = $url;
       }
       catch(\Exception $e){

       }


    }

    //Twilio Notification
    public static function send_twilio_msg($to, $msg,$created_id=0)
    {
        if($created_id==0){
            $settings  = Utility::settings(\Auth::user()->creatorId());
        }else{
            $settings  = Utility::settings($created_id);
        }
        $account_sid    = $settings['twilio_sid'];
        $auth_token = $settings['twilio_token'];
        $twilio_number = $settings['twilio_from'];
        try{
            $client        = new Client($account_sid, $auth_token);
            $client->messages->create($to, [
                'from' => $twilio_number,
                'body' => $msg,
            ]);
        }
        catch(\Exception $e){

        }
        //  dd('SMS Sent Successfully.');

    }

    //inventory management (Quantity)
    public static function total_quantity($type, $quantity, $product_id)
    {


        $product      = ProductService::find($product_id);
        $pro_quantity = $product->quantity;

        if($type == 'minus')
        {
            $product->quantity = $pro_quantity - $quantity;
        }
        else
        {
            $product->quantity = $pro_quantity + $quantity;


        }
        $product->save();
    }

    //add quantity in product stock
    public static function addProductStock($product_id, $quantity, $type, $description,$type_id)
    {

        $stocks             = new StockReport();
        $stocks->product_id = $product_id;
        $stocks->quantity	 = $quantity;
        $stocks->type = $type;
        $stocks->type_id = $type_id;
        $stocks->description = $description;
        $stocks->created_by =\Auth::user()->creatorId();
        $stocks->save();
    }

    public static function mode_layout()
    {
        $data = DB::table('settings');

        if (\Auth::check()) {

            $data=$data->where('created_by','=',\Auth::user()->creatorId())->get();
            if(count($data)==0){
                $data =DB::table('settings')->where('created_by', '=', 1 )->get();
            }

        } else {

            $data->where('created_by', '=', 1);
            $data = $data->get();
        }




        $settings = [
            "cust_darklayout" => "off",
            "cust_theme_bg" => "on",
            "color" => ''
        ];
        foreach($data as $row)
        {
            $settings[$row->name] = $row->value;
        }
        return $settings;
    }

    public static function colorset()

    {

        if(\Auth::check())
        {
            if(\Auth::user()->type == 'super admin')
            {
                $user = \Auth::user();

                $setting = DB::table('settings')->where('created_by',$user->id)->pluck('value','name')->toArray();
            }
            else
            {
                $setting = DB::table('settings')->where('created_by', \Auth::user()->creatorId())->pluck('value','name')->toArray();
            }
        }
        else
        {
            $user = User::where('type','super admin')->first();
            $setting = DB::table('settings')->where('created_by',$user->id)->pluck('value','name')->toArray();
        }

        if(!isset($setting['color']))
        {
            $setting = Utility::settings();
        }

        return $setting;
    }

    public static function get_superadmin_logo(){
        $is_dark_mode = self::getValByName('cust_darklayout');
        $setting = DB::table('settings')->where('created_by', Auth::user()->id)->pluck('value','name')->toArray();
        if(!empty($setting['cust_darklayout'])){
            $is_dark_mode = $setting['cust_darklayout'];
            // dd($is_dark_mode);
            if($is_dark_mode == 'on'){
                return 'logo-light.png';
            }else{
                return 'logo-dark.png';
            }

        }
        else {
            return 'logo-dark.png';
        }

    }

    public static function GetLogo()
    {
        $setting = Utility::colorset();

        if(\Auth::user() && \Auth::user()->type != 'super admin')
        {

            if(Utility::getValByName('cust_darklayout') == 'on')
            {

                return Utility::getValByName('company_logo_light');
            }
            else
            {
                return Utility::getValByName('company_logo_dark');
            }
        }
        else
        {
            if(Utility::getValByName('cust_darklayout') == 'on')
            {

                return Utility::getValByName('light_logo');
            }
            else
            {
                return Utility::getValByName('dark_logo');
            }
        }
    }

    public static function getGdpr()
    {
        $data = DB::table('settings');
        if (\Auth::check()) {
            $data = $data->where('created_by', '=', 1);
        } else {
            $data = $data->where('created_by', '=', 1);
        }
        $data     = $data->get();
        $settings = [
            "gdpr_cookie" => "",
            "cookie_text" => "",
        ];
        foreach ($data as $row) {
            $settings[$row->name] = $row->value;
        }
        return $settings;
    }

    public static function getValByName1($key)
    {
        $setting = Utility::getGdpr();
        if (!isset($setting[$key]) || empty($setting[$key])) {
            $setting[$key] = '';
        }

        return $setting[$key];
    }


    //add quantity in warehouse stock
    public static function addWarehouseStock($product_id, $quantity, $warehouse_id)
    {

        $product     = WarehouseProduct::where('product_id' , $product_id)->where('warehouse_id' , $warehouse_id)->first();
        if($product){
            $pro_quantity = $product->quantity;
            $product_quantity = $pro_quantity + $quantity;
        }else{
            $product_quantity = $quantity;
        }

        $data = WarehouseProduct::updateOrCreate(
            ['warehouse_id' => $warehouse_id, 'product_id' => $product_id,'created_by' => \Auth::user()->id],
            ['warehouse_id' => $warehouse_id, 'product_id' => $product_id, 'quantity' => $product_quantity,'created_by' => \Auth::user()->id])
          ;

    }

    public static function starting_number($id, $type)
    {

        if($type == 'invoice')
        {
            $data = DB::table('settings')->where('created_by', \Auth::user()->creatorId())->where('name', 'invoice_starting_number')->update(array('value' => $id));
        }
        elseif($type == 'proposal')
        {
            $data = DB::table('settings')->where('created_by', \Auth::user()->creatorId())->where('name', 'proposal_starting_number')->update(array('value' => $id));
        }

        elseif($type == 'bill')
        {
            $data = DB::table('settings')->where('created_by', \Auth::user()->creatorId())->where('name', 'bill_starting_number')->update(array('value' => $id));
        }

        return $data;
    }

    //  Start Storage Setting

    public static function upload_file($request,$key_name,$name,$path,$custom_validation =[])
    {
        try{
            $settings = Utility::getStorageSetting();
//                dd($settings);

            if(!empty($settings['storage_setting'])){

                if($settings['storage_setting'] == 'wasabi'){

                    config(
                        [
                            'filesystems.disks.wasabi.key' => $settings['wasabi_key'],
                            'filesystems.disks.wasabi.secret' => $settings['wasabi_secret'],
                            'filesystems.disks.wasabi.region' => $settings['wasabi_region'],
                            'filesystems.disks.wasabi.bucket' => $settings['wasabi_bucket'],
                            'filesystems.disks.wasabi.endpoint' => 'https://s3.'.$settings['wasabi_region'].'.wasabisys.com'
                        ]
                    );

                    $max_size = !empty($settings['wasabi_max_upload_size'])? $settings['wasabi_max_upload_size']:'2048';
                    $mimes =  !empty($settings['wasabi_storage_validation'])? $settings['wasabi_storage_validation']:'';

                }else if($settings['storage_setting'] == 's3'){
                    config(
                        [
                            'filesystems.disks.s3.key' => $settings['s3_key'],
                            'filesystems.disks.s3.secret' => $settings['s3_secret'],
                            'filesystems.disks.s3.region' => $settings['s3_region'],
                            'filesystems.disks.s3.bucket' => $settings['s3_bucket'],
                            'filesystems.disks.s3.use_path_style_endpoint' => false,
                            'filesystems.disks.s3.visibility' => 'public',
                        ]
                    );
                    $max_size = !empty($settings['s3_max_upload_size'])? $settings['s3_max_upload_size']:'2048';
                    $mimes =  !empty($settings['s3_storage_validation'])? $settings['s3_storage_validation']:'';


                }else{

                    $max_size = !empty($settings['local_storage_max_upload_size'])? $settings['local_storage_max_upload_size']:'20480000000';
                    $mimes =  !empty($settings['local_storage_validation'])? $settings['local_storage_validation']:'';
                }


                $file = $request->$key_name;

                if(count($custom_validation) > 0){

                    $validation =$custom_validation;
                }else{

                    $validation =[
                        'mimes:'.$mimes,
                        'max:'.$max_size,
                    ];

                }

                $validator = \Validator::make($request->all(), [
                    $key_name =>$validation
                ]);

                // if($validator->fails()){

                //     $res = [
                //         'flag' => 0,
                //         'msg' => $validator->messages()->first(),
                //     ];

                //     return $res;
                // } else {

                $name = $name;

                if($settings['storage_setting']=='local')
                {
//                    dd(\Storage::disk(),$path);

                    $request->$key_name->move(storage_path($path), $name);
                    $path = $path.$name;
                }
                else if($settings['storage_setting'] == 'wasabi'){

                    $path = \Storage::disk('wasabi')->putFileAs(
                        $path,
                        $file,
                        $name
                    );

                        // $path = $path.$name;

                    }else if($settings['storage_setting'] == 's3'){
                        // print_r($name);
                        // dd($path);

                        if (! $path=Storage::disk('s3')->putFileAs($path, $file , $name)) {
                            // echo 'no';
                        }else{
                            // echo 'uploaded';
                        }
                        // $path = \Storage::disk('s3')->putFileAs(
                        //         $path,
                        //         $file,
                        //         $name
                        // );

                        // $path = $path.$name;
                        // dd($path);
                    }



                    $res = [
                        'flag' => 1,
                        'msg'  =>'success',
                        'url'  => $path
                    ];
                    return $res;
                // }

            }else{
                $res = [
                    'flag' => 0,
                    'msg' => __('Please set proper configuration for storage.'),
                ];
                return $res;
            }

        }catch(\Exception $e){

            $res = [
                'flag' => 0,
                'msg' => $e->getMessage(),
            ];
            return $res;
        }
    }

    public static function multi_upload_file($request,$key_name,$name,$path,$custom_validation =[])
    {
        try{
            $settings = Utility::getStorageSetting();

            if(!empty($settings['storage_setting'])){

                if($settings['storage_setting'] == 'wasabi'){
                    config(
                        [
                            'filesystems.disks.wasabi.key' => $settings['wasabi_key'],
                            'filesystems.disks.wasabi.secret' => $settings['wasabi_secret'],
                            'filesystems.disks.wasabi.region' => $settings['wasabi_region'],
                            'filesystems.disks.wasabi.bucket' => $settings['wasabi_bucket'],
                            'filesystems.disks.wasabi.endpoint' => 'https://s3.'.$settings['wasabi_region'].'.wasabisys.com'
                        ]
                    );

                    $max_size = !empty($settings['wasabi_max_upload_size'])? $settings['wasabi_max_upload_size']:'2048';
                    $mimes =  !empty($settings['wasabi_storage_validation'])? $settings['wasabi_storage_validation']:'';

                }else if($settings['storage_setting'] == 's3'){
                    config(
                        [
                            'filesystems.disks.s3.key' => $settings['s3_key'],
                            'filesystems.disks.s3.secret' => $settings['s3_secret'],
                            'filesystems.disks.s3.region' => $settings['s3_region'],
                            'filesystems.disks.s3.bucket' => $settings['s3_bucket'],
                            'filesystems.disks.s3.use_path_style_endpoint' => false,
                            'filesystems.disks.s3.visibility' => 'public',
                        ]
                    );
                    $max_size = !empty($settings['s3_max_upload_size'])? $settings['s3_max_upload_size']:'2048';
                    $mimes =  !empty($settings['s3_storage_validation'])? $settings['s3_storage_validation']:'';


                }else{
                    $max_size = !empty($settings['local_storage_max_upload_size'])? $settings['local_storage_max_upload_size']:'20480000000';
                    $mimes =  !empty($settings['local_storage_validation'])? $settings['local_storage_validation']:'';
                }

                $file = $request;

                if(count($custom_validation) > 0){
                    $validation = $custom_validation;
                }else{
                    $validation =[
                        'mimes:'.$mimes,
                        'max:'.$max_size,
                    ];
                }

                $name = $name;

                if($settings['storage_setting']=='local')
                {
                    $file->move(storage_path($path), $name);
                    $path = $path.$name;
                }
                else if($settings['storage_setting'] == 'wasabi'){
                    $path = \Storage::disk('wasabi')->putFileAs(
                        $path,
                        $file,
                        $name
                    );
                }
                else if($settings['storage_setting'] == 's3'){
                    if (! $path=Storage::disk('s3')->putFileAs($path, $file , $name)) {
                        // echo 'no';
                    }else{
                        // echo 'uploaded';
                    }
                }

                $res = [
                    'flag' => 1,
                    'msg'  =>'success',
                    'url'  => $path
                ];
                return $res;

            }else{
                $res = [
                    'flag' => 0,
                    'msg' => __('Please set proper configuration for storage.'),
                ];
                return $res;
            }

        }catch(\Exception $e){

            $res = [
                'flag' => 0,
                'msg' => $e->getMessage(),
            ];
            return $res;
        }
    }

    //only employee edit storage setting upload_coustom_file function

    public static function upload_coustom_file($request,$key_name,$name,$path,$data_key,$custom_validation =[])
    {

        try{
            $settings = Utility::getStorageSetting();


            if(!empty($settings['storage_setting'])){

                if($settings['storage_setting'] == 'wasabi'){

                    config(
                        [
                            'filesystems.disks.wasabi.key' => $settings['wasabi_key'],
                            'filesystems.disks.wasabi.secret' => $settings['wasabi_secret'],
                            'filesystems.disks.wasabi.region' => $settings['wasabi_region'],
                            'filesystems.disks.wasabi.bucket' => $settings['wasabi_bucket'],
                            'filesystems.disks.wasabi.endpoint' => 'https://s3.'.$settings['wasabi_region'].'.wasabisys.com'
                        ]
                    );

                    $max_size = !empty($settings['wasabi_max_upload_size'])? $settings['wasabi_max_upload_size']:'2048';
                    $mimes =  !empty($settings['wasabi_storage_validation'])? $settings['wasabi_storage_validation']:'';

                }else if($settings['storage_setting'] == 's3'){
                    config(
                        [
                            'filesystems.disks.s3.key' => $settings['s3_key'],
                            'filesystems.disks.s3.secret' => $settings['s3_secret'],
                            'filesystems.disks.s3.region' => $settings['s3_region'],
                            'filesystems.disks.s3.bucket' => $settings['s3_bucket'],
                            'filesystems.disks.s3.use_path_style_endpoint' => false,
                            'filesystems.disks.s3.visibility' => 'public',
                        ]
                    );
                    $max_size = !empty($settings['s3_max_upload_size'])? $settings['s3_max_upload_size']:'2048';
                    $mimes =  !empty($settings['s3_storage_validation'])? $settings['s3_storage_validation']:'';


                }else{
                    $max_size = !empty($settings['local_storage_max_upload_size'])? $settings['local_storage_max_upload_size']:'2048';

                    $mimes =  !empty($settings['local_storage_validation'])? $settings['local_storage_validation']:'';
                }


                $file = $request->$key_name;
                // dd($file[$data_key]);
                $file=$file[$data_key];
                if(count($custom_validation) > 0){
                    $validation =$custom_validation;
                }else{

                    $validation =[
                        'mimes:'.$mimes,
                        'max:'.$max_size,
                    ];

                }
                $validator = \Validator::make($request->all(), [
                    $name =>$validation
                ]);

                if($validator->fails()){
                    $res = [
                        'flag' => 0,
                        'msg' => $validator->messages()->first(),
                    ];
                    return $res;
                } else {


                    if($settings['storage_setting']=='local'){



                        \Storage::disk()->putFileAs(
                            $path,
                            $request->file($key_name)[$data_key],
                            $name
                        );


                        $path = $name;
                    }else if($settings['storage_setting'] == 'wasabi'){

                        $path = \Storage::disk('wasabi')->putFileAs(
                            $path,
                            $file,
                            $name
                        );

                        // $path = $path.$name;

                    }else if($settings['storage_setting'] == 's3'){

                        // $path = \Storage::disk('s3')->putFileAs(
                        //     $path,
                        //     $file,
                        //     $name
                        // );
                        if (! $path=Storage::disk('s3')->putFileAs($path, $file , $name)) {
                            echo 'no';
                        }else{
                            echo 'uploaded';
                        }
                        // $path = $path.$name;
                        // dd($path);
                    }

                    $res = [
                        'flag' => 1,
                        'msg'  =>'success',
                        'url'  => $path
                    ];
                    return $res;
                }

            }else{
                $res = [
                    'flag' => 0,
                    'msg' => __('Please set proper configuration for storage.'),
                ];
                return $res;
            }

        }catch(\Exception $e){
            $res = [
                'flag' => 0,
                'msg' => $e->getMessage(),
            ];
            return $res;
        }
    }

    public static function get_file($path){
        $settings = Utility::getStorageSetting();

        try {
            if($settings['storage_setting'] == 'wasabi'){
                config(
                    [
                        'filesystems.disks.wasabi.key' => $settings['wasabi_key'],
                        'filesystems.disks.wasabi.secret' => $settings['wasabi_secret'],
                        'filesystems.disks.wasabi.region' => $settings['wasabi_region'],
                        'filesystems.disks.wasabi.bucket' => $settings['wasabi_bucket'],
                        'filesystems.disks.wasabi.endpoint' => 'https://s3.'.$settings['wasabi_region'].'.wasabisys.com'
                    ]
                );
            }elseif($settings['storage_setting'] == 's3'){
                config(
                    [
                        'filesystems.disks.s3.key' => $settings['s3_key'],
                        'filesystems.disks.s3.secret' => $settings['s3_secret'],
                        'filesystems.disks.s3.region' => $settings['s3_region'],
                        'filesystems.disks.s3.bucket' => $settings['s3_bucket'],
                        'filesystems.disks.s3.use_path_style_endpoint' => false,
                    ]
                );
            }

            return \Storage::disk($settings['storage_setting'])->url($path);
        } catch (\Throwable $th) {
            return '';
        }
    }

    public static function getStorageSetting()
    {
        $data = DB::table('settings');
        $data = $data->where('created_by', '=', 1);
        $data     = $data->get();
        $settings = [
            "storage_setting" => "local",
            "local_storage_validation" => ".jpg,.jpeg,.png,.xlsx,.xls,.csv,.pdf,.docx",
            "local_storage_max_upload_size" => "2048000",
            "s3_key" => "",
            "s3_secret" => "",
            "s3_region" => "",
            "s3_bucket" => "",
            "s3_url"    => "",
            "s3_endpoint" => "",
            "s3_max_upload_size" => "",
            "s3_storage_validation" => "",
            "wasabi_key" => "",
            "wasabi_secret" => "",
            "wasabi_region" => "",
            "wasabi_bucket" => "",
            "wasabi_url" => "",
            "wasabi_root" => "",
            "wasabi_max_upload_size" => "",
            "wasabi_storage_validation" => "",
        ];
        foreach($data as $row)
        {
            $settings[$row->name] = $row->value;
        }
        return $settings;
    }

    //  End Storage Setting


    public static function getTargetrating($designationid, $competencyCount)
    {

        $indicator = Indicator::where('designation', $designationid)->first();
        if (!empty($indicator->rating) && $indicator->rating!='null' && ($competencyCount != 0))
        {

            $rating = json_decode($indicator->rating, true);
            $starsum = array_sum($rating);

            $overallrating = $starsum / $competencyCount;
        } else {
            $overallrating = 0;
        }
        return $overallrating;
    }

    //################## Get all state country city function ##########################################
    public static function getcountry()
    {
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.countrystatecity.in/v1/countries',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'X-CSCAPI-KEY: '.env('Locationapi_key')
            ),
            ));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

            $response = curl_exec($curl);


            curl_close($curl);
            return json_decode($response);

    }

    public static function getstate($country_code)
    {
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.countrystatecity.in/v1/countries/'.$country_code.'/states',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'X-CSCAPI-KEY: '.env('Locationapi_key')
            ),
            ));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($curl);
            curl_close($curl);
            $data=json_decode($response);
            if(isset($data->error)){
                $array=array();
                return $array;
            }else{
                uasort($data, function($a, $b) {
                    return $a->name < $b->name ? -1 : 1;
                });
                return $data;
            }

    }
    public static function getcity($country_code,$state_code)
    {
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.countrystatecity.in/v1/countries/'.$country_code.'/states/'.$state_code.'/cities',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'X-CSCAPI-KEY: '.env('Locationapi_key')
            ),
            ));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

            $response = curl_exec($curl);

            curl_close($curl);
            return json_decode($response);
    }
//################## Get all state country city function by id##########################################

        public static function getcountry_details($country_code)
        {
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api.countrystatecity.in/v1/countries/'.$country_code,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_HTTPHEADER => array(
                'X-CSCAPI-KEY: '.env('Locationapi_key')
              ),
            ));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($curl);

            curl_close($curl);
            return json_decode($response);
        }

        public static function getstate_details($country_code,$state_code)
        {
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api.countrystatecity.in/v1/countries/'.$country_code.'/states/'.$state_code,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_HTTPHEADER => array(
                'X-CSCAPI-KEY: '.env('Locationapi_key')
              ),
            ));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($curl);

            curl_close($curl);
            return json_decode($response);
        }
        public static function getcountry_detailsonly_name($country_code)
        {
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api.countrystatecity.in/v1/countries/'.$country_code,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_HTTPHEADER => array(
                'X-CSCAPI-KEY: '.env('Locationapi_key')
              ),
            ));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($curl);

            curl_close($curl);
            $data=json_decode($response);
            if(isset($data->name)){
                return $data->name;
            }else{
                return '';
            }

        }

        public static function getstate_detailsonly_name($country_code,$state_code)
        {
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api.countrystatecity.in/v1/countries/'.$country_code.'/states/'.$state_code,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_HTTPHEADER => array(
                'X-CSCAPI-KEY: '.env('Locationapi_key')
              ),
            ));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($curl);

            curl_close($curl);
            $data=json_decode($response);
            if(isset($data->name)){
                return $data->name;
            }else{
                return '';
            }
        }
        // Date Convert
        public static function site_date_format($date,$user_id){

            $data =DB::table('settings')->where(['name'=>'site_date_format','created_by'=>$user_id])->get();
            if(count($data)>0){
                $convertor=$data[0]->value;
            }else{
                $convertor="M j, Y";
            }
            return  date($convertor, strtotime($date));

        }

        public static function site_date_format_minus_day($date,$user_id,$minus_count){
            
            $data =DB::table('settings')->where(['name'=>'site_date_format','created_by'=>$user_id])->get();
            if(count($data)>0){
                $convertor=$data[0]->value;
            }else{
                $convertor="M j, Y";
            }

            if($minus_count > 0){
                $minus_day_get = "-".$minus_count." day";
                return  date($convertor, strtotime($date . $minus_day_get));
            }
            else{
                return  date($convertor, strtotime($date));
            }
        }

         // Time Convert
         public static function site_time_format($date,$user_id){

            $data =DB::table('settings')->where(['name'=>'site_time_format','created_by'=>$user_id])->get();
            if(count($data)>0){
                $convertor=$data[0]->value;
            }else{
                $convertor="g:i A";
            }
            return  date($convertor, strtotime($date));

        }
         // Time Convert
         public static function site_decimal_number($myNumber,$user_id){

            $data =DB::table('settings')->where(['name'=>'decimal_number','created_by'=>$user_id])->get();
            if(count($data)>0){
                $convertor=$data[0]->value;
            }else{
                $convertor="2";
            }
            return  number_format( $myNumber, $convertor, ',', ' ' );

        }

         // Site Currency
         public static function site_currency($user_id){

            $data =DB::table('settings')->where(['name'=>'site_currency','created_by'=>$user_id])->get();
            if(count($data)>0){
                $convertor=$data[0]->value;
            }else{
                $convertor="INR";
            }
            return  $convertor;

        }

         // Site Currency
         public static function site_currency_symbol($user_id){

            $data =DB::table('settings')->where(['name'=>'site_currency_symbol','created_by'=>$user_id])->get();
            if(count($data)>0){
                $convertor=$data[0]->value;
            }else{
                $convertor="₹";
            }
            return  $convertor;

        }
        // UTC  Time Convert
        public static function utc_time_convert($time){
            $timezone = 'America/New_York';
            $carbon = Carbon::parse($time);
            $carbon->utc();
            $utcTime = $carbon->toDateTimeString();
            $dateTimeUTC= date('H:i:s', strtotime($utcTime));
            return  $dateTimeUTC;
        }
        // utc to company timezone
        public static function utc_to_originaltime($time,$setting){

            $timezone =$setting['timezone'];
            // dd($timezone);
            // $timezone = 'America/New_York';
            $carbon = Carbon::parse($time, $timezone);
            $carbon->utc();
            $utcTime = $carbon->toDateTimeString();
            $dateTimeUTC= date('H:i:s', strtotime($utcTime));
            return  $dateTimeUTC;
            // $carbon = Carbon::parse('H:i:s', $time, 'America/Hermosillo');
            // $utcTime = $carbon->toDateTimeString();
            // $dateTimeUTC= date('H:i:s', strtotime($utcTime));
            // return  $dateTimeUTC;

        }

        public static function remaining_duration_calculator($end,$id){
           $holidays=DB::table('project_holidays')->where('project_id',$id)->get();
           $project=DB::table('projects')->where('id',$id)->first();
           if($project){
                // $weekends_array=array('MONDAY','TUESDAY','WEDNESDAY','THURSDAY','FRIDAY','SATURDAY','SUNDAY');
                $weekarray=explode(',',$project->non_working_days);
                $excluded_dates =array();

                if(count($holidays)>0){
                    foreach ($holidays as $key => $value) {
                        $excluded_dates [] =Carbon::create($value->date);
                    }
                }
                $final_count = 0;

                $start_date = Carbon::now();
                $end_date = Carbon::create($end);
                $date_range = CarbonPeriod::create($start_date, $end_date);

                foreach ($date_range as $date) {
                    if (!in_array($date->dayOfWeek, $weekarray) && !in_array($date, $excluded_dates)) {
                        $final_count++;
                    }
                }

                return $final_count;

           }else{
                return '0';
           }


        }

}
