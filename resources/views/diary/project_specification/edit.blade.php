<style>
  #project_file{
    height: 23px;
    width: 10%;
  }
</style>
<div class="modal-body">
    <div class="row">
      <form action="{{ route('update_project_specification') }}" method="POST"  enctype="multipart/form-data" >
        @csrf
        <div class="container">
            <input type="hidden" name="project_id" value="{{$project_id}}">
            <input type="hidden" name="id" value="{{$data->id}}">
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
                <label for="InputLIst">{{__('Reference No')}}<span style='color:red;'>*</span></label>
                <input type="text" name="reference_no" class="form-control"
                 placeholder="{{__('Reference No')}}" value="{{$data->reference_no}}" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="input">{{__('Description')}}<span style='color:red;'>*</span></label>
                <input type="text" name="description" class="form-control"
                 placeholder="{{__('Description')}}" value="{{$data->description}}" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="InputLIst">{{__('Location')}}<span style='color:red;'>*</span></label>
                <input type="text" name="location" class="form-control"
                 placeholder="{{__('Location')}}" value="{{$data->location}}" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="input">{{__('Drawing References (if any)')}}</label>
                <input type="text" name="drawing_reference" class="form-control"
                 placeholder="{{__('Drawing References (if any)')}}" value="{{$data->drawing_reference}}" >
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="input">{{__('Remarks/ Notes')}}</label>
                <textarea name="remarks" class="form-control"
                 placeholder="{{__('Remarks/ Notes')}}" >{{$data->remarks}}</textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="input">{{__('Attachments')}}<span style='color:red;'>*</span></label>
                <input type="file" class="form-control document_setup"
                 name="attachment_file_name" accept="image/*, .png, .jpeg, .jpg , .pdf, .gif">
                <span class="show_document_error" style="color:red;"></span>
                @php $documentPath=\App\Models\Utility::get_file('uploads/project_direction_summary'); @endphp
                <br>
                <table>
                  <tr>
                    <td> {{$data->attachment_file_name}}
                      <a id="project_file" class="btn btn-primary" download
                      href="{{ $documentPath . '/' . $data->attachment_file_name }}">
                      <i class="ti ti-download text-white"></i> </a>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xs-3">
            <div class="modal-footer">
                <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
                <input type="submit" id="edit_project" value="{{__('Update')}}" class="btn btn-primary add">
            </div>
        </div>
      </form>
    </div>
  </div>
<script>
    $(document).ready(function() {
        $(document).on('submit', 'form', function() {
            $('#edit_project').attr('disabled', 'disabled');
        });

        var src = URL.createObjectURL(this.files[0])
        document.getElementById('project_file').src = src
    });
</script>