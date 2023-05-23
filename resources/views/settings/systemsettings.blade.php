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
<style>
.card-footer.text-center {
    background: none;
}
</style>
@include('new_layouts.header')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                        {{ __('Admin Settings') }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <div class="card">
                    <div class="row g-0">
                    @include('new_layouts.sidebar')
                        <div class="col d-flex flex-column">
                            <div class="card-body">
                            
                        {{Form::model($settings,array('route'=>'system.settings','method'=>'post'))}}
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
                                        {{-- <select class="form-control site_currency_symbol" name="site_currency_symbol" id='site_currency_symbol'
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
                                        </select> --}}
                                        {{Form::text('site_currency_symbol',null,array('class'=>'form-control'))}}
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

                                <div class="form-group col-md-6">
                                        {{Form::label('employee_prefix',__('Employee Prefix'),array('class'=>'form-label')) }}
                                        {{Form::text('employee_prefix',null,array('class'=>'form-control'))}}
                                        @error('employee_prefix')
                                        <span class="invalid-employee_prefix" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                        @enderror
                                    </div>


                                <div class="form-group col-md-6 shipping_display_invoice">
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

                                <!-- <div class="form-group col-md-6">
                                    <label class="form-label mb-0">{{__('App Site URL')}}</label> <br>
                                    <small>{{__("App Site URL to login app.")}}</small>
                                    {{ Form::text('currency',URL::to('/'), ['class' => 'form-control', 'placeholder' => __('Enter Currency'),'disabled'=>'true']) }}
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-label mb-0">{{__('Tracking Interval')}}</label> <br>
                                    <small>{{__("Image Screenshort Take Interval time ( 1 = 1 min)")}}</small>
                                    {{ Form::number('interval_time',isset($settings['interval_time'])?$settings['interval_time']:'10', ['class' => 'form-control', 'placeholder' => __('Enter Tracking Interval')]) }}
                                </div> -->

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
                        <div class="card-footer text-center">
                            <div class="form-group">
                                <input class="btn btn-print-invoice btn-primary m-r-10" type="submit" value="{{__('Save Changes')}}">
                            </div>
                        </div>
                        {{Form::close()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
// var site_currency=document.getElementById("site_currency");
//     var site_currency_symbol=document.getElementById("site_currency_symbol");
// site_currency.addEventListener('change', (event) => {
//     site_currency_symbol.value=site_currency.value;
   
// });
</script>
@include('new_layouts.footer')
<style>
.col-md-6{
    margin-bottom:5px;
}
.form-switch.form-switch-left {
    position: relative;
    bottom: 5px;
}
.shipping_display_invoice {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}
.shipping_display_invoice label {
    align-items: center;
    position: relative;
    display: flex;
    margin-top: 12px;
}
</style>