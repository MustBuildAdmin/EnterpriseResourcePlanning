<div class="col-12">
    <div class="card">
        <div class="row">
            @if(count($tasks) > 0)
                @foreach($tasks as $task)
                    @php
                        $permissions = \Auth::user()->getPermission($task->project_id);
                    @endphp
                    <div class="col-md-4">
                        <div class="card m-3 card-progress border shadow-none" id="{{$task->id}}" style="{{ !empty($task->priority_color) ? 'border-left: 2px solid '.$task->priority_color.' !important' :'' }};">
                            <div class="card-body">
                                <div class="row align-items-center mb-2">
                                    <div class="col-6">
                                        <span class="badge badge-pill badge-xs badge-{{\App\Models\ProjectTask::$priority_color[$task->priority]}}">{{ \App\Models\ProjectTask::$priority[$task->priority] }}</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        @if(str_replace('%','',$task->taskProgress()['percentage']) > 0)<span class="text-sm">{{ $task->taskProgress()['percentage'] }}</span>@endif
                                    </div>
                                </div>
                                @if(isset($permissions) && in_array('show task',$permissions))
                                    <a class="h6 task-name-break" href="{{ route('projects.tasks.index',$task->project->id) }}">{{ $task->name }}</a>
                                @else
                                    <a class="h6 task-name-break" href="#">{{ $task->name }}</a>
                                @endif
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <div class="actions d-inline-block">
                                            @if(count($task->taskFiles) > 0)
                                                <div class="action-item mr-2"><i class="ti ti-paperclip mr-2"></i>{{ count($task->taskFiles) }}</div>@endif
                                            @if(count($task->comments) > 0)
                                                <div class="action-item mr-2"><i class="ti ti-brand-hipchart mr-2"></i>{{ count($task->comments) }}</div>@endif
                                            @if($task->checklist->count() > 0)
                                                <div class="action-item mr-2"><i class="ti ti-tasks mr-2"></i>{{ $task->countTaskChecklist() }}</div>@endif
                                        </div>
                                    </div>
                                    <div class="col-5">@if(!empty($task->end_date) && $task->end_date != '0000-00-00')<small @if(strtotime($task->end_date) < time())class="text-danger"@endif>{{ Utility::getDateFormated($task->end_date) }}</small>@endif</div>
                                    <div class="col-7 text-end">
                                        @if($users = $task->users())
                                            <div class="avatar-group">
                                                @foreach($users as $key => $user)
                                                    @if($key<3)
                                                        <a href="#" class="avatar rounded-circle avatar-sm">
                                                            <img {{ $user->img_avatar }} title="{{ $user->name }}">
                                                        </a>
                                                    @else
                                                        @break
                                                    @endif
                                                @endforeach
                                                @if(count($users) > 3)
                                                    <a href="#" class="avatar rounded-circle avatar-sm">
                                                        <img avatar="+ {{ count($users)-3 }}">
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-md-12">
                    <h6 class="text-center m-3">{{__('No tasks found')}}</h6>
                </div>
            @endif
        </div>
    </div>
</div>
