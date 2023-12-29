<style>
    div#choices_multiple1_chosen {
        width: 100% !important;
        border-color:#e6e7e9 !important;
    }
    .chosen-container-multi .chosen-choices
    {
    border: none;
    cursor: text;
    padding: 0.2325rem 0.75rem;
    border-top: 1px solid #ddd;
    border-left: 1px solid #ddd;
    border-right: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    width: 100%;
    text-indent: 0;
   }
   input#create_user1 {
    display: none;
}
</style>

{{Form::open(array('url'=>'users','method'=>'post','id'=>'users_form',
  'autocomplete'=>'off','enctype'=>"multipart/form-data"))}}

    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {{Form::label('name',__('Name'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
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
                    {{Form::label('lname',__('Last Name'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
                    {{Form::text('lname',null,array('class'=>'form-control','maxlength' => 35,
                    'placeholder'=>__('Enter Last Name'),'required'=>'required'))}}
                    @error('name')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                    @enderror
                </div>
            </div>
        </div>
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
                {!! Form::select('gender', $gender, 'null',array('class' => 'form-control',
                'required'=>'required')) !!}
                @error('role')
                <small class="invalid-role" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        </div>
      
       @php
            $rndColor = Utility::rndRGBColorCode(); #function call
       @endphp

        <input type="hidden" name="color_code" value="{{ $rndColor }}">
        <div class="row">
            @if(\Auth::user()->type != 'super admin')
            <div class="form-group col-md-6">
                <div class="form-group">
                    {{ Form::label('Reportto', __('Reporting to'), ['class' => 'form-label']) }}
                    <span class="text-danger">*</span>
                        <div id="reporting_toerr">
                        {!! Form::select('reporting_to[]', $users, null,array('id' => 'choices-multiple1',
                            'class' => 'form-control chosen-select get_reportto',
                            'multiple'=>'true','required'=>'required')) !!}
                        </div>
                    </div>
                </div>
            </div>
            @endif
          
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
                        {{Form::label('state',__('State'),array('class'=>'form-label')) }}
                        <span style='color:red;'>*</span>
                        <div class="form-icon-user">
                            <select class="form-control" name="state" id='state' placeholder="Select State" required>
                                <option value="">{{ __('Select State ...') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <div class="form-group">
                        {{Form::label('city',__('City'),array('class'=>'form-label')) }}
                        <span style='color:red;'>*</span>
                        <div class="form-icon-user">
                            {{Form::text('city',null,array('class'=>'form-control','oninput'=>'process(this)',
                            'required'=>'required'))}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-4 col-sm-6 country_code">
                    <div class="form-group">
                        {{Form::label('phone',__('Phone'),array('class'=>'form-label')) }}
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
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <div class="form-group">
                        {{Form::label('zip',__('Zip Code'),array('class'=>'form-label')) }}
                        <span style='color:red;'>*</span>
                        <div class="form-icon-user">
                            {{Form::text('zip',null,array('class'=>'form-control','id'=>'zip','required'=>'required'))}}
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-group">
                        {{Form::label('password',__('Password'),['class'=>'form-label'])}}
                        <span style='color:red;'>*</span>
                        {{Form::password('password',array('class'=>'form-control',
                        'placeholder'=>__('Enter User Password'),'required'=>'required','minlength'=>"6"))}}
                        @error('password')
                        <small class="invalid-password" role="alert">
                            <strong class="text-danger">{{ $message }}</strong>
                        </small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
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
        @if(\Auth::user()->type != 'super admin')
         <div class="row">
            <div class="form-group col-md-6">
                {{ Form::label('role', __('User Role'),['class'=>'form-label']) }}
                {!! Form::select('role', $roles, null,array('class' => 'form-control',
                    'required'=>'required')) !!}
                @error('role')
                <small class="invalid-role" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{Form::label('avatar',__('Profile Image'),array('class'=>'form-label')) }}
                    <div class="form-icon-user">
                        <input type="file" class="form-control document_setup" id="avatar"  name="avatar"
                        accept="image/*, .png, .jpeg, .jpg">
                    </div>
                    <span class="show_document_error" style="color:red;"></span>
                </div>
            </div>
         </div>
        @elseif(\Auth::user()->type == 'super admin')
        <div class="row">
            {!! Form::hidden('role', 'company', null,array('class' => 'form-control',
            'required'=>'required')) !!}
            <div class="col-md-6">
                <div class="form-group">
                    {{Form::label('company_name',__('Company Name'),['class'=>'form-label']) }}
                    {{Form::text('company_name',null,array('class'=>'form-control','maxlength' => 35,
                      'placeholder'=>__('Enter Company Name'),'required'=>'required'))}}
                    @error('company_name')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                    @enderror
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
        </div>
            <div class="form-group col-md-6">
                {{ Form::label('company_type', __('Company'),['class'=>'form-label']) }}
                {!! Form::select('company_type', $company_type, null,array('class' => 'form-control',
                    'required'=>'required')) !!}
                @error('company_type')
                <small class="invalid-role" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        @endif
       
        @if(!$customFields->isEmpty())
            <div class="col-md-6">
                <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                    @include('customFields.formBuilder')
                </div>
            </div>
        @endif
    </div>

</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="button" id="create_user" value="{{__('Create')}}" class="btn  btn-primary">
    <input type="submit" id="create_user1" value="{{__('Create')}}" class="btn  btn-primary">
</div>

{{Form::close()}}
<script>


var phone_number = window.intlTelInput(document.querySelector("#phone"), {
    separateDialCode: true,
    preferredCountries:["in"],
    hiddenInput: "phone_country",
    utilsScript:"{{ asset('assets/phonepicker/js/utils.js') }}"
});
$('input#create_user').click(function(){
    $("#phone").val(phone_number.getNumber(intlTelInputUtils.numberFormat.E164));
    $('input#create_user1').click()

});
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

     
        $(document).on('submit', 'form', function() {
            $('#create_user').attr('disabled', 'disabled');
        });

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
                        $("#create_user").prop('disabled',false);
                        $(".email_duplicate_error").css('display','none');
                    }
                    else{
                        $("#create_user").prop('disabled',true);
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
            var full_number = phone_number.getNumber(intlTelInputUtils.numberFormat.E164);
            $("input[name='phone_country'").val(full_number);

            $.ajax({
                url : '{{ route("check_duplicate_mobile") }}',
                type : 'GET',
                data : { 'getname' : $("#phone").val(),'formname' : "Users" },
                success : function(data) {
                    if(data == 1){
                        $("#create_user").prop('disabled',false);
                        $(".mobile_duplicate_error").css('display','none');
                    }
                    else{
                        $("#create_user").prop('disabled',true);
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

   

    function process(input){
        let value = input.value;
        let numbers = value.replace(/[^a-zA-Z]/g, "");
        input.value = numbers;
    }

</script>

<style>
div#reporting_toerr {
    display: flex;
    flex-direction: column-reverse;
}
</style>