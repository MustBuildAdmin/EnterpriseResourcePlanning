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
                {{-- @if(Gate::check('manage customer'))
                <li class="{{ (Request::segment(1) == 'customer')?'active':''}}">
                    <a href="{{route('customer.index')}}"><span
                            class="icon"><i class="ti ti-users"></i>
                        </span><span class="list">{{__('Customer')}}</span>
                       
                    </a>
                </li>
                @endif --}}

                @if(Gate::check('manage product & service'))
                <li class="{{ (Request::segment(1) == 'productservice')?'active':''}}" >
                    <a data-bs-target="#expense" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                        <span class="icon"><i class="ti ti-users"></i></span>
                        <span class="list">{{__('Product & Services')}}</span>
                    </a>
                    <ul class="collapse list-unstyled" id="expense">
                      
                            <li class="{{ (Request::route()->getName() == 'bill.index' || Request::route()->getName() == 'bill.create' || Request::route()->getName() == 'bill.edit' || Request::route()->getName() == 'bill.show') ? ' active' : '' }}"><a href="{{ route('productservice.index') }}">{{__('Product & Services')}}</a></li>
                     
                       
                            <li class="{{ (Request::segment(1) == 'productstock')?'active':''}}"><a href="{{ route('productstock.index') }}" >{{__('Product Stock')}}</a></li>

                            
                       
                    </ul>
                </li>
                @endif

                @if(Gate::check('manage vender'))
                <li class="{{ (Request::segment(1) == 'vender')?'active':''}}">
                    <a href="{{ route('vender.index') }}"><span
                            class="icon"><i class="ti ti-users"></i>
                        </span><span class="list">{{__('Vendor')}}</span>
                       
                    </a>
                </li>
                @endif

                @if(Gate::check('manage proposal'))
                <li class="{{ (Request::segment(1) == 'proposal')?'active':''}}">
                    <a href="{{ route('proposal.index') }}"><span
                            class="icon"><img src="assets/images/icons/sticky-note.png"/>
                        </span><span class="list">{{__('Proposal')}}</span>
                       
                    </a>
                </li>
                @endif


                @if( Gate::check('manage bank account') ||  Gate::check('manage bank transfer'))
                    <li class="{{(Request::segment(1) == 'bank-account' || Request::segment(1) == 'bank-transfer')? 'active dash-trigger' :''}}">
                        <a data-bs-target="#banking" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                            <span class="icon"><img src="assets/images/icons/bank.png"/></span>
                            <span class="list">{{ __('Banking') }}</span>
                        </a>
                        <ul class="collapse list-unstyled" id="banking">
                          
                                <li class="{{ (Request::route()->getName() == 'bank-account.index' || Request::route()->getName() == 'bank-account.create' || Request::route()->getName() == 'bank-account.edit') ? ' active' : '' }}"><a href="{{ route('bank-account.index') }}">{{__('Account')}}</a></li>
                         
                           
                                <li class=" {{ (Request::route()->getName() == 'bank-transfer.index' || Request::route()->getName() == 'bank-transfer.create' || Request::route()->getName() == 'bank-transfer.edit') ? ' active' : '' }}"><a href="{{route('bank-transfer.index')}}">{{__('Transfer')}}</a></li>
                           
                        </ul>
                    </li>
                @endif


                @if( Gate::check('manage invoice') ||  Gate::check('manage revenue') ||  Gate::check('manage credit note'))
                    <li class="{{(Request::segment(1) == 'invoice' || Request::segment(1) == 'revenue' || Request::segment(1) == 'credit-note')? 'active dash-trigger' :''}}">
                        <a data-bs-target="#income" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                            <span class="icon"><img src="assets/images/icons/salary.png"/></span>
                            <span class="list">{{ __('Income') }}</span>
                        </a>
                        <ul class="collapse list-unstyled" id="income">
                          
                                <li class="{{ (Request::route()->getName() == 'invoice.index' || Request::route()->getName() == 'invoice.create' || Request::route()->getName() == 'invoice.edit' || Request::route()->getName() == 'invoice.show') ? ' active' : '' }}"><a href="{{ route('invoice.index') }}">{{__('Invoice')}}</a></li>
                         
                           
                                <li class="{{ (Request::route()->getName() == 'revenue.index' || Request::route()->getName() == 'revenue.create' || Request::route()->getName() == 'revenue.edit') ? ' active' : '' }}"><a href="{{route('revenue.index')}}">{{__('Revenue')}}</a></li>

                                <li class="{{ (Request::route()->getName() == 'credit.note' ) ? ' active' : '' }}"><a href="{{route('credit.note')}}">{{__('Credit Note')}}</a></li>
                           
                        </ul>
                    </li>
                @endif

                @if( Gate::check('manage bill')  ||  Gate::check('manage payment') ||  Gate::check('manage debit note'))
                <li class="{{(Request::segment(1) == 'bill' || Request::segment(1) == 'payment' || Request::segment(1) == 'debit-note')? 'active dash-trigger' :''}}">
                    <a data-bs-target="#expense" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                        <span class="icon"><img src="assets/images/icons/expenses.png"/></span>
                        <span class="list">{{ __('Expense') }}</span>
                    </a>
                    <ul class="collapse list-unstyled" id="expense">
                      
                            <li class="{{ (Request::route()->getName() == 'bill.index' || Request::route()->getName() == 'bill.create' || Request::route()->getName() == 'bill.edit' || Request::route()->getName() == 'bill.show') ? ' active' : '' }}"><a href="{{ route('bill.index') }}">{{__('Bill')}}</a></li>
                     
                       
                            <li class="{{ (Request::route()->getName() == 'payment.index' || Request::route()->getName() == 'payment.create' || Request::route()->getName() == 'payment.edit') ? ' active' : '' }}"><a href="{{route('payment.index')}}">{{__('Payment')}}</a></li>

                            <li class="{{ (Request::route()->getName() == 'debit.note' ) ? ' active' : '' }}"><a href="{{route('debit.note')}}">{{__('Debit Note')}}</a></li>
                       
                    </ul>
                </li>
                @endif

                @if( Gate::check('manage chart of account') ||  Gate::check('manage journal entry') ||   Gate::check('balance sheet report') ||  Gate::check('ledger report') ||  Gate::check('trial balance report'))
                <li class="{{(Request::segment(1) == 'chart-of-account' || Request::segment(1) == 'journal-entry' || Request::segment(2) == 'ledger' ||  Request::segment(2) == 'balance-sheet' ||  Request::segment(2) == 'trial-balance')? 'active dash-trigger' :''}}">
                    <a data-bs-target="#double" data-bs-toggle="collapse" aria-expanded="false" class="accordion-collapse collapse list-unstyled">
                        <span class="icon"><img src="assets/images/icons/bookkeeping.png"/></span>
                        <span class="list">{{__('Double Entry')}}</span>
                    </a>
                    <ul class="collapse list-unstyled" id="double">
                      
                            <li class=" {{ (Request::route()->getName() == 'chart-of-account.index') ? ' active' : '' }}"><a href="{{ route('chart-of-account.index') }}">{{__('Chart of Accounts')}}</a></li>
                     
                       
                            <li class="{{ (Request::route()->getName() == 'journal-entry.edit' || Request::route()->getName() == 'journal-entry.create' || Request::route()->getName() == 'journal-entry.index' || Request::route()->getName() == 'journal-entry.show') ? ' active' : '' }}"><a href="{{ route('journal-entry.index') }}">{{__('Journal Account')}}</a></li>

                            <li class="{{ (Request::route()->getName() == 'report.ledger' ) ? ' active' : '' }}"><a href="{{route('report.ledger')}}">{{__('Ledger Summary')}}</a></li>
                            <li class="{{ (Request::route()->getName() == 'report.balance.sheet' ) ? ' active' : '' }}"><a href="{{route('report.balance.sheet')}}">{{__('Balance Sheet')}}</a></li>

                            <li class=" {{ (Request::route()->getName() == 'trial.balance' ) ? ' active' : '' }}"><a href="{{route('trial.balance')}}">{{__('Trial Balance')}}</a></li>
                       
                    </ul>
                </li>
                @endif

                @if(\Auth::user()->type =='company')
                <li class="{{ (Request::segment(1) == 'budget')?'active':''}}">
                    <a href="{{ route('budget.index') }}"><span
                            class="icon"><img src="assets/images/icons/budget.png"/>
                        </span><span class="list"> {{__('Budget Planner')}}</span>
                       
                    </a>
                </li>
                @endif

                @if(Gate::check('manage goal'))
                <li class="{{ (Request::segment(1) == 'goal')?'active':''}}">
                    <a href="{{ route('goal.index') }}"><span
                            class="icon"><img src="assets/images/icons/target.png"/>
                        </span><span class="list">{{__('Financial Goal')}}</span>
                       
                    </a>
                </li>
                @endif

                @if(Gate::check('manage constant tax') || Gate::check('manage constant category') ||Gate::check('manage constant unit') ||Gate::check('manage constant payment method') ||Gate::check('manage constant custom field') )
                <li class="{{(Request::segment(1) == 'taxes' || Request::segment(1) == 'product-category' || Request::segment(1) == 'product-unit' || Request::segment(1) == 'payment-method' || Request::segment(1) == 'custom-field' || Request::segment(1) == 'chart-of-account-type')? 'active dash-trigger' :''}}">
                    <a href="{{ route('taxes.index') }}"><span
                            class="icon"><img src="assets/images/icons/settings.png"/>
                        </span><span class="list">{{__('Accounting Setup')}}</span>
                       
                    </a>
                </li>
                @endif

                @if(Gate::check('manage print settings'))
                <li class="{{ (Request::route()->getName() == 'print-setting') ? ' active' : '' }}">
                    <a href="{{ route('print.setting') }}"><span
                            class="icon"><img src="assets/images/icons/printer.png"/>
                        </span><span class="list">{{__('Print Settings')}}</span>
                       
                    </a>
                </li>
                @endif

               
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
