@include('new_layouts.header')
@include('hrm.hrm_main')
<div class="page-body">
	<div class="container-xl">
		<div class="card">
			<div class="row g-0">
				<div class="col d-flex flex-column">
					<div class="card-body">
						<h2 class="mb-4">{{ __('Trip') }}</h2>
                        @can('create travel')
                            <a href="#" data-url="{{ route('travel.create') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Create New Trip')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="mb-3 btn btn-sm btn-primary">
                                {{__('Create')}} &nbsp;<i class="ti ti-plus"></i>
                            </a>
                        @endcan
						<div class="row align-items-center">
							<div id="personal_info" class="card">
								<div class="card-body"> 
                                    <div class="row">
                                        <div class="table-responsive">
                                            <table class="table card-table table-vcenter text-nowrap datatable">
                                                <thead>
                                                    <tr>
                                                        @role('company')
                                                        <th>{{__('Employee Name')}}</th>
                                                        @endrole
                                                        <th>{{__('Start Date')}}</th>
                                                        <th>{{__('End Date')}}</th>
                                                        <th>{{__('Purpose of Trip')}}</th>
                                                        <th>{{__('Country')}}</th>
                                                        <th>{{__('Description')}}</th>
                                                        @if(Gate::check('edit travel') || Gate::check('delete travel'))
                                                            <th width="200px">{{__('Action')}}</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody class="font-style">
                                                    @foreach ($travels as $travel)
                                                        <tr>
                                                            @role('company')
                                                            <td>{{ !empty($travel->employee())?$travel->employee()->name:'' }}</td>
                                                            @endrole
                                                            <td>{{ \Auth::user()->dateFormat( $travel->start_date) }}</td>
                                                            <td>{{ \Auth::user()->dateFormat( $travel->end_date) }}</td>
                                                            <td>{{ $travel->purpose_of_visit }}</td>
                                                            <td>{{ $travel->place_of_visit }}</td>
                                                            <td>{{ $travel->description }}</td>
                                                            @if(Gate::check('edit travel') || Gate::check('delete travel'))
                                                                <td>
                                                                    <div class="ms-2" style="display:flex;gap:10px;">
                                                                        @can('edit travel')
                                                                            <a href="#" class="btn btn-md bg-primary" data-url="{{ URL::to('travel/'.$travel->id.'/edit') }}" data-ajax-popup="true" data-title="{{__('Edit Trip')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                                                <i class="ti ti-pencil text-white"></i>
                                                                            </a>
                                                                        @endcan
                                                                        @can('delete travel')
                                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['travel.destroy', $travel->id],'id'=>'delete-form-'.$travel->id]) !!}
                                                                                <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$travel->id}}').submit();">
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
                                    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> 
@include('new_layouts.footer')