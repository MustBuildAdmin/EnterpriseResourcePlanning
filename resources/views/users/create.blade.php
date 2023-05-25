<style>
    div#choices_multiple1_chosen {
        width: 100% !important;
    }
</style>
{{Form::open(array('url'=>'users','method'=>'post'))}}

<div class="modal-body">


    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('name',__('Name'),['class'=>'form-label']) }}
                {{Form::text('name',null,array('class'=>'form-control','maxlength' => 35,'placeholder'=>__('Enter User Name'),'required'=>'required'))}}
                @error('name')
                <small class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('email',__('Email'),['class'=>'form-label'])}}<span style='color:red;'>*</span>
                {{Form::text('email',null,array('class'=>'form-control','id'=>'email','placeholder'=>__('Enter User Email'),'required'=>'required'))}}
                <span class="invalid-name email_duplicate_error" role="alert" style="display: none;">
                    <span class="text-danger">Email Already Exist!</span>
                </span> 
                @error('email')
                <small class="invalid-email" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror

            </div>
        </div>
    <div class="row">
   
   <div class="form-group col-md-6">
                {{ Form::label('gender', __('Gender'),['class'=>'form-label']) }}
                {!! Form::select('gender', $gender, 'null',array('class' => 'form-control select2','required'=>'required')) !!}
                @error('role')
                <small class="invalid-role" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>

            <div class="form-group col-md-6">
                <div class="form-group">
                {{Form::label('reporting_to',__('Reporting to'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                <div class="form-icon-user">
                    <select  name="reporting_to[]" id='choices-multiple1' class='chosen-select' required multiple>
                        <option value="">{{ __('Select Reporting to ...') }}</option>
                        @foreach($users as $key => $value)
                              <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            </div>
       <div class="form-group col-md-6">
            <div class="form-group">
                {{Form::label('country',__('Country'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                <div class="form-icon-user">
                    <select class="form-control country" name="country" id='country'
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
                    <select class="form-control" name="state" id='state'
                            placeholder="Select State" >
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
                    <input class="form-control" name="phone" type="number" id="phone" maxlength="16" placeholder="+91 111 111 1111"  required>
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
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('address',__('Address'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                <div class="form-icon-user">
                    {{Form::textarea('address',null,array('class'=>'form-control','rows'=>3,'required'=>'required'))}}
                </div>
            </div>
        </div>
    </div>
        @if(\Auth::user()->type != 'super admin')
            <div class="form-group col-md-6">
                {{ Form::label('role', __('User Role'),['class'=>'form-label']) }}
                {!! Form::select('role', $roles, null,array('class' => 'form-control select2','required'=>'required')) !!}
                @error('role')
                <small class="invalid-role" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        @elseif(\Auth::user()->type == 'super admin')
            {!! Form::hidden('role', 'company', null,array('class' => 'form-control select2','required'=>'required')) !!}
            <div class="col-md-6">
                <div class="form-group">
                    {{Form::label('company_name',__('Company Name'),['class'=>'form-label']) }}
                    {{Form::text('company_name',null,array('class'=>'form-control','maxlength' => 35,'placeholder'=>__('Enter Company Name'),'required'=>'required'))}}
                    @error('company_name')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                    @enderror
                </div>
            </div>
            <div class="form-group col-md-6">
                {{ Form::label('company_type', __('Company'),['class'=>'form-label']) }}
                {!! Form::select('company_type', $company_type, null,array('class' => 'form-control select2','required'=>'required')) !!}
                @error('company_type')
                <small class="invalid-role" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        @endif
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('password',__('Password'),['class'=>'form-label'])}}
                {{Form::password('password',array('class'=>'form-control','placeholder'=>__('Enter User Password'),'required'=>'required','minlength'=>"6"))}}
                @error('password')
                <small class="invalid-password" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
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

</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary"  id="create_user">
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

        $(".chosen-select").chosen();

        $(document).on("keypress", '#zip', function (event) {
            if(event.which <= 48 || event.which >=57){
                event.preventDefault();
            }
        });

        $(document).on("change", '#zip', function (event) {
            $value = $("#zip").val();
            if(isNaN($value)){
            $("#zip").val('');
            }
        });

    });

    $(document).ready(function(){
        $(document).on("keyup", '#email', function () {
            $.ajax({
                url : '{{ route("check_duplicate_email") }}',
                type : 'GET',
                data : { 'get_name' : $("#email").val(),'form_name' : "Users" },
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
                    alert("Request: "+JSON.stringify(request));
                }
            });
        });
    });
</script>

