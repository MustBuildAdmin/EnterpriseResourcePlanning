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

table.dataTable>tbody>tr.child span.dtr-title {
   
   font-weight: var(--tblr-font-weight-bold);
   color: var(--tblr-muted);

}
</style>
<div class="row">
  <div class="col-md-8">
     <h2>{{__('VO / Change Order/ SCA')}}</h2>
  </div>
    @can('create vochange')
    <div class="col-auto ms-auto d-print-none">
      <div class="input-group-btn">
          <a class="btn btn-primary" href="#" data-size="xl"
            data-url="{{ route('add_variation_scope_change',["projectid"=>$projectid]) }}"
            data-ajax-popup="true" data-title="{{__('Create VO/Change Order')}}"
            data-bs-toggle="tooltip" title="{{__('Create')}}">
            <span class="btn-inner--icon"><i class="fa fa-plus"></i></span>
          </a>
          <a href="{{ route('projects.show', $projectid) }}"  class="btn btn-danger"
           data-bs-toggle="tooltip" title="{{ __('Back') }}">
            <span class="btn-inner--icon"><i class="fa fa-arrow-left"></i></span>
          </a>
      </div>
    </div>
    @endcan
    <div class="col-xl-12 mt-3">
      <div class="card table-card">
        <div class="container-fluid">
          @can('manage vochange')
          <div class="container table-responsive-xl">
             <!-- table data -->
            <table class="table" id="example2" aria-describedby="vo_sca_change_order">
              <thead class="">
                <tr>
                  <th>{{__('S.No')}}</th>
                  <th>{{__('Issued By')}}</th>
                  <th>{{__('Issued Date')}}</th>
                  <th>{{__('VO/SCA Reference')}}</th>
                  <th>{{__('VO Description')}}</th>
                  <th>{{__('Reference')}}</th>
                  <th>{{__('Date')}}</th>
                  <th>{{__('Contractor Claimed Omission Cost')}}</th>
                  <th>{{__('Contractor Claimed  Addition Cost')}}</th>
                  <th>{{__('Contractor Claimed Net Amount')}}</th>
                  <th>{{__('Consultant Certified Omission Cost')}}</th>
                  <th>{{__('Consultant Certified Addition Cost')}}</th>
                  <th>{{__('Consultant Certified Net Amount')}}</th>
                  {{-- <th>{{__('Net Amount')}}
                  </th>  --}}
                  {{-- <th>{{__('Impact/Lead Time')}}</th>
                  <th>{{__('Granted EOT(in days)')}}</th>
                  <th>{{__(' Remarks')}}</th> --}}
                  @if(Gate::check('edit vochange') || Gate::check('delete vochange'))
                  <th>{{__('Action')}}</th>
                  @endif
                </tr>
              </thead>
              <tbody>
                @foreach ($dairydata as $key=>$data)
                    @php
                         $check=$data->data;
                    @endphp
                    @if($check != null)
                    @php $bulk_data = json_decode($check); @endphp
                    @else
                    @php $bulk_data = array(); @endphp
                    @endif
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$bulk_data->issued_by}}</td>
                  <td>{{ Utility::site_date_format($bulk_data->issued_date,\Auth::user()->id) }}</td>
                  <td>{{$bulk_data->sca_reference}}</td>
                  <td>{{$bulk_data->vo_reference}}</td>
                  <td>{{$bulk_data->reference}}</td>
                  <td>{{ Utility::site_date_format($bulk_data->vo_date,\Auth::user()->id) }}</td>
                  <td>{{$bulk_data->claimed_omission_cost}}</td>
                  <td>{{$bulk_data->claimed_addition_cost}}</td>
                  <td>{{$bulk_data->claimed_net_amount}}</td>
                  <td>{{$bulk_data->approved_omission_cost}}</td>
                  <td>{{$bulk_data->approved_addition_cost}}</td>
                  <td>{{$bulk_data->approved_net_cost}}</td>
                  {{-- <td>{{$bulk_data->impact_time}}</td>
                  <td>{{$bulk_data->granted_eot}}</td>
                  <td>{{$bulk_data->remarks}}</td> --}}
                  @if(Gate::check('edit vochange') || Gate::check('delete vochange'))
                  <td>
                    <div class="ms-2" style="display:flex;gap:10px;">
                      @can('edit vochange')
                      <a href="#"  class="btn btn-md bg-primary backgroundnone"
                      data-url="{{ route('edit_variation_scope_change',["projectid"=>$projectid,"id"=>$data->id]) }}"
                      data-ajax-popup="true" data-size="xl" data-bs-toggle="tooltip"
                      title="{{__('Edit')}}" data-title="{{__('Edit VO or Change Order')}}">
                      <i class="ti ti-pencil text-white"></i>
                      </a>
                      @endcan
                      @can('delete vochange')
                      {!! Form::open(['method' => 'POST', 'route' => ['delete_variation_scope_change', $data->id],
                      'id'=>'delete-form-'.$data->id]) !!}
                      {{ Form::hidden('id',$data->id, ['class' => 'form-control']) }}
                      {{ Form::hidden('projectid',$projectid, ['class' => 'form-control']) }}
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
<script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"
integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
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
              buttons: [
                  {
                      extend: 'excelHtml5',
                      title: 'VO or Change Order or Scope Change Authorization Summary',
                      titleAttr: 'Excel',
                      text: '<i class="fa fa-file-excel-o"></i>',
                      orientation: 'landscape',
                      exportOptions: {
                          modifier: {
                              order: 'index', // 'current', 'applied','index', 'original'
                              page: 'all', // 'all', 'current'
                              search: 'none' // 'none', 'applied', 'removed'
                          },
                          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                      }
                  },
                  {
                      extend: 'pdfHtml5',
                      title: 'VO or Change Order or Scope Change Authorization Summary',
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
                          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9 , 10, 11, 12]
                      }
                  },
                  {
                      extend: 'print',
                      title: 'VO or Change Order or Scope Change Authorization Summary',
                      titleAttr: 'Print',
                      text: '<i class="fa fa-print"></i>',
                      orientation: 'landscape',
                      exportOptions: {
                          modifier: {
                              order: 'index', // 'current', 'applied','index', 'original'
                              page: 'all', // 'all', 'current'
                              search: 'none' // 'none', 'applied', 'removed'
                          },
                          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                      }
                  },
                  'colvis'
              ]
          });
        

       $(document).on("paste", '.impact_time', function (event) {
            if (event.originalEvent.clipboardData.getData('Text').match(/[^\d]/)) {
                event.preventDefault();
            }
        });

        $(document).on("keypress", '.impact_time', function (event) {
            if(event.which < 48 || event.which >58){
                return false;
            }
        });

        $(document).on("paste", '.granted_eot', function (event) {
            if (event.originalEvent.clipboardData.getData('Text').match(/[^\d]/)) {
                event.preventDefault();
            }
        });

        $(document).on("keypress", '.granted_eot', function (event) {
            if(event.which < 48 || event.which >58){
                return false;
            }
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

});

</script>
