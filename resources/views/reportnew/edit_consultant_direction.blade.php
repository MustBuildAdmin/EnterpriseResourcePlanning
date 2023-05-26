<style>
  textarea {
    resize: vertical;
  }
</style>
<div class="modal-body">
  <div class="row">
    <div class="container">
      <h3 style="text-align: center; font-weight: 800; color: blue"> Consultants Directions Summary</h3>
      <form class="" action="{{ route('update_consultant_direction') }}" enctype="multipart/form-data" method="POST"> 
        @csrf 
        <div class="container">
            <input type="hidden" name="project_id" value="{{$project}}">
            <div class="row mb-5">
              <input name="id" type="hidden" class="form-control" value="{{$consult_dir->id}}" placeholder="Enter your  Issued By" />
              <div class="col form-group ">
                <label for="InputIssued">ARCHITECT AND ENGNEER'S DIRECTIONS (AD & ED) SUMMARY for the project of:</label>
                <span>{{$project_name->project_name}}</span>
              </div>
            </div>
            <hr style="border: 1px solid black" />
            <div class="row mb-5">
              <div class="col">
                <div class="form-group">
                  <label for="InputIssued">Issued By:</label>
                  <input name="issued_by" type="text" class="form-control" value="{{$consult_dir->issued_by}}" placeholder="Enter your  Issued By" />
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label for="InputIssued">Issued Date:</label>
                  <input name="issued_date" type="date" class="form-control" value="{{$consult_dir->issued_date}}" placeholder="Enter your  Issued Date" />
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label for="InputReference">AD/ED Reference:</label>
                  <input name="ad_ae_ref" value="{{$consult_dir->ad_ae_ref}}" type="text" class="form-control" placeholder="Enter your  AD/ED Reference" />
                </div>
              </div>
              <div class="col-12 mt-3">
                <div class="form-group">
                  <label for="InputDescription">AD/ED Description:</label>
                  <textarea name="ad_ae_decs" type="text" class="form-control" placeholder="Enter your  AD/ED Description">{{$consult_dir->ad_ae_decs}}</textarea>
                </div>
                <div class="col-md-12 mt-3">
                  <label for="InputRemarks">Attachment</label>
                  <input name="attach_file_name" required type="file" id="concreteFile" class="form-control" name="file" />
                  <span>{{$consult_dir->attach_file_name}}</span>
                </div>
              </div>
            </div>
            <table class="table" id="dynamicAddRemove"> @foreach ($consult_dir_multi as $mutli_data) <tr>
                <td>
                  <h4 style="text-align: center; font-weight: 700"> Initiator Action: </h4>
                  <div class="row mb-5">
                    <div class="col">
                      <div class="form-group">
                        <label for="InputReference">Reference:</label>
                        <input type="text" value="{{$mutli_data->initiator_reference}}" name="initiator_reference[]" class="form-control" placeholder="Enter your  Reference" />
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <label for="Inputdate">Date:</label>
                        <input type="date" value="{{$mutli_data->initiator_date}}" name="initiator_date[]" class="form-control" placeholder="Enter your  Date" />
                      </div>
                    </div>
                    <div class="col-md-12 mt-3">
                      <label for="InputRemarks">Attachment</label>
                      <input name="initiator_file_name[]" required type="file" id="concreteFile" class="form-control" multiple />
                      <span>{{$mutli_data->initiator_file_name}}</span>
                    </div>
                  </div>
                  <h4 style="text-align: center; font-weight: 700">Replier:</h4>
                  <div class="row mb-3">
                    <div class="col">
                      <div class="form-group">
                        <label for="InputReference">Reference:</label>
                        <input type="text" value="{{$mutli_data->replier_reference}}" name="replier_reference[]" class="form-control" placeholder="Enter your  Reference" />
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <label for="Inputdate">Date:</label>
                        <input type="date" value="{{$mutli_data->replier_date}}" name="replier_date[]" class="form-control" placeholder="Enter your  Date" />
                      </div>
                    </div>
                  </div>
                  <div class="row mb-5">
                    <div class="col form-group">
                      <label for="InputRemarks">Status:</label>
                      <select name="replier_status[]" class="form-control" aria-label="Default select example">
                        <option selected disabled>Status</option>
                        <option value="clear" @if('clear'==$mutli_data->replier_status){ selected }@endif>Clear</option>
                        <option value="pending" @if('pending'==$mutli_data->replier_status){ selected }@endif>Pending</option>
                        <option value="withdrawn" @if('withdrawn'==$mutli_data->replier_status){ selected }@endif>Withdrawn</option>
                      </select>
                    </div>
                    <div class="col-12 mt-3">
                      <div class="form-group">
                        <label for="InputRemarks">Remarks/ Notes:</label>
                        <textarea type="text" class="form-control" name="replier_remark[]" placeholder="Enter your Remarks/ Notes">{{$mutli_data->replier_remark}}</textarea>
                      </div>
                    </div>
                    <div class="col-md-12 mt-3">
                      <label for="InputRemarks">Attachment</label>
                      <input required type="file" name="replier_file_name[]" id="concreteFile" class="form-control"  />
                      <span>{{$mutli_data->replier_file_name}}</span>
                    </div>
                  </div>
                  @if(!empty($replier_date))
                  <div class="col-md-12 mt-3">
                    <button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary">Add Subject</button>
                  </div>
                  @endif
                </td>
              </tr>
            </table> @endforeach <div class="row" style="margin:20px 0px 20px">
              <div class="modal-footer">
                <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
                <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
              </div>
            </div>
          </form>
        </div>
    </div>
  </div>
</div>