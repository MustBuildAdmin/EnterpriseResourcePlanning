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
<table class="table" id="example3">
    <thead>
    <tr>
        <th scope="col">{{__('Tasks')}}</th>
        <th scope="col">{{__('Status')}}</th>
        <th scope="col">{{__('Actual Progress')}}</th>
        <th scope="col">{{__('Planned Start Date')}}</th>
        <th scope="col">{{__('Planned End Date')}}</th>
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
                        @if (strtotime($show_parent->end_date) < time() && $show_parent->progress < 100)
                            <span class="badge badge-success" style="background-color:#DC3545;">Pending</span>
                        @elseif(strtotime($show_parent->end_date) < time() && $show_parent->progress >= 100)
                            <span class="badge badge-success" style="background-color:#28A745;">Completed</span>
                        @else
                            <span class="badge badge-info" style="background-color:#007bff;">In-Progress</span>
                        @endif
                    </td>
                    <td style="width:10%;">
                        @if ($show_parent->progress >= 100)
                            <span class="badge badge-success" style="background-color:#28A745;">{{$show_parent->progress}}%</span>
                        @else
                            <span class="badge badge-info" style="background-color:#007bff;">{{$show_parent->progress}}%</span>
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
                            @php
                                if($show_parent->users != ""){
                                    $users_data = json_decode($show_parent->users);
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
            // bSort: false,
        });
    });
</script>
