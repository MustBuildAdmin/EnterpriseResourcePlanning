@extends('layouts.admin')
@section('page-title')
    {{__('Manage Project Stages')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Project Stage')}}</li>
@endsection
@push('script-page')
    <script src="{{ asset('assets/js/jscolor.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-ui/jquery-ui.js') }}"></script>
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
                        url: "{{route('projectstages.order')}}",
                        data: {order: order, _token: $('meta[name="csrf-token"]').attr('content')},
                        type: 'POST',
                        success: function (data) {
                        },
                        error: function (data) {
                            data = data.responseJSON;
                            show_toastr('{{__("Error")}}', data.error, 'error')
                        }
                    })
                }
            });
        });
    </script>
@endpush

@section('action-btn')
    @can('create project stage')
        <div class="float-end">
            <a href="#" data-url="{{ route('projectstages.create') }}" data-ajax-popup="true" data-title="{{__('Create Project Stage')}}" class="btn btn-xs btn-white btn-icon-only width-auto"><i class="ti ti-plus"></i> {{__('Create')}} </a>
        </div>
    @endcan
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info note-constant text-xs">
                <strong>{{__('Note')}} :</strong> {{__('System will consider last stage as a completed / done task for get progress on project.')}}
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <ul class="list-group sortable">
                        @foreach ($projectstages as $projectstage)
                            <li class="list-group-item" data-id="{{$projectstage->id}}">
                                <div class="row">
                                    <div class="col-6 text-xs text-dark">{{$projectstage->name}}</div>
                                    <div class="col-4 text-xs text-dark">{{$projectstage->created_at}}</div>
                                    <div class="col-2">
                                        @can('edit project stage')
                                            <a href="#" data-url="{{ URL::to('projectstages/'.$projectstage->id.'/edit') }}" data-ajax-popup="true" data-title="{{__('Edit Project Stages')}}" class="edit-icon">
                                                <i class="ti ti-pencil text-white"></i>
                                            </a>
                                        @endcan
                                        @can('delete project stage')
                                            <a href="#" class="delete-icon" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$projectstage->id}}').submit();"><i class="ti ti-trash"></i></a>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['projectstages.destroy', $projectstage->id],'id'=>'delete-form-'.$projectstage->id]) !!}
                                            {!! Form::close() !!}
                                        @endcan
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
