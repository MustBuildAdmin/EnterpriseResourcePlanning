{{ Form::open(array('url' => 'product-category')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('name', __('Category Name'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::text('name', '', array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('type', __('Category Type'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::select('type',$types,null, array('class' => 'form-select ','required'=>'required', 'placeholder'=>'Select type')) }}
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('color', __('Category Color'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::text('color', '', array('class' => 'form-control jscolor','required'=>'required')) }}
            <small>{{__('For chart representation')}}</small>
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary category_submit">
</div>
{{ Form::close() }}
<script>
$(document).ready(function() {
    $(".category_submit").click(function() {
        var valid = true;
        $('[required]').each(function() {
            if ($(this).is(':invalid') || !$(this).val()) {
                valid = false;
            }
        });
        if (!valid) {
            $(".category_submit").attr('disabled', false);
        }else{
            $(".category_submit").hide();
        }        
    })   
});
</script>
