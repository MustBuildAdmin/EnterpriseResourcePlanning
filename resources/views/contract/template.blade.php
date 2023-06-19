
@php
$logo=\App\Models\Utility::get_file('uploads/logo/');
$dark_logo    = Utility::getValByName('dark_logo');
$img = asset($logo . '/' . (isset($dark_logo) && !empty($dark_logo) ? $dark_logo : 'logo-dark.png'));
$settings    = Utility::settings();
@endphp

@extends('layouts.contractheader')
@section('page-title')

@endsection

@section('title')

@endsection

@section('content')

<div class="row">
    <div class="col-lg-10">
        <div class="container">
            <div>
                <div class="card mt-5" id="printTable" style="margin-left: 180px;margin-right: -57px;">
                    <div class="card-body" id="boxes">
                    <div class="row invoice-title mt-2">
                                <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12 ">
                                    <img  src="{{$img}}" style="max-width: 150px;"/>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12 text-end">
                                    <h3 class="invoice-number">{{\Auth::user()->contractNumberFormat($contract->id)}}</h3>
                                </div>
                            </div>
                            <div class="row align-items-center mb-4">

                                <div class="col-sm-6 mb-3 mb-sm-0 mt-3">
                                    <div class="col-lg-12 col-md-8 mb-3">
                                        <h6 class="d-inline-block m-0 d-print-none">{{__('Contract Type  :')}}</h6>
                                        <span class="col-md-8"><span class="text-md">{{$contract->types->name }}</span></span>
                                    </div>
                                    <div class="col-lg-6 col-md-8">
                                    <h6 class="d-inline-block m-0 d-print-none">{{__('Contract Value   :')}}</h6>
                                    <span class="col-md-8"><span class="text-md">{{ Auth::user()->priceFormat($contract->value) }}</span></span>
                                </div>
                                </div>
                                <div class="col-sm-6 text-sm-end">
                                    <div>
                                        <div class="float-end">
                                            <div class="">
                                                <h6 class="d-inline-block m-0 d-print-none">{{__('Start Date   :')}}</h6>
                                                <span class="col-md-8"><span class="text-md">{{Auth::user()->dateFormat($contract->start_date) }}</span></span>
                                            </div>
                                            <div class="mt-3">
                                                <h6 class="d-inline-block m-0 d-print-none">{{__('End Date   :')}}</h6>
                                                <span class="col-md-8"><span class="text-md">{{Auth::user()->dateFormat($contract->end_date)}}</span></span>
                                            </div>

                                            {{-- {!! DNS2D::getBarcodeHTML(route('pay.invoice',\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)), "QRCODE",2,2) !!} --}}
                                        </div>

                                    </div>
                                </div>
                            </div>
                        <p data-v-f2a183a6="">
                              <div>{!!$contract->description!!}</div>
                                <br>
                                <div>{!!$contract->contract_description!!}</div>
                        </p>
                        <div class="row">
                                <div class="col-6">
                                    <div>
                                        <img width="200px" src="{{$contract->company_signature}}" >
                                    </div>
                                    <div>
                                        <h5 class="mt-auto">{{__('Company Signature')}}</h5>
                                    </div>
                                </div>
                                <div class="col-6 text-end">
                                    <img width="150px" src="{{$contract->client_signature}}" >
                                    <h5 class="mt-auto">{{__('Client Signature')}}</h5>
                                </div>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@push('script-page')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
<script>
    function closeScript() {
        setTimeout(function () {
            window.open(window.location, '_self').close();
        }, 1000);
    }

    $(window).on('load', function () {
        var element = document.getElementById('boxes');
        var opt = {
            filename: '{{App\Models\Utility::contractNumberFormat($contract->id)}}',
            image: {type: 'jpeg', quality: 1},
            html2canvas: {scale: 4, dpi: 72, letterRendering: true},
            jsPDF: {unit: 'in', format: 'A4'}
        };

        html2pdf().set(opt).from(element).save().then(closeScript);
    });
</script>
@endpush


