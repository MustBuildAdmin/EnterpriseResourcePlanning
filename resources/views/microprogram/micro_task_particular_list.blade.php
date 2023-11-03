@include('new_layouts.header')
<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet"/>
<style>
    tr.highlighted {
        padding-top: 10px;
        padding-bottom: 10px
    }
</style>
<div class="page-wrapper">
    @include('construction_project.side-menu')

    @php
        $actual_task_progress = $data['con_data']->progress ? $data['con_data']->progress : '0';
        if ($actual_task_progress < $current_Planed_percentage) {
            $style = 'color:red;';
        } else {
            $style = '';
        }

        if (strtotime($data['con_data']->end_date) < time() && $data['con_data']->progress < 100){
            $spanClass = 'status-red';
            $statusData = 'Pending';
        }
        elseif(strtotime($data['con_data']->end_date) < time() && $data['con_data']->progress >= 100){
            $spanClass = 'status-green';
            $statusData = 'Completed';
        }
        else{
            $spanClass = 'status-blue';
            $statusData = 'In-Progress';
        }
    @endphp

    <div class="container-fluid m-3">
        <div class="row row-cards">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        {{$data['con_data']->task_id}}-{{ $data['con_data'] != null ?
                        $data['con_data']->text : 'Task' }} Progress Details
                    </h3>
                </div>
                <div class="card-body">
                    <div class="datagrid">
                        <div class="datagrid-item">
                            <div class="datagrid-title">Task Name</div>
                            <div class="datagrid-content">
                                {{ $data['con_data'] != null ?$data['con_data']->text : 'Task' }}
                            </div>
                        </div>

                        <div class="datagrid-item">
                            @php
                                $users_data = $data['con_data']->users != "" ?
                                json_decode($data['con_data']->users) : array();
                            @endphp
                            <div class="datagrid-title">Avatars list</div>
                            <div class="datagrid-content">
                                <div class="avatar-list avatar-list-stacked">
                                    @forelse ($users_data as $key => $get_user)
                                        @php
                                            $user_db = DB::table('users')->where('id',$get_user)->first();
                                        @endphp
                                        @if($key<3)
                                            <span class="avatar avatar-xs rounded" title="{{$user_db->name}}">
                                                {{ substr($user_db->name, 0, 1) }}
                                            </span>
                                        @else
                                            <?php  $short=substr($user_db->name, 0, 1);?>
                                            <span class="avatar avatar-xs rounded">+{{strtoupper($short)}}</span>
                                        @endif
                                    @empty
                                        {{ __('Not Assigned') }}
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="datagrid-item">
                            <div class="datagrid-title">Task Creator</div>
                            <div class="datagrid-content">Third Party</div>
                        </div>

                        <div class="datagrid-item">
                            <div class="datagrid-title">Planned Start Date</div>
                            <div class="datagrid-content">
                                {{ Utility::site_date_format($data['con_data']->start_date, \Auth::user()->id) }}</div>
                        </div>

                        <div class="datagrid-item">
                            <div class="datagrid-title">Planned End Date</div>
                            <div class="datagrid-content">
                                {{Utility::site_date_format_minus_day($data['con_data']->end_date,
                                \Auth::user()->id, 1)}}
                            </div>
                        </div>

                        <div class="datagrid-item">
                            <div class="datagrid-title">Actucal Start Date</div>
                            <div class="datagrid-content">
                                {{ isset($actualStartDate->record_date) ?
                                Utility::site_date_format($actualStartDate->record_date, \Auth::user()->id) : '-'}}
                            </div>
                        </div>

                        <div class="datagrid-item">
                            <div class="datagrid-title">Actucal End Date</div>
                            <span class="status {{$spanClass}}">
                                {{ isset($actualEndDate->record_date) ?
                                Utility::site_date_format($actualEndDate->record_date, \Auth::user()->id) : '-' }}
                            </span>
                        </div>

                        <div class="datagrid-item">
                            <div class="datagrid-title">Planned Progress</div>
                            <div class="datagrid-content">{{ round($current_Planed_percentage) }}%</div>
                        </div>

                        <div class="datagrid-item">
                            <div class="datagrid-title">Actual Progress</div>
                            <div class="datagrid-content">
                                {{ $data['con_data']->progress != null ? $data['con_data']->progress : '0' }}%</div>
                        </div>

                        <div class="datagrid-item">
                            <div class="datagrid-title">Planned Duration</div>
                            <div class="datagrid-content">{{ $data['con_data']->duration }} days</div>
                        </div>

                        <div class="datagrid-item">
                            <div class="datagrid-title">Actual Duration</div>
                            <span class="status {{$spanClass}}">{{ $total_count_of_task }} days</span>
                        </div>

                        <div class="datagrid-item">
                            <div class="datagrid-title">Status</div>
                            <div class="datagrid-content">
                                <span class="status {{$spanClass}}">{{$statusData}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-actions">
                        @php $get_date = $data['get_date']; @endphp
                        <a href="#" data-size="xl" data-url="{{ route('micro_add_particular_task',
                        ["task_id"=>$task_id, "get_date"=>$get_date]) }}" data-ajax-popup="true"
                        data-title="{{$data['con_data']!=null ? $data['con_data']->text:'Task' }} Progress Update"
                        data-bs-toggle="modal" title="{{__('Create')}}" class="btn btn-success float-end"
                        data-bs-target="#modal-large">
                            Progress Update
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive card p-4">
                        <table class="table table-vcenter card-table" id="task-progress"
                        aria-describedby="Task Progress">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('Planned Date') }}</th>
                                    <th scope="col">{{ __('Actual Date') }}</th>
                                    <th scope="col">{{ __('Status') }}</th>
                                    <th scope="col">{{ __('Actual Progress as per a Day') }}</th>
                                    <th scope="col">{{ __('FileName') }}</th>
                                    <th scope="col">{{ __('Description') }}</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $documentPath = \App\Models\Utility::get_file('uploads/task_particular_list');
                                @endphp
                                @forelse ($data['get_task_progress'] as $task_progress)
                                    <tr>
                                        <td>
                                            {{Utility::site_date_format($task_progress->created_at,\Auth::user()->id)}}
                                        </td>
                                        <td>
                                            {{Utility::site_date_format($task_progress->record_date,\Auth::user()->id)}}
                                        </td>
                                        <td>
                                            @if(date('Y-m-d', strtotime($task_progress->created_at)) > date('Y-m-d') &&
                                            $task_progress->percentage >= '100')
                                                <span class="badge badge-success">Incomplete</span>
                                            @elseif ($task_progress->percentage >= '100')
                                                <span class="badge badge-success"
                                                    style="background-color:#3ec334;">completed</span>
                                            @else
                                                <span class="badge badge-success"
                                                    style="background-color:#DC3545;">Incomplete</span>
                                            @endif
                                        </td>
                                        <td><span class="badge badge-info"
                                            style="background-color:#007bff;">{{ $task_progress->percentage }}%</span>
                                        </td>
                                        <td>
                                            @php
                                                $file_explode = explode(',', $task_progress->filename);
                                            @endphp
                                            @forelse ($file_explode as $file_show)
                                                @if ($file_show != '')
                                                    <span class="badge badge-primary"
                                                    style="background-color:#007bff;margin-top: 5px;">{{ $file_show }}
                                                    </span>&nbsp;&nbsp;&nbsp;
                                                    <a href="{{ route('micro_task_file_download',
                                                    [$task_progress->task_id, "$file_show"]) }}"
                                                        class="badge badge-primary"
                                                        style="background-color:#007bff;
                                            margin-top: 5px;cursor: pointer;">
                                                        <i class="fa fa-download"></i>
                                                    </a>
                                                    <br>
                                                @else
                                                    -
                                                @endif
                                            @empty
                                            @endforelse
                                        </td>
                                        <td>{!! $task_progress->description !!}</td>
                                        <td>
                                            <div class="actions">
                                                <a class="backgroundnone"
                                                    data-url="{{route('micro_edit_particular_task',
                                                    ['task_progress_id' => $task_progress->id,'task_id' => $task_id])}}"
                                                    data-ajax-popup="true" data-size="xl" data-bs-toggle="tooltip"
                                                    title="{{ __('Edit') }}"
                                                    data-title="{{ $data['con_data'] != null ?
                                                    $data['con_data']->text : 'Task' }} Progress Update">
                                                    <i class="ti ti-pencil text-white"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('new_layouts.footer')
    <script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('litepicker/litepicker.js') }}"></script>
    <script src="{{ asset('datatable/jquery.dataTables.min.js') }}"></script>

    <script>
        new DataTable('#task-progress', {
            pagingType: 'full_numbers',
            aaSorting: []
        });
    </script>