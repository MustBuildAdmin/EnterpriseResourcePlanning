<div class="modal-body">
    <div class="row">
      <form action="{{ route('save_project_specification') }}" method="POST"  enctype="multipart/form-data" >
        @csrf
        <div class="container">
          <input type="hidden" name="project_id" value="{{$project_id}}">
          <div class="row">
            <div class="form-group">
              <label for="InputLIst"><b>SPECIFICATIONS</b> for the project of:</label>
              <b>{{$project_name->project_name}}</b>
            </div>
          </div>
          <hr style="border: 1px solid black;">
          <h3 style="text-align: center;">{{__('Specification')}}</h3>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="InputLIst">{{__('Reference No')}} <span style='color:red;'>*</span></label>
                <input type="text" name="reference_no" class="form-control"
                 placeholder="{{__('Reference No')}}" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="input">{{__('Description')}} <span style='color:red;'>*</span></label>
                <input type="text" name="description" class="form-control" placeholder="{{__('Description')}}" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="InputLIst">{{__('Location')}} <span style='color:red;'>*</span></label>
                <input type="text" name="location" class="form-control" placeholder="{{__('Location')}}" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="input">{{__('Drawing References (if any)')}}</label>
                <input type="text" name="drawing_reference" class="form-control"
                 placeholder="{{__('Drawing References (if any)')}}" >
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="input">{{__('Remarks/ Notes')}}</label>
                <textarea name="remarks" class="form-control" placeholder="{{__('Remarks/ Notes')}}" ></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="input">{{__('Attachments')}}</label>
                <input type="file" class="form-control document_setup"
                 name="attachment_file_name"  accept="image/*, .png, .jpeg, .jpg , .pdf, .gif">
                <span class="show_document_error" style="color:red;"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xs-3">
            <div class="modal-footer">
                <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
                <input type="submit" id="add_project" value="{{__('Submit')}}" class="btn  btn-primary add">
            </div>
        </div>
      </form>
    </div>
  </div>
<script>
    $(document).ready(function() {
        $(document).on('submit', 'form', function() {
            $('#add_project').attr('disabled', 'disabled');
        });
    });
</script>