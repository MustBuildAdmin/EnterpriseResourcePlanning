<div class="modal-body">
    <div class="row">
      <form action="{{ route('save_project_specification') }}" method="POST"  enctype="multipart/form-data" > 
        @csrf 
        <div class="container">
          <input type="hidden" name="project_id" value="{{$project_id}}">
          <div class="row">
            <div class="form-group">
              <label for="InputLIst">SPECIFICATIONS for the project of :</label>
              {{$project_name->project_name}}
            </div>
          </div>
          <hr style="border: 1px solid black;">
          <h3 style="text-align: center;">Specification</h3>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="InputLIst">Reference No:</label>
                <input type="text" name="reference_no" class="form-control" placeholder="Reference No" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="input">Description :</label>
                <input type="text" name="description" class="form-control" placeholder="Description" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="InputLIst">Location:</label>
                <input type="text" name="location" class="form-control" placeholder="Location" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="input">Drawing References (if any): </label>
                <input type="text" name="drawing_reference" class="form-control" placeholder="Drawing References (if any):" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="input">Remarks/ Notes:</label>
                <textarea name="remarks" class="form-control" placeholder="Remarks/ Notes" required></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="input">Attachments:</label>
                <input type="file" class="form-control" name="attachment_file_name" required>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xs-3">
            <div class="modal-footer">
                <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
                <input type="submit" value="{{__('Submit')}}" class="btn  btn-primary"> 
            </div>
        </div>
      </form>
    </div>
  </div>