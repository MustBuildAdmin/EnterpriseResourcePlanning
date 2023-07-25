@include('new_layouts.header')
<link rel="stylesheet" href="{{asset('css/summernote/summernote-lite.css')}}">
<style>
    i.ti.ti-plus {
        color: #FFF !important;
    }
    #edit,#view {
    background: unset !important;
    }
    </style>
<div class="page-wrapper">
    @include('crm.side-menu', ['hrm_header' => 'Manage Deals - Sales'])

	<div class="float-end">
        <a href="{{ route('deals.index') }}" data-bs-toggle="tooltip"
           title="{{__('Kanban View')}}" class="btn btn-sm btn-primary">
            <i class="ti ti-layout-grid"></i>
        </a>
        <a href="#" data-size="lg" data-url="{{ route('deals.create') }}"
            data-ajax-popup="true" data-bs-toggle="tooltip"
            title="{{__('Create New Deal')}}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
    </div>
    <br><br><br>

	@if($pipeline)
        <div class="row">
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto mb-3 mb-sm-0">
                                <small class="text-muted">{{__('Total Deals')}}</small>
                                <h3 class="m-0">{{ $cnt_deal['total'] }}</h3>
                            </div>
                            <div class="col-auto">
                                <div class="theme-avtar bg-info">
                                    <i class="ti ti-layers-difference"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto mb-3 mb-sm-0">
                                <small class="text-muted">{{__('This Month Total Deals')}}</small>
                                <h3 class="m-0">{{ $cnt_deal['this_month'] }}</h3>
                            </div>
                            <div class="col-auto">
                                <div class="theme-avtar bg-primary">
                                    <i class="ti ti-layers-difference"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto mb-3 mb-sm-0">
                                <small class="text-muted">{{__('This Week Total Deals')}}</small>
                                <h3 class="m-0">{{ $cnt_deal['this_week'] }}</h3>
                            </div>
                            <div class="col-auto">
                                <div class="theme-avtar bg-warning">
                                    <i class="ti ti-layers-difference"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto mb-3 mb-sm-0">
                                <small class="text-muted">{{__('Last 30 Days Total Deals')}}</small>
                                <h3 class="m-0">{{ $cnt_deal['last_30days'] }}</h3>
                            </div>
                            <div class="col-auto">
                                <div class="theme-avtar bg-danger">
                                    <i class="ti ti-layers-difference"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table datatable" aria-describedby="deal list">
                                <thead>
                                <tr>
                                    <th>{{__('Name')}}</th>
                                    <th>{{__('Price')}}</th>
                                    <th>{{__('Stage')}}</th>
                                    <th>{{__('Tasks')}}</th>
                                    <th>{{__('Users')}}</th>
                                    <th>{{__('Action')}}</th>

                                </tr>
                                </thead>
                                <tbody>
                               
                                    @foreach ($deals as $deal)
                                        <tr>
                                            <td>{{ $deal->name }}</td>
                                            <td>{{\Auth::user()->priceFormat($deal->price)}}</td>
                                            <td>{{ $deal->stage->name }}</td>
                                            <td>{{count($deal->tasks)}}/{{count($deal->complete_tasks)}}</td>
                                            <td>
                                                @foreach($deal->users as $user)
                                                    <a href="#" class="btn btn-sm mr-1 p-0 rounded-circle">
                                                        <img alt="image" data-toggle="tooltip"
                                                        data-original-title="{{$user->name}}"
                                                         @if($user->avatar) src="{{asset('/storage/uploads/avatar/'
                                                         .$user->avatar)}}"
                                                         @else
                                                         src="{{asset('/storage/uploads/avatar/avatar.png')}}"
                                                         @endif
                                                         class="rounded-circle " width="25" height="25">
                                                    </a>
                                                @endforeach
                                            </td>
                                            @if(\Auth::user()->type != 'Client')
                                                <td class="Action">
                                                    <div class="ms-2" style="display:flex;gap:10px;">
                                                        @can('view deal')
                                                            @if($deal->is_active)
                                                                <a id="view" href="{{route('deals.show',$deal->id)}}"
                                                                    class="mx-3 btn btn-sm d-inline-flex
                                                                    align-items-center" data-size="xl"
                                                                    data-bs-toggle="tooltip" title="{{__('View')}}"
                                                                    data-title="{{__('Lead Detail')}}">
                                                                    <i class="ti ti-eye text-white"></i>
                                                                </a>
                                                            @endif
                                                        @endcan
                                                        @can('edit deal')
                                                            <a href="#" id="edit"
                                                                class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                                data-url="{{ URL::to('deals/'.$deal->id.'/edit') }}"
                                                                data-ajax-popup="true" data-size="xl"
                                                                data-bs-toggle="tooltip" title="{{__('Edit')}}"
                                                                data-title="{{__('Lead Edit')}}">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        @endcan
                                                        @can('delete deal')
                                                            {!! Form::open(['method' => 'DELETE',
                                                                'route' => ['deals.destroy', $deal->id],
                                                                'id'=>'delete-form-'.$deal->id]) !!}
                                                                <a href="#" class="mx-3 btn btn-sm
                                                                  align-items-center bs-pass-para"
                                                                 data-bs-toggle="tooltip" title="{{__('Delete')}}">
                                                                   <i class="ti ti-trash text-white"></i>
                                                                </a>
                                                            {!! Form::close() !!}
                                                        @endif
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
    @endif
    
    @include('new_layouts.footer')
	</div>
	

<script src="{{asset('css/summernote/summernote-lite.js')}}"></script>
<script>
    $(document).on("change", ".change-pipeline select[name=default_pipeline_id]", function () {
        $('#change-pipeline').submit();
    });
</script>

