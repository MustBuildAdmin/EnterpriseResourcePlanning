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
}
