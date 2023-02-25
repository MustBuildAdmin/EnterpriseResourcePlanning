{{ Form::model($deal, array('route' => array('deals.discussion.store', $deal->id), 'method' => 'POST')) }}
<div class="modal-body">
    <div class="row">
        <div class="col-12 form-group">
            {{ Form::label('comment', __('Message'),['class'=>'form-label']) }}
            {{ Form::textarea('comment', null, array('class' => 'form-control')) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{Form::close()}}



