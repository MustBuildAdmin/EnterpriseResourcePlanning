<table class="table" id="example3">
    <thead>
    <tr>
        <th scope="col">{{__('Projects')}}</th>
        <th scope="col">{{__('Tasks')}}</th>
        <th scope="col">{{__('Start Date')}}</th>
        <th scope="col">{{__('End Date')}}</th>
        <th scope="col">{{__('Assigned To')}}</th>
        <th scope="col">{{__('Progress')}}</th>
    </tr>
    </thead>
    <tbody class="list">
        @if(count($show_parent_task) > 0)
            @foreach($show_parent_task as $show_parent)
                <tr>
                    <td>
                        <span class="d-flex text-sm text-center justify-content-between">
                            <p class="m-0">{{ $show_parent->project_name }}</p>
                            <span class="me-5 badge p-2 px-3 rounded bg-{{ (\Auth::user()->checkProject($show_parent->project_id) == 'Owner') ? 'success' : 'warning'  }}">
                                {{ __(\Auth::user()->checkProject($show_parent->project_id)) }}
                            </span>
                        </span>
                    </td>
                    <td>
                        <span class="h6 text-sm font-weight-bold mb-0">{{ $show_parent->text }}</span>
                    </td>
                    <td class="{{ (strtotime($show_parent->start_date) < time()) ? 'text-danger' : '' }}">
                        {{ Utility::site_date_format($show_parent->start_date,\Auth::user()->id) }}
                    </td>
                    <td class="{{ (strtotime($show_parent->end_date) < time()) ? 'text-danger' : '' }}">
                        {{ Utility::site_date_format($show_parent->end_date,\Auth::user()->id) }}
                    </td>
                    <td>
                        <div class="avatar-group">
                            @if($show_parent->users()->count() > 0)
                                @if($users = $show_parent->users()) 
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
                    <td>
                        {{ $show_parent->progress }}
                    </td>
                </tr>
            @endforeach
        @else
        @endif
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example3').dataTable().fnDestroy();
        $('#example3').DataTable({
            dom: 'Bfrtip',
            searching: true,
            info: true,
            paging: true,
        });
    });
</script>