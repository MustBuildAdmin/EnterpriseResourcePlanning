@include('new_layouts.header')
@include('hrm.hrm_main')

<div class="row">
  <div class="col-md-6">
     <h2>Company Policy</h2>
  </div>
  <div class="col-md-6 float-end">

    @can('create company policy')0
        <a class="floatrght btn btn-sm btn-primary mb-3" href="#" data-url="{{ route('hrm_company_policy.create') }}" data-ajax-popup="true" data-title="{{__('Create New Company Policy')}}" data-bs-toggle="tooltip" title="{{__('Create')}}">
            {{__('Create')}} &nbsp;<i class="ti ti-plus"></i>
        </a>
    @endcan

  </div>
</div>



    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    <th>{{__('Branch')}}</th>
                    <th>{{__('Title')}}</th>
                    <th>{{__('Description')}}</th>
                    <th>{{__('Attachment')}}</th>
                    @if(Gate::check('edit company policy') || Gate::check('delete company policy'))
                        <th>{{__('Action')}}</th>
                    @endif
                </tr>
            </thead>
            <tbody class="font-style">
                @foreach ($companyPolicy as $policy)
                    @php
                        $policyPath=\App\Models\Utility::get_file('uploads/companyPolicy');
                    @endphp
                    <tr>
                        <td>{{ !empty($policy->branches)?$policy->branches->name:'' }}</td>
                        <td>{{ $policy->title }}</td>
                        <td>{{ $policy->description }}</td>
                        <td>
                            {{-- @if(!empty($policy->attachment))
                                <a href="{{$policyPath.'/'.$policy->attachment}}" target="_blank">
                                    <img src="{{$policyPath.'/'.$policy->attachment}}" alt="No Attachment" width="100px" height="100px">
                                </a>
                            @else
                                <p>-</p>
                            @endif --}}

                            @if (!empty($policy->attachment))
                                <div class="action-btn bg-primary ms-2">

                                    <a  class="mx-3 btn btn-sm align-items-center" href="{{ $policyPath . '/' . $policy->attachment }}" download="">
                                        <i class="ti ti-download text-white"></i>
                                    </a>
                                </div>
                                <div class="action-btn bg-secondary ms-2">
                                    <a class="mx-3 btn btn-sm align-items-center" href="{{ $policyPath . '/' . $policy->attachment }}" target="_blank"  >
                                        <i class="ti ti-crosshair text-white" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Preview') }}"></i>
                                    </a>
                                </div>
                            @else
                                <p>-</p>
                            @endif

                        </td>
                        @if(Gate::check('edit company policy') || Gate::check('delete company policy'))
                            <td>
                                @can('edit company policy')
                                    <div class="action-btn bg-primary ms-2">
                                        <a href="#" data-url="{{ route('hrm_company_policy.edit',$policy->id)}}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Company Policy')}}" class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}"><i class="ti ti-pencil text-white"></i></a>
                                    </div>
                                @endcan
                                @can('delete company policy')
                                    <div class="action-btn bg-danger ms-2">
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['hrm_company_policy.destroy', $policy->id],'id'=>'delete-form-'.$policy->id]) !!}

                                        <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$policy->id}}').submit();"><i class="ti ti-trash text-white"></i></a>
                                        {!! Form::close() !!}
                                    </div>
                                @endcan
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
	</div>
	</div>
@include('new_layouts.footer')
