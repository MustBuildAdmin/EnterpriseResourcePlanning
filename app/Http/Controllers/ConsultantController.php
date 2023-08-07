<?php

namespace App\Http\Controllers;

use App\Models\CustomField;
use App\Models\Employee;
use App\Models\ExperienceCertificate;
use App\Models\GenerateOfferLetter;
use App\Models\JoiningLetter;
use App\Models\NOC;
use App\Models\Consultant;
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
                $users =Consultant::where([
                    ['name', '!=', Null],
                    [function ($query) use ($request) {
                        if (($s = $request->search)) {
                            $user = \Auth::user();
                            $query->orWhere('name', 'LIKE', '%' . $s . '%')
                            ->get();
                        }
                    }]
                ])->where('created_by', '=', $user->creatorId())->paginate(8);
                $user_count=Consultant::where('created_by', '=', $user->creatorId())->get()->count();
                // $users = Consultant::where('created_by', '=', $user->creatorId())->get();
            }
            else
            {
                // $users = Consultant::where('created_by', '=', $user->creatorId())->get();
                $users =Consultant::where([
                    ['name', '!=', Null],
                    [function ($query) use ($request) {
                        if (($s = $request->search)) {
                            $user = \Auth::user();
                            $query->orWhere('name', 'LIKE', '%' . $s . '%')
                            ->get();
                        }
                    }]
                ])->where('created_by', '=', $user->creatorId())->paginate(8);
                $user_count=Consultant::where('created_by', '=', $user->creatorId())->get()->count();
            }
            
            // return view('user.index')->with('users', $users);
            return view('consultants.index')->with('users', $users)->with('user_count', $user_count);
        }
        else
        {
            return redirect()->back();
        }

    }

    public function create(Request $request)
    {

        $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'user')->get();
        $user  = \Auth::user();
        $roles = Role::where('created_by', '=', $user->creatorId())->where('name','!=','client')->get()->pluck('name', 'id');
        $gender=['male'=>'Male','female'=>'Female','other'=>'Other'];
        $company_type=Company_type::where('status',1)->get()->pluck('name', 'id');
        $users =Consultant::where([
            ['name', '!=', Null],
            [function ($query) use ($request) {
                if (($s = $request->search)) {
                    $user = \Auth::user();
                    $query->orWhere('name', 'LIKE', '%' . $s . '%')
                    ->get();
                }
            }]
        ])->where('created_by', '=', $user->creatorId())->get()->pluck('name', 'id');
        if(count($users)<=0){
            $users =Consultant::where([
                ['name', '!=', Null],
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

        if($request->reporting_to!=null){
            $string_version = implode(',', $request->reporting_to);
        }else{
            $string_version = Null;
        }
       

        if(\Auth::user()->can('create consultant'))
        {
            $default_language = DB::table('settings')->select('value')->where('name', 'default_language')->first();
            if(\Auth::user()->type == 'super admin')
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required|max:120',
                                       'email' => 'required|email|unique:consultants',
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
                    $image_path = $dir . $fileNameToStore;
                    if (\File::exists($image_path)) {
                        \File::delete($image_path);
                    }
                    $url = '';
                    $path = Utility::upload_file($request,'avatar',$fileNameToStore,$dir,[]);
    
                    if($path['flag'] == 1){
                        $url = $path['url'];
                    }else{
                        return redirect()->back()->with('error', __($path['msg']));
                    }

                }
                $user               = new Consultant();
                $user['name']       = $request->name;
                $user['email']      = $request->email;
                $user['gender']      = $request->gender;
                $user['phone']      = $request->phone;
                $user['created_by'] = \Auth::user()->creatorId();
                $user['country']=$request->country;
                $user['state']=$request->state;
                $user['city']=$request->city;
                $user['zip']=$request->zip;
                $user['address']=$request->address;
                $user['type']='Consultant';
                $user['color_code']=$request->color_code;
                if(isset($url)){
                    $user['avatar']=$url;
                }
                $user->save();
                // $role_r = Role::findByName('company');
                // $user->assignRole($role_r);
            }
            else
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required|max:120',
                                       'email' => 'required|email|unique:consultants',
                                       'gender'=>'required'

                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();
                    return redirect()->back()->with('error', $messages->first());
                }


                $objUser    = \Auth::user()->creatorId();
                $objUser =Consultant::find($objUser);
                $user = Consultant::find(\Auth::user()->created_by);
                $request['created_by'] = \Auth::user()->creatorId();
                $request['gender']      = $request->gender;
                $user = Consultant::create($request->all());
                // if($request['type'] != 'client')
                    // \App\Models\Utility::employeeDetails($user->id,\Auth::user()->creatorId());
               
            }
            // Send Email
            $setings = Utility::settings();

            if($setings['create_user'] == 1) {
             
                $user->password = $this->generateRandomString();
                $user->type = 'Consultant';

                $userArr = [
                    'email' => $user->email,
                    'password' => $user->password,
                ];
                $resp = Utility::sendEmailTemplate('create_user', [$user->id => $user->email], $userArr);

                return redirect()->route('consultants.index')->with('success', __('User successfully created.') . ((!empty($resp) && $resp['is_success'] == false && !empty($resp['error'])) ? '' : ''));
            }
            return redirect()->route('consultants.index')->with('success', __('Consultant successfully created.'));

        }
        else
        {
            return redirect()->back();
        }

    }

    public function edit(Request $request,$id)
    {
        $user  = \Auth::user();
        $roles = Role::where('created_by', '=', $user->creatorId())->where('name','!=','client')->get()->pluck('name', 'id');
        $gender=['male'=>'Male','female'=>'Female','other'=>'Other'];
        $company_type=Company_type::get()->pluck('name', 'id');
        if(\Auth::user()->can('edit consultant'))
        {
            $user              = Consultant::findOrFail($id);
          
            $countrylist=Utility::getcountry();
            $statelist=Utility::getstate($user->country);
            $user->customField = CustomField::getData($user, 'user');
            $customFields      = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'user')->get();
            $users =Consultant::where([
                ['name', '!=', Null],
                [function ($query) use ($request) {
                    if (($s = $request->search)) {
                        $user = \Auth::user();
                        $query->orWhere('name', 'LIKE', '%' . $s . '%')
                        ->get();
                    }
                }]
            ])->where('created_by', '=', $user->creatorId())->where('id', '!=', $id)->orwhere('id', '=', $user->creatorId())->get()->pluck('name', 'id');
          

            // return view('user.edit', compact('user','gender', 'roles', 'customFields','countrylist','statelist','company_type'));
            return view('consultants.edit', compact('user','gender', 'roles', 'customFields','countrylist','statelist','company_type','users'));
        }
        else
        {
            return redirect()->back();
        }

    }


    public function update(Request $request, $id)
    {
      
        if($request->reporting_to!=null){
            $string_version = implode(',', $request->reporting_to);
        }else{
            $string_version = null;
        }
       
        if(\Auth::user()->can('edit consultant'))
        {
            if(\Auth::user()->type == 'super admin')
            {
                $user = Consultant::findOrFail($id);
                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required|max:120',
                                       'email' => 'required|email|unique:users,email,' . $id,
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
                    $image_path = $dir . $fileNameToStore;
                    if (\File::exists($image_path)) {
                        \File::delete($image_path);
                    }
                    $url = '';
                    $path = Utility::upload_file($request,'avatar',$fileNameToStore,$dir,[]);
    
                    if($path['flag'] == 1){
                        $url = $path['url'];
                    }else{
                        return redirect()->back()->with('error', __($path['msg']));
                    }

                }
                $role = Role::findByName('company');
                $input = $request->all();
                $input['type'] = $role->name;
                // $input['reporting_to']=$string_version;
                if(isset($url)){
                    $input['avatar']=$url;
                }
                $user->fill($input)->save();
                CustomField::saveData($user, $request->customField);
                DB::table('users')->where('id',$id)->update(['company_type'=>$request->company_type]);

                $insert2=array(
                    'name'=>'company_type',
                    'value'=>$request->company_type,
                );
                $data =DB::table('settings')->where('created_by',$id)->update($insert2);

                $roles[] = $role->id;
                $user->roles()->sync($roles);

                return redirect()->route('consultants.index')->with(
                    'success', 'User successfully updated.'
                );
            }
            else
            {
                $user = Consultant::findOrFail($id);
                $validator = \Validator::make(
                    $request->all(), [
                                        'name' => 'required|max:120',
                                        'email' => 'required|email|unique:users,email,' . $id,
                                        'role' => 'required',
                                        'gender'=>'required'
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();
                    return redirect()->back()->with('error', $messages->first());
                }

                // $role          = Role::findById($request->role);
                $input         = $request->all();
                $input['type']='Consultant';
                $input['color_code']=$request->color_code;
                $input['reporting_to']=$string_version;
                $user->fill($input)->save();
                // Utility::employeeDetailsUpdate($user->id,\Auth::user()->creatorId());
                // CustomField::saveData($user, $request->customField);

                $roles[] = $request->role;
                $user->roles()->sync($roles);

                return redirect()->route('consultants.index')->with(
                    'success', 'User successfully updated.'
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
            $user = Consultant::find($id);
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
                if(\Auth::user()->type == 'company')
                {
                    $employee = Employee::where(['user_id' => $user->id])->delete();
                    if($employee){
                        $delete_user = Consultant::where(['id' => $user->id])->delete();
                        if($delete_user){
                            return redirect()->route('consultants.index')->with('success', __('User successfully deleted .'));
                        }else{
                            return redirect()->back()->with('error', __('Something is wrong.'));
                        }
                    }else{
                        return redirect()->back()->with('error', __('Something is wrong.'));
                    }
                }

                return redirect()->route('consultants.index')->with('error', __('User permission denied.'));
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

    public function check_duplicate_email_consultant(Request $request){
        
        try {
            $formname  = $request->form_name;
            $checkname = $request->get_name;
            $getid     = $request->get_id;
    
            if($formname == "Users"){
                if($getid == null){
                    $getcheckval = Consultant::where('email',$checkname)->first();
                }
                else{
                    $getcheckval = Consultant::where('email',$checkname)->where('id','!=',$getid)->first();
                }
            }
            else{
                $getcheckval = "Not Empty";
            }
        
            if($getcheckval == null){
                return 1; //Success
            }
            else{
                return 0; //Error
            }
        
        } catch (Exception $e) {

            return $e->getMessage();

        }
        
    
    }

    public function userPassword($id)
    {
        $eId        = \Crypt::decrypt($id);
        $user = Consultant::find($eId);

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


        $user                 = Consultant::where('id', $id)->first();
        $user->forceFill([
                             'password' => Hash::make($request->password),
                         ])->save();

        return redirect()->route('consultants.index')->with(
            'success', 'User Password successfully updated.'
        );


    }


}
