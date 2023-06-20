@if(isset($task))
    {{ Form::model($task, array('route' => array('deals.tasks.update', $deal->id, $task->id), 'method' => 'PUT')) }}
@else
    {{ Form::open(array('route' => ['deals.tasks.store',$deal->id])) }}
@endif
<div class="modal-body">
    <div class="row">
        <div class="col-12 form-group">
            {{ Form::label('name', __('Name'),['class'=>'form-label']) }}
            {{ Form::text('name', null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="col-6 form-group">
            {{ Form::label('date', __('Date'),['class'=>'form-label']) }}
            {{ Form::date('date', null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="col-6 form-group">
            {{ Form::label('time', __('Time'),['class'=>'form-label']) }}
            {{ Form::time('time', null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="col-6 form-group">
            {{ Form::label('priority', __('Priority'),['class'=>'form-label']) }}
            <select class="form-control select2" name="priority" required id="choices-multiple1">
                @foreach($priorities as $key => $priority)
                    <option value="{{$key}}" @if(isset($task) && $task->priority == $key) selected @endif>{{__($priority)}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 form-group">
            {{ Form::label('status', __('Status'),['class'=>'form-label']) }}
            <select class="form-control select2" name="status" id="choices-multiple2" required>
                @foreach($status as $key => $st)
                    <option value="{{$key}}" @if(isset($task) && $task->status == $key) selected @endif>{{__($st)}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    @if(isset($task))
        <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
    @else
        <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
    @endif

</div>
{{Form::close()}}


<script>
    $('#date').daterangepicker({
        locale: {format: 'YYYY-MM-DD'},
        singleDatePicker: true,
    });
    $("#time").timepicker({
        icons: {
            up: 'ti ti-chevron-up',
            down: 'ti ti-chevron-down'
        }
    });
</script>
