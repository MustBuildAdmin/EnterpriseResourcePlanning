@include('hrm.hrm_main')

    

<div class="page-body">
	<div class="container-xl">
		<div class="card">
			<div class="row g-0">
				<div class="col d-flex flex-column">
					<div class="card-body">
						<h2 class="mb-4">{{ __('Termination') }}</h2>
                        @can('create termination')
                            <a href="#" data-url="{{ route('termination.create') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Create New Termination')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="mb-3 btn btn-sm btn-primary">
                                <i class="ti ti-plus"></i>
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
                                                        <th>{{__('Termination Type')}}</th>
                                                        <th>{{__('Notice Date')}}</th>
                                                        <th>{{__('Termination Date')}}</th>
                                                        <th>{{__('Description')}}</th>
                                                        @if(Gate::check('edit termination') || Gate::check('delete termination'))
                                                            <th>{{__('Action')}}</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody class="font-style">
                                                    @foreach ($terminations as $termination)
                                                        <tr>
                                                            @role('company')
                                                            <td>{{ !empty($termination->employee())?$termination->employee()->name:'' }}</td>
                                                            @endrole

                                                            <td>{{ !empty($termination->terminationType())?$termination->terminationType()->name:'' }}</td>
                                                            <td>{{  \Auth::user()->dateFormat($termination->notice_date) }}</td>
                                                            <td>{{  \Auth::user()->dateFormat($termination->termination_date) }}</td>
                                                            {{--                                    <td>{{ $termination->description }}</td>--}}
                                                            <td>
                                                                <a href="#" class="action-item" data-url="{{ route('termination.description',$termination->id) }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Desciption')}}" data-title="{{__('Desciption')}}"><i class="fa fa-comment"></i></a>
                                                            </td>
                                                            @if(Gate::check('edit termination') || Gate::check('delete termination'))
                                                                <td>
                                                                    <div class="ms-2" style="display:flex;gap:10px;">
                                                                        @can('edit termination')
                                                                            <a href="#" class="btn btn-md bg-primary" data-url="{{ URL::to('termination/'.$termination->id.'/edit') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Termination')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                                                <i class="ti ti-pencil text-white"></i>
                                                                            </a>
                                                                        @endcan
                                                                        @can('delete termination')
                                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['termination.destroy', $termination->id],'id'=>'delete-form-'.$termination->id]) !!}
                                                                                <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$termination->id}}').submit();">
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