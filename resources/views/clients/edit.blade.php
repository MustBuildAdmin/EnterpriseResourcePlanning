
{{ Form::model($client, array('route' => array('clients.update', $client->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <h5 class="sub-title"><strong>{{__('Basic Info')}}</strong></h5>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="form-group">
                        {{ Form::label('name', __('Name'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
                        {{ Form::text('name', null, array('class' => 'form-control','placeholder'=>__('Enter Client Name'),'required'=>'required')) }}
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="form-group">
                        {{ Form::label('email', __('E-Mail Address'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
                        {{ Form::email('email', null, array('class' => 'form-control','placeholder'=>__('Enter Client Email'),'required'=>'required')) }}
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="form-group">
                    {{ Form::label('gender', __('Gender'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
                    {!! Form::select('gender', $gender, $user->gender,array('class' => 'form-control select2','required'=>'required')) !!}
                    @error('role')
                    <small class="invalid-role" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                    @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="form-group">
                        {{Form::label('country',__('Country'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                        <div class="form-icon-user">
                            <select class="form-control country" name="country" id='country'
                                        placeholder="Select Country" required>
                                        <option value="">{{ __('Select Country ...') }}</option>
                                        @foreach($countrylist as $key => $value)
                                            <option value="{{$value->iso2}}" @if($user->country==$value->iso2) selected @endif>{{$value->name}}</option>
                                        @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="form-group">
                        {{Form::label('state',__('State'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                        <div class="form-icon-user">
                            <select class="form-control country" name="state" id='state'
                                        placeholder="Select State" required>
                                        <option value="">{{ __('Select State ...') }}</option>
                                        @foreach($statelist as $key => $value)
                                            <option value="{{$value->iso2}}" @if($user->state==$value->iso2) selected @endif>{{$value->name}}</option>
                                        @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="form-group">
                        {{Form::label('city',__('City'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                        <div class="form-icon-user">
                            {{Form::text('city',null,array('class'=>'form-control','required'=>'required'))}}
                        </div>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-lg-6 col-md-4 col-sm-6">
                <div class="form-group">
                    {{Form::label('phone',__('Phone'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                    <div class="form-icon-user">
                        <input class="form-control" name="phone" type="number" id="phone" maxlength="16" required placeholder="+91 111 111 1111" value='{{$user->phone}}'>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-4 col-sm-6">
                <div class="form-group">
                    {{Form::label('zip',__('Zip Code'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                    <div class="form-icon-user">
                        {{Form::text('zip',null,array('class'=>'form-control','required'=>'required'))}}
                    </div>
                </div>
            </div>
           
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-4 col-sm-6">
                <div class="form-group">
                    {{Form::label('address',__('Address'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                    <div class="">
                        {{Form::textarea('address',null,array('class'=>'form-control','rows'=>3,'required'=>'required'))}}
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-4 col-sm-6">
                <div class="form-group">
                    {{Form::label('tax_number',__('Tax Number'),['class'=>'form-label'])}}<span style='color:red;'>*</span>
                    <div class="form-icon-user">
                        {{Form::number('tax_number',null,array('class'=>'form-control','maxlength' => 20,'required'=>'required'))}}
                    </div>
                </div>
            </div>
        </div>
    </div>
        @if(!$customFields->isEmpty())
            @include('custom_fields.formBuilder')
        @endif
     
        <h5 class="sub-title"><strong>{{__('Billing Address')}}</strong></h5>
        <hr>
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
                                        <option value="{{$value->iso2}}" @if($user->billing_country==$value->iso2) selected @endif>{{$value->name}}</option>
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
                                        <option value="{{$value->iso2}}" @if($user->billing_state==$value->iso2) selected @endif>{{$value->name}}</option>
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
                        <input class="form-control" name="billing_phone" type="number" id="billing_phone" maxlength="16" placeholder="+91 111 111 1111" value='{{$user->billing_phone}}'>
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
        <div class="custom-control custom-checkbox mt-n1">
            <input type="checkbox" name="copy_status" class="custom-control-input checkbox1" id="checkbox1" @if($user->copy_status==1) checked @else @endif>
            <label class="custom-control-label" for="checkbox1">  <h6 class="sub-title"><strong>Do you copy a billing address<strong></h6></label>
        </div>
        @if(App\Models\Utility::getValByName('shipping_display')=='on')
            <div class="col-md-12 text-end">
                {{-- <input type="button" id="billing_data" value="{{__('Shipping Same As Billing')}}" class="btn btn-primary"> --}}
            </div>
            <h5 class="sub-title"><strong>{{__('Shipping Address')}}</strong></h5>
            <hr>
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
                                        <option value="{{$value->iso2}}" @isset($user->shipping_country)@if($user->shipping_country==$value->iso2) selected @endif @endisset>{{$value->name}}</option>
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
                            @foreach($statelist as $key => $value)
                                <option value="{{$value->iso2}}" @if($user->shipping_state==$value->iso2) selected @endif>{{$value->name}}</option>
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
                            <input class="form-control" name="shipping_phone" type="number" id="shipping_phone" maxlength="16" placeholder="+91 111 111 1111"  value='{{$user->shipping_phone}}'>
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
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>

{{Form::close()}}


<script>
     $(document).on("change", '#country', function () {
        var name=$(this).val();
        var settings = {
                "url": "https://api.countrystatecity.in/v1/countries/"+name+"/states",
                "method": "GET",
                "headers": {
                    "X-CSCAPI-KEY": '{{ env('Locationapi_key') }}'
                },
                };

                $.ajax(settings).done(function (response) {
                        $('#state').empty();
                        $('#state').append('<option value="">{{__('Select State ...')}}</option>');
                            $.each(response, function (key, value) {
                                $('#state').append('<option value="' + value.iso2 + '">' + value.name + '</option>');
                            });
            });
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

    $(document).on("change", ".checkbox1", function () {
    var $this = $(this).parent().parent();
    if (this.checked) {

      $this.find('#shipping_name').val($this.find('#billing_name').val());
      $this.find('#shipping_city').val($this.find('#billing_city').val());
      $this.find('#shipping_phone').val($this.find('#billing_phone').val());
      $this.find('#shipping_zip').val($this.find('#billing_zip').val());
      $this.find('#shipping_address').val($this.find('#billing_address').val());
      $this.find('#shipping_country').val($this.find('#billing_country').val());
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
     
     
      
    } else {
      $this.find('#shipping_name').val("");
      $this.find('#shipping_city').val("");
      $this.find('#shipping_phone').val("");
      $this.find('#shipping_zip').val("");
      $this.find('#shipping_address').val("");
      $this.find('#shipping_country').val("");
      setTimeout(function() {     $this.find('#shipping_state').val(""); }, 100);
     

    }

  });

});
</script>