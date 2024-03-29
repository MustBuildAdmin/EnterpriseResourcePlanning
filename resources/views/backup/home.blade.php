@include('new_layouts.header')
<main class="page-wrapper">
    <section>
        {{--
      <aside class="col-2">
         <nav id="sidebar" class="navbar navbar-vertical navbar-transparent">
            <div class="custom-menu">
               <button type="button" id="sidebarCollapse"
                class="btn btn-primary">
                <i class="fa fa-bars"></i> <span class="sr-only">
                  Toggle Menu</span>
               </button>
            </div>
            <div class="p-4">
               <h1><a href="index.html" class="logo">Portfolic <span>Portfolio Agency</span></a></h1>
               <ul class="list-unstyled components mb-5">
                  <li class="active"> <a href="#"><span class="fa fa-home mr-3"></span> Home</a> </li>
                  <li> <a href="#"><span class="fa fa-user mr-3"></span> About</a> </li>
                  <li> <a href="#"><span class="fa fa-briefcase mr-3"></span> Works</a> </li>
                  <li> <a href="#"><span class="fa fa-sticky-note mr-3"></span> Blog</a> </li>
                  <li> <a href="#"><span class="fa fa-suitcase mr-3"></span> Gallery</a> </li>
                  <li> <a href="#"><span class="fa fa-cogs mr-3"></span> Services</a> </li>
                  <li> <a href="#"><span class="fa fa-paper-plane mr-3"></span> Contacts</a> </li>
               </ul>
            </div>
         </nav>
      </aside>
      --}}
        <article class="col-12">
            <div class="page-header d-print-none">
                <div class="container-fluid">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <h2 class="page-title">
                                {{ __('Welcome') }} {{ \Auth::user()->name }}!
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-body">
                <div class="container-fluid">
                    <div class="row row-cards">
                        @if (\Auth::user()->type != 'super admin' &&
                                (Gate::check('manage user')
                                || Gate::check('manage role')
                                || Gate::check('manage client')))
                            @can('manage user')
                                <div class="col-md-6 col-xl-2">
                                    <a class="card card-link" href="{{ route('users.index') }}">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <span class="bg-primary text-white avatar">
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
                                                    </span>
                                                </div>
                                                <div class="col">
                                                    <div class="font-weight-medium mt-2">{{ __('Users') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endcan
                        @endif
                        @if (\Auth::user()->type != 'super admin' &&
                        (Gate::check('manage user') || Gate::check('manage role') || Gate::check('manage client')))
                            @can('manage role')
                                <div class="col-md-6 col-xl-2">
                                    <a class="card card-link" href="{{ route('roles.index') }}">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <span class="bg-primary text-white avatar">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-user-circle" width="24"
                                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                                            <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                                            <path
                                                                d="M6.168 18.849a4 4 0 0 1 3.832
                                                               -2.849h4a4 4 0 0 1 3.834 2.855">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="col">
                                                    <div class="font-weight-medium mt-2">{{ __('Roles') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endcan
                        @endif
                        @if (\Auth::user()->show_hrm() == 1)
                            @can('show hrm dashboard')
                                <div class="col-md-6 col-xl-2">
                                    <a class="card card-link" href="{{ url('hrm_dashboard') }}">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <span class="bg-red text-white avatar">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-tower" width="24"
                                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M5 3h1a1 1 0 0 1 1 1v2h3v-2a1 1 0 0
                                                             1 1 -1h2a1 1 0 0 1 1 1v2h3v-2a1
                                                            1 0 0 1 1 -1h1a1 1 0 0 1 1 1v4.394a2
                                                             2 0 0 1 -.336 1.11l-1.328 1.992a2 2 0 0 0
                                                            -.336 1.11v7.394a1 1 0 0 1 -1 1h-10a1 1 0
                                                             0 1 -1 -1v-7.394a2 2 0 0 0 -.336 -1.1
                                                            1l-1.328 -1.992a2 2 0 0 1 -.336
                                                             -1.11v-4.394a1 1 0 0 1 1 -1z">
                                                            </path>
                                                            <path d="M10 21v-5a2 2 0 1 1 4 0v5"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="col">
                                                    <div class="font-weight-medium mt-2">
                                                      {{ __('Human Resource') }}
                                                   </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endcan
                        @endif
                        @if (\Auth::user()->show_account() == 1)
                            @if (Gate::check('manage proposal') ||
                                    Gate::check('manage bank account') ||
                                    Gate::check('manage bank transfer') ||
                                    Gate::check('manage invoice') ||
                                    Gate::check('manage revenue') ||
                                    Gate::check('manage credit note') ||
                                    Gate::check('manage bill') ||
                                    Gate::check('manage payment') ||
                                    Gate::check('manage debit note') ||
                                    Gate::check('manage chart of account') ||
                                    Gate::check('manage journal entry') ||
                                    Gate::check('balance sheet report') ||
                                    Gate::check('ledger report') ||
                                    Gate::check('trial balance report') ||
                                    Gate::check('manage product & service') ||
                                    Gate::check('manage vender'))
                                <div class="col-md-6 col-xl-2">
                                    <a class="card card-link" href="{{ route('productservice.index') }}">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <span class="bg-dark text-white avatar">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon"
                                                            width="24" height="24" viewBox="0 0 24 24"
                                                            stroke-width="2" stroke="currentColor" fill="none"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                            </path>
                                                            <path d="M4 18v-12a2 2 0 0 1 2 -2h12a2 2
                                                                      0 0 1 2 2v12a2 2 0 0
                                                                     1 -2 2h-12a2 2 0 0 1 -2 -2z">
                                                            </path>
                                                            <path d="M7 14l3 -3l2 2l3 -3l2 2"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="col">
                                                    <div class="font-weight-medium mt-2">{{ __('Accounting System ') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endcan
                        @endif
                        @if (\Auth::user()->show_crm() == 1)
                            @if (Gate::check('manage lead') ||
                                    Gate::check('manage deal') ||
                                    Gate::check('manage form builder') ||
                                    Gate::check('manage contract') ||
                                    Gate::check('manage client'))
                                <div class="col-md-6 col-xl-2">
                                    <a class="card card-link"
                                        @if (Auth::user()->type == 'client') href="{{ route('deals.index') }}"
                     @else href="{{ route('clients.index') }}" @endif>
                                        {{--
                     <a class="card card-link" href="{{ route('clients.index') }}">
                        --}}
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <span class="bg-yellow text-white avatar">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-user-check"
                                                            width="24" height="24" viewBox="0 0 24 24"
                                                            stroke-width="2" stroke="currentColor" fill="none"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                            </path>
                                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
                                                            <path d="M15 19l2 2l4 -4"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="col">
                                                    <div class="font-weight-medium mt-2">{{ __('CRM') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endif
                        @if (Gate::check('manage consultant'))
                            <div class="col-md-6 col-xl-2">
                                <a class="card card-link" href="{{ route('consultants.index') }}">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-auto">
                                                <span class="bg-primary text-white avatar">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-users" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                        </path>
                                                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="col">
                                                <div class="font-weight-medium mt-2">{{ __('Consultant') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                        @if (\Auth::user()->show_project() == 1)
                            @if (Gate::check('manage project'))
                                <div class="col-md-6 col-xl-2">
                                    <a class="card card-link" href="{{ route('construction_main') }}">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <span class="bg-info text-white avatar">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-wrecking-ball"
                                                            width="24" height="24" viewBox="0 0 24 24"
                                                            stroke-width="2" stroke="currentColor" fill="none"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                            </path>
                                                            <path d="M19 13m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0">
                                                            </path>
                                                            <path d="M4 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0">
                                                            </path>
                                                            <path d="M13 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0">
                                                            </path>
                                                            <path d="M13 19l-9 0"></path>
                                                            <path d="M4 15l9 0"></path>
                                                            <path d="M8 12v-5h2a3 3 0 0 1 3 3v5"></path>
                                                            <path d="M5 15v-2a1 1 0 0 1 1 -1h7"></path>
                                                            <path d="M19 11v-7l-6 7"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="col">
                                                    <div class="font-weight-medium mt-2">
                                                        {{ __('Construction Management System') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endif
                        @if (\Auth::user()->type != 'super admin')
                            <div class="col-md-6 col-xl-2">
                                <a class="card card-link" href="{{ route('support.index') }}">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-auto">
                                                <span class="bg-success text-white avatar">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-headset"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="2" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                        </path>
                                                        <path d="M4 14v-3a8 8 0 1 1 16 0v3"></path>
                                                        <path d="M18 19c0 1.657 -2.686 3 -6 3"></path>
                                                        <path d="M4 14a2 2 0 0 1 2 -2h1a2 2 0 0
                                                         1 2 2v3a2 2 0 0 1 -2 2h-1a2 2 0 0 1 -2
                                                         -2v-3z">
                                                        </path>
                                                        <path d="M15 14a2 2 0 0 1 2 -2h1a2 2 0 0 1 2 2v3a2
                                                         2 0 0 1 -2 2h-1a2 2 0 0 1 -2
                                                         -2v-3z">
                                                        </path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="col">
                                                <div class="font-weight-medium mt-2">{{ __('Support System') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                        <?php $check_user_leave_permission = \App\Models\User::where('name', '!=', null)
                            ->where('created_by', '=', \Auth::user()->creatorId())
                            ->where('type', '!=', 'client')
                            ->where('id', '!=', \Auth::user()->id)
                            ->get()
                            ->pluck('reporting_to', 'id');
                        $login_user = \Auth::user()->id;
                        $enable_menu = 0;
                        foreach ($check_user_leave_permission as $value) {
                            $reporting_user = explode(',', $value);
                            if (in_array($login_user, $reporting_user)) {
                                $enable_menu = 1;
                            }
                        }
                        
                        ?>
                        @if (\Auth::user()->type != 'client'
                         && \Auth::user()->type != 'company'
                         && \Auth::user()->type != 'super admin')
                            <div class="col-md-6 col-xl-2">
                                <a class="card card-link" href="{{ route('my-info') }}">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-auto">
                                                <span class="bg-success text-white avatar">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-user-circle"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="2" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                        </path>
                                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                                        <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                                        <path
                                                            d="M6.168 18.849a4 4 0 0 1 3.832
                                                             -2.849h4a4 4 0 0 1 3.834 2.855">
                                                        </path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="col">
                                                <div class="font-weight-medium mt-2">{{ __('My Details') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @if ($enable_menu == 1)
                                <div class="col-md-6 col-xl-2">
                                    <a class="card card-link" href="{{ route('leave.index') }}">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <span class="bg-success text-white avatar">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor"
                                                            class="bi bi-clock" viewBox="0 0 16 16">
                                                            <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0
                                                                     0 .252.434l3.5 2a.5.5 0 0 0 .496-.8
                                                                     68L8 8.71V3.5z" />
                                                            <path
                                                                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0
                                                                 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="col">
                                                    <div class="font-weight-medium mt-2">{{ __('Manage Leave') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                            <div class="col-md-6 col-xl-2">
                                <a class="card card-link" href="{{ route('mark-attendance') }}">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-auto">
                                                <span class="bg-success text-white avatar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-clock"
                                                        viewBox="0 0 16 16">
                                                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0
                                                               .252.434l3.5 2a.5.5 0 0 0 .496-.868L8
                                                               8.71V3.5z" />
                                                        <path
                                                            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0
                                                             16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="col">
                                                <div class="font-weight-medium mt-2">{{ __('Mark Attendance') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                        @if (\Auth::user()->type != 'super admin')
                            @if (Gate::check('manage company plan')
                            || Gate::check('manage order')
                            || Gate::check('manage company settings'))
                                <div class="col-md-6 col-xl-2">
                                    <a class="card card-link" href="{{ route('systemsettings') }}" disabled>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <span class="bg-dark text-white avatar">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-settings"
                                                            width="24" height="24" viewBox="0 0 24 24"
                                                            stroke-width="2" stroke="currentColor" fill="none"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                            </path>
                                                            <path d="M10.325 4.317c.426 -1.756 2.924 -1.756
                                                             3.35 0a1.724 1.724 0 0 0 2.573
                                                            1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724
                                                             0 0 0 1.065 2.572c1.756 .426
                                                            1.756 2.924 0 3.35a1.724 1.724 0 0 0
                                                             -1.066 2.573c.94 1.543 -.826 3.31 -2.37
                                                            2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426
                                                             1.756 -2.924 1.756 -3.35 0a1.724
                                                            1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31
                                                             -.826 -2.37 -2.37a1.724 1.724
                                                            0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924
                                                             0 -3.35a1.724 1.724 0 0 0 1.0
                                                            66 -2.573c-.94 -1.543 .826 -3.31 2.37
                                                             -2.37c1 .608 2.296 .07 2.572 -1.065z">
                                                            </path>
                                                            <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="col">
                                                    <div class="font-weight-medium mt-2">
                                                        {{ __('System Settings') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endif

                        @if (Gate::check('manage sub contractor'))
                            <div class="col-md-6 col-xl-2">
                                <a class="card card-link" href="{{ route('subcontractor.index') }}" disabled>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-auto">
                                                <span class="bg-dark text-white avatar">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-settings"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="2" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                        </path>
                                                        <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724
                                                                  1.724 0 0 0 2.573 1.066c1.543 -.94
                                                                   3.31 .826 2.37 2.37a1.724
                                                                  1.724 0 0 0 1.065 2.572c1.756
                                                                   .426 1.756 2.924 0 3.35a1.724 1.724 0
                                                                  0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37
                                                                  2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756
                                                                  -2.924 1.756 -3.35 0a1.724
                                                                  1.724 0 0 0 -2.573 -1.066c-1.543
                                                                   .94 -3.31 -.826 -2.37 -2.37a1.724 1.724
                                                                  0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924
                                                                  0 -3.35a1.724 1.724 0 0 0 1.0
                                                                  66 -2.573c-.94 -1.543 .826 -3.31 2.37
                                                                  -2.37c1 .608 2.296
                                                                  .07 2.572 -1.065z">
                                                        </path>
                                                        <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="col">
                                                <div class="font-weight-medium mt-2"> {{ __('Sub Contractor') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
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
@include('new_layouts.footer')
