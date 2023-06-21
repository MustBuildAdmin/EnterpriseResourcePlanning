<style>
.form-check {
    margin: 8px 12px !important;
}
</style>

{{Form::open(array('url'=>'construction_asign','method'=>'post'))}}
<div class="modal-body">

    <div class="row">
        <div class="col-12">
            <div class="form-group">
                {{Form::label('project',__('Project'),['class'=>'form-label'])}}<span class="text-danger">*</span>
                <select class='form-control' name='project' required>
                    <option value="">{{__('Select Project')}}</option>
                    @foreach($projects as $key => $value)
                        <option value="{{$value->id}}">{{$value->name}}</option>
                    @endforeach
                </select>
                <br>
                {{Form::label('employee',__('Employee'),['class'=>'form-label'])}}<span class="text-danger">*</span>
                <select name="employee[]" multiple="multiple" size="5" class="form-control chosen-select" id="employee" multiple tabindex="6"  required>
                   
                        @foreach($employees as $key => $value)
                            <option value="{{$value->user_id}}">{{$value->email}}</option>
                        @endforeach
                         
                </select>
            </div>
        
                @error('name')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>  
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{Form::close()}}

<script>
  $(".chosen-select").chosen({
    disable_search_threshold: 10,
    no_results_text: "Oops, nothing found!",
    width: "95%"
  });
  $('#employee').trigger("chosen:updated");
</script>

