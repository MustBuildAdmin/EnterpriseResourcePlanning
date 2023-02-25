<div class="card bg-none card-box">
    {{ Form::model($estimation, array('route' => array('estimations.update', $estimation->id), 'method' => 'PUT')) }}
    <div class="row">
        <div class="col-6 form-group">
            {{ Form::label('client_id', __('Client'),['class'=>'form-label']) }}
            {{ Form::select('client_id', $client,null, array('class' => 'form-control select2','required'=>'required')) }}
        </div>
        <div class="col-6 form-group">
            {{ Form::label('status', __('Status'),['class'=>'form-label']) }}
            {{ Form::select('status', \App\Models\Estimation::$statues,null, array('class' => 'form-control select2','required'=>'required')) }}
        </div>
        <div class="col-6 form-group">
            {{ Form::label('issue_date', __('Issue Date'),['class'=>'form-label']) }}
            {{ Form::text('issue_date',null, array('class' => 'form-control datepicker','required'=>'required')) }}
        </div>
        <div class="col-6 form-group">
            {{ Form::label('discount', __('Discount'),['class'=>'form-label']) }}
            {{ Form::number('discount',null, array('class' => 'form-control','required'=>'required','min'=>"0")) }}
        </div>
        <div class="col-6 form-group">
            {{ Form::label('tax_id', __('Tax %'),['class'=>'form-label']) }}
            {{ Form::select('tax_id', $taxes,null, array('class' => 'form-control select2','required'=>'required')) }}
        </div>
        <div class="col-12 form-group">
            {{ Form::label('terms', __('Terms'),['class'=>'form-label']) }}
            {{ Form::textarea('terms',null, array('class' => 'form-control')) }}
        </div>
        <div class="col-12 text-end">
            <input type="submit" value="{{__('Update')}}" class="btn-create badge-blue">
            <input type="button" value="{{__('Cancel')}}" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    {{ Form::close() }}
</div>
