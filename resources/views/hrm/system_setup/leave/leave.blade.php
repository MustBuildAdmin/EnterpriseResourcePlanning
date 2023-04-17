@include('hrm.hrm_main')

<div class="page-body">
	<div class="container-xl">
		<div class="card">
			<div class="row g-0">
				<div class="col d-flex flex-column">
					<div class="card-body"> 
						<h2 class="mb-4">{{__('Leave Type')}}</h2>
                        @can('create leave type')
                            <a href="#" data-url="{{ route('leavetype.create') }}" data-ajax-popup="true" data-title="{{__('Create New Leave Type')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary mb-3">
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
                                                        <th>{{__('Leave Type')}}</th>
                                                        <th>{{__('Days / Year')}}</th>
                                                        <th width="200px">{{__('Action')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="font-style">
                                                    @foreach ($leavetypes as $leavetype)
                                                        <tr>
                                                            <td>{{ $leavetype->title }}</td>
                                                            <td>{{ $leavetype->days}}</td>

                                                            <td>
                                                                <div class="ms-2" style="display:flex;gap:10px;">
                                                                    @can('edit leave type')
                                                                        <a href="#" class="btn btn-md bg-primary" data-url="{{ URL::to('leavetype/'.$leavetype->id.'/edit') }}" data-ajax-popup="true" data-title="{{__('Edit Leave Type')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                                            <i class="ti ti-pencil text-white"></i>
                                                                        </a>
                                                                    @endcan

                                                                    @can('delete leave type')
                                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['leavetype.destroy', $leavetype->id],'id'=>'delete-form-'.$leavetype->id]) !!}
                                                                            <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$leavetype->id}}').submit();">
                                                                                <i class="ti ti-trash text-white"></i>
                                                                            </a>
                                                                        {!! Form::close() !!}
                                                                    @endcan
                                                                </div>
                                                            </td>
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