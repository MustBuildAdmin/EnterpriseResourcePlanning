<?php

namespace App\Http\Controllers;

use App\Mail\SelledInvoice;
use App\Models\Customer;
use App\Models\Pos;
use App\Models\PosPayment;
use App\Models\PosProduct;
use App\Models\ProductService;
use App\Models\Utility;
use App\Models\warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('manage pos'))
        {
            $customers      = Customer::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'name');
            $customers->prepend('Walk-in-customer', '');
            $warehouses = warehouse::select('*', \DB::raw("CONCAT(name) AS name"))->where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
//            $warehouses->prepend('Select Warehouse', '');
            $user = Auth::user();
            $details = [
                'pos_id' => $user->posNumberFormat($this->invoicePosNumber()),
                'customer' => $customers != null ? $customers->toArray() : [],
                'user' => $user != null ? $user->toArray() : [],
                'date' => date('Y-m-d'),
                'pay' => 'show',
            ];
//            dd($details['pos_id']);



            return view('pos.index',compact('customers','warehouses','details'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {


        $sess = session()->get('pos');

        if (Auth::user()->can('manage pos') && isset($sess) && !empty($sess) && count($sess) > 0) {
            $user = Auth::user();

            $settings = Utility::settings();

            $customer = Customer::where('name', '=', $request->vc_name)->where('created_by', $user->creatorId())->first();
            $warehouse = warehouse::where('id', '=', $request->warehouse_name)->where('created_by', $user->creatorId())->first();
           
            $details = [
                'pos_id' => $user->posNumberFormat($this->invoicePosNumber()),
                'customer' => $customer != null ? $customer->toArray() : [],
                'warehouse' => $warehouse != null ? $warehouse->toArray() : [],
                'user' => $user != null ? $user->toArray() : [],
                'date' => date('Y-m-d'),
                'pay' => 'show',
            ];
            $setting  = Utility::settings(\Auth::user()->creatorId());
            if (!empty($details['customer']))
            {
                 //gst calulation------------------
               
                $gstflag=0;
                if($details['customer']['billing_state']==$setting['company_state']){
                    $gstflag=1;
                }else{
                    $gstflag=0;
                }
                $warehousedetails = '<h7 class="text-dark">' . ucfirst($details['warehouse']['name'])  . '</p></h7>';
                // $details['customer']['billing_state'] = $details['customer']['billing_state'] != '' ? ", " . $details['customer']['billing_state'] : '';
                // $details['customer']['shipping_state'] = $details['customer']['shipping_state'] != '' ? ", " . $details['customer']['shipping_state'] : '';
                $details['customer']['billing_state'] = $details['customer']['billing_state'] != '' ? ", " .Utility::getstate_detailsonly_name($details['customer']['billing_country'],$details['customer']['billing_state']): '';
                $details['customer']['shipping_state'] = $details['customer']['shipping_state'] != '' ? ", " .Utility::getstate_detailsonly_name($details['customer']['shipping_country'],$details['customer']['shipping_state']): '';

                $customerdetails = '<h6 class="text-dark">' . ucfirst($details['customer']['name']) . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['billing_phone'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['billing_address'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['billing_city'] .$details['customer']['billing_state']. '</p>' . '<p class="m-0 h6 font-weight-normal">' . Utility::getcountry_detailsonly_name($details['customer']['billing_country']) . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['billing_zip'] . '</p></h6>';

                $shippdetails = '<h6 class="text-dark"><b>' . ucfirst($details['customer']['name']) . '</b>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['shipping_phone'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['shipping_address'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['shipping_city'] .$details['customer']['shipping_state']. '</p>' . '<p class="m-0 h6 font-weight-normal">' . Utility::getcountry_detailsonly_name($details['customer']['shipping_country']) . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $details['customer']['shipping_zip'] . '</p></h6>';

            }
            else {
                $customerdetails = '<h2 class="h6"><b>' . __('Walk-in Customer') . '</b><h2>';
                $warehousedetails = '<h7 class="text-dark">' . ucfirst($details['warehouse']['name'])  . '</p></h7>';
                $shippdetails = '-';
                $gstflag=0;

            }


            $settings['company_telephone'] = $settings['company_telephone'] != '' ? ", " . $settings['company_telephone'] : '';
            $settings['company_state']     = $settings['company_state'] != '' ? ", " . Utility::getstate_detailsonly_name($settings['company_country'],$settings['company_state'] ): '';

            $userdetails = '<h6 class="text-dark"><b>' . ucfirst($details['user']['name']) . ' </b> <h2  class="font-weight-normal">' . '<p class="m-0 font-weight-normal">' . $settings['company_name'] . $settings['company_telephone'] . '</p>' . '<p class="m-0 font-weight-normal">' . $settings['company_address'] . '</p>' . '<p class="m-0 h6 font-weight-normal">' . $settings['company_city'] . $settings['company_state'] . '</p>' . '<p class="m-0 font-weight-normal">' .  Utility::getcountry_detailsonly_name($settings['company_country']) . '</p>' . '<p class="m-0 font-weight-normal">' . $settings['company_zipcode'] . '</p></h2>';

            $details['customer']['details'] = $customerdetails;
            $details['warehouse']['details'] = $warehousedetails;
//
            $details['customer']['shippdetails'] = $shippdetails;

            $details['user']['details'] = $userdetails;

            $mainsubtotal = 0;
            $sales        = [];

            foreach ($sess as $key => $value) {
                $subtotal = $value['price'] * $value['quantity'];
                $tax      = ($subtotal * $value['tax']) / 100;

                $sales['data'][$key]['name']       = $value['name'];
                $sales['data'][$key]['quantity']   = $value['quantity'];
                $sales['data'][$key]['price']      = Auth::user()->priceFormat($value['price']);
                $sales['data'][$key]['tax']        = $value['tax'] . '%';
                $sales['data'][$key]['tax_amount'] = $tax;
                $sales['data'][$key]['subtotal']   = Auth::user()->priceFormat($value['subtotal']);
                $mainsubtotal                      += $value['subtotal'];
            }
            $sales['total'] = Auth::user()->priceFormat($mainsubtotal);




            return view('pos.show', compact('sales', 'details','setting','gstflag'));
        } else {
            return response()->json(
                [
                    'error' => __('Add some products to cart!'),
                ],
                '404'
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        if (Auth::user()->can('manage pos')) {
            $user_id = Auth::user()->creatorId();
            $customer_id      = Customer::customer_id($request->vc_name);
//            dd($customer_id);
            $warehouse_id      = warehouse::warehouse_id($request->warehouse_name);
//            dd($warehouse_id);

            $pos_id       = $this->invoicePosNumber();
            $sales            = session()->get('pos');

            if (isset($sales) && !empty($sales) && count($sales) > 0) {
                $result = DB::table('pos')->where('pos_id', $pos_id)->where('created_by', $user_id)->get();
                if (count($result) > 0) {
                    return response()->json(
                        [
                            'code' => 200,
                            'success' => __('Payment is already completed!'),
                        ]
                    );
                } else {
                    $pos = new Pos();
                    $pos->pos_id       = $pos_id;
                    $pos->customer_id      = $customer_id;
                    $pos->warehouse_id      = $request->warehouse_name;
                    $pos->created_by       = $user_id;
                    $pos->save();

                    foreach ($sales as $key => $value) {
                        $product_id = $value['id'];

                        $product = ProductService::whereId($product_id)->where('created_by', $user_id)->first();

                        $original_quantity = ($product == null) ? 0 : (int)$product->quantity;

                        $product_quantity = $original_quantity - $value['quantity'];


                        if ($product != null && !empty($product)) {
                            ProductService::where('id', $product_id)->update(['quantity' => $product_quantity]);
                        }

                        $tax_id = ProductService::tax_id($product_id);


                        $positems = new PosProduct();
                        $positems->pos_id    = $pos->id;
                        $positems->product_id = $product_id;
                        $positems->price      = $value['price'];
                        $positems->quantity   = $value['quantity'];
                        $positems->tax     = $tax_id;
                        $positems->tax        = $value['tax'];
                        $positems->save();
                    }

                    $posPayment                 = new PosPayment();
                    $posPayment->pos_id          =$pos->id;
                    $posPayment->date           = $request->date;

                    $mainsubtotal = 0;
                    $sales        = [];

                    $sess = session()->get('pos');
                    foreach ($sess as $key => $value) {
                        $subtotal = $value['price'] * $value['quantity'];
                        $tax      = ($subtotal * $value['tax']) / 100;
                        $sales['data'][$key]['price']      = Auth::user()->priceFormat($value['price']);
                        $sales['data'][$key]['tax']        = $value['tax'] . '%';
                        $sales['data'][$key]['tax_amount'] = Auth::user()->priceFormat($tax);
                        $sales['data'][$key]['subtotal']   = Auth::user()->priceFormat($value['subtotal']);
                        $mainsubtotal                      += $value['subtotal'];
                    }
                    $amount = Auth::user()->priceFormat($mainsubtotal);
                    $posPayment->amount         = $amount;
                    $posPayment->save();

                    session()->forget('pos');

//                    if ($pos->customer != null) {
//                        $pos_id              = Crypt::encrypt($pos->id);
//                        $pos->customer_name  = ucfirst($pos->customer->name);
//                        $pos->customer_email = $pos->customer->email;
//                        $pos->url            = route('get.sales.invoice', $pos_id);
//
//                        try {
//                            Mail::to($pos->customer_email)->send(new SelledInvoice($pos));
//                        } catch (\Exception $e) {
//                            $smtp_error = "<br><span class='text-danger'>" . __('E-Mail has been not sent due to SMTP configuration') . '</span>';
//                        }
//                    }

                    return response()->json(
                        [
                            'code' => 200,
                            'success' => __('Payment completed successfully!'),
                        ]
                    );
                }
            } else {
                return response()->json(
                    [
                        'code' => 404,
                        'success' => __('Items not found!'),
                    ]
                );
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    function invoicePosNumber()
    {
        if (Auth::user()->can('manage pos')) {
            $latest = Pos::where('created_by', '=', \Auth::user()->creatorId())->latest()->first();


            return $latest ? $latest->pos_id + 1 : 1;
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    function report()
    {
        if(\Auth::user()->can('manage pos'))
        {

            $posPayments = Pos::where('created_by', '=', \Auth::user()->creatorId())->get();
            return view('pos.report',compact('posPayments'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

    }

}
