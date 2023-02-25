<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\Order;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserCoupon;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class RazorpayPaymentController extends Controller
{
    //
    public $secret_key;
    public $public_key;
    public $is_enabled;
    protected $invoiceData;

    public function paymentConfig()
    {
        if(\Auth::check())
        {
            $payment_setting = Utility::getAdminPaymentSetting();
        }
        else
        {
            $payment_setting = Utility::getCompanyPaymentSetting($this->invoiceData->created_by);
        }

        $this->secret_key = isset($payment_setting['razorpay_secret_key']) ? $payment_setting['razorpay_secret_key'] : '';
        $this->public_key = isset($payment_setting['razorpay_public_key']) ? $payment_setting['razorpay_public_key'] : '';
        $this->is_enabled = isset($payment_setting['is_razorpay_enabled']) ? $payment_setting['is_razorpay_enabled'] : 'off';

        return $this;
    }


    public function planPayWithRazorpay(Request $request)
    {

        $planID    = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $plan      = Plan::find($planID);
        $authuser  = \Auth::user();
        $coupon_id = '';
        if($plan)
        {

            $price = $plan->price;
            if(isset($request->coupon) && !empty($request->coupon))
            {
                $request->coupon = trim($request->coupon);
                $coupons         = Coupon::where('code', strtoupper($request->coupon))->where('is_active', '1')->first();
                if(!empty($coupons))
                {
                    $usedCoupun             = $coupons->used_coupon();
                    $discount_value         = ($price / 100) * $coupons->discount;
                    $plan->discounted_price = $price - $discount_value;

                    if($usedCoupun >= $coupons->limit)
                    {
                        return redirect()->back()->with('error', __('This coupon code has expired.'));
                    }
                    $price     = $price - $discount_value;
                    $coupon_id = $coupons->id;
                }
                else
                {
                    return redirect()->back()->with('error', __('This coupon code is invalid or has expired.'));
                }
            }

            if($price <= 0)
            {
                $authuser->plan = $plan->id;
                $authuser->save();

                $assignPlan = $authuser->assignPlan($plan->id);

                if($assignPlan['is_success'] == true && !empty($plan))
                {

                    $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
                    Order::create(
                        [
                            'order_id' => $orderID,
                            'name' => null,
                            'email' => null,
                            'card_number' => null,
                            'card_exp_month' => null,
                            'card_exp_year' => null,
                            'plan_name' => $plan->name,
                            'plan_id' => $plan->id,
                            'price' => $price == null ? 0 : $price,
                            'price_currency' => !empty(env('CURRENCY')) ? env('CURRENCY') : 'USD',
                            'txn_id' => '',
                            'payment_type' => 'Razorpay',
                            'payment_status' => 'succeeded',
                            'receipt' => null,
                            'user_id' => $authuser->id,
                        ]
                    );
                    $res['msg']  = __("Plan successfully upgraded.");
                    $res['flag'] = 2;

                    return $res;
                }
                else
                {
                    return Utility::error_res(__('Plan fail to upgrade.'));
                }
            }

            $res_data['email']       = Auth::user()->email;
            $res_data['total_price'] = $price;
            $res_data['currency']    = env('CURRENCY');
            $res_data['flag']        = 1;
            $res_data['coupon']      = $coupon_id;

            return $res_data;
        }
        else
        {
            return Utility::error_res(__('Plan is deleted.'));
        }

    }

    public function getPaymentStatus(Request $request, $pay_id, $plan)
    {
        $payment = $this->paymentConfig();
        $planID  = \Illuminate\Support\Facades\Crypt::decrypt($plan);
        $plan    = Plan::find($planID);
        $user    = \Auth::user();
        if($plan)
        {
            try
            {
                $orderID = time();
                $ch      = curl_init('https://api.razorpay.com/v1/payments/' . $pay_id . '');
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                curl_setopt($ch, CURLOPT_USERPWD, $this->public_key . ':' . $this->secret_key); // Input your Razorpay Key Id and Secret Id here
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = json_decode(curl_exec($ch));
                // check that payment is authorized by razorpay or not

                if($response->status == 'authorized')
                {

                    if($request->has('coupon_id') && $request->coupon_id != '')
                    {
                        $coupons = Coupon::find($request->coupon_id);
                        if(!empty($coupons))
                        {
                            $userCoupon         = new UserCoupon();
                            $userCoupon->user   = $user->id;
                            $userCoupon->coupon = $coupons->id;
                            $userCoupon->order  = $orderID;
                            $userCoupon->save();


                            $usedCoupun = $coupons->used_coupon();
                            if($coupons->limit <= $usedCoupun)
                            {
                                $coupons->is_active = 0;
                                $coupons->save();
                            }
                        }
                    }

                    $order                 = new Order();
                    $order->order_id       = $orderID;
                    $order->name           = $user->name;
                    $order->card_number    = '';
                    $order->card_exp_month = '';
                    $order->card_exp_year  = '';
                    $order->plan_name      = $plan->name;
                    $order->plan_id        = $plan->id;
                    $order->price          = isset($response->amount) ? $response->amount / 100 : 0;
                    $order->price_currency = env('CURRENCY');
                    $order->txn_id         = isset($response->id) ? $response->id : $pay_id;
                    $order->payment_type   = __('Razorpay');
                    $order->payment_status = 'success';
                    $order->receipt        = '';
                    $order->user_id        = $user->id;
                    $order->save();


                    $assignPlan = $user->assignPlan($plan->id, $request->payment_frequency);

                    if($assignPlan['is_success'])
                    {
                        return redirect()->route('plans.index')->with('success', __('Plan activated Successfully!'));
                    }
                    else
                    {
                        return redirect()->route('plans.index')->with('error', __($assignPlan['error']));
                    }
                }
                else
                {
                    return redirect()->route('plans.index')->with('error', __('Transaction has been failed! '));
                }
            }
            catch(\Exception $e)
            {


                return redirect()->route('plans.index')->with('error', __('Plan not found!'));
            }
        }
    }

    public function customerPayWithRazorpay(Request $request)
    {

        $invoiceID = \Illuminate\Support\Facades\Crypt::decrypt($request->invoice_id);
        $invoice   = Invoice::find($invoiceID);
        $user      = User::find($invoice->created_by);
        if($invoice)
        {
            $price = $request->amount;
            if($price > 0)
            {
                $res_data['email']       = $user->email;
                $res_data['total_price'] = $price;
                $res_data['currency']    = Utility::getValByName('site_currency');
                $res_data['flag']        = 1;

                return $res_data;

            }
            else
            {
                $res['msg']  = __("Enter valid amount.");
                $res['flag'] = 2;

                return $res;
            }

        }
        else
        {
            return redirect()->back()->with('error', __('Invoice is deleted.'));

        }

    }

    public function getInvoicePaymentStatus(Request $request, $pay_id, $invoice_id)
    {
        $invoiceID = \Illuminate\Support\Facades\Crypt::decrypt($invoice_id);
        $invoice   = Invoice::find($invoiceID);
        $this->invoiceData = $invoice;

        $orderID   = strtoupper(str_replace('.', '', uniqid('', true)));
        $settings  = DB::table('settings')->where('created_by', '=', $invoice->created_by)->get()->pluck('value', 'name');
        $payment   = $this->paymentConfig();
        $result    = array();

        if($invoice)
        {
            try
            {
                $orderID = time();
                $ch      = curl_init('https://api.razorpay.com/v1/payments/' . $pay_id . '');
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                curl_setopt($ch, CURLOPT_USERPWD, $this->public_key . ':' . $this->secret_key); // Input your Razorpay Key Id and Secret Id here
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = json_decode(curl_exec($ch));
                // check that payment is authorized by razorpay or not

                if($response->status == 'authorized')
                {

                    $payments = InvoicePayment::create(
                        [

                            'invoice_id' => $invoice->id,
                            'date' => date('Y-m-d'),
                            'amount' => $request->amount,
                            'payment_method' => 1,
                            'order_id' => $orderID,
                            'payment_type' => __('Razorpay'),
                            'receipt' => '',
                            'description' => __('Invoice') . ' ' . Utility::invoiceNumberFormat($settings, $invoice->invoice_id),
                        ]
                    );

                    $invoice = Invoice::find($invoice->id);


                    if($invoice->getDue() <= 0)
                    {
                        Invoice::change_status($invoice->id, 4);
                    }
                    else
                    {
                        Invoice::change_status($invoice->id, 3);
                    }

                    //Slack Notification
                    $setting  = Utility::settings($invoice->created_by);
                    $customer = Customer::find($invoice->customer_id);
                    if(isset($setting['payment_notification']) && $setting['payment_notification'] == 1)
                    {
                        $msg = __("New payment of").' ' . $request->amount . __("created for").' '. $customer->name . __("by").' '. __('Razorpay'). '.';
                        Utility::send_slack_msg($msg,$invoice->created_by);
                    }


                    //Telegram Notification
                    $setting  = Utility::settings($invoice->created_by);
                    $customer = Customer::find($invoice->customer_id);
                    if(isset($setting['telegram_payment_notification']) && $setting['telegram_payment_notification'] == 1)
                    {
                        $msg = __("New payment of").' ' . $request->amount . __("created for").' '. $customer->name . __("by").' '. __('Razorpay'). '.';
                        Utility::send_telegram_msg($msg,$invoice->created_by);
                    }

                    //Twilio Notification
                    $setting  = Utility::settings($invoice->created_by);
                    $customer = Customer::find($invoice->customer_id);
                    if(isset($setting['twilio_payment_notification']) && $setting['twilio_payment_notification'] ==1)
                    {
                        $msg = __("New payment of").' ' . $request->amount . __("created for").' ' . $customer->name . __("by").' '.  $payments['payment_type'] . '.';
                        Utility::send_twilio_msg($customer->contact,$msg,$invoice->created_by);
                    }




                    return redirect()->route('invoice.link.copy', Crypt::encrypt($invoice->id))->with('success', __(' Payment successfully added.'));
                }
                else
                {
                    return redirect()->route('invoice.link.copy', Crypt::encrypt($invoice->id))->with('error', __('Transaction has been failed! '));
                }
            }
            catch(\Exception $e)
            {

                return redirect()->route('invoice.link.copy', Crypt::encrypt($invoice->id))->with('error', __('Invoice not found!'));
            }
        }
    }
}
