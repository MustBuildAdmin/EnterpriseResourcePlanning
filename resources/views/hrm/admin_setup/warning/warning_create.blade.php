{{Form::open(array('url'=>'warning','method'=>'post'))}}
<div class="modal-body">
    <div class="row">
        @if(\Auth::user()->type != 'employee')
            <div class="form-group col-md-6 col-lg-6">
                {{ Form::label('warning_by', __('Warning By*'),['class'=>'form-label'])}}
                {{ Form::select('warning_by', $employees,null, array('class' => 'form-control select','required'=>'required','placeholder'=>'Select Employee')) }}
            </div>
        @endif
        <div class="form-group col-md-6 col-lg-6">
            {{Form::label('warning_to',__('Warning To*'),['class'=>'form-label'])}}
            {{Form::select('warning_to',$employees,null,array('class'=>'form-control select','required'=>'required','placeholder'=>'Select Employee'))}}
        </div>
        <div class="form-group col-md-6 col-lg-6">
            {{Form::label('subject',__('Subject*'),['class'=>'form-label'])}}
            {{Form::text('subject',null,array('class'=>'form-control','required'=>'required'))}}
        </div>
        <div class="form-group col-md-6 col-lg-6">
            {{Form::label('warning_date',__('Warning Date*'),['class'=>'form-label'])}}
            {{Form::date('warning_date',null,array('class'=>'form-control ','required'=>'required'))}}
        </div>
        <div class="form-group col-md-12">
            {{Form::label('description',__('Description'),['class'=>'form-label'])}}<span style='color:red;'>*</span>
            {{Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Description'),'required'=>'required'))}}
        </div>
        
    </div>
    
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" id="add_warning" value="{{__('Create')}}" class="btn  btn-primary">
</div>

{{Form::close()}}
<script> 
    $(document).ready(function(){
        $(document).on('submit', 'form', function() {
            $('#add_warning').attr('disabled', 'disabled');
        });
    });
</script>
