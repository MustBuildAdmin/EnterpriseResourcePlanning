
@php

    //$logo=asset(Storage::url('uploads/logo/'));
       $logo=\App\Models\Utility::get_file('uploads/logo');

    $company_favicon=Utility::getValByName('company_favicon');
    $setting = \App\Models\Utility::colorset();
    $company_logo = \App\Models\Utility::GetLogo();
    $mode_setting = \App\Models\Utility::mode_layout();
    $color = (!empty($setting['color'])) ? $setting['color'] : 'theme-3';
    $SITE_RTL = Utility::getValByName('SITE_RTL');
     $lang=Utility::getValByName('default_language');


@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{$SITE_RTL == 'on' ? 'rtl' : '' }}">
<meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<head>
    <title>{{(Utility::getValByName('title_text')) ? Utility::getValByName('title_text') : config('app.name', 'Must BuildApp')}} -  {{__('Settings')}}</title>
    <!-- <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script> -->
    <!-- <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script> -->

    <!-- Meta -->
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="url" content="{{ url('').'/'.config('chatify.path') }}" data-user="{{ Auth::user()->id }}">
    <link rel="icon" href="{{$logo.'/'.(isset($company_favicon) && !empty($company_favicon)?$company_favicon:'favicon.png')}}" type="image" sizes="16x16">
    <link href="{{asset('assets/dist/css/tabler.min.css?1674944402')}}" rel="stylesheet"/>
    <link href="{{asset('assets/dist/css/tabler-flags.min.css?1674944402')}}" rel="stylesheet"/>
    <link href="{{asset('assets/dist/css/tabler-payments.min.css?1674944402')}}" rel="stylesheet"/>
    <link href="{{asset('assets/dist/css/tabler-vendors.min.css?1674944402')}}" rel="stylesheet"/>
    <link href="{{asset('assets/dist/css/demo.min.css?1674944402')}}" rel="stylesheet"/>
    <style>
        .form-group {
            margin-bottom: 1.3rem;
        }
        a:hover {
            outline: none;
            text-decoration: none;
        }
        .text-muted {
    --bs-text-opacity: 1;
    color: #6c757d !important;
}
       @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
      :root {
      	--tblr-font-sans-serif: 'Poppins', sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
    @stack('css-page')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/main.css') }}">

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
    @if ($setting['cust_darklayout'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}">
    @endif

    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" id="main-style-link">

    @stack('css-page')
</head>
<body class="{{ $color }}">

<!-- [ Pre-loader ] start -->
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>
@if (Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li style="text-align: center;list-style: none;font-weight:bold;">{{ Session::get('success') }}</li>
        </ul>
    </div>
@endif
@php

    // $logo=asset(Storage::url('uploads/logo/'));
   $logo=\App\Models\Utility::get_file('uploads/logo');
   $logo_light = \App\Models\Utility::getValByName('company_logo_light');
   $logo_dark = \App\Models\Utility::getValByName('company_logo_dark');
   $company_favicon = \App\Models\Utility::getValByName('company_favicon');
   $setting = \App\Models\Utility::colorset();
   $mode_setting = \App\Models\Utility::mode_layout();
   $color = (!empty($setting['color'])) ? $setting['color'] : 'theme-3';
   $company_setting=\App\Models\Utility::settingsById('site_currency');
   $SITE_RTL= isset($setting['SITE_RTL'])?$setting['SITE_RTL']:'off';
   $EmailTemplates   = App\Models\EmailTemplate::all();
   $currantLang =  Utility::languages();



@endphp

    <script src="https://code.jquery.com/jquery-3.6.4.min.js" type="text/javascript"></script>

    <script>


        $(document).on("change", '#company_country', function () {
            console.log("testong")
            var name=$(this).val();
            var settings = {
                    "url": "https://api.countrystatecity.in/v1/countries/"+name+"/states",
                    "method": "GET",
                    "headers": {
                        "X-CSCAPI-KEY": '{{ env('Locationapi_key') }}'
                    },
                    };

                    $.ajax(settings).done(function (response) {
                            $('#company_state').empty();
                            $('#company_state').append('<option value="">{{__('Select State ...')}}</option>');
                                $.each(response, function (key, value) {
                                    $('#company_state').append('<option value="' + value.iso2 + '">' + value.name + '</option>');
                                });
                });
            });


        function getstate(did) {


            var name=did
            var settings = {
                    "url": "https://api.countrystatecity.in/v1/countries/"+name+"/states",
                    "method": "GET",
                    "headers": {
                        "X-CSCAPI-KEY": '{{ env('Locationapi_key') }}'
                    },
                    };

                    $.ajax(settings).done(function (response) {

                            $('#company_state').empty();
                            $('#company_state').append('<option value="">{{__("Select State ...")}}</option>');
                                $.each(response, function (key, value) {
                                    var select = '';
                                    if (value.iso2 == '{{ $setting["company_state"] }}') {
                                        select = 'selected';
                                    }
                                    $('#company_state').append('<option '+ select+'  value="' + value.iso2 +'">' + value.name + '</option>');
                                });
                });
        }

        $(document).ready(function () {
            var country = '{{ $setting["company_country"] }}';
            if(country!=''&& country!=null){
                getstate(country);
            }

        });
    </script>

@push('script-page')
    <script>
        $(document).on("change", "select[name='invoice_template'], input[name='invoice_color']", function () {
            var template = $("select[name='invoice_template']").val();
            var color = $("input[name='invoice_color']:checked").val();
            $('#invoice_frame').attr('src', '{{url('/invoices/preview')}}/' + template + '/' + color);
        });

        $(document).on("change", "select[name='proposal_template'], input[name='proposal_color']", function () {
            var template = $("select[name='proposal_template']").val();
            var color = $("input[name='proposal_color']:checked").val();
            $('#proposal_frame').attr('src', '{{url('/proposal/preview')}}/' + template + '/' + color);
        });

        $(document).on("chnge", "select[name='bill_template'], input[name='bill_color']", function () {
            var template = $("select[name='bill_template']").val();
            var color = $("input[name='bill_color']:checked").val();
            $('#bill_frame').attr('src', '{{url('/bill/preview')}}/' + template + '/' + color);
        });
    </script>

    <script>
            var scrollSpy = new bootstrap.ScrollSpy(document.body, {
                target: '#useradd-sidenav',
                offset: 300,
            })
            $(".list-group-item").click(function(){
                $('.list-group-item').filter(function(){
                    return this.href == id;
                }).parent().removeClass('text-primary');
            });

            function check_theme(color_val) {
                $('#theme_color').prop('checked', false);
                $('input[value="' + color_val + '"]').prop('checked', true);
            }
        </script>


    <script>
        // document.getElementById('company_logo_dark').onchange = function () {
        //     var src = URL.createObjectURL(this.files[0])
        //     document.getElementById('image').src = src
        // }
        // document.getElementById('company_logo_light').onchange = function () {
        //     var src = URL.createObjectURL(this.files[0])
        //     document.getElementById('image1').src = src
        // }
        // document.getElementById('company_favicon').onchange = function () {
        //     var src = URL.createObjectURL(this.files[0])
        //     document.getElementById('image2').src = src
        // }
    </script>

    <script type="text/javascript">

        $(document).on("click", ".email-template-checkbox", function () {
            var chbox = $(this);
            $.ajax({
                url: chbox.attr('data-url'),
                data: {_token: $('meta[name="csrf-token"]').attr('content'), status: chbox.val()},
                type: 'PUT',
                success: function (response) {
                    if (response.is_success) {
                        show_toastr('success', response.success, 'success');
                        if (chbox.val() == 1) {
                            $('#' + chbox.attr('id')).val(0);
                        } else {
                            $('#' + chbox.attr('id')).val(1);
                        }
                    } else {
                        show_toastr('Error', response.error, 'error');
                    }
                },
                error: function (response) {
                    response = response.responseJSON;
                    if (response.is_success) {
                        show_toastr('Error', response.error, 'error');
                    } else {
                        show_toastr('Error', response, 'error');
                    }
                }
            })
        });

    </script>



@endpush
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" type="text/javascript"></script>
<div class="page-body">
  <div class="container-xl">
  <div id="multi-step-form-container">
        <!-- Form Steps / Progress Bar -->
        <ul class="form-stepper form-stepper-horizontal text-center mx-auto pl-0">
            <!-- Step 1 -->
            <li class="form-stepper-active text-center form-stepper-list" step="1">
                <a class="mx-2">
                    <span class="form-stepper-circle">
                        <span>1</span>
                    </span>
                    <div class="label">{{ __('System Setting') }}</div>
                </a>
            </li>
            <!-- Step 2 -->
            <li class="form-stepper-unfinished text-center form-stepper-list" step="2">
                <a class="mx-2">
                    <span class="form-stepper-circle text-muted">
                        <span>2</span>
                    </span>
                    <div class="label text-muted">{{ __('Company Setting') }}</div>
                </a>
            </li>
        </ul>
        <div>
        {{Form::model($settings,array('route'=>'company.settingssave','method'=>'post','id'=>'company_form'))}}
            <section id="step-1" class="form-step">
                <div class="card-body p-0">
                    <h2 class="font-normal">Account Basic Details</h2>
                    <div id="useradd-2" class="card">
                            <div class="card-header">
                                <h3 class="card-title"> {{__('System Settings')}}</h3>
                                <!-- <small class="text-muted">{{ __('Edit details about your Company') }}</small> -->
                                <div class="card-actions">
                                    <button class="button btn-navigate-form-step" type="button" id="nextbtn" step_number="2">Next</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        {{Form::label('site_currency',__('Currency *'),array('class' => 'form-label')) }}
                                        <select class="form-control site_currency" name="site_currency" id='site_currency'
                                                placeholder="Select Currecy" required>
                                            <option value="">{{ __('Select Currency ...') }}</option>
                                            @isset($currency)
                                            @foreach($currency as $key => $value)
                                                <option value="{{$value->id}}" @isset($settings['site_currency'])
                                                    @if($settings['site_currency']==$value->id) Selected @endif
                                                @endisset>{{$value->currency}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        <label id="site_currency-error" class="invalid-feedback" for="site_currency">This field is required.</label>
                                        <!-- {{ Form::text('site_currency', $settings['site_currency'], ['class' => 'form-control font-style', 'required', 'placeholder' => __('Enter Currency')]) }} -->
                                        <!-- <small> {{ __('Note: Add currency code as per three-letter ISO code.') }}<br>
                                            <a href="https://stripe.com/docs/currencies"
                                                target="_blank">{{ __('you can find out here..') }}</a></small> <br> -->
                                        @error('site_currency')
                                        <span class="invalid-site_currency" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        {{Form::label('site_currency_symbol',__('Currency Symbol '),array('class' => 'form-label')) }}
                                        <select class="form-control site_currency_symbol" name="site_currency_symbol" id='site_currency_symbol' disabled
                                                placeholder="Select Currecy" required>
                                            <option value=""></option>
                                            <!-- {{ __('Select Currency Symbol ...') }} -->
                                            @isset($currency)
                                            @foreach($currency as $key => $value)
                                                <option value="{{$value->id}}" @isset($settings['site_currency'])
                                                    @if($settings['site_currency']==$value->id) Selected @endif
                                                @endisset>{{$value->symbol}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        <!-- {{Form::text('site_currency_symbol',null,array('class'=>'form-control'))}} -->
                                        @error('site_currency_symbol')
                                        <span class="invalid-site_currency_symbol" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                            <label class="form-label" for="example3cols3Input">{{__('Currency Symbol Position')}}</label>
                                            <div class="row ms-1">
                                                <div class="form-check col-md-6">
                                                    <input class="form-check-input" type="radio" name="site_currency_symbol_position" value="pre" @if(@$settings['site_currency_symbol_position'] == 'pre') checked @endif
                                                    id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        {{__('Pre')}}
                                                    </label>
                                                </div>
                                                <div class="form-check col-md-6">
                                                    <input class="form-check-input" type="radio" name="site_currency_symbol_position" value="post" @if(@$settings['site_currency_symbol_position'] == 'post') checked @endif
                                                    id="flexCheckChecked">
                                                    <label class="form-check-label" for="flexCheckChecked">
                                                        {{__('Post')}}
                                                    </label>
                                                </div>

                                            </div>
                                        </div>
                                    <div class="form-group col-md-6">
                                        <label for="site_date_format" class="form-label">{{__('Date Format')}}</label>
                                        <select type="text" name="site_date_format" class="form-control selectric" id="site_date_format">
                                            <option value="M j, Y" @if(@$settings['site_date_format'] == 'M j, Y') selected="selected" @endif>M j, Y</option>
                                            <option value="d-m-Y" @if(@$settings['site_date_format'] == 'd-m-Y') selected="selected" @endif>d-m-y</option>
                                            <option value="m-d-Y" @if(@$settings['site_date_format'] == 'm-d-Y') selected="selected" @endif>m-d-y</option>
                                            <option value="Y-m-d" @if(@$settings['site_date_format'] == 'Y-m-d') selected="selected" @endif>y-m-d</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="site_time_format" class="form-label">{{__('Time Format')}}</label>
                                        <select type="text" name="site_time_format" class="form-control selectric" id="site_time_format">
                                            <option value="h:i A" @if(@$settings['site_time_format'] == 'h:i A') selected="selected" @endif>h:i A</option>
                                            <option value="h:i a" @if(@$settings['site_time_format'] == 'h:i a') selected="selected" @endif>h:i a</option>

                                            <option value="H:i" @if(@$settings['site_time_format'] == 'H:i') selected="selected" @endif>H:i</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        {{Form::label('invoice_prefix',__('Invoice Prefix'),array('class'=>'form-label')) }}

                                        {{Form::text('invoice_prefix',null,array('class'=>'form-control'))}}
                                        @error('invoice_prefix')
                                        <span class="invalid-invoice_prefix" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        {{Form::label('proposal_prefix',__('Proposal Prefix'),array('class'=>'form-label')) }}
                                        {{Form::text('proposal_prefix',null,array('class'=>'form-control'))}}
                                        @error('proposal_prefix')
                                        <span class="invalid-proposal_prefix" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        {{Form::label('employee_prefix',__('Employee Prefix'),array('class'=>'form-label')) }}
                                        {{Form::text('employee_prefix',null,array('class'=>'form-control'))}}
                                        @error('employee_prefix')
                                        <span class="invalid-employee_prefix" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        {{Form::label('purchase_prefix',__('Purchase Prefix'),array('class'=>'form-label')) }}
                                        {{Form::text('purchase_prefix',null,array('class'=>'form-control'))}}
                                        @error('purchase_prefix')
                                        <span class="invalid-purchase_prefix" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        {{Form::label('pos_prefix',__('Pos Prefix'),array('class'=>'form-label')) }}
                                        {{Form::text('pos_prefix',null,array('class'=>'form-control'))}}
                                        @error('pos_prefix')
                                            <span class="invalid-pos_prefix" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>


                                    <div class="form-group col-md-6">
                                        {{Form::label('bill_prefix',__('Bill Prefix'),array('class'=>'form-label')) }}
                                        {{Form::text('bill_prefix',null,array('class'=>'form-control'))}}
                                        @error('bill_prefix')
                                        <span class="invalid-bill_prefix" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        {{Form::label('customer_prefix',__('Customer Prefix'),array('class'=>'form-label')) }}
                                        {{Form::text('customer_prefix',null,array('class'=>'form-control'))}}
                                        @error('customer_prefix')
                                        <span class="invalid-customer_prefix" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        {{Form::label('vender_prefix',__('Vendor Prefix'),array('class'=>'form-label')) }}
                                        {{Form::text('vender_prefix',null,array('class'=>'form-control'))}}
                                        @error('vender_prefix')
                                        <span class="invalid-vender_prefix" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        {{Form::label('decimal_number',__('Decimal Number Format'),array('class'=>'form-label')) }}
                                        {{Form::number('decimal_number', null, ['class'=>'form-control'])}}
                                        @error('decimal_number')
                                        <span class="invalid-decimal_number" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        {{Form::label('journal_prefix',__('Journal Prefix'),array('class'=>'form-label')) }}
                                        {{Form::text('journal_prefix',null,array('class'=>'form-control'))}}
                                        @error('journal_prefix')
                                        <span class="invalid-journal_prefix" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                        @enderror
                                    </div>


                                    <!-- <div class="form-group col-md-6">
                                        <label class="form-label mb-0">{{__('App Site URL')}}</label> <br>
                                        <small>{{__("App Site URL to login app.")}}</small>
                                        {{ Form::text('currency',URL::to('/'), ['class' => 'form-control', 'placeholder' => __('Enter Currency'),'disabled'=>'true']) }}
                                    </div> -->

                                    <!-- <div class="form-group col-md-6">
                                        <label class="form-label mb-0">{{__('Tracking Interval')}}</label> <br>
                                        <small>{{__("Image Screenshort Take Interval time ( 1 = 1 min)")}}</small>
                                        {{ Form::number('interval_time',isset($settings['interval_time'])?$settings['interval_time']:'10', ['class' => 'form-control', 'placeholder' => __('Enter Tracking Interval')]) }}
                                    </div> -->



                                    <div class="form-group col-md-6">
                                        {{Form::label('shipping_display',__('Shipping Display in Proposal / Invoice / Bill ?'),array('class'=>'form-label')) }}
                                        <div class=" form-switch form-switch-left">
                                            <input type="checkbox" class="form-check-input mt-4" name="shipping_display" id="email_tempalte_13" {{($settings['shipping_display']=='on')?'checked':''}} >
                                            <label class="form-check-label" for="email_tempalte_13"></label>
                                        </div>

                                        @error('shipping_display')
                                        <span class="invalid-shipping_display" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        {{Form::label('footer_title',__('Invoice/Bill Footer Title'),array('class'=>'form-label')) }}
                                        {{Form::text('footer_title',null,array('class'=>'form-control'))}}
                                        @error('footer_title')
                                        <span class="invalid-footer_title" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        {{Form::label('footer_notes',__('Invoice/Bill Footer Notes'),array('class'=>'form-label')) }}
                                        {{Form::textarea('footer_notes', null, ['class'=>'form-control','rows'=>'3'])}}
                                        @error('footer_notes')
                                        <span class="invalid-footer_notes" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer text-end" style="display:none;">
                                <div class="form-group">
                                    <input class="btn btn-print-invoice btn-primary m-r-10" id="systemsetting" type="submit" value="{{__('Save Changes')}}">
                                </div>
                            </div>
                        </div>
                </div>
            </section>
            <section id="step-2" class="form-step d-none">
                <h2 class="font-normal">Personal Details</h2>
                <div id="useradd-3" class="card">
                        <div class="card-header">
                        <h3 class="card-title">{{ __('Company Setting') }}</h5>
                            <!-- <small class="text-muted">{{ __('Edit details about your Company') }}</small> -->
                            <div class="card-actions">
                                <button class="button btn-navigate-form-step" id="previous" type="button" step_number="1">Prev</button>
                                <!-- <button class="button submit-btn" type="button" id="savebtndummy">Save</button> -->
                                <button class="button submit-btn" type="submit"  id="savebtn">Save</button>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="form-group col-md-6">
                                    {{Form::label('company_name *',__('Company Name *'),array('class' => 'form-label')) }}
                                    {{Form::text('company_name',null,array('class'=>'form-control font-style'))}}
                                    @error('company_name')
                                    <span class="invalid-company_name" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('company_address',__('Address'),array('class' => 'form-label')) }}
                                    {{Form::text('company_address',null,array('class'=>'form-control font-style'))}}
                                    @error('company_address')
                                    <span class="invalid-company_address" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group  col-md-6">
                                    {{Form::label('company_country',__('Country *'),array('class' => 'form-label')) }}
                                    <select class="form-control country" name="company_country" id='company_country'
                                                placeholder="Select Country" required>
                                            <option value="">{{ __('Select Country ...') }}</option>
                                            @isset($country)
                                            @foreach($country as $key => $value)
                                                <option value="{{$value->iso2}}" @isset($settings['company_country'])
                                                    @if($settings['company_country']==$value->iso2) Selected @endif
                                                @endisset>{{$value->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    @error('company_country')
                                    <span class="invalid-company_country" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    {{Form::label('company_state',__('State *'),array('class' => 'form-label')) }}
                                    <select class="form-control " name="company_state" id='company_state'
                                            placeholder="Select State"  required>
                                        <option value="">{{ __('Select State ...') }}</option>
                                    </select>
                                    @error('company_state')
                                    <span class="invalid-company_state" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    {{Form::label('company_city',__('City'),array('class' => 'form-label')) }}
                                    {{Form::text('company_city',null,array('class'=>'form-control font-style'))}}
                                    @error('company_city')
                                    <span class="invalid-company_city" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('company_zipcode',__('Zip/Post Code'),array('class' => 'form-label')) }}
                                    {{Form::number('company_zipcode',null,array('class'=>'form-control'))}}
                                    @error('company_zipcode')
                                    <span class="invalid-company_zipcode" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    {{Form::label('company_telephone',__('Telephone'),array('class' => 'form-label')) }}
                                    {{Form::number('company_telephone',null,array('class'=>'form-control'))}}
                                    @error('company_telephone')
                                    <span class="invalid-company_telephone" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('company_email',__('System Email *'),array('class' => 'form-label')) }}
                                    {{Form::email('company_email',null,array('class'=>'form-control','required'=>'required','readonly'=>'true'))}}
                                    @error('company_email')
                                    <span class="invalid-company_email" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('company_email_from_name',__('Email (From Name) *'),array('class' => 'form-label')) }}
                                    {{Form::text('company_email_from_name',null,array('class'=>'form-control font-style'))}}
                                    @error('company_email_from_name')
                                    <span class="invalid-company_email_from_name" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('registration_number',__('Company Registration Number *'),array('class' => 'form-label')) }}
                                    {{Form::text('registration_number',null,array('class'=>'form-control'))}}
                                    @error('registration_number')
                                    <span class="invalid-registration_number" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>




                                <div class="form-group col-md-6">
                                    {{Form::label('company_start_time',__('Company Start Time *'),array('class' => 'form-label')) }}
                                    {{Form::time('company_start_time',null,array('class'=>'form-control'))}}
                                    @error('company_start_time')
                                    <span class="invalid-company_start_time" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    {{Form::label('company_end_time',__('Company End Time *'),array('class' => 'form-label')) }}
                                    {{Form::time('company_end_time',null,array('class'=>'form-control'))}}
                                    @error('company_end_time')
                                    <span class="invalid-company_end_time" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="row">
                                        <label class="form-check-label" id="gstvat" for="s">{{__('GSTVAT')}}
                                        <div class="col-md-12">
                                                <div class="form-check form-check-inline form-group mb-3">
                                                    <input type="radio" id="indiangst" name="indiangst" value="1" class="form-check-input" {{($settings['indiangst'] == '1')?'checked':''}} >
                                                    <label class="form-check-label" for="indiangst">{{__('Yes')}}</label>
                                                </div>
                                                    <div class="form-check form-check-inline form-group mb-3">
                                                    <input type="radio" id="indiangst1" name="indiangst" value="0" class="form-check-input" {{($settings['indiangst'] == '0')?'checked':''}}>
                                                    <label class="form-check-label" for="indiangst1">{{__('No')}}</label>
                                                </div>
                                        </div>
                                        {{-- <div class="col-md-6">

                                            </div> --}}
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                                <div class="form-check form-check-inline form-group mb-3">
                                                    <input type="radio" id="customRadio8" name="tax_type" disabled="$settings['indiangst'] == '1'?false:true" value="VAT" class="form-check-input" {{($settings['tax_type'] == 'VAT')?'checked':''}} >
                                                    <label class="form-check-label" for="customRadio8">{{__('VAT Number')}}</label>
                                                </div>
                                            </div>
                                        <div class="col-md-6">
                                                <div class="form-check form-check-inline form-group mb-3">
                                                    <input type="radio" id="customRadio7" name="tax_type" disabled="$settings['indiangst'] == '1'?false:true" value="GST" class="form-check-input" {{($settings['tax_type'] == 'GST')?'checked':''}}>
                                                    <label class="form-check-label" for="customRadio7">{{__('GST Number')}}</label>
                                                </div>
                                            </div>
                                    </div>
                                    {{Form::text('vat_number',null,array('id'=>'vat_number','class'=>'form-control','disabled'=>true,'placeholder'=>__('Enter VAT / GST Number')))}}
                                </div>
                                <div class="form-group col-md-6 mt-2">
                                    {{Form::label('timezone',__('Timezone *'),array('class' => 'form-label'))}}
                                    <select type="text" name="timezone" class="form-control custom-select" id="timezone">
                                        <option value="">{{__('Select Timezone')}}</option>
                                        @foreach($timezones as $k=>$timezone)
                                            <option value="{{$k}}" {{(env('TIMEZONE')==$k)?'selected':''}}>{{$timezone}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <div class="form-group col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                                <div class="form-check form-check-inline form-group mb-3">
                                                    <input type="radio" id="indiangst" name="indiangst" value="1" class="form-check-input" {{($settings['indiangst'] == '1')?'checked':''}}>
                                                    <label class="form-check-label" for="customRadio7">{{__('Indiangst')}}</label>
                                                </div>
                                            </div>
                                    </div>
                                </div> --}}

                            </div>

                        </div>
                        <div class="card-footer text-end" style="display:none;">
                            <div class="form-group">
                                <input class="btn btn-print-invoice btn-primary m-r-10" id="companysettings" type="submit" value="{{__('Save Changes')}}">
                            </div>
                        </div>


                    </div>

            </section>
        {{Form::close()}}
        </div>
    </div>
</div>

  </div>
</div>
<div>
<script src="{{ asset('js/jquery.validate.js') }}"></script>

<script>
$('#nextbtn').click(function(){
//   alert("The paragraph was clicked.");
  var site_currency=document.getElementById("site_currency");
  if(site_currency.value==''){
    $('#site_currency-error').css("display","block");
  }else{
    navigateToFormStep(2);
  }

});

$().ready(function() {
$('#company_form').validate({
    rules: {
        company_name:{
                required:true,
        },
        company_country:{
            required:true,
        },
        company_state:{
            required:true,
        },
        company_email:{
            required:true,
        },
        company_email_from_name:{
            required:true,
        },
        registration_number:{
            required:true
        },
        timezone:{
            required:true
        }
    },
   
    submitHandler: function(form) {
        form.submit();
    }
});

});


    window.addEventListener("DOMContentLoaded", (event) => {
    var site_currency=document.getElementById("site_currency");
    var site_currency_symbol=document.getElementById("site_currency_symbol");
        // if(site_currency.value=='' || site_currency_symbol.value==''){
        //     document.getElementById("nextbtn").disabled = true;
        // }else{
        //     document.getElementById("nextbtn").disabled = false;
        // }
    });
    site_currency.addEventListener('change', (event) => {
        $('#site_currency-error').css("display","none");
        site_currency_symbol.value=site_currency.value;
        // if(site_currency.value=='' || site_currency_symbol.value==''){
        //     document.getElementById("nextbtn").disabled = true;
        // }else{
        //     document.getElementById("nextbtn").disabled = false;
        // }
    });
    site_currency_symbol.addEventListener('change', (event) => {
        if(site_currency.value=='' || site_currency_symbol.value==''){
            document.getElementById("nextbtn").disabled = true;
        }else{
            document.getElementById("nextbtn").disabled = false;
        }
    });
    const navigateToFormStep = (stepNumber) => {
        document.querySelectorAll(".form-step").forEach((formStepElement) => {
            formStepElement.classList.add("d-none");
        });
        document.querySelectorAll(".form-stepper-list").forEach((formStepHeader) => {
            formStepHeader.classList.add("form-stepper-unfinished");
            formStepHeader.classList.remove("form-stepper-active", "form-stepper-completed");
        });
        document.querySelector("#step-" + stepNumber).classList.remove("d-none");

        const formStepCircle = document.querySelector('li[step="' + stepNumber + '"]');
        formStepCircle.classList.remove("form-stepper-unfinished", "form-stepper-completed");
        formStepCircle.classList.add("form-stepper-active");
        for (let index = 0; index < stepNumber; index++) {
            const formStepCircle = document.querySelector('li[step="' + index + '"]');
            if (formStepCircle) {
                formStepCircle.classList.remove("form-stepper-unfinished", "form-stepper-active");
                formStepCircle.classList.add("form-stepper-completed");
            }
        }
    };
    document.querySelectorAll("#previous").forEach((formNavigationBtn) => {
        formNavigationBtn.addEventListener("click", () => {
             const stepNumber = parseInt(formNavigationBtn.getAttribute("step_number"));
            navigateToFormStep(stepNumber);
        });
    });
    // $('#savebtn').click(function(){
    //     $('#settings_form').submit();
    //     $('#company_form').submit();


    // });
</script>
<style>
    .form-switch {
    height: 0px !important;
    padding-left: 2.5rem;
    margin-top: -23px;
}
    .bottombutton{
        text-align:center;
    }
    h1 {
        text-align: center;
    }

    h2 {
        margin: 0;
    }

    #multi-step-form-container {
        margin-top: 5rem;
    }

    .text-center {
        text-align: center;
    }

    .mx-auto {
        margin-left: auto;
        margin-right: auto;
    }

    .pl-0 {
        padding-left: 0;
    }

    .button {
        padding: 0.7rem 1.5rem;
        border: 1px solid #4361ee;
        background-color: #4361ee;
        color: #fff;
        border-radius: 5px;
        cursor: pointer;
    }

    .submit-btn {
        border: 1px solid #6fd943;
        background-color: #6fd943;
    }

    .mt-3 {
        margin-top: 2rem;
    }

    .d-none {
        display: none;
    }

    .form-step {
        /* border: 1px solid rgba(0, 0, 0, 0.1); */
        border-radius: 20px;
        padding: 3rem;
        padding-top:0px;
    }

    .font-normal {
        font-weight: normal;
    }

    ul.form-stepper {
        counter-reset: section;
        /* margin-bottom: 3rem; */
    }

    ul.form-stepper .form-stepper-circle {
        position: relative;
    }

    ul.form-stepper .form-stepper-circle span {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translateY(-50%) translateX(-50%);
    }

    .form-stepper-horizontal {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
    }

    ul.form-stepper>li:not(:last-of-type) {
        margin-bottom: 0.625rem;
        -webkit-transition: margin-bottom 0.4s;
        -o-transition: margin-bottom 0.4s;
        transition: margin-bottom 0.4s;
    }

    .form-stepper-horizontal>li:not(:last-of-type) {
        margin-bottom: 0 !important;
    }

    .form-stepper-horizontal li {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-flex: 1;
        -ms-flex: 1;
        flex: 1;
        -webkit-box-align: start;
        -ms-flex-align: start;
        align-items: start;
        -webkit-transition: 0.5s;
        transition: 0.5s;
    }

    .form-stepper-horizontal li:not(:last-child):after {
        position: relative;
        -webkit-box-flex: 1;
        -ms-flex: 1;
        flex: 1;
        height: 1px;
        content: "";
        top: 32%;
    }

    .form-stepper-horizontal li:after {
        background-color: #dee2e6;
    }

    .form-stepper-horizontal li.form-stepper-completed:after {
        background-color: #4da3ff;
    }

    .form-stepper-horizontal li:last-child {
        flex: unset;
    }

    ul.form-stepper li a .form-stepper-circle {
        display: inline-block;
        width: 40px;
        height: 40px;
        margin-right: 0;
        line-height: 1.7rem;
        text-align: center;
        background: rgba(0, 0, 0, 0.38);
        border-radius: 50%;
    }

    .form-stepper .form-stepper-active .form-stepper-circle {
        background-color: #4361ee !important;
        color: #fff;
    }

    .form-stepper .form-stepper-active .label {
        color: #4361ee !important;
    }

    .form-stepper .form-stepper-active .form-stepper-circle:hover {
        background-color: #4361ee !important;
        color: #fff !important;
    }

    .form-stepper .form-stepper-unfinished .form-stepper-circle {
        background-color: #f8f7ff;
    }

    .form-stepper .form-stepper-completed .form-stepper-circle {
        background-color: #6fd943 !important;
        color: #fff;
    }

    .form-stepper .form-stepper-completed .label {
        color: #6fd943 !important;
    }

    .form-stepper .form-stepper-completed .form-stepper-circle:hover {
        background-color: #6fd943 !important;
        color: #fff !important;
    }

    .form-stepper .form-stepper-active span.text-muted {
        color: #fff !important;
    }

    .form-stepper .form-stepper-completed span.text-muted {
        color: #fff !important;
    }

    .form-stepper .label {
        font-size: 1rem;
        margin-top: 0.5rem;
    }

    .form-stepper a {
        cursor: default;
    }
    @media screen and (max-width:767px) {
        .form-step {
            padding: 0.5rem;
        }
        .form-switch {
            height: unset !important;
            padding-left: 2.5rem;
            margin-top: -16px;
        }
        #step-2 .card-actions {
            width: 80%;
        }
        #step-2 .card-header {
            display: block;
        }
        #step-2 .card-actions button {
            margin: 3px;
        }
        #step-2 .card-actions {
            /* width: 80%; */
            margin-top: 10px;
            align-items: flex-end;
            display: flex;
            justify-content: flex-end;
        }

    }
    #site_currency-error{
        display:none;
    }
    label#gstvat {
        font-weight: var(--tblr-font-weight-medium);
    }
    .col-md-12 {
        font-weight: normal;
    }
</style>
<script>
$('#indiangst').change(function () {
    $('#customRadio8').attr("disabled",false);
    $('#customRadio7').attr("disabled",false);
    $('#vat_number').attr("disabled",false);

});
$('#indiangst1').change(function () {
    $('#customRadio8').attr("disabled",true);
    $('#customRadio7').attr("disabled",true);
    $('#vat_number').attr("disabled",true);
    $('#customRadio8').prop("checked",false);
    $('#customRadio7').prop("checked",false);
    $('#vat_number').prop("value","");
});
</script>
