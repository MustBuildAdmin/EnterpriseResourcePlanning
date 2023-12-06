

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
ul.chosen-choices {
    background-image: none !important;
    height: 33.47px !important;
    box-shadow: none !important;
    border-radius: 3px;
    border: var(--tblr-border-width) solid var(--tblr-border-color) !important;
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
    .new {
        padding: 50px;
    }
    .nonworkingdays{
        margin-top: 8px;
    }
    .checkbox_group {
        display: block !important;
        margin-bottom: 15px;
        margin-top:28px;
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
        {{ Form::open(['url' => 'projects', 'method' => 'post','enctype' => 'multipart/form-data',
             'id' => 'create_project_form', 'class' => 'create_project_form']) }}
            <div>
                <section>
                    <div class="row">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {{ Form::label('project_name', __('Project Name'), ['class' => 'form-label']) }}
                                <span class="text-danger">*</span>
                                {{ Form::text('project_name', null, ['class' => 'form-control project_name',
                                    'id'=>'project_name','required'=>'required','placeholder'=>'Enter Project Name']) }}
                                <span class="invalid-name show_duplicate_error" role="alert" style="display: none;">
                                    <strong class="text-danger">Project Name Already Exist!</strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {{ Form::label('client', __('Client'),['class'=>'form-label']) }}
                                <span class="text-danger">*</span>
                                {!! Form::select('client', $clients, null,array('class' => 'form-control',
                                    'required'=>'required')) !!}
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {{ Form::label('Users', __('Manager'), ['class' => 'form-label']) }}
                                <span class="text-danger">*</span> <br>
                                {!! Form::select('reportto', $repoter, null,array('id' => 'reportto',
                                    'class' => 'form-control get_reportto','required'=>'required')) !!}
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {{Form::label('country',__('Country'),array('class'=>'form-label')) }}
                                <span style='color:red;'>*</span>
                                <select class="form-control country" name="country" id='country_wizard'
                                placeholder="Select Country" required>
                                    <option value="">{{ __('Select Country ...') }}</option>
                                    @foreach($country as $key => $value)
                                          <option value="{{$value->iso2}}">{{$value->name}}</option>
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
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {{Form::label('city',__('City'),array('class'=>'form-label')) }}
                                <span style='color:red;'>*</span>
                                {{Form::text('city',null,array('class'=>'form-control',
                                    'required'=>'required','placeholder'=>'Enter City',
                                'oninput'=>'alphaOnly(this)'))}}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                       
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {{Form::label('zip',__('Zip Code'),array('class'=>'form-label')) }}
                                <span style='color:red;'>*</span>
                                {{Form::number('zip',null,array('class'=>'form-control','id'=>'zip',
                                'required'=>'required', 'minlength'=>5,'placeholder'=>'Enter zip code'))}}
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {{Form::label('latitude',__('Latitude'),array('class'=>'form-label')) }}
                                <span style='color:red;'>*</span>
                                {{Form::text('latitude',null,array('class'=>'form-control','id'=>'latitude',
                                    'required'=>'required','placeholder'=>'Enter latitude'))}}
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {{Form::label('longitude',__('Longitude'),array('class'=>'form-label')) }}
                                <span style='color:red;'>*</span>
                                {{Form::text('longitude',null,array('class'=>'form-control',
                                    'id'=>'longitude','required'=>'required','placeholder'=>'Enter longitude'))}}
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
                                    'required'=>'required','placeholder'=>'Enter start date']) }}
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
                                <span class="text-danger">*</span>
                                {{ Form::date('end_date', null, ['class' => 'form-control',
                                    'required'=>'required','placeholder'=>'Enter end date']) }}
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {{ Form::label('estimated_days', __('Estimated Days'),['class' => 'form-label']) }}
                                {{ Form::text('estimated_days', null,
                                ['class' => 'form-control estimated_days' ,'readonly'=>true,
                                'placeholder'=>'Enter estimated days']) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {{ Form::label('project_image', __('Project Image'), ['class' => 'form-label']) }}
                                <input type="file" class="form-control" id="project_image"  name="project_image">
                            </div>
                            <span id="project_image_error" class="invalid-feedback" for="project_image"></span>
                        </div>
                        <div class="col-sm-4 col-md-4 nonworkingdays">
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
                                {!! Form::select('non_working_days[]', $non_working_days, null,
                                    array('id' => 'non_working_days','class' => 'form-control
                                    chosen-select get_non_working_days','multiple'=>'true','required'=>'required',
                                    'data-placeholder'=>'Select non working days'
                                   ))
                                !!}
                            </div>
                            <span id="non_working_days_error" class="error" for="non_working_days">
                                This field is required</span>
                        </div>
                        
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {{ Form::label('report_time', __('Report Time'), ['class' => 'form-label']) }}
                                <span class="text-danger">*</span>
                                <select class="form-control" name="report_time" id='report_time'
                                 placeholder="Select Report Time" required>
                                    <option value="">{{ __('Select Report Time ...') }}</option>
                                    <?php foreach($reportingtime as $key=>$value){
                                        echo '<option value="'.$key.':00">'.$value.'</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group checkbox_group">
                                <input type="checkbox" id="micro_program" name="micro_program">
                                <label for="micro_program">Do you want Look-a-head</label>
                            </div>
                        </div>
                    </div>
                </section>
                
                <section>
                    <div class="row mb-3">
                            <div class="form-group">
                                @if($setting['company_type']==2)
                                    {{ Form::label('file_type', __('Select a Method'), ['class' => 'form-label']) }}
                                    <div class="mt-3">
                                        <label class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" value='M'
                                             name="file_status" checked="" id="file_status">
                                            <span class="form-check-label">Manual Method</span>
                                        </label>
                                        <label class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" value='MP'
                                             name="file_status" id="file_status">
                                            <span class="form-check-label">Import your project from Mircosoft's
                                                 Project Management (MPP)</span>
                                        </label>
                                        <label class="form-check form-check-inline">
                                            <input class="form-check-input" value='P' type="radio"
                                             name="file_status" id="file_status">
                                            <span class="form-check-label">Import your project from Orcale's
                                                 Primavera (XER)</span>
                                        </label>
                                    </div>
                                @endif
                        </div>
                        <div class="col-sm-6 col-md-6 outside_file" style="display:none;">
                            <div class="upload-btn-wrapper">
                                <button class="btn">Upload a file</button>
                                <input type='file' name='file' id='file' accept=".mpp">
                            </div>
                        </div>

                       
                    </div>
                    <button type="button" class="btn btn-primary createProject"
                       onclick="createProject();">Create</button>
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
    var key_i=2;
    check_validation = 0;
    $(document).on("click", '.addmore', function () {

        if ($("#holidays").prop('checked') == false) {
            holidayValidation();
        }

        if(check_validation == 0){
            var data="<tr id='"+key_i+"' class='duplicate_tr'>"+
                "<td><input type='checkbox' class='case'/></td>";
                data +="<td><input class='form-control holiday_date get_date' type='date' data-date_id='"+key_i+"' id='holiday_date"+key_i+"' name='holiday_date[]'/> <label style='display:none;color:red;' class='holiday_date_label"+key_i+"'>This Field Is Required </label></td>"+
                "<td><input class='form-control holiday_description' type='text' data-desc_id='"+key_i+"' id='holiday_description"+key_i+"' name='holiday_description[]'/> <label style='display:none;color:red;' class='holiday_description_label"+key_i+"'>This Field Is Required </label></td>"+
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

   

    $(document).on("change", '#file_status', function () {
        var status=$(this).val();
        if(status=='MP'){
            $('#file').attr('accept','.mpp');
            $(".outside_file").show();
            $(".mp_file_lable").show();
            $(".prima_file_label").hide();
        }else if(status=='P'){
            $('#file').attr('accept','.xer');
            $(".outside_file").show();
            $(".prima_file_label").show();
            $(".mp_file_lable").hide();
        }
        else{
            $(".outside_file").hide();
        }
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
        $('#estimated_days').val(estimated_days);
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

    $(document).on("change", '#country_wizard', function () {
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

            // $.each(response.sort(), function (key, value) {
            //     $('#state').append('<option value="' + value.iso2 + '">' + value.name + '</option>');
            // });
        });
    });

    $(document).ready(function() {
        $('.chosen-select').chosen({
            default_multiple_text:"Select Non working days"
        });
    });

    $('#commonModal').on('hidden.bs.modal', function () {
        location.reload();
    });

    // $(document).on("keyup", '.project_name', function () {
    //     $(".show_duplicate_error").css('display','none');
    //     $.ajax({
    //         url : '{{ route("checkDuplicateProject") }}',
    //         type : 'GET',
    //         data : { 'project_name' : $(".project_name").val(),'form_name' : "ProjectCreate" },
    //         success : function(data) {
    //             console.log(data,typeof(data))
    //             if(data == 1){
    //                 $(".show_duplicate_error").css('display','none');
    //             }
    //             else{
    //                 $(".show_duplicate_error").css('display','block');
    //             }
    //         },
    //         error : function(request,error)
    //         {
    //             alert("Request: "+JSON.stringify(request));
    //         }
    //     });
    // });

    function alphaOnly(input){
        let value = input.value;
        let numbers = value.replace(/[^a-zA-Z]/g, "");
        input.value = numbers;
    }
    $(function ()
    {
        var form = $("#create_project_form");

        form.validate({
            rules: {
                project_name: {
                    required: true,
                    remote: {
                        url: '{{ route("checkDuplicateProject") }}',
                        data: { 'form_name' : "ProjectCreate" },
                        type: "GET"
                    }
                },
                latitude: {
                    required: true,
                    latCoord: true
                },
                longitude: {
                    required: true,
                    longCoord: true
                },
                non_working_days:{
                    required:true
                }
            },
            messages: {
                project_name: {
                    remote: "Sorry, that project name already exists!"
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
    function createProject(){
       
            var form = $("#create_project_form");
        if(form.valid()){
            let non_working=$('#non_working_days').val();
        if(non_working.length<=0){
            $("#non_working_days_error").show();
        }else{

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "Do You Want Create Project?",
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
                    $(".createProject").prop('disabled',true);
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {
                }
            });
        }
    }
       
    }
  
</script>