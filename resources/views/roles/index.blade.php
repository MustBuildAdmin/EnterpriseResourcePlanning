@include('new_layouts.header')
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
</style>
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
              <table class="table datatable" >
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
<script type = "text/javascript" >
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
