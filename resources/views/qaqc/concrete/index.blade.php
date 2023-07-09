@include('new_layouts.header')
@include('construction_project.side-menu')
<link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  
.dataTables_wrapper .dataTables_paginate {
	float: right;
	text-align: right;
	padding-top: 0.25em;
}


.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    background: #fff;
    max-width: 1072px !important;
   
}

.table-responsive .bg-primary {
    background: unset !important;
}

div.dt-buttons .dt-button {
	background-color: #ffa21d;
	color: #fff;
	width: 29px;
	height: 28px;
	border-radius: 4px;
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
	display: inline-flex;
	align-items: center;
	justify-content: center;
	font-size: 20px;
}

h3, .h3 {
	font-size: 1rem !important;
}

</style>
<div class="row">
  <div class="col-md-6">
     <h2>{{__('Concrete Pouring Record ')}}</h2>
  </div>
    @can('create concrete')
    <div class="col-auto ms-auto d-print-none">
        <div class="input-group-btn">
            <a href="#" data-size="xl"
            data-url="{{ route('qaqc.concrete_create',["project_id"=>$project_id]) }}"
            data-ajax-popup="true" data-title="{{__('Create Concrete Pouring Record')}}"
            data-bs-toggle="tooltip" title="{{__('Create')}}" class="btn btn-primary">
            <span class="btn-inner--icon"><i class="fa fa-plus"></i></span>
            </a>
            <a href="{{ route('projects.show', $project_id) }}"
            class="btn btn-danger" data-bs-toggle="tooltip" title="{{ __('Back') }}">
              <span class="btn-inner--icon"><i class="fa fa-arrow-left"></i></span>
            </a>
        </div>
    </div>
    @endcan
    <div class="col-xl-12 mt-3">
      <div class="card table-card">
        <div class="container-fluid">
          @can('manage concrete')
          <div class="container table-responsive-xl">
            <table class="table" id="example2" aria-describedby="concrete">
              <thead class="">
                <tr>
                  <th>{{__('Sno')}}</th>
                  <th>{{__('Date of Casting')}}</th>
                  <th>{{__('Element of Casting')}}</th>
                  <th>{{__('Grade of Concrete')}}</th>
                  <th>{{__('Theoretical')}}</th>
                  <th>{{__('Actual')}}</th>
                  <th>{{__('7 days Test Fall on')}}</th>
                  <th>{{__('28 days Test Fall on')}}</th>
                  <th>{{__('28 days Result')}}</th>
                  <th>{{__('Remarks')}}</th>
                  <th>{{__('Attachment')}}</th>
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
                  <td>{{ Utility::site_date_format($bulk_data->testing_fall,\Auth::user()->id ?? '-')}}</td>
                  <td>{{ Utility::site_date_format($bulk_data->days_testing_falls,\Auth::user()->id ?? '-') }}</td>
                  <td>{{$bulk_data->days_testing_result ?? '-'}}</td>
                  <td>{{$bulk_data->remarks ?? '-'}}</td>
                  <td>{{$data->file_name ?? '-'}}</td>
                  @if(Gate::check('edit concrete') || Gate::check('delete concrete'))
                  <td>
                      <div class="ms-2" style="display:flex;gap:10px;">
                        @can('edit concrete')
                              <a href="#"  class="btn btn-md bg-primary backgroundnone"
                              data-url="{{ route('qaqc.concrete_edit',["project_id"=>$project_id,"id"=>$data->id]) }}"
                              data-ajax-popup="true" data-size="xl" data-bs-toggle="tooltip" title="{{__('Edit')}}"
                              data-title="{{__('Create Concrete Pouring Record')}}">
                              <i class="ti ti-pencil text-white"></i>
                            </a>
                          @endcan
                          @can('delete concrete')
                          {!! Form::open(['method' => 'POST', 'route' => ['concrete.delete_concrete', $data->id],'id'=>'delete-form-'.$data->id]) !!} 
                          {{ Form::hidden('id',$data->id, ['class' => 'form-control']) }}
                          {{ Form::hidden('project_id',$project_id, ['class' => 'form-control']) }}
                          <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para"
                           data-bs-toggle="tooltip" title="{{__('Delete')}}">
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
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script type="text/javascript">
     $(document).ready(function() {
        $('#example2').DataTable({
            dom: 'Bfrtip',
            searching: true,
            info: true,
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
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Concrete Pouring Record',
                    titleAttr: 'PDF',
                    pageSize: 'LEGAL',
                    pagesize: 'A3',
                    orientation: 'landscape',
                    text: '<i class="fa fa-file-pdf-o"></i>',
                    customize: function(doc) {
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
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
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
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
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
