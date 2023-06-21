<style>
  textarea {
    resize: vertical;
  }
</style>
<div class="modal-body">
  <div class="row">
    <div class="container">
      <form class="" id="edit_data" action="{{ route('update_consultant_direction') }}" enctype="multipart/form-data" method="POST"> 
        @csrf 
        <div class="container">
            <input type="hidden" name="project_id" value="{{$project}}">
            <div class="row">
              <input name="id" type="hidden" class="form-control" value="{{$consult_dir->id}}" placeholder="Enter your  Issued By" />
              <div class="col form-group ">
                <label for="InputIssued">{{__('ARCHITECT AND ENGNEERS DIRECTIONS (AD & ED) SUMMARY for the project of:')}}</label>
                <span>{{$project_name->project_name}}</span>
              </div>
            </div>
            <hr style="border: 1px solid black" />
            <div class="col-xs-12">
              <h3 style="text-align: center;text-transform: uppercase;">{{__('Consultants Directions Summary')}}</h3>
            </div>
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="InputIssued">{{__('Issued By')}} <span style='color:red;'>*</span></label>
                  <input name="issued_by" type="text" class="form-control" value="{{$consult_dir->issued_by}}" placeholder="{{__('Issued By')}}" />
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label for="InputIssued">{{__('Issued Date')}} <span style='color:red;'>*</span></label>
                  <input name="issued_date" type="date" class="form-control" value="{{$consult_dir->issued_date}}" placeholder="{{__('Issued Date')}}" />
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label for="InputReference">{{__('AD/ED Reference')}} <span style='color:red;'>*</span></label>
                  <input name="ad_ae_ref" value="{{$consult_dir->ad_ae_ref}}" type="text" class="form-control" placeholder="{{__('AD/ED Reference')}}" />
                </div>
              </div>
              <div class="col-12 mt-3">
                <div class="form-group">
                  <label for="InputDescription">{{__('AD/ED Description')}} <span style='color:red;'>*</span></label>
                  <textarea name="ad_ae_decs" type="text" class="form-control" placeholder="{{__('AD/ED Description')}}">{{$consult_dir->ad_ae_decs}}</textarea>
                </div>
                <div class="col-md-12 mt-3">
                  <label for="InputRemarks">{{__('Attachment')}} <span style='color:red;'>*</span></label>
                  <input name="attach_file_name"  type="file"  class="form-control"/>
                  <span>{{$consult_dir->attach_file_name}}</span>
                </div>
              </div>
            </div>
            <table class="table" id="dynamicAddRemove"> 
              @foreach ($consult_dir_multi as $key => $mutli_data) 
              <tr>
                <td>
                  <h4 style="text-align: center; font-weight: 700">{{__('Initiator Action &  Reply')}}</h4>
                  <div class="row mb-5">
                    <div class="col">
                      <div class="form-group">
                        <label for="InputReference">{{__('Reference')}}</label>
                        <input type="text" value="{{$mutli_data['initiator_reference']}}" name="initiator_reference[]" class="form-control" placeholder="{{__('Reference')}}" />
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <label for="Inputdate">{{__('Date')}}</label>
                        <input type="date" value="{{$mutli_data['initiator_date']}}"  name="initiator_date[]" class="form-control" placeholder="Enter your  Date" />
                      </div>
                    </div>
                    <div class="col-md-12 mt-3">
                      <label for="InputRemarks">{{__('Attachment')}}</label>
                      <input name="initiator_file_name[]"  type="file" id="" class="form-control" multiple />
                      <span>{{$mutli_data['initiator_file_name']}}</span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col form-group">
                      <label for="InputRemarks">{{__('Status')}}</label>
                      <select name="replier_status[]" class="form-control" aria-label="Default select example">
                        <option selected disabled>Status</option>
                        <option value="clear" @if('clear'==$mutli_data['replier_status']){ selected }@endif>Clear</option>
                        <option value="pending" @if('pending'==$mutli_data['replier_status']){ selected }@endif>Pending</option>
                        <option value="withdrawn" @if('withdrawn'==$mutli_data['replier_status']){ selected }@endif>Withdrawn</option>
                      </select>
                    </div>
                    <div class="col-12 mt-3">
                      <div class="form-group">
                        <label for="InputRemarks">{{__('Remarks/ Notes')}}</label>
                        <textarea  class="form-control" name="replier_remark[]" placeholder="{{__('Remarks/ Notes')}}">{{ $mutli_data['replier_remark'] }}</textarea>
                      </div>
                    </div>
                    {{-- <div class="col-md-12 mt-3">
                      <label for="InputRemarks">{{__('Attachment')}}</label>
                      <input  type="file" name="replier_file_name[]" id="" class="form-control"  />
                      <span>{{ $mutli_data['replier_file_name'] }}</span>
                    </div> --}}
                  </div>
                  @if(!empty($initiator_date))
                  <div class="col-md-12 mt-3">
                    <button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary">{{__('Add More')}}</button>
                  </div>
                  @endif
                </td>
              </tr>
         
            </table> 
            @endforeach 
            <div class="row">
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
<script type="text/javascript">
  $(document).ready(function () {
    var i = 0;
    $("#edit_data").on('click', '#dynamic-ar', function () {
        ++i;
        $("#dynamicAddRemove").append('<tr><td> <h4 style="text-align: center; font-weight: 700">Initiator Action & Reply</h4><div class="row mb-5"><div class="col"><div class="form-group"><label for="InputReference">Reference:</label><input type="text" name="initiator_reference[' + i +']" class="form-control" placeholder="Enter your  Reference"/></div></div><div class="col"><div class="form-group"><label for="Inputdate">Date:</label><input type="date" name="initiator_date[' + i +']" class="form-control" placeholder="Enter your  Date"/></div></div><div class="col-md-12 mt-3"><label for="InputRemarks">Attachment</label><input name="initiator_file_name[' + i +']"  type="file" id="" class="form-control" /></div></div><div class="row"><div class="col form-group"><label for="InputRemarks">Status:</label><select name="replier_status[' + i +']" class="form-control" aria-label="Default select example"><option selected disabled>Status</option><option value="clear">Clear</option><option value="pending">Pending</option><option value="withdrawn">Withdrawn</option></select></div><div class="col-12 mt-3"><div class="form-group"><label for="InputRemarks">Remarks/ Notes:</label><textarea type="text" class="form-control" name="replier_remark[' + i +']" placeholder="Enter your Remarks/ Notes"></textarea></div></div><div class="col-md-12 mt-3"><label for="InputRemarks">Attachment</label><input  type="file"  name="replier_file_name[' + i +']" id="concreteFile" class="form-control" /></div></div><div class="col-md-12 mt-3"><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></div></td></tr>');
    });
    $(document).on('click', '.remove-input-field', function () {
        $(this).parents('tr').remove();
    });
  });
</script>
