@include('new_layouts.header')
<div class="page-wrapper">
    @include('construction_project.side-menu')
    <div class="container-fluid" id="taskboard_view">
        <div class="p-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="mb-0">{{ __('Lookahead Schedule') }}</h1>
                        <div class="card-actions">
                            <button class="btn btn-primary pull-right" onclick="scheduleStart()">
                                Start the Schedule
                            </button>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="accordion" id="accordion-example">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-1">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-1" aria-expanded="true">
                                        {{$scheduleGet->schedule_name}}
                                    </button>
                                </h2>

                                <div id="collapse-1" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordion-example">
                                    <div class="accordion-body pt-0">
                                        <div class="card p-3 mb-3 ">
                                            <div class="row w-100">
                                                <div class="col-3 p-4">
                                                    <input type="hidden" name="schedule_id" id="schedule_id" value="{{$scheduleGet->id}}">
                                                    <span><b>Schedule Duration:</b> {{$scheduleGet->schedule_duration}} days </span>
                                                </div>
                                                {{-- <div class="col-4 p-4">
                                                    <span><b>Holiday Duration:</b> 4 days </span>
                                                </div>
                                                <div class="col-4  p-4">
                                                    <b>Planned Percentage:</b> 20%
                                                </div> --}}
                                                <div class="col-5 p-4">
                                                    <span><b>Schedule Start Date:</b>
                                                        {{ Utility::site_date_format($scheduleGet->schedule_start_date, \Auth::user()->id) }}
                                                        - <b>
                                                            Schedule End Date:</b>
                                                        {{ Utility::site_date_format($scheduleGet->schedule_end_date, \Auth::user()->id) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="group__goals sortable_microschedule">
                                                    @forelse ($microSchedule as $key_sort => $microschedule)
                                                        @php $key_sort++; @endphp
                                                        <div class="card" data-task_id="{{ $microschedule->main_id }}" data-sortnumber="{{$key_sort}}">
                                                            <div class="row">
                                                                <div
                                                                    class="col-md-1 py-3  border-end bg-primary text-white">
                                                                    <div class="datagrid-title text-white">Micro Id
                                                                    </div>
                                                                    <div class="datagrid-content">
                                                                        {{ $microschedule->id }}</div>
                                                                </div>
                                                                <div class="col-md-5 p-3">
                                                                    <div class="datagrid-title ">Task Name</div>
                                                                    <div class="datagrid-content">
                                                                        {{ $microschedule->text }}</div>
                                                                </div>
                                                                <div class="col-md-2 p-3">
                                                                    <div class="datagrid-title">Start Date</div>
                                                                    <div class="datagrid-content">
                                                                        {{ Utility::site_date_format($microschedule->start_date, \Auth::user()->id) }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2 p-3">
                                                                    <div class="datagrid-title">End date</div>
                                                                    <div class="datagrid-content">
                                                                        {{ Utility::site_date_format($microschedule->end_date, \Auth::user()->id) }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2 p-3">
                                                                    <div class="datagrid-title">Assignees</div>
                                                                    @php
                                                                        if ($microschedule->users != '') {
                                                                            $users_data_micro = json_decode($microschedule->users);
                                                                        } else {
                                                                            $users_data_micro = [];
                                                                        }
                                                                    @endphp
                                                                    <div class="datagrid-content">
                                                                        <div
                                                                            class="avatar-list avatar-list-stacked">
                                                                            @forelse ($users_data_micro as $key => $get_user)
                                                                                @php
                                                                                    $user_db = DB::table('users')
                                                                                        ->where('id', $get_user)
                                                                                        ->first();
                                                                                @endphp
                                                                                @if ($key < 3)
                                                                                    @if ($user_db->avatar)
                                                                                        <a href="#"
                                                                                            class="avatar rounded-circle avatar-sm">
                                                                                            @if ($user_db->avatar)
                                                                                                <span
                                                                                                    class="avatar avatar-xs rounded"
                                                                                                    style="background-image:
                                                                                                url({{ asset('/storage/uploads/avatar/' . $user_db->avatar) }})">
                                                                                                </span>
                                                                                            @else
                                                                                                <span
                                                                                                    class="avatar avatar-xs rounded"
                                                                                                    style="background-image:
                                                                                                url({{ asset('/storage/uploads/avatar/avatar.png') }})">
                                                                                                </span>
                                                                                            @endif
                                                                                        </a>
                                                                                    @else
                                                                                        <?php $short = substr($user_db->name, 0, 1); ?>
                                                                                        <span
                                                                                            class="avatar avatar-xs rounded">{{ strtoupper($short) }}</span>
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
                        <h1 class="mb-0">{{ __('Week Task List') }}</h1>
                    </div>
                    
                    <div class="card-body">
                        <div class="accordion" id="accordion-example">
                            <div id="collapse-2" class="accordion-collapse collapse show"
                                data-bs-parent="#accordion-example">
                                <div class="accordion-body pt-0">
                                    <div class="card p-3 mb-3 ">
                                        <div class="row w-100">
                                            <div class="col-5 p-4">
                                                <span><b>Week Start Date:</b>
                                                    {{ Utility::site_date_format($weekStartDate, \Auth::user()->id) }}
                                                    - <b>
                                                        Week End Date:</b>
                                                    {{ Utility::site_date_format($weekEndDate, \Auth::user()->id) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="pt-3 group__goals sortable_task">
                                                @forelse ($weekSchedule as $key_sort => $schedule)
                                                    @php $key_sort++; @endphp
                                                    <div class="card" data-task_id="{{ $schedule->main_id }}" data-sortnumber="{{$key_sort}}">
                                                        <div class="row">
                                                            <div
                                                                class="col-md-1 py-3  border-end bg-primary text-white">
                                                                <div class="datagrid-title text-white">Task Id
                                                                </div>
                                                                <div class="datagrid-content">
                                                                    {{ $schedule->id }}</div>
                                                            </div>
                                                            <div class="col-md-5 p-3">
                                                                <div class="datagrid-title ">Task Name</div>
                                                                <div class="datagrid-content">
                                                                    {{ $schedule->text }}</div>
                                                            </div>
                                                            <div class="col-md-2 p-3">
                                                                <div class="datagrid-title">Start Date</div>
                                                                <div class="datagrid-content">
                                                                    {{ Utility::site_date_format($schedule->start_date, \Auth::user()->id) }}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 p-3">
                                                                <div class="datagrid-title">End date</div>
                                                                <div class="datagrid-content">
                                                                    {{ Utility::site_date_format($schedule->end_date, \Auth::user()->id) }}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 p-3">
                                                                <div class="datagrid-title">Assignees</div>
                                                                @php
                                                                    if ($schedule->users != '') {
                                                                        $users_data = json_decode($schedule->users);
                                                                    } else {
                                                                        $users_data = [];
                                                                    }
                                                                @endphp
                                                                <div class="datagrid-content">
                                                                    <div
                                                                        class="avatar-list avatar-list-stacked">
                                                                        @forelse ($users_data as $key => $get_user)
                                                                            @php
                                                                                $user_db = DB::table('users')
                                                                                    ->where('id', $get_user)
                                                                                    ->first();
                                                                            @endphp
                                                                            @if ($key < 3)
                                                                                @if ($user_db->avatar)
                                                                                    <a href="#"
                                                                                        class="avatar rounded-circle avatar-sm">
                                                                                        @if ($user_db->avatar)
                                                                                            <span
                                                                                                class="avatar avatar-xs rounded"
                                                                                                style="background-image:
                                                                                            url({{ asset('/storage/uploads/avatar/' . $user_db->avatar) }})">
                                                                                            </span>
                                                                                        @else
                                                                                            <span
                                                                                                class="avatar avatar-xs rounded"
                                                                                                style="background-image:
                                                                                            url({{ asset('/storage/uploads/avatar/avatar.png') }})">
                                                                                            </span>
                                                                                        @endif
                                                                                    </a>
                                                                                @else
                                                                                    <?php $short = substr($user_db->name, 0, 1); ?>
                                                                                    <span
                                                                                        class="avatar avatar-xs rounded">{{ strtoupper($short) }}</span>
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
                                                        <div class="datagrid-title text-white">No Schedule Found
                                                        </div>
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
    </div>
</div>

@include('new_layouts.footer')

<script src="{{ asset('tom-select/tom-select.popular.min.js') }}"></script>
<script src="{{ asset('litepicker/litepicker.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<script>
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
    
    document.querySelectorAll(".sortable_task").forEach(node => {
        new Sortable(node, {
            group: 'scoreboard',
            direction: 'vertical',
            animation: 250,
            scroll: true,
            bubbleScroll: true,
            onMove: function(evt, originalEvent) {
                if (
                    evt.dragged.classList.contains("group") &&
                    evt.to.classList.contains("group__goals")
                ) {
                    return false;
                }
            },
            update: function(event, ui) {
                console.log("lllkk");
            },
            receive : function (event, ui) {
                console.log("rec 1");
            },
        });
    });

    document.querySelectorAll(".sortable_microschedule").forEach(node => {
        new Sortable(node, {
            group: 'scoreboard',
            direction: 'vertical',
            animation: 250,
            scroll: true,
            bubbleScroll: true,
            onMove: function(evt, originalEvent) {
                if (
                    evt.dragged.classList.contains("group") &&
                    evt.to.classList.contains("group__goals")
                ) {
                    return false;
                }

            },
            onAdd: function (/**Event*/evt) {
                
            },
            onSort: function (/**Event*/evt) {
                console.log("ll");
                $(".sortable_microschedule .card").each(function(index) {
                    index++;
                    $(this).attr('data-sortnumber',index);
                });
            }
        });
    });

    function scheduleStart(){
        schedule_id   = $("#schedule_id").val();
        schedulearray = getData();
        console.log("schedulearray",schedulearray);

        $.ajax({
            url : '{{route("mainschedule_store")}}',
            type : 'POST',
            data : {
                'schedulearray' : schedulearray,
                'schedule_id' : schedule_id,
                '_token' : '{{ csrf_token() }}',
            },
            success : function(data_check) {
                if(data_check == 1){
                    toastr.success("Micro Planning Scheduled");
                }
                else if(data_check == 2){
                    toastr.warning("OOPS! Your schedule is start runing, So can't be modify!");
                }
                else if(data_check == 0){
                    toastr.warning("Please Drag and Drop the Task List into the Micro Planning");
                }
                else{
                    toastr.error("Somenthing went wrong!");
                }
            },
            error : function(request,error)
            {
                alert("Request: "+JSON.stringify(request));
            }
        });
    }

    function getData(){
        schedulearray = [];
        innerarray    = [];
       
        $(".sortable_microschedule .card").each(function(index) {
            order_number = $(this).data('sortnumber');
            task_id      = $(this).data('task_id');

            console.log("order_number",order_number);
            console.log("task_id",task_id);

            innerarray = {'sort_number':order_number,'task_id':task_id};
            schedulearray.push(innerarray);
        });

        return schedulearray;
    }
</script>
