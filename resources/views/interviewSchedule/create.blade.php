
{{Form::open(array('url'=>'interview-schedule','method'=>'post'))}}
    <div class="modal-body">

    <div class="row">
        <div class="form-group col-md-6">
            {{Form::label('candidate',__('Interviewer*'),['class'=>'form-label'])}}
            {{ Form::select('candidate', $candidates,null, array('class' => 'form-control select','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('employee',__('Assign Employee*'),['class'=>'form-label'])}}
            {{ Form::select('employee', $employees,null, array('class' => 'form-control select','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('date',__('Interview Date*'),['class'=>'form-label'])}}
            {{Form::date('date',null,array('class'=>'form-control ','required'=>'required'))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('time',__('Interview Time*'),['class'=>'form-label'])}}
            {{Form::time('time',null,array('class'=>'form-control timepicker','required'=>'required'))}}
        </div>
        <div class="form-group col-md-12">
            {{Form::label('comment',__('Comment'),['class'=>'form-label'])}}
            {{Form::textarea('comment',null,array('class'=>'form-control'))}}
        </div>
    
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
    {{Form::close()}}
@if($candidate!=0)
    <script>
        $('select#candidate').val({{$candidate}}).trigger('change');
    </script>
@endif
