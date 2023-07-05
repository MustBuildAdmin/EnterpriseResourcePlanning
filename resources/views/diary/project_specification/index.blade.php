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

table.dataTable>tbody>tr.child span.dtr-title {
   
   font-weight: var(--tblr-font-weight-bold);
   color: var(--tblr-muted);

}
</style>
<div class="row">
  <div class="col-md-6">
     <h2>{{__('Project Specifications Summary')}}</h2>
  </div>
@can('create directions')
<div class="col-auto ms-auto d-print-none">
  <div class="input-group-btn">
      <a href="#" data-size="xl" data-url="{{ route('add_project_specification',["project_id"=>$project_id]) }}"  data-ajax-popup="true" data-title="{{__('Create Project Specifications Summary')}}" data-bs-toggle="tooltip" title="{{__('Create')}}" class="btn btn-primary">
          <span class="btn-inner--icon"><i class="fa fa-plus"></i></span>
      </a>
      <a href="{{ route('projects.show', $project_id) }}"  class="btn btn-danger" data-bs-toggle="tooltip" title="{{ __('Back') }}">
        <span class="btn-inner--icon"><i class="fa fa-arrow-left"></i></span>
      </a>
  </div>
</div>
@endcan
<div class="col-xl-12 mt-3">
    <div class="card table-card">
      <div class="container-fluid">
        @can('manage project specification')
        <div class="table">
          <table class="table" id="example2">
            <thead class="">
              <tr>
                <th>{{__('S.No')}}</th>
                <th>{{__('Reference No')}}</th>
                <th>{{__('Description')}}</th>
                <th>{{__('Location')}}</th>
                <th>{{__('Drawing References (if any)')}}</th>
                <th>{{__('Remarks/ Notes')}}</th>
                <th>{{__('Attachments')}}</th>
                @if(Gate::check('edit project specification') || Gate::check('delete project specification'))
                <th>{{__('Action')}}</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @foreach ($dairy_data as $key=>$data)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$data->reference_no}}</td>
                <td>{{$data->description}}</td>
                <td>{{$data->location}}</td>
                <td>{{$data->drawing_reference != "" ? $data->drawing_reference :'-'}}</td>
                <td>{{$data->remarks != "" ? $data->remarks :'-'}}</td>
                <td>{{$data->attachment_file_name != "" ? $data->attachment_file_name :'-'}}</td>
                @if(Gate::check('edit project specification') || Gate::check('delete project specification'))
                <td>
                    <div class="ms-2" style="display:flex;gap:10px;">
                        @can('edit project specification')
                            <a href="#"  class="btn btn-md bg-primary backgroundnone" data-url="{{ route('edit_project_specification',["project_id"=>$project_id,"id"=>$data->id]) }}" data-ajax-popup="true" data-size="xl" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit Project Specifications Summary')}}"><i class="ti ti-pencil text-white"></i></a>
                        @endcan

                        @can('delete project specification')
                          {!! Form::open(['method' => 'POST', 'route' => ['delete_project_specification', $data->id],'id'=>'delete-form-'.$data->id]) !!} 
                          {{ Form::hidden('id',$data->id, ['class' => 'form-control']) }}
                          {{ Form::hidden('project_id',$project_id, ['class' => 'form-control']) }}
                          <a href="#"  class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}">
                            <i class="ti ti-trash text-white mt-1">
                            </i>
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
                      title: 'Project Specifications Summary',
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
                      title: 'Project Specifications Summary',
                      titleAttr: 'PDF',
                      pagesize: 'A4',
                      orientation: 'potrait',
                      pageSize: 'LEGAL',
                      text: '<i class="fa fa-file-pdf-o"></i>',
                      customize: function(doc) {
                        doc.styles.tableBodyEven.alignment = 'center';
                        doc.styles.tableBodyEven.noWrap = false;
                        doc.styles.tableBodyOdd.alignment = 'center';
                        doc.styles.tableBodyOdd.noWrap = false;
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
                      title: 'Project Specifications Summary',
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