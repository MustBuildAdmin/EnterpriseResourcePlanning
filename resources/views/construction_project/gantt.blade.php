@include('new_layouts.header')
{{-- @extends('layouts.admin') --}}
<!-- css link starts -->
<link href="{{ asset('assets/js/css/dhtmlxgantt.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/js/gantt/common/controls_styles.css') }}">
<link href="{{ asset('assets/js/css/tabler.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/js/css/demo.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/js/css/tabler-vendors.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto:regular,medium,thin,bold">
<!-- token input css link starts -->
<link rel="stylesheet" href="{{ asset('tokeninput/tokeninput.css') }}" />
<!-- token input css link end -->
<!-- css link ends -->

<!-- css starts -->
<style type="text/css">
    .gantt_task_line {
        background-color: rgb(0 84 166 / 75%);
    }

    .gantt_critical_task {
        background-color: #e63030 !important;
    }

    .gantt_task_progress {
        background-color: rgb(0 84 166 / 100%);
    }

    .gantt-container {
        display: flex;
        flex-flow: column;
        height: 80vh;
    }

    .gantt_task_cell.week_end {
        background-color: #EFF5FD;
    }

    .gantt_task_row.gantt_selected .gantt_task_cell.week_end {
        background-color: #F8EC9C;
    }

    .slack {
        position: absolute;
        border-radius: 0;
        opacity: 0.7;
        border: none;
        border-right: 1px solid #b6b6b6;
        margin-left: -2px;
        background: #b6b6b6;
        background: repeating-linear-gradient(45deg, #FFFFFF,
                #48aad1 5px,
                #b6b6b6 5px,
                #b6b6b6 10px);
    }

    .subnav>.container-fluid>.navbar-nav>ul>li>a>span {
        color: #fff !important;
    }

    .baseline {
        position: absolute;
        border-radius: 2px;
        opacity: 0.6;
        margin-top: -7px;
        height: 12px;
        background: #ffd180;
        border: 1px solid rgb(255, 153, 0);
    }

    /*
        .gantt_task_line, .gantt_line_wrapper {
        margin-top: -9px;
        } */
    .gantt_side_content {
        margin-bottom: 7px;
    }

    .gantt_task_link .gantt_link_arrow {
        margin-top: -10px
    }

    .gantt_side_content.gantt_right {
        bottom: 0;
    }
</style>
<!-- css ends -->

<!-- script js starts -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/js/dhtmlxgantt.js') }}"></script>
<script src="{{ asset('assets/js/js/tabler.min.js') }}"></script>
<script src="{{ asset('assets/js/js/demo-theme.min.js') }}"></script>
<script src="{{ asset('assets/nouislider/dist/nouislider.js') }}"></script>
<script src="{{ asset('assets/litepicker/dist/litepicker.js') }}"></script>
<script src="{{ asset('assets/tom-select/dist/js/tom-select.popular.min.js') }}"></script>
{{-- <script src="https://export.dhtmlx.com/gantt/api.js"
integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script> --}}
<script src="{{ asset('assets/js/js/Chart.min.js') }}"></script>
<script src="{{ asset('assets/js/js/zoomingConfig.js') }}"></script>
<script src="{{ asset('assets/js/js/criticalPath.js') }}"></script>
<script src="{{ asset('assets/js/js/overlay.js') }}"></script>
<script src="{{ asset('assets/js/js/export.js') }}"></script>
{{-- <script src="{{asset('assets/js/js/lightBox.js')}}"></script> --}}
<script src="{{ asset('assets/js/js/expandAndCollapse.js') }}"></script>
<script src="{{ asset('assets/js/js/taskPostion.js') }}"></script>
<script src="{{ asset('assets/js/js/slack.js') }}"></script>
<script src="{{ asset('assets/js/js/dynamicProgress.js') }}"></script>
<script src="{{ asset('assets/js/js/taskText.js') }}"></script>
<script src="{{ asset('assets/js/js/highlight.js') }}"></script>
<script src="{{ asset('assets/js/js/slackrow.js') }}"></script>
<script src="{{ asset('tokeninput/jquery.tokeninput.js') }}"></script>
<!-- script js ends -->
@php
    $holidays = [];

    foreach ($project_holidays as $key => $value) {
        // $time = strtotime($value->date);
        $holidays[] = date('Y,m,d', strtotime($value->date));
    }

    $holidays = implode(':', $holidays);
@endphp
@include('construction_project.side-menu')
<div class="text-center container container-slim py-4 loader_show">
    <div class="mb-3">
        <a href="." class="navbar-brand navbar-brand-autodark">
            <img src="./static/logo-small.svg" height="36" alt="">
        </a>
    </div>
    <div class="text-secondary mb-3">{{ __('Loading') }}</div>
    <div class="progress progress-sm">
        <div class="progress-bar progress-bar-indeterminate"></div>
    </div>
</div>
<div id="additional_elements" class="page d-none">

    <div class="gantt-container" id="gantt-block">
        <header class="navbar navbar-expand-md  d-print-none" data-bs-theme="light">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
                    aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    {{ $projectname }} - {{session::get('current_revision_name')}}
                </h1>
                <div class="d-flex flex-column flex-md-row flex-fill
                            align-items-stretch align-items-md-center"
                    id="sidebar-menu">
                    <!-- top nav menu list  starts-->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link undo_action" onclick="gantt.undo();">{{ __('Undo') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link redo_action" onclick="gantt.redo();">{{ __('Redo') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" onclick="zoomIn()">{{ __('Zoom In') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" onclick="zoomOut()">{{ __('Zoom Out') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" onclick="today_scroll()">{{ __('Today') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" onclick="gantt.ext.fullscreen.toggle()">{{ __('FullScreen') }}</a>
                        </li>
                        <li>
                            <a class="nav-link">
                                <select class="form-select gantt_zoom_select"
                                    style="width: 100px;height: 29px;margin-top: 2%;padding: 2px 20px 0px 10px;">
                                    <option value="day">{{ __('Daily') }}</option>
                                    <option value="week">{{ __('Weekly') }}</option>
                                    <option value="month">{{ __('Monthly') }}</option>
                                    <option value="quarter">{{ __('Quaterly') }}</option>
                                    <option value="year">{{ __('Yearly') }}</option>
                                </select>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#edit-base" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" role="button" aria-expanded="false">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/package -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"></path>
                                        <path d="M12 12l8 -4.5"></path>
                                        <path d="M12 12l0 9"></path>
                                        <path d="M12 12l-8 -4.5"></path>
                                        <path d="M16 5.25l-8 4.5"></path>
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    {{ __('Edit') }}
                                </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <a href="#" class="dropdown-item action indent_action" id="indent"
                                            onclick="gantt.performAction('Indent')">
                                            <!-- Download SVG icon from http://tabler-icons.io/i/activity -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon"
                                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M3 12h4l3 8l4 -16l3 8h4"></path>
                                            </svg>
                                            {{ __('Indent') }}
                                        </a>
                                        <a href="#" class="dropdown-item action outdent_action" id="outdent"
                                            onclick="expandAll();">
                                            <!-- Download SVG icon from http://tabler-icons.io/i/activity -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon"
                                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M3 12h4l3 8l4 -16l3 8h4"></path>
                                            </svg>
                                            {{ __('Outdent') }}
                                        </a>
                                        <div class="dropdown-divider"></div>
                                    </div>
                                </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" role="button" aria-expanded="false">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/package -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"></path>
                                        <path d="M12 12l8 -4.5"></path>
                                        <path d="M12 12l0 9"></path>
                                        <path d="M12 12l-8 -4.5"></path>
                                        <path d="M16 5.25l-8 4.5"></path>
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    {{ __('View') }}
                                </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <a href="#" class="dropdown-item" onclick="collapseAll()">
                                            <!-- Download SVG icon from http://tabler-icons.io/i/activity -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon"
                                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M3 12h4l3 8l4 -16l3 8h4"></path>
                                            </svg>
                                            {{ __('Expand All') }}
                                        </a>
                                        <a href="#" class="dropdown-item" onclick="expandAll();">
                                            <!-- Download SVG icon from http://tabler-icons.io/i/activity -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon"
                                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M3 12h4l3 8l4 -16l3 8h4"></path>
                                            </svg>
                                            {{ __('Collapse All') }}
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <label class="dropdown-item form-switch">
                                            <input class="form-check-input m-0 me-2"
                                                onchange="updateCriticalPath(this)" type="checkbox">
                                            {{ __('Critical Path') }}
                                        </label>
                                        <label class="dropdown-item form-switch">
                                            <input class="form-check-input m-0 me-2" onchange="toggleSlack(this)"
                                                type="checkbox">{{ __('Show Slack') }}
                                        </label>
                                    </div>
                                </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" role="button" aria-expanded="false">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/package -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"></path>
                                        <path d="M12 12l8 -4.5"></path>
                                        <path d="M12 12l0 9"></path>
                                        <path d="M12 12l-8 -4.5"></path>
                                        <path d="M16 5.25l-8 4.5"></path>
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    {{ __('Hide and Show Grid Columns') }}
                                </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column" id="gantt-columns">
                                    </div>
                                </div>
                        </li>
                        <li class="nav-item dropdown">
                            {{-- {{ Form::open(['route' => ['projects.freeze_status'], 'method' => 'POST',
                            'id' => 'gantt_chart_submit']) }}

                            {{ Form::hidden('project_id', $project->id, ['class' => 'form-control']) }}
                            <a href="#" class="nav-link freeze_button" style='width: 100%;'
                                data-bs-toggle="tooltip" title="{{ __('Click to save') }}"
                                data-original-title="{{ __('Delete') }}"
                                data-confirm="{{ __('Are You Sure?') . '|'
                                . __('This action can not be undone. Do you want to continue?') }}"
                                data-confirm-yes="document.getElementById('delete-form-{{ $project->id }}').submit();">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"></path>
                                    <path d="M12 12l8 -4.5"></path>
                                    <path d="M12 12l0 9"></path>
                                    <path d="M12 12l-8 -4.5"></path>
                                    <path d="M16 5.25l-8 4.5"></path>
                                </svg>
                                <span class="nav-link-title">
                                    {{ __('Save') }}
                                    {!! Form::close() !!}
                                </span>

                            </a>
                        </li> --}}
                        <a href="#"  class="nav-link freeze_button" data-bs-toggle="modal"
                         data-bs-target="#modal-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                               viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                               stroke-linecap="round" stroke-linejoin="round">
                               <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                               <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"></path>
                               <path d="M12 12l8 -4.5"></path>
                               <path d="M12 12l0 9"></path>
                               <path d="M12 12l-8 -4.5"></path>
                               <path d="M16 5.25l-8 4.5"></path>
                            </svg>
                            {{ __('Save') }}
                         </a>
                    </ul>
                    <!-- top nav menu list ends-->
                </div>
        </header>
        <div class="h-100 w-100" id="gantt_here"></div>
    </div>

    <!-- custom lightbox starts-->
    <div class="modal modal-blur fade" id="modal-task" tabindex="-1" style="display: none;" aria-hidden="true"
        role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"id="task-title">{{ __('New Task') }}</h5>
                    <button type="button" id="close" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close" name="close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('Task Name') }}</label>
                        <input type="hidden" id="user_id" name="user_id">
                        <input type="hidden" id="reporter_id" name="reporter_id">
                        <input type="text" class="form-control" name="description"
                            placeholder="{{ __('Type your Task Name') }}">
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6 col-12">
                            <label class="form-label">{{ __('Task Start Date') }}</label>
                            <input type="text" class="form-control" name="start_date" id="start-date"
                                placeholder="{{ __('Enter Your Task Start Date') }}">
                        </div>
                        <div class="col-md-6  col-12">
                            <label class="form-label">{{ __('Task End Date') }}</label>
                            <input type="text" class="form-control" name="end_date" id="end-date"
                                placeholder="{{ __('Enter Your Task End Date') }}">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6 col-12">
                            <label class="form-label">{{ __('Assignee') }}</label>
                            <input type="text" id="taskassignee" name="users"
                                value="{{ request()->get('q') }}" required>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6 col-12">
                            <label class="form-label">{{ __('Reporting To') }}</label>
                            <input type="text" class="form-control" name="reported_to" id="task-reporting"
                                placeholder="{{ __('Search your Reporting to') }}">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="mb-3">
                            <div class="form-label">{{ __('Task Assignment Mode') }}</div>
                            <div>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="Assignment" checked="">
                                    <span class="form-check-label">{{ __('Self Task') }}</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="Assignment">
                                    <span class="form-check-label">{{ __('Sub Contract Task') }}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6 col-12">
                            <label class="form-label">{{ __('SubContractor') }}</label>
                            <input type="text" class="form-control" name="subcontractor" id="sub-contractor"
                                placeholder="Search your  subcontractor">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-link link-secondary" id="cancel" data-bs-dismiss="modal">
                        {{ __('Cancel') }}
                    </a>
                    <a href="#" class="btn btn-primary ms-auto" id="save" data-bs-dismiss="modal">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 5l0 14"></path>
                            <path d="M5 12l14 0"></path>
                        </svg>
                        {{ __('Add new Task') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- custom lightbox ends-->

    <!-- Delete Confirmation starts-->
<div class="modal modal-blur fade" id="modal-warning" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
       <div class="modal-content">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="modal-status btn-warning"></div>
          <div class="modal-body text-center py-4">
             <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
             <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg"
                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M12 9v4" />
                <path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0
                   1.636 2.871h16.214a1.914 1.914 0 0 0 1.636
                   -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z" />
                <path d="M12 16h.01" />
             </svg>
             <h3>{{ __('Are you sure?') }}</h3>
             <div class="text-secondary">{{ __('This action is IRREVERSIBLE.') }}</div>
             <div class="text-secondary">{{ __('Do you want to continue?') }}</div>
          </div>
          <div class="modal-footer">
             <div class="w-100">
                <div class="row">
                   <div class="col">
                      <a href="#" id="confirm_del_no" class="btn w-100" data-bs-dismiss="modal">
                      {{ __('No') }}
                      </a>
                   </div>
                   <div class="col">
                      <a href="#" id="confirm_del_yes" class="btn btn-danger w-100" data-bs-dismiss="modal">
                      {{ __('Yes') }}
                      </a>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>
 <!-- Delete Confirmation ends-->
 
 <!-- Suc alert starts-->
 <div class="modal modal-blur fade" id="modal-success" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
       <div class="modal-content">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="modal-status bg-success"></div>
          <div class="modal-body text-center py-4">
             <!-- Download SVG icon from http://tabler-icons.io/i/circle-check -->
             <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-green icon-lg"
              width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
               stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                <path d="M9 12l2 2l4 -4" />
             </svg>
             <h3>{{ __('Success') }}</h3>
             <div class="text-secondary">{{ __('Baseline Status successfully changed.') }}</div>
          </div>
          <div class="modal-footer">
             <div class="w-100">
                <div class="row">
                   <div class="col">
                      <a href="#" id="confirm_ok" class="btn w-100" data-bs-dismiss="modal">
                        {{ __('Ok') }}
                      </a>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>
 <!-- Suc alert ends-->
</div>

<input type='hidden' id='weekends' value='{{ $nonWorkingDay }}'>
<input type='hidden' id='holidays' value='{{ $holidays }}'>
<input type='hidden' id='frezee_status' value='{{ $freezeCheck->freeze_status }}'>
<input type='hidden' id='critical_update' value='{{ $critical_update }}'>



<script type="text/javascript">
    var tempcsrf = '{!! csrf_token() !!}';

    // check freeze status #############################

    var frezee_status_actual = $('#frezee_status').val();
    if (frezee_status_actual == '1') {
        gantt.config.readonly = true;
        $('.freeze_button').addClass('disabled');
        $('.undo_action').addClass('disabled');
        $('.redo_action').addClass('disabled');
        $('.indent_action').addClass('disabled');
        $('.outdent_action').addClass('disabled');
    } else {
        gantt.config.readonly = false;
        $('.freeze_button').removeClass('disabled');
        $('.undo_action').removeClass('disabled');
        $('.redo_action').removeClass('disabled');
        $('.indent_action').removeClass('disabled');
        $('.outdent_action').removeClass('disabled');
    }

    // check the data is empty #############################
    $.post("{{ route('projects.get_gantt_task_count') }}", {
            _token: tempcsrf,
            project_id: {{ $project->id }}
        },
        function(resp, textStatus, jqXHR) {
            if (resp == 0) {
                $('.freeze_button').addClass('disabled');
                $('.undo_action').addClass('disabled');
                $('.redo_action').addClass('disabled');
                $('.indent_action').addClass('disabled');
                $('.outdent_action').addClass('disabled');
            }
        });
    // end ###############################################

        
    // delete confirmation show  #############################
    $(document).on("click", "#confirm_del_yes", function () {
        $("#modal-success").modal('show');
        var project_id = {{ $project->id }};
        $.ajax({
            url: "{{route('projects.freeze_status')}}",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),project_id: project_id
            },
            type: 'POST',
            success: function(response) {
                    location.reload();
            },
            error: function(response) {
                    show_toastr('error', response.error, 'error');
            }
        })
    });
    // delete confirmation show  #############################

    // delete confirmation hide  #############################
    $(document).on("click", "#confirm_del_no", function () {

        $("#confirm_del_yes").modal('hide');

    });
    // delete confirmation hide  #############################


    function setScaleConfig(level) {
        switch (level) {
            case "day":
                gantt.config.scales = [{
                    unit: "day",
                    step: 1,
                    format: "%d %M"
                }];
                gantt.config.scale_height = 27;
                break;
            case "week":
                var weekScaleTemplate = function(date) {
                    var dateToStr = gantt.date.date_to_str("%d %M");
                    var endDate = gantt.date.add(gantt.date.add(date, 1, "week"), -1, "day");
                    return dateToStr(date) + " - " + dateToStr(endDate);
                };
                gantt.config.scales = [{
                        unit: "week",
                        step: 1,
                        format: weekScaleTemplate
                    },
                    {
                        unit: "day",
                        step: 1,
                        format: "%D"
                    }
                ];
                gantt.config.scale_height = 50;
                break;
            case "month":
                gantt.config.scales = [{
                        unit: "month",
                        step: 1,
                        format: "%F, %Y"
                    },
                    {
                        unit: "day",
                        step: 1,
                        format: "%j, %D"
                    }
                ];
                gantt.config.scale_height = 50;
                break;
            case "quarter":

                gantt.config.scales = [{
                        unit: "month",
                        step: 1,
                        format: "%M"
                    },
                    {
                        unit: "quarter",
                        step: 1,
                        format: function(date) {
                            var dateToStr = gantt.date.date_to_str("%M");
                            var endDate = gantt.date.add(gantt.date.add(date, 3, "month"), -1, "day");
                            return dateToStr(date) + " - " + dateToStr(endDate);
                        }
                    }
                ]
                gantt.config.scale_height = 50;
                break;
            case "year":
                gantt.config.scales = [{
                        unit: "year",
                        step: 1,
                        format: "%Y"
                    },
                    {
                        unit: "month",
                        step: 1,
                        format: "%M"
                    }
                ];
                gantt.config.scale_height = 90;
                break;
        }
    }

    var els = document.querySelectorAll(".gantt_zoom_select");
    for (var i = 0; i < els.length; i++) {
        els[i].onchange = function(e) {
            var el = e.target;
            var value = el.value;
            setScaleConfig(value);
            gantt.render();
        };
    };
</script>
<script>
    gantt.plugins({
        click_drag: true,
        auto_scheduling: true,
        critical_path: true,
        drag_timeline: true,
        overlay: true,
        export_api: true,
        fullscreen: true,
        grouping: true,
        keyboard_navigation: true,
        multiselect: true,
        quick_info: true,
        tooltip: true,
        undo: true,
        marker: true
    });
    gantt.config.branch_loading = true;
    gantt.config.show_empty_state = true;
    gantt.config.work_time = true;
    gantt.config.auto_types = true;
    gantt.config.details_on_create = false;
    gantt.config.keep_grid_width = false;
    gantt.config.grid_resize = true;
    gantt.config.duration_unit = "day";
    gantt.config.row_height = 30;
    gantt.config.min_column_width = 40;
    gantt.config.order_branch = true;
    gantt.config.order_branch_free = true;
    gantt.config.sort = true;
    gantt.locale.labels.baseline_enable_button = 'Set';
    gantt.locale.labels.baseline_disable_button = 'Remove';
    gantt.templates.timeline_cell_class = function(task, date) {
        if (!gantt.isWorkTime(date))
            return "week_end";
        return "";
    };

    // auto schedule before
    // progress end
    gantt.config.auto_scheduling = true;
    gantt.config.auto_scheduling_strict = true;
    gantt.config.auto_scheduling_compatibility = true;
    var workflag = 0;
    var autoload = 0;
    gantt.attachEvent("onBeforeAutoSchedule", function() {
        var check_cri = $('#critical_update').val();
        if (check_cri == 0) {
            var tasks = gantt.getTaskByTime();
            const critical_task = new Array();
            const updatedTask = new Array();
            if (workflag == 0) {
                for (var i = 0; i < tasks.length; i++) {

                    const task = gantt.getTask(tasks[i].id);
                    const tt = gantt.isCriticalTask(task);
                    // const totalStack = gantt.getTotalSlack(task);
                    // const freeSlack = gantt.getFreeSlack(task)
                    // const constraintType = gantt.getConstraintType(task);
                    const taskdetails = {
                        ...task,
                        isCriticalTask: gantt.isCriticalTask(task),
                        totalStack: gantt.getTotalSlack(task),
                        freeSlack: gantt.getFreeSlack(task),
                        constraintType: gantt.getConstraintType(task),
                    }


                    updatedTask.push(taskdetails);

                };
             
                workflag = 1;
                $.ajax({
                    url: '{{ route('projects.criticaltask_update') }}',
                    type: 'get',
                    data: {
                        'updatedTask': updatedTask,
                    },
                    success: function(data) {

                    }
                });

            }
        }

        return true;
    });
    gantt.attachEvent("onAfterTaskAutoSchedule", function(task, new_date, constraint, predecessor) {

    });

    // end autoschedule before ##########################################################################




    gantt.ext.fullscreen.getFullscreenElement = function() {
        return document.getElementById("gantt-block");
    }
    gantt.init("gantt_here");

    setTimeout(
        function() {
            gantt.load("{{ route('projects.gantt_data', [$project->id]) }}");
            $('.loader_show').hide();
            $('#additional_elements').removeClass("d-none");
        }, 3000);
</script>


<script>
    (function() {

        function shiftTask(task_id, direction) {
            var task = gantt.getTask(task_id);
            task.start_date = gantt.date.add(task.start_date, direction, "day");
            task.end_date = gantt.calculateEndDate(task.start_date, task.duration);
            gantt.updateTask(task.id);
        }

        var actions = {

            indent: function indent(task_id) {
                var prev_id = gantt.getPrevSibling(task_id);
                while (gantt.isSelectedTask(prev_id)) {
                    var prev = gantt.getPrevSibling(prev_id);
                    if (!prev) break;
                    prev_id = prev;
                }
                if (prev_id) {
                    var new_parent = gantt.getTask(prev_id);
                    gantt.moveTask(task_id, gantt.getChildren(new_parent.id).length, new_parent.id);
                    new_parent.type = gantt.config.types.project;
                    new_parent.$open = true;
                    gantt.updateTask(task_id);
                    gantt.updateTask(new_parent.id);
                    return task_id;
                }
                return null;
            },
            outdent: function outdent(task_id, initialIndexes, initialSiblings) {
                var cur_task = gantt.getTask(task_id);
                var old_parent = cur_task.parent;
                if (gantt.isTaskExists(old_parent) && old_parent != gantt.config.root_id) {
                    var index = gantt.getTaskIndex(old_parent) + 1;
                    var prevSibling = initialSiblings[task_id].first;

                    if (gantt.isSelectedTask(prevSibling)) {
                        index += (initialIndexes[task_id] - initialIndexes[prevSibling]);
                    }
                    gantt.moveTask(task_id, index, gantt.getParent(cur_task.parent));
                    if (!gantt.hasChild(old_parent))
                        gantt.getTask(old_parent).type = gantt.config.types.task;
                    gantt.updateTask(task_id);
                    gantt.updateTask(old_parent);
                    return task_id;
                }
                return null;
            },
            moveForward: function(task_id) {
                shiftTask(task_id, 1);
            },
            moveBackward: function(task_id) {
                shiftTask(task_id, -1);
            }
        };
        var cascadeAction = {
            indent: true,
            outdent: true,
            del: true
        };

        var singularAction = {
            undo: true,
            redo: true
        };

        gantt.performAction = function(actionName) {
            var action = actions[actionName];
            if (!action)
                return;

            if (singularAction[actionName]) {
                action();
                return;
            }

            gantt.batchUpdate(function() {

                // need to preserve order of items on indent/outdent,
                // remember order before changing anything:
                var indexes = {};
                var siblings = {};
                gantt.eachSelectedTask(function(task_id) {
                    gantt.ext.undo.saveState(task_id, "task");
                    indexes[task_id] = gantt.getTaskIndex(task_id);
                    siblings[task_id] = {
                        first: null
                    };

                    var currentId = task_id;
                    while (gantt.isTaskExists(gantt.getPrevSibling(currentId)) &&
                        gantt.isSelectedTask(gantt.getPrevSibling(currentId))) {
                        currentId = gantt.getPrevSibling(currentId);
                    }
                    siblings[task_id].first = currentId;
                });

                var updated = {};
                gantt.eachSelectedTask(function(task_id) {

                    if (cascadeAction[actionName]) {
                        if (!updated[gantt.getParent(task_id)]) {
                            var updated_id = action(task_id, indexes, siblings);

                            updated[updated_id] = true;
                        } else {
                            updated[task_id] = true;
                        }
                    } else {
                        action(task_id, indexes);
                    }
                });
            });
        };


    })();





    function today_scroll() {
        var today = new Date();
        var additional_width = (gantt.$container.offsetWidth - gantt.config.grid_width) / 2
        var position = gantt.posFromDate(today) - additional_width;
        gantt.scrollTo(position)
    }



    function zoomIn() {
        gantt.ext.zoom.zoomIn();
    }

    function zoomOut() {
        gantt.ext.zoom.zoomOut()
    }

    function toggleSlack(toggle) {
        if (toggle.checked) {
            toggle.innerHTML = "Hide Slack";
            //declaring custom config
            gantt.config.show_slack = true;
        } else {
            toggle.innerHTML = "Show Slack";
            gantt.config.show_slack = false;
        }
        gantt.render();
    }
    // function columnHideandShow() {
    //    console.log("bhi")
    // }

    /* show slack */
    (function() {
        var totalSlackColumn = {
            name: "totalSlack",
            align: "center",
            resize: true,
            hide: false,
            width: 70,
            label: "{{ __('Total slack') }}",
            template: function(task) {
                return gantt.getTotalSlack(task);
            }
        }

        var freeSlackColumn = {
            name: "freeSlack",
            align: "center",
            resize: true,
            hide: false,
            width: 70,
            label: "{{ __('Free slack') }}",
            template: function(task) {
                if (gantt.isSummaryTask(task)) {
                    return "";
                }
                return gantt.getFreeSlack(task);
            }
        };

        const showWbsColumn = {
            name: "WBS",
            align: "center",
            resize: true,
            tree: true,
            hide: false,
            width: 700,
            label: "{{ __('WBS') }}",
            template: function(task) {
                return gantt.getWBSCode(task);
            }
        }




        const showAssignees = {
            name: "Assignee",
            align: "center",
            resize: true,
            hide: false,
            width: 700,
            label: "{{ __('Assignee') }}",
            template: function(task) {
                if (task.type == gantt.config.types.project) {
                    return "";
                }
                var result = "";

                task.assigness.forEach(function(assignee) {
                    if (!assignee)
                        return;
                    result += "<div class='owner-label' title='" + assignee.firstName + "'>" +
                        assignee.firstName.substr(0, 1) +
                        "</div>";

                });

                return result;
            }
        }

        Element.prototype.appendTemplate = function(html) {
            this.insertAdjacentHTML('beforeend', html);
            return this.lastChild;
        };

        const formatter = gantt.ext.formatters.durationFormatter({
            enter: "day",
            store: "day",
            format: "auto"
        });
        const linksFormatter = gantt.ext.formatters.linkFormatter({
            durationFormatter: formatter
        });

        gantt.config.columns = [
            showWbsColumn,
            {
                name: "id",
                width: 50,
                label: "{{ __('Task Id') }}",
                resize: true,
                hide: false,
            },
            {
                name: "text",
                width: 150,
                resize: true,
                hide: false
            },
            {
                name: "start_date",
                align: "center",
                resize: true,
                width: 120,
                label: "{{ __('Start Date') }}",
                hide: false
            },
            {
                name: "end_date",
                label: "End",
                align: "center",
                label: "{{ __('End Date') }}",
                width: 120,
                template: function(task) {
                    return gantt.templates.date_grid(task.end_date, task);
                },
                resize: true,
                hide: false
            },
            {
                name: "predecessors",
                label: "{{ __('Predecessors') }}",
                width: 200,
                align: "left",
                resize: true,
                hide: false,
                template: function(task) {
                    var links = task.$target;
                    var labels = [];
                    for (var i = 0; i < links.length; i++) {
                        var link = gantt.getLink(links[i]);
                        labels.push(linksFormatter.format(link));
                    }
                    return labels.join(", ")
                }
            },
            {
                name: "successors",
                label: "{{ __('Successors') }}",
                width: 200,
                align: "left",
                resize: true,
                hide: false,
                template: function(task) {
                    const links = task.$source;
                    const labels = [];
                    for (let i = 0; i < links.length; i++) {
                        let link = gantt.getLink(links[i]);
                        let copy = gantt.copy(link);
                        copy.target = link.source;
                        copy.source = link.target;
                        labels.push(linksFormatter.format(copy));
                    }
                    return labels.join(", ")
                }

            },
            {
                name: "duration",
                align: "center",
                label: "{{ __('Duration') }}",
                resize: true,
                width: 78,
                hide: false
            },
            // showAssignees,
            freeSlackColumn,
            totalSlackColumn,
            {
                name: "add",
                width: 44,
                min_width: 44,
                max_width: 44,
                hide: false
            }
        ];
        const columns = gantt.config.columns;
        for (let i = 0; i < columns.length; i++) {
            const template = `<label class='dropdown-item form-switch'>
                    <input class='form-check-input m-0 me-2'
                    id=${columns[i].name} name="columns" ${columns[i].hide ? "": "checked"} type='checkbox'>
                    ${columns[i].name}
                    </label>`
            const parent = document.getElementById("gantt-columns");
            parent.appendTemplate(template);
            document.getElementById(columns[i].name).onchange = function(event) {
                if (columns[i].name && !event.target.checked) {
                    gantt.getGridColumn(columns[i].name).hide = !event.target.checked;
                    gantt.render();
                } else {
                    gantt.getGridColumn(columns[i].name).hide = !event.target.checked;
                    gantt.render();
                }
            }
        }



        gantt.config.show_slack = false;
        gantt.addTaskLayer(function addSlack(task) {
            if (!gantt.config.show_slack) {
                return null;
            }

            var slack = gantt.getFreeSlack(task);

            if (!slack) {
                return null;
            }

            var state = gantt.getState().drag_mode;

            if (state == 'resize' || state == 'move') {
                return null;
            }

            var slackStart = new Date(task.end_date);
            var slackEnd = gantt.calculateEndDate(slackStart, slack);
            var sizes = gantt.getTaskPosition(task, slackStart, slackEnd);
            var el = document.createElement('div');

            el.className = 'slack';
            el.style.left = sizes.left + 'px';
            el.style.top = sizes.top + 2 + 'px';
            el.style.width = sizes.width + 'px';
            el.style.height = sizes.height + 'px';

            return el;
        });
    })();

    const new_gantt = [];

    const calculatingCriticalandFloatValue = function(task) {
        const updatedTask = {
            ...task,
            isCriticalTask: gantt.isCriticalTask(task),
            totalSlack: gantt.getTotalSlack(task),
            freeSlack: gantt.getFreeSlack(task),
            constraintType: gantt.getConstraintType(task),
        }
        new_gantt.push(updatedTask);
    }


    gantt.eachTask(function(task) {
        calculatingCriticalandFloatValue(task)
    })


  



    gantt.config.lightbox.sections = [{
            name: "description",
            height: 70,
            map_to: "text",
            type: "textarea",
            focus: true
        },
        {
            name: "time",
            map_to: "auto",
            type: "duration"
        },
        {
            name: "baseline",
            map_to: {
                start_date: "planned_start",
                end_date: "planned_end"
            },
            button: true,
            type: "duration_optional"
        }
    ];
    gantt.config.lightbox.project_sections = [{
            name: "description",
            height: 70,
            map_to: "text",
            type: "textarea",
            focus: true
        },
        {
            name: "time",
            map_to: "auto",
            type: "duration",
            readonly: true
        },
        {
            name: "baseline",
            map_to: {
                start_date: "planned_start",
                end_date: "planned_end"
            },
            button: true,
            type: "duration_optional"
        }
    ];
    gantt.config.lightbox.milestone_sections = [{
            name: "description",
            height: 70,
            map_to: "text",
            type: "textarea",
            focus: true
        },
        {
            name: "time",
            map_to: "auto",
            type: "duration",
            single_date: true
        },
        {
            name: "baseline",
            single_date: true,
            map_to: {
                start_date: "planned_start",
                end_date: "planned_end"
            },
            button: true,
            type: "duration_optional"
        }
    ];

    gantt.locale.labels.section_baseline = "Planned";


    // adding baseline display
    gantt.addTaskLayer(function draw_planned(task) {
        if (task.planned_start && task.planned_end) {
            var sizes = gantt.getTaskPosition(task, task.planned_start, task.planned_end);
            var el = document.createElement('div');
            el.className = 'baseline';
            el.style.left = sizes.left + 'px';
            el.style.width = sizes.width + 'px';
            el.style.top = sizes.top + gantt.config.task_height + 13 + 'px';
            return el;
        }
        return false;
    });

    gantt.templates.task_class = function(start, end, task) {
        if (task.planned_end) {
            var classes = ['has-baseline'];
            if (end.getTime() > task.planned_end.getTime()) {
                classes.push('overdue');
            }
            return classes.join(' ');
        }
    };

    gantt.templates.rightside_text = function(start, end, task) {
        if (task.planned_end) {
            if (end.getTime() > task.planned_end.getTime()) {
                var overdue = Math.ceil(Math.abs((end.getTime() -
                    task.planned_end.getTime()) / (24 * 60 * 60 * 1000)));
                var text = "<b>Overdue: " + overdue + " days</b>";
                return text;
            }
        }
    };
</script>
<script>
    gantt.showLightbox = function(id) {

        document.body.classList.add("modal-open");
        taskId = id;
        var task = gantt.getTask(id);
        const taskTitle = document.getElementById('task-title');
        taskTitle.innerHTML = `${task.id}-${task.text}`
        var form = getForm();
        var input = form.querySelector("[name='description']");
        input.focus();
        input.value = task.text;
        var start_date = form.querySelector("[name='start_date']");
        var end_date = form.querySelector("[name='end_date']");

        var startdate = task.start_date;
        var sdate = new Date(startdate),
        yr = sdate.getFullYear(),
        month = sdate.getMonth() < 10 ? '0' + sdate.getMonth() : sdate.getMonth(),
        day = sdate.getDate() < 10 ? '0' + sdate.getDate() : sdate.getDate(),
        newone = yr + '-' + month + '-' + day;
        start_date.value = newone;

        var enddate = task.end_date;
        var edate = new Date(enddate),
        year = edate.getFullYear(),
        mon = edate.getMonth() < 10 ? '0' + edate.getMonth() : edate.getMonth(),
        days = edate.getDate() < 10 ? '0' + edate.getDate() : edate.getDate(),
        newsecond = year + '-' + mon + '-' + days;
        end_date.value = newsecond;

        var users = form.querySelector("[name='users']");

        var user_id = form.querySelector("[name='user_id']");
        user_id.value = task.users;
        var reported_to = form.querySelector("[name='reported_to']");
        var reporter_id = form.querySelector("[name='reporter_id']");
        reporter_id.value = task.reported_to;

        var asignee = '';

        $('#taskassignee').tokenInput("clear");

        if (task.users != null) {

            $.ajax({
                url: "{{ route('project.get_assignee_name') }}",
                type: "GET",
                data: {
                    id: $('#user_id').val()
                },
                success: function(d) {
                    asignee = {
                        id: d.id,
                        name: d.name
                    };
                    setTimeout(function() {
                        $('#taskassignee').tokenInput("add", asignee);
                    }, 200);
                }
            });

        }
        var reportedto = '';
        if (task.reported_to != '') {

            $.ajax({
                url: "{{ route('project.get_reporter_name') }}",
                type: "GET",
                data: {
                    id: $('#reporter_id').val()
                },
                success: function(dd) {
                console.log("gg",dd);
                    reportedto = {
                        id: dd.id,
                        name: dd.name
                    };
                    setTimeout(function() {
                        $('#task-reporting').tokenInput("add", reportedto);
                    }, 200);
                }
            });

        }


        form.style.display = "block";
        form.querySelector("#save").onclick = save;
        form.querySelector("#close").onclick = cancel;
        form.querySelector("#cancel").onclick = cancel;
      
    }


    gantt.hideLightbox = function() {
        getForm().style.display = "";
        taskId = null;
    }


    function getForm() {
        const domEl = document.getElementById("modal-task");
        domEl.classList.add("show");

        return document.getElementById("modal-task");
    };

    function save() {
        var task = gantt.getTask(taskId);

        task.text = getForm().querySelector("[name='description']").value;
        get_start_date = getForm().querySelector("[name='start_date']").value;
        get_end_date = getForm().querySelector("[name='end_date']").value;
        task.users = getForm().querySelector("[name='users']").value;
        task.reported_to = getForm().querySelector("[name='reported_to']").value;

        task.start_date = new Date(get_start_date);
        task.end_date = new Date(get_end_date);

        if (task.$new) {
            delete task.$new;
            gantt.addTask(task, task.parent);
        } else {
            gantt.updateTask(task.id);
        }

        gantt.hideLightbox();
    }

    function cancel() {
        var task = gantt.getTask(taskId);

        if (task.$new)
            gantt.deleteTask(task.id);
        gantt.hideLightbox();
    }

    function remove() {
        gantt.deleteTask(taskId);
        gantt.hideLightbox();
    }


    gantt.attachEvent("onBeforeLightbox", function(id) {


    })

    // gantt create edit functionality

    if (frezee_status_actual != 1) {
        var app_url = "{{ env('APP_URL') }}";
        var dp = new gantt.dataProcessor(app_url);
        // var dp = new gantt.dataProcessor("/erp/public/");
        var critical = 0;
        dp.init(gantt);


        dp.attachEvent("onBeforeDataSending", function(id, state, data) {



            return true;
        });

        dp.attachEvent("onBeforeUpdate", function(id, state, data) {

            gantt.config.readonly = true;
            if (gantt.isTaskExists(id)) {

                let task = gantt.getTask(id);
                if (typeof task != 'undefined') {
                    let totalStack = gantt.getTotalSlack(task);
                    let freeSlack = gantt.getFreeSlack(task);

                    if (typeof totalStack != 'undefined') {
                        data.totalStack = totalStack;
                    }


                    if (typeof freeSlack != 'undefined') {
                        data.freeSlack = freeSlack;
                    }
                }
            }

            return true;
        });

        dp.setTransactionMode({
            mode: "REST",
            payload: {
                "_token": tempcsrf,
            }
        });

        dp.attachEvent("onAfterUpdate", function(id, action, tid, response) {

            gantt.config.readonly = false;
            if (action == "inserted") {

                gantt.showLightbox(tid);
                //  gantt.load("{{ route('projects.gantt_data', [$project->id]) }}");
            }
        });
    }
    // gantt crud end

    $("#taskassignee").tokenInput("{{ route('project.user_search') }}", {
        propertyToSearch: "name",
        tokenValue: "id",
        tokenDelimiter: ",",
        hintText: "{{ __('Search Task Assignee...') }}",
        noResultsText: "{{ __('Task Assignee not found.') }}",
        searchingText: "{{ __('Searching...') }}",
        deleteText: "&#215;",
        minChars: 2,
        tokenLimit: 1,
        zindex: 9999,
        animateDropdown: false,
        resultsLimit: 10,
        deleteText: "&times;",
        preventDuplicates: true,
        theme: "bootstrap"
    });

    $("#task-reporting").tokenInput("{{ route('project.user_search') }}", {
        propertyToSearch: "name",
        tokenValue: "id",
        tokenDelimiter: ",",
        hintText: "{{ __('Search Reporting To...') }}",
        noResultsText: "{{ __('Reporting To not found.') }}",
        searchingText: "{{ __('Searching...') }}",
        deleteText: "&#215;",
        minChars: 2,
        tokenLimit: 1,
        zindex: 9999,
        animateDropdown: false,
        resultsLimit: 10,
        deleteText: "&times;",
        preventDuplicates: true,
        theme: "bootstrap"
    });
    // @formatter:off
    document.addEventListener("DOMContentLoaded", function() {
        window.Litepicker && (new Litepicker({
            element: document.getElementById('start-date'),
            elementEnd: document.getElementById('end-date'),
            singleMode: false,
            allowRepick: true,
            buttonText: {
                previousMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
      <svg xmlns="http://www.w3.org/2000/svg" class="icon"
        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
        stroke="currentColor" fill="none" stroke-linecap="round"
        stroke-linejoin="round"><path stroke="none"
        d="M0 0h24v24H0z" fill="none"/>
          <path d="M15 6l-6 6l6 6" />
      </svg>`,
                nextMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
       height="24" viewBox="0 0 24 24" stroke-width="2"
        stroke="currentColor" fill="none" stroke-linecap="round"
         stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"
          fill="none"/><path d="M9 6l6 6l-6 6" />
      </svg>`,
            },
        }));
    });
    // @formatter:on
</script>
