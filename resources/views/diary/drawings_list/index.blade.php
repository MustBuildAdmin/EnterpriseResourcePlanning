
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

h3,
.h3 {
	font-size: 1rem !important;
}

table.dataTable>tbody>tr.child span.dtr-title {

	font-weight: var(--tblr-font-weight-bold);
	color: var(--tblr-muted);

}
#drawing_list{
    width:30%;

}
</style>

<div class="col-auto ms-auto d-print-none">
    <div class="input-group-btn">
       <select name="" id="drawing_list" class="form-control floatrght">
          <option value="" disabled>Select your option</option>
          <option value="1">Shop Drawings List</option>
          <option value="2">Contractor As-Built Drawings List</option>
          <option value="3">Consultant Working / Construction Drawings List</option>
          <option value="4">Tender / Contract DrawingsList</option>
       </select>
    </div>
 </div>
 <div class="container" id="content_id">
    <div class="col-md-6">
       <h2>{{__('Shop Drawings List')}}</h2>
    </div>
    <br> <br>
    @can('create directions')
    <div class="float-end mt-auto">
       <div class="input-group-btn">
          <a href="#" data-size="xl" data-url="{{ route('create_shop_drawing_list',["projectid"=>$projectid]) }}"
            data-ajax-popup="true" data-title="{{__('Create Project Specifications Summary')}}"
            data-bs-toggle="tooltip" title="{{__('Create')}}" class="btn btn-primary">
            <span class="btn-inner--icon"><i class="fa fa-plus"></i></span>
          </a>
          <a href="{{ route('projects.show', $projectid) }}" class="btn btn-danger"
          data-bs-toggle="tooltip" title="{{ __('Back') }}">
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
                <table class="table" id="example2" aria-describedby="shop drawing">
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
                   </tbody>
                </table>
             </div>
             @endcan
          </div>
       </div>
    </div>
 </div>

@include('new_layouts.footer')
<script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"
integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"
integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"
integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"
integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"
integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"
integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"
integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script>

 $("#drawing_list").change(function() {

    var tempcsrf = $("meta[name='csrf-token']").attr("content");

 	var dairy_id = $(this).find(":selected").val();

 	$.ajax({

 		type: "POST",
 		url: "{{ route('drawing_selection_list') }}",
 		data: {
 			_token: tempcsrf,
 			dairy_id: dairy_id,
 			project_id: {{$projectid}},
 		},
 		cache: false,
 		success: function(data) {
 			$("#content_id").html(data.html);
      
  setTimeout(() => {
    $('#example2').dataTable().fnDestroy();
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
  }, 3000);

 		},
 		error: function(XMLHttpRequest, textStatus, errorThrown) {
 			alert("Error: " + errorThrown);
 		}
 	});

 });

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


      
</script>
