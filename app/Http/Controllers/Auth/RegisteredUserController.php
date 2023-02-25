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
use Illuminate\Support\Facades\DB;
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
            'password' => ['required', 'string',
                         'min:8','confirmed', Rules\Password::defaults()],
        ]);



        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'company_name' => $request->company_name,
            'company_type'=>$request->company_type,
            'password' => Hash::make($request->password),
             'type' => 'company',
             'default_pipeline' => 1,
              'plan' => 1,
              'lang' => Utility::getValByName('default_language'),
               'avatar' => '',
               'created_by' => 1,
        ]);

    
        $insert_array=array(
            'name'=>'company_name',
            'value'=>$request->company_name,
            'created_by'=>$user->id,
        );
        $data =DB::table('settings')->insert($insert_array);

        $insert2=array(
            'name'=>'company_type',
            'value'=>$request->company_type,
            'created_by'=>$user->id,
        );
        $data =DB::table('settings')->insert($insert2);
        

        $role_r = Role::findByName('company');
        $user->assignRole($role_r);
//        $user->userDefaultData();
        $user->userDefaultDataRegister($user->id);
        $user->userWarehouseRegister($user->id);
        Utility::chartOfAccountTypeData($user->id);
        Utility::chartOfAccountData1($user->id);
        Utility::pipeline_lead_deal_Stage($user->id);
        Utility::project_task_stages($user->id);
        Utility::labels($user->id);
        Utility::sources($user->id);
        Utility::jobStage($user->id);
        GenerateOfferLetter::defaultOfferLetterRegister($user->id);
        ExperienceCertificate::defaultExpCertificatRegister($user->id);
        JoiningLetter::defaultJoiningLetterRegister($user->id);
        NOC::defaultNocCertificateRegister($user->id);




        event(new Registered($user));

        Auth::login($user);

        return \Redirect::to('paymentPage');
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
