<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ExperienceCertificate;
use App\Models\GenerateOfferLetter;
use App\Models\JoiningLetter;
use App\Models\NOC;
use App\Models\User;
use App\Models\Plan;
use  App\Models\Utility;
use Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use App\Models\Company_type;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */



  public function __construct()
    {
        $this->middleware('guest');
    }


    public function create()
    {
        // return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        //ReCpatcha

        if(env('RECAPTCHA_MODULE') == 'on')
        {
            $validation['g-recaptcha-response'] = 'required|captcha';
        }else{
            $validation = [];
        }
        $this->validate($request, $validation);
        $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'company_type'=>'required',
            // 'password' => ['required', 'string',
            //              'min:8','confirmed', Rules\Password::defaults()],
        ]);


        $password="Change@123";
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'company_name' => $request->company_name,
            'company_type'=>$request->company_type,
            'password' => Hash::make($password),
             'type' => 'company',
             'default_pipeline' => 1,
              'plan' => 1,
              'lang' => Utility::getValByName('default_language'),
               'avatar' => '',
               'created_by' => 1,
               'verfiy_email'=>1
        ]);
        if($user->id){

            //create a new token to be sent to the user.
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => Str::random(60), //change 60 to any length you want
                'created_at' => Carbon::now()
            ]);

            $tokenData = DB::table('password_resets')->where('email', $request->email)->first();

            $token = $tokenData->token;
            $url=url('').'/password-set/'.$token.'?email='.$request->email;
            $userArr = [
                'email' => $request->email,
                'set_password_url' => $url,
            ];

            $role_r = Role::findByName('company');
            $user->assignRole($role_r);
            $user->userDefaultDataRegister($user->id);
            $user->userWarehouseRegister($user->id);

            $resp = Utility::sendEmailTemplateHTML('create_user_set_password', [$user->id => $user->email], $userArr);
            event(new Registered($user));
            return redirect()->route('login')->with('success', __('Registered Successfully. Check you email for verfication. Kindly find the below link. '.$userArr['set_password_url']));

            // return \Redirect::to('login');
        }



    }
    public function paymentPage(){
        $plans=Plan::get();
        return view('payment.paymentPage',compact('plans'));
    }
    public function showRegistrationForm($lang = '')
    {

        $settings = Utility::settings();
//    $lang = $settings['default_language'];
        $companytype = Company_type::where('status',1)->get();
        if($settings['enable_signup'] == 'on')
        {
            if($lang == '')
            {
                $lang = Utility::getValByName('default_language');
            }
            \App::setLocale($lang);

            return view('auth.register', compact('lang','companytype'));
        }
        else
        {
            return \Redirect::to('login');
        }
    }

}
