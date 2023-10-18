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
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col-10">
            <!-- Page pre-title -->
            <div class="page-pretitle">
              Overview
            </div>
            <h2 class="page-title">
              Dashboard
            </h2>
          </div>


        </div>
      </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
      <div class="container-xl">
        <div class="row row-deck row-cards">
          <div class="col-lg-6 col-xl-3">
            <div class="card">
              <div class="card-body p-4 py-5 text-center">
                @php
                  $avatar=substr($project->project_name, 0, 1);
                @endphp
                <span class="avatar avatar-xl mb-4 rounded">{{ $avatar }}</span>
                <h3 class="mb-0">{{$project->project_name}}</h3>
                <p class="text-secondary"><b>Start from:</b>
                {{ Utility::getDateFormated($project->start_date) }} - <b>Due to:</b>
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
                <h3>Project Current Status</h3>
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
          <div class="col-lg-6 col-xl-3">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  Current Look a Head
                </h3>
                <div class="card-actions">
                  <a href="#">
                    View the Active Look a Head<!-- Download SVG icon from http://tabler-icons.io/i/edit -->
                  </a>
                </div>
              </div>
              <div class="card-body">
                <dl class="row">
                  <dt class="col-5">Start Date:</dt>
                  <dd class="col-7">2020-01-05 </dd>
                  <dt class="col-5">End Date:</dt>
                  <dd class="col-7">2020-01-05 </dd>
                  <dt class="col-5">Holiday in Days:</dt>
                  <dd class="col-7">2</dd>
                  <dt class="col-5">Weekends in Days</dt>
                  <dd class="col-7">1</dd>
                  <dt class="col-5">Total working days:</dt>
                  <dd class="col-7">4</dd>
                  <dt class="col-5">Total Task Taken:</dt>
                  <dd class="col-7">10</dd>
                  <dt class="col-5">Total Sub Task Created:</dt>
                  <dd class="col-7">10</dd>
                </dl>
              </div>
            </div>
          </div>
        </div>
        <div class="row row-deck row-cards mt-5">
          <div class="col-sm-6 col-lg-6">
            <div class="card">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="subheader">Total Task</div>
                </div>
                <div class="h1 mb-3">{{$project_data['task']['total'] }} Tasks</div>
                <div class="d-flex mb-2">
                  <div>Planned Percentage</div>
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
                  <div class="subheader">Completed Task</div>
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
                  <div class="h1 mb-0 me-2">{{$completed_task}} Tasks</div>
                </div>
                <div class="d-flex mb-2">
                  <div>Actual Percentage</div>
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
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" />
                            <path d="M12 3v3m0 12v3" />
                          </svg>
                        </span>
                      </div>

                        <div class="col">
                          <a @if( Session::get('current_revision_freeze')==1)
                          href='{{ route('taskBoard.view', ['list','status'=>'comp']) }}' @endif>
                          <div class="font-weight-medium">
                            Completed Sub-Task Today
                          </div>
                          </a>
                          <div class="text-muted">
                          {{  $completed_task }} Tasks
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
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M17 17h-11v-14h-2" />
                            <path d="M6 5l14 1l-1 7h-13" />
                          </svg>
                        </span>
                      </div>
                      <div class="col">
                        <a @if( Session::get('current_revision_freeze')==1)
                        href='{{ route('taskBoard.view', ['list','status'=>'ongoing']) }}' @endif>
                          <div class="font-weight-medium">
                            Ongoing Sub-Task Today
                          </div>
                          <div class="text-muted">
                          {{ $ongoing_task }} Tasks
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
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                              d="M22 4.01c-1 .49 -1.98 .689 -3 .99c-1.121 -1.265 -2.783 -1.335
                               -4.38 -.737s-2.643 2.06 -2.62 3.737v1c-3.245 .083 -6.135 -1.395
                                -8 -4c0 0 -4.182 7.433 4 11c-1.872 1.247 -3.739 2.088 -6 2c3.308 1.803 6.913
                                 2.423 10.034 1.517c3.58 -1.04 6.522 -3.723 7.651 -7.742a13.84 13.84 0 0
                                  0 .497 -3.753c0 -.249 1.51 -2.772 1.818 -4.013z" />
                          </svg>
                        </span>
                      </div>
                      <div class="col">
                        <a @if( Session::get('current_revision_freeze')==1)
                         href='{{ route('taskBoard.view', ['list','status'=>'remaning']) }}' @endif>
                          <div class="font-weight-medium">
                            Remaining Sub-Task Today
                          </div>
                          <div class="text-muted">
                          {{ $total_sub- $completed_task-$ongoing_task }} Tasks
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
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />
                          </svg>
                        </span>
                      </div>
                      <div class="col">
                        <a @if( Session::get('current_revision_freeze')==1)
                         href='{{ route('taskBoard.view', ['list','status'=>'pending']) }}' @endif>
                          <div class="font-weight-medium">
                            Pending Sub-Task Today
                          </div>
                          <div class="text-muted">
                            {{ $notfinished }} Tasks
                          </div>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h3 class="card-title">Task summary</h3>
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
    const data=<?php echo json_encode($alldates)?>;
    const completed=<?php echo json_encode($completed)?>;
    const pending=<?php echo json_encode($pending)?>;
    console.log(pending);
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
        // @formatter:on
  </script>
@include('new_layouts.footer')
