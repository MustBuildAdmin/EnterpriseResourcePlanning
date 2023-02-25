@extends('layouts.admin')
@push('script-page')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    @if(\Auth::user()->type=='company')
        <script>
            $(function () {
                $(".sortable").sortable();
                $(".sortable").disableSelection();
                $(".sortable").sortable({
                    stop: function () {
                        var order = [];
                        $(this).find('li').each(function (index, data) {
                            order[index] = $(data).attr('data-id');
                        });

                        $.ajax({
                            url: "{{route('project-task-stages.order')}}",
                            data: {order: order, _token: $('meta[name="csrf-token"]').attr('content')},
                            type: 'POST',
                            success: function (data) {
                            },
                            error: function (data) {
                                data = data.responseJSON;
                                toastr('Error', data.error, 'error')
                            }
                        })
                    }
                });
            });
        </script>
    @endif
@endpush
@section('page-title')
    {{__('Manage Project Task Stages')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Project Task Stage')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">
    @can('create project task stage')
            <a href="#" data-url="{{ route('project-task-stages.create') }}"  data-bs-toggle="tooltip" title="{{__('Create')}}" class="btn btn-sm btn-primary" data-ajax-popup="true" data-title="{{__('Create Project Task Stage')}}">
                <i class="ti ti-plus"></i>
            </a>

    @endcan
</div>

@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-10 col-xxl-8">

                <div class="card mt-5">
                    <div class="card-body">
                        <div class="tab-content" id="pills-tabContent">
                            @php($i=0)
                            @foreach ($task_stages as $key => $task_stage)

                            <div class="tab-pane fade show  @if($i==0) active @endif" role="tabpanel">
                                <ul class="list-group sortable">
                                    @foreach ($task_stages as $task_stage)
                                        <li class="list-group-item" data-id="{{$task_stage->id}}">
                                            <span class="text-sm text-dark">{{$task_stage->name}}</span>
                                            <span class="float-end">
                                                @can('edit project task stage')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" data-url="{{ URL::to('project-task-stages/'.$task_stage->id.'/edit') }}" data-ajax-popup="true"  data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit Bug Status')}}" class="mx-3 btn btn-sm d-inline-flex align-items-center">
                                                          <i class="ti ti-pencil text-white"></i>
                                                      </a>
                                                    </div>
                                                @endcan
                                                @can('delete project task stage')
                                                        <div class="action-btn bg-danger ms-2">
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['project-task-stages.destroy', $task_stage->id],'id'=>'delete-form-'.$task_stage->id]) !!}
                                                              <a href="#!" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$task_stage->id}}').submit();">
                                                                    <i class="ti ti-trash text-white"></i>
                                                              </a>
                                                            {!! Form::close() !!}
                                                        </div>

                                                @endcan
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            @php($i++)
                            @endforeach
                        </div>
                        <p class="text-muted mt-4"><strong>{{__('Note')}} : </strong>{{__('You can easily change order of project task stage using drag & drop.')}}</p>
                    </div>
                </div>

        </div>
    </div>
@endsection
