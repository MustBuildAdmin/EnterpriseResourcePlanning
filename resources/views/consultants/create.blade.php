<style>
    div#choices_multiple1_chosen {
        width: 100% !important;
    }
</style>

{{Form::open(array('url'=>'consultants','method'=>'post','id'=>'users_form','autocomplete'=>'off',
'enctype'=>"multipart/form-data"))}}

    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {{Form::label('name',__('First Name'),['class'=>'form-label']) }}
                    <span style='color:red;'>*</span>
                    {{Form::text('name',null,array('class'=>'form-control','maxlength' => 35,
                     'placeholder'=>__('Enter User Name'),'required'=>'required'))}}
                    @error('name')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{Form::label('lname',__('Last Name'),['class'=>'form-label'])}}<span style='color:red;'>*</span>
                    {{Form::text('lname',null,array('class'=>'form-control','id'=>'lname',
                    'placeholder'=>__('Enter User Last Name'),'autocomplete'=>'off','required'=>'required'))}}
                </div>
            </div>
        </div>
      
        @php
            $rndColor = Utility::rndRGBColorCode(); #function call
        @endphp
        <input type="hidden" name="color_code" value="{{ $rndColor }}">

        @php
        $password = Utility::randomPassword(); #function call
        @endphp

        <input type="hidden" name="password" value="{{ $password }}">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {{Form::label('email',__('Email'),['class'=>'form-label'])}}<span style='color:red;'>*</span>
                    {{Form::text('email',null,array('class'=>'form-control','id'=>'email',
                    'placeholder'=>__('Enter User Email'),'autocomplete'=>'off','required'=>'required'))}}
                    <span class="invalid-name email_duplicate_error" role="alert" style="display: none;">
                        <span class="text-danger">{{__('Email Already Exist!')}}</span>
                    </span>
                    @error('email')
                    <small class="invalid-email" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                    @enderror

                </div>
            </div>
            <div class="form-group col-md-6">
                {{ Form::label('gender', __('Gender'),['class'=>'form-label']) }}
                {!! Form::select('gender', $gender, 'null',array('class' => 'form-control','required'=>'required')) !!}
                @error('role')
                <small class="invalid-role" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <div class="form-group">
                    {{Form::label('country',__('Country'),array('class'=>'form-label')) }}
                    <span style='color:red;'>*</span>
                    <div class="form-icon-user">
                        <select class="form-control country" name="country" id="country"
                         placeholder="Select Country" required>
                            <option value="">{{ __('Select Country ...') }}</option>
                            @foreach($country as $key => $value)
                                <option value="{{$value->iso2}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                        {{-- {{Form::text('country',null,array('class'=>'form-control'))}} --}}
                    </div>
                </div>
            </div>
            <div class="form-group col-md-6">
                <div class="form-group">
                    {{Form::label('state',__('State'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                    <div class="form-icon-user">
                        <select class="form-control" name="state" id='state' placeholder="Select State" required>
                            <option value="">{{ __('Select State ...') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-6">
                <div class="form-group">
                    {{Form::label('city',__('City'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                    <div class="form-icon-user">
                        {{Form::text('city',null,array('class'=>'form-control','required'=>'required'))}}
                    </div>
                </div>
            </div>
            <div class="form-group col-md-6">
                <div class="form-group">
                    {{Form::label('phone',__('Phone'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                    <div class="form-icon-user">
                        <input class="form-control" name="phone" type="number" id="phone"
                         maxlength="16" placeholder="+91 111 111 1111"  required>
                        <span class="invalid-name mobile_duplicate_error" role="alert" style="display: none;">
                            <span class="text-danger">{{__('Mobile Number Already Exist!')}}</span>
                        </span>
                        {{-- {{Form::text('phone',null,array('class'=>'form-control'))}} --}}
                    </div>
                </div>
            </div>
            <div class="form-group col-md-6">
                <div class="form-group">
                    {{Form::label('zip',__('Zip Code'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                    <div class="form-icon-user">
                        {{Form::text('zip',null,array('class'=>'form-control','id'=>'zip','required'=>'required'))}}
                    </div>
                </div>
            </div>
            <div class="form-group col-md-6">
                <div class="form-group">
                    {{Form::label('avatar',__('Profile Image'),array('class'=>'form-label')) }}
                    <div class="form-icon-user">
                        {{Form::file('avatar',null,array('class'=>'form-control'))}}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    {{Form::label('address',__('Address'),array('class'=>'form-label')) }}
                    <span style='color:red;'>*</span>
                    <div class="form-icon-user">
                        {{Form::textarea('address',null,array('class'=>'form-control',
                        'rows'=>3,'required'=>'required'))}}
                    </div>
                </div>
            </div>
        </div>
        @if(!$customFields->isEmpty())
            <div class="col-md-6">
                <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                    @include('customFields.formBuilder')
                </div>
            </div>
        @endif
    </div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary"  id="create_consultant">
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
</script>

<script>
    $(document).ready(function() {

        $(".chosen-select").chosen({
            placeholder_text:"{{ __('Reporting to') }}"
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
                url : '{{ route("check_duplicate_email") }}',
                type : 'GET',
                data : { 'getname' : $("#email").val(),'formname' : "Users" },
                success : function(data) {
                    if(data == 1){
                        $("#create_consultant").prop('disabled',false);
                        $(".email_duplicate_error").css('display','none');
                    }
                    else{
                        $("#create_consultant").prop('disabled',true);
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
                url : '{{ route("check_duplicate_mobile") }}',
                type : 'GET',
                data : { 'getname' : $("#phone").val(),'formname' : "Users" },
                success : function(data) {
                    if(data == 1){
                        $("#create_consultant").prop('disabled',false);
                        $(".mobile_duplicate_error").css('display','none');
                    }
                    else{
                        $("#create_consultant").prop('disabled',true);
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

    $('#users_form').validate({
        rules: {
            reportto: "required",
        },
        ignore: ':hidden:not("#choices-multiple1")'
    });

    $('.get_reportto').on('change', function() {
        get_val = $(this).val();
        

        if(get_val != ""){
            $("#reportto-error").hide();
        }
        else{
            $("#reportto-error").show();
        }
       
    });
 
</script>

<style>
div#reporting_toerr {
    display: flex;
    flex-direction: column-reverse;
}
</style>