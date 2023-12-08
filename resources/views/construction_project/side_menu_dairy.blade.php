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
<div class=>
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
                        <a href="{{ route('show_dairy', $project_id) }}"
                            class="{{ Request::route()->getName() == 'show_dairy' ?
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

                    <!--Drawings starts-->
                    <li class="nav-item">
                        <a href="{{ route('drawing_list') }}"
                            class="{{ Request::route()->getName() == 'drawings.index' ?
                            'nav-link active' : 'nav-link' }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-scribble" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M3 15c2 3 4 4 7 4s7 -3 7 -7s-3 -7 -6 -7s-5 1.5 -5 4s2 5 6 5s8.408 -2.453 10 -5"></path>
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                {{ __('Drawings') }}
                            </span>
                        </a>
                    </li>
                    <!--Drawings end-->
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
