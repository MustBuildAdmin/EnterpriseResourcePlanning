<?php

namespace App\Http\Controllers;

use App\Models\CustomField;
use App\Models\Employee;
use App\Models\ExperienceCertificate;
use App\Models\GenerateOfferLetter;
use App\Models\JoiningLetter;
use App\Models\NOC;
use App\Models\User;
use App\Models\UserCompany;
use App\Models\Company_type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Utility;
use App\Models\Order;
use App\Models\Plan;
use App\Models\UserToDo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Session;
use Spatie\Permission\Models\Role;
use Config;


class ConsultantController extends Controller
{

    public function index(Request $request)
    {
        $user = \Auth::user();
        if(\Auth::user()->can('manage consultant'))
        {
            if(\Auth::user()->type == 'super admin')
            {
                $users =User::where([
                    ['name', '!=', Null],
                    [function ($query) use ($request) {
                        if (($s = $request->search)) {
                            $query->orWhere('name', 'LIKE', '%' . $s . '%')
                            ->get();
                        }
                    }]
                ])->where('created_by', '=', $user->creatorId())->where('type', '=', 'consultant')->paginate(8);
                $usercount=User::where('created_by', '=', $user->creatorId())
                                ->where('type', '=', 'consultant')
                                ->get()
                                ->count();
            }
            else
            {
                $users =User::where([
                    ['name', '!=', null],
                    [function ($query) use ($request) {
                        if (($s = $request->search)) {
                            $user = \Auth::user();
                            $query->orWhere('name', 'LIKE', '%' . $s . '%')
                            ->get();
                        }
                    }]
                ])->where('created_by', '=', $user->creatorId())->where('type', '=', 'consultant')->paginate(8);
                $usercount=User::where('created_by', '=', $user->creatorId())
                                ->where('type', '=', 'consultant')
                                ->get()
                                ->count();
            }
            
            return view('consultants.index')->with('users', $users)->with('usercount', $usercount);
        }
        else
        {
            return redirect()->back();
        }

    }

    public function create(Request $request)
    {

        $customFields = CustomField::where('created_by', '=', \Auth::user()
                        ->creatorId())
                        ->where('module', '=', 'user')
                        ->get();
        $user  = \Auth::user();
        $roles = Role::where('created_by', '=', $user->creatorId())
                ->where('name','!=','client')
                ->get()
                ->pluck('name', 'id');
        $gender=['male'=>'Male','female'=>'Female','other'=>'Other'];
        $company_type=Company_type::where('status',1)->get()->pluck('name', 'id');
        $users =User::where([
            ['name', '!=', null],
            [function ($query) use ($request) {
                if (($s = $request->search)) {
                    $user = \Auth::user();
                    $query->orWhere('name', 'LIKE', '%' . $s . '%')
                    ->get();
                }
            }]
        ])->where('created_by', '=', $user->creatorId())->get()->pluck('name', 'id');
        if(count($users)<=0){
            $users =User::where([
                ['name', '!=', null],
                [function ($query) use ($request) {
                    if (($s = $request->search)) {
                        $user = \Auth::user();
                        $query->orWhere('name', 'LIKE', '%' . $s . '%')
                        ->get();
                    }
                }]
            ])->where('id', '=', $user->creatorId())->get()->pluck('name', 'id');
        }
        if(\Auth::user()->can('create consultant'))
        {
            $country=Utility::getcountry();

            // return view('user.create', compact('roles','gender', 'customFields','country','company_type'));
            return view('consultants.create', compact('roles','gender', 'customFields','country','company_type','users'));
        }
        else
        {
            return redirect()->back();
        }
    }
    
    public function store(Request $request)
    {


        if(\Auth::user()->can('create consultant'))
        {
            $defaultlanguage = DB::table('settings')->select('value')->where('name', 'default_language')->first();
            
            
                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required|max:120',
                                       'email' => 'required|email|unique:users',
                                       'password' => 'required|min:6',
                                       'gender'=>'required'
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                if(isset($request->avatar)){
                    
                    $filenameWithExt = $request->file('avatar')->getClientOriginalName();
                    $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension       = $request->file('avatar')->getClientOriginalExtension();
                    $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                
                    $dir = Config::get('constants.USER_IMG');
                    $imagepath = $dir . $fileNameToStore;
                    if (\File::exists($imagepath)) {
                        \File::delete($imagepath);
                    }
                    $url = '';
                    $path = Utility::upload_file($request,'avatar',$fileNameToStore,$dir,[]);
    
                    if($path['flag'] == 1){
                        $url = $path['url'];
                    }else{
                        return redirect()->back()->with('error', __($path['msg']));
                    }

                }
                $user               = new User();
                $user['name']       = $request->name;
                $user['lname']       = $request->lname;
                $user['email']      = $request->email;
                $user['gender']      = $request->gender;
                $psw                = $request->password;
                $user['password']   = Hash::make($request->password);
                $user['type']       = 'company';
                $user['default_pipeline'] = 1;
                $user['plan'] = 1;
                $user['lang']       = !empty($defaultlanguage) ? $defaultlanguage->value : '';
                $user['created_by'] = \Auth::user()->creatorId();
                $user['country']=$request->country;
                $user['state']=$request->state;
                $user['city']=$request->city;
                $user['phone']=$request->phone;
                $user['zip']=$request->zip;
                $user['address']=$request->address;
                $user['company_type']       = $request->company_type;
                $user['color_code']=$request->color_code;
                $user['company_name']       = $request->company_name;
                if(isset($url)){
                    $user['avatar']=$url;
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
            
           
            // Send Email
            $setings = Utility::settings();

            if($setings['create_consultant'] == 1) {
                $user->password = $psw;
                $user->type = $role_r->name;

                $userArr = [
                    'email' => $user->email,
                    'password' => $user->password,
                ];
               

                $resp=Utility::sendEmailTemplate('create_consultant', [$user->id => $user->email], $userArr);

                return redirect()->route('consultants.index')->with('success', __('Consultant successfully created.') .
                ((!empty($resp) && $resp['is_success'] == false && !empty($resp['error'])) ? '' : ''));
            }
            return redirect()->route('consultants.index')->with('success', __('Consultant successfully created.'));

        }
        else
        {
            return redirect()->back();
        }

    }


  public function normal_store(Request $request){
    $validator = \Validator::make(
        $request->all(), [
                           'name' => 'required|max:120',
                           'email' => 'required|email|unique:users',
                           'password' => 'required|min:6',
                           'gender'=>'required'

                       ]
    );
    if($validator->fails())
    {
        $messages = $validator->getMessageBag();
        return redirect()->back()->with('error', $messages->first());
    }

    $defaultlanguage = DB::table('settings')->select('value')->where('name', 'default_language')->first();

    if(isset($request->avatar)){
        
        $filenameWithExt = $request->file('avatar')->getClientOriginalName();
        $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension       = $request->file('avatar')->getClientOriginalExtension();
        $fileNameToStore = $filename . '_' . time() . '.' . $extension;
    
        $dir = Config::get('constants.USER_IMG');
        $imagepath = $dir . $fileNameToStore;
        if (\File::exists($imagepath)) {
            \File::delete($imagepath);
        }
        $url = '';
        $path = Utility::upload_file($request,'avatar',$fileNameToStore,$dir,[]);

        if($path['flag'] == 1){
            $url = $path['url'];
        }else{
            return redirect()->back()->with('error', __($path['msg']));
        }

    }

    $objUser    = \Auth::user()->creatorId();
    $objUser =User::find($objUser);
    $user = User::find(\Auth::user()->created_by);
    $totaluser = $objUser->countUsers();
    $plan       = Plan::find($objUser->plan);
    if($totaluser < $plan->max_users || $plan->max_users == -1)
    {
        $role_r = Role::findByName('consultant');
        $psw                   = $request->password;
        $request['password']   = Hash::make($request->password);
        $request['type']       = 'consultant';
        $request['lang']       = !empty($defaultlanguage) ? $defaultlanguage->value : 'en';
        $request['created_by'] = \Auth::user()->creatorId();
        $request['gender']      = $request->gender;
    
        if(isset($url)){
            $request['avatar']=$url;
        }
       
        $user = User::create($request->all());
        $user->assignRole($role_r);
        $user->userDefaultDataRegister($user->id);
        if($request['type'] != 'client'){
            Utility::employeeDetails($user->id,\Auth::user()->creatorId());
        }
         
    }
    $setings = Utility::settings();

    if($setings['create_consultant'] == 1) {
        $user->password = $psw;
        $user->type = $role_r->name;

        $userArr = [
            'email' => $user->email,
            'password' => $user->password,
        ];
       

        $resp=Utility::sendEmailTemplate('create_consultant', [$user->id => $user->email], $userArr);

        return redirect()->route('consultants.index')->with('success', __('Consultant successfully created.') .
        ((!empty($resp) && $resp['is_success'] == false && !empty($resp['error'])) ? '' : ''));
    }
    else
    {
        return redirect()->back()->with('error', __('Your user limit is over, Please upgrade plan.'));
    }
  }

    public function edit(Request $request,$id,$color_co)
    {
        $user  = \Auth::user();
        $roles = Role::where('created_by', '=', $user->creatorId())
                ->where('name','!=','client')
                ->get()
                ->pluck('name', 'id');
        $gender=['male'=>'Male','female'=>'Female','other'=>'Other'];
        $company_type=Company_type::get()->pluck('name', 'id');
        if(\Auth::user()->can('edit consultant'))
        {
            $user              = User::findOrFail($id);
          
            $countrylist=Utility::getcountry();
            $statelist=Utility::getstate($user->country);
            $user->customField = CustomField::getData($user, 'user');
            $customFields      = CustomField::where('created_by', '=', \Auth::user()
                                ->creatorId())
                                ->where('module', '=', 'user')
                                ->get();
            $users =User::where([
                ['name', '!=', null],
                [function ($query) use ($request) {
                    if (($s = $request->search)) {
                        $user = \Auth::user();
                        $query->orWhere('name', 'LIKE', '%' . $s . '%')
                        ->get();
                    }
                }]
            ])->where('created_by', '=', $user->creatorId())
            ->where('id', '!=', $id)
            ->orwhere('id', '=', $user->creatorId())
            ->get()
            ->pluck('name', 'id');
          
            return view('consultants.edit', compact('user','gender', 'roles', 'customFields',
                        'countrylist','statelist','company_type','users','color_co'));
        }
        else
        {
            return redirect()->back();
        }

    }


    public function update(Request $request, $id)
    {
      
      
        if(\Auth::user()->can('edit consultant'))
        {
            if(\Auth::user()->type == 'super admin')
            {
                $user = User::findOrFail($id);
                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required|max:120',
                                       'email' => 'required|email|unique:users,email,' . $id,
                                       'gender'=>'required'
                                   ]
                );
                $this->validator_alert($validator);

                $img=$request->avatar;
                $this->image_upload($img);
                $input = $request->all();
        
                $input['color_code']=$request->color_code;
             
                $this->image_url($user);
                $user->fill($input)->save();
                CustomField::saveData($user, $request->customField);
                DB::table('users')->where('id',$id)->update(['company_type'=>$request->company_type]);

                $insert2=array(
                    'name'=>'company_type',
                    'value'=>$request->company_type,
                );
                $data =DB::table('settings')->where('created_by',$id)->update($insert2);


                return redirect()->route('consultants.index')->with(
                    'success', 'Consultant successfully updated.'
                );
            }
            else
            {
                $user = User::findOrFail($id);
                $validator = \Validator::make(
                    $request->all(), [
                                        'name' => 'required|max:120',
                                        'email' => 'required|email|unique:users,email,' . $id,
                                        'gender'=>'required'
                                   ]
                );
                $this->validator_alert($validator);
                $img=$request->avatar;
                $this->image_upload($img);
                $input         = $request->all();
                $this->image_url($user);
                $user->fill($input)->save();
                Utility::employeeDetailsUpdate($user->id,\Auth::user()->creatorId());
                CustomField::saveData($user, $request->customField);
                return redirect()->route('consultants.index')->with(
                    'success', 'Consultant successfully updated.'
                );
            }
        }
        else
        {
            dd();
            return redirect()->back();
        }
    }



    public function destroy($id)
    {

        if(\Auth::user()->can('delete consultant'))
        {
            $user = User::find($id);
            if($user)
            {
                if(\Auth::user()->type == 'super admin')
                {
                    if($user->is_deleted == 0)
                    {
                        $user->is_deleted = 1;
                    }
                    else
                    {
                        $user->is_deleted = 0;
                    }
                    $user->save();
                }
                if(\Auth::user()->type == 'consultant')
                {
                    $employee = Employee::where(['user_id' => $user->id])->delete();
                    if($employee){
                        $deleteuser = User::where(['id' => $user->id])->delete();
                        if($deleteuser){
                            return redirect()->route('consultants.index')
                                             ->with('success', __('Consultant successfully deleted .'));
                        }else{
                            return redirect()->back()->with('error', __('Something is wrong.'));
                        }
                    }else{
                        return redirect()->back()->with('error', __('Something is wrong.'));
                    }
                }

                return redirect()->route('consultants.index')->with('error', __('Consultant permission denied.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Something is wrong.'));
            }
        }
        else
        {
            return redirect()->back();
        }
    }

    

    public function userPassword($id)
    {
        $eId        = \Crypt::decrypt($id);
        $user = User::find($eId);

        return view('consultants.reset', compact('user'));

    }

    public function userPasswordReset(Request $request, $id)
    {
       
        $validator = \Validator::make(
            $request->all(), [
                               'password' => 'required|confirmed|same:password_confirmation',
                           ]
        );

        if($validator->fails())
        {
            $messages = $validator->getMessageBag();
            

            return redirect()->back()->with('error', $messages->first());
        }


        $user                 = User::where('id', $id)->first();
        $user->forceFill([
                             'password' => Hash::make($request->password),
                         ])->save();

        return redirect()->route('consultants.index')->with(
            'success', 'Consultants Password successfully updated.'
        );


    }

    public function scott_search(Request $request)
    {
          
        return view('consultants.scott-search');
    }

    public function scott_result(Request $request)
    {
        if($request->filled('search')){
            $users = User::search($request->search)->where('type','consultant')->get();
        }else{
            $users = array();
        }

        $returnHTML = view("consultants.result",compact('users'))->render();

        return response()->json([
            "success" => true,
            "html" => $returnHTML,
        ]);
          
    }


}
