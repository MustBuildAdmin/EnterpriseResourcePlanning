@include('new_layouts.header')
@include('hrm.hrm_main')
<div class="page-body">
	<div class="container-xl">
		<div class="card">
			<div class="row g-0">
				<div class="col d-flex flex-column">
					<div class="card-body"> 
						<h2 class="mb-4">{{__('Designation')}}</h2>
                        @can('create designation')
                            <a href="#" data-url="{{ route('designation.create') }}" data-ajax-popup="true" data-title="{{__('Create New Designation')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary mb-3">
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
                                                        <th>{{__('Department')}}</th>
                                                        <th>{{__('Designation')}}</th>
                                                        <th width="200px">{{__('Action')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="font-style">
                                                    @foreach ($designations as $designation)
                                                        @php
                                                            $department = \App\Models\Department::where('id', $designation->department_id)->first();
                                                        @endphp
                                                        <tr>
                                                            <td>{{ !empty($department->name)?$department->name:'' }}</td>
                                                            <td>{{ $designation->name }}</td>

                                                            <td class="Action">
                                                                <div class="ms-2" style="display:flex;gap:10px;">
                                                                    @can('edit designation')
                                                                        <a href="#" class="btn btn-md bg-primary" data-url="{{route('designation.edit',$designation->id) }}" data-ajax-popup="true" data-title="{{__('Edit Designation')}}" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                                                            <i class="ti ti-pencil text-white"></i>
                                                                        </a>
                                                                    @endcan

                                                                    @can('delete designation')
                                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['designation.destroy', $designation->id],'id'=>'delete-form-'.$designation->id]) !!}
                                                                            <a href="#" class="btn btn-md btn-danger bs-pass-para" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$designation->id}}').submit();">
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