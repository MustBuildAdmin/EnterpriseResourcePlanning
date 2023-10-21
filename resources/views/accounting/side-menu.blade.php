@php $lang= Auth::user()->lang; @endphp
<style>
   .navbar-expand-lg {
   top: 4.8em !important;
   }
   a.nav-link.active{
   background: #206bc4 !important;
   color: #fff !important;
   }
   a.nav-link.actives{
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

            <li>
               <a class="{{ (Request::route()->getName() == 'productservice.index'
                  || Request::route()->getName() == 'productstock.index')
                  ?'nav-link active dropdown-toggle' :'nav-link dropdown-toggle'}}"
                  href="#planning" data-bs-toggle="dropdown"
                  data-bs-auto-close="false" role="button" aria-expanded="false" >
                  <span class=" d-md-none d-lg-inline-block">
                     <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-24-hours"
                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"></path>
                        <path d="M4 13a8.094 8.094 0 0 0 3 5.24"></path>
                        <path
                           d="M11 15h2a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-1a1 1 0 0 0 -1 1v1a1 1 0 0 0 1 1h2">
                        </path>
                        <path d="M17 15v2a1 1 0 0 0 1 1h1"></path>
                        <path d="M20 15v6"></path>
                     </svg>
                  </span>
                  <span class="nav-link-title">{{__('Product & Services')}}</span>
               </a>
               <div class="dropdown-menu">
                  <div class="dropdown-menu-columns">
                     <div class="dropdown-menu-column">
                        <a  class="{{ (Request::route()->getName() == 'productservice.index')
                            ?'dropdown-item active' :'dropdown-item'}}"
                            href="{{ route('productservice.index') }}">
                        {{__('Product & Services')}}
                        </a>
                        <a  class="{{ (Request::route()->getName() == 'productstock.index')
                            ?'dropdown-item active' :'dropdown-item'}}"
                            href="{{ route('productstock.index') }}" >
                        {{__('Product Stock')}}
                        </a>
                     </div>
                  </div>
               </div>
            </li>
            @if(Gate::check('manage vender'))
            <li>
               <a href="{{ route('vender.index') }}"
                  class="{{ (Request::route()->getName() == 'vender.index') ?'nav-link active' :'nav-link'}}">
                  <span class=" d-md-none d-lg-inline-block">
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
                  <span class="nav-link-title"> {{ __('Vendor') }} </span>
               </a>
            </li>
            @endif
            @if(Gate::check('manage proposal'))
            <li>
               <a href="{{ route('proposal.index') }}"
                  class="{{ (Request::route()->getName() == 'proposal.index') ?'nav-link active' :'nav-link'}}">
                  <span class=" d-md-none d-lg-inline-block">
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
                  <span class="nav-link-title"> {{ __('Proposal') }} </span>
               </a>
            </li>
            @endif
            @if( Gate::check('manage bank account') ||  Gate::check('manage bank transfer'))
            <li>
               <a class="{{ (Request::route()->getName() == 'bank-account.index'
                  || Request::route()->getName() == 'bank-transfer.index')
                  ?'nav-link active dropdown-toggle' :'nav-link dropdown-toggle'}}"
                  href="#planning" data-bs-toggle="dropdown"
                  data-bs-auto-close="false" role="button" aria-expanded="false">
                  <span class=" d-md-none d-lg-inline-block">
                     <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-building-bank"
                      width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                       stroke-linecap="round" stroke-linejoin="round">
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
                  <span class="nav-link-title">{{ __('Banking') }}</span>
               </a>
               <div class="dropdown-menu">
                  <div class="dropdown-menu-columns">
                     <div class="dropdown-menu-column">
                        <a class="{{ (Request::route()->getName() == 'bank-account.index')
                           ?'dropdown-item active' :'dropdown-item'}}"
                            href="{{ route('bank-account.index') }}">
                            {{__('Account')}}
                        </a>
                        <a class="{{ (Request::route()->getName() == 'bank-transfer.index')
                           ?'dropdown-item active' :'dropdown-item'}}"
                            href="{{route('bank-transfer.index')}}">
                            {{__('Transfer')}}
                        </a>
                     </div>
                  </div>
               </div>
            </li>
            @endif
            @if( Gate::check('manage invoice') ||  Gate::check('manage revenue') ||  Gate::check('manage credit note'))
            <li>
               <a class="{{ (Request::route()->getName() == 'invoice.index'
                  || Request::route()->getName() == 'revenue.index'
                  || Request::route()->getName() == 'credit.note')
                  ?'nav-link active dropdown-toggle' :'nav-link dropdown-toggle'}}"
                  href="#planning" data-bs-toggle="dropdown"
                  data-bs-auto-close="false" role="button" aria-expanded="false">
                  <span class=" d-md-none d-lg-inline-block">
                     <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-autofit-content"
                      width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
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
                  <span class="nav-link-title">{{ __('Income') }}</span>
               </a>
               <div class="dropdown-menu">
                  <div class="dropdown-menu-columns">
                     <div class="dropdown-menu-column">
                        <a class="{{ (Request::route()->getName() == 'invoice.index')
                           ?'dropdown-item active' :'dropdown-item'}}"
                           href="{{ route('invoice.index') }}">
                           {{__('Invoice')}}
                        </a>
                        <a class="{{ (Request::route()->getName() == 'revenue.index')
                           ?'dropdown-item active' :'dropdown-item'}}"
                           href="{{route('revenue.index')}}">
                           {{__('Revenue')}}
                        </a>
                        <a class="{{ (Request::route()->getName() == 'credit.note')
                           ?'dropdown-item active' :'dropdown-item'}}"
                            href="{{route('credit.note')}}">
                            {{__('Credit Note')}}
                        </a>
                     </div>
                  </div>
               </div>
            </li>
            @endif
            @if( Gate::check('manage bill')  ||  Gate::check('manage payment') ||  Gate::check('manage debit note'))
            <li>
               <a class="{{ (Request::route()->getName() == 'bill.index'
                  || Request::route()->getName() == 'payment.index'
                  || Request::route()->getName() == 'debit.note')
                  ?'nav-link active dropdown-toggle' :'nav-link dropdown-toggle'}}"
                  href="#planning" data-bs-toggle="dropdown"
                  data-bs-auto-close="false" role="button" aria-expanded="false">
                  <span class=" d-md-none d-lg-inline-block">
                     <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-explicit"
                      width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                       fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M4 4m0 1a1 1 0 0 1 1 -1h14a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-14a1 1 0 0 1 -1 -1z">
                        </path>
                        <path d="M14 8h-4v8h4"></path>
                        <path d="M14 12h-4"></path>
                     </svg>
                  </span>
                  <span class="nav-link-title">{{ __('Expense') }}</span>
               </a>
               <div class="dropdown-menu">
                  <div class="dropdown-menu-columns">
                     <div class="dropdown-menu-column">
                        <a class="{{ (Request::route()->getName() == 'bill.index')
                           ?'dropdown-item active' :'dropdown-item'}}"
                           href="{{ route('bill.index') }}">
                           {{__('Bill')}}
                        </a>
                        <a class="{{ (Request::route()->getName() == 'payment.index')
                           ?'dropdown-item active' :'dropdown-item'}}"
                           href="{{route('payment.index')}}">
                           {{__('Payment')}}
                        </a>
                        <a class="{{ (Request::route()->getName() == 'debit.note')
                           ?'dropdown-item active' :'dropdown-item'}}"
                           href="{{route('debit.note')}}">
                           {{__('Debit Note')}}
                        </a>
                     </div>
                  </div>
               </div>
            </li>
            @endif
            </li>
            @if( Gate::check('manage chart of account') ||  Gate::check('manage journal entry')
             || Gate::check('balance sheet report') ||  Gate::check('ledger report')
             ||  Gate::check('trial balance report'))
            <li>
               <a class="{{ (Request::route()->getName() == 'chart-of-account.index'
                 || Request::route()->getName() == 'journal-entry.index'
                 || Request::route()->getName() == 'report.ledger'
                 || Request::route()->getName() == 'report.balance.sheet'
                 || Request::route()->getName() == 'trial.balance')
                 ?'nav-link active dropdown-toggle' :'nav-link dropdown-toggle'}}"
                 href="#planning" data-bs-toggle="dropdown"
                  data-bs-auto-close="false" role="button" aria-expanded="false">
                  <span class=" d-md-none d-lg-inline-block">
                     <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-desktop-down"
                      width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                       stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M13.5 16h-9.5a1 1 0 0 1 -1 -1v-10a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v7.5"></path>
                        <path d="M7 20h5"></path>
                        <path d="M9 16v4"></path>
                        <path d="M19 16v6"></path>
                        <path d="M22 19l-3 3l-3 -3"></path>
                     </svg>
                  </span>
                  <span class="nav-link-title">{{__('Double Entry')}}</span>
               </a>
               <div class="dropdown-menu">
                  <div class="dropdown-menu-columns">
                     <div class="dropdown-menu-column">
                        <a class="{{ (Request::route()->getName() == 'chart-of-account.index')
                           ?'dropdown-item active' :'dropdown-item'}}"
                           href="{{ route('chart-of-account.index') }}">
                           {{__('Chart of Accounts')}}
                        </a>
                        <a class="{{ (Request::route()->getName() == 'journal-entry.index')
                           ?'dropdown-item active' :'dropdown-item'}}"
                           href="{{ route('journal-entry.index') }}">
                           {{__('Journal Account')}}
                        </a>
                        <a class="{{ (Request::route()->getName() == 'report.ledger')
                           ?'dropdown-item active' :'dropdown-item'}}"
                           href="{{route('report.ledger')}}">
                           {{__('Ledger Summary')}}
                        </a>
                        <a class="{{ (Request::route()->getName() == 'report.balance.sheet')
                           ?'dropdown-item active' :'dropdown-item'}}"
                           href="{{route('report.balance.sheet')}}">
                           {{__('Balance Sheet')}}
                        </a>
                        <a class="{{ (Request::route()->getName() == 'trial.balance')
                           ?'dropdown-item active' :'dropdown-item'}}"
                           href="{{route('trial.balance')}}">
                           {{__('Trial Balance')}}
                        </a>
                     </div>
                  </div>
               </div>
            </li>
            @endif
            @if(\Auth::user()->type =='company')
            <li class="{{ (Request::segment(1) == 'budget')?'active':''}}">
               <a href="{{ route('budget.index') }}" class="{{ (Request::route()->getName() == 'budget.index')
                  ?'nav-link active' :'nav-link'}}">
                  <span class=" d-md-none d-lg-inline-block">
                     <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-forms" width="24"
                      height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                       stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 3a3 3 0 0 0 -3 3v12a3 3 0 0 0 3 3"></path>
                        <path d="M6 3a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3"></path>
                        <path d="M13 7h7a1 1 0 0 1 1 1v8a1 1 0 0 1 -1 1h-7"></path>
                        <path d="M5 7h-1a1 1 0 0 0 -1 1v8a1 1 0 0 0 1 1h1"></path>
                        <path d="M17 12h.01"></path>
                        <path d="M13 12h.01"></path>
                     </svg>
                  </span>
                  <span class="nav-link-title">{{__('Budget Planner')}}</span>
               </a>
            </li>
            @endif
            @if(Gate::check('manage goal'))
            <li>
               <a href="{{ route('goal.index') }}" class="{{ (Request::route()->getName() == 'goal.index')
                  ?'nav-link active' :'nav-link'}}">
                  <span class=" d-md-none d-lg-inline-block">
                     <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home-stats"
                      width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                       fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M19 13v-1h2l-9 -9l-9 9h2v7a2 2 0 0 0 2 2h2.5"></path>
                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2"></path>
                        <path d="M13 22l3 -3l2 2l4 -4"></path>
                        <path d="M19 17h3v3"></path>
                     </svg>
                  </span>
                  <span class="nav-link-title">{{ __('Financial Goal') }}</span>
               </a>
            </li>
            @endif
            @if(Gate::check('manage constant tax') || Gate::check('manage constant category')
             ||Gate::check('manage constant unit')
             ||Gate::check('manage constant payment method')
             ||Gate::check('manage constant custom field') )
            <li>
               <a href="{{ route('taxes.index') }}" class="{{ (Request::route()->getName() == 'taxes.index')
                  ?'nav-link active' :'nav-link'}}">
                  <span class=" d-md-none d-lg-inline-block">
                     <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-adjustments-check"
                      width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                       fill="none" stroke-linecap="round" stroke-linejoin="round">
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
                  <span class="nav-link-title"> {{ __('Accounting Setup') }}</span>
               </a>
            </li>
            @endif
            @if(Gate::check('manage print settings'))
            <li>
               @if(Request::route()->getName()=="print.setting")
                  @php $printactive='nav-link actives'; @endphp
               @else
                  @php $printactive='nav-link'; @endphp
               @endif
               <a href="{{ route('print.setting') }}"  class="{{ $printactive }}">
                  <span class=" d-md-none d-lg-inline-block">
                     <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer" width="24"
                      height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                       stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0
                         -2 2v4a2 2 0 0 0 2 2h2"></path>
                        <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"></path>
                        <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"></path>
                     </svg>
                  </span>
                  <span class="nav-link-title">  {{ __('Print Settings') }} </span>
               </a>
               @endif
            </li>
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
