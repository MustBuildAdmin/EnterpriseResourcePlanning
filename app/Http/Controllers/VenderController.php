<?php

namespace App\Http\Controllers;

use App\Exports\VenderExport;
use App\Imports\VenderImport;
use App\Models\CustomField;
use App\Models\Transaction;
use App\Models\Utility;
use App\Models\Vender;
use Auth;
use App\Models\User;
use App\Models\Plan;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class VenderController extends Controller
{

    public function dashboard()
    {
        $data['billChartData'] = \Auth::user()->billChartData();

        return view('vender.dashboard', $data);
    }

    public function index()
    {
        if(\Auth::user()->can('manage vender'))
        {
            $venders = Vender::where('created_by', \Auth::user()->creatorId())->get();

            return view('vender.index', compact('venders'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        if(\Auth::user()->can('create vender'))
        {
            $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'vendor')->get();
            $country=Utility::getcountry();
            return view('vender.create', compact('customFields','country'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function store(Request $request)
    {
        if(\Auth::user()->can('create vender'))
        {
            $rules = [
                'name' => 'required',
                'contact' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
                'email' => 'required|email|unique:venders',
            ];


            $validator = \Validator::make($request->all(), $rules);

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->route('vender.index')->with('error', $messages->first());
            }


                        $objVendor    = \Auth::user();
                        $creator      = User::find($objVendor->creatorId());
                        $total_vendor = $objVendor->countVenders();
                        $plan         = Plan::find($creator->plan);

                        $default_language = DB::table('settings')->select('value')->where('name', 'default_language')->first();
                        if($total_vendor < $plan->max_venders || $plan->max_venders == -1)
                        {
                            $vender                   = new Vender();
                            $vender->vender_id        = $this->venderNumber();
                            $vender->name             = $request->name;
                            $vender->contact          = $request->contact;
                            $vender->email            = $request->email;
                            $vender->tax_number      =$request->tax_number;
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
                            $vender->lang             = !empty($default_language) ? $default_language->value : '';
                            $vender->save();
                            CustomField::saveData($vender, $request->customField);
                        }
                        else
                        {
                            return redirect()->back()->with('error', __('Your user limit is over, Please upgrade plan.'));
                        }

                        $role_r = Role::where('name', '=', 'vender')->firstOrFail();
                        $vender->assignRole($role_r); //Assigning role to user


                        $vender->type     = 'Vender';
//                        try {
//
////                            Mail::to($vender->email)->send(new UserCreate($vender));
//                        } catch (\Exception $e) {
//                            $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
//                        }


                      //Twilio Notification
                        $setting  = Utility::settings(\Auth::user()->creatorId());
                        if(isset($setting['twilio_vender_notification']) && $setting['twilio_vender_notification'] ==1)
                        {
                            $msg = __("New Vendor created by").' '.\Auth::user()->name.'.';
                            Utility::send_twilio_msg($request->contact,$msg);
                        }


            return redirect()->route('vender.index')->with('success', __('Vendor successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function show($ids)
    {
        $id     = \Crypt::decrypt($ids);
        $vendor = Vender::find($id);
        $country=Utility::getcountry_details($vendor->billing_country);
        $state=Utility::getstate_details($vendor->billing_country,$vendor->billing_state);
        $shipcountry=Utility::getcountry_details($vendor->shipping_country);
        $shipstate=Utility::getstate_details($vendor->shipping_country,$vendor->shipping_state);

        return view('vender.show', compact('vendor','country','state','shipcountry','shipstate'));
    }


    public function edit($id)
    {
        if(\Auth::user()->can('edit vender'))
        {
            $vender              = Vender::find($id);
            $vender->customField = CustomField::getData($vender, 'vendor');
            $countrylist=Utility::getcountry();
            $statelist=Utility::getstate($vender->billing_country);
            // $citylist=Utility::getcity($vender->billing_country,$vender->billing_state);
            $sellerstatelist=Utility::getstate($vender->shipping_country);
            // $sellercitylist=Utility::getcity($vender->shipping_country,$vender->shipping_state);
            $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'vendor')->get();

            return view('vender.edit', compact('vender', 'customFields','countrylist','statelist','sellerstatelist'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function update(Request $request, Vender $vender)
    {
        if(\Auth::user()->can('edit vender'))
        {

            $rules = [
                'name' => 'required',
                'contact' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
            ];


            $validator = \Validator::make($request->all(), $rules);

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->route('vender.index')->with('error', $messages->first());
            }

            $vender->name             = $request->name;
            $vender->contact          = $request->contact;
            $vender->tax_number      = $request->tax_number;
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
            $vender->save();
            CustomField::saveData($vender, $request->customField);

            return redirect()->route('vender.index')->with('success', __('Vendor successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function destroy(Vender $vender)
    {
        if(\Auth::user()->can('delete vender'))
        {
            if($vender->created_by == \Auth::user()->creatorId())
            {
                $vender->delete();

                return redirect()->route('vender.index')->with('success', __('Vendor successfully deleted.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    function venderNumber()
    {
        $latest = Vender::where('created_by', '=', \Auth::user()->creatorId())->latest()->first();
        if(!$latest)
        {
            return 1;
        }

        return $latest->vender_id + 1;
    }

    public function venderLogout(Request $request)
    {
        \Auth::guard('vender')->logout();

        $request->session()->invalidate();

        return redirect()->route('vender.login');
    }

    public function payment(Request $request)
    {

        if(\Auth::user()->can('manage vender payment'))
        {
            $category = [
                'Bill' => 'Bill',
                'Deposit' => 'Deposit',
                'Sales' => 'Sales',
            ];

            $query = Transaction::where('user_id', \Auth::user()->id)->where('created_by', \Auth::user()->creatorId())->where('user_type', 'Vender')->where('type', 'Payment');
            if(!empty($request->date))
            {
                $date_range = explode(' - ', $request->date);
                $query->whereBetween('date', $date_range);
            }

            if(!empty($request->category))
            {
                $query->where('category', '=', $request->category);
            }
            $payments = $query->get();


            return view('vender.payment', compact('payments', 'category'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function transaction(Request $request)
    {

        if(\Auth::user()->can('manage vender transaction'))
        {


            $category = [
                'Bill' => 'Bill',
                'Deposit' => 'Deposit',
                'Sales' => 'Sales',
            ];

            $query = Transaction::where('user_id', \Auth::user()->id)->where('user_type', 'Vender');

            if(!empty($request->date))
            {
                $date_range = explode(' - ', $request->date);
                $query->whereBetween('date', $date_range);
            }

            if(!empty($request->category))
            {
                $query->where('category', '=', $request->category);
            }
            $transactions = $query->get();


            return view('vender.transaction', compact('transactions', 'category'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function profile()
    {
        $userDetail              = \Auth::user();
        $userDetail->customField = CustomField::getData($userDetail, 'vendor');
        $customFields            = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'vendor')->get();

        return view('vender.profile', compact('userDetail', 'customFields'));
    }

    public function editprofile(Request $request)
    {

        $userDetail = \Auth::user();
        $user       = Vender::findOrFail($userDetail['id']);
        $this->validate(
            $request, [
                        'name' => 'required|max:120',
                        'contact' => 'required',
                        'email' => 'required|email|unique:users,email,' . $userDetail['id'],
                    ]
        );
        if($request->hasFile('profile'))
        {
            $filenameWithExt = $request->file('profile')->getClientOriginalName();
            $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension       = $request->file('profile')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;

            $dir        = storage_path('uploads/avatar/');
            $image_path = $dir . $userDetail['avatar'];

            if(File::exists($image_path))
            {
                File::delete($image_path);
            }

            if(!file_exists($dir))
            {
                mkdir($dir, 0777, true);
            }

            $path = $request->file('profile')->storeAs('uploads/avatar/', $fileNameToStore);

        }

        if(!empty($request->profile))
        {
            $user['avatar'] = $fileNameToStore;
        }
        $user['name']    = $request['name'];
        $user['email']   = $request['email'];
        $user['contact'] = $request['contact'];
        $user->save();
        CustomField::saveData($user, $request->customField);

        return redirect()->back()->with(
            'success', 'Profile successfully updated.'
        );
    }

    public function editBilling(Request $request)
    {

        $userDetail = \Auth::user();
        $user       = Vender::findOrFail($userDetail['id']);
        $this->validate(
            $request, [
                        'billing_name' => 'required',
                        'billing_country' => 'required',
                        'billing_state' => 'required',
                        'billing_city' => 'required',
                        'billing_phone' => 'required',
                        'billing_zip' => 'required',
                        'billing_address' => 'required',
                    ]
        );
        $input = $request->all();
        $user->fill($input)->save();

        return redirect()->back()->with(
            'success', 'Profile successfully updated.'
        );
    }

    public function editShipping(Request $request)
    {
        $userDetail = \Auth::user();
        $user       = Vender::findOrFail($userDetail['id']);
        $this->validate(
            $request, [
                        'shipping_name' => 'required',
                        'shipping_country' => 'required',
                        'shipping_state' => 'required',
                        'shipping_city' => 'required',
                        'shipping_phone' => 'required',
                        'shipping_zip' => 'required',
                        'shipping_address' => 'required',
                    ]
        );
        $input = $request->all();
        $user->fill($input)->save();

        return redirect()->back()->with(
            'success', 'Profile successfully updated.'
        );
    }

    public function changeLanquage($lang)
    {


        $user       = Auth::user();
        $user->lang = $lang;
        $user->save();

        return redirect()->back()->with('success', __('Language successfully change.'));

    }

    public function export()
    {
        $name = 'vendor_' . date('Y-m-d i:h:s');
        $data = Excel::download(new VenderExport(), $name . '.xlsx');

        return $data;
    }

    public function importFile()
    {
        return view('vender.import');
    }

    public function import(Request $request)
    {

        $rules = [
            'file' => 'required|mimes:csv,txt,xlsx,xls',
        ];

        $validator = \Validator::make($request->all(), $rules);

        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $vendors = (new VenderImport())->toArray(request()->file('file'))[0];

        $totalCustomer = count($vendors) - 1;
        $errorArray    = [];
        for($i = 1; $i <= count($vendors) - 1; $i++)
        {
            $vendor = $vendors[$i];

            $vendorByEmail = Vender::where('email', $vendor[1])->first();

//            $countryStausArray = Vender::$country_array;
//            $location          = array_search($vendor[4], $countryStausArray);
//            $company_location  = array_search($vendor[26], $countryStausArray);

            if(!empty($vendorByEmail))
            {
                $vendorData = $vendorByEmail;
            }
            else
            {
                $vendorData            = new Vender();
                $vendorData->vender_id = $this->venderNumber();
            }

            $vendorData->vender_id          =$vendor[0];
            $vendorData->name               = $vendor[1];
            $vendorData->email              = $vendor[2];
            $vendorData->password           = Hash::make($vendor[3]);
            $vendorData->contact            = $vendor[4];
            $vendorData->avatar             = $vendor[5];
            $vendorData->billing_name       = $vendor[6];
            $vendorData->billing_country    = $vendor[7];
            $vendorData->billing_state      = $vendor[8];
            $vendorData->billing_city       = $vendor[9];
            $vendorData->billing_phone      = $vendor[10];
            $vendorData->billing_zip        = $vendor[11];
            $vendorData->billing_address    = $vendor[12];
            $vendorData->shipping_name      = $vendor[13];
            $vendorData->shipping_country   = $vendor[14];
            $vendorData->shipping_state     = $vendor[15];
            $vendorData->shipping_city      = $vendor[16];
            $vendorData->shipping_phone     = $vendor[17];
            $vendorData->shipping_zip       = $vendor[18];
            $vendorData->shipping_address   = $vendor[19];

            $vendorData->created_by         = \Auth::user()->creatorId();

            if(empty($vendorData))
            {
                $errorArray[] = $vendorData;
            }
            else
            {
                $vendorData->save();
            }
        }

        $errorRecord = [];
        if(empty($errorArray))
        {
            $data['status'] = 'success';
            $data['msg']    = __('Record successfully imported');
        }
        else
        {
            $data['status'] = 'error';
            $data['msg']    = count($errorArray) . ' ' . __('Record imported fail out of' . ' ' . $totalCustomer . ' ' . 'record');


            foreach($errorArray as $errorData)
            {

                $errorRecord[] = implode(',', $errorData);

            }

            \Session::put('errorArray', $errorRecord);
        }

        return redirect()->back()->with($data['status'], $data['msg']);
    }
}
