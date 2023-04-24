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
                <li class="active">
                    <a href="#homeSubmenu"><span class="icon"><i class="ti ti-dashboard"></i></span><span
                            class="list">Dashboard</span></a>
                </li>

                <li>
                    @if (\Auth::user()->type == 'Employee')
                <li>
                    @php
                        $employee = App\Models\Employee::where('user_id', \Auth::user()->id)->first();
                    @endphp
                    <a href="{{ route('employee.show', \Illuminate\Support\Facades\Crypt::encrypt($employee->id)) }}"><span
                            class="icon"><i class="ti ti-users"></i>
                        </span><span class="list">{{ __('Employee') }}</span>
                    </a>
                </li>
            @else
                <li>
                    <a href="{{ route('employee.index') }}"><span class="icon"><i class="ti ti-users"></i></span><span
                            class="list">{{ __('Employee Setup') }}</span></a>
                </li>
                @endif
                </li>

                <li>
                    <a href="#"> <span class="icon"><i class="ti ti-calendar-stats"></i></span><span
                            class="list">Leave Management</span></a>
                </li>

                <li>
                    <a href="#"><span class="icon"><i class="ti ti-calendar-stats"></i></span><span
                            class="list">Payslips</span></a>
                </li>

                <li>
                    <a href="#"><span class="icon"><i class="ti ti-chart-infographic"></i></span><span
                            class="list">Reports</span></a>
                </li>

                <li>
                    <a href="#pageSubmenu_admin_setup" data-toggle="collapse" aria-expanded="false"
                        class="dropdown-toggle"><span class="icon"><i class="ti ti-users"></i></span>
                        <span class="list">{{ __('HR Admin Setup') }}</span>
                    </a>
                    <ul class="collapse list-unstyled" id="pageSubmenu_admin_setup">
                        @can('manage award')
                            <li><a href="{{ url('award') }}">{{ __('Award') }}</a></li>
                        @endcan
                        @can('manage transfer')
                            <li><a href="{{ url('transfer') }}">{{ __('Transfer') }}</a></li>
                        @endcan
                        @can('manage resignation')
                            <li><a href="{{ url('resignation') }}">{{ __('Resignation') }}</a></li>
                        @endcan
                        @can('manage travel')
                            <li><a href="{{ url('travel') }}">{{ __('Trip') }}</a></li>
                        @endcan
                        @can('manage promotion')
                            <li><a href="{{ url('promotion') }}" class="dropdown-item">{{ __('Promotion') }}</a>
                            </li>
                        @endcan
                        @can('manage complaint')
                            <li><a href="{{ url('complaint') }}" class="dropdown-item">{{ __('Complaints') }}</a>
                            </li>
                        @endcan
                        @can('manage warning')
                            <li><a href="{{ url('warning') }}" class="dropdown-item">{{ __('Warning') }}</a></li>
                        @endcan
                        @can('manage termination')
                            <li><a href="{{ url('termination') }}" class="dropdown-item">{{ __('Termination') }}</a></li>
                        @endcan
                        @can('manage announcement')
                            <li><a href="{{ url('announcement') }}" class="dropdown-item">{{ __('Announcement') }}</a>
                            </li>
                        @endcan
                        @can('manage holiday')
                            <li><a href="{{ url('holiday') }}" class="dropdown-item">{{ __('Holidays') }}</a></li>
                        @endcan
                    </ul>
                </li>

                <li>
                    <a href="#"><span class="icon"><i class="ti ti-calendar-event"></i></span><span
                            class="list">Event and Meetings</span></a>
                </li>

                @can('manage document')
                    <li>
                        <a href="{{ url('hrm_doc_setup') }}"><span class="icon"><i
                                    class="ti ti-certificate"></i></span><span
                                class="list">{{ __('Document Setup') }}</span></a>
                    </li>
                @endcan

                @can('manage company policy')
                    <li>
                        <a href="{{ url('hrm_company_policy') }}"><span class="icon"><i
                                    class="ti ti-certificate"></i></span><span
                                class="list">{{ __('Company policy') }}</span></a>
                    </li>
                @endcan

                <li>
                    <a href="#"><span class="icon"> <i class="ti ti-tool"></i></span><span
                            class="list">Resource Settings</span></a>
                </li>

                <li>
                    <a href="#pageSubmenu_system_setup" data-toggle="collapse" aria-expanded="false"
                        class="dropdown-toggle"><span class="icon"><i class="ti ti-users"></i></span>
                        <span class="list">{{ __('HRM System Setup') }}</span>
                    </a>
                    <ul class="collapse list-unstyled" id="pageSubmenu_system_setup">
                        <li><a href="{{ route('branch.index') }}" class="dropdown-item">{{ __('Branch') }}</a></li>
                        <li><a href="{{ route('department.index') }}" class="dropdown-item">{{ __('Department') }}</a>
                        </li>
                        <li><a href="{{ route('designation.index') }}"
                                class="dropdown-item">{{ __('Designation') }}</a></li>
                        <li><a href="{{ route('leavetype.index') }}" class="dropdown-item">{{ __('Leave Type') }}</a>
                        </li>
                        <li><a href="{{ route('document.index') }}"
                                class="dropdown-item">{{ __('Document Type') }}</a></li>
                        <li><a href="{{ route('paysliptype.index') }}"
                                class="dropdown-item">{{ __('Payslip Type') }}</a></li>
                        <li><a href="{{ route('allowanceoption.index') }}"
                                class="dropdown-item">{{ __('Allowance Option') }}</a></li>
                        <li><a href="{{ route('loanoption.index') }}"
                                class="dropdown-item">{{ __('Loan Option') }}</a></li>
                        <li><a href="{{ route('deductionoption.index') }}"
                                class="dropdown-item">{{ __('Deduction Option') }}</a></li>
                        <li><a href="{{ route('goaltype.index') }}" class="dropdown-item">{{ __('Goal Type') }}</a>
                        </li>
                        <li><a href="{{ route('trainingtype.index') }}"
                                class="dropdown-item">{{ __('Training Type') }}</a></li>
                        <li><a href="{{ route('awardtype.index') }}"
                                class="dropdown-item">{{ __('Award Type') }}</a></li>
                        <li><a href="{{ route('terminationtype.index') }}"
                                class="dropdown-item">{{ __('Termination Type') }}</a></li>
                        <li><a href="{{ route('job-category.index') }}"
                                class="dropdown-item">{{ __('Job Category') }}</a></li>
                        <li><a href="{{ route('job-stage.index') }}" class="dropdown-item">{{ __('Job Stage') }}</a>
                        </li>
                        <li><a href="{{ route('performanceType.index') }}"
                                class="dropdown-item">{{ __('Performance Type') }}</a></li>
                        <li><a href="{{ route('competencies.index') }}"
                                class="dropdown-item">{{ __('Competencies') }}</a></li>
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
