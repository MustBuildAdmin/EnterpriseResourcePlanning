<div class="page">


    <!-- Sidebar  -->
    <aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
                aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="sidebar-menu">
                <ul class="navbar-nav pt-lg-3">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
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
                            <span class="nav-link-title"> {{ __('Dashboard') }} </span></a>

                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                            data-bs-auto-close="false" role="button" aria-expanded="false">
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
                                Planning
                            </span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    @can('view grant chart')
                                        <a class="dropdown-item" href="#">
                                            {{ __('Gantt Chart') }}
                                        </a>
                                    @endcan

                                    <a href="{{ route('taskBoard.view', ['list']) }}"
                                        class="dropdown-item">{{ __('Task') }}</a>
                                    @if ($setting['company_type'] != 2)
                                        @can('manage bug report')
                                            <a href="{{ route('task.bug', 1) }}" class="dropdown-item">
                                                {{ __('Bug Report') }}
                                            </a>
                                        @endcan
                                        @if (\Auth::user()->type != 'client' || \Auth::user()->type == 'client')
                                            <a class="dropdown-item"
                                                href="{{ route('projecttime.tracker', 1) }}">
                                                {{ __('Tracker') }}
                                            </a>
                                        @endif
                                        @can('create project task')
                                            <a class="dropdown-item"
                                                href="{{ route('projects.tasks.index', 1) }}">
                                                {{ __('Task') }}
                                            </a>
                                        @endcan
                                        @if (\Auth::user()->type != 'client')
                                            @can('view timesheet')
                                                <a class="dropdown-item" href="{{ route('timesheet.index', 1) }}">
                                                    {{ __('Timesheet') }}
                                                </a>
                                            @endcan
                                        @endif
                                    @endif
                                    <a class="dropdown-item"
                                        href="{{ route('project_report.view_task_report', 1) }}">
                                        {{ __('Task Report') }}
                                    </a>

                    </li>
                    {{-- Dairy --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown"
                            data-bs-auto-close="false" role="button" aria-expanded="false">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z">
                                    </path>
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                {{ __('Diary') }}
                            </span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    <a href="{{ route('drawing_list') }}"
                                        class="{{ Request::segment(1) == 'drawing_list' ? 'active dropdown-item' : 'dropdown-item' }}">{{ __('Drawing') }}</a>

                                    @can('manage project specification')
                                        <a href="{{ route('show_project_specification') }}"
                                            class="{{ Request::segment(1) == 'show_project_specification' ? 'active dropdown-item' : 'dropdown-item' }}">
                                            {{ __('Project Specifications Summary') }}
                                            <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                                        </a>
                                    @endcan

                                    @can('manage vochange')
                                        <a class="{{ Request::segment(1) == 'variation_scope_change' ? 'active dropdown-item' : 'dropdown-item' }}"
                                            href="{{ route('variation_scope_change') }}">
                                            {{ __('VO/Change Order') }}
                                        </a>
                                    @endcan

                                    @can('manage directions')
                                        <a class="{{ Request::segment(1) == 'show_consultant_direction' ? 'active dropdown-item' : 'dropdown-item' }}"
                                            href="{{ route('show_consultant_direction') }}">
                                            {{ __('Directions') }}
                                        </a>
                                    @endcan

                                    @can('manage RFI')
                                        <a href="{{ route('rfi_show_info') }}"
                                            class="{{ Request::segment(1) == 'rfi_show_info' ? 'active dropdown-item' : 'dropdown-item' }}">{{ __('RFI') }}</a>
                                    @endcan

                                    <a href="#" class="dropdown-item">{{ __('RAF/RAM') }}</a>
                                    <a href="{{ route('procurement_material') }}"
                                        class="{{ Request::segment(1) == 'procurement_material' ? 'active dropdown-item' : 'dropdown-item' }}">{{ __('Procurement Material Supply Log') }}</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#navbar-layout" data-bs-toggle="dropdown"
                            data-bs-auto-close="false" role="button" aria-expanded="false">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <!-- Download SVG icon from http://tabler-icons.io/i/layout-2 -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M4 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v1a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z">
                                    </path>
                                    <path
                                        d="M4 13m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z">
                                    </path>
                                    <path
                                        d="M14 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z">
                                    </path>
                                    <path
                                        d="M14 15m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v1a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z">
                                    </path>
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Layout
                            </span>
                        </a>
                        <div class="dropdown-menu show">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    <a class="dropdown-item" href="./layout-horizontal.html">
                                        Horizontal
                                    </a>
                                    <a class="dropdown-item" href="./layout-boxed.html">
                                        Boxed
                                        <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                                    </a>
                                    <a class="dropdown-item" href="./layout-vertical.html">
                                        Vertical
                                    </a>
                                    <a class="dropdown-item" href="./layout-vertical-transparent.html">
                                        Vertical transparent
                                    </a>
                                    <a class="dropdown-item" href="./layout-vertical-right.html">
                                        Right vertical
                                    </a>
                                    <a class="dropdown-item" href="./layout-condensed.html">
                                        Condensed
                                    </a>
                                    <a class="dropdown-item" href="./layout-combo.html">
                                        Combined
                                    </a>
                                </div>
                                <div class="dropdown-menu-column">
                                    <a class="dropdown-item" href="./layout-navbar-dark.html">
                                        Navbar dark
                                    </a>
                                    <a class="dropdown-item" href="./layout-navbar-sticky.html">
                                        Navbar sticky
                                    </a>
                                    <a class="dropdown-item" href="./layout-navbar-overlap.html">
                                        Navbar overlap
                                    </a>
                                    <a class="dropdown-item" href="./layout-rtl.html">
                                        RTL mode
                                    </a>
                                    <a class="dropdown-item" href="./layout-fluid.html">
                                        Fluid
                                    </a>
                                    <a class="dropdown-item" href="./layout-fluid-vertical.html">
                                        Fluid vertical
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </aside>

    <!-- Page Content  -->
    <div id="content" class="page-wrapper">


        <div class="collapseToggle hrm">
            <span id="toggleIcon" class="fa fa-chevron-left"></span>
        </div>

        @isset($hrm_header)
            <h2 class="mb-4">{{ __($hrm_header) }}</h2>
        @endisset



        <script type="text/javascript">
            $('.collapseToggle').on('click', function() {
                $(".sidebar").toggleClass('sidebar--Collapse');
                $('.main').toggleClass('main--slide');
                $('#toggleIcon').toggleClass('rotate');
            });
        </script>
        {{-- @include('new_layouts.footer') --}}
