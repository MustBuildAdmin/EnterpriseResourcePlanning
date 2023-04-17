@include('new_layouts.header')
@include('hrm.hrm_main')
<div class="page-body">
	<div class="container-xl">
		<div class="card">
			<div class="row g-0">
				<div class="col d-flex flex-column">
					<div class="card-body"> 
						<h2 class="mb-4">{{__('Job Category')}}</h2>
                        @can('create job category')
                            <a href="#" data-url="{{ route('job-category.create') }}" data-ajax-popup="true" data-title="{{__('Create New Job Category')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="mb-3 btn btn-sm btn-primary">
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
                                                        <th>{{__('Category')}}</th>
                                                        <th width="200px">{{__('Action')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="font-style">
                                                    @foreach ($categories as $category)
                                                        <tr>
                                                            <td>{{ $category->title }}</td>
                                                            <td>
                                                                <div class="ms-2" style="display:flex;gap:10px;">
                                                                    @can('edit job category')
                                                                        <a href="#" class="btn btn-md bg-primary" data-url="{{ route('job-category.edit',$category->id) }}" data-ajax-popup="true" data-title="{{__('Edit Job Category')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                                            <i class="ti ti-pencil text-white"></i>
                                                                        </a>
                                                                    @endcan
                                                                    @can('delete job category')
                                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['job-category.destroy', $category->id],'id'=>'delete-form-'.$category->id]) !!}
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