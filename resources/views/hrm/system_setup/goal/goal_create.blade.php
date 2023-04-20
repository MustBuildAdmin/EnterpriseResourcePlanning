{{Form::open(array('url'=>'goaltype','method'=>'post'))}}
<div class="modal-body">

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {{Form::label('name',__('Name*'),['class'=>'form-label'])}}
            {{Form::text('name',null,array('class'=>'form-control','required'=>'required','placeholder'=>__('Enter Goal Type Name')))}}
            @error('name')
            <span class="invalid-name" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

</div>
</div>
<div class="modal-footer">
<input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
<input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{Form::close()}}

