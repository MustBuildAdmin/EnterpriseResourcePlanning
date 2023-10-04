@include('new_layouts.header')
{{-- @extends('layouts.admin') --}}
<link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.css') }}">

<link rel="stylesheet" href="{{ asset('tokeninput/tokeninput.css') }}">

<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" />

<div class="page-wrapper">
    @include('construction_project.side-menu')
    <div class="container-fluid" id="taskboard_view">
        <div class="p-4">
            <div class="card">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="mb-0">Micro Planning</h1>
                            <div class="card-actions">
                                <a href="#" class="btn btn-primary w-100" data-bs-toggle="modal"
                                    data-bs-target="#modal-large">
                                    Create a New Schedule
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="accordion" id="accordion-example">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-1">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-1" aria-expanded="true">
                                            Weekly Scheluding #1
                                        </button>
                                    </h2>

                                    <div id="collapse-1" class="accordion-collapse collapse show"
                                        data-bs-parent="#accordion-example">
                                        <div class="accordion-body pt-0">
                                            <div class="card p-3 mb-3 ">
                                                <div class="row w-100">
                                                    <div class="col-4 p-4">
                                                        <span><b>Schedule Duration:</b> 4 days </span>
                                                    </div>
                                                    <div class="col-4 p-4">
                                                        <span><b>Holiday Duration:</b> 4 days </span>
                                                    </div>
                                                    <div class="col-4  p-4">
                                                        <b>Planned Percentage:</b> 20%
                                                    </div>
                                                    <div class="col-6  p-4">
                                                        <span><b>Schedule Start Date:</b>
                                                            {{ Utility::site_date_format($weekStartDate,\Auth::user()->id) }} - <b>
                                                            Schedule End Date:</b>
                                                            {{ Utility::site_date_format($weekEndDate,\Auth::user()->id) }}
                                                        </span>
                                                    </div>
                                                    <div class="col-6 p-3">
                                                        <a href="#" class="btn btn-primary pull-right">
                                                            Start the Schedule
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="group__goals sortable">
                                                        @forelse ($weekSchedule as $schedule)
                                                            <div class="card">
                                                                <div class="row">
                                                                    <div
                                                                        class="col-md-1 py-3  border-end bg-primary text-white">
                                                                        <div class="datagrid-title text-white">Task Id</div>
                                                                        <div class="datagrid-content">{{$schedule->id}}</div>
                                                                    </div>
                                                                    <div class="col-md-5 p-3">
                                                                        <div class="datagrid-title ">Task Name</div>
                                                                        <div class="datagrid-content">{{$schedule->text}}</div>
                                                                    </div>
                                                                    <div class="col-md-2 p-3">
                                                                        <div class="datagrid-title">Start Date</div>
                                                                        <div class="datagrid-content">
                                                                            {{ Utility::site_date_format($schedule->start_date,\Auth::user()->id) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 p-3">
                                                                        <div class="datagrid-title">End date</div>
                                                                        <div class="datagrid-content">
                                                                            {{ Utility::site_date_format($schedule->end_date,\Auth::user()->id) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 p-3">
                                                                        <div class="datagrid-title">Assignees</div>
                                                                        @php
                                                                            if($schedule->users != ""){
                                                                                $users_data = json_decode($schedule->users);
                                                                            }
                                                                            else{
                                                                                $users_data = array();
                                                                            }
                                                                        @endphp
                                                                        <div class="datagrid-content">
                                                                            <div class="avatar-list avatar-list-stacked">
                                                                                @forelse ($users_data as $key => $get_user)
                                                                                    @php
                                                                                        $user_db = DB::table('users')->where('id',$get_user)->first();
                                                                                    @endphp
                                                                                    @if($key<3)
                                                                                        @if($user_db->avatar)
                                                                                            <a href="#" class="avatar rounded-circle avatar-sm">
                                                                                                @if($user_db->avatar)
                                                                                                    <span class="avatar avatar-xs rounded"
                                                                                                    style="background-image:
                                                                                                    url({{asset('/storage/uploads/avatar/'.$user_db->avatar)}})">
                                                                                                    </span>
                                                                                                @else
                                                                                                    <span class="avatar avatar-xs rounded"
                                                                                                    style="background-image:
                                                                                                    url({{asset('/storage/uploads/avatar/avatar.png')}})">
                                                                                                    </span>
                                                                                                @endif
                                                                                            </a>
                                                                                        @else
                                                                                            <?php  $short=substr($user_db->name, 0, 1);?>
                                                                                            <span
                                                                                            class="avatar avatar-xs rounded">{{strtoupper($short)}}</span>
                                                                                        @endif
                                                                                    @endif
                                                                                @empty
                                                                                    {{ __('Not Assigned') }}
                                                                                @endforelse
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <div
                                                                class="col-md-4 py-3  border-end bg-primary text-white">
                                                                <div class="datagrid-title text-white">No Schedule Found</div>
                                                            </div>
                                                        @endforelse
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
                
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="mb-0">Total Task List</h1>
                        </div>
                        <div class="card-body p-5">
                            <div class="card p-4">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label required">Task Planned Start Date</label>
                                            <div class="input-icon">
                                                <span
                                                    class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="2" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                                        <path d="M16 3v4" />
                                                        <path d="M8 3v4" />
                                                        <path d="M4 11h16" />
                                                        <path d="M11 15h1" />
                                                        <path d="M12 15v3" />
                                                    </svg>
                                                </span>
                                                <input class="form-control" placeholder="Select a Start date"
                                                    id="start-date" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label required">Task Planned End Date</label>
                                            <div class="input-icon">
                                                <span
                                                    class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="2" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                                        <path d="M16 3v4" />
                                                        <path d="M8 3v4" />
                                                        <path d="M4 11h16" />
                                                        <path d="M11 15h1" />
                                                        <path d="M12 15v3" />
                                                    </svg>
                                                </span>
                                                <input class="form-control" placeholder="Select a End date"
                                                    id="end-date" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-3 group__goals sortable">
                                <div class="card">
                                    <div class="row">
                                        <div class="col-md-1 py-3  border-end bg-primary text-white">
                                            <div class="datagrid-title text-white">Task Id</div>
                                            <div class="datagrid-content">MB-12000</div>
                                        </div>
                                        <div class="col-md-5 p-3">
                                            <div class="datagrid-title ">Task Name</div>
                                            <div class="datagrid-content">Third Party</div>
                                        </div>
                                        <div class="col-md-2 p-3">
                                            <div class="datagrid-title">Start Date</div>
                                            <div class="datagrid-content">5/aug/2023</div>
                                        </div>
                                        <div class="col-md-2 p-3">
                                            <div class="datagrid-title">End date</div>
                                            <div class="datagrid-content">10/aug/2023</div>
                                        </div>
                                        <div class="col-md-2 p-3">
                                            <div class="datagrid-title">Assignees</div>
                                            <div class="datagrid-content">
                                                <div class="avatar-list avatar-list-stacked">
                                                    <span class="avatar avatar-xs rounded"
                                                        style="background-image: url(./static/avatars/000m.jpg)"></span>
                                                    <span class="avatar avatar-xs rounded">JL</span>
                                                    <span class="avatar avatar-xs rounded"
                                                        style="background-image: url(./static/avatars/002m.jpg)"></span>
                                                    <span class="avatar avatar-xs rounded"
                                                        style="background-image: url(./static/avatars/003m.jpg)"></span>
                                                    <span class="avatar avatar-xs rounded"
                                                        style="background-image: url(./static/avatars/000f.jpg)"></span>
                                                    <span class="avatar avatar-xs rounded">+3</span>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div class="card">
                                    <div class="row">
                                        <div class="col-md-1 py-3  border-end bg-primary text-white">
                                            <div class="datagrid-title text-white">Task Id</div>
                                            <div class="datagrid-content">MB-12000</div>
                                        </div>
                                        <div class="col-md-5 p-3">
                                            <div class="datagrid-title ">Task Name</div>
                                            <div class="datagrid-content">Third Party</div>
                                        </div>
                                        <div class="col-md-2 p-3">
                                            <div class="datagrid-title">Start Date</div>
                                            <div class="datagrid-content">5/aug/2023</div>
                                        </div>
                                        <div class="col-md-2 p-3">
                                            <div class="datagrid-title">End date</div>
                                            <div class="datagrid-content">10/aug/2023</div>
                                        </div>
                                        <div class="col-md-2 p-3">
                                            <div class="datagrid-title">Assignees</div>
                                            <div class="datagrid-content">
                                                <div class="avatar-list avatar-list-stacked">
                                                    <span class="avatar avatar-xs rounded"
                                                        style="background-image: url(./static/avatars/000m.jpg)"></span>
                                                    <span class="avatar avatar-xs rounded">JL</span>
                                                    <span class="avatar avatar-xs rounded"
                                                        style="background-image: url(./static/avatars/002m.jpg)"></span>
                                                    <span class="avatar avatar-xs rounded"
                                                        style="background-image: url(./static/avatars/003m.jpg)"></span>
                                                    <span class="avatar avatar-xs rounded"
                                                        style="background-image: url(./static/avatars/000f.jpg)"></span>
                                                    <span class="avatar avatar-xs rounded">+3</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="row">
                                        <div class="col-md-1 py-3  border-end bg-primary text-white">
                                            <div class="datagrid-title text-white">Task Id</div>
                                            <div class="datagrid-content">MB-12000</div>
                                        </div>
                                        <div class="col-md-5 p-3">
                                            <div class="datagrid-title ">Task Name</div>
                                            <div class="datagrid-content">Third Party</div>
                                        </div>
                                        <div class="col-md-2 p-3">
                                            <div class="datagrid-title">Start Date</div>
                                            <div class="datagrid-content">5/aug/2023</div>
                                        </div>
                                        <div class="col-md-2 p-3">
                                            <div class="datagrid-title">End date</div>
                                            <div class="datagrid-content">10/aug/2023</div>
                                        </div>
                                        <div class="col-md-2 p-3">
                                            <div class="datagrid-title">Assignees</div>
                                            <div class="datagrid-content">
                                                <div class="avatar-list avatar-list-stacked">
                                                    <span class="avatar avatar-xs rounded"
                                                        style="background-image: url(./static/avatars/000m.jpg)"></span>
                                                    <span class="avatar avatar-xs rounded">JL</span>
                                                    <span class="avatar avatar-xs rounded"
                                                        style="background-image: url(./static/avatars/002m.jpg)"></span>
                                                    <span class="avatar avatar-xs rounded"
                                                        style="background-image: url(./static/avatars/003m.jpg)"></span>
                                                    <span class="avatar avatar-xs rounded"
                                                        style="background-image: url(./static/avatars/000f.jpg)"></span>
                                                    <span class="avatar avatar-xs rounded">+3</span>
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
        $("#skill_input").tokenInput("{{ route('report_task_autocomplete') }}", {
            propertyToSearch: "text",
            tokenValue: "id",
            tokenDelimiter: ",",
            hintText: "Search Task...",
            noResultsText: "Task not found.",
            searchingText: "Searching...",
            deleteText: "&#215;",
            minChars: 2,
            tokenLimit: 4,
            animateDropdown: false,
            resultsLimit: 10,
            deleteText: "&times;",
            preventDuplicates: true,
            theme: "bootstrap"
        });

        $("#user_select").tokenInput("{{ route('user_autocomplete') }}", {
            propertyToSearch: "name",
            tokenValue: "id",
            tokenDelimiter: ",",
            hintText: "Search Users...",
            noResultsText: "User not found.",
            searchingText: "Searching...",
            deleteText: "&#215;",
            minChars: 2,
            tokenLimit: 4,
            animateDropdown: false,
            resultsLimit: 10,
            deleteText: "&times;",
            preventDuplicates: true,
            theme: "bootstrap",
            queryParam: "selectsearch",
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
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

    document.addEventListener("DOMContentLoaded", function() {
        var el;
        window.TomSelect && (new TomSelect(el = document.getElementById('task-status'), {
            copyClassesToDropdown: false,
            plugins: ['remove_button'],
            dropdownParent: 'body',
            controlInput: '<input>',
            render: {
                item: function(data, escape) {
                    if (data.customProperties) {
                        return '<div><span class="dropdown-item-indicator">' +
                            data.customProperties + '</span>' + escape(data.text) + '</div>';
                    }
                    return '<div>' + escape(data.text) + '</div>';
                },
                option: function(data, escape) {
                    if (data.customProperties) {
                        return '<div><span class="dropdown-item-indicator">' +
                            data.customProperties + '</span>' + escape(data.text) + '</div>';
                    }
                    return '<div>' + escape(data.text) + '</div>';
                },
            },
        }));
    });

    $(function() {
        alltask();
    });

    function alltask(start_date, end_date, user_id, status_task, task_id_arr) {
        $("#all_task_append").html("");
        $.ajax({
            url: '{{ route('show_task_report') }}',
            type: 'GET',
            data: {
                'start_date': start_date,
                'end_date': end_date,
                'user_id': user_id,
                'status_task': status_task,
                'task_id_arr': task_id_arr
            },
            cache: true,
            success: function(data) {
                if (data['success'] == true) {
                    $("#all_task_append").html(data['all_task']);
                }
            },
            error: function(request, error) {
                alert("Request: " + JSON.stringify(request));
            }
        });
    }

    function submit_button() {
        start_date = $(".start_date").val();
        end_date = $(".end_date").val();
        status_task = $(".task_status").val();
        task_id = $('input#skill_input').tokenInput('get');
        user_id = $('input#user_select').tokenInput('get');

        var task_id_arr = [];
        $.each(task_id, function(i, obj) {
            task_id_arr.push(obj.id);
        });

        var user_id_arr = [];
        $.each(user_id, function(i, obj) {
            user_id_arr.push(obj.id);
        });

        alltask(start_date, end_date, user_id_arr, status_task, task_id_arr);
    }
</script>
