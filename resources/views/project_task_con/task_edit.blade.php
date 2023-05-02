{{ Form::model('data',['route' => ['con_taskupdate'], 'id' => 'edit_task', 'method' => 'POST']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                {{ Form::label('name', __('Percentage'),['class' => 'form-label']) }}<span class="text-danger">*</span>
                {{ Form::number('percentage', $data['percentage'], ['class' => 'form-control','required'=>'required','max'=>'100','min'=>'1']) }}
                {{ Form::hidden('task_id', $task_id, ['class' => 'form-control']) }}
                {{ Form::hidden('user_id', \Auth::user()->id, ['class' => 'form-control']) }}
                {{ Form::hidden('get_date', $data['get_date'], ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {{ Form::label('description', __('Description'),['class' => 'form-label']) }}
                {{ Form::textarea('description', $data['desc'], ['class' => 'form-control','rows'=>'3','data-toggle' => 'autosize','required'=>'required']) }}
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="form-label">{{__('Task members')}}</label>
        <small class="form-text text-muted mb-2 mt-0">{{__('Below users are assigned in your project.')}}</small>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>
{{Form::close()}}