<?php

namespace App\Http\Controllers;


use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\Order;
use App\Models\Plan;
use App\Models\Transaction;
use App\Models\UserCoupon;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Stripe;

class StripePaymentController extends Controller
{
    public $settings;


    public function index()
    {
        $objUser = \Auth::user();
        if($objUser->type == 'super admin')
        {
            $orders = Order::select([
                                        'orders.*',
                                        'users.name as user_name',
                                    ])->join('users', 'orders.user_id', '=', 'users.id')->orderBy('orders.created_at', 'DESC')->get();
        }
        else
        {
            $orders = Order::select([
                                        'orders.*',
                                        'users.name as user_name',
                                    ])->join('users', 'orders.user_id', '=', 'users.id')->orderBy('orders.created_at', 'DESC')->where('users.id', '=', $objUser->id)->get();
        }

        return view('order.index', compact('orders'));
    }


    public function stripe($code)
    {

        $plan_id               = \Illuminate\Support\Facades\Crypt::decrypt($code);
        $plan                  = Plan::find($plan_id);
        $admin_payment_setting = Utility::getAdminPaymentSetting();
        if($plan)
        {
            return view('stripe', compact('plan', 'admin_payment_setting'));
        }
        else
        {
            return redirect()->back()->with('error', __('Plan is deleted.'));
        }
    }


    public function stripePost(Request $request)
    {

        $objUser = \Auth::user();
        $planID  = \Illuminate\Support\Facades\Crypt::decrypt($request->plan_id);
        $plan    = Plan::find($planID);

        $admin_payment_setting = Utility::getAdminPaymentSetting();
        if($plan)
        {
            try
            {
                $price = $plan->price;
                if(!empty($request->coupon))
                {
                    $coupons = Coupon::where('code', strtoupper($request->coupon))->where('is_active', '1')->first();
                    if(!empty($coupons))
                    {
                        $usedCoupun     = $coupons->used_coupon();
                        $discount_value = ($plan->price / 100) * $coupons->discount;
                        $price          = $plan->price - $discount_value;

                        if($coupons->limit == $usedCoupun)
                        {
                            return redirect()->back()->with('error', __('This coupon code has expired.'));
                        }
                    }
                    else
                    {
                        return redirect()->back()->with('error', __('This coupon code is invalid or has expired.'));
                    }
                }

                $orderID = strtoupper(str_replace('.', '', uniqid('', true)));

                if($price > 0.0)
                {
                    Stripe\Stripe::setApiKey($admin_payment_setting['stripe_secret']);
                    $data = Stripe\Charge::create([
                                                      "amount" => 100 * $price,
                                                      "currency" => env('CURRENCY'),
                                                      "source" => $request->stripeToken,
                                                      "description" => " Plan - " . $plan->name,
                                                      "metadata" => ["order_id" => $orderID],
                                                  ]);
                }
                else
                {
                    $data['amount_refunded'] = 0;
                    $data['failure_code']    = '';
                    $data['paid']            = 1;
                    $data['captured']        = 1;
                    $data['status']          = 'succeeded';


                }


                if($data['amount_refunded'] == 0 && empty($data['failure_code']) && $data['paid'] == 1 && $data['captured'] == 1)
                {

                    Order::create([
                                      'order_id' => $orderID,
                                      'name' => $request->name,
                                      'card_number' => isset($data['payment_method_details']['card']['last4']) ? $data['payment_method_details']['card']['last4'] : '',
                                      'card_exp_month' => isset($data['payment_method_details']['card']['exp_month']) ? $data['payment_method_details']['card']['exp_month'] : '',
                                      'card_exp_year' => isset($data['payment_method_details']['card']['exp_year']) ? $data['payment_method_details']['card']['exp_year'] : '',
                                      'plan_name' => $plan->name,
                                      'plan_id' => $plan->id,
                                      'price' => $price,
                                      'price_currency' => env('CURRENCY'),
                                      'txn_id' => isset($data['balance_transaction']) ? $data['balance_transaction'] : '',
                                      'payment_type' => __('STRIPE'),
                                      'payment_status' => isset($data['status']) ? $data['status'] : 'succeeded',
                                      'receipt' => isset($data['receipt_url']) ? $data['receipt_url'] : 'free coupon',
                                      'user_id' => $objUser->id,
                                  ]);

                    if(!empty($request->coupon))
                    {
                        $userCoupon         = new UserCoupon();
                        $userCoupon->user   = $objUser->id;
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
                    if($data['status'] == 'succeeded')
                    {
                        $assignPlan = $objUser->assignPlan($plan->id);
                        if($assignPlan['is_success'])
                        {
                            return redirect()->route('plans.index')->with('success', __('Plan successfully activated.'));
                        }
                        else
                        {
                            return redirect()->route('plans.index')->with('error', __($assignPlan['error']));
                        }
                    }
                    else
                    {
                        return redirect()->route('plans.index')->with('error', __('Your payment has failed.'));
                    }
                }
                else
                {
                    return redirect()->route('plans.index')->with('error', __('Transaction has been failed.'));
                }
            }
            catch(\Exception $e)
            {
                return redirect()->route('plans.index')->with('error', __($e->getMessage()));
            }
        }
        else
        {
            return redirect()->route('plans.index')->with('error', __('Plan is deleted.'));
        }
    }

    public function addPayment(Request $request, $id)
    {

        $invoice                 = Invoice::find($id);
        $company_payment_setting = Utility::getCompanyPaymentSetting($invoice->created_by);
        $settings                = DB::table('settings')->where('created_by', '=', $invoice->created_by)->get()->pluck('value', 'name');


        if($invoice)
        {
            if($request->amount > $invoice->getDue())
            {
                return redirect()->back()->with('error', __('Invalid amount.'));
            }
            else
            {
                try
                {

                    $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
                    $price   = $request->amount;
                    Stripe\Stripe::setApiKey($company_payment_setting['stripe_secret']);

                    $data = Stripe\Charge::create([
                                                      "amount" => 100 * $price,
                                                      "currency" => $settings['site_currency'],
                                                      "source" => $request->stripeToken,
                                                      "description" => 'Invoice ' . Utility::invoiceNumberFormat($settings, $invoice->invoice_id),
                                                      "metadata" => ["order_id" => $orderID],
                                                  ]);

                    if($data['amount_refunded'] == 0 && empty($data['failure_code']) && $data['paid'] == 1 && $data['captured'] == 1)
                    {
                        $payments = InvoicePayment::create([

                                                               'invoice_id' => $invoice->id,
                                                               'date' => date('Y-m-d'),
                                                               'amount' => $price,
                                                               'account_id' => 0,
                                                               'payment_method' => 0,
                                                               'order_id' => $orderID,
                                                               'currency' => $data['currency'],
                                                               'txn_id' => $data['balance_transaction'],
                                                               'payment_type' => __('STRIPE'),
                                                               'receipt' => $data['receipt_url'],
                                                               'reference' => '',
                                                               'description' => 'Invoice ' . Utility::invoiceNumberFormat($settings, $invoice->invoice_id),
                                                           ]);

                        if($invoice->getDue() <= 0)
                        {
                            $invoice->status = 4;
                        }
                        elseif(($invoice->getDue() - $request->amount) == 0)
                        {
                            $invoice->status = 4;
                        }
                        else
                        {
                            $invoice->status = 3;
                        }
                        $invoice->save();

                        $invoicePayment              = new Transaction();
                        $invoicePayment->user_id     = $invoice->customer_id;
                        $invoicePayment->user_type   = 'Customer';
                        $invoicePayment->type        = 'STRIPE';
                        $invoicePayment->created_by  = $invoice->invoice_id;
                        $invoicePayment->payment_id  = $invoicePayment->id;
                        $invoicePayment->category    = 'Invoice';
                        $invoicePayment->amount      = $price;
                        $invoicePayment->date        = date('Y-m-d');
                        $invoicePayment->payment_id  = $payments->id;
                        $invoicePayment->description = 'Invoice ' . Utility::invoiceNumberFormat($settings, $invoice->invoice_id);
                        $invoicePayment->account     = 0;
                        Transaction::addTransaction($invoicePayment);

                        Utility::userBalance('customer', $invoice->customer_id, $request->amount, 'debit');

                        Utility::bankAccountBalance($request->account_id, $request->amount, 'credit');

                        //Slack Notification
                        $setting  = Utility::settings($invoice->created_by);
                        $customer = Customer::find($invoice->customer_id);
                        if(isset($setting['payment_notification']) && $setting['payment_notification'] == 1)
                        {
                            $msg = __("New payment of").' ' . $price . __("created for").' ' . $customer->name . __("by").' '. $invoicePayment->type . '.';
                            Utility::send_slack_msg($msg,$invoice->created_by);
                        }

                        //Telegram Notification
                        $setting  = Utility::settings($invoice->created_by);
                        $customer = Customer::find($invoice->customer_id);
                        if(isset($setting['telegram_payment_notification']) && $setting['telegram_payment_notification'] == 1)
                        {
                            $msg = __("New payment of").' ' . $price . __("created for").' ' . $customer->name . __("by").' '. $invoicePayment->type . '.';
                            Utility::send_telegram_msg($msg,$invoice->created_by);
                        }

                        //Twilio Notification
                        $setting  = Utility::settings($invoice->created_by);
                        $customer = Customer::find($invoice->customer_id);
                        if(isset($setting['twilio_payment_notification']) && $setting['twilio_payment_notification'] ==1)
                        {
                            $msg = __("New payment of").' ' . $price . __("created for").' ' . $customer->name . __("by").' '.  $invoicePayment->type . '.';
                            Utility::send_twilio_msg($customer->contact,$msg,$invoice->created_by);
                        }

                        return redirect()->back()->with('success', __(' Payment successfully added.'));

                    }
                    else
                    {
                        return redirect()->back()->with('error', __('Transaction has been failed.'));
                    }
                }
                catch(\Exception $e)
                {
                    return redirect()->back()->with('error', __($e->getMessage()));
                }
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
