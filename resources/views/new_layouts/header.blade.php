@php
    $users=\Auth::user();
    //$logo=asset(Storage::url('uploads/logo/'));
    $logo = \App\Models\Utility::get_file('uploads/logo');
    $languages=\App\Models\Utility::languages();
    $lang = isset($users->lang)?$users->lang:'en';
    $company_favicon = Utility::getValByName('company_favicon');
    $setting = \App\Models\Utility::colorset();
    $company_logo = \App\Models\Utility::GetLogo();
    $mode_setting = \App\Models\Utility::mode_layout();
    $color = !empty($setting['color']) ? $setting['color'] : 'theme-3';
    $profile=\App\Models\Utility::get_file('uploads/avatar/');
    $SITE_RTL = Utility::getValByName('SITE_RTL');

@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $SITE_RTL == 'on' ? 'rtl' : '' }}">


<meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">

<head>
    <title>
        {{ Utility::getValByName('title_text') ? Utility::getValByName('title_text') : config('app.name', 'Must BuildApp') }}
        - @yield('page-title')</title>
    {{-- <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script> --}}

    <script src="https://code.jquery.com/jquery-3.6.4.min.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
		


    <!-- Meta -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="url" content="{{ url('') . '/' . config('chatify.path') }}" data-user="{{ Auth::user()->id }}">
    <link rel="icon" href="{{ $logo . '/' . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png') }}" type="image" sizes="16x16">
    <!-- font css -->
    <link href="{{ asset('assets/dist/css/tabler.min.css?1674944402') }}" rel="stylesheet" />
    <link href="{{ asset('assets/dist/css/tabler-flags.min.css?1674944402') }}" rel="stylesheet" />
    <link href="{{ asset('assets/dist/css/tabler-payments.min.css?1674944402') }}" rel="stylesheet" />
    <link href="{{ asset('assets/dist/css/tabler-vendors.min.css?1674944402') }}" rel="stylesheet" />
    <link href="{{ asset('assets/dist/css/demo.min.css?1674944402') }}" rel="stylesheet" />
	<link href="{{ asset('assets/js/chosenjquery/chosen.css') }}" rel="stylesheet"/>
	<!-- font css -->
	{{-- <link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

	<link rel="stylesheet" href="{{ asset('assets/css/plugins/style.css') }}">

	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap.min.css">

	{{-- <script src="{{ asset('assets/js/plugins/simple-datatables.js') }}"></script> --}}
	{{-- <script src="{{ asset('assets/js/datatables.min.js') }}"></script>--}}

	<link rel="stylesheet" href="{{ asset('assets/css/plugins/style.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

	{{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}

	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

	<link href="https://harvesthq.github.io/chosen/chosen.css" rel="stylesheet"/>
	<script src="https://harvesthq.github.io/chosen/chosen.jquery.js"></script>
    <style>
         @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        :root {
            --tblr-font-sans-serif: 'Poppins', sans-serif;
        }
        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
		#lang{
			text-decoration: none;
		}
		.fa-globe{
			color:#616876 !important;
		}
		.swal2-confirm{
			margin-left:10px !important;
		}
		.error{
			color: red !important;
		}
		

    </style>

</head>
<body class=" d-flex flex-column">
	<div class="page">
		<!-- Navbar -->
		<header class="navbar navbar-expand-md navbar-light d-print-none">
			<div class="container-fluid">
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
				<h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <a href=".">

							@if($mode_setting['cust_darklayout'] && $mode_setting['cust_darklayout'] == 'on' )
								<img src="{{ $logo . '/' . (isset($company_logos) && !empty($company_logos) ? $company_logos : 'logo-dark.png') }}"
									alt="{{ config('app.name', 'Must BuildApp-SaaS') }}"  width="110" height="32" alt="Must BuildApp"
                            class="navbar-brand-image">
							@else
								<img src="{{ $logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png') }}"
									alt="{{ config('app.name', 'Must BuildApp-SaaS') }}"  width="110" height="32" alt="Must BuildApp"
                            class="navbar-brand-image">
							@endif
                    </a>
                </h1>
				<div class="navbar-nav flex-row order-md-last">
					<div class="nav-item d-none d-md-flex me-3"> </div>
					<div class="d-none d-md-flex">
						<a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
							<!-- Download SVG icon from http://tabler-icons.io/i/moon -->
							<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
								<path stroke="none" d="M0 0h24v24H0z" fill="none" />
								<path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" /> </svg>
						</a>
						<a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
							<!-- Download SVG icon from http://tabler-icons.io/i/sun -->
							<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
								<path stroke="none" d="M0 0h24v24H0z" fill="none" />
								<path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
								<path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" /> </svg>
						</a>
						<div class="nav-item dropdown d-none d-md-flex me-3">
							<a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
								<!-- Download SVG icon from http://tabler-icons.io/i/bell -->
								<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
									<path stroke="none" d="M0 0h24v24H0z" fill="none" />
									<path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
									<path d="M9 17v1a3 3 0 0 0 6 0v-1" /> </svg> <span class="badge bg-red"></span> </a>
							<div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Last updates</h3> </div>
									<div class="list-group list-group-flush list-group-hoverable">
										<div class="list-group-item">
											<div class="row align-items-center">
												<div class="col-auto"><span class="status-dot status-dot-animated bg-red d-block"></span> </div>
												<div class="col text-truncate"> <a href="#" class="text-body d-block">Example 1</a>
													<div class="d-block text-muted text-truncate mt-n1"> Change deprecated html tags to text decoration classes (#29604) </div>
												</div>
												<div class="col-auto">
													<a href="#" class="list-group-item-actions">
														<!-- Download SVG icon from http://tabler-icons.io/i/star -->
														<svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
															<path stroke="none" d="M0 0h24v24H0z" fill="none" />
															<path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /> </svg>
													</a>
												</div>
											</div>
										</div>
										<div class="list-group-item">
											<div class="row align-items-center">
												<div class="col-auto"><span class="status-dot d-block"></span></div>
												<div class="col text-truncate"> <a href="#" class="text-body d-block">Example 2</a>
													<div class="d-block text-muted text-truncate mt-n1"> justify-content:between ⇒ justify-content:space-between (#29734) </div>
												</div>
												<div class="col-auto">
													<a href="#" class="list-group-item-actions show">
														<!-- Download SVG icon from http://tabler-icons.io/i/star -->
														<svg xmlns="http://www.w3.org/2000/svg" class="icon text-yellow" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
															<path stroke="none" d="M0 0h24v24H0z" fill="none" />
															<path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /> </svg>
													</a>
												</div>
											</div>
										</div>
										<div class="list-group-item">
											<div class="row align-items-center">
												<div class="col-auto"><span class="status-dot d-block"></span></div>
												<div class="col text-truncate"> <a href="#" class="text-body d-block">Example 3</a>
													<div class="d-block text-muted text-truncate mt-n1"> Update change-version.js (#29736) </div>
												</div>
												<div class="col-auto">
													<a href="#" class="list-group-item-actions">
														<!-- Download SVG icon from http://tabler-icons.io/i/star -->
														<svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
															<path stroke="none" d="M0 0h24v24H0z" fill="none" />
															<path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /> </svg>
													</a>
												</div>
											</div>
										</div>
										<div class="list-group-item">
											<div class="row align-items-center">
												<div class="col-auto"><span class="status-dot status-dot-animated bg-green d-block"></span> </div>
												<div class="col text-truncate"> <a href="#" class="text-body d-block">Example 4</a>
													<div class="d-block text-muted text-truncate mt-n1"> Regenerate package-lock.json (#29730) </div>
												</div>
												<div class="col-auto">
													<a href="#" class="list-group-item-actions">
														<!-- Download SVG icon from http://tabler-icons.io/i/star -->
														<svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
															<path stroke="none" d="M0 0h24v24H0z" fill="none" />
															<path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /> </svg>
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
						<a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu"> <span class="avatar avatar-sm" > <img src="{{(!empty(\Auth::user()->avatar))? $profile.\Auth::user()->avatar: asset(Storage::url("uploads/avatar/avatar.png"))}}" class="img-fluid rounded-circle"></span>
							<div class="d-none d-xl-block ps-2">
								<div>{{\Auth::user()->name }}</div>
							</div>
						</a>
						<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow"> <a href="{{route('new_profile')}}" class="dropdown-item">{{__('Profile')}}</a>
							<div class="dropdown-divider"></div> <a href="{{route('company.settings')}}" class="dropdown-item">Settings</a> <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();" class="dropdown-item">{{__('Logout')}}</a>
							<form id="frm-logout" action="{{ route('logout') }}" method="POST" class="d-none"> {{ csrf_field() }} </form>
						</div>
					</div>
				</div>
			</div>
		</header>
		<header class="navbar-expand-md">
			<div class="collapse navbar-collapse" id="navbar-menu">
				<div class="navbar navbar-light">
					<div class="container-fluid">
						<ul class="navbar-nav">
							<li class="nav-item">
								<a class="nav-link" href="{{route('new_home')}}"> <span class="nav-link-icon d-md-none d-lg-inline-block">
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
                                    </span> <span class="nav-link-title">
                                        {{__('Home')}}
                                    </span> </a>
							</li>
						</ul>
						{{-- <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last">
							<form action="./" method="get" autocomplete="off" novalidate>
								<div class="input-icon"> <span class="input-icon-addon">
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
									<input type="text" value="" class="form-control" placeholder="Search…" aria-label="Search in website"> </div>
							</form>
						</div> --}}
						<div class="dropdown dash-h-item drp-language order-md-last">
							<a class="dash-head-link dropdown-toggle arrow-none me-0" id="lang" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
								<i class="fas fa-globe"></i>
                                <span class="drp-text hide-mob">{{Str::upper(isset($lang)?$lang:'en')}}</span>

                            </a>
							<div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                                @foreach($languages as $language)
                                    <a href="{{route('change.language',$language)}}"  class="dropdown-item @if($language == $lang) text-danger @endif">
                                        <span>{{Str::upper($language)}}</span>
                                    </a>
                                @endforeach
								<h></h>
                                @if(\Auth::user()->type=='super admin')
                                <a class="dropdown-item text-primary" href="{{route('manage.language',[isset($lang)?$lang:'en'])}}">{{ __('Manage Language ') }}</a>
                                @endif
                            </div>
						</div>
					</div>
				</div>
			</div>
		</header>

		<div class="modal fade" id="commonModal" tabindex="-1" role="dialog"
			aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel"></h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="body">
					</div>
				</div>
			</div>
		</div>
		<div class="position-fixed top-0 end-0 p-3" style="z-index: 99999">
			<div id="liveToast" class="toast text-white  fade" role="alert" aria-live="assertive" aria-atomic="true">
				<div class="d-flex">
					<div class="toast-body"> </div>
					<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
				</div>
			</div>
		</div>
