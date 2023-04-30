
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
                @can('manage lead')
                <li class="{{ (Request::route()->getName() == 'leads.list' || Request::route()->getName() == 'leads.index' || Request::route()->getName() == 'leads.show') ? ' active' : '' }}">
                    <a href="{{ route('leads.index') }}"><span class="icon"><i class="ti ti-dashboard"></i></span><span
                            class="list">{{__('Leads')}}</span></a>
                </li>
                @endcan
                @can('manage deal')
                <li class="{{ (Request::route()->getName() == 'deals.list' || Request::route()->getName() == 'deals.index' || Request::route()->getName() == 'deals.show') ? ' active' : '' }}">
                    <a href="{{ route('deals.index') }}"><span
                            class="icon"><i class="ti ti-users"></i>
                        </span><span class="list">{{__('Deals')}}</span>
                    </a>
                </li>
                @endcan
                @can('manage form builder')
                <li class="{{ (Request::segment(1) == 'form_builder' || Request::segment(1) == 'form_response')?'active open':''}}">
                    <a href="{{route('form_builder.index')}}"> <span class="icon"><i class="ti ti-calendar-stats"></i></span><span
                            class="list">{{__('Form Builder')}}</span></a>
                </li>
                @endcan
                @if(\Auth::user()->type=='company')
                <li class="{{ (Request::route()->getName() == 'contract.index' || Request::route()->getName() == 'contract.show')?'active':''}}">
                    <a href="{{route('contract.index')}}"><span class="icon"><i class="ti ti-calendar-stats"></i></span><span
                            class="list">{{__('Contract')}}</span></a>
                </li>
                @endif
                @if(Gate::check('manage lead stage') || Gate::check('manage pipeline') ||Gate::check('manage source') ||Gate::check('manage label') || Gate::check('manage stage'))
                <li class='{{(Request::segment(1) == 'stages' || Request::segment(1) == 'labels' || Request::segment(1) == 'sources' || Request::segment(1) == 'lead_stages' || Request::segment(1) == 'pipelines' || Request::segment(1) == 'product-category' || Request::segment(1) == 'product-unit' || Request::segment(1) == 'payment-method' || Request::segment(1) == 'custom-field' || Request::segment(1) == 'chart-of-account-type')? 'active dash-trigger' :''}}'>
                    <a href="{{ route('pipelines.index') }}"><span class="icon"><i class="ti ti-chart-infographic"></i></span><span
                            class="list">{{__('CRM System Setup')}}</span></a>
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
