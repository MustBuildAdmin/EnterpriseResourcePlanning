{{ Form::model($lead, array('route' => array('leads.sources.update', $lead->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <div class="col-12 form-group">
            <div class="row gutters-xs">
                @foreach ($sources as $source)
                    <div class="col-12 custom-control custom-checkbox mt-2 mb-2">
                        {{ Form::checkbox('sources[]',$source->id,($selected && array_key_exists($source->id,$selected))?true:false,['class' => 'form-check-input','id'=>'sources_'.$source->id]) }}
                        {{ Form::label('sources_'.$source->id, ucfirst($source->name),['class'=>'form-check-label']) }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{Form::close()}}


