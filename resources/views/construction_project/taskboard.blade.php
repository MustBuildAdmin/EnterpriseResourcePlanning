@include('new_layouts.header')
{{-- @extends('layouts.admin') --}}
<link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.css') }}">

<link rel="stylesheet" href="{{ asset('tokeninput/tokeninput.css') }}">

<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet"/>
<style>
    .nav-item .active {
        background: #c6c6c7 !important;
        color: #000000 !important;
    }
    .wrappers{
        display: flex;
        justify-content: center;
    }
    .cards {
        display: flex;
        padding: 24px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .loader{
        border-radius: 50%;
        position: relative;
        display: inline-block;
        height: 0px;
        width: 0px;
    }

    .loader span{
        position: absolute;
        display: block;
        background: #ddd;
        height: 15px;
        width: 15px;
        border-radius: 50%;
        top: -20px;
        perspective: 100000px;
    }
    .loader span:nth-child(1) {
        left:30px;
        animation: bounce2 1s cubic-bezier(0.04, 0.35, 0, 1) infinite;
        animation-delay: 0s;
        background: #ff756f;
    }
    .loader span:nth-child(2) {
        left:6px;
        animation: bounce2 1s cubic-bezier(0.04, 0.35, 0, 1) infinite;
        animation-delay: .2s;
        background: #ffde6f;
    }
    .loader span:nth-child(3) {
        left:-20px;
        animation: bounce2 1s cubic-bezier(0.04, 0.35, 0, 1) infinite;
        animation-delay: .4s;
        background: #01de6f;
    }
    .loader span:nth-child(4) {
        left: -44px;
        animation: bounce2 1s cubic-bezier(0.04, 0.35, 0, 1) infinite;
        animation-delay: .6s;
        background: #6f75ff;
    }

    @keyframes bounce2 {
        0%, 56%, 100% {
            transform: translateY(0px);
        }
        25% {
            transform: translateY(-30px);
        }
    }
</style>
    <div class="page-wrapper">
        @include('construction_project.side-menu')
        <div class="row">
            <div class="row min-750" id="taskboard_view">
                <div class="col-md-12">
                    <div class="card">
                        <div class="col-12">
                            <br>
                            <div class="card-header">
                                <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a href="#tabs-home-7" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler  me-2 icon-tabler-calendar-star" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M11 21h-5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v3.5"></path>
                                                <path d="M16 3v4"></path>
                                                <path d="M8 3v4"></path>
                                                <path d="M4 11h11"></path>
                                                <path d="M17.8 20.817l-2.172 1.138a.392 .392 0 0 1 -.568 -.41l.415 -2.411l-1.757 -1.707a.389 .389 0 0 1 .217 -.665l2.428 -.352l1.086 -2.193a.392 .392 0 0 1 .702 0l1.086 2.193l2.428 .352a.39 .39 0 0 1 .217 .665l-1.757 1.707l.414 2.41a.39 .39 0 0 1 -.567 .411l-2.172 -1.138z"></path>
                                            </svg>
                                            Sub Tasks
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a href="#tabs-profile-7" class="nav-link" data-bs-toggle="tab" aria-selected="false" tabindex="-1" role="tab">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler me-2 icon-tabler-calendar-up" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M12.5 21h-6.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v5"></path>
                                                <path d="M16 3v4"></path>
                                                <path d="M8 3v4"></path>
                                                <path d="M4 11h16"></path>
                                                <path d="M19 22v-6"></path>
                                                <path d="M22 19l-3 -3l-3 3"></path>
                                            </svg>
                                            Summary
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <center>
                                <section class="wrappers loader_show_hide" style="display: none;">
                                    <div class="cards">
                                        <div class="loader">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        </div>
                                    </div>
                                </section>
                            </center>

                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane active show" id="tabs-home-7" role="tabpanel">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">Task Lists Information</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-2 border-end p-3">
                                                            <form>
                                                                <div class="col-md-12">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Search By Task Name or Id</label>
                                                                            <input type="text" id="skill_input" value="{{ request()->get('q') }}" >
                                                                        </div>
                                                                </div>
                                                                <div class="col-12 mb-3">
                                                                    <label class="form-label required">Task  Planned Start Date</label>
                                                                    <div class="input-icon">
                                                                        <span class="input-icon-addon">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" 
                                                                            stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                            <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                                                            <path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M11 15h1" /><path d="M12 15v3" /></svg>
                                                                        </span>
                                                                        <input class="form-control" placeholder="Select a Start date" id="start-date"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 mb-3">
                                                                    <label class="form-label required">Task Planned End Date</label>
                                                                    <div class="input-icon">
                                                                        <span class="input-icon-addon">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                                                            stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                            <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                                                            <path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M11 15h1" /><path d="M12 15v3" />
                                                                            </svg>
                                                                        </span>
                                                                        <input class="form-control" placeholder="Select a End date" id="end-date"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Search Assignee</label>
                                                                        <input type="text" id="user_select" value="{{ request()->get('selectsearch') }}" >
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Task Status</label>
                                                                        <select type="text" class="form-select" placeholder="Task Status" id="task-status" value="">
                                                                            <option value="">Select Status</option>
                                                                            <option value="completed">Completed</option>
                                                                            <option value="pending">Pending</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 mt-4">
                                                                    <div class="mb-3">
                                                                        <button class="btn btn-tabler w-100">Search</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                            
                                                        <div class="col-md-10">
                                                            <div class="table-responsive card p-4" id="all_task_append">
                                                                {{-- SUB task show --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabs-profile-7" role="tabpanel">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">Summary Lists Information</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="col-md-12">
                                                        <div class="table-responsive card p-4">
                                                            <table class="table table-vcenter card-table" id="summary-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Summary ID</th>
                                                                        <th>Summary Name</th>
                                                                        <th>Summary Status</th>
                                                                        <th>Actual Progress</th>
                                                                        <th>Planned Progress</th>
                                                                        <th>Planned Start Date</th>
                                                                        <th>Planned End Date</th>
                                                                        <th>Assigned To</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                        <td><a href="#">345432345432356</a></td>
                                                                        <td>Tabler is a free and open source web application UI kit based on Bootstrap 5, with hundreds responsive components and multiple layouts.</td>
                                                                        <td><span class="badge bg-warning me-1"></span> Pending</td>
                                                                        <td class="sort-progress" data-progress="30">
                                                                            <div class="row align-items-center">
                                                                                <div class="col-12 col-lg-auto">30%</div>
                                                                                <div class="col">
                                                                                <div class="progress" style="width: 5rem">
                                                                                    <div class="progress-bar bg-red" style="width: 40%" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" aria-label="30% Complete">
                                                                                    <span class="visually-hidden">30% Complete</span>
                                                                                    </div>
                                                                                </div>
                                                                                </div>
                                                                            </div>
                                                                            </td>
                                                                        <td class="sort-progress" data-progress="30">
                                                                            <div class="row align-items-center">
                                                                                <div class="col-12 col-lg-auto">30%</div>
                                                                                <div class="col">
                                                                                <div class="progress" style="width: 5rem">
                                                                                    <div class="progress-bar" style="width: 30%" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" aria-label="30% Complete">
                                                                                    <span class="visually-hidden">30% Complete</span>
                                                                                    </div>
                                                                                </div>
                                                                                </div>
                                                                            </div>
                                                                            </td>
                                                                        <td>
                                                                            15 Dec 2017
                                                                            </td>
                                                                        <td>
                                                                            15 Dec 2017
                                                                            </td>
                                                                        <td><div class="avatar-list avatar-list-stacked">
                                                                            <span class="avatar avatar-xs rounded" style="background-image: url(./static/avatars/000m.jpg)"></span>
                                                                            <span class="avatar avatar-xs rounded">JL</span>
                                                                            <span class="avatar avatar-xs rounded" style="background-image: url(./static/avatars/002m.jpg)"></span>
                                                                            <span class="avatar avatar-xs rounded" style="background-image: url(./static/avatars/003m.jpg)"></span>
                                                                            <span class="avatar avatar-xs rounded" style="background-image: url(./static/avatars/000f.jpg)"></span>
                                                                            <span class="avatar avatar-xs rounded">+3</span>
                                                                        </div></td>
                                                                    </tr>
                                                                    <tr>
                                                                    <td><a href="#">345432345432356</a></td>
                                                                    <td>Tabler is a free and open source web application UI kit based on Bootstrap 5, with hundreds responsive components and multiple layouts.</td>
                                                                    <td><span class="badge bg-info me-1"></span> In-Progress</td>
                                                                    <td class="sort-progress" data-progress="30">
                                                                        <div class="row align-items-center">
                                                                            <div class="col-12 col-lg-auto">30%</div>
                                                                            <div class="col">
                                                                            <div class="progress" style="width: 5rem">
                                                                                <div class="progress-bar" style="width: 40%" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" aria-label="30% Complete">
                                                                                <span class="visually-hidden">30% Complete</span>
                                                                                </div>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                        </td>
                                                                    <td class="sort-progress" data-progress="30">
                                                                        <div class="row align-items-center">
                                                                            <div class="col-12 col-lg-auto">30%</div>
                                                                            <div class="col">
                                                                            <div class="progress" style="width: 5rem">
                                                                                <div class="progress-bar" style="width: 30%" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" aria-label="30% Complete">
                                                                                <span class="visually-hidden">30% Complete</span>
                                                                                </div>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                        </td>
                                                                    <td>
                                                                        15 Dec 2017
                                                                        </td>
                                                                    <td>
                                                                        15 Dec 2017
                                                                        </td>
                                                                    <td><div class="avatar-list avatar-list-stacked">
                                                                        <span class="avatar avatar-xs rounded" style="background-image: url(./static/avatars/000m.jpg)"></span>
                                                                        <span class="avatar avatar-xs rounded">JL</span>
                                                                        <span class="avatar avatar-xs rounded" style="background-image: url(./static/avatars/002m.jpg)"></span>
                                                                        <span class="avatar avatar-xs rounded" style="background-image: url(./static/avatars/003m.jpg)"></span>
                                                                        <span class="avatar avatar-xs rounded" style="background-image: url(./static/avatars/000f.jpg)"></span>
                                                                        <span class="avatar avatar-xs rounded">+3</span>
                                                                    </div></td>
                                                                    </tr>
                                                                    <tr>
                                                                    <td><a href="#">345432345432356</a></td>
                                                                    <td>Tabler is a free and open source web application UI kit based on Bootstrap 5, with hundreds responsive components and multiple layouts.</td>
                                                                    <td><span class="badge bg-success me-1"></span>Completed</td>
                                                                    <td class="sort-progress" data-progress="30">
                                                                        <div class="row align-items-center">
                                                                            <div class="col-12 col-lg-auto">100%</div>
                                                                            <div class="col">
                                                                            <div class="progress" style="width: 5rem">
                                                                                <div class="progress-bar bg-green" style="width: 100%" role="progressbar bg-danger" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" aria-label="30% Complete">
                                                                                    <span class="visually-hidden">100% Complete</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        </td>
                                                                    <td class="sort-progress" data-progress="30">
                                                                        <div class="row align-items-center">
                                                                            <div class="col-12 col-lg-auto">100%</div>
                                                                            <div class="col">
                                                                            <div class="progress" style="width: 5rem">
                                                                                <div class="progress-bar bg-green" style="width: 100%" role="progressbar bg-danger" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" aria-label="30% Complete">
                                                                                <span class="visually-hidden">100% Complete</span>
                                                                                </div>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                        </td>
                                                                    <td>
                                                                        15 Dec 2017
                                                                        </td>
                                                                    <td>
                                                                        15 Dec 2017
                                                                        </td>
                                                                    <td><div class="avatar-list avatar-list-stacked">
                                                                        <span class="avatar avatar-xs rounded" style="background-image: url(./static/avatars/000m.jpg)"></span>
                                                                        <span class="avatar avatar-xs rounded">JL</span>
                                                                        <span class="avatar avatar-xs rounded" style="background-image: url(./static/avatars/002m.jpg)"></span>
                                                                        <span class="avatar avatar-xs rounded" style="background-image: url(./static/avatars/003m.jpg)"></span>
                                                                        <span class="avatar avatar-xs rounded" style="background-image: url(./static/avatars/000f.jpg)"></span>
                                                                        <span class="avatar avatar-xs rounded">+3</span>
                                                                    </div></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@include('new_layouts.footer')

<script src="{{ asset('tom-select/tom-select.popular.min.js') }}"></script>
<script src="{{ asset('litepicker/litepicker.js') }}"></script>
<script src="{{ asset('tokeninput/jquery.tokeninput.js') }}"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $("#skill_input").tokenInput("{{route('task_autocomplete')}}", {
            propertyToSearch:"text",
            tokenValue:"id",
            tokenDelimiter:",",
            hintText: "Search Task...",
            noResultsText: "Task not found.",
            searchingText: "Searching...",
            deleteText:"&#215;",
            minChars: 2,
            tokenLimit: 4,
            animateDropdown: false,
            resultsLimit:10,
            deleteText: "&times;",
            preventDuplicates: true,
            theme: "bootstrap"
        });

        $("#user_select").tokenInput("{{route('user_autocomplete')}}", {
            propertyToSearch:"name",
            tokenValue:"id",
            tokenDelimiter:",",
            hintText: "Search Users...",
            noResultsText: "User not found.",
            searchingText: "Searching...",
            deleteText:"&#215;",
            minChars: 2,
            tokenLimit: 4,
            animateDropdown: false,
            resultsLimit:10,
            deleteText: "&times;",
            preventDuplicates: true,
            theme: "bootstrap",
            queryParam:"selectsearch",
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        window.Litepicker && (new Litepicker({
            element: document.getElementById('start-date'),
            elementEnd: document.getElementById('end-date'),
            singleMode: false,
            allowRepick: true,
            buttonText: {
                previousMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
                nextMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
            },
        }));
    });

    document.addEventListener("DOMContentLoaded", function () {
        var el;
        window.TomSelect && (new TomSelect(el = document.getElementById('task-name'), {
            copyClassesToDropdown: false,
            plugins: ['remove_button'],
            dropdownParent: 'body',
            controlInput: '<input>',
            render:{
                item: function(data,escape) {
                    if( data.customProperties ){
                        return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                    }
                    return '<div>' + escape(data.text) + '</div>';
                },
                option: function(data,escape){
                    if( data.customProperties ){
                        return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                    }
                    return '<div>' + escape(data.text) + '</div>';
                },
                search: function(){
                    console.log("ll");
                },
            },
        }));
    });

    document.addEventListener("DOMContentLoaded", function () {
        var el;
        window.TomSelect && (new TomSelect(el = document.getElementById('search-assignee'), {
                        copyClassesToDropdown: false,            plugins: ['remove_button'],
            dropdownParent: 'body',
            controlInput: '<input>',
            render:{
                item: function(data,escape) {
                    if( data.customProperties ){
                        return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                    }
                    return '<div>' + escape(data.text) + '</div>';
                },
                option: function(data,escape){
                    if( data.customProperties ){
                        return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                    }
                    return '<div>' + escape(data.text) + '</div>';
                },
            },
        }));
    });

    document.addEventListener("DOMContentLoaded", function () {
        var el;
        window.TomSelect && (new TomSelect(el = document.getElementById('task-status'), {
                        copyClassesToDropdown: false,            plugins: ['remove_button'],
            dropdownParent: 'body',
            controlInput: '<input>',
            render:{
                item: function(data,escape) {
                    if( data.customProperties ){
                        return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                    }
                    return '<div>' + escape(data.text) + '</div>';
                },
                option: function(data,escape){
                    if( data.customProperties ){
                        return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                    }
                    return '<div>' + escape(data.text) + '</div>';
                },
            },
        }));
    });
    
    $(function () {
        alltask();
    });

    function alltask(start_date,end_date,user_id,status_task){
        // $(".loader_show_hide").show();
        $("#all_task_append").html("");
        $.ajax({
            url : '{{route("get_all_task")}}',
            type : 'GET',
            data : {
                'start_date'  : start_date,
                'end_date'    : end_date,
                'user_id'     : user_id,
                'status_task' : status_task
            },
            cache:true,
            success : function(data) {
                if(data['success'] == true){
                    $("#all_task_append").html(data['all_task']);
                }
                // $(".loader_show_hide").hide();
            },
            error : function(request,error)
            {
                alert("Request: "+JSON.stringify(request));
            }
        });
    }

    function submit_button(){
        start_date  = $(".start_date").val();
        end_date    = $(".end_date").val();
        user_id     = JSON.stringify($("#users").val());
        status_task = $("#status_task").val();


        alltask(start_date,end_date,user_id,status_task);
    }

    function maintask(){
        // $(".loader_show_hide").show();
        $("#main_task_append").html("");

        $(".start_date").val("");
        $("#status_task").val("");
        $('.chosen-select option').prop('selected', false).trigger('chosen:updated');

        $.ajax({
            url : '{{route("main_task_list")}}',
            type : 'GET',
            data : {
            },
            cache:true,
            success : function(data) {
                if(data['success'] == true){
                    $("#main_task_append").html(data['main_task']);
                }
                // $(".loader_show_hide").hide();
            },
            error : function(request,error)
            {
                alert("Request: "+JSON.stringify(request));
            }
        });
    }

    function status_task(get_this){
        status = $(get_this).val();

        if(status == 1){
            $(".end_date").val("");
            $(".start_date").val("");
        }
        else if(status == ""){
            $(".end_date").val("{{date('Y-m-d')}}");
        }
    }

    function start_date_change(){
        status = $("#status_task").val();
        if(status == 1){
            $("#status_task").val("");
        }
    }

    function end_date_change(){
        status = $("#status_task").val();
        if(status == 1){
            $("#status_task").val("");
        }
    }
</script>
