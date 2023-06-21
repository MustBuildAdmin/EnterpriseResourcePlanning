@extends('layouts.admin')
@section('page-title')
    {{__('Dashboard')}}
@endsection
@push('script-page')
    <script>
        (function () {
            var options = {
                chart: {
                    height: 180,
                    type: 'area',
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: 'Refferal',
                    data:{!! json_encode(array_values($home_data['task_overview'])) !!}
                },],
                xaxis: {
                    categories:{!! json_encode(array_keys($home_data['task_overview'])) !!},
                },
                colors: ['#3ec9d6'],
                fill: {
                    type: 'solid',
                },
                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                },
                // markers: {
                //     size: 4,
                //     colors: ['#3ec9d6', '#FF3A6E',],
                //     opacity: 0.9,
                //     strokeWidth: 2,
                //     hover: {
                //         size: 7,
                //     }
                // }
            };
            var chart = new ApexCharts(document.querySelector("#task_overview"), options);
            chart.render();
        })();

        (function () {
            var options = {
                chart: {
                    height: 300,
                    type: 'bar',
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        borderRadius: 10,
                        dataLabels: {
                            position: 'top',
                        },
                    }
                },
                colors: ["#3ec9d6"],
                dataLabels: {
                    enabled: true,
                    offsetX: -6,
                    style: {
                        fontSize: '12px',
                        colors: ['#fff']
                    }
                },
                stroke: {
                    show: true,
                    width: 1,
                    colors: ['#fff']
                },
                grid: {
                    strokeDashArray: 4,
                },
                series: [{
                    data: {!! json_encode(array_values($home_data['timesheet_logged'])) !!}
                }],
                xaxis: {
                    categories: {!! json_encode(array_keys($home_data['timesheet_logged'])) !!},
                },
            };
            var chart = new ApexCharts(document.querySelector("#timesheet_logged"), options);
            chart.render();
        })();

    </script>
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Project')}}</li>
@endsection
@section('content')
    <div class="row">

        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-primary">
                                    <i class="ti ti-cast"></i>
                                </div>
                                <div class="ms-3">
                                    <small class="text-muted">{{__('Total')}}</small>
                                    <h6 class="m-0">{{__('Projects')}}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto text-end">
                            <h4 class="m-0">{{ $home_data['total_project']['total'] }}</h4>
                            <small class="text-muted"><span class="text-success">{{ $home_data['total_project']['percentage'] }}%</span> {{__('completd')}}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-info">
                                    <i class="ti ti-activity"></i>
                                </div>
                                <div class="ms-3">
                                    <small class="text-muted">{{__('Total')}}</small>
                                    <h6 class="m-0">{{__('Tasks')}}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto text-end">
                            <h4 class="m-0">{{ $home_data['total_task']['total'] }}</h4>
                            <small class="text-muted"><span class="text-success">{{ $home_data['total_task']['percentage'] }}%</span> {{__('completd')}}</small>
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
                                    <h6 class="m-0">{{__('Expense')}}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto text-end">
                            <h4 class="m-0">{{ $home_data['total_expense']['total'] }}</h4>
                            <small class="text-muted"><span class="text-success">{{ $home_data['total_expense']['percentage'] }}%</span> {{__('expense')}}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">

                    <h5>{{__('Project Status')}}</h5>
                </div>
                <div class="card-body">
                    <div class="row ">
                        @foreach($home_data['project_status'] as $status => $val)
                            <div class="col-md-6 col-sm-6 mb-5">
                                <div class="align-items-start">

                                    <div class="ms-2">
                                        <p class="text-muted text-sm mb-0">{{__(\App\Models\Project::$project_status[$status])}}</p>
                                        <h3 class="mb-0 text-{{ \App\Models\Project::$status_color[$status] }}">{{ $val['total'] }}%</h3>
                                        <div class="progress mb-0">
                                            <div class="progress-bar bg-{{ \App\Models\Project::$status_color[$status] }}" style="width: {{$val['percentage']}}%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5>{{__('Tasks Overview')}} <span class="float-end"> <small class="text-muted">{{__('Total Completed task in last 7 days')}}</small></span></h5>

                </div>
                <div class="card-body">
                    <div id="task_overview"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5>{{__('Top Due Projects')}}</h5>
                </div>
                <div class="card-body project_table">
                    <div class="table-responsive ">
                        <table class="table table-hover mb-0">
                            <thead>
                            <tr>
                                <th>{{__('Name')}}</th>
                                <th>{{__('End Date')}}</th>
                                <th >{{__('Status')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($home_data['due_project']->count() > 0)
                                @foreach($home_data['due_project'] as $due_project)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{asset(Storage::url('/'.$due_project->project_image ))}}"
                                                     class="wid-40 rounded-circle me-3" >
                                                <div>
                                                    <h6 class="mb-0">{{ $due_project->project_name }}</h6>
                                                    <p class="mb-0"><span class="text-success">{{ \Auth::user()->priceFormat($due_project->budget) }}</p>

                                                </div>
                                            </div>
                                        </td>
                                        <td >{{  Utility::getDateFormated($due_project->end_date) }}</td>
                                        <td class="text-end">
                                            <span class=" status_badge p-2 px-3 rounded badge bg-{{\App\Models\Project::$status_color[$due_project->status]}}">{{ __(\App\Models\Project::$project_status[$due_project->status]) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="py-5">
                                    <td class="text-center mb-0" colspan="3">{{__('No Due Projects Found.')}}</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>{{__('Timesheet Logged Hours')}} <span>  <small class="float-end text-muted flo">{{__('Last 7 days')}}</small></span></h5>
                </div>
                <div class="card-body project_table">
                    <div id="timesheet_logged"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__('Top Due Tasks')}}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                            @foreach($home_data['due_tasks'] as $due_task)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="">
                                                <small class="text-muted">{{__('Task')}}:</small>
                                                <h6 class="m-0"><a href="{{ route('projects.tasks.index',$due_task->project->id) }}" class="name mb-0 h6 text-sm">{{ $due_task->name }}</a></h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{__('Project')}}:</small>
                                        <h6 class="m-0 h6 text-sm">{{$due_task->project->project_name}}</h6>
                                    </td>
                                    <td>

                                        <small class="text-muted">{{__('Stage')}}:</small>
                                        <div class="d-flex align-items-center h6 text-sm mt-2">
                                            <span class="full-circle bg-{{ \App\Models\ProjectTask::$priority_color[$due_task->priority] }}"></span>
                                            <span class="ms-1">{{ \App\Models\ProjectTask::$priority[$due_task->priority] }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{__('Completion')}}:</small>
                                        <h6 class="m-0 h6 text-sm">{{ $due_task->taskProgress()['percentage'] }}</h6>
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
