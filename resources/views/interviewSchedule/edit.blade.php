    {{Form::model($interviewSchedule,array('route' => array('interview-schedule.update', $interviewSchedule->id), 'method' => 'PUT')) }}
    <div class="modal-body">

    <div class="row">
        <div class="form-group col-md-6">
            {{Form::label('candidate',__('Interviewer*'),['class'=>'form-label'])}}
            {{ Form::select('candidate', $candidates,null, array('class' => 'form-select','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('employee',__('Assign Employee*'),['class'=>'form-label'])}}
            {{ Form::select('employee', $employees,null, array('class' => 'form-select','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('date',__('Interview Date*'),['class'=>'form-label'])}}
            {{Form::date('date',null,array('class'=>'form-control ','required'=>'required'))}}
        </div>
        <div class="form-group col-md-">
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
        <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
    </div>
    {{Form::close()}}

