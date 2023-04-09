@include('hrm.hrm_main')

    

<div class="page-body">
	<div class="container-xl">
		<div class="card">
			<div class="row g-0">
				<div class="col d-flex flex-column">
					<div class="card-body">
						<h2 class="mb-4">{{ __('Create New Award') }}</h2>
                        @can('create award')
                            <a href="#" data-size="lg" data-url="{{ route('award.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create New Award')}}" class="mb-3 btn btn-sm btn-primary">
                                {{__('Create')}} <i class="ti ti-plus"></i>
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
                                                        <th>{{__('Employee')}}</th>
                                                        @endrole
                                                        <th>{{__('Award Type')}}</th>
                                                        <th>{{__('Date')}}</th>
                                                        <th>{{__('Gift')}}</th>
                                                        <th>{{__('Description')}}</th>
                                                        @if(Gate::check('edit award') || Gate::check('delete award'))
                                                            <th width="200px">{{__('Action')}}</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody class="font-style">
                                                    @foreach ($awards as $award)
                                                        <tr>
                                                            @role('company')
                                                                <td>{{!empty( $award->employee())? $award->employee()->name:'' }}</td>
                                                            @endrole
                                                            <td>{{ !empty($award->awardType())?$award->awardType()->name:'' }}</td>
                                                            <td>{{  \Auth::user()->dateFormat($award->date )}}</td>
                                                            <td>{{ $award->gift }}</td>
                                                            <td>{{ $award->description }}</td>

                                                            @if(Gate::check('edit award') || Gate::check('delete award'))
                                                                <td class="Action">
                                                                    <span>
                                                                        @can('edit award')
                                                                        <div class="action-btn bg-primary ms-2">
                                                                            <a href="#" data-url="{{ URL::to('award/'.$award->id.'/edit') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Award')}}" class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                                                <i class="ti ti-pencil text-white"></i></a>
                                                                        </div>
                                                                            @endcan
                                                                        @can('delete award')
                                                                        <div class="action-btn bg-danger ms-2">
                                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['award.destroy', $award->id],'id'=>'delete-form-'.$award->id]) !!}
                                                                        <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$award->id}}').submit();">
                                                                            <i class="ti ti-trash text-white"></i></a>
                                                                            {!! Form::close() !!}
                                                                            </div>
                                                                        @endcan
                                                                    </span>
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