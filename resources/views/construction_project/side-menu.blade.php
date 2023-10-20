@php
    if (Session::has('project_id')) {
        $project_id = Session::get('project_id');
    } else {
        $project_id = 0;
    }

    $microGet = App\Models\Project::where('id', $project_id)->first();
    $checMicroProgram = $microGet != null ? $microGet->micro_program : 0;
    $setting = Utility::settings(\Auth::user()->creatorId());
@endphp

<style>
    .navbar-expand-lg {
        top: 4.8em !important;
    }

    .navbar-vertical.navbar-expand-lg .navbar-collapse .dropdown-menu .dropdown-item.active,
    .navbar-vertical.navbar-expand-lg .navbar-collapse .dropdown-menu .dropdown-item:active {
        background: var(--tblr-navbar-active-bg) !important;
        color: black !important;
    }
</style>
<div class="page">
    <!-- Sidebar  -->
    <header id="sidebar" class="navbar navbar-expand-md subnav d-print-none" data-bs-theme="light"
        style="background: #e4e4e4;">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
                aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="sidebar-menu">
                <ul class="navbar-nav pt-lg-1">
                    <!--Dashboard start-->
                    <li class="nav-item">
                        <a href="{{ route('projects.show', $project_id) }}"
                            class="{{ Request::route()->getName() == 'projects.show' ?
                            'nav-link active' : 'nav-link' }}">
                            <span class=" d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M5 12l-2 0l9 -9l9 9l-2 0"></path>
                                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path>
                                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path>
                                </svg>
                            </span>
                            <span class="nav-link-title"> {{ __('Dashboard') }} </span>
                        </a>
                    </li>
                    <!--Dashboard end-->

                    <!--Main Planning start-->
                    <li class="nav-item dropdown">
                        <a class="{{ Request::route()->getName() == 'projects.gantt' ||
                        Request::route()->getName() == 'revision' ||
                        Request::route()->getName() == 'project_report.revsion_task_list' ||
                        Request::route()->getName() == 'taskBoard.view' ||
                        Request::route()->getName() == 'project_report.view_task_report'
                            ? 'nav-link active dropdown-toggle'
                            : 'nav-link dropdown-toggle' }}"
                            href="#planning" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button"
                            aria-expanded="false">
                            <span class=" d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-home"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"></path>
                                    <path d="M4 13a8.094 8.094 0 0 0 3 5.24"></path>
                                    <path
                                        d="M11 15h2a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-1a1 1 0 0 0 -1 1v1a1 1 0 0 0 1 1h2">
                                    </path>
                                    <path d="M17 15v2a1 1 0 0 0 1 1h1"></path>
                                    <path d="M20 15v6"></path>
                                </svg>
                            </span>
                            <span class="nav-link-title">{{ __('Main Planning') }}</span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    @can('view grant chart')
                                        <a href="{{ route('projects.gantt', $project_id) }}"
                                            class="{{ Request::route()->getName() == 'projects.gantt' ?
                                            'dropdown-item active' : 'dropdown-item' }}">
                                            {{ __('Gantt') }}
                                        </a>
                                    @endcan
                                    @if (Session::get('current_revision_freeze') == 1)
                                        <a href="{{ url('revision') }}"
                                            class="{{ Request::route()->getName() == 'revision' ?
                                            'dropdown-item active' : 'dropdown-item' }}">
                                            {{ __('Revision') }}
                                        </a>
                                    @endif
                                    @if (session::has('revision_started'))
                                        <a href="{{ route('project_report.revsion_task_list', $project_id) }}"
                                            class="{{ Request::route()->getName() == 'project_report.revsion_task_list'
                                             ?'dropdown-item active' : 'dropdown-item' }}">
                                          {{ __('Revised Program') }}
                                        </a>
                                    @endif
                                    {{-- @if ($checMicroProgram == 1)
                                    <a href="{{ route('microprogram') }}"
                                       class="dropdown-item">{{ __('Micro Program') }}</a>
                                    @endif
                                    @if (session::has('revision_started'))
                                    <a href="{{ route('project_report.revsion_task_list', $project_id) }}"
                                       class="{{ (Request::route()->getName() == 'project_report.revsion_task_list')
                                       ?'dropdown-item active' :'dropdown-item'}}">{{ __('Revised Program') }}</a>
                                    @endif --}}
                                    <a href="{{ route('taskBoard.view', ['list']) }}"
                                        class="{{ Request::route()->getName() == 'taskBoard.view' ?
                                        'dropdown-item active' :'dropdown-item' }}">{{ __('Task') }}</a>
                                    {{-- <a href="{{ route('project_report.view_task_report', $project_id) }}"
                                    class="{{ (Request::route()->getName() == 'project_report.view_task_report')
                                    ?'dropdown-item active' :'dropdown-item'}}">{{ __('Task Reports') }}</a> --}}
                                    @if ($setting['company_type'] != 2)
                                        @can('manage bug report')
                                            <a href="{{ route('task.bug', $project_id) }}" class="dropdown-item">
                                                {{ __('Bug Report') }}</a>
                                        @endcan
                                        {{-- @can('create project task')
                                          <a href="{{ route('projects.tasks.index', $project_id) }}"
                                             class="dropdown-item">{{ __('Task') }}</a>
                                          @endcan --}}
                                        @if (\Auth::user()->type != 'client' || \Auth::user()->type == 'client')
                                            <a href="{{ route('projecttime.tracker', $project_id) }}"
                                                class="dropdown-item">{{ __('Tracker') }}</a>
                                        @endif
                                        @if (\Auth::user()->type != 'client')
                                            @can('view timesheet')
                                                <a href="{{ route('timesheet.index', $project_id) }}"
                                                    class="dropdown-item">{{ __('Timesheet') }}</a>
                                            @endcan
                                        @endif
                                        {{-- @can('view expense')
                                          <a href="{{ route('projects.expenses.index',$project_id) }}"
                                             class="dash-item">{{ __('Expense') }}</a>
                                          @endcan
                                          <a href="{{ route('task.newcalendar',['all']) }}"
                                             class="dash-item">{{ __('Task Calendar') }}</a>
                                          <a href="{{route('project_report.index')}}"
                                             class="dash-item">{{ __('Project Reports') }}</a>
                                          --}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </li>
                    <!--Main Planning end-->

                    <!--LookaHead Planning starts-->
                    @if ($checMicroProgram == 1)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
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
                                    {{ __('Lookahead Planning') }}
                                </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <a class="dropdown-item">
                                            {{ __('Lookahead Gantt') }}
                                        </a>
                                        <a class="dropdown-item">
                                            {{ __('Lookahead Schedule') }}
                                        </a>
                                        <a class="dropdown-item">
                                            {{ __('Active Lookahead') }}
                                        </a>
                                    </div>
                                </div>
                        </li>
                    @endif
                    <!--LookaHead Planning end-->

                    <!--Team Members starts-->
                    <li class="nav-item dropdown">
                        <a href="{{ route('project.teammembers', $project_id) }}"
                            class="{{ Request::route()->getName() == 'project.teammembers'
                                ? 'nav-link active dropdown-toggle'
                                : 'nav-link dropdown-toggle' }}"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button"
                            aria-expanded="false">
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
                                {{ __('Team Members') }}
                            </span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    <a href="{{ route('project.teammembers', $project_id) }}"
                                        class="{{ Request::route()->getName() == 'project.teammembers' ?
                                        'dropdown-item active' : 'dropdown-item' }}">
                                        {{ __('Engineers') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!--Team Members end-->

                    <!--Activites starts-->
                    <li class="nav-item">
                        <a href="{{ route('project.activities', $project_id) }}"
                            class="{{ Request::route()->getName() == 'project.activities' ?
                            'nav-link active' : 'nav-link' }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M5 12l-2 0l9 -9l9 9l-2 0"></path>
                                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path>
                                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path>
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                {{ __('Activites') }}
                            </span>
                        </a>
                    </li>
                    <!--Activites end-->


                    <!--Reports starts-->
                    <li class="nav-item dropdown">
                        <a href="{{ route('project_report.view_task_report', $project_id) }}"
                            class="{{ Request::route()->getName() == 'project_report.view_task_report'
                                ? 'nav-link active dropdown-toggle'
                                : 'nav-link dropdown-toggle' }}"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button"
                            aria-expanded="false">
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
                                {{ __('Reports') }}
                            </span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    <a href="{{ route('project_report.view_task_report', $project_id) }}"
                                        class="{{ Request::route()->getName() == 'project_report.view_task_report' ?
                                        'nav-link active' : 'nav-link' }}">
                                        {{ __('Daily Task Reports') }}
                                    </a>
                                    <a class="dropdown-item" href="./accordion.html">
                                        {{ __('OverAll Reports') }}
                                    </a>
                                    <a class="dropdown-item" href="./accordion.html">
                                        {{ __('LookaHead Reports') }}
                                    </a>
                                </div>
                            </div>
                    </li>
                    <!--Reports ends-->

                    <!--Holidays starts-->
                    <li class="nav-item">
                        <a href="{{ route('project_holiday.index', $project_id) }}"
                            class="{{ Request::route()->getName() == 'project_holiday.index' ? 
                            'nav-link active' : 'nav-link' }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M5 12l-2 0l9 -9l9 9l-2 0"></path>
                                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path>
                                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path>
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                {{ __('Holidays') }}
                            </span>
                        </a>
                    </li>
                     <!--Holidays ends-->
                     {{--
                     <li class=""><a href="{{route('qaqc.bricks')}}">{{__('Bricks')}}</a></li>
                     <li class=""><a href="{{route('qaqc.cement')}}">{{__('Cement')}}</a></li>
                     <li class=""><a href="{{route('qaqc.sand')}}">{{__('Sand')}}</a></li>
                     <li class=""><a href="{{route('qaqc.steel')}}">{{__('Steel')}}</a></li>
                     --}}
                     {{-- Contracts --}}
                     {{--
                     <li class="">
                        <a data-bs-target="#submenuContracts" data-bs-toggle="collapse"
                           aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                        <span class="icon"><img src="{{asset('assets/images/icons/leave.png')}}" alt="ige"/></span>
                        <span class="list">{{ __('Contracts') }}</span>
                        </a>
                        <ul class="collapse list-unstyled" id="submenuContracts">
                           <li class="">
                              <a data-bs-target="#submenuTender" data-bs-toggle="collapse"
                                 aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                              <span class="icon"><i class="ti ti-users"></i></span>
                              <span class="list">{{__('Tender')}}</span>
                              </a>
                              <ul class="collapse list-unstyled" id="submenuTender">
                                 <li class=""><a href="{{route('contract.boq')}}">{{__('BOQ')}}</a></li>
                              </ul>
                           </li>
                           <li class="">
                              <a href="{{route('contract.claimspaymentcertificate')}}"
                                 aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                              <span class="icon"><i class="ti ti-users"></i></span>
                              <span class="list">{{__('Claims/Payment Certificate')}}</span>
                              </a>
                           </li>
                           <li class="">
                              <a data-bs-target="#submenuMaterial" data-bs-toggle="collapse"
                                 aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                              <span class="icon"><i class="ti ti-users"></i></span>
                              <span class="list">{{__('Material ')}}</span>
                              </a>
                              <ul class="collapse list-unstyled" id="submenuMaterial">
                                 <li class="">
                                    <ul class="collapse list-unstyled" id="submenuMaterial">
                                       <li class=""><a href="{{route('contract.reports')}}">{{__('Reports')}}</a></li>
                                       <li class="">
                                          <a href="{{route('contract.reconcilation')}}">
                                          {{__('Reconcilation')}}</a>
                                       </li>
                                       <li class="">
                                          <a href="{{route('contract.eot')}}">{{__('EOT-Extension of time')}}</a>
                                       </li>
                                    </ul>
                                 </li>
                              </ul>
                           </li>
                        </ul>
                     </li>
                     --}}
                </ul>
            </div>
        </div>
    </header>

    <!-- Page Content  -->
    <div class="page-wrapper">
        @isset($hrm_header)
            <h2 class="mb-4">{{ __($hrm_header) }}</h2>
        @endisset

        {{-- @include('new_layouts.footer') --}}
