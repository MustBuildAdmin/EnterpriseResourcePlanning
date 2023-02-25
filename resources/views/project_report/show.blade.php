@extends('layouts.admin')
@section('page-title')
    {{__('Project Reports')}}
@endsection

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{__('Project Reports')}}</h5>
    </div>
@endsection
@push('css-page')
{{--<link rel="stylesheet" href="{{ asset('public/custom/css/datatables.min.css') }}">--}}

<style>
.table.dataTable.no-footer {
    border-bottom: none !important;
}
.display-none {
    display: none !important;
}
</style>
@endpush
@push('script-page')

    <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
{{--    <script src="{{ asset('js/datatable/dataTables.buttons.min.js') }}"></script>--}}
{{--    <script src="{{ asset('js/datatable/jszip.min.js') }}"></script>--}}
{{--    <script src="{{ asset('js/datatable/pdfmake.min.js') }}"></script>--}}
{{--    <script src="{{ asset('js/datatable/vfs_fonts.js') }}"></script>--}}
{{--    <script src="{{ asset('js/datatable/buttons.html5.min.js') }}"></script>--}}
    <script>

        var filename = $('#filename').val();

        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,
                filename: filename,
                image: {type: 'jpeg', quality: 1},
                html2canvas: {scale: 4, dpi: 72, letterRendering: true},
                jsPDF: {unit: 'in', format: 'A2'}
            };
            html2pdf().set(opt).from(element).save();

        }


        $(document).ready(function () {
            var filename = $('#filename').val();
            $('#reportTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: filename
                    }, {
                        extend: 'csvHtml5',
                        title: filename
                    }, {
                        extend: 'pdfHtml5',
                        title: filename
                    },
                ],
                language: dataTabelLang
            });
        });
</script>

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('project_report.index')}}">{{__('Project Report')}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{__('Project Details')}}</li>
@endsection

@section('action-btn')
    <div class="float-end">

    <a href="#" onclick="saveAsPDF();" class="btn btn-sm btn-primary py-2 dwn" data-bs-toggle="tooltip" title="{{__('Download')}}" id="download-buttons">
        <i class="ti ti-download"></i>
    </a>
    </div>
@endsection
@section('content')


<div class="row">
    <div class="col-sm-12">
        <div class="row" id="printableArea">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('Overview')}}</h5>
                        </div>
                        <div class="card-body" style="min-height: 280px;">
                            <div class="row align-items-center">
                                <div class="col-7">
                                    <table class="table" >
                                        <tbody>
                                            <tr class="border-0" >
                                                <th class="border-0" >{{ __('Project Name')}}:</th>
                                                <td class="border-0"> {{$project->project_name}}</td>
                                            </tr>
                                            <tr>
                                                <th class="border-0">{{ __('Project Status')}}:</th>
                                                <td class="border-0">

                                                    @if($project->status == 'in_progress')
                                                        <div class="badge  bg-success p-2 px-3 rounded"> {{ __('In Progress')}}</div>
                                                    @elseif($project->status == 'on_hold')
                                                    <div class="badge  bg-secondary p-2 px-3 rounded">{{ __('On Hold')}}</div>
                                                    @elseif($project->status == 'Canceled')
                                                    <div class="badge  bg-success p-2 px-3 rounded"> {{ __('Canceled')}}</div>
                                                    @else
                                                        <div class="badge bg-warning p-2 px-3 rounded">{{ __('Finished')}}</div>
                                                    @endif
                                                </td>
                                            </tr>

                                            <tr role="row">
                                                <th class="border-0">{{ __('Start Date') }}:</th>
                                                <td class="border-0">{{($project->start_date)}}</td>
                                            </tr>
                                            <tr>
                                                <th class="border-0">{{ __('End Date') }}:</th>
                                                <td class="border-0">{{($project->end_date)}}</td>
                                            </tr>
                                            <tr>
                                                <th class="border-0">{{ __('Total Members')}}:</th>
                                                <td class="border-0">{{(int) $project->users->count()  }}</td>
                                            </tr>
                                        </tbody>
                                   </table>
                                </div>
                                <div class="col-5 ">
                                            @php
                                                $task_percentage = $project->project_progress()['percentage'];
                                                $data =trim($task_percentage,'%');
                                                $status = $data > 0 && $data <= 25 ? 'red' : ($data > 25 && $data <= 50 ? 'orange' : ($data > 50 && $data <= 75 ? 'blue' : ($data > 75 && $data <= 100 ? 'green' : '')));
                                            @endphp
                                    <div class="circular-progressbar p-0">
                                        <div class="flex-wrapper">
                                            <div class="single-chart">
                                                <svg viewBox="0 0 36 36"
                                                    class="circular-chart orange  {{$status}}">
                                                    <path class="circle-bg" d="M18 2.0845
                                                                a 15.9155 15.9155 0 0 1 0 31.831
                                                                a 15.9155 15.9155 0 0 1 0 -31.831" />
                                                    <path class="circle"
                                                        stroke-dasharray="{{ $data }}, 100" d="M18 2.0845
                                                                a 15.9155 15.9155 0 0 1 0 31.831
                                                                a 15.9155 15.9155 0 0 1 0 -31.831" />
                                                    <text x="18" y="20.35"
                                                        class="percentage">{{ $data }}%</text>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    @php
                        $mile_percentage = $project->project_milestone_progress()['percentage'];
                        $mile_percentage =trim($mile_percentage,'%');
                    @endphp
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header" style="padding: 25px 35px !important;">
                            <div class="d-flex justify-content-between align-items-center">

                                <div class="row">
                                    <h5 class="mb-0">{{ __('Milestone Progress') }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <div id="milestone-chart" class="chart-canvas chartjs-render-monitor" height="150"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="float-end">
                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Refferals"><i class=""></i></a>
                            </div>
                            <h5>{{ __('Task Priority') }}</h5>
                        </div>
                        <div class="card-body"  style="min-height: 280px;">
                            <div class="row align-items-center">
                                <div class="col-12">
                                    <div id='chart_priority'></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <div class="float-end">
                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Refferals"><i class=""></i></a>
                            </div>
                            <h5>{{ __('Task Status') }}</h5>
                        </div>
                        <div class="card-body"  style="min-height: 280px;">
                            <div class="row align-items-center">
                                <div class="col-12">
                                    <div id="chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="float-end">
                                  <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Refferals"><i class=""></i></a>
                              </div>
                            <h5>{{ __('Hours Estimation') }}</h5>
                        </div>
                        <div class="card-body"  style="min-height: 280px;">
                            <div class="row align-items-center">
                                <div class="col-12">
                                      <div id="chart-hours"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
@php
$lastStage=\App\Models\TaskStage::where('created_by',\Auth::user()->creatorId())->orderby('id','desc')->first();

@endphp
                <div class="col-md-5">
                    <div class="card ">
                        <div class="card-header">
                            <h5>{{ __('Users') }}</h5>
                        </div>
                        <div class="card-body table-border-style ">
                            <div class="table-responsive milestone">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{__('Name')}}</th>
                                            <th>{{__('Assigned Tasks')}}</th>
                                            <th>{{__('Done Tasks')}}</th>
                                            <th>{{__('Logged Hours')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($project->users as $user)
                                            @php
                                                $hours_format_number = 0;
                                                $total_hours = 0;
                                                $hourdiff_late = 0;
                                                $esti_late_hour =0;
                                                $esti_late_hour_chart=0;

                                                $total_user_task = App\Models\ProjectTask::where('project_id',$project->id)->whereRaw("FIND_IN_SET(?,  assign_to) > 0", [$user->id])->get()->count();



                                                $all_task = App\Models\ProjectTask::where('project_id',$project->id)->whereRaw("FIND_IN_SET(?,  assign_to) > 0", [$user->id])->get();

                                                $total_complete_task = App\Models\ProjectTask::where('project_id','=',$project->id)->where('stage_id',$lastStage->id)
                                                ->where('assign_to','=',$user->id)->count();

                                                $logged_hours = 0;
                                                $timesheets = App\Models\Timesheet::where('project_id',$project->id)->where('created_by' ,$user->id)->get();
                                            @endphp

                                            @foreach($timesheets as $timesheet)
                                                @php

                                                    $hours =  date('H', strtotime($timesheet->time));
                                                    $minutes =  date('i', strtotime($timesheet->time));
                                                    $total_hours = $hours + ($minutes/60) ;
                                                    $logged_hours += $total_hours ;
                                                    $hours_format_number = number_format($logged_hours, 2, '.', '');
                                                @endphp
                                            @endforeach
                                            <tr>
                                                <td>{{$user->name}}</td>
                                                <td>{{$total_user_task}}</td>
                                                <td>{{$total_complete_task}}</td>
                                                <td>{{$hours_format_number}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="card ">
                        <div class="card-header">
                            <h5>{{ __('Milestones') }}</h5>
                        </div>
                        <div class="card-body table-border-style ">
                            <div class="table-responsive milestone">
                                <table class="table" >
                                    <thead>
                                        <tr>
                                            <th> {{__('Name')}}</th>
                                            <th> {{__('Progress')}}</th>
                                            <th> {{__('Cost')}}</th>
                                            <th> {{__('Status')}}</th>
                                            <th> {{__('Start Date')}}</th>
                                            <th> {{__('End Date')}}</th>
                                        </tr>
                                    </thead>
                                     <tbody>
                                           @foreach($project->milestones as $milestone)
                                                <tr>
                                               <td>{{$milestone->title}}</td>
                                                <td>
                                                    <div class="progress_wrapper">
                                                            <div class="progress">
                                                                    <div class="progress-bar" role="progressbar"  style="width: {{ $milestone->progress }}px;"
                                                                    aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">
                                                                    </div>
                                                            </div>
                                                                    <div class="progress_labels">
                                                                        <div class="total_progress">
                                                                            <strong> {{ $milestone->progress }}%</strong>
                                                                        </div>
                                                                    </div>
                                                    </div>
                                                </td>
                                               <td>{{$milestone->cost}}</td>
                                               <td> @if($milestone->status == 'complete')
                                                                    <label class="badge bg-success p-2 px-3 rounded">{{__('Complete')}}</label>
                                                                @else
                                                       <label class="badge bg-warning p-2 px-3 rounded">{{__('Incomplete')}}</label>
                                                   @endif</td>

                                               <td>{{$milestone->start_date}}</td>
                                               <td>{{$milestone->due_date}}</td>
                                            </tr>
                                           @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

        </div>

        <div class="col-sm-12">
            <div class="col-md-12  row d-sm-flex align-items-center justify-content-end">
                <div class="col-1">
                    <button class=" btn btn-primary mx-2 btn-filter apply">
                        <a href="{{ route('project_report.export',$project->id)}}" class="text-white">{{ __('Export') }}</a>
                    </button>
                </div>
            </div>
        </div>

        <div class="col-sm-12 mt-3">
                <div class="card">
                    <div class="card-body mt-3 mx-2">
                        <div class="row mt-2">
                            <div class="table-responsive">
                                    <table class="table datatable">
                                        <thead>
                                                <th>{{ __('Task Name') }}</th>
                                                <th>{{ __('Milestone') }}</th>
                                                <th>{{ __('Start Date') }}</th>
                                                <th>{{ __('End Date') }}</th>
                                                <th>{{ __('Assigned to') }}</th>
                                                <th> {{__('Total Logged Hours')}}</th>
                                                <th>{{ __('Priority') }}</th>
                                                <th>{{ __('Stage') }}</th>

                                            </thead>

                                        @foreach($tasks as $task)
                                            @php
                                                $hours_format_number = 0;
                                                $total_hours = 0;
                                                $hourdiff_late = 0;
                                                $esti_late_hour =0;
                                                $esti_late_hour_chart=0;

                                                $total_user_task = App\Models\ProjectTask::where('project_id',$project->id)->whereRaw("FIND_IN_SET(?,  assign_to) > 0", [$user->id])->get()->count();

                                                $all_task = App\Models\ProjectTask::where('project_id',$project->id)->whereRaw("FIND_IN_SET(?,  assign_to) > 0", [$user->id])->get();

                                                $total_complete_task = App\Models\ProjectTask::join('task_stages','task_stages.id','=','project_tasks.stage_id')
                                                ->where('task_stages.project_id','=',$project->id)->where('stage_id',4)->where('assign_to','=',$user->id)->get()->count();

                                                $logged_hours = 0;
                                                $timesheets = App\Models\Timesheet::where('project_id',$project->id)->where('task_id' ,$task->id)->get();
                                            @endphp
                                            @foreach($timesheets as $timesheet)

                                                @php

                                                    $hours =  date('H', strtotime($timesheet->time));
                                                    $minutes =  date('i', strtotime($timesheet->time));
                                                    $total_hours = $hours + ($minutes/60) ;
                                                    $logged_hours += $total_hours ;
                                                    $hours_format_number = number_format($logged_hours, 2, '.', '');
                                                @endphp
                                            @endforeach
                                            <tbody>

                                            <td>
                                                <a href="#!" data-size="md" data-url="{{ route('projects.tasks.show',[$project->id,$task->id]) }}"
                                                   data-ajax-popup="true" class="dropdown-item" data-bs-original-title="{{__('View')}}">
                                                    {{$task->name}}
                                                </a>
                                            </td>
                                            <td>{{ (!empty($task->milestone)) ? $task->milestone->title : '-' }}</td>
                                            <td>{{$task->start_date}}</td>
                                            <td>{{$task->end_date}}</td>
                                            <td>
                                                <div class="avatar-group">
                                                    @if($task->users()->count() > 0)
                                                        @if($users = $task->users())
                                                            @foreach($users as $key => $user)
                                                                @if($key<3)
                                                                    <a href="#" class="avatar rounded-circle avatar-sm">
                                                                        <img src="{{$user->getImgImageAttribute()}}" title="{{ $user->name }}">
                                                                    </a>
                                                                @else
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        @if(count($users) > 3)
                                                            <a href="#" class="avatar rounded-circle avatar-sm">
                                                                <img src="{{$user->getImgImageAttribute()}}">
                                                            </a>
                                                        @endif
                                                    @else
                                                        {{ __('-') }}
                                                    @endif
                                                </div>
                                            </td>
                                            <td>{{$hours_format_number}}</td>
                                            <td>
                                                <div class="">
                                                    <span class="badge p-2 px-3 status_badge rounded bg-{{\App\Models\ProjectTask::$priority_color[$task->priority]}}">{{ \App\Models\ProjectTask::$priority[$task->priority] }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $task->stage->name }}</td>


                                            </tbody>
                                        @endforeach
                                    </table>
                                </div>
                        </div>
                    </div>
                </div>
            </div>

    </div>
</div>

@endsection
@push('script-page')
{{--<script src="{{ asset('public/custom/js/jquery.dataTables.min.js') }}"></script>--}}
            <script src="{{ asset('assets/js/datatables.min.js') }}"></script>

            <script src="{{asset('assets/js/plugins/apexcharts.min.js')}}"></script>

<script>
    var filename = $('#chart-hours').val();

    function saveAsPDF() {
        var element = document.getElementById('printableArea');
        var opt = {
            margin: 0.3,

            image: {
                type: 'jpeg',
                quality: 1
            },
            html2canvas: {
                scale: 4,
                dpi: 72,
                letterRendering: true
            },
            jsPDF: {
                unit: 'in',
                format: 'A2'
            }
        };
        html2pdf().set(opt).from(element).save();
    }
</script>

<script>
(function () {
    var options = {
        series: [{!! json_encode($mile_percentage) !!}],
        chart: {
            height: 475,
            type: 'radialBar',
            offsetY: -20,
            sparkline: {
                enabled: true
            }
        },
        plotOptions: {
            radialBar: {
                startAngle: -90,
                endAngle: 90,
                track: {
                    background: "#e7e7e7",
                    strokeWidth: '97%',
                    margin: 5, // margin is in pixels
                },
                dataLabels: {
                    name: {
                        show: true
                    },
                    value: {
                        offsetY: -50,
                        fontSize: '20px'
                    }
                }
            }
        },
        grid: {
            padding: {
                top: -10
            }
        },
        colors: ["#51459d"],
        labels: ['Progress'],
    };
    var chart = new ApexCharts(document.querySelector("#milestone-chart"), options);
    chart.render();
})();




    var options = {
          series: [{
          data: {!! json_encode($arrProcessPer_priority) !!}
        }],
          chart: {
          height: 210,
          type: 'bar',
        },
        colors: ['#6fd943','#ff3a6e','#3ec9d6'],
        plotOptions: {
          bar: {

            columnWidth: '50%',
            distributed: true,
          }
        },
        dataLabels: {
          enabled: false
        },
        legend: {
          show: true
        },
        xaxis: {
          categories: {!! json_encode($arrProcess_Label_priority) !!},
          labels: {
            style: {
              colors: {!! json_encode($chartData['color']) !!},

            }
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart_priority"), options);
        chart.render();


        var options = {
            series:  {!! json_encode($arrProcessPer_status_task) !!},
            chart: {
                width: 380,
                type: 'pie',
            },
            color: {!! json_encode($chartData['color']) !!},
            labels:{!! json_encode($arrProcess_Label_status_tasks) !!},
            responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                width: 100
                },
                legend: {
                position: 'bottom'

                }
            }
            }]
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();


        ///===================== Hour Chart =============================================================///
        var options = {
          series: [{
           data: [{!! json_encode($esti_logged_hour_chart) !!},{!! json_encode($logged_hour_chart) !!}],

        }],
          chart: {
          height: 210,
          type: 'bar',
        },
        colors: ['#963aff','#ffa21d'],
        plotOptions: {
          bar: {
               horizontal: true,
            columnWidth: '30%',
            distributed: true,
          }
        },
        dataLabels: {
          enabled: false
        },
        legend: {
          show: true
        },
        xaxis: {
          categories: ["Estimated Hours","Logged Hours "],

        }
        };

        var chart = new ApexCharts(document.querySelector("#chart-hours"), options);
        chart.render();



</script>
@endpush
