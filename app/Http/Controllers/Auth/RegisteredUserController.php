<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company_type;
use App\Models\ExperienceCertificate;
use App\Models\GenerateOfferLetter;
use App\Models\JoiningLetter;
use App\Models\NOC;
use App\Models\Plan;
use App\Models\User;
use App\Models\Utility;
use Auth;
use Carbon\Carbon;
use Config;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

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
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        //ReCpatcha

        if (env('RECAPTCHA_MODULE') == 'on') {
            $validation['g-recaptcha-response'] = 'required|captcha';
        } else {
            $validation = [];
        }
        $this->validate($request, $validation);
        $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'company_type' => 'required',
            // 'password' => ['required', 'string',
            //              'min:8','confirmed', Rules\Password::defaults()],
        ]);

        $password=Utility::randomPassword();
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'company_name' => $request->company_name,
            'company_type' => $request->company_type,
            'password' => Hash::make($password),
            'type' => $request->type,
            'default_pipeline' => 1,
            'plan' => 1,
            'lang' => Utility::getValByName('default_language'),
            'avatar' => '',
            'created_by' => 1,
            'verfiy_email' => 1,
        ]);
        if ($user->id) {

            //create a new token to be sent to the user.
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => Str::random(60), //change 60 to any length you want
                'created_at' => Carbon::now(),
            ]);

            $tokenData = DB::table('password_resets')->where('email', $request->email)->first();

            $token = $tokenData->token;
            $url = url('').'/password-set/'.$token.'?email='.$request->email;
            $userArr = [
                'email' => $request->email,
                'password' => $password,
                'set_password_url' => $url,
            ];

            $insert_array = [
                'name' => 'company_name',
                'value' => $request->company_name,
                'created_by' => $user->id,
            ];

            $data = DB::table('settings')->insert($insert_array);

            $insert2 = [
                'name' => 'company_type',
                'value' => $request->company_type,
                'created_by' => $user->id,
            ];

            $data = DB::table('settings')->insert($insert2);

            $role_r = Role::findByName('company');
            $user->assignRole($role_r);
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
            switch($request->type) {
                case 'company':

                    $resp = Utility::sendEmailTemplateHTML('create_user_set_password',
                    [$user->id => $user->email], $userArr);
                event(new Registered($user));

                return redirect()->route('login')->with('success_register', __($userArr['set_password_url']));

                case 'consultant':

                $user->password = $password;
                $user->type = 'consultant';

                $userArr = [
                    'email' => $user->email,
                    'password' => $user->password,
                ];

                Utility::sendEmailTemplate(Config::get('constants.CR_CONSULTANT'),
                [$user->id => $user->email], $userArr);
                event(new Registered($user));

                return redirect()->route('login')->with('success',__(Config::get('constants.CONSULTANT_MAIL')));

                case 'sub_contractor':

                    $user->password = $password;
                    $user->type = 'sub_contractor';

                    $userArr = [
                        'email' => $user->email,
                        'password' => $user->password,
                    ];

                    Utility::sendEmailTemplate(Config::get('constants.SR_CONSULTANT'), [$user->id => $user->email], $userArr);
                    event(new Registered($user));

                    return redirect()->route('login')->with('success',__(Config::get('constants.subcontractor_MAIL')));

                default:

            }



            // return \Redirect::to('login');
        }

    }

    public function paymentPage()
    {
        $plans = Plan::get();

        return view('payment.paymentPage', compact('plans'));
    }

    public function showRegistrationForm($lang = '')
    {

        $settings = Utility::settings();
        //    $lang = $settings['default_language'];
        $companytype = Company_type::where('status', 1)->get();
        if ($settings['enable_signup'] == 'on') {
            if ($lang == '') {
                $lang = Utility::getValByName('default_language');
            }
            \App::setLocale($lang);

            return view('auth.register', compact('lang', 'companytype'));
        } else {
            return \Redirect::to('login');
        }
    }
}
