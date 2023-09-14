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

    public function check_duplicate_mobile(Request $request)
    {
        try {
            $formname = $request->formname;
            $checkname = $request->getname;
            $getid = $request->getid;

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
}
