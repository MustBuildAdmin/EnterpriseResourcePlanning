{{ Form::model($category, array('route' => array('product-category.update', $category->id), 'method' => 'PUT')) }}
<div class="modal-body">

    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('name', __('Category Name'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::text('name', null, array('class' => 'form-control font-style','required'=>'required')) }}
        </div>
        <div class="form-group  col-md-12">
            {{ Form::label('type', __('Category Type'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::select('type',$types,null, array('class' => 'form-select','required'=>'required', 'placeholder'=>'Select type')) }}
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('color', __('Category Color'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::text('color', null, array('class' => 'form-control jscolor','required'=>'required')) }}
            <p class="small">{{__('For chart representation')}}</p>
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>
{{ Form::close() }}
