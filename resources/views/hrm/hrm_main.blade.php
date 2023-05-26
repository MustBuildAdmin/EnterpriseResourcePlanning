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
                {{-- <li>
                    <a href="#homeSubmenu"><span class="icon"><i class="ti ti-dashboard"></i></span><span class="list">Dashboard</span></a>
                </li> --}}

                <li class="{{ (Request::segment(1) == 'employee' ? 'active' : '')}}">
                    <a href="{{ route('hrm_dashboard') }}"><span
                            class="icon"><img src="assets/images/icons/dashboard.png"/>
                        </span><span class="list">{{ __('Dashboard') }}</span>
                    </a>
                </li>

                <li class="{{ (Request::segment(1) == 'employee' ? 'active' : '')}}">
                    @if (\Auth::user()->type == 'Employee')
                        @php
                            $employee = App\Models\Employee::where('user_id', \Auth::user()->id)->first();
                        @endphp
                        <a
                            href="{{ route('employee.show', \Illuminate\Support\Facades\Crypt::encrypt($employee->id)) }}"><span
                                class="icon"><i class="ti ti-users"></i>
                            </span><span class="list">{{ __('Employee') }}</span>
                        </a>
                    @else
                        <a href="{{ route('employee.index') }}"><span class="icon"><img src="assets/images/icons/employee.png"/></span><span
                                class="list">{{ __('Employee Setup') }}</span></a>
                    @endif
                </li>

                @if( Gate::check('manage set salary') || Gate::check('manage pay slip'))
                    <li class="{{ (Request::segment(1) == 'setsalary' || Request::segment(1) == 'payslip') ? 'active' : '' }}">
                        <a data-bs-target="#payslip_hrm_setup" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                            <span class="icon"><img src="assets/images/icons/money.png"/></span>
                            <span class="list">{{ __('Payroll Setup') }}</span>
                        </a>
                        <ul class="collapse list-unstyled" id="payslip_hrm_setup">
                            @can('manage set salary')
                                <li class="{{ (request()->is('setsalary*') ? 'active' : '') }}"><a href="{{ route('setsalary.index') }}">{{ __('Set salary') }}</a></li>
                            @endcan
                            @can('manage pay slip')
                                <li class="{{ (request()->is('payslip*') ? 'active' : '') }}"><a href="{{route('payslip.index')}}">{{ __('Payslip') }}</a></li>
                            @endcan
                        </ul>
                    </li>
                @endif

                @if( Gate::check('manage leave') || Gate::check('manage attendance'))
                    <li class="{{ (Request::segment(1) == 'leave' || Request::segment(1) == 'attendanceemployee') ? 'active' :'' }}">
                        <a data-bs-target="#hrm_leave_management_setup" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                            <span class="icon"><img src="assets/images/icons/leave.png"/></span>
                            <span class="list">{{ __('Leave Management') }}</span>
                        </a>
                        <ul class="collapse list-unstyled" id="hrm_leave_management_setup">
                            @can('manage leave')
                                <li class="{{ (Request::route()->getName() == 'leave.index') ?'active' :''}}"><a href="{{route('leave.index')}}">{{__('Manage Leave')}}</a></li>
                            @endcan
                            @can('manage attendance')
                                <li class="{{ (Request::segment(1) == 'attendanceemployee') ? 'active' : '' }}">
                                    <a data-bs-target="#attendanbce_setup" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                                        <span class="icon"><i class="ti ti-users"></i></span>
                                        <span class="list">{{__('Attendance')}}</span>
                                    </a>
                                    <ul class="collapse list-unstyled" id="attendanbce_setup">
                                        <li class="{{ (Request::route()->getName() == 'attendanceemployee.index' ? 'active' : '') }}"><a href="{{route('attendanceemployee.index')}}">{{__('Mark Attendance')}}</a></li>
                                        @can('create attendance')
                                            <li class="{{ (Request::route()->getName() == 'attendanceemployee.bulkattendance' ? 'active' : '') }}"><a href="{{ route('attendanceemployee.bulkattendance') }}">{{__('Bulk Attendance')}}</a></li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif

                <li class="{{ Request::segment(1) == 'holiday-calender' || Request::segment(1) == 'holiday' || Request::segment(1) == 'policies' ||
                    Request::segment(1) == 'award' || Request::segment(1) == 'transfer' || Request::segment(1) == 'resignation' || Request::segment(1) == 'travel' ||
                    Request::segment(1) == 'promotion' || Request::segment(1) == 'complaint' || Request::segment(1) == 'warning' || Request::segment(1) == 'termination' ||
                    Request::segment(1) == 'announcement' || Request::segment(1) == 'competencies' ? 'active' : '' }}">

                    <a data-bs-target="#pageSubmenu_admin_setup" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                        <span class="icon"><img src="assets/images/icons/hr-manager.png"/></span>
                        <span class="list">{{ __('HR Admin Setup') }}</span>
                    </a>
                    <ul class="collapse list-unstyled" id="pageSubmenu_admin_setup">
                        @can('manage award')
                            <li class="{{ Request::segment(1) == 'award' ? 'active' : '' }}"><a href="{{ url('award') }}">{{ __('Award') }}</a></li>
                        @endcan
                        @can('manage transfer')
                            <li class="{{ Request::segment(1) == 'transfer' ? 'active' : '' }}"><a href="{{ url('transfer') }}">{{ __('Transfer') }}</a></li>
                        @endcan
                        @can('manage resignation')
                            <li class="{{ Request::segment(1) == 'resignation' ? 'active' : '' }}"><a href="{{ url('resignation') }}">{{ __('Resignation') }}</a></li>
                        @endcan
                        @can('manage travel')
                            <li class="{{ Request::segment(1) == 'travel' ? 'active' : '' }}"><a href="{{ url('travel') }}">{{ __('Trip') }}</a></li>
                        @endcan
                        @can('manage promotion')
                            <li class="{{ Request::segment(1) == 'promotion' ? 'active' : '' }}"><a href="{{ url('promotion') }}" class="dropdown-item">{{ __('Promotion') }}</a></li>
                        @endcan
                        @can('manage complaint')
                            <li class="{{ Request::segment(1) == 'complaint' ? 'active' : '' }}"><a href="{{ url('complaint') }}" class="dropdown-item">{{ __('Complaints') }}</a></li>
                        @endcan
                        @can('manage warning')
                            <li class="{{ Request::segment(1) == 'warning' ? 'active' : '' }}"><a href="{{ url('warning') }}" class="dropdown-item">{{ __('Warning') }}</a></li>
                        @endcan
                        @can('manage termination')
                            <li class="{{ Request::segment(1) == 'termination' ? 'active' : '' }}"><a href="{{ url('termination') }}" class="dropdown-item">{{ __('Termination') }}</a></li>
                        @endcan
                        @can('manage announcement')
                            <li class="{{ Request::segment(1) == 'announcement' ? 'active' : '' }}"><a href="{{ url('announcement') }}" class="dropdown-item">{{ __('Announcement') }}</a>
                            </li>
                        @endcan
                        @can('manage holiday')
                            <li class="{{ Request::segment(1) == 'holiday' ? 'active' : '' }}"><a href="{{ url('holiday') }}" class="dropdown-item">{{ __('Holidays') }}</a></li>
                        @endcan
                    </ul>
                </li>

                {{-- <li>
                    <a href="#"><span class="icon"><i class="ti ti-calendar-event"></i></span><span class="list">Event and Meetings</span></a>
                </li> --}}

                @can('manage document')
                    <li class="{{ Request::segment(1) == 'hrm_doc_setup' ? 'active' : '' }}">
                        <a href="{{ url('hrm_doc_setup') }}"><span class="icon"><i
                                    class="ti ti-certificate"></i></span><span
                                class="list">{{ __('Document Setup') }}</span></a>
                    </li>
                @endcan

                @can('manage company policy')
                    <li class="{{ Request::segment(1) == 'hrm_company_policy' ? 'active' : '' }}">
                        <a href="{{ url('hrm_company_policy') }}"><span class="icon"><i
                                    class="ti ti-certificate"></i></span><span
                                class="list">{{ __('Company policy') }}</span></a>
                    </li>
                @endcan

                {{-- <li>
                    <a href="#"><span class="icon"> <img src="assets/images/icons/support.png"/></span><span
                            class="list">Resource Settings</span></a>
                </li> --}}

                <li
                    class="{{ Request::segment(1) == 'leavetype' ||
                    Request::segment(1) == 'document' ||
                    Request::segment(1) == 'performanceType' ||
                    Request::segment(1) == 'branch' ||
                    Request::segment(1) == 'department' ||
                    Request::segment(1) == 'designation' ||
                    Request::segment(1) == 'job-stage' ||
                    Request::segment(1) == 'performanceType' ||
                    Request::segment(1) == 'job-category' ||
                    Request::segment(1) == 'terminationtype' ||
                    Request::segment(1) == 'awardtype' ||
                    Request::segment(1) == 'trainingtype' ||
                    Request::segment(1) == 'goaltype' ||
                    Request::segment(1) == 'paysliptype' ||
                    Request::segment(1) == 'allowanceoption' ||
                    Request::segment(1) == 'loanoption' ||
                    Request::segment(1) == 'deductionoption'
                        ? 'active'
                        : '' }}">

                    <a data-bs-toggle="collapse" data-bs-target="#pageSubmenusystemsetup" role="button" aria-expanded="false"
                        aria-controls="pageSubmenusystemsetup"><span class="icon"><img src="assets/images/icons/support.png"/></span>
                        <span class="list">{{ __('Resource Settings') }}</span>
                    </a>
                    <ul class="accordion-collapse collapse list-unstyled" id="pageSubmenusystemsetup">
                        <li class="{{ Request::segment(1) == 'branch' ? 'active' : '' }}"><a
                                href="{{ route('branch.index') }}" class="dropdown-item">{{ __('Branch') }}</a></li>
                        <li class="{{ Request::segment(1) == 'department' ? 'active' : '' }}"><a
                                href="{{ route('department.index') }}"
                                class="dropdown-item">{{ __('Department') }}</a></li>
                        <li class="{{ Request::segment(1) == 'designation' ? 'active' : '' }}"><a
                                href="{{ route('designation.index') }}"
                                class="dropdown-item">{{ __('Designation') }}</a></li>
                        <li class="{{ Request::segment(1) == 'leavetype' ? 'active' : '' }}"><a
                                href="{{ route('leavetype.index') }}" class="dropdown-item">{{ __('Leave Type') }}</a>
                        </li>
                        <li class="{{ Request::segment(1) == 'document' ? 'active' : '' }}"><a
                                href="{{ route('document.index') }}"
                                class="dropdown-item">{{ __('Document Type') }}</a></li>
                        <li class="{{ Request::segment(1) == 'paysliptype' ? 'active' : '' }}"><a
                                href="{{ route('paysliptype.index') }}"
                                class="dropdown-item">{{ __('Payslip Type') }}</a></li>
                        <li class="{{ Request::segment(1) == 'allowanceoption' ? 'active' : '' }}"><a
                                href="{{ route('allowanceoption.index') }}"
                                class="dropdown-item">{{ __('Allowance Option') }}</a></li>
                        <li class="{{ Request::segment(1) == 'loanoption' ? 'active' : '' }}"><a
                                href="{{ route('loanoption.index') }}"
                                class="dropdown-item">{{ __('Loan Option') }}</a></li>
                        <li class="{{ Request::segment(1) == 'deductionoption' ? 'active' : '' }}"><a
                                href="{{ route('deductionoption.index') }}"
                                class="dropdown-item">{{ __('Deduction Option') }}</a></li>
                        <li class="{{ Request::segment(1) == 'goaltype' ? 'active' : '' }}"><a
                                href="{{ route('goaltype.index') }}" class="dropdown-item">{{ __('Goal Type') }}</a>
                        </li>
                        <li class="{{ Request::segment(1) == 'trainingtype' ? 'active' : '' }}"><a
                                href="{{ route('trainingtype.index') }}"
                                class="dropdown-item">{{ __('Training Type') }}</a></li>
                        <li class="{{ Request::segment(1) == 'awardtype' ? 'active' : '' }}"><a
                                href="{{ route('awardtype.index') }}"
                                class="dropdown-item">{{ __('Award Type') }}</a></li>
                        <li class="{{ Request::segment(1) == 'terminationtype' ? 'active' : '' }}"><a
                                href="{{ route('terminationtype.index') }}"
                                class="dropdown-item">{{ __('Termination Type') }}</a></li>
                        <li class="{{ Request::segment(1) == 'job-category' ? 'active' : '' }}"><a
                                href="{{ route('job-category.index') }}"
                                class="dropdown-item">{{ __('Job Category') }}</a></li>
                        <li class="{{ Request::segment(1) == 'job-stage' ? 'active' : '' }}"><a
                                href="{{ route('job-stage.index') }}"
                                class="dropdown-item">{{ __('Job Stage') }}</a></li>
                        <li class="{{ Request::segment(1) == 'performanceType' ? 'active' : '' }}"><a
                                href="{{ route('performanceType.index') }}"
                                class="dropdown-item">{{ __('Performance Type') }}</a></li>
                        <li class="{{ Request::segment(1) == 'competencies' ? 'active' : '' }}"><a
                                href="{{ route('competencies.index') }}"
                                class="dropdown-item">{{ __('Competencies') }}</a></li>
                    </ul>
                </li>

                @can('manage report')
                    <li class="{{ (Request::segment(1) == 'reports-monthly-attendance' || Request::segment(1) == 'reports-leave' || 
                        Request::segment(1) == 'reports-payroll') ? 'active dash-trigger' : ''}}">
                        <a data-bs-target="#hrm_reports" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                            <span class="icon"><img src="assets/images/icons/support.png"/></span>
                            <span class="list">{{ __('Reports') }}</span>
                        </a>
                        <ul class="collapse list-unstyled" id="hrm_reports">
                            <li class="{{ request()->is('reports-payroll') ? 'active' : '' }}"><a href="{{ route('report.payroll') }}">{{ __('Payroll') }}</a></li>
                            <li class="{{ request()->is('reports-leave') ? 'active' : '' }}"><a href="{{ route('report.leave') }}">{{ __('Leave') }}</a></li>
                            <li class="{{ request()->is('reports-monthly-attendance') ? 'active' : '' }}"><a href="{{ route('report.monthly.attendance') }}">{{ __('Monthly Attendance') }}</a></li>
                        </ul>
                    </li>
                @endcan
            </ul>
        </div>
    </nav>

    <!-- Page Content  -->
    <div id="content" class="main">
        
    
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
