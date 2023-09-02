
{{Form::open(array('url'=>'custom-question','method'=>'post'))}}
<div class="modal-body">

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('question',__('Question*'),['class'=>'form-label'])}}
                {{Form::text('question',null,array('class'=>'form-control','required'=>'required','placeholder'=>__('Enter question')))}}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('is_required',__('Is Required*'),['class'=>'form-label'])}}
                {{ Form::select('is_required', $is_required,null, array('class' => 'form-select','required'=>'required')) }}
            </div>
        </div>
      
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{Form::close()}}

