@include('new_layouts.header')
@include('hrm.hrm_main')
<div class="page-body">
	<div class="container-xl">
		<div class="card">
			<div class="row g-0">
				<div class="col d-flex flex-column">
					<div class="card-body"> 
						<h2 class="mb-4">{{__('Document Type')}}</h2>
                        @can('create document type')
                            <a href="#" data-url="{{ route('document.create') }}" data-ajax-popup="true" data-title="{{__('Create New Document Type')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary mb-3">
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
                                                        <th>{{__('Document')}}</th>
                                                        <th>{{__('Required Field')}}</th>
                                                        @if(Gate::check('edit document type') || Gate::check('delete document type'))
                                                            <th width="200px">{{__('Action')}}</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody class="font-style">
                                                    @foreach ($documents as $document)
                                                        <tr>
                                                            <td>{{ $document->name }}</td>
                                                            <td>
                                                                <h6 class="float-left mr-1">
                                                                    @if( $document->is_required == 1 )
                                                                        <div class="doc_status_badge badge bg-success p-2 px-3 rounded">{{__('Required')}}</div>
                                                                    @else
                                                                        <div class="doc_status_badge badge bg-danger p-2 px-3 rounded">{{__('Not Required')}}</div>
                                                                    @endif
                                                                </h6>
                                                            </td>

                                                            @if(Gate::check('edit document type') || Gate::check('delete document type'))
                                                                <td>
                                                                    <div class="ms-2" style="display:flex;gap:10px;">
                                                                        @can('edit document type')
                                                                            <a href="#" class="btn btn-md bg-primary" data-url="{{ URL::to('document/'.$document->id.'/edit') }}" data-ajax-popup="true" data-title="{{__('Edit Document Type')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                                                <i class="ti ti-pencil text-white"></i>
                                                                            </a>
                                                                        @endcan

                                                                        @can('delete document type')
                                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['document.destroy', $document->id],'id'=>'delete-form-'.$document->id]) !!}
                                                                                <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}"><i class="ti ti-trash text-white text-white"></i></a>
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