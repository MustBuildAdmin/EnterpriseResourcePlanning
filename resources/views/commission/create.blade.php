{{Form::open(array('url'=>'commission','method'=>'post'))}}
{{ Form::hidden('employee_id',$employee->id, array()) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('title', __('Title'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{ Form::text('title',null, array('class' => 'form-control ','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('type', __('Type'), ['class' => 'form-label']) }}<span style='color:red;'>*</span>
            {{ Form::select('type', $commissions, null, ['class' => 'form-select amount_type', 'required' => 'required']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('amount', __('Amount'),['class'=>'form-label amount_label']) }}<span style='color:red;'>*</span>
            {{ Form::number('amount',null, array('class' => 'form-control amount_input ','required'=>'required','step'=>'0.01')) }}
        </div>

    </div>
</div>
    <div class="modal-footer">
        <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
    </div>
{{ Form::close() }}
