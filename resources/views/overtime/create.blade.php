{{Form::open(array('url'=>'overtime','method'=>'post'))}}
<div class="modal-body">

    {{ Form::hidden('employee_id',$employee->id, array()) }}

    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('title', __('Overtime Title'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::text('title',null, array('class' => 'form-control ','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('number_of_days', __('Number of days'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{ Form::number('number_of_days',null, array('class' => 'form-control ','required'=>'required','step'=>'0.01')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('hours', __('Hours'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{ Form::number('hours',null, array('class' => 'form-control ','required'=>'required','step'=>'0.01')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('rate', __('Rate'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{ Form::number('rate',null, array('class' => 'form-control ','required'=>'required','step'=>'0.01')) }}
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{ Form::close() }}

