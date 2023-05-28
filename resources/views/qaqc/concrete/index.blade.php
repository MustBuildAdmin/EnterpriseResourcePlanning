@include('new_layouts.header')
@include('construction_project.side-menu')
<style>
  
h3, .h3 {
    font-size: 1rem !important;
}

</style>

<div>
    <div class="col-xl-12 mt-3">
        <div class="card table-card">
          <div class="col-auto float-end ms-4 mt-4">
            <a href="#" data-size="xl" data-url="{{ route('qaqc.concrete_create',["project_id"=>$project_id]) }}" data-ajax-popup="true" data-title="{{__('Create New Project')}}" data-bs-toggle="tooltip" title="{{__('Create')}}" class="btn btn-sm btn-primary">
              <i class="ti ti-plus"></i>
            </a>
          </div>
          <div class="card-header card-body table-border-style">
            <div class="table-responsive">
              <table class="table datatable" id="example1">
                <thead class="">
                  <tr>
                    <th>{{__('Sno')}}</th>
                    <th>{{__('Date of Casting')}}</th>
                    <th>{{__('Casting Element')}}</th>
                    <th>{{__('Concrete Grade')}}</th>
                    <th>{{__('Theoretical')}}</th>
                    <th>{{__('Actual')}}</th>
                    <th>{{__('7 days Test Fall on')}}</th>
                    <th>{{__('28 days Test Fall on')}}</th>
                    <th>{{__('28 days Result')}}</th>
                    <th>{{__('Remarks')}}</th>
                    <th>{{__('Action')}}</th>
                  </tr>
                </thead>
                <tbody> 
                @forelse ($dairy_data as $key=>$data) 
                        @php $check=$data->diary_data; @endphp 
                        @if($check != null) 
                            @php $bulk_data = json_decode($check); @endphp 
                        @else 
                            @php $bulk_data = array(); @endphp 
                        @endif 
                    <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$bulk_data->date_of_casting}}</td>
                    <td>{{$bulk_data->element_of_casting}}</td>
                    <td>{{$bulk_data->grade_of_concrete}}</td>
                    <td>{{$bulk_data->theoretical}}</td>
                    <td>{{$bulk_data->actual}}</td>
                    <td>{{$bulk_data->testing_fall ?? '-'}}</td>
                    <td>{{$bulk_data->days_testing_falls ?? '-'}}</td>
                    <td>{{$bulk_data->days_testing_result ?? '-'}}</td>
                    <td>{{$bulk_data->remarks}}</td>
                    <td>
                      <div class="action-btn bg-primary ms-2">
                        <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-url="{{ route('qaqc.concrete_edit',["project_id"=>$project_id,"id"=>$data->id]) }}" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit Project')}}">
                          <i class="ti ti-pencil text-white"></i>
                        </a>
                      </div>
                      <div class="action-btn bg-danger ms-2"> 
                        {!! Form::open(['method' => 'POST', 'route' => ['concrete.delete_concrete', $data->id],'id'=>'delete-form-'.$data->id]) !!} 
                        {{ Form::hidden('id',$data->id, ['class' => 'form-control']) }}
                        {{ Form::hidden('project_id',$project_id, ['class' => 'form-control']) }}
                        <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}">
                          <i class="ti ti-trash text-white mt-1"></i>
                        </a> 
                        {!! Form::close() !!} 
                      </div>
                    </td> 
                  </tr> 
                @empty 
                  <tr>
                      <td  colspan="11" class="text-center">No Concrete Pouring Record Data Found</td>
                  </tr> 
                @endforelse 
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
</div>
@include('new_layouts.footer')
<script>

</script>
<script type="text/javascript">
  $(document).ready(function () {
    var i = 0;
    $(document).on("click", "#dynamic-ar", function () {
        ++i;
        $("#dynamicAddRemove").append('<tr><td> <h4 style="text-align: center; font-weight: 700">Initiator Action:</h4><div class="row mb-5"><div class="col"><div class="form-group"><label for="InputReference">Reference:</label><input type="text" name="initiator_reference[]" class="form-control" placeholder="Enter your  Reference"/></div></div><div class="col"><div class="form-group"><label for="Inputdate">Date:</label><input type="date" name="initiator_date[]" class="form-control" placeholder="Enter your  Date"/></div></div><div class="col-md-12 mt-3"><label for="InputRemarks">Attachment</label><input name="initiator_file_name[]"  type="file" id="" class="form-control" multiple/></div></div> <h4 style="text-align: center; font-weight: 700">Replier:</h4><div class="row mb-3"><div class="col"><div class="form-group"><label for="InputReference">Reference:</label><input type="text" name="replier_reference[]" class="form-control" placeholder="Enter your  Reference"/></div></div><div class="col"><div class="form-group"><label for="Inputdate">Date:</label><input type="date" name="replier_date[]" class="form-control" placeholder="Enter your  Date"/></div></div></div><div class="row mb-5"><div class="col form-group"><label for="InputRemarks">Status:</label><select name="replier_status[]" class="form-control" aria-label="Default select example"><option selected disabled>Status</option><option value="clear">Clear</option><option value="pending">Pending</option><option value="withdrawn">Withdrawn</option></select></div><div class="col-12 mt-3"><div class="form-group"><label for="InputRemarks">Remarks/ Notes:</label><textarea type="text" class="form-control" name="replier_remark[]" placeholder="Enter your Remarks/ Notes"></textarea></div></div><div class="col-md-12 mt-3"><label for="InputRemarks">Attachment</label><input  type="file"  name="replier_file_name[]" id="" class="form-control" multiple/></div></div><div class="col-md-12 mt-3"><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></div></td></tr>');
    });
    $(document).on('click', '.remove-input-field', function () {
        $(this).parents('tr').remove();
    });

    var j = 0;
    $(document).on("click", "#dynamic-rfi", function () {
        ++j;
        $("#dynamicaddrfi").append('<tr><td><h4 style="text-align: center;">Date Replied By Consultant :</h4><div class=""><div class="row"><div class="col-md-6"><div class="form-group"><label for="InputLIst">Submit Date :</label><input type="date" name="submit_date[]" class="form-control" value=""></div></div><div class="col-md-6"><div class="form-group"><label for="input">Return Date :</label><input type="date" name="return_date[]" class="form-control" value=""></div></div></div><div class="row"><div class="col-md-6"><div class="form-group"><label for="Input">Status of Return :</label><select class="form-control" name="status_of_return[]"><option selected disabled>Status</option><option value="Exception">No Exception Taken (NET) (OR) Approved /with comment</option><option value="Resubmission">Revise No Resubmission Requried (RNRR)</option><option value="Revise">Revise and Resubmit (RR)</option><option value="Submit">Submit Specified Item (SSI)</option><option value="Rejected">Rejected</option></select></div></div><div class="col-md-6"><div class="form-group"><label for="InputDate">Remarks :</label><textarea class="form-control" name="remarks[]"></textarea></div></div></div><div class="col-md-3 pull-right"><button class="btn btn-secondary" type="button" id="remove-input-field"> Remove Submission </button></div></div></td></tr>');
    });
    $(document).on('click', '#remove-input-field', function () {
        $(this).parents('tr').remove();
    });

  });
</script>

