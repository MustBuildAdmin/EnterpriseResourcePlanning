@include('new_layouts.header')
<style>
    .green {
        background-color: #206bc4 !important;
    }
</style>
@php $setting  = Utility::settings(\Auth::user()->creatorId()); @endphp
@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
    <link rel='stylesheet' href='https://unicons.iconscout.com/release/v3.0.6/css/line.css'>

    <div class="page-wrapper dashboard">

        @include('construction_project.side-menu')








        <div class="form-popup1-bg popupnew">
            <div class="form-container">
                <button id="btnCloseForm" class="close-button">X</button>
                <h1>{{ __('Add Member') }}</h1>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 mb-4">
                            <div class="list-group-item px-0">
                                <div class="row ">
                                    <div class="col-auto">
                                        <img src="https://demo.rajodiya.com/erpgo/storage/uploads/avatar/user-11.jpg"
                                            class="wid-40 rounded-circle ml-3" alt="avatar image">
                                    </div>
                                    <div class="col">
                                        <h6 class="mb-0">Protiong</h6>
                                        <p class="mb-0">
                                            <span class="text-success">protiong@teleworm.us</span>
                                        </p>
                                    </div>
                                    <div class="col-auto">
                                        <div class="action-btn bg-info ms-2 invite_usr" data-id="25">
                                            <button type="button" class="mx-3 btn btn-sm  align-items-center">
                                                <span class="btn-inner--visible">
                                                    <i class="ti ti-plus text-white" id="usr_icon_25"></i>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-6 mb-4">
                            <div class="list-group-item px-0">
                                <div class="row ">
                                    <div class="col-auto">
                                        <img src="https://demo.rajodiya.com/erpgo/storage/uploads/avatar/user-11.jpg"
                                            class="wid-40 rounded-circle ml-3" alt="avatar image">
                                    </div>
                                    <div class="col">
                                        <h6 class="mb-0">Protiong</h6>
                                        <p class="mb-0">
                                            <span class="text-success">protiong@teleworm.us</span>
                                        </p>
                                    </div>
                                    <div class="col-auto">
                                        <div class="action-btn bg-info ms-2 invite_usr" data-id="25">
                                            <button type="button" class="mx-3 btn btn-sm  align-items-center">
                                                <span class="btn-inner--visible">
                                                    <i class="ti ti-plus text-white" id="usr_icon_25"></i>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                    <input id="project_id" name="project_id" type="hidden" value="15">
                </div>
            </div>
        </div>




        <div class="form-popup-bg popupnew">
            <div class="form-container">
                <button id="btnCloseForm" class="close-button">X</button>
                <h1>{{ __('Create MileStone') }}</h1>

                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="title" class="form-label">{{ __('Title') }}</label>
                            <input class="form-control" required="required" name="title" type="text" id="title">
                        </div>
                        <div class="form-group  col-md-6">
                            <label for="status" class="form-label">{{ __('Status') }}</label>
                            <select class="form-select" required="required" id="status" name="status">
                                <option value="in_progress">{{ __('In Progress') }}</option>
                                <option value="on_hold">{{ __('On Hold') }}</option>
                                <option value="complete">{{ __('Complete') }}</option>
                                <option value="canceled">{{ __('Canceled') }}</option>
                            </select>
                        </div>
                        <div class="form-group  col-md-6">
                            <label for="start_date" class="col-form-label">{{ __('Start Date') }}</label>
                            <input class="form-control" required="required" name="start_date" type="date" value=""
                                id="start_date">
                        </div>
                        <div class="form-group  col-md-6">
                            <label for="due_date" class="col-form-label">{{ __('Due Date') }}</label>
                            <input class="form-control" required="required" name="due_date" type="date" value=""
                                id="due_date">
                        </div>
                        <div class="form-group  col-md-6">
                            <label for="cost" class="col-form-label">{{ __('Cost') }}</label>
                            <input class="form-control" required="required" stage="0.01" name="cost" type="number"
                                value="" id="cost">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-md-12">
                            <label for="description" class="form-label">{{ __('Description') }}</label>
                            <textarea class="form-control" rows="2" name="description" cols="50" id="description"></textarea>
                        </div>
                    </div>
                    <br />
                    <div class="modal-footer">
                        <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light"
                            data-bs-dismiss="modal">
                        <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">
                    </div>
                </div>
            </div>
        </div>
        {{--
<section id="wrapper">

  <div class="p-4">

    <section class="statistics">
      <div class="row">
        <div class="col-lg-4 bgwhite">
          <div class="box d-flex rounded-2 align-items-center mb-4 mb-lg-0 p-3">
            <i class="uil-list-ul fs-2 text-center green rounded-circle"></i>
            <div class="ms-3">
              <div class="d-flex align-items-center">
                 <span class="d-block">{{__('Total Task')}}</span>
              </div>
              <p class="fs-normal mb-0">{{$project_data['task']['total'] }}</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 bgwhite">
          <div class="box d-flex rounded-2 align-items-center mb-4 mb-lg-0 p-3">
            <<i class="uil-list-ul fs-2 text-center green rounded-circle"></i>
            <div class="ms-3">
              <div class="d-flex align-items-center">
                 <span class="d-block">{{__('Total')}} {{__('Sub Task')}}</span>
              </div>
              <p class="fs-normal mb-0">{{ $total_sub }}</p>
            </div>
          </div>
        </div>
        @if (Auth::user()->type != 'client')
        <div class="col-lg-4 bgwhite">
          <div class="box d-flex rounded-2 align-items-center p-3">
            <i class="uil-list-ul fs-2 text-center green rounded-circle"></i>
            <div class="ms-3">
              <div class="d-flex align-items-center">
                <span class="d-block">{{__('Total')}} {{__('Remaining Days')}}</span>
              </div>
              <p class="fs-normal mb-0">{{ $remaining_working_days }}</p>
            </div>
          </div>
        </div>
        @else
          <div class="col-lg-4 col-md-6"></div>
        @endif
      </div>
      <br>
      <div class="row">
        <div class="col-lg-4 bgwhite">
            <div class="box d-flex rounded-2 align-items-center p-3">
              <i class="uil-list-ul fs-2 text-center green rounded-circle"></i>
              <div class="ms-3">
                <div class="d-flex align-items-center">
                  <span class="d-block">Workdone % Productivity</span>
                </div>
                <br>
                <p class="fs-normal mb-0">{{ $workdone_percentage }}%</p>
              </div>
            </div>
        </div>
        <div class="col-lg-4 bgwhite">
            <div class="box d-flex rounded-2 align-items-center p-3">
              <i class="uil-list-ul fs-2 text-center green rounded-circle"></i>
              <div class="ms-3">
                <div class="d-flex align-items-center">
                  <span class="d-block">Task not started even after<br>planned start date<br>No.of Task:</span>
                </div>
                <br>
                <p class="fs-normal mb-0" @if ($not_started != 0) style='color:red;' @endif>{{ $not_started }}</p>
              </div>
            </div>
        </div>
        <div class="col-lg-4 bgwhite">
            <div class="box d-flex rounded-2 align-items-center mb-4 mb-lg-0 p-3">
              <i class="uil-list-ul fs-2 text-center green rounded-circle"></i>
              <div class="ms-3">
                <div class="d-flex align-items-center">
                   <span class="d-block">Task in progress even after<br>planned end date<br>No.of.Tasks</span>
                </div>
                <p class="fs-normal mb-0 align-items-center" @if ($not_started != 0) style='color:red;' @endif>{{$notfinished }}</p>
              </div>
            </div>
        </div>
      </div>
    </section> --}}
        <br />



        <section class="container">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h2>{{ __('Project Dashboard') }}</h2>
                </div>
                <div class="col-md-6">
                    <div class="float-end icons">
                        {{-- @can('view grant chart')
          <a href="{{ route('projects.gantt',$project->id) }}" class="btn btn-sm btn-primary">
              {{__('Gantt Chart')}}
          </a>
      @endcan --}}

                        {{-- @can('view expense')
          <a href="{{ route('projects.expenses.index',$project->id) }}" class="btn btn-sm btn-primary">
              {{__('Expense')}}
          </a>
      @endcan
      <a href="{{ route('project_report.view_task_report',$project->id) }}" class="btn btn-sm btn-primary">
        {{__('Report')}}
      </a> --}}

                        {{-- @if ($setting['company_type'] != 2)
          @can('manage bug report')
              <a href="{{ route('task.bug',$project->id) }}" class="btn btn-sm btn-primary">
                  {{__('Bug Report')}}
              </a>
          @endcan
          @if (\Auth::user()->type != 'client' || \Auth::user()->type == 'client')
          <a href="{{ route('projecttime.tracker',$project->id) }}" class="btn btn-sm btn-primary">
              {{__('Tracker')}}
          </a>
          @endif
          @can('create project task')
          <a href="{{ route('projects.tasks.index',$project->id) }}" class="btn btn-sm btn-primary">
              {{__('Task')}}
          </a>
          @endcan
          @if (\Auth::user()->type != 'client')
          @can('view timesheet')
              <a href="{{ route('timesheet.index',$project->id) }}" class="btn btn-sm btn-primary">
                  {{__('Timesheet')}}
              </a>
          @endcan
          @endif
      @endif --}}

                        {{-- @can('edit project')
          <a href="#" data-size="lg" data-url="{{ route('projects.edit', $project->id) }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Edit Project')}}" class="btn btn-sm btn-primary">
              <i class="ti ti-pencil"></i>
          </a>
      @endcan --}}
                        <div class="col-auto ms-auto d-print-none">
                            <div class="input-group-btn">
                                <a href="{{ route('construction_main') }}" class="btn btn-danger"
                                    data-bs-toggle="tooltip" title="{{ __('Back') }}">
                                    <span class="btn-inner--icon"><i class="fa fa-arrow-left"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-4 bgwhite">

                    <div class="card" style="height: 352px;">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar me-3">
                                    <img {{ $project->img_image }} alt="" class="img-user wid-45 rounded-circle">
                                </div>
                                <div class="d-block  align-items-center justify-content-between w-100">
                                    <div class="mb-3 mb-sm-0">
                                        <h5 class="mb-1"> {{ $project->project_name }}</h5>
                                        <p class="mb-0 text-sm">
                                        <div class="progress-wrapper">
                                            <span
                                                class="progress-percentage">{{ __('Workdone % Productivity As of Today') }}
                                                : {{ round($workdone_percentage) }} %</span>
                                            <div class="progress progress-xs mt-2">
                                                <div class="progress-bar bg-info" role="progressbar"
                                                    aria-valuenow="{{ round($workdone_percentage) }}" aria-valuemin="0"
                                                    aria-valuemax="100"
                                                    style="width: {{ round($workdone_percentage) }}%;"></div>
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
                                            <span class="text-white text-sm">{{ __('Start Date') }}</span>
                                            <h5 class="text-white text-nowrap">
                                                {{ Utility::getDateFormated($project->start_date) }}</h5>
                                        </div>
                                        <div class="row align-items-center">
                                            <span class="text-white text-sm">{{ __('End Date') }}</span>
                                            <h5 class="text-white text-nowrap">
                                                {{ Utility::getDateFormated($project->end_date) }}</h5>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <span class="text-white text-sm">{{ __('Client') }}</span>
                                        <h5 class="text-white text-nowrap">
                                            {{ !empty($project->client) ? $project->client->name : '-' }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 bgwhite">
                    <div class="card">
                        <div class="card">
                            <div class="card-body" style='min-height: 72px !important;'>
                                <div class="d-flex align-items-start">
                                    <div class="theme-avtar bg-primary">
                                        <i class="ti ti-clipboard-list"></i>
                                    </div>
                                    <div class="ms-3">
                                        <p class="text-muted mb-0">{{ __('Project Task status') }}</p>
                                        {{-- <h4 class="mb-0">{{ $project_data['task_chart']['total'] }}</h4> --}}

                                    </div>
                                </div>

                            </div>

                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="d-flex align-items-center">
                                        <span class="text-muted">{{ __('Total Project Task') }}</span>
                                    </div>
                                    <span>{{ $project_data['task']['total'] }}</span>
                                </div>
                                <hr>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="d-flex align-items-center">

                                        <span class="text-muted">{{ __('Total Project Sub-Task') }}</span>
                                    </div>
                                    <span>{{ $total_sub }}</span>
                                </div>
                                <hr>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="d-flex align-items-center">

                                        <span class="text-muted">{{ __('Completed Sub-Task as of Today') }}</span>
                                    </div>
                                    <span>{{ $completed_task }}</span>
                                </div>
                                <hr>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="d-flex align-items-center">

                                        <span class="text-muted">{{ __('Ongoing Sub-Task as of Today') }}</span>
                                    </div>
                                    <span>{{ $ongoing_task }}</span>
                                </div>
                                <hr>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="d-flex align-items-center">

                                        <span class="text-muted">{{ __('Remaining Sub-Task as of Today') }}</span>
                                    </div>

                                    <span>{{ $total_sub - $completed_task - $ongoing_task }}</span>
                                </div>
                                <hr>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="d-flex align-items-center">

                                        <span class="text-muted">Task not started even after<br>planned start date</span>
                                    </div>
                                    <span
                                        @if ($not_started) style='color:red;' @endif>{{ $not_started }}</span>
                                </div>
                                <hr>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="d-flex align-items-center">

                                        <span class="text-muted">Task in progress even after<br>planned end date</span>
                                    </div>
                                    <span
                                        @if ($notfinished) style='color:red;' @endif>{{ $notfinished }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($project->freeze_status == 1)
                    <div class="col-lg-4 bgwhite">
                        <div class="card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-start">
                                        <div class="theme-avtar bg-primary">
                                            <i class="ti ti-clipboard-list"></i>
                                        </div>
                                        <div class="ms-3">
                                            <p class="text-muted mb-0">{{ __('Project Progress Status As of Today') }}</p>
                                            {{-- <h4 class="mb-0">{{ $project_data['task_chart']['total'] }}</h4> --}}

                                        </div>
                                    </div>
                                    <div id="task_chart"></div>
                                </div>

                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="d-flex align-items-center">
                                            <span class="text-muted">{{ __('Total Days Completed to Date') }}</span>
                                        </div>
                                        <span>{{ $project_data['day_left']['day'] }}</span>
                                        {{-- <span>{{ $remaining_working_days }}</span> --}}

                                    </div>
                                    <div class="progress mb-3">
                                        <div class="progress-bar bg-primary"
                                            style="width: {{ $project_data['day_left']['percentage'] }}%"></div>
                                    </div>

                                    <hr>
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="d-flex align-items-center">

                                            <span class="text-muted">{{ __('Planned Progress') }}</span>
                                        </div>
                                        <span>{{ round($current_Planed_percentage) }}%</span>


                                    </div>

                                    <div class="progress mb-3">
                                        <div class="progress-bar bg-primary"
                                            style="width: {{ round($current_Planed_percentage) }}%"></div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="d-flex align-items-center">

                                            <span class="text-muted">{{ __('Actual Progress') }}</span>
                                        </div>
                                        <span>{{ round($actual_percentage) }}%</span>


                                    </div>

                                    <div class="progress mb-3">
                                        <div class="progress-bar bg-primary"
                                            style="width: {{ round($actual_percentage) }}%"></div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="d-flex align-items-center">

                                            <span class="text-muted">{{ __('Delay in progress') }}</span>
                                        </div>
                                        @php
                                            $delay = round($current_Planed_percentage - $actual_percentage);
                                            if ($delay < 0) {
                                                $delay = 0;
                                            }
                                            if ($delay > 100) {
                                                $delay = 100;
                                            }
                                        @endphp
                                        <span
                                            @if ($delay > 0) style='color:red;' @endif>{{ $delay }}%</span>


                                    </div>

                                    <div class="progress mb-3">
                                        <div class="progress-bar bg-primary" style="width: {{ round($delay) }}%"></div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="d-flex align-items-center">

                                            <span class="text-muted">{{ __('Actual Remaining Progress') }}</span>
                                        </div>
                                        <span>{{ round(100 - $actual_percentage) }}%</span>


                                    </div>

                                    <div class="progress mb-3">
                                        <div class="progress-bar bg-primary"
                                            style="width: {{ round(100 - $actual_percentage) }}%"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-lg-4 bgwhite">
                    <div class="card">
                        <div class="card-header">
                            <div class="headingnew align-items-center justify-content-between">
                                <h5>{{ __('Members') }}</h5> @can('edit project')
                                    <div class="float-end">
                                        <a href="#" data-size="lg"
                                            data-url="{{ route('invite.project.member.view', $project->id) }}"
                                            data-ajax-popup="true" data-bs-toggle="tooltip" title=""
                                            class="btn btn-sm btn-primary" data-bs-original-title="{{ __('Add Member') }}">
                                            <i class="ti ti-plus"></i>
                                        </a>
                                    </div>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush list" id="project_users"></ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 mb-6 mb-md-0">
                    @can('view activity')

                        <div class="card activity-scroll">
                            <div class="card-header">
                                <h5>{{ __('Activity Log') }}</h5>
                                <small>{{ __('Activity Log of this project') }}</small>
                            </div>
                            <div class="card-body vertical-scroll-cards">
                                @foreach ($project->activities as $activity)
                                    <div class="card p-2 mb-2">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="theme-avtar bg-primary">
                                                    <i class="ti ti-{{ $activity->logIcon($activity->log_type) }}"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <h6 class="mb-0">{{ __($activity->log_type) }}</h6>
                                                    <p class="text-muted text-sm mb-0">{!! $activity->getRemark() !!}</p>
                                                </div>
                                            </div>
                                            <p class="text-muted text-sm mb-0">{{ $activity->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endcan

                </div>
            </div>
        </section>


        <div class="row">


            {{-- <div class="col-md-6 col-lg-6 mb-6 mb-lg-0"> --}}
            {{-- <div class="card">
    <div class="card-header">
      <div class="headingnew align-items-center justify-content-between">
        <h5>{{__('Members')}}</h5> @can('edit project') <div class="float-end">
          <a href="#" data-size="lg" data-url="{{ route('invite.project.member.view', $project->id) }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary" data-bs-original-title="{{__('Add Member')}}">
            <i class="ti ti-plus"></i>
          </a>
        </div> @endcan
      </div>
    </div>
    <div class="card-body">
      <ul class="list-group list-group-flush list" id="project_users"></ul>
    </div>
  </div> --}}
            {{-- </div> --}}







        </div>


        <section class="statis  text-center main2">
            <div class="row">

                <div class="col-md-6 col-lg-6 mb-6 mb-lg-0">

                </div>


            </div>
        </section>




    </div>
    </section>


    <div class="row">
        <div class="col-md-6">
        </div>
        <div class="col-md-6">
        </div>
    </div>



    </div>
    </div>
    </div>
    </div>
    @include('new_layouts.footer')

    <script>
        // (function () {
        //     var options = {
        //         chart: {
        //             type: 'area',
        //             height: 60,
        //             sparkline: {
        //                 enabled: true,
        //             },
        //         },
        //         colors: ["#ffa21d"],
        //         dataLabels: {
        //             enabled: false
        //         },
        //         stroke: {
        //             curve: 'smooth',
        //             width: 2,
        //         },
        //         series: [{
        //             name: 'Bandwidth',
        //             data:{{ json_encode(array_map('intval', $project_data['timesheet_chart']['chart'])) }}
        //         }],

        //         tooltip: {
        //             followCursor: false,
        //             fixed: {
        //                 enabled: false
        //             },
        //             x: {
        //                 show: false
        //             },
        //             y: {
        //                 title: {
        //                     formatter: function (seriesName) {
        //                         return ''
        //                     }
        //                 }
        //             },
        //             marker: {
        //                 show: false
        //             }
        //         }
        //     }
        //     var chart = new ApexCharts(document.querySelector("#timesheet_chart"), options);
        //     chart.render();
        // })();

        (function() {
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
                    data: {{ json_encode($project_data['task_chart']['chart']) }}
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
                            formatter: function(seriesName) {
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

        $(document).ready(function() {
            loadProjectUser();
            $(document).on('click', '.invite_usr', function() {
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
                    success: function(data) {
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
            var project_id = '{{ $project->id }}';

            $.ajax({
                url: '{{ route('project.user') }}',
                data: {
                    project_id: project_id
                },
                beforeSend: function() {
                    $('#project_users').html(
                        '<tr><th colspan="2" class="h6 text-center pt-5">{{ __('Loading...') }}</th></tr>');
                },
                success: function(data) {
                    mainEle.html(data.html);
                    $('[id^=fire-modal]').remove();
                    // loadConfirm();
                }
            });
        }
    </script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>

    <script>
        function closeForm() {
            $('.form-popup-bg').removeClass('is-visible');

            $('.form-popup1-bg').removeClass('is-visible');
        }

        $(document).ready(function($) {

            /* Contact Form Interactions */
            $('#btnOpenForm').on('click', function(event) {
                event.preventDefault();

                $('.form-popup-bg').addClass('is-visible');
            });

            //close popup when clicking x or off popup
            $('.form-popup-bg').on('click', function(event) {
                if ($(event.target).is('.form-popup-bg') || $(event.target).is('#btnCloseForm')) {
                    event.preventDefault();
                    $(this).removeClass('is-visible');
                }
            });



            /* Contact Form Interactions */
            $('#btnOpenForm2').on('click', function(event) {
                event.preventDefault();

                $('.form-popup1-bg').addClass('is-visible');
            });

            //close popup when clicking x or off popup
            $('.form-popup1-bg').on('click', function(event) {
                if ($(event.target).is('.form-popup1-bg') || $(event.target).is('#btnCloseForm')) {
                    event.preventDefault();
                    $(this).removeClass('is-visible');
                }
            });



        });
    </script>
