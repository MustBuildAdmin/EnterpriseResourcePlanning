<style>
    .form-check {
        margin: 8px 12px !important;
    }
    .chosen-container{
        width: 75%!important;
        height: fit-content;
    }
    </style>
{{ Form::model($project, ['route' => ['projects.update', $project->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                {{ Form::label('project_name', __('Project Name'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                {{ Form::text('project_name', null, ['class' => 'form-control']) }}
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
                {{ Form::label('client', __('Client'),['class'=>'form-label']) }}<span class="text-danger">*</span>
                {!! Form::select('client', $clients, $project->client_id,array('class' => 'form-control select2','id'=>'choices-multiple1','required'=>'required')) !!}
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                {{ Form::label('budget', __('Budget'), ['class' => 'form-label']) }}
                {{ Form::number('budget', null, ['class' => 'form-control']) }}
            </div>
        </div>
        {{-- <div class="col-6 col-md-6">
            <div class="form-group">
                {{ Form::label('estimated_hrs', __('Estimated Hours'),['class' => 'form-label']) }}
                {{ Form::number('estimated_hrs', null, ['class' => 'form-control','min'=>'0','maxlength' => '8']) }}
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
                @php $reportto=explode(',',$project->report_to); @endphp
                {{ Form::label('Reportto', __('Report To'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                {!! Form::select('reportto[]', $repoter, $reportto ,array('class' => 'form-control chosen-select','required'=>'required','multiple'=>'true','required'=>'required')) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                {{ Form::label('tag', __('Tag'), ['class' => 'form-label']) }}
                {{ Form::text('tag', isset($project->tags) ? $project->tags: '', ['class' => 'form-control', 'data-toggle' => 'tags']) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
                <select name="status" id="status" class="form-control main-element select2" required>
                    <option value=''>Choose Status</option>
                    @foreach(\App\Models\Project::$project_status as $k => $v)
                        <option value="{{$k}}" {{ ($project->status == $k) ? 'selected' : ''}}>{{__($v)}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                {{ Form::label('report_time', __('Report Time'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                {{ Form::time('report_time', $project->report_time, ['class' => 'form-control', 'rows' => '4', 'cols' => '50']) }}
                  {{-- {{ Form::time('report_time',  \App\Models\Utility::utc_to_originaltime($project->report_time,$setting), ['class' => 'form-control', 'rows' => '4', 'cols' => '50']) }} --}}
            </div>
        </div>
    </div>
    {{Form::label('non_working_days',__('non_working_days'),['class'=>'form-label'])}}<span class="text-danger">*</span>
                <br>
                <div style='display:flex;flex-wrap: wrap;align-content: stretch;'>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" name='non_working_days[]' id='monday' @if(str_contains($project->non_working_days, '1')) checked @endif required> 
                    <label class="form-check-label" for="monday">
                    Monday
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="2" name='non_working_days[]' id='tuesday' @if(str_contains($project->non_working_days, '2')) checked @endif required>
                    <label class="form-check-label" for="tuesday">
                    Tuesday
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="3" name='non_working_days[]' id='wednesday' @if(str_contains($project->non_working_days, '3')) checked @endif required>
                    <label class="form-check-label" for="wednesday">
                        Wednesday
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="4" name='non_working_days[]' id='thursday' @if(str_contains($project->non_working_days, '4')) checked @endif required>
                    <label class="form-check-label" for="thursday">
                        Thursday
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="5" name='non_working_days[]' id='friday' @if(str_contains($project->non_working_days, '5')) checked @endif required>
                    <label class="form-check-label" for="friday">
                        Friday
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="6" name='non_working_days[]' id='saturday' @if(str_contains($project->non_working_days, '6')) checked @endif required>
                    <label class="form-check-label" for="saturday">
                        Saturday
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="0" name='non_working_days[]' id='sunday' @if(str_contains($project->non_working_days, '7')) checked @endif required>
                    <label class="form-check-label" for="sunday">
                        Sunday
                    </label>
                </div>
                </div>
                {{Form::label('holidays',__('holiday_status'),['class'=>'form-label'])}}
                <div style='display:flex;flex-wrap: wrap;align-content: stretch;'>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name='holidays' id='holidays'@if($project->holidays==1) checked @endif>
                        <label class="form-check-label" for="holidays">
                            {{__('holidays')}}
                        </label>
                    </div>
            </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            {{ Form::label('project_image', __('Project Image'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
            <div class="form-file mb-3">
                <input type="file" class="form-control" id="project_image" name="project_image" >
            </div>
            <span id="project_image_error" class="error" for="project_image"></span>

            <img id="image"  src="{{asset(Storage::url($project->project_image))}}" class="avatar avatar-xl" alt="">
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" id="create_project"  value="{{__('Update')}}" class="btn  btn-primary">
</div>
{{Form::close()}}


<script>
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
    document.getElementById('project_image').onchange = function () {
        var fileInput =  document.getElementById("project_image");
        var fileName=fileInput.files[0].name.substring(fileInput.files[0].name.lastIndexOf('.') + 1);
        if(fileName=='jpeg' || fileName=='png' || fileName=='jpg' || fileName=='txt'){
            document.getElementById('project_image').classList="form-control valid";
            document.getElementById('project_image_error').innerHTML='';
        }
        else if(fileInput.files[0] && fileInput.files[0].size>2097152){
            document.getElementById('project_image').classList="form-control error";
            document.getElementById('project_image_error').innerHTML='Size of image should not be more than 2MB';
            document.getElementById('create_project').disabled=true;
        }else{
            document.getElementById('project_image').classList="form-control error";
            document.getElementById('project_image_error').innerHTML='Upload valid file types(jpeg,png,jpg,txt)';
            document.getElementById('create_project').disabled=true;
        }
        var src = URL.createObjectURL(this.files[0])
        document.getElementById('image').src = src
    }
    $(document).ready(function() {
        $(document).ready(function() {
            $('.chosen-select').chosen();
        });
  });
</script>