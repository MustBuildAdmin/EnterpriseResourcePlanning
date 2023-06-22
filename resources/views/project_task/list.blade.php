<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="col-12">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Stage')}}</th>
                                <th scope="col">{{__('Priority')}}</th>
                                <th scope="col">{{__('End Date')}}</th>
                                <th scope="col">{{__('Assigned To')}}</th>
                                <th scope="col">{{__('Completion')}}</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody class="list">

                            @if(count($tasks) > 0)
                                @foreach($tasks as $task)
                                    <tr>
                                        <td>
                                            <span class="h6 text-sm font-weight-bold mb-0"><a href="{{ route('projects.tasks.index',$task->project->id) }}">{{ $task->name }}</a></span>
                                            <span class="d-flex text-sm text-muted justify-content-between">
                                        <p class="m-0">{{ $task->project->project_name }}</p>
                                    <span class="me-5 badge p-2 px-3 rounded bg-{{ (\Auth::user()->checkProject($task->project_id) == 'Owner') ? 'success' : 'warning'  }}">
                                        {{ __(\Auth::user()->checkProject($task->project_id)) }}</span>
                                </span>
                                        </td>
                                        <td>{{ $task->stage->name }}</td>
                                        <td>
                                            <span class="status_badge badge p-2 px-3 rounded bg-{{__(\App\Models\ProjectTask::$priority_color[$task->priority])}}">{{ __(\App\Models\ProjectTask::$priority[$task->priority]) }}</span>
                                        </td>
                                        <td class="{{ (strtotime($task->end_date) < time()) ? 'text-danger' : '' }}">{{ Utility::getDateFormated($task->end_date) }}</td>
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
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="completion mr-2">{{ $task->taskProgress()['percentage'] }}</span>
                                                {{--<div>
                                                    <div class="progress" style="width: 100px;">
                                                        <div class="progress-bar bg-{{ $task->taskProgress()['color'] }}" role="progressbar" aria-valuenow="{{ $task->taskProgress()['percentage'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $task->taskProgress()['percentage'] }};"></div>
                                                    </div>
                                                </div>--}}
                                            </div>
                                        </td>
                                        <td class="text-end w-15">
                                            <div class="actions">
                                                <a class="action-item px-1" data-bs-toggle="tooltip" title="{{__('Attachment')}}" data-original-title="{{__('Attachment')}}">
                                                    <i class="ti ti-paperclip mr-2"></i>{{ count($task->taskFiles) }}
                                                </a>
                                                <a class="action-item px-1" data-bs-toggle="tooltip" title="{{__('Comment')}}" data-original-title="{{__('Comment')}}">
                                                    <i class="ti ti-brand-hipchat mr-2"></i>{{ count($task->comments) }}
                                                </a>
                                                <a class="action-item px-1" data-bs-toggle="tooltip" title="{{__('Checklist')}}" data-original-title="{{__('Checklist')}}">
                                                    <i class="ti ti-list-check mr-2"></i>{{ $task->countTaskChecklist() }}
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <th scope="col" colspan="7"><h6 class="text-center">{{__('No tasks found')}}</h6></th>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

