@include('new_layouts.header')
{{-- @extends('layouts.admin') --}}
<link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.css') }}">

<link rel="stylesheet" href="{{ asset('tokeninput/tokeninput.css') }}">

<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet"/>

    <div class="page-wrapper">
        @include('construction_project.side-menu')
            <div class="container-fluid" id="taskboard_view">
                <div class="p-4">
                    <div class="card">
                        <div class="col-12">
                            <div class="card-header">
                                <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs" role="tablist">
                                    <li class="nav-item" role="presentation" onclick="alltask()">
                                        <a href="#tabs-home-7" class="nav-link active" data-bs-toggle="tab"
                                        aria-selected="true" role="tab">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler  me-2 icon-tabler-calendar-star" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path
                                                d="M11 21h-5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v3.5">
                                                </path>
                                                <path d="M16 3v4"></path>
                                                <path d="M8 3v4"></path>
                                                <path d="M4 11h11"></path>
                                                <path
                                                d="M17.8 20.817l-2.172 1.138a.392 .392 0 0 1 -.568 -.41l.415
                                                -2.411l-1.757 -1.707a.389 .389 0 0 1 .217 -.665l2.428 -.352l1.086
                                                -2.193a.392 .392 0 0 1 .702 0l1.086 2.193l2.428 .352a.39 .39 0 0
                                                1 .217 .665l-1.757 1.707l.414 2.41a.39 .39 0 0 1 -.567
                                                .411l-2.172 -1.138z"></path>
                                            </svg>
                                            {{ __('Tasks') }}
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation" onclick="maintask()">
                                        <a href="#tabs-profile-7" class="nav-link" data-bs-toggle="tab"
                                        aria-selected="false" tabindex="-1" role="tab">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler me-2 icon-tabler-calendar-up" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M12.5 21h-6.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1
                                                2 -2h12a2 2 0 0 1 2 2v5"></path>
                                                <path d="M16 3v4"></path>
                                                <path d="M8 3v4"></path>
                                                <path d="M4 11h16"></path>
                                                <path d="M19 22v-6"></path>
                                                <path d="M22 19l-3 -3l-3 3"></path>
                                            </svg>
                                            {{ __('Summary') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>


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
            

                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane active show" id="tabs-home-7" role="tabpanel">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">{{ __('Task Lists Information') }}</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-2 border-end p-3">
                                                            <form>
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">
                                                                            {{ __('Search By Task Name or Id') }}
                                                                        </label>
                                                                        <input type="text" id="skill_input"
                                                                        value="{{ request()->get('q') }}" >
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 mb-3">
                                                                    <label class="form-label required">
                                                                        {{ __('Task  Planned Start Date') }}
                                                                    </label>
                                                                    <div class="input-icon">
                                                                        <span class="input-icon-addon">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                            class="icon" width="24" height="24"
                                                                            viewBox="0 0 24 24" stroke-width="2"
                                                                            stroke="currentColor" fill="none"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round">
                                                                            <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none"/>
                                                                            <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0
                                                                            1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0
                                                                            1 -2 -2v-12z" />
                                                                            <path d="M16 3v4" /><path d="M8 3v4" />
                                                                            <path d="M4 11h16" /><path d="M11 15h1" />
                                                                            <path d="M12 15v3" /></svg>
                                                                        </span>
                                                                        <input class="form-control start_date"
                                                                        placeholder="Select a Start date"
                                                                        id="start-date"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 mb-3">
                                                                    <label class="form-label required">
                                                                        {{ __('Task Planned End Date') }}
                                                                    </label>
                                                                    <div class="input-icon">
                                                                        <span class="input-icon-addon">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                            class="icon" width="24" height="24"
                                                                            viewBox="0 0 24 24" stroke-width="2"
                                                                            stroke="currentColor" fill="none"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round"><path stroke="none"
                                                                            d="M0 0h24v24H0z" fill="none"/>
                                                                            <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2
                                                                            2v12a2 2 0 0 1 -2 2h-12a2 2 0 0
                                                                            1 -2 -2v-12z" />
                                                                            <path d="M16 3v4" /><path d="M8 3v4" />
                                                                            <path d="M4 11h16" /><path d="M11 15h1" />
                                                                            <path d="M12 15v3" />
                                                                            </svg>
                                                                        </span>
                                                                        <input class="form-control end_date"
                                                                        placeholder="Select a End date" id="end-date"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">
                                                                            {{ __('Search Assignee') }}
                                                                        </label>
                                                                        <input type="text" id="user_select"
                                                                        value="{{ request()->get('selectsearch') }}" >
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">
                                                                            {{ __('Task Status') }}
                                                                        </label>
                                                                        <select type="text"
                                                                        class="form-select task_status"
                                                                        placeholder="Task Status"
                                                                        id="task-status" value="">
                                                                            <option value="">
                                                                                {{ __('Select Status') }}
                                                                            </option>
                                                                            <option value="3">
                                                                                {{ __('Pending') }}
                                                                            </option>
                                                                            <option value="4">
                                                                                {{ __('Completed') }}
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 mt-4">
                                                                    <div class="mb-3">
                                                                        <button type="button"
                                                                        class="btn btn-tabler w-100"
                                                                        onclick="submit_button()">
                                                                        {{ __('Search') }}
                                                                    </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                            
                                                        <div class="col-md-10">
                                                            <div class="table-responsive card p-4" id="all_task_append">
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
                                                    <h4 class="card-title">{{ __('Summary Lists Information') }}</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-2 border-end p-3">
                                                            <form>
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">
                                                                            {{ __('Search By Summary Name or Id') }}
                                                                        </label>
                                                                        <input type="text" id="main_skill_input"
                                                                        value="{{ request()->get('q') }}" >
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 mb-3">
                                                                    <label class="form-label required">
                                                                        {{ __('Summary Planned Start Date') }}
                                                                    </label>
                                                                    <div class="input-icon">
                                                                        <span class="input-icon-addon">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                            class="icon" width="24" height="24"
                                                                            viewBox="0 0 24 24" stroke-width="2"
                                                                            stroke="currentColor" fill="none"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round">
                                                                            <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none"/>
                                                                            <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0
                                                                            1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2
                                                                            -2v-12z" />
                                                                            <path d="M16 3v4" /><path d="M8 3v4" />
                                                                            <path d="M4 11h16" /><path d="M11 15h1" />
                                                                            <path d="M12 15v3" /></svg>
                                                                        </span>
                                                                        <input class="form-control main_start_date"
                                                                        placeholder="Select a Start date"
                                                                        id="main_start-date"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 mb-3">
                                                                    <label class="form-label required">
                                                                        {{ __('Summary Planned End Date') }}
                                                                    </label>
                                                                    <div class="input-icon">
                                                                        <span class="input-icon-addon">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                            class="icon" width="24" height="24"
                                                                            viewBox="0 0 24 24" stroke-width="2"
                                                                            stroke="currentColor" fill="none"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round">
                                                                            <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none"/>
                                                                            <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2
                                                                            2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2
                                                                            -2v-12z" />
                                                                            <path d="M16 3v4" /><path d="M8 3v4" />
                                                                            <path d="M4 11h16" /><path d="M11 15h1" />
                                                                            <path d="M12 15v3" />
                                                                            </svg>
                                                                        </span>
                                                                        <input class="form-control main_end_date"
                                                                        placeholder="Select a End date"
                                                                        id="main_end-date"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">
                                                                            {{ __('Summary Status') }}
                                                                        </label>
                                                                        <select type="text"
                                                                        class="form-select main_task_status"
                                                                        placeholder="Task Status"
                                                                        id="main_task-status" value="">
                                                                            <option value="">
                                                                                {{ __('Select Status') }}
                                                                            </option>
                                                                            <option value="3">
                                                                                {{ __('Pending') }}
                                                                            </option>
                                                                            <option value="4">
                                                                                {{ __('Completed') }}
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 mt-4">
                                                                    <div class="mb-3">
                                                                        <button type="button"
                                                                        class="btn btn-tabler w-100"
                                                                        onclick="main_submit_button()">
                                                                        {{ __('Search') }}
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>

                                                        <div class="col-md-10">
                                                            <div class="table-responsive card p-4"
                                                            id="main_task_append">
                                                                
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
<script src="{{ asset('datatable/jquery.dataTables.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $("#skill_input").tokenInput("{{route('task_autocomplete')}}", {
            propertyToSearch:"text",
            tokenValue:"id",
            tokenDelimiter:",",
            hintText: "{{ __('Search Task...') }}",
            noResultsText: "{{ __('Task not found.') }}",
            searchingText: "{{ __('Searching...') }}",
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
            hintText: "{{ __('Search Users...') }}",
            noResultsText: "{{ __('User not found.') }}",
            searchingText: "{{ __('Searching...') }}",
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

        $("#main_skill_input").tokenInput("{{route('task_autocomplete_main')}}", {
            propertyToSearch:"text",
            tokenValue:"id",
            tokenDelimiter:",",
            hintText: "{{ __('Search Summary...') }}",
            noResultsText: "{{ __('Summary not found.') }}",
            searchingText: "{{ __('Searching...') }}",
            deleteText:"&#215;",
            minChars: 2,
            tokenLimit: 4,
            animateDropdown: false,
            resultsLimit:10,
            deleteText: "&times;",
            preventDuplicates: true,
            theme: "bootstrap"
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        window.Litepicker && (new Litepicker({
            element: document.getElementById('start-date'),
            elementEnd: document.getElementById('end-date'),
            singleMode: false,
            allowRepick: true,
            buttonText: {
                previousMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"
                fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,

                nextMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"
                fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
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
                        return '<div><span class="dropdown-item-indicator">'
                            + data.customProperties + '</span>' + escape(data.text) + '</div>';
                    }
                    return '<div>' + escape(data.text) + '</div>';
                },
                option: function(data,escape){
                    if( data.customProperties ){
                        return '<div><span class="dropdown-item-indicator">'
                            + data.customProperties + '</span>' + escape(data.text) + '</div>';
                    }
                    return '<div>' + escape(data.text) + '</div>';
                },
            },
        }));
    });

    document.addEventListener("DOMContentLoaded", function () {
        window.Litepicker && (new Litepicker({
            element: document.getElementById('main_start-date'),
            elementEnd: document.getElementById('main_end-date'),
            singleMode: false,
            allowRepick: true,
            buttonText: {
                previousMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"
                fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,

                nextMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"
                fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
            },
        }));
    });

    document.addEventListener("DOMContentLoaded", function () {
        var el;
        window.TomSelect && (new TomSelect(el = document.getElementById('main_task-status'), {
                        copyClassesToDropdown: false,            plugins: ['remove_button'],
            dropdownParent: 'body',
            controlInput: '<input>',
            render:{
                item: function(data,escape) {
                    if( data.customProperties ){
                        return '<div><span class="dropdown-item-indicator">'
                            + data.customProperties + '</span>' + escape(data.text) + '</div>';
                    }
                    return '<div>' + escape(data.text) + '</div>';
                },
                option: function(data,escape){
                    if( data.customProperties ){
                        return '<div><span class="dropdown-item-indicator">'
                            + data.customProperties + '</span>' + escape(data.text) + '</div>';
                    }
                    return '<div>' + escape(data.text) + '</div>';
                },
            },
        }));
    });
    
    $(function () {
        alltask();
    });

    function alltask(start_date,end_date,user_id,status_task,task_id_arr){
        // $(".loader_show_hide").show();
        $("#all_task_append").html("");
        $.ajax({
            url : '{{route("get_all_task")}}',
            type : 'GET',
            data : {
                'start_date'  : start_date,
                'end_date'    : end_date,
                'user_id'     : user_id,
                'status_task' : status_task,
                'task_id_arr' : task_id_arr
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
        status_task = $(".task_status").val();
        task_id     = $('input#skill_input').tokenInput('get');
        user_id     = $('input#user_select').tokenInput('get');

        var task_id_arr = [];
        $.each(task_id, function(i, obj){
            task_id_arr.push(obj.id);
        });

        var user_id_arr = [];
        $.each(user_id, function(i, obj){
            user_id_arr.push(obj.id);
        });


        alltask(start_date,end_date,user_id_arr,status_task,task_id_arr);
    }

    function maintask(start_date,end_date,status_task,task_id_arr){
        // $(".loader_show_hide").show();
        $("#main_task_append").html("");

        $(".start_date").val("");
        $("#status_task").val("");
        $('.chosen-select option').prop('selected', false).trigger('chosen:updated');

        $.ajax({
            url : '{{route("main_task_list")}}',
            type : 'GET',
            data : {
                'start_date'  : start_date,
                'end_date'    : end_date,
                'status_task' : status_task,
                'task_id_arr' : task_id_arr
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

    function main_submit_button(){
        start_date  = $(".main_start_date").val();
        end_date    = $(".main_end_date").val();
        status_task = $(".main_task_status").val();
        task_id     = $('input#main_skill_input').tokenInput('get');
      

        var task_id_arr = [];
        $.each(task_id, function(i, obj){
            task_id_arr.push(obj.id);
        });

        maintask(start_date,end_date,status_task,task_id_arr);
    }
</script>
