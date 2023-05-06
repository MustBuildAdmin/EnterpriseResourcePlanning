<?php

namespace App\Http\Controllers;

use App\Mail\EmailTest;
use App\Mail\TestMail;
use App\Models\EmailTemplate;
use App\Models\ExperienceCertificate;
use App\Models\GenerateOfferLetter;
use App\Models\IpRestrict;
use App\Models\JoiningLetter;
use App\Models\User;
use App\Models\NOC;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Cookie;
use Artisan;


class SystemController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('manage system settings'))
        {
            $settings = Utility::settings();
            $admin_payment_setting = Utility::getAdminPaymentSetting();
            return view('settings.index', compact('settings','admin_payment_setting'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function store(Request $request)
    {

        if(\Auth::user()->can('manage system settings'))
        {
            if($request->logo_dark)
            {


                $logoName = 'logo-dark.png';
                $dir = 'uploads/logo';
                $validation =[
                    'mimes:'.'png',
                    'max:'.'20480',
                ];
                $path = Utility::upload_file($request,'logo_dark',$logoName,$dir,[]);
            //    dd($path);
                if($path['flag'] == 1){
                    $logo = $path['url'];
                }else{
                    return redirect()->back()->with('error', __($path['msg']));
                }
            }

//                $path     = $request->file('logo_dark')->storeAs('uploads/logo/', $logoName);
//
//                \DB::insert(
//                    'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', [
//                                                                                                                                                 $logoName,
//                                                                                                                                                 'company_logo_dark',
//                                                                                                                                                 \Auth::user()->creatorId(),
//                                                                                                                                             ]
//                );
//
//
//            }

            if($request->logo_light)
            {

                $logoName = 'logo-light.png';

                $dir = 'uploads/logo';
                $validation =[
                    'mimes:'.'png',
                    'max:'.'20480',
                ];
                $path = Utility::upload_file($request,'logo_light',$logoName,$dir,$validation);
                if($path['flag'] == 1){
                    $logo = $path['url'];
                }else{
                    return redirect()->back()->with('error', __($path['msg']));
                }
            }
//                $path            = $request->file('logo_light')->storeAs('uploads/logo/', $logoName);
//
//                \DB::insert(
//                    'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', [
//                                                                                                                                                 $logoName,
//                                                                                                                                                 'company_logo_light',
//                                                                                                                                                 \Auth::user()->creatorId(),
//                                                                                                                                             ]
//                );
//            }


            if($request->favicon)
            {
//                $request->validate(
//                    [
//                        'favicon' => 'image|mimes:png|max:20480',
//                    ]
//                );
                $favicon = 'favicon.png';
                $dir = 'uploads/logo';
                $validation =[
                    'mimes:'.'png',
                    'max:'.'20480',
                ];

                $path = Utility::upload_file($request,'favicon',$favicon,$dir,$validation);
                if($path['flag'] == 1){
                    $favicon = $path['url'];
                }else{
                    return redirect()->back()->with('error', __($path['msg']));
                }
            }
//                $path    = $request->file('favicon')->storeAs('uploads/logo/', $favicon);
//
//                \DB::insert(
//                    'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', [
//                                                                                                                                                 $favicon,
//                                                                                                                                                 'company_favicon',
//                                                                                                                                                 \Auth::user()->creatorId(),
//                                                                                                                                             ]
//                );
//            }


//            $arrEnv = [
//                'SITE_RTL' => !isset($request->SITE_RTL) ? 'off' : 'on',
//                'THEME_COLOR' => $request->color,
//            ];
//            Utility::setEnvironmentValue($arrEnv);
            $settings = Utility::settings();

            if(!empty($request->title_text) || !empty($request->color)   || !empty($request->SITE_RTL)  || !empty($request->footer_text) || !empty($request->default_language) || isset($request->display_landing_page)|| isset($request->gdpr_cookie) || isset($request->enable_signup) || isset($request->color) || !empty($request->cust_theme_bg) || !empty($request->cust_darklayout))
            {
                $post = $request->all();

                $SITE_RTL = $request->has('SITE_RTL') ? $request-> SITE_RTL : 'off';
                $post['SITE_RTL'] = $SITE_RTL;

                if(!isset($request->display_landing_page))
                {
                    $post['display_landing_page'] = 'off';
                }
                if(!isset($request->gdpr_cookie))
                {
                    $post['gdpr_cookie'] = 'off';
                }
                if(!isset($request->enable_signup))
                {
                    $post['enable_signup'] = 'off';
                }
//                if(!isset($request->footer_text))
//                {
//                    $post['footer_text'] = '';
//                }

                if(!isset($request->cust_theme_bg))
                {
                    $cust_theme_bg         = (!empty($request->cust_theme_bg)) ? 'on' : 'off';
                    $post['cust_theme_bg'] = $cust_theme_bg;
                }
                if(!isset($request->cust_darklayout))
                {

                    $cust_darklayout         = (!empty($request->cust_darklayout)) ? 'on' : 'off';
                    $post['cust_darklayout'] = $cust_darklayout;
                }

                unset($post['_token'], $post['company_logo_dark'], $post['company_logo_light'], $post['company_favicon']);



                foreach($post as $key => $data)
                {
                    if(in_array($key, array_keys($settings)))
                    {
                        \DB::insert(
                            'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', [
                                                                                                                                                         $data,
                                                                                                                                                         $key,
                                                                                                                                                         \Auth::user()->creatorId(),
                                                                                                                                                     ]
                        );
                    }
                }
            }

            return redirect()->back()->with('success', 'System Setting successfully updated.');
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function saveEmailSettings(Request $request)
    {
        if(\Auth::user()->can('manage system settings'))
        {
            $request->validate(
                [
                    'mail_driver' => 'required|string|max:255',
                    'mail_host' => 'required|string|max:255',
                    'mail_port' => 'required|string|max:255',
                    'mail_username' => 'required|string|max:255',
                    'mail_password' => 'required|string|max:255',
                    'mail_encryption' => 'required|string|max:255',
                    'mail_from_address' => 'required|string|max:255',
                    'mail_from_name' => 'required|string|max:255',
                ]
            );

            $arrEnv = [
                'MAIL_DRIVER' => $request->mail_driver,
                'MAIL_HOST' => $request->mail_host,
                'MAIL_PORT' => $request->mail_port,
                'MAIL_USERNAME' => $request->mail_username,
                'MAIL_PASSWORD' => $request->mail_password,
                'MAIL_ENCRYPTION' => $request->mail_encryption,
                'MAIL_FROM_NAME' => $request->mail_from_name,
                'MAIL_FROM_ADDRESS' => $request->mail_from_address,
            ];
            Utility::setEnvironmentValue($arrEnv);

            return redirect()->back()->with('success', __('Setting successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }

    }

    public function saveCompanySettings(Request $request)
    {

        if(\Auth::user()->can('manage company settings'))
        {
            $user = \Auth::user();
            $request->validate(
                [
                    'company_name' => 'required|string|max:255',
                    'company_email' => 'required',
                    'company_email_from_name' => 'required|string',
                    // 'site_currency' => 'required',
                ]
            );
            $post = $request->all();
            unset($post['_token']);
            $settings = Utility::settings();

            foreach($post as $key => $data)
            {
                if(in_array($key, array_keys($settings)))
                {
                    \DB::insert(
                        'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', [
                                                                                                                                                     $data,
                                                                                                                                                     $key,
                                                                                                                                                     \Auth::user()->creatorId(),
                                                                                                                                                 ]
                    );
                }
            }
            $arrEnv = [
                'TIMEZONE' => $request->timezone,
            ];

            Utility::setEnvironmentValue($arrEnv);

            return redirect()->back()->with('success', __('Setting successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }
    

    public function savePaymentSettings(Request $request)
    {




        if(\Auth::user()->can('manage stripe settings'))
        {
            //dd($request);

            $validator = \Validator::make(
                $request->all(), [
                                   'currency' => 'required|string|max:255',
                                   'currency_symbol' => 'required|string|max:255',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $arrEnv = [
                'CURRENCY_SYMBOL' => $request->currency_symbol,
                'CURRENCY' => $request->currency,

            ];

            Utility::setEnvironmentValue($arrEnv);

            self::adminPaymentSettings($request);

            return redirect()->back()->with('success', __('Payment setting successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function saveSystemSettings(Request $request)
    {

        if(\Auth::user()->can('manage company settings'))
        {
            $user = \Auth::user();
            $request->validate(
                [
                    'site_currency' => 'required',
                ]
            );
            $post = $request->all();

            unset($post['_token']);

            if(!isset($post['shipping_display']))
            {
                $post['shipping_display'] = 'off';
            }

            $settings = Utility::settings();


            foreach($post as $key => $data)
            {
                if(in_array($key, array_keys($settings)))
                {
                    \DB::insert(
                        'insert into settings (`value`, `name`,`created_by`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', [
                                                                                                                                                                                     $data,
                                                                                                                                                                                     $key,
                                                                                                                                                                                     \Auth::user()->creatorId(),
                                                                                                                                                                                     date('Y-m-d H:i:s'),
                                                                                                                                                                                     date('Y-m-d H:i:s'),
                                                                                                                                                                                 ]
                    );
                }
            }

            return redirect()->back()->with('success', __('Setting successfully updated.'));

        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function saveZoomSettings(Request $request)
    {
        $post = $request->all();
        unset($post['_token']);
        $created_by = \Auth::user()->creatorId();
        foreach($post as $key => $data)
        {
            \DB::insert(
                'insert into settings (`value`, `name`,`created_by`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', [
                                                                                                                                                                             $data,
                                                                                                                                                                             $key,
                                                                                                                                                                             $created_by,
                                                                                                                                                                             date('Y-m-d H:i:s'),
                                                                                                                                                                             date('Y-m-d H:i:s'),
                                                                                                                                                                         ]
            );
        }
        return redirect()->back()->with('success', __('Setting added successfully saved.'));
    }

    public function saveBusinessSettings(Request $request)
    {

        if(\Auth::user()->can('manage business settings'))
        {
            $post = $request->all();

            $user = \Auth::user();
            if($request->company_logo_dark)
            {

//                $request->validate(
//                    [
//                        'company_logo_dark' => 'image|mimes:png|max:20480',
//                    ]
//
//                );
                $validation =[
                    'mimes:'.'png',
                    'max:'.'20480',
                ];

//                $logoName     = $user->id . '-logo-dark.png';
//                $path         = $request->file('company_logo_dark')->storeAs('uploads/logo/', $logoName);
//                $company_logo = !empty($request->company_logo_dark) ? $logoName : 'logo-dark.png';

                $logoName = 'logo-dark.png';
                $dir = 'uploads/logo';
                $path = Utility::upload_file($request,'company_logo_dark',$logoName,$dir,$validation);
                if($path['flag'] == 1){
                    $logo = $path['url'];
                }else{
                    return redirect()->back()->with('error', __($path['msg']));
                }

                \DB::insert(
                    'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', [
                                                                                                                                                 $logoName,
                                                                                                                                                 'company_logo_dark',
                                                                                                                                                 \Auth::user()->creatorId(),
                                                                                                                                             ]
                );
            }


            if($request->company_logo_light)
            {
//                $request->validate(
//                    [
//                        'company_logo_light' => 'image|mimes:png|max:20480',
//                    ]
//                );
//                $logoName     = $user->id . '-logo-light.png';
//                $path         = $request->file('company_logo_light')->storeAs('uploads/logo/', $logoName);
//                $company_logo = !empty($request->company_logo_light) ? $logoName : 'logo-light.png';

                $validation =[
                    'mimes:'.'png',
                    'max:'.'20480',
                ];
                $logoName = 'logo-light.png';
                $dir = 'uploads/logo';
                $path = Utility::upload_file($request,'company_logo_light',$logoName,$dir,$validation);
                if($path['flag'] == 1){
                    $logo = $path['url'];
                }else{
                    return redirect()->back()->with('error', __($path['msg']));
                }


                \DB::insert(
                    'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', [
                                                                                                                                                 $logoName,
                                                                                                                                                 'company_logo_light',
                                                                                                                                                 \Auth::user()->creatorId(),
                                                                                                                                             ]
                );
            }

            if($request->company_favicon)
            {
//                $request->validate(
//                    [
//                        'company_favicon' => 'image|mimes:png|max:20480',
//                    ]
//                );
//                $favicon = $user->id . '_favicon.png';
//                $path    = $request->file('company_favicon')->storeAs('uploads/logo/', $favicon);
//
//                $company_favicon = !empty($request->favicon) ? $favicon : 'favicon.png';

                $validation =[
                    'mimes:'.'png',
                    'max:'.'20480',
                ];

                $favicon = 'favicon.png';
                $dir = 'uploads/logo/';
                $path = Utility::upload_file($request,'company_favicon',$favicon,$dir,$validation);
                if($path['flag'] == 1){
//                    $favicon = $path['url'];
                }else{
                    return redirect()->back()->with('error', __($path['msg']));
                }



                \DB::insert(
                    'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', [
                                                                                                                                                 $favicon,
                                                                                                                                                 'company_favicon',
                                                                                                                                                 \Auth::user()->creatorId(),
                                                                                                                                             ]
                );
            }

            $settings = Utility::settings();


                if(!empty($request->title_text) || !empty($request->color) || !empty($request->cust_theme_bg) || !empty($request->cust_darklayout))

                {

                    $SITE_RTL = $request->has('SITE_RTL') ? $request-> SITE_RTL : 'off';
                    $post['SITE_RTL'] = $SITE_RTL;

                if(!isset($request->cust_theme_bg))
                {
                    $cust_theme_bg         = (!empty($request->cust_theme_bg)) ? 'on' : 'off';
                    $post['cust_theme_bg'] = $cust_theme_bg;
                }
                if(!isset($request->cust_darklayout))
                {

                    $cust_darklayout         = (!empty($request->cust_darklayout)) ? 'on' : 'off';
                    $post['cust_darklayout'] = $cust_darklayout;
                }

                unset($post['_token'], $post['company_logo_dark'], $post['company_logo_light'], $post['company_favicon']);
                foreach($post as $key => $data)
                {
                    if(in_array($key, array_keys($settings)))
                    {

                        \DB::insert(
                            'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', [
                                                                                                                                                         $data,
                                                                                                                                                         $key,
                                                                                                                                                         \Auth::user()->creatorId(),
                                                                                                                                                     ]
                        );
                    }
                }
            }

            return redirect()->back()->with('success', 'System Setting successfully updated.');
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }
    public function emailsettings(Request $request){
        $EmailTemplates = EmailTemplate::all();
        return view('settings.emailsettings', compact('EmailTemplates'));

    }
    public function companysettings(Request $request){
        $settings                = Utility::settings();
        $timezones               = config('timezones');
        $country=Utility::getcountry();
        return view('settings.company_settings', compact('country','settings','timezones'));

    }
    public function systemsettings(Request $request){
        $settings                = Utility::settings();
        $currency = DB::table('currency')->get();

        return view('settings.systemsettings', compact('settings','currency'));

    }
    public function companyIndex(Request $request )
    {
        if(\Auth::user()->can('manage company settings'))
        {

            if($request->offerlangs){
                $offerlang = $request->offerlangs;
            }else{
                $offerlang = "en";
            }
            if($request->joininglangs){
                $joininglang = $request->joininglangs;
            }else{
                $joininglang = "en";
            }
            if($request->explangs){
                $explang = $request->explangs;
            }else{
                $explang = "en";
            }
            if($request->noclangs){
                $noclang = $request->noclangs;
            }else{
                $noclang = "en";
            }


            $settings                = Utility::settings();
            $timezones               = config('timezones');
            $company_payment_setting = Utility::getCompanyPaymentSetting(\Auth::user()->creatorId());

            $EmailTemplates = EmailTemplate::all();
            $ips = IpRestrict::where('created_by', \Auth::user()->creatorId())->get();
            // $languages = Utility::languages();

            //offer letter
            $Offerletter=GenerateOfferLetter::all();
            $currOfferletterLang = GenerateOfferLetter::where('created_by',  \Auth::user()->id)->where('lang', $offerlang)->first();

            //joining letter
            $Joiningletter=JoiningLetter::all();
            $currjoiningletterLang = JoiningLetter::where('created_by',  \Auth::user()->id)->where('lang', $joininglang)->first();

            //Experience Certificate
            $experience_certificate=ExperienceCertificate::all();
            $curr_exp_cetificate_Lang = ExperienceCertificate::where('created_by',  \Auth::user()->id)->where('lang', $explang)->first();

            //NOC
            $noc_certificate=NOC::all();
            $currnocLang = NOC::where('created_by',  \Auth::user()->id)->where('lang', $noclang)->first();
            $country=Utility::getcountry();
            return view('settings.company', compact('settings','country','company_payment_setting','timezones', 'ips','EmailTemplates','currOfferletterLang','Offerletter','offerlang','Joiningletter','currjoiningletterLang','joininglang','experience_certificate','curr_exp_cetificate_Lang','explang','noc_certificate','currnocLang','noclang'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function companyIndex1(Request $request )
    {
        if(\Auth::user()->can('manage company settings'))
        {

            if($request->offerlangs){
                $offerlang = $request->offerlangs;
            }else{
                $offerlang = "en";
            }
            if($request->joininglangs){
                $joininglang = $request->joininglangs;
            }else{
                $joininglang = "en";
            }
            if($request->explangs){
                $explang = $request->explangs;
            }else{
                $explang = "en";
            }
            if($request->noclangs){
                $noclang = $request->noclangs;
            }else{
                $noclang = "en";
            }


            $settings                = Utility::settings();
            $get_user=User::where('id',\Auth::user()->id)->first();
           
            $timezones               = config('timezones');
            $company_payment_setting = Utility::getCompanyPaymentSetting(\Auth::user()->creatorId());

            $EmailTemplates = EmailTemplate::all();
            $ips = IpRestrict::where('created_by', \Auth::user()->creatorId())->get();
            // $languages = Utility::languages();

            //offer letter
            $Offerletter=GenerateOfferLetter::all();
            $currOfferletterLang = GenerateOfferLetter::where('created_by',  \Auth::user()->id)->where('lang', $offerlang)->first();

            //joining letter
            $Joiningletter=JoiningLetter::all();
            $currjoiningletterLang = JoiningLetter::where('created_by',  \Auth::user()->id)->where('lang', $joininglang)->first();

            //Experience Certificate
            $experience_certificate=ExperienceCertificate::all();
            $curr_exp_cetificate_Lang = ExperienceCertificate::where('created_by',  \Auth::user()->id)->where('lang', $explang)->first();

            //NOC
            $noc_certificate=NOC::all();
            $currnocLang = NOC::where('created_by',  \Auth::user()->id)->where('lang', $noclang)->first();
            $country=Utility::getcountry();
            $currency = DB::table('currency')->get();


            return view('settings.companysettings', compact('settings','country','company_payment_setting','timezones', 'ips','EmailTemplates','currOfferletterLang','Offerletter','offerlang','Joiningletter','currjoiningletterLang','joininglang','experience_certificate','curr_exp_cetificate_Lang','explang','noc_certificate','currnocLang','noclang','currency'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function saveCompanyPaymentSettings(Request $request)
    {

        if(isset($request->is_stripe_enabled) && $request->is_stripe_enabled == 'on')
        {

            $request->validate(
                [
                    'stripe_key' => 'required|string|max:255',
                    'stripe_secret' => 'required|string|max:255',
                ]
            );

            $post['is_stripe_enabled'] = $request->is_stripe_enabled;
            $post['stripe_secret']     = $request->stripe_secret;
            $post['stripe_key']        = $request->stripe_key;
        }

        else
        {
            $post['is_stripe_enabled'] = 'off';
        }

        if(isset($request->is_paypal_enabled) && $request->is_paypal_enabled == 'on')
        {
            $request->validate(
                [
                    'paypal_mode' => 'required',
                    'paypal_client_id' => 'required',
                    'paypal_secret_key' => 'required',
                ]
            );

            $post['is_paypal_enabled'] = $request->is_paypal_enabled;
            $post['paypal_mode']       = $request->paypal_mode;
            $post['paypal_client_id']  = $request->paypal_client_id;
            $post['paypal_secret_key'] = $request->paypal_secret_key;
        }
        else
        {
            $post['is_paypal_enabled'] = 'off';
        }

        if(isset($request->is_paystack_enabled) && $request->is_paystack_enabled == 'on')
        {
            $request->validate(
                [
                    'paystack_public_key' => 'required|string',
                    'paystack_secret_key' => 'required|string',
                ]
            );
            $post['is_paystack_enabled'] = $request->is_paystack_enabled;
            $post['paystack_public_key'] = $request->paystack_public_key;
            $post['paystack_secret_key'] = $request->paystack_secret_key;
        }
        else
        {
            $post['is_paystack_enabled'] = 'off';
        }

        if(isset($request->is_flutterwave_enabled) && $request->is_flutterwave_enabled == 'on')
        {
            $request->validate(
                [
                    'flutterwave_public_key' => 'required|string',
                    'flutterwave_secret_key' => 'required|string',
                ]
            );
            $post['is_flutterwave_enabled'] = $request->is_flutterwave_enabled;
            $post['flutterwave_public_key'] = $request->flutterwave_public_key;
            $post['flutterwave_secret_key'] = $request->flutterwave_secret_key;
        }
        else
        {
            $post['is_flutterwave_enabled'] = 'off';
        }
        if(isset($request->is_razorpay_enabled) && $request->is_razorpay_enabled == 'on')
        {
            $request->validate(
                [
                    'razorpay_public_key' => 'required|string',
                    'razorpay_secret_key' => 'required|string',
                ]
            );
            $post['is_razorpay_enabled'] = $request->is_razorpay_enabled;
            $post['razorpay_public_key'] = $request->razorpay_public_key;
            $post['razorpay_secret_key'] = $request->razorpay_secret_key;
        }
        else
        {
            $post['is_razorpay_enabled'] = 'off';
        }

        if(isset($request->is_mercado_enabled) && $request->is_mercado_enabled == 'on')
        {
            $request->validate(
                [
                    'mercado_access_token' => 'required|string',
                ]
            );
            $post['is_mercado_enabled'] = $request->is_mercado_enabled;
            $post['mercado_access_token']     = $request->mercado_access_token;
            $post['mercado_mode'] = $request->mercado_mode;
        }
        else
        {
            $post['is_mercado_enabled'] = 'off';
        }

        if(isset($request->is_paytm_enabled) && $request->is_paytm_enabled == 'on')
        {
            $request->validate(
                [
                    'paytm_mode' => 'required',
                    'paytm_merchant_id' => 'required|string',
                    'paytm_merchant_key' => 'required|string',
                    'paytm_industry_type' => 'required|string',
                ]
            );
            $post['is_paytm_enabled']    = $request->is_paytm_enabled;
            $post['paytm_mode']          = $request->paytm_mode;
            $post['paytm_merchant_id']   = $request->paytm_merchant_id;
            $post['paytm_merchant_key']  = $request->paytm_merchant_key;
            $post['paytm_industry_type'] = $request->paytm_industry_type;
        }
        else
        {
            $post['is_paytm_enabled'] = 'off';
        }
        if(isset($request->is_mollie_enabled) && $request->is_mollie_enabled == 'on')
        {
            $request->validate(
                [
                    'mollie_api_key' => 'required|string',
                    'mollie_profile_id' => 'required|string',
                    'mollie_partner_id' => 'required',
                ]
            );
            $post['is_mollie_enabled'] = $request->is_mollie_enabled;
            $post['mollie_api_key']    = $request->mollie_api_key;
            $post['mollie_profile_id'] = $request->mollie_profile_id;
            $post['mollie_partner_id'] = $request->mollie_partner_id;
        }
        else
        {
            $post['is_mollie_enabled'] = 'off';
        }

        if(isset($request->is_skrill_enabled) && $request->is_skrill_enabled == 'on')
        {
            $request->validate(
                [
                    'skrill_email' => 'required|email',
                ]
            );
            $post['is_skrill_enabled'] = $request->is_skrill_enabled;
            $post['skrill_email']      = $request->skrill_email;
        }
        else
        {
            $post['is_skrill_enabled'] = 'off';
        }

        if(isset($request->is_coingate_enabled) && $request->is_coingate_enabled == 'on')
        {
            $request->validate(
                [
                    'coingate_mode' => 'required|string',
                    'coingate_auth_token' => 'required|string',
                ]
            );

            $post['is_coingate_enabled'] = $request->is_coingate_enabled;
            $post['coingate_mode']       = $request->coingate_mode;
            $post['coingate_auth_token'] = $request->coingate_auth_token;
        }
        else
        {
            $post['is_coingate_enabled'] = 'off';
        }

        //save paymentwall Detail
        if(isset($request->is_paymentwall_enabled) && $request->is_paymentwall_enabled == 'on')
        {
            //            dd('a');
            $request->validate(
                [
                    'paymentwall_public_key' => 'required|string',
                    'paymentwall_secret_key' => 'required|string',
                ]
            );
            $post['is_paymentwall_enabled'] = $request->is_paymentwall_enabled;
            $post['paymentwall_public_key'] = $request->paymentwall_public_key;
            $post['paymentwall_secret_key'] = $request->paymentwall_secret_key;
        }
        else
        {
            // dd('b');
            $post['is_paymentwall_enabled'] = 'off';
        }
        //  dd($post);

        foreach($post as $key => $data)
        {

            $arr = [
                $data,
                $key,
                \Auth::user()->id,
            ];
            \DB::insert(
                'insert into company_payment_settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', $arr
            );

        }

        return redirect()->back()->with('success', __('Payment setting successfully updated.'));
    }

    public function testMail(Request $request)
    {
//        $user = \Auth::user();
        $data                      = [];
        $data['mail_driver']       = $request->mail_driver;
        $data['mail_host']         = $request->mail_host;
        $data['mail_port']         = $request->mail_port;
        $data['mail_username']     = $request->mail_username;
        $data['mail_password']     = $request->mail_password;
        $data['mail_encryption']   = $request->mail_encryption;
        $data['mail_from_address'] = $request->mail_from_address;
        $data['mail_from_name']    = $request->mail_from_name;

        return view('settings.test_mail', compact('data'));
    }

    public function testSendMail(Request $request)
    {

        $validator = \Validator::make(
            $request->all(), [
                'email' => 'required|email',
                'mail_driver' => 'required',
                'mail_host' => 'required',
                'mail_port' => 'required',
                'mail_username' => 'required',
                'mail_password' => 'required',
                'mail_from_address' => 'required',
                'mail_from_name' => 'required',
            ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();
            return response()->json(
                [
                    'is_success' => false,
                    'message' => $messages->first()
                ]
            );
            // return redirect()->back()->with('error', $messages->first());
        }

        try
        {
            config(
                [
                    'mail.driver' => $request->mail_driver,
                    'mail.host' => $request->mail_host,
                    'mail.port' => $request->mail_port,
                    'mail.encryption' => $request->mail_encryption,
                    'mail.username' => $request->mail_username,
                    'mail.password' => $request->mail_password,
                    'mail.from.address' => $request->mail_from_address,
                    'mail.from.name' => $request->mail_from_name,
                ]
            );
            Mail::to($request->email)->send(new TestMail());
        }
        catch(\Exception $e)
        {
            return response()->json(
                [
                    'success' => false,
                    'message' => $e->getMessage(),
                ]
            );
        }

        return response()->json(
            [
                'success' => true,
                'message' => __('Email send Successfully'),
            ]
        );
    }



//    public function testSendMail(Request $request)
//    {
//        $validator = \Validator::make($request->all(), ['email' => 'required|email']);
//        if($validator->fails())
//        {
//            $messages = $validator->getMessageBag();
//
//            return redirect()->back()->with('error', $messages->first());
//        }
//
//        try
//        {
//            Mail::to($request->email)->send(new TestMail());
//        }
//        catch(\Exception $e)
//        {
//
//            $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
//        }
//
//        return redirect()->back()->with('success', __('Email send Successfully.') . ((isset($smtp_error)) ? '<br> <span class="text-danger">' . $smtp_error . '</span>' : ''));
//
//    }



    public function printIndex()
    {
        if(\Auth::user()->can('manage print settings'))
        {
            $settings = Utility::settings();

            return view('accounting.settings.print', compact('settings'));
            // return view('settings.print', compact('settings'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function posPrintIndex()
    {
        if(\Auth::user()->can('manage print settings'))
        {
            $settings = Utility::settings();

            return view('settings.pos', compact('settings'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }


    public function adminPaymentSettings($request)
    {

        if(isset($request->is_stripe_enabled) && $request->is_stripe_enabled == 'on')
        {


            $request->validate(
                [
                    'stripe_key' => 'required|string|max:255',
                    'stripe_secret' => 'required|string|max:255',
                ]
            );

            $post['is_stripe_enabled'] = $request->is_stripe_enabled;
            $post['stripe_secret']     = $request->stripe_secret;
            $post['stripe_key']        = $request->stripe_key;
        }

        else
        {
            $post['is_stripe_enabled'] = 'off';
        }

        if(isset($request->is_paypal_enabled) && $request->is_paypal_enabled == 'on')
        {
            $request->validate(
                [
                    'paypal_mode' => 'required',
                    'paypal_client_id' => 'required',
                    'paypal_secret_key' => 'required',
                ]
            );

            $post['is_paypal_enabled'] = $request->is_paypal_enabled;
            $post['paypal_mode']       = $request->paypal_mode;
            $post['paypal_client_id']  = $request->paypal_client_id;
            $post['paypal_secret_key'] = $request->paypal_secret_key;
        }
        else
        {
            $post['is_paypal_enabled'] = 'off';
        }

        if(isset($request->is_paystack_enabled) && $request->is_paystack_enabled == 'on')
        {
            $request->validate(
                [
                    'paystack_public_key' => 'required|string',
                    'paystack_secret_key' => 'required|string',
                ]
            );
            $post['is_paystack_enabled'] = $request->is_paystack_enabled;
            $post['paystack_public_key'] = $request->paystack_public_key;
            $post['paystack_secret_key'] = $request->paystack_secret_key;
        }
        else
        {
            $post['is_paystack_enabled'] = 'off';
        }

        if(isset($request->is_flutterwave_enabled) && $request->is_flutterwave_enabled == 'on')
        {
            $request->validate(
                [
                    'flutterwave_public_key' => 'required|string',
                    'flutterwave_secret_key' => 'required|string',
                ]
            );
            $post['is_flutterwave_enabled'] = $request->is_flutterwave_enabled;
            $post['flutterwave_public_key'] = $request->flutterwave_public_key;
            $post['flutterwave_secret_key'] = $request->flutterwave_secret_key;
        }
        else
        {
            $post['is_flutterwave_enabled'] = 'off';
        }
        if(isset($request->is_razorpay_enabled) && $request->is_razorpay_enabled == 'on')
        {
            $request->validate(
                [
                    'razorpay_public_key' => 'required|string',
                    'razorpay_secret_key' => 'required|string',
                ]
            );
            $post['is_razorpay_enabled'] = $request->is_razorpay_enabled;
            $post['razorpay_public_key'] = $request->razorpay_public_key;
            $post['razorpay_secret_key'] = $request->razorpay_secret_key;
        }
        else
        {
            $post['is_razorpay_enabled'] = 'off';
        }

        if(isset($request->is_mercado_enabled) && $request->is_mercado_enabled == 'on')
        {
            $request->validate(
                [
                    'mercado_access_token' => 'required|string',
                ]
            );
            $post['is_mercado_enabled'] = $request->is_mercado_enabled;
            $post['mercado_access_token']     = $request->mercado_access_token;
            $post['mercado_mode'] = $request->mercado_mode;
        }
        else
        {
            $post['is_mercado_enabled'] = 'off';
        }

        if(isset($request->is_paytm_enabled) && $request->is_paytm_enabled == 'on')
        {
            $request->validate(
                [
                    'paytm_mode' => 'required',
                    'paytm_merchant_id' => 'required|string',
                    'paytm_merchant_key' => 'required|string',
                    'paytm_industry_type' => 'required|string',
                ]
            );
            $post['is_paytm_enabled']    = $request->is_paytm_enabled;
            $post['paytm_mode']          = $request->paytm_mode;
            $post['paytm_merchant_id']   = $request->paytm_merchant_id;
            $post['paytm_merchant_key']  = $request->paytm_merchant_key;
            $post['paytm_industry_type'] = $request->paytm_industry_type;
        }
        else
        {
            $post['is_paytm_enabled'] = 'off';
        }
        if(isset($request->is_mollie_enabled) && $request->is_mollie_enabled == 'on')
        {
            $request->validate(
                [
                    'mollie_api_key' => 'required|string',
                    'mollie_profile_id' => 'required|string',
                    'mollie_partner_id' => 'required',
                ]
            );
            $post['is_mollie_enabled'] = $request->is_mollie_enabled;
            $post['mollie_api_key']    = $request->mollie_api_key;
            $post['mollie_profile_id'] = $request->mollie_profile_id;
            $post['mollie_partner_id'] = $request->mollie_partner_id;
        }
        else
        {
            $post['is_mollie_enabled'] = 'off';
        }

        if(isset($request->is_skrill_enabled) && $request->is_skrill_enabled == 'on')
        {
            $request->validate(
                [
                    'skrill_email' => 'required|email',
                ]
            );
            $post['is_skrill_enabled'] = $request->is_skrill_enabled;
            $post['skrill_email']      = $request->skrill_email;
        }
        else
        {
            $post['is_skrill_enabled'] = 'off';
        }

        if(isset($request->is_coingate_enabled) && $request->is_coingate_enabled == 'on')
        {
            $request->validate(
                [
                    'coingate_mode' => 'required|string',
                    'coingate_auth_token' => 'required|string',
                ]
            );

            $post['is_coingate_enabled'] = $request->is_coingate_enabled;
            $post['coingate_mode']       = $request->coingate_mode;
            $post['coingate_auth_token'] = $request->coingate_auth_token;
        }
        else
        {
            $post['is_coingate_enabled'] = 'off';
        }

        //save paymentwall Detail
        if(isset($request->is_paymentwall_enabled) && $request->is_paymentwall_enabled == 'on')
        {

            //            dd('a');
            $request->validate(
                [
                    'paymentwall_public_key' => 'required|string',
                    'paymentwall_secret_key' => 'required|string',
                ]
            );
            $post['is_paymentwall_enabled'] = $request->is_paymentwall_enabled;
            $post['paymentwall_public_key'] = $request->paymentwall_public_key;
            $post['paymentwall_secret_key'] = $request->paymentwall_secret_key;
        }
        else
        {
            // dd('b');
            $post['is_paymentwall_enabled'] = 'off';
        }
        //  dd($post);


        foreach($post as $key => $data)
        {

            $arr = [
                $data,
                $key,
                \Auth::user()->id,
            ];
            \DB::insert(
                'insert into admin_payment_settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', $arr
            );

        }


    }

    public function savePusherSettings(Request $request)
    {
        if(\Auth::user()->type == 'super admin')
        {
            $request->validate(
                [
                    'pusher_app_id' => 'required',
                    'pusher_app_key' => 'required',
                    'pusher_app_secret' => 'required',
                    'pusher_app_cluster' => 'required',
                ]
            );

            $arrEnvStripe = [
                'PUSHER_APP_ID' => $request->pusher_app_id,
                'PUSHER_APP_KEY' => $request->pusher_app_key,
                'PUSHER_APP_SECRET' => $request->pusher_app_secret,
                'PUSHER_APP_CLUSTER' => $request->pusher_app_cluster,
            ];

            $envStripe = Utility::setEnvironmentValue($arrEnvStripe);
            Artisan::call('config:cache');
            Artisan::call('config:clear');
            if($envStripe)
            {
                return redirect()->back()->with('success', __('Pusher successfully updated.'));
            }
            else
            {
                return redirect()->back()->with('error', 'Something went wrong.');
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }


    }

    public function saveSlackSettings(Request $request){
        $post = [];
        $post['slack_webhook'] = $request->input('slack_webhook');
        $post['lead_notification'] = $request->has('lead_notification')?$request->input('lead_notification'):0;
        $post['deal_notification'] = $request->has('deal_notification')?$request->input('deal_notification'):0;
        $post['leadtodeal_notification'] = $request->has('leadtodeal_notification')?$request->input('leadtodeal_notification'):0;
        $post['contract_notification'] = $request->has('contract_notification')?$request->input('contract_notification'):0;
        $post['project_notification'] = $request->has('project_notification')?$request->input('project_notification'):0;
        $post['task_notification'] = $request->has('task_notification')?$request->input('task_notification'):0;
        $post['taskmove_notification'] = $request->has('taskmove_notification')?$request->input('taskmove_notification'):0;
        $post['taskcomment_notification'] = $request->has('taskcomment_notification')?$request->input('taskcomment_notification'):0;
        $post['payslip_notification'] = $request->has('payslip_notification')?$request->input('payslip_notification'):0;
        $post['award_notification'] = $request->has('award_notification')?$request->input('award_notification'):0;
        $post['announcement_notification'] = $request->has('announcement_notification')?$request->input('announcement_notification'):0;
        $post['holiday_notification'] = $request->has('holiday_notification')?$request->input('holiday_notification'):0;
        $post['support_notification'] = $request->has('support_notification')?$request->input('support_notification'):0;
        $post['event_notification'] = $request->has('event_notification')?$request->input('event_notification'):0;
        $post['meeting_notification'] = $request->has('meeting_notification')?$request->input('meeting_notification'):0;
        $post['policy_notification'] = $request->has('policy_notification')?$request->input('policy_notification'):0;
        $post['invoice_notification'] = $request->has('invoice_notification')?$request->input('invoice_notification'):0;
        $post['revenue_notification'] = $request->has('revenue_notification')?$request->input('revenue_notification'):0;
        $post['bill_notification'] = $request->has('bill_notification')?$request->input('bill_notification'):0;
        $post['payment_notification'] = $request->has('payment_notification')?$request->input('payment_notification'):0;
        $post['budget_notification'] = $request->has('budget_notification')?$request->input('budget_notification'):0;

        if(isset($post) && !empty($post) && count($post) > 0)
        {
            $created_at = $updated_at = date('Y-m-d H:i:s');

            foreach($post as $key => $data)
            {
                DB::insert(
                    'INSERT INTO settings (`value`, `name`,`created_by`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `updated_at` = VALUES(`updated_at`) ', [
                                                                                                                                                                                                                      $data,
                                                                                                                                                                                                                      $key,
                                                                                                                                                                                                                      Auth::user()->id,
                                                                                                                                                                                                                      $created_at,
                                                                                                                                                                                                                      $updated_at,
                                                                                                                                                                                                                  ]
                );
            }
        }

        return redirect()->back()->with('success', __('Slack updated successfully.'));
    }

    public function saveTelegramSettings(Request $request){
        $post = [];
        $post['telegram_accestoken'] = $request->input('telegram_accestoken');
        $post['telegram_chatid'] = $request->input('telegram_chatid');
        $post['telegram_lead_notification'] = $request->has('telegram_lead_notification')?$request->input('telegram_lead_notification'):0;
        $post['telegram_deal_notification'] = $request->has('telegram_deal_notification')?$request->input('telegram_deal_notification'):0;
        $post['telegram_leadtodeal_notification'] = $request->has('telegram_leadtodeal_notification')?$request->input('telegram_leadtodeal_notification'):0;
        $post['telegram_contract_notification'] = $request->has('telegram_contract_notification')?$request->input('telegram_contract_notification'):0;
        $post['telegram_project_notification'] = $request->has('telegram_project_notification')?$request->input('telegram_project_notification'):0;
        $post['telegram_task_notification'] = $request->has('telegram_task_notification')?$request->input('telegram_task_notification'):0;
        $post['telegram_taskmove_notification'] = $request->has('telegram_taskmove_notification')?$request->input('telegram_taskmove_notification'):0;
        $post['telegram_taskcomment_notification'] = $request->has('telegram_taskcomment_notification')?$request->input('telegram_taskcomment_notification'):0;
        $post['telegram_payslip_notification'] = $request->has('telegram_payslip_notification')?$request->input('telegram_payslip_notification'):0;
        $post['telegram_award_notification'] = $request->has('telegram_award_notification')?$request->input('telegram_award_notification'):0;
        $post['telegram_announcement_notification'] = $request->has('telegram_announcement_notification')?$request->input('telegram_announcement_notification'):0;
        $post['telegram_holiday_notification'] = $request->has('telegram_holiday_notification')?$request->input('telegram_holiday_notification'):0;
        $post['telegram_support_notification'] = $request->has('telegram_support_notification')?$request->input('telegram_support_notification'):0;
        $post['telegram_event_notification'] = $request->has('telegram_event_notification')?$request->input('telegram_event_notification'):0;
        $post['telegram_meeting_notification'] = $request->has('telegram_meeting_notification')?$request->input('telegram_meeting_notification'):0;
        $post['telegram_policy_notification'] = $request->has('telegram_policy_notification')?$request->input('telegram_policy_notification'):0;
        $post['telegram_invoice_notification'] = $request->has('telegram_invoice_notification')?$request->input('telegram_invoice_notification'):0;
        $post['telegram_revenue_notification'] = $request->has('telegram_revenue_notification')?$request->input('telegram_revenue_notification'):0;
        $post['telegram_bill_notification'] = $request->has('telegram_bill_notification')?$request->input('telegram_bill_notification'):0;
        $post['telegram_payment_notification'] = $request->has('telegram_payment_notification')?$request->input('telegram_payment_notification'):0;
        $post['telegram_budget_notification'] = $request->has('telegram_budget_notification')?$request->input('telegram_budget_notification'):0;

        if(isset($post) && !empty($post) && count($post) > 0)
        {
            $created_at = $updated_at = date('Y-m-d H:i:s');

            foreach($post as $key => $data)
            {
                DB::insert(
                    'INSERT INTO settings (`value`, `name`,`created_by`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `updated_at` = VALUES(`updated_at`) ', [
                                                                                                                                                                                                                      $data,
                                                                                                                                                                                                                      $key,
                                                                                                                                                                                                                      Auth::user()->id,
                                                                                                                                                                                                                      $created_at,
                                                                                                                                                                                                                      $updated_at,
                                                                                                                                                                                                                  ]
                );
            }
        }

        return redirect()->back()->with('success', __('Telegram updated successfully.'));
    }

    public function saveTwilioSettings(Request $request){
        $post = [];
        $post['twilio_sid'] = $request->input('twilio_sid');
        $post['twilio_token'] = $request->input('twilio_token');
        $post['twilio_from'] = $request->input('twilio_from');
        $post['twilio_customer_notification'] = $request->has('twilio_customer_notification')?$request->input('twilio_customer_notification'):0;
        $post['twilio_vender_notification'] = $request->has('twilio_vender_notification')?$request->input('twilio_vender_notification'):0;
        $post['twilio_invoice_notification'] = $request->has('twilio_invoice_notification')?$request->input('twilio_invoice_notification'):0;
        $post['twilio_revenue_notification'] = $request->has('twilio_revenue_notification')?$request->input('twilio_revenue_notification'):0;
        $post['twilio_bill_notification'] = $request->has('twilio_bill_notification')?$request->input('twilio_bill_notification'):0;
        $post['twilio_proposal_notification'] = $request->has('twilio_proposal_notification')?$request->input('twilio_proposal_notification'):0;
        $post['twilio_payment_notification'] = $request->has('twilio_payment_notification')?$request->input('twilio_payment_notification'):0;
        $post['twilio_reminder_notification'] = $request->has('twilio_reminder_notification')?$request->input('twilio_reminder_notification'):0;


        if(isset($post) && !empty($post) && count($post) > 0)
        {
            $created_at = $updated_at = date('Y-m-d H:i:s');

            foreach($post as $key => $data)
            {
                DB::insert(
                    'INSERT INTO settings (`value`, `name`,`created_by`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `updated_at` = VALUES(`updated_at`) ', [
                                                                                                                                                                                                                      $data,
                                                                                                                                                                                                                      $key,
                                                                                                                                                                                                                      Auth::user()->id,
                                                                                                                                                                                                                      $created_at,
                                                                                                                                                                                                                      $updated_at,
                                                                                                                                                                                                                  ]
                );
            }
        }

        return redirect()->back()->with('success', __('Twilio updated successfully.'));
    }

    public function recaptchaSettingStore(Request $request)
    {

        //return redirect()->back()->with('error', __('This operation is not perform due to demo mode.'));

        $user = \Auth::user();
        $rules = [];

        if($request->recaptcha_module == 'on')
        {

            $rules['google_recaptcha_key'] = 'required|string|max:50';
            $rules['google_recaptcha_secret'] = 'required|string|max:50';
        }

        $validator = \Validator::make(
            $request->all(), $rules
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $arrEnv = [
            'RECAPTCHA_MODULE' => $request->recaptcha_module ?? 'off',
            'NOCAPTCHA_SITEKEY' => $request->google_recaptcha_key,
            'NOCAPTCHA_SECRET' => $request->google_recaptcha_secret,
        ];

        if(Utility::setEnvironmentValue($arrEnv))
        {
            return redirect()->back()->with('success', __('Recaptcha Settings updated successfully'));
        }
        else
        {
            return redirect()->back()->with('error', __('Something is wrong'));
        }
    }


    public function storageSettingStore(Request $request)
    {

        if(isset($request->storage_setting) && $request->storage_setting == 'local')
        {

            $request->validate(
                [

                    'local_storage_validation' => 'required',
                    'local_storage_max_upload_size' => 'required',
                ]
            );

            $post['storage_setting'] = $request->storage_setting;
            $local_storage_validation = implode(',', $request->local_storage_validation);
            $post['local_storage_validation'] = $local_storage_validation;
            $post['local_storage_max_upload_size'] = $request->local_storage_max_upload_size;

        }

        if(isset($request->storage_setting) && $request->storage_setting == 's3')
        {
            $request->validate(
                [
                    's3_key'                  => 'required',
                    's3_secret'               => 'required',
                    's3_region'               => 'required',
                    's3_bucket'               => 'required',
                    's3_url'                  => 'required',
                    's3_endpoint'             => 'required',
                    's3_max_upload_size'      => 'required',
                    's3_storage_validation'   => 'required',
                ]
            );
            $post['storage_setting']            = $request->storage_setting;
            $post['s3_key']                     = $request->s3_key;
            $post['s3_secret']                  = $request->s3_secret;
            $post['s3_region']                  = $request->s3_region;
            $post['s3_bucket']                  = $request->s3_bucket;
            $post['s3_url']                     = $request->s3_url;
            $post['s3_endpoint']                = $request->s3_endpoint;
            $post['s3_max_upload_size']         = $request->s3_max_upload_size;
            $s3_storage_validation              = implode(',', $request->s3_storage_validation);
            $post['s3_storage_validation']      = $s3_storage_validation;
        }

        if(isset($request->storage_setting) && $request->storage_setting == 'wasabi')
        {
            $request->validate(
                [
                    'wasabi_key'                    => 'required',
                    'wasabi_secret'                 => 'required',
                    'wasabi_region'                 => 'required',
                    'wasabi_bucket'                 => 'required',
                    'wasabi_url'                    => 'required',
                    'wasabi_root'                   => 'required',
                    'wasabi_max_upload_size'        => 'required',
                    'wasabi_storage_validation'     => 'required',
                ]
            );
            $post['storage_setting']            = $request->storage_setting;
            $post['wasabi_key']                 = $request->wasabi_key;
            $post['wasabi_secret']              = $request->wasabi_secret;
            $post['wasabi_region']              = $request->wasabi_region;
            $post['wasabi_bucket']              = $request->wasabi_bucket;
            $post['wasabi_url']                 = $request->wasabi_url;
            $post['wasabi_root']                = $request->wasabi_root;
            $post['wasabi_max_upload_size']     = $request->wasabi_max_upload_size;
            $wasabi_storage_validation          = implode(',', $request->wasabi_storage_validation);
            $post['wasabi_storage_validation']  = $wasabi_storage_validation;
        }

        foreach($post as $key => $data)
        {

            $arr = [
                $data,
                $key,
                \Auth::user()->id,
            ];

            \DB::insert(
                'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', $arr
            );
        }

        return redirect()->back()->with('success', 'Storage setting successfully updated.');

    }

    public function offerletterupdate($lang, Request $request)
    {
        $user = GenerateOfferLetter::updateOrCreate(['lang' =>   $lang,'created_by' =>  \Auth::user()->id],['content' => $request->content]);

        return response()->json(
            [
                'is_success' => true,
                'success' => __('Offer Letter successfully saved!'),
            ], 200
        );

    }
    public function joiningletterupdate($lang, Request $request)
    {

        $user = JoiningLetter::updateOrCreate(['lang' =>   $lang,'created_by' =>  \Auth::user()->id],['content' => $request->content]);

        return response()->json(
            [
                'is_success' => true,
                'success' => __('Joing Letter successfully saved!'),
            ], 200
        );

    }
    public function experienceCertificateupdate($lang, Request $request)
    {
        //   dd($request->all());
        $user = ExperienceCertificate::updateOrCreate(['lang' =>   $lang,'created_by' =>  \Auth::user()->id],['content' => $request->content]);

        return response()->json(
            [
                'is_success' => true,
                'success' => __('Experience Certificate successfully saved!'),
            ], 200
        );

    }
    public function NOCupdate($lang, Request $request)
    {
        //   dd($request->all());
        $user = NOC::updateOrCreate(['lang' =>   $lang,'created_by' =>  \Auth::user()->id],['content' => $request->content]);

        return response()->json(
            [
                'is_success' => true,
                'success' => __('NOC successfully saved!'),
            ], 200
        );

    }


}
