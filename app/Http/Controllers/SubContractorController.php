<?php

namespace App\Http\Controllers;

use App\Models\Company_type;
use App\Models\CustomField;
use App\Models\Employee;
use App\Models\ExperienceCertificate;
use App\Models\GenerateOfferLetter;
use App\Models\JoiningLetter;
use App\Models\NOC;
use App\Models\Plan;
use App\Models\User;
use App\Models\Utility;
use Carbon\Carbon;
use App\Models\SubContractorCompanies;
use Config;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SubContractorController extends Controller
{
    public function index(Request $request)
    {
        $user = \Auth::user();
        if (\Auth::user()->can('manage sub contractor')) {
            $users = User::where([
                ['name', '!=', null],
                [function ($query) use ($request) {
                    if ($s = $request->search) {
                        $query->orWhere('name', 'LIKE', '%' . $s . '%')
                            ->get();
                    }
                }],
            ])->where('created_by', '=', $user->creatorId())->where('type', '=', 'sub_contractor')->paginate(8);

            return view('subcontractor.index')->with('users', $users);
        }
        else {
            return redirect()->back();
        }
    }

    public function create(Request $request)
    {
        if (\Auth::user()->can('create sub contractor')) {
            $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())
                ->where('module', '=', 'subcontractor')->get();
            $country = Utility::getcountry();

            return view('subcontractor.create', compact('customFields','country'));
        } else {
            return redirect()->back();
        }
    }

    public function subContractorStore(Request $request){
        $defaultlanguage = DB::table('settings')->select('value')->where('name', 'default_language')->first();
        $fileNames       = $this->upload($request);
        $psw             = $request->password;

        $subconsult                     = new User();
        $subconsult['name']             = $request->name;
        $subconsult['lname']            = $request->lname;
        $subconsult['email']            = $request->email;
        $subconsult['password']         = Hash::make($request->password);
        $subconsult['type']             = 'sub_contractor';
        $subconsult['default_pipeline'] = 1;
        $subconsult['plan']             = 1;
        $subconsult['lang']             = ! empty($defaultlanguage) ? $defaultlanguage->value : '';
        $subconsult['created_by']       = \Auth::user()->creatorId();
        $subconsult['phone']            = $request->contact;
        $subconsult['tax_number']       = $request->tax_number;
        $subconsult['color_code']       = $request->color_code;
        $subconsult['billing_name']     = $request->billing_name;
        $subconsult['billing_country']  = $request->billing_country;
        $subconsult['billing_state']    = $request->billing_state;
        $subconsult['billing_city']     = $request->billing_city;
        $subconsult['billing_phone']    = $request->billing_phone;
        $subconsult['billing_zip']      = $request->billing_zip;
        $subconsult['billing_address']  = $request->billing_address;
        $subconsult['shipping_name']    = $request->shipping_name;
        $subconsult['shipping_country'] = $request->shipping_country;
        $subconsult['shipping_state']   = $request->shipping_state;
        $subconsult['shipping_city']    = $request->shipping_city;
        $subconsult['shipping_phone']   = $request->shipping_phone;
        $subconsult['shipping_zip']     = $request->shipping_zip;
        $subconsult['shipping_address'] = $request->shipping_address;

        if (isset($fileNames)) {
            $subconsult['avatar'] = $fileNames;
        }

        $subconsult->save();
        $role_r = Role::findByName('sub_contractor');
        $subconsult->assignRole($role_r);
        $subconsult->userDefaultDataRegister($subconsult->id);
        $subconsult->userWarehouseRegister($subconsult->id);
        Utility::chartOfAccountTypeData($subconsult->id);
        Utility::chartOfAccountData1($subconsult->id);
        Utility::pipeline_lead_deal_Stage($subconsult->id);
        Utility::project_task_stages($subconsult->id);
        Utility::labels($subconsult->id);
        Utility::sources($subconsult->id);
        Utility::jobStage($subconsult->id);
        GenerateOfferLetter::defaultOfferLetterRegister($subconsult->id);
        ExperienceCertificate::defaultExpCertificatRegister($subconsult->id);
        JoiningLetter::defaultJoiningLetterRegister($subconsult->id);
        NOC::defaultNocCertificateRegister($subconsult->id);
        $requested_date = Config::get('constants.TIMESTUMP');
        $createConnection = SubContractorCompanies::create([
            "company_id"=>\Auth::user()->creatorId(),
            'sub_contractor_id'=>$subconsult->id,
            'requested_date'=>$requested_date,
            'status'=>'requested'
        ]);
        $inviteUrl=url('').Config::get('constants.INVITATION_URL_subcontractor').$createConnection->id;
        $userArr = [
            'invite_link' => $inviteUrl,
            'user_name' => \Auth::user()->name,
            'company_name' => \Auth::user()->company_name,
            'email' => \Auth::user()->email,
        ];
        Utility::sendEmailTemplate(Config::get('constants.INSR'), [$subconsult->id => $subconsult->email], $userArr);
           

        $setings = Utility::settings();

        if ($setings['create_sub_contractor'] == 1) {
            $subconsult->password = $psw;
            $subconsult->type = $role_r->name;

            $userArr = [
                'email' => $subconsult->email,
                'password' => $subconsult->password,
            ];
            Utility::sendEmailTemplate(Config::get('constants.SR_CONSULTANT'),
                    [$subconsult->id => $subconsult->email], $userArr);

        }

        return redirect()->route('subcontractor.index')->with('success', Config::get('constants.subcontractor_MAIL'));
    }

    public function normal_store(Request $request)
    {
        $this->validationCreateSubContractor($request);
        $fileNames = $this->upload($request);
        $objUser   = \Auth::user()->creatorId();
        $objUser   = User::find($objUser);
        $usersubcon      = User::find(\Auth::user()->created_by);
        $totaluser = $objUser->countUsers();
        $plan      = Plan::find($objUser->plan);
        if ($totaluser < $plan->max_users || $plan->max_users == -1) {

            $psw = $request->password;

            if ($fileNames != null) {
                $avatar = $fileNames;
            } else {
                $avatar = null;
            }

            $usersubcon = User::create(
                [
                    'name'             => $request->name,
                    'lname'            => $request->lname,
                    'email'            => $request->email,
                    'password'         => Hash::make($request->password),
                    'type'             => 'sub_contractor',
                    'lang'             => Utility::getValByName('default_language'),
                    'created_by'       => \Auth::user()->creatorId(),
                    'phone'            => $request->contact,
                    'avatar'           => $avatar,
                    'color_code'       => $request->color_code,
                    'tax_number'       => $request->tax_number,
                    'billing_name'     => $request->billing_name,
                    'billing_country'  => $request->billing_country,
                    'billing_state'    => $request->billing_state,
                    'billing_city'     => $request->billing_city,
                    'billing_phone'    => $request->billing_phone,
                    'billing_zip'      => $request->billing_zip,
                    'billing_address'  => $request->billing_address,
                    'shipping_name'    => $request->shipping_name,
                    'shipping_country' => $request->shipping_country,
                    'shipping_state'   => $request->shipping_state,
                    'shipping_city'    => $request->shipping_city,
                    'shipping_phone'   => $request->shipping_phone,
                    'shipping_zip'     => $request->shipping_zip,
                    'shipping_address' => $request->shipping_address,
                ]
            );
            $roler = Role::findByName('sub_contractor');
            $usersubcon->assignRole($roler);
            $usersubcon->userDefaultDataRegister($usersubcon->id);
        }

        $setings = Utility::settings();
        $requesteddate = Config::get('constants.TIMESTUMP');
        $createConnection = SubContractorCompanies::create([
            "company_id" => \Auth::user()->creatorId(),
            'sub_contractor_id' => $usersubcon->id,
            'requested_date' => $requesteddate,
            'status' => 'requested',
        ]);
        $inviteUrl = url('') . Config::get('constants.INVITATION_URL_subcontractor') . $createConnection->id;
        $userarr = [
            'invite_link' => $inviteUrl,
            'user_name' => \Auth::user()->name,
            'company_name' => \Auth::user()->company_name,
            'email' => \Auth::user()->email,
        ];
        Utility::sendEmailTemplate(Config::get('constants.INSR'), [$usersubcon->id => $usersubcon->email], $userarr);

        if ($setings['create_sub_contractor'] == 1) {
            $usersubcon->password = $psw;
            $usersubcon->type = 'sub_contractor';

            $userarray = [
                'email' => $usersubcon->email,
                'password' => $usersubcon->password,
            ];

            Utility::sendEmailTemplate(Config::get('constants.SR_CONSULTANT'),
                    [$usersubcon->id => $usersubcon->email], $userarray);

            return redirect()->route('subcontractor.index')
                             ->with('success', Config::get('constants.subcontractor_MAIL'));
        }
        else {
            return redirect()->back()->with('error', __('Your user limit is over, Please upgrade plan.'));
        }
    }

    public function upload($request)
    {
        if (isset($request->avatar)) {

            $filenameWithExtension = $request->file('avatar')->getClientOriginalName();
            $fileName = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('avatar')->getClientOriginalExtension();
            $filenamestore = $fileName . '_' . time() . '.' . $extension;

            $directory = Config::get('constants.USER_IMG');
            $imagepath = $directory.$filenamestore;
            if (\File::exists($imagepath)) {
                \File::delete($imagepath);
            }

            Utility::upload_file($request, 'avatar', $filenamestore, $directory, []);

            return $filenamestore;
        }
    }

    public function store(Request $request)
    {
        $this->validationCreateSubContractor($request);
        $defaultlanguage = DB::table('settings')->select('value')->where('name', 'default_language')->first();
        $fileNames = $this->upload($request);
        $subcon = new User();
        $subcon['name'] = $request->name;
        $subcon['lname'] = $request->lname;
        $subcon['email'] = $request->email;
        $subcon['gender'] = $request->gender;
        $psw = $request->password;
        $subcon['password'] = Hash::make($request->password);
        $subcon['type'] = 'sub_contractor';
        $subcon['default_pipeline'] = 1;
        $subcon['plan'] = 1;
        $subcon['lang'] = !empty($defaultlanguage) ? $defaultlanguage->value : '';
        $subcon['created_by'] = \Auth::user()->creatorId();
        $subcon['country'] = $request->country;
        $subcon['state'] = $request->state;
        $subcon['city'] = $request->city;
        $subcon['phone'] = $request->phone;
        $subcon['zip'] = $request->zip;
        $subcon['address'] = $request->address;
        $subcon['company_type'] = $request->company_type;
        $subcon['color_code'] = $request->color_code;
        $subcon['company_name'] = $request->company_name;
        if (isset($fileNames)) {
            $subcon['avatar'] = $fileNames;
        }
        $subcon->save();
        $role_r = Role::findByName('sub_contractor');
        $subcon->assignRole($role_r);
        $subcon->userDefaultDataRegister($subcon->id);
        $subcon->userWarehouseRegister($subcon->id);
        Utility::chartOfAccountTypeData($subcon->id);
        Utility::chartOfAccountData1($subcon->id);
        Utility::pipeline_lead_deal_Stage($subcon->id);
        Utility::project_task_stages($subcon->id);
        Utility::labels($subcon->id);
        Utility::sources($subcon->id);
        Utility::jobStage($subcon->id);
        GenerateOfferLetter::defaultOfferLetterRegister($subcon->id);
        ExperienceCertificate::defaultExpCertificatRegister($subcon->id);
        JoiningLetter::defaultJoiningLetterRegister($subcon->id);
        NOC::defaultNocCertificateRegister($subcon->id);
        $requested_date = Config::get('constants.TIMESTUMP');
        $createConnection = SubContractorCompanies::create([
            "company_id" => \Auth::user()->creatorId(),
            'sub_contractor_id' => $subcon->id,
            'requested_date' => $requested_date,
            'status' => 'requested',
        ]);
        $inviteUrl = url('') . Config::get('constants.INVITATION_URL_subcontractor') . $createConnection->id;
        $userArr = [
            'invite_link' => $inviteUrl,
            'user_name' => \Auth::user()->name,
            'company_name' => \Auth::user()->company_name,
            'email' => \Auth::user()->email,
        ];
        Utility::sendEmailTemplate(Config::get('constants.INSR'), [$subcon->id => $subcon->email], $userArr);

        $setings = Utility::settings();

        if ($setings['create_sub_contractor'] == 1) {
            $subcon->password = $psw;
            $subcon->type = $role_r->name;

            $userArr = [
                'email' => $subcon->email,
                'password' => $subcon->password,
            ];
            Utility::sendEmailTemplate(Config::get('constants.SR_CONSULTANT'),
                    [$subcon->id => $subcon->email], $userArr);
        }

        return redirect()->route('subcontractor.index')->with('success', Config::get('constants.subcontractor_MAIL'));
    }

    public function createConnection(Request $request)
    {
        // Need to check invitation link is valid or expired based on that need to redirect
        $checkConnection = SubContractorCompanies::where(['id' => $request->id])->first();
        $companyDetails = User::where(['id' => $checkConnection->company_id])->first();
        $requestedDate = Carbon::parse($checkConnection->requested_date)->format('Y-m-d');
        $expiryDate = Carbon::parse($requestedDate)->addDays(7)->format('Y-m-d');
        $checkValidity = Carbon::now()->between($requestedDate, $expiryDate);
        $msg = 'expired';
        if ($checkValidity && $checkConnection->status == 'requested') {
            $msg = 'valid';
        } else {
            if ($checkConnection->status == 'requested') {
                SubContractorCompanies::where(['id' => $request->id])->update(['status' => 'expired']);
            } else {
                $msg = $checkConnection->status;
            }
        }
        return view('subcontractor.invitation', compact('checkConnection', 'companyDetails', 'msg'));
    }

    public function submitConnection(Request $request)
    {
        $msg = $request->status;
        SubContractorCompanies::where(['id' => $request->id])->update(['status' => $msg]);
        $checkConnection = SubContractorCompanies::where(['id' => $request->id])->first();
        $companyDetails = User::where(['id' => $checkConnection->company_id])->first();
        return view('subcontractor.invitation', compact('checkConnection', 'companyDetails', 'msg'));
    }

    public function edit(Request $request, $id, $color_co)
    {
        if (\Auth::user()->can('edit sub contractor')) {
            $vender = User::find($id);
            $vender->customField = CustomField::getData($vender, 'vendor');
            $countrylist = Utility::getcountry();
            $statelist = Utility::getstate($vender->billing_country);
            $sellerstatelist = Utility::getstate($vender->shipping_country);
            $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())
                ->where('module', '=', 'vendor')->get();

            return view('subcontractor.edit', compact('vender','customFields',
                'countrylist', 'statelist', 'color_co','sellerstatelist'));
        } else {
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {

        $this->validationUpdateSubContractor($request,$id);
        $user = User::findOrFail($id);
        $fileNames = $this->upload($request);

        $post = [
            'name'             => $request->name,
            'lname'            => $request->lname,
            'email'            => $request->email,
            'type'             => 'sub_contractor',
            'lang'             => Utility::getValByName('default_language'),
            'created_by'       => \Auth::user()->creatorId(),
            'phone'            => $request->contact,
            'color_code'       => $request->color_code,
            'tax_number'       => $request->tax_number,
            'billing_name'     => $request->billing_name,
            'billing_country'  => $request->billing_country,
            'billing_state'    => $request->billing_state,
            'billing_city'     => $request->billing_city,
            'billing_phone'    => $request->billing_phone,
            'billing_zip'      => $request->billing_zip,
            'billing_address'  => $request->billing_address,
            'shipping_name'    => $request->shipping_name,
            'shipping_country' => $request->shipping_country,
            'shipping_state'   => $request->shipping_state,
            'shipping_city'    => $request->shipping_city,
            'shipping_phone'   => $request->shipping_phone,
            'shipping_zip'     => $request->shipping_zip,
            'shipping_address' => $request->shipping_address,
        ];

        if (!empty($fileNames)) {
            $post['avatar'] = $fileNames;
        }
        $user->update($post);

        CustomField::saveData($user, $request->customField);

        return redirect()->route('subcontractor.index')->with(
            'success', __('Consultant successfully updated.')
        );
    }

    public function validationCreateSubContractor($request){
        $validation = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
        ];

        $validator = \Validator::make($request->all(), $validation);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }
        else{
            return true;
        }
    }

    public function validationUpdateSubContractor($request,$id){
        $validation = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
        ];

        $validator = \Validator::make($request->all(), $validation);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }
        else{
            return true;
        }
    }

    public function update_subContractor(Request $request, $id)
    {

        $this->validationUpdateSubContractor($request,$id);
        $user = User::findOrFail($id);
        $fileNames = $this->upload($request);

        $post = [
            'name'             => $request->name,
            'lname'            => $request->lname,
            'email'            => $request->email,
            'type'             => 'sub_contractor',
            'lang'             => Utility::getValByName('default_language'),
            'created_by'       => \Auth::user()->creatorId(),
            'phone'            => $request->contact,
            'color_code'       => $request->color_code,
            'tax_number'       => $request->tax_number,
            'billing_name'     => $request->billing_name,
            'billing_country'  => $request->billing_country,
            'billing_state'    => $request->billing_state,
            'billing_city'     => $request->billing_city,
            'billing_phone'    => $request->billing_phone,
            'billing_zip'      => $request->billing_zip,
            'billing_address'  => $request->billing_address,
            'shipping_name'    => $request->shipping_name,
            'shipping_country' => $request->shipping_country,
            'shipping_state'   => $request->shipping_state,
            'shipping_city'    => $request->shipping_city,
            'shipping_phone'   => $request->shipping_phone,
            'shipping_zip'     => $request->shipping_zip,
            'shipping_address' => $request->shipping_address,
        ];
        if (!empty($fileNames)) {
            $post['avatar'] = $fileNames;
        }
        $user->update($post);

        Utility::employeeDetailsUpdate($user->id, \Auth::user()->creatorId());
        CustomField::saveData($user, $request->customField);

        return redirect()->route('subcontractor.index')->with(
            'success', __('Sub Contractor successfully updated.')
        );
    }

   

    public function userPassword($id)
    {
        try {
            $eId = \Crypt::decrypt($id);
            $user = User::find($eId);
            return view('subcontractor.reset', compact('user'));

        }
        catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function userPasswordReset(Request $request, $id)
    {
        try {

            $validator = \Validator::make(
                $request->all(), [
                    'password' => 'required|confirmed|same:password_confirmation',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $usercon = User::where('id', $id)->first();
            $usercon->forceFill([
                'password' => Hash::make($request->password),
            ])->save();

            return redirect()->route('subcontractor.index')->with(
                'success', __('Sub Contractor Password successfully updated.')
            );

        } catch (Exception $e) {

            return $e->getMessage();

        }

    }


    public function get_company_details(Request $request, $id)
    {
        try {
            $user = User::where('id', $id)->where('type', 'company')->first();
            return view('subcontractor.view', compact('user'));
        }
        catch (Exception $e) {
            return $e->getMessage();
        }

    }

    public function seach_result(Request $request)
    {
        try {

            $searchValue = $request['q'];

            if ($request->filled('q')) {
                $userlist = User::search($searchValue)
                    ->where('type', 'sub_contractor')
                    ->orderBy('name', 'ASC')
                    ->get();

            }

            $userData = array();
            if (count($userlist) > 0) {
                foreach ($userlist as $task) {
                    $setUser = [
                        'id' => $task->id,
                        'name' => $task->name,

                    ];
                    $userData[] = $setUser;
                }
            }
            echo json_encode($userData);
        }
        catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function invite_sub_contractor(Request $request)
    {
        try {
            return view('subcontractor.invite');
        }
        catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function store_invitation_status(Request $request)
    {

        try {
            if(!is_null($request->subcontractor_id)){
                $subcontractortid = explode(',', $request->subcontractor_id);

                foreach ($subcontractortid as $cid) {
    
                    $requesteddate = Config::get('constants.TIMESTUMP');
                    $createconnection = SubContractorCompanies::create([
                        "company_id" => \Auth::user()->creatorId(),
                        'sub_contractor_id' => $cid,
                        'requested_date' => $requesteddate,
                        'status' => 'requested',
                    ]);
                    $inviteUrl = url('') . Config::get('constants.INVITATION_URL_subcontractor').$createconnection->id;
                    $userarr = [
                        'invite_link' => $inviteUrl,
                        'user_name' => \Auth::user()->name,
                        'company_name' => \Auth::user()->company_name,
                        'email' => \Auth::user()->email,
                    ];
                    $get_email=DB::table('users')->where('id',$cid)->select('email')->first();
                    Utility::sendEmailTemplate('Invite Sub Contractor', [$cid => $get_email->email], $userarr);
    
                }
    
                return redirect()->route('subcontractor.index')
                    ->with('success', __('Sub Contractor Invitation Sent Successfully.'));
            }else{

                return redirect()->route('subcontractor.index')
                    ->with('error', __('There is no Subcontractor.'));
            }
            

        }
        catch (Exception $e) {
            return $e->getMessage();
        }
    }

}
