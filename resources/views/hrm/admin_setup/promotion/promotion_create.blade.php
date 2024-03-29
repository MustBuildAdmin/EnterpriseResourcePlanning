{{Form::open(array('url'=>'promotion','method'=>'post'))}}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('employee_id', __('Employee*'),['class'=>'form-label'])}}
            {{ Form::select('employee_id', $employees,null, array('class' => 'form-select','required'=>'required', 'placeholder'=>'Select Employee')) }}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('designation_id',__('Designation*'),['class'=>'form-label'])}}
            {{Form::select('designation_id',$designations,null,array('class'=>'form-select','required'=>'required','placeholder'=>'Select Designation'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('promotion_title',__('Promotion Title*'),['class'=>'form-label'])}}
            {{Form::text('promotion_title',null,array('class'=>'form-control','required'=>'required'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('promotion_date',__('Promotion Date*'),['class'=>'form-label'])}}
            {{Form::date('promotion_date',null,array('class'=>'form-control ','required'=>'required'))}}
        </div>
        <div class="form-group col-lg-12">
            {{Form::label('description',__('Description'),['class'=>'form-label'])}}<span style='color:red;'>*</span>
            {{Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Description'),'required'=>'required'))}}
        </div>
    
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" id="add_promotion" value="{{__('Create')}}" class="btn  btn-primary">
</div>

{{Form::close()}}
<script> 
    $(document).ready(function(){
        $(document).on('submit', 'form', function() {
            $('#add_promotion').attr('disabled', 'disabled');
        });
    });
</script>