    {{ Form::model($bugStatus, array('route' => array('bugstatus.update', $bugStatus->id), 'method' => 'PUT')) }}
    <div class="modal-body">

    <div class="row">
        <div class="form-group col-12">
            {{ Form::label('title', __('Bug Status Title'),['class'=>'form-label']) }}
            {{ Form::text('title',null, array('class' => 'form-control','required'=>'required')) }}
        </div>

    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn btn-primary">
</div>
    {{ Form::close() }}

