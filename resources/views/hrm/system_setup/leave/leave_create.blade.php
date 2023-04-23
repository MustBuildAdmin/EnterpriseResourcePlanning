{{Form::open(array('url'=>'leavetype','method'=>'post'))}}
<div class="modal-body">

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {{Form::label('title',__('Leave Type*'),['class'=>'form-label'])}}
            {{Form::text('title',null,array('class'=>'form-control','required'=>'required','placeholder'=>__('Enter Leave Type Name')))}}
            @error('title')
            <span class="invalid-name" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            {{Form::label('days',__('Days Per Year*'),['class'=>'form-label'])}}
            {{Form::number('days',null,array('class'=>'form-control','required'=>'required','placeholder'=>__('Enter Days / Year')))}}
        </div>
    </div>

</div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{Form::close()}}

