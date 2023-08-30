{{Form::open(array('url'=>'transfer','method'=>'post'))}}
<div class="modal-body">

    <div class="row">
        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('employee_id', __('Employee*'),['class'=>'form-label'])}}
            {{ Form::select('employee_id', $employees,null, array('class' => 'form-select','required'=>'required', 'placeholder'=>'Select Employee')) }}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('branch_id',__('Branch*'),['class'=>'form-label'])}}
            {{Form::select('branch_id',$branches,null,array('class'=>'form-select','required'=>'required','placeholder'=>'Select Branch'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('department_id',__('Department*'),['class'=>'form-label'])}}
            {{Form::select('department_id',$departments,null,array('class'=>'form-select','required'=>'required','placeholder'=>'Select Department'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('transfer_date',__('Transfer Date*'),['class'=>'form-label'])}}
            {{Form::date('transfer_date',null,array('class'=>'form-control ','required'=>'required'))}}
        </div>
        <div class="form-group col-lg-12">
            {{Form::label('description',__('Description'),['class'=>'form-label'])}}<span style='color:red;'>*</span>
            {{Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Description'),'required'=>'required'))}}
        </div>
    
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" id="add_transfer" value="{{__('Create')}}" class="btn  btn-primary">
</div>

{{Form::close()}}
<script> 
    $(document).ready(function(){
        $(document).on('submit', 'form', function() {
            $('#add_transfer').attr('disabled', 'disabled');
        });
    });
</script>

    