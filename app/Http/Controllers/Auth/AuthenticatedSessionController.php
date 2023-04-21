<?php

namespace App\Http\Controllers\Auth;

use App\Models\Customer;
use App\Models\Plan;
use App\Models\Vender;
use  App\Models\Utility;
use Carbon\Carbon;
use Artisan;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */


    public function __construct()
    {
        // if(!file_exists(storage_path() . "/installed"))
        // {
        //     header('location:install');
        //     die;
        // }
        // $this->middleware('guest')->except('logout');
    }

    public function create()
    {
        // return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param \App\Http\Requests\Auth\LoginRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */


    // protected function authenticated(Request $request)
    //    {


    //             $user = Auth::user();
    //        if($user->delete_status == 0)
    //        {
    //            auth()->logout();
    //        }

    //        if($user->is_active == 0)
    //        {
    //            auth()->logout();
    //        }
    //    }


    public function store(LoginRequest $request)
    {

     //ReCpatcha
        if(env('RECAPTCHA_MODULE') == 'on')
        {
            $validation['g-recaptcha-response'] = 'required|captcha';
        }else{
            $validation = [];
        }
        $this->validate($request, $validation);

        $request->authenticate();
        $request->session()->regenerate();
        $user = Auth::user();

        $check_email=DB::table('users')->where('id',Auth::id())->where('email',$request->email)->first();

        $update_lang=array('lang'=>$request->lang);

        if($check_email->lang!=null && $request->lang!='en'){

            DB::table('users')->where('id',Auth::id())->where('email',$request->email)->update($update_lang);

        }else if($check_email->lang==null){

            DB::table('users')->where('id',Auth::id())->where('email',$request->email)->update($update_lang);
            
        }else{

        }

        if($user->delete_status == 0)
        {
            auth()->logout();
        }

        if($user->is_active == 0)
        {
            auth()->logout();
        }
        $user = \Auth::user();
        if($user->type == 'company')
        {
            $plan = Plan::find($user->plan);
            if($plan)
            {
                if($plan->duration != 'unlimited')
                {
                    $datetime1 = new \DateTime($user->plan_expire_date);
                    $datetime2 = new \DateTime(date('Y-m-d'));
                    //                    $interval  = $datetime1->diff($datetime2);
                    $interval = $datetime2->diff($datetime1);
                    $days     = $interval->format('%r%a');
                    if($days <= 0)
                    {
                        $user->assignPlan(1);

                        return redirect()->intended(RouteServiceProvider::HOME)->with('error', __('Your Plan is expired.'));
                    }
                }
            }

        }
        $last_login=$user->last_login_at;

        if($user->last_login_at==NULL){
            $user->update(
                [
                    'last_login_at' => Carbon::now()->toDateTimeString(),
                ]
            );
            if($user->type =='company' || $user->type =='super admin')
            {
                return redirect('companysetting');

            }
            else  if($user->type =='client')
            {
                return redirect('projects');

            }
            else
            {
                return redirect('users');
            }
        }else{
            $user->update(
                [
                    'last_login_at' => Carbon::now()->toDateTimeString(),
                ]
            );
            if($user->type =='company' || $user->type =='super admin' || $user->type =='client')
            {
               
                return redirect()->intended(RouteServiceProvider::HOME);

            }
            else
            {
             
                return redirect()->intended(RouteServiceProvider::EMPHOME);
            }
        }
       
        

    }
    /**
     * Destroy an authenticated session.
    *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        Artisan::call('optimize:clear');

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }


    public function showCustomerLoginForm($lang = '')
    {
        if($lang == '')
        {
            $lang = Utility::getValByName('default_language');
        }

        \App::setLocale($lang);

        return view('auth.customer_login', compact('lang'));
    }

    public function customerLogin(Request $request)
    {

        $this->validate(
            $request, [
                        'email' => 'required|email',
                        'password' => 'required|min:6',
                    ]
        );

        if(\Auth::guard('customer')->attempt(
            [
                'email' => $request->email,
                'password' => $request->password,
            ], $request->get('remember')
        ))
        {
            if(\Auth::guard('customer')->user()->is_active == 0)
            {
                \Auth::guard('customer')->logout();
            }
            $user = \Auth::guard('customer')->user();
            $user->update(
                [
                    'last_login_at' => Carbon::now()->toDateTimeString(),
                ]
            );

            return redirect()->route('customer.dashboard');
        }

        return $this->sendFailedLoginResponse(0);
    }

    public function showVenderLoginForm($lang = '')
    {
        if($lang == '')
        {
            $lang = Utility::getValByName('default_language');
        }

        \App::setLocale($lang);

        return view('auth.vender_login', compact('lang'));
    }

    public function venderLogin(Request $request)
    {
        $this->validate(
            $request, [
                        'email' => 'required|email',
                        'password' => 'required|min:6',
                    ]
        );
        if(\Auth::guard('vender')->attempt(
            [
                'email' => $request->email,
                'password' => $request->password,
            ], $request->get('remember')
        ))
        {
            if(\Auth::guard('vender')->user()->is_active == 0)
            {
                \Auth::guard('vender')->logout();
            }
            $user = \Auth::guard('vender')->user();
            $user->update(
                [
                    'last_login_at' => Carbon::now()->toDateTimeString(),
                ]
            );

            return redirect()->route('vender.dashboard');
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function showLoginForm($lang = '')
    {
       

        if($lang == '')
        {
            $lang = Utility::getValByName('default_language');
        }

        \App::setLocale($lang);

        $settings = Utility::settings();

        return view('auth.login', compact('lang','settings'));
    }

    public function showLinkRequestForm($lang = '')
    {
        if($lang == '')
        {
            $lang = Utility::getValByName('default_language');
        }

        \App::setLocale($lang);

        $settings = Utility::settings();

        return view('auth.forgot-password', compact('lang','settings'));
    }

    public function showCustomerLoginLang($lang = '')
    {
        if($lang == '')
        {
            $lang = Utility::getValByName('default_language');
        }

        \App::setLocale($lang);

        return view('auth.customer_login', compact('lang'));
    }

    public function showVenderLoginLang($lang = '')
    {
        if($lang == '')
        {
            $lang = Utility::getValByName('default_language');
        }

        \App::setLocale($lang);

        return view('auth.vender_login', compact('lang'));
    }

    //    ---------------------------------Customer ----------------------------------_
    public function showCustomerLinkRequestForm($lang = '')
    {
        if($lang == '')
        {
            $lang = Utility::getValByName('default_language');
        }

        \App::setLocale($lang);

        return view('auth.passwords.customerEmail', compact('lang'));
    }

    public function postCustomerEmail(Request $request)
    {

        $request->validate(
            [
                'email' => 'required|email|exists:customers',
            ]
        );

        $token = \Str::random(60);

        DB::table('password_resets')->insert(
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]
        );

        Mail::send(
            'auth.customerVerify', ['token' => $token], function ($message) use ($request){
            $message->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'));
            $message->to($request->email);
            $message->subject('Reset your password');
        }
        );

        return back()->with('status', 'We have e-mailed your password reset link!');
    }

    public function showResetForm(Request $request, $token = null)
    {

        $default_language = DB::table('settings')->select('value')->where('name', 'default_language')->first();
        $lang             = !empty($default_language) ? $default_language->value : 'en';

        \App::setLocale($lang);

        return view('auth.passwords.reset')->with(
            [
                'token' => $token,
                'email' => $request->email,
                'lang' => $lang,
            ]
        );
    }

    public function getCustomerPassword($token)
    {

        return view('auth.passwords.customerReset', ['token' => $token]);
    }

    public function updateCustomerPassword(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|exists:customers',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required',

            ]
        );

        $updatePassword = DB::table('password_resets')->where(
            [
                'email' => $request->email,
                'token' => $request->token,
            ]
        )->first();

        if(!$updatePassword)
        {
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $user = Customer::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email' => $request->email])->delete();

        return redirect('/login')->with('message', 'Your password has been changed.');

    }

    //    ----------------------------Vendor----------------------------------------------------
    public function showVendorLinkRequestForm($lang = '')
    {
        if($lang == '')
        {
            $lang = Utility::getValByName('default_language');
        }

        \App::setLocale($lang);

        return view('auth.passwords.vendorEmail', compact('lang'));
    }

    public function postVendorEmail(Request $request)
    {

        $request->validate(
            [
                'email' => 'required|email|exists:venders',
            ]
        );

        $token = \Str::random(60);

        DB::table('password_resets')->insert(
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]
        );

        Mail::send(
            'auth.vendorVerify', ['token' => $token], function ($message) use ($request){
            $message->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'));
            $message->to($request->email);
            $message->subject('Reset your password');
        }
        );

        return back()->with('status', 'We have e-mailed your password reset link!');
    }

    public function getVendorPassword($token)
    {

        return view('auth.passwords.vendorReset', ['token' => $token]);
    }

    public function updateVendorPassword(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|exists:venders',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required',

            ]
        );

        $updatePassword = DB::table('password_resets')->where(
            [
                'email' => $request->email,
                'token' => $request->token,
            ]
        )->first();

        if(!$updatePassword)
        {
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $user = Vender::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email' => $request->email])->delete();

        return redirect('/login')->with('message', 'Your password has been changed.');

    }
}

