{{ Form::model($deal, array('route' => array('deals.clients.update', $deal->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <div class="col-12 form-group">
            {{ Form::label('clients', __('Clients'),['class'=>'form-label']) }}
            {{ Form::select('clients[]', $clients,false, array('class' => 'form-control select2','id'=>'choices-multiple1','multiple'=>'','required' => 'required')) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{Form::close()}}
