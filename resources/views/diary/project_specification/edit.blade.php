<div class="modal-body">
    <div class="row">
      <form action="{{ route('update_project_specification') }}" method="POST"  enctype="multipart/form-data" > 
        @csrf 
        <div class="container">
            <input type="hidden" name="project_id" value="{{$project_id}}">
            <input type="hidden" name="id" value="{{$data->id}}">
          <div class="row">
            <div class="form-group">
              <label for="InputLIst">{{__('SPECIFICATIONS for the project of')}}:</label>
              {{$project_name->project_name}}
            </div>
          </div>
          <hr style="border: 1px solid black;">
          <h3 style="text-align: center;">{{__('Specification')}}</h3>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="InputLIst">{{__('Reference No')}}<span style='color:red;'>*</span></label>
                <input type="text" name="reference_no" class="form-control" placeholder="Reference No" value="{{$data->reference_no}}" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="input">{{__('Description')}}<span style='color:red;'>*</span></label>
                <input type="text" name="description" class="form-control" placeholder="Description" value="{{$data->description}}" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="InputLIst">{{__('Location')}}<span style='color:red;'>*</span></label>
                <input type="text" name="location" class="form-control" placeholder="Location" value="{{$data->location}}" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="input">{{__('Drawing References (if any)')}}<span style='color:red;'>*</span></label>
                <input type="text" name="drawing_reference" class="form-control" placeholder="Drawing References (if any):" value="{{$data->drawing_reference}}" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="input">{{__('Remarks/ Notes')}}<span style='color:red;'>*</span></label>
                <textarea name="remarks" class="form-control" placeholder="Remarks/ Notes" required>{{$data->remarks}}</textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="input">{{__('Attachments')}}<span style='color:red;'>*</span></label>
                <input type="file" class="form-control" name="attachment_file_name" >
                <span>{{$data->attachment_file_name}}</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xs-3">
            <div class="modal-footer">
                <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
                <input type="submit" value="{{__('Update')}}" class="btn  btn-primary"> 
            </div>
        </div>
      </form>
    </div>
  </div>