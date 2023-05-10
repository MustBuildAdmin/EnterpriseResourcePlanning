{{Form::model($customer,array('route' => array('customer.update', $customer->id), 'method' => 'PUT','id'=>'customerform')) }}
<div class="modal-body">

    <h6 class="sub-title">{{__('Basic Info')}}</h6>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{Form::label('name',__('Name'),array('class'=>'form-label')) }}
                <div class="form-icon-user">
                    {{Form::text('name',null,array('class'=>'form-control','required'=>'required','minlength'=>1,'maxlength'=>50))}}
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{Form::label('contact',__('Contact'),['class'=>'form-label'])}}<span style="font-size: 12px;color: #e12323;"> (With Country Code)</span>
                <div class="form-icon-user">
                    <input class="form-control" name="contact" type="number" id="contact" maxlength="16" placeholder="+91 111 111 1111" required  value='{{$customer->contact}}'>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{Form::label('email',__('Email'),['class'=>'form-label'])}}
                <div class="form-icon-user">
                    {{Form::text('email',null,array('class'=>'form-control'))}}
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{Form::label('tax_number',__('Tax Number'),['class'=>'form-label'])}}
                <div class="form-icon-user">
                    {{Form::number('tax_number',null,array('class'=>'form-control'))}}
                </div>
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

    <h6 class="sub-title">{{__('Billing Address')}}</h6>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{Form::label('billing_name',__('Name'),array('class'=>'','class'=>'form-label')) }}
                <div class="form-icon-user">
                    {{Form::text('billing_name',null,array('class'=>'form-control'))}}
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{Form::label('billing_country',__('Country'),array('class'=>'form-label')) }}
                <div class="form-icon-user">
                    <select class="form-control country" name="billing_country" id='billing_country'
                                placeholder="Select Country" >
                                <option value="">{{ __('Select Country ...') }}</option>
                                @foreach($countrylist as $key => $value)
                                    <option value="{{$value->iso2}}" @if($customer->billing_country==$value->iso2) selected @endif>{{$value->name}}</option>
                                @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{Form::label('billing_state',__('State'),array('class'=>'form-label')) }}
                <div class="form-icon-user">
                    <select class="form-control country" name="billing_state" id='billing_state'
                                placeholder="Select State" >
                                <option value="">{{ __('Select State ...') }}</option>
                                @foreach($statelist as $key => $value)
                                    <option value="{{$value->iso2}}" @if($customer->billing_state==$value->iso2) selected @endif>{{$value->name}}</option>
                                @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{Form::label('billing_city',__('City'),array('class'=>'form-label')) }}
                <div class="form-icon-user">
                    {{Form::text('billing_city',null,array('class'=>'form-control','required'=>'required'))}}
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{Form::label('billing_phone',__('Phone'),array('class'=>'form-label')) }}
                <div class="form-icon-user">
                    <input class="form-control" name="billing_phone" type="number" id="billing_phone" maxlength="16" placeholder="+91 111 111 1111" value='{{$customer->billing_phone}}'>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{Form::label('billing_zip',__('Zip Code'),array('class'=>'form-label')) }}
                <div class="form-icon-user">
                    {{Form::number('billing_zip',null,array('class'=>'form-control'))}}
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('billing_address',__('Address'),array('class'=>'form-label')) }}
                <div class="input-group">
                    {{Form::textarea('billing_address',null,array('class'=>'form-control','rows'=>3))}}
                </div>
            </div>
        </div>
    </div>

    @if(App\Models\Utility::getValByName('shipping_display')=='on')
        <div class="col-md-12 text-end">
            {{-- <input type="button" id="billing_data" value="{{__('Shipping Same As Billing')}}" class="btn btn-primary"> --}}
        </div>
        <h6 class="sub-title">{{__('Shipping Address')}}</h6>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="form-group">
                    {{Form::label('shipping_name',__('Name'),array('class'=>'form-label')) }}
                    <div class="form-icon-user">
                        {{Form::text('shipping_name',null,array('class'=>'form-control'))}}
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="form-group">
                    {{Form::label('shipping_country',__('Country'),array('class'=>'form-label')) }}
                    <div class="form-icon-user">
                        <select class="form-control" name="shipping_country" id='shipping_country'
                                placeholder="Select Country" >
                                <option value="">{{ __('Select Country ...') }}</option>
                                @foreach($countrylist as $key => $value)
                                    <option value="{{$value->iso2}}" @isset($customer->shipping_country)@if($customer->shipping_country==$value->iso2) selected @endif @endisset>{{$value->name}}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="form-group">
                    {{Form::label('shipping_state',__('State'),array('class'=>'form-label')) }}
                    <div class="form-icon-user">
                        <select class="form-control " name="shipping_state" id='shipping_state'
                        placeholder="Select Country" >
                        <option value="">{{ __('Select State ...') }}</option>
                        @foreach($sellerstatelist as $key => $value)
                            <option value="{{$value->iso2}}" @if($customer->shipping_state==$value->iso2) selected @endif>{{$value->name}}</option>
                        @endforeach
                </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="form-group">
                    {{Form::label('shipping_city',__('City'),array('class'=>'form-label')) }}
                    <div class="form-icon-user">
                        {{Form::text('shipping_city',null,array('class'=>'form-control','required'=>'required'))}}
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="form-group">
                    {{Form::label('shipping_phone',__('Phone'),array('class'=>'form-label')) }}
                    <div class="form-icon-user">
                        <input class="form-control" name="shipping_phone" type="number" id="shipping_phone" maxlength="16" placeholder="+91 111 111 1111"  value='{{$customer->shipping_phone}}'>
                        {{-- {{Form::text('shipping_phone',null,array('class'=>'form-control'))}} --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="form-group">
                    {{Form::label('shipping_zip',__('Zip Code'),array('class'=>'form-label')) }}
                    <div class="form-icon-user">
                        {{Form::number('shipping_zip',null,array('class'=>'form-control'))}}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    {{Form::label('shipping_address',__('Address'),array('class'=>'form-label')) }}
                    <label class="form-label" for="example2cols1Input"></label>
                    <div class="input-group">
                        {{Form::textarea('shipping_address',null,array('class'=>'form-control','rows'=>3))}}
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn btn-primary">
</div>
{{Form::close()}}
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
    // $(document).on("change", '#billing_state', function () {
    //     var state=$(this).val();
    //     var country=$('#billing_country').val();
    //     var settings = {
    //             "url": "https://api.countrystatecity.in/v1/countries/"+country+"/states/"+state+"/cities",
    //             "method": "GET",
    //             "headers": {
    //                 "X-CSCAPI-KEY": '{{ env('Locationapi_key') }}'
    //             },
    //             };
        
    //             $.ajax(settings).done(function (response) {
    //             console.log(response);
    //                     $('#billing_city').empty();
    //                     $('#billing_city').append('<option value="">{{__('Select City ...')}}</option>');
    //                         $.each(response, function (key, value) {
    //                             $('#billing_city').append('<option value="' + value.id + '">' + value.name + '</option>');
    //                         });
    //         });
    //     });
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
    // $(document).on("change", '#shipping_state', function () {
    //     var state=$(this).val();
    //     var country=$('#shipping_country').val();
    //     var settings = {
    //             "url": "https://api.countrystatecity.in/v1/countries/"+country+"/states/"+state+"/cities",
    //             "method": "GET",
    //             "headers": {
    //                 "X-CSCAPI-KEY": '{{ env('Locationapi_key') }}'
    //             },
    //             };
        
    //             $.ajax(settings).done(function (response) {
    //             console.log(response);
    //                     $('#shipping_city').empty();
    //                     $('#shipping_city').append('<option value="">{{__('Select City ...')}}</option>');
    //                         $.each(response, function (key, value) {
    //                             $('#shipping_city').append('<option value="' + value.iso2 + '">' + value.name + '</option>');
    //                         });
    //         });
    //     });
    </script>
    <script>
$('#customerform').validate({
    rules: {
        name:{
            required: true,
            lettersonly: true,
        },
        billing_city: {
            required: true,
            lettersonly: true,
        },
        shipping_city: {
            required: true,
            lettersonly: true,
        }
    },
    submitHandler: function(form) {
        form.submit();
    }
});
$.validator.addMethod("lettersonly", function(value, element) {
    return this.optional(element) || /^[a-z\s]+$/i.test(value);
}, "Only alphabetical characters");
</script>