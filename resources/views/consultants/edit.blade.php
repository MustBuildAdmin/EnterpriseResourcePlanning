<style>
    div#choices_multiple1_chosen {
        width: 100% !important;
    }
</style>
@if(\Auth::user()->type == 'super admin')
    @php $url='consultants.update' @endphp
@else
    @php $url='consultants.update_consultant' @endphp
@endif
{{Form::model($user,array('route' => array($url, $user->id),
  'method' => 'PUT','id'=>'edit_user','autocomplete'=>'off','enctype'=>"multipart/form-data")) }}
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group ">
                    {{Form::label('name',__('First Name'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
                    {{Form::text('name',null,array('class'=>'form-control font-style',
                    'maxlength' => 35,'placeholder'=>__('Enter First Name')))}}
                    @error('name')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{Form::label('lastname',__('Last Name'),['class'=>'form-label']) }}
                    <span style='color:red;'>*</span>
                    <input type="text" class="form-control" value="{{$user->lname}}"
                     id="lname" name="lname" placeholder="{{ __('Enter Last Name') }}" autocomplete="off" required>
                </div>
            </div>
           
            @if ($user->color_code!=null || $user->color_code!='')
                @php $colorcor =$user->color_code; @endphp
            @else
                @php $colorcor =$colorco; @endphp
            @endif
            <input type="hidden" name="color_code" value="{{ $colorcor }}">

            <input type="hidden" name="password" value="{{$user->password}}">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {{Form::label('email',__('Email Address'),['class'=>'form-label'])}}
                        <span style='color:red;'>*</span>
                        {{Form::email('email',null,array('class'=>'form-control','id'=>'email',
                        'placeholder'=>__('Enter User Email')))}}
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
                        {!! Form::select('gender', $gender, $user->gender,array('class' => 'form-control',
                        'required'=>'required')) !!}
                        @error('role')
                        <small class="invalid-role" role="alert">
                            <strong class="text-danger">{{ $message }}</strong>
                        </small>
                        @enderror
                </div>
            </div>

            <div class="form-group col-md-6">
                <div class="form-group">
                    {{Form::label('country',__('Country'),array('class'=>'form-label')) }}
                    <span style='color:red;'>*</span>
                    <div class="form-icon-user">
                        <select class="form-control country" name="country" id="country"
                         placeholder="Select Country" required>
                            <option value="">{{ __('Select Country ...') }}</option>
                            @foreach($countrylist as $key => $value)
                                <option value="{{$value->iso2}}"
                                    @if($user->country==$value->iso2) selected @endif>
                                    {{$value->name}}
                                </option>
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
                                    <option value="{{$value->iso2}}"
                                        @if($user->state==$value->iso2) selected @endif>
                                        {{$value->name}}
                                    </option>
                                @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-6">
                <div class="form-group">
                    {{Form::label('city',__('City'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                    <div class="form-icon-user">
                        {{Form::text('city',null,array('class'=>'form-control','required'=>'required',
                        'oninput'=>'process(this)'))}}
                    </div>
                </div>
            </div>
            <div class="form-group col-md-6">
                <div class="form-group">
                    {{Form::label('zip',__('Postal Code'),array('class'=>'form-label','id'=>'zip')) }}
                    <span style='color:red;'>*</span>
                    <div class="form-icon-user">
                        {{Form::text('zip',null,array('class'=>'form-control','required'=>'required'))}}
                    </div>
                </div>
            </div>
            <div class="form-group col-md-6">
                <div class="form-group">
                    {{Form::label('phone',__('Mobile Number'),array('class'=>'form-label')) }}
                    <span style='color:red;'>*</span>
                    <div class="form-icon-user">
                         <input type="text" name="phone" class="form-control" data-mask="(00) 0000-0000"
                          data-mask-visible="true" placeholder="(00) 0000-0000" id="phone"
                          maxlength="16" autocomplete="off" oninput="numeric(this)"  value='{{$user->phone}}'/>
                        <span class="invalid-name edit_mobile_duplicate_error" role="alert" style="display: none;">
                            <span class="text-danger">{{__('Mobile Number Already Exist!')}}</span>
                        </span>
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

            <div class="col-md-12">
                <div class="form-group">
                    {{Form::label('address',__('Address'),array('class'=>'form-label')) }}
                    <div class="form-icon-user">
                        {{Form::textarea('address',null,array('class'=>'form-control','rows'=>3,
                        'placeholder'=>'Here can be your Address'))}}
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
        <button type="button" class="btn me-auto" data-bs-dismiss="modal">{{__('Close')}}</button>
        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" id="edit_consultant">
            {{__('Update')}}
        </button>
    </div>

{{Form::close()}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"
 integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC" crossorigin="anonymous"></script>
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

    $(document).ready(function() {

        $(document).on('submit', 'form', function() {
            $('#edit_consultant').attr('disabled', 'disabled');
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
                        $("input#edit_consultant").prop('disabled',false);
                        $("span.invalid-name.email_duplicate_error").css('display','none');
                    }
                    else{
                        $("input#edit_consultant").prop('disabled',true);
                        $("span.invalid-name.email_duplicate_error").css('display','block');
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
                data : { 'get_id': "{{$user->id}}",'getname' : $("#phone").val(),'formname' : "Users" },
                success : function(data) {
                    if(data == 1){
                        $("#edit_consultant").prop('disabled',false);
                        $(".edit_mobile_duplicate_error").css('display','none');
                    }
                    else{
                        $("#edit_consultant").prop('disabled',true);
                        $(".edit_mobile_duplicate_error").css('display','block');
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

    function numeric(input){
        let value = input.value;
        let numbers = value.replace(/[^0-9]/g, "");
        input.value = numbers;
    }
   
</script>
<style>
div#reporting_toerr {
    display: flex;
    flex-direction: column-reverse;
}
</style>