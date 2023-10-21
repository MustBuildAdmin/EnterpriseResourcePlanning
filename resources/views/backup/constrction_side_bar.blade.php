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
    <header id="sidebar" class="navbar navbar-expand-md subnav  d-print-none">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
                aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="sidebar-menu">
                <ul class="navbar-nav pt-lg-3">
                    <li class="nav-item">
                        <a href="{{ route('projects.show', $project_id) }}"
                            class="{{ Request::route()->getName() == 'projects.show' ?
                             'nav-link active' : 'nav-link' }}">
                            <span class=" d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-analyze"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M20 11a8.1 8.1 0 0 0 -6.986 -6.918a8.095 8.095 0 0 0 -8.019 3.918"></path>
                                    <path d="M4 13a8.1 8.1 0 0 0 15 3"></path>
                                    <path d="M19 16m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                    <path d="M5 8m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                    <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                </svg>
                            </span>
                            <span class="nav-link-title"> {{ __('Dashboard') }} </span>
                        </a>
                    </li>
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
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-24-hours"
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
                            <span class="nav-link-title">{{ __('Planning') }}</span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    @can('view grant chart')
                                        <a href="{{ route('projects.gantt', $project_id) }}"
                                            class="{{ Request::route()->getName() == 'projects.gantt' ?
                                             'dropdown-item active' : 'dropdown-item' }}">{{ __('Gantt') }}
                                        </a>
                                    @endcan
                                    @if ($checMicroProgram == 1)
                                        <a href="{{ route('microprogram') }}"
                                            class="dropdown-item">{{ __('Micro Program') }}</a>
                                    @endif
                                    @if (Session::get('current_revision_freeze') == 1)
                                        <a href="{{ url('revision') }}"
                                            class="{{ Request::route()->getName() == 'revision' ? 'dropdown-item active'
                                             : 'dropdown-item' }}">{{ __('Revision') }}
                                        </a>
                                    @endif
                                    @if (session::has('revision_started'))
                                        <a href="{{ route('project_report.revsion_task_list', $project_id) }}"
                                        class="{{ Request::route()->getName() == 'project_report.revsion_task_list' ?
                                        'dropdown-item active' : 'dropdown-item' }}">
                                             {{ __('Revised Program') }}
                                        </a>
                                    @endif
                                    <a href="{{ route('taskBoard.view', ['list']) }}"
                                    class="{{ Request::route()->getName() == 'taskBoard.view' ? 'dropdown-item active'
                                         : 'dropdown-item' }}">{{ __('Task Workdone') }}
                                    </a>
                                    <a href="{{ route('project_report.view_task_report', $project_id) }}"
                                        class="{{ Request::route()->getName() == 'project_report.view_task_report' ?
                                         'dropdown-item active' : 'dropdown-item' }}">
                                         {{ __('Task Reports') }}
                                    </a>
                                    @if ($setting['company_type'] != 2)
                                        @can('manage bug report')
                                            <a href="{{ route('task.bug', $project_id) }}" class="dropdown-item">
                                                {{ __('Bug Report') }}</a>
                                        @endcan
                                        @can('create project task')
                                            <a href="{{ route('projects.tasks.index', $project_id) }}"
                                                class="dropdown-item">{{ __('Task') }}</a>
                                        @endcan
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
                    <li class=" nav-item dropdown">
                        <a class="{{ Request::route()->getName() == 'drawing_list' ||
                        Request::route()->getName() == 'daily_reports' ||
                        Request::route()->getName() == 'show_project_specification' ||
                        Request::route()->getName() == 'variation_scope_change' ||
                        Request::route()->getName() == 'show_consultant_direction' ||
                        Request::route()->getName() == 'rfi_show_info' ||
                        Request::route()->getName() == 'procurement_material'
                            ? ' nav-link dropdown-toggle show'
                            : 'nav-link dropdown-toggle' }}"
                            href="#planning" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button"
                            aria-expanded="{{ Request::route()->getName() == 'drawing_list' ||
                            Request::route()->getName() == 'daily_reports' ||
                            Request::route()->getName() == 'show_project_specification' ||
                            Request::route()->getName() == 'variation_scope_change' ||
                            Request::route()->getName() == 'show_consultant_direction' ||
                            Request::route()->getName() == 'rfi_show_info' ||
                            Request::route()->getName() == 'procurement_material'
                                ? 'true'
                                : 'false' }}">
                            <span class=" d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-address-book" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M20 6v12a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2
                                -2v-12a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2z">
                                    </path>
                                    <path d="M10 16h6"></path>
                                    <path d="M13 11m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                    <path d="M4 8h3"></path>
                                    <path d="M4 12h3"></path>
                                    <path d="M4 16h3"></path>
                                </svg>
                            </span>
                            <span class="nav-link-title">{{ __('Diary') }}</span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    <a href="{{ route('drawing_list') }}" class="dropdown-item">{{ __('Drawing') }}
                                        <span class="badge badge-sm bg-primary-lt text-uppercase ms-auto">
                                            Coming Soon
                                        </span>
                                    </a>
                                    @can('manage directions')
                                        <a href="{{ route('show_consultant_direction') }}"
                                            class="dropdown-item">{{ __('Directions') }}
                                            <span class="badge badge-sm bg-primary-lt text-uppercase ms-auto">
                                                Coming Soon
                                            </span>
                                        </a>
                                    @endcan
                                    @can('manage project specification')
                                        <a href="{{ route('show_project_specification') }}" class="dropdown-item">
                                            {{ __('Specifications') }}
                                            <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                                        </a>
                                    @endcan

                                    @can('manage RFI')
                                        <a href="{{ route('rfi_show_info') }}" class="dropdown-item">{{ __('RFI') }}
                                            <span class="badge badge-sm bg-primary-lt text-uppercase ms-auto">
                                                Coming Soon
                                            </span>
                                        </a>
                                    @endcan
                                    @can('manage site reports')
                                        <a href="{{ route('daily_reports') }}"
                                            class="dropdown-item">{{ __('Site Reports') }}
                                            <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                                        </a>
                                    @endcan
                                    @can('manage vochange')
                                        <a href="{{ route('variation_scope_change') }}"
                                            class="dropdown-item">{{ __('VO/CO') }}
                                            <span class="badge badge-sm bg-primary-lt text-uppercase ms-auto">
                                                Coming Soon
                                            </span>
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#quality" data-bs-toggle="dropdown"
                            data-bs-auto-close="outside" role="button" aria-expanded="false">
                            <span class=" d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-chart-area-line" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 19l4 -6l4 2l4 -5l4 4l0 5l-16 0"></path>
                                    <path d="M4 12l3 -4l4 2l5 -6l4 4"></path>
                                </svg>
                            </span>
                            <span class="nav-link-title">{{ __('Quality') }}</span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    <ul class="navbar-nav pt-lg-3">
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#concrete"
                                                data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button"
                                                aria-expanded="false">
                                                {{ __('Material Testing ') }}
                                            </a>
                                            <div class="dropdown-menu">
                                                <div class="dropdown-menu-columns">
                                                    <div class="dropdown-menu-column">
                                                        <a class="dropdown-item" href="{{ route('qaqc.concrete') }}">
                                                            {{ __('Concrete') }}
                                                            <span class="badge badge-sm bg-green-lt
                                                             text-uppercase ms-auto">
                                                                New
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#contracts" data-bs-toggle="dropdown"
                            data-bs-auto-close="outside" role="button" aria-expanded="false">
                            <span class=" d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-chart-area-line" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 19l4 -6l4 2l4 -5l4 4l0 5l-16 0"></path>
                                    <path d="M4 12l3 -4l4 2l5 -6l4 4"></path>
                                </svg>
                            </span>
                            <span class="nav-link-title">{{ __('Contracts') }}</span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    <ul class="navbar-nav pt-lg-3">
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#tender"
                                                data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button"
                                                aria-expanded="false">{{ __('Tender') }}</a>
                                            <div class="dropdown-menu">
                                                <div class="dropdown-menu-columns">
                                                    <div class="dropdown-menu-column">
                                                        <a class="dropdown-item" href="{{ route('contract.boq') }}">
                                                            {{ __('BOQ') }}
                                                            <span class="badge badge-sm bg-green-lt
                                                             text-uppercase ms-auto">
                                                                New
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('project.teammembers', $project_id) }}" class="nav-link">
                            <span class=" d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-analyze"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M20 11a8.1 8.1 0 0 0 -6.986 -6.918a8.095 8.095 0 0 0 -8.019 3.918"></path>
                                    <path d="M4 13a8.1 8.1 0 0 0 15 3"></path>
                                    <path d="M19 16m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                    <path d="M5 8m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                    <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                </svg>
                            </span>
                            <span class="nav-link-title"> {{ __('Team Members') }} </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('project_holiday') }}" class="nav-link">
                            <span class=" d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-calendar-check" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M11.5 21h-5.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v6">
                                    </path>
                                    <path d="M16 3v4"></path>
                                    <path d="M8 3v4"></path>
                                    <path d="M4 11h16"></path>
                                    <path d="M15 19l2 2l4 -4"></path>
                                </svg>
                            </span>
                            <span class="nav-link-title"> {{ __('Holidays') }} </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('project.activities', $project_id) }}" class="nav-link">
                            <span class=" d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-analyze"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M20 11a8.1 8.1 0 0 0 -6.986 -6.918a8.095 8.095 0 0 0 -8.019 3.918"></path>
                                    <path d="M4 13a8.1 8.1 0 0 0 15 3"></path>
                                    <path d="M19 16m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                    <path d="M5 8m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                    <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                </svg>
                            </span>
                            <span class="nav-link-title"> {{ __('History') }} </span>
                        </a>
                    </li>
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
