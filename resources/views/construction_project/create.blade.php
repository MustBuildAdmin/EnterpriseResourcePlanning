<style>
.form-check {
    margin: 8px 12px !important;
}
</style>

{{Form::open(array('url'=>'construction_project','method'=>'post'))}}
<div class="modal-body">

    <div class="row">
        <div class="col-12">
            <div class="form-group">
                {{Form::label('name',__('Name'),['class'=>'form-label'])}}<span class="text-danger">*</span>
                {{Form::text('name',null,array('class'=>'form-control','required' => 'required','placeholder'=>__('Enter Project Name')))}}
                <span class="invalid-name" role="alert">
                    <strong class="text-danger" id='error'></strong>
                </span>
                <br>
                {{Form::label('project_location',__('Project_Location'),['class'=>'form-label'])}}<span class="text-danger">*</span>
                {{Form::text('project_location',null,array('class'=>'form-control','required' => 'required','placeholder'=>__('Enter Project Location')))}}
                <br>
                {{Form::label('start_date',__('Start Date'),['class'=>'form-label'])}}<span class="text-danger">*</span>
                {{Form::date('start_date',null,array('class'=>'form-control','required' => 'required'))}}
                <br>
                {{Form::label('end_date',__('End Date'),['class'=>'form-label'])}}<span class="text-danger">*</span>
                {{Form::date('end_date',null,array('class'=>'form-control','required' => 'required'))}}
                <br>
                {{Form::label('project_budget',__('Project Budget'),['class'=>'form-label'])}}<span class="text-danger">*</span>
                {{Form::number('project_budget',null,array('class'=>'form-control','min'=>1,'required' => 'required'))}}
                <br>
                {{ Form::label('client', __('Client'),['class'=>'form-label']) }}<span class="text-danger">*</span>
                {!! Form::select('client', $clients, null,array('class' => 'form-control','required'=>'required')) !!}
                <br>
                {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                <select name="status" id="status" class="form-control main-element">
                    @foreach(\App\Models\Construction_project::$project_status as $k => $v)
                        <option value="{{$k}}">{{__($v)}}</option>
                    @endforeach
                </select>
                <br>
                {{Form::label('non_working_days',__('non_working_days'),['class'=>'form-label'])}}<span class="text-danger">*</span>
                <br>
                <div style='display:flex;flex-wrap: wrap;align-content: stretch;'>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" name='non_working_days[]' id='monday'>
                    <label class="form-check-label" for="monday">
                    Monday
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="2" name='non_working_days[]' id='tuesday'>
                    <label class="form-check-label" for="tuesday">
                    Tuesday
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="3" name='non_working_days[]' id='wednesday'>
                    <label class="form-check-label" for="wednesday">
                        Wednesday
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="4" name='non_working_days[]' id='thursday'>
                    <label class="form-check-label" for="thursday">
                        Thursday
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="5" name='non_working_days[]' id='friday'>
                    <label class="form-check-label" for="friday">
                        Friday
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="6" name='non_working_days[]' id='saturday'>
                    <label class="form-check-label" for="saturday">
                        Saturday
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="7" name='non_working_days[]' id='sunday'>
                    <label class="form-check-label" for="sunday">
                        Sunday
                    </label>
                </div>
            </div>
            <br>
            {{Form::label('holidays',__('holiday_status'),['class'=>'form-label'])}}<span class="text-danger">*</span>
            <div style='display:flex;flex-wrap: wrap;align-content: stretch;'>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" name='holidays' id='monday'>
                    <label class="form-check-label" for="monday">
                        {{__('holidays')}}
                    </label>
                </div>
            </div>
            <br>
                {{ Form::label('file_type', __('Project File Type'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                <select name="status" id="status" class="form-control main-element">
                    <option value='MP'>Microsoft Project<option>
                    <option value='P'>Primavera<option>
                </select>
                <br>
                <input type='file' name='file' id='file'>
                <br>
                @error('name')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{Form::close()}}

<script>
var tempcsrf = '{!! csrf_token() !!}';
$(document).on("keyup", '#name', function () {
    var tt= $(this).val().length;
    if(tt>3){
        var name= $(this).val();
        $.ajax({
        url: "{{ route('construction_name_presented') }}",
        type: "GET",
            data: {
                _token: tempcsrf,
                name: name
            },
            success: function(data) {
                if(data=='in'){
                    // show_toastr('error', 'Please enter valid date');
                    $('#error').text('Project Name already exit');
                }else{
                    $('#error').text('');
                }
                
            },
        });
        
    }
});


</script>

