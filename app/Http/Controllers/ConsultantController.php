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
            return view('consultants.create', compact('roles','gender', 'customFields',
                        'country','company_type','users'));
        }
        else
        {
            return redirect()->back();
        }
    }
    
    public function store(Request $request)
    {

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
                $user               = new User();
                $user['name']       = $request->name;
                $user['lname']       = $request->lname;
                $user['email']      = $request->email;
                $user['gender']      = $request->gender;
                $psw                = $request->password;
                $user['password']   = Hash::make($request->password);
                $user['type']       = 'consultant';
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
                if(isset($fileNameToStore)){
                    $user['avatar']=$fileNameToStore;
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
        
            $setings = Utility::settings();

            if($setings['create_consultant'] == 1) {
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
 

  public function normal_store(Request $request){

   
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
        
        $psw = $request->password;
    
        if(isset($fileNameToStore)){
            $avatar=$fileNameToStore;
        }else{
            $avatar=null;
        }
      
        $user = User::create(
            [
                'name' => $request->name,
                'lname' => $request->lname,
                'email' => $request->email,
                'type'=> 'consultant',
                'gender'=> $request->gender,
                'password' => Hash::make($request->password),
                'lang' => Utility::getValByName('default_language'),
                'created_by' => \Auth::user()->creatorId(),
                'country'=>$request->country,
                'state'=>$request->state,
                'city'=>$request->city,
                'phone'=>$request->phone,
                'zip'=>$request->zip,
                'avatar'=>$avatar,
                'address'=>$request->address,
                'color_code'=>$request->color_code,
            ]
        );

        $user->userDefaultDataRegister($user->id);
    
    }
    $setings = Utility::settings();

    if($setings['create_consultant'] == 1) {
        $user->password = $psw;
        $user->type = 'consultant';

        $userArr = [
            'email' => $user->email,
            'password' => $user->password,
        ];
       

        Utility::sendEmailTemplate('create_consultant', [$user->id => $user->email], $userArr);

        return redirect()->route('consultants.index')->with('success', Config::get('constants.CONSULTANT_MAIL'));
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

        $user = User::findOrFail($id);
        if(isset($request->avatar)){
            
            $filenameWithExt = $request->file('avatar')->getClientOriginalName();
            $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension       = $request->file('avatar')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
        
            $dir = Config::get('constants.USER_IMG');
            $image_path = $dir . $fileNameToStore;
            if (\File::exists($image_path)) {
                \File::delete($image_path);
            }
         
            $path = Utility::upload_file($request,'avatar',$fileNameToStore,$dir,[]);

            if($path['flag'] == 1){
                $url = $path['url'];
            }else{
                return redirect()->back()->with('error', __($path['msg']));
            }

        }

        $post =[
                'name' => $request->name,
                'lname' => $request->lname,
                'email' => $request->email,
                'type'=> 'consultant',
                'gender'=> $request->gender,
                'password' => Hash::make($request->password),
                'lang' => Utility::getValByName('default_language'),
                'country'=>$request->country,
                'state'=>$request->state,
                'city'=>$request->city,
                'phone'=>$request->phone,
                'zip'=>$request->zip,
                'address'=>$request->address,
                'color_code'=>$request->color_code,
                'created_by' => \Auth::user()->creatorId(),
        ];

        if(!empty($request->avatar))
        {
            $post['avatar']=$fileNameToStore;
            
        }
        $user->update($post);

        CustomField::saveData($user, $request->customField);
        
        return redirect()->route('consultants.index')->with(
            'success', 'User successfully updated.'
        );
    }
    


    public function update_consultant(Request $request, $id)
    {
      
        $user = User::findOrFail($id);
        if(isset($request->avatar)){
            
            $filenameWithExt = $request->file('avatar')->getClientOriginalName();
            $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension       = $request->file('avatar')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
        
            $dir = Config::get('constants.USER_IMG');
            $image_path = $dir . $fileNameToStore;
            if (\File::exists($image_path)) {
                \File::delete($image_path);
            }
           
            $path = Utility::upload_file($request,'avatar',$fileNameToStore,$dir,[]);

            if($path['flag'] == 1){
                $url = $path['url'];
            }else{
                return redirect()->back()->with('error', __($path['msg']));
            }

        }

        $input         = $request->all();
        $input['type'] = 'consultant';
        if(isset($fileNameToStore)){
            $input['avatar']=$fileNameToStore;
        }
        $user->fill($input)->save();
        Utility::employeeDetailsUpdate($user->id,\Auth::user()->creatorId());
        CustomField::saveData($user, $request->customField);
        return redirect()->route('consultants.index')->with(
            'success', 'User successfully updated.'
        );
               
   
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
