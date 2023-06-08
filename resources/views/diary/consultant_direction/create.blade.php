<style>
  textarea {
    resize: vertical;
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
              <label for="InputIssued">ARCHITECT AND ENGNEER'S DIRECTIONS (AD & ED) SUMMARY for the project of:</label>
              <span>{{$project_name->project_name}}</span>
            </div>
          </div>
          <hr style="border: 1px solid black" />
          <div class="col-xs-12">
            <h3 style="text-align: center;text-transform: uppercase;">Consultants Directions Summary</h3>
          </div>
          <div class="row">
            <input type="hidden" name="project_id" value="{{$project}}">
            <div class="col">
              <div class="form-group">
                <label for="InputIssued">Issued By <span style='color:red;'>*</span></label>
                <input name="issued_by" type="text" class="form-control" placeholder="Enter your  Issued By" required/>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="InputIssued">Issued Date <span style='color:red;'>*</span></label>
                <input name="issued_date" type="date" class="form-control" placeholder="Enter your  Issued Date" required/>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="InputReference">AD/ED Reference <span style='color:red;'>*</span></label>
                <input name="ad_ae_ref" type="text" class="form-control" placeholder="Enter your  AD/ED Reference" required/>
              </div>
            </div>
            <div class="col-12 mt-3">
              <div class="form-group">
                <label for="InputDescription">AD/ED Description <span style='color:red;'>*</span></label>
                <textarea name="ad_ae_decs" type="text" class="form-control" placeholder="Enter your  AD/ED Description" required></textarea>
              </div>
              <div class="col-md-12 mt-3">
                <label for="InputRemarks">Attachment <span style='color:red;'>*</span></label>
                <input name="attach_file_name" required type="file" id="concreteFile" class="form-control" required/>
              </div>
            </div>
          </div>
          <table class="table" id="dynamicAddRemove">
            <tr>
              <td>
                <h4 style="text-align: center; font-weight: 700"> Initiator Action:</h4>
                <div class="row mb-5">
                  <div class="col">
                    <div class="form-group">
                      <label for="InputReference">Reference <span style='color:red;'>*</span></label>
                      <input type="text" name="initiator_reference[]" class="form-control" placeholder="Enter your  Reference" required/>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <label for="Inputdate">Date <span style='color:red;'>*</span></label>
                      <input type="date" name="initiator_date[]" class="form-control" placeholder="Enter your  Date" required/>
                    </div>
                  </div>
                  <div class="col-md-12 mt-3">
                    <label for="InputRemarks">Attachment <span style='color:red;'>*</span></label>
                    <input name="initiator_file_name[]" required type="file" id="concreteFile" class="form-control" required />
                  </div>
                </div>
                <h4 style="text-align: center; font-weight: 700;">Replier:</h4>
                <div class="row mb-3">
                  <div class="col">
                    <div class="form-group">
                      <label for="InputReference">Reference <span style='color:red;'>*</span></label>
                      <input type="text" name="replier_reference[]" class="form-control" placeholder="Enter your  Reference" required />
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <label for="Inputdate">Date <span style='color:red;'>*</span></label>
                      <input type="date" name="replier_date[]" class="form-control" placeholder="Enter your  Date" required/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col form-group">
                    <label for="InputRemarks">Status <span style='color:red;'>*</span></label>
                    <select name="replier_status[]" class="form-control" aria-label="Default select example" required>
                      <option selected disabled>Status</option>
                      <option value="clear">Clear</option>
                      <option value="pending">Pending</option>
                      <option value="withdrawn">Withdrawn</option>
                    </select>
                  </div>
                  <div class="col-12 mt-3">
                    <div class="form-group">
                      <label for="InputRemarks">Remarks/ Notes <span style='color:red;'>*</span></label>
                      <textarea type="text" class="form-control" name="replier_remark[]" placeholder="Enter your Remarks/ Notes" required></textarea>
                    </div>
                  </div>
                  <div class="col-md-12 mt-3">
                    <label for="InputRemarks">Attachment <span style='color:red;'>*</span></label>
                    <input required type="file" name="replier_file_name[]" class="form-control" required />
                  </div>
                </div>
              </td>
            </tr>
          </table>
          <div class="row">
            <div class="modal-footer">
              <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
              <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
            </div>
          </div>
      </form>
    </div>
  </div>
</div>