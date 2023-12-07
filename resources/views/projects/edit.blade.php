

<link rel="stylesheet" href="{{ asset('WizardSteps/css/wizard.css') }}">
<style>
    .upload-btn-wrapper {
  position: relative;
  overflow: hidden;
  display: inline-block;
}
.createProject {
    display: flex;
    margin-left: auto;
    width: 200px;
}
.btn {
  padding: 8px 20px;
  cursor: pointer;
}

.upload-btn-wrapper input[type=file] {
  font-size: 100px;
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
}
    .chosen-container{
        width: 100%!important;
        height: fit-content;
    }
    .estimated_days:focus {
        box-shadow: unset;
        border: 1px solid #ccc !important;
    }
    .estimated_days:hover {
        border: 1px solid #ccc !important;
    }

    /* Loader */
    .wrappers{
        display: flex;
        justify-content: center;
    }
    .cards {
        display: flex;
        padding: 24px;
        border-radius: 5px;
        align-items: center;
        justify-content: center;
    }
    .loader{
        border-radius: 50%;
        position: relative;
        display: inline-block;
        height: 0px;
        width: 0px;
    }

    .loader span{
        position: absolute;
        display: block;
        background: #ddd;
        height: 15px;
        width: 15px;
        border-radius: 50%;
        top: -20px;
        perspective: 100000px;
    }
    .loader span:nth-child(1) {
        left:30px;
        animation: bounce2 1s cubic-bezier(0.04, 0.35, 0, 1) infinite;
        animation-delay: 0s;
        background: #ff756f;
    }
    .loader span:nth-child(2) {
        left:6px;
        animation: bounce2 1s cubic-bezier(0.04, 0.35, 0, 1) infinite;
        animation-delay: .2s;
        background: #ffde6f;
    }
    .loader span:nth-child(3) {
        left:-20px;
        animation: bounce2 1s cubic-bezier(0.04, 0.35, 0, 1) infinite;
        animation-delay: .4s;
        background: #01de6f;
    }
    .loader span:nth-child(4) {
        left: -44px;
        animation: bounce2 1s cubic-bezier(0.04, 0.35, 0, 1) infinite;
        animation-delay: .6s;
        background: #6f75ff;
    }

    @keyframes bounce2 {
        0%, 56%, 100% {
            transform: translateY(0px);
        }
        25% {
            transform: translateY(-30px);
        }
    }

    /* micro program CSS */
    .newmicro_program {
        margin-top: 30px !important;
    }
    .col-sm-4.col-md-4.rowTop{
        margin-top: 10px;
    }
    .checkbox_group {
        display: block !important;
        margin-bottom: 15px;
    }

    .checkbox_group input {
        padding: 0;
        height: initial;
        width: initial;
        margin-bottom: 0;
        display: none !important;
        cursor: pointer;
    }

    .checkbox_group label {
        position: relative;
        cursor: pointer;
    }

    .checkbox_group label:before {
        content:'';
        -webkit-appearance: none;
        background-color: transparent;
        border: 2px solid #0079bf;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
        padding: 10px;
        display: inline-block;
        position: relative;
        vertical-align: middle;
        cursor: pointer;
        margin-right: 5px;
    }

    .checkbox_group input:checked + label:after {
        content: '';
        display: block;
        position: absolute;
        top: 2px;
        left: 9px;
        width: 6px;
        height: 14px;
        border: solid #0079bf;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }
    span#non_working_days_error{
        display:none;
    }
</style>
<div class="modal-body">
    <div class="container">
        {{ Form::model($project, ['route' => ['projects.update', $project->id], 'method' => 'PUT',
             'enctype' => 'multipart/form-data', 'id' => 'create_project_form',
              'class' => 'create_project_form']) }}
            {{ csrf_field() }}
            <div>
                <section>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                {{ Form::label('project_name', __('Project Name'), ['class' => 'form-label']) }}
                                <span class="text-danger">*</span>
                                {{ Form::text('project_name', null, ['class' => 'form-control',
                                    'required'=>'required','disabled'=>'true','readonly'=>true]) }}
                                {{Form::hidden('freeze_statuss',$project->freeze_status,
                                    array('class'=>'form-control','id'=>'freeze_status'))}}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {{Form::label('country',__('Country'),array('class'=>'form-label')) }}
                                <span style='color:red;'>*</span>
                                <select class="form-control country" name="country" id='country'
                                 placeholder="Select Country" required>
                                    <option value="">{{ __('Select Country ...') }}</option>
                                    @foreach($country as $key => $value)
                                          <option value="{{$value->iso2}}"
                                           @if($project->country == $value->iso2)
                                            selected @endif>{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {{Form::label('state',__('State'),array('class'=>'form-label')) }}
                                <span style='color:red;'>*</span>
                                <select class="form-control" name="state" id='state'
                                 placeholder="Select State" required>
                                    <option value="">{{ __('Select State ...') }}</option>
                                    @foreach ($statelist as $state_display)
                                        <option value="{{$state_display->iso2}}"
                                         @if($project->state == $state_display->iso2) selected
                                          @endif>{{$state_display->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {{Form::label('city',__('City'),array('class'=>'form-label')) }}
                                <span style='color:red;'>*</span>
                                {{Form::text('city',null,array('class'=>'form-control', 'placeholder'=>'Enter city',
                                    'required'=>'required',
                                'oninput'=>'alphaOnly(this)'))}}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {{Form::label('zip',__('Zip Code'),array('class'=>'form-label')) }}
                                <span style='color:red;'>*</span>
                                {{Form::text('zip',$project->zipcode,array('class'=>'form-control','id'=>'zip',
                                'required'=>'required', 'minlength'=>5,'placeholder'=>'Enter zip code'))}}
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {{Form::label('latitude',__('Latitude'),array('class'=>'form-label')) }}
                                <span style='color:red;'>*</span>
                                {{Form::text('latitude',null,array('class'=>'form-control',
                                    'id'=>'latitude','placeholder'=>'Enter latitude','required'=>'required'))}}
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {{Form::label('longitude',__('Longitude'),array('class'=>'form-label')) }}
                                <span style='color:red;'>*</span>
                                {{Form::text('longitude',null,array('class'=>'form-control',
                                    'id'=>'longitude','placeholder'=>'Enter longitude','required'=>'required'))}}
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                        <label class="form-label">Other Address Details</label>
                        {!! Form::textarea('otheraddress', null, ['class'=>'form-control','rows'=>'6',
                            'placeholder'=>'Other Address Details']) !!}

                        </div>
                    </div>
                </section>
                <section>
                    <div class="row">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}
                                <span class="text-danger">*</span>
                                {{ Form::date('start_date', null, ['class' => 'form-control',
                                    'placeholder'=>'Enter start date',
                                    'required'=>'required']) }}
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
                                <span class="text-danger">*</span>
                                {{ Form::date('end_date', null, ['class' => 'form-control',
                                    'placeholder'=>'Enter end date','required'=>'required']) }}
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {{ Form::label('estimated_days', __('Estimated Days'),['class' => 'form-label']) }}
                                {{ Form::text('estimated_days', null, ['class' => 'form-control',
                                    'placeholder'=>'Enter estimated days' ,'readonly'=>true]) }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                            {{ Form::label('Users', __('Manager'), ['class' => 'form-label']) }}
                            <span class="text-danger">*</span>
                                <select class="form-control" name="report_to" id='report_to'
                                 placeholder="Select Manager" required>
                                    @foreach ($repoter as $key=>$value)
                                        <option value="{{$key}}"
                                         @if($project->report_to == $key) selected
                                          @endif>{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {{ Form::label('project_image', __('Project Image'), ['class' => 'form-label']) }}
                                <input type="file" class="form-control" id="project_image"  name="project_image">
                            </div>
                            <span id="project_image_error" class="invalid-feedback" for="project_image"></span>

                            @if($project->project_image != null)
                                <img id="image"  src="{{  \App\Models\Utility::get_file($project->project_image) }}"
                                class="avatar avatar-xl" alt="">
                            @endif
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
                                <span class="text-danger">*</span>
                                <select name="status" id="status" class="form-control main-element select2" required>
                                    <option value=''>Choose Status</option>
                                    @foreach(\App\Models\Project::$project_status as $k => $v)
                                        <option value="{{$k}}" {{ ($project->status == $k) ?
                                             'selected' : ''}}>{{__($v)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-md-4 ">
                            <div class="form-group">
                                {{ Form::label('report_time', __('Report Time'), ['class' => 'form-label']) }}
                                <span class="text-danger">*</span>
                                <select class="form-control" name="report_time" id='report_time'
                                 placeholder="Select Report Time" required>
                                    <option value="">{{ __('Select Report Time ...') }}</option>
                                    <?php
                                    foreach($reportingtime as $key=>$value){
                                        if($key.':00' == $project->report_time){
                                            echo '<option value="'.$key.':00" selected>'.$value.'</option>';
                                        }
                                        else{
                                            echo '<option value="'.$key.':00">'.$value.'</option>';
                                        }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 rowTop">
                            <div class="form-group">
                                {{Form::label('non_working_days',__('non_working_days'),['class'=>'form-label'])}}
                                <span class="text-danger">*</span>
                                @php
                                    $non_working_days = array(
                                        '1' => 'Monday',
                                        '2' => 'Tuesday',
                                        '3' => 'Wednesday',
                                        '4' => 'Thursday',
                                        '5' => 'Friday',
                                        '6' => 'Saturday',
                                        '0' => 'Sunday'
                                    );
                                @endphp
                                @php $non_working_days_set=explode(',',$project->non_working_days); @endphp
                                {!! Form::select('non_working_days[]', $non_working_days, $non_working_days_set,
                                    array('id' => 'non_working_days','class' => 'form-control chosen-select
                                    get_non_working_days','multiple'=>'true','placeholder'=>'Select non working days'))
                                !!}
                            </div>
                            <span id="non_working_days_error" class="error" for="non_working_days">
                                This field is required</span>

                        </div>
                        @if($project->micro_program == 1)
                        <div class="col-sm-4 col-md-4 newmicro_program rowTop">
                            <div class="form-group">
                                <label>Look-a-head Enabled</label>
                            </div>
                        </div>
                        @endif
                    </div>

                    <button type="button" class="btn btn-primary createProject" onclick="createProject()">Save</button>
                </section>
            </div>
        {{Form::close()}}
    </div>
</div>

<div class="modal fade loding_popup" id="loding_popup" tabindex="-1" role="dialog"
aria-labelledby="exampleModalCenterTitle"
aria-hidden="true" data-toggle="modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <center>
                    <section class="wrappers loader_show_hide">
                        <div class="cards">
                        <div class="loader">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        </div>
                    </section>
                </center>
            </div>
        </div>
    </div>
</div>

<script>

    $('#loding_popup').modal({backdrop: 'static', keyboard: false});
    $('#commonModal').modal({backdrop: 'static', keyboard: false});
    disabled_all();
    function disabled_all(){
        freeze_status = $("#freeze_status").val();
        if(freeze_status == 1){
            $('input').prop('disabled',true);
            $('select').prop('disabled',true);
            $("a:contains(Finish)").prop('disabled',true);
            $('.delete_key').prop('disabled',true);
            $('.addmore').prop('disabled',true);
        }
    }

    $(document).on('keypress', function (e) {
        if (e.which == 13) {
            swal.closeModal();
        }
    });

    function count_table_tr(){
        count_tr = $(".holiday_table tbody tr").length;
        row_count = parseInt(count_tr) + parseInt(1);

        return row_count;
    }
    var key_i = count_table_tr();
    check_validation = 0;
    $(document).on("click", '.addmore', function () {

        if ($("#holidays").prop('checked') == false) {
            holidayValidation();
        }

        if(check_validation == 0){
            var data="<tr id='"+key_i+"' class='duplicate_tr'>"+
                "<td><input type='checkbox' class='case'/></td>";
                data +="<td><input data-date_id='"+key_i+"' class='form-control holiday_date get_date' type='date' id='holiday_date"+key_i+"' name='holiday_date[]'/> <label style='display:none;color:red;' class='holiday_date_label"+key_i+"'>This Field Is Required </label></td>"+
                "<td><input data-desc_id='"+key_i+"' class='form-control holiday_description' type='text' id='holiday_description"+key_i+"' name='holiday_description[]'/> <label style='display:none;color:red;' class='holiday_description_label"+key_i+"'>This Field Is Required </label></td>"+
            "</tr>";

            $('.holiday_table tbody').append(data);
            key_i++;
        }
    });

    function holidayValidation(){
        $( ".holiday_date" ).each(function(index) {
            get_inc_id = $(this).data('date_id');

            get_date_val = $("#holiday_date"+get_inc_id).val();
            get_desc_val = $("#holiday_description"+get_inc_id).val();

            if(get_date_val == "" && get_desc_val == ""){
                $(".holiday_date_label"+get_inc_id).show();
                $(".holiday_description_label"+get_inc_id).show();
                check_validation = 1;
            }
            else if(get_date_val == ""){
                $(".holiday_date_label"+get_inc_id).show();
                check_validation = 1;
            }
            else if(get_desc_val == ""){
                $(".holiday_description_label"+get_inc_id).show();
                check_validation = 1;
            }
            else{
                $(".holiday_date_label"+get_inc_id).hide();
                $(".holiday_description_label"+get_inc_id).hide();
                check_validation = 0;
            }
        });
    }

    $(document).on("click", '.delete_key', function () {
        case_count = $('.case:checkbox:checked').length;
        if(case_count != 0){
            $('.case:checkbox:checked').parents("tr").remove();
            $('.check_all').prop("checked", false);
            check_key();
        }
        else{
            toastr.error("please Check One Row!");
        }
    });

    function check_key(){
        obj = $('.holiday_table tr');
        $.each( obj, function( key, value ) {
            id = value.id;
            $('#'+id).html(key+1);
        });
	}

    function select_all_key() {
        $('input[class=case]:checkbox').each(function(){
            if($('input[class=check_all]:checkbox:checked').length == 0){
                $(this).prop("checked", false);
            } else {
                $(this).prop("checked", true);
            }
        });
    }

    $(document).on('change', '.holiday_date', function () {
        holiday_array   = [];
        holiday_date    = $(this).val();
        holiday_date_id = $(this).attr('id');

        $('.holiday_table tr').each(function(){
            pre_holiday = $(this).find(".get_date").val();
            pre_holiday_id = $(this).find(".get_date").attr('id');
            if(pre_holiday_id != holiday_date_id && pre_holiday != undefined && pre_holiday != ""){
                holiday_array.push(pre_holiday);
            }
        });

        if(holiday_array.indexOf(holiday_date) !== -1)
        {
            toastr.error("This Date Is Already Exist!");
            $(this).val("");
        }
    });

    $(function ()
    {
        var form = $("#create_project_form");

        form.validate({
            rules: {
                latitude: {
                    required: true,
                    latCoord: true
                },
                longitude: {
                    required: true,
                    longCoord: true
                }
            }
        });

        $.validator.addMethod('latCoord', function(value, element) {
            return this.optional(element) ||
            value.length >= 4 && /^(?=.)-?((8[0-5]?)|([0-7]?[0-9]))?(?:\.[0-9]{1,20})?$/.test(value);
        }, 'Your Latitude format has error.')

        $.validator.addMethod('longCoord', function(value, element) {
            return this.optional(element) ||
            value.length >= 4 && /^(?=.)-?((0?[8-9][0-9])|180|([0-1]?[0-7]?[0-9]))?(?:\.[0-9]{1,20})?$/.test(value);
        }, 'Your Longitude format has error.')
    });

    $(document).on("change", '#holidays', function () {
        if ($(this).is(':checked')) {
            $(".holidays_show_hide").hide();
        }
        else{
            $(".holidays_show_hide").show();
        }
    });

    $(document).on("change", '#start_date', function () {
        var start=$('#start_date').val();
        $('#end_date').val('');
        $('#end_date').attr('min',start);
    });

    $(document).on("change", '#end_date', function () {
        var start=$('#start_date').val();
        var End=$('#end_date').val();
        const date1 = new Date(start);
        const date2 = new Date(End);
        const diffTime = Math.abs(date2 - date1);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        const estimated_days=diffDays+1;
        if(!Number.isNaN(diffDays)){
            $('#estimated_days').val(estimated_days);
        }else{
            $('#estimated_days').val('');
        }
    });

    $('.get_non_working_days').on('change', function() {
        get_val = $(this).val();

        if(get_val != ""){
            $("#non_working_days_error").hide();
        }
        else{
            $("#non_working_days_error").show();
        }
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

    document.getElementById('project_image').onchange = function () {
        var fileInput =  document.getElementById("project_image");
        var fileName=fileInput.files[0].name.substring(fileInput.files[0].name.lastIndexOf('.') + 1);
        if(fileName=='jpeg' || fileName=='png' || fileName=='jpg' || fileName=='txt'){
            document.getElementById('project_image').classList="form-control valid";
            document.getElementById('project_image_error').innerHTML='';
            $("#upload_customer").prop('disabled',false);
            $("#create_project").prop('disabled',false);
        }
        else if(fileInput.files[0] && fileInput.files[0].size>2097152){
            document.getElementById('project_image').classList="form-control error";
            document.getElementById('project_image_error').innerHTML='Size of image should not be more than 2MB';
            $("#create_project").prop('disabled',true);
        }else{
            document.getElementById('project_image').classList="form-control error";
            document.getElementById('project_image_error').innerHTML='Upload valid file types(jpeg,png,jpg,txt)';
            $("#create_project").prop('disabled',true);
        }
    }

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

            Object.keys(response).sort(function(a,b) {
                return response[a].name.localeCompare( response[b].name );
            }).forEach(function( key ) {
                $('#state').append('<option value="' + response[key].iso2 + '">' + response[key].name + '</option>');
            });

            // $.each(response, function (key, value) {
            //     $('#state').append('<option value="' + value.iso2 + '">' + value.name + '</option>');
            // });
        });
    });

    $(document).ready(function() {
        $('.chosen-select').chosen();
    });

    $('#commonModal').on('hidden.bs.modal', function () {
        location.reload();
    });

    function alphaOnly(input){
        let value = input.value;
        let numbers = value.replace(/[^a-zA-Z]/g, "");
        input.value = numbers;
    }
    function createProject(){

        var form = $("#create_project_form");
        if(form.valid()){
            let non_working=$('#non_working_days').val();
            if(non_working.length<=0){
                $("#non_working_days_error").show();
            }else{

            freeze_status = $("#freeze_status").val();
                if(freeze_status == 1){
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                    })
                    swalWithBootstrapButtons.fire({
                        title: 'Freezed',
                        text: "This Project Was Freezed! Please Contact Your Company.",
                        icon: 'warning',
                        showCancelButton: false,
                        confirmButtonText: 'Ok',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                        }
                    });
                }
                else{
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                    })
                    swalWithBootstrapButtons.fire({
                        title: 'Are you sure?',
                        text: "Do you want to submit changes?",
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var finishButton = form.find('a[href="#finish"]').removeAttr('href');
                            $(".loding_popup").modal('show');
                            form.submit();
                        }
                        else if (result.dismiss === Swal.DismissReason.cancel) {
                        }
                    });
                }
            }
        }

    }
</script>
