<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Plan;
use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Exception;
use App\Models\Vender;

class SubContractorController extends Controller
{
    public function index(Request $request)
    {
        $user = \Auth::user();
        if (\Auth::user()->can('manage sub contractor')) {
            if (\Auth::user()->type == 'super admin') {
                $users = Vender::where([
                    ['name', '!=', null],
                    [function ($query) use ($request) {
                        if (($s = $request->search)) {
                            $query->orWhere('name', 'LIKE', '%'.$s.'%')
                                ->get();
                        }
                    }],
                ])->where('created_by', '=', $user->creatorId())->paginate(8);

                $usercount = Vender::where('created_by', '=', $user->creatorId())
                    ->get()->count();
            }
            else {
                $users = Vender::where([
                    ['name', '!=', null],
                    [function ($query) use ($request) {
                        if (($s = $request->search)) {
                            $user = \Auth::user();
                            $query->orWhere('name', 'LIKE', '%'.$s.'%')
                                ->get();
                        }
                    }],
                ])->where('created_by', '=', $user->creatorId())->paginate(8);

                $usercount = Vender::where('created_by', '=', $user->creatorId())
                    ->get()->count();
            }

            return view('subcontractor.index')->with('users', $users)->with('usercount', $usercount);
        }
        else {
            return redirect()->back();
        }
    }

    public function create(Request $request)
    {
        if (\Auth::user()->can('create sub contractor')) {
            $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())
                ->where('module', '=', 'vendor')->get();
            $country = Utility::getcountry();

            return view('vender.create', compact('customFields', 'country'));
        }
        else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function edit(Request $request){
        $user = \Auth::user();
        $roles = Role::where('created_by', '=', $user->creatorId())
            ->where('name', '!=', 'client')
            ->get()
            ->pluck('name', 'id');
        $gender = ['male' => 'Male', 'female' => 'Female', 'other' => 'Other'];
        $company_type = Company_type::get()->pluck('name', 'id');
        if (\Auth::user()->can('edit contractor')) {
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

            return view('subcontractor.edit', compact('user', 'gender', 'roles', 'customFields',
                'countrylist', 'statelist', 'company_type', 'users', 'color_co'));
        } else {
            return redirect()->back();
        }
    }

    public function invite_subContractor(Request $request){
        try {
            return view('subcontractor.invite');
        }
        catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function userPassword(Request $request){
        try {
            $eId = \Crypt::decrypt($id);
            $user = User::find($eId);
            return view('subcontractor.reset', compact('user'));
        }
        catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function seach_result(Request $request){
        try {
            $searchValue = $request['q'];

            if($request->filled('q')){
                $userlist = Vender::search($searchValue)
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
        }
        catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function store_invitation_status(request $request){
        try {
            $consulantid = explode(',', $request->consulant_id);

            foreach($consulantid as $cid){
                $requested_date = Config::get('constants.TIMESTUMP');
                $createConnection = ConsultantCompanies::create([
                    "company_id"=>\Auth::user()->creatorId(),
                    'subcontractor_id'=>$cid,
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
    
                Utility::sendEmailTemplate('invite_subcontractor', [$cid => \Auth::user()->email], $userArr);
            }

            return redirect()->route('subContractor.index')
                ->with('success', __('Sub Contractor Invitation Sent Successfully.'));
        }
        catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function check_duplicate_email_subcontractor(Request $request){
        try {
            $formname  = $request->formname;
            $checkname = $request->getname;
            $getid     = $request->getid;

            if ($formname == 'Venders') {
                $getcheckval = $getid == null ?
                    Vender::where('email', $checkname)->first() :
                    Vender::where('email', $checkname)->where('id', '!=', $getid)->first();
            }
            else {
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

    public function check_duplicate_mobile_subcontractor(Request $request)
    {
        try {
            $formname  = $request->formname;
            $checkname = $request->getname;
            $getid     = $request->getid;

            if ($formname == 'Venders') {
                $getcheckval = $getid == null ?
                    Vender::where('contact', $checkname)->first() :
                    Vender::where('contact', $checkname)->where('id', '!=', $getid)->first();
            }
            else {
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

    public function subContractorStore(Request $request){
        if (\Auth::user()->can('create sub contractor')) {
            $objVendor    = \Auth::user();
            $creator      = User::find($objVendor->creatorId());
            $total_vendor = $objVendor->countVenders();
            $plan         = Plan::find($creator->plan);
            $fileNames    = $this->upload($request);
            $user         = new User();

            $default_language = DB::table('settings')->select('value')->where('name', 'default_language')->first();
            // if ($total_vendor < $plan->max_venders || $plan->max_venders == -1) {
                $vender                   = new Vender();
                $vender->vender_id        = $this->venderNumber();
                $vender->name             = $request->name;
                $vender->contact          = $request->contact;
                $vender->email            = $request->email;
                $user->password           = Hash::make($request->password);
                $vender->tax_number       = $request->tax_number;
                $vender->created_by       = \Auth::user()->creatorId();
                $vender->billing_name     = $request->billing_name;
                $vender->billing_country  = $request->billing_country;
                $vender->billing_state    = $request->billing_state;
                $vender->billing_city     = $request->billing_city;
                $vender->billing_phone    = $request->billing_phone;
                $vender->billing_zip      = $request->billing_zip;
                $vender->billing_address  = $request->billing_address;
                $vender->shipping_name    = $request->shipping_name;
                $vender->shipping_country = $request->shipping_country;
                $vender->shipping_state   = $request->shipping_state;
                $vender->shipping_city    = $request->shipping_city;
                $vender->shipping_phone   = $request->shipping_phone;
                $vender->shipping_zip     = $request->shipping_zip;
                $vender->shipping_address = $request->shipping_address;
                $vender->color_code       = $request->color_code;
                if (isset($fileNames)) {
                    $vender->avatar = $fileNames;
                }
                $vender->lang = ! empty($default_language) ? $default_language->value : '';
                $vender->save();

                CustomField::saveData($vender, $request->customField);
            // }
            // else {
            //     return redirect()->back()->with('error', __('Your user limit is over, Please upgrade plan.'));
            // }

            $role_r = Role::where('name', '=', 'vender')->firstOrFail();
            $vender->assignRole($role_r); //Assigning role to user
            $user->userDefaultDataRegister($vender->id);

            return redirect()->route('subContractor.index')->with('success', __('Vendor successfully created.'));
        }
        else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function venderNumber()
    {
        $latest = Vender::where('created_by', '=', \Auth::user()->creatorId())->latest()->first();
        if (! $latest) {
            return 1;
        }

        return $latest->vender_id + 1;
    }
}
