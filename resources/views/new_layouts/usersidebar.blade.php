<!-- <div class="col-3 d-none d-md-block border-end">
<div class="card-body">
    <div class="list-group list-group-transparent">
        <a href="{{ route('my-info') }}"  class="{{request()->route()->uri =='my-info' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}">{{ __('MyInfo') }} </a>
        <a href="{{ route('my-leave') }}"  class="{{request()->route()->uri =='my-leave' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}">{{ __('MyLeave') }} </a>
        <a href="{{ route('my-payslip') }}"  class="{{request()->route()->uri =='my-payslip' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}">{{ __('MyPayslip') }} </a>
        <a href="{{ route('my-performance') }}"  class="{{request()->route()->uri =='my-performance' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}">{{ __('MyPerformance') }} </a>
        <a href="{{ route('my-goals') }}"  class="{{request()->route()->uri =='my-goals' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}">{{ __('Mygoals') }} </a>
        <a href="{{ route('my-relief') }}"  class="{{request()->route()->uri =='my-relief' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}">{{ __('Myrelief') }} </a>
        <a href="{{ route('my-appraisal') }}"  class="{{request()->route()->uri =='my-appraisal' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}">{{ __('Myappraisal') }} </a>

    </div>
</div>
</div> -->
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
        <div class="sidebar myinfo">
            <ul class="list-unstyled components nav nav-sidebar">
                <li>
                <a href="{{ route('my-info') }}"  class="{{request()->route()->uri =='my-info' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}"><span class="icon"><i class="ti ti-user"></i></span><span class="list">{{ __('MyInfo') }}</span> </a>
               
                <!-- <a href="{{ route('my-performance') }}"  class="{{request()->route()->uri =='my-performance' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}"><span class="icon"><i class="ti ti-calendar-stats"></i></span><span class="list">{{ __('MyPerformance') }} </span> </a>
                <a href="{{ route('my-goals') }}"  class="{{request()->route()->uri =='my-goals' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}"><span class="icon"><i class="ti ti-calendar-stats"></i></span><span class="list">{{ __('Mygoals') }} </span> </a>
                <a href="{{ route('my-relief') }}"  class="{{request()->route()->uri =='my-relief' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}"><span class="icon"><i class="ti ti-calendar-stats"></i></span><span class="list">{{ __('Myrelief') }} </span> </a>
                <a href="{{ route('my-appraisal') }}"  class="{{request()->route()->uri =='my-appraisal' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}"><span class="icon"><i class="ti ti-calendar-stats"></i></span><span class="list">{{ __('Myappraisal') }} </span> </a> -->
                </li>
                <li>
                   <a href="{{ route('my-leave') }}"  class="{{request()->route()->uri =='my-leave' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}"><span class="icon"><i class="ti ti-calendar-stats"></i></span><span class="list">{{ __('MyLeave') }} </span> </a>
                </li> 
                <li>
                   <a href="{{ route('my-payslip') }}"  class="{{request()->route()->uri =='my-payslip' ? 'list-group-item list-group-item-action d-flex align-items-center active':'list-group-item list-group-item-action d-flex align-items-center'}}"><span class="icon"><i class="ti ti-calendar-stats"></i></span><span class="list">{{ __('MyPayslip') }} </span> </a>
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
