<div class="modal-body">
  <div class="row">
    <form method="POST" action="{{route('save_variation_scope_change')}}" enctype="multipart/form-data"> @csrf <input type="hidden" name="project_id" id="project_id" value="{{$project}}">
      <div class="container" style="margin-top: 50px;">
        <div class="col-xs-12">
          <div class="form-group">
            <label for="InputLIst">VARIATIONS/SCOPE CHANGE AUTHORIZATION for the project of:</label>
            <span>{{$project_name->project_name}}</span>
          </div>
        </div>
        <hr style="border: 1px solid black;">
        <div class="col-xs-12">
          <h3 style="text-align: center;">VARIATIONS/SCOPE CHANGE AUTHORIZATION</h3>
        </div>
        <div class="row">
          <div class="col-6 mb-3">
            <div class="form-group">
              <label for="Input">Issued By <span style='color:red;'>*</span></label>
              <input type="text" name="issued_by" class="form-control" placeholder="Text input" required>
            </div>
          </div>
          <div class="col-6 mb-3">
            <div class="form-group">
              <label for="Input">Issued Date <span style='color:red;'>*</span></label>
              <input type="date" name="issued_date" class="form-control" placeholder="Text input" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6 mb-3">
            <div class="form-group">
              <label class="form-group">VO/SCA Reference <span style='color:red;'>*</span></label>
              <textarea name="sca_reference" class="form-control" required></textarea>
            </div>
          </div>
          <div class="col-6 mb-3">
            <div class="form-group">
              <label class="form-group">VO Description </label>
              <textarea name="vo_reference" class="form-control"></textarea>
            </div>
          </div>
        </div>
        <div class="col-xs-12">
          <h4 class="text-center">Initiator:</h4>
          <div class="row">
            <div class="col-6 mb-3">
              <div class="form-group">
                <label for="Input">Referene <span style='color:red;'>*</span></label>
                <input type="text" name="reference" class="form-control" placeholder="Text input" required>
              </div>
            </div>
            <div class="col-6 mb-3">
              <div class="form-group">
                <label for="Input">Date <span style='color:red;'>*</span></label>
                <input name="vo_date" type="date" class="form-control" placeholder="Text input" required>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xs-12">
          <h4 class="text-center">Variation/SCA Claimed Amount More by Contractor</h4>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="Input">Omission Cost <span style='color:red;'>*</span></label>
                <input name="claimed_omission_cost" type="text" class="form-control claimed_omission_cost" required>
              </div>
            </div>
            <div class="col-md-4">
              <label for="Input">Addition Cost <span style='color:red;'>*</span></label>
              <input name="claimed_addition_cost" type="text" class="form-control claimed_addition_cost" required>
            </div>
            <div class="col-md-4">
              <label for="Input">Net Amount <span style='color:red;'>*</span></label>
              <input name="claimed_net_amount" type="text" class="form-control claimed_net_amount" required>
            </div>
          </div>
        </div>
        <div class="col-xs-12">
          <h4 class="text-center">Variation/SCA Approved Amount by Consultant</h4>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="Input">Omission Cost <span style='color:red;'>*</span></label>
                <input name="approved_omission_cost" type="text" class="form-control approved_omission_cost" required>
              </div>
            </div>
            <div class="col-md-4">
              <label for="Input">Addition Cost <span style='color:red;'>*</span></label>
              <input name="approved_addition_cost" type="text" class="form-control approved_addition_cost" required>
            </div>
            <div class="col-md-4">
              <label for="Input">Net Amount <span style='color:red;'>*</span></label>
              <input name="approved_net_cost" type="text" class="form-control approved_net_cost" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <label class="form-group">Impact/Lead Time <span style='color:red;'>*</span></label>
            <div class="form-group">
              <input name="impact_time" type="text" class="form-control" required>
            </div>
          </div>
          <div class="col-md-6">
            <label class="form-group">Granted EOT(in days) <span style='color:red;'>*</span></label>
            <div class="form-group">
              <input name="granted_eot" type="date" class="form-control" required>
            </div>
          </div>
        </div>
        <div class="col-xs-12">
          <label class="form-group">Remarks:</label>
          <div class="form-group">
            <textarea name="remarks" class="form-control"></textarea>
          </div>
        </div>
        <div class="col-xs-6">
          <div class="form-group">
            <label for="InputATTACHMENTS:">ATTACHMENTS <span style='color:red;'>*</span></label>
            <input type="file" name="attachment_file" class="form-control imgs" placeholder="Text input" required>
          </div>
        </div>
      </div>
      <div class="col-xs-9"></div>
      <div class="modal-footer">
        <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
      </div>
    </form>
  </div>
</div>