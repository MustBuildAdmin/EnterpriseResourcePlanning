@include('new_layouts.header')
@include('hrm.hrm_main')
<div class="page-body">
	<div class="container-xl">
		<div class="card">
			<div class="row g-0">
				<div class="col d-flex flex-column">
					<div class="card-body"> 
						<h2 class="mb-4">{{__('Goal Type')}}</h2>
                        @can('create goal type')
                            <a href="#" data-url="{{ route('goaltype.create') }}" data-ajax-popup="true" data-title="{{__('Create New Goal Type')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="mb-3 btn btn-sm btn-primary">
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
                                                        <th>{{__('Goal Type')}}</th>
                                                        <th width="200px">{{__('Action')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="font-style">
                                                    @foreach ($goaltypes as $goaltype)
                                                        <tr>
                                                            <td>{{ $goaltype->name }}</td>
                                                            <td>
                                                                <div class="ms-2" style="display:flex;gap:10px;">
                                                                    @can('edit goal type')
                                                                        <a href="#" class="btn btn-md bg-primary" data-url="{{ URL::to('goaltype/'.$goaltype->id.'/edit') }}" data-ajax-popup="true" data-title="{{__('Edit Goal Type')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                                            <i class="ti ti-pencil text-white"></i>
                                                                        </a>
                                                                    @endcan

                                                                    @can('delete goal type')
                                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['goaltype.destroy', $goaltype->id],'id'=>'delete-form-'.$goaltype->id]) !!}
                                                                            <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}"><i class="ti ti-trash text-white text-white"></i></a>
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