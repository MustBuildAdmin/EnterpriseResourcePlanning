{{ Form::model($transfer, array('route' => array('bank-transfer.update', $transfer->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-6">
            {{ Form::label('from_account', __('From Account'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{ Form::select('from_account', $bankAccount,null, array('class' => 'form-select','id' => "choices-multiple",'required'=>'required')) }}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('to_account', __('To Account'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{ Form::select('to_account', $bankAccount,null, array('class' => 'form-select','id' => "choices-multiple1",'required'=>'required')) }}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('amount', __('Amount'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{ Form::number('amount', null, array('class' => 'form-control','required'=>'required','step'=>'0.01')) }}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('date', __('Date'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{Form::date('date',null,array('class'=>'form-control','required'=>'required'))}}
        </div>

        <div class="form-group  col-md-6">
            {{ Form::label('reference', __('Reference'),['class'=>'form-label']) }}
            {{ Form::text('reference', null, array('class' => 'form-control')) }}
        </div>

        <div class="form-group  col-md-12">
            {{ Form::label('description', __('Description'),['class'=>'form-label']) }}
            {{ Form::textarea('description', null, array('class' => 'form-control','rows'=>3)) }}
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>
{{ Form::close() }}


