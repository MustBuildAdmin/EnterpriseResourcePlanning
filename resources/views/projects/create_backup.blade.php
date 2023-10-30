<style>
    .form-check {
        margin: 8px 12px !important;
    }
    .chosen-container{
        width: 75%!important;
        height: fit-content;
    }
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

{{ Form::open(['url' => 'projects', 'method' => 'post','enctype' => 'multipart/form-data', 'id' => 'create_project_form', 'class' => 'create_project_form']) }}
<div class="modal-body">
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
        <div class="form-group col-sm-12 col-md-12">
            {{ Form::label('project_image', __('Project Image'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
            <div class="form-file mb-3">
                <input type="file" class="form-control" id="project_image"  name="project_image" required>
            </div>
            <span id="project_image_error" class="invalid-feedback" for="project_image"></span>
        </div>
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                {{ Form::label('client', __('Client'),['class'=>'form-label']) }}<span class="text-danger">*</span>
                {!! Form::select('client', $clients, null,array('class' => 'form-control','required'=>'required')) !!}
            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                {{ Form::label('user', __('User'),['class'=>'form-label']) }}<span class="text-danger">*</span>
                {!! Form::select('user[]', $users, null,array('class' => 'form-control','required'=>'required')) !!}
            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                {{ Form::label('budget', __('Budget'), ['class' => 'form-label']) }}
                {{ Form::number('budget', null, ['class' => 'form-control']) }}
            </div>
        </div>
        {{-- <div class="col-6 col-md-6">
            <div class="form-group">
                {{ Form::label('estimated_hrs', __('Estimated Hours'),['class' => 'form-label']) }}
                {{ Form::text('estimated_hrs', null, ['class' => 'form-control','min'=>'0','maxlength' => '8']) }}
            </div>
        </div> --}}
        <div class="col-6 col-md-6">
            <div class="form-group">
                {{ Form::label('estimated_days', __('Estimated Days'),['class' => 'form-label']) }}
                {{ Form::text('estimated_days', null, ['class' => 'form-control' ,'readonly'=>true]) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
                {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '4', 'cols' => '50']) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                {{ Form::label('Reportto', __('Report To'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                {!! Form::select('reportto[]', $repoter, null,array('id' => 'reportto','class' => 'form-control chosen-select get_reportto','multiple'=>'true','required'=>'required')) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                {{ Form::label('tag', __('Tag'), ['class' => 'form-label']) }}
                {{ Form::text('tag', null, ['class' => 'form-control', 'data-toggle' => 'tags']) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                <select name="status" id="status" class="form-control main-element" required>
                    <option value=''>Choose Status</option>
                    @foreach(\App\Models\Project::$project_status as $k => $v)
                        <option value="{{$k}}">{{__($v)}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                {{ Form::label('report_time', __('Report Time'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                {{ Form::time('report_time', null, ['class' => 'form-control', 'rows' => '4', 'cols' => '50']) }}
            </div>
        </div>
    </div>
    {{Form::label('non_working_days',__('non_working_days'),['class'=>'form-label'])}}<span class="text-danger">*</span>
    <br>
    <div style='display:flex;flex-wrap: wrap;align-content: stretch;'>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="1" name='non_working_days[]' id='monday' required>
        <label class="form-check-label" for="monday">
        Monday
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="2" name='non_working_days[]' id='tuesday' required>
        <label class="form-check-label" for="tuesday">
        Tuesday
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="3" name='non_working_days[]' id='wednesday' required>
        <label class="form-check-label" for="wednesday">
            Wednesday
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="4" name='non_working_days[]' id='thursday' required>
        <label class="form-check-label" for="thursday">
            Thursday
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="5" name='non_working_days[]' id='friday' required>
        <label class="form-check-label" for="friday">
            Friday
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="6" name='non_working_days[]' id='saturday' required>
        <label class="form-check-label" for="saturday">
            Saturday
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="0" name='non_working_days[]' id='sunday' required>
        <label class="form-check-label" for="sunday">
            Sunday
        </label>
    </div>
</div>
<br>
{{Form::label('holidays',__('holiday_status'),['class'=>'form-label'])}}
<div style='display:flex;flex-wrap: wrap;align-content: stretch;'>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="1" name='holidays' id='holidays'>
        <label class="form-check-label" for="holidays">
            {{__('holidays')}}
        </label>
    </div>
</div>
<br>
@if($setting['company_type']==2)
    {{ Form::label('file_type', __('Project File Type'), ['class' => 'form-label']) }}
    <select name="file_status" id="file_status" class="form-control main-element" >
        <option value=''>Choose File Type</option>
        <option value='M'>Manual</option>
        <option value='MP'>Microsoft Project</option>
        <option value='P'>Primavera</option>
    </select>
    <br>
    <input type='file' name='file' id='file' accept=".mpp">
    <br>
@endif
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" id="create_project" value="{{__('Create')}}" class="btn  btn-primary">
    
</div>
<div class="hide" style='display:none;'>
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
<br><h3 style="text-align: center;padding: 2px;background-color: #206bc4;color: white;">Loading... , kindly don't close the pop-up window</h3><br>
</div>
{{Form::close()}}

<script>
$(document).on("click", '#file_status', function () {
    var status=$(this).val();
    if(status=='MP'){
        $('#file').attr('accept','.mpp');
    }else{
        $('#file').attr('accept','.xer');
    }
});
$(document).on("change", '#start_date', function () {
    var start=$('#start_date').val();
    $('#end_date').val('');
    $('#end_date').attr('min',start);
});
// $(document).on("click", '#create_project', function () {
    
//     $('.hide').show();
//     return true;
//     // $('#create_project').attr('disabled','true');
// });
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
            reportto: "required",
        },
        ignore: ':hidden:not("#reportto")'
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

    $(document).ready(function() {
        $('.chosen-select').chosen();
    });
    

  </script>