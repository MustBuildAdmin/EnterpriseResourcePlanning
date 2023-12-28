<div class="card-body">
    <div class="pt-3 group__goals sortable_task">
        @forelse ($weekSchedule as $key_sort => $schedule)
            @php $key_sort++; @endphp
            <div class="card" data-task_id="{{ $schedule->id }}" data-sortnumber="{{$key_sort}}" data-con_main_id="{{ $schedule->main_id }}">
                <div class="row">
                    <div class="col-md-1 py-3  border-end bg-primary text-white">
                        <div class="datagrid-title text-white">{{ __('Task Id') }}</div>
                        <div class="datagrid-content">{{ $schedule->id }}</div>
                    </div>
                    <div class="col-md-5 p-3">
                        <div class="datagrid-title ">{{ __('Task Name') }}</div>
                        <div class="datagrid-content">{{ $schedule->text }}</div>
                    </div>
                    <div class="col-md-2 p-3">
                        <div class="datagrid-title">{{ __('Start Date') }}</div>
                        <div class="datagrid-content">{{ Utility::site_date_format($schedule->start_date,\Auth::user()->id) }}</div>
                    </div>
                    <div class="col-md-2 p-3">
                        <div class="datagrid-title">{{ __('End date') }}</div>
                        <div class="datagrid-content">{{ Utility::site_date_format($schedule->end_date, \Auth::user()->id) }}</div>
                    </div>
                    <div class="col-md-2 p-3">
                        <div class="datagrid-title">{{ __('Assignees') }}</div>
                        @php
                            $users_data = array();
                            if ($schedule->users != '') {
                                $user_set[] = $schedule->users;
                                // $users_data = json_decode($user_set);
                            }
                        @endphp
                        <div class="datagrid-content">
                        <div
                            class="avatar-list avatar-list-stacked">
                            @forelse ($users_data as $key => $get_user)
                                @php $user_db = DB::table('users')->where('id', $get_user)->first(); @endphp
                                @if ($key < 3)
                                    @if ($user_db->avatar)
                                        <a href="#" class="avatar rounded-circle avatar-sm">
                                            @if ($user_db->avatar)
                                                <span class="avatar avatar-xs rounded" style="background-image:
                                                    url({{ asset('/storage/uploads/avatar/' . $user_db->avatar) }})">
                                                </span>
                                            @else
                                                <span class="avatar avatar-xs rounded" style="background-image:
                                                    url({{ asset('/storage/uploads/avatar/avatar.png') }})">
                                                </span>
                                            @endif
                                        </a>
                                    @else
                                        <?php $short = substr($user_db->name, 0, 1); ?>
                                        <span class="avatar avatar-xs rounded">{{ strtoupper($short) }}</span>
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

<div class="d-flex mt-4">
    <ul class="pagination ms-auto">
       {!! $weekSchedule->links() !!}
    </ul>
 </div>