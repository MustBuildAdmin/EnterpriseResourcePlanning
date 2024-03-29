<style>
  textarea {
    resize: vertical;
  }
  .bold{
    font-weight: bold;
  }
</style>
<div class="modal-body">
  <div class="row">
    <div class="container">
      <form class="" action="{{ route('save_consultant_direction') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="container">
          <div class="row">
            <div class="col form-group ">
              <label class="bold">{{__('ARCHITECT AND ENGNEERS DIRECTIONS (AD & ED)
                SUMMARY for the project of')}}</label> <span>:</span>
              <span class="bold">{{$projectname->project_name}}</span>
            </div>
          </div>
          <hr style="border: 1px solid black" />
          <div class="col-xs-12">
            <h3 style="text-align: center;text-transform: uppercase;">{{__('Consultants Directions Summary')}}</h3>
          </div>

          <div class="row">
            <input type="hidden" name="project_id" value="{{$project}}">
            <div class="col">
              <div class="form-group">
                <label for="InputIssued">{{__('Issued By')}} <span style='color:red;'>*</span></label>
                <input name="issued_by" type="text" class="form-control"
                placeholder="{{__('Issued By')}}" required/>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="InputIssued">{{__('Issued Date')}} <span style='color:red;'>*</span></label>
                <input name="issued_date"  max="{{ date('Y-m-d') }}"
                type="date" class="form-control" placeholder="{{__('Issued Date')}}" required/>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="InputReference">{{__('AD/ED Reference')}} <span style='color:red;'>*</span></label>
                <input name="ad_ae_ref" type="text" class="form-control"
                placeholder="{{__('AD/ED Reference')}}" required/>
              </div>
            </div>
            <div class="col-12 mt-3">
              <div class="form-group">
                <label for="InputDescription">{{__('AD/ED Description')}} <span style='color:red;'>*</span></label>
                <textarea name="ad_ae_decs" type="text" class="form-control"
                placeholder="{{__('AD/ED Description')}}" required></textarea>
              </div>
              <div class="col-md-12 mt-3">
                <label for="InputRemarks">{{__('Attachment')}} <span style='color:red;'>*</span></label>
                <input name="attach_file_name"  type="file"  class="form-control document_setup"
                accept="image/*, .png, .jpeg, .jpg ,pdf" required/>
                <span class="show_document_error" style="color:red;"></span>
              </div>
            </div>
          </div>
          <table class="table" id="dynamicAddRemove" aria-describedby="directions">
            <th></th>
            <tr>
              <td>
                <h4 style="text-align: center; font-weight: 700">{{__('Initiator Action & Reply')}}</h4>
                <div class="row mb-5">
                  <div class="col">
                    <div class="form-group">
                      <label for="InputReference">{{__('Reference')}}</label>
                      <input type="text" name="initiator_reference[]"
                      class="form-control" placeholder="{{__('Reference')}}" required/>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <label for="Inputdate">{{__('Date')}}</label>
                      <input type="date" max="{{ date('Y-m-d') }}"
                      name="initiator_date[]" class="form-control" placeholder="{{__('Date')}}" required/>
                    </div>
                  </div>
                  <div class="col-md-12 mt-3">
                    <label for="InputRemarks">{{__('Attachment')}}</label>
                    <input name="initiator_file_name[]"  type="file"
                    class="form-control file_input" accept="image/*, .png, .jpeg, .jpg , .pdf, .gif" required/>
                    <span class="show_document_error" style="color:red;"></span>
                  </div>
                </div>
              
                <div class="row">
                  <div class="col form-group">
                    <label for="InputRemarks">{{__('Status')}}</label>
                    <select name="replier_status[]" class="form-control"
                    aria-label="Default select example" required>
                      <option selected disabled>{{__('Select Status')}}</option>
                      <option value="clear">{{__('Clear')}}</option>
                      <option value="pending">{{__('Pending')}}</option>
                      <option value="withdrawn">{{__('Withdrawn')}}</option>
                    </select>
                  </div>
                  <div class="col-12 mt-3">
                    <div class="form-group">
                      <label for="InputRemarks">{{__('Remarks/ Notes')}}</label>
                      <textarea type="text" class="form-control" name="replier_remark[]"
                      placeholder="{{__('Remarks/ Notes')}}" required></textarea>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          </table>
          <div class="row">
            <div class="modal-footer">
              <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
              <input type="submit" value="{{__('Create')}}" id="add_directions" class="btn  btn-primary">
            </div>
          </div>
      </form>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
      $(document).on('submit', 'form', function() {
          $('#add_directions').attr('disabled', 'disabled');
      });
  });
</script>