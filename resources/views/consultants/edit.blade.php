<style>
    div#choices_multiple1_chosen {
        width: 100% !important;
    }
</style>
@php
$color_palate = 0;
	$color = ['#4585b5','#cd3850', '#a7c57a', '#97ca49', '#d75bac','#a2d2ff','#ffafcc','#1d3557','#606c38','#bc6c25','#ffbe0b','#fb5607','#588157','#5e548e'];
    @endphp
{{Form::model($user,array('route' => array('consultants.update', $user->id), 'method' => 'PUT','id'=>'edit_user','autocomplete'=>'off')) }}
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
                <label for="{{__('Last Name')}}"></label><span style='color:red;'>*</span>
        
                <input type="text" class="form-control" value="{{$user->lname}}" id="lname" name="lname" placeholder="{{ __('Enter User Last Name') }}" autocomplete="off" required>
               

            </div>
        </div>

        <?php
        function rndRGBColorCode()
   {
       return 'rgb(' . rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255) . ')'; #using the inbuilt random function
   }
       ?>
       @php
       $rndColor = rndRGBColorCode(); #function call
      
       @endphp
        @if ($user->color_code!=Null || $user->color_code!='')
        @php $color_co =$user->color_code; @endphp
        @else
        @php $color_co =$rndColor; @endphp
        @endif
        <input type="hidden" name="color_code" value="{{ $color_co }}"> 
        <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('email',__('Email'),['class'=>'form-label'])}}<span style='color:red;'>*</span>
                {{Form::email('email',null,array('class'=>'form-control','id'=>'email','placeholder'=>__('Enter User Email')))}}
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
                    {!! Form::select('gender', $gender, $user->gender,array('class' => 'form-control select2','required'=>'required')) !!}
                    @error('role')
                    <small class="invalid-role" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                    @enderror
            </div>
        </div>
           
            <div class="form-group col-md-6">
                <div class="form-group">
                    {{Form::label('country',__('Country'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                    <div class="form-icon-user">
                        <select class="form-control country" name="country" id='country'placeholder="Select Country" required>
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
                            <input class="form-control" name="phone" type="number" id="phone" maxlength="16" placeholder="+91 111 111 1111" value='{{$user->phone}}' required>
                            <span class="invalid-name edit_mobile_duplicate_error" role="alert" style="display: none;">
                                <span class="text-danger">{{__('Mobile Number Already Exist!')}}</span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <div class="form-group">
                        {{Form::label('zip',__('Zip Code'),array('class'=>'form-label','id'=>'zip')) }}<span style='color:red;'>*</span>
                        <div class="form-icon-user">
                            {{Form::text('zip',null,array('class'=>'form-control','required'=>'required'))}}
                        </div>
                    </div>
                </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            {{Form::label('address',__('Address'),array('class'=>'form-label')) }}
                            <div class="form-icon-user">
                                {{Form::textarea('address',null,array('class'=>'form-control','rows'=>3))}}
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

</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light"data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary" id="edit_consultant">
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
        
        $(document).on("keyup", '#email', function () {
            $.ajax({
                url : '{{ route("check_duplicate_email_consultant") }}',
                type : 'GET',
                data : { 'getid': "{{$user->id}}", 'getname' : $("#email").val(), 'formname' : "Users" },
                success : function(data) {
                    if(data == 1){
                        $("#edit_consultant").prop('disabled',false);
                        $(".email_duplicate_error").css('display','none');
                    }
                    else{
                        $("#edit_consultant").prop('disabled',true);
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
   
</script>
<style>
div#reporting_toerr {
    display: flex;
    flex-direction: column-reverse;
}
</style>