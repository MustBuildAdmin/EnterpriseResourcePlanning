<div class="modal-body">
    <div class="row">
        <form action="{{ route('rfi_info_main_save') }}" method="POST">
            @csrf
            <div class="container">
                <input type="hidden" name="project_id" value="{{$project}}">
                <div class="row">
                    <div class="form-group">
                        <label for="InputLIst">{{__('REQUEST FOR INFORMATION (RFI) STATUS for the project of:')}}</label>
                       {{$project_name->project_name}}
                    </div>
                </div>
                <hr style="border: 1px solid black;">
                <h3 style="text-align: center;">{{__('REQUEST FOR INFORMATION (RFI) STATUS')}}</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="InputLIst">{{__('RFI Reference No')}} <span style='color:red;'>*</span></label>
                            <input type="text" name="reference_no" class="form-control" placeholder="{{__('RFI Reference No')}}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="input">{{__('Issue Date')}} <span style='color:red;'>*</span></label>
                            <input type="date" name="issue_date" class="form-control" placeholder="Text input" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="input">{{__('Description')}} <span style='color:red;'>*</span></label>
                            <textarea name="description" class="form-control" placeholder="{{__('Description')}}" required></textarea>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
                <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
              </div>
        </form>
    </div>
</div>