<div class="card bg-none card-box">
    @if(isset($product))
        {{ Form::model($product, array('route' => array('estimations.products.update', $estimation->id,$product->id), 'method' => 'PUT')) }}
    @else
        {{ Form::model($estimation, array('route' => array('estimations.products.store', $estimation->id), 'method' => 'POST')) }}
    @endif
    <div class="row">
        <div class="col-6 form-group">
            {{ Form::label('product_id', __('Product'),['class'=>'form-label']) }}
            {{ Form::select('product_id', $products,null, array('class' => 'form-control select2','required'=>'required')) }}
        </div>
        <div class="col-6 form-group">
            {{ Form::label('quantity', __('Quantity'),['class'=>'form-label']) }}
            {{ Form::number('quantity', isset($product)?null:1, array('class' => 'form-control','required'=>'required','min'=>'1')) }}
        </div>
        <div class="col-12 form-group">
            {{ Form::label('description', __('Description'),['class'=>'form-label']) }}
            {{ Form::textarea('description', null, array('class' => 'form-control')) }}
        </div>
        <div class="form-group col-md-12 text-end">
            @if(isset($product))
                <input type="submit" value="{{__('Update')}}" class="btn-create badge-blue">
            @else
                <input type="submit" value="{{__('Add')}}" class="btn-create badge-blue">
            @endif
            <input type="button" value="{{__('Cancel')}}" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    {{ Form::close() }}
</div>
