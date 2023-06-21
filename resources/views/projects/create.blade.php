

<link rel="stylesheet" href="{{ asset('WizardSteps/css/wizard.css') }}">
<style>
    .chosen-container{
        width: 75%!important;
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
                                {{ Form::text('project_name', null, ['class' => 'form-control','required'=>'required']) }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {{ Form::label('location', __('Project Location'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                                {{ Form::text('location', null, ['class' => 'form-control','required'=>'required']) }}
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {{ Form::label('address', __('Projet Address'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                                {!! Form::textarea('address', null, ['class'=>'form-control','rows'=>'2', 'cols' => 4, 'required'=>'required']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {{ Form::label('client', __('Client'),['class'=>'form-label']) }}<span class="text-danger">*</span>
                                {!! Form::select('client', $clients, null,array('class' => 'form-control','required'=>'required')) !!}
                            </div>
                        </div>
                        <div class="form-group col-sm-6 col-md-6">
                            {{ Form::label('project_image', __('Project Image'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                            <div class="form-file mb-3">
                                <input type="file" class="form-control" id="project_image"  name="project_image">
                            </div>
                            <span id="project_image_error" class="error" for="project_image"></span>
                        </div>
                    </div>
                </section>

                <h3>{{ __('Project Members') }}</h3>
                <section>
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
                                {{ Form::label('report_time', __('Report Time'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                                {{ Form::time('report_time', null, ['class' => 'form-control', 'rows' => '4', 'cols' => '50','required'=>'required']) }}
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {{ Form::label('user', __('User'),['class'=>'form-label']) }}<span class="text-danger">*</span>
                                {!! Form::select('user[]', $users, null,array('class' => 'form-control','required'=>'required')) !!}
                            </div>
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
                </section>
            </div>
        {{Form::close()}}
    </div>
</div>

<script>
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
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                    // form.submit();
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

    $('#create_project_form').validate({
        rules: {
            non_working_days: "required",
        },
        ignore: ':hidden:not("#non_working_days")'
    });

    $('.get_non_working_days').on('change', function() {
        get_val = $(this).val();
        console.log("nonWorkingDays",get_val);

        if(get_val != ""){
            $("#non_working_days-error").hide();
        }
        else{
            $("#non_working_days-error").show();
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

    $(document).ready(function() {
        $('.chosen-select').chosen();
    });
</script>