<?php

namespace App\Http\Controllers;

use App\Models\ClientDeal;
use App\Models\ClientPermission;
use App\Models\Contract;
use App\Models\CustomField;
use App\Models\Estimation;
use App\Models\Invoice;
use App\Models\Plan;
use App\Models\User;
use App\Models\Utility;
use App\Models\Project;
use http\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Config;
class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware(
            [
                'auth',
                'XSS',
            ]
        );
    }

    public function index(Request $request)
    {
        if(\Auth::user()->can('manage client'))
        {
            $user    = \Auth::user();
            $clients =User::where([
                ['name', '!=', Null],
                [function ($query) use ($request) {
                    if (($s = $request->search)) {
                        $user = \Auth::user();
                        $query->orWhere('name', 'LIKE', '%' . $s . '%')
                        ->orWhere('email', 'LIKE', '%' . $s . '%')
                        ->get();
                    }
                }]
            ])->where('created_by', '=', $user->creatorId())->where('type', '=', 'client')->paginate(8);
            // $clients = User::where('created_by', '=', $user->creatorId())->where('type', '=', 'client')->paginate(1);

            return view('client.index', compact('clients'));
        }
        else
        {

            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function create(Request $request)
    {

        if(\Auth::user()->can('create client'))
        {
            if($request->ajax)
            {
                return view('clients.createAjax');
            }
            else
            {
                $gender=['male'=>'Male','female'=>'Female','other'=>'Other'];
                $country=Utility::getcountry();

                $customFields = CustomField::where('module', '=', 'client')->get();

                return view('clients.create', compact('customFields','gender','country'));
            }
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    function customerNumber()
    {
        $latest = User::where('created_by', '=', \Auth::user()->creatorId())->latest()->first();
        if(!$latest)
        {
                return 1;
        }else{
          
                return $latest->customer_id + 1;
        }

    }

    public function store(Request $request)
    {
       
        if(\Auth::user()->can('create client'))
                {
                    $user      = \Auth::user();
                    $validator = \Validator::make(
                        $request->all(), [
                                           'name' => 'required',
                                           'email' => 'required|email|unique:users',
                                           'password' => 'required',
                                       ]
                    );

                    if($validator->fails())
                    {
                        $messages = $validator->getMessageBag();
                        if($request->ajax)
                        {
                            return response()->json(['error' => $messages->first()], 401);
                        }
                        else
                        {
                            return redirect()->back()->with('error', $messages->first());
                        }
                    }
                    $objCustomer    = \Auth::user();
                    $creator        = User::find($objCustomer->creatorId());
                    $total_client = User::where('type','client')->count();
                    // dd($total_client);
                    $plan           = Plan::find($creator->plan);
                    $user_value=$this->customerNumber();

                    // user profile update 
                    if(isset($request->avatar)){
                        
                            $filenameWithExt = $request->file('avatar')->getClientOriginalName();
                            $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                            $extension       = $request->file('avatar')->getClientOriginalExtension();
                            $fileNameToStore = $filename . '_' . time() . '.' . $extension;  
                        
                            $dir = Config::get('constants.USER_IMAGE');
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
                    if(isset($url)){
                        $avatar=$url;
                    }else{
                        $avatar=null;
                    }
                    // user profile update completed
                    if($request->copy_status!=null){
                        $copy_status=$request->copy_status;

                        $shipping_name    = $request->name;
                        $shipping_country = $request->billing_country;
                        $shipping_state   = $request->billing_state;
                        $shipping_city    = $request->billing_city;
                        $shipping_phone   = $request->billing_phone;
                        $shipping_zip     = $request->billing_zip;
                        $shipping_address = $request->billing_address;
                    }else{
                        $copy_status=0;

                        $shipping_name    = $request->shipping_name;
                        $shipping_country = $request->shipping_country;
                        $shipping_state   = $request->shipping_state;
                        $shipping_city    = $request->shipping_city;
                        $shipping_phone   = $request->shipping_phone;
                        $shipping_zip     = $request->shipping_zip;
                        $shipping_address = $request->shipping_address;
                    }

                    if($total_client < $plan->max_clients || $plan->max_clients == -1)
                    {
                        $role = Role::findByName('client');
                        $client = User::create(
                            [
                                'name' => $request->name,
                                'email' => $request->email,
                                'job_title' => $request->job_title,
                                'password' => Hash::make($request->password),
                                'type' => 'client',
                                'lang' => Utility::getValByName('default_language'),
                                'created_by' => $user->creatorId(),
                                'country'=>$request->billing_country,
                                'state'=>$request->billing_state,
                                'city'=>$request->billing_city,
                                'phone'=>$request->billing_phone,
                                'zip'=>$request->billing_zip,
                                'avatar'=>$avatar,
                                'address'=>$request->billing_address,
                                'customer_id'=>$user_value,
                                'tax_number'=>$request->tax_number,
                                'billing_name'=>$request->name,
                                'billing_country'=>$request->billing_country,
                                'billing_state'=>$request->billing_state,
                                'billing_city'=>$request->billing_city,
                                'billing_phone'=>$request->billing_phone,
                                'billing_zip'=>$request->billing_zip,
                                'billing_address'=>$request->billing_address,
                                'shipping_name'=>$shipping_name,
                                'shipping_country'=>$shipping_country,
                                'shipping_state'=>$shipping_state,
                                'shipping_city'=>$shipping_city,
                                'shipping_phone'=>$shipping_phone,
                                'shipping_zip'=>$shipping_zip,
                                'shipping_address'=>$shipping_address,
                                'copy_status'=>$copy_status
                            ]
                        );

                          
                        //Send Email

                        $role_r = Role::findByName('client');
                        $client->assignRole($role_r);

                        $client->password = $request->password;
                        $clientArr = [
                            'client_name' => $client->name,
                            'client_email' => $client->email,
                            'client_password' =>  $client->password,
                        ];
                        $resp = Utility::sendEmailTemplate('create_client', [$client->email], $clientArr);


                        return redirect()->route('clients.index')->with('success', __('Client successfully added.') . ((!empty($resp) && $resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));

                    }


                    else
                    {
                        return redirect()->back()->with('error', __('Your user limit is over, Please upgrade plan.'));
                    }

                }
        else
        {
            if($request->ajax)
                    {
                        return response()->json(['error' => __('Permission Denied.')], 401);
                    }
            else
            {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
    }

    public function show(User $client)
    {
        $usr = Auth::user();
        if(!empty($client) && $usr->id == $client->creatorId() && $client->id != $usr->id && $client->type == 'client')
        {
            // For Estimations
            $estimations = $client->clientEstimations()->orderByDesc('id')->get();
            $curr_month  = $client->clientEstimations()->whereMonth('issue_date', '=', date('m'))->get();
            $curr_week   = $client->clientEstimations()->whereBetween(
                'issue_date', [
                                \Carbon\Carbon::now()->startOfWeek(),
                                \Carbon\Carbon::now()->endOfWeek(),
                            ]
            )->get();
            $last_30days = $client->clientEstimations()->whereDate('issue_date', '>', \Carbon\Carbon::now()->subDays(30))->get();
            // Estimation Summary
            $cnt_estimation                = [];
            $cnt_estimation['total']       = Estimation::getEstimationSummary($estimations);
            $cnt_estimation['this_month']  = Estimation::getEstimationSummary($curr_month);
            $cnt_estimation['this_week']   = Estimation::getEstimationSummary($curr_week);
            $cnt_estimation['last_30days'] = Estimation::getEstimationSummary($last_30days);

            $cnt_estimation['cnt_total']       = $estimations->count();
            $cnt_estimation['cnt_this_month']  = $curr_month->count();
            $cnt_estimation['cnt_this_week']   = $curr_week->count();
            $cnt_estimation['cnt_last_30days'] = $last_30days->count();

            // For Contracts
            $contracts   = $client->clientContracts()->orderByDesc('id')->get();
            $curr_month  = $client->clientContracts()->whereMonth('start_date', '=', date('m'))->get();
            $curr_week   = $client->clientContracts()->whereBetween(
                'start_date', [
                                \Carbon\Carbon::now()->startOfWeek(),
                                \Carbon\Carbon::now()->endOfWeek(),
                            ]
            )->get();
            $last_30days = $client->clientContracts()->whereDate('start_date', '>', \Carbon\Carbon::now()->subDays(30))->get();

            // Contracts Summary
            $cnt_contract                = [];
            $cnt_contract['total']       = Contract::getContractSummary($contracts);
            $cnt_contract['this_month']  = Contract::getContractSummary($curr_month);
            $cnt_contract['this_week']   = Contract::getContractSummary($curr_week);
            $cnt_contract['last_30days'] = Contract::getContractSummary($last_30days);

            $cnt_contract['cnt_total']       = $contracts->count();
            $cnt_contract['cnt_this_month']  = $curr_month->count();
            $cnt_contract['cnt_this_week']   = $curr_week->count();
            $cnt_contract['cnt_last_30days'] = $last_30days->count();

            return view('clients.show', compact('client', 'estimations', 'cnt_estimation', 'contracts', 'cnt_contract'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function edit(User $client)
    {
        if(\Auth::user()->can('edit client'))
        {
            $user = \Auth::user();
            if($client->created_by == $user->creatorId())
            {
                $user  = User::findOrFail($client->id);
                $gender=['male'=>'Male','female'=>'Female','other'=>'Other'];
                $client->customField = CustomField::getData($client, 'client');
                $customFields        = CustomField::where('module', '=', 'client')->get();
                $countrylist=Utility::getcountry();
                $statelist=Utility::getstate($user->country);
                return view('clients.edit', compact('user','gender','client', 'customFields','statelist','countrylist'));
            }
            else
            {
                return response()->json(['error' => __('Invalid Client.')], 401);
            }
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    public function update(User $client, Request $request)
    {
        if(\Auth::user()->can('edit client'))
        {
            $user = \Auth::user();
            if($client->created_by == $user->creatorId())
            {
                $validation = [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email,' . $client->id,
                ];

                $post         = [];
                $post['name'] = $request->name;
                if(!empty($request->password))
                {
                    $validation['password'] = 'required';
                    $post['password']       = Hash::make($request->password);
                }

                $validator = \Validator::make($request->all(), $validation);
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
                
                    $dir = Config::get('constants.USER_IMAGE');
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
                if(isset($url)){
                    $avatar=$url;
                }else{
                    $avatar=null;
                }
                if($request->copy_status!=null){
                    $copy_status=$request->copy_status;

                    $shipping_name    = $request->name;
                    $shipping_country = $request->billing_country;
                    $shipping_state   = $request->billing_state;
                    $shipping_city    = $request->billing_city;
                    $shipping_phone   = $request->billing_phone;
                    $shipping_zip     = $request->billing_zip;
                    $shipping_address = $request->billing_address;
                }else{
                    $copy_status=0;

                    $shipping_name    = $request->shipping_name;
                    $shipping_country = $request->shipping_country;
                    $shipping_state   = $request->shipping_state;
                    $shipping_city    = $request->shipping_city;
                    $shipping_phone   = $request->shipping_phone;
                    $shipping_zip     = $request->shipping_zip;
                    $shipping_address = $request->shipping_address;
                }

                if(isset($url)){
                    $post['avatar']=$url;
                }
                $post['email'] = $request->email;
                $post['country']=$request->country;
                $post['state']=$request->state;
                $post['city']=$request->city;
                $post['phone']=$request->phone;
                $post['zip']=$request->zip;
                $post['address']=$request->address;
                $post['tax_number']=$request->tax_number;
                $post['billing_name']=$request->name;
                $post['billing_country']=$request->billing_country;
                $post['billing_state']=$request->billing_state;
                $post['billing_city']=$request->billing_city;
                $post['billing_phone']=$request->billing_phone;
                $post['billing_zip']=$request->billing_zip;
                $post['billing_address']=$request->billing_address;
                $post['shipping_name']=$shipping_name;
                $post['shipping_country']=$shipping_country;
                $post['shipping_state']=$shipping_state;
                $post['shipping_city']=$shipping_city;
                $post['shipping_phone']=$shipping_phone;
                $post['shipping_zip']=$shipping_zip;
                $post['shipping_address']=$shipping_address;
                $post['copy_status']=$copy_status;
               
                $client->update($post);

                CustomField::saveData($client, $request->customField);

                return redirect()->back()->with('success', __('Client Updated Successfully!'));
            }
            else
            {
                return redirect()->back()->with('error', __('Invalid Client.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function destroy(User $client)
    {
        $user = \Auth::user();
        // Check client for Proejct assign
        $projects=Project::where(['client_id'=>$client->id])->whereNotIn('status',['complete','canceled'])->get();
        if(count($projects)>0){
            return redirect()->back()->with('error', 'This client has assigned for some open projects.');
        }else{
            if($client->created_by == $user->creatorId())
            {
                $estimation = Estimation::where('client_id', '=', $client->id)->first();
                if(empty($estimation))
                {
                  /*  ClientDeal::where('client_id', '=', $client->id)->delete();
                    ClientPermission::where('client_id', '=', $client->id)->delete();*/
                    $client->delete();
                    return redirect()->back()->with('success', __('Client Deleted Successfully!'));
                }
                else
                {
                    return redirect()->back()->with('error', __('This client has assigned some estimation.'));
                }
            }
            else
            {
                return redirect()->back()->with('error', __('Invalid Client.'));
            }
        }
    }

    public function clientPassword($id)
    {
        $eId        = \Crypt::decrypt($id);
        $user = User::find($eId);
        $client = User::where('created_by', '=', $user->creatorId())->where('type', '=', 'client')->first();


        return view('clients.reset', compact('user', 'client'));
    }

    public function clientPasswordReset(Request $request, $id)
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

        return redirect()->route('clients.index')->with(
            'success', 'Client Password successfully updated.'
        );


    }

   

}
