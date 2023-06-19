@extends('layouts.admin')
@section('page-title')
    {{__('Manage Bug Report')}}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('projects.index')}}">{{__('Project')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('projects.show',$project->id)}}">    {{ucwords($project->project_name)}}</a></li>
    <li class="breadcrumb-item">{{__('Bug Report')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        @can('manage bug report')
            <a href="{{ route('task.bug.kanban',$project->id) }}" data-bs-toggle="tooltip" title="{{__('Kanban')}}" class="btn btn-sm btn-primary">
                <i class="ti ti-grid-dots"></i>
            </a>
        @endcan
        @can('create bug report')
            <a href="#" data-size="lg" data-url="{{ route('task.bug.create',$project->id) }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create New Bug')}}" class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        @endcan
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th> {{__('Bug Id')}}</th>
                                <th> {{__('Assign To')}}</th>
                                <th> {{__('Bug Title')}}</th>
                                <th> {{__('Start Date')}}</th>
                                <th> {{__('Due Date')}}</th>
                                <th> {{__('Status')}}</th>
                                <th> {{__('Priority')}}</th>
                                <th> {{__('Created By')}}</th>
                                <th width="10%"> {{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($bugs as $bug)
                                <tr>
                                    <td>{{ \Auth::user()->bugNumberFormat($bug->bug_id)}}</td>
                                    <td>{{ (!empty($bug->assignTo)?$bug->assignTo->name:'') }}</td>
                                    <td>{{ $bug->title}}</td>
                                    <td>{{ Auth::user()->dateFormat($bug->start_date) }}</td>
                                    <td>{{ Auth::user()->dateFormat($bug->due_date) }}</td>
                                    <td>{{ (!empty($bug->bug_status)?$bug->bug_status->title:'') }}</td>
                                    <td>{{ $bug->priority }}</td>
                                    <td>{{ $bug->createdBy->name }}</td>
                                    <td class="Action" width="10%">
                                        @can('edit bug report')
                                            <div class="action-btn bg-info ms-2">
                                                <a href="#" data-size="lg" class="mx-3 btn btn-sm  align-items-center" data-url="{{ route('task.bug.edit',[$project->id,$bug->id]) }}" data-ajax-popup="true" data-size="xl" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Bug Report')}}">
                                                    <i class="ti ti-pencil text-white"></i>
                                                </a>
                                            </div>
                                        @endcan
                                        @can('delete bug report')
                                            <div class="action-btn bg-danger ms-2">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['task.bug.destroy', $project->id,$bug->id]]) !!}
                                                <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}"><i class="ti ti-trash text-white"></i></a>
                                                {!! Form::close() !!}
                                            </div>
                                        @endcan
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
@endsection
