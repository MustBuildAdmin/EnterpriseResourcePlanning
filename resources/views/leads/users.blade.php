<style>
div#choices_multiple4_chosen {
        width: 100% !important;
}
</style>
{{ Form::model($lead, array('route' => array('leads.users.update', $lead->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <div class="col-12 form-group">
            {{ Form::label('users', __('User'),['class'=>'form-label']) }}
            {{ Form::select('users[]', $users,false, array('class' => 'chosen-select',
            'id'=>'choices-multiple4','multiple'=>'')) }}
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
