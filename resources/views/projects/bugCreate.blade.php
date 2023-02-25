{{ Form::open(array('route' => array('task.bug.store',$project_id))) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('title', __('Title'),['class'=>'form-label']) }}
            {{ Form::text('title', '', array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('priority', __('Priority'),['class'=>'form-label']) }}
            {!! Form::select('priority', $priority, null,array('class' => 'form-control select','required'=>'required')) !!}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('start_date', __('Start Date'),['class'=>'form-label']) }}
            {{ Form::date('start_date', '', array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('due_date', __('Due Date'),['class'=>'form-label']) }}
            {{ Form::date('due_date', '', array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('status', __('Bug Status'),['class'=>'form-label']) }}
            {!! Form::select('status', $status, null,array('class' => 'form-control select','required'=>'required')) !!}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('assign_to', __('Assigned To'),['class'=>'form-label']) }}
            {{ Form::select('assign_to', $users, null,array('class' => 'form-control select','required'=>'required')) }}
        </div>
    </div>
    <div class="row">
        <div class="form-group  col-md-12">
            {{ Form::label('description', __('Description'),['class'=>'form-label']) }}
            {!! Form::textarea('description', null, ['class'=>'form-control','rows'=>'2']) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{Form::close()}}
