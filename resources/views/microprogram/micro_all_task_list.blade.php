<style>
    .user-initial {
        width: 35px !important;
        height: 35px;
        border-radius: 50%;
        background-color: #e0e0e0;
        color: #333;
        font-size: 24px;
        text-align: center;
        line-height: 35px;
        display: grid;
    }


    .dataTables_length {
        margin-bottom: 5%;
    }
</style>

<table class="table table-vcenter card-table" id="task-table" aria-describedby="Sub Task">
    <thead>
        <tr>
            <th scope="col">{{ __('TaskId') }}</th>
            <th scope="col">{{ __('Tasks') }}</th>
            <th scope="col">{{ __('Status') }}</th>
            <th scope="col">{{ __('Actual Progress') }}</th>
            <th scope="col">{{ __('Planned Progress') }}</th>
            <th scope="col">{{ __('Planned Start Date') }}</th>
            <th scope="col">{{ __('Planned End Date') }}</th>
            <th scope="col">{{ __('Assigned To') }}</th>
        </tr>
    </thead>
    <tbody class="list">
        @forelse ($tasks as $task)
            @php

                if (Session::has('project_instance')) {
                    $instanceId = Session::get('project_instance');
                } else {
                    $instanceId = null;
                }

                $total_count_of_task = DB::table('task_progress')
                    ->where('instance_id', $instanceId)
                    ->where('task_id', $task->main_id)
                    ->get()
                    ->count();

                $remaining_working_days = Utility::remaining_duration_calculator($task->end_date, $task->project_id);
                $remaining_working_days = $remaining_working_days != 0 ? $remaining_working_days - 1 : 0; // include the last day

                ############### Remaining days ##################

                $completed_days = $task->duration - $remaining_working_days;

                if ($task->duration == 1) {
                    $current_Planed_percentage = 100;
                } else {
                    // percentage calculator
                    if ($task->duration > 0) {
                        $perday = 100 / $task->duration;
                    } else {
                        $perday = 0;
                    }

                    $current_Planed_percentage = round($completed_days * $perday);
                }

                $checkLatestFreeze = DB::table('instance')
                    ->where('instance', Session::get('latest_project_instance'))
                    ->first();

                $checkInstanceCount = DB::table('instance')
                    ->where('project_id', Session::get('project_id'))
                    ->count();
                if ($checkLatestFreeze != null) {
                    $checkLatestFreezeStatus = $checkLatestFreeze->freeze_status == 0 ? 0 : 1;
                } else {
                    $checkLatestFreezeStatus = 0;
                }

            @endphp
            <tr>
                <td style="width:5%; font-size: 15px;">

                    @if (Session::get('current_revision_freeze') == 1 &&
                            Session::get('project_instance') != Session::get('latest_project_instance') &&
                            $checkLatestFreezeStatus == 1)
                        <a style="text-decoration: none;">
                            <span class="h6 text-sm font-weight-bold mb-0">{{ $task->id }}</span>
                        </a>
                    @else
                        <a href="{{ route('micro_task_particular', ['task_id' => $task->main_id, 'get_date' => $get_end_date]) }}"
                            style="text-decoration: none;">
                            <span class="h6 text-sm font-weight-bold mb-0">{{ $task->id }}</span>
                        </a>
                    @endif

                </td>

                <td style="width:30%; font-size: 15px;">
                    {{ $task->text }}
                </td>

                <td style="width:20%;">
                    @if (strtotime($task->end_date) < time() && $task->progress < 100)
                        <span class="badge bg-warning me-1"></span> Pending
                    @elseif(strtotime($task->end_date) < time() && $task->progress >= 100)
                        <span class="badge bg-success me-1"></span> Completed
                    @else
                        <span class="badge bg-info me-1"></span> In-Progress
                    @endif
                </td>

                <td style="width:15%;" class="sort-progress" data-progress="{{ round($task->progress) }}">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-auto" style="width: 50px;">{{ round($task->progress) }}%</div>
                        <div class="col">
                            <div class="progress" style="width: 5rem">
                                <div class="progress-bar" style="width: {{ round($task->progress) }}%"
                                    role="progressbar" aria-valuenow="{{ round($task->progress) }}" aria-valuemin="0"
                                    aria-valuemax="100" aria-label="{{ round($task->progress) }}% Complete">
                                    <span class="visually-hidden">{{ round($task->progress) }}% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>

                <td style="width:15%;" class="sort-progress" data-progress="{{ round($current_Planed_percentage) }}">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-auto" style="width: 50px;">
                            {{ round($current_Planed_percentage) }}%
                        </div>
                        <div class="col">
                            <div class="progress" style="width: 5rem">
                                <div class="progress-bar" style="width: {{ round($current_Planed_percentage) }}%"
                                    role="progressbar" aria-valuenow="{{ round($current_Planed_percentage) }}"
                                    aria-valuemin="0" aria-valuemax="100"
                                    aria-label="{{ round($current_Planed_percentage) }}% Complete">
                                    <span class="visually-hidden">
                                        {{ round($current_Planed_percentage) }}% Complete
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>

                <td style="width:5%;" class="{{ strtotime($task->start_date) < time() ? 'text-danger' : '' }}">
                    {{ Utility::site_date_format($task->start_date, \Auth::user()->id) }}
                </td>

                <td style="width:5%;" class="{{ strtotime($task->end_date) < time() ? 'text-danger' : '' }}">
                    {{ Utility::site_date_format_minus_day($task->end_date, \Auth::user()->id, 1) }}
                </td>

                <td style="width:10%;">
                    <div class="avatar-group">
                        @php
                            if ($task->users != '') {
                                $users_data = json_decode($task->users);
                            } else {
                                $users_data = [];
                            }
                        @endphp
                        @forelse ($users_data as $key => $get_user)
                            @php
                                $user_db = DB::table('users')
                                    ->where('id', $get_user)
                                    ->first();
                            @endphp

                            @if ($key < 3)
                                @if ($user_db->avatar)
                                    <a href="#" class="avatar rounded-circle avatar-sm">
                                        <img data-original-title="{{ $user_db != null ? $user_db->name : '' }}"
                                            @if ($user_db->avatar) src="{{ asset('/storage/uploads/avatar/' . $user_db->avatar) }}"
                                        @else
                                            src="{{ asset('/storage/uploads/avatar/avatar.png') }}" @endif
                                            title="{{ $user_db != null ? $user_db->name : '' }}" class="hweb">
                                    </a>
                                @else
                                    <?php $short = substr($user_db->name, 0, 1); ?>
                                    <span class="user-initial">{{ strtoupper($short) }}</span>
                                @endif
                            @endif
                        @empty
                            {{ __('Not Assigned') }}
                        @endforelse
                    </div>
                </td>
            </tr>
        @empty
        @endforelse
    </tbody>
</table>

<script>
    $(function() {
        datatable2();
    });

    function datatable2() {
        new DataTable('#task-table', {
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
            }
        });
    }
</script>
