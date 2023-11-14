@include('new_layouts.header')
<style>
.projectlifetimezone{
  display : none !important;
}
</style>
<div class="page-wrapper">
@include('construction_project.side-menu')
<?php
$delay=round($current_Planed_percentage-$actual_percentage);
if($delay<0){
  $delay=0;
}
if($delay>100){
  $delay=100;
}
?>
    <!-- Page header -->
    <div class="page-header d-print-none">
      <div class="container-fluid">
        <div class="row g-2 align-items-center">
          <div class="col-10">
            <!-- Page pre-title -->
            <div class="page-pretitle">
              {{ __('Overview')}}
            </div>
            <h2 class="page-title">
              {{ __('Dashboard')}}
            </h2>
          </div>


        </div>
      </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
      <div class="container-fluid">
        <div class="row row-deck row-cards">
          <div class="col-lg-6 col-xl-3">
            <div class="card">
              <div class="card-body p-4 py-5 text-center">
                @php
                  $avatar=substr($project->project_name, 0, 1);
                @endphp
                <span class="avatar avatar-xl mb-4 rounded">{{ $avatar }}</span>
                <h3 class="mb-0">{{$project->project_name}}</h3>
                <p class="text-secondary"><b>{{ __('Start from')}}:</b>
                {{ Utility::getDateFormated($project->start_date) }} - <b>{{ __('Due to')}}:</b>
                 {{ Utility::getDateFormated($project->end_date) }}</p>
                <p class="mb-3">
                @if($project->status == 'in_progress')
                  <span class="badge bg-info p-2 px-3 rounded"> {{ __('In Progress')}}</span>
                @elseif($project->status == 'on_hold')
                  <span class="badge  bg-warning p-2 px-3 rounded">{{ __('On Hold')}}</span>
                @elseif($project->status == 'Canceled')
                  <span class="badge  bg-red p-2 px-3 rounded"> {{ __('Canceled')}}</span>
                @else
                    <span class="badge bg-success p-2 px-3 rounded">{{ __('Finished')}}</span>
                @endif
                </p>
                <div>
                  <div class="avatar-list avatar-list-stacked">
                  @foreach ($project->users as $user)
                    @php
                      $avatar=substr($user->name, 0, 1);
                    @endphp
                    <span class="avatar avatar-sm rounded">{{$avatar}}</span>
                  @endforeach
                  </div>
                </div>
              </div>
              <div class="progress card-progress">
                <div class="progress-bar" style="width: 38%" role="progressbar" aria-valuenow="38" aria-valuemin="0"
                  aria-valuemax="100" aria-label="38% Complete">
                  <span class="visually-hidden">38% Complete</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-xl-3">
            <div class="card">
              <div class="card-header">
                <h3>{{ __('Project Current Status')}}</h3>
              </div>
              <div class="card-body">
                <div id="chart-demo-pie"></div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-xl-3 projectlifetimezone" >
            <div class="card">
              <div class="card-header">
                <h3>Project Life Time Zone</h3>
              </div>
              <div class="card-body">
                <p class="mb-3">Life Time <strong>120 th day </strong>of 300 days</p>
                <div class="progress progress-separated mb-3">
                  <div class="progress-bar bg-primary" role="progressbar" style="width: 44%" aria-label="Regular"></div>
                  <div class="progress-bar bg-info" role="progressbar" style="width: 19%" aria-label="System"></div>
                  <div class="progress-bar bg-success" role="progressbar" style="width: 9%" aria-label="Shared"></div>
                </div>
                <div class="row">
                  <div class="col-auto d-flex align-items-center pe-2">
                    <span class="legend me-2 bg-primary"></span>
                    <span>Safe zone</span>
                    <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-secondary">915MB</span>
                  </div>
                  <div class="col-auto d-flex align-items-center px-2">
                    <span class="legend me-2 bg-info"></span>
                    <span>Critical Zone</span>
                    <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-secondary">415MB</span>
                  </div>
                  <div class="col-auto d-flex align-items-center px-2">
                    <span class="legend me-2 bg-success"></span>
                    <span>Shared</span>
                    <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-secondary">201MB</span>
                  </div>
                  <div class="col-auto d-flex align-items-center ps-2">
                    <span class="legend me-2"></span>
                    <span>Free</span>
                    <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-secondary">612MB</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @if($checkProject != null)
            <div class="col-lg-6 col-xl-3">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    {{ __('Current Look a Head')}}
                  </h3>
                  <div class="card-actions">
                    <a href="{{ route('micro_taskboard') }}">
                      {{ __('View the Active Look a Head')}}
                      <!-- Download SVG icon from http://tabler-icons.io/i/edit -->
                    </a>
                  </div>
                </div>
                <div class="card-body">
                  <dl class="row">
                    @if($microProgram != null)
                      <dt class="col-5">{{ __('Start Date')}}:</dt>
                      <dd class="col-7">
                        {{ Utility::site_date_format($microProgram->schedule_start_date,\Auth::user()->id) }}
                      </dd>
                      <dt class="col-5">{{ __('End Date')}}:</dt>
                      <dd class="col-7">
                        {{ Utility::site_date_format($microProgram->schedule_end_date,\Auth::user()->id) }}
                      </dd>
                      <dt class="col-5">{{ __('Holiday in Days')}}:</dt>
                      <dd class="col-7">{{$holidayCount}}</dd>
                      <dt class="col-5">{{ __('Weekends in Days')}}</dt>
                      <dd class="col-7">{{$microWeekEndCount}}</dd>
                      <dt class="col-5">{{ __('Total working days')}}:</dt>
                      <dd class="col-7">{{$totalWorkingDays}}</dd>
                      <dt class="col-5">{{ __('Total Task Taken')}}:</dt>
                      <dd class="col-7">{{$conTaskTaken}}</dd>
                      <dt class="col-5">{{ __('Total Sub Task Created')}}:</dt>
                      <dd class="col-7">{{$microTaskCount}}</dd>
                    @else
                      <dd class="col-7">{{ __('No schedule is active')}}</dd>
                    @endif
                  </dl>
                </div>
              </div>
            </div>
          @endif
        </div>

        @if($checkProject != null)
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h3 class="card-title">{{ __('Look a Head')}}</h3>
                <div id="micro_chart-mentions" class="chart-lg"></div>
              </div>
            </div>
          </div>
        @endif

        <div class="row row-deck row-cards mt-5">
          <div class="col-sm-6 col-lg-6">
            <div class="card">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="subheader">{{ __('Total Task')}}</div>
                </div>
                <div class="h1 mb-3">{{$project_data['task']['total'] }} {{ __('Tasks')}}</div>
                <div class="d-flex mb-2">
                  <div>{{ __('Planned Percentage')}}</div>
                  <div class="ms-auto">
                    <span class="text-blue d-inline-flex align-items-center lh-1">
                    {{ round($current_Planed_percentage) }}%
                    </span>
                  </div>
                </div>
                <div class="progress progress-sm">
                  <div class="progress-bar bg-primary" style="width: {{ round($current_Planed_percentage) }}%"
                  role="progressbar" aria-valuenow="{{ round($current_Planed_percentage) }}"
                    aria-valuemin="0" aria-valuemax="100" aria-label="75% Complete">
                    <span class="visually-hidden">75% Complete</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-6">
            <div class="card">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="subheader"> {{ __('Completed Task')}}</div>
                  <div class="ms-auto lh-1">
                    {{-- <div class="dropdown">
                      <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">Last 7 days</a>
                      <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item active" href="#">Last 7 days</a>
                        <a class="dropdown-item" href="#">Last 30 days</a>
                        <a class="dropdown-item" href="#">Last 3 months</a>
                      </div>
                    </div> --}}
                  </div>
                </div>
                <div class="h1 mb-3">
                  <div class="h1 mb-0 me-2">{{$completed_task}} {{ __('Tasks')}}</div>
                </div>
                <div class="d-flex mb-2">
                  <div>{{ __('Actual Percentage')}}</div>
                  <div class="ms-auto">
                    <span class="text-blue d-inline-flex align-items-center lh-1">
                    {{round($actual_percentage)}}% <!-- Download SVG icon from http://tabler-icons.io/i/trending-up -->
                    </span>
                  </div>
                </div>
                <div class="progress progress-sm">
                  <div class="progress-bar bg-primary" style="width: {{round($actual_percentage)}}%"
                  role="progressbar" aria-valuenow="{{round($actual_percentage)}}"
                    aria-valuemin="0" aria-valuemax="100" aria-label="75% Complete">
                    <span class="visually-hidden">{{round($actual_percentage)}}% Complete</span>
                  </div>
                </div>
              </div>

            </div>

          </div>

          <div class="col-12">
            <div class="row row-cards">
              <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span
                          class="bg-primary text-white avatar">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-checklist" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8"></path>
                            <path d="M14 19l2 2l4 -4"></path>
                            <path d="M9 8h4"></path>
                            <path d="M9 12h2"></path>
                          </svg>
                        </span>
                      </div>

                        <div class="col">
                          <a @if( Session::get('current_revision_freeze')==1)
                          href='{{ route('taskBoard.view', ['list','status'=>'comp']) }}' @endif>
                          <div class="font-weight-medium">
                            {{ __('Total Completed Sub-Tasks')}}
                          </div>
                          </a>
                          <div class="text-muted">
                          {{  $completed_task }} {{ __('Tasks')}}
                          </div>
                        </div>

                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span
                          class="bg-green text-white avatar">
                          <svg xmlns="http://www.w3.org/2000/svg" 
                          class="icon icon-tabler icon-tabler-road" 
                          width="24" height="24" viewBox="0 0 24 24" 
                          stroke-width="2" stroke="currentColor" fill="none"
                           stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M4 19l4 -14"></path>
                            <path d="M16 5l4 14"></path>
                            <path d="M12 8v-2"></path>
                            <path d="M12 13v-2"></path>
                            <path d="M12 18v-2"></path>
                          </svg>
                        </span>
                      </div>
                      <div class="col">
                        <a @if( Session::get('current_revision_freeze')==1)
                        href='{{ route('taskBoard.view', ['list','status'=>'ongoing']) }}' @endif>
                          <div class="font-weight-medium">
                            {{ __('Total Ongoing Sub-Tasks')}}
                          </div>
                          <div class="text-muted">
                          {{ $ongoing_task }} {{ __('Tasks')}}
                          </div>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span
                          class="bg-twitter text-white avatar">
                          <svg xmlns="http://www.w3.org/2000/svg" 
                          class="icon icon-tabler icon-tabler-list-details" 
                          width="24" height="24" viewBox="0 0 24 24" stroke-width="2" 
                          stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M13 5h8"></path>
                            <path d="M13 9h5"></path>
                            <path d="M13 15h8"></path>
                            <path d="M13 19h5"></path>
                            <path d="M3 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                            <path d="M3 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                          </svg>
                        </span>
                      </div>
                      <div class="col">
                        <a @if( Session::get('current_revision_freeze')==1)
                         href='{{ route('taskBoard.view', ['list','status'=>'remaning']) }}' @endif>
                          <div class="font-weight-medium">
                            {{ __('Total Remaining Sub-Tasks')}}
                          </div>
                          <div class="text-muted">
                          {{ $total_sub- $completed_task-$ongoing_task }} {{ __('Tasks')}}
                          </div>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span
                          class="bg-facebook text-white avatar">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list" 
                          width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                           stroke="currentColor" fill="none" stroke-linecap="round" 
                                                    stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M9 6l11 0"></path>
                            <path d="M9 12l11 0"></path>
                            <path d="M9 18l11 0"></path>
                            <path d="M5 6l0 .01"></path>
                            <path d="M5 12l0 .01"></path>
                            <path d="M5 18l0 .01"></path>
                          </svg>
                        </span>
                      </div>
                      <div class="col">
                        <a @if( Session::get('current_revision_freeze')==1)
                         href='{{ route('taskBoard.view', ['list','status'=>'pending']) }}' @endif>
                          <div class="font-weight-medium">
                            {{ __('Total Pending Sub-Tasks')}}
                          </div>
                          <div class="text-muted">
                            {{ $notfinished }} {{ __('Tasks')}}
                          </div>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

               <!--This is a Dependency Critical task count starts-->
              <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span
                          class="bg-orange text-white avatar">
                          <svg xmlns="http://www.w3.org/2000/svg" 
                          class="icon icon-tabler icon-tabler-route-2" width="24" height="24" 
                          viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" 
                          fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M3 19a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                            <path d="M19 7a2 2 0 1 0 0 -4a2 2 0 0 0 0 4z"></path>
                            <path d="M14 5a2 2 0 0 0 -2 2v10a2 2 0 0 1 -2 2"></path>
                          </svg>
                        </span>
                      </div>
                      <div class="col">
                        <a @if( Session::get('current_revision_freeze')==1)
                         href='{{ route('taskBoard.view', ['list','status'=>'dependency_critical']) }}' @endif>
                          <div class="font-weight-medium">
                            {{ __('Total Dependency Critical Tasks') }}
                          </div>
                          <div class="text-muted">
                            {{ $dependencycriticalcount }} {{ __('Tasks')}}
                          </div>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!--This is a Dependency Critical task count ends-->

              <!--This is a Entire Critical task count starts-->
              <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span
                          class="bg-red  text-white avatar">
                          <svg xmlns="http://www.w3.org/2000/svg" 
                          class="icon icon-tabler icon-tabler-alert-triangle-filled" 
                          width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                           stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                      <path d="M12 1.67c.955 0 1.845 .467 2.39 1.247l.105 .16l8.114 13.548a2.914 2.914 0 0 1 -2.307 4.363l-.195 .008h-16.225a2.914 2.914 0 0 1 -2.582 -4.2l.099 -.185l8.11 -13.538a2.914 2.914 0 0 1 2.491 -1.403zm.01 13.33l-.127 .007a1 1 0 0 0 0 1.986l.117 .007l.127 -.007a1 1 0 0 0 0 -1.986l-.117 -.007zm-.01 -7a1 1 0 0 0 -.993 .883l-.007 .117v4l.007 .117a1 1 0 0 0 1.986 0l.007 -.117v-4l-.007 -.117a1 1 0 0 0 -.993 -.883z" stroke-width="0" fill="currentColor"></path>
                                    </svg>
                        </span>
                      </div>
                      <div class="col">
                        <a @if( Session::get('current_revision_freeze')==1)
                         href='{{ route('taskBoard.view', ['list','status'=>'entire_critical']) }}' @endif>
                          <div class="font-weight-medium">
                            {{ __('Total Critical Tasks') }}
                          </div>
                          <div class="text-muted">
                            {{ $entirecriticalcount }} {{ __('Tasks')}}
                          </div>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!--This is a Entire Critical task count ends-->
            </div>
          </div>
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h3 class="card-title">{{ __('Task summary')}}</h3>
                <div id="chart-mentions" class="chart-lg"></div>
              </div>
            </div>
          </div>


        </div>
      </div>
    </div>
  </div>
  <script>
    // @formatter:off
    all_completed  = "{{$all_completed}}";
    all_upcoming   = "{{$all_upcoming}}";
    all_inprogress = "{{$all_inprogress}}";
    all_pending    = "{{$all_pending}}";

    document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts && (new ApexCharts(document.getElementById('chart-demo-pie'), {
            chart: {
                type: "donut",
                fontFamily: 'inherit',
                height: 240,
                sparkline: {
                    enabled: true
                },
                animations: {
                    enabled: false
                },
            },
            fill: {
                opacity: 1,
            },
            series: [all_pending, all_completed, all_inprogress, all_upcoming],
            labels: ["Pending", "Completed", "In-Progress", "UpComming"],
            tooltip: {
                theme: 'dark'
            },
            grid: {
                strokeDashArray: 4,
            },
            colors: [tabler.getColor("danger"), tabler.getColor("green", 0.8),
            tabler.getColor("primary", 0.6), tabler.getColor("orange -300")],
            legend: {
                show: true,
                position: 'bottom',
                offsetY: 12,
                markers: {
                    width: 10,
                    height: 10,
                    radius: 100,
                },
                itemMargin: {
                    horizontal: 8,
                    vertical: 8
                },
            },
            tooltip: {
                fillSeriesColor: false
            },
        })).render();
    });

    const data=<?php echo json_encode($alldates)?>;
    const completed=<?php echo json_encode($completed)?>;
    const pending=<?php echo json_encode($pending)?>;

    document.addEventListener("DOMContentLoaded", function () {
      window.ApexCharts && (new ApexCharts(document.getElementById('chart-mentions'), {
        chart: {
          type: "bar",
          fontFamily: 'inherit',
          height: 240,
          parentHeightOffset: 0,
          toolbar: {
            show: false,
          },
          animations: {
            enabled: false
          },
          stacked: true,
        },
        plotOptions: {
          bar: {
            columnWidth: '50%',
          }
        },
        dataLabels: {
          enabled: false,
        },
        fill: {
          opacity: 1,
        },
        series: [{
          name: "Pending",
          data: pending,
        }, {
          name: "Completed",
          data: completed,
        }],
        tooltip: {
          theme: 'dark'
        },
        grid: {
          padding: {
            top: -20,
            right: 0,
            left: -4,
            bottom: -4
          },
          strokeDashArray: 4,
          xaxis: {
            lines: {
              show: true
            }
          },
        },
        xaxis: {
          labels: {
            padding: 0,
          },
          tooltip: {
            enabled: false
          },
          axisBorder: {
            show: false,
          },
          type: 'datetime',
        },
        yaxis: {
          labels: {
            padding: 4
          },
        },
        labels:data,
        colors: [tabler.getColor("red"), tabler.getColor("primary", 0.8), tabler.getColor("green", 0.8)],
        legend: {
          show: false,
        },
      })).render();
    });

    const microProgramName=<?php echo json_encode($microProgramName)?>;
    const micro_planned_set =<?php echo json_encode($micro_planned_set)?>;
    const micro_actual_percentage_set = <?php echo json_encode($micro_actual_percentage_set)?>;

    document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts && (new ApexCharts(document.getElementById('micro_chart-mentions'), {
        chart: {
            type: "bar",
            fontFamily: 'inherit',
            height: 320,
            parentHeightOffset: 0,
            toolbar: {
            show: false,
            },
            animations: {
            enabled: false
            },
        },
        plotOptions: {
            bar: {
            columnWidth: '50%',
            }
        },
        dataLabels: {
            enabled: false,
        },
        fill: {
            opacity: 1,
        },
        series: [{
            name: "Planned",
            data: micro_planned_set
        }, {
            name: "Actual",
            data: micro_actual_percentage_set
        }],
        tooltip: {
            theme: 'dark'
        },
        grid: {
            padding: {
            top: -20,
            right: 0,
            left: -4,
            bottom: -4
            },
            strokeDashArray: 4,
        },
        xaxis: {
            labels: {
            padding: 0,
            },
            tooltip: {
            enabled: false
            },
            axisBorder: {
            show: false,
            },
            categories: microProgramName,
        },
        yaxis: {
            labels: {
            padding: 4
            },
        },
        colors: [tabler.getColor("primary")],
        legend: {
            show: false,
        },
        })).render();
    });
    // @formatter:on
  </script>
@include('new_layouts.footer')
