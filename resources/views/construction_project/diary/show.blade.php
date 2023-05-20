@extends('layouts.admin')
@section('page-title')
    {{__('Project Diary')}}
@endsection
<style>
    div.dt-buttons .dt-button {
   background-color: #ffa21d;
    color:#fff;
    width: 29px;
    height: 28px;
    border-radius: 4px;
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;

}
div.dt-buttons .dt-button:hover {
    background-color: #ffa21d;
    color:#fff;
    width: 29px;
    height: 28px;
    border-radius: 4px;
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}
div.dt-buttons {
    float: right;
}
.action-btn {
    display: inline-grid !important;
}
h3, .h3 {
    font-size: 1rem !important;
}

</style>
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('diary')}}">{{__('Manage Diary')}}</a></li>
    <li class="breadcrumb-item">{{__('Dairy')}}</li>
@endsection

@section('action-btn')
<div class="float-end">
    <div class="diary_template_select">
      <input type="hidden" id="project_id" value="{{$project_id}}">
      <select id="diary_template_select"  class="form-control float-end">
        @foreach ($dairy_list as $list)
            <option value="{{$list->id}}">{{$list->diary_name}}</option>
        @endforeach
      </select>
    </div>
</div>  
@endsection


@section('content')
<div id="content_id">
    <div class="col-xl-12 mt-3">
        <div class="card table-card">
          <div class="col-auto float-end ms-4 mt-4">
            <a href="#" data-size="xl" data-url="{{ route('diary.diary_create',["project_id"=>$project_id]) }}" data-ajax-popup="true" data-title="{{__('Create New Project')}}" data-bs-toggle="tooltip" title="{{__('Create')}}" class="btn btn-sm btn-primary">
              <i class="ti ti-plus"></i>
            </a>
          </div>
          <div class="card-header card-body table-border-style">
            <div class="table-responsive">
              <table class="table datatable" >
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
                        <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-url="{{ route('dairy.dairy_update',["project_id"=>$project_id,"id"=>$data->id]) }}" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit Project')}}">
                          <i class="ti ti-pencil text-white"></i>
                        </a>
                      </div>
                      <div class="action-btn bg-danger ms-2"> {!! Form::open(['method' => 'POST', 'route' => ['diary_destroy', $data->id],'id'=>'delete-form-'.$data->id]) !!} 
                        <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}">
                          <i class="ti ti-trash text-white mt-1"></i>
                        </a> {!! Form::close() !!} 
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
@endsection

@push('script-page')
{{-- <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.5/js/buttons.print.min.js"></script>
<script>
$(document).ready(function() {
    $('.datatable').DataTable({
        dom: 'Bfrtip',
        searching: false,
        info: false,
        paging: false,
        buttons: [

            {

                extend: 'excelHtml5',
                title: 'Task Report',
                titleAttr: 'Excel',
                text: '<i class="fa fa-file-excel-o"></i>',

                exportOptions: {
                    modifier: {
                        order: 'index', // 'current', 'applied','index', 'original'
                        page: 'all', // 'all', 'current'
                        search: 'none' // 'none', 'applied', 'removed'
                    },
                   
                }
            },

            'colvis'
        ]
       
    });
}); 

</script> --}}
<script>
 $("#diary_template_select").change(function() {

 	var tempcsrf = '{!! csrf_token() !!}';

 	var dairy_id = $(this).find(":selected").val();

 	$.ajax({

 		type: "POST",
 		url: "{{ route('diary_data') }}",
 		data: {
 			_token: tempcsrf,
 			dairy_id: dairy_id,
 			project_id: {{$project_id}},
 		},
 		cache: false,
 		success: function(data) {
 			$("#content_id").html(data.html);
 		},
 		error: function(XMLHttpRequest, textStatus, errorThrown) {
 			alert("Error: " + errorThrown);
 		}
 	});

 });
</script>
<script type="text/javascript">
  $(document).ready(function () {
    var i = 0;
    $(document).on("click", "#dynamic-ar", function () {
        ++i;
        $("#dynamicAddRemove").append('<tr><td> <h4 style="text-align: center; font-weight: 700">Initiator Action:</h4><div class="row mb-5"><div class="col"><div class="form-group"><label for="InputReference">Reference:</label><input type="text" name="initiator_reference[' + i +']" class="form-control" placeholder="Enter your  Reference"/></div></div><div class="col"><div class="form-group"><label for="Inputdate">Date:</label><input type="date" name="initiator_date[' + i +']" class="form-control" placeholder="Enter your  Date"/></div></div><div class="col-md-12 mt-3"><label for="InputRemarks">Attachment</label><input name="initiator_file_name[' + i +']" required type="file" id="" class="form-control" /></div></div> <h4 style="text-align: center; font-weight: 700">Replier:</h4><div class="row mb-3"><div class="col"><div class="form-group"><label for="InputReference">Reference:</label><input type="text" name="replier_reference[' + i +']" class="form-control" placeholder="Enter your  Reference"/></div></div><div class="col"><div class="form-group"><label for="Inputdate">Date:</label><input type="date" name="replier_date[' + i +']" class="form-control" placeholder="Enter your  Date"/></div></div></div><div class="row mb-5"><div class="col form-group"><label for="InputRemarks">Status:</label><select name="replier_status[' + i +']" class="form-control" aria-label="Default select example"><option selected disabled>Status</option><option value="clear">Clear</option><option value="pending">Pending</option><option value="withdrawn">Withdrawn</option></select></div><div class="col-12 mt-3"><div class="form-group"><label for="InputRemarks">Remarks/ Notes:</label><textarea type="text" class="form-control" name="replier_remark[' + i +']" placeholder="Enter your Remarks/ Notes"></textarea></div></div><div class="col-md-12 mt-3"><label for="InputRemarks">Attachment</label><input required type="file"  name="replier_file_name[' + i +']" id="concreteFile" class="form-control" /></div></div><div class="col-md-12 mt-3"><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></div></td></tr>');
    });
    $(document).on('click', '.remove-input-field', function () {
        $(this).parents('tr').remove();
    });
  });
</script>
@endpush
