@extends('layouts.admin')

@section('title')
    {{ __('Dashboard')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
@endsection


@push('theme-script')
    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
@endpush

@push('script-page')


    <script>
            @if($calenderTasks)
            (function () {
                var etitle;
                var etype;
                var etypeclass;
                var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    themeSystem: 'bootstrap',
                    initialDate: '{{ $transdate }}',
                    slotDuration: '00:10:00',
                    navLinks: true,
                    droppable: true,
                    selectable: true,
                    selectMirror: true,
                    editable: true,
                    dayMaxEvents: true,
                    handleWindowResize: true,
                    events:{!! json_encode($calenderTasks) !!},

                });
                calendar.render();
            })();
        @endif

        $(document).on('click', '.fc-day-grid-event', function (e) {
            if (!$(this).hasClass('deal')) {
                e.preventDefault();
                var event = $(this);
                var title = $(this).find('.fc-content .fc-title').html();
                var size = 'md';
                var url = $(this).attr('href');
                $("#commonModal .modal-title").html(title);
                $("#commonModal .modal-dialog").addClass('modal-' + size);

                $.ajax({
                    url: url,
                    success: function (data) {
                        $('#commonModal .modal-body').html(data);
                        $("#commonModal").modal('show');
                    },
                    error: function (data) {
                        data = data.responseJSON;
                        show_toastr('Error', data.error, 'error')
                    }
                });
            }
        });



    </script>
    <script>


        (function () {
            var chartBarOptions = {
                series: {!! json_encode($taskData['dataset']) !!},


                chart: {
                    height: 250,
                    type: 'area',
                    // type: 'line',
                    dropShadow: {
                        enabled: true,
                        color: '#000',
                        top: 18,
                        left: 7,
                        blur: 10,
                        opacity: 0.2
                    },
                    toolbar: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                title: {
                    text: '',
                    align: 'left'
                },
                xaxis: {
                    categories:{!! json_encode($taskData['label']) !!},
                    title: {
                        text: "{{__('Days')}}"
                    }
                },
                colors: ['#6fd944', '#883617','#4e37b9','#8f841b'],

                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: false,
                },
                // markers: {
                //     size: 4,
                //     colors: ['#3b6b1d', '#be7713' ,'#2037dc','#cbbb27'],
                //     opacity: 0.9,
                //     strokeWidth: 2,
                //     hover: {
                //         size: 7,
                //     }
                // },
                yaxis: {
                    title: {
                        text: "{{__('Amount')}}"
                    },

                }

            };
            var arChart = new ApexCharts(document.querySelector("#chart-sales"), chartBarOptions);
            arChart.render();
        })();



        (function () {
            var options = {
                chart: {
                    height: 140,
                    type: 'donut',
                },
                dataLabels: {
                    enabled: false,
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                        }
                    }
                },
                series: {!! json_encode(array_values($projectData)) !!},
                colors:["#bd9925", "#2f71bd", "#720d3a","#ef4917"],
                labels:   {!! json_encode($project_status) !!},
                legend: {
                    show: true
                }
            };
            var chart = new ApexCharts(document.querySelector("#chart-doughnut"), options);
            chart.render();
        })();
    </script>
@endpush

@section('content')
@php

  $project_task_percentage = $project['project_task_percentage'];
  $label='';
        if($project_task_percentage<=15){
            $label='bg-danger';
        }else if ($project_task_percentage > 15 && $project_task_percentage <= 33) {
            $label='bg-warning';
        } else if ($project_task_percentage > 33 && $project_task_percentage <= 70) {
            $label='bg-primary';
        } else {
            $label='bg-success';
        }


  $project_percentage = $project['project_percentage'];
  $label1='';
        if($project_percentage<=15){
            $label1='bg-danger';
        }else if ($project_percentage > 15 && $project_percentage <= 33) {
            $label1='bg-warning';
        } else if ($project_percentage > 33 && $project_percentage <= 70) {
            $label1='bg-primary';
        } else {
            $label1='bg-success';
        }

  $project_bug_percentage = $project['project_bug_percentage'];
  $label2='';
      if($project_bug_percentage<=15){
        $label2='bg-danger';
      }else if ($project_bug_percentage > 15 && $project_bug_percentage <= 33) {
        $label2='bg-warning';
      } else if ($project_bug_percentage > 33 && $project_bug_percentage <= 70) {
        $label2='bg-primary';
      } else {
        $label2='bg-success';
      }
@endphp

    <div class="row">
        @if(!empty($arrErr))
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                @if(!empty($arrErr['system']))
                    <div class="alert alert-danger text-xs">
                         {{ __('are required in') }} <a href="{{ route('settings') }}" class=""><u> {{ __('System Setting') }}</u></a>
                    </div>
                @endif
                @if(!empty($arrErr['user']))
                    <div class="alert alert-danger text-xs">
                         <a href="{{ route('users') }}" class=""><u>{{ __('here') }}</u></a>
                    </div>
                @endif
                @if(!empty($arrErr['role']))
                    <div class="alert alert-danger text-xs">
                         <a href="{{ route('roles.index') }}" class=""><u>{{ __('here') }}</u></a>
                    </div>
                @endif
            </div>
        @endif
    </div>

<div class="col-sm-12">
    <div class="row">
        <div class="col-xxl-6">
            <div class="row">
                @if(isset($arrCount['deal']))
                    <div class="col-lg-6 col-md-6">
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
                                                <h6 class="m-0">{{__('Deal')}}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto text-end">
                                        <h5 class="m-0">{{ $arrCount['deal'] }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if(isset($arrCount['task']))
                        <div class="col-lg-6 col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row align-items-center justify-content-between">
                                                    <div class="col-auto mb-3 mb-sm-0">
                                                        <div class="d-flex align-items-center">
                                                            <div class="theme-avtar bg-primary">
                                                                <i class="ti ti-list"></i>
                                                            </div>
                                                            <div class="ms-3">
                                                                <small class="text-muted">{{__('Total')}}</small>
                                                                <h6 class="m-0">{{__('Deal Task')}}</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto text-end">
                                                        <h5 class="m-0">{{ $arrCount['task'] }}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                    @endif

                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('Calendar') }}</h5>
                        </div>
                        <div class="card-body">
                            <div id='calendar' class='calendar'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6">
            <div class="row">
                <div class="col--xxl-12">
                    <div class="card">
                            <div class="card-body">
                                <div class="row ">
                                    <div class="col-md-4 col-sm-6">
                                        <div class="align-items-start">
                                            <div class="ms-2">
                                                <p class="text-muted text-sm mb-0">{{__('Total Project')}}</p>
                                                <h3 class="mb-0 text-warning">{{$project['project_percentage']}}%</h3>
                                                <div class="progress mb-0">
                                                    <div class="progress-bar bg-{{$label1}}" style="width: {{$project['project_percentage']}}%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="align-items-start">
                                            <div class="ms-2">
                                                <p class="text-muted text-sm mb-0">{{__('Total Project Tasks')}}</p>
                                                <h3 class="mb-0 text-info">{{$project['projects_tasks_count']}}%</h3>
                                                <div class="progress mb-0">
                                                    <div class="progress-bar bg-{{$label1}}" style="width: {{$project['project_task_percentage']}}%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="align-items-start">

                                            <div class="ms-2">

                                                <p class="text-muted text-sm mb-0">{{__('Total Bugs')}}</p>
                                                <h3 class="mb-0 text-danger">{{$project['projects_bugs_count']}}%</h3>
                                                <div class="progress mb-0">
                                                    <div class="progress-bar bg-{{$label1}}" style="width: {{$project['project_bug_percentage']}}%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{__('Tasks Overview')}}</h5>
                            <h6 class="last-day-text">{{__('Last 7 Days')}}</h6>
                        </div>
                        <div class="card-body">
                            <div id="chart-sales" height="200" class="p-3"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{__('Project Status')}}
                                <span class="float-end text-muted">{{__('Year').' - '.$currentYear}}</span>
                            </h5>

                        </div>
                        <div class="card-body">
                            <div id="chart-doughnut"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="{{ (Auth::user()->type =='company' || Auth::user()->type =='client') ? 'col-xl-6 col-lg-6 col-md-6' : 'col-xl-8 col-lg-8 col-md-8' }} col-sm-12">
            <div class="card bg-none min-410 mx-410">
                <div class="card-header">
                    <h5>{{ __('Top Due Project') }}</h5>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                        <tr>
                            <th>{{__('Task Name')}}</th>
                            <th>{{__('Remain Task')}}</th>
                            <th>{{__('Due Date')}}</th>
                            <th>{{__('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        @forelse($project['projects'] as $project)
                            @php
                                $datetime1 = new DateTime($project->due_date);
                                $datetime2 = new DateTime(date('Y-m-d'));
                                $interval = $datetime1->diff($datetime2);
                                $days = $interval->format('%a');

                                 $project_last_stage = ($project->project_last_stage($project->id))?$project->project_last_stage($project->id)->id:'';
                                $total_task = $project->project_total_task($project->id);
                                $completed_task=$project->project_complete_task($project->id,$project_last_stage);
                                $remain_task=$total_task-$completed_task;
                            @endphp
                            <tr>
                                <td class="id-web">
                                    {{$project->project_name}}
                                </td>
                                <td>{{$remain_task }}</td>
                                <td>{{ Auth::user()->dateFormat($project->end_date) }}</td>
                                <td>
                                    <div class="action-btn bg-primary ms-2">
                                        <a href="{{ route('projects.show',$project->id) }}" class="mx-3 btn btn-sm align-items-center"><i class="ti ti-eye text-white"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="4">{{__('No Data Found.!')}}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6">
            <div class="card bg-none min-410 mx-410">
                <div class="card-header">
                    <h5>{{ __('Top Due Task') }}</h5>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                        <tr>
                            <th>{{__('Task Name')}}</th>
                            <th>{{__('Assign To')}}</th>
                            <th>{{__('Task Stage')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($top_tasks as $top_task)
                            <tr>
                                <td class="id-web">
                                    {{$top_task->name}}
                                </td>
                                <td>
                                    <div class="avatar-group">
                                        @if($top_task->users()->count() > 0)
                                            @if($users = $top_task->users())
                                                @foreach($users as $key => $user)
                                                    @if($key<3)
                                                        <a href="#" class="avatar rounded-circle avatar-sm">
                                                            <img data-original-title="{{(!empty($user)?$user->name:'')}}" @if($user->avatar) src="{{asset('/storage/uploads/avatar/'.$user->avatar)}}" @else src="{{asset('assets/img/avatar/avatar-1.png')}}" @endif title="{{ $user->name }}" class="hweb">
                                                        </a>
                                                    @else
                                                        @break
                                                    @endif
                                                @endforeach
                                            @endif
                                            @if(count($users) > 3)
                                                <a href="#" class="avatar rounded-circle avatar-sm">
                                                    <img  data-original-title="{{(!empty($user)?$user->name:'')}}" @if($user->avatar) src="{{asset('/storage/uploads/avatar/'.$user->avatar)}}" @else src="{{asset('assets/img/avatar/avatar-1.png')}}" @endif class="hweb">
                                                </a>
                                            @endif
                                        @else
                                            {{ __('-') }}
                                        @endif
                                    </div>
                                </td>
                                <td><span class="p-2 px-3 rounded badge bg-">{{ $top_task->stage->name }}</span></td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="4">{{__('No Data Found.!')}}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
