<?php

namespace App\Http\Controllers;

use App\Exports\BillExport;
use App\Models\BankAccount;
use App\Models\Bill;
use App\Models\BillPayment;
use App\Models\BillProduct;
use App\Models\CustomField;
use App\Models\ProductService;
use App\Models\ProductServiceCategory;
use App\Models\StockReport;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Utility;
use App\Models\Vender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class BillController extends Controller
{
    public function index(Request $request)
    {
        if (\Auth::user()->can('manage bill')) {

            $vender = Vender::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $vender->prepend('Select Vendor', '');

            $status = Bill::$statues;

            $query = Bill::where('created_by', '=', \Auth::user()->creatorId());
            if (! empty($request->vender)) {
                $query->where('vender_id', '=', $request->vender);
            }
            if (! empty($request->bill_date)) {
                $date_range = explode('to', $request->bill_date);
                $query->whereBetween('bill_date', $date_range);
            }

            if (! empty($request->status)) {
                $query->where('status', '=', $request->status);
            }
            $bills = $query->get();

            return view('accounting.bill.index', compact('bills', 'vender', 'status'));
            // return view('bill.index', compact('bills', 'vender', 'status'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function create($vendorId)
    {

        if (\Auth::user()->can('create bill')) {
            $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'bill')->get();
            $category = ProductServiceCategory::where('created_by', \Auth::user()->creatorId())->where('type', 2)->get()->pluck('name', 'id');
            $category->prepend('Select Category', '');

            $bill_number = \Auth::user()->billNumberFormat($this->billNumber());
            $venders = Vender::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $venders->prepend('Select Vender', '');

            $product_services = ProductService::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $product_services->prepend('--', '');
            //gst calucluation
            $settings = Utility::settings(\Auth::user()->creatorId());

            return view('accounting.bill.create', compact('venders', 'bill_number', 'product_services', 'category', 'customFields', 'vendorId', 'settings'));
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        //        dd($request->all());
        if (\Auth::user()->can('create bill')) {


            $bill_number = \Auth::user()->billNumberFormat($this->billNumber());
            $venders = Vender::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $venders->prepend('Select Vender', '');

            $product_services = ProductService::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $product_services->prepend('--', '');
            //gst calucluation
            $settings = Utility::settings(\Auth::user()->creatorId());
            $validator = \Validator::make(
                $request->all(), [
                    'vender_id' => 'required',
                    'bill_date' => 'required',
                    'due_date' => 'required',
                    'category_id' => 'required',
                    'items' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $bill = new Bill();
            $bill->bill_id = $this->billNumber();
            $bill->vender_id = $request->vender_id;
            $bill->bill_date = $request->bill_date;
            $bill->status = 0;
            $bill->due_date = $request->due_date;
            $bill->category_id = $request->category_id;
            $bill->order_number = ! empty($request->order_number) ? $request->order_number : 0;
            //            $bill->discount_apply = isset($request->discount_apply) ? 1 : 0;
            $bill->created_by = \Auth::user()->creatorId();
            $bill->save();
            CustomField::saveData($bill, $request->customField);
            $products = $request->items;

            for ($i = 0; $i < count($products); $i++) {
                $billProduct = new BillProduct();
                $billProduct->bill_id = $bill->id;
                $billProduct->product_id = $products[$i]['item'];
                $billProduct->quantity = $products[$i]['quantity'];
                $billProduct->tax = $products[$i]['tax'];
                //                $billProduct->discount    = isset($products[$i]['discount']) ? $products[$i]['discount'] : 0;
                $billProduct->discount = $products[$i]['discount'];
                $billProduct->price = $products[$i]['price'];
                $billProduct->description = $products[$i]['description'];
                $billProduct->save();

                //inventory management (Quantity)
                Utility::total_quantity('plus', $billProduct->quantity, $billProduct->product_id);

                //Product Stock Report
                $type = 'bill';
                $type_id = $bill->id;
                $description = $products[$i]['quantity'].'  '.__(' quantity purchase in bill').' '.\Auth::user()->billNumberFormat($bill->bill_id);
                Utility::addProductStock($products[$i]['item'], $products[$i]['quantity'], $type, $description, $type_id);

            }

            //Slack Notification
            $setting = Utility::settings(\Auth::user()->creatorId());
            if (isset($setting['bill_notification']) && $setting['bill_notification'] == 1) {
                $msg = __('New Bill').' '.\Auth::user()->billNumberFormat($bill->bill_id).' '.__('created by').' '.\Auth::user()->name.'.';
                Utility::send_slack_msg($msg);
            }

            //Telegram Notification
            $setting = Utility::settings(\Auth::user()->creatorId());
            if (isset($setting['telegram_bill_notification']) && $setting['telegram_bill_notification'] == 1) {
                $msg = __('New Bill').' '.\Auth::user()->billNumberFormat($bill->bill_id).' '.__('created by').' '.\Auth::user()->name.'.';
                Utility::send_telegram_msg($msg);
            }

            //Twilio Notification
            $setting = Utility::settings(\Auth::user()->creatorId());
            $vendor = Vender::find($request->vender_id);
            if (isset($setting['twilio_bill_notification']) && $setting['twilio_bill_notification'] == 1) {
                $msg = __('New Bill').' '.\Auth::user()->billNumberFormat($bill->bill_id).' '.__('created by').' '.\Auth::user()->name.'.';
                Utility::send_twilio_msg($vendor->contact, $msg);
            }

            return redirect()->route('bill.index', $bill->id)->with('success', __('Bill successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function venderNumber()
    {
        $latest = Vender::where('created_by', '=', \Auth::user()->creatorId())->latest()->first();
        if (! $latest) {
            return 1;
        }

        return $latest->customer_id + 1;
    }

    public function show($ids)
    {

        if (\Auth::user()->can('show bill')) {
            $id = Crypt::decrypt($ids);
            $bill = Bill::find($id);
            if ($bill->created_by == \Auth::user()->creatorId()) {

                $billPayment = BillPayment::where('bill_id', $bill->id)->first();
                $vendor = $bill->vender;
                $iteams = $bill->items;
                //gst calulation------------------
                $setting = Utility::settings(\Auth::user()->creatorId());
                $vender = Vender::find($bill->vender_id);
                $gstflag = 0;
                if ($vender->billing_state == $setting['company_state']) {
                    $gstflag = 1;
                } else {
                    $gstflag = 0;
                }
                $hsc = [];
                foreach ($iteams as $key => $value) {
                    $products = ProductService::find($value->product_id);
                    $hsc[$value->id] = $products->hsc;
                }
                $bill->customField = CustomField::getData($bill, 'bill');
                $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'bill')->get();

                return view('bill.view', compact('bill', 'vendor', 'iteams', 'billPayment', 'customFields', 'setting', 'gstflag', 'hsc'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function edit($ids)
    {
        if (\Auth::user()->can('edit bill')) {
            $id = Crypt::decrypt($ids);
            $bill = Bill::find($id);
            $category = ProductServiceCategory::where('created_by', \Auth::user()->creatorId())->where('type', 2)->get()->pluck('name', 'id');
            $category->prepend('Select Category', '');

            //            $bill_number      = \Auth::user()->billNumberFormat($this->billNumber());
            $bill_number = \Auth::user()->billNumberFormat($bill->bill_id);
            $venders = Vender::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $product_services = ProductService::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $bill->customField = CustomField::getData($bill, 'bill');
            $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'bill')->get();
            $settings = Utility::settings(\Auth::user()->creatorId());

            return view('bill.edit', compact('venders', 'product_services', 'bill', 'bill_number', 'category', 'customFields', 'settings'));
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, Bill $bill)
    {

        if (\Auth::user()->can('edit bill')) {

            if ($bill->created_by == \Auth::user()->creatorId()) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'vender_id' => 'required',
                        'bill_date' => 'required',
                        'due_date' => 'required',
                        'items' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->route('bill.index')->with('error', $messages->first());
                }
                $bill->vender_id = $request->vender_id;
                $bill->bill_date = $request->bill_date;
                $bill->due_date = $request->due_date;
                $bill->order_number = $request->order_number;
                //                $bill->discount_apply = isset($request->discount_apply) ? 1 : 0;
                $bill->category_id = $request->category_id;
                $bill->save();
                CustomField::saveData($bill, $request->customField);
                $products = $request->items;

                for ($i = 0; $i < count($products); $i++) {
                    $billProduct = BillProduct::find($products[$i]['id']);

                    if (isset($products[$i]['id'])) {
                        Utility::total_quantity('plus', $billProduct->quantity, $billProduct->product_id);
                    }

                    if ($billProduct == null) {
                        $billProduct = new BillProduct();
                        $billProduct->bill_id = $bill->id;
                    }

                    if (isset($products[$i]['item'])) {
                        $billProduct->product_id = $products[$i]['item'];
                    }

                    $billProduct->quantity = $products[$i]['quantity'];
                    $billProduct->tax = $products[$i]['tax'];
                    //                    $billProduct->discount    = isset($products[$i]['discount']) ? $products[$i]['discount'] : 0;
                    $billProduct->discount = $products[$i]['discount'];
                    $billProduct->price = $products[$i]['price'];
                    $billProduct->description = $products[$i]['description'];
                    $billProduct->save();

                    if (isset($products[$i]['item'])) {
                        Utility::total_quantity('plus', $billProduct->quantity, $billProduct->product_id);
                    }

                    //Product Stock Report
                    $type = 'bill';
                    $type_id = $bill->id;
                    StockReport::where('type', '=', 'bill')->where('type_id', '=', $bill->id)->delete();
                    $description = $products[$i]['quantity'].'  '.__(' quantity purchase in bill').' '.\Auth::user()->billNumberFormat($bill->bill_id);

                    if (isset($products[$i]['item'])) {
                        Utility::addProductStock($products[$i]['item'], $products[$i]['quantity'], $type, $description, $type_id);
                    }

                }

                return redirect()->route('bill.index')->with('success', __('Bill successfully updated.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Bill $bill)
    {
        if (\Auth::user()->can('delete bill')) {
            if ($bill->created_by == \Auth::user()->creatorId()) {
                $billpayments = $bill->payments;
                foreach ($billpayments as $key => $value) {
                    $transaction = Transaction::where('payment_id', $value->id)->first();
                    $transaction->delete();

                    $billpayment = BillPayment::find($value->id)->first();
                    $billpayment->delete();

                }
                $bill->delete();
                if ($bill->vender_id != 0) {
                    Utility::userBalance('vendor', $bill->vender_id, $bill->getTotal(), 'debit');
                }
                BillProduct::where('bill_id', '=', $bill->id)->delete();

                return redirect()->route('bill.index')->with('success', __('Bill successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function billNumber()
    {
        $latest = Bill::where('created_by', '=', \Auth::user()->creatorId())->latest()->first();
        if (! $latest) {
            return 1;
        }

        return $latest->bill_id + 1;
    }

    public function product(Request $request)
    {
        $data['product'] = $product = ProductService::find($request->product_id);
        $data['unit'] = ! empty($product->unit()) ? $product->unit()->name : '';
        $data['taxRate'] = $taxRate = ! empty($product->tax_id) ? $product->taxRate($product->tax_id) : 0;
        $data['taxes'] = ! empty($product->tax_id) ? $product->tax($product->tax_id) : 0;
        //gst calucluation
        $vender = Vender::where('id', '=', $request->user_id)->first();

        $setting = Utility::settings(\Auth::user()->creatorId());
        $data['setting'] = $setting;
        if ($setting['company_state'] == $vender->billing_state) {
            $data['taxestype'] = '1';
        } else {
            $data['taxestype'] = '0';
        }
        if (in_array($vender->shipping_state, Utility::union_state())) {
            $data['utgst'] = '1';
        } else {
            $data['utgst'] = '0';
        }
        $salePrice = $product->purchase_price;
        $quantity = 1;
        $taxPrice = ($taxRate / 100) * ($salePrice * $quantity);
        $data['totalAmount'] = ($salePrice * $quantity);

        return json_encode($data);
    }

    public function productDestroy(Request $request)
    {
        if (\Auth::user()->can('delete bill product')) {
            BillProduct::where('id', '=', $request->id)->delete();

            return redirect()->back()->with('success', __('Bill product successfully deleted.'));

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function sent($id)
    {
        if (\Auth::user()->can('send bill')) {
            $bill = Bill::where('id', $id)->first();
            $bill->send_date = date('Y-m-d');
            $bill->status = 1;
            $bill->save();

            $vender = Vender::where('id', $bill->vender_id)->first();

            $bill->name = ! empty($vender) ? $vender->name : '';
            $bill->bill = \Auth::user()->billNumberFormat($bill->bill_id);

            $billId = Crypt::encrypt($bill->id);
            $bill->url = route('bill.pdf', $billId);

            Utility::userBalance('vendor', $vender->id, $bill->getTotal(), 'credit');

            $vendorArr = [
                'vender_bill_name' => $bill->name,
                'vender_bill_number' => $bill->bill,
                'vender_bill_url' => $bill->url,

            ];
            //            dd($vendorArr);
            $resp = \App\Models\Utility::sendEmailTemplate('vender_bill_send', [$vender->id => $vender->email], $vendorArr);

            return redirect()->back()->with('success', __('Bill successfully sent.').(($resp['is_success'] == false && ! empty($resp['error'])) ? '<br> <span class="text-danger">'.$resp['error'].'</span>' : ''));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function resent($id)
    {

        //        if(\Auth::user()->can('send bill'))
        //        {
        //            $bill = Bill::where('id', $id)->first();
        //
        //            $vender = Vender::where('id', $bill->vender_id)->first();
        //
        //            $bill->name = !empty($vender) ? $vender->name : '';
        //            $bill->bill = \Auth::user()->billNumberFormat($bill->bill_id);
        //
        //            $billId    = Crypt::encrypt($bill->id);
        //            $bill->url = route('bill.pdf', $billId);
        //

        // Send Email
        $setings = Utility::settings();

        if ($setings['bill_resend'] == 1) {
            $bill = Bill::where('id', $id)->first();
            $vender = Vender::where('id', $bill->vender_id)->first();
            $bill->name = ! empty($vender) ? $vender->name : '';
            $bill->bill = \Auth::user()->billNumberFormat($bill->bill_id);
            $billId = Crypt::encrypt($bill->id);
            $bill->url = route('bill.pdf', $billId);
            $billResendArr = [
                'vender_name' => $vender->name,
                'vender_email' => $vender->email,
                'bill_name' => $bill->name,
                'bill_number' => $bill->bill,
                'bill_url' => $bill->url,
            ];

            $resp = Utility::sendEmailTemplate('bill_resend', [$vender->id => $vender->email], $billResendArr);

        }

        return redirect()->back()->with('success', __('Bill successfully sent.').(($resp['is_success'] == false && ! empty($resp['error'])) ? '<br> <span class="text-danger">'.$resp['error'].'</span>' : ''));
        //        }
        //        else
        //        {
        //            return redirect()->back()->with('error', __('Permission denied.'));
        //        }

    }

    public function payment($bill_id)
    {
        if (\Auth::user()->can('create payment bill')) {
            $bill = Bill::where('id', $bill_id)->first();
            $venders = Vender::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            $categories = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $accounts = BankAccount::select('*', \DB::raw("CONCAT(bank_name,' ',holder_name) AS name"))->where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            return view('bill.payment', compact('venders', 'categories', 'accounts', 'bill'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));

        }
    }

    public function createPayment(Request $request, $bill_id)
    {
        if (\Auth::user()->can('create payment bill')) {
            $validator = \Validator::make(
                $request->all(), [
                    'date' => 'required',
                    'amount' => 'required',
                    'account_id' => 'required',

                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $billPayment = new BillPayment();
            $billPayment->bill_id = $bill_id;
            $billPayment->date = $request->date;
            $billPayment->amount = $request->amount;
            $billPayment->account_id = $request->account_id;
            $billPayment->payment_method = 0;
            $billPayment->reference = $request->reference;
            $billPayment->description = $request->description;

            if (! empty($request->add_receipt)) {
                if ($billPayment->add_receipt) {
                    $path = storage_path('uploads/payment'.$billPayment->add_receipt);
                    if (file_exists($path)) {
                        \File::delete($path);
                    }
                }
                $fileName = time().'_'.$request->add_receipt->getClientOriginalName();
                $billPayment->add_receipt = $fileName;
                $dir = 'uploads/payment';
                $path = Utility::upload_file($request, 'add_receipt', $fileName, $dir, []);
                if ($path['flag'] == 0) {
                    return redirect()->back()->with('error', __($path['msg']));
                }
                //                $request->add_receipt  =$fileName;
                //                $billPayment->save();
            }
            $billPayment->save();

            $bill = Bill::where('id', $bill_id)->first();
            $due = $bill->getDue();
            $total = $bill->getTotal();

            if ($bill->status == 0) {
                $bill->send_date = date('Y-m-d');
                $bill->save();
            }

            if ($due <= 0) {
                $bill->status = 4;
                $bill->save();
            } else {
                $bill->status = 3;
                $bill->save();
            }
            $billPayment->user_id = $bill->vender_id;
            $billPayment->user_type = 'Vender';
            $billPayment->type = 'Partial';
            $billPayment->created_by = \Auth::user()->id;
            $billPayment->payment_id = $billPayment->id;
            $billPayment->category = 'Bill';
            $billPayment->account = $request->account_id;
            Transaction::addTransaction($billPayment);

            $vender = Vender::where('id', $bill->vender_id)->first();

            $payment = new BillPayment();
            $payment->name = $vender['name'];
            $payment->method = '-';
            $payment->date = \Auth::user()->dateFormat($request->date);
            $payment->amount = \Auth::user()->priceFormat($request->amount);
            $payment->bill = 'bill '.\Auth::user()->billNumberFormat($billPayment->bill_id);

            Utility::userBalance('vendor', $bill->vender_id, $request->amount, 'debit');

            Utility::bankAccountBalance($request->account_id, $request->amount, 'debit');

            // Send Email
            $setings = Utility::settings();
            if ($setings['bill_payment'] == 1) {

                $vender = Vender::where('id', $bill->vender_id)->first();
                $billPaymentArr = [
                    'vender_name' => $vender->name,
                    'vender_email' => $vender->email,
                    'payment_name' => $payment->name,
                    'payment_amount' => $payment->amount,
                    'payment_bill' => $payment->bill,
                    'payment_date' => $payment->date,
                    'payment_method' => $payment->method,
                    'company_name' => $payment->method,

                ];

                $resp = Utility::sendEmailTemplate('bill_payment', [$vender->id => $vender->email], $billPaymentArr);

                return redirect()->back()->with('success', __('Payment successfully added.').(($resp['is_success'] == false && ! empty($resp['error'])) ? '<br> <span class="text-danger">'.$resp['error'].'</span>' : ''));

            }

            return redirect()->back()->with('success', __('Payment successfully added.'));
        }

    }

    public function paymentDestroy(Request $request, $bill_id, $payment_id)
    {

        if (\Auth::user()->can('delete payment bill')) {
            $payment = BillPayment::find($payment_id);
            BillPayment::where('id', '=', $payment_id)->delete();

            $bill = Bill::where('id', $bill_id)->first();

            $due = $bill->getDue();
            $total = $bill->getTotal();

            if ($due > 0 && $total != $due) {
                $bill->status = 3;

            } else {
                $bill->status = 2;
            }

            Utility::userBalance('vendor', $bill->vender_id, $payment->amount, 'credit');
            Utility::bankAccountBalance($payment->account_id, $payment->amount, 'credit');

            $bill->save();
            $type = 'Partial';
            $user = 'Vender';
            Transaction::destroyTransaction($payment_id, $type, $user);

            return redirect()->back()->with('success', __('Payment successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function venderBill(Request $request)
    {
        if (\Auth::user()->can('manage vender bill')) {

            $status = Bill::$statues;

            $query = Bill::where('vender_id', '=', \Auth::user()->vender_id)->where('status', '!=', '0')->where('created_by', \Auth::user()->creatorId());

            if (! empty($request->vender)) {
                $query->where('id', '=', $request->vender);
            }
            if (! empty($request->bill_date)) {
                $date_range = explode(' - ', $request->bill_date);
                $query->whereBetween('bill_date', $date_range);
            }

            if (! empty($request->status)) {
                $query->where('status', '=', $request->status);
            }
            $bills = $query->get();

            return view('bill.index', compact('bills', 'status'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function venderBillShow($id)
    {
        if (\Auth::user()->can('show bill')) {
            $bill_id = Crypt::decrypt($id);
            $bill = Bill::where('id', $bill_id)->first();

            if ($bill->created_by == \Auth::user()->creatorId()) {
                $vendor = $bill->vender;
                $iteams = $bill->items;

                return view('bill.view', compact('bill', 'vendor', 'iteams'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function vender(Request $request)
    {
        $vender = Vender::where('id', '=', $request->id)->first();
        $country = Utility::getcountry_details($vender->billing_country);
        $state = Utility::getstate_details($vender->billing_country, $vender->billing_state);
        $shipcountry = Utility::getcountry_details($vender->shipping_country);
        $shipstate = Utility::getstate_details($vender->shipping_country, $vender->shipping_state);

        return view('bill.vender_detail', compact('vender', 'country', 'state', 'shipcountry', 'shipstate'));
    }

    public function venderBillSend($bill_id)
    {
        return view('vender.bill_send', compact('bill_id'));
    }

    public function venderBillSendMail(Request $request, $bill_id)
    {
        $validator = \Validator::make(
            $request->all(), [
                'email' => 'required|email',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $email = $request->email;
        $bill = Bill::where('id', $bill_id)->first();

        $vender = Vender::where('id', $bill->vender_id)->first();
        $bill->name = ! empty($vender) ? $vender->name : '';
        $bill->bill = \Auth::user()->billNumberFormat($bill->bill_id);

        $billId = Crypt::encrypt($bill->id);
        $bill->url = route('bill.pdf', $billId);

        try {
            //            Mail::to($email)->send(new VenderBillSend($bill));
        } catch (\Exception $e) {
            $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
        }

        return redirect()->back()->with('success', __('Bill successfully sent.').((isset($smtp_error)) ? '<br> <span class="text-danger">'.$smtp_error.'</span>' : ''));

    }

    public function shippingDisplay(Request $request, $id)
    {
        $bill = Bill::find($id);

        if ($request->is_display == 'true') {
            $bill->shipping_display = 1;
        } else {
            $bill->shipping_display = 0;
        }
        $bill->save();

        return redirect()->back()->with('success', __('Shipping address status successfully changed.'));
    }

    public function duplicate($bill_id)
    {
        if (\Auth::user()->can('duplicate bill')) {
            $bill = Bill::where('id', $bill_id)->first();

            $duplicateBill = new Bill();
            $duplicateBill->bill_id = $this->billNumber();
            $duplicateBill->vender_id = $bill['vender_id'];
            $duplicateBill->bill_date = date('Y-m-d');
            $duplicateBill->due_date = $bill['due_date'];
            $duplicateBill->send_date = null;
            $duplicateBill->category_id = $bill['category_id'];
            $duplicateBill->order_number = $bill['order_number'];
            $duplicateBill->status = 0;
            $duplicateBill->shipping_display = $bill['shipping_display'];
            $duplicateBill->created_by = $bill['created_by'];
            $duplicateBill->save();

            if ($duplicateBill) {
                $billProduct = BillProduct::where('bill_id', $bill_id)->get();
                foreach ($billProduct as $product) {
                    $duplicateProduct = new BillProduct();
                    $duplicateProduct->bill_id = $duplicateBill->id;
                    $duplicateProduct->product_id = $product->product_id;
                    $duplicateProduct->quantity = $product->quantity;
                    $duplicateProduct->tax = $product->tax;
                    $duplicateProduct->discount = $product->discount;
                    $duplicateProduct->price = $product->price;
                    $duplicateProduct->save();
                }
            }

            return redirect()->back()->with('success', __('Bill duplicate successfully.'));

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function previewBill($template, $color)
    {

        $objUser = \Auth::user();
        $settings = Utility::settings();
        $bill = new Bill();

        $vendor = new \stdClass();
        $vendor->email = '<Email>';
        $vendor->shipping_name = '<Vendor Name>';
        $vendor->shipping_country = '<Country>';
        $vendor->shipping_state = '<State>';
        $vendor->shipping_city = '<City>';
        $vendor->shipping_phone = '<Vendor Phone Number>';
        $vendor->shipping_zip = '<Zip>';
        $vendor->shipping_address = '<Address>';
        $vendor->billing_name = '<Vendor Name>';
        $vendor->billing_country = '<Country>';
        $vendor->billing_state = '<State>';
        $vendor->billing_city = '<City>';
        $vendor->billing_phone = '<Vendor Phone Number>';
        $vendor->billing_zip = '<Zip>';
        $vendor->billing_address = '<Address>';

        $totalTaxPrice = 0;
        $taxesData = [];
        $items = [];
        for ($i = 1; $i <= 3; $i++) {
            $item = new \stdClass();
            $item->name = 'Item '.$i;
            $item->quantity = 1;
            $item->tax = 5;
            $item->discount = 50;
            $item->price = 100;

            $taxes = [
                'Tax 1',
                'Tax 2',
            ];

            $itemTaxes = [];
            foreach ($taxes as $k => $tax) {
                $taxPrice = 10;
                $totalTaxPrice += $taxPrice;
                $itemTax['name'] = 'Tax '.$k;
                $itemTax['rate'] = '10 %';
                $itemTax['price'] = '$10';
                $itemTaxes[] = $itemTax;
                if (array_key_exists('Tax '.$k, $taxesData)) {
                    $taxesData['Tax '.$k] = $taxesData['Tax 1'] + $taxPrice;
                } else {
                    $taxesData['Tax '.$k] = $taxPrice;
                }
            }
            $item->itemTax = $itemTaxes;
            $items[] = $item;
        }

        $bill->bill_id = 1;
        $bill->issue_date = date('Y-m-d H:i:s');
        $bill->due_date = date('Y-m-d H:i:s');
        $bill->itemData = $items;

        $bill->totalTaxPrice = 60;
        $bill->totalQuantity = 3;
        $bill->totalRate = 300;
        $bill->totalDiscount = 10;
        $bill->taxesData = $taxesData;
        $bill->created_by = $objUser->creatorId();

        $bill->customField = [];
        $customFields = [];

        $preview = 1;
        $color = '#'.$color;
        $font_color = Utility::getFontColor($color);

        //        $logo         = asset(Storage::url('uploads/logo/'));
        //        $bill_logo = Utility::getValByName('bill_logo');
        //        $company_logo = \App\Models\Utility::GetLogo();
        //        if(isset($bill_logo) && !empty($bill_logo))
        //        {
        //            $img          = asset(\Storage::url('bill_logo').'/'. $bill_logo);
        //        }
        //        else
        //        {
        //            $img          = asset($logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png'));
        //        }

        $logo = asset(Storage::url('uploads/logo/'));
        $company_logo = Utility::getValByName('company_logo_dark');
        $bill_logo = Utility::getValByName('bill_logo');
        if (isset($bill_logo) && ! empty($bill_logo)) {
            $img = Utility::get_file('bill_logo/').$bill_logo;
        } else {
            $img = asset($logo.'/'.(isset($company_logo) && ! empty($company_logo) ? $company_logo : 'logo-dark.png'));
        }

        return view('bill.templates.'.$template, compact('bill', 'preview', 'color', 'img', 'settings', 'vendor', 'font_color', 'customFields'));
    }

    public function bill($bill_id)
    {
        $settings = Utility::settings();
        $billId = Crypt::decrypt($bill_id);

        $bill = Bill::where('id', $billId)->first();
        $data = DB::table('settings');
        $data = $data->where('created_by', '=', $bill->created_by);
        $data1 = $data->get();

        foreach ($data1 as $row) {
            $settings[$row->name] = $row->value;
        }

        $vendor = $bill->vender;

        $totalTaxPrice = 0;
        $totalQuantity = 0;
        $totalRate = 0;
        $totalDiscount = 0;
        $taxesData = [];
        $items = [];

        foreach ($bill->items as $product) {

            $item = new \stdClass();
            $item->name = ! empty($product->product()) ? $product->product()->name : '';
            $item->quantity = $product->quantity;
            $item->tax = $product->tax;
            $item->discount = $product->discount;
            $item->price = $product->price;
            $item->description = $product->description;

            $totalQuantity += $item->quantity;
            $totalRate += $item->price;
            $totalDiscount += $item->discount;

            $taxes = Utility::tax($product->tax);
            $itemTaxes = [];
            if (! empty($item->tax)) {
                foreach ($taxes as $tax) {
                    $taxPrice = Utility::taxRate($tax->rate, $item->price, $item->quantity);
                    $totalTaxPrice += $taxPrice;

                    $itemTax['name'] = $tax->name;
                    $itemTax['rate'] = $tax->rate.'%';
                    $itemTax['price'] = Utility::priceFormat($settings, $taxPrice);
                    $itemTaxes[] = $itemTax;

                    if (array_key_exists($tax->name, $taxesData)) {
                        $taxesData[$tax->name] = $taxesData[$tax->name] + $taxPrice;
                    } else {
                        $taxesData[$tax->name] = $taxPrice;
                    }

                }

                $item->itemTax = $itemTaxes;
            } else {
                $item->itemTax = [];
            }
            $items[] = $item;
        }

        $bill->itemData = $items;
        $bill->totalTaxPrice = $totalTaxPrice;
        $bill->totalQuantity = $totalQuantity;
        $bill->totalRate = $totalRate;
        $bill->totalDiscount = $totalDiscount;
        $bill->taxesData = $taxesData;
        $bill->customField = CustomField::getData($bill, 'bill');
        $customFields = [];
        if (! empty(\Auth::user())) {
            $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'bill')->get();
        }

        //        $logo         = asset(Storage::url('uploads/logo/'));
        //        $company_logo = Utility::getValByName('company_logo_dark');
        //        $img          = asset($logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png'));

        $logo = asset(Storage::url('uploads/logo/'));
        $company_logo = Utility::getValByName('company_logo_dark');
        $settings_data = \App\Models\Utility::settingsById($bill->created_by);
        $bill_logo = $settings_data['bill_logo'];
        if (isset($bill_logo) && ! empty($bill_logo)) {
            $img = Utility::get_file('bill_logo/').$bill_logo;
        } else {
            $img = asset($logo.'/'.(isset($company_logo) && ! empty($company_logo) ? $company_logo : 'logo-dark.png'));
        }
        //gst calulation------------------
        $setting = Utility::settings(\Auth::user()->creatorId());
        $vender = Vender::find($bill->vender_id);
        $gstflag = 0;
        if ($vender->billing_state == $setting['company_state']) {
            $gstflag = 1;
        } else {
            $gstflag = 0;
        }
        if ($bill) {
            $color = '#'.$settings['bill_color'];
            $font_color = Utility::getFontColor($color);

            return view('bill.templates.'.$settings['bill_template'], compact('bill', 'color', 'settings', 'vendor', 'img', 'font_color', 'customFields', 'setting', 'gstflag'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function saveBillTemplateSettings(Request $request)
    {
        $post = $request->all();
        unset($post['_token']);

        if (isset($post['bill_template']) && (! isset($post['bill_color']) || empty($post['bill_color']))) {
            $post['bill_color'] = 'ffffff';
        }

        //        $validator = \Validator::make(
        //            $request->all(),
        //            [
        //                'bill_logo' => 'image|mimes:png|max:20480',
        //            ]
        //        );
        //        if($validator->fails())
        //        {
        //            $messages = $validator->getMessageBag();
        //            return  redirect()->back()->with('error', $messages->first());
        //        }
        //        $bill_logo = \Auth::user()->id . '_bill_logo.png';
        //        $path = $request->file('bill_logo')->storeAs('bill_logo', $bill_logo);
        //        $post['bill_logo'] = $bill_logo;

        if ($request->bill_logo) {
            $dir = 'bill_logo/';
            $bill_logo = \Auth::user()->id.'_bill_logo.png';
            $validation = [
                'mimes:'.'png',
                'max:'.'20480',
            ];
            $path = Utility::upload_file($request, 'bill_logo', $bill_logo, $dir, $validation);
            if ($path['flag'] == 0) {
                return redirect()->back()->with('error', __($path['msg']));
            }
            $post['bill_logo'] = $bill_logo;
        }

        foreach ($post as $key => $data) {
            \DB::insert(
                'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', [
                    $data,
                    $key,
                    \Auth::user()->creatorId(),
                ]
            );
        }

        return redirect()->back()->with('success', __('Bill Setting updated successfully'));
    }

    public function items(Request $request)
    {
        $items = BillProduct::where('bill_id', $request->bill_id)->where('product_id', $request->product_id)->first();

        return json_encode($items);
    }

    public function invoiceLink($billId)
    {

        $id = Crypt::decrypt($billId);

        $bill = Bill::find($id);

        $user_id = $bill->created_by;

        $user = User::find($user_id);
        //        dd( $bill->id);
        $billPayment = BillPayment::where('bill_id', $bill->id)->get();
        //        dd($billPayment);
        $vendor = $bill->vender;
        $iteams = $bill->items;
        //        dd($iteams,$vendor);
        $bill->customField = CustomField::getData($bill, 'bill');
        $customFields = CustomField::where('module', '=', 'bill')->get();

        //        dd($customFields);

        return view('bill.customer_bill', compact('bill', 'vendor', 'iteams', 'customFields', 'billPayment', 'user'));
    }

    public function export()
    {
        $name = 'bill_'.date('Y-m-d i:h:s');
        $data = Excel::download(new BillExport(), $name.'.xlsx');
        ob_end_clean();

        return $data;
    }
}
