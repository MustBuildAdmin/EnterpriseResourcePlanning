@php
    $logo=asset(Storage::url('uploads/logo/'));
$company_favicon=Utility::getValByName('company_favicon');
    $setting = \App\Models\Utility::colorset();

   $color = 'theme-3';
    if (!empty($setting)) {
        $color = $setting;
    }

    $SITE_RTL = Cookie::get('SITE_RTL');
    if ($SITE_RTL == '') {
        $SITE_RTL = 'off';
    }

    $currantLang = Cookie::get('LANGUAGE');
    if (!isset($currantLang)) {
        $currantLang = 'en';
    }

    $cust_theme_bg = Cookie::get('cust_theme_bg');
    if ($cust_theme_bg == '') {
        $cust_theme_bg = 'on';
    }

    $cust_darklayout = Cookie::get('cust_darklayout');
    if ($cust_darklayout == '') {
        $cust_darklayout = 'off';
}
@endphp

    <!DOCTYPE html>

<html lang="en">

<head>
    <title>{{__('ERPGo')}}</title>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

    <!-- Meta -->
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    {{--    <meta name="url" content="{{ url('').'/'.config('chatify.path') }}" data-user="{{ Auth::user()->id }}">--}}
    <link rel="icon" href="{{$logo.'/'.(isset($company_favicon) && !empty($company_favicon)?$company_favicon:'favicon.png')}}" type="image" sizes="16x16">

    <!-- Favicon icon -->
    {{--    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon"/>--}}
<!-- Calendar-->
    @stack('css-page')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/main.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/plugins/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/flatpickr.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/plugins/animate.min.css') }}">



    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

    <!--bootstrap switch-->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap-switch-button.min.css') }}">

    <!-- vendor css -->
    @if ($SITE_RTL == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}">
    @endif
    @if ($cust_darklayout == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    @endif

    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" id="main-style-link">

    @stack('css-page')
</head>

<body class="{{ $color }}">
<header class="header header-transparent" id="header-main">

</header>

<div class="main-content container">

    <div class="row justify-content-between align-items-center mb-3">
        <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">

            <div class="all-button-box mx-2">

                <a href="{{ route('purchase.pdf', \Crypt::encrypt($purchase->id))}}" target="_blank" class="btn btn-primary mt-3">
                    {{__('Download')}}
                </a>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice">
                        <div class="invoice-print">
                            <div class="row invoice-title mt-2">
                                <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12">
                                    <h2>{{__('Purchase')}}</h2>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12 text-end">
                                    <h3 class="invoice-number float-right"></h3>

                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <div class="d-flex align-items-center justify-content-end">

                                        <div class="me-4">
                                            <small>
                                                <strong>{{__('Pos Date')}} :</strong><br>
                                                {{$user->dateFormat($purchase->pos_date)}}<br><br>
                                            </small>
                                        </div>
{{--                                        <small>--}}
{{--                                            <strong>{{__('Due Date')}} :</strong><br>--}}
{{--                                            {{$user->dateFormat($purchase->due_date)}}<br><br>--}}
{{--                                        </small>--}}

                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                @if(!empty($vendor->billing_name))
                                    <div class="col">
                                        <small class="font-style">
                                            <strong>{{__('Billed To')}} :</strong><br>
                                            {{!empty($vendor->billing_name)?$vendor->billing_name:''}}<br>
                                            {{!empty($vendor->billing_phone)?$vendor->billing_phone:''}}<br>
                                            {{!empty($vendor->billing_address)?$vendor->billing_address:''}}<br>
                                            {{!empty($vendor->billing_zip)?$vendor->billing_zip:''}}<br>
                                            {{!empty($vendor->billing_city)?$vendor->billing_city:'' .', '}} {{!empty($vendor->billing_state)?$vendor->billing_state:'',', '}} {{!empty($vendor->billing_country)?$vendor->billing_country:''}}
                                        </small>
                                    </div>
                                @endif
                                @if(\Utility::getValByName('shipping_display')=='on')
                                    <div class="col">
                                        <small>
                                            <strong>{{__('Shipped To')}} :</strong><br>
                                            {{!empty($vendor->shipping_name)?$vendor->shipping_name:''}}<br>
                                            {{!empty($vendor->shipping_phone)?$vendor->shipping_phone:''}}<br>
                                            {{!empty($vendor->shipping_address)?$vendor->shipping_address:''}}<br>
                                            {{!empty($vendor->shipping_zip)?$vendor->shipping_zip:''}}<br>
                                            {{!empty($vendor->shipping_city)?$vendor->shipping_city:'' .', '}} {{!empty($vendor->shipping_state)?$vendor->shipping_state:'',', '}} {{!empty($vendor->shipping_country)?$vendor->shipping_country:''}}
                                        </small>
                                    </div>
                                @endif
                                <div class="col">
                                    <div class="float-end mt-3">
                                        {!! DNS2D::getBarcodeHTML(route('bill.link.copy',\Illuminate\Support\Facades\Crypt::encrypt($purchase->id)), "QRCODE",2,2) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <small>
                                        <strong>{{__('Status')}} :</strong><br>
                                        @if($purchase->status == 0)
                                            <span class="badge bg-primary">{{ __(\App\Models\Bill::$statues[$purchase->status]) }}</span>
                                        @elseif($purchase->status == 1)
                                            <span class="badge bg-warning">{{ __(\App\Models\Bill::$statues[$purchase->status]) }}</span>
                                        @elseif($purchase->status == 2)
                                            <span class="badge bg-danger">{{ __(\App\Models\Bill::$statues[$purchase->status]) }}</span>
                                        @elseif($purchase->status == 3)
                                            <span class="badge bg-info">{{ __(\App\Models\Bill::$statues[$purchase->status]) }}</span>
                                        @elseif($purchase->status == 4)
                                            <span class="badge bg-success">{{ __(\App\Models\Bill::$statues[$purchase->status]) }}</span>
                                        @endif
                                    </small>
                                </div>



                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="font-weight-bold">{{__('Product Summary')}}</div>
                                    <small>{{__('All items here cannot be deleted.')}}</small>
                                    <div class="table-responsive mt-2">
                                        <table class="table table-striped">
                                            <tr>
                                                <th class="text-dark" data-width="40">#</th>
                                                <th class="text-dark">{{__('Product')}}</th>
                                                <th class="text-dark">{{__('Quantity')}}</th>
                                                <th class="text-dark">{{__('Rate')}}</th>
                                                <th class="text-dark">{{__('Tax')}}</th>
                                                <th class="text-dark">
                                                        {{__('Discount')}}

                                                </th>
                                                <th class="text-dark">{{__('Description')}}</th>
                                                <th class="text-end text-dark" width="12%">{{__('Price')}}<br>
                                                    <small class="text-danger ">{{__('before tax & discount')}}</small>
                                                </th>
                                            </tr>
                                            @php
                                                $totalQuantity=0;
                                                $totalRate=0;
                                                $totalTaxPrice=0;
                                                $totalDiscount=0;
                                                $taxesData=[];
                                            @endphp

                                            @foreach($iteams as $key =>$iteam)
                                                @if(!empty($iteam->tax))
                                                    @php
                                                        $taxes=\Utility::tax($iteam->tax);
                                                        $totalQuantity+=$iteam->quantity;
                                                        $totalRate+=$iteam->price;
                                                        $totalDiscount+=$iteam->discount;
                                                        foreach($taxes as $taxe){
                                                            $taxDataPrice=\Utility::taxRate($taxe->rate,$iteam->price,$iteam->quantity);
                                                            if (array_key_exists($taxe->name,$taxesData))
                                                            {
                                                                $taxesData[$taxe->name] = $taxesData[$taxe->name]+$taxDataPrice;
                                                            }
                                                            else
                                                            {
                                                                $taxesData[$taxe->name] = $taxDataPrice;
                                                            }
                                                        }
                                                    @endphp
                                                @endif
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{!empty($iteam->product())?$iteam->product()->name:''}}</td>
                                                    <td>{{$iteam->quantity}}</td>
                                                    <td>{{$user->priceFormat($iteam->price)}}</td>
                                                    <td>
                                                        @if(!empty($iteam->tax))
                                                            <table>
                                                                @php $totalTaxRate = 0;@endphp
                                                                @foreach($taxes as $tax)
                                                                    @php
                                                                        $taxPrice=\Utility::taxRate($tax->rate,$iteam->price,$iteam->quantity);
                                                                        $totalTaxPrice+=$taxPrice;
                                                                    @endphp
                                                                    <tr>
                                                                        <td>{{$tax->name .' ('.$tax->rate .'%)'}}</td>
                                                                        <td>{{$user->priceFormat($taxPrice)}}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </table>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                            {{$user->priceFormat($iteam->discount)}}

                                                    </td>
                                                    <td>{{!empty($iteam->description)?$iteam->description:'-'}}</td>
                                                    <td class="text-end">{{$user->priceFormat(($iteam->price*$iteam->quantity))}}</td>
                                                </tr>
                                            @endforeach
                                            <tfoot>
                                            <tr>
                                                <td></td>
                                                <td><b>{{__('Total')}}</b></td>
                                                <td><b>{{$totalQuantity}}</b></td>
                                                <td><b>{{$user->priceFormat($totalRate)}}</b></td>
                                                <td><b>{{$user->priceFormat($totalTaxPrice)}}</b></td>
                                                <td>
                                                        <b>{{$user->priceFormat($totalDiscount)}}</b>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6"></td>
                                                <td class="text-end"><b>{{__('Sub Total')}}</b></td>
                                                <td class="text-end">{{$user->priceFormat($purchase->getSubTotal())}}</td>
                                            </tr>

                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b>{{__('Discount')}}</b></td>
                                                    <td class="text-end">{{$user->priceFormat($purchase->getTotalDiscount())}}</td>
                                                </tr>

                                            @if(!empty($taxesData))
                                                @foreach($taxesData as $taxName => $taxPrice)
                                                    <tr>
                                                        <td colspan="6"></td>
                                                        <td class="text-end"><b>{{$taxName}}</b></td>
                                                        <td class="text-end">{{ $user->priceFormat($taxPrice) }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            <tr>
                                                <td colspan="6"></td>
                                                <td class="blue-text text-end"><b>{{__('Total')}}</b></td>
                                                <td class="blue-text text-end">{{$user->priceFormat($purchase->getTotal())}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6"></td>
                                                <td class="text-end"><b>{{__('Paid')}}</b></td>
                                                <td class="text-end">{{$user->priceFormat(($purchase->getTotal()-$purchase->getDue()))}}</td>
                                            </tr>

                                            <tr>
                                                <td colspan="6"></td>
                                                <td class="text-end"><b>{{__('Due')}}</b></td>
                                                <td class="text-end">{{$user->priceFormat($purchase->getDue())}}</td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<footer id="footer-main">
    <div class="footer-dark">
        <div class="container">
            <div class="row align-items-center justify-content-md-between py-4 mt-4 delimiter-top">
                <div class="col-md-6">
                    <div class="copyright text-sm font-weight-bold text-center text-md-left">
                        {{!empty($companySettings['footer_text']) ? $companySettings['footer_text']->value : ''}}
                    </div>
                </div>
                <div class="col-md-6">
                    <ul class="nav justify-content-center justify-content-md-end mt-3 mt-md-0">
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_blank">
                                <i class="fab fa-dribbble"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_blank">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_blank">
                                <i class="fab fa-github"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_blank">
                                <i class="fab fa-facebook"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>


@if($message = Session::get('success'))
    <script>
        show_toastr('success', '{!! $message !!}');
    </script>
@endif
@if($message = Session::get('error'))
    <script>
        show_toastr('error', '{!! $message !!}');
    </script>
@endif


