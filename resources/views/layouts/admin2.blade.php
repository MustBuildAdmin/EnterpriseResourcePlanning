@php

    //$logo=asset(Storage::url('uploads/logo/'));
    $logo = \App\Models\Utility::get_file('uploads/logo');

    $company_favicon = Utility::getValByName('company_favicon');
    $setting = \App\Models\Utility::colorset();
    $company_logo = \App\Models\Utility::GetLogo();
    $mode_setting = \App\Models\Utility::mode_layout();
    $color = !empty($setting['color']) ? $setting['color'] : 'theme-3';
    $SITE_RTL = Utility::getValByName('SITE_RTL');
    $lang = Utility::getValByName('default_language');

@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $SITE_RTL == 'on' ? 'rtl' : '' }}">


<meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">

<head>
    <title>
        {{ Utility::getValByName('title_text') ? Utility::getValByName('title_text') : config('app.name', 'Must BuildApp') }}
        - @yield('page-title')</title>

    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

    <!-- Meta -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="url" content="{{ url('') . '/' . config('chatify.path') }}" data-user="{{ Auth::user()->id }}">
    <link rel="icon"
        href="{{ $logo . '/' . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png') }}"
        type="image" sizes="16x16">
    <!-- font css -->
    <link href="{{ asset('assets/dist/css/tabler.min.css?1674944402') }}" rel="stylesheet" />
    <link href="{{ asset('assets/dist/css/tabler-flags.min.css?1674944402') }}" rel="stylesheet" />
    <link href="{{ asset('assets/dist/css/tabler-payments.min.css?1674944402') }}" rel="stylesheet" />
    <link href="{{ asset('assets/dist/css/tabler-vendors.min.css?1674944402') }}" rel="stylesheet" />
    <link href="{{ asset('assets/dist/css/demo.min.css?1674944402') }}" rel="stylesheet" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        :root {
            --tblr-font-sans-serif: 'Poppins', sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>

</head>

<body class=" d-flex flex-column">
    <div class="page">
        <!-- Navbar -->
        <header class="navbar navbar-expand-md navbar-light d-print-none">
            <div class="container-xl">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
                    aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <a href=".">
                        <img src="./static/logo.svg" width="110" height="32" alt="Must BuildApp"
                            class="navbar-brand-image">
                    </a>
                </h1>
                <div class="navbar-nav flex-row order-md-last">
                    <div class="nav-item d-none d-md-flex me-3">

                    </div>
                    <div class="d-none d-md-flex">
                        <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode"
                            data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
                            </svg>
                        </a>
                        <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode"
                            data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                <path
                                    d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
                            </svg>
                        </a>
                        <div class="nav-item dropdown d-none d-md-flex me-3">
                            <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1"
                                aria-label="Show notifications">
                                <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                                    <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                                </svg>
                                <span class="badge bg-red"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Last updates</h3>
                                    </div>
                                    <div class="list-group list-group-flush list-group-hoverable">
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto"><span
                                                        class="status-dot status-dot-animated bg-red d-block"></span>
                                                </div>
                                                <div class="col text-truncate">
                                                    <a href="#" class="text-body d-block">Example 1</a>
                                                    <div class="d-block text-muted text-truncate mt-n1">
                                                        Change deprecated html tags to text decoration classes (#29604)
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="#" class="list-group-item-actions">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon text-muted" width="24" height="24"
                                                            viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path
                                                                d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto"><span class="status-dot d-block"></span></div>
                                                <div class="col text-truncate">
                                                    <a href="#" class="text-body d-block">Example 2</a>
                                                    <div class="d-block text-muted text-truncate mt-n1">
                                                        justify-content:between ⇒ justify-content:space-between (#29734)
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="#" class="list-group-item-actions show">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon text-yellow" width="24" height="24"
                                                            viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path
                                                                d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto"><span class="status-dot d-block"></span></div>
                                                <div class="col text-truncate">
                                                    <a href="#" class="text-body d-block">Example 3</a>
                                                    <div class="d-block text-muted text-truncate mt-n1">
                                                        Update change-version.js (#29736)
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="#" class="list-group-item-actions">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon text-muted" width="24" height="24"
                                                            viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path
                                                                d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto"><span
                                                        class="status-dot status-dot-animated bg-green d-block"></span>
                                                </div>
                                                <div class="col text-truncate">
                                                    <a href="#" class="text-body d-block">Example 4</a>
                                                    <div class="d-block text-muted text-truncate mt-n1">
                                                        Regenerate package-lock.json (#29730)
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="#" class="list-group-item-actions">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon text-muted" width="24" height="24"
                                                            viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path
                                                                d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                            aria-label="Open user menu">
                            <span class="avatar avatar-sm"
                                style="background-image: url(./static/avatars/000m.jpg)"></span>
                            <div class="d-none d-xl-block ps-2">
                                <div>Paweł Kuna</div>
                                <div class="mt-1 small text-muted">UI Designer</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <a href="#" class="dropdown-item">Status</a>
                            <a href="./profile.html" class="dropdown-item">Profile</a>
                            <a href="#" class="dropdown-item">Feedback</a>
                            <div class="dropdown-divider"></div>
                            <a href="./settings.html" class="dropdown-item">Settings</a>
                            <a href="./sign-in.html" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <header class="navbar-expand-md">
            <div class="collapse navbar-collapse" id="navbar-menu">
                <div class="navbar navbar-light">
                    <div class="container-xl">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="./">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Home
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last">
                            <form action="./" method="get" autocomplete="off" novalidate>
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                            <path d="M21 21l-6 -6" />
                                        </svg>
                                    </span>
                                    <input type="text" value="" class="form-control" placeholder="Search…"
                                        aria-label="Search in website">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <main class="page-wrapper">
            <section class="row">
                {{-- <aside class="col-2">
                <nav id="sidebar" class="navbar navbar-vertical navbar-transparent">
                    <div class="custom-menu">
                        <button type="button" id="sidebarCollapse" class="btn btn-primary">
                            <i class="fa fa-bars"></i>
                            <span class="sr-only">Toggle Menu</span>
                        </button>
                    </div>
                    <div class="p-4">
                        <h1><a href="index.html" class="logo">Portfolic <span>Portfolio Agency</span></a></h1>
                        <ul class="list-unstyled components mb-5">
                            <li class="active">
                                <a href="#"><span class="fa fa-home mr-3"></span> Home</a>
                            </li>
                            <li>
                                <a href="#"><span class="fa fa-user mr-3"></span> About</a>
                            </li>
                            <li>
                                <a href="#"><span class="fa fa-briefcase mr-3"></span> Works</a>
                            </li>
                            <li>
                                <a href="#"><span class="fa fa-sticky-note mr-3"></span> Blog</a>
                            </li>
                            <li>
                                <a href="#"><span class="fa fa-suitcase mr-3"></span> Gallery</a>
                            </li>
                            <li>
                                <a href="#"><span class="fa fa-cogs mr-3"></span> Services</a>
                            </li>
                            <li>
                                <a href="#"><span class="fa fa-paper-plane mr-3"></span> Contacts</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </aside> --}}
                <article class="col-12">
                    <div class="page-header d-print-none">
                        <div class="container-xl">
                            <div class="row g-2 align-items-center">
                                <div class="col">
                                    <h2 class="page-title">
                                        Welcome User Name!
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="page-body">
                        <div class="container-xl">
                            <div class="row row-cards">
                                <div class="col-md-6 col-xl-2">
                                    <a class="card card-link" href="#">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-users" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                                    </svg>
                                                </div>
                                                <div class="col">
                                                    <div class="font-weight-medium">Users</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xl-2">
                                    <a class="card card-link" href="#">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-user-circle"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="2" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                                        <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                                        <path
                                                            d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <div class="col">
                                                    <div class="font-weight-medium">Roles</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xl-2">
                                    <a class="card card-link" href="#">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-tower" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path
                                                            d="M5 3h1a1 1 0 0 1 1 1v2h3v-2a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v2h3v-2a1 1 0 0 1 1 -1h1a1 1 0 0 1 1 1v4.394a2 2 0 0 1 -.336 1.11l-1.328 1.992a2 2 0 0 0 -.336 1.11v7.394a1 1 0 0 1 -1 1h-10a1 1 0 0 1 -1 -1v-7.394a2 2 0 0 0 -.336 -1.11l-1.328 -1.992a2 2 0 0 1 -.336 -1.11v-4.394a1 1 0 0 1 1 -1z">
                                                        </path>
                                                        <path d="M10 21v-5a2 2 0 1 1 4 0v5"></path>
                                                    </svg>
                                                </div>
                                                <div class="col">
                                                    <div class="font-weight-medium">Human Resource</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xl-2">
                                    <a class="card card-link" href="#">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-user-check" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
                                                        <path d="M15 19l2 2l4 -4"></path>
                                                    </svg>
                                                </div>
                                                <div class="col">
                                                    <div class="font-weight-medium">Clients</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xl-2">
                                    <a class="card card-link" href="#">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-wrecking-ball"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="2" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M19 13m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                                        <path d="M4 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                                        <path d="M13 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                                        <path d="M13 19l-9 0"></path>
                                                        <path d="M4 15l9 0"></path>
                                                        <path d="M8 12v-5h2a3 3 0 0 1 3 3v5"></path>
                                                        <path d="M5 15v-2a1 1 0 0 1 1 -1h7"></path>
                                                        <path d="M19 11v-7l-6 7"></path>
                                                    </svg>
                                                </div>
                                                <div class="col">
                                                    <div class="font-weight-medium">Construction</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xl-2">
                                    <a class="card card-link" href="#">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-headset" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M4 14v-3a8 8 0 1 1 16 0v3"></path>
                                                        <path d="M18 19c0 1.657 -2.686 3 -6 3"></path>
                                                        <path
                                                            d="M4 14a2 2 0 0 1 2 -2h1a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-1a2 2 0 0 1 -2 -2v-3z">
                                                        </path>
                                                        <path
                                                            d="M15 14a2 2 0 0 1 2 -2h1a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-1a2 2 0 0 1 -2 -2v-3z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <div class="col">
                                                    <div class="font-weight-medium">Support System</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xl-2">
                                    <a class="card card-link" href="#">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-settings" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path
                                                            d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z">
                                                        </path>
                                                        <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                                                    </svg>
                                                </div>
                                                <div class="col">
                                                    <div class="font-weight-medium">Settings</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="container-xl mt-5">
                            <div class="row g-2 align-items-center">
                                <div class="col">
                                    <h2 class="page-title">
                                        Activity
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="page-body">
                            <div class="container-xl">
                                <div class="row ">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="divide-y"
                                                    style="
                          max-height: 200px;
                          overflow-y: scroll;
                      ">
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <span class="avatar">JL</span>
                                                            </div>
                                                            <div class="col">
                                                                <div class="text-truncate">
                                                                    <strong>Jeffie Lewzey</strong> commented on your
                                                                    <strong>"I'm not a witch."</strong> post.
                                                                </div>
                                                                <div class="text-muted">yesterday</div>
                                                            </div>
                                                            <div class="col-auto align-self-center">
                                                                <div class="badge bg-primary"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <span class="avatar"
                                                                    style="background-image: url(./static/avatars/002m.jpg)"></span>
                                                            </div>
                                                            <div class="col">
                                                                <div class="text-truncate">
                                                                    It's <strong>Mallory Hulme</strong>'s birthday. Wish
                                                                    him
                                                                    well!
                                                                </div>
                                                                <div class="text-muted">2 days ago</div>
                                                            </div>
                                                            <div class="col-auto align-self-center">
                                                                <div class="badge bg-primary"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <span class="avatar"
                                                                    style="background-image: url(./static/avatars/003m.jpg)"></span>
                                                            </div>
                                                            <div class="col">
                                                                <div class="text-truncate">
                                                                    <strong>Dunn Slane</strong> posted <strong>"Well,
                                                                        what
                                                                        do you want?"</strong>.
                                                                </div>
                                                                <div class="text-muted">today</div>
                                                            </div>
                                                            <div class="col-auto align-self-center">
                                                                <div class="badge bg-primary"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <span class="avatar"
                                                                    style="background-image: url(./static/avatars/000f.jpg)"></span>
                                                            </div>
                                                            <div class="col">
                                                                <div class="text-truncate">
                                                                    <strong>Emmy Levet</strong> created a new project
                                                                    <strong>Morning alarm clock</strong>.
                                                                </div>
                                                                <div class="text-muted">4 days ago</div>
                                                            </div>
                                                            <div class="col-auto align-self-center">
                                                                <div class="badge bg-primary"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <span class="avatar"
                                                                    style="background-image: url(./static/avatars/001f.jpg)"></span>
                                                            </div>
                                                            <div class="col">
                                                                <div class="text-truncate">
                                                                    <strong>Maryjo Lebarree</strong> liked your photo.
                                                                </div>
                                                                <div class="text-muted">2 days ago</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <span class="avatar">EP</span>
                                                            </div>
                                                            <div class="col">
                                                                <div class="text-truncate">
                                                                    <strong>Egan Poetz</strong> registered new client as
                                                                    <strong>Trilia</strong>.
                                                                </div>
                                                                <div class="text-muted">yesterday</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <span class="avatar"
                                                                    style="background-image: url(./static/avatars/002f.jpg)"></span>
                                                            </div>
                                                            <div class="col">
                                                                <div class="text-truncate">
                                                                    <strong>Kellie Skingley</strong> closed a new deal
                                                                    on
                                                                    project <strong>Pen Pineapple Apple Pen</strong>.
                                                                </div>
                                                                <div class="text-muted">2 days ago</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <span class="avatar"
                                                                    style="background-image: url(./static/avatars/003f.jpg)"></span>
                                                            </div>
                                                            <div class="col">
                                                                <div class="text-truncate">
                                                                    <strong>Christabel Charlwood</strong> created a new
                                                                    project for <strong>Wikibox</strong>.
                                                                </div>
                                                                <div class="text-muted">4 days ago</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <span class="avatar">HS</span>
                                                            </div>
                                                            <div class="col">
                                                                <div class="text-truncate">
                                                                    <strong>Haskel Shelper</strong> change status of
                                                                    <strong>Tabler Icons</strong> from
                                                                    <strong>open</strong>
                                                                    to <strong>closed</strong>.
                                                                </div>
                                                                <div class="text-muted">today</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <span class="avatar"
                                                                    style="background-image: url(./static/avatars/006m.jpg)"></span>
                                                            </div>
                                                            <div class="col">
                                                                <div class="text-truncate">
                                                                    <strong>Lorry Mion</strong> liked <strong>Tabler UI
                                                                        Kit</strong>.
                                                                </div>
                                                                <div class="text-muted">yesterday</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <span class="avatar"
                                                                    style="background-image: url(./static/avatars/004f.jpg)"></span>
                                                            </div>
                                                            <div class="col">
                                                                <div class="text-truncate">
                                                                    <strong>Leesa Beaty</strong> posted new video.
                                                                </div>
                                                                <div class="text-muted">2 days ago</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <span class="avatar"
                                                                    style="background-image: url(./static/avatars/007m.jpg)"></span>
                                                            </div>
                                                            <div class="col">
                                                                <div class="text-truncate">
                                                                    <strong>Perren Keemar</strong> and 3 others followed
                                                                    you.
                                                                </div>
                                                                <div class="text-muted">2 days ago</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <span class="avatar">SA</span>
                                                            </div>
                                                            <div class="col">
                                                                <div class="text-truncate">
                                                                    <strong>Sunny Airey</strong> upload 3 new photos to
                                                                    category <strong>Inspirations</strong>.
                                                                </div>
                                                                <div class="text-muted">2 days ago</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <span class="avatar"
                                                                    style="background-image: url(./static/avatars/009m.jpg)"></span>
                                                            </div>
                                                            <div class="col">
                                                                <div class="text-truncate">
                                                                    <strong>Geoffry Flaunders</strong> made a
                                                                    <strong>$10</strong> donation.
                                                                </div>
                                                                <div class="text-muted">2 days ago</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <span class="avatar"
                                                                    style="background-image: url(./static/avatars/010m.jpg)"></span>
                                                            </div>
                                                            <div class="col">
                                                                <div class="text-truncate">
                                                                    <strong>Thatcher Keel</strong> created a profile.
                                                                </div>
                                                                <div class="text-muted">3 days ago</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <span class="avatar"
                                                                    style="background-image: url(./static/avatars/005f.jpg)"></span>
                                                            </div>
                                                            <div class="col">
                                                                <div class="text-truncate">
                                                                    <strong>Dyann Escala</strong> hosted the event
                                                                    <strong>Tabler UI Birthday</strong>.
                                                                </div>
                                                                <div class="text-muted">4 days ago</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <span class="avatar"
                                                                    style="background-image: url(./static/avatars/006f.jpg)"></span>
                                                            </div>
                                                            <div class="col">
                                                                <div class="text-truncate">
                                                                    <strong>Avivah Mugleston</strong> mentioned you on
                                                                    <strong>Best of 2020</strong>.
                                                                </div>
                                                                <div class="text-muted">2 days ago</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-auto">
                                                                <span class="avatar">AA</span>
                                                            </div>
                                                            <div class="col">
                                                                <div class="text-truncate">
                                                                    <strong>Arlie Armstead</strong> sent a Review
                                                                    Request to
                                                                    <strong>Amanda Blake</strong>.
                                                                </div>
                                                                <div class="text-muted">2 days ago</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </section>
        </main>
    </div>



    </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
        crossorigin="anonymous"></script>
    <script src="{{ asset('assets/dist/js/tabler.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/demo.min.js?1674944402') }}" defer></script>
    <script src="{{ asset('assets/dist/js/demo-theme.min.js?1674944402') }}"></script>
    <script src="{{ asset('assets/js/vendor-all.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script>
        feather.replace();
    </script>
    <script>
        (function($) {

            "use strict";

            var fullHeight = function() {

                $('.js-fullheight').css('height', $(window).height());
                $(window).resize(function() {
                    $('.js-fullheight').css('height', $(window).height());
                });

            };
            fullHeight();

            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });

        })(jQuery);
    </script>



</body>
