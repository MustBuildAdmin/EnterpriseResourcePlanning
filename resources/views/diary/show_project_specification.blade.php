<div class="col-xl-12 mt-3">
    <div class="card table-card">
      <div class="col-auto float-end ms-4 mt-4">
        <a href="#" data-size="xl" data-url="{{ route('add_project_specification',["project_id"=>$project_id]) }}" data-ajax-popup="true" data-title="{{__('Create New Project')}}" data-bs-toggle="tooltip" title="{{__('Create')}}" class="btn btn-sm btn-primary">
          <i class="ti ti-plus"></i>
        </a>
      </div>
      <div class="card-header card-body table-border-style">
        <div class="table-responsive">
          <table class="table datatable" id="example1">
            <thead class="">
              <tr>
                <th>{{__('Sno')}}</th>
                <th>{{__('Reference No')}}</th>
                <th>{{__('Description')}}</th>
                <th>{{__('Location')}}</th>
                <th>{{__('Drawing References (if any)')}}</th>
                <th>{{__('Remarks/ Notes')}}</th>
                <th>{{__('Attachments')}}</th>
                <th>{{__('Action')}}</th>
              </tr>
            </thead>
            <tbody> 
              @forelse ($dairy_data as $key=>$data) 
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$data->reference_no}}</td>
                <td>{{$data->description}}</td>
                <td>{{$data->location}}</td>
                <td>{{$data->drawing_reference}}</td>
                <td>{{$data->remarks}}</td>
                <td>{{$data->attachment_file_name}}</td>
                <td>
                      <div class="action-btn bg-primary ms-2">
                        <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-url="{{ route('edit_project_specification',["project_id"=>$project_id,"id"=>$data->id]) }}" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit Project')}}">
                          <i class="ti ti-pencil text-white"></i>
                        </a>
                      </div>
                      <div class="action-btn bg-danger ms-2">
                         {!! Form::open(['method' => 'POST', 'route' => ['delete_project_specification', $data->id],'id'=>'delete-form-'.$data->id]) !!} 
                         {{ Form::hidden('id',$data->id, ['class' => 'form-control']) }}
                         {{ Form::hidden('project_id',$project_id, ['class' => 'form-control']) }}
                        <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}">
                          <i class="ti ti-trash text-white mt-1"></i>
                        </a>
                         {!! Form::close() !!} 
                      </div>
                    </td> 
              </tr>
              @empty 
              <tr>
              <td colspan="8" class="text-center">No Project Specifications Summary Data Found</td>
            </tr> 
              @endforelse 
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  