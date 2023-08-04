@php
    $lang= Auth::user()->lang;
@endphp



<style>
    .navbar-expand-lg {
        top: 8em !important;
    }
</style>

<div class="page">
    <aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
                aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
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
                            </span>
                            <span class="nav-link-title"> {{ __('Dashboard') }} </span></a>

                    </li>

                    <li class="{{ Request::segment(1) == 'employee' ? 'active nav-item' : 'nav-item' }}">
                        @if (\Auth::user()->type == 'Employee')
                            @php
                                $employee = App\Models\Employee::where('user_id', \Auth::user()->id)->first();
                            @endphp
                            <a href="{{ route('employee.show', \Illuminate\Support\Facades\Crypt::encrypt($employee->id)) }}"
                                class="nav-link">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                    </svg>
                                </span>
                                <span class="nav-link-title"> {{ __('Employee') }} </span></a>
                        @else
                            <a href="{{ route('employee.index') }}" class="nav-link">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                    </svg>
                                </span>
                                <span class="nav-link-title">{{ __('Employee Setup') }}</span></a>
                        @endif

                    </li>


                    @if( Gate::check('manage job') || Gate::check('create job') || Gate::check('manage job application') || Gate::check('manage custom question') || Gate::check('show interview schedule') || Gate::check('show career'))
                    <li class="nav-item dropdown">
                                        <a class="{{ (Request::segment(1) == 'job' || Request::segment(1) == 'job-application' || Request::segment(1) == 'candidates-job-applications' || Request::segment(1) == 'job-onboard' || Request::segment(1) == 'custom-question' || Request::segment(1) == 'interview-schedule' || Request::segment(1) == 'career') ? 'nav-link dropdown-toggle show' : 'nav-link dropdown-toggle'}}   " href="#"\
                                        aria-expanded="{{ (Request::segment(1) == 'job' || Request::segment(1) == 'job-application' || Request::segment(1) == 'candidates-job-applications' || Request::segment(1) == 'job-onboard' || Request::segment(1) == 'custom-question' || Request::segment(1) == 'interview-schedule' || Request::segment(1) == 'career') ? 'true' : 'false' }}"
                                        >{{__('Recruitment Setup')}}</a>

                                        <div class=class="{{ (Request::segment(1) == 'job' || Request::segment(1) == 'job-application' || Request::segment(1) == 'candidates-job-applications' || Request::segment(1) == 'job-onboard' || Request::segment(1) == 'custom-question' || Request::segment(1) == 'interview-schedule' || Request::segment(1) == 'career')  ? 'dropdown-menu show'
                            : 'dropdown-menu'}}"
                            data-bs-popper= "{{ (Request::segment(1) == 'job' || Request::segment(1) == 'job-application' || Request::segment(1) == 'candidates-job-applications' || Request::segment(1) == 'job-onboard' || Request::segment(1) == 'custom-question' || Request::segment(1) == 'interview-schedule' || Request::segment(1) == 'career')  ? 'static'
                            : ''}}"
                            >
                            <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                            @can('manage job')
                                <a class="dash-item {{ (Request::route()->getName() == 'job.index' || Request::route()->getName() == 'job.create' || Request::route()->getName() == 'job.edit' || Request::route()->getName() == 'job.show'   ? 'active dropdown-item' : 'dropdown-item')}}"
                                    href="{{route('job.index')}}">
                                    {{__('Jobs')}}
                                </a>
                                @endcan
                                @can('create job')
                                <a class="dash-item {{ ( Request::route()->getName() == 'job.create' ? 'active dropdown-item' : 'dropdown-item')}}"
                                    href="{{route('job.create')}}">
                                    {{__('Job Create')}}
                                </a>
                                @endcan
                                @can('manage job application')
                                <a class="dash-item {{ (request()->is('job-application*') ? 'active dropdown-item' : 'dropdown-item')}}"
                                    href="{{route('job.application.candidate')}}">
                                    {{__('Job Application')}}
                                </a>
                                @endcan
                                @can('manage job application')
                                <a class="dash-item {{ (request()->is('job-onboard*')  ? 'active dropdown-item' : 'dropdown-item')}}"
                                    href="{{route('job.index')}}">
                                    {{__('Job On-boarding')}}
                                </a>
                                @endcan
                                @can('manage custom question')
                                <a class="dash-item  {{ (request()->is('custom-question*')  ? 'active dropdown-item' : 'dropdown-item')}}"
                                href="{{route('custom-question.index')}}">
                                {{__('Custom Question')}}
                                </a>
                                @endcan
                                @can('show interview schedule')
                                <a class="dash-item {{ (request()->is('interview-schedule*') ? 'active dropdown-item' : 'dropdown-item')}}"
                                href="{{route('interview-schedule.index')}}">
                                 {{__('Interview Schedule')}}
                                </a>
                                @endcan
                                @can('show career')
                                <a class="dash-item {{ (request()->is('career*') ? 'active dropdown-item' : 'dropdown-item')}}"
                                href="{{route('career',[\Auth::user()->creatorId(),$lang])}}">
                                {{__('Career')}}
                                </a>
                                @endcan
                            </div>
                            </div>
                        
                        </div>
                    </li>
                    @endif






                    <li class="active nav-item dropdown">
                        <a class="{{ Request::segment(1) == 'holiday-calender' ||
                        Request::segment(1) == 'holiday' ||
                        Request::segment(1) == 'policies' ||
                        Request::segment(1) == 'award' ||
                        Request::segment(1) == 'transfer' ||
                        Request::segment(1) == 'resignation' ||
                        Request::segment(1) == 'travel' ||
                        Request::segment(1) == 'promotion' ||
                        Request::segment(1) == 'complaint' ||
                        Request::segment(1) == 'warning' ||
                        Request::segment(1) == 'termination' ||
                        Request::segment(1) == 'announcement' ||
                        Request::segment(1) == 'competencies'
                            ? 'nav-link dropdown-toggle show'
                            : 'nav-link dropdown-toggle' }}"
                            href="#hradmin_settings" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button"
                            aria-expanded="{{ Request::segment(1) == 'holiday-calender' ||
                            Request::segment(1) == 'holiday' ||
                            Request::segment(1) == 'policies' ||
                            Request::segment(1) == 'award' ||
                            Request::segment(1) == 'transfer' ||
                            Request::segment(1) == 'resignation' ||
                            Request::segment(1) == 'travel' ||
                            Request::segment(1) == 'promotion' ||
                            Request::segment(1) == 'complaint' ||
                            Request::segment(1) == 'warning' ||
                            Request::segment(1) == 'termination' ||
                            Request::segment(1) == 'announcement' ||
                            Request::segment(1) == 'competencies'
                                ? 'true'
                                : 'false' }}">
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-settings" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
                                {{ __('HR Admin Setup') }}
                            </span>
                        </a>
                        <div class="{{ Request::segment(1) == 'holiday-calender' ||
                        Request::segment(1) == 'holiday' ||
                        Request::segment(1) == 'policies' ||
                        Request::segment(1) == 'award' ||
                        Request::segment(1) == 'transfer' ||
                        Request::segment(1) == 'resignation' ||
                        Request::segment(1) == 'travel' ||
                        Request::segment(1) == 'promotion' ||
                        Request::segment(1) == 'complaint' ||
                        Request::segment(1) == 'warning' ||
                        Request::segment(1) == 'termination' ||
                        Request::segment(1) == 'announcement' ||
                        Request::segment(1) == 'competencies'
                            ? 'dropdown-menu show'
                            : 'dropdown-menu' }}"
                            data-bs-popper="{{ Request::segment(1) == 'holiday-calender' ||
                            Request::segment(1) == 'holiday' ||
                            Request::segment(1) == 'policies' ||
                            Request::segment(1) == 'award' ||
                            Request::segment(1) == 'transfer' ||
                            Request::segment(1) == 'resignation' ||
                            Request::segment(1) == 'travel' ||
                            Request::segment(1) == 'promotion' ||
                            Request::segment(1) == 'complaint' ||
                            Request::segment(1) == 'warning' ||
                            Request::segment(1) == 'termination' ||
                            Request::segment(1) == 'announcement' ||
                            Request::segment(1) == 'competencies'
                                ? 'static'
                                : '' }}">


                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                @can('manage award')
                                <a class="{{ Request::segment(1) == 'award' ? 'active dropdown-item' : 'dropdown-item' }}"
                                    href="{{ url('award') }}">
                                    {{ __('Award') }}
                                </a>
                                @endcan
                                @can('manage transfer')
                                <a class="{{ Request::segment(1) == 'transfer' ? 'active dropdown-item' : 'dropdown-item' }}"
                                    href="{{ url('transfer') }}">
                                    {{ __('Transfer') }}
                                </a>
                                @endcan
                                @can('manage resignation')
                                <a class="{{ Request::segment(1) == 'resignation' ? 'active dropdown-item' : 'dropdown-item' }}"
                                href="{{ url('resignation') }}">
                                    {{ __('Resignation') }}
                                </a>
                                @endcan
                                @can('manage travel')
                                <a class="{{ Request::segment(1) == 'travel' ? 'active dropdown-item' : 'dropdown-item' }}"
                                href="{{ url('travel') }}">
                                    {{ __('Trip') }}
                                </a>
                                @endcan
                                @can('manage promotion')
                                <a class="{{ Request::segment(1) == 'promotion' ? 'active dropdown-item' : 'dropdown-item' }}"
                                href="{{ url('promotion') }}" >
                                    {{ __('Promotion') }}
                                </a>
                                @endcan
                                @can('manage complaint')
                                <a class="{{ Request::segment(1) == 'complaint' ? 'active dropdown-item' : 'dropdown-item' }}"
                                href="{{ url('complaint') }}">
                                    {{ __('Complaints') }}
                                </a>
                                @endcan
                                @can('manage warning')
                                <a class="{{ Request::segment(1) == 'warning' ? 'active dropdown-item' : 'dropdown-item' }}"
                                    hhref="{{ url('warning') }}" >
                                    {{ __('Warning') }}
                                </a>
                                @endcan
                                @can('manage termination')
                                <a class="{{ Request::segment(1) == 'termination' ? 'active dropdown-item' : 'dropdown-item' }}"
                                href="{{ url('termination') }}" >
                                    {{ __('Termination') }}
                                </a>
                                @endcan
                                @can('manage announcement')
                                <a class="{{ Request::segment(1) == 'announcement' ? 'active dropdown-item' : 'dropdown-item' }}"
                                href="{{ url('announcement') }}" >
                                    {{ __('Announcement') }}
                                </a>
                                @endcan
                                @can('manage holiday')
                                <a class="{{ Request::segment(1) == 'holiday' ? 'active dropdown-item' : 'dropdown-item' }}"
                                href="{{ url('holiday') }}" >
                                {{ __('Holidays') }}
                            </a>
                            @endcan
                            </div>
                        </div>
                    </div>
                    </li>

                    <li class="active nav-item dropdown">
                        <a class="{{ Request::segment(1) == 'leavetype' ||
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
                        Request::segment(1) == 'deductionoption' ||
                        Request::segment(1) == 'competencies'
                            ? 'nav-link dropdown-toggle show'
                            : 'nav-link dropdown-toggle' }}"
                            href="#resource_settings" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button"
                            aria-expanded="{{ Request::segment(1) == 'leavetype' ||
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
                            Request::segment(1) == 'deductionoption' ||
                            Request::segment(1) == 'competencies'
                                ? 'true'
                                : 'false' }}">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-adjustments-horizontal" width="24"
                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M14 6m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                <path d="M4 6l8 0"></path>
                                <path d="M16 6l4 0"></path>
                                <path d="M8 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                <path d="M4 12l2 0"></path>
                                <path d="M10 12l10 0"></path>
                                <path d="M17 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                <path d="M4 18l11 0"></path>
                                <path d="M19 18l1 0"></path>
                            </svg>
                            <span class="nav-link-title">
                                {{ __('Resource Settings') }}
                            </span>
                        </a>
                        <div class="{{ Request::segment(1) == 'leavetype' ||
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
                        Request::segment(1) == 'deductionoption' ||
                        Request::segment(1) == 'competencies'
                            ? 'dropdown-menu show'
                            : 'dropdown-menu' }}"
                            data-bs-popper="{{ Request::segment(1) == 'leavetype' ||
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
                            Request::segment(1) == 'deductionoption' ||
                            Request::segment(1) == 'competencies'
                                ? 'static'
                                : '' }}">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    <a class="{{ Request::segment(1) == 'branch' ? 'active dropdown-item' : 'dropdown-item' }}"
                                        href="{{ route('branch.index') }}">
                                        {{ __('Branch') }}
                                    </a>
                                    <a href="{{ route('designation.index') }}"
                                        class="{{ Request::segment(1) == 'designation ' ? 'active dropdown-item' : 'dropdown-item' }}">{{ __('Designation') }}</a>

                                    <a href="{{ route('leavetype.index') }}"
                                        class="{{ Request::segment(1) == 'leavetype' ? 'active dropdown-item' : 'dropdown-item' }}">{{ __('Leave Type') }}</a>


                                    <a href="{{ route('document.index') }}"
                                        class="{{ Request::segment(1) == 'document' ? 'active dropdown-item' : 'dropdown-item' }}">{{ __('Document Type') }}</a>

                                    <a href="{{ route('paysliptype.index') }}"
                                        class="{{ Request::segment(1) == 'paysliptype' ? 'active dropdown-item' : 'dropdown-item' }}">{{ __('Payslip Type') }}</a>


                                    <a href="{{ route('allowanceoption.index') }}"
                                        class="{{ Request::segment(1) == 'allowanceoption' ? 'active dropdown-item' : 'dropdown-item' }}">{{ __('Allowance Option') }}</a>

                                    <a href="{{ route('loanoption.index') }}"
                                        class="{{ Request::segment(1) == 'loanoption' ? 'active dropdown-item' : 'dropdown-item' }}">{{ __('Loan Option') }}</a>

                                    <a href="{{ route('deductionoption.index') }}"
                                        class="{{ Request::segment(1) == 'deductionoption' ? 'active dropdown-item' : 'dropdown-item' }}">{{ __('Deduction Option') }}</a>

                                    <a href="{{ route('goaltype.index') }}"
                                        class="{{ Request::segment(1) == 'goaltype' ? 'active dropdown-item' : 'dropdown-item' }}">{{ __('Goal Type') }}</a>

                                    <a href="{{ route('trainingtype.index') }}"
                                        class="{{ Request::segment(1) == 'trainingtype' ? 'active dropdown-item' : 'dropdown-item' }}">{{ __('Training Type') }}</a>

                                    <a href="{{ route('awardtype.index') }}"
                                        class="{{ Request::segment(1) == 'awardtype' ? 'active dropdown-item' : 'dropdown-item' }}">{{ __('Award Type') }}</a>
                                    <a href="{{ route('terminationtype.index') }}"
                                        class="{{ Request::segment(1) == 'terminationtype' ? 'active dropdown-item' : 'dropdown-item' }}">{{ __('Termination Type') }}</a>

                                    <a href="{{ route('job-category.index') }}"
                                        class="{{ Request::segment(1) == 'job-category' ? 'active dropdown-item' : 'dropdown-item' }}">{{ __('Job Category') }}</a>
                                    <a href="{{ route('job-stage.index') }}"
                                        class="{{ Request::segment(1) == 'job-stage' ? 'active dropdown-item' : 'dropdown-item' }}">{{ __('Job Stage') }}</a>
                                    <a href="{{ route('performanceType.index') }}"
                                        class="{{ Request::segment(1) == 'performanceType' ? 'active dropdown-item' : 'dropdown-item' }}">{{ __('Performance Type') }}</a>
                                    <a href="{{ route('competencies.index') }}"
                                        class="{{ Request::segment(1) == 'competencies' ? 'active dropdown-item' : 'dropdown-item' }}">{{ __('Competencies') }}</a>
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




        {{-- @include('new_layouts.footer') --}}
