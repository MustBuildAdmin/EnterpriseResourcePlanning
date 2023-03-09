@extends('layouts.admin')
@section('page-title')
    {{ucwords($project->project_name)}}
@endsection
@push('script-page')
    <script>
        (function () {
            var options = {
                chart: {
                    type: 'area',
                    height: 60,
                    sparkline: {
                        enabled: true,
                    },
                },
                colors: ["#ffa21d"],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2,
                },
                series: [{
                    name: 'Bandwidth',
                    data:{{ json_encode(array_map('intval',$project_data['timesheet_chart']['chart'])) }}
                }],

                tooltip: {
                    followCursor: false,
                    fixed: {
                        enabled: false
                    },
                    x: {
                        show: false
                    },
                    y: {
                        title: {
                            formatter: function (seriesName) {
                                return ''
                            }
                        }
                    },
                    marker: {
                        show: false
                    }
                }
            }
            var chart = new ApexCharts(document.querySelector("#timesheet_chart"), options);
            chart.render();
        })();

        (function () {
            var options = {
                chart: {
                    type: 'area',
                    height: 60,
                    sparkline: {
                        enabled: true,
                    },
                },
                colors: ["#ffa21d"],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2,
                },
                series: [{
                    name: 'Bandwidth',
                    data:{{ json_encode($project_data['task_chart']['chart']) }}
                }],

                tooltip: {
                    followCursor: false,
                    fixed: {
                        enabled: false
                    },
                    x: {
                        show: false
                    },
                    y: {
                        title: {
                            formatter: function (seriesName) {
                                return ''
                            }
                        }
                    },
                    marker: {
                        show: false
                    }
                }
            }
            var chart = new ApexCharts(document.querySelector("#task_chart"), options);
            chart.render();
        })();

        $(document).ready(function () {
            loadProjectUser();
            $(document).on('click', '.invite_usr', function () {
                var project_id = $('#project_id').val();
                var user_id = $(this).attr('data-id');

                $.ajax({
                    url: '{{ route('invite.project.user.member') }}',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        'project_id': project_id,
                        'user_id': user_id,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        if (data.code == '200') {
                            show_toastr(data.status, data.success, 'success')
                            location.reload();
                            loadProjectUser();
                        } else if (data.code == '404') {
                            show_toastr(data.status, data.errors, 'error')
                        }
                    }
                });
            });
        });

        function loadProjectUser() {
            var mainEle = $('#project_users');
            var project_id = '{{$project->id}}';

            $.ajax({
                url: '{{ route('project.user') }}',
                data: {project_id: project_id},
                beforeSend: function () {
                    $('#project_users').html('<tr><th colspan="2" class="h6 text-center pt-5">{{__('Loading...')}}</th></tr>');
                },
                success: function (data) {
                    mainEle.html(data.html);
                    $('[id^=fire-modal]').remove();
                    loadConfirm();
                }
            });
        }

    </script>
@endpush
@php $setting  = Utility::settings(\Auth::user()->creatorId()); @endphp


@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('projects.index')}}">{{__('Project')}}</a></li>
    <li class="breadcrumb-item">{{ucwords($project->project_name)}}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        @can('view grant chart')
            <a href="{{ route('projects.gantt',$project->id) }}" class="btn btn-sm btn-primary">
                {{__('Gantt Chart')}}
            </a>
        @endcan
       
        @can('view expense')
            <a href="{{ route('projects.expenses.index',$project->id) }}" class="btn btn-sm btn-primary">
                {{__('Expense')}}
            </a>
        @endcan
       
        @if($setting['company_type']!=2)
            @can('manage bug report')
                <a href="{{ route('task.bug',$project->id) }}" class="btn btn-sm btn-primary">
                    {{__('Bug Report')}}
                </a>
            @endcan
            @if(\Auth::user()->type!='client' || (\Auth::user()->type=='client' ))
            <a href="{{ route('projecttime.tracker',$project->id) }}" class="btn btn-sm btn-primary">
                {{__('Tracker')}}
            </a>
            @endif
            @can('create project task')
            <a href="{{ route('projects.tasks.index',$project->id) }}" class="btn btn-sm btn-primary">
                {{__('Task')}}
            </a>
            @endcan
            @if(\Auth::user()->type != 'client')
            @can('view timesheet')
                <a href="{{ route('timesheet.index',$project->id) }}" class="btn btn-sm btn-primary">
                    {{__('Timesheet')}}
                </a>
            @endcan
            @endif
        @endif
        
        @can('edit project')
            <a href="#" data-size="lg" data-url="{{ route('projects.edit', $project->id) }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Edit Project')}}" class="btn btn-sm btn-primary">
                <i class="ti ti-pencil"></i>
            </a>
        @endcan

    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-warning">
                                    <i class="ti ti-list"></i>
                                </div>
                                <div class="ms-3">
                                    <small class="text-muted h6">{{__('Total Task')}}</small>
                                    <h6 class="m-0">{{$project_data['task']['total'] }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto text-end">
                            <h4 class="m-0">{{ $project_data['task']['done'] }}</h4>
                            <small class="text-muted h6">{{__('Done Task')}}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-danger">
                                    <i class="ti ti-report-money"></i>
                                </div>
                                <div class="ms-3">
                                    <small class="text-muted">{{__('Total')}}</small>
                                    <h6 class="m-0">{{__('Budget')}}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto text-end">
                            <h4 class="m-0">{{ \Auth::user()->priceFormat($project->budget)}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(Auth::user()->type !='client')
            <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-success">
                                    <i class="ti ti-report-money"></i>
                                </div>
                                <div class="ms-3">
                                    <small class="text-muted">{{__('Total')}}</small>
                                    <h6 class="m-0">{{__('Expense')}}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto text-end">
                            <h4 class="m-0">{{ \Auth::user()->priceFormat($project_data['expense']['total']) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
            <div class="col-lg-4 col-md-6"></div>
        @endif
        <div class="col-lg-4 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <img {{ $project->img_image }} alt="" class="img-user wid-45 rounded-circle">
                        </div>
                        <div class="d-block  align-items-center justify-content-between w-100">
                            <div class="mb-3 mb-sm-0">
                                <h5 class="mb-1"> {{$project->project_name}}</h5>
                                <p class="mb-0 text-sm">
                                <div class="progress-wrapper">
                                    <span class="progress-percentage"><small class="font-weight-bold">{{__('Completed:')}} : </small>{{ $project->project_progress()['percentage'] }}</span>
                                    <div class="progress progress-xs mt-2">
                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="{{ $project->project_progress()['percentage'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $project->project_progress()['percentage'] }};"></div>
                                    </div>
                                </div>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-10">
                            <h4 class="mt-3 mb-1"></h4>
                            <p> {{ $project->description }}</p>
                        </div>
                    </div>
                    <div class="card bg-primary mb-0">
                        <div class="card-body">
                            <div class="d-block d-sm-flex align-items-center justify-content-between">
                                <div class="row align-items-center">
                                    <span class="text-white text-sm">{{__('Start Date')}}</span>
                                    <h5 class="text-white text-nowrap">{{ Utility::getDateFormated($project->start_date) }}</h5>
                                </div>
                                <div class="row align-items-center">
                                    <span class="text-white text-sm">{{__('End Date')}}</span>
                                    <h5 class="text-white text-nowrap">{{ Utility::getDateFormated($project->end_date) }}</h5>
                                </div>

                            </div>
                            <div class="row">
                                <span class="text-white text-sm">{{__('Client')}}</span>
                                <h5 class="text-white text-nowrap">{{ (!empty($project->client)?$project->client->name:'-') }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="theme-avtar bg-primary">
                            <i class="ti ti-clipboard-list"></i>
                        </div>
                        <div class="ms-3">
                            <p class="text-muted mb-0">{{__('Last 7 days task done')}}</p>
                            <h4 class="mb-0">{{ $project_data['task_chart']['total'] }}</h4>

                        </div>
                    </div>
                    <div id="task_chart"></div>
                </div>

                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">
                            <span class="text-muted">{{__('Day Left')}}</span>
                        </div>
                        <span>{{ $project_data['day_left']['day'] }}</span>
                    </div>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-primary" style="width: {{ $project_data['day_left']['percentage'] }}%"></div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">

                            <span class="text-muted">{{__('Open Task')}}</span>
                        </div>
                        <span>{{ $project_data['open_task']['tasks'] }}</span>
                    </div>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-primary" style="width: {{ $project_data['open_task']['percentage'] }}%"></div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">
                            <span class="text-muted">{{__('Completed Milestone')}}</span>
                        </div>
                        <span>{{ $project_data['milestone']['total'] }}</span>
                    </div>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-primary" style="width: {{ $project_data['milestone']['percentage'] }}%"></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-4 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="theme-avtar bg-primary">
                            <i class="ti ti-clipboard-list"></i>
                        </div>
                        <div class="ms-3">
                            <p class="text-muted mb-0">{{__('Last 7 days hours spent')}}</p>
                            <h4 class="mb-0">{{ $project_data['timesheet_chart']['total'] }}</h4>

                        </div>
                    </div>
                    <div id="timesheet_chart"></div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">
                            <span class="text-muted">{{__('Total project time spent')}}</span>
                        </div>
                        <span>{{ $project_data['time_spent']['total'] }}</span>
                    </div>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-primary" style="width: {{ $project_data['time_spent']['percentage'] }}%"></div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">

                            <span class="text-muted">{{__('Allocated hours on task')}}</span>
                        </div>
                        <span>{{ $project_data['task_allocated_hrs']['hrs'] }}</span>
                    </div>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-primary" style="width: {{ $project_data['task_allocated_hrs']['percentage'] }}%"></div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">
                            <span class="text-muted">{{__('User Assigned')}}</span>
                        </div>
                        <span>{{ $project_data['user_assigned']['total'] }}</span>
                    </div>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-primary" style="width: {{ $project_data['user_assigned']['percentage'] }}%"></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5>{{__('Members')}}</h5>
                        @can('edit project')
                            <div class="float-end">
                                <a href="#" data-size="lg" data-url="{{ route('invite.project.member.view', $project->id) }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary" data-bs-original-title="{{__('Add Member')}}">
                                    <i class="ti ti-plus"></i>
                                </a>
                            </div>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush list" id="project_users">
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="card-header">
                    @can('create milestone')
                        <div class="d-flex align-items-center justify-content-between">
                            <h5>{{__('Milestones')}} ({{count($project->milestones)}})</h5>

                            <div class="float-end">
                                <a href="#" data-size="md" data-url="{{ route('project.milestone', $project->id) }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary" data-bs-original-title="{{__('Create New Milestone')}}">
                                    <i class="ti ti-plus"></i>
                                </a>
                            </div>
                        </div>
                    @endcan

                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @if($project->milestones->count() > 0)
                            @foreach($project->milestones as $milestone)
                                <li class="list-group-item px-0">
                                    <div class="row align-items-center justify-content-between">
                                        <div class="col-sm-auto mb-3 mb-sm-0">
                                            <div class="d-flex align-items-center">
                                                <div class="div">
                                                    <h6 class="m-0">{{ $milestone->title }}
                                                        <span class="badge-xs badge bg-{{\App\Models\Project::$status_color[$milestone->status]}} p-2 px-3 rounded">{{ __(\App\Models\Project::$project_status[$milestone->status]) }}</span>
                                                    </h6>
                                                    <small class="text-muted">{{ $milestone->tasks->count().' '. __('Tasks') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-auto text-sm-end d-flex align-items-center">
                                            <div class="action-btn bg-warning ms-2">
                                                <a href="#" data-size="md" data-url="{{ route('project.milestone.show',$milestone->id) }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('View')}}" class="btn btn-sm">
                                                    <i class="ti ti-eye text-white"></i>
                                                </a>
                                            </div>
                                            <div class="action-btn bg-info ms-2">
                                                <a href="#" data-size="md" data-url="{{ route('project.milestone.edit',$milestone->id) }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Edit')}}" class="btn btn-sm">
                                                    <i class="ti ti-pencil text-white"></i>
                                                </a>
                                            </div>
                                            <div class="action-btn bg-danger ms-2">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['project.milestone.destroy', $milestone->id]]) !!}
                                                <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}"><i class="ti ti-trash text-white"></i></a>

                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <div class="py-5">
                                <h6 class="h6 text-center">{{__('No Milestone Found.')}}</h6>
                            </div>
                        @endif
                    </ul>

                </div>
            </div>
        </div>
        @can('view activity')
            <div class="col-xl-6">
                <div class="card activity-scroll">
                    <div class="card-header">
                        <h5>{{__('Activity Log')}}</h5>
                        <small>{{__('Activity Log of this project')}}</small>
                    </div>
                    <div class="card-body vertical-scroll-cards">
                        @foreach($project->activities as $activity)
                            <div class="card p-2 mb-2">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="theme-avtar bg-primary">
                                            <i class="ti ti-{{$activity->logIcon($activity->log_type)}}"></i>
                                        </div>
                                        <div class="ms-3">
                                            <h6 class="mb-0">{{ __($activity->log_type) }}</h6>
                                            <p class="text-muted text-sm mb-0">{!! $activity->getRemark() !!}</p>
                                        </div>
                                    </div>
                                    <p class="text-muted text-sm mb-0">{{$activity->created_at->diffForHumans()}}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endcan
        <div class="col-lg-6 col-md-6">
            <div class="card activity-scroll">
                <div class="card-header">
                    <h5>{{__('Attachments')}}</h5>
                    <small>{{__('Attachment that uploaded in this project')}}</small>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @if($project->projectAttachments()->count() > 0)
                            @foreach($project->projectAttachments() as $attachment)
                                <li class="list-group-item px-0">
                                    <div class="row align-items-center justify-content-between">
                                        <div class="col mb-3 mb-sm-0">
                                            <div class="d-flex align-items-center">
                                                <div class="div">
                                                    <h6 class="m-0">{{ $attachment->name }}</h6>
                                                    <small class="text-muted">{{ $attachment->file_size }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto text-sm-end d-flex align-items-center">
                                            <div class="action-btn bg-info ms-2">
                                                <a href="{{asset(Storage::url('tasks/'.$attachment->file))}}" download data-bs-toggle="tooltip" title="{{__('Download')}}" class="btn btn-sm">
                                                    <i class="ti ti-download text-white"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <div class="py-5">
                                <h6 class="h6 text-center">{{__('No Attachments Found.')}}</h6>
                            </div>
                        @endif
                    </ul>

                </div>
            </div>
        </div>
    </div>
@endsection
