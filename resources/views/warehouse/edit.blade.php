{{ Form::model($warehouse, array('route' => array('warehouse.update', $warehouse->id), 'method' => 'PUT')) }}

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">

            {{ Form::label('name', __('Name'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{ Form::text('name', null, array('class' => 'form-control','required'=>'required')) }}
            @error('name')
            <small class="invalid-name" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
            @enderror
        </div>
        <div class="form-group col-md-12">
            {{Form::label('address',__('Address'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
            {{Form::textarea('address',null,array('class'=>'form-control','rows'=>3,'required'=>'required'))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('city',__('City'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
            {{Form::text('city',null,array('class'=>'form-control','required'=>'required'))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('city_zip',__('Zip Code'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
            {{Form::text('city_zip',null,array('class'=>'form-control','required'=>'required'))}}
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Edit')}}" class="btn  btn-primary">
</div>
{{ Form::close() }}
