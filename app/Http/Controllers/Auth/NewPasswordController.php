<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

use App\Models\ExperienceCertificate;
use App\Models\GenerateOfferLetter;
use App\Models\JoiningLetter;
use  App\Models\Utility;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('auth.passwords.reset', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();
                if($user->verfiy_email==1){
                    $insert_array=array(
                        'name'=>'company_name',
                        'value'=>$user->company_name,
                        'created_by'=>$user->id,
                    );
                    $data =DB::table('settings')->insert($insert_array);

                    $insert2=array(
                        'name'=>'company_type',
                        'value'=>$user->company_type,
                        'created_by'=>$user->id,
                    );
                    $data =DB::table('settings')->insert($insert2);
                    

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

                    event(new Registered($user));

                    Auth::login($user);

                    return \Redirect::to('paymentPage');

                        event(new PasswordReset($user));
                    }
                }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }
}
