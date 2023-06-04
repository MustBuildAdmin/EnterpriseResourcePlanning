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
                            {{Form::model($settings,array('route'=>'company.settingssave','method'=>'post'))}}
                        <div class="card-body">

                            <div class="row">
                                <div class="form-group col-md-6">
                                    {{Form::label('company_name *',__('Company Name *'),array('class' => 'form-label')) }}
                                    {{Form::text('company_name',null,array('class'=>'form-control font-style','maxlength'=>60,'minlength'=>3))}}
                                    @error('company_name')
                                    <span class="invalid-company_name" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('company_address',__('Address'),array('class' => 'form-label')) }}
                                    {{Form::text('company_address',null,array('class'=>'form-control font-style','readonly'))}}
                                    @error('company_address')
                                    <span class="invalid-company_address" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group  col-md-6">
                                    {{Form::label('company_country',__('Country'),array('class' => 'form-label')) }}
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
                                    {{Form::label('company_state',__('State'),array('class' => 'form-label')) }}
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
                                    {{Form::text('company_city',null,array('class'=>'form-control font-style','maxlength'=>60,'minlength'=>3))}}
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
                                    {{Form::number('company_telephone',null,array('class'=>'form-control','readonly'))}}
                                    @error('company_telephone')
                                    <span class="invalid-company_telephone" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('company_email',__('System Email *'),array('class' => 'form-label')) }}
                                    {{Form::email('company_email',null,array('class'=>'form-control','required'=>'required','readonly'))}}
                                    @error('company_email')
                                    <span class="invalid-company_email" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('company_email_from_name',__('Email (From Name) *'),array('class' => 'form-label')) }}
                                    {{Form::text('company_email_from_name',null,array('class'=>'form-control font-style','readonly'))}}
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
                                        <div class="col-md-6">
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
                                <div class="form-group col-md-6 mt-2">
                                    {{Form::label('timezone',__('Timezone'),array('class' => 'form-label'))}}
                                    <select type="text" name="timezone" class="form-control custom-select" id="timezone" disabled>
                                        <option value="">{{__('Select Timezone')}}</option>
                                        @foreach($timezones as $k=>$timezone)
                                            <option value="{{$k}}" {{($settings['timezone']==$k)?'selected':''}}>{{$timezone}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                        </div>
                        <div class="card-footer text-end">
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
@include('new_layouts.footer')
<script type="text/javascript">
 $(document).on("change", '#company_country', function () {
    console.log("testongsdfsdfs")
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
<style>
.emailtemplates {
    display: flex;
    flex-direction: row;
    justify-content:space-between;
}
.email-template-checkbox{
    margin-left:0px !important;
}
.emaildiv {
    margin-bottom: 10px;
}
.col-md-6{
    margin-bottom:5px;
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
document.addEventListener("DOMContentLoaded", (event) => {
    var value=$('input[name="indiangst"]:checked').val();
    if(value=='1'){
        $('#customRadio8').attr("disabled",false);
        $('#customRadio7').attr("disabled",false);
        $('#vat_number').attr("disabled",false);
    }else{
        $('#customRadio8').attr("disabled",true);
        $('#customRadio7').attr("disabled",true);
        $('#vat_number').attr("disabled",true);
        $('#customRadio8').prop("checked",false);
        $('#customRadio7').prop("checked",false);
        $('#vat_number').prop("value","");
    }
});
</script>