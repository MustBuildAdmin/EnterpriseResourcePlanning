<table class="table" id="example2">
    <thead>
    <tr>
        <th scope="col">{{__('Tasks')}}</th>
        <th scope="col">{{__('Status')}}</th>
        <th scope="col">{{__('Actual Progress')}}</th>
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
                <tr>
                    <td style="width:40%;" class="{{ (strtotime($task->end_date) < time()) ? 'text-danger' : '' }}">
                        <a href="{{route('task_particular',['task_id' => $task->main_id,'get_date' => $get_end_date])}}" style="text-decoration: none;">
                            <span class="h6 text-sm font-weight-bold mb-0">{{ $task->text }}</span>
                        </a>
                    </td>
                    <td style="width:10%;">
                        @if (strtotime($task->end_date) < time() && $task->progress <= 100)
                            <span class="badge badge-success" style="background-color:#DC3545;">Pending</span>
                        @elseif(strtotime($task->end_date) < time() && $task->progress >= 100)
                            <span class="badge badge-success" style="background-color:#28A745;">Completed</span>
                        @else
                            <span class="badge badge-info" style="background-color:#007bff;">In-Progress</span>
                        @endif
                    </td>
                    <td style="width:10%;">
                        @if ($task->progress >= 100)
                            <span class="badge badge-success" style="background-color:#28A745;">{{$task->progress}}%</span>
                        @else
                            <span class="badge badge-info" style="background-color:#007bff;">{{$task->progress}}%</span>
                        @endif
                    </td>
                    <td style="width:10%;" class="{{ (strtotime($task->start_date) < time()) ? 'text-danger' : '' }}">
                        {{ Utility::site_date_format($task->start_date,\Auth::user()->id) }}
                    </td>
                    <td style="width:10%;" class="{{ (strtotime($task->end_date) < time()) ? 'text-danger' : '' }}">
                        {{ Utility::site_date_format($task->end_date,\Auth::user()->id) }}
                    </td>
                    <td style="width:10%;">
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
                                    <a href="#" class="avatar rounded-circle avatar-sm">
                                        <img data-original-title="{{ $user_db != null ? $user_db->name : "" }}" 
                                            @if($user_db->avatar) 
                                                src="{{asset('/storage/uploads/avatar/'.$user_db->avatar)}}" 
                                            @else 
                                                src="{{asset('/storage/uploads/avatar/avatar.png')}}"
                                            @endif 
                                        title="{{ $user_db != null ? $user_db->name : "" }}" class="hweb">
                                    </a>
                                @endif
                            @empty
                                {{ __('-') }}
                            @endforelse
                        </div>
                    </td>
                    @if(\Auth::user()->type == 'company')
                        <td style="width:10%;" class="text-center w-15">
                            <div class="actions">
                                <a style="height: 36px;" href="#" data-size="xl" data-url="{{ route('edit_assigned_to',["task_id"=>$task->main_id]) }}" 
                                    data-ajax-popup="true" data-title="{{__('Edit Assigned To')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" class="floatrght btn btn-primary mb-3">
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
        $('#example2').dataTable().fnDestroy();
        $('#example2').DataTable({
            dom: 'Bfrtip',
            searching: true,
            info: true,
            paging: true,
            bSort: false,
        });
    }
</script>