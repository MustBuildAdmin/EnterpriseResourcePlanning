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
     <h2>{{__('RFI-Request For Information Status')}}</h2>
  </div>
   
    @can('create RFI')
    <div class="col-auto ms-auto d-print-none">
        <div class="input-group-btn">
            <a href="#" data-size="xl" data-url="{{ route('rfi_info_status',["projectid"=>$projectid]) }}"
                data-ajax-popup="true" data-title="{{__('Create RFI')}}"
                data-bs-toggle="tooltip" title="{{__('Create')}}" class="btn btn-primary">
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
            @can('manage RFI')
            <div class="container table-responsive-xl">
              <table class="table" id="example2" aria-describedby="rfi">
                <thead class="table">
                <tr>
                    <th>{{__('Sno')}}</th>
                    <th>{{__('Contractor')}}</th>
                    <th>{{__('RFI Reference No')}}</th>
                    <th>{{__('Requested Date')}}</th>
                    <th>{{__('Required Date')}}</th>
                    <th>{{__('Priority')}}</th>
                    <th>{{__('Cost Impact')}}</th>
                    <th>{{__('Time impact')}}</th>
                    <th>{{__('Description')}}</th>
                    @if(Gate::check('edit RFI') || Gate::check('delete RFI'))
                    <th>{{__('Action')}}</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                    @foreach ($dairydata as $key=>$data)
                    <td>{{$loop->iteration}}</td>
                    <td>{{$data->contractor_name ?? '-'}}</td>
                    <td>{{$data->reference_no ?? '-'}}</td>
                    <td>{{ Utility::site_date_format($data->requested_date ?? '-',\Auth::user()->id) }}</td>
                    <td>{{ Utility::site_date_format($data->required_date ?? '-',\Auth::user()->id) }}</td>
                    <td>{{$data->priority ?? '-'}}</td>
                    <td>{{$data->cost_impact ?? '-'}}</td>
                    <td>{{$data->time_impact ?? '-'}}</td>
                    <td>{{$data->description ?? '-'}}</td>
                        @if(Gate::check('edit RFI') || Gate::check('delete RFI'))
                        <td>
                            <div class="ms-2" style="display:flex;gap:10px;">
                                @can('edit RFI')
                                    <a href="#"  class="btn btn-md backgroundnone"
                                     data-url="{{ route('edit_rfi_info_status',["projectid"=>$projectid,
                                     "id"=>$data->id]) }}"
                                     data-ajax-popup="true" data-size="xl"
                                     data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit RFI')}}">
                                    <i class="ti ti-pencil text-white"></i></a>
                                @endcan
                                @can('delete RFI')
                                    {!! Form::open(['method' => 'POST', 'route' => ['delete_rfi_status',
                                    $data->id],'id'=>'delete-form-'.$data->id]) !!}
                                    {{ Form::hidden('id',$data->id, ['class' => 'form-control']) }}
                                    {{ Form::hidden('projectid',$projectid, ['class' => 'form-control']) }}
                                        <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip"
                                         title="{{__('Delete')}}" data-original-title="{{__('Delete')}}"
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
</div>

@include('new_layouts.footer')
<script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"  integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"  integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"  integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"  integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"  integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"  integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"  integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script>
<script type="text/javascript">

    $(document).ready(function () {
        var j = 0;
        $(document).on("click", "#dynamic-rfi", function () {
            ++j;
            $("#dynamicaddrfi").append(
            '<tr>'+
                '<td>'+
                    '<h4 style="text-align: center;">Date Replied By Consultant :</h4>'+
                        '<div class="">'+
                            '<div class="row">'+
                                '<div class="col-md-6">'+
                                    '<div class="form-group">'+
                                        '<label for="InputLIst">Submit Date :</label>'+
                                        '<input type="date" name="submit_date[]" class="form-control" value="">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-md-6">'+
                                    '<div class="form-group">'+
                                        '<label for="input">Return Date :</label>'+
                                        '<input type="date" name="return_date[]" class="form-control" value="">'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-md-6">'+
                                    '<div class="form-group">'+
                                        '<label for="Input">Status of Return :</label>'+
                                        '<select class="form-control" name="status_of_return[]">'+
                                            '<option selected disabled>Status</option>'+
                                            '<option value="Exception">'+
                                                'No Exception Taken (NET) (OR) Approved /with comment'+
                                            '</option>'+
                                            '<option value="Resubmission">'+
                                                'Revise No Resubmission Requried (RNRR)'+
                                            '</option>'+
                                            '<option value="Revise">Revise and Resubmit (RR)</option>'+
                                            '<option value="Submit">Submit Specified Item (SSI)</option>'+
                                            '<option value="Rejected">Rejected</option>'+
                                        '</select>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-md-6">'+
                                    '<div class="form-group">'+
                                        '<label for="InputDate">Remarks :</label>'+
                                        '<textarea class="form-control" name="remarks[]"></textarea>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-md-3 pull-right">'+
                            '<button class="btn btn-secondary" type="button" id="remove-input-field">'+
                                'Remove Submission</button>'+
                            '</div>'+
                        '</div>'+
                '</td>'+
            '</tr>'
            );
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
            responsive:true,
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'RFI-Request For Information Status',
                    titleAttr: 'Excel',
                    text: '<i class="fa fa-file-excel-o"></i>',
    
                    exportOptions: {
                        modifier: {
                            order: 'index', // 'current', 'applied','index', 'original'
                            page: 'all', // 'all', 'current'
                            search: 'none' // 'none', 'applied', 'removed'
                        },
                        columns: [0, 1, 2, 3, 4, 5, 6 ,7, 8]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'RFI-Request For Information Status',
                    titleAttr: 'PDF',
                    pagesize: 'A4',
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
                        columns: [0, 1, 2, 3, 4, 5, 6 ,7, 8]
                    }
                },
                {
                    extend: 'print',
                    title: 'RFI-Request For Information Status',
                    titleAttr: 'Print',
                    orientation: 'landscape',
                    text: '<i class="fa fa-print"></i>',
    
                    exportOptions: {
                        modifier: {
                            order: 'index', // 'current', 'applied','index', 'original'
                            page: 'all', // 'all', 'current'
                            search: 'none' // 'none', 'applied', 'removed'
                        },
                        columns: [0, 1, 2, 3, 4, 5, 6 ,7, 8]
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


