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
use Obydul\LaraSkrill\SkrillClient;
use Obydul\LaraSkrill\SkrillRequest;

class SkrillPaymentController extends Controller
{
    public    $email;
    public    $is_enabled;
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


        $this->email      = isset($payment_setting['skrill_email']) ? $payment_setting['skrill_email'] : '';
        $this->is_enabled = isset($payment_setting['is_skrill_enabled']) ? $payment_setting['is_skrill_enabled'] : 'off';

        return $this;
    }


    public function planPayWithSkrill(Request $request)
    {
        $payment    = $this->paymentConfig();
        $planID     = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $plan       = Plan::find($planID);
        $authuser   = Auth::user();
        $coupons_id = '';

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
                    $coupons_id             = $coupons->id;
                    if($usedCoupun >= $coupons->limit)
                    {
                        return redirect()->back()->with('error', __('This coupon code has expired.'));
                    }
                    $price = $price - $discount_value;
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

                    $orderID = time();
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
                            'payment_type' => __('Skrill'),
                            'payment_status' => 'succeeded',
                            'receipt' => null,
                            'user_id' => $authuser->id,
                        ]
                    );
                    $assignPlan = $authuser->assignPlan($plan->id);

                    return redirect()->route('plans.index')->with('success', __('Plan activated Successfully!'));
                }
                else
                {
                    return redirect()->back()->with('error', __('Plan fail to upgrade.'));
                }
            }
            $tran_id             = md5(date('Y-m-d') . strtotime('Y-m-d H:i:s') . 'user_id');
            $skill               = new SkrillRequest();
            $skill->pay_to_email = $this->email;
            $skill->return_url   = route(
                'plan.skrill', [
                                 $request->plan_id,
                                 'tansaction_id=' . MD5($tran_id),
                                 'coupon_id=' . $coupons_id,
                             ]
            );
            $skill->cancel_url   = route('plan.skrill', [$request->plan_id]);

            // create object instance of SkrillRequest
            $skill->transaction_id  = MD5($tran_id); // generate transaction id
            $skill->amount          = $price;
            $skill->currency        = env('CURRENCY');
            $skill->language        = 'EN';
            $skill->prepare_only    = '1';
            $skill->merchant_fields = 'site_name, customer_email';
            $skill->site_name       = \Auth::user()->name;
            $skill->customer_email  = \Auth::user()->email;

            // create object instance of SkrillClient
            $client = new SkrillClient($skill);
            $sid    = $client->generateSID(); //return SESSION ID

            // handle error
            $jsonSID = json_decode($sid);
            if($jsonSID != null && $jsonSID->code == "BAD_REQUEST")
            {
                return redirect()->back()->with('error', $jsonSID->message);
            }


            // do the payment
            $redirectUrl = $client->paymentRedirectUrl($sid); //return redirect url
            if($tran_id)
            {
                $data = [
                    'amount' => $price,
                    'trans_id' => MD5($request['transaction_id']),
                    'currency' => env('CURRENCY'),
                ];
                session()->put('skrill_data', $data);
            }

            return redirect($redirectUrl);

        }
        else
        {
            return redirect()->back()->with('error', 'Plan is deleted.');
        }

    }

    public function getPaymentStatus(Request $request, $plan)
    {

        $planID  = \Illuminate\Support\Facades\Crypt::decrypt($plan);
        $plan    = Plan::find($planID);
        $user    = \Auth::user();
        $orderID = time();
        if($plan)
        {
            try
            {

                if(session()->has('skrill_data') && isset($request->tansaction_id) && !empty($request->tansaction_id))
                {
                    $get_data = session()->get('skrill_data');

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
                    $order->price          = isset($get_data['amount']) ? $get_data['amount'] : 0;
                    $order->price_currency = env('CURRENCY_CODE');
                    $order->txn_id         = isset($request->transaction_id) ? $request->transaction_id : '';
                    $order->payment_type   = __('Skrill');
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


    public function customerPayWithSkrill(Request $request)
    {


        $invoiceID = \Illuminate\Support\Facades\Crypt::decrypt($request->invoice_id);
        $invoice   = Invoice::find($invoiceID);
        $user      = User::find($invoice->created_by);
        $this->invoiceData = $invoice;
        $payment = $this->paymentConfig();

        if($invoice)
        {
            $price = $request->amount;
            if($price > 0)
            {

                $tran_id             = md5(date('Y-m-d') . strtotime('Y-m-d H:i:s') . 'user_id');
                $skill               = new SkrillRequest();
                $skill->pay_to_email = $this->email;
                $skill->return_url   = route(
                    'customer.skrill', [
                                         $request->invoice_id,
                                         $price,
                                         'tansaction_id=' . MD5($tran_id),
                                     ]
                );
                $skill->cancel_url   = route(
                    'customer.skrill', [
                                         $request->invoice_id,
                                         $price,
                                     ]
                );

                // create object instance of SkrillRequest
                $skill->transaction_id  = MD5($tran_id); // generate transaction id
                $skill->amount          = $price;
                $skill->currency        = Utility::getValByName('site_currency');
                $skill->language        = 'EN';
                $skill->prepare_only    = '1';
                $skill->merchant_fields = 'site_name, customer_email';
                $skill->site_name       = $user->name;
                $skill->customer_email  = $user->email;

                // create object instance of SkrillClient
                $client = new SkrillClient($skill);
                $sid    = $client->generateSID(); //return SESSION ID

                // handle error
                $jsonSID = json_decode($sid);
                if($jsonSID != null && $jsonSID->code == "BAD_REQUEST")
                {
                    return redirect()->back()->with('error', $jsonSID->message);
                }


                // do the payment
                $redirectUrl = $client->paymentRedirectUrl($sid); //return redirect url
                if($tran_id)
                {
                    $data = [
                        'amount' => $price,
                        'trans_id' => MD5($request['transaction_id']),
                        'currency' => Utility::getValByName('site_currency'),
                    ];
                    session()->put('skrill_data', $data);
                }


                return redirect($redirectUrl);

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

    public function getInvoicePaymentStatus(Request $request, $invoice_id, $amount)
    {

        $invoiceID = \Illuminate\Support\Facades\Crypt::decrypt($invoice_id);
        $invoice   = Invoice::find($invoiceID);
        $this->invoiceData = $invoice;

        $payment  = $this->paymentConfig();
        $orderID  = strtoupper(str_replace('.', '', uniqid('', true)));
        $settings = DB::table('settings')->where('created_by', '=', $invoice->created_by)->get()->pluck('value', 'name');


        $result    = array();

        if($invoice)
        {
            try
            {

                if(session()->has('skrill_data') && isset($request->tansaction_id) && !empty($request->tansaction_id))
                {
                    $get_data = session()->get('skrill_data');

                    $payments = InvoicePayment::create(
                        [
                            'invoice_id' => $invoice->id,
                            'date' => date('Y-m-d'),
                            'amount' => $request->amount,
                            'payment_method' => 1,
                            'order_id' => $orderID,
                            'payment_type' => __('Skrill'),
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
                        $msg = __("New payment of").' ' . $request->amount . __("created for").' ' . $customer->name . __("by").' '. __('Skrill'). '.';
                        Utility::send_slack_msg($msg,$invoice->created_by);
                    }


                    //Telegram Notification
                    $setting  = Utility::settings($invoice->created_by);
                    $customer = Customer::find($invoice->customer_id);
                    if(isset($setting['telegram_payment_notification']) && $setting['telegram_payment_notification'] == 1)
                    {
                        $msg = __("New payment of").' ' . $request->amount . __("created for").' ' . $customer->name . __("by").' '. __('Skrill'). '.';
                        Utility::send_telegram_msg($msg,$invoice->created_by);
                    }

                    //Twilio Notification
                    $setting  = Utility::settings($invoice->created_by);
                    $customer = Customer::find($invoice->customer_id);
                    if(isset($setting['twilio_payment_notification']) && $setting['twilio_payment_notification'] ==1)
                    {
                        $msg = __("New payment of").' ' . $amount . __("created for").' ' . $customer->name . __("by").' '.  $payments['payment_type'] . '.';
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
