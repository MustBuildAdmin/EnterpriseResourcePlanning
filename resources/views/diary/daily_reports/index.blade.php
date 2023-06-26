@include('new_layouts.header')
@include('construction_project.side-menu')
<link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>

.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    background: #fff;
    max-width: 1072px !important;
   
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

.action-btn {
	display: inline-grid !important;
}

h3, .h3 {
	font-size: 1rem !important;
}
</style>
<div class="sitereportmain">
    <div class="row">
      <div class="col-md-6">
        <h2>{{__('Daily Reports')}}</h2>
      </div>
      <div class="col-auto ms-auto d-print-none">
        <div class="input-group-btn">
            <a href="{{ route('daily_reportscreate') }}" class="btn btn-primary">
                <span class="btn-inner--icon"><i class="fa fa-plus"></i></span>
            </a>
            <a  class="btn btn-danger" data-bs-toggle="tooltip" title="{{ __('Back') }}">
              <span class="btn-inner--icon"><i class="ti ti-arrow-back"></i></span>
            </a>
        </div>
    </div>  
    </div>
    <div class="row">
      <div class="row">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-body table-border-style">
              <div class="table-responsive" >
                <table class="table" id="example2">
                  <thead>
                    <tr>
                      <th>{{__('SNo')}}</th>
                      <th>{{__('Daily Report No')}}</th>
                      <th>{{__('Contractor Name')}}</th>
                      <th>{{__('Date')}}</th>
                      <th>{{__('Weather')}}</th>
                      <th>{{__('Site conditions')}}</th>
                      <th>{{__('Day')}}</th>
                      <th>{{__('Temparture')}}</th>
                      <th>{{__('Minimum')}}</th>
                      <th>{{__('Prepared By')}}</th>
                      <th>{{__('Title')}}</th>
                      <th style="width:25%;">{{__('Action')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($data as $key=>$data_report)
                    <tr class="font-style">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$data_report->id}}</td>
                        <td>{{$data_report->contractor_name}}</td>
                        <td>{{$data_report->con_date}}</td>
                        <td>{{$data_report->weather}}</td>
                        <td>{{$data_report->site_conditions}}</td>  
                        <td>{{$data_report->con_day}}</td>
                        <td>{{$data_report->temperature}}</td>
                        <td>{{$data_report->min_input}}</td>
                        <td>{{$data_report->prepared_by}}</td>
                        <td>{{$data_report->title}}</td>
                        <td>
                            <div class="ms-2" style="display:flex;gap:10px;">
                                {{-- @can('edit procurement material') --}}
                                    <a class="btn btn-md bg-primary backgroundnone" href="{{route('daily_reportsedit',\Crypt::encrypt($data_report->id))}}"   title="{{__('Edit')}}" data-title="{{__('Edit Procurement Material Supply Log')}}"><i class="ti ti-pencil text-white"></i></a>
                                {{-- @endcan --}}
                                {{-- @can('delete procurement material') --}}
                                    {!! Form::open(['method' => 'POST', 'route' => ['delete_site_reports', $data_report->id],'id'=>'delete-form-'.$data_report->id]) !!} 
                                    {{ Form::hidden('id',$data_report->id, ['class' => 'form-control']) }}
                                    {{ Form::hidden('project_id',$project_id, ['class' => 'form-control']) }}
                                        <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}"><i class="ti ti-trash text-white"></i></a>
                                    {!! Form::close() !!} 
                                {{-- @endcan --}}
                            </div>
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@include('new_layouts.footer')
<script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script>
$(document).ready(function() {
    $('#example2').DataTable({
        dom: 'Bfrtip',
        searching: true,
        info: true,
        paging: true,
        scrollX: true,
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Procurement Material Supply Log',
                titleAttr: 'Excel',
                text: '<i class="fa fa-file-excel-o"></i>',

                exportOptions: {
                    modifier: {
                        order: 'index', // 'current', 'applied','index', 'original'
                        page: 'all', // 'all', 'current'
                        search: 'none' // 'none', 'applied', 'removed'
                    },
                    columns: [0, 1, 2, 3, 4, 5 ,6 , 7]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'Procurement Material Supply Log',
                titleAttr: 'PDF',
                orientation : 'landscape',
                pagesize: 'A3',
                orientation: 'landscape',
                text: '<i class="fa fa-file-pdf-o"></i>',
                customize: function(doc) {
                    // doc.content[1].table.widths =Array(doc.content[1].table.body[0].length + 1).join('*').split(''); 
                    doc.styles.tableBodyEven.alignment = 'center';
                    doc.styles.tableBodyEven.noWrap = true;
                    doc.styles.tableBodyOdd.alignment = 'center';
                    doc.styles.tableBodyOdd.noWrap = true;
                    doc.styles.tableHeader.fontSize = 9;  
                    doc.defaultStyle.fontSize = 9;
                    doc.content[0].alignment = 'center';
                    doc.defaultStyle.alignment = 'center';
                    doc.styles.tableHeader.alignment = 'center';
                    },
                exportOptions: {
              
                    modifier: {
                        order: 'index', // 'current', 'applied','index', 'original'
                        page: 'all', // 'all', 'current'
                        search: 'none' // 'none', 'applied', 'removed'
                    },
                    columns: [0, 1, 2, 3, 4, 5 ,6 , 7]
                }
            },
            {
                extend: 'print',
                title: 'Procurement Material Supply Log',
                titleAttr: 'Print',
                text: '<i class="fa fa-print"></i>',
                orientation: 'landscape',
                exportOptions: {
                    modifier: {
                        order: 'index', // 'current', 'applied','index', 'original'
                        page: 'all', // 'all', 'current'
                        search: 'none' // 'none', 'applied', 'removed'
                    },
                    columns: [0, 1, 2, 3, 4, 5 ,6 , 7]
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