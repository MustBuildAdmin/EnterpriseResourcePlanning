<style>
    /* pagination */
    .pagination {
        height: 36px;
        margin: 18px 0;
        color: #6c58bF;
    }

    .pagination ul {
        display: inline-block;
        *display: inline;
        /* IE7 inline-block hack */
        *zoom: 1;
        margin-left: 0;
        color: #ffffff;
        margin-bottom: 0;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .pagination li {
        display: inline;
        color: #6c58bF;
    }

    .pagination a {
        float: left;
        padding: 0 14px;
        line-height: 34px;
        color: #6c58bF;
        text-decoration: none;
        border: 1px solid #ddd;
        border-left-width: 0;
    }

    .pagination a:hover,
    .pagination .active a {
        background-color: var(--tblr-pagination-active-bg);
        color: #ffffff;
    }

    .pagination a:focus {
        background-color: #ffffff;
        color: #ffffff;
    }


    .pagination .active a {
        color: #ffffff;
        cursor: default;
    }

    .pagination .disabled span,
    .pagination .disabled a,
    .pagination .disabled a:hover {
        color: #999999;
        background-color: transparent;
        cursor: default;
    }

    .pagination li:first-child a {
        border-left-width: 1px;
        -webkit-border-radius: 3px 0 0 3px;
        -moz-border-radius: 3px 0 0 3px;
        border-radius: 3px 0 0 3px;
    }

    .pagination li:last-child a {
        -webkit-border-radius: 0 3px 3px 0;
        -moz-border-radius: 0 3px 3px 0;
        border-radius: 0 3px 3px 0;
    }

    .pagination-centered {
        text-align: center;
    }

    .pagination-right {
        text-align: right;
    }

    .pager {
        margin-left: 0;
        margin-bottom: 18px;
        list-style: none;
        text-align: center;
        color: #6c58bF;
        *zoom: 1;
    }

    .pager:before,
    .pager:after {
        display: table;
        content: "";
    }

    .pager:after {
        clear: both;
    }

    .pager li {
        display: inline;
        color: #6c58bF;
    }

    .pager a {
        display: inline-block;
        padding: 5px 14px;
        color: #6c58bF;
        background-color: #fff;
        border: 1px solid #ddd;
        -webkit-border-radius: 15px;
        -moz-border-radius: 15px;
        border-radius: 15px;
    }

    .pager a:hover {
        text-decoration: none;
        background-color: #f5f5f5;
    }

    .pager .next a {
        float: right;
    }

    .pager .previous a {
        float: left;
    }

    .pager .disabled a,
    .pager .disabled a:hover {
        color: #999999;
    }

    .dataTables_wrapper .dataTables_paginate {
        float: right;
        text-align: right;
        padding-top: 0.25em;
    }
</style>

<div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar">
        <div class="sidebar">
            <ul class="list-unstyled components nav nav-sidebar">
                {{-- Planning --}}
                <li class="">
                    <a data-bs-toggle="collapse" data-bs-target="#pageSubmenuplanning" role="button" aria-expanded="false"
                        aria-controls="pageSubmenuplanning"><span class="icon"><img src="{{asset('assets/images/icons/support.png')}}"/></span>
                        <span class="list">{{ __('Planning') }}</span>
                    </a>
                    <ul class="accordion-collapse collapse list-unstyled" id="pageSubmenuplanning">
                        {{-- <li class="">
                            <a href="# " class="dropdown-item">{{ __('Productivity') }}</a>
                        </li> --}}
                        <li class="">
                            <a href="{{ route('taskBoard.view',['list']) }}" class="dropdown-item">{{ __('Task') }}</a>
                        </li>
                        <li class="">
                            <a href="{{ route('task.newcalendar',['all']) }}" class="dropdown-item">{{ __('Task Calendar') }}</a>
                        </li>
                        <li class="">
                            <a href="{{route('project_report.index')}}" class="dropdown-item">{{ __('Project Reports') }}</a>
                        </li>
                    </ul>
                </li>

                {{-- Dairy --}}
                <li class="">
                    <a data-bs-toggle="collapse" data-bs-target="#pageSubmenuDairy" role="button" aria-expanded="false"
                        aria-controls="pageSubmenuDairy"><span class="icon"><img src="{{asset('assets/images/icons/support.png')}}"/></span>
                        <span class="list">{{ __('Dairy') }}</span>
                    </a>
                    <ul class="accordion-collapse collapse list-unstyled" id="pageSubmenuDairy">
                        <li class="">
                            <a href="#" class="dropdown-item">{{ __('Drawing') }}</a>
                        </li>
                        <li class="">
                            <a href="#" class="dropdown-item">{{ __('Site Reports') }}</a>
                        </li>
                        <li class="">
                            <a href="#" class="dropdown-item">{{ __('VO/Change Order') }}</a>
                        </li>
                        <li class="">
                            <a href="#" class="dropdown-item">{{ __('Directions') }}</a>
                        </li>
                        <li class="">
                            <a href="#" class="dropdown-item">{{ __('RFI') }}</a>
                        </li>
                        <li class="">
                            <a href="#" class="dropdown-item">{{ __('RAF/RAM') }}</a>
                        </li>
                        <li class="">
                            <a href="#" class="dropdown-item">{{ __('Procurement Material Supply Log') }}</a>
                        </li>
                    </ul>
                </li>

                {{-- QA and QC --}}
                <li class="">
                    <a data-bs-target="#submenuQaAndQc" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                        <span class="icon"><img src="{{asset('assets/images/icons/leave.png')}}"/></span>
                        <span class="list">{{ __('QA and QC') }}</span>
                    </a>
                    <ul class="collapse list-unstyled" id="submenuQaAndQc">
                        <li class="">
                            <a data-bs-target="#submenuTesting" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                                <span class="icon"><i class="ti ti-users"></i></span>
                                <span class="list">{{__('Testing ')}}</span>
                            </a>
                            <ul class="collapse list-unstyled" id="submenuTesting">
                                <li class=""><a href="">{{__('Concrete')}}</a></li>
                                <li class=""><a href="">{{__('Bricks')}}</a></li>
                                <li class=""><a href="">{{__('Cement')}}</a></li>
                                <li class=""><a href="">{{__('Sand')}}</a></li>
                                <li class=""><a href="">{{__('Steel')}}</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                {{-- Contracts --}}
                <li class="">
                    <a data-bs-target="#submenuContracts" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                        <span class="icon"><img src="{{asset('assets/images/icons/leave.png')}}"/></span>
                        <span class="list">{{ __('Contracts') }}</span>
                    </a>
                    <ul class="collapse list-unstyled" id="submenuContracts">
                        <li class="">
                            <a data-bs-target="#submenuTender" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                                <span class="icon"><i class="ti ti-users"></i></span>
                                <span class="list">{{__('Tender')}}</span>
                            </a>
                            <ul class="collapse list-unstyled" id="submenuTender">
                                <li class=""><a href="">{{__('BOQ')}}</a></li>
                               
                            </ul>
                        </li>
                        <li class="">
                            <a data-bs-target="#submenuTender1" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                                <span class="icon"><i class="ti ti-users"></i></span>
                                <span class="list">{{__('Claims/Payment Certificate')}}</span>
                            </a>
                        </li>
                        <li class="">
                            <a data-bs-target="#submenuMaterial" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                                        <span class="icon"><i class="ti ti-users"></i></span>
                                        <span class="list">{{__('Material ')}}</span>
                            </a>
                            <ul class="collapse list-unstyled" id="submenuTender">
                            <li class="">
                                    <ul class="collapse list-unstyled" id="submenuMaterial">
                                        <li class=""><a href="">{{__('Reports')}}</a></li>
                                        <li class=""><a href="">{{__('Reconcilation')}}</a></li>
                                        <li class=""><a href="">{{__('EOT-Extension of time')}}</a></li>
                                    </ul>
                                </li>
                            </ul>
                           
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Page Content  -->
    <div id="content" class="main">
        <div class="collapseToggle">
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
