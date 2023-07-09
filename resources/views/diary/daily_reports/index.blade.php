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

.table-responsive .bg-primary {
	background: #206bc4 !important;
}

table.dataTable>tbody>tr.child span.dtr-title {
   
   font-weight: var(--tblr-font-weight-bold);
   color: var(--tblr-muted);

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
     <h2>{{__('Site Reports')}}</h2>
  </div>
@can('create site reports')
<div class="col-auto ms-auto d-print-none">
  <div class="input-group-btn">
      <a href="{{ route('daily_reportscreate') }}" title="{{__('Create Site Report')}}" class="btn btn-primary">
          <span class="btn-inner--icon"><i class="fa fa-plus"></i></span>
      </a>
      <a href=""  class="btn btn-danger" data-bs-toggle="tooltip" title="{{ __('Back') }}">
        <span class="btn-inner--icon"><i class="fa fa-arrow-left"></i></span>
      </a>
  </div>
</div>
@endcan
<div class="col-xl-12 mt-3">
    <div class="card table-card">
      <div class="container-fluid">
        @can('manage site reports')
        <div class="container table-responsive-xl">
          <table class="table" id="example2" aria-describedby="daily reports">
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
                <th>{{__('Degree')}}</th>
                {{-- <th>{{__('Document')}}</th> --}}
                <th>{{__('Remarks')}}</th>
                <th>{{__('Prepared By')}}</th>
                <th>{{__('Title')}}</th>
                @if(Gate::check('edit site reports') || Gate::check('delete site reports'))
                <th>{{__('Action')}}</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $key=>$data_report)
              <tr class="">
                  <td>{{$loop->iteration}}</td>
                  <td>{{$data_report->id}}</td>
                  <td>{{$data_report->contractor_name}}</td>
                  <td>{{ Utility::site_date_format($data_report->con_date,\Auth::user()->id) }}</td>
                  <td>{{$data_report->weather}}</td>
                  <td>{{$data_report->site_conditions}}</td>
                  <td>{{$data_report->con_day}}</td>
                  <td>{{$data_report->temperature}}</td>
                  <td>{{$data_report->min_input}}</td>
                  <td>{{$data_report->degree}}</td>
                  {{-- <td>
                    @php
                    $file_explode = explode(',',$data_report->file_name);
                    @endphp
                    @forelse ($file_explode as $file_show)
                    @if($file_show != "")
                        <span class="">{{$file_show}}</span> <br>
                    @else
                        -
                    @endif
                    @empty
                    @endforelse
                  </td>  --}}
                  <td>{{$data_report->remarks}}</td>
                  <td>{{$data_report->prepared_by}}</td>
                  <td>{{$data_report->title}}</td>
                  @if(Gate::check('edit site reports') || Gate::check('delete site reports'))
                  <td>
                      <div class="ms-2" style="display:flex;gap:10px;">
                          @can('edit site reports')
                              <a class="btn btn-md bg-primary backgroundnone"
                                href="{{route('daily_reportsedit',Crypt::encrypt($data_report->id))}}"
                                title="{{__('Edit Site Report')}}" data-title="{{__('Edit Site Report')}}">
                                <i class="ti ti-pencil text-white"></i>
                              </a>
                          @endcan
                          @can('delete site reports')
                              {!! Form::open(['method' => 'POST', 'route' => ['delete_site_reports',
                               $data_report->id],'id'=>'delete-form-'.$data_report->id]) !!}
                              {{ Form::hidden('id',$data_report->id, ['class' => 'form-control']) }}
                              {{ Form::hidden('project_id',$project_id, ['class' => 'form-control']) }}
                                  <a href="#" class="btn btn-md btn-danger bs-pass-para"
                                   data-bs-toggle="tooltip" title="{{__('Delete')}}"
                                   data-original-title="{{__('Delete')}}"
                                   data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone.
                                   Do you want to continue?')}}">
                                   <i class="ti ti-trash text-white"></i>
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

@include('new_layouts.footer')
<script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script>
  $(document).on('keypress', function (e) {
    if (e.which == 13) {
        swal.closeModal();
    }
});

  $(document).ready(function() {
          $('#example2').DataTable({
              dom: 'Bfrtip',
              searching: true,
              info: true,
              responsive:true,
              paging: true,
              info: true,
              buttons: [
                  {
                      extend: 'excelHtml5',
                      title: 'Site Reports',
                      titleAttr: 'Excel',
                      text: '<i class="fa fa-file-excel-o"></i>',
      
                      exportOptions: {
                          modifier: {
                              order: 'index', // 'current', 'applied','index', 'original'
                              page: 'all', // 'all', 'current'
                              search: 'none' // 'none', 'applied', 'removed'
                          },
                          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8 , 9 ,10 ,11, 12]
                      }
                  },
                  {
                      extend: 'pdfHtml5',
                      title: 'Site Reports',
                      titleAttr: 'PDF',
                      pagesize: 'A3',
                      orientation: 'landscape',
                      pageSize: 'LEGAL',
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
                          columns: [0, 1, 2, 3, 4, 5, 6 ,7, 8 , 9 ,10 ,11 ,12]
                      }
                  },
                  {
                      extend: 'print',
                      title: 'Site Reports',
                      titleAttr: 'Print',
                      text: '<i class="fa fa-print"></i>',
      
                      exportOptions: {
                          modifier: {
                              order: 'index', // 'current', 'applied','index', 'original'
                              page: 'all', // 'all', 'current'
                              search: 'none' // 'none', 'applied', 'removed'
                          },
                          columns: [0, 1, 2, 3, 4, 5, 6,7, 8 , 9 ,10 ,11 ,12]
                      }
                  },
                  'colvis'
              ]
          });
  });

  $(document).on('change', '.document_setup', function(){
        var fileExtension = ['jpeg', 'jpg', 'png', 'pdf', 'gif'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            $(".show_document_file").hide();
            $(".show_document_error").html("Upload only pdf, jpeg, jpg, png, gif");
            $(".add").prop('disabled',true);
            return false;
        } else{
            $(".show_document_file").show();
            $(".show_document_error").hide();
            $(".add").prop('disabled',false);
            return true;
        }

    });
      
</script>