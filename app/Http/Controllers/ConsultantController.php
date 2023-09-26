<?php

namespace App\Http\Controllers;

use App\Models\Company_type;
use App\Models\CustomField;
use App\Models\Employee;
use App\Models\ExperienceCertificate;
use App\Models\GenerateOfferLetter;
use App\Models\JoiningLetter;
use App\Models\NOC;
use App\Models\User;
use App\Models\UserCompany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Utility;
use App\Models\ConsultantCompanies;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Plan;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Exception;

class ConsultantController extends Controller
{
    public function index(Request $request)
    {
        $user = \Auth::user();
        if (\Auth::user()->can('manage consultant')) {
            $users = User::where([
                ['name', '!=', null],
                [function ($query) use ($request) {
                    if (($s = $request->search)) {
                        $query->orWhere('name', 'LIKE', '%'.$s.'%')
                            ->get();
                    }
                }],
            ])->where('created_by', '=', $user->creatorId())->where('type', '=', 'consultant')->paginate(8);
            $usercount = User::where('created_by', '=', $user->creatorId())
                ->where('type', '=', 'consultant')
                ->get()
                ->count();

            return view('consultants.index')->with('users', $users)->with('usercount', $usercount);
        } else {
            return redirect()->back();
        }

    }

    public function validationCreateConsultant($request){
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

    public function create(Request $request)
    {

        $customFields = CustomField::where('created_by', '=', \Auth::user()
            ->creatorId())
            ->where('module', '=', 'user')
            ->get();
        $user = \Auth::user();
        $roles = Role::where('created_by', '=', $user->creatorId())
            ->where('name', '!=', 'client')
            ->get()
            ->pluck('name', 'id');
        $gender = ['male' => 'Male', 'female' => 'Female', 'other' => 'Other'];
        $company_type = Company_type::where('status', 1)->get()->pluck('name', 'id');
        $users = User::where([
            ['name', '!=', null],
            [function ($query) use ($request) {
                if (($s = $request->search)) {
                    $user = \Auth::user();
                    $query->orWhere('name', 'LIKE', '%'.$s.'%')
                        ->get();
                }
            }],
        ])->where('created_by', '=', $user->creatorId())->get()->pluck('name', 'id');
        if (count($users) <= 0) {
            $users = User::where([
                ['name', '!=', null],
                [function ($query) use ($request) {
                    if (($s = $request->search)) {
                        $user = \Auth::user();
                        $query->orWhere('name', 'LIKE', '%'.$s.'%')
                            ->get();
                    }
                }],
            ])->where('id', '=', $user->creatorId())->get()->pluck('name', 'id');
        }
        if (\Auth::user()->can('create consultant')) {
            $country = Utility::getcountry();

            return view('consultants.create', compact('roles', 'gender', 'customFields',
                'country', 'company_type', 'users'));
        } else {
            return redirect()->back();
        }
    }

    public function upload($request)
    {
        if (isset($request->avatar)) {

            $filenameWithExt = $request->file('avatar')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('avatar')->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            $dir = Config::get('constants.USER_IMG');
            $imagepath = $dir.$fileNameToStore;
            if (\File::exists($imagepath)) {
                \File::delete($imagepath);
            }

            Utility::upload_file($request, 'avatar', $fileNameToStore, $dir, []);

            return $fileNameToStore;

        }
    }

    public function store(Request $request)
    {
        $this->validationCreateConsultant($request);
        $defaultlanguage = DB::table('settings')->select('value')->where('name', 'default_language')->first();
        $fileNames = $this->upload($request);
        $user = new User();
        $user['name'] = $request->name;
        $user['lname'] = $request->lname;
        $user['email'] = $request->email;
        $user['gender'] = $request->gender;
        $psw = $request->password;
        $user['password'] = Hash::make($request->password);
        $user['type'] = 'consultant';
        $user['default_pipeline'] = 1;
        $user['plan'] = 1;
        $user['lang'] = ! empty($defaultlanguage) ? $defaultlanguage->value : '';
        $user['created_by'] = \Auth::user()->creatorId();
        $user['country'] = $request->country;
        $user['state'] = $request->state;
        $user['city'] = $request->city;
        $user['phone'] = $request->phone;
        $user['zip'] = $request->zip;
        $user['address'] = $request->address;
        $user['company_type'] = $request->company_type;
        $user['color_code'] = $request->color_code;
        $user['company_name'] = $request->company_name;
        if (isset($fileNames)) {
            $user['avatar'] = $fileNames;
        }
        $user->save();
        $role_r = Role::findByName('consultant');
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
        $requested_date = Config::get('constants.TIMESTUMP');
        $createConnection = ConsultantCompanies::create([
            "company_id"=>\Auth::user()->creatorId(),
            'consultant_id'=>$user->id,
            'requested_date'=>$requested_date,
            'status'=>'requested'
        ]);
        $inviteUrl=url('').Config::get('constants.INVITATION_URL').$createConnection->id;
        $userArr = [
            'invite_link' => $inviteUrl,
            'user_name' => \Auth::user()->name,
            'company_name' => \Auth::user()->company_name,
            'email' => \Auth::user()->email,
        ];
        Utility::sendEmailTemplate('invite_consultant', [$user->id => $user->email], $userArr);
           

        $setings = Utility::settings();

        if ($setings['create_consultant'] == 1) {
            $user->password = $psw;
            $user->type = $role_r->name;

            $userArr = [
                'email' => $user->email,
                'password' => $user->password,
            ];
            Utility::sendEmailTemplate('create_consultant', [$user->id => $user->email], $userArr);

        }

        return redirect()->route('consultants.index')->with('success', Config::get('constants.CONSULTANT_MAIL'));
    }
    
    public function createConnection(Request $request){
        // Need to check invitation link is valid or expired based on that need to redirect
        $checkConnection=ConsultantCompanies::where(['id'=>$request->id])->first();
        $companyDetails=User::where(['id'=>$checkConnection->company_id])->first();
        $requestedDate= Carbon::parse($checkConnection->requested_date)->format('Y-m-d');
        $expiryDate=  Carbon::parse($requestedDate)->addDays(7)->format('Y-m-d');
        $checkValidity= Carbon::now()->between($requestedDate, $expiryDate);
        $msg='expired';
        if($checkValidity && $checkConnection->status=='requested'){
            $msg='valid';
        }else{
            if($checkConnection->status=='requested'){
                ConsultantCompanies::where(['id'=>$request->id])->update(['status'=>'expired']);
            }else{
                $msg=$checkConnection->status;
            }
        }
        return view('consultants.invitation', compact('checkConnection','companyDetails','msg'));
    }

    public function submitConnection(Request $request){
        $msg=$request->status;
        ConsultantCompanies::where(['id'=>$request->id])->update(['status'=>$msg]);
        $checkConnection=ConsultantCompanies::where(['id'=>$request->id])->first();
        $companyDetails=User::where(['id'=>$checkConnection->company_id])->first();
        return view('consultants.invitation', compact('checkConnection','companyDetails','msg'));
    }

    public function normal_store(Request $request)
    {
       
        $this->validationCreateConsultant($request);
        $fileNames = $this->upload($request);

        $objUser = \Auth::user()->creatorId();
        $objUser = User::find($objUser);
        $user = User::find(\Auth::user()->created_by);
        $totaluser = $objUser->countUsers();
        $plan = Plan::find($objUser->plan);
        if ($totaluser < $plan->max_users || $plan->max_users == -1) {

            $psw = $request->password;

            if ($fileNames != null) {
                $avatar = $fileNames;
            } else {
                $avatar = null;
            }

            $user = User::create(
                [
                    'name' => $request->name,
                    'lname' => $request->lname,
                    'email' => $request->email,
                    'type' => 'consultant',
                    'gender' => $request->gender,
                    'password' => Hash::make($request->password),
                    'lang' => Utility::getValByName('default_language'),
                    'created_by' => \Auth::user()->creatorId(),
                    'country' => $request->country,
                    'state' => $request->state,
                    'city' => $request->city,
                    'phone' => $request->phone,
                    'zip' => $request->zip,
                    'avatar' => $avatar,
                    'address' => $request->address,
                    'color_code' => $request->color_code,
                ]
            );
            $roler = Role::findByName('consultant');
            $user->assignRole($roler);
            $user->userDefaultDataRegister($user->id);

        }
        $setings = Utility::settings();
        $requested_date = Config::get('constants.TIMESTUMP');
        $createConnection = ConsultantCompanies::create([
            "company_id"=>\Auth::user()->creatorId(),
            'consultant_id'=>$user->id,
            'requested_date'=>$requested_date,
            'status'=>'requested'
        ]);
        $inviteUrl=url('').Config::get('constants.INVITATION_URL').$createConnection->id;
        $userArr = [
            'invite_link' => $inviteUrl,
            'user_name' => \Auth::user()->name,
            'company_name' => \Auth::user()->company_name,
            'email' => \Auth::user()->email,
        ];
        Utility::sendEmailTemplate('invite_consultant', [$user->id => $user->email], $userArr);
        


        if ($setings['create_consultant'] == 1) {
            $user->password = $psw;
            $user->type = 'consultant';

            $userArr = [
                'email' => $user->email,
                'password' => $user->password,
            ];

            Utility::sendEmailTemplate('create_consultant', [$user->id => $user->email], $userArr);

            return redirect()->route('consultants.index')->with('success', Config::get('constants.CONSULTANT_MAIL'));
        } else {
            return redirect()->back()->with('error', __('Your user limit is over, Please upgrade plan.'));
        }
    }

    public function edit(Request $request, $id, $color_co)
    {
        $user = \Auth::user();
        $roles = Role::where('created_by', '=', $user->creatorId())
            ->where('name', '!=', 'client')
            ->get()
            ->pluck('name', 'id');
        $gender = ['male' => 'Male', 'female' => 'Female', 'other' => 'Other'];
        $company_type = Company_type::get()->pluck('name', 'id');
        if (\Auth::user()->can('edit consultant')) {
            $user = User::findOrFail($id);

            $countrylist = Utility::getcountry();
            $statelist = Utility::getstate($user->country);
            $user->customField = CustomField::getData($user, 'user');
            $customFields = CustomField::where('created_by', '=', \Auth::user()
                ->creatorId())
                ->where('module', '=', 'user')
                ->get();
            $users = User::where([
                ['name', '!=', null],
                [function ($query) use ($request) {
                    if (($s = $request->search)) {
                        $user = \Auth::user();
                        $query->orWhere('name', 'LIKE', '%'.$s.'%')
                            ->get();
                    }
                }],
            ])->where('created_by', '=', $user->creatorId())
                ->where('id', '!=', $id)
                ->orwhere('id', '=', $user->creatorId())
                ->get()
                ->pluck('name', 'id');

            return view('consultants.edit', compact('user', 'gender', 'roles', 'customFields',
                'countrylist', 'statelist', 'company_type', 'users', 'color_co'));
        } else {
            return redirect()->back();
        }

    }

    public function validationUpdateConsultant($request,$id){
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

    public function update(Request $request, $id)
    {
        $this->validationUpdateConsultant($request,$id);
        $user = User::findOrFail($id);
        $fileNames = $this->upload($request);

        $post = [
            'name' => $request->name,
            'lname' => $request->lname,
            'email' => $request->email,
            'type' => 'consultant',
            'gender' => $request->gender,
            'lang' => Utility::getValByName('default_language'),
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'phone' => $request->phone,
            'zip' => $request->zip,
            'address' => $request->address,
            'color_code' => $request->color_code,
            'created_by' => \Auth::user()->creatorId(),
        ];

        if (! empty($fileNames)) {
            $post['avatar'] = $fileNames;

        }
        $user->update($post);

        CustomField::saveData($user, $request->customField);

        return redirect()->route('consultants.index')->with(
            'success', __('Consultant successfully updated.')
        );
    }

    public function update_consultant(Request $request, $id)
    {

        $this->validationUpdateConsultant($request,$id);
        $user = User::findOrFail($id);
        $fileNames = $this->upload($request);

        $input = $request->all();
        $input['type'] = 'consultant';
        if (isset($fileNames)) {
            $input['avatar'] = $fileNames;
        }
        $user->fill($input)->save();
        Utility::employeeDetailsUpdate($user->id, \Auth::user()->creatorId());
        CustomField::saveData($user, $request->customField);

        return redirect()->route('consultants.index')->with(
            'success', __('Consultant successfully updated.')
        );

    }

    

    public function userPassword($id)
    {
        try {

            $eId = \Crypt::decrypt($id);
            $user = User::find($eId);
    
            return view('consultants.reset', compact('user'));
          
        } catch (Exception $e) {
          
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
    
            $user = User::where('id', $id)->first();
            $user->forceFill([
                'password' => Hash::make($request->password),
            ])->save();
    
            return redirect()->route('consultants.index')->with(
                'success', __('Consultants Password successfully updated.')
            );

          
        } catch (Exception $e) {
          
            return $e->getMessage();
          
        }

    }



    public function get_company_details(Request $request,$id){

        try {


            $user=User::where('id',$id)->where('type','company')->first();

            return view('consultants.view',compact('user'));
          
          
        } catch (Exception $e) {
          
            return $e->getMessage();
          
        }
        
      

    }

    public function seach_result(Request $request){

        try {

            $searchValue = $request['q'];

            if($request->filled('q')){
                $userlist = User::search($searchValue)
                                ->where('type','consultant')
                                ->orderBy('name','ASC')
                                ->get();
                
            }

            $userData = array();
            if(count($userlist) > 0){
                foreach($userlist as $task){
                    $setUser = [
                        'id' => $task->id,
                        'name' => $task->name,

                    ];
                    $userData[] = $setUser;
                }
            }

            echo json_encode($userData);
          
    
        } catch (Exception $e) {
          
              return $e->getMessage();
          
        }

       
    }

    public function invite_consultant(Request $request){

        try {


              return view('consultants.invite');
          
          
        } catch (Exception $e) {
          
            
          
              return $e->getMessage();
          
        }
        
       

    }


    public function store_invitation_status(Request $request){
       
        try {

  
            $consulantid = explode(',', $request->consulant_id);

            foreach($consulantid as $cid){
    
                $requested_date = Config::get('constants.TIMESTUMP');
                $createConnection = ConsultantCompanies::create([
                    "company_id"=>\Auth::user()->creatorId(),
                    'consultant_id'=>$cid,
                    'requested_date'=>$requested_date,
                    'status'=>'requested'
                ]);
                $inviteUrl=url('').Config::get('constants.INVITATION_URL').$createConnection->id;
                $userArr = [
                    'invite_link' => $inviteUrl,
                    'user_name' => \Auth::user()->name,
                    'company_name' => \Auth::user()->company_name,
                    'email' => \Auth::user()->email,
                ];
    
                Utility::sendEmailTemplate('invite_consultant', [$cid => \Auth::user()->email], $userArr);
            
            }

                return redirect()->route('consultants.index')
                             ->with('success', __('Consultant Invitation Sent Successfully.'));
   
    
        } catch (Exception $e) {
          
               return $e->getMessage();
          
        }

       

    }


}
