@include('new_layouts.header')
@include('construction_project.side-menu')
<link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  
.dataTables_wrapper .dataTables_paginate {
	float: right;
	text-align: right;
	padding-top: 0.25em;
}

.table-responsive .bg-primary {
	background: #206bc4 !important;
}

div.dt-buttons .dt-button {
	background-color: #ffa21d;
	color: #fff;
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
	color: #fff;
	width: 29px;
	height: 28px;
	border-radius: 4px;
	color: #fff;
	display: inline-flex;
	align-items: center;
	justify-content: center;
	font-size: 20px;
}

h3, .h3 {
	font-size: 1rem !important;
}

.table-responsive .bg-primary {
	background: unset !important;
}
</style>
<div class="row">
  <div class="col-md-6">
     <h2>{{__('Concrete Pouring Record ')}}</h2> 
  </div>
    @can('create concrete')
    <div class="col-auto ms-auto d-print-none">
        <div class="input-group-btn">
            <a href="#" data-size="xl" data-url="{{ route('qaqc.concrete_create',["project_id"=>$project_id]) }}" data-ajax-popup="true" data-title="{{__('Create Concrete Pouring Record')}}" data-bs-toggle="tooltip" title="{{__('Create')}}" class="btn btn-primary">
                <span class="btn-inner--icon"><i class="fa fa-plus"></i></span>
            </a>
            <a href="{{ route('projects.show', $project_id) }}"  class="btn btn-danger" data-bs-toggle="tooltip" title="{{ __('Back') }}">
              <span class="btn-inner--icon"><i class="ti ti-arrow-back"></i></span>
            </a>
        </div>
    </div>  
    @endcan
    <div class="col-xl-12 mt-3">
      <div class="card table-card">
        <div class="card-header card-body table-border-style">
          @can('manage concrete')
          <div class="table">
            <table class="table" id="example2">
              <thead class="">
                <tr>
                  <th>{{__('Sno')}}</th>
                  <th>{{__('Date of Casting')}}</th>
                  <th>{{__('Element of Casting')}}</th>
                  <th>{{__('Grade of Concrete')}}</th>
                  <th>{{__('Theoretical')}}</th>
                  <th>{{__('Actual')}}</th>
                  {{-- <th>{{__('7 days Test Fall on')}}</th>
                  <th>{{__('28 days Test Fall on')}}</th> --}}
                  <th>{{__('28 days Result')}}</th>
                  {{-- <th>{{__('Remarks')}}</th> --}}
                  @if(Gate::check('edit concrete') || Gate::check('delete concrete'))
                  <th>{{__('Action')}}</th>
                  @endif
                </tr>
              </thead>
              <tbody> 
              @foreach ($dairy_data as $key=>$data) 
                      @php $check=$data->diary_data; @endphp 
                      @if($check != null) 
                          @php $bulk_data = json_decode($check); @endphp 
                      @else 
                          @php $bulk_data = array(); @endphp 
                      @endif 
                  <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{ Utility::site_date_format($bulk_data->date_of_casting,\Auth::user()->id) }}</td>
                  <td>{{$bulk_data->element_of_casting}}</td>
                  <td>{{$bulk_data->grade_of_concrete}}</td>
                  <td>{{ Utility::site_date_format($bulk_data->theoretical,\Auth::user()->id)}}</td>
                  <td>{{ Utility::site_date_format($bulk_data->actual,\Auth::user()->id) }}</td>
                  {{-- <td>{{$bulk_data->testing_fall ?? '-'}}</td>
                  <td>{{$bulk_data->days_testing_falls ?? '-'}}</td> --}}
                  <td>{{$bulk_data->days_testing_result ?? '-'}}</td>
                  {{-- <td>{{$bulk_data->remarks}}</td> --}}
                  @if(Gate::check('edit concrete') || Gate::check('delete concrete'))
                  <td>
                      <div class="ms-2" style="display:flex;gap:10px;">
                        @can('edit concrete')
                              <a href="#"  class="btn btn-md bg-primary backgroundnone" data-url="{{ route('qaqc.concrete_edit',["project_id"=>$project_id,"id"=>$data->id]) }}" data-ajax-popup="true" data-size="xl" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Create Concrete Pouring Record')}}"><i class="ti ti-pencil text-white"></i></a>
                          @endcan
                          @can('delete concrete')
                          {!! Form::open(['method' => 'POST', 'route' => ['concrete.delete_concrete', $data->id],'id'=>'delete-form-'.$data->id]) !!} 
                          {{ Form::hidden('id',$data->id, ['class' => 'form-control']) }}
                          {{ Form::hidden('project_id',$project_id, ['class' => 'form-control']) }}
                          <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}">
                            <i class="ti ti-trash text-white mt-1"></i>
                          </a> 
                          {!! Form::close() !!} 
                          @endcan
                      </div>
                  </td>
                  @endif
                </tr> 
              @endforeach
              </tbody>
            </table>
          </div>
          @endcan
        </div>
      </div>
    </div>    
</div>
@include('new_layouts.footer')
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
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

     $(document).ready(function() {
        $('#example2').DataTable({
            dom: 'Bfrtip',
            searching: true,
            info: true,
            paging: true,
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Concrete Pouring Record',
                    titleAttr: 'Excel',
                    text: '<i class="fa fa-file-excel-o"></i>',
    
                    exportOptions: {
                        modifier: {
                            order: 'index', // 'current', 'applied','index', 'original'
                            page: 'all', // 'all', 'current'
                            search: 'none' // 'none', 'applied', 'removed'
                        },
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Concrete Pouring Record',
                    titleAttr: 'PDF',
                    text: '<i class="fa fa-file-pdf-o"></i>',
                    customize: function(doc) {
                        // doc.content[1].table.widths =Array(doc.content[1].table.body[0].length + 1).join('*').split(''); 
                        doc.styles.tableBodyEven.alignment = 'center';
                        doc.styles.tableBodyEven.noWrap = true;
                        doc.styles.tableBodyOdd.alignment = 'center';
                        doc.styles.tableBodyOdd.noWrap = true;
                        doc.styles.tableHeader.fontSize = 9;  
                        doc.defaultStyle.fontSize = 9;
                        doc.defaultStyle.alignment = 'center';
                        doc.styles.tableHeader.alignment = 'center';
                    },
    
                    exportOptions: {
                        modifier: {
                            order: 'index', // 'current', 'applied','index', 'original'
                            page: 'all', // 'all', 'current'
                            search: 'none' // 'none', 'applied', 'removed'
                        },
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'print',
                    title: 'Concrete Pouring Record',
                    titleAttr: 'Print',
                    text: '<i class="fa fa-print"></i>',
    
                    exportOptions: {
                        modifier: {
                            order: 'index', // 'current', 'applied','index', 'original'
                            page: 'all', // 'all', 'current'
                            search: 'none' // 'none', 'applied', 'removed'
                        },
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                'colvis'
            ]
        });
    });

$(document).on('keypress', function (e) {
    if (e.which == 13) {
        swal.closeModal();
    }
});
</script>
