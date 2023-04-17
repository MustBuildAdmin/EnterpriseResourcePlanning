
{{Form::open(array('url'=>'competencies','method'=>'post'))}}
<div class="modal-body">

<div class="row ">
    <div class="col-12">
        <div class="form-group">
            {{Form::label('name',__('Name*'),['class'=>'form-label'])}}
            {{Form::text('name',null,array('class'=>'form-control','required'=>'required'))}}
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            {{Form::label('type',__('Type*'),['class'=>'form-label'])}}
            {{Form::select('type',$performance,null,array('class'=>'form-control select','required'=>'required'))}}
        </div>
    </div>

</div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{Form::close()}}

