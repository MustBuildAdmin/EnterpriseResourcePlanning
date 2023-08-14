<style>
.navbar-expand-lg {
	top: 8em !important;
}
</style>
@php
    $lang= Auth::user()->lang;
@endphp
<div class="page">
	<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
		<div class="container-fluid">
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse"
             data-bs-target="#sidebar-menu" aria-controls="sidebar-menu"
              aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
			<div class="collapse navbar-collapse" id="sidebar-menu">
				<ul class="navbar-nav pt-lg-3">
					<li class="{{ Request::segment(1) == 'employee' ? 'active nav-item' : 'nav-item' }}">
						<a href="{{ route('hrm_dashboard') }}" href="#" class="nav-link">
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
                            </span> <span class="nav-link-title"> {{ __('Dashboard') }} </span></a>
					</li>
					<li class="active nav-item dropdown">
						<a class="{{ Request::segment(1) == 'holiday-calender'
                            ? 'nav-link dropdown-toggle show'
                            : 'nav-link dropdown-toggle' }}" href="#hradmin_settings"
                             data-bs-toggle="dropdown" data-bs-auto-close="false"
                              role="button" aria-expanded="{{ Request::segment(1) == 'holiday-calender' ||
                            Request::segment(1) == 'holiday' ||
                            Request::segment(1) == 'policies'
                                ? 'true'
                                : 'false' }}">
							<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-settings"
                             width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                              fill="none" stroke-linecap="round" stroke-linejoin="round">
								<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
								<path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
								<path d="M12 10.5v1.5"></path>
								<path d="M12 16v1.5"></path>
								<path d="M15.031 12.25l-1.299 .75"></path>
								<path d="M10.268 15l-1.3 .75"></path>
								<path d="M15 15.803l-1.285 -.773"></path>
								<path d="M10.285 12.97l-1.285 -.773"></path>
								<path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
								<path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
							</svg>
                            <span class="nav-link-title">
                                {{ __('Diary') }}
                            </span>
                        </a>
						<div class="{{ Request::segment(1) == 'new_drawing' ||
                        Request::segment(1) == 'new_rfi' ||
                        Request::segment(1) == 'new_vo_change'
                            ? 'dropdown-menu show'
                            : 'dropdown-menu' }}" data-bs-popper="{{ Request::segment(1) == 'new_drawing' ||
                            Request::segment(1) == 'new_rfi' ||
                            Request::segment(1) == 'new_vo_change'
                                ? 'static'
                                : '' }}">
							<div class="dropdown-menu-columns">
								<div class="dropdown-menu-column">
                                    @can('manage resignation')
                                    <a class="{{ Request::segment(1) == 'new_drawing' ? 'active dropdown-item' :
                                    'dropdown-item' }}" href="{{ route('new_drawing') }}">
                                        {{ __('Drawing') }}
                                    </a>
                                @endcan
                                @can('manage award')
                                <a class="{{ Request::segment(1) == 'new_rfi' ? 'active dropdown-item' :
                                 'dropdown-item' }}" href="{{ route('new_rfi') }}">
                                    {{ __('RFI') }}
                                </a>
                                @endcan
                                @can('manage transfer')
                                <a class="{{ Request::segment(1) == 'new_vo_change' ? 'active dropdown-item' :
                                'dropdown-item' }}" href="{{ route('new_vo_change') }}">
                                    {{ __('VO Change Order') }}
                                </a>
                                @endcan
                            </div>
							</div>
						</div>
					</li>
					</li>
					</li>
				</ul>
			</div>
		</div>
	</aside>
	<!-- Page Content  -->
	<div class="page-wrapper">
        @isset($hrm_header)
		<h2 class="mb-4">{{ __($hrm_header) }}</h2>
        @endisset