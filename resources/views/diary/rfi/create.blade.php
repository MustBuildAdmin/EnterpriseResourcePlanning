<div class="modal-body">
    <div class="row">
        <form action="{{ route('rfi_info_main_save') }}" method="POST">
            @csrf
            <div class="container">
                <input type="hidden" name="project_id" value="{{$project}}">
                <div class="row">
                    <div class="form-group">
                        <label for="InputLIst">REQUEST FOR INFORMATION (RFI) STATUS for the project of:</label>
                       {{$project_name->project_name}}
                    </div>
                </div>
                <hr style="border: 1px solid black;">
                <h3 style="text-align: center;">REQUEST FOR INFORMATION (RFI) STATUS</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="InputLIst">RFI Reference No :</label>
                            <input type="text" name="reference_no" class="form-control" placeholder="Text input">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="input">Issue Date :</label>
                            <input type="date" name="issue_date" class="form-control" placeholder="Text input">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="input">Description:</label>
                            <textarea name="description" class="form-control" type="text"></textarea>
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