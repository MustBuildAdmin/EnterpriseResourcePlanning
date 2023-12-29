@if(\Auth::user()->type == 'super admin')
    @php $url='subcontractor.update' @endphp
@else
    @php $url='subcontractor.update_subcontractor' @endphp
@endif
{{ Form::model($vender, array('route' => array($url, $vender->id) , 'method' => 'PUT',
'enctype'=>"multipart/form-data")) }}
<style>
    .tax_number, .billing_phone, .billing_zip, .shipping_zip, .shipping_phone, .shipping_address,
     .billing_city, .shipping_city,.billing_address {
        margin-top : 15px;
    }
    .billing_address_title, .shipping_address_title {
        margin-top : 15px;
    }
    input#update_subcontractor1 {
    display: none;
}
</style>
<div class="modal-body">
    <h3 class="sub-title">{{__('Basic Info')}}</h3>
    <div class="row">
        @if ($vender->color_code!=null || $vender->color_code!='')
            @php $colorcor = $vender->color_code; @endphp
        @else
            @php $colorcor = $colorco; @endphp
        @endif

        <input type="hidden" name="color_code" value="{{ $colorcor }}">
        <input type="hidden" name="password" value="{{$vender->password}}">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    <span><i class="ti ti-address-card"></i></span>
                    {{ Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) }}
                    {{ Form::hidden('email', null, ['class' => 'form-control', 'required' => 'required']) }}
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{Form::label('lnamelabel',__('Last Name'),array('class'=>'form-label')) }}
                <span style='color:red;'>*</span>
                <div class="form-icon-user">
                    {{Form::text('lname',null,array('class'=>'form-control','required'=>'required',
                    'placeholder'=>'Last Name'))}}
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-4 col-sm-6 country_code">
            <div class="form-group">
                {{Form::label('contact',__('Contact'),array('class'=>'form-label')) }}
                <span style='color:red;'>*</span>
                <div class="form-icon-user">
                    <input class="form-control" name="phone" type="tel" id="phone"
                    maxlength="16" placeholder="+91 111 111 1111"  required>
                    <span class="invalid-name mobile_duplicate_error" role="alert" style="display: none;">
                        <span class="text-danger">{{__('Mobile Number Already Exist!')}}</span>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{ Form::label('tax_number', __('Tax Number'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    <span><i class="ti ti-crosshairs"></i></span>
                    {{ Form::text('tax_number', null, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>

        <div class="form-group col-md-6">
            <div class="form-group">
                {{Form::label('avatar',__('Profile Image'),array('class'=>'form-label')) }}
                <div class="form-icon-user">
                    <input type="file" class="form-control document_setup" id="avatar"  name="avatar"
                     accept="image/*, .png, .jpeg, .jpg">
                </div>
                <span class="show_document_error" style="color:red;"></span>
            </div>
        </div>

        @if (!$customFields->isEmpty())
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                    @include('customFields.formBuilder')
                </div>
            </div>
        @endif
    </div>

    <h3 class="sub-title billing_address_title">{{__('Billing Address')}}</h3>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{ Form::label('billing_name', __('Name'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {{ Form::text('billing_name', null, ['id'=>'billings_name',
                    'class' => 'form-control']) }}
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{ Form::label('billing_country', __('Country'), ['class' => 'form-label']) }}
                <select class="form-control country" name="billing_country" id='billing_country'
                    placeholder="Select Country">
                    <option value="">{{ __('Select Country ...') }}</option>
                    @foreach ($countrylist as $key => $value)
                        <option value="{{ $value->iso2 }}"
                            @if ($vender->billing_country == $value->iso2) selected @endif>
                            {{ $value->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{ Form::label('billing_state', __('State'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    <select class="form-control country" name="billing_state" id='billing_state'
                        placeholder="Select State">
                        <option value="">{{ __('Select State ...') }}</option>
                        @foreach ($statelist as $key => $value)
                            <option value="{{ $value->iso2 }}"
                                @if ($vender->billing_state == $value->iso2) selected @endif>
                                {{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{ Form::label('billing_city', __('City'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {{ Form::text('billing_city', null, ['class' => 'form-control',
                    'id'=>'billing_city',
                    'required' => 'required','oninput'=>'process(this)']) }}
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-4 col-sm-6 country_code">
            <div class="form-group">
                {{Form::label('billing_phone',__('Phone'),array('class'=>'form-label')) }}
                <span style='color:red;'>*</span>
                <div class="form-icon-user">
                    <input class="form-control" name="billing_phone" type="tel" id="billing_phone"
                     maxlength="16" placeholder="+91 111 111 1111"  required>
                    <span class="invalid-name billing_duplicate" role="alert" style="display: none;">
                        <span class="text-danger">{{__('Mobile Number Already Exist!')}}</span>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{ Form::label('billing_zip', __('Zip Code'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {{ Form::text('billing_zip', null, ['class' => 'form-control billings_zip',
                    'placeholder' => __('Enter User Email')]) }}
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group billing_address">
                {{ Form::label('billing_address', __('Address'), ['class' => 'form-label']) }}
                <span style='color:red;'>*</span>
                {{ Form::textarea('billing_address', null, ['class' => 'form-control',
                'id'=>'billing_address','rows' => 3]) }}
            </div>
        </div>
    </div>

    <div class="custom-control custom-checkbox mt-n1">
        <input type="checkbox" name="copy_status" class="custom-control-input checkbox1" id="checkbox1" value="1">
        <label class="custom-control-label" for="checkbox1">
            <h6 class="sub-title">
                <strong>Do you copy a billing address<strong>
            </h6>
        </label>
    </div>

    @if(App\Models\Utility::getValByName('shipping_display')=='on')
        <div class="col-md-12 text-end">
        </div>
        <h3 class="sub-title shipping_address_title">{{__('Shipping Address')}}</h3>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="form-group">
                    {{ Form::label('shipping_name', __('Name'), ['class' => 'form-label']) }}
                    <div class="form-icon-user">
                        {{ Form::text('shipping_name', null, ['id'=>'shipping_name',
                        'class' => 'form-control']) }}
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="form-group">
                    {{ Form::label('shipping_country', __('Country'), ['class' => 'form-label']) }}
                    <div class="form-icon-user">
                        <select class="form-control" name="shipping_country" id='shipping_country'
                            placeholder="Select Country">
                            <option value="">{{ __('Select Country ...') }}</option>
                            @foreach ($countrylist as $key => $value)
                                <option value="{{ $value->iso2 }}"
                                    @isset($vender->shipping_country)
                                    @if ($vender->shipping_country == $value->iso2) selected @endif @endisset>
                                    {{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="form-group">
                    {{ Form::label('shipping_state', __('State'), ['class' => 'form-label']) }}
                    <div class="form-icon-user">
                        <select class="form-control " name="shipping_state" id='shipping_state'
                            placeholder="Select Country">
                            <option value="">{{ __('Select State ...') }}</option>
                            @foreach ($sellerstatelist as $key => $value)
                                <option value="{{ $value->iso2 }}"
                                     @if ($vender->shipping_state == $value->iso2) selected @endif>
                                    {{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="form-group">
                    {{ Form::label('shipping_city', __('City'), ['class' => 'form-label']) }}
                    <div class="form-icon-user">
                        {{ Form::text('shipping_city', null, ['class' => 'form-control',
                        'id'=>'shipping_city',
                        'required' => 'required','oninput'=>'process(this)']) }}
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 country_code">
                <div class="form-group">
                    {{Form::label('shipping_phone',__('Phone'),array('class'=>'form-label')) }}
                    <span style='color:red;'>*</span>
                    <div class="form-icon-user">
                        <input class="form-control" name="shipping_phone" type="tel" id="shipping_phone"
                        maxlength="16" placeholder="+91 111 111 1111"  required>
                        <span class="invalid-name shipping_mobile_duplicate" role="alert" style="display: none;">
                            <span class="text-danger">{{__('Mobile Number Already Exist!')}}</span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="form-group">
                    {{ Form::label('shipping_zip', __('Zip Code'), ['class' => 'form-label']) }}
                    <div class="form-icon-user">
                        {{ Form::text('shipping_zip', null, ['class' => 'form-control shippings_zip',
                        'placeholder' => __('Enter User Email')]) }}
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group shipping_address">
                    {{Form::label('shipping_address',__('Address'),array('class'=>'form-label')) }}
                    <div class="input-group">
                        {{ Form::textarea('shipping_address', null, ['class' => 'form-control',
                        'id'=>'shipping_address','rows' => 3]) }}
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="button" value="{{__('Update')}}" class="btn btn-primary" id="update_subcontractor">
    <input type="submit" value="{{__('Update')}}" class="btn btn-primary" id="update_subcontractor1">
</div>
{{Form::close()}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"
    integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC" crossorigin="anonymous">
</script>

<script>

var phone_number = window.intlTelInput(document.querySelector("#phone"), {
    separateDialCode: true,
    preferredCountries:["in"],
    hiddenInput: "phone_country",
    utilsScript:"{{ asset('assets/phonepicker/js/utils.js') }}"
});
var billing_phone_number = window.intlTelInput(document.querySelector("#billing_phone"), {
    separateDialCode: true,
    preferredCountries:["in"],
    hiddenInput: "billing_phone_country",
    utilsScript:"{{ asset('assets/phonepicker/js/utils.js') }}"
});
var shipping_phone_number=window.intlTelInput(document.querySelector("#shipping_phone"), {
    separateDialCode: true,
    preferredCountries:["in"],
    hiddenInput: "shipping_phone_country",
    utilsScript:"{{ asset('assets/phonepicker/js/utils.js') }}"
});

$('input#update_subcontractor').click(function(){
    $("#phone").val(phone_number.getNumber(intlTelInputUtils.numberFormat.E164));
    $("#billing_phone").val(billing_phone_number.getNumber(intlTelInputUtils.numberFormat.E164));
    $("#shipping_phone").val(shipping_phone_number.getNumber(intlTelInputUtils.numberFormat.E164));
    $('input#update_subcontractor1').click()

});
    $(document).on("change", '#billing_country', function () {
        var name=$(this).val();
        var settings = {
            "url": "https://api.countrystatecity.in/v1/countries/"+name+"/states",
            "method": "GET",
            "headers": {
                "X-CSCAPI-KEY": '{{ env('Locationapi_key') }}'
            },
        };
    
        $.ajax(settings).done(function (response) {
            $('#billing_state').empty();
            $('#billing_state').append('<option value="">{{__('Select State ...')}}</option>');
            $.each(response, function (key, value) {
                $('#billing_state').append('<option value="' + value.iso2 + '">' + value.name + '</option>');
            });
        });
    });
    
    $(document).on("change", '#shipping_country', function () {
        var name=$(this).val();
        var settings = {
            "url": "https://api.countrystatecity.in/v1/countries/"+name+"/states",
            "method": "GET",
            "headers": {
                "X-CSCAPI-KEY": '{{ env('Locationapi_key') }}'
            },
        };
    
        $.ajax(settings).done(function (response) {
            $('#shipping_state').empty();
            $('#shipping_state').append('<option value="">{{__('Select State ...')}}</option>');
            $.each(response, function (key, value) {
                $('#shipping_state').append('<option value="' + value.iso2 + '">' + value.name + '</option>');
            });
        });
    });

    $(document).ready(function() {
        console.log(("{{$vender->billing_phone}}","dfsd"))
        billing_phone_number.setNumber("{{$vender->billing_phone}}");
        shipping_phone_number.setNumber("{{$vender->shipping_phone}}");
        phone_number.setNumber("{{$vender->phone}}");
        $(document).on('submit', 'form', function() {
            $('#update_subcontractor').attr('disabled', 'disabled');
        });

        $(document).on("paste", '#zip', function (event) {
            if (event.originalEvent.clipboardData.getData('Text').match(/[^\d]/)) {
                event.preventDefault();
            }
        });

        $(document).on("keypress", '#zip', function (event) {
            if(event.which < 48 || event.which >58){
                return false;
            }
        });
    });

    $(document).on("change", ".checkbox1", function () {
        var $this = $(this).parent().parent();

        if (this.checked) {
            $this.find('#shipping_name').val($this.find('#billings_name').val());
            $this.find('#shipping_city').val($this.find('#billing_city').val());
            $this.find('#shipping_phone').val($this.find('#billing_phone').val());
            shipping_phone_number.setCountry(billing_phone_number.getSelectedCountryData().iso2);
            $this.find('.shippings_zip').val($this.find('.billings_zip').val());
            $this.find('#shipping_address').val($this.find('#billing_address').val());
            $this.find('#shipping_country').val($this.find('#billing_country').val());

            $this.find('#shipping_name').prop('disabled',true);
            $this.find('#shipping_city').prop('disabled',true);
            $this.find('#shipping_phone').prop('disabled',true);
            $this.find('.shippings_zip').prop('disabled',true);
            $this.find('#shipping_address').prop('disabled',true);
            $this.find('#shipping_country').prop('disabled',true);
            $this.find('#shipping_state').prop('disabled',true);

            var name=$this.find('#shipping_country').val();
            var settings = {
                "url": "https://api.countrystatecity.in/v1/countries/"+name+"/states",
                "method": "GET",
                "headers": {
                    "X-CSCAPI-KEY": '{{ env('Locationapi_key') }}'
                },
            };
    
            $.ajax(settings).done(function (response) {
                $('#shipping_state').empty();
                $('#shipping_state').append('<option value="">{{__('Select State ...')}}</option>');
                $.each(response, function (key, value) {
                    $('#shipping_state').append('<option value="' + value.iso2 + '">' + value.name + '</option>');
                });
            });
            setTimeout(function(){   $this.find('#shipping_state').val($this.find('#billing_state').val()); }, 1700);
        }
        else {
            $this.find('#shipping_name').val("");
            $this.find('#shipping_city').val("");
            $this.find('#shipping_phone').val("");
            $this.find('.shippings_zip').val("");
            $this.find('#shipping_address').val("");
            $this.find('#shipping_country').val("");
            setTimeout(function() {$this.find('#shipping_state').val(""); }, 100);
            $this.find('#shipping_name').prop('disabled',false);
            $this.find('#shipping_city').prop('disabled',false);
            $this.find('#shipping_phone').prop('disabled',false);
            $this.find('.shippings_zip').prop('disabled',false);
            $this.find('#shipping_address').prop('disabled',false);
            $this.find('#shipping_country').prop('disabled',false);
            $this.find('#shipping_state').prop('disabled',false);
        }
    });

    function process(input){
        let value = input.value;
        let numbers = value.replace(/[^a-zA-Z]/g, "");
        input.value = numbers;
    }

    function numeric(input){
        let value = input.value;
        let numbers = value.replace(/[^0-9]/g, "");
        input.value = numbers;
    }
</script>
