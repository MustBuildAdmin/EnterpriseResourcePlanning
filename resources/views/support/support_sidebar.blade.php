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

@php
  //  $logo=asset(Storage::url('uploads/logo/'));
    $logo=\App\Models\Utility::get_file('uploads/logo');
    $company_logo=Utility::getValByName('company_logo_dark');
    $company_logos=Utility::getValByName('company_logo_light');
    $company_small_logo=Utility::getValByName('company_small_logo');
    $setting = \App\Models\Utility::colorset();
    $setting_data=\App\Models\Utility::settings();
    $mode_setting = \App\Models\Utility::mode_layout();
    $emailTemplate     = \App\Models\EmailTemplate::first();
    $lang= Auth::user()->lang;
@endphp

<div class="wrapper">
<nav id="sidebar" class="navbar navbar-vertical navbar-transparent">
        <div class="sidebar">
            <ul class="list-unstyled components nav nav-sidebar">
                @if( Gate::check('show hrm dashboard') || Gate::check('show project dashboard') || Gate::check('show account dashboard'))
                    <li class="{{ ( Request::segment(1) == null ||Request::segment(1) == 'account-dashboard' || Request::segment(1) == 'income report'
                                                || Request::segment(1) == 'report' || Request::segment(1) == 'reports-payroll' || Request::segment(1) == 'reports-leave' ||
                                                    Request::segment(1) == 'reports-monthly-attendance') ?'active dash-trigger':''}}">
                        <a data-bs-target="#account_setup" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                                            <span class="icon"><i class="ti ti-home"></i></span>
                                            <span class="list">{{ __('Dashboard') }}</span>
                        </a>
                        <ul class="collapse list-unstyled" id="account_setup">
                            @if(\Auth::user()->show_account() == 1 && Gate::check('show account dashboard'))
                                <li class="{{ ( Request::segment(1) == null   || Request::segment(1) == 'account-dashboard'|| Request::segment(1) == 'report') ? ' active dash-trigger' : ''}}">
                                    <a data-bs-target="#account2_setup" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                                                    <span class="icon"><i class="ti ti-box"></i></span>
                                                    <span class="list">{{ __('Accounting') }}</span>
                                    </a>
                                    <ul class="collapse list-unstyled" id="account2_setup">
                                    @can('show account dashboard')
                                        <li class="{{ ( Request::segment(1) == null || Request::segment(1) == 'account-dashboard') ? ' active' : '' }}">
                                            <a href="{{route('dashboard')}}">{{__(' Overview')}}</a>
                                        </li>
                                    @endcan
                                    @if( Gate::check('income report') || Gate::check('expense report') || Gate::check('income vs expense report') ||
                                                 Gate::check('tax report')  || Gate::check('loss & profit report') || Gate::check('invoice report') ||
                                                 Gate::check('bill report') || Gate::check('stock report') || Gate::check('invoice report') ||
                                                 Gate::check('manage transaction')||  Gate::check('statement report'))
                                        <li class="{{(Request::segment(1) == 'report')? 'active dash-trigger ' :''}}">
                                            <a data-bs-target="#report_setup" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                                                        <span class="icon"><i class="ti ti-file"></i></span>
                                                        <span class="list">{{ __('Reports') }}</span>
                                            </a>
                                            <ul class="collapse list-unstyled" id="report_setup">
                                                @can('expense report')
                                                    <li class="{{ (Request::route()->getName() == 'report.expense.summary' ) ? ' active' : '' }}">
                                                        <a href="{{route('report.expense.summary')}}">{{__('Expense Summary')}}</a>
                                                    </li>
                                                @endcan
                                                @can('income vs expense report')
                                                    <li class="{{ (Request::route()->getName() == 'report.income.vs.expense.summary' ) ? ' active' : '' }}">
                                                        <a href="{{route('report.income.vs.expense.summary')}}">{{__('Income VS Expense')}}</a>
                                                    </li>
                                                @endcan
                                                @can('statement report')
                                                    <li class="{{ (Request::route()->getName() == 'report.account.statement') ? ' active' : '' }}">
                                                        <a href="{{route('report.account.statement')}}">{{__('Account Statement')}}</a>
                                                    </li>
                                                @endcan
                                                @can('invoice report')
                                                    <li class="{{ (Request::route()->getName() == 'report.invoice.summary' ) ? ' active' : '' }}">
                                                        <a href="{{route('report.invoice.summary')}}">{{__('Invoice Summary')}}</a>
                                                    </li>
                                                @endcan
                                                @can('bill report')
                                                    <li class="{{ (Request::route()->getName() == 'report.bill.summary' ) ? ' active' : '' }}">
                                                        <a href="{{route('report.bill.summary')}}">{{__('Bill Summary')}}</a>
                                                    </li>
                                                @endcan
                                                    @can('stock report')
                                                        <li class="{{ (Request::route()->getName() == 'report.product.stock.report' ) ? ' active' : '' }}">
                                                            <a href="{{route('report.product.stock.report')}}" class="dash-link">{{ __('Product Stock') }}</a>
                                                        </li>
                                                @endcan

                                                @can('loss & profit report')
                                                    <li class="{{ (Request::route()->getName() == 'report.profit.loss.summary' ) ? ' active' : '' }}">
                                                        <a href="{{route('report.profit.loss.summary')}}">{{__('Profit & Loss')}}</a>
                                                    </li>
                                                @endcan
                                                @can('manage transaction')
                                                    <li class="{{ (Request::route()->getName() == 'transaction.index' || Request::route()->getName() == 'transfer.create' || Request::route()->getName() == 'transaction.edit') ? ' active' : '' }}">
                                                        <a href="{{ route('transaction.index') }}">{{__('Transaction')}}</a>
                                                    </li>
                                                @endcan
                                                @can('income report')
                                                    <li class="{{ (Request::route()->getName() == 'report.income.summary' ) ? ' active' : '' }}">
                                                        <a href="{{route('report.income.summary')}}">{{__('Income Summary')}}</a>
                                                    </li>
                                                @endcan
                                                @can('tax report')
                                                    <li class="{{ (Request::route()->getName() == 'report.tax.summary' ) ? ' active' : '' }}">
                                                        <a href="{{route('report.tax.summary')}}">{{__('Tax Summary')}}</a>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </li>   
                                    @endif
                                    </ul>
                                </li>
                            @endif
                            @if(\Auth::user()->show_hrm() == 1)
                                <li class="{{ ( Request::segment(1) == 'hrm-dashboard'   || Request::segment(1) == 'reports-payroll') ? ' active dash-trigger' : ''}}">
                                    <a data-bs-target="#hrm_setup" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                                        <span class="icon"><i class="ti ti-user"></i></span>
                                        <span class="list">{{ __('HRM') }}</span>
                                    </a>
                                    <ul class="collapse list-unstyled" id="hrm_setup">
                                        @can('show hrm dashboard')
                                            <li class="{{ (\Request::route()->getName()=='hrm.dashboard') ? ' active' : '' }}">
                                                    <a href="{{route('hrm.dashboard')}}">{{__(' Overview')}}</a>
                                            </li>
                                        @endcan
                                        @can('manage report')
                                                <li class="{{ (Request::segment(1) == 'reports-monthly-attendance' || Request::segment(1) == 'reports-leave'
                                                    || Request::segment(1) == 'reports-payroll') ? 'active dash-trigger' : ''}}">
                                                    <a data-bs-target="#hrm_report_setup" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                                                        <span class="icon"><i class="ti ti-file"></i></span>
                                                        <span class="list">{{ __('Reports') }}</span>
                                                    </a>
                                                    <ul class="collapse list-unstyled" id="hrm_report_setup">
                                                        <li class="{{ request()->is('reports-payroll') ? 'active' : '' }}">
                                                            <a href="{{ route('report.payroll') }}">{{__('Payroll')}}</a>
                                                        </li>
                                                        <li class="{{ request()->is('reports-leave') ? 'active' : '' }}">
                                                            <a href="{{ route('report.leave') }}">{{__('Leave')}}</a>
                                                        </li>
                                                        <li class="{{ request()->is('reports-monthly-attendance') ? 'active' : '' }}">
                                                            <a href="{{ route('report.monthly.attendance') }}">{{ __('Monthly Attendance') }}</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endif
                            @if(\Auth::user()->show_project() == 1)
                                @can('show project dashboard')
                                    <li class="{{ (Request::route()->getName() == 'project.dashboard') ? ' active' : '' }}">
                                        <a href="{{route('project.dashboard')}}">{{__('Project ')}}</a>
                                    </li>
                                @endcan
                            @endif
                        </ul>
                    </li>
                @endif
                @if(\Auth::user()->show_hrm() == 1)
                    @if( Gate::check('manage employee') || Gate::check('manage setsalary'))
                        <li class="{{ (Request::segment(1) == 'holiday-calender'
                            || Request::segment(1) == 'leavetype' || Request::segment(1) == 'leave' ||
                                    Request::segment(1) == 'attendanceemployee' || Request::segment(1) == 'document-upload' || Request::segment(1) == 'document' || Request::segment(1) == 'performanceType'  ||
                                        Request::segment(1) == 'branch' || Request::segment(1) == 'department' || Request::segment(1) == 'designation' || Request::segment(1) == 'employee'
                                        || Request::segment(1) == 'leave_requests' || Request::segment(1) == 'holidays' || Request::segment(1) == 'policies' || Request::segment(1) == 'leave_calender'
                                        || Request::segment(1) == 'award' || Request::segment(1) == 'transfer' || Request::segment(1) == 'resignation' || Request::segment(1) == 'training' || Request::segment(1) == 'travel' ||
                                        Request::segment(1) == 'promotion' || Request::segment(1) == 'complaint' || Request::segment(1) == 'warning'
                                        || Request::segment(1) == 'termination' || Request::segment(1) == 'announcement' || Request::segment(1) == 'job' || Request::segment(1) == 'job-application' ||
                                        Request::segment(1) == 'candidates-job-applications' || Request::segment(1) == 'job-onboard' || Request::segment(1) == 'custom-question'
                                        || Request::segment(1) == 'interview-schedule' || Request::segment(1) == 'career' || Request::segment(1) == 'holiday' || Request::segment(1) == 'setsalary' ||
                                        Request::segment(1) == 'payslip' || Request::segment(1) == 'paysliptype' || Request::segment(1) == 'company-policy' || Request::segment(1) == 'job-stage'
                                        || Request::segment(1) == 'job-category' || Request::segment(1) == 'terminationtype' || Request::segment(1) == 'awardtype' || Request::segment(1) == 'trainingtype' ||
                                        Request::segment(1) == 'goaltype' || Request::segment(1) == 'paysliptype' || Request::segment(1) == 'allowanceoption' || Request::segment(1) == 'competencies' || Request::segment(1) == 'loanoption'
                                        || Request::segment(1) == 'deductionoption')?'active dash-trigger':''}}">
                            <a data-bs-target="#hrm_system" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                                <span class="icon"><i class="ti ti-user"></i></span>
                                <span class="list">{{ __('HRM System') }}</span>
                            </a>
                            <ul class="collapse list-unstyled" id="hrm_system">
                                <li class="{{ (Request::segment(1) == 'employee' ? 'active dash-trigger' : '')}}   ">
                                    @if(\Auth::user()->type =='Employee')
                                            @php
                                                $employee=App\Models\Employee::where('user_id',\Auth::user()->id)->first();
                                            @endphp
                                            <a href="{{route('employee.show',\Illuminate\Support\Facades\Crypt::encrypt($employee->id))}}">{{__('Employee')}}</a>
                                    @else
                                            <a href="{{route('employee.index')}}" class="dash-link">
                                                {{ __('Employee Setup') }}
                                            </a>
                                    @endif
                                    @if( Gate::check('manage set salary') || Gate::check('manage pay slip'))
                                        <li class="{{ (Request::segment(1) == 'setsalary' || Request::segment(1) == 'payslip') ? 'active dash-trigger' : ''}}">
                                            <a data-bs-target="#payroll_setup" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                                                <span class="icon"><i class="ti ti-cash"></i></span>
                                                <span class="list">{{ __('Payroll Setup') }}</span>
                                            </a>
                                            <ul class="collapse list-unstyled" id="payroll_setup">
                                                @can('manage set salary')
                                                    <li class="{{ (request()->is('setsalary*') ? 'active' : '')}}">
                                                        <a href="{{ route('setsalary.index') }}">{{__('Set salary')}}</a>
                                                    </li>
                                                @endcan
                                                @can('manage pay slip')
                                                    <li class="{{ (request()->is('payslip*') ? 'active' : '')}}">
                                                        <a href="{{route('payslip.index')}}">{{__('Payslip')}}</a>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </li>
                                    @endif
                                    @if( Gate::check('manage leave') || Gate::check('manage attendance'))
                                        <li class="{{ (Request::segment(1) == 'leave' || Request::segment(1) == 'attendanceemployee') ? 'active dash-trigger' :''}}">
                                            <a data-bs-target="#leave_management" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                                                <span class="icon"><i class="ti ti-calendar"></i></span>
                                                <span class="list">{{ __('Leave Management Setup') }}</span>
                                            </a>
                                            <ul class="collapse list-unstyled" id="leave_management">
                                                @can('manage leave')
                                                    <li class="{{ (Request::route()->getName() == 'leave.index') ?'active' :''}}">
                                                        <a href="{{route('leave.index')}}">{{__('Manage Leave')}}</a>
                                                    </li>
                                                @endcan
                                                @can('manage attendance')
                                                    <li class="{{ (Request::segment(1) == 'attendanceemployee') ? 'active dash-trigger' : ''}}" href="#navbar-attendance" data-toggle="collapse" role="button" aria-expanded="{{ (Request::segment(1) == 'attendanceemployee') ? 'true' : 'false'}}">
                                                        <a data-bs-target="#attendance" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                                                            <span class="icon"><i class="ti ti-users"></i></span>
                                                            <span class="list">{{ __('Attendance') }}</span>
                                                        </a>
                                                        <ul class="collapse list-unstyled" id="attendance">
                                                            <li class="{{ (Request::route()->getName() == 'attendanceemployee.index' ? 'active' : '')}}">
                                                                <a href="{{route('attendanceemployee.index')}}">{{__('Mark Attendance')}}</a>
                                                            </li>
                                                            @can('create attendance')
                                                                <li class="{{ (Request::route()->getName() == 'attendanceemployee.bulkattendance' ? 'active' : '')}}">
                                                                    <a href="{{ route('attendanceemployee.bulkattendance') }}">{{__('Bulk Attendance')}}</a>
                                                                </li>
                                                            @endcan
                                                        </ul>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </li>
                                    @endif
                                    @if( Gate::check('manage indicator') || Gate::check('manage appraisal') || Gate::check('manage goal tracking'))
                                        <li class="{{ (Request::segment(1) == 'indicator' || Request::segment(1) == 'appraisal' || Request::segment(1) == 'goaltracking') ? 'active dash-trigger' : ''}}" href="#navbar-performance" data-toggle="collapse" role="button" aria-expanded="{{ (Request::segment(1) == 'indicator' || Request::segment(1) == 'appraisal' || Request::segment(1) == 'goaltracking') ? 'true' : 'false'}}">
                                            <a data-bs-target="#performance_setup" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                                                <span class="icon"><i class="ti ti-users"></i></span>
                                                <span class="list">{{ __('Performance Setup') }}</span>
                                            </a>
                                            <ul class="{{ (Request::segment(1) == 'indicator' || Request::segment(1) == 'appraisal' || Request::segment(1) == 'goaltracking') ? 'show' : 'collapse'}} collapse list-unstyled" id="performance_setup">
                                                @can('manage indicator')
                                                    <li class="{{ (request()->is('indicator*') ? 'active' : '')}}">
                                                        <a href="{{route('indicator.index')}}">{{__('Indicator')}}</a>
                                                    </li>
                                                @endcan
                                                @can('manage appraisal')
                                                    <li class="{{ (request()->is('appraisal*') ? 'active' : '')}}">
                                                        <a href="{{route('appraisal.index')}}">{{__('Appraisal')}}</a>
                                                    </li>
                                                @endcan
                                                @can('manage goal tracking')
                                                    <li class="{{ (request()->is('goaltracking*') ? 'active' : '')}}">
                                                        <a href="{{route('goaltracking.index')}}">{{__('Goal Tracking')}}</a>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </li>
                                    @endif
                                    @if( Gate::check('manage training') || Gate::check('manage trainer') || Gate::check('show training'))
                                        <li class="{{ (Request::segment(1) == 'trainer' || Request::segment(1) == 'training') ? 'active dash-trigger' : ''}}" href="#navbar-training" data-toggle="collapse" role="button" aria-expanded="{{ (Request::segment(1) == 'trainer' || Request::segment(1) == 'training') ? 'true' : 'false'}}">
                                            <a data-bs-target="#training_setup" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                                                <span class="icon"><i class="ti ti-users"></i></span>
                                                <span class="list">{{ __('Training Setup') }}</span>
                                            </a>
                                            <ul class="collapse list-unstyled" id="training_setup">
                                                @can('manage training')
                                                    <li class="{{ (request()->is('training*') ? 'active' : '')}}">
                                                        <a href="{{route('training.index')}}">{{__('Training List')}}</a>
                                                    </li>
                                                @endcan
                                                @can('manage trainer')
                                                    <li class="{{ (request()->is('trainer*') ? 'active' : '')}}">
                                                        <a href="{{route('trainer.index')}}">{{__('Trainer')}}</a>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </li>
                                    @endif
                                    @if( Gate::check('manage job') || Gate::check('create job') || Gate::check('manage job application') || Gate::check('manage custom question') || Gate::check('show interview schedule') || Gate::check('show career'))
                                        <li class="{{ (Request::segment(1) == 'job' || Request::segment(1) == 'job-application' || Request::segment(1) == 'candidates-job-applications' || Request::segment(1) == 'job-onboard' || Request::segment(1) == 'custom-question' || Request::segment(1) == 'interview-schedule' || Request::segment(1) == 'career') ? 'active dash-trigger' : ''}}    ">
                                            <a data-bs-target="#recruitment_setup" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                                                <span class="icon"><i class="ti ti-users"></i></span>
                                                <span class="list">{{ __('Recruitment Setup') }}</span>
                                            </a>
                                            <ul class="collapse list-unstyled" id="recruitment_setup">
                                                @can('manage job')
                                                    <li class="{{ (Request::route()->getName() == 'job.index' || Request::route()->getName() == 'job.create' || Request::route()->getName() == 'job.edit' || Request::route()->getName() == 'job.show'   ? 'active' : '')}}">
                                                        <a href="{{route('job.index')}}">{{__('Jobs')}}</a>
                                                    </li>
                                                @endcan
                                                @can('create job')
                                                    <li class="{{ ( Request::route()->getName() == 'job.create' ? 'active' : '')}} ">
                                                        <a href="{{route('job.create')}}">{{__('Job Create')}}</a>
                                                    </li>
                                                @endcan
                                                @can('manage job application')
                                                    <li class="{{ (request()->is('job-application*') ? 'active' : '')}}">
                                                        <a href="{{route('job-application.index')}}">{{__('Job Application')}}</a>
                                                    </li>
                                                @endcan
                                                @can('manage job application')
                                                    <li class="{{ (request()->is('candidates-job-applications') ? 'active' : '')}}">
                                                        <a href="{{route('job.application.candidate')}}">{{__('Job Candidate')}}</a>
                                                    </li>
                                                @endcan
                                                @can('manage job application')
                                                    <li class="{{ (request()->is('job-onboard*') ? 'active' : '')}}">
                                                        <a href="{{route('job.on.board')}}">{{__('Job On-boarding')}}</a>
                                                    </li>
                                                @endcan
                                                @can('manage custom question')
                                                    <li class=" {{ (request()->is('custom-question*') ? 'active' : '')}}">
                                                        <a href="{{route('custom-question.index')}}">{{__('Custom Question')}}</a>
                                                    </li>
                                                @endcan
                                                @can('show interview schedule')
                                                    <li class="{{ (request()->is('interview-schedule*') ? 'active' : '')}}">
                                                        <a href="{{route('interview-schedule.index')}}">{{__('Interview Schedule')}}</a>
                                                    </li>
                                                @endcan
                                                @can('show career')
                                                    <li class="{{ (request()->is('career*') ? 'active' : '')}}">
                                                        <a href="{{route('career',[\Auth::user()->creatorId(),$lang])}}">{{__('Career')}}</a>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </li>
                                    @endif
                                    @if( Gate::check('manage award') || Gate::check('manage transfer') || Gate::check('manage resignation') || Gate::check('manage travel') || Gate::check('manage promotion') || Gate::check('manage complaint') || Gate::check('manage warning') || Gate::check('manage termination') || Gate::check('manage announcement') || Gate::check('manage holiday') )
                                        <li class="{{ (Request::segment(1) == 'holiday-calender' || Request::segment(1) == 'holiday' || Request::segment(1) == 'policies' || Request::segment(1) == 'award' || Request::segment(1) == 'transfer' || Request::segment(1) == 'resignation' || Request::segment(1) == 'travel' || Request::segment(1) == 'promotion' || Request::segment(1) == 'complaint' || Request::segment(1) == 'warning' || Request::segment(1) == 'termination' || Request::segment(1) == 'announcement' || Request::segment(1) == 'competencies' ) ? 'active dash-trigger' : ''}}">
                                            <a data-bs-target="#hr_admin_setup" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                                                <span class="icon"><i class="ti ti-user"></i></span>
                                                <span class="list">{{ __('HR Admin Setup') }}</span>
                                            </a>
                                            <ul class="collapse list-unstyled" id="hr_admin_setup">
                                                @can('manage award')
                                                    <li class="{{ (request()->is('award*') ? 'active' : '')}}">
                                                        <a href="{{route('award.index')}}">{{__('Award')}}</a>
                                                    </li>
                                                @endcan
                                                @can('manage transfer')
                                                    <li class="{{ (request()->is('transfer*') ? 'active' : '')}}">
                                                        <a href="{{route('transfer.index')}}">{{__('Transfer')}}</a>
                                                    </li>
                                                @endcan
                                                @can('manage resignation')
                                                    <li class="{{ (request()->is('resignation*') ? 'active' : '')}}">
                                                        <a href="{{route('resignation.index')}}">{{__('Resignation')}}</a>
                                                    </li>
                                                @endcan
                                                @can('manage travel')
                                                    <li class="{{ (request()->is('travel*') ? 'active' : '')}}">
                                                        <a href="{{route('travel.index')}}">{{__('Trip')}}</a>
                                                    </li>
                                                @endcan
                                                @can('manage promotion')
                                                    <li class="{{ (request()->is('promotion*') ? 'active' : '')}}">
                                                        <a href="{{route('promotion.index')}}">{{__('Promotion')}}</a>
                                                    </li>
                                                @endcan
                                                @can('manage complaint')
                                                    <li class="{{ (request()->is('complaint*') ? 'active' : '')}}">
                                                        <a href="{{route('complaint.index')}}">{{__('Complaints')}}</a>
                                                    </li>
                                                @endcan
                                                @can('manage warning')
                                                    <li class="{{ (request()->is('warning*') ? 'active' : '')}}">
                                                        <a href="{{route('warning.index')}}">{{__('Warning')}}</a>
                                                    </li>
                                                @endcan
                                                @can('manage termination')
                                                    <li class="{{ (request()->is('termination*') ? 'active' : '')}}">
                                                        <a href="{{route('termination.index')}}">{{__('Termination')}}</a>
                                                    </li>
                                                @endcan
                                                @can('manage announcement')
                                                    <li class="{{ (request()->is('announcement*') ? 'active' : '')}}">
                                                        <a href="{{route('announcement.index')}}">{{__('Announcement')}}</a>
                                                    </li>
                                                @endcan
                                                @can('manage holiday')
                                                    <li class="{{ (request()->is('holiday*') || request()->is('holiday-calender') ? 'active' : '')}}">
                                                        <a href="{{route('holiday.index')}}">{{__('Holidays')}}</a>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </li>
                                    @endif
                                    @can('manage event')
                                        <li class="{{ (request()->is('event*') ? 'active' : '')}}">
                                            <a href="{{route('event.index')}}">{{__('Event Setup')}}</a>
                                        </li>
                                    @endcan
                                    @can('manage meeting')
                                        <li class="{{ (request()->is('meeting*') ? 'active' : '')}}">
                                            <a href="{{route('meeting.index')}}">{{__('Meeting')}}</a>
                                        </li>
                                    @endcan
                                    @can('manage assets')
                                        <li class="{{ (request()->is('account-assets*') ? 'active' : '')}}">
                                            <a href="{{route('account-assets.index')}}">{{__('Employees Asset Setup ')}}</a>
                                        </li>
                                    @endcan
                                    @can('manage document')
                                        <li class="{{ (request()->is('document-upload*') ? 'active' : '')}}">
                                            <a href="{{route('document-upload.index')}}">{{__('Document Setup')}}</a>
                                        </li>
                                    @endcan
                                    @can('manage company policy')
                                        <li class="{{ (request()->is('company-policy*') ? 'active' : '')}}">
                                            <a href="{{route('company-policy.index')}}">{{__('Company policy')}}</a>
                                        </li>
                                    @endcan
                                    <li class="{{ (Request::segment(1) == 'leavetype' || Request::segment(1) == 'document' || Request::segment(1) == 'performanceType' || Request::segment(1) == 'branch' || Request::segment(1) == 'department'
                                                                    || Request::segment(1) == 'designation' || Request::segment(1) == 'job-stage'|| Request::segment(1) == 'performanceType'  || Request::segment(1) == 'job-category' || Request::segment(1) == 'terminationtype' ||
                                                                Request::segment(1) == 'awardtype' || Request::segment(1) == 'trainingtype' || Request::segment(1) == 'goaltype' || Request::segment(1) == 'paysliptype' ||
                                                                 Request::segment(1) == 'allowanceoption' || Request::segment(1) == 'loanoption' || Request::segment(1) == 'deductionoption') ? 'active dash-trigger' : ''}}">
                                        <a href="{{route('branch.index')}}">{{__('HRM System Setup')}}</a>
                                    </li>
                                </li>
                            </ul>  
                        </li>
                    @endif                                
                @endif
                @if(\Auth::user()->show_account() == 1)
                    @if( Gate::check('manage customer') || Gate::check('manage vender') || Gate::check('manage customer') || Gate::check('manage vender') ||
                         Gate::check('manage proposal') ||  Gate::check('manage bank account') ||  Gate::check('manage bank transfer') ||  Gate::check('manage invoice')
                         ||  Gate::check('manage revenue') ||  Gate::check('manage credit note') ||  Gate::check('manage bill')  ||  Gate::check('manage payment') ||
                          Gate::check('manage debit note') || Gate::check('manage chart of account') ||  Gate::check('manage journal entry') ||   Gate::check('balance sheet report')
                          || Gate::check('ledger report') ||  Gate::check('trial balance report'))
                        <li class="dash-hasmenu
                                        {{ (Request::route()->getName() == 'print-setting' || Request::segment(1) == 'customer' ||
                                            Request::segment(1) == 'vender' || Request::segment(1) == 'proposal' || Request::segment(1) == 'bank-account' ||
                                            Request::segment(1) == 'bank-transfer' || Request::segment(1) == 'invoice' || Request::segment(1) == 'revenue' ||
                                            Request::segment(1) == 'credit-note' || Request::segment(1) == 'taxes' || Request::segment(1) == 'product-category' ||
                                            Request::segment(1) == 'product-unit' || Request::segment(1) == 'payment-method' || Request::segment(1) == 'custom-field' ||
                                            Request::segment(1) == 'chart-of-account-type' || ( Request::segment(1) == 'transaction') &&  Request::segment(2) != 'ledger'
                                            &&  Request::segment(2) != 'balance-sheet' &&  Request::segment(2) != 'trial-balance' || Request::segment(1) == 'goal'
                                            || Request::segment(1) == 'budget'|| Request::segment(1) == 'chart-of-account' || Request::segment(1) == 'journal-entry' ||
                                             Request::segment(2) == 'ledger' ||  Request::segment(2) == 'balance-sheet' ||  Request::segment(2) == 'trial-balance' ||
                                             Request::segment(1) == 'bill' || Request::segment(1) == 'payment' || Request::segment(1) == 'debit-note')?' active dash-trigger':''}}">

                            <a data-bs-target="#accounting_system" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                                <span class="icon"><i class="ti ti-box"></i></span>
                                <span class="list">{{ __('Accounting System') }}</span>
                            </a>
                            <ul class="collapse list-unstyled" id="accounting_system">
                                @if(Gate::check('manage customer'))
                                    <li class="{{ (Request::segment(1) == 'customer')?'active':''}}">
                                        <a href="{{route('customer.index')}}">{{__('Customer')}}</a>
                                    </li>
                                @endif
                                @if(Gate::check('manage vender'))
                                    <li class="{{ (Request::segment(1) == 'vender')?'active':''}}">
                                        <a href="{{ route('vender.index') }}">{{__('Vendor')}}</a>
                                    </li>
                                @endif
                                @if(Gate::check('manage proposal'))
                                    <li class="{{ (Request::segment(1) == 'proposal')?'active':''}}">
                                        <a href="{{ route('proposal.index') }}">{{__('Proposal')}}</a>
                                    </li>
                                @endif
                                @if( Gate::check('manage bank account') ||  Gate::check('manage bank transfer'))
                                    <li class="{{(Request::segment(1) == 'bank-account' || Request::segment(1) == 'bank-transfer')? 'active dash-trigger' :''}}">
                                        <a data-bs-target="#banking" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                                            <span class="icon"><i class="ti ti-banking"></i></span>
                                            <span class="list">{{ __('Banking') }}</span>
                                        </a>
                                        <ul class="collapse list-unstyled" id="banking">
                                            <li class="{{ (Request::route()->getName() == 'bank-account.index' || Request::route()->getName() == 'bank-account.create' || Request::route()->getName() == 'bank-account.edit') ? ' active' : '' }}">
                                                <a href="{{ route('bank-account.index') }}">{{__('Account')}}</a>
                                            </li>
                                            <li class="{{ (Request::route()->getName() == 'bank-transfer.index' || Request::route()->getName() == 'bank-transfer.create' || Request::route()->getName() == 'bank-transfer.edit') ? ' active' : '' }}">
                                                <a href="{{route('bank-transfer.index')}}">{{__('Transfer')}}</a>
                                            </li>
                                        </ul>
                                    </li>
                                @endif
                                @if( Gate::check('manage invoice') ||  Gate::check('manage revenue') ||  Gate::check('manage credit note'))
                                    <li class="{{(Request::segment(1) == 'invoice' || Request::segment(1) == 'revenue' || Request::segment(1) == 'credit-note')? 'active dash-trigger' :''}}">
                                        <a data-bs-target="#income" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                                            <span class="icon"><i class="ti ti-money"></i></span>
                                            <span class="list">{{ __('Income') }}</span>
                                        </a>                            
                                        <ul class="collapse list-unstyled" id="income">
                                            <li class="{{ (Request::route()->getName() == 'invoice.index' || Request::route()->getName() == 'invoice.create' || Request::route()->getName() == 'invoice.edit' || Request::route()->getName() == 'invoice.show') ? ' active' : '' }}">
                                                <a href="{{ route('invoice.index') }}">{{__('Invoice')}}</a>
                                            </li>
                                            <li class="{{ (Request::route()->getName() == 'revenue.index' || Request::route()->getName() == 'revenue.create' || Request::route()->getName() == 'revenue.edit') ? ' active' : '' }}">
                                                <a href="{{route('revenue.index')}}">{{__('Revenue')}}</a>
                                            </li>
                                            <li class="{{ (Request::route()->getName() == 'credit.note' ) ? ' active' : '' }}">
                                                <a href="{{route('credit.note')}}">{{__('Credit Note')}}</a>
                                            </li>
                                        </ul>
                                    </li>
                                @endif
                                @if( Gate::check('manage bill')  ||  Gate::check('manage payment') ||  Gate::check('manage debit note'))
                                    <li class="{{(Request::segment(1) == 'bill' || Request::segment(1) == 'payment' || Request::segment(1) == 'debit-note')? 'active dash-trigger' :''}}">
                                        <a data-bs-target="#expense" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                                            <span class="icon"><i class="ti ti-users"></i></span>
                                            <span class="list">{{ __('Expense') }}</span>
                                        </a>
                                        <ul class="collapse list-unstyled" id="expense">
                                            <li class="{{ (Request::route()->getName() == 'bill.index' || Request::route()->getName() == 'bill.create' || Request::route()->getName() == 'bill.edit' || Request::route()->getName() == 'bill.show') ? ' active' : '' }}">
                                                <a href="{{ route('bill.index') }}">{{__('Bill')}}</a>
                                            </li>
                                            <li class="{{ (Request::route()->getName() == 'payment.index' || Request::route()->getName() == 'payment.create' || Request::route()->getName() == 'payment.edit') ? ' active' : '' }}">
                                                <a href="{{route('payment.index')}}">{{__('Payment')}}</a>
                                            </li>
                                            <li class=" {{ (Request::route()->getName() == 'debit.note' ) ? ' active' : '' }}">
                                                <a href="{{route('debit.note')}}">{{__('Debit Note')}}</a>
                                            </li>
                                        </ul>
                                    </li>
                                @endif
                                @if( Gate::check('manage chart of account') ||  Gate::check('manage journal entry') ||   Gate::check('balance sheet report') ||  Gate::check('ledger report') ||  Gate::check('trial balance report'))
                                    <li class="{{(Request::segment(1) == 'chart-of-account' || Request::segment(1) == 'journal-entry' || Request::segment(2) == 'ledger' ||  Request::segment(2) == 'balance-sheet' ||  Request::segment(2) == 'trial-balance')? 'active dash-trigger' :''}}">
                                        <a data-bs-target="#double_entry" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                                            <span class="icon"><i class="ti ti-coin"></i></span>
                                            <span class="list">{{ __('Double Entry') }}</span>
                                        </a>
                                        <ul class="collapse list-unstyled" id="double_entry">
                                            <li class="{{ (Request::route()->getName() == 'chart-of-account.index') ? ' active' : '' }}">
                                                <a href="{{ route('chart-of-account.index') }}">{{__('Chart of Accounts')}}</a>
                                            </li>
                                            <li class="{{ (Request::route()->getName() == 'journal-entry.edit' || Request::route()->getName() == 'journal-entry.create' || Request::route()->getName() == 'journal-entry.index' || Request::route()->getName() == 'journal-entry.show') ? ' active' : '' }}">
                                                <a href="{{ route('journal-entry.index') }}">{{__('Journal Account')}}</a>
                                            </li>
                                            <li class="{{ (Request::route()->getName() == 'report.ledger' ) ? ' active' : '' }}">
                                                <a href="{{route('report.ledger')}}">{{__('Ledger Summary')}}</a>
                                            </li>
                                            <li class="{{ (Request::route()->getName() == 'report.balance.sheet' ) ? ' active' : '' }}">
                                                <a href="{{route('report.balance.sheet')}}">{{__('Balance Sheet')}}</a>
                                            </li>
                                            <li class="{{ (Request::route()->getName() == 'trial.balance' ) ? ' active' : '' }}">
                                                <a href="{{route('trial.balance')}}">{{__('Trial Balance')}}</a>
                                            </li>
                                        </ul>
                                    </li>
                                @endif
                                @if(\Auth::user()->type =='company')
                                    <li class="{{ (Request::segment(1) == 'budget')?'active':''}}">
                                        <a href="{{ route('budget.index') }}">{{__('Budget Planner')}}</a>
                                    </li>
                                @endif
                                @if(Gate::check('manage goal'))
                                    <li class="{{ (Request::segment(1) == 'goal')?'active':''}}">
                                        <a href="{{ route('goal.index') }}">{{__('Financial Goal')}}</a>
                                    </li>
                                @endif
                                @if(Gate::check('manage constant tax') || Gate::check('manage constant category') ||Gate::check('manage constant unit') ||Gate::check('manage constant payment method') ||Gate::check('manage constant custom field') )
                                    <li class="{{(Request::segment(1) == 'taxes' || Request::segment(1) == 'product-category' || Request::segment(1) == 'product-unit' || Request::segment(1) == 'payment-method' || Request::segment(1) == 'custom-field' || Request::segment(1) == 'chart-of-account-type')? 'active dash-trigger' :''}}">
                                        <a href="{{ route('taxes.index') }}">{{__('Accounting Setup')}}</a>
                                    </li>
                                @endif

                                @if(Gate::check('manage print settings'))
                                    <li class="{{ (Request::route()->getName() == 'print-setting') ? ' active' : '' }}">
                                        <a href="{{ route('print.setting') }}">{{__('Print Settings')}}</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
                @if(\Auth::user()->show_crm() == 1)
                    @if( Gate::check('manage lead') || Gate::check('manage deal') || Gate::check('manage form builder')  || Gate::check('manage contract'))
                        <li class="{{ (Request::segment(1) == 'stages' || Request::segment(1) == 'labels' || Request::segment(1) == 'sources' ||
                                        Request::segment(1) == 'lead_stages' || Request::segment(1) == 'pipelines' || Request::segment(1) == 'deals' ||
                                        Request::segment(1) == 'leads'  || Request::segment(1) == 'form_builder' || Request::segment(1) == 'form_response' || Request::segment(1) == 'contract')?' active dash-trigger':''}}">
                            <a data-bs-target="#crm_system" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                                <span class="icon"><i class="ti ti-layers-difference"></i></span>
                                <span class="list">{{ __('CRM System') }}</span>
                            </a>
                            <ul class="collapse list-unstyled
                                        {{ (Request::segment(1) == 'stages' || Request::segment(1) == 'labels' || Request::segment(1) == 'sources' ||
                                            Request::segment(1) == 'lead_stages' || Request::segment(1) == 'leads'  || Request::segment(1) == 'form_builder' ||
                                            Request::segment(1) == 'form_response' || Request::segment(1) == 'deals' || Request::segment(1) == 'pipelines')?'show':''}}" id="crm_system">
                                @can('manage lead')
                                    <li class=" {{ (Request::route()->getName() == 'leads.list' || Request::route()->getName() == 'leads.index' || Request::route()->getName() == 'leads.show') ? ' active' : '' }}">
                                        <a href="{{ route('leads.index') }}">{{__('Leads')}}</a>
                                    </li>
                                @endcan
                                @can('manage deal')
                                    <li class=" {{ (Request::route()->getName() == 'deals.list' || Request::route()->getName() == 'deals.index' || Request::route()->getName() == 'deals.show') ? ' active' : '' }}">
                                        <a href="{{route('deals.index')}}">{{__('Deals')}}</a>
                                    </li>
                                @endcan
                                @can('manage form builder')
                                    <li class=" {{ (Request::segment(1) == 'form_builder' || Request::segment(1) == 'form_response')?'active open':''}}">
                                        <a href="{{route('form_builder.index')}}">{{__('Form Builder')}}</a>
                                    </li>
                                @endcan
                                @if(\Auth::user()->type=='company')
                                    <li class="  {{ (Request::route()->getName() == 'contract.index' || Request::route()->getName() == 'contract.show')?'active':''}}">
                                        <a href="{{route('contract.index')}}">{{__('Contract')}}</a>
                                    </li>
                                @endif
                                @if(Gate::check('manage lead stage') || Gate::check('manage pipeline') ||Gate::check('manage source') ||Gate::check('manage label') || Gate::check('manage stage'))
                                    <li class="  {{(Request::segment(1) == 'stages' || Request::segment(1) == 'labels' || Request::segment(1) == 'sources' || Request::segment(1) == 'lead_stages' || Request::segment(1) == 'pipelines' || Request::segment(1) == 'product-category' || Request::segment(1) == 'product-unit' || Request::segment(1) == 'payment-method' || Request::segment(1) == 'custom-field' || Request::segment(1) == 'chart-of-account-type')? 'active dash-trigger' :''}}">
                                        <a href="{{ route('pipelines.index') }}   ">{{__('CRM System Setup')}}</a>

                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
                @if(\Auth::user()->show_project() == 1)
                    @if( Gate::check('manage project'))
                        <li class="dash-hasmenu
                                        {{ ( Request::segment(1) == 'project' || Request::segment(1) == 'bugs-report' || Request::segment(1) == 'bugstatus' ||
                                                Request::segment(1) == 'project-task-stages' || Request::segment(1) == 'calendar' || Request::segment(1) == 'timesheet-list' ||
                                                Request::segment(1) == 'taskboard' || Request::segment(1) == 'timesheet-list' || Request::segment(1) == 'taskboard' ||
                                                Request::segment(1) == 'project' || Request::segment(1) == 'projects' || Request::segment(1) == 'project_report') ? 'active dash-trigger' : ''}}">
                            <a data-bs-target="#construction_system" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                                <span class="icon"><i class="ti ti-receipt"></i></span>
                                <span class="list">@if($setting_data['company_type']!=2){{__('Project System')}}@else {{__('construction management')}} @endif</span>
                                        </a>
                            <ul class="collapse list-unstyled" id="construction_system">
                                @can('manage project')
                                    <li class=" {{Request::segment(1) == 'project' || Request::route()->getName() == 'projects.list' || Request::route()->getName() == 'projects.list' ||Request::route()->getName() == 'projects.index' || Request::route()->getName() == 'projects.show' || request()->is('projects/*') ? 'active' : ''}}">
                                        <a href="{{route('projects.index')}}">@if($setting_data['company_type']!=2){{__('Projects')}}@else {{__('Productivity')}} @endif</a>
                                    </li>
                                @endcan
                                {{-- @if($setting_data['company_type']==2) --}}
                                <!-- this diary url need to remove !-->
                                    {{-- @can('manage project')
                                    <li class=" {{Request::segment(1) == 'dairy' ? 'active' : ''}}">
                                        <a href="{{route('dairy.index')}}">{{__('Dairy')}}</a>
                                    </li>
                                    @endcan --}}
                                {{-- @endif --}}
                                @can('manage project task')
                                    <li class="{{ (request()->is('taskboard*') ? 'active' : '')}}">
                                        <a href="{{ route('taskBoard.view', 'list') }}">{{__('Tasks')}}</a>
                                    </li>
                                @endcan
                                {{-- @can('manage timesheet')
                                    <li class="{{ (request()->is('timesheet-list*') ? 'active' : '')}}">
                                        <a href="{{route('timesheet.list')}}">{{__('Timesheet')}}</a>
                                    </li>
                                @endcan --}}
                                @if($setting_data['company_type']!=2)
                                    @can('manage bug report')
                                        <li class="{{ (request()->is('bugs-report*') ? 'active' : '')}}">
                                            <a href="{{route('bugs.view','list')}}">{{__('Bug')}}</a>
                                        </li>
                                    @endcan
                                @endif

                                <!-- old calender -->
                                {{-- @can('manage project task')
                                    <li class="{{ (request()->is('calendar*') ? 'active' : '')}}">
                                        <a href="{{ route('task.calendar',['all']) }}">{{__('Task Calendar')}}</a>
                                    </li>
                                @endcan --}}
                                <!-- old calender -->

                                <!-- new calender -->
                                @can('manage project task')
                                    <li class="{{ (request()->is('calendar*') ? 'active' : '')}}">
                                        <a href="{{ route('task.newcalendar',['all']) }}">{{__('Task Calendar')}}</a>
                                    </li>
                                @endcan
                                <!-- new calender -->
                                {{-- @if(\Auth::user()->type!='super admin')
                                    <li class=" {{ (Request::segment(1) == 'time-tracker')?'active open':''}}">
                                        <a href="{{ route('time.tracker') }}">{{__('Tracker')}}</a>
                                    </li>
                                @endif --}}
                                @if (\Auth::user()->type == 'company' || \Auth::user()->type == 'employee')
                                        <li class=" {{(Request::route()->getName() == 'project_report.index' || Request::route()->getName() == 'project_report.show') ? 'active' : ''}}">
                                            <a href="{{route('project_report.index') }}">{{__('Project Report')}}</a>
                                        </li>
                                @endif
                                @if($setting_data['company_type']!=2)
                                    @if(Gate::check('manage project task stage') || Gate::check('manage bug status'))
                                        <li class="{{ (Request::segment(1) == 'bugstatus' || Request::segment(1) == 'project-task-stages') ? 'active dash-trigger' : ''}}">
                                            <a data-bs-target="#project_system_setup" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                                                <span class="icon"><i class="ti ti-users"></i></span>
                                                <span class="list">{{ __('Project System Setup') }}</span>
                                            </a>
                                            <ul class="collapse list-unstyled" id="project_system_setup">
                                                @can('manage project task stage')
                                                    <li class=" {{ (Request::route()->getName() == 'project-task-stages.index') ? 'active' : '' }}">
                                                        <a href="{{route('project-task-stages.index')}}">{{__('Project Task Stages')}}</a>
                                                    </li>
                                                @endcan
                                                @can('manage bug status')
                                                    <li class="{{ (Request::route()->getName() == 'bugstatus.index') ? 'active' : '' }}">
                                                        <a href="{{route('bugstatus.index')}}">{{__('Bug Status')}}</a>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </li>
                                    @endif
                                @else
                                    @if(Gate::check('manage project task stage') || Gate::check('manage bug status'))
                                            <li class="{{ (Request::segment(1) == 'bugstatus' || Request::segment(1) == 'project-task-stages') ? 'active dash-trigger' : ''}}">
                                                <a data-bs-target="#construction_setting" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                                                    <span class="icon"><i class="ti ti-users"></i></span>
                                                    <span class="list">{{ __('Construction Setting') }}</span>
                                                </a>
                                                <ul class="collapse list-unstyled" id="construction_setting">
                                                    @can('manage project task stage')
                                                        <li class=" {{ (Request::route()->getName() == 'project-task-stages.index') ? 'active' : '' }}">
                                                            <a href="{{route('project-task-stages.index')}}">{{__('Project Task Stages')}}</a>
                                                        </li>
                                                    @endcan
                                                    <li class=" {{ (Request::route()->getName() == 'project_holiday*') ? 'active' : '' }}">
                                                        <a href="{{route('project_holiday.index')}}">{{__('Project_holiday')}}</a>
                                                    </li>
                                                </ul>
                                            </li>
                                    @endif
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
                @if(\Auth::user()->type!='super admin' && ( Gate::check('manage user') || Gate::check('manage role') || Gate::check('manage client')))
                    <li class="{{ (Request::segment(1) == 'users' || Request::segment(1) == 'roles' || Request::segment(1) == 'clients')?' active dash-trigger':''}}">
                        <a data-bs-target="#user_management" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                            <span class="icon"><i class="ti ti-users"></i></span>
                            <span class="list">{{ __('User Management') }}</span>
                        </a>
                        <ul class="collapse list-unstyled" id="user_management">
                            @can('manage user')
                                <li class="{{ (Request::route()->getName() == 'users.index' || Request::route()->getName() == 'users.create' || Request::route()->getName() == 'users.edit') ? ' active' : '' }}">
                                    <a href="{{ route('users.index') }}">{{__('User')}}</a>
                                </li>
                            @endcan
                            @can('manage role')
                                <li class="{{ (Request::route()->getName() == 'roles.index' || Request::route()->getName() == 'roles.create' || Request::route()->getName() == 'roles.edit') ? ' active' : '' }} ">
                                    <a href="{{route('roles.index')}}">{{__('Role')}}</a>
                                </li>
                            @endcan
                            @can('manage client')
                                <li class="{{ (Request::route()->getName() == 'clients.index' || Request::segment(1) == 'clients' || Request::route()->getName() == 'clients.edit') ? ' active' : '' }}">
                                    <a href="{{ route('clients.index') }}">{{__('Client')}}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif
                @if(Gate::check('manage product & service') || Gate::check('manage product & service'))
                    <li>
                        <a data-bs-target="#products_system" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                            <span class="icon"><i class="ti ti-shopping-cart"></i></span>
                            <span class="list">{{ __('Products System') }}</span>
                        </a>
                        <ul class="collapse list-unstyled" id="products_system">
                            @if(Gate::check('manage product & service'))
                                <li class="{{ (Request::segment(1) == 'productservice')?'active':''}}">
                                    <a href="{{ route('productservice.index') }}" class="dash-link">{{__('Product & Services')}}
                                    </a>
                                </li>
                            @endif
                            @if(Gate::check('manage product & service'))
                                <li class="{{ (Request::segment(1) == 'productstock')?'active':''}}">
                                    <a href="{{ route('productstock.index') }}" class="dash-link">{{__('Product Stock')}}
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if( Gate::check('manage warehouse') ||  Gate::check('manage purchase')  || Gate::check('manage pos') || Gate::check('manage print settings'))
                    <li class="{{ (Request::segment(1) == 'warehouse' || Request::segment(1) == 'purchase')?' active dash-trigger':''}}">
                        <a data-bs-target="#pos_system" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                            <span class="icon"><i class="ti ti-layers-difference"></i></span>
                            <span class="list">{{ __('POS System') }}</span>
                        </a>
                        <ul class="{{ (Request::segment(1) == 'warehouse' || Request::segment(1) == 'purchase')?'show':''}} collapse list-unstyled" id="pos_system">
                            @can('manage warehouse')
                                <li class="{{ (Request::route()->getName() == 'warehouse.index' || Request::route()->getName() == 'warehouse.show') ? ' active' : '' }}">
                                    <a href="{{ route('warehouse.index') }}">{{__('Warehouse')}}</a>
                                </li>
                            @endcan
                            @can('manage purchase')
                                <li class="{{ (Request::route()->getName() == 'purchase.index' || Request::route()->getName() == 'purchase.create' || Request::route()->getName() == 'purchase.edit' || Request::route()->getName() == 'purchase.show') ? ' active' : '' }}">
                                    <a href="{{ route('purchase.index') }}">{{__('Purchase')}}</a>
                                </li>
                            @endcan
                            @can('manage pos')
                                <li class="{{ (Request::route()->getName() == 'pos.index' ) ? ' active' : '' }}">
                                    <a href="{{ route('pos.index') }}">{{__(' Add POS')}}</a>
                                </li>

                                <li class="{{ (Request::route()->getName() == 'pos.report' ) ? ' active' : '' }}">
                                    <a href="{{ route('pos.report') }}">{{__('POS')}}</a>
                                </li>
                            @endcan
                            @if(Gate::check('manage print settings'))
                                <li class="{{ (Request::route()->getName() == 'pos-print-setting') ? ' active' : '' }}">
                                    <a href="{{ route('pos.print.setting') }}">{{__('Print Settings')}}</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(\Auth::user()->type!='super admin')
                    <li class="{{ (Request::segment(1) == 'support')?'active':''}}">
                        <a href="{{route('support.index')}}">
                            <span class="icon"><i class="ti ti-headphones"></i></span>
                            <span class="list">{{ __('Support System') }}</span>
                        </a>
                    </li>
                    
                    <li class="{{ (Request::segment(1) == 'chats')?'active':''}}">
                        <a href="{{ url('chats') }}">
                            <span class="icon"><i class="ti ti-message-circle"></i></span>
                            <span class="list">{{ __('Messenger') }}</span>
                        </a>    
                    </li>
                @endif
                @if((\Auth::user()->type != 'super admin'))
                    @if( Gate::check('manage company plan') || Gate::check('manage order') || Gate::check('manage company settings'))
                        <li>
                            <a data-bs-target="#system_setup" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                                <span class="icon"><i class="ti ti-settings"></i></span>
                                <span class="list">{{ __('System Setup') }}</span>
                            </a>
                            <ul class="collapse list-unstyled" id="system_setup">
                                @if(Gate::check('manage company settings'))
                                    <li class="{{ (Request::segment(1) == 'companysetting') ? ' active' : '' }}">
                                        <a href="{{ route('systemsettings') }}">{{__('System Settings')}}</a>
                                    </li>
                                @endif
                                @if(Gate::check('manage company plan'))
                                    <li class="{{ (Request::route()->getName() == 'plans.index' || Request::route()->getName() == 'stripe') ? ' active' : '' }}">
                                        <a href="{{ route('plans.index') }}">{{__('Setup Subscription Plan')}}</a>
                                    </li>
                                @endif

                                @if(Gate::check('manage order') && Auth::user()->type == 'company')
                                    <li class="{{ (Request::segment(1) == 'order')? 'active' : ''}}">
                                        <a href="{{ route('order.index') }}">{{__('Order')}}</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
            </ul>
        </div>
    </nav>
    <!-- Page Content  -->
    <div id="content" class="page-wrapper">
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











    