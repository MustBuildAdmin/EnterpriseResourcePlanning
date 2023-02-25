<div class="modal-body">

<div class="p-2">
    <div class="row mb-4">
        <div class="col-md-6">
            <span class="font-bold lab-title">{{ __('Status')}} : </span>
            <span class="badge-xs badge p-2 px-3 rounded bg-{{\App\Models\Project::$status_color[$milestone->status]}} text-white">{{ __(\App\Models\Project::$project_status[$milestone->status]) }}</span>
        </div>

        <div class="col-md-12 pt-4">
            <div class="font-weight-bold lab-title">{{ __('Description')}} :</div>
            <p class="mt-1 lab-val">{{(!empty($milestone->description)) ? $milestone->description : '-'}}</p>
        </div>
        <div class="col-12">
            <div class=" table-border-style">
                <div class="table-responsive">
                    <table class="table ">
                        <thead>
                        <tr>
                            <th scope="col">{{__('Name')}}</th>
                            <th scope="col">{{__('Stage')}}</th>
                            <th scope="col">{{__('Priority')}}</th>
                            <th scope="col">{{__('End Date')}}</th>
                            <th scope="col">{{__('Completion')}}</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        @if(count($milestone->tasks) > 0)
                            @foreach($milestone->tasks as $task)
                                <tr>
                                    <td>
                                        <span class="h6 text-sm">{{ $task->name }}</span>
                                    </td>
                                    <td>{{ $task->stage->name }}</td>
                                    <td>
                                        <span class="badge p-2 px-3 rounded badge-sm bg-{{__(\App\Models\ProjectTask::$priority_color[$task->priority])}}">{{ __(\App\Models\ProjectTask::$priority[$task->priority]) }}</span>
                                    </td>
                                    <td class="{{ (strtotime($task->end_date) < time()) ? 'text-danger' : '' }}">{{ Utility::getDateFormated($task->end_date) }}</td>
                                    <td>
                                        {{ $task->taskProgress()['percentage'] }}
                                    </td>
                                    <td class="text-end w-15">
                                        <div class="actions">
                                            <a class="action-item px-2" data-bs-toggle="tooltip" data-original-title="{{__('Attachment')}}">
                                                <i class="ti ti-paperclip mr-2"></i>{{ count($task->taskFiles) }}
                                            </a>
                                            <a class="action-item px-2" data-bs-toggle="tooltip" data-original-title="{{__('Comment')}}">
                                                <i class="ti ti-brand-hipchat mr-2"></i>{{ count($task->comments) }}
                                            </a>
                                            <a class="action-item px-2" data-bs-toggle="tooltip" data-original-title="{{__('Checklist')}}">
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
