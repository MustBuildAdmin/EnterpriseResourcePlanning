{{ Form::open(array('url' => 'labels')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-12">
            {{ Form::label('name', __('Label Name'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::text('name', '', array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="form-group col-12">
            {{ Form::label('pipeline_id', __('Pipeline'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::select('pipeline_id', $pipelines,null, array('class' => 'form-control select2','required'=>'required')) }}
        </div>
        <div class="form-group col-12">
            {{ Form::label('name', __('Color'),['class'=>'form-label']) }}
            <div class="row gutters-xs">
                @foreach($colors as $color)
                    <div class="col-auto">
                        <label class="colorinput">
                            <input name="color" type="radio" value="{{$color}}" class="colorinput-input">
                            <span class="colorinput-color bg-{{$color}}"></span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{Form::close()}}
