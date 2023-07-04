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
use Auth;
use File;
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



class ConsultantController extends Controller
{

    public function index(Request $request)
    {
        $user = \Auth::user();
        if(\Auth::user()->can('manage user'))
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
        if(\Auth::user()->can('create user'))
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
       

        if(\Auth::user()->can('create user'))
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
                $user               = new Consultant();
                $user['name']       = $request->name;
                $user['email']      = $request->email;
                $user['gender']      = $request->gender;
                $user['phone']      = $request->phone;
                $user['created_by'] = \Auth::user()->creatorId();
                $user['country']=$request->country;
                $user['state']=$request->state;
                $user['city']=$request->city;
                $user['phone']=$request->phone;
                $user['zip']=$request->zip;
                $user['address']=$request->address;
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
                if($request['type'] != 'client')
                    \App\Models\Utility::employeeDetails($user->id,\Auth::user()->creatorId());
               
            }
            // Send Email
            // $setings = Utility::settings();

            // if($setings['create_user'] == 1) {
            //     $user->password = $psw;
            //     $user->type = $role_r->name;

            //     $userArr = [
            //         'email' => $user->email,
            //         'password' => $user->password,
            //     ];
            //     $resp = Utility::sendEmailTemplate('create_user', [$user->id => $user->email], $userArr);

                // return redirect()->route('consultants.index')->with('success', __('User successfully created.') . ((!empty($resp) && $resp['is_success'] == false && !empty($resp['error'])) ? '' : ''));
            // }
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
        if(\Auth::user()->can('edit user'))
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
            $string_version = Null;
        }
       
        if(\Auth::user()->can('edit user'))
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

//                $role = Role::findById($request->role);
                $role = Role::findByName('company');
                $input = $request->all();
                $input['type'] = $role->name;
                // $input['reporting_to']=$string_version;

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

                $role          = Role::findById($request->role);
                $input         = $request->all();
                $input['type'] = $role->name;
                $input['reporting_to']=$string_version;
                $user->fill($input)->save();
                Utility::employeeDetailsUpdate($user->id,\Auth::user()->creatorId());
                CustomField::saveData($user, $request->customField);

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

        if(\Auth::user()->can('delete user'))
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

    public function profile()
    {
        $userDetail              = \Auth::user();
        $userDetail->customField = CustomField::getData($userDetail, 'user');
        $customFields            = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'user')->get();

        return view('user.profile', compact('userDetail', 'customFields'));
    }

    public function editprofile(Request $request)
    {
        try {
            $userDetail = \Auth::user();
            echo $userDetail->id;
            $user  = Consultant::findOrFail($userDetail->id);

            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required|max:120',
                    'email' => 'required|email|unique:users,email,' . $userDetail->id,
                ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            if($request->hasFile('profile'))
            {
                // image restriction
                $validator = \Validator::make(
                    $request->all(), [
                        'profile' => 'mimes:jpeg,jpg,png,gif,webp|required|max:20480',
                    ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();
                    return redirect()->back()->with('error', $messages->first());
                }

                $filenameWithExt = $request->file('profile')->getClientOriginalName();
                $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension       = $request->file('profile')->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;

                // Storage::disk('s3')->put($filePath, file_get_contents($file));
                // $s3client = S3Client::factory(
                //     [
                //         'signature' => 'v4',
                //         'version' => 'latest',
                //         'ACL' => 'private',
                //         'region' => env('AWS_DEFAULT_REGION'),
                //         'credentials' => $credentials,
                //         'Statement' => [
                //             'Action ' => "*",
                //         ],
                //     ]);
                //aws s3 part
                $settings = Utility::getStorageSetting();
                if($settings['storage_setting']=='local')
                {
                    $dir = 'uploads/avatar/';
                }else{
                    $dir = 'uploads/avatar';
                }

                $image_path = $dir . $userDetail->avatar;

                if(File::exists($image_path))
                {
                    File::delete($image_path);
                }


                $url = '';
                $path = Utility::upload_file($request,'profile',$fileNameToStore,$dir,[]);
                if($path['flag'] == 1)
                {
                    $url = $path['url'];
                }else{
                    return redirect()->route('profile', \Auth::user()->id)->with('error', __($path->msg));
                }
                //aws s3 part
            }

            if(!empty($request->profile))
            {
                $user->avatar = $fileNameToStore;
            }
            $user['name']  = $request->name;
            $user['email'] = $request->email;
            $user->save();
            CustomField::saveData($user, $request->customField);

            return redirect()->route('dashboard')->with('success', 'Profile successfully updated.');
        }
        catch (Exception $e) {
            return $e->getMessage();
        }

    }

    public function new_edit_profile(Request $request)
    {
        try {
            $userDetail = \Auth::user();
            echo $userDetail->id;
            $user  = Consultant::findOrFail($userDetail->id);

            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required|max:120',
                    'email' => 'required|email|unique:users,email,' . $userDetail->id,
                ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            if($request->hasFile('profile'))
            {
                // image restriction
                $validator = \Validator::make(
                    $request->all(), [
                        'profile' => 'mimes:jpeg,jpg,png,gif,webp|required|max:20480',
                    ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();
                    return redirect()->back()->with('error', $messages->first());
                }

                $filenameWithExt = $request->file('profile')->getClientOriginalName();
                $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension       = $request->file('profile')->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;

                // Storage::disk('s3')->put($filePath, file_get_contents($file));
                // $s3client = S3Client::factory(
                //     [
                //         'signature' => 'v4',
                //         'version' => 'latest',
                //         'ACL' => 'private',
                //         'region' => env('AWS_DEFAULT_REGION'),
                //         'credentials' => $credentials,
                //         'Statement' => [
                //             'Action ' => "*",
                //         ],
                //     ]);
                //aws s3 part
                $settings = Utility::getStorageSetting();
                if($settings['storage_setting']=='local')
                {
                    $dir = 'uploads/avatar/';
                }else{
                    $dir = 'uploads/avatar';
                }

                $image_path = $dir . $userDetail->avatar;

                if(File::exists($image_path))
                {
                    File::delete($image_path);
                }


                $url = '';
                $path = Utility::upload_file($request,'profile',$fileNameToStore,$dir,[]);
                if($path['flag'] == 1)
                {
                    $url = $path['url'];
                }else{
                    return redirect()->route('profile', \Auth::user()->id)->with('error', __($path->msg));
                }
                //aws s3 part
            }

            if(!empty($request->profile))
            {
                $user->avatar = $fileNameToStore;
            }
            $user['name']  = $request->name;
            $user['email'] = $request->email;
            $user->save();
            CustomField::saveData($user, $request->customField);

            return redirect()->route('new_profile')->with('success', 'Profile successfully updated.');
        }
        catch (Exception $e) {
            return $e->getMessage();
        }

    }


    public function updatePassword(Request $request)
    {

        if(Auth::Check())
        {
            $objUser= Auth::user();
            $request->validate(
                [
                    'old_password' =>  ['required', function ($attribute, $value, $fail) use ($objUser) {
                        if (!\Hash::check($value, $objUser->password)) {
                            return $fail(__('The current password is incorrect.'));
                        }
                    }],
                    'password' => 'required|min:6',
                    'password_confirmation' => 'required|same:password',
                ]
            );

            $request_data     = $request->All();
            $current_password = $objUser->password;
            if(Hash::check($request_data['old_password'], $current_password))
            {
                $user_id            = Auth::User()->id;
                $obj_user           = Consultant::find($user_id);
                $obj_user->password = Hash::make($request_data['password']);;
                $obj_user->save();

                return redirect()->route('profile', $objUser->id)->with('success', __('Password successfully updated.'));
            }
            else
            {
                return redirect()->route('profile', $objUser->id)->with('error', __('Please enter correct current password.'));
            }
        }
        else
        {
            return redirect()->route('profile', \Auth::user()->id)->with('error', __('Something is wrong.'));
        }
    }


    public function newpassword(Request $request)
    {

        if(Auth::Check())
        {
            $objUser= Auth::user();
            $request->validate(
                [
                    'old_password' =>  ['required', function ($attribute, $value, $fail) use ($objUser) {
                        if (!\Hash::check($value, $objUser->password)) {
                            return $fail(__('The current password is incorrect.'));
                        }
                    }],
                    'password' => 'required|min:6',
                    'password_confirmation' => 'required|same:password',
                ]
            );

            $request_data     = $request->All();
            $current_password = $objUser->password;
            if(Hash::check($request_data['old_password'], $current_password))
            {
                $user_id            = Auth::User()->id;
                $obj_user           = Consultant::find($user_id);
                $obj_user->password = Hash::make($request_data['password']);;
                $obj_user->save();

                return redirect()->route('view_change_password', $objUser->id)->with('success', __('Password successfully updated.'));
            }
            else
            {
                return redirect()->route('view_change_password', $objUser->id)->with('error', __('Please enter correct current password.'));
            }
        }
        else
        {
            return redirect()->route('view_change_password', \Auth::user()->id)->with('error', __('Something is wrong.'));
        }
    }
    // User To do module
  public function todo_store(Request $request)
  {
      $request->validate(
          ['title' => 'required|max:120']
      );

      $post            = $request->all();
      $post['user_id'] = Auth::user()->id;
      $todo            = UserToDo::create($post);


      $todo->updateUrl = route(
          'todo.update', [
                           $todo->id,
                       ]
      );
      $todo->deleteUrl = route(
          'todo.destroy', [
                            $todo->id,
                        ]
      );

      return $todo->toJson();
  }

  public function todo_update($todo_id)
  {
      $user_todo = UserToDo::find($todo_id);
      if($user_todo->is_complete == 0)
      {
          $user_todo->is_complete = 1;
      }
      else
      {
          $user_todo->is_complete = 0;
      }
      $user_todo->save();
      return $user_todo->toJson();
  }

  public function todo_destroy($id)
  {
      $todo = UserToDo::find($id);
      $todo->delete();

      return true;
  }

  // change mode 'dark or light'
  public function changeMode()
  {
      $usr = \Auth::user();
      if($usr->mode == 'light')
      {
          $usr->mode      = 'dark';
          $usr->dark_mode = 1;
      }
      else
      {
          $usr->mode      = 'light';
          $usr->dark_mode = 0;
      }
      $usr->save();

      return redirect()->back();
  }

  public function upgradePlan($user_id)
    {
        $user = Consultant::find($user_id);
        $plans = Plan::get();
        return view('user.plan', compact('user', 'plans'));
    }
    public function activePlan($user_id, $plan_id)
    {

        $user       = Consultant::find($user_id);
        $assignPlan = $user->assignPlan($plan_id);
        $plan       = Plan::find($plan_id);
        if($assignPlan['is_success'] == true && !empty($plan))
        {
            $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
            Order::create(
                [
                    'order_id' => $orderID,
                    'name' => null,
                    'card_number' => null,
                    'card_exp_month' => null,
                    'card_exp_year' => null,
                    'plan_name' => $plan->name,
                    'plan_id' => $plan->id,
                    'price' => $plan->price,
                    'price_currency' => isset(\Auth::user()->planPrice()['currency']) ? \Auth::user()->planPrice()['currency'] : '',
                    'txn_id' => '',
                    'payment_status' => 'succeeded',
                    'receipt' => null,
                    'user_id' => $user->id,
                ]
            );

            return redirect()->back()->with('success', 'Plan successfully upgraded.');
        }
        else
        {
            return redirect()->back()->with('error', 'Plan fail to upgrade.');
        }

    }

    public function userPassword($id)
    {
        $eId        = \Crypt::decrypt($id);
        $user = Consultant::find($eId);

        // return view('user.reset', compact('user'));
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

public function new_profile(Request $request){

    $userDetail              = \Auth::user();

    $userDetail->customField = CustomField::getData($userDetail, 'user');
    $get_logo=Consultant::select('avatar')->where('id', '=', Auth::id())->first();
    $customFields            = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'user')->get();

    return view('user_profile.profile', compact('userDetail', 'customFields','get_logo'));


}

public function view_change_password(Request $request){
    $userDetail              = \Auth::user();
    $userDetail->customField = CustomField::getData($userDetail, 'user');
    $customFields            = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'user')->get();
    return view('user_profile.change_password', compact('userDetail', 'customFields'));
}

public function delete_new_profile(Request $request){

    try {
        $set_data=array('avatar'=>null);
        Consultant::where('id',$request->user_id)->update($set_data);
        return response()->json(['status'=>true]);
      } catch (Exception $e) {

          return $e->getMessage();

      }

}

public function check_duplicate_email_consultant(Request $request){
    
    try {
        $form_name  = $request->form_name;
        $check_name = $request->get_name;
        $get_id     = $request->get_id;
   
        if($form_name == "Users"){
            if($get_id == null){
                $get_check_val = Consultant::where('email',$check_name)->first();
            }
            else{
                $get_check_val = Consultant::where('email',$check_name)->where('id','!=',$get_id)->first();
            }
        }
        else{
            $get_check_val = "Not Empty";
        }
      
        if($get_check_val == null){
            return 1; //Success
        }
        else{
            return 0; //Error
        }
       
      } catch (Exception $e) {

          return $e->getMessage();

      }
    
   
}

}
