<style>
    div#choices_multiple4_chosen {
        width: 100% !important;
    }
    div#choices_multiple3_chosen {
        width: 100% !important;
    }
</style>
{{ Form::model($deal, array('route' => array('deals.update', $deal->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <div class="col-6 form-group">
            {{ Form::label('name', __('Deal Name'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::text('name', null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="col-6 form-group">
            {{ Form::label('phone', __('Phone'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::text('phone', null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="col-6 form-group">
            {{ Form::label('price', __('Price'),['class'=>'form-label']) }}
            {{ Form::number('price', null, array('class' => 'form-control')) }}
        </div>
        <div class="col-6 form-group">
            {{ Form::label('pipeline_id', __('Pipeline'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::select('pipeline_id', $pipelines,null, array('class' => 'form-control ','required'=>'required')) }}
        </div>
        <div class="col-6 form-group">
            {{ Form::label('stage_id', __('Stage'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::select('stage_id', [''=>__('Select Stage')],null, array('class' => 'form-control ','required'=>'required')) }}
        </div>
        <div class="col-12 form-group">
            {{ Form::label('sources', __('Sources'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::select('sources[]', $sources,null, array('class' => 'form-control chosen-select','multiple'=>'','id'=>'choices-multiple3','required'=>'required')) }}
        </div>
        <div class="col-12 form-group">
            {{ Form::label('products', __('Products'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::select('products[]', $products,null, array('class' => 'form-control chosen-select','multiple'=>'','id'=>'choices-multiple4','required'=>'required')) }}
        </div>
        <div class="col-12 form-group">
            {{ Form::label('notes', __('Notes'),['class'=>'form-label']) }}
            {{ Form::textarea('notes',null, array('class' => 'summernote-simple')) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn btn-primary">
</div>
{{Form::close()}}



<script>
    $(document).ready(function() {
        $(".chosen-select").chosen();
    });

    var stage_id = '{{$deal->stage_id}}';

    $(document).ready(function () {
        $("#commonModal select[name=pipeline_id]").trigger('change');
    });

    $(document).on("change", "#commonModal select[name=pipeline_id]", function () {
        $.ajax({
            url: '{{route('stages.json')}}',
            data: {pipeline_id: $(this).val(), _token: $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            success: function (data) {
                $('#stage_id').empty();
                $("#stage_id").append('<option value="" selected="selected">{{__('Select Stage')}}</option>');
                $.each(data, function (key, data) {
                    var select = '';
                    if (key == '{{ $deal->stage_id }}') {
                        select = 'selected';
                    }
                    $("#stage_id").append('<option value="' + key + '" ' + select + '>' + data + '</option>');
                });
                $("#stage_id").val(stage_id);
                $('#stage_id').select2({
                    placeholder: "{{__('Select Stage')}}"
                });
            }
        })
    });
</script>
