@include('new_layouts.header')
@include('construction_project.side-menu')
<link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
/* pagination */
.pagination {
	height: 36px;
	margin: 18px 0;
	color: #6c58bF;
}

.pagination ul {
	display: inline-block;
	*display: inline;
         /* IE7 inline-block hack */
	*zoom: 1;
	margin-left: 0;
	color: #ffffff;
	margin-bottom: 0;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
	-webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
	-moz-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
	box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.pagination li {
	display: inline;
	color: #6c58bF;
}

.pagination a {
	float: left;
	padding: 0 14px;
	line-height: 34px;
	color: #6c58bF;
	text-decoration: none;
	border: 1px solid #ddd;
	border-left-width: 0;
}

.pagination a:hover,
     .pagination .active a {
	background-color: var(--tblr-pagination-active-bg);
	color: #ffffff;
}

.pagination a:focus {
	background-color: #ffffff;
	color: #ffffff;
}

.pagination .active a {
	color: #ffffff;
	cursor: default;
}

.pagination .disabled span,
     .pagination .disabled a,
     .pagination .disabled a:hover {
	color: #999999;
	background-color: transparent;
	cursor: default;
}

.pagination li:first-child a {
	border-left-width: 1px;
	-webkit-border-radius: 3px 0 0 3px;
	-moz-border-radius: 3px 0 0 3px;
	border-radius: 3px 0 0 3px;
}

.pagination li:last-child a {
	-webkit-border-radius: 0 3px 3px 0;
	-moz-border-radius: 0 3px 3px 0;
	border-radius: 0 3px 3px 0;
}

.pagination-centered {
	text-align: center;
}

.pagination-right {
	text-align: right;
}

.pager {
	margin-left: 0;
	margin-bottom: 18px;
	list-style: none;
	text-align: center;
	color: #6c58bF;
	*zoom: 1;
}

.pager:before,
     .pager:after {
	display: table;
	content: "";
}

.pager:after {
	clear: both;
}

.pager li {
	display: inline;
	color: #6c58bF;
}

.pager a {
	display: inline-block;
	padding: 5px 14px;
	color: #6c58bF;
	background-color: #fff;
	border: 1px solid #ddd;
	-webkit-border-radius: 15px;
	-moz-border-radius: 15px;
	border-radius: 15px;
}

.pager a:hover {
	text-decoration: none;
	background-color: #f5f5f5;
}

.pager .next a {
	float: right;
}

.pager .previous a {
	float: left;
}

.pager .disabled a,
     .pager .disabled a:hover {
	color: #999999;
}

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

.action-btn {
	display: inline-grid !important;
}

h3, .h3 {
	font-size: 1rem !important;
}
</style>
<div class="row">
  <div class="col-md-6">
     <h2>{{__('Procurement Material Supply Log')}}</h2> 
  </div>
    <div class="col-md-6 float-end floatrght">
        @can('create procurement material')
            <a class="floatrght btn btn-primary mb-3" href="#" data-size="xl" data-url="{{ route('add_procurement_material',["project_id"=>$project_id]) }}" data-ajax-popup="true" data-title="{{__('Create Procurement Material Supply Log')}}" data-bs-toggle="tooltip" title="{{__('Create')}}" class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        @endcan
    </div>
    <div class="col-xl-12 mt-3">
        <div class="card table-card">
    
        <div class="card-header card-body table-border-style">
            @can('manage procurement material')
            <div class="table">
              <table class="table" id="example2">
                <thead class="">
                <tr>
                    <th>{{__('Sno')}}</th>
                    <th>{{__('RAM Ref with No')}}</th>
                    <th>{{__('Name of Supplier')}}</th>
                    <th>{{__('Contact Person')}}</th>
                    <th>{{__('Mobile/HP')}}</th>
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
                        <td>{{$data->ram_ref_no}}</td>
                        <td>{{$data->supplier_name}}</td>
                        <td>{{$data->contact_person}}</td>
                        <td>{{$data->mobile_hp_no}}</td>
                        <td>{{$data->target_delivery_date}}</td>
                        <td>{{$data->target_approval_date}}</td>
                        <td>{{$data->status}}</td>
                        @if(Gate::check('edit procurement material') || Gate::check('delete procurement material'))
                        <td>
                            <div class="ms-2" style="display:flex;gap:10px;">
                                @can('edit procurement material')
                                    <a href="#"  class="btn btn-md bg-primary backgroundnone" data-url="{{ route('edit_procurement_material',["project_id"=>$project_id,"id"=>$data->id]) }}" data-ajax-popup="true" data-size="xl" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit Procurement Material Supply Log')}}"><i class="ti ti-pencil text-white"></i></a>
                                @endcan
                                @can('delete procurement material')
                                    {!! Form::open(['method' => 'POST', 'route' => ['delete_procurement_material', $data->id],'id'=>'delete-form-'.$data->id]) !!} 
                                    {{ Form::hidden('id',$data->id, ['class' => 'form-control']) }}
                                    {{ Form::hidden('project_id',$project_id, ['class' => 'form-control']) }}
                                        <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}"><i class="ti ti-trash text-white"></i></a>
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
<script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script type="text/javascript">

    $(document).ready(function () {
        var j = 0;
        $(document).on("click", "#dynamic-procurement", function () {
            ++j;
            $("#dynamicprocurement").append('<tr><td><h4 style="text-align: center;">Date Replied By Consultant :</h4><div class=""><div class="row"><div class="col-md-6"><div class="form-group"><label for="InputLIst">Submission Date :</label><input type="date" name="submission_date[]" class="form-control" value=""></div></div><div class="col-md-6"><div class="form-group"><label for="input">Actual Reply Date :</label><input type="date" name="actual_reply_date[]" class="form-control" value=""></div></div></div><div class="col-md-3 pull-right"><button class="btn btn-secondary" type="button" id="removedynamicprocurement"> Remove Submission </button></div></div></td></tr>');
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
                    text: '<i class="fa fa-file-pdf-o"></i>',
    
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


