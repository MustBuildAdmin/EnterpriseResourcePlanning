@include('new_layouts.header')
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="row g-0">
        <div class="col d-flex flex-column">
          <div class="card-body">
            <h2 class="mb-4">{{__('Manage Role')}}</h2>
            <div class="col-auto ms-auto d-print-none">
              <div class="float-end">
                <a href="#" data-size="lg" data-url="{{ route('roles.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create New Role')}}" class="btn btn-primary">
                  <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 5l0 14" />
                    <path d="M5 12l14 0" />
                  </svg>
                  {{__('Create New Role')}}
                </a>
                <a href="#" data-bs-toggle="tooltip" title="{{__('Delete All')}}" class="btn btn-danger" id="checkdelete">
                  <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none">
                      </path>
                      <path d="M3 4m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"></path>
                      <path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-10"></path>
                      <path d="M10 12l4 0"></path>
                    </svg>
                  {{__('Delete All')}}
                </a>
              </div>
            </div>
            <br>
            <br>
            <div class="table-responsive">
              <table class="table datatable">
                <thead>
                  <tr>
                    <th class="w-1">
                      <input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices">
                    </th>
                    <th>{{__('Role')}} </th>
                    <th data-orderable="false">{{__('Permissions')}} </th>
                    <th width="150" data-orderable="false">{{__('Action')}} </th>
                  </tr>
                </thead>
                <tbody>
                @foreach ($roles as $role) @if($role->name != 'client')
                <tr class="font-style">
                    <th class="w-1">
                      <input name="selectcheck" class="form-check-input m-0 align-middle" type="checkbox" data-id="{{$role->id}}" aria-label="Select all invoices">
                    </th>
                    <td class="Role">{{ $role->name }}</td>
                    <td class="Permission" data-orderable="false">
                      @for($j=0;$j <count($role->permissions()->pluck('name'));$j++)
                      <span class="badge rounded-pill bg-primary m-2">{{$role->permissions()->pluck('name')[$j]}}</span>
                      @endfor
                    </td>
                    <td class="Action" data-orderable="false">
                      <span>
                      @can('edit role') <div class="ms-2">
                          <a href="#" class="btn btn-md bg-primary" data-url="{{ route('roles.edit',$role->id) }}" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Role Edit')}}">
                            <i class="ti ti-pencil text-white"></i>
                          </a>
                        </div>
                        @endcan
                        @can('delete role')
                        <div class="ms-2">
                        {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id],'id'=>'delete-form-'.$role->id]) !!} <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}">
                            <i class="ti ti-trash text-white"></i>
                          </a>
                          {!! Form::close() !!}
                          </div>
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
<script>
  var clicked = false;
  $(document).on("click", '#checkdelete', function () {

    var id=[];
    $(".align-middle").prop("checked", !clicked);
    clicked = !clicked;
    this.innerHTML = clicked ? '{{__('Deselect')}}' : '{{__('Delete All')}}';
    $('input[name^="selectcheck"]:checked').each(function(){
      id.push($(this).data('id'));
    });

    if (id.length === 0) {
          return false;
    }
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

          $.ajax({
            url: "{{route('delete_multi_role')}}",
            method: "POST",
            data: {"_token": "{{ csrf_token() }}",id:id},
            success: function (response) {
              location.reload();

            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(textStatus, errorThrown);
            }
          });

        } else if (
            result.dismiss === Swal.DismissReason.cancel
        ) {
        }
    })

});
</script>
@include('new_layouts.footer')
