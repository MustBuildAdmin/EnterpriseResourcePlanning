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

<table class="table table-vcenter card-table" id="summary-table" aria-describedby="Main Task">
    <thead>
        <tr>
            <th scope="col">{{ __('SummaryId') }}</th>
            <th scope="col">{{ __('Tasks') }}</th>
            <th scope="col">{{ __('Status') }}</th>
            <th scope="col">{{ __('Actual Progress') }}</th>
            <th scope="col">{{ __('Planned Progress') }}</th>
            <th scope="col">{{ __('Planned Start Date') }}</th>
            <th scope="col">{{ __('Planned End Date') }}</th>
        </tr>
    </thead>
    <tbody class="list">
        @forelse ($show_parent_task as $show_parent)
            @php
                $instanceId = Session::get('project_instance');
                $remaining_working_days = Utility::remaining_duration_calculator($show_parent->end_date, $show_parent->project_id);
                $remaining_working_days = $remaining_working_days != 0 ? $remaining_working_days - 1 : 0; // include the last day
                $completed_days = $show_parent->duration - $remaining_working_days;

                if ($show_parent->duration == 1) {
                    $current_Planed_percentage = 100;
                } else {
                    // percentage calculator
                    if ($show_parent->duration > 0) {
                        $perday = 100 / $show_parent->duration;
                    } else {
                        $perday = 0;
                    }
                    $current_Planed_percentage = round($completed_days * $perday);
                }
            @endphp
            <tr>
                <td style="width:5%; font-size: 15px;">
                    <a style="text-decoration: none;">{{ $show_parent->main_id }}</a>
                </td>

                <td style="width:30%; font-size: 15px;">
                    {{ $show_parent->text }}
                </td>

                <td style="width:20%;">
                    @if (strtotime($show_parent->end_date) < time() && $show_parent->progress < 100)
                        <span class="badge bg-warning me-1"></span> Pending
                    @elseif(strtotime($show_parent->end_date) < time() && $show_parent->progress >= 100)
                        <span class="badge bg-success me-1"></span> Completed
                    @else
                        <span class="badge bg-info me-1"></span> In-Progress
                    @endif
                </td>

                <td style="width:15%;" class="sort-progress" data-progress="{{ round($show_parent->progress) }}">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-auto" style="width: 50px;">{{ round($show_parent->progress) }}%</div>
                        <div class="col">
                            <div class="progress" style="width: 5rem">
                                <div class="progress-bar" style="width: {{ round($show_parent->progress) }}%"
                                    role="progressbar" aria-valuenow="{{ round($show_parent->progress) }}"
                                    aria-valuemin="0" aria-valuemax="100"
                                    aria-label="{{ round($show_parent->progress) }}% Complete">
                                    <span class="visually-hidden">{{ round($show_parent->progress) }}% Complete</span>
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

                <td style="width:5%;"
                    class="{{ strtotime($show_parent->start_date) < time() ? 'text-danger' : '' }}">
                    {{ Utility::site_date_format($show_parent->start_date, \Auth::user()->id) }}
                </td>

                <td style="width:5%;" class="{{ strtotime($show_parent->end_date) < time() ? 'text-danger' : '' }}">
                    {{ Utility::site_date_format_minus_day($show_parent->end_date, \Auth::user()->id, 1) }}
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
        new DataTable('#summary-table', {
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
