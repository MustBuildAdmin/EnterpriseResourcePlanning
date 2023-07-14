{{Form::model($resignation,array('route' => array('resignation.update', $resignation->id), 'method' => 'PUT')) }}
<div class="modal-body">

<div class="row">
    @if(\Auth::user()->type!='employee')
        <div class="form-group col-lg-12">
            {{ Form::label('employee_id', __('Employee*'),['class'=>'form-label'])}}
            {{ Form::select('employee_id', $employees,null, array('class' => 'form-control select','required'=>'required','placeholder'=>'Select Employee')) }}
        </div>
    @endif
    <div class="form-group col-lg-6 col-md-6">
        {{Form::label('notice_date',__('Notice Date*'),['class'=>'form-label'])}}
        {{Form::date('notice_date',null,array('class'=>'form-control ','required'=>'required'))}}
    </div>
    <div class="form-group col-lg-6 col-md-6">
        {{Form::label('resignation_date',__('Resignation Date*'),['class'=>'form-label'])}}
        {{Form::date('resignation_date',null,array('class'=>'form-control ','required'=>'required'))}}
    </div>
    <div class="form-group col-lg-12">
        {{Form::label('description',__('Description'),['class'=>'form-label'])}}<span style='color:red;'>*</span>
        {{Form::textarea('description',null,array('class'=>'form-control','required'=>'required','placeholder'=>__('Enter Description')))}}
    </div>
    
</div>
</div>
<div class="modal-footer">
<input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
<input type="submit" id="edit_resignation" value="{{__('Update')}}" class="btn  btn-primary">
</div>
{{Form::close()}}
<script> 
    $(document).ready(function(){
        $(document).on('submit', 'form', function() {
            $('#edit_resignation').attr('disabled', 'disabled');
        });
    });
</script>

