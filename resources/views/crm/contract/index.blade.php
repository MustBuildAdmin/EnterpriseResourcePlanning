@include('new_layouts.header')
<link rel="stylesheet" href="{{asset('css/summernote/summernote-lite.css')}}">
<style>
.nav-fill .nav-item .nav-link, .nav-justified .nav-item .nav-link {
    width: 13%;
    float: right;
}
</style>
@include('crm.side-menu')


<div class="row">
  <div class="col-md-6">
     <h2>Manage Contract</h2>
  </div>
  <div class="col-md-6 float-end ">
       
        <a href="{{ route('contract.grid') }}"  data-bs-toggle="tooltip" title="{{__('Grid View')}}" class="floatrght btn btn-sm btn-primary">
            <i class="ti ti-layout-grid"></i>
        </a>
        @if(\Auth::user()->type == 'company')
            <a href="#" data-size="md" data-url="{{ route('contract.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create New Contract')}}" class="floatrght btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        @endif

  </div>
</div>


	<div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th scope="col">{{__('#')}}</th>
                                <th scope="col">{{__('Subject')}}</th>
                                @if(\Auth::user()->type!='client')
                                    <th scope="col">{{__('Client')}}</th>
                                @endif
                                <th scope="col">{{__('Project')}}</th>

                                <th scope="col">{{__('Contract Type')}}</th>
                                <th scope="col">{{__('Contract Value')}}</th>
                                <th scope="col">{{__('Start Date')}}</th>
                                <th scope="col">{{__('End Date')}}</th>
                                <th scope="col" >{{__('Action')}}</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($contracts as $contract)

                                <tr class="font-style">
                                    <td>
                                        <a href="{{route('contract.show',$contract->id)}}" class="btn btn-outline-primary">{{\Auth::user()->contractNumberFormat($contract->id)}}</a>
                                    </td>
                                    <td>{{ $contract->subject}}</td>
                                    @if(\Auth::user()->type!='client')
                                        <td>{{ !empty($contract->clients)?$contract->clients->name:'-' }}</td>
                                    @endif
                                    <td>{{ !empty($contract->projects)?$contract->projects->project_name:'-' }}</td>

                                    <td>{{ !empty($contract->types)?$contract->types->name:'' }}</td>
                                    <td>{{ \Auth::user()->priceFormat($contract->value) }}</td>
                                    <td>{{  \Auth::user()->dateFormat($contract->start_date )}}</td>
                                    <td>{{  \Auth::user()->dateFormat($contract->end_date )}}</td>
                                    {{--                                    <td>--}}
                                    {{--                                        <a href="#" class="action-item" data-url="{{ route('contract.description',$contract->id) }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Desciption')}}" data-title="{{__('Desciption')}}"><i class="fa fa-comment"></i></a>--}}
                                    {{--                                    </td>--}}

                                    <td class="action ">
										<div class="ms-2" style="display:flex;gap:10px;">
											@if(\Auth::user()->type=='company')
												@if($contract->status=='accept')
													<a href="{{route('contract.copy',$contract->id)}}"
													class="mx-3 btn btn-sm d-inline-flex align-items-center"
													data-bs-whatever="{{__('Duplicate')}}" data-bs-toggle="tooltip"
													data-bs-original-title="{{__('Duplicate')}}"> <span class="text-white">
															<i class="ti ti-copy"></i></span>
													</a>
												@endif
											@endif
											@can('show contract')
												<a href="{{ route('contract.show',$contract->id) }}"
													class="mx-3 btn btn-sm d-inline-flex align-items-center"
													data-bs-whatever="{{__('View Budget Planner')}}" data-bs-toggle="tooltip"
													data-bs-original-title="{{__('View')}}"> <span class="text-white"> <i class="ti ti-eye"></i></span></a>
											@endcan
											@can('edit contract')
												<a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-url="{{ route('contract.edit',$contract->id) }}" data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit Contract')}}">
													<i class="ti ti-pencil text-white"></i>
												</a>
											@endcan
											@can('delete contract')
												{!! Form::open(['method' => 'DELETE', 'route' => ['contract.destroy', $contract->id]]) !!}
												<a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}"><i class="ti ti-trash text-white"></i></a>
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

        @include('new_layouts.footer')
    </div>

	

