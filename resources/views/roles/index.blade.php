@include('new_layouts.header')
<style>
   
   :root {
     --theadColor: #206bc4;
}

 table.dataTable {
     box-shadow: #bbbbbb 0px 0px 5px 0px;
}
 thead {
     background-color: var(--theadColor);
}
 thead > tr, thead > tr > th {
     background-color: transparent !important;
     color: #fff  !important;
     font-weight: normal;
     text-align: start;
}
 table.dataTable thead th, table.dataTable thead td {
     border-bottom: 0px solid #111 !important;
}
 .dataTables_wrapper > div {
     margin: 5px;
}
 table.dataTable.display tbody tr.even > .sorting_1,
 table.dataTable.order-column.stripe tbody tr.even> .sorting_1,
 table.dataTable.display tbody tr.even,
 table.dataTable.display tbody tr.odd > .sorting_1,
 table.dataTable.order-column.stripe tbody tr.odd > .sorting_1,
 table.dataTable.display tbody tr.odd {
     background-color: #ffffff;
}
 table.dataTable thead th {
     position: relative;
     background-image: none !important;
}
 table.dataTable thead th.sorting:after,
 table.dataTable thead th.sorting_asc:after,
table.dataTable thead th.sorting_desc:after {
     position: absolute;
     top: 12px;
     right: 8px;
     display: block;
     font-family: "Font Awesome\ 5 Free";
}
 table.dataTable thead th.sorting:after {
     content: "\f0dc";
     color: #ddd;
     font-size: 0.8em;
     padding-top: 0.12em;
}
 table.dataTable thead th.sorting_asc:after {
     content: "\f0de";
}
 table.dataTable thead th.sorting_desc:after {
     content: "\f0dd";
}
 table.dataTable.display tbody tr:hover > .sorting_1, table.dataTable.order-column.hover tbody tr:hover > .sorting_1 {
     background-color: #f2f2f2 !important;
     color: #000;
}
 tbody tr:hover {
     background-color: #f2f2f2 !important;
     color: #000;
}
 .dataTables_wrapper .dataTables_paginate .paginate_button.current,
 .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
     background: none !important;
     border-radius: 50px;
     background-color: var(--theadColor) !important;
     color:#fff !important
}
 .paginate_button.current:hover {
     background: none !important;
     border-radius: 50px;
     background-color: var(--theadColor) !important;
     color:#fff !important
}
 .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover,
 .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
     border: 1px solid #979797;
     background: none !important;
     border-radius: 50px !important;
     background-color: #000 !important;
     color: #fff !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover,
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active {
    cursor: default;
    color: #fff !important;
    border: 1px solid transparent;
    background: transparent;
    box-shadow: none;
}
    .table-responsive .bg-primary {
        background: #206bc4 !important;
    }
</style>
<link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" />
@if($roles_count==0)
<div class="page-body">
  <div class="container-xl">
    <div class="row g-0">
      <div class="col d-flex flex-column">
        <div class="card-body">
          <h2 class="mb-4">{{__('Manage Role')}}
          </h2>
          <div class="container-xl d-flex flex-column justify-content-center">
            <div class="empty">
              <div class="empty-img">
                <img src="{{ asset('assets/images/undraw_printing_invoices_5r4r.svg') }}" height="128" alt="">
              </div>
              <p class="empty-title">{{__('No results found')}}
              </p>
              <div class="empty-action">
                <a href="#" data-size="lg"
                data-url="{{ route('roles.create') }}" data-ajax-popup="true"
                data-bs-toggle="tooltip" title="{{__('Create New Role')}}" class="btn btn-primary">
                  <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                  <svg xmlns="http://www.w3.org/2000/svg"
                   class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 5l0 14" />
                    <path d="M5 12l14 0" />
                  </svg> {{__('Create New Role')}}
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@else
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="row g-0">
        <div class="col d-flex flex-column">
          <div class="card-body">
            <h2 class="mb-4">{{__('Manage Role')}}
            </h2>
            <div class="col-auto ms-auto d-print-none">
              <div class="float-end">
                <a href="#" data-size="lg" data-url="{{ route('roles.create') }}"
                data-ajax-popup="true" data-bs-toggle="tooltip"
                title="{{__('Create New Role')}}" class="btn btn-primary">
                  <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon"
                  width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                  stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 5l0 14" />
                    <path d="M5 12l14 0" />
                  </svg>
                  {{__('Create New Role')}}
                </a>
                <a href="#" data-bs-toggle="tooltip" title="{{__('Delete All')}}"
                class="btn btn-danger" id="checkdelete">
                  <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                  height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                  fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none">
                    </path>
                    <path d="M3 4m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z">
                    </path>
                    <path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-10">
                    </path>
                    <path d="M10 12l4 0">
                    </path>
                  </svg>
                  {{__('Delete All')}}
                </a>
              </div>
            </div>
            <br>
            <br>
            <br>
            <div class="table-responsive">
              <table class="table table-vcenter card-table no-footer dataTable" id="role_table">
                <thead>
                  <tr>
                    <th class="w-1">
                      <input class="form-check-input m-0 align-middle"
                      type="checkbox" id="checkboxesMain" aria-label="Select all invoices">
                    </th>
                    <th>{{__('Role')}}
                    </th>
                    <th data-orderable="false">{{__('Permissions')}}
                    </th>
                    <th width="150" data-orderable="false">{{__('Action')}}
                    </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($roles as $role)
                  @if($role->name != 'client')
                  <tr class="font-style">
                    <th class="w-1">
                      <input type="checkbox" class="form-check-input m-0 align-middle checkbox" data-id="{{$role->id}}">
                    </th>
                    <td class="Role">{{ $role->name }}
                    </td>
                    <td class="Permission" data-orderable="false">
                      @for($j=0;$j
                      <count($role->permissions()->pluck('name'));$j++)
                        <span class="badge rounded-pill bg-primary m-2">{{$role->permissions()->pluck('name')[$j]}}
                        </span>
                        @endfor
                        </td>
                    <td class="Action" data-orderable="false">
                      <span>
                        @can('edit role')
                        <a href="#" class="btn btn-md bg-primary"
                        style="background:unset !important;"
                        data-url="{{ route('roles.edit',$role->id) }}"
                        data-ajax-popup="true" data-size="lg"
                        data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Role Edit')}}">
                            <i class="ti ti-pencil text-white">
                            </i>
                          </a>

                        @endcan
                    </span>
                    <span>
                        @can('delete role')
                        {!! Form::open(['method' => 'DELETE',
                        'route' => ['roles.destroy', $role->id],'id'=>'delete-form-'.$role->id]) !!}
                        <a href="#" class="btn btn-md btn-danger bs-pass-para"
                        data-bs-toggle="tooltip" title="{{__('Delete')}}">
                          <i class="ti ti-trash text-white">
                          </i>
                        </a>
                        {!! Form::close() !!}

                        @endcan
                      </span>
                    </td>
                  </tr>
                  @endif
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
@endif
<script src="{{ asset('datatable/jquery.dataTables.min.js') }}"></script>
<script type ="text/javascript">

new DataTable('#role_table', {
        pagingType: 'full_numbers',
        aaSorting: [],
        "language": {
            "sLengthMenu": "{{ __('Show _MENU_ Records') }}",
            "sZeroRecords": "{{ __('No data available in table') }}",
            "sEmptyTable": "{{ __('No data available in table') }}",
            "sInfo": "{{ __('Showing records _START_ to _END_ of a total of _TOTAL_ records') }}",
            "sInfoFiltered": "{{ __('filtering of a total of _MAX_ records') }}",
            "sSearch": "{{ __('Search') }}:",
            "oPaginate": {
                "sFirst": "{{ __('First') }}",
                "sLast": "{{ __('Last') }}",
                "sNext": "{{ __('Next') }}",
                "sPrevious": "{{ __('Previous') }}"
            },
        }
    });

//delete swal validation starts
  $(document).on('keypress', function (e) {
          if (e.which == 13) {
              swal.closeModal();
          }
  });
//delete swal validation ends

  $(document).ready(function() {
  	$('#checkboxesMain').on('click', function(e) {
  		if ($(this).is(':checked', true)) {
  			$(".checkbox").prop('checked', true);
  		} else {
  			$(".checkbox").prop('checked', false);
  		}
  	});
  	$('.checkbox').on('click', function() {
  		if ($('.checkbox:checked').length == $('.checkbox').length) {
  			$('#checkboxesMain').prop('checked', true);
  		} else {
  			$('#checkboxesMain').prop('checked', false);
  		}
  	});
  	$('#checkdelete').on('click', function(e) {
  		var studentIdArr = [];
  		$(".checkbox:checked").each(function() {
  			studentIdArr.push($(this).attr('data-id'));
  		});
  		if (studentIdArr.length <= 0) {
  			toastr.error("Choose min one item to remove.");
  		} else {
  			// if (confirm("Are you sure?")) {
  			var form = $(this).closest("form");
  			const swalWithBootstrapButtons = Swal.mixin({
  				customClass: {
  					confirmButton: 'btn btn-success',
  					cancelButton: 'btn btn-danger'
  				},
  				buttonsStyling: false
  			})
  			swalWithBootstrapButtons.fire({
  				title: 'Are you sure?',
  				text: "It will delete if you take this action. Do you want to continue?",
  				icon: 'warning',
  				showCancelButton: true,
  				confirmButtonText: 'Yes',
  				cancelButtonText: 'No',
  				reverseButtons: true
  			}).then((result) => {

  				if (result.isConfirmed) {

  					var stuId = studentIdArr.join(",");

  					$.ajax({
  						url: "{{route('delete_multi_role')}}",
  						method: 'POST',
  						headers: {
  							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  						},
  						data: 'ids=' + stuId,
  						success: function(data) {
  							if (data['status'] == true) {
  								$(".checkbox:checked").each(function() {
  									$(this).parents("tr").remove();
  								});
  								location.reload();
  								toastr.success(data.message);
  							} else {
  								toastr.error("Error Occured");
  							}
  						},
  						error: function(data) {
  							alert(data.responseText);
  						}
  					});

  				} else if (
  					result.dismiss === Swal.DismissReason.cancel
  				) {}
  			})


  		}
  	});
  });
 </script>

@include('new_layouts.footer')
