<?php

namespace App\Http\Controllers;

use App\Models\CustomField;
use App\Exports\ProductServiceExport;
use App\Imports\ProductServiceImport;
use App\Models\Product;
use App\Models\ProductService;
use App\Models\ProductServiceCategory;
use App\Models\ProductServiceUnit;
use App\Models\Tax;
use App\Models\Utility;
use App\Models\Vender;
use App\Models\WarehouseProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;



class ProductServiceController extends Controller
{
    public function index(Request $request)
    {

        if(\Auth::user()->can('manage product & service'))
        {
            $category = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 0)->get()->pluck('name', 'id');
            $category->prepend('Select Category', '');

            if(!empty($request->category))
            {

                $productServices = ProductService::where('created_by', '=', \Auth::user()->creatorId())->where('category_id', $request->category)->get();
            }
            else
            {
                $productServices = ProductService::where('created_by', '=', \Auth::user()->creatorId())->get();
            }

            return view('productservice.index', compact('productServices', 'category'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        if(\Auth::user()->can('create product & service'))
        {
            $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'product')->get();
            $category     = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 0)->get()->pluck('name', 'id');
            $unit         = ProductServiceUnit::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $tax          = Tax::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            return view('productservice.create', compact('category', 'unit', 'tax', 'customFields'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {

        if(\Auth::user()->can('create product & service'))
        {

            $rules = [
                'name' => 'required',
                'sku' => 'required|unique:product_services,sku',
                'hsc' => 'required|unique:product_services,hsc',
                'sale_price' => 'required|numeric',
                'purchase_price' => 'required|numeric',
                'category_id' => 'required',
                'unit_id' => 'required',
                'type' => 'required',
                'pro_image' => 'mimes:jpeg,png,jpg,webp|max:20480',
            ];

            $validator = \Validator::make($request->all(), $rules);

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->route('productservice.index')->with('error', $messages->first());
            }

            $productService                 = new ProductService();
            $productService->name           = $request->name;
            $productService->description    = $request->description;
            $productService->sku            = $request->sku;
            $productService->hsc            = $request->hsc;
            $productService->sale_price     = $request->sale_price;
            $productService->purchase_price = $request->purchase_price;
            $productService->tax_id         = !empty($request->tax_id) ? implode(',', $request->tax_id) : '';
            $productService->unit_id        = $request->unit_id;
            $productService->quantity        = $request->quantity;
            $productService->type           = $request->type;
            $productService->category_id    = $request->category_id;
//            if(isset($request->pro_image))
//            {
//                $productService->pro_image = $fileNameToStore;
//            }

            if(!empty($request->pro_image))
            {

                if($productService->pro_image)
                {
                    $path = storage_path('uploads/pro_image' . $productService->pro_image);
                    if(file_exists($path))
                    {
                        \File::delete($path);
                    }
                }
                $fileName = time() . "_" . $request->pro_image->getClientOriginalName();
                $productService->pro_image = $fileName;
                $dir        = 'uploads/pro_image';
                $path = Utility::upload_file($request,'pro_image',$fileName,$dir,[]);
            }

            $productService->created_by     = \Auth::user()->creatorId();
            $productService->save();
            CustomField::saveData($productService, $request->customField);

            return redirect()->route('productservice.index')->with('success', __('Product successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function edit($id)
    {
        $productService = ProductService::find($id);

        if(\Auth::user()->can('edit product & service'))
        {
            if($productService->created_by == \Auth::user()->creatorId())
            {
                $category = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 0)->get()->pluck('name', 'id');
                $unit     = ProductServiceUnit::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $tax      = Tax::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

                $productService->customField = CustomField::getData($productService, 'product');
                $customFields                = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'product')->get();
                $productService->tax_id      = explode(',', $productService->tax_id);
                $hsc=$productService->hsc;

                return view('productservice.edit', compact('category', 'unit', 'tax', 'productService', 'customFields','hsc'));
            }
            else
            {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }


    public function update(Request $request, $id)
    {

        if(\Auth::user()->can('edit product & service'))
        {
            $productService = ProductService::find($id);
            if($productService->created_by == \Auth::user()->creatorId())
            {

                $rules = [
                    'name' => 'required',
                    'sku' => 'required', Rule::unique('product_services')->ignore($productService->id),
                    'hsc' =>'required', Rule::unique('product_services')->ignore($productService->id),
                    'sale_price' => 'required|numeric',
                    'purchase_price' => 'required|numeric',
                    'category_id' => 'required',
                    'unit_id' => 'required',
                    'type' => 'required',

                ];

                $validator = \Validator::make($request->all(), $rules);

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->route('productservice.index')->with('error', $messages->first());
                }

                $productService->name           = $request->name;
                $productService->description    = $request->description;
                $productService->sku            = $request->sku;
                $productService->hsc            = $request->hsc;
                $productService->sale_price     = $request->sale_price;
                $productService->purchase_price = $request->purchase_price;
                $productService->tax_id         = !empty($request->tax_id) ? implode(',', $request->tax_id) : '';
                $productService->unit_id        = $request->unit_id;
                $productService->quantity        = $request->quantity;
                $productService->type           = $request->type;
                $productService->category_id    = $request->category_id;
//                if(isset($request->pro_image))
//                {
//                    $productService->pro_image = $fileNameToStore;
//                }
                if(!empty($request->pro_image))
                {

                    if($productService->pro_image)
                    {
                        $path = storage_path('uploads/pro_image' . $productService->pro_image);
                        if(file_exists($path))
                        {
                            \File::delete($path);
                        }
                    }
                    $fileName = time() . "_" . $request->pro_image->getClientOriginalName();
                    $productService->pro_image = $fileName;
                    $dir        = 'uploads/pro_image';
                    $path = Utility::upload_file($request,'pro_image',$fileName,$dir,[]);

                }

                $productService->created_by     = \Auth::user()->creatorId();
                $productService->save();
                CustomField::saveData($productService, $request->customField);

                return redirect()->route('productservice.index')->with('success', __('Product successfully updated.'));
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


    public function destroy($id)
    {
        if(\Auth::user()->can('delete product & service'))
        {
            $productService = ProductService::find($id);
            if($productService->created_by == \Auth::user()->creatorId())
            {
                $productService->delete();

                return redirect()->route('productservice.index')->with('success', __('Product successfully deleted.'));
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

    public function export()
    {
        $name = 'product_service_' . date('Y-m-d i:h:s');
        $data = Excel::download(new ProductServiceExport(), $name . '.xlsx');

        return $data;
    }

    public function importFile()
    {
        return view('productservice.import');
    }

    public function import(Request $request)
    {
        $rules = [
            'file' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }
        $products     = (new ProductServiceImport)->toArray(request()->file('file'))[0];
        $totalProduct = count($products) - 1;
        $errorArray   = [];
        for ($i = 1; $i <= count($products) - 1; $i++) {
            $items  = $products[$i];

            $taxes     = explode(';', $items[5]);

            $taxesData = [];
            foreach ($taxes as $tax)
            {
                $taxes       = Tax::where('id', $tax)->first();
                //                $taxesData[] = $taxes->id;
                $taxesData[] = !empty($taxes->id) ? $taxes->id : 0;


            }

            $taxData = implode(',', $taxesData);
            //            dd($taxData);

            if (!empty($productBySku)) {
                $productService = $productBySku;
            } else {
                $productService = new ProductService();
            }


            $productService->name           = $items[0];
            $productService->sale_price     = $items[1];
            $productService->purchase_price = $items[2];
            $productService->quantity       = $items[3];
            $productService->tax_id         = $items[4];
            $productService->category_id    = $items[5];
            $productService->unit_id        = $items[6];
            $productService->type           = $items[7];
            $productService->description    = $items[8];
            $productService->created_by     = \Auth::user()->creatorId();

            if (empty($productService)) {
                $errorArray[] = $productService;
            } else {
                $productService->save();
            }
        }

        $errorRecord = [];
        if (empty($errorArray)) {

            $data['status'] = 'success';
            $data['msg']    = __('Record successfully imported');
        } else {
            $data['status'] = 'error';
            $data['msg']    = count($errorArray) . ' ' . __('Record imported fail out of' . ' ' . $totalProduct . ' ' . 'record');


            foreach ($errorArray as $errorData) {

                $errorRecord[] = implode(',', $errorData);
            }

            \Session::put('errorArray', $errorRecord);
        }

        return redirect()->back()->with($data['status'], $data['msg']);
    }


    public function warehouseDetail($id)
    {
        $products = WarehouseProduct::where('product_id', '=', $id)->where('created_by', '=', \Auth::user()->creatorId())->get();
        return view('productservice.detail', compact('products'));
    }

    public function searchProducts(Request $request)
    {
//        dd($request->all());

        $lastsegment = $request->session_key;

            if (Auth::user()->can('manage pos') && $request->ajax() && isset($lastsegment) && !empty($lastsegment)) {

                $output = "";
            if($request->war_id == '0'){
                if ($request->cat_id !== '' && $request->search == '') {
                    if($request->cat_id == '0'){
                        $products = ProductService::getallproducts()->get();
                    }else{
                        $products = ProductService::getallproducts()->where('category_id', $request->cat_id)->get();
                    }
//                dd($products);
                } else {
                    if($request->cat_id == '0'){
                        $products = ProductService::getallproducts()->where('product_services.name', 'LIKE', "%{$request->search}%")->get();
                    }else{
                        $products = ProductService::getallproducts()->where('product_services.name', 'LIKE', "%{$request->search}%")->orWhere('category_id', $request->cat_id)->get();
                    }

                }
            }else{
                $ids = WarehouseProduct::where('warehouse_id',$request->war_id)->get()->pluck('product_id')->toArray();
                $products = ProductService::getallproducts()->whereIn('product_services.id',$ids)->get();
            }


            if (count($products)>0)
            {
                foreach ($products as $key => $product)
                {
                    if(!empty($product->pro_image)){
                        $image_url =('uploads/pro_image').'/'.$product->pro_image;
                    }else{
                        $image_url =('uploads/pro_image').'/default.png';
                    }
                    if ($request->session_key == 'purchases')
                    {
                        $productprice = $product->purchase_price != 0 ? $product->purchase_price : 0;
                    }
                    else if ($request->session_key == 'pos')
                    {
                        $productprice = $product->sale_price != 0 ? $product->sale_price : 0;
                    }
                    else
                    {
                        $productprice = $product->sale_price != 0 ? $product->sale_price : $product->purchase_price;
//                        dd($productprice);
                    }


                    $output .= '

                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-4 col-12">
                                <div class="tab-pane fade show active toacart w-100" data-url="' . url('add-to-cart/' . $product->id . '/' . $lastsegment) .'">
                                    <div class="position-relative card">
                                        <img alt="Image placeholder" src="' . asset(Storage::url($image_url)) . '" class="card-image avatar shadow hover-shadow-lg" style=" height: 6rem; width: 100%;">
                                        <div class="p-0 custom-card-body card-body d-flex ">
                                            <div class="card-body my-2 p-2 text-left card-bottom-content">
                                                <h6 class="mb-2 text-dark product-title-name">' . $product->name . '</h6>
                                                <small class="badge badge-primary mb-0">' . Auth::user()->priceFormat($productprice) . '</small>

                                                <small class="top-badge badge badge-danger mb-0">'. $product->quantity.' '.$product->unit()->name .'</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    ';

                }

                return Response($output);
            } else {
                $output='<div class="card card-body col-12 text-center">
                    <h5>'.__("No Product Available").'</h5>
                    </div>';
                return Response($output);
            }
        }
    }

    public function addToCart(Request $request, $id,$session_key)
    {

        if (Auth::user()->can('manage product & service') && $request->ajax()) {
            $product = ProductService::find($id);
//            dd($product);

            $productquantity = 0;

            if ($product) {

                $productquantity = $product->getTotalProductQuantity();

            }

            if (!$product || ($session_key == 'pos' && $productquantity == 0)) {
                return response()->json(
                    [
                        'code' => 404,
                        'status' => 'Error',
                        'error' => __('This product is out of stock!'),
                    ],
                    404
                );
            }

            $productname = $product->name;

            if ($session_key == 'purchases') {

                $productprice = $product->purchase_price != 0 ? $product->purchase_price : 0;
            } else if ($session_key == 'pos') {

                $productprice = $product->sale_price != 0 ? $product->sale_price : 0;
            } else {

                $productprice = $product->sale_price != 0 ? $product->sale_price : $product->purchase_price;
            }

            $originalquantity = (int)$productquantity;


            $tax = ProductService::where('product_services.id', $id)->leftJoin(
                'taxes',
                function ($join) {
                    $join->on('taxes.id', '=', 'product_services.tax_id')
                        ->where('taxes.created_by', '=', Auth::user()->creatorId())
                        ->orWhereNull('product_services.tax_id');
                }
            )->select(DB::Raw('IFNULL( `taxes`.`rate` , 0 ) as rate'))->first();

            $producttax = $tax->rate;

            $tax = ($productprice * $producttax) / 100;

            $subtotal        = $productprice + $tax;
            $cart            = session()->get($session_key);
//            $image_url       = (!empty($product->image) && Storage::exists($product->image)) ? $product->image : 'logo/placeholder.png';
            $image_url = (!empty($product->pro_image) && Storage::exists($product->pro_image)) ? $product->pro_image : 'uploads/pro_image/'. $product->pro_image;


            $model_delete_id = 'delete-form-' . $id;

            $carthtml = '';

            $carthtml .= '<tr data-product-id="' . $id . '" id="product-id-' . $id . '">
                            <td class="cart-images">
                                <img alt="Image placeholder" src="' . asset(Storage::url($image_url)) . '" class="card-image avatar shadow hover-shadow-lg">
                            </td>

                            <td class="name">' . $productname . '</td>

                            <td class="">
                                   <span class="quantity buttons_added">
                                         <input type="button" value="-" class="minus">
                                         <input type="number" step="1" min="1" max="" name="quantity" title="' . __('Quantity') . '" class="input-number" size="4" data-url="' . url('update-cart/') . '" data-id="' . $id . '">
                                         <input type="button" value="+" class="plus">
                                   </span>
                            </td>


                            <td class="tax">' . $producttax . '% </td>

                            <td class="price">' . Auth::user()->priceFormat($productprice) . '</td>

                            <td class="subtotal">' . Auth::user()->priceFormat($subtotal) . '</td>

                            <td class="">
                                 <a href="#" class="action-btn bg-danger bs-pass-para-pos" data-confirm="' . __("Are You Sure?") . '" data-text="' . __("This action can not be undone. Do you want to continue?") . '" data-confirm-yes=' . $model_delete_id . ' title="' . __('Delete') . '}" data-id="' . $id . '" title="' . __('Delete') . '"   >
                                   <span class=""><i class="ti ti-trash btn btn-sm text-white"></i></span>
                                 </a>
                                 <form method="post" action="' . url('remove-from-cart') . '"  accept-charset="UTF-8" id="' . $model_delete_id . '">
                                      <input name="_method" type="hidden" value="DELETE">
                                      <input name="_token" type="hidden" value="' . csrf_token() . '">
                                      <input type="hidden" name="session_key" value="' . $session_key . '">
                                      <input type="hidden" name="id" value="' . $id . '">
                                 </form>

                            </td>
                        </td>';



            // if cart is empty then this the first product
            if (!$cart) {
                $cart = [
                    $id => [
                        "name" => $productname,
                        "quantity" => 1,
                        "price" => $productprice,
                        "id" => $id,
                        "tax" => $producttax,
                        "subtotal" => $subtotal,
                        "originalquantity" => $originalquantity,
                    ],
                ];
//                dd($cart);

                if ($originalquantity < $cart[$id]['quantity'] && $session_key == 'pos') {
                    return response()->json(
                        [
                            'code' => 404,
                            'status' => 'Error',
                            'error' => __('This product is out of stock!'),
                        ],
                        404
                    );
                }

                session()->put($session_key, $cart);

                return response()->json(
                    [
                        'code' => 200,
                        'status' => 'Success',
                        'success' => $productname . __(' added to cart successfully!'),
                        'product' => $cart[$id],
                        'carthtml' => $carthtml,
                    ]
                );
            }

            // if cart not empty then check if this product exist then increment quantity
            if (isset($cart[$id])) {

                $cart[$id]['quantity']++;
                $cart[$id]['id'] = $id;

                $subtotal = $cart[$id]["price"] * $cart[$id]["quantity"];
                $tax      = ($subtotal * $cart[$id]["tax"]) / 100;

                $cart[$id]["subtotal"]         = $subtotal + $tax;
                $cart[$id]["originalquantity"] = $originalquantity;

                if ($originalquantity < $cart[$id]['quantity'] && $session_key == 'pos') {
                    return response()->json(
                        [
                            'code' => 404,
                            'status' => 'Error',
                            'error' => __('This product is out of stock!'),
                        ],
                        404
                    );
                }

                session()->put($session_key, $cart);

                return response()->json(
                    [
                        'code' => 200,
                        'status' => 'Success',
                        'success' => $productname . __(' added to cart successfully!'),
                        'product' => $cart[$id],
                        'carttotal' => $cart,
                    ]
                );
            }

            // if item not exist in cart then add to cart with quantity = 1
            $cart[$id] = [
                "name" => $productname,
                "quantity" => 1,
                "price" => $productprice,
                "tax" => $producttax,
                "subtotal" => $subtotal,
                "id" => $id,
                "originalquantity" => $originalquantity,
            ];

            if ($originalquantity < $cart[$id]['quantity'] && $session_key == 'pos') {
                return response()->json(
                    [
                        'code' => 404,
                        'status' => 'Error',
                        'error' => __('This product is out of stock!'),
                    ],
                    404
                );
            }

            session()->put($session_key, $cart);

            return response()->json(
                [
                    'code' => 200,
                    'status' => 'Success',
                    'success' => $productname . __(' added to cart successfully!'),
                    'product' => $cart[$id],
                    'carthtml' => $carthtml,
                    'carttotal' => $cart,
                ]
            );
        } else {
            return response()->json(
                [
                    'code' => 404,
                    'status' => 'Error',
                    'error' => __('This Product is not found!'),
                ],
                404
            );
        }
    }

    public function updateCart(Request $request)
    {

        $id          = $request->id;
        $quantity    = $request->quantity;
        $session_key = $request->session_key;


        if (Auth::user()->can('manage product & service') && $request->ajax() && isset($id) && !empty($id) && isset($session_key) && !empty($session_key)) {
            $cart = session()->get($session_key);



            if (isset($cart[$id]) && $quantity == 0) {
                unset($cart[$id]);
            }

            if ($quantity) {

                $cart[$id]["quantity"] = $quantity;

                $producttax            = $cart[$id]["tax"];
                $productprice          = $cart[$id]["price"];

                $subtotal = $productprice * $quantity;
                $tax      = ($subtotal * $producttax) / 100;

                $cart[$id]["subtotal"] = $subtotal + $tax;
            }

            if ($cart[$id]["originalquantity"] < $cart[$id]['quantity'] && $session_key == 'pos') {
                return response()->json(
                    [
                        'code' => 404,
                        'status' => 'Error',
                        'error' => __('This product is out of stock!'),
                    ],
                    404
                );
            }

            session()->put($session_key, $cart);

            return response()->json(
                [
                    'code' => 200,
                    'success' => __('Cart updated successfully!'),
                    'product' => $cart,
                ]
            );
        } else {
            return response()->json(
                [
                    'code' => 404,
                    'status' => 'Error',
                    'error' => __('This Product is not found!'),
                ],
                404
            );
        }
    }

    public function emptyCart(Request $request)
    {
        $session_key = $request->session_key;

        if (Auth::user()->can('manage product & service') && isset($session_key) && !empty($session_key))
        {
            $cart = session()->get($session_key);
            if (isset($cart) && count($cart) > 0)
            {
                session()->forget($session_key);
            }

            return redirect()->back()->with('error', __('Cart is empty!'));
        }
        else
        {
            return redirect()->back()->with('error', __('Cart cannot be empty!.'));

        }
    }

    public function warehouseemptyCart(Request $request)
    {
        $session_key = $request->session_key;

            $cart = session()->get($session_key);
            if (isset($cart) && count($cart) > 0)
            {
                session()->forget($session_key);
            }

        return response()->json();

    }

    public function removeFromCart(Request $request)
    {
        $id          = $request->id;
        $session_key = $request->session_key;
        if (Auth::user()->can('manage product & service') && isset($id) && !empty($id) && isset($session_key) && !empty($session_key)) {
            $cart = session()->get($session_key);
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put($session_key, $cart);
            }

            return redirect()->back()->with('error', __('Product removed from cart!'));
        } else {
            return redirect()->back()->with('error', __('This Product is not found!'));
        }
    }

}
