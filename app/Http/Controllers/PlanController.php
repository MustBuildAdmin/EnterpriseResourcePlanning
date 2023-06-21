<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Utility;
use File;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {

        if(\Auth::user()->can('manage plan'))
        {
            $plans                 = Plan::get();
            $admin_payment_setting = Utility::getAdminPaymentSetting();

            return view('plan.index', compact('plans', 'admin_payment_setting'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {

        if(\Auth::user()->can('create plan'))
        {
            $arrDuration = [
                'unlimited' => __('unlimited'),
                'month' => __('Per Month'),
                'year' => __('Per Year'),
            ];

            return view('plan.create', compact('arrDuration'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function store(Request $request)
    {
        if(\Auth::user()->can('create plan'))
        {
            $admin_payment_setting = Utility::getAdminPaymentSetting();

            if(!empty($admin_payment_setting) && ($admin_payment_setting['is_stripe_enabled'] == 'on' || $admin_payment_setting['is_paypal_enabled'] == 'on' || $admin_payment_setting['is_paystack_enabled'] == 'on' || $admin_payment_setting['is_flutterwave_enabled'] == 'on' || $admin_payment_setting['is_razorpay_enabled'] == 'on' || $admin_payment_setting['is_mercado_enabled'] == 'on' || $admin_payment_setting['is_paytm_enabled'] == 'on' || $admin_payment_setting['is_mollie_enabled'] == 'on' || $admin_payment_setting['is_skrill_enabled'] == 'on' || $admin_payment_setting['is_coingate_enabled'] == 'on'))
            {

                $validation                  = [];
                $validation['name']          = 'required|unique:plans';
                $validation['price']         = 'required|numeric|min:0';
                $validation['duration']      = 'required';
                $validation['max_users']     = 'required|numeric';
                $validation['max_customers'] = 'required|numeric';
                $validation['max_venders']   = 'required|numeric';

                if($request->image)
                {
                    $validation['image'] = 'required|max:20480';
                }
                $request->validate($validation);
                $post = $request->all();
                if(isset($request->enable_project))
                {
                    $post['project'] = 1;
                }
                if(isset($request->enable_crm))
                {
                    $post['crm'] = 1;
                }
                if(isset($request->enable_hrm))
                {
                    $post['hrm'] = 1;
                }
                if(isset($request->enable_account))
                {
                    $post['account'] = 1;
                }
                if($request->hasFile('image'))
                {
                    $filenameWithExt = $request->file('image')->getClientOriginalName();
                    $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension       = $request->file('image')->getClientOriginalExtension();
                    $fileNameToStore = 'plan_' . time() . '.' . $extension;

                    $dir = storage_path('uploads/plan/');
                    if(!file_exists($dir))
                    {
                        mkdir($dir, 0777, true);
                    }
                    $path          = $request->file('image')->storeAs('uploads/plan/', $fileNameToStore);
                    $post['image'] = $fileNameToStore;
                }

                if(Plan::create($post))
                {
                    return redirect()->back()->with('success', __('Plan Successfully created.'));
                }
                else
                {
                    return redirect()->back()->with('error', __('Something is wrong.'));
                }

            }
            else
            {
                return redirect()->back()->with('error', __('Please set stripe or paypal api key & secret key for add new plan.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }


    public function edit($plan_id)
    {
        if(\Auth::user()->can('edit plan'))
        {
            $arrDuration = Plan::$arrDuration;
            $plan        = Plan::find($plan_id);

            return view('plan.edit', compact('plan', 'arrDuration'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function update(Request $request, $plan_id)
    {

        if(\Auth::user()->can('edit plan'))
        {

            $admin_payment_setting = Utility::getAdminPaymentSetting();

            if(!empty($admin_payment_setting) && ($admin_payment_setting['is_stripe_enabled'] == 'on' || $admin_payment_setting['is_paypal_enabled'] == 'on' || $admin_payment_setting['is_paystack_enabled'] == 'on' || $admin_payment_setting['is_flutterwave_enabled'] == 'on' || $admin_payment_setting['is_razorpay_enabled'] == 'on' || $admin_payment_setting['is_mercado_enabled'] == 'on' || $admin_payment_setting['is_paytm_enabled'] == 'on' || $admin_payment_setting['is_mollie_enabled'] == 'on' || $admin_payment_setting['is_skrill_enabled'] == 'on' || $admin_payment_setting['is_coingate_enabled'] == 'on'))
            {
                $plan = Plan::find($plan_id);
                if(!empty($plan))
                {
                    $validation                  = [];
                    $validation['name']          = 'required|unique:plans,name,' . $plan_id;
                    $validation['duration']      = 'required';
                    $validation['max_users']     = 'required|numeric';
                    $validation['max_customers'] = 'required|numeric';
                    $validation['max_venders']   = 'required|numeric';

                    $request->validate($validation);
                    $post = $request->all();
                    if(array_key_exists('enable_project', $post))
                    {
                        $post['project'] = 1;
                    }
                    else
                    {
                        $post['project'] = 0;
                    }
                    if(array_key_exists('enable_crm', $post))
                    {
                        $post['crm'] = 1;
                    }
                    else
                    {
                        $post['crm'] = 0;
                    }
                    if(array_key_exists('enable_hrm', $post))
                    {
                        $post['hrm'] = 1;
                    }
                    else
                    {
                        $post['hrm'] = 0;
                    }
                    if(array_key_exists('enable_account', $post))
                    {
                        $post['account'] = 1;
                    }
                    else
                    {
                        $post['account'] = 0;
                    }

                    if($request->hasFile('image'))
                    {
                        $filenameWithExt = $request->file('image')->getClientOriginalName();
                        $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        $extension       = $request->file('image')->getClientOriginalExtension();
                        $fileNameToStore = 'plan_' . time() . '.' . $extension;

                        $dir = storage_path('uploads/plan/');
                        if(!file_exists($dir))
                        {
                            mkdir($dir, 0777, true);
                        }
                        $image_path = $dir . '/' . $plan->image;  // Value is not URL but directory file path
                        if(File::exists($image_path))
                        {

                            chmod($image_path, 0755);
                            File::delete($image_path);
                        }
                        $path = $request->file('image')->storeAs('uploads/plan/', $fileNameToStore);

                        $post['image'] = $fileNameToStore;
                    }

                    if($plan->update($post))
                    {
                        return redirect()->back()->with('success', __('Plan successfully updated.'));
                    }
                    else
                    {
                        return redirect()->back()->with('error', __('Something is wrong.'));
                    }
                }
                else
                {
                    return redirect()->back()->with('error', __('Plan not found.'));
                }


            }
            else
            {
                return redirect()->back()->with('error', __('Please set stripe api key & secret key for add new plan.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }


    public function userPlan(Request $request)
    {
        $objUser = \Auth::user();
        $planID  = \Illuminate\Support\Facades\Crypt::decrypt($request->code);
        $plan    = Plan::find($planID);
        if($plan)
        {
            if($plan->price <= 0)
            {
                $objUser->assignPlan($plan->id);

                return redirect()->route('plans.index')->with('success', __('Plan successfully activated.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Something is wrong.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Plan not found.'));
        }
    }
}
