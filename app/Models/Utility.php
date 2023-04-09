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
                            $general_template_ending= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/><meta name="viewport" content="width=device-width, initial-scale=1.0"/><meta content="telephone=no" name="format-detection"/><title></title><style type="text/css" data-premailer="ignore">@import url(https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700);</style><style data-premailer="ignore"> @media screen and (max-width: 600px){u+.body{width: 100vw !important;}}a[x-apple-data-detectors]{color: inherit !important;text-decoration: none !important;font-size: inherit !important;font-family: inherit !important;font-weight: inherit !important;line-height: inherit !important;}</style><style>body,table{width:100%}.avatar,.box{-webkit-box-shadow:0 1px 4px rgba(0,0,0,.05)}.h1 a,.h2 a,.h3 a,.h4 a,.h5 a,h1 a,h2 a,h3 a,h4 a,h5 a,pre code{color:inherit}.icon,body,pre code{padding:0}a,img{text-decoration:none}.day,.icon,table.rounded{border-collapse:separate}body{margin:0;background-color:#f5f7fb;font-size:15px;line-height:160%;mso-line-height-rule:exactly;color:#444}body,table,td{font-family:Open Sans,-apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,Helvetica,Arial,sans-serif}table{border-collapse:collapse}table:not(.main){-premailer-cellpadding:0;-premailer-cellspacing:0}.preheader{padding:0;font-size:0;display:none;max-height:0;mso-hide:all;line-height:0;color:transparent;height:0;max-width:0;opacity:0;overflow:hidden;visibility:hidden;width:0}.h1,.h2,h1,h2{line-height:130%}.main{-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}.wrap{width:100%;max-width:640px;text-align:left}.icon,.list-centered,.text-center{text-align:center}.wrap-narrow{max-width:500px}.box{background:#fff;border-radius:3px;box-shadow:0 1px 4px rgba(0,0,0,.05);border:1px solid #f0f0f0}.box+.box,.mt-lg,.my-lg{margin-top:24px}.content,.content-image-text{padding:40px 48px}@media only screen and (max-width:560px){body{font-size:14px!important}.content,.content-image-text{padding:24px!important}}.content-image-text{padding:24px;background-repeat:repeat;vertical-align:bottom;color:#fff;font-weight:400}.content-big,.p-xl{padding:48px}.content-image{height:360px;background-position:center;background-size:cover}.content-image-sm{height:200px}.h1,.h2,.h3,.h4,.h5,h1,h2,h3,h4,h5{font-weight:600;margin:0 0 .5em}.h1,.h2,.h3,h1,h2,h3{font-weight:300}.h1,h1{font-size:28px}.h2,h2{font-size:24px}.h3,h3{font-size:20px;line-height:120%}.icon,img{line-height:100%}.calendar-lg,.h4,h4{font-size:16px}.calendar-md,.h5,h5{font-size:14px}.table th,.table-pre td,pre,pre code{font-size:12px}.hr,hr{border:none;height:1px;background-color:#f0f0f0;margin:32px 0}code,pre{white-space:pre-wrap;border-radius:3px;background:#f5f7fb;word-break:break-word;font-family:Consolas,Monaco,Andale Mono,Ubuntu Mono,monospace;color:#728c96}.chart-bar,.m-0,figure,pre{margin:0}pre{max-width:100%;overflow:auto;padding:8px 12px;-moz-tab-size:3;-o-tab-size:3;tab-size:3}pre code{background:0 0}code{font-weight:400;font-size:13px;padding:.2em .4em}.font-strong,.table th,strong{font-weight:600}a img,img{border:0}.table-pre pre{padding:0 8px;background:0 0}.table-pre td{font-family:Consolas,Monaco,Andale Mono,Ubuntu Mono,monospace;background:#f5f7fb;color:#728c96;padding-top:0;padding-bottom:0}.table-pre .table-pre-line{text-align:right;padding:0 12px;vertical-align:top;color:#9eb0b7;background:#f1f4fa;width:1%}.table-pre .table-pre-line-highlight-red td{background:#fae9e9;color:#cd201f}.table-pre .table-pre-line-highlight-red td pre,.text-red{color:#cd201f}.table-pre .table-pre-line-highlight-green td{background:#eff8e6;color:#5eba00}.table-pre .table-pre-line-highlight-green td pre,.text-green{color:#5eba00}.pt-sm,.py-sm,.table-pre tr:first-child td{padding-top:8px}.pb-sm,.py-sm,.table-pre tr:last-child td{padding-bottom:8px}img{outline:0;vertical-align:baseline;font-size:0}a{color:#467fcf}a:hover{text-decoration:underline}ol,p,ul{margin:0 0 1em}.chart,.row,.table-fixed{table-layout:fixed}.h-100p,.row .row{height:100%}.row-flex{table-layout:auto}.col,.col-mobile,.col-spacer,.table-vtop td,.table-vtop th,.va-top{vertical-align:top}.col-mobile-spacer,.col-spacer,.w-lg{width:24px}.col-mobile-spacer-sm,.col-spacer-sm,.w-md{width:16px}.col-mobile-spacer-xs,.col-spacer-xs,.w-sm{width:8px}.col-hr,.col-mobile-hr{width:1px!important;border-left:16px solid #fff;border-right:16px solid #fff;background:#f0f0f0}.quote,.status{display:inline-block}.table td,.table th{padding:4px 12px}.pl-0,.px-0,.table tr>td:first-child,.table tr>th:first-child{padding-left:0}.pr-0,.px-0,.table tr>td:last-child,.table tr>th:last-child{padding-right:0}.table th{text-transform:uppercase;color:#9eb0b7;padding:0 0 4px}.p-xs,.table-data td,.table-data th{padding:4px}.avatar{border-radius:50%;box-shadow:0 1px 4px rgba(0,0,0,.05)}.alert,.avatar-rounded,.quote,.rounded,.status{border-radius:3px}.status{font-weight:300;vertical-align:-1px;color:#fff;width:12px;height:12px;margin:0 4px 0 0;background-color:#9eb0b7}.quote{background:#fafafa;padding:8px 12px}.btn,.btn-block,.d-block,.icon img{display:block}.list-item>td{padding-top:8px;padding-bottom:8px}.list-md .list-item>td{padding-top:16px;padding-bottom:16px}.border-top,.list-item+.list-item{border-top:1px solid #f0f0f0}.list-item:first-child>td,.pt-0,.py-0{padding-top:0}.list-item:last-child>td,.pb-0,.py-0{padding-bottom:0}.list-centered>a{margin:0 16px}.alert{padding:8px 16px;font-weight:400}.icon{border-radius:50%;background:#f3f6f6;font-weight:300;width:32px;height:32px;font-size:20px}.day-month,.day-weekday{font-weight:400;text-transform:uppercase}.chart-bar-series,.chart-cell{padding:0;margin:0;text-align:left}.icon-md{width:54px;height:54px;font-size:32px}.icon-md.icon-border{border-width:1px}.icon-lg{width:72px;height:72px;font-size:48px}.border-wide,.icon-lg.icon-border{border-width:2px}.icon-lg img{width:40px;height:40px}.icon-border{background:0 0;border:1px solid #f0f0f0}.chart-cell{vertical-align:bottom}.chart-cell-spacer,.w-xs{width:4px}.chart-bar-series{font-size:0;line-height:0;background-color:#9eb0b7}.calendar,.chart-bar-label,.chart-label,.day{text-align:center;line-height:100%}.chart-bar-label,.chart-label{color:#9eb0b7;font-size:12px;padding:6px 0 0}.chart-bar-label{padding:0 0 4px;font-size:10px;color:#444}.chart-percentage{font-size:0;height:16px}.chart-percentage:first-child{border-radius:2px 0 0 2px}.chart-percentage:last-child{border-radius:0 2px 2px 0}.h-sm,.progress{height:8px}.progress td:first-child{border-radius:3px 0 0 3px}.progress td:last-child{border-radius:0 3px 3px 0}.h-xs,.progress-sm{height:4px}.calendar{font-size:11px}.calendar td{padding:1px}.calendar-day{background:#fafafa}.calendar-day.other-month{border-color:transparent;color:#bbc8cd;background:0 0}.calendar-day td{padding:5px 0}.calendar-md .calendar-day td{padding:10px 0}.calendar-lg .calendar-day td{padding:24px 0}.day{width:72px;border-radius:3px;border:1px solid rgba(0,0,0,.1);background:#fff}.day-weekday{color:#9eb0b7;font-size:12px;padding:0 0 4px}.day-number{font-size:32px;padding:8px 0}.day-month{background:#cd201f;border-radius:3px 3px 0 0;color:#fff;font-size:12px;padding:4px 0}.btn,.btn-span{font-size:16px;text-decoration:none;white-space:nowrap;font-weight:600;line-height:100%}.highlight .hll{background-color:#ffc}.highlight .c,.highlight .c1,.highlight .cm{color:#998;font-style:italic}.highlight .err{color:#a61717;background-color:#e3d2d2}.highlight .k,.highlight .kc,.highlight .kd,.highlight .kn,.highlight .kp,.highlight .kr,.highlight .o,.highlight .ow{color:#000;font-weight:700}.highlight .cp,.highlight .cs{color:#999;font-weight:700;font-style:italic}.highlight .gd{color:#000;background-color:#fdd}.highlight .ge{color:#000;font-style:italic}.highlight .gr,.highlight .gt{color:#a00}.highlight .bp,.highlight .gh{color:#999}.highlight .gi{color:#000;background-color:#dfd}.highlight .go{color:#888}.highlight .gp,.highlight .nn{color:#555}.highlight .gs{font-weight:700}.highlight .gu{color:#aaa}.highlight .kt,.highlight .nc{color:#458;font-weight:700}.highlight .il,.highlight .m,.highlight .mf,.highlight .mh,.highlight .mi,.highlight .mo{color:#099}.highlight .s,.highlight .s1,.highlight .s2,.highlight .sb,.highlight .sc,.highlight .sd,.highlight .se,.highlight .sh,.highlight .si,.highlight .sx{color:#d01040}.highlight .na,.highlight .no,.highlight .nv,.highlight .vc,.highlight .vg,.highlight .vi{color:teal}.highlight .nb{color:#0086b3}.highlight .nd{color:#3c5d5d;font-weight:700}.highlight .ni{color:purple}.highlight .ne,.highlight .nf,.highlight .nl{color:#900;font-weight:700}.highlight .nt{color:navy}.highlight .w{color:#bbb}.highlight .sr{color:#009926}.highlight .ss{color:#990073}.btn{padding:12px 32px;border-radius:3px;color:#fff;border:1px solid transparent;-webkit-transition:background-color .3s;transition:background-color .3s}.border-blue,.btn.bg-bordered{border-color:#467fcf}.btn:hover{text-decoration:none}.btn.bg-secondary,.btn.bg-secondary .btn-span,.text-gray,.text-muted{color:#9eb0b7}.btn.bg-bordered{color:#467fcf}.btn.bg-bordered:hover{background-color:#f9fbfe!important}.btn.bg-bordered .btn-span,.text-blue{color:#467fcf}.btn-span{color:#fff}.btn-big{font-size:17px;padding:12px 24px;border-radius:5px;text-transform:none}.badge,.btn-small,.btn-small .btn-span{font-size:12px}.badge,.text-uppercase{text-transform:uppercase}.btn-small{padding:8px;line-height:100%}.badge{border-radius:50px;padding:4px 16px;color:#fff;font-weight:700;background:#bbc8cd}.badge-big,.font-sm{font-size:13px}.badge-big{padding:8px 24px}.bg-white{background-color:#fff;color:#444}.bg-light{background-color:#fafafa}.bg-none{background-color:transparent}.bg-body{background-color:#f5f7fb}.bg-dark{background-color:#222;color:#fff}.text-default{color:#444}.text-muted-light{color:#bbc8cd}.text-muted-dark{color:#728c96}.bg-blue{background-color:#467fcf;color:#fff}a.bg-blue:hover{background-color:#3a77cc!important}.bg-blue-lightest{background-color:#edf2fa}.bg-blue-lighter{background-color:#c8d9f1}.bg-blue-light{background-color:#7ea5dd}.bg-blue-dark{background-color:#3866a6}.bg-blue-darker{background-color:#1c3353;color:#fff}.bg-blue-darkest{background-color:#15263e;color:#fff}.bg-blue-lt,.theme-dark .bg-blue-lt{color:#467fcf!important;background:#c8d9f1!important}.bg-azure{background-color:#45aaf2;color:#fff}a.bg-azure:hover{background-color:#37a3f1!important}.bg-azure-lightest{background-color:#ecf7fe}.bg-azure-lighter{background-color:#c7e6fb}.bg-azure-light{background-color:#7dc4f6}.bg-azure-dark{background-color:#3788c2}.bg-azure-darker{background-color:#1c4461;color:#fff}.bg-azure-darkest{background-color:#153349;color:#fff}.bg-azure-lt,.theme-dark .bg-azure-lt{color:#45aaf2!important;background:#c7e6fb!important}.text-azure{color:#45aaf2}.border-azure{border-color:#45aaf2}.bg-indigo{background-color:#6574cd;color:#fff}a.bg-indigo:hover{background-color:#596ac9!important}.bg-indigo-lightest{background-color:#f0f1fa}.bg-indigo-lighter{background-color:#d1d5f0}.bg-indigo-light{background-color:#939edc}.bg-indigo-dark{background-color:#515da4}.bg-indigo-darker{background-color:#282e52;color:#fff}.bg-indigo-darkest{background-color:#1e233e;color:#fff}.bg-indigo-lt,.theme-dark .bg-indigo-lt{color:#6574cd!important;background:#d1d5f0!important}.text-indigo{color:#6574cd}.border-indigo{border-color:#6574cd}.bg-purple{background-color:#a55eea;color:#fff}a.bg-purple:hover{background-color:#9d50e8!important}.bg-purple-lightest{background-color:#f6effd}.bg-purple-lighter{background-color:#e4cff9}.bg-purple-light{background-color:#c08ef0}.bg-purple-dark{background-color:#844bbb}.bg-purple-darker{background-color:#42265e;color:#fff}.bg-purple-darkest{background-color:#321c46;color:#fff}.bg-purple-lt,.theme-dark .bg-purple-lt{color:#a55eea!important;background:#e4cff9!important}.text-purple{color:#a55eea}.border-purple{border-color:#a55eea}.bg-pink{background-color:#f66d9b;color:#fff}a.bg-pink:hover{background-color:#f55f91!important}.bg-pink-lightest{background-color:#fef0f5}.bg-pink-lighter{background-color:#fcd3e1}.bg-pink-light{background-color:#f999b9}.bg-pink-dark{background-color:#c5577c}.bg-pink-darker{background-color:#622c3e;color:#fff}.bg-pink-darkest{background-color:#4a212f;color:#fff}.bg-pink-lt,.theme-dark .bg-pink-lt{color:#f66d9b!important;background:#fcd3e1!important}.text-pink{color:#f66d9b}.border-pink{border-color:#f66d9b}.bg-red{background-color:#cd201f;color:#fff}a.bg-red:hover{background-color:#c01e1d!important}.bg-red-lightest{background-color:#fae9e9}.bg-red-lighter{background-color:#f0bcbc}.bg-red-light{background-color:#dc6362}.bg-red-dark{background-color:#a41a19}.bg-red-darker{background-color:#520d0c;color:#fff}.bg-red-darkest{background-color:#3e0a09;color:#fff}.bg-red-lt,.theme-dark .bg-red-lt{color:#cd201f!important;background:#f0bcbc!important}.border-red{border-color:#cd201f}.bg-orange{background-color:#fd9644;color:#fff}a.bg-orange:hover{background-color:#fd8e35!important}.bg-orange-lightest{background-color:#fff5ec}.bg-orange-lighter{background-color:#fee0c7}.bg-orange-light{background-color:#feb67c}.bg-orange-dark{background-color:#ca7836}.bg-orange-darker{background-color:#653c1b;color:#fff}.bg-orange-darkest{background-color:#4c2d14;color:#fff}.bg-orange-lt,.theme-dark .bg-orange-lt{color:#fd9644!important;background:#fee0c7!important}.text-orange{color:#fd9644}.border-orange{border-color:#fd9644}.bg-yellow{background-color:#f1c40f;color:#fff}a.bg-yellow:hover{background-color:#e3b90d!important}.bg-yellow-lightest{background-color:#fef9e7}.bg-yellow-lighter{background-color:#fbedb7}.bg-yellow-light{background-color:#f5d657}.bg-yellow-dark{background-color:#c19d0c}.bg-yellow-darker{background-color:#604e06;color:#fff}.bg-yellow-darkest{background-color:#483b05;color:#fff}.bg-yellow-lt,.theme-dark .bg-yellow-lt{color:#f1c40f!important;background:#fbedb7!important}.text-yellow{color:#f1c40f}.border-yellow{border-color:#f1c40f}.bg-lime{background-color:#7bd235;color:#fff}a.bg-lime:hover{background-color:#73cb2d!important}.bg-lime-lightest{background-color:#f2fbeb}.bg-lime-lighter{background-color:#d7f2c2}.bg-lime-light{background-color:#a3e072}.bg-lime-dark{background-color:#62a82a}.bg-lime-darker{background-color:#315415;color:#fff}.bg-lime-darkest{background-color:#253f10;color:#fff}.bg-lime-lt,.theme-dark .bg-lime-lt{color:#7bd235!important;background:#d7f2c2!important}.text-lime{color:#7bd235}.border-lime{border-color:#7bd235}.bg-green{background-color:#5eba00;color:#fff}a.bg-green:hover{background-color:#56ab00!important}.bg-green-lightest{background-color:#eff8e6}.bg-green-lighter{background-color:#cfeab3}.bg-green-light{background-color:#8ecf4d}.bg-green-dark{background-color:#4b9500}.bg-green-darker{background-color:#264a00;color:#fff}.bg-green-darkest{background-color:#1c3800;color:#fff}.bg-green-lt,.theme-dark .bg-green-lt{color:#5eba00!important;background:#cfeab3!important}.border-green{border-color:#5eba00}.bg-teal{background-color:#2bcbba;color:#fff}a.bg-teal:hover{background-color:#28beae!important}.bg-teal-lightest{background-color:#eafaf8}.bg-teal-lighter{background-color:#bfefea}.bg-teal-light{background-color:#6bdbcf}.bg-teal-dark{background-color:#22a295}.bg-teal-darker{background-color:#11514a;color:#fff}.bg-teal-darkest{background-color:#0d3d38;color:#fff}.bg-teal-lt,.theme-dark .bg-teal-lt{color:#2bcbba!important;background:#bfefea!important}.text-teal{color:#2bcbba}.border-teal{border-color:#2bcbba}.bg-cyan{background-color:#17a2b8;color:#fff}a.bg-cyan:hover{background-color:#1596aa!important}.bg-cyan-lightest{background-color:#e8f6f8}.bg-cyan-lighter{background-color:#b9e3ea}.bg-cyan-light{background-color:#5dbecd}.bg-cyan-dark{background-color:#128293}.bg-cyan-darker{background-color:#09414a;color:#fff}.bg-cyan-darkest{background-color:#073137;color:#fff}.bg-cyan-lt,.theme-dark .bg-cyan-lt{color:#17a2b8!important;background:#b9e3ea!important}.text-cyan{color:#17a2b8}.border-cyan{border-color:#17a2b8}.bg-gray{background-color:#9eb0b7;color:#fff}a.bg-gray:hover{background-color:#95a9b0!important}.bg-gray-lightest{background-color:#f5f7f8}.bg-gray-lighter{background-color:#e2e7e9}.bg-gray-light{background-color:#bbc8cd}.bg-gray-dark{background-color:#7e8d92}.bg-gray-darker{background-color:#3f4649;color:#fff}.bg-gray-darkest{background-color:#2f3537;color:#fff}.bg-gray-lt,.theme-dark .bg-gray-lt{color:#9eb0b7!important;background:#e2e7e9!important}.border-gray{border-color:#9eb0b7}.bg-secondary{background-color:#f5f7f8;color:#fff}a.bg-secondary:hover{background-color:#ecf0f2!important}.bg-secondary-lightest{background-color:#fefefe}.bg-secondary-lighter{background-color:#fcfdfd}.bg-secondary-light{background-color:#f8f9fa}.bg-secondary-dark{background-color:#c4c6c6}.bg-secondary-darker{background-color:#626363;color:#fff}.bg-secondary-darkest{background-color:#4a4a4a;color:#fff}.bg-secondary-lt,.theme-dark .bg-secondary-lt{color:#f5f7f8!important;background:#fcfdfd!important}.text-secondary{color:#f5f7f8}.border-secondary{border-color:#f5f7f8}.bg-facebook{background-color:#3b5998;color:#fff}.bg-twitter{background-color:#1da1f2;color:#fff}.bg-google{background-color:#dc4e41;color:#fff}.bg-youtube{background-color:red;color:#fff}.bg-vimeo{background-color:#1ab7ea;color:#fff}.bg-dribbble{background-color:#ea4c89;color:#fff}.bg-github{background-color:#181717;color:#fff}.bg-instagram{background-color:#e4405f;color:#fff}.bg-pinterest{background-color:#bd081c;color:#fff}.bg-vk{background-color:#6383a8;color:#fff}.bg-rss{background-color:orange;color:#fff}.bg-flickr{background-color:#0063dc;color:#fff}.bg-bitbucket{background-color:#0052cc;color:#fff}.text-left{text-align:left}.text-right{text-align:right}.text-justify{text-align:justify}.text-strikethrough{text-decoration:line-through}@media only screen and (max-width:560px){.content-image{height:100px!important}.content-image-text{padding-top:96px!important}.h1,h1{font-size:24px!important}.h2,h2{font-size:20px!important}.h3,h3{font-size:18px!important}.col-hr,.col-spacer{height:24px!important}.col,.col-hr,.col-spacer,.col-spacer-sm,.col-spacer-xs,.row{display:table!important;width:100%!important}.col-hr{border:0!important;width:auto!important;background:0 0!important}.col-spacer{width:100%!important}.col-spacer-sm{height:16px!important}.col-spacer-xs{height:8px!important}.chart-cell-spacer{width:4px!important}.text-mobile-center{text-align:center!important}.d-mobile-none{display:none!important}}.mt-0,.my-0,.text-wrap>:first-child{margin-top:0}.mb-0,.my-0,.text-wrap>:last-child{margin-bottom:0}.va-middle{vertical-align:middle}.va-bottom{vertical-align:bottom}.va-text-bottom{vertical-align:text-bottom}.img-responsive{max-width:100%;height:auto}.img-illustration{max-width:240px;max-height:160px;width:auto;height:auto}.img-hover:hover img{opacity:.64}.circled{border-radius:50%}.rounded-top{border-top-left-radius:3px;border-top-right-radius:3px}.w-1p{width:1%}.w-33p{width:33.3333%}.w-50p{width:50%}.w-100p{width:100%}.w-auto{width:auto}.font-lg{font-size:18px}.font-xl{font-size:21px}.font-normal{font-weight:400}.lh-narrow{line-height:133.33%}.lh-normal{line-height:160%}.lh-1{line-height:100%}.lh-wide{line-height:2200%}.border{border:1px solid #f0f0f0}.border-dark{border-color:#d1d1d1}.border-bottom{border-bottom:1px solid #f0f0f0}.border-left{border-left:1px solid #f0f0f0}.border-right{border-right:1px solid #f0f0f0}.border-dashed{border-style:dashed}.shadow{-webkit-box-shadow:0 1px 4px rgba(0,0,0,.05);box-shadow:0 1px 4px rgba(0,0,0,.05)}.mr-0,.mx-0{margin-right:0}.ml-0,.mx-0{margin-left:0}.m-xs{margin:4px}.mt-xs,.my-xs{margin-top:4px}.mr-xs,.mx-xs{margin-right:4px}.mb-xs,.my-xs{margin-bottom:4px}.ml-xs,.mx-xs{margin-left:4px}.m-sm{margin:8px}.mt-sm,.my-sm{margin-top:8px}.mr-sm,.mx-sm{margin-right:8px}.mb-sm,.my-sm{margin-bottom:8px}.ml-sm,.mx-sm{margin-left:8px}.m-md{margin:16px}.mt-md,.my-md{margin-top:16px}.mr-md,.mx-md{margin-right:16px}.mb-md,.my-md{margin-bottom:16px}.ml-md,.mx-md{margin-left:16px}.m-lg{margin:24px}.mr-lg,.mx-lg{margin-right:24px}.mb-lg,.my-lg{margin-bottom:24px}.ml-lg,.mx-lg{margin-left:24px}.m-xl{margin:48px}.mt-xl,.my-xl{margin-top:48px}.mr-xl,.mx-xl{margin-right:48px}.mb-xl,.my-xl{margin-bottom:48px}.ml-xl,.mx-xl{margin-left:48px}.m-xxl{margin:96px}.mt-xxl,.my-xxl{margin-top:96px}.mr-xxl,.mx-xxl{margin-right:96px}.mb-xxl,.my-xxl{margin-bottom:96px}.ml-xxl,.mx-xxl{margin-left:96px}.p-0{padding:0}.pt-xs,.py-xs{padding-top:4px}.pr-xs,.px-xs{padding-right:4px}.pb-xs,.py-xs{padding-bottom:4px}.pl-xs,.px-xs{padding-left:4px}.p-sm{padding:8px}.pr-sm,.px-sm{padding-right:8px}.pl-sm,.px-sm{padding-left:8px}.p-md{padding:16px}.pt-md,.py-md{padding-top:16px}.pr-md,.px-md{padding-right:16px}.pb-md,.py-md{padding-bottom:16px}.pl-md,.px-md{padding-left:16px}.p-lg{padding:24px}.pt-lg,.py-lg{padding-top:24px}.pr-lg,.px-lg{padding-right:24px}.pb-lg,.py-lg{padding-bottom:24px}.pl-lg,.px-lg{padding-left:24px}.pt-xl,.py-xl{padding-top:48px}.pr-xl,.px-xl{padding-right:48px}.pb-xl,.py-xl{padding-bottom:48px}.pl-xl,.px-xl{padding-left:48px}.p-xxl{padding:96px}.pt-xxl,.py-xxl{padding-top:96px}.pr-xxl,.px-xxl{padding-right:96px}.pb-xxl,.py-xxl{padding-bottom:96px}.pl-xxl,.px-xxl{padding-left:96px}.h-0{height:0}.w-0{width:0}.h-md{height:16px}.h-lg{height:24px}.h-xl{height:48px}.w-xl{width:48px}.h-xxl{height:96px}.w-xxl{width:96px}.theme-dark .bg-body,.theme-dark.bg-body{background:#212936}.theme-dark .box{background:#2b3648;border-color:#2b3648;color:#ddd}.theme-dark .chart-bar-label,.theme-dark .text-default{color:#ddd}.theme-dark .col-hr,.theme-dark .col-mobile-hr{border-color:#2b3648;background-color:#212936}.theme-dark .border,.theme-dark .border-bottom,.theme-dark .border-left,.theme-dark .border-right,.theme-dark .border-secondary,.theme-dark .border-top,.theme-dark .list-item{border-color:#3e495b}.theme-dark .bg-light,.theme-dark .calendar-day,.theme-dark .quote{background-color:#354258}.theme-dark .bg-secondary{background:0 0}.theme-dark a.bg-secondary:hover{background-color:#354258!important}.theme-dark .btn.bg-bordered:hover{background-color:#467fcf!important;color:#fff!important}.theme-dark .btn.bg-bordered:hover .btn-span{color:#fff!important}.theme-dark .bg-blue-lightest{background-color:#2e3d56}.theme-dark .bg-blue-lighter{background-color:#334c71}.theme-dark .bg-blue-light{background-color:#3e69a7}.theme-dark .bg-blue-dark{background-color:#6b99d9}.theme-dark .bg-blue-darker{background-color:#b5ccec;color:#212936}.theme-dark .bg-blue-darkest{background-color:#c8d9f1;color:#212936}.theme-dark .bg-azure-lightest{background-color:#2e4259}.theme-dark .bg-azure-lighter{background-color:#33597b}.theme-dark .bg-azure-light{background-color:#3d87bf}.theme-dark .bg-azure-dark{background-color:#6abbf5}.theme-dark .bg-azure-darker{background-color:#b5ddfa;color:#212936}.theme-dark .bg-azure-darkest{background-color:#c7e6fb;color:#212936}.theme-dark .bg-indigo-lightest{background-color:#313c55}.theme-dark .bg-indigo-lighter{background-color:#3c4970}.theme-dark .bg-indigo-light{background-color:#5461a5}.theme-dark .bg-indigo-dark{background-color:#8490d7}.theme-dark .bg-indigo-darker{background-color:#c1c7eb;color:#212936}.theme-dark .bg-indigo-darkest{background-color:#d1d5f0;color:#212936}.theme-dark .bg-purple-lightest{background-color:#373a58}.theme-dark .bg-purple-lighter{background-color:#504279}.theme-dark .bg-purple-light{background-color:#8052b9}.theme-dark .bg-purple-dark{background-color:#b77eee}.theme-dark .bg-purple-darker{background-color:#dbbff7;color:#212936}.theme-dark .bg-purple-darkest{background-color:#e4cff9;color:#212936}.theme-dark .bg-pink-lightest{background-color:#3f3c50}.theme-dark .bg-pink-lighter{background-color:#684761}.theme-dark .bg-pink-light{background-color:#b95d82}.theme-dark .bg-pink-dark{background-color:#f88aaf}.theme-dark .bg-pink-darker{background-color:#fbc5d7;color:#212936}.theme-dark .bg-pink-darkest{background-color:#fcd3e1;color:#212936}.theme-dark .bg-red-lightest{background-color:#3b3444}.theme-dark .bg-red-lighter{background-color:#5c2f3c}.theme-dark .bg-red-light{background-color:#9c272b}.theme-dark .bg-red-dark{background-color:#d74d4c}.theme-dark .bg-red-darker{background-color:#eba6a5;color:#212936}.theme-dark .bg-red-darkest{background-color:#f0bcbc;color:#212936}.theme-dark .bg-orange-lightest{background-color:#404048}.theme-dark .bg-orange-lighter{background-color:#6a5347}.theme-dark .bg-orange-light{background-color:#be7945}.theme-dark .bg-orange-dark{background-color:#fdab69}.theme-dark .bg-orange-darker{background-color:#fed5b4;color:#212936}.theme-dark .bg-orange-darkest{background-color:#fee0c7;color:#212936}.theme-dark .bg-yellow-lightest{background-color:#3f4442}.theme-dark .bg-yellow-lighter{background-color:#666137}.theme-dark .bg-yellow-light{background-color:#b69920}.theme-dark .bg-yellow-dark{background-color:#f4d03f}.theme-dark .bg-yellow-darker{background-color:#f9e79f;color:#212936}.theme-dark .bg-yellow-darkest{background-color:#fbedb7;color:#212936}.theme-dark .bg-lime-lightest{background-color:#334646}.theme-dark .bg-lime-lighter{background-color:#436542}.theme-dark .bg-lime-light{background-color:#63a33b}.theme-dark .bg-lime-dark{background-color:#95db5d}.theme-dark .bg-lime-darker{background-color:#caedae;color:#212936}.theme-dark .bg-lime-darkest{background-color:#d7f2c2;color:#212936}.theme-dark .bg-green-lightest{background-color:#304341}.theme-dark .bg-green-lighter{background-color:#3a5e32}.theme-dark .bg-green-light{background-color:#4f9216}.theme-dark .bg-green-dark{background-color:#7ec833}.theme-dark .bg-green-darker{background-color:#bfe399;color:#212936}.theme-dark .bg-green-darkest{background-color:#cfeab3;color:#212936}.theme-dark .bg-teal-lightest{background-color:#2b4553}.theme-dark .bg-teal-lighter{background-color:#2b636a}.theme-dark .bg-teal-light{background-color:#2b9e98}.theme-dark .bg-teal-dark{background-color:#55d5c8}.theme-dark .bg-teal-darker{background-color:#aaeae3;color:#212936}.theme-dark .bg-teal-darkest{background-color:#bfefea;color:#212936}.theme-dark .bg-cyan-lightest{background-color:#294153}.theme-dark .bg-cyan-lighter{background-color:#25566a}.theme-dark .bg-cyan-light{background-color:#1d8296}.theme-dark .bg-cyan-dark{background-color:#45b5c6}.theme-dark .bg-cyan-darker{background-color:#a2dae3;color:#212936}.theme-dark .bg-cyan-darkest{background-color:#b9e3ea;color:#212936}.theme-dark .bg-gray-lightest{background-color:#374253}.theme-dark .bg-gray-lighter{background-color:#4e5b69}.theme-dark .bg-gray-light{background-color:#7c8b96}.theme-dark .bg-gray-dark{background-color:#b1c0c5}.theme-dark .bg-gray-darker{background-color:#d8dfe2;color:#212936}.theme-dark .bg-gray-darkest{background-color:#e2e7e9;color:#212936}.theme-dark .bg-secondary-lightest{background-color:#3f495a}.theme-dark .bg-secondary-lighter{background-color:#68707d}.theme-dark .bg-secondary-light{background-color:#b8bdc3}.theme-dark .bg-secondary-dark{background-color:#f7f9f9}.theme-dark .bg-secondary-darker{background-color:#fbfcfc;color:#212936}.theme-dark .bg-secondary-darkest{background-color:#fcfdfd;color:#212936}.theme-dark .table-pre td,.theme-dark .table-pre-line,.theme-dark code,.theme-dark pre{background-color:#354258;color:#fff}.theme-dark .table-pre .table-pre-line-highlight-red td{background-color:#7c2b34}.theme-dark .table-pre .table-pre-line-highlight-red td pre{background-color:transparent;color:#fff}</style></head><body class="bg-body"><center><table class="main bg-body" width="100%" cellspacing="0" cellpadding="0"><tr><td align="center" valign="top"><span class="preheader">This is preheader text. Some clients will show this text as a preview.</span><table class="wrap" cellspacing="0" cellpadding="0"> <tr><td class="p-sm"><table cellpadding="0" cellspacing="0"><tr><td class="py-lg"><table cellspacing="0" cellpadding="0"> <tr> <td> <a href="https://erpdev.mustbuildapp.com/"><img src="https://mustbuilderp.s3.ap-southeast-1.amazonaws.com/uploads/logo/logo-light.png" width="116" height="34" alt=""/></a> </td><td class="text-right"> <a href="https://erpdev.mustbuildapp.com/" class="text-muted-light font-sm"> View online </a> </td></tr></table> </td></tr></table> <div class="main-content"> <table class="box" cellpadding="0" cellspacing="0"> <tr> <td> <table cellpadding="0" cellspacing="0"> <tr> <td class="content pb-0" align="center"> <table class="icon icon-lg bg-green" cellspacing="0" cellpadding="0"> <tr> <td valign="middle" align="center"> <img src="./assets/icons-white-check.png" class=" va-middle" width="40" height="40" alt="check"/> </td></tr></table> </td></tr><tr> <td class="content text-center">'.$content->content.'</td></tr><tr> <td class="content text-center border-top"> <p> Yours sincerely,<br><a href="https://erpdev.mustbuildapp.com/" class="text-default">MustBuild</a> </p><p> <img src="https://mustbuilderp.s3.ap-southeast-1.amazonaws.com/uploads/logo/logo-light.png" width="116" height="54" alt=""/></p></td></tr></table> </td></tr></table> </div><table cellspacing="0" cellpadding="0"> <tr> <td class="py-xl"> <table class="font-sm text-center text-muted" cellspacing="0" cellpadding="0"> <tr> <td align="center" class="pb-md"> <table class="w-auto" cellspacing="0" cellpadding="0"> <tr> <td class="px-sm"> <a href="https://erpdev.mustbuildapp.com/"> <img src="./assets/icons-gray-social-facebook-square.png" class=" va-middle" width="24" height="24" alt="social-facebook-square"/> </a> </td><td class="px-sm"> <a href="https://erpdev.mustbuildapp.com/"> <img src="./assets/icons-gray-social-twitter.png" class=" va-middle" width="24" height="24" alt="social-twitter"/> </a> </td><td class="px-sm"> <a href="https://erpdev.mustbuildapp.com/"> <img src="./assets/icons-gray-social-github.png" class=" va-middle" width="24" height="24" alt="social-github"/> </a> </td><td class="px-sm"> <a href="https://erpdev.mustbuildapp.com/"> <img src="./assets/icons-gray-social-youtube.png" class=" va-middle" width="24" height="24" alt="social-youtube"/> </a> </td><td class="px-sm"> <a href="https://erpdev.mustbuildapp.com/"> <img src="./assets/icons-gray-social-pinterest.png" class=" va-middle" width="24" height="24" alt="social-pinterest"/> </a> </td><td class="px-sm"> <a href="https://erpdev.mustbuildapp.com/"> <img src="./assets/icons-gray-social-instagram.png" class=" va-middle" width="24" height="24" alt="social-instagram"/> </a> </td></tr></table> </td></tr><tr> <td class="px-lg"> If you have any questions, feel free to message us at <a href="mailto:support@tabler.io" class="text-muted">support@tabler.io</a>. </td></tr><tr> <td class="pt-md"> You are receiving this email because you have bought or downloaded one of the Tabler products. <a href="https://erpdev.mustbuildapp.com/" class="text-muted">Unsubscribe</a> </td></tr></table> </td></tr></table> </td></tr></table> </td></tr></table> </center></body></html>';

                                                    $content->content=$general_template_ending;

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

                if($validator->fails()){

                    $res = [
                        'flag' => 0,
                        'msg' => $validator->messages()->first(),
                    ];

                    return $res;
                } else {

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

}
