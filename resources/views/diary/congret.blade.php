<div class="col-xl-12 mt-3">
    <div class="card table-card">
      <div class="col-auto float-end ms-4 mt-4">
        <a href="#" data-size="xl" data-url="{{ route('dairy.dairy_create',["project_id"=>$project_id]) }}" data-ajax-popup="true" data-title="{{__('Create New Project')}}" data-bs-toggle="tooltip" title="{{__('Create')}}" class="btn btn-sm btn-primary">
          <i class="ti ti-plus"></i>
        </a>
      </div>
      <div class="card-header card-body table-border-style">
        <div class="table-responsive">
          <table class="table datatable" id="example1">
            <thead class="">
              <tr>
                <th>{{__('Sno')}}</th>
                <th>{{__('Date of Casting')}}</th>
                <th>{{__('Casting Element')}}</th>
                <th>{{__('Concrete Grade')}}</th>
                <th>{{__('Theoretical')}}</th>
                <th>{{__('Actual')}}</th>
                <th>{{__('7 days Test Fall on')}}</th>
                <th>{{__('28 days Test Fall on')}}</th>
                <th>{{__('28 days Result')}}</th>
                <th>{{__('Remarks')}}</th>
                <th>{{__('Action')}}</th>
              </tr>
            </thead>
            <tbody> 
            @forelse ($dairy_data as $key=>$data) 
                    @php $check=$data->diary_data; @endphp 
                    @if($check != null) 
                        @php $bulk_data = json_decode($check); @endphp 
                    @else 
                        @php $bulk_data = array(); @endphp 
                    @endif 
                <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$bulk_data->date_of_casting}}</td>
                <td>{{$bulk_data->element_of_casting}}</td>
                <td>{{$bulk_data->grade_of_concrete}}</td>
                <td>{{$bulk_data->theoretical}}</td>
                <td>{{$bulk_data->actual}}</td>
                <td>{{$bulk_data->testing_fall ?? '-'}}</td>
                <td>{{$bulk_data->days_testing_falls ?? '-'}}</td>
                <td>{{$bulk_data->days_testing_result ?? '-'}}</td>
                <td>{{$bulk_data->remarks}}</td>
                <td>
                  <div class="action-btn bg-primary ms-2">
                    <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-url="{{ route('dairy.dairy_update',["project_id"=>$project_id,"id"=>$data->id]) }}" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit Project')}}">
                      <i class="ti ti-pencil text-white"></i>
                    </a>
                  </div>
                  <div class="action-btn bg-danger ms-2"> {!! Form::open(['method' => 'POST', 'route' => ['diary_destroy', $data->id],'id'=>'delete-form-'.$data->id]) !!} 
                    <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}">
                      <i class="ti ti-trash text-white mt-1"></i>
                    </a> {!! Form::close() !!} 
                  </div>
                </td> 
                </tr>
            @empty 
             <tr>
                <td colspan="11" class="text-center">No Concrete Pouring Record Data Found</td>
              </tr> 
            @endforelse 
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>