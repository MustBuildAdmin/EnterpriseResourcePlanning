   @php
    $settings_data = \App\Models\Utility::settingsById($invoice->created_by);
@endphp
    <!DOCTYPE html>
<html lang="en" dir="{{$settings_data['SITE_RTL'] == 'on'?'rtl':''}}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Lato&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style type="text/css">.resize-observer[data-v-b329ee4c] {
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
            width: 100%;
            height: 100%;
            border: none;
            background-color: transparent;
            pointer-events: none;
            display: block;
            overflow: hidden;
            opacity: 0
        }

        .resize-observer[data-v-b329ee4c] object {
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            overflow: hidden;
            pointer-events: none;
            z-index: -1
        }</style>
    <style type="text/css">p[data-v-f2a183a6] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-f2a183a6] {
            margin: 0;
        }

        .d-table[data-v-f2a183a6] {
            margin-top: 20px;
        }

        .d-table-footer[data-v-f2a183a6] {
            display: -webkit-box;
            display: flex;
        }

        .d-table-controls[data-v-f2a183a6] {
            -webkit-box-flex: 2;
            flex: 2;
        }

        .d-table-summary[data-v-f2a183a6] {
            -webkit-box-flex: 1;
            flex: 1;
        }

        .d-table-summary-item[data-v-f2a183a6] {
            width: 100%;
            display: -webkit-box;
            display: flex;
        }

        .d-table-label[data-v-f2a183a6] {
            -webkit-box-flex: 1;
            flex: 1;
            display: -webkit-box;
            display: flex;
            -webkit-box-pack: end;
            justify-content: flex-end;
            padding-top: 9px;
            padding-bottom: 9px;
        }

        .d-table-label .form-input[data-v-f2a183a6] {
            margin-left: 10px;
            width: 80px;
            height: 24px;
        }

        .d-table-label .form-input-mask-text[data-v-f2a183a6] {
            top: 3px;
        }

        .d-table-value[data-v-f2a183a6] {
            -webkit-box-flex: 1;
            flex: 1;
            text-align: right;
            padding-top: 9px;
            padding-bottom: 9px;
            padding-right: 10px;
        }

        .d-table-spacer[data-v-f2a183a6] {
            margin-top: 5px;
        }

        .d-table-tr[data-v-f2a183a6] {
            display: -webkit-box;
            display: flex;
            flex-wrap: wrap;
        }

        .d-table-td[data-v-f2a183a6] {
            padding: 10px 10px 10px 10px;
        }

        .d-table-th[data-v-f2a183a6] {
            padding: 10px 10px 10px 10px;
            font-weight: bold;
        }

        .d-body[data-v-f2a183a6] {
            padding: 50px;
        }

        .d[data-v-f2a183a6] {
            font-size: 0.9em !important;
            color: black;
            background: white;
            min-height: 1000px;
        }

        .d-right[data-v-f2a183a6] {
            text-align: right;
        }

        .d-title[data-v-f2a183a6] {
            font-size: 50px;
            line-height: 50px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .d-header-50[data-v-f2a183a6] {
            -webkit-box-flex: 1;
            flex: 1;
        }

        .d-header-inner[data-v-f2a183a6] {
            display: -webkit-box;
            display: flex;
            padding: 50px;
        }

        .d-header-brand[data-v-f2a183a6] {
            width: 200px;
        }

        .d-logo[data-v-f2a183a6] {
            max-width: 100%;
        }</style>
    <style type="text/css">p[data-v-37eeda86] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-37eeda86] {
            margin: 0;
        }

        img[data-v-37eeda86] {
            max-width: 100%;
        }

        .d-table-value[data-v-37eeda86] {
            padding-right: 0;
        }

        .d-table-controls[data-v-37eeda86] {
            -webkit-box-flex: 5;
            flex: 5;
        }

        .d-table-summary[data-v-37eeda86] {
            -webkit-box-flex: 4;
            flex: 4;
        }</style>
    <style type="text/css">p[data-v-e95a8a8c] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-e95a8a8c] {
            margin: 0;
        }

        img[data-v-e95a8a8c] {
            max-width: 100%;
        }

        .d[data-v-e95a8a8c] {
            font-family: monospace;
        }

        .fancy-title[data-v-e95a8a8c] {
            margin-top: 0;
            padding-top: 0;
        }

        .d-table-value[data-v-e95a8a8c] {
            padding-right: 0;
        }

        .d-table-controls[data-v-e95a8a8c] {
            -webkit-box-flex: 5;
            flex: 5;
        }

        .d-table-summary[data-v-e95a8a8c] {
            -webkit-box-flex: 4;
            flex: 4;
        }</style>
    <style type="text/css">p[data-v-363339a0] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-363339a0] {
            margin: 0;
        }

        img[data-v-363339a0] {
            max-width: 100%;
        }

        .fancy-title[data-v-363339a0] {
            margin-top: 0;
            font-size: 30px;
            line-height: 1.2em;
            padding-top: 0;
        }

        .f-b[data-v-363339a0] {
            font-size: 17px;
            line-height: 1.2em;
        }

        .thank[data-v-363339a0] {
            font-size: 45px;
            line-height: 1.2em;
            text-align: right;
            font-style: italic;
            padding-right: 25px;
        }

        .f-remarks[data-v-363339a0] {
            padding-left: 25px;
        }

        .d-table-value[data-v-363339a0] {
            padding-right: 0;
        }

        .d-table-controls[data-v-363339a0] {
            -webkit-box-flex: 5;
            flex: 5;
        }

        .d-table-summary[data-v-363339a0] {
            -webkit-box-flex: 4;
            flex: 4;
        }</style>
    <style type="text/css">p[data-v-e23d9750] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-e23d9750] {
            margin: 0;
        }

        img[data-v-e23d9750] {
            max-width: 100%;
        }

        .fancy-title[data-v-e23d9750] {
            margin-top: 0;
            font-size: 40px;
            line-height: 1.2em;
            font-weight: bold;
            padding: 25px;
            margin-right: 25px;
        }

        .f-b[data-v-e23d9750] {
            font-size: 17px;
            line-height: 1.2em;
        }

        .thank[data-v-e23d9750] {
            font-size: 45px;
            line-height: 1.2em;
            text-align: right;
            font-style: italic;
            padding-right: 25px;
        }

        .f-remarks[data-v-e23d9750] {
            padding: 25px;
        }

        .d-table-value[data-v-e23d9750] {
            padding-right: 0;
        }

        .d-table-controls[data-v-e23d9750] {
            -webkit-box-flex: 5;
            flex: 5;
        }

        .d-table-summary[data-v-e23d9750] {
            -webkit-box-flex: 4;
            flex: 4;
        }</style>
    <style type="text/css">p[data-v-4b3dcb8a] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-4b3dcb8a] {
            margin: 0;
        }

        img[data-v-4b3dcb8a] {
            max-width: 100%;
        }

        .fancy-title[data-v-4b3dcb8a] {
            margin-top: 0;
            padding-top: 0;
        }

        .sub-title[data-v-4b3dcb8a] {
            margin: 5px 0 3px 0;
            display: block;
        }

        .d-table-value[data-v-4b3dcb8a] {
            padding-right: 0;
        }

        .d-table-controls[data-v-4b3dcb8a] {
            -webkit-box-flex: 5;
            flex: 5;
        }

        .d-table-summary[data-v-4b3dcb8a] {
            -webkit-box-flex: 4;
            flex: 4;
        }</style>
    <style type="text/css">p[data-v-1ad6e3b9] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-1ad6e3b9] {
            margin: 0;
        }

        img[data-v-1ad6e3b9] {
            max-width: 100%;
        }

        .fancy-title[data-v-1ad6e3b9] {
            margin-top: 0;
            padding-top: 0;
        }

        .sub-title[data-v-1ad6e3b9] {
            margin: 5px 0 3px 0;
            display: block;
        }

        .d-no-pad[data-v-1ad6e3b9] {
            padding: 0px;
        }

        .grey-box[data-v-1ad6e3b9] {
            padding: 50px;
            background: #f8f8f8;
        }

        .d-inner-2[data-v-1ad6e3b9] {
            padding: 50px;
        }</style>
    <style type="text/css">p[data-v-136bf9b5] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-136bf9b5] {
            margin: 0;
        }

        img[data-v-136bf9b5] {
            max-width: 100%;
        }

        .fancy-title[data-v-136bf9b5] {
            margin-top: 0;
            padding-top: 0;
        }

        .d-table-value[data-v-136bf9b5] {
            padding-right: 0px;
        }</style>
    <style type="text/css">p[data-v-7d9d14b5] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-7d9d14b5] {
            margin: 0;
        }

        img[data-v-7d9d14b5] {
            max-width: 100%;
        }

        .fancy-title[data-v-7d9d14b5] {
            margin-top: 0;
            padding-top: 0;
        }

        .sub-title[data-v-7d9d14b5] {
            margin: 0 0 5px 0;
        }

        .padd[data-v-7d9d14b5] {
            margin-left: 5px;
            padding-left: 5px;
            border-left: 1px solid #f8f8f8;
            margin-right: 5px;
            padding-right: 5px;
            border-right: 1px solid #f8f8f8;
        }

        .d-inner[data-v-7d9d14b5] {
            padding-right: 0px;
        }

        .d-table-value[data-v-7d9d14b5] {
            padding-right: 5px;
        }

        .d-table-controls[data-v-7d9d14b5] {
            -webkit-box-flex: 5;
            flex: 5;
        }

        .d-table-summary[data-v-7d9d14b5] {
            -webkit-box-flex: 4;
            flex: 4;
        }</style>
    <style type="text/css">p[data-v-b8f60a0c] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-b8f60a0c] {
            margin: 0;
        }

        img[data-v-b8f60a0c] {
            max-width: 100%;
        }

        .fancy-title[data-v-b8f60a0c] {
            margin-top: 0;
            padding-top: 10px;
        }

        .d-table-value[data-v-b8f60a0c] {
            padding-right: 0;
        }

        .d-table-controls[data-v-b8f60a0c] {
            -webkit-box-flex: 5;
            flex: 5;
        }

        .d-table-summary[data-v-b8f60a0c] {
            -webkit-box-flex: 4;
            flex: 4;
        }

        .overflow-x-hidden {
            overflow-x: hidden !important;
        }</style>
       @if($settings_data['SITE_RTL']=='on')
        <link rel="stylesheet" href="{{ asset('css/bootstrap-rtl.css') }}">
    @endif
</head>
<body class="">

<div class="container">
    <div id="app" class="content">
        <div class="editor">
            <div class="invoice-preview-inner">
                <div class="editor-content">
                    <div class="preview-main client-preview">
                        <div data-v-b8f60a0c="" class="d" style="width:710px;margin-left: auto;margin-right: auto;" id="boxes">
                            <div data-v-b8f60a0c="" class="d-inner">
                                <div data-v-b8f60a0c="" class="row">
                                    <div data-v-b8f60a0c="" class="col-33">

                                        <h1 data-v-b8f60a0c="" class="fancy-title tu mb5" style="color: {{$color}}; border-top: 15px solid {{$color}};">{{__('INVOICE')}}</h1>
                                        <div>
                                            {!! DNS2D::getBarcodeHTML(route('invoice.link.copy',\Crypt::encrypt($invoice->invoice_id)), "QRCODE",2,2) !!}
                                        </div>

                                    </div>

                                    <div data-v-b8f60a0c="" class="col-33"></div>
                                    <div data-v-b8f60a0c="" class="col-33"><img data-v-b8f60a0c="" style="max-width: 250px;" class="d-logo" src="{{$img}}"></div>
                                </div>

                                <div data-v-b8f60a0c="" class="row">
                                    <div data-v-b8f60a0c="" class="col-66"><strong data-v-b8f60a0c="" class="tu mb5" style="color: {{$color}};">{{__('From')}}:</strong>
                                        <p data-v-b8f60a0c="">@if($settings['company_name']){{$settings['company_name']}}@endif</p>
                                        @if($settings['company_email']){{$settings['company_email']}}@endif<br>
                                        @if($settings['company_telephone']){{$settings['company_telephone']}}@endif<br>
                                        <pre data-v-b8f60a0c="">@if($settings['company_address']){{$settings['company_address']}}@endif</pre>
                                        <p data-v-b8f60a0c="">@if($settings['company_city']) {{$settings['company_city']}}@endif, {{!empty($settings['company_state'])?\App\Models\Utility::getstate_detailsonly_name($settings['company_country'],$settings['company_state']):'',', '}} @if($settings['company_zipcode']) - {{$settings['company_zipcode']}}@endif</p>
                                        <p data-v-e95a8a8c="">{{!empty($settings['company_country'])?\App\Models\Utility::getcountry_detailsonly_name($settings['company_country']):''}}</p><br>
                                        @if(!empty($settings['registration_number'])){{__('Registration Number')}} : {{$settings['registration_number']}} @endif<br>
                                        @if(!empty($settings['tax_type']) && !empty($settings['vat_number'])){{$settings['tax_type'].' '. __('Number')}} : {{$settings['vat_number']}} <br>@endif
                                    </div>
                                    <div data-v-b8f60a0c="" class="col-33">
                                        <table data-v-b8f60a0c="" class="summary-table">
                                            <tbody data-v-b8f60a0c="">
                                            <tr data-v-b8f60a0c="">
                                                <td data-v-b8f60a0c="" class="tu fwb" style="color: {{$color}};">{{__('Number')}}:</td>
                                                <td data-v-b8f60a0c="" class="text-right">{{Utility::invoiceNumberFormat($settings,$invoice->invoice_id)}}</td>
                                            </tr>
                                            <tr data-v-b8f60a0c="">
                                                <td data-v-b8f60a0c="" class="tu fwb" style="color: {{$color}};">{{__('Issue Date')}}:</td>
                                                <td data-v-b8f60a0c="" class="text-right">{{Utility::dateFormat($settings,$invoice->issue_date)}}</td>
                                            </tr>
                                            <tr data-v-b8f60a0c="">
                                                <td data-v-b8f60a0c="" class="tu fwb" style="color: {{$color}};">{{__('Due Date')}}:</td>
                                                <td data-v-b8f60a0c="" class="text-right">{{Utility::dateFormat($settings,$invoice->due_date)}}</td>
                                            </tr>
                                            @if(!empty($customFields) && count($invoice->customField)>0)
                                                @foreach($customFields as $field)
                                                    <tr data-v-b8f60a0c="">
                                                        <td data-v-b8f60a0c="" class="tu fwb" style="color: {{$color}};">{{$field->name}} :</td>
                                                        <td data-v-b8f60a0c="" class="text-right"> {{!empty($invoice->customField)?$invoice->customField[$field->id]:'-'}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div data-v-b8f60a0c="" class="break-25"></div>
                                <div class="row">
                                    <div class="bill_to">
                                        <strong data-v-f2a183a6="">{{__('Bill To')}}:</strong>
                                        <p>
                                            {{!empty($customer->billing_name)?$customer->billing_name:''}}<br>
                                            {{!empty($customer->billing_phone)?$customer->billing_phone:''}}<br>
                                            {{!empty($customer->billing_address)?$customer->billing_address:''}}<br>
                                            {{!empty($customer->billing_zip)?$customer->billing_zip:''}}<br>
                                            {{!empty($customer->billing_city)?$customer->billing_city:'' .', '}} {{!empty($customer->billing_state)?\App\Models\Utility::getstate_detailsonly_name($customer->billing_country,$customer->billing_state):'',', '}} 
                                            {{!empty($customer->billing_country)?\App\Models\Utility::getcountry_detailsonly_name($customer->billing_country):''}}
                                        </p>
                                    </div>
                                    @if($settings['shipping_display']=='on')
                                        <div class="ship_to">
                                            <strong data-v-f2a183a6="">{{__('Ship To')}}:</strong>
                                            <p>
                                                {{!empty($customer->shipping_name)?$customer->shipping_name:''}}<br>
                                                {{!empty($customer->shipping_phone)?$customer->shipping_phone:''}}<br>
                                                {{!empty($customer->shipping_address)?$customer->shipping_address:''}}<br>
                                                {{!empty($customer->shipping_zip)?$customer->shipping_zip:''}}<br>
                                                {{!empty($customer->shipping_city)?$customer->shipping_city:'' . ', '}} {{!empty($customer->shipping_state)?\App\Models\Utility::getstate_detailsonly_name($customer->billing_country,$customer->shipping_state):'' .', '}},{{!empty($customer->shipping_country)?\App\Models\Utility::getcountry_detailsonly_name($customer->shipping_country):''}}<br>
                                            </p>
                                        </div>
                                    @endif
                                </div>
                                <div class="row mt-3">
                                <div class="col">
                                    @php  
                                        $statecode=\App\Models\Utility::statecode();
                                    @endphp
                                    <small>
                                        <strong>{{__('Place Of Supply')}} :</strong><br>
                                            <span>{{!empty($customer->shipping_state)?\App\Models\Utility::getstate_detailsonly_name($customer->billing_country,$customer->shipping_state):'' .', '}} 
                                            @isset($statecode[$customer->shipping_state])
                                                ({{$statecode[$customer->shipping_state]}})
                                            @endisset
                                            </span>
                                    </small>
                                </div>
                                </div>
                                <div data-v-b8f60a0c="" class="break-25"></div>
                                <div data-v-b8f60a0c="" class="d-table">
                                    <div data-v-b8f60a0c="" class="d-table">

                                        <div data-v-f2a183a6="" class="d-table-tr" style="background: {{$color}};color:{{$font_color}}">
                                            <div class="d-table-th w-4">{{__('Item')}}</div>
                                            <div class="d-table-th w-2">{{__('Quantity')}}</div>
                                            <div class="d-table-th w-3">{{__('Rate')}}</div>
                                            <div class="d-table-th w-2">{{__('HSC/SAC')}}</div>
                                            <div class="d-table-th w-4">{{__('Discount')}}</div>
                                            @if($gstflag==1)
                                            <div class="d-table-th w-3">CGST</div>
                                            <div class="d-table-th w-3">SGST</div>
                                            @else
                                            <div class="d-table-th w-3">IGST</th>
                                            @endif
                                            {{-- <div class="d-table-th w-4">{{__('Tax')}} </div> --}}
                                           
{{--                                            <div class="d-table-th w-3">{{__('Description')}}</div>--}}
                                            <div class="d-table-th w-4 text-right">{{__('Price')}}<br><small class="text-danger">{{__('before tax & discount')}}</small>
                                            </div>
                                        </div>

                                        <div class="d-table-body">
                                            @if(isset($invoice->itemData) && count($invoice->itemData) > 0)
                                                @foreach($invoice->itemData as $key => $item)
                                                @php dd($item);@endphp
                                                    <div class="d-table-tr" style="border-bottom:1px solid {{$color}};">
                                                        <div class="d-table-td w-4">
                                                            <pre data-v-f2a183a6="">{{$item->name}}</pre>
                                                        </div>
                                                        <div class="d-table-td w-3">
                                                            <pre data-v-f2a183a6="">{{$item->quantity}}</pre>
                                                        </div>
                                                        <div class="d-table-td w-4">
                                                            <pre data-v-f2a183a6="">{{Utility::priceFormat($settings,$item->price)}}</pre>
                                                        </div>
                                                        <div class="d-table-td w-4">
                                                            <pre data-v-f2a183a6="">@isset($hsc[$item->id]) {{$hsc[$item->id]}} @endisset</pre>
                                                        </div>
                                                        <div class="d-table-td w-4">
                                                            <pre data-v-f2a183a6="">{{($item->discount!=0)?Utility::priceFormat($settings,$item->discount):'-'}}</pre>
                                                        </div>
                                                        <div class="d-table-td w-4">
                                                            <pre data-v-f2a183a6="">{{($item->discount!=0)?Utility::priceFormat($settings,$item->discount):'-'}}</pre>
                                                        </div>
                                                     
                                                        @if($gstflag==1)
                                                        <div class="d-table-td w-5">
                                                                <pre data-v-f2a183a6="">
                                                                   @if(!empty($item->itemTax))
                                                                        @foreach($item->itemTax as $taxes)
                                                                            <span>({{$taxes['rate']/2}})</span> <span>{{$taxes['price']/2}}</span>
                                                                        @endforeach
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </pre>
                                                        </div>
                                                        <div class="d-table-td w-5">
                                                            <pre data-v-f2a183a6="">
                                                               @if(!empty($item->itemTax))
                                                                    @foreach($item->itemTax as $taxes)
                                                                        <span>({{$taxes['rate']/2}})</span> <span>{{$taxes['price']/2}}</span>
                                                                    @endforeach
                                                                @else
                                                                    -
                                                                @endif
                                                            </pre>
                                                        </div>
                                                        @else
                                                            <div class="d-table-td w-5">
                                                                <pre data-v-f2a183a6="">
                                                                @if(!empty($item->itemTax))
                                                                        @foreach($item->itemTax as $taxes)
                                                                            <span>({{$taxes['rate']}})</span> <span>{{$taxes['price']}}</span>
                                                                        @endforeach
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </pre>
                                                            </div>
                                                        @endif
                                                           

{{--                                                        <div class="d-table-td w-3">--}}
{{--                                                            <pre data-v-f2a183a6="">{{!empty($item->description)?$item->description:'-'}}</pre>--}}
{{--                                                        </div>--}}
                                                        <div class="d-table-td w-4 text-right"><span>{{Utility::priceFormat($settings,$item->price * $item->quantity)}}</span></div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="d-table-tr" style="border-bottom:1px solid {{$color}};">
                                                    <div class="d-table-td w-2"><span>-</span></div>
                                                    <div class="d-table-td w-7">
                                                        <pre data-v-f2a183a6="">-</pre>
                                                    </div>
                                                    <div class="d-table-td w-5">
                                                        <pre data-v-f2a183a6="">-</pre>
                                                    </div>
                                                    <div class="d-table-td w-5">
                                                        <pre data-v-f2a183a6="">-</pre>
                                                    </div>
                                                    <div class="d-table-td w-4 text-right"><span>-</span></div>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="d-table-tr" style="border-bottom:1px solid {{$color}};">
                                            <div class="d-table-td w-4">
                                                <pre data-v-f2a183a6="">{{__('Total')}}</pre>
                                            </div>
                                            <div class="d-table-td w-2">
                                                <pre data-v-f2a183a6="">{{$invoice->totalQuantity}}</pre>
                                            </div>
                                            <div class="d-table-td w-5">
                                                <pre data-v-f2a183a6="">{{Utility::priceFormat($settings,$invoice->totalRate)}}</pre>
                                            </div>
                                            <div class="d-table-td w-4">
                                                <pre data-v-f2a183a6="">{{Utility::priceFormat($settings,$invoice->totalDiscount)}}</pre>
                                            </div>
                                            <div class="d-table-td w-5">
                                                <pre data-v-f2a183a6="">{{Utility::priceFormat($settings,$invoice->totalTaxPrice) }}</pre>
                                            </div>
                                            <div class="d-table-td w-5">
                                                <pre data-v-f2a183a6="">{{Utility::priceFormat($settings,$invoice->totalTaxPrice) }}</pre>
                                            </div>

                                                


                                            <div class="d-table-td w-4 text-right">
                                                    <span>{{Utility::priceFormat($settings,$invoice->getSubTotal())}}
                                                    </span>
                                            </div>
                                        </div>

                                        <div data-v-f2a183a6="" class="d-table-footer">
                                            <div data-v-f2a183a6="" class="d-table-controls"></div>
                                            <div data-v-f2a183a6="" class="d-table-summary">
                                                <div data-v-f2a183a6="" class="d-table-summary-item">
                                                    <div data-v-f2a183a6="" class="d-table-label">{{__('Subtotal')}}:</div>
                                                    <div data-v-f2a183a6="" class="d-table-value">{{Utility::priceFormat($settings,$invoice->getSubTotal())}}</div>
                                                </div>
                                                @if($invoice->getTotalDiscount())
                                                    <div data-v-f2a183a6="" class="d-table-summary-item">
                                                        <div data-v-f2a183a6="" class="d-table-label">{{__('Discount')}}:</div>
                                                        <div data-v-f2a183a6="" class="d-table-value">{{Utility::priceFormat($settings,$invoice->getTotalDiscount())}}</div>
                                                    </div>
                                                @endif
                                                @if(!empty($invoice->taxesData))
                                                    @foreach($invoice->taxesData as $taxName => $taxPrice)
                                                        {{-- gst calucluation --}}
                                                                @if($settings['indiangst']==1 && isset($gstflag))
                                                                    @if($gstflag==1)
                                                                        <div data-v-f2a183a6="" class="d-table-summary-item">
                                                                            <div data-v-f2a183a6="" class="d-table-label">CGST :</div>
                                                                            <div data-v-f2a183a6="" class="d-table-value">{{ Utility::priceFormat($settings,$taxPrice/2)}}</div>
                                                                        </div>
                                                                        <div data-v-f2a183a6="" class="d-table-summary-item">
                                                                            <div data-v-f2a183a6="" class="d-table-label">SGST :</div>
                                                                            <div data-v-f2a183a6="" class="d-table-value">{{ Utility::priceFormat($settings,$taxPrice/2)}}</div>
                                                                        </div>
                                                                    @else
                                                                        <div data-v-f2a183a6="" class="d-table-summary-item">
                                                                            <div data-v-f2a183a6="" class="d-table-label">IGST :</div>
                                                                            <div data-v-f2a183a6="" class="d-table-value">{{ Utility::priceFormat($settings,$taxPrice)}}</div>
                                                                        </div>
                                                                    @endif
                                                                @else
                                                                    <div data-v-f2a183a6="" class="d-table-summary-item">
                                                                        <div data-v-f2a183a6="" class="d-table-label">{{$taxName}} :</div>
                                                                        <div data-v-f2a183a6="" class="d-table-value">{{ Utility::priceFormat($settings,$taxPrice)}}</div>
                                                                    </div>
                                                                @endif
                                                            
                                                    @endforeach
                                                @endif
                                                <div data-v-f2a183a6="" class="d-table-summary-item">
                                                    <div data-v-f2a183a6="" class="d-table-label">{{__('Total')}}:</div>
                                                    <div data-v-f2a183a6="" class="d-table-value">{{Utility::priceFormat($settings,$invoice->getSubTotal()-$invoice->getTotalDiscount()+$invoice->getTotalTax())}}</div>
                                                </div>
                                                <div data-v-f2a183a6="" class="d-table-summary-item">
                                                    <div data-v-f2a183a6="" class="d-table-label">{{__('Paid')}}:</div>
                                                    <div data-v-f2a183a6="" class="d-table-value">{{Utility::priceFormat($settings,($invoice->getTotal()-$invoice->getDue())-($invoice->invoiceTotalCreditNote()))}}</div>
                                                </div>
                                                <div data-v-f2a183a6="" class="d-table-summary-item">
                                                    <div data-v-f2a183a6="" class="d-table-label">{{__('Credit Note')}}:</div>
                                                    <div data-v-f2a183a6="" class="d-table-value">{{Utility::priceFormat($settings,($invoice->invoiceTotalCreditNote()))}}</div>
                                                </div>
                                                <div data-v-f2a183a6="" class="d-table-summary-item">
                                                    <div data-v-f2a183a6="" class="d-table-label">{{__('Due Amount')}}:</div>
                                                    <div data-v-f2a183a6="" class="d-table-value">{{Utility::priceFormat($settings,$invoice->getDue())}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div data-v-f2a183a6="" class="d-header-50">
                                    <p data-v-f2a183a6="">
                                        {{$settings['footer_title']}} :<br>
                                        {{$settings['footer_notes']}}
                                    </p>
                                </div>
                                <div data-v-b8f60a0c="" class="break-25"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- @if(!isset($preview))
    @include('invoice.script');
@endif --}}
</body>
</html>
