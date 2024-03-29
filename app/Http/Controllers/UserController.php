<?php

namespace App\Http\Controllers;

use App\Models\Company_type;
use App\Models\CustomField;
use App\Models\Employee;
use App\Models\ExperienceCertificate;
use App\Models\GenerateOfferLetter;
use App\Models\JoiningLetter;
use App\Models\NOC;
use App\Models\Order;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserToDo;
use App\Models\Utility;
use App\Models\Enquiry;
use Config;
use Exception;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = \Auth::user();
        if (\Auth::user()->can('manage user')) {
            if (\Auth::user()->type == 'super admin') {
                $users = User::where([
                    ['name', '!=', null],
                    [function ($query) use ($request) {
                        if (($s = $request->search)) {
                            $user = \Auth::user();
                            $query->orWhere('name', 'LIKE', '%'.$s.'%')
                                ->get();
                        }
                    }],
                ])->where('created_by', '=', $user->creatorId())->where('type', '=', 'company')->paginate(8);
                $user_count = User::where('created_by', '=', $user->creatorId())->where('type', '=', 'company')->get()->count();
                // $users = User::where('created_by', '=', $user->creatorId())->where('type', '=', 'company')->get();
            } else {
                // $users = User::where('created_by', '=', $user->creatorId())->where('type', '!=', 'client')->get();
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
                    ->where('type', '!=', 'client')
                    ->where('type', '!=', 'consultant')
                    ->where('type', '!=', 'sub_contractor')
                    ->paginate(8);
                    $user_count = User::where('created_by', '=', $user->creatorId())
                    ->where('type', '!=', 'client')->where('type', '!=', 'consultant')
                    ->where('type', '!=', 'sub_contractor')
                    ->get()
                    ->count();
            }

            // return view('user.index')->with('users', $users);
            return view('users.index')->with('users', $users)->with('user_count', $user_count);
        } else {
            return redirect()->back();
        }

    }

    public function create(Request $request)
    {

        $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'user')->get();
        $user = \Auth::user();
        $roles = Role::where('created_by', '=', $user->creatorId())->where('name', '!=', 'client')->get()->pluck('name', 'id');
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
        ])->where('created_by', '=', $user->creatorId())->where('type', '!=', 'client')->get()->pluck('name', 'id');
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
            ])->where('id', '=', $user->creatorId())->where('type', '!=', 'client')->get()->pluck('name', 'id');
        }
        if (\Auth::user()->can('create user')) {
            $country = Utility::getcountry();

            // return view('user.create', compact('roles','gender', 'customFields','country','company_type'));
            return view('users.create', compact('roles', 'gender', 'customFields', 'country', 'company_type', 'users'));
        } else {
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {

        if ($request->reporting_to != null) {
            $string_version = implode(',', $request->reporting_to);
        } else {
            $string_version = null;
        }

        if (\Auth::user()->can('create user')) {
            $default_language = DB::table('settings')->select('value')->where('name', 'default_language')->first();
            if (\Auth::user()->type == 'super admin') {
                $validator = \Validator::make(
                    $request->all(), [
                        'name' => 'required|max:120',
                        'email' => 'required|email|unique:users',
                        'phone' => 'required|unique:users',
                        'password' => 'required|min:6',
                        'gender' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                if (isset($request->avatar)) {

                    $filenameWithExt = $request->file('avatar')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $request->file('avatar')->getClientOriginalExtension();
                    $fileNameToStore = $filename.'_'.time().'.'.$extension;

                    $dir = Config::get('constants.USER_IMG');
                    $image_path = $dir.$fileNameToStore;
                    if (\File::exists($image_path)) {
                        \File::delete($image_path);
                    }
                    $url = '';
                    $path = Utility::upload_file($request, 'avatar', $fileNameToStore, $dir, []);

                    if ($path['flag'] == 1) {
                        $url = $path['url'];
                    } else {
                        return redirect()->back()->with('error', __($path['msg']));
                    }

                }
                $user = new User();
                $user['name'] = $request->name;
                $user['lname'] = $request->lname;
                $user['email'] = $request->email;
                $user['gender'] = $request->gender;
                // $user['phone']      = $request->phone;
                $psw = $request->password;
                $user['password'] = Hash::make($request->password);
                $user['type'] = 'company';
                $user['default_pipeline'] = 1;
                $user['plan'] = 1;
                $user['lang'] = ! empty($default_language) ? $default_language->value : '';
                $user['created_by'] = \Auth::user()->creatorId();
                $user['plan'] = Plan::first()->id;
                $user['country'] = $request->country;
                $user['state'] = $request->state;
                $user['city'] = $request->city;
                $user['phone'] = $request->phone;
                $user['zip'] = $request->zip;
                $user['address'] = $request->address;
                $user['company_type'] = $request->company_type;
                $user['color_code'] = $request->color_code;
                // $user['reporting_to']=$string_version;
                $user['company_name'] = $request->company_name;
                if (isset($url)) {
                    $user['avatar'] = $url;
                }
                $user->save();
                $role_r = Role::findByName('company');
                $user->assignRole($role_r);
                //                $user->userDefaultData();
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
            } else {
                $validator = \Validator::make(
                    $request->all(), [
                        'name' => 'required|max:120',
                        'email' => 'required|email|unique:users',
                        'phone' => 'required|unique:users',
                        'password' => 'required|min:6',
                        'role' => 'required',
                        'gender' => 'required',

                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                if (isset($request->avatar)) {

                    $filenameWithExt = $request->file('avatar')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $request->file('avatar')->getClientOriginalExtension();
                    $fileNameToStore = $filename.'_'.time().'.'.$extension;

                    $dir = Config::get('constants.USER_IMG');
                    $image_path = $dir.$fileNameToStore;
                    if (\File::exists($image_path)) {
                        \File::delete($image_path);
                    }

                    Utility::upload_file($request, 'avatar', $fileNameToStore, $dir, []);

                }

                $objUser = \Auth::user()->creatorId();
                $objUser = User::find($objUser);
                $user = User::find(\Auth::user()->created_by);
                $total_user = $objUser->countUsers();
                $plan = Plan::find($objUser->plan);
                if ($total_user < $plan->max_users || $plan->max_users == -1) {
                    $role_r = Role::findById($request->role);

                    if (isset($fileNameToStore)) {
                        $avatar = $fileNameToStore;
                    } else {
                        $avatar = null;
                    }

                    $psw = $request->password;
                    $user = User::create(
                        [
                            'name' => $request->name,
                            'lname' => $request->lname,
                            'email' => $request->email,
                            'type' => $role_r->name,
                            'gender' => $request->gender,
                            'password' => Hash::make($request->password),
                            'lang' => Utility::getValByName('default_language'),
                            'created_by' => $user->creatorId(),
                            'country' => $request->country,
                            'state' => $request->state,
                            'city' => $request->city,
                            'phone' => $request->phone,
                            'zip' => $request->zip,
                            'reporting_to' => $string_version,
                            'avatar' => $avatar,
                            'address' => $request->address,
                            'color_code' => $request->color_code,
                            'created_by' => \Auth::user()->creatorId(),
                        ]
                    );

                    $user->assignRole($role_r);
                    if ($request['type'] != 'client') {
                        \App\Models\Utility::employeeDetails($user->id, \Auth::user()->creatorId());
                    }
                } else {
                    return redirect()->back()->with('error', __('Your user limit is over, Please upgrade plan.'));
                }
            }
            // Send Email
            $setings = Utility::settings();

            if ($setings['create_user'] == 1) {
                $user->password = $psw;
                $user->type = $role_r->name;

                $userArr = [
                    'email' => $user->email,
                    'password' => $user->password,
                ];

                $resp = Utility::sendEmailTemplate('create_user', [$user->id => $user->email], $userArr);

                return redirect()->route('users.index')->with('success', __('User successfully created.').((! empty($resp) && $resp['is_success'] == false && ! empty($resp['error'])) ? '' : ''));
            }

            return redirect()->route('users.index')->with('success', __('User successfully created.'));

        } else {
            return redirect()->back();
        }

    }

    public function edit(Request $request, $id, $colorco)
    {
        $user = \Auth::user();

        $roles = Role::where('created_by', '=', $user->creatorId())->where('name', '!=', 'client')->get()->pluck('name', 'id');
        $gender = ['male' => 'Male', 'female' => 'Female', 'other' => 'Other'];
        $company_type = Company_type::get()->pluck('name', 'id');
        if (\Auth::user()->can('edit user')) {
            $user = User::findOrFail($id);

            $countrylist = Utility::getcountry();
            $statelist = Utility::getstate($user->country);
            $user->customField = CustomField::getData($user, 'user');
            $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'user')->get();
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
                ->where('type', '!=', 'client')
                ->where('id', '!=', $id)
                ->orwhere('id', '=', $user->creatorId())
                ->get()
                ->pluck('name', 'id');

            // return view('user.edit', compact('user','gender', 'roles', 'customFields','countrylist','statelist','company_type'));
            return view('users.edit', compact('user', 'gender', 'roles', 'customFields', 'countrylist',
                'statelist', 'company_type', 'users', 'colorco'));
        } else {
            return redirect()->back();
        }

    }

    public function update(Request $request, $id)
    {

        if ($request->reporting_to != null) {
            $string_version = implode(',', $request->reporting_to);
        } else {
            $string_version = null;
        }

        if (\Auth::user()->can('edit user')) {
            if (\Auth::user()->type == 'super admin') {
                $user = User::findOrFail($id);
                $validator = \Validator::make(
                    $request->all(), [
                        'name' => 'required|max:120',
                        'email' => 'required|email|unique:users,email,'.$id,
                        'phone' => 'required|unique:users,phone,'.$id,
                        'gender' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                if (isset($request->avatar)) {

                    $filenameWithExt = $request->file('avatar')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $request->file('avatar')->getClientOriginalExtension();
                    $fileNameToStore = $filename.'_'.time().'.'.$extension;

                    $dir = Config::get('constants.USER_IMG');
                    $image_path = $dir.$fileNameToStore;
                    if (\File::exists($image_path)) {
                        \File::delete($image_path);
                    }

                    Utility::upload_file($request, 'avatar', $fileNameToStore, $dir, []);

                }
                //                $role = Role::findById($request->role);
                $role = Role::findByName('company');
                $input = $request->all();
                $input['type'] = $role->name;
                $input['color_code'] = $request->color_code;
                // $input['reporting_to']=$string_version;
                if (isset($fileNameToStore)) {
                    $input['avatar'] = $fileNameToStore;
                }
                $user->fill($input)->save();
                CustomField::saveData($user, $request->customField);
                DB::table('users')->where('id', $id)->update(['company_type' => $request->company_type]);

                $insert2 = [
                    'name' => 'company_type',
                    'value' => $request->company_type,
                ];
                $data = DB::table('settings')->where('created_by', $id)->update($insert2);

                $roles[] = $role->id;
                $user->roles()->sync($roles);

                return redirect()->route('users.index')->with(
                    'success', 'User successfully updated.'
                );
            } else {
                $user = User::findOrFail($id);
                $validator = \Validator::make(
                    $request->all(), [
                        'name' => 'required|max:120',
                        'email' => 'required|email|unique:users,email,'.$id,
                        'phone' => 'required|unique:users,phone,'.$id,

                        'role' => 'required',
                        'gender' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                if (isset($request->avatar)) {

                    $filenameWithExt = $request->file('avatar')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $request->file('avatar')->getClientOriginalExtension();
                    $fileNameToStore = $filename.'_'.time().'.'.$extension;

                    $dir = Config::get('constants.USER_IMG');
                    $image_path = $dir.$fileNameToStore;
                    if (\File::exists($image_path)) {
                        \File::delete($image_path);
                    }

                    Utility::upload_file($request, 'avatar', $fileNameToStore, $dir, []);

                }
                $role = Role::findById($request->role);

                $post = [
                    'name' => $request->name,
                    'lname' => $request->lname,
                    'email' => $request->email,
                    'type' => $role->name,
                    'gender' => $request->gender,
                    'password' => Hash::make($request->password),
                    'lang' => Utility::getValByName('default_language'),
                    'created_by' => $user->creatorId(),
                    'country' => $request->country,
                    'state' => $request->state,
                    'city' => $request->city,
                    'phone' => $request->phone,
                    'zip' => $request->zip,
                    'reporting_to' => $string_version,
                    'address' => $request->address,
                    'color_code' => $request->color_code,
                    'created_by' => \Auth::user()->creatorId(),
                ];

                if (! empty($request->avatar)) {
                    $post['avatar'] = $fileNameToStore;

                }

                $user->update($post);

                Utility::employeeDetailsUpdate($user->id, \Auth::user()->creatorId());
                CustomField::saveData($user, $request->customField);

                $roles[] = $request->role;
                $user->roles()->sync($roles);

                return redirect()->route('users.index')->with(
                    'success', 'User successfully updated.'
                );
            }
        } else {
            return redirect()->back();
        }
    }

    public function destroy($id)
    {

        if (\Auth::user()->can('delete user')) {
            $user = User::find($id);
            if ($user) {
                if (\Auth::user()->type == 'super admin') {
                    if ($user->delete_status == 0) {
                        $user->delete_status = 1;
                    } else {
                        $user->delete_status = 0;
                    }
                    $user->save();
                }
                if (\Auth::user()->type == 'company') {
                    $employee = Employee::where(['user_id' => $user->id])->delete();
                    if ($employee) {
                        $delete_user = User::where(['id' => $user->id])->delete();
                        if ($delete_user) {
                            return redirect()->route('users.index')->with('success', __('User successfully deleted .'));
                        } else {
                            return redirect()->back()->with('error', __('Something is wrong.'));
                        }
                    } else {
                        return redirect()->back()->with('error', __('Something is wrong.'));
                    }
                }

                return redirect()->route('users.index')->with('error', __('User permission denied.'));
            } else {
                return redirect()->back()->with('error', __('Something is wrong.'));
            }
        } else {
            return redirect()->back();
        }
    }

    public function profile()
    {
        $userDetail = \Auth::user();
        $userDetail->customField = CustomField::getData($userDetail, 'user');
        $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'user')->get();

        return view('user.profile', compact('userDetail', 'customFields'));
    }

    public function editprofile(Request $request)
    {
        try {
            $userDetail = \Auth::user();
            echo $userDetail->id;
            $user = User::findOrFail($userDetail->id);

            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required|max:120',
                    'email' => 'required|email|unique:users,email,'.$userDetail->id,
                    // 'phone' => 'required|unique:users,phone,'.$userDetail->id,

                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            if ($request->hasFile('profile')) {
                // image restriction
                $validator = \Validator::make(
                    $request->all(), [
                        'profile' => 'mimes:jpeg,jpg,png,gif,webp|required|max:20480',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $filenameWithExt = $request->file('profile')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('profile')->getClientOriginalExtension();
                $fileNameToStore = $filename.'_'.time().'.'.$extension;

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
                if ($settings['storage_setting'] == 'local') {
                    $dir = Config::get('constants.USER_IMAGE');
                } else {
                    $dir = 'uploads/avatar';
                }

                $image_path = $dir.$userDetail->avatar;

                if (File::exists($image_path)) {
                    File::delete($image_path);
                }

                $url = '';
                $path = Utility::upload_file($request, 'profile', $fileNameToStore, $dir, []);
                if ($path['flag'] == 1) {
                    $url = $path['url'];
                } else {
                    return redirect()->route('profile', \Auth::user()->id)->with('error', __($path->msg));
                }
                //aws s3 part
            }

            if (! empty($request->profile)) {
                $user->avatar = $fileNameToStore;
            }
            $user['name'] = $request->name;
            $user['email'] = $request->email;
            $user->save();
            CustomField::saveData($user, $request->customField);

            return redirect()->route('dashboard')->with('success', 'Profile successfully updated.');
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    public function new_edit_profile(Request $request)
    {
        try {
            $userDetail = \Auth::user();
            $user = User::findOrFail($userDetail->id);
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required|max:120',
                    'email' => 'required|email|unique:users,email,'.$userDetail->id,
                ]
            );
           
            
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            if ($request->hasFile('profile')) {
                // image restriction
                $validator = \Validator::make(
                    $request->all(), [
                        'profile' => 'mimes:jpeg,jpg,png,gif,webp|required|max:20480',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $filenameWithExt = $request->file('profile')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('profile')->getClientOriginalExtension();
                $fileNameToStore = $filename.'_'.time().'.'.$extension;

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
                if ($settings['storage_setting'] == 'local') {
                    $dir = Config::get('constants.USER_IMAGE');
                } else {
                    $dir = 'uploads/avatar';
                }

                $image_path = $dir.$userDetail->avatar;

                if (File::exists($image_path)) {
                    File::delete($image_path);
                }

                $url = '';
                $path = Utility::upload_file($request, 'profile', $fileNameToStore, $dir, []);
                if ($path['flag'] == 1) {
                    $url = $path['url'];
                } else {
                    return redirect()->route('profile', \Auth::user()->id)->with('error', __($path->msg));
                }
                //aws s3 part
            }

            if (! empty($request->profile)) {
                $user->avatar = $fileNameToStore;
            }
            $user['name'] = $request->name;
            $user['email'] = $request->email;
            $user->save();
            CustomField::saveData($user, $request->customField);

            return redirect()->route('new_profile')->with('success', 'Profile successfully updated.');
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    public function updatePassword(Request $request)
    {

        if (Auth::Check()) {
            $objUser = Auth::user();
            $request->validate(
                [
                    'old_password' => ['required', function ($attribute, $value, $fail) use ($objUser) {
                        if (! \Hash::check($value, $objUser->password)) {
                            return $fail(__('The current password is incorrect.'));
                        }
                    }],
                    'password' => 'required|min:6',
                    'password_confirmation' => 'required|same:password',
                ]
            );

            $request_data = $request->All();
            $current_password = $objUser->password;
            if (Hash::check($request_data['old_password'], $current_password)) {
                $user_id = Auth::User()->id;
                $obj_user = User::find($user_id);
                $obj_user->password = Hash::make($request_data['password']);
                $obj_user->save();

                return redirect()->route('profile', $objUser->id)->with('success', __('Password successfully updated.'));
            } else {
                return redirect()->route('profile', $objUser->id)->with('error', __('Please enter correct current password.'));
            }
        } else {
            return redirect()->route('profile', \Auth::user()->id)->with('error', __('Something is wrong.'));
        }
    }

    public function newpassword(Request $request)
    {

        if (Auth::Check()) {
            $objUser = Auth::user();
            $request->validate(
                [
                    'old_password' => ['required', function ($attribute, $value, $fail) use ($objUser) {
                        if (! \Hash::check($value, $objUser->password)) {
                            return $fail(__('The current password is incorrect.'));
                        }
                    }],
                    'password' => 'required|min:6',
                    'password_confirmation' => 'required|same:password',
                ]
            );

            $request_data = $request->All();
            $current_password = $objUser->password;
            if (Hash::check($request_data['old_password'], $current_password)) {
                $user_id = Auth::User()->id;
                $obj_user = User::find($user_id);
                $obj_user->password = Hash::make($request_data['password']);
                $obj_user->save();

                return redirect()->route('view_change_password', $objUser->id)->with('success', __('Password successfully updated.'));
            } else {
                return redirect()->route('view_change_password', $objUser->id)->with('error', __('Please enter correct current password.'));
            }
        } else {
            return redirect()->route('view_change_password', \Auth::user()->id)->with('error', __('Something is wrong.'));
        }
    }

    // User To do module
    public function todo_store(Request $request)
    {
        $request->validate(
            ['title' => 'required|max:120']
        );

        $post = $request->all();
        $post['user_id'] = Auth::user()->id;
        $todo = UserToDo::create($post);

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
        if ($user_todo->is_complete == 0) {
            $user_todo->is_complete = 1;
        } else {
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
        if ($usr->mode == 'light') {
            $usr->mode = 'dark';
            $usr->dark_mode = 1;
        } else {
            $usr->mode = 'light';
            $usr->dark_mode = 0;
        }
        $usr->save();

        return redirect()->back();
    }

    public function upgradePlan($user_id)
    {
        $user = User::find($user_id);
        $plans = Plan::get();

        return view('user.plan', compact('user', 'plans'));
    }

    public function activePlan($user_id, $plan_id)
    {

        $user = User::find($user_id);
        $assignPlan = $user->assignPlan($plan_id);
        $plan = Plan::find($plan_id);
        if ($assignPlan['is_success'] == true && ! empty($plan)) {
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
        } else {
            return redirect()->back()->with('error', 'Plan fail to upgrade.');
        }

    }

    public function userPassword($id)
    {
        $eId = \Crypt::decrypt($id);
        $user = User::find($eId);

        // return view('user.reset', compact('user'));
        return view('users.reset', compact('user'));

    }

    public function userPasswordReset(Request $request, $id)
    {

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

        return redirect()->route('users.index')->with(
            'success', 'User Password successfully updated.'
        );

    }

    public function new_profile(Request $request)
    {

        $userDetail = \Auth::user();

        $userDetail->customField = CustomField::getData($userDetail, 'user');
        $get_logo = User::select('avatar')->where('id', '=', Auth::id())->first();
        $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'user')->get();

        return view('user_profile.profile', compact('userDetail', 'customFields', 'get_logo'));

    }

    public function view_change_password(Request $request)
    {
        $userDetail = \Auth::user();
        $userDetail->customField = CustomField::getData($userDetail, 'user');
        $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'user')->get();

        return view('user_profile.change_password', compact('userDetail', 'customFields'));
    }

    public function delete_new_profile(Request $request)
    {

        try {
            $set_data = ['avatar' => null];
            User::where('id', $request->user_id)->update($set_data);

            return response()->json(['status' => true]);
        } catch (Exception $e) {

            return $e->getMessage();

        }

    }

    public function check_duplicate_email(Request $request)
    {

        try {
            $formname = $request->formname;
            $checkname = $request->getname;
            $getid = $request->getid;

            if ($formname == 'Users') {
                if ($getid == null) {
                    $getcheckval = User::where('email', $checkname)->first();
                } else {
                    $getcheckval = User::where('email', $checkname)->where('id', '!=', $getid)->first();
                }
            } else {
                $getcheckval = 'Not Empty';
            }

            if ($getcheckval == null) {
                return 1; //Success
            } else {
                return 0; //Error
            }

        } catch (Exception $e) {

            return $e->getMessage();

        }

    }

    public function check_duplicate_mobile(Request $request)
    {
        try {
            $formname = $request->formname;
            $checkname = $request->getname;
            $getid = $request->getid;
            if(isset($request->getid)){
                $getid = $request->getid;
            }elseif(isset($request->get_id)){
                $getid =  $request->get_id;
            }
          
            if ($formname == 'Users') {
                if ($getid == null) {
                    $getcheckval = User::where('phone', $checkname)->first();
                } else {
                    $getcheckval = User::where('phone', $checkname)->where('id', '!=', $getid)->first();
                }
            } else {
                $getcheckval = 'Not Empty';
            }
            
            if ($getcheckval == null) {
                return 1; //Success
            } else {
                return 0; //Error
            }

        } catch (Exception $e) {

            return $e->getMessage();

        }
    }
    public function contactus(Request $request)
    {
        try {
            
            $enquiry = new Enquiry();
            $enquiry['name'] = $request->name;
            $enquiry['email'] = $request->email;
            $enquiry['subject'] = $request->subject;
            $enquiry['message'] = $request->message;
            $enquiry->save();
            return response()->json(['status' => true]);

        } catch (Exception $e) {

            return $e->getMessage();

        }
    }
}
