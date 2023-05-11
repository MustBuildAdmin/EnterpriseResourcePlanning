<style>
    div#choices_multiple1_chosen, div#choices_multiple2_chosen {
        width: 100% !important;
    }
</style>
{{ Form::open(array('url' => 'deals')) }}
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
            {{ Form::number('price', 0, array('class' => 'form-control','min'=>0)) }}
        </div>
        <div class="col-6 form-group">
            {{ Form::label('clients', __('Clients'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::select('clients[]', $clients,null, array('class' => 'form-control chosen-select','multiple'=>'','id'=>'choices-multiple1','required'=>'required')) }}
            @if(count($clients) <= 0 && Auth::user()->type == 'Owner')
                <div class="text-muted text-xs">
                    {{__('Please create new clients')}} <a href="{{route('clients.index')}}">{{__('here')}}</a>.
                </div>
            @endif
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{Form::close()}}

<script>
    $(document).ready(function() {
        $(".chosen-select").chosen();
    });
</script>
