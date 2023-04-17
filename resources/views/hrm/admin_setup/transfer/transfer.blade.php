@include('new_layouts.header')
@include('hrm.hrm_main')
<div class="page-body">
	<div class="container-xl">
		<div class="card">
			<div class="row g-0">
				<div class="col d-flex flex-column">
					<div class="card-body">
						<h2 class="mb-4">{{ __('Transfer') }}</h2>
                        @can('create transfer')
                            <a href="#" data-size="lg" data-url="{{ route('transfer.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create New Transfer')}}" class="mb-3 btn btn-sm btn-primary">
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
                                                        <th>{{__('Branch')}}</th>
                                                        <th>{{__('Department')}}</th>
                                                        <th>{{__('Transfer Date')}}</th>
                                                        <th>{{__('Description')}}</th>
                                                        @if(Gate::check('edit transfer') || Gate::check('delete transfer'))
                                                            <th width="200px">{{__('Action')}}</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody class="font-style">
                                                    @foreach ($transfers as $transfer)
                                                        <tr>
                                                            @role('company')
                                                            <td>{{ !empty($transfer->employee())?$transfer->employee()->name:'' }}</td>
                                                            @endrole
                                                            <td>{{ !empty($transfer->branch())?$transfer->branch()->name:'' }}</td>
                                                            <td>{{ !empty($transfer->department())?$transfer->department()->name:'' }}</td>
                                                            <td>{{  \Auth::user()->dateFormat($transfer->transfer_date) }}</td>
                                                            <td>{{ $transfer->description }}</td>
                                                            @if(Gate::check('edit transfer') || Gate::check('delete transfer'))
                                                                <td>
                                                                    <div class="ms-2" style="display:flex;gap:10px;">
                                                                        @can('edit transfer')
                                                                            <a href="#" data-url="{{ URL::to('transfer/'.$transfer->id.'/edit') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Transfer')}}" class="btn btn-md bg-primary" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                                                <i class="ti ti-pencil text-white"></i>
                                                                            </a>
                                                                        @endcan
                                                                        @can('delete transfer')
                                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['transfer.destroy', $transfer->id],'id'=>'delete-form-'.$transfer->id]) !!}
                                                                                <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" data-original-title="{{__('Delete')}}" title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$transfer->id}}').submit();">
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