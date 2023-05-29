<div class="col-xl-12 mt-3">
    <div class="card table-card">
      <div class="col-auto float-end ms-4 mt-4">
        <a href="#" data-size="xl" data-url="{{ route('add_variation_scope_change',["project_id"=>$project_id]) }}" data-ajax-popup="true" data-title="{{__('Create New Project')}}" data-bs-toggle="tooltip" title="{{__('Create')}}" class="btn btn-sm btn-primary">
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
                <th>{{__('VO/SCA Reference')}}</th>
                <th>{{__('VO Description')}}</th>
                <th>{{__('Reference')}}</th>
                <th>{{__('Date')}}</th>
                <th>{{__('Omission Cost')}}</th>
                <th>{{__('Addition Cost')}}</th>
                <th>{{__('Net Amount')}}</th>
                <th>{{__('Omission Cost')}}</th>
                <th>{{__('Addition Cost')}}</th>
                <th>{{__('Net Amount')}}</th>
                <th>{{__('Impact/Lead Time')}}</th>
                <th>{{__('Granted EOT(in days)')}}</th>
                <th>{{__(' Remarks')}}</th>
                <th>{{__('Action')}}</th>
              </tr>
            </thead>
            <tbody> 
              @forelse ($dairy_data as $key=>$data) 
                        @php $check=$data->data; @endphp 
                        @if($check != null) 
                            @php $bulk_data = json_decode($check); @endphp 
                        @else 
                            @php $bulk_data = array(); @endphp 
                        @endif
                      
                        <tr>
                          <td>{{$loop->iteration}}</td>
                          <td>{{$bulk_data->issued_by}}</td>
                          <td>{{$bulk_data->issued_date}}</td>
                          <td>{{$bulk_data->sca_reference}}</td>
                          <td>{{$bulk_data->vo_reference}}</td>
                          <td>{{$bulk_data->reference}}</td>
                          <td>{{$bulk_data->vo_date}}</td>
                          <td>{{$bulk_data->claimed_omission_cost}}</td>
                          <td>{{$bulk_data->claimed_addition_cost}}</td>
                          <td>{{$bulk_data->claimed_net_amount}}</td>
                          <td>{{$bulk_data->approved_omission_cost}}</td>
                          <td>{{$bulk_data->approved_addition_cost}}</td>
                          <td>{{$bulk_data->approved_net_cost}}</td>
                          <td>{{$bulk_data->impact_time}}</td>
                          <td>{{$bulk_data->granted_eot}}</td>
                          <td>{{$bulk_data->remarks}}</td>
                          <td>
                            <div class="action-btn bg-primary ms-2">
                              <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-url="{{ route('edit_variation_scope_change',["project_id"=>$project_id,"id"=>$data->id]) }}" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit Project')}}">
                                <i class="ti ti-pencil text-white"></i>
                              </a>
                            </div>
                            <div class="action-btn bg-danger ms-2"> 
                              {!! Form::open(['method' => 'POST', 'route' => ['delete_variation_scope_change', $data->id],'id'=>'delete-form-'.$data->id]) !!} 
                              @csrf
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
                            <td  colspan="15" class="text-center">No VO or Change Order or Scope Change Authorization Summary Data Found</td>
                        </tr> 
                      @endforelse 
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  