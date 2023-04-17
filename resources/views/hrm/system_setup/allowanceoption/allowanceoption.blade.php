@include('new_layouts.header')
@include('hrm.hrm_main')
<div class="page-body">
	<div class="container-xl">
		<div class="card">
			<div class="row g-0">
				<div class="col d-flex flex-column">
					<div class="card-body"> 
						<h2 class="mb-4">{{__('Allowance Option')}}</h2>
                        @can('create allowance option')
                            <a href="#" data-url="{{ route('allowanceoption.create') }}" data-ajax-popup="true" data-title="{{__('Create New Allowance Option')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="mb-3 btn btn-sm btn-primary">
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
                                                        <th>{{__('Allowance Option')}}</th>
                                                        <th width="200px">{{__('Action')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="font-style">
                                                    @foreach ($allowanceoptions as $allowanceoption)
                                                        <tr>
                                                            <td>{{ $allowanceoption->name }}</td>
                                                            <td>
                                                                <div class="ms-2" style="display:flex;gap:10px;">
                                                                    @can('edit allowance option')
                                                                        <a href="#" class="btn btn-md bg-primary" data-url="{{ URL::to('allowanceoption/'.$allowanceoption->id.'/edit') }}" data-ajax-popup="true" data-title="{{__('Edit Document Type')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                                            <i class="ti ti-pencil text-white"></i>
                                                                        </a>
                                                                    @endcan

                                                                    @can('delete allowance option')
                                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['allowanceoption.destroy', $allowanceoption->id],'id'=>'delete-form-'.$allowanceoption->id]) !!}
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