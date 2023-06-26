

<link rel="stylesheet" href="{{ asset('WizardSteps/css/wizard.css') }}">
<style>
    .chosen-container{
        width: 100%!important;
        height: fit-content;
    }
</style>
<div class="modal-body">
    <div class="container">
        {{ Form::open(['url' => 'projects', 'method' => 'post','enctype' => 'multipart/form-data', 'id' => 'create_project_form', 'class' => 'create_project_form']) }}
            <div>
                <h3>{{ __('Project Details') }}</h3>
                <section>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                {{ Form::label('project_name', __('Project Name'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                                {{ Form::text('project_name', null, ['class' => 'form-control project_name','required'=>'required']) }}
                                <span class="invalid-name show_duplicate_error" role="alert" style="display: none;">
                                    <strong class="text-danger">Project Name Already Exist!</strong>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {{Form::label('country',__('Country'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                                <select class="form-control country" name="country" id='country' placeholder="Select Country" required>
                                    <option value="">{{ __('Select Country ...') }}</option>
                                    @foreach($country as $key => $value)
                                          <option value="{{$value->iso2}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {{Form::label('state',__('State'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                                <select class="form-control" name="state" id='state' placeholder="Select State" required>
                                    <option value="">{{ __('Select State ...') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {{Form::label('city',__('City'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                                {{Form::text('city',null,array('class'=>'form-control','required'=>'required'))}}
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {{Form::label('zip',__('Zip Code'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                                {{Form::text('zip',null,array('class'=>'form-control','id'=>'zip','required'=>'required'))}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {{Form::label('latitude',__('Latitude'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                                {{Form::text('latitude',null,array('class'=>'form-control','id'=>'latitude','required'=>'required'))}}
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {{Form::label('longitude',__('Longitude'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                                {{Form::text('longitude',null,array('class'=>'form-control','id'=>'longitude','required'=>'required'))}}
                            </div>
                        </div>
                    </div>
                </section>

                <h3>{{ __('Project Members') }}</h3>
                <section>
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {{ Form::label('client', __('Client'),['class'=>'form-label']) }}<span class="text-danger">*</span>
                                {!! Form::select('client', $clients, null,array('class' => 'form-control','required'=>'required')) !!}
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {{ Form::label('Users', __('Users'), ['class' => 'form-label']) }}<span class="text-danger">*</span> <br>
                                {!! Form::select('reportto[]', $repoter, null,array('id' => 'reportto','class' => 'form-control chosen-select get_reportto','multiple'=>'true','required'=>'required')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                                {{ Form::date('start_date', null, ['class' => 'form-control','required'=>'required']) }}
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                                {{ Form::date('end_date', null, ['class' => 'form-control','required'=>'required']) }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {{ Form::label('estimated_days', __('Estimated Days'),['class' => 'form-label']) }}
                                {{ Form::text('estimated_days', null, ['class' => 'form-control' ,'readonly'=>true]) }}
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {{ Form::label('report_time', __('Report Time'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                                {{ Form::time('report_time', null, ['class' => 'form-control', 'rows' => '4', 'cols' => '50','required'=>'required']) }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {{ Form::label('project_image', __('Project Image'), ['class' => 'form-label']) }}
                                <input type="file" class="form-control" id="project_image"  name="project_image">
                            </div>
                            <span id="project_image_error" class="error" for="project_image"></span>
                        </div>
                    </div>
                </section>

                <h3>{{ __('Project Holidays') }}</h3>
                <section>
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {{Form::label('non_working_days',__('non_working_days'),['class'=>'form-label'])}}<span class="text-danger">*</span>
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
                                    array('id' => 'non_working_days','class' => 'form-control chosen-select get_non_working_days','multiple'=>'true','required'=>'required')) 
                                !!}
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {{Form::label('holidays',__('holiday_status'),['class'=>'form-label'])}}
                                <div style='display:flex;flex-wrap: wrap;align-content: stretch;'>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" name='holidays' id='holidays'>
                                        <label class="form-check-label" for="holidays">
                                            {{__('holidays')}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="card-body table-border-style holidays_show_hide" style="overflow: scroll; height: 80%;">
                        {{Form::label('holiday',__('Add Extra Project Holiday'),['class'=>'form-label'])}}
                        <div class="table-responsive holiday_table" id="holiday_table">
                            <table class="table" id="example2" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th><input class='check_all' type='checkbox' onclick="select_all_key()"/></th>
                                        <th>{{__('Date')}}</th>
                                        <th>{{__('Description')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-count_id="1" id="1">
                                        <td><input type='checkbox' disabled/></td>
                                        <td style="width: 30%;"><input type="date" class="form-control holiday_date get_date" id="holiday_date1" name="holiday_date[]"></td>
                                        <td style="width: 70%;"><input type="text" class="form-control holiday_description" id="holiday_description1" name="holiday_description[]"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <br>
                        <button type="button" class='btn btn-danger delete_key'><i class="fa fa-minus" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;Delete Table Row</button>
                        <button type="button" class='btn btn-primary addmore'><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;Add More Table Row</button>
                    </div>
                </section>

                <h3>{{ __('Project Import or Manual') }}</h3>
                <section>
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                @if($setting['company_type']==2)
                                    {{ Form::label('file_type', __('Project File Type'), ['class' => 'form-label']) }}
                                    <select name="file_status" id="file_status" class="form-control main-element" >
                                        <option value=''>Choose File Type</option>
                                        <option value='M'>Manual</option>
                                        <option value='MP'>Microsoft Project</option>
                                        <option value='P'>Primavera</option>
                                    </select>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 outside_file" style="display:none;">
                            {{ Form::label('file_type', __('Microsoft Project File Type'), ['class' => 'form-label mp_file_lable','style'=>'display:none;']) }}
                            {{ Form::label('file_type', __('Primavera File Type'), ['class' => 'form-label prima_file_label','style'=>'display:none;']) }}
                            <input type='file' name='file' id='file' accept=".mpp">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            {{ Form::label('boq', __('Upload a BOQ File Here'), ['class' => 'form-label boq_file']) }}
                            <input type='file' name='boq_file' id='boq_file' accept=".xlsx, .xls, .csv">
                        </div>
                    </div>
                </section>
            </div>
        {{Form::close()}}
    </div>
</div>

<script>

    var key_i=2;
    $(document).on("click", '.addmore', function () {
        var data="<tr id='"+key_i+"' class='duplicate_tr'>"+
            "<td><input type='checkbox' class='case'/></td>";
            data +="<td><input class='form-control holiday_date get_date' type='date' id='holiday_date"+key_i+"' name='holiday_date[]'/></td>"+
            "<td><input class='form-control holiday_description' type='text' id='holiday_description"+key_i+"' name='holiday_description[]'/></td>"+
        "</tr>";

        console.log("data",data);

        $('.holiday_table tbody').append(data);
        key_i++;
    });

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

    var form = $("#create_project_form");

    form.children("div").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        onStepChanging: function (event, currentIndex, newIndex)
        {
            if(currentIndex == 2){
                form.validate().settings.ignore = ":disabled";
            }
            else{
                form.validate().settings.ignore = ":disabled,:hidden";
            }
            return form.valid();
        },
        onFinishing: function (event, currentIndex)
        {
            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
        },
        onFinished: function (event, currentIndex)
        {
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
                    form.submit();
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {
                }
            });
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
            $("#non_working_days-error").hide();
        }
        else{
            $("#non_working_days-error").show();
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
            $.each(response, function (key, value) {
                $('#state').append('<option value="' + value.iso2 + '">' + value.name + '</option>');
            });
        });
    });

    $(document).ready(function() {
        $('.chosen-select').chosen();
    });

    $('#commonModal').on('hidden.bs.modal', function () {
        location.reload();
    });

    $(document).on("keyup", '.project_name', function () {
        $(".show_duplicate_error").css('display','none');
        $.ajax({
            url : '{{ route("checkDuplicateProject") }}',
            type : 'GET',
            data : { 'get_name' : $(".project_name").val(),'form_name' : "ProjectCreate" },
            success : function(data) {
                if(data == 1){
                    $(".show_duplicate_error").css('display','none');
                }
                else{
                    $(".show_duplicate_error").css('display','block');
                }
            },
            error : function(request,error)
            {
                alert("Request: "+JSON.stringify(request));
            }
        });
    });
</script>