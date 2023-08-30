{{ Form::open(array('url' => 'custom-field')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            {{Form::label('name',__('Custom Field Name'),['class'=>'form-label'])}}<span class="text-danger">*</span>
            {{Form::text('name',null,array('class'=>'form-control','required'=>'required'))}}
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('type', __('Type'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::select('type',$types,null, array('class' => 'form-select ','required'=>'required')) }}
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('module', __('Module'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::select('module',$modules,null, array('class' => 'form-select ','required'=>'required')) }}
        </div>

    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{ Form::close() }}
