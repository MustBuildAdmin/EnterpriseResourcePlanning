{{Form::open(array('url'=>'holiday','method'=>'post'))}}
<div class="modal-body">

    <div class="row">

        <div class="form-group col-md-12">
            {{Form::label('occasion',__('Occasion*'),['class'=>'form-label'])}}
            {{Form::text('occasion',null,array('class'=>'form-control','required'=>'required'))}}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            {{Form::label('date',__('Start Date*'),['class'=>'form-label'])}}
            {{Form::date('date',null,array('class'=>'form-control ','required'=>'required'))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('end_date',__('End Date*'),['class'=>'form-label'])}}
            {{Form::date('end_date',null,array('class'=>'form-control ','required'=>'required'))}}
        </div>

    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>

{{Form::close()}}

