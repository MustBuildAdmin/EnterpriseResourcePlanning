@extends('layouts.admin')
@section('page-title')
    {{__('Manage Bug Report')}}
@endsection


@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Project')}}</li>
    <li class="breadcrumb-item">{{__('Bug Report')}}</li>
@endsection

@section('action-btn')
    <div class="float-end">

        @if($view == 'grid')
            <a href="{{ route('bugs.view', 'list') }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" title="{{__('List View')}}">
                <span class="btn-inner--text"><i class="ti ti-list"></i></span>
            </a>
        @else
            <a href="{{ route('bugs.view', 'grid') }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" title="{{__('Card View')}}">
                <span class="btn-inner--text"><i class="ti ti-table"></i></span>
            </a>
        @endif

        @can('manage project')

            <a href="{{ route('projects.index') }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" title="{{__('Back')}}">
                <span class="btn-inner--icon"><i class="ti ti-arrow-left"></i></span>
            </a>
        @endcan

    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">

                    <div class="table-responsive">
                        <table class="table align-items-center">
                            <thead>
                            <tr>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Bug Status')}}</th>
                                <th scope="col">{{__('Priority')}}</th>
                                <th scope="col">{{__('End Date')}}</th>
                                <th scope="col">{{__('created By')}}</th>
                                <th scope="col">{{__('Assigned To')}}</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            @if(count($bugs) > 0)
                                @foreach($bugs as $bug)
                                    <tr>
                                        <td>
                                            <span class="h6 text-sm font-weight-bold mb-0"><a href="{{ route('task.bug',$bug->project_id) }}">{{ $bug->title }}</a></span>
                                            <span class="d-flex text-sm text-muted justify-content-between">
                                    <p class="m-0">{{!empty($bug->project)?$bug->project->project_name:''}}</p>
                                    <span class="me-5 badge p-2 px-3 rounded bg-{{ (\Auth::user()->checkProject($bug->project_id) == 'Owner') ? 'success' : 'warning'  }}">{{ __(\Auth::user()->checkProject($bug->project_id)) }}</span>
                                </span>
                                        </td>
                                        <td>{{ $bug->bug_status->title }}</td>
                                        <td>
                                            <span class="status_badge badge p-2 px-3 rounded bg-{{__(\App\Models\ProjectTask::$priority_color[$bug->priority])}}">{{ __(\App\Models\ProjectTask::$priority[$bug->priority]) }}</span>
                                        </td>
                                        <td class="{{ (strtotime($bug->due_date) < time()) ? 'text-danger' : '' }}">{{ Utility::getDateFormated($bug->due_date) }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                {{ $bug->createdBy->name }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="avatar-group">
                                                @if($bug->users()->count() > 0)
                                                    @php $user = $bug->users(); @endphp

                                                    <a href="#" class="avatar rounded-circle avatar-sm">
                                                        <img data-original-title="{{(!empty($user[0])?$user[0]->name:'')}}" @if($user[0]->avatar) src="{{asset('/storage/uploads/avatar/'.$user[0]->avatar)}}" @else src="{{asset('/storage/uploads/avatar/avatar.png')}}" @endif title="{{ $user[0]->name }}" class="hweb">
                                                    </a>
                                                    @if($users = $bug->users())
                                                        @foreach($users as $key => $user)
                                                            @if($key<3)

                                                            @else
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    @if(count($users) > 3)
                                                        <a href="#" class="avatar rounded-circle avatar-sm">
                                                            <img  src="{{$user->getImgImageAttribute()}}">
                                                        </a>
                                                    @endif
                                                @else
                                                    {{ __('-') }}
                                                @endif
                                            </div>
                                        </td>

                                        <td class="text-end w-15">
                                            <div class="actions">
                                                <a class="action-item px-1" data-bs-toggle="tooltip" title="{{__('Attachment')}}" data-original-title="{{__('Attachment')}}">
                                                    <i class="ti ti-paperclip mr-2"></i>{{ count($bug->bugFiles) }}
                                                </a>
                                                <a class="action-item px-1" data-bs-toggle="tooltip" title="{{__('Comment')}}" data-original-title="{{__('Comment')}}">
                                                    <i class="ti ti-brand-hipchat mr-2"></i>{{ count($bug->comments) }}
                                                </a>
                                                <a class="action-item px-1" data-toggle="tooltip" data-original-title="{{__('Checklist')}}">
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <th scope="col" colspan="7"><h6 class="text-center">{{__('No tasks found')}}</h6></th>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
