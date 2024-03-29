{{Form::open(array('url'=>"subcontractorstore",'method'=>'post','id'=>'subcontractorCreate'))}}
<style>
    .tax_number, .billing_phone, .billing_zip, .shipping_zip, .shipping_phone, .shipping_address, .billing_city, .shipping_city, 
    .billing_address {
        margin-top : 15px;
    }
    .billing_address_title, .shipping_address_title {
        margin-top : 15px;
    }
</style>
<div class="modal-body">
    <h3 class="sub-title">{{__('Basic Info')}}</h3>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6">
            @php
                $rndColor = Utility::rndRGBColorCode(); #function call
                $password = Utility::randomPassword(); #function call
            @endphp
            
            <input type="hidden" name="color_code" value="{{ $rndColor }}">
            <input type="hidden" name="password" value="{{ $password }}">

            <div class="form-group">
                {{Form::label('name',__('Name'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                {{Form::text('name',null,array('class'=>'form-control','required'=>'required', 'placeholder'=>'Name'))}}
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{Form::label('contact',__('Contact'),['class'=>'form-label'])}}<span style='color:red;'>*</span>
                <div class="form-icon-user">
                    {{Form::text('contact',null,array('id'=>'phone','class'=>'form-control',
                    'Placeholder'=>'(00) 0000-0000','required'=>'required','maxlength' => 16,
                    'oninput'=>"numeric(this)",'data-mask'=>"(00) 0000-0000",'data-mask-visible'=>"true"))}}

                    <span class="invalid-name mobile_duplicate_error" role="alert" style="display: none;">
                        <span class="text-danger">{{__('Mobile Number Already Exist!')}}</span>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{Form::label('email',__('Email'),['class'=>'form-label'])}}<span style='color:red;'>*</span>
                {{Form::text('email',null,array('id'=>'email','class'=>'form-control','required'=>'required',
                'placeholder'=>'Email'))}}
                <span class="invalid-name email_duplicate_error" role="alert" style="display: none;">
                    <span class="text-danger">{{__('Email Already Exist!')}}</span>
                </span>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group tax_number">
                {{Form::label('tax_number',__('Tax Number'),['class'=>'form-label'])}}<span style='color:red;'>*</span>
                {{Form::number('tax_number',null,array('class'=>'form-control','maxlength'=>'20','required'=>'required',
                'placeholder'=>'Tax number'))}}
            </div>
        </div>
        @if(!$customFields->isEmpty())
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
                {{Form::label('billing_name',__('Name'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                {{Form::text('billing_name',null,array('class'=>'form-control','required'=>'required', 'placeholder'=>'Name'))}}
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{Form::label('billing_country',__('Country'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                <select class="form-control country" name="billing_country" id='billing_country'
                            placeholder="Select Country" required>
                        <option value="">{{ __('Select Country ...') }}</option>
                        @foreach($country as $key => $value)
                            <option value="{{$value->iso2}}">{{$value->name}}</option>
                        @endforeach
                </select>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{Form::label('billing_state',__('State'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                <div class="form-icon-user">
                    <select class="form-control country" name="billing_state" id='billing_state'
                            placeholder="Select State" required>
                        <option value="">{{ __('Select State ...') }}</option>
                    </select>
                </div>

            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group billing_city">
                {{Form::label('billing_city',__('City'),array('class'=>'form-label')) }}
                <span style='color:red;'>*</span>
                <div class="form-icon-user">
                    {{Form::text('billing_city',null,array('class'=>'form-control','required'=>'required',
                    'placeholder'=>'City','oninput'=>'process(this)'))}}
                </div>

            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group billing_phone">
                {{Form::label('billing_phone',__('Phone'),array('class'=>'form-label')) }}
                <span style='color:red;'>*</span>
                {{Form::text('billing_phone',null,array('class'=>'form-control',
                'Placeholder'=>'(00) 0000-0000','maxlength' => 16,'required'=>'required',
                'oninput'=>"numeric(this)",'data-mask'=>"(00) 0000-0000",'data-mask-visible'=>"true"))}}
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group billing_zip">
                {{Form::label('billing_zip',__('Zip Code'),array('class'=>'form-label')) }}
                <span style='color:red;'>*</span>
                {{Form::text('billing_zip',null,array('id'=> 'zip','class'=>'form-control','required'=>'required',
                'placeholder'=>'Zipcode'))}}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group billing_address">
                {{Form::label('billing_address',__('Address'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                {{Form::textarea('billing_address',null,array('class'=>'form-control','rows'=>3,'required'=>'required', 'placeholder'=>'Address'))}}
            </div>
        </div>
    </div>

    @if(App\Models\Utility::getValByName('shipping_display')=='on')
        <div class="col-md-12 text-end">
            {{-- <input type="button" id="billing_data" value="{{__('Shipping Same As Billing')}}" class="btn btn-primary"> --}}
        </div>
        <h3 class="sub-title shipping_address_title">{{__('Shipping Address')}}</h3>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="form-group">
                    {{Form::label('shipping_name',__('Name'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                    {{Form::text('shipping_name',null,array('class'=>'form-control','required'=>'required', 'placeholder'=>'Name'))}}
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="form-group">
                    {{Form::label('shipping_country',__('Country'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                    <div class="form-icon-user">
                        <select class="form-control country" name="shipping_country" id='shipping_country'
                                placeholder="Select Country" required>
                                <option value="">{{ __('Select Country ...') }}</option>
                                @foreach($country as $key => $value)
                                    <option value="{{$value->iso2}}">{{$value->name}}</option>
                                @endforeach
                        </select>
                    </div>
                </div>  
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="form-group">
                    {{Form::label('shipping_state',__('State'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                    <div class="form-icon-user">
                        <div class="form-icon-user">
                            <select class="form-control " name="shipping_state" id='shipping_state'
                                    placeholder="Select State" required>
                                <option value="">{{ __('Select State ...') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="form-group shipping_city">
                    {{Form::label('shipping_city',__('City'),array('class'=>'form-label')) }}
                    <span style='color:red;'>*</span>
                    <div class="form-icon-user">
                        <div class="form-icon-user">
                            {{Form::text('shipping_city',null,array('class'=>'form-control','required'=>'required',
                            'placeholder'=>'City','oninput'=>'process(this)'))}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="form-group shipping_phone">
                    {{Form::label('shipping_phone',__('Phone'),array('class'=>'form-label')) }}
                    <span style='color:red;'>*</span>
                    {{Form::text('shipping_phone',null,array('class'=>'form-control',
                    'Placeholder'=>'(00) 0000-0000','maxlength' => 16,'required'=>'required',
                    'oninput'=>"numeric(this)",'data-mask'=>"(00) 0000-0000",'data-mask-visible'=>"true"))}}
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="form-group shipping_zip">
                    {{Form::label('shipping_zip',__('Zip Code'),array('class'=>'form-label')) }}
                    <span style='color:red;'>*</span>
                    {{Form::text('shipping_zip',null,array('id'=> 'zip','class'=>'form-control','required'=>'required',
                    'placeholder'=>'Zipcode'))}}
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group shipping_address">
                    {{Form::label('shipping_address',__('Address'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                    {{Form::textarea('shipping_address',null,array('class'=>'form-control','rows'=>3,'required'=>'required', 'placeholder'=>'Address'))}}
                </div>
            </div>
        </div>
    @endif
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn btn-primary" id="create_subcontractor">
</div>
{{Form::close()}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"
    integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC" crossorigin="anonymous">
</script>

<script>
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
        $(document).on('submit', 'form', function() {
            $('#create_subcontractor').attr('disabled', 'disabled');
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

    $(document).ready(function(){
        $(document).on("keyup", '#email', function () {
            $.ajax({
                url : '{{ route("check_duplicate_email_subcontractor") }}',
                type : 'GET',
                data : { 'getname' : $("#email").val(),'formname' : "Venders" },
                success : function(data) {
                    if(data == 1){
                        $("#create_subcontractor").prop('disabled',false);
                        $(".email_duplicate_error").css('display','none');
                    }
                    else{
                        $("#create_subcontractor").prop('disabled',true);
                        $(".email_duplicate_error").css('display','block');
                    }
                },
                error : function(request,error)
                {
                    // alert("Request: "+JSON.stringify(request));
                }
            });
        });

        $(document).on("keyup", '#phone', function () {
            $.ajax({
                url : '{{ route("check_duplicate_mobile_subcontractor") }}',
                type : 'GET',
                data : { 'getname' : $("#phone").val(),'formname' : "Venders" },
                success : function(data) {
                    if(data == 1){
                        $("#create_subcontractor").prop('disabled',false);
                        $(".mobile_duplicate_error").css('display','none');
                    }
                    else{
                        $("#create_subcontractor").prop('disabled',true);
                        $(".mobile_duplicate_error").css('display','block');
                    }
                },
                error : function(request,error)
                {
                    // alert("Request: "+JSON.stringify(request));
                }
            });
        });
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
