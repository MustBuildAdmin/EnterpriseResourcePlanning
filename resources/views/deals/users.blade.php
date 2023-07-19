<style>
div#choices_multiple6_chosen {
    width: 100% !important;
}
</style>
{{ Form::model($deal, array('route' => array('deals.users.update', $deal->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <div class="col-12 form-group">
            {{ Form::label('users', __('User'),['class'=>'form-label']) }}
            {{ Form::select('users[]', $users,false, array('class' => 'chosen-select',
                'id'=>'choices-multiple6','multiple'=>'','required'=>'required')) }}
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

