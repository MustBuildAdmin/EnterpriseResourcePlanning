<?php

namespace App\Http\Controllers;

use App\Exports\CustomerExport;
use App\Imports\CustomerImport;
use App\Models\Customer;
use App\Models\CustomField;
use App\Models\Transaction;
use App\Models\Utility;
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

class CustomerController extends Controller
{

    public function dashboard()
    {
        $data['invoiceChartData'] = \Auth::user()->invoiceChartData();

        return view('customer.dashboard', $data);
    }

    public function index()
    {
        if(\Auth::user()->can('manage customer'))
        {
            $customers = Customer::where('created_by', \Auth::user()->creatorId())->get();

            return view('accounting.customer.index', compact('customers'));
            // return view('customer.index', compact('customers'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('create customer'))
        {
            $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'customer')->get();
            $country=Utility::getcountry();
            return view('accounting.customer.create', compact('customFields','country'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function store(Request $request)
    {
        if(\Auth::user()->can('create customer'))
        {

            $rules = [
                'name' => 'required',
                'contact' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
                'email' => 'required|email|unique:customers',
            ];


            $validator = \Validator::make($request->all(), $rules);

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->route('customer.index')->with('error', $messages->first());
            }

            $objCustomer    = \Auth::user();
            $creator        = User::find($objCustomer->creatorId());
            $total_customer = $objCustomer->countCustomers();
            $plan           = Plan::find($creator->plan);

            $default_language          = DB::table('settings')->select('value')->where('name', 'default_language')->first();
            if($total_customer < $plan->max_customers || $plan->max_customers == -1)
            {
                $customer                  = new Customer();
                $customer->customer_id     = $this->customerNumber();
                $customer->name            = $request->name;
                $customer->contact         = $request->contact;
                $customer->email           = $request->email;
                $customer->tax_number      =$request->tax_number;
                $customer->created_by      = \Auth::user()->creatorId();
                $customer->billing_name    = $request->billing_name;
                $customer->billing_country = $request->billing_country;
                $customer->billing_state   = $request->billing_state;
                $customer->billing_city    = $request->billing_city;
                $customer->billing_phone   = $request->billing_phone;
                $customer->billing_zip     = $request->billing_zip;
                $customer->billing_address = $request->billing_address;

                $customer->shipping_name    = $request->shipping_name;
                $customer->shipping_country = $request->shipping_country;
                $customer->shipping_state   = $request->shipping_state;
                $customer->shipping_city    = $request->shipping_city;
                $customer->shipping_phone   = $request->shipping_phone;
                $customer->shipping_zip     = $request->shipping_zip;
                $customer->shipping_address = $request->shipping_address;

                $customer->lang = !empty($default_language) ? $default_language->value : '';

                $customer->save();
                CustomField::saveData($customer, $request->customField);
            }
            else
            {
                return redirect()->back()->with('error', __('Your user limit is over, Please upgrade plan.'));
            }

            //Twilio Notification
            $setting  = Utility::settings(\Auth::user()->creatorId());
            if(isset($setting['twilio_customer_notification']) && $setting['twilio_customer_notification'] ==1)
            {
                $msg = __("New Customer created by").' '.\Auth::user()->name.'.';
                Utility::send_twilio_msg($request->contact,$msg);
            }

            return redirect()->route('accounting.customer.index')->with('success', __('Customer successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function show($ids)
    {
        $id       = \Crypt::decrypt($ids);
        $customer = Customer::find($id);
        $state=Utility::getstate_details($customer->billing_country,$customer->billing_state);
        $country=Utility::getcountry_details($customer->billing_country);

        $shipstate=Utility::getstate_details($customer->shipping_country,$customer->shipping_state);
        $shipcountry=Utility::getcountry_details($customer->shipping_country);

        return view('accounting.customer.show', compact('customer','shipstate','shipcountry','state','country'));
    }


    public function edit($id)
    {
        if(\Auth::user()->can('edit customer'))
        {
            $customer              = Customer::find($id);
            $customer->customField = CustomField::getData($customer, 'customer');
            $countrylist=Utility::getcountry();
            $statelist=Utility::getstate($customer->billing_country);
            // $citylist=Utility::getcity($customer->billing_country,$customer->billing_state);
            $sellerstatelist=Utility::getstate($customer->shipping_country);
            // dd($statelist);
            // $sellercitylist=Utility::getcity($customer->shipping_country,$customer->shipping_state);
            $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'customer')->get();

            return view('accounting.customer.edit', compact('customer', 'customFields','countrylist','statelist','sellerstatelist'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function update(Request $request, Customer $customer)
    {

        if(\Auth::user()->can('edit customer'))
        {

            $rules = [
                'name' => 'required',
                'contact' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
            ];


            $validator = \Validator::make($request->all(), $rules);
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->route('accounting.customer.index')->with('error', $messages->first());
            }

            $customer->name             = $request->name;
            $customer->contact          = $request->contact;
            $customer->email           = $request->email;
            $customer->tax_number      =$request->tax_number;
            $customer->created_by       = \Auth::user()->creatorId();
            $customer->billing_name     = $request->billing_name;
            $customer->billing_country  = $request->billing_country;
            $customer->billing_state    = $request->billing_state;
            $customer->billing_city     = $request->billing_city;
            $customer->billing_phone    = $request->billing_phone;
            $customer->billing_zip      = $request->billing_zip;
            $customer->billing_address  = $request->billing_address;
            $customer->shipping_name    = $request->shipping_name;
            $customer->shipping_country = $request->shipping_country;
            $customer->shipping_state   = $request->shipping_state;
            $customer->shipping_city    = $request->shipping_city;
            $customer->shipping_phone   = $request->shipping_phone;
            $customer->shipping_zip     = $request->shipping_zip;
            $customer->shipping_address = $request->shipping_address;
            $customer->save();

            CustomField::saveData($customer, $request->customField);

            return redirect()->route('accounting.customer.index')->with('success', __('Customer successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function destroy(Customer $customer)
    {
        if(\Auth::user()->can('delete customer'))
        {
            if($customer->created_by == \Auth::user()->creatorId())
            {
                $customer->delete();

                return redirect()->route('accounting.customer.index')->with('success', __('Customer successfully deleted.'));
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

    function customerNumber()
    {
        $latest = Customer::where('created_by', '=', \Auth::user()->creatorId())->latest()->first();
        if(!$latest)
        {
            return 1;
        }

        return $latest->customer_id + 1;
    }

    public function customerLogout(Request $request)
    {
        \Auth::guard('customer')->logout();

        $request->session()->invalidate();

        return redirect()->route('customer.login');
    }

    public function payment(Request $request)
    {

        if(\Auth::user()->can('manage customer payment'))
        {
            $category = [
                'Invoice' => 'Invoice',
                'Deposit' => 'Deposit',
                'Sales' => 'Sales',
            ];

            $query = Transaction::where('user_id', \Auth::user()->id)->where('user_type', 'Customer')->where('type', 'Payment');
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

            return view('accounting.customer.payment', compact('payments', 'category'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function transaction(Request $request)
    {
        if(\Auth::user()->can('manage customer payment'))
        {
            $category = [
                'Invoice' => 'Invoice',
                'Deposit' => 'Deposit',
                'Sales' => 'Sales',
            ];

            $query = Transaction::where('user_id', \Auth::user()->id)->where('user_type', 'Customer');

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

            return view('accounting.customer.transaction', compact('transactions', 'category'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function profile()
    {
        $userDetail              = \Auth::user();
        $userDetail->customField = CustomField::getData($userDetail, 'customer');
        $customFields            = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'customer')->get();

        return view('customer.profile', compact('userDetail', 'customFields'));
    }

    public function editprofile(Request $request)
    {
        $userDetail = \Auth::user();
        $user       = Customer::findOrFail($userDetail['id']);

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
        $user       = Customer::findOrFail($userDetail['id']);
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
        $user       = Customer::findOrFail($userDetail['id']);
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

        return redirect()->back()->with('success', __('Language Change Successfully!'));

    }


    public function export()
    {
        $name = 'customer_' . date('Y-m-d i:h:s');
        $data = Excel::download(new CustomerExport(), $name . '.xlsx'); ob_end_clean();

        return $data;
    }

    public function importFile()
    {
        return view('accounting.customer.import');
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

        $customers = (new CustomerImport())->toArray(request()->file('file'))[0];

        $totalCustomer = count($customers) - 1;
        $errorArray    = [];
        for($i = 1; $i <= count($customers) - 1; $i++)
        {
            $customer = $customers[$i];

            $customerByEmail = Customer::where('email', $customer[1])->first();
            if(!empty($customerByEmail))
            {
                $customerData = $customerByEmail;
            }
            else
            {
                $customerData = new Customer();
                $customerData->customer_id      = $this->customerNumber();
            }


            $customerData->name             = $customer[0];
            $customerData->email            = $customer[1];
            $customerData->contact          = $customer[3];
            $customerData->is_active        = 1;
            $customerData->billing_name     = $customer[4];
            // $customerData->billing_country  = $customer[5];
            // $customerData->billing_state    = $customer[6];
            $customerData->billing_city     = $customer[5];
            $customerData->billing_phone    = $customer[6];
            $customerData->billing_zip      = $customer[7];
            $customerData->billing_address  = $customer[8];
            $customerData->shipping_name    = $customer[9];
            // $customerData->shipping_country = $customer[12];
            // $customerData->shipping_state   = $customer[13];
            $customerData->shipping_city    = $customer[10];
            $customerData->shipping_phone   = $customer[11];
            $customerData->shipping_zip     = $customer[12];
            $customerData->shipping_address = $customer[13];
            $customerData->tax_number      =$customer[14];
            $customerData->lang             = 'en';
            $customerData->balance          = 0;
            $customerData->created_by       = \Auth::user()->creatorId();

            if(empty($customerData))
            {
                $errorArray[] = $customerData;
            }
            else
            {
                $customerData->save();
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

    public function searchCustomers(Request $request)
    {
        if (\Illuminate\Support\Facades\Auth::user()->can('manage customer')) {
            $customers = [];
            $search    = $request->search;
            if ($request->ajax() && isset($search) && !empty($search)) {
                $customers = Customer::select('id as value', 'name as label', 'email')->where('is_active', '=', 1)->where('created_by', '=', Auth::user()->getCreatedBy())->Where('name', 'LIKE', '%' . $search . '%')->orWhere('email', 'LIKE', '%' . $search . '%')->get();

                return json_encode($customers);
            }

            return $customers;
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }




}
