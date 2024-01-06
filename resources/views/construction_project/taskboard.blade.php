@include('new_layouts.header')
@push('css-page')
<link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
<link rel='stylesheet' href='https://unicons.iconscout.com/release/v3.0.6/css/line.css'>
<link rel="stylesheet" href="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.css') }}">
<link rel="stylesheet" href="{{ asset('tokeninput/tokeninput.css') }}">
<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet"/>
<style>
    .ellipsis_task {
        width: auto;
        text-align: left;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        word-break: break-all;
    }
</style>
@include('construction_project.side-menu')
    <section>
        <div class="page-wrapper">
            <div class="container-fluid" id="taskboard_view">
                <div class="p-2">
                    <div class="card">
                        <div class="col-12">
                            <div class="card-header">
                                <ul class="nav nav-tabs card-header-tabs nav-fill p-0"
                                data-bs-toggle="tabs" role="tablist">
                                    <li class="nav-item" role="presentation">
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
                                    <li class="nav-item" role="presentation">
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


                            <div class="">
                                <div class="tab-content">
                                    <div class="tab-pane active show" id="tabs-home-7" role="tabpanel">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">{{ __('Task Lists Information') }}</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-2 border-end ">
                                                            <form>
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">
                                                                            {{ __('Search By Task Name or TaskID') }}
                                                                        </label>
                                                                        <input type="text"  id="skill_input"
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
                                                                        id="start-date" required />
                                                                        <span id='task_error_start'  style='color:red;'></span>
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
                                                                        placeholder="Select a End date" id="end-date" required/>
                                                                        <span id='task_error_end'  style='color:red;'></span>
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
                                                                    <div class="mb-3">
                                                                        <button type="reset"
                                                                            class="btn btn-default w-100"
                                                                            onclick="reset_button()">
                                                                            {{ __('Reset') }}
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>

                                                        <div class="col-md-10">
                                                            <div class="table-responsive card p-1" id="all_task_append">
                                                                <table class="table table-vcenter card-table" id="task-table" aria-describedby="Sub Task">
                                                                    <thead>
                                                                        <tr>
                                                                    <th scope="col" style="color: white;">{{__('TaskId')}}</th>
                                                                    <th scope="col" style="color: white;">{{__('Tasks')}}</th>
                                                                    <th scope="col" style="color: white;">{{__('Status')}}</th>
                                                                    <th scope="col" style="color: white;">{{__('Is critical Task')}}</th>
                                                                    <th scope="col" style="color: white;">{{__('Dependency Critical Date')}}</th>
                                                                    <th scope="col" style="color: white;">{{__('Entire Critical Date')}}</th>
                                                                    {{-- <th scope="col" style="color: white;">{{__('Float')}}</th> --}}
                                                                    <th scope="col" style="color: white;">{{__('Actual Progress')}}</th>
                                                                    <th scope="col" style="color: white;">{{__('Planned Progress')}}</th>
                                                                    <th scope="col" style="color: white;">{{__('Planned Start Date')}}</th>
                                                                    <th scope="col" style="color: white;">{{__('Planned End Date')}}</th>
                                                                    <th scope="col" style="color: white;">{{__('Assigned To')}}</th>
                                                                </tr>
                                                                    </thead>
                                                                </table>
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
                                                                            {{ __('Search By Summary Name or TaskId') }}
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
                                                                    <div class="mb-3">
                                                                        <button type="reset"
                                                                            class="btn btn-default w-100"
                                                                            onclick="main_reset_button()">
                                                                            {{ __('Reset') }}
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>

                                                        <div class="col-md-10">
                                                            <div class="table-responsive card p-4">
                                                                <table class="table table-vcenter card-table"
                                                                id="summary-table" aria-describedby="Main Task"
                                                                style="width: 100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col"
                                                                            style='color:white;'>
                                                                            {{__('SummaryId')}}</th>
                                                                            <th scope="col"
                                                                            style='color:white;'>{{__('Tasks')}}</th>
                                                                            <th scope="col"
                                                                            style='color:white;'>{{__('Status')}}</th>
                                                                            <th scope="col"
                                                                            style='color:white;'>
                                                                            {{__('Actual Progress')}}</th>
                                                                            <th scope="col" style='color:white;'>
                                                                                {{__('Planned Progress')}}</th>
                                                                            <th scope="col" style='color:white;'>
                                                                                {{__('Planned Start Date')}}</th>
                                                                            <th scope="col" style='color:white;'>
                                                                                {{__('Planned End Date')}}</th>
                                                                        </tr>
                                                                    </thead>
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
    </section>

@include('new_layouts.footer')

<script src="{{ asset('tom-select/tom-select.popular.min.js') }}"></script>
<script src="{{ asset('litepicker/litepicker.js') }}"></script>
<script src="{{ asset('tokeninput/jquery.tokeninput.js') }}"></script>
<script src="{{ asset('datatable/jquery.dataTables.min.js') }}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {

        task_datatable(null,null,null,null,null);
        main_datatable(null,null,null,null);

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

    function task_datatable(start_date,end_date,user_id_arr,status_task,task_id_arr){
        $('#task-table').dataTable().fnDestroy();
        $('#task-table').DataTable({
            processing: true,
            serverSide: true,
            pagingType: 'full_numbers',
            aaSorting: [],
            "language": {
                "sLengthMenu": "{{ __('Show _MENU_ Records') }}",
                "sZeroRecords": "{{ __('No data available in table') }}",
                "sEmptyTable": "{{ __('No data available in table') }}",
                "sInfo": "{{ __('Showing records _START_ to _END_ of a total of _TOTAL_ records') }}",
                "sInfoFiltered": "{{ __('filtering of a total of _MAX_ records') }}",
                "sSearch": "{{ __('Search') }}:",
                "oPaginate": {
                    "sFirst": "{{ __('First') }}",
                    "sLast": "{{ __('Last') }}",
                    "sNext": "{{ __('Next') }}",
                    "sPrevious": "{{ __('Previous') }}"
                },
            },
            ajax: {
                url: "{{ route('get_all_task_datatable') }}",
                type: "POST",
                data: function (data) {
                    data.start_date = start_date;
                    data.end_date = end_date;
                    data.user_id = user_id_arr;
                    data.status_task = status_task;
                    data.task_id_arr = task_id_arr;
                }
            },
            order: [],
            columnDefs: [
                {
                    "targets": 0,
                    "className": "text-center",
                    "orderable": true
                },
                {
                    "targets": 1,
                    "className": "text-right",
                    "width": "20%",
                    "orderable": true
                },
                {
                    "targets": 2,
                    "className": "text-center",
                    "width": "20%",
                    "orderable": true
                },
                {
                    "targets": 3,
                    "className": "text-center",
                    "orderable": true
                },
                {
                    "targets": 4,
                    "className": "text-center",
                    "orderable": true
                },
                {
                    "targets": 5,
                    "className": "text-center",
                    "orderable": true
                },
                {
                    "targets": 6,
                    "className": "text-center",
                    "orderable": true
                },
                {
                    "targets": 7,
                    "className": "text-center",
                    "orderable": true
                },
                {
                    "targets": 8,
                    "className": "text-center",
                    "orderable": true
                },
                {
                    "targets": 9,
                    "className": "text-center",
                    "orderable": true
                },
                {
                    "targets": 10,
                    "className": "text-center",
                    "orderable": false
                }
            ],
            pageLength: 10,
            searching: true,
            aoColumns: [
                {data: 'id'},
                {data: 'text'},
                {data: 'status'},
                {data: 'dependency_critical'},
                {data: 'dependency_critical_date'},
                {data: 'entire_critical_date'},
                // {data: 'float_val'},
                {data: 'actual_progress'},
                {data: 'planned_progress'},
                {data: 'planned_start'},
                {data: 'planned_end'},
                {data: 'assigne'}
            ]
        });
    }

    function reset_button(){
        $(".start_date").val("");
        $(".end_date").val("");
        $('input#skill_input').tokenInput('clear');
        $('input#user_select').tokenInput('clear');
        document.querySelector('select.task_status').tomselect.setValue("");

        task_datatable(null,null,null,null,null);
    }

    function main_reset_button(){
        $(".main_start_date").val("");
        $(".main_end_date").val("");
        $('input#main_skill_input').tokenInput('clear');
        document.querySelector('select.main_task_status').tomselect.setValue("");

        main_datatable(null,null,null,null);
    }


    function submit_button(){
        start_date  = $(".start_date").val();
        end_date    = $(".end_date").val();
        status_task = $(".task_status").val();
        task_id     = $('input#skill_input').tokenInput('get');
        user_id     = $('input#user_select').tokenInput('get');

        if(start_date==''){
            $('#task_error_start').text('Please Select Start date');
            return false
        }else{
            $('#task_error_start').text('');
        }
        if(end_date==''){
            $('#task_error_end').text('Please Select End date');
            return false;
        }else{
            $('#task_error_end').text('');
        }

        var task_id_arr = [];
        $.each(task_id, function(i, obj){
            task_id_arr.push(obj.id);
        });

        var user_id_arr = [];
        $.each(user_id, function(i, obj){
            user_id_arr.push(obj.id);
        });

        task_datatable(start_date,end_date,user_id_arr,status_task,task_id_arr);
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

        main_datatable(start_date,end_date,status_task,task_id_arr);
    }

    function main_datatable(start_date,end_date,status_task,task_id_arr){
        $('#summary-table').dataTable().fnDestroy();
        $('#summary-table').DataTable({
            processing: true,
            serverSide: true,
            pagingType: 'full_numbers',
            aaSorting: [],
            "language": {
                "sLengthMenu": "{{ __('Show _MENU_ Records') }}",
                "sZeroRecords": "{{ __('No data available in table') }}",
                "sEmptyTable": "{{ __('No data available in table') }}",
                "sInfo": "{{ __('Showing records _START_ to _END_ of a total of _TOTAL_ records') }}",
                "sInfoFiltered": "{{ __('filtering of a total of _MAX_ records') }}",
                "sSearch": "{{ __('Search') }}:",
                "oPaginate": {
                    "sFirst": "{{ __('First') }}",
                    "sLast": "{{ __('Last') }}",
                    "sNext": "{{ __('Next') }}",
                    "sPrevious": "{{ __('Previous') }}"
                },
            },
            ajax: {
                url: "{{ route('get_all_main_task_datatable') }}",
                type: "POST",
                data: function (data) {
                    data.start_date = start_date;
                    data.end_date = end_date;
                    data.status_task = status_task;
                    data.task_id_arr = task_id_arr;
                }
            },
            order: [],
            columnDefs: [ { orderable: true, targets: [0,1,2,3,4,5,6]}],
            pageLength: 10,
            searching: true,
            aoColumns: [
                {data: 'id'},
                {data: 'text'},
                {data: 'status'},
                {data: 'actual_progress'},
                {data: 'planned_progress'},
                {data: 'planned_start'},
                {data: 'planned_end'}
            ]
        });
    }
</script>
