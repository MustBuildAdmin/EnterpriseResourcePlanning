<table class="table" id="example3">
    <thead>
    <tr>
        <th scope="col">{{__('Tasks')}}</th>
        <th scope="col">{{__('Status')}}</th>
        <th scope="col">{{__('Progress')}}</th>
        <th scope="col">{{__('Start Date')}}</th>
        <th scope="col">{{__('End Date')}}</th>
        <th scope="col">{{__('Assigned To')}}</th>
        
    </tr>
    </thead>
    <tbody class="list">
        @if(count($show_parent_task) > 0)
            @foreach($show_parent_task as $show_parent)
                <tr>
                    <td style="width:40%;" class="{{ (strtotime($show_parent->end_date) < time()) ? 'text-danger' : '' }}">
                        <span class="h6 text-sm font-weight-bold mb-0">{{ $show_parent->text }}</span>
                    </td>
                    <td style="width:10%;">
                        @if (strtotime($show_parent->end_date) < time() && $show_parent->progress <= 100)
                            <span class="badge badge-success" style="background-color:#DC3545;">Pending</span>
                        @elseif(strtotime($show_parent->end_date) < time() && $show_parent->progress >= 100)
                            <span class="badge badge-success" style="background-color:#28A745;">Completed</span>
                        @else
                            <span class="badge badge-info" style="background-color:#007bff;">In-Progress</span>
                        @endif
                    </td>
                    <td style="width:10%;">
                        @if ($show_parent->progress >= 100)
                            <span class="badge badge-success" style="background-color:#28A745;">{{$show_parent->progress}} %</span>
                        @else
                            <span class="badge badge-info" style="background-color:#007bff;">{{$show_parent->progress}} %</span>
                        @endif
                    </td>
                    <td  style="width:10%;"class="{{ (strtotime($show_parent->start_date) < time()) ? 'text-danger' : '' }}">
                        {{ Utility::site_date_format($show_parent->start_date,\Auth::user()->id) }}
                    </td>
                    <td  style="width:10%;"class="{{ (strtotime($show_parent->end_date) < time()) ? 'text-danger' : '' }}">
                        {{ Utility::site_date_format($show_parent->end_date,\Auth::user()->id) }}
                    </td>
                    <td style="width:10%;">
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