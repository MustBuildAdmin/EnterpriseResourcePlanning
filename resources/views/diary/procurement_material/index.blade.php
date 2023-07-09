@include('new_layouts.header')
@include('construction_project.side-menu')
<link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
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

.action-btn {
	display: inline-grid !important;
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
     <h2>{{__('Procurement Material Supply Log')}}</h2>
  </div>
 
        @can('create procurement material')
        <div class="col-auto ms-auto d-print-none">
            <div class="input-group-btn">
                <a href="#" data-size="xl"
                data-url="{{ route('add_procurement_material',["project_id"=>$project_id]) }}" data-ajax-popup="true"
                data-title="{{__('Create Procurement Material Supply Log')}}" data-bs-toggle="tooltip"
                title="{{__('Create')}}" class="btn btn-primary">
                <span class="btn-inner--icon"><i class="fa fa-plus"></i></span>
                </a>
                <a href="{{ route('projects.show', $project_id) }}"  class="btn btn-danger"
                 data-bs-toggle="tooltip" title="{{ __('Back') }}">
                  <span class="btn-inner--icon"><i class="fa fa-arrow-left"></i></span>
                </a>
            </div>
        </div>
        @endcan
  
    <div class="col-xl-12 mt-3">
        <div class="card table-card">
    
        <div class="container-fluid">
            @can('manage procurement material')
            <div class="">
            <div class="container table-responsive-xl">
              <table class="table" id="example2" aria-describedby="procurement material">
                <thead class="">
                <tr>
                    <th>{{__('Sno')}}</th>
                    <th>{{__('Description')}}</th>
                    <th>{{__('RAM Ref with No')}}</th>
                    <th>{{__('Location')}}</th>
                    <th>{{__('Name of Supplier')}}</th>
                    <th>{{__('Contact Person')}}</th>
                    <th>{{__('Mobile/HP')}}</th>
                    <th>{{__('Telephone')}}</th>
                    <th>{{__('Fax')}}</th>
                    <th>{{__('Email')}}</th>
                    <th>{{__('Lead Time')}}</th>
                    <th>{{__('Target Delivery Date')}}</th>
                    <th>{{__('Target Date of Approval')}}</th>
                    <th>{{__('Status')}}</th>
                    @if(Gate::check('edit procurement material') || Gate::check('delete procurement material'))
                    <th>{{__('Action')}}</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                    @foreach ($dairy_data as $key=>$data)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$data->description}}</td>
                        <td>{{$data->ram_ref_no}}</td>
                        <td>{{$data->location}}</td>
                        <td>{{$data->supplier_name}}</td>
                        <td>{{$data->contact_person}}</td>
                        <td>{{$data->mobile_hp_no}}</td>
                        <td>{{$data->tel}}</td>
                        <td>{{$data->fax}}</td>
                        <td>{{$data->email}}</td>
                        <td>{{$data->lead_time}}</td>
                        <td>{{ Utility::site_date_format($data->target_delivery_date,\Auth::user()->id) }}</td>
                        <td>{{ Utility::site_date_format($data->target_approval_date,\Auth::user()->id) }}</td>
                        <td>{{$data->status}}</td>
                        @if(Gate::check('edit procurement material') || Gate::check('delete procurement material'))
                        <td>
                            <div class="ms-2" style="display:flex;gap:10px;">
                                @can('edit procurement material')
                                    <a href="#"  class="btn btn-md bg-primary backgroundnone"
                                     data-url="{{ route('edit_procurement_material',["project_id"=>$project_id,"id"=>$data->id]) }}"
                                      data-ajax-popup="true" data-size="xl" data-bs-toggle="tooltip"
                                      title="{{__('Edit')}}"
                                      data-title="{{__('Edit Procurement Material Supply Log')}}">
                                      <i class="ti ti-pencil text-white"></i>
                                    </a>
                                @endcan
                                @can('delete procurement material')
                                    {!! Form::open(['method' => 'POST', 'route' => ['delete_procurement_material', $data->id],'id'=>'delete-form-'.$data->id]) !!} 
                                    {{ Form::hidden('id',$data->id, ['class' => 'form-control']) }}
                                    {{ Form::hidden('project_id',$project_id, ['class' => 'form-control']) }}
                                        <a href="#" class="btn btn-md btn-danger bs-pass-para"
                                        data-bs-toggle="tooltip" title="{{__('Delete')}}"
                                        data-original-title="{{__('Delete')}}"
                                        data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}">
                                        <i class="ti ti-trash text-white"></i></a>
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
        </div>
            @endcan
        </div>
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
<script type="text/javascript">

    $(document).ready(function () {
        var j = 1;
        $(document).on("click", "#dynamic-procurement", function () {
            ++j;
            $("#dynamicprocurement").append('<tr>'+
                '<td>'+
                    '<h4 style="text-align: center;">Date Replied By Consultant :</h4>'+
                    '<div class="row">'+
                        '<div class="col-md-4">'+
                            '<div class="form-group">'+
                                '<label for="InputLIst">Submission Date :</label>'+
                                '<input type="date" name="submission_date[]" class="form-control" value="">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-4">'+
                            '<div class="form-group">'+
                                '<label for="input">Actual Reply Date :</label>'+
                                '<input type="date" name="actual_reply_date[]" class="form-control" value="">'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-md-4">'+
                                '<div class="form-group">'+
                                    '<label for="input">No of Submissions</label>'+
                                    '<input type="text" name="" placeholder="No of Submissions" class="form-control number" value="'+j+'" disabled>'+
                                    '<input type="hidden" name="no_of_submission[]" placeholder="No of Submissions" class="form-control number" value="'+j+'">'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-3 pull-right">'+
                            '<button class="btn btn-secondary" type="button" id="removedynamicprocurement"> Remove Submission </button>'+
                        '</div>'+
                    '</div>'+
                '</td>'+
            '</tr>');
        });
        $(document).on('click', '#removedynamicprocurement', function () {
            $(this).parents('tr').remove();
        });
    
    });

    $(document).ready(function() {
        $('#example2').DataTable({
            dom: 'Bfrtip',
            searching: true,
            info: true,
            paging: true,
            responsive:true,
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
                        columns: [0, 1, 2, 3, 4, 5 ,6 , 7, 8, 9, 10, 11, 12, 13]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Procurement Material Supply Log',
                    titleAttr: 'PDF',
                    orientation : 'landscape',
                    pagesize: 'A4',
                    text: '<i class="fa fa-file-pdf-o"></i>',
                    customize: function(doc) {
                        doc.styles.tableBodyEven.alignment = 'center';
                        doc.styles.tableBodyEven.noWrap = false;
                        doc.styles.tableBodyOdd.alignment = 'center';
                        doc.styles.tableBodyOdd.noWrap = false;
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
                        columns: [0, 1, 2, 3, 4, 5 ,6 , 7, 8, 9, 10, 11, 12, 13]
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
                        columns: [0, 1, 2, 3, 4, 5 ,6 , 7, 8, 9, 10, 11, 12, 13]
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


