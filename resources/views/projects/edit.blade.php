

<link rel="stylesheet" href="{{ asset('WizardSteps/css/wizard.css') }}">
<style>
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
        display: flex;
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
</style>
<div class="modal-body">
    <div class="container">
        {{ Form::model($project, ['route' => ['projects.update', $project->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'id' => 'create_project_form', 'class' => 'create_project_form']) }}
            {{ csrf_field() }}
            <div>
                <h3>{{ __('Project Details') }}</h3>
                <section>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                {{ Form::label('project_name', __('Project Name'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                                {{ Form::text('project_name', null, ['class' => 'form-control','required'=>'required']) }}
                                {{Form::hidden('freeze_statuss',$project->freeze_status,array('class'=>'form-control','id'=>'freeze_status'))}}
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
                                          <option value="{{$value->iso2}}" @if($project->country == $value->iso2) selected @endif>{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {{Form::label('state',__('State'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                                <select class="form-control" name="state" id='state' placeholder="Select State" required>
                                    <option value="">{{ __('Select State ...') }}</option>
                                    @foreach ($statelist as $state_display)
                                        <option value="{{$state_display->iso2}}" @if($project->state == $state_display->iso2) selected @endif>{{$state_display->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {{Form::label('city',__('City'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                                {{Form::text('city',null,array('class'=>'form-control','required'=>'required',
                                'oninput'=>'alphaOnly(this)'))}}
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {{Form::label('zip',__('Zip Code'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                                {{Form::text('zip',$project->zipcode,array('class'=>'form-control','id'=>'zip',
                                'required'=>'required', 'minlength'=>5))}}
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
                                {!! Form::select('client', $clients, $project->client_id,array('class' => 'form-control select2','id'=>'choices-multiple1','required'=>'required')) !!}
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                @php $reportto=explode(',',$project->report_to); @endphp
                                {{ Form::label('Users', __('Users'), ['class' => 'form-label']) }}<span class="text-danger">*</span> <br>
                                {!! Form::select('reportto[]', $repoter, $reportto ,array('class' => 'form-control chosen-select get_reportto','required'=>'required','multiple'=>'true','required'=>'required')) !!}
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
                                {{ Form::time('report_time', $project->report_time, ['class' => 'form-control', 'rows' => '4', 'cols' => '50']) }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-md-6">
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
                                @php $non_working_days_set=explode(',',$project->non_working_days); @endphp
                                {!! Form::select('non_working_days[]', $non_working_days, $non_working_days_set,
                                    array('id' => 'non_working_days','class' => 'form-control chosen-select get_non_working_days','multiple'=>'true','required'=>'required')) 
                                !!}
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {{Form::label('holidays',__('holiday_status'),['class'=>'form-label'])}}
                                <div style='display:flex;flex-wrap: wrap;align-content: stretch;'>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name='holidays' id='holidays' @if($project->holidays==1) checked @endif>
                                        <label class="form-check-label" for="holidays">
                                            {{__('holidays')}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>
                    @php
                        if($project->holidays==1){
                            $holiday_show = 'display:none;';
                        }
                        else{
                            $holiday_show = '';
                        }
                    @endphp
                    <div class="card-body table-border-style holidays_show_hide" style="overflow: scroll; height: 80%;{{$holiday_show}}">
                        {{Form::label('holiday',__('Add Project Holidays'),['class'=>'form-label'])}}
                        <div class="table-responsive holiday_table" id="holiday_table">
                            <table class="table" id="example2" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th><input class='check_all' type='checkbox' onclick="select_all_key()"/></th>
                                        <th>{{__('Date')}}</th>
                                        <th>{{__('Holiday Name')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $set_key = 1; @endphp
                                    @forelse ($project_holidays as $holiday_show)
                                            <tr data-count_id="{{$set_key}}" id="{{$set_key}}" class="duplicate_tr">
                                            <td><input type='checkbox' class='case'/></td>
                                            <td style="width: 30%;">
                                                <input value="{{$holiday_show->date}}" type="date" class="form-control holiday_date get_date" id="holiday_date{{$set_key}}" name="holiday_date[]">
                                                <label style='display:none;color:red;' class='holiday_date_label{{$set_key}}'>This Field is Required </label>
                                            </td>
                                            <td style="width: 70%;">
                                                <input value="{{$holiday_show->description}}" type="text" class="form-control holiday_description" id="holiday_description{{$set_key}}" name="holiday_description[]">
                                                <label style='display:none;color:red;' class='holiday_description_label{{$set_key}}'>This Field is Required </label>
                                            </td>
                                        </tr>
                                        @php $set_key++; @endphp
                                    @empty
                                        <td><input type='checkbox' disabled/></td>
                                        <td style="width: 30%;">
                                            <input type="date" data-date_id='1' class="form-control holiday_date get_date" id="holiday_date1" name="holiday_date[]">
                                            <label style='display:none;color:red;' class='holiday_date_label1'>This Field is Required </label>
                                        </td>
                                        <td style="width: 70%;">
                                            <input type="text" data-desc_id='1' class="form-control holiday_description" id="holiday_description1" name="holiday_description[]">
                                            <label style='display:none;color:red;' class='holiday_description_label1'>This Field is Required </label>
                                        </td>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <button type="button" class='btn btn-danger delete_key'><i class="fa fa-minus" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;Delete Table Row</button>
                        <button type="button" class='btn btn-primary addmore'><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;Add More Table Row</button>
                    </div>
                </section>

                <h3>{{ __('Project Status') }}</h3>
                <section>
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                                <select name="status" id="status" class="form-control main-element select2" required>
                                    <option value=''>Choose Status</option>
                                    @foreach(\App\Models\Project::$project_status as $k => $v)
                                        <option value="{{$k}}" {{ ($project->status == $k) ? 'selected' : ''}}>{{__($v)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
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

        form.children("div").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            onStepChanging: function (event, currentIndex, newIndex)
            {
                get_reportto         = $(".get_reportto").val();
                get_non_working_days = $(".get_non_working_days").val();

                if (newIndex < currentIndex) {
                    return true;
                }
                else if(currentIndex == 1 && newIndex == 2 && get_reportto == ""){
                    form.validate().settings.ignore = ":disabled";
                }
                else if(currentIndex == 2 && newIndex == 3 && get_non_working_days == ""){
                    form.validate().settings.ignore = ":disabled";
                }
                else if(currentIndex == 2 && newIndex == 3 && $("#holidays").prop('checked') == false){
                    if ($("#holidays").prop('checked') == false) {
                        holidayValidation();
                        if(check_validation == 1){
                            $(".current").attr('aria-disabled','true');
                            return false;
                        }
                        else{
                            $(".current").attr('aria-disabled','false');
                            $(".current").removeClass('error');
                        }
                    }
                    else{
                        $(".current").attr('aria-disabled','false');
                        $(".current").removeClass('error');
                    }
                }
                else{
                    form.validate().settings.ignore = ":disabled,:hidden";
                }
                
                return form.valid();
            },
            labels: {
                finish: 'Finish <i class="fa fa-chevron-right"></i>',
                next: 'Next <i class="fa fa-chevron-right"></i>',
                previous: '<i class="fa fa-chevron-left"></i> Previous'
            },
            onFinishing: function (event, currentIndex)
            {
                form.validate().settings.ignore = ":disabled,:hidden";
                return form.valid();
            },
            onFinished: function (event, currentIndex)
            {
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
                        }
                        else if (result.dismiss === Swal.DismissReason.cancel) {
                        }
                    });
                }
            }
        });
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
</script>