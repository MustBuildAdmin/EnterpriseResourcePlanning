@php $lang= Auth::user()->lang; @endphp
<style>
    .navbar-expand-lg {
        top: 4.8em !important;
    }

    a.nav-link.active {
        background: #206bc4 !important;
        color: #fff !important;
    }

    a.nav-link.actives {
        background: #206bc4 !important;
        color: #fff !important;
    }
</style>
<div class="page">
    <header class="navbar navbar-expand-md  d-print-none border-bottom" data-bs-theme="light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
                aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="sidebar-menu">
                <ul class="navbar-nav pt-lg-3">

                    <!--Dashboard Menu Starts-->
                    <li>
                        <a href="{{ route('hrm_dashboard') }}"
                            class="{{ Request::segment(1) == 'hrm_dashboard' ? 'nav-link active' : 'nav-link' }}">
                            <span class=" d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-adjustments-check" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 10a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                    <path d="M6 4v4"></path>
                                    <path d="M6 12v8"></path>
                                    <path d="M13.823 15.176a2 2 0 1 0 -2.638 2.651"></path>
                                    <path d="M12 4v10"></path>
                                    <path d="M16 7a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                    <path d="M18 4v1"></path>
                                    <path d="M18 9v5"></path>
                                    <path d="M15 19l2 2l4 -4"></path>
                                </svg>
                            </span>
                            <span class="nav-link-title"> {{ __('Dashboard') }}</span>
                        </a>
                    </li>
                    <!--Dashboard Menu Ends-->

                    <!--Employee Setup Starts-->
                    @if (Gate::check('manage vender'))
                        <li>
                            @if (\Auth::user()->type == 'Employee')
                                @php
                                    $employee = App\Models\Employee::where('user_id', \Auth::user()->id)->first();
                                @endphp
                                <a href="{{ route('employee.show', \Illuminate\Support\Facades\Crypt::encrypt($employee->id)) }}"
                                    class="{{ Request::route()->getName() == 'employee.*' ? 'nav-link active' : 'nav-link' }}">
                                    <span class=" d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-users" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                        </svg>
                                    </span>
                                    <span class="nav-link-title"> {{ __('Employee') }}</span>
                                </a>
                            @else
                                <a href="{{ route('employee.index') }}"
                                    class="{{ request()->is('employee*') ? 'nav-link active' : 'nav-link' }}">
                                    <span class=" d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-users" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">{{ __('Employee Setup') }}</span>
                                </a>
                            @endif
                        </li>
                    @endif
                    <!--Employee Setup Ends-->

                    <!--Payrolls setup Starts-->
                    @if (Gate::check('manage set salary') || Gate::check('manage pay slip'))
                        <li class="nav-item dropdown">
                            <a class="{{ Request::segment(1) == 'setsalary' || Request::segment(1) == 'payslip'
                                ? 'nav-link active dropdown-toggle'
                                : 'nav-link dropdown-toggle' }}"
                                href="#income" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button"
                                aria-expanded="false">
                                <span class=" d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-arrow-autofit-content" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M6 4l-3 3l3 3"></path>
                                        <path d="M18 4l3 3l-3 3"></path>
                                        <path d="M4 14m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v2a2 2 0 0 1
                                        -2 2h-12a2 2 0 0 1 -2 -2z"></path>
                                        <path d="M10 7h-7"></path>
                                        <path d="M21 7h-7"></path>
                                    </svg>
                                </span>
                                <span class="nav-link-title">{{ __('Payroll Setup') }}</span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <!--Branch Starts-->
                                        @can('manage set salary')
                                            <a class="{{ Request::segment(1) == 'setsalary' ? 'dropdown-item active' : 'dropdown-item' }}"
                                                href="{{ route('setsalary.index') }}">
                                                {{ __('Set salary') }}
                                            </a>
                                        @endcan
                                        <!--Branch Ends-->

                                        <!--Designation Starts-->
                                        @can('manage pay slip')
                                            <a class="{{ Request::segment(1) == 'payslip' ? 'dropdown-item active' : 'dropdown-item' }}"
                                                href="{{ route('payslip.index') }}">
                                                {{ __('Payslip') }}
                                            </a>
                                        @endcan
                                        <!--Designation Ends-->

                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif
                    <!--Payrolls setup Ends-->

                    <!--Manage Leave Starts-->
                    @if( Gate::check('manage leave') || Gate::check('manage attendance'))
                    <li class="nav-item dropdown">
                        <a class="{{ Request::route()->getName() == 'leave.index' ||
                        Request::route()->getName() == 'attendanceemployee.index' ||
                        Request::route()->getName() == 'attendanceemployee.bulkattendance'
                            ? 'nav-link active dropdown-toggle'
                            : 'nav-link dropdown-toggle' }}"
                            href="#income" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button"
                            aria-expanded="false">
                            <span class=" d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-arrow-autofit-content" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M6 4l-3 3l3 3"></path>
                                    <path d="M18 4l3 3l-3 3"></path>
                                    <path d="M4 14m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v2a2 2 0 0 1
                                    -2 2h-12a2 2 0 0 1 -2 -2z"></path>
                                    <path d="M10 7h-7"></path>
                                    <path d="M21 7h-7"></path>
                                </svg>
                            </span>
                            <span class="nav-link-title">{{ __('Manage Leave') }}</span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">

                                    <a class="{{ Request::route()->getName() == 'leave.index' ? 'dropdown-item active' : 'dropdown-item' }}"
                                        href="{{ route('leave.index') }}">
                                        {{ __('Leave') }}
                                    </a>

                                    <!--Branch Starts-->
                                    @can('manage set salary')
                                        <a class="{{ Request::route()->getName() == 'attendanceemployee.index' ? 'dropdown-item active' : 'dropdown-item' }}"
                                            href="{{ route('attendanceemployee.index') }}">
                                            {{ __('Mark Attendance') }}
                                        </a>
                                    @endcan
                                    <!--Branch Ends-->

                                    <!--Designation Starts-->
                                    @can('manage pay slip')
                                        <a class="{{ Request::route()->getName() == 'attendanceemployee.bulkattendance' ? 'dropdown-item active' : 'dropdown-item' }}"
                                            href="{{ route('attendanceemployee.bulkattendance') }}">
                                            {{ __('Bulk Attendance') }}
                                        </a>
                                    @endcan
                                    <!--Designation Ends-->

                                </div>
                            </div>
                        </div>
                    </li>
                    @endif

                    @if( Gate::check('manage indicator') || Gate::check('manage appraisal') || Gate::check('manage goal tracking'))
                    <li class="nav-item dropdown">
                        <a class="{{ Request::route()->getName() == 'indicator.index' ||
                        Request::route()->getName() == 'appraisal.index' ||
                        Request::route()->getName() == 'goaltracking.index'
                            ? 'nav-link active dropdown-toggle'
                            : 'nav-link dropdown-toggle' }}"
                            href="#income" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button"
                            aria-expanded="false">
                            <span class=" d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-arrow-autofit-content" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M6 4l-3 3l3 3"></path>
                                    <path d="M18 4l3 3l-3 3"></path>
                                    <path d="M4 14m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v2a2 2 0 0 1
                                    -2 2h-12a2 2 0 0 1 -2 -2z"></path>
                                    <path d="M10 7h-7"></path>
                                    <path d="M21 7h-7"></path>
                                </svg>
                            </span>
                            <span class="nav-link-title">{{ __('Performance Setup') }}</span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    <!--Branch Starts-->
                                    @can('manage set salary')
                                        <a class="{{ Request::route()->getName() == 'indicator.index' ? 'dropdown-item active' : 'dropdown-item' }}"
                                            href="{{ route('indicator.index') }}">
                                            {{ __('Indicator') }}
                                        </a>
                                    @endcan
                                    <!--Branch Ends-->

                                    <!--Designation Starts-->
                                    @can('manage pay slip')
                                        <a class="{{ Request::route()->getName() == 'appraisal.index' ? 'dropdown-item active' : 'dropdown-item' }}"
                                            href="{{ route('appraisal.index') }}">
                                            {{ __('Appraisal') }}
                                        </a>
                                    @endcan

                                    @can('manage pay slip')
                                        <a class="{{ Request::route()->getName() == 'goaltracking.index' ? 'dropdown-item active' : 'dropdown-item' }}"
                                            href="{{ route('goaltracking.index') }}">
                                            {{ __('Goal Tracking') }}
                                        </a>
                                    @endcan
                                    <!--Designation Ends-->

                                </div>
                            </div>
                        </div>
                    </li>
                    @endif

                    @if( Gate::check('manage training')
                            || Gate::check('manage trainer')
                            || Gate::check('show training'))
                    <li class="nav-item dropdown">
                        <a class="{{ Request::route()->getName() == 'indicator.index' ||
                        Request::route()->getName() == 'appraisal.index' ||
                        Request::route()->getName() == 'goaltracking.index'
                            ? 'nav-link active dropdown-toggle'
                            : 'nav-link dropdown-toggle' }}"
                            href="#income" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button"
                            aria-expanded="false">
                            <span class=" d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-arrow-autofit-content" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M6 4l-3 3l3 3"></path>
                                    <path d="M18 4l3 3l-3 3"></path>
                                    <path d="M4 14m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v2a2 2 0 0 1
                                    -2 2h-12a2 2 0 0 1 -2 -2z"></path>
                                    <path d="M10 7h-7"></path>
                                    <path d="M21 7h-7"></path>
                                </svg>
                            </span>
                            <span class="nav-link-title">{{ __('Training Setup') }}</span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    <!--Training List Starts-->
                                    @can('manage training')
                                        <a class="{{ Request::route()->getName() == 'training.index' ? 'dropdown-item active' : 'dropdown-item' }}"
                                            href="{{ route('training.index') }}">
                                            {{ __('Training List') }}
                                        </a>
                                    @endcan
                                    <!--Training List Ends-->

                                    <!--Trainer Starts-->
                                    @can('manage trainer')
                                        <a class="{{ Request::route()->getName() == 'trainer.index' ? 'dropdown-item active' : 'dropdown-item' }}"
                                            href="{{ route('trainer.index') }}">
                                            {{ __('Trainer') }}
                                        </a>
                                    @endcan
                                    <!--Trainer Ends-->

                                </div>
                            </div>
                        </div>
                    </li>
                    @endif



                    <!--HRM Setup Starts-->
                    @if (Gate::check('manage award') ||
                        Gate::check('manage transfer') ||
                        Gate::check('manage resignation') ||
                        Gate::check('manage travel') ||
                        Gate::check('manage travel') ||
                        Gate::check('manage promotion') ||
                        Gate::check('manage complaint') ||
                        Gate::check('manage warning') ||
                        Gate::check('manage termination') ||
                        Gate::check('manage announcement') ||
                        Gate::check('manage holiday'))
                        <li class="nav-item dropdown">
                            <a class="{{ Request::segment(1) == 'award' ||
                            Request::segment(1) == 'transfer' ||
                            Request::segment(1) == 'resignation' ||
                            Request::segment(1) == 'travel' ||
                            Request::segment(1) == 'promotion' ||
                            Request::segment(1) == 'complaint' ||
                            Request::segment(1) == 'warning' ||
                            Request::segment(1) == 'termination' ||
                            Request::segment(1) == 'announcement' ||
                            Request::segment(1) == 'holiday'
                                ? 'nav-link active dropdown-toggle'
                                : 'nav-link dropdown-toggle' }}"
                                href="#banking" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                                role="button" aria-expanded="false">
                                <span class=" d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-building-bank" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M3 21l18 0"></path>
                                        <path d="M3 10l18 0"></path>
                                        <path d="M5 6l7 -3l7 3"></path>
                                        <path d="M4 10l0 11"></path>
                                        <path d="M20 10l0 11"></path>
                                        <path d="M8 14l0 3"></path>
                                        <path d="M12 14l0 3"></path>
                                        <path d="M16 14l0 3"></path>
                                    </svg>
                                </span>
                                <span class="nav-link-title"> {{ __('HR Admin Setup') }}</span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">

                                        <!--Award Starts-->
                                        @can('manage award')
                                            <a class="{{ Request::segment(1) == 'award' ? 'dropdown-item active' : 'dropdown-item' }}"
                                                href="{{ url('award') }}">
                                                {{ __('Award') }}
                                            </a>
                                        @endcan
                                        <!--Award Ends-->

                                        <!--Transfer Starts-->
                                        @can('manage transfer')
                                            <a class="{{ Request::segment(1) == 'transfer' ? 'dropdown-item active' : 'dropdown-item' }}"
                                                href="{{ url('transfer') }}">
                                                {{ __('Transfer') }}
                                            </a>
                                        @endcan
                                        <!--Transfer Ends-->

                                        <!--Resignation Starts-->
                                        @can('manage resignation')
                                            <a class="{{ Request::segment(1) == 'resignation' ? 'dropdown-item active' : 'dropdown-item' }}"
                                                href="{{ url('resignation') }}">
                                                {{ __('Resignation') }}
                                            </a>
                                        @endcan
                                        <!--Resignation Ends-->

                                        <!--Travel Starts-->
                                        @can('manage travel')
                                            <a class="{{ Request::segment(1) == 'travel' ? 'dropdown-item active' : 'dropdown-item' }}"
                                                href="{{ url('travel') }}">
                                                {{ __('Trip') }}
                                            </a>
                                        @endcan
                                        <!--Travel Ends-->

                                        <!--Promotion Starts-->
                                        @can('manage promotion')
                                            <a class="{{ Request::segment(1) == 'promotion' ? 'dropdown-item active' : 'dropdown-item' }}"
                                                href="{{ url('promotion') }}">
                                                {{ __('Promotion') }}
                                            </a>
                                        @endcan
                                        <!--Promotion Ends-->

                                        <!--Complaint Starts-->
                                        @can('manage complaint')
                                            <a class="{{ Request::segment(1) == 'complaint' ? 'dropdown-item active' : 'dropdown-item' }}"
                                                href="{{ url('complaint') }}">
                                                {{ __('Complaints') }}
                                            </a>
                                        @endcan
                                        <!--Complaint Ends-->

                                        <!--Warning Starts-->
                                        @can('manage warning')
                                            <a class="{{ Request::segment(1) == 'warning' ? 'dropdown-item active' : 'dropdown-item' }}"
                                                href="{{ url('warning') }}">
                                                {{ __('Warning') }}
                                            </a>
                                        @endcan
                                        <!--Warning Ends-->

                                        <!--Termination Starts-->
                                        @can('manage termination')
                                            <a class="{{ Request::segment(1) == 'termination' ? 'dropdown-item active' : 'dropdown-item' }}"
                                                href="{{ url('termination') }}">
                                                {{ __('Termination') }}
                                            </a>
                                        @endcan
                                        <!--Termination Ends-->

                                        <!--Announcement Starts-->
                                        @can('manage announcement')
                                            <a class="{{ Request::segment(1) == 'announcement' ? 'dropdown-item active' : 'dropdown-item' }}"
                                                href="{{ url('announcement') }}">
                                                {{ __('Announcement') }}
                                            </a>
                                        @endcan
                                        <!--Announcement Ends-->

                                        <!--Holidays Starts-->
                                        @can('manage holiday')
                                            <a class="{{ Request::segment(1) == 'holiday' ? 'dropdown-item active' : 'dropdown-item' }}"
                                                href="{{ url('holiday') }}">
                                                {{ __('Holidays') }}
                                            </a>
                                        @endcan
                                        <!--Holidays Ends-->


                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif
                    <!--HRM Setup ends-->

                    <!--Resource Settings Starts-->
                    @if (Gate::check('manage invoice') || Gate::check('manage revenue') || Gate::check('manage credit note'))
                        <li class="nav-item dropdown">
                            <a class="{{ Request::segment(1) == 'branch' ||
                            Request::segment(1) == 'designation' ||
                            Request::segment(1) == 'leavetype' ||
                            Request::segment(1) == 'document' ||
                            Request::segment(1) == 'paysliptype' ||
                            Request::segment(1) == 'allowanceoption' ||
                            Request::segment(1) == 'loanoption' ||
                            Request::segment(1) == 'deductionoption' ||
                            Request::segment(1) == 'goaltype' ||
                            Request::segment(1) == 'trainingtype' ||
                            Request::segment(1) == 'awardtype' ||
                            Request::segment(1) == 'terminationtype' ||
                            Request::segment(1) == 'job-category' ||
                            Request::segment(1) == 'job-stage' ||
                            Request::segment(1) == 'performanceType' ||
                            Request::segment(1) == 'competencies'
                                ? 'nav-link active dropdown-toggle'
                                : 'nav-link dropdown-toggle' }}"
                                href="#income" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button"
                                aria-expanded="false">
                                <span class=" d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-arrow-autofit-content" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M6 4l-3 3l3 3"></path>
                                        <path d="M18 4l3 3l-3 3"></path>
                                        <path d="M4 14m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v2a2 2 0 0 1
                             -2 2h-12a2 2 0 0 1 -2 -2z"></path>
                                        <path d="M10 7h-7"></path>
                                        <path d="M21 7h-7"></path>
                                    </svg>
                                </span>
                                <span class="nav-link-title"> {{ __('Resource Settings') }}</span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <!--Branch Starts-->
                                        <a class="{{ Request::segment(1) == 'branch' ? 'dropdown-item active' : 'dropdown-item' }}"
                                            href="{{ route('branch.index') }}">
                                            {{ __('Branch') }}
                                        </a>
                                        <!--Branch Ends-->

                                        <!--Designation Starts-->
                                        <a class="{{ Request::segment(1) == 'designation' ? 'dropdown-item active' : 'dropdown-item' }}"
                                            href="{{ route('designation.index') }}">
                                            {{ __('Designation') }}
                                        </a>
                                        <!--Designation Ends-->

                                        <!--Leave Type Starts-->
                                        <a class="{{ Request::segment(1) == 'leavetype' ? 'dropdown-item active' : 'dropdown-item' }}"
                                            href="{{ route('leavetype.index') }}">
                                            {{ __('Leave Type') }}
                                        </a>
                                        <!--Leave Type Ends-->

                                        <!--Document Typee Starts-->
                                        <a class="{{ Request::segment(1) == 'document' ? 'dropdown-item active' : 'dropdown-item' }}"
                                            href="{{ route('document.index') }}">
                                            {{ __('Document Type') }}
                                        </a>
                                        <!--Document Typee Ends-->

                                        <!--Payslip Type Starts-->
                                        <a class="{{ Request::segment(1) == 'paysliptype' ? 'dropdown-item active' : 'dropdown-item' }}"
                                            href="{{ route('paysliptype.index') }}">
                                            {{ __('Payslip Type') }}
                                        </a>
                                        <!--Payslip Type Ends-->

                                        <!--Allowance Option Starts-->
                                        <a class="{{ Request::segment(1) == 'allowanceoption' ? 'dropdown-item active' : 'dropdown-item' }}"
                                            href="{{ route('allowanceoption.index') }}">
                                            {{ __('Allowance Option') }}
                                        </a>
                                        <!--Allowance Option Ends-->

                                        <!--Loan Option Starts-->
                                        <a class="{{ Request::segment(1) == 'loanoption' ? 'dropdown-item active' : 'dropdown-item' }}"
                                            href="{{ route('loanoption.index') }}">
                                            {{ __('Loan Option') }}
                                        </a>
                                        <!--Loan Option Ends-->

                                        <!--Deduction Option Starts-->
                                        <a class="{{ Request::segment(1) == 'deductionoption' ? 'dropdown-item active' : 'dropdown-item' }}"
                                            href="{{ route('deductionoption.index') }}">
                                            {{ __('Deduction Option') }}
                                        </a>
                                        <!--Deduction Option Ends-->

                                        <!--Goal Type Starts-->
                                        <a class="{{ Request::segment(1) == 'goaltype' ? 'dropdown-item active' : 'dropdown-item' }}"
                                            href="{{ route('goaltype.index') }}">
                                            {{ __('Goal Type') }}
                                        </a>
                                        <!--Goal Type Ends-->

                                        <!--Training Type Starts-->
                                        <a class="{{ Request::segment(1) == 'trainingtype' ? 'dropdown-item active' : 'dropdown-item' }}"
                                            href="{{ route('trainingtype.index') }}">
                                            {{ __('Training Type') }}
                                        </a>
                                        <!--Training Type ends-->

                                        <!--awardtype Starts-->
                                        <a class="{{ Request::segment(1) == 'awardtype' ? 'dropdown-item active' : 'dropdown-item' }}"
                                            href="{{ route('awardtype.index') }}">
                                            {{ __('Award Type') }}
                                        </a>
                                        <!--awardtype ends-->

                                        <!--terminationtype Starts-->
                                        <a class="{{ Request::segment(1) == 'terminationtype' ? 'dropdown-item active' : 'dropdown-item' }}"
                                            href="{{ route('terminationtype.index') }}">
                                            {{ __('Termination Type') }}
                                        </a>
                                        <!--terminationtype Ends-->

                                        <!--job-category Starts-->
                                        <a class="{{ Request::segment(1) == 'job-category' ? 'dropdown-item active' : 'dropdown-item' }}"
                                            href="{{ route('job-category.index') }}">
                                            {{ __('Job Category') }}
                                        </a>
                                        <!--job-category Ends-->

                                        <!--job-stage Starts-->
                                        <a class="{{ Request::segment(1) == 'job-stage' ? 'dropdown-item active' : 'dropdown-item' }}"
                                            href="{{ route('job-stage.index') }}">
                                            {{ __('Job Stage') }}
                                        </a>
                                        <!--job-stage Ends-->

                                        <!--Performance Starts-->
                                        <a class="{{ Request::segment(1) == 'performanceType' ? 'dropdown-item active' : 'dropdown-item' }}"
                                            href="{{ route('performanceType.index') }}">
                                            {{ __('Performance Type') }}
                                        </a>
                                        <!--Performance ends-->

                                        <!--Competencies Starts-->
                                        <a class="{{ Request::segment(1) == 'competencies' ? 'dropdown-item active' : 'dropdown-item' }}"
                                            href="{{ route('competencies.index') }}">
                                            {{ __('Competencies') }}
                                        </a>
                                        <!--Competencies ends-->

                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif
                    <!--Resource Settings ends-->

                </ul>
            </div>
        </div>
    </header>
    <!-- Page Content  -->
    <div class="page-wrapper">
        <div class="container-fluild p-5">
            @isset($hrm_header)
                <h2 class="mb-4">{{ __($hrm_header) }}</h2>
            @endisset
