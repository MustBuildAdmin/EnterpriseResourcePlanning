<table class="table" id="example2">
    <thead>
    <tr>
        <th scope="col">{{__('Projects')}}</th>
        <th scope="col">{{__('Tasks')}}</th>
        <th scope="col">{{__('Progress')}}</th>
        <th scope="col">{{__('Start Date')}}</th>
        <th scope="col">{{__('End Date')}}</th>
        <th scope="col">{{__('Assigned To')}}</th>
        <th scope="col">{{__('Action')}}</th>
    </tr>
    </thead>
    <tbody class="list">
        @forelse ($tasks as $task)
            @if($task->instance_id == $task->pro_instance_id)
                <tr>
                    <td>
                        <span class="d-flex text-sm text-center justify-content-between">
                            <p class="m-0">{{ $task->project_name }}</p>
                            <span class="me-5 badge p-2 px-3 rounded bg-{{ (\Auth::user()->checkProject($task->project_id) == 'Owner') ? 'success' : 'warning'  }}">
                                {{ __(\Auth::user()->checkProject($task->project_id)) }}
                            </span>
                        </span>
                    </td>
                    <td>
                        <span class="h6 text-sm font-weight-bold mb-0">{{ $task->text }}</span>
                    </td>
                    <td>
                        <span class="h6 text-sm font-weight-bold mb-0">{{ $task->progress }}</span>
                    </td>
                    <td class="{{ (strtotime($task->start_date) < time()) ? 'text-danger' : '' }}">
                        {{ Utility::site_date_format($task->start_date,\Auth::user()->id) }}
                    </td>
                    <td class="{{ (strtotime($task->end_date) < time()) ? 'text-danger' : '' }}">
                        {{ Utility::site_date_format($task->end_date,\Auth::user()->id) }}
                    </td>
                    <td>
                        <div class="avatar-group">
                            @if($task->users()->count() > 0)
                                @if($users = $task->users()) 
                                    @foreach($users as $key => $user)
                                        @if($key<3)
                                            <a href="#" class="avatar rounded-circle avatar-sm">
                                                <img data-original-title="{{(!empty($user)?$user->name:'')}}" @if($user->avatar) src="{{asset('/storage/uploads/avatar/'.$user->avatar)}}" @else src="{{asset('/storage/uploads/avatar/avatar.png')}}" @endif title="{{ $user->name }}" class="hweb">
                                            </a>
                                        @else
                                            @break
                                        @endif
                                    @endforeach
                                @endif
                                @if(count($users) > 3)
                                    <a href="#" class="avatar rounded-circle avatar-sm">
                                        <img  data-original-title="{{(!empty($user)?$user->name:'')}}" @if($user->avatar) src="{{asset('/storage/uploads/avatar/'.$user->avatar)}}" @else src="{{asset('/storage/uploads/avatar/avatar.png')}}" @endif class="hweb">
                                    </a>
                                @endif
                            @else
                                {{ __('-') }}
                            @endif
                        </div>
                    </td>
                    <td class="text-center w-15">
                        <div class="actions">
                            <a href="{{route('task_particular',['task_id' => $task->main_id,'get_date' => $get_end_date])}}" title="{{__('Edit')}}" class="btn btn-sm btn-primary">
                                <i class="ti ti-pencil"></i>
                            </a>
                        </div>
                    </td>
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
        });
    }
</script>