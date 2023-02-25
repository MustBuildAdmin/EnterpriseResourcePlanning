{{Form::model($meeting,array('route' => array('meeting.update', $meeting->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('title',__('Meeting Title*'),['class'=>'form-label'])}}
                {{Form::text('title',null,array('class'=>'form-control','required'=>'required','placeholder'=>__('Enter Meeting Title')))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('date',__('Meeting Date*'),['class'=>'form-label'])}}
                {{Form::date('date',null,array('class'=>'form-control ','required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('time',__('Meeting Time*'),['class'=>'form-label'])}}
                {{Form::time('time',null,array('class'=>'form-control timepicker','required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('note',__('Meeting Note'),['class'=>'form-label'])}}
                {{Form::textarea('note',null,array('class'=>'form-control','placeholder'=>__('Enter Meeting Note')))}}
            </div>
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>
{{Form::close()}}

