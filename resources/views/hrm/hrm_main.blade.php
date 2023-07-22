><style>
       .navbar-expand-lg {
        top: 8em !important;
    }

</style>

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
