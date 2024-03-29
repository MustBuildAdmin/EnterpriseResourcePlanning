<style>
div#choices_multiple3_chosen {
    width: 100% !important;
}
</style>
{{ Form::model($lead, array('route' => array('leads.products.update', $lead->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <div class="col-12 form-group">
            {{ Form::label('products', __('Products'),['class'=>'form-label']) }}
            {{ Form::select('products[]', $products,false, array('class' => 'chosen-select','id'=>'choices-multiple3',
            'multiple'=>'','required'=>'required')) }}
        </div>
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Save')}}" class="btn  btn-primary">
</div>

{{Form::close()}}

<script>
      $(document).ready(function() {
        $(".chosen-select").chosen();
    });
</script>


