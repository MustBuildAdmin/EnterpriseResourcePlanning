<div class="col-xl-12 mt-3">
    <div class="card table-card">
      <div class="col-auto float-end ms-4 mt-4">
        <a href="#" data-size="xl" data-url="{{ route('consultant_direction',["project_id"=>$project_id]) }}" data-ajax-popup="true" data-title="{{__('Create New Project')}}" data-bs-toggle="tooltip" title="{{__('Create')}}" class="btn btn-sm btn-primary">
          <i class="ti ti-plus"></i>
        </a>
      </div>
      <div class="card-header card-body table-border-style">
        <div class="table-responsive">
          <table class="table datatable" id="example1">
            <thead class="">
              <tr>
                <th>{{__('Sno')}}</th>
                <th>{{__('Issued By')}}</th>
                <th>{{__('Issued Date')}}</th>
                <th>{{__('AD/ED Reference')}}</th>
                <th>{{__('AD/ED Description')}}</th>
                <th>{{__('Reference')}}</th>
                <th>{{__('Initiator Reference')}}</th>
                <th>{{__('Initiator Date')}}</th>
                <th>{{__('Action')}}</th>
              </tr>
            </thead>
            <tbody> 
              @forelse ($dairy_data as $key=>$data) 
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$data->issued_by}}</td>
                <td>{{$data->issued_date}}</td>
                <td>{{$data->ad_ae_ref}}</td>
                <td>{{$data->ad_ae_decs}}</td>
                <td>{{$data->attach_file_name}}</td>
                <td>{{$data->initiator_reference}}</td>
                <td>{{$data->initiator_date}}</td>
                <td>
                      <div class="action-btn bg-primary ms-2">
                        <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-url="{{ route('edit_consultant_direction',["project_id"=>$project_id,"id"=>$data->id]) }}" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit Project')}}">
                          <i class="ti ti-pencil text-white"></i>
                        </a>
                      </div>
                      <div class="action-btn bg-danger ms-2"> {!! Form::open(['method' => 'POST', 'route' => ['delete_concrete', $data->id],'id'=>'delete-form-'.$data->id]) !!} 
                        <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}">
                          <i class="ti ti-trash text-white mt-1"></i>
                        </a> {!! Form::close() !!} 
                      </div>
                    </td> 
              @empty 
              <td colspan="9" class="text-center">No Consultants Directions Summary Data Found</td>
            </tr> 
              @endforelse 
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  