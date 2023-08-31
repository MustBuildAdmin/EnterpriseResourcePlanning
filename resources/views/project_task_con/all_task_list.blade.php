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
</style>

<table class="table table-vcenter card-table" id="task-table">
    <thead>
    <tr>
        <th scope="col">{{__('TaskId')}}</th>
        <th scope="col">{{__('Tasks')}}</th>
        <th scope="col">{{__('Status')}}</th>
        <th scope="col">{{__('Actual Progress')}}</th>
        <th scope="col">{{__('Planned Progress')}}</th>
        <th scope="col">{{__('Planned Start Date')}}</th>
        <th scope="col">{{__('Planned End Date')}}</th>
        <th scope="col">{{__('Assigned To')}}</th>
        @if(\Auth::user()->type == 'company')
            <th scope="col">{{__('Action')}}</th>
        @endif
    </tr>
    </thead>
    <tbody class="list">
        @forelse ($tasks as $task)
            @if($task->instance_id == $task->pro_instance_id)
                @php
                    $total_count_of_task  = DB::table('task_progress')->where('task_id',$task->main_id)->get()->count();

                    $remaining_working_days=Utility::remaining_duration_calculator($task->end_date,$task->project_id);
                    $remaining_working_days=$remaining_working_days-1;// include the last day

                    ############### Remaining days ##################

                    $completed_days=$task->duration-$remaining_working_days;
                    // percentage calculator
                    if($task->duration>0){
                        $perday=100/$task->duration;
                    }else{
                        $perday=0;
                    }

                    $current_Planed_percentage=round($completed_days*$perday);
                    if($current_Planed_percentage > 100){
                        $current_Planed_percentage=100;
                    }
                    if($current_Planed_percentage < 0){
                        $current_Planed_percentage=0;
                    }

                @endphp
                <tr>
                    <td style="width: 15%; font-size: 15px;">
                        <a href="{{route('task_particular',['task_id' => $task->main_id,'get_date' => $get_end_date])}}" style="text-decoration: none;">
                            TaskId-{{ $task->id }}
                        </a>
                    </td>

                    <td style="width: 20%; font-size: 14px;">
                        {{ $task->text }}
                    </td>

                    <td style="width: 18%;">
                        @if (strtotime($task->end_date) < time() && $task->progress < 100)
                            <span class="badge bg-warning me-1"></span> Pending
                        @elseif(strtotime($task->end_date) < time() && $task->progress >= 100)
                            <span class="badge bg-success me-1"></span> Completed
                        @else
                            <span class="badge bg-info me-1"></span> In-Progress
                        @endif
                    </td>

                    <td style="width: 12%;" class="sort-progress" data-progress="{{$task->progress}}">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-auto">{{$task->progress}}%</div>
                            <div class="col">
                                <div class="progress" style="width: 5rem">
                                    <div class="progress-bar" style="width: {{$task->progress}}%" role="progressbar"
                                        aria-valuenow="{{$task->progress}}" aria-valuemin="0" aria-valuemax="100"
                                        aria-label="{{$task->progress}}% Complete">
                                        <span class="visually-hidden">{{$task->progress}}% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td style="width: 12%;" class="sort-progress" data-progress="{{round($current_Planed_percentage)}}">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-auto">{{round($current_Planed_percentage)}}%</div>
                            <div class="col">
                                <div class="progress" style="width: 5rem">
                                    <div class="progress-bar" style="width: {{round($current_Planed_percentage)}}%" role="progressbar"
                                        aria-valuenow="{{round($current_Planed_percentage)}}" aria-valuemin="0" aria-valuemax="100"
                                        aria-label="{{round($current_Planed_percentage)}}% Complete">
                                        <span class="visually-hidden">{{round($current_Planed_percentage)}}% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td style="width: 5%; font-size: 14px;" class="{{ (strtotime($task->start_date) < time()) ? 'text-danger' : '' }}">
                        {{ Utility::site_date_format($task->start_date,\Auth::user()->id) }}
                    </td>

                    <td style="width: 5%;" class="{{ (strtotime($task->end_date) < time()) ? 'text-danger' : '' }}">
                        {{ Utility::site_date_format_minus_day($task->end_date,\Auth::user()->id,1) }}
                    </td>

                    <td style="width: 8%;">
                        <div class="avatar-group">
                            @php
                                if($task->users != ""){
                                    $users_data = json_decode($task->users);
                                }
                                else{
                                    $users_data = array();
                                }
                            @endphp
                            @forelse ($users_data as $key => $get_user)
                                @php
                                    $user_db = DB::table('users')->where('id',$get_user)->first();
                                @endphp

                                @if($key<3)
                                    @if($user_db->avatar)
                                        <a href="#" class="avatar rounded-circle avatar-sm">
                                            <img data-original-title="{{ $user_db != null ? $user_db->name : "" }}"
                                            @if($user_db->avatar)
                                                src="{{asset('/storage/uploads/avatar/'.$user_db->avatar)}}"
                                            @else
                                                src="{{asset('/storage/uploads/avatar/avatar.png')}}"
                                            @endif
                                        title="{{ $user_db != null ? $user_db->name : "" }}" class="hweb">
                                        </a>
                                    @else
                                        <?php  $short=substr($user_db->name, 0, 1);?>
                                        <span class="user-initial">{{strtoupper($short)}}</span>
                                    @endif

                                @endif
                            @empty
                                {{ __('Not Assigned') }}
                            @endforelse
                        </div>
                    </td>

                    @if(\Auth::user()->type == 'company')
                        <td class="text-center w-15" style="width: 5%;">
                            <div class="actions" style="height: 36px;">
                                <a style="margin-top: 20%;" href="#" data-size="xl" data-url="{{ route('edit_assigned_to',["task_id"=>$task->main_id]) }}"
                                    data-ajax-popup="true" data-title="{{__('Edit Assigned To')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" 
                                    class="floatrght">
                                    <i class="ti ti-pencil"></i>
                                </a>
                            </div>
                        </td>
                    @endif
                </tr>
            @endif
        @empty
        @endforelse
    </tbody>
</table>

<script>
    $(function () {
        datatable2();
    });

    function datatable2(){
        new DataTable('#summary-table, #task-table', {
            pagingType: 'full_numbers',
            aaSorting: []
        });
    }
</script>
