<div class="card bg-none card-box">
    {{ Form::model($leadstages, array('route' => array('projectstages.update', $leadstages->id), 'method' => 'PUT')) }}
    <div class="row">
        <div class="form-group col-12">
            {{ Form::label('name', __('Project Stage Name'),['class'=>'form-label']) }}
            {{ Form::text('name', null, array('class' => 'form-control ','required'=>'required')) }}
        </div>
        <div class="form-group col-12">
            {{ Form::label('color', __('Color'),['class'=>'form-label']) }}
            <input class="jscolor form-control " value="{{ $leadstages->color }}" name="color" id="color" required>
            <small class="small">{{ __('For chart representation') }}</small>
        </div>
        <div class="col-12 text-end">
            <input type="submit" value="{{__('Update')}}" class="btn-create badge-blue">
            <input type="button" value="{{__('Cancel')}}" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    {{ Form::close() }}
</div>
