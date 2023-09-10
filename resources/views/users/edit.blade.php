<style>
    div#choices_multiple1_chosen {
        width: 100% !important;
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
</style>
{{Form::model($user,array('route' => array('users.update', $user->id), 'method' => 'PUT','id'=>'edit_user','autocomplete'=>'off','enctype'=>"multipart/form-data")) }}
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group ">
                    {{Form::label('name',__('Name'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
                    {{Form::text('name',null,array('class'=>'form-control font-style','maxlength' => 35,'placeholder'=>__('Enter User Name')))}}
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
                    <input type="text" name="lname" class="form-control" maxlength="35" value="{{$user->lname}}"
                     placeholder="{{__('Enter Last Name')}}" required>
                    @error('name')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                    @enderror
                </div>
            </div>
        </div>
     
     
       
        @if ($user->color_code!=null || $user->color_code!='')
             @php $colorcor =$user->color_code; @endphp
        @else
             @php $colorcor =$colorco; @endphp
        @endif

            <input type="hidden" name="color_code" value="{{ $colorcor }}">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {{Form::label('email',__('Email'),['class'=>'form-label'])}}<span style='color:red;'>*</span>
                        {{Form::email('email',null,array('class'=>'form-control','id'=>'email','placeholder'=>__('Enter User Email')))}}
                        <span class="invalid-name duplicate_error" role="alert" style="display: none;">
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
                    {!! Form::select('gender', $gender, $user->gender,array('class' => 'form-control',
                        'required'=>'required')) !!}
                    @error('role')
                        <small class="invalid-role" role="alert">
                            <strong class="text-danger">{{ $message }}</strong>
                        </small>
                    @enderror
                </div>
            </div>

            <div class="row">
                @if(\Auth::user()->type != 'super admin')
                <?php $reporting_to=explode(",",$user->reporting_to); ?>
                    <div class="form-group col-md-6">
                        <div class="form-group">
                            {{Form::label('reporting_to',__('Reporting to'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                            <div class="form-icon-user" id="reporting_toerr">
                                <select  name="reporting_to[]" id='choices-multiple1' class='chosen-select get_reportto' required multiple>
                                    @foreach($users as $key => $value)
                                        @if(in_array($key,$reporting_to))
                                            <option value="{{$key}}" selected>{{$value}}</option>
                                        @else
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                        
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="form-group col-md-6">
                        {{ Form::label('company_type', __('Company'),['class'=>'form-label']) }}
                        {!! Form::select('company_type', $company_type, $user->company_type,
                            array('class' => 'form-control','required'=>'required')) !!}
                        @error('company_type')
                        <small class="invalid-role" role="alert">
                            <strong class="text-danger">{{ $message }}</strong>
                        </small>
                        @enderror
                    </div>
                @endif
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {{Form::label('country',__('Country'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                        <div class="form-icon-user">
                            <select class="form-control country" name="country" id="country" required>
                                    <option value="">{{ __('Select Country ...') }}</option>
                                    @foreach($countrylist as $key => $value)
                                        <option value="{{$value->iso2}}" @if($user->country==$value->iso2) selected @endif>{{$value->name}}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <div class="form-group">
                        {{Form::label('state',__('State'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                        <div class="form-icon-user">
                            <select class="form-control state" name="state" id='state' placeholder="Select State" required>
                                <option value="">{{ __('Select State ...') }}</option>
                                @foreach($statelist as $key => $value)
                                    <option value="{{$value->iso2}}" @if($user->state==$value->iso2) selected @endif>{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <div class="form-group">
                        {{Form::label('city',__('City'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                        <div class="form-icon-user">
                            {{Form::text('city',null,array('class'=>'form-control','oninput'=>'process(this)',
                            'required'=>'required'))}}
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <div class="form-group">
                        {{Form::label('phone',__('Phone'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                        <div class="form-icon-user">
                            <input class="form-control" name="phone" type="number" id="phone" maxlength="16" placeholder="+91 111 111 1111" value='{{$user->phone}}' required>
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
                        {{Form::label('zip',__('Zip Code'),array('class'=>'form-label','id'=>'zip')) }}<span style='color:red;'>*</span>
                        <div class="form-icon-user">
                            {{Form::text('zip',null,array('class'=>'form-control','required'=>'required'))}}
                        </div>
                    </div>
                </div>

                @if(\Auth::user()->type != 'super admin')
                    <div class="form-group col-md-6">
                        {{ Form::label('role', __('User Role'),['class'=>'form-label']) }}
                        {!! Form::select('role', $roles, $user->roles,array('class' => 'form-control')) !!}
                        @error('role')
                        <small class="invalid-role" role="alert">
                            <strong class="text-danger">{{ $message }}</strong>
                        </small>
                        @enderror
                    </div>
                @endif

                <div class="col-md-12">
                    <div class="form-group">
                        {{Form::label('address',__('Address'),array('class'=>'form-label')) }}
                        <div class="form-icon-user">
                            {{Form::textarea('address',null,array('class'=>'form-control','rows'=>3))}}
                        </div>
                    </div>
                </div>
            </div>
                    <div class="col-md-12">
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
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light"data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary" id="edit_user">
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

        $(document).on('submit', 'form', function() {
            $('#edit_user').attr('disabled', 'disabled');
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
        
        $(document).on("keyup", '#email', function () {
            $.ajax({
                url : '{{ route("check_duplicate_email") }}',
                type : 'GET',
                data : { 'getid': "{{$user->id}}", 'getname' : $("#email").val(), 'formname' : "Users" },
                success : function(data) {
                    if(data == 1){
                        $("input#edit_user").prop('disabled',false);
                        $("span.invalid-name.duplicate_error").css('display','none');
                    }
                    else{
                        $("input#edit_user").prop('disabled',true);
                        $("span.invalid-name.duplicate_error").css('display','block');
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
                data : { 'getid': "{{$user->id}}", 'getname' : $("#phone").val(), 'formname' : "Users" },
                success : function(data) {
                    if(data == 1){
                        $("input#edit_user").prop('disabled',false);
                        $(".mobile_duplicate_error").css('display','none');
                    }
                    else{
                        $("input#edit_user").prop('disabled',true);
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

    $('#edit_user').validate({
        rules: {
            reportto: "required",
        },
        ignore: ':hidden:not("#choices-multiple1")'
    });

    $('.get_reportto').on('change', function() {
        get_val = $(this).val();
        console.log("get_val",get_val);

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