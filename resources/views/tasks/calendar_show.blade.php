<div class="modal-body">

<div class="row">
    <div class="col-12 pb-2">
        <b>{{__(' Estimated Hours')}}</b> : <span>{{ (!empty($task->estimated_hrs)) ? number_format($task->estimated_hrs) : '-' }}</span>
    </div>
    <div class="col-12 pb-2">
        <b>{{__('Milestone')}}</b> : <span>{{ (!empty($task->milestone)) ? $task->milestone->title : '-' }}</span>
    </div>
    <div class="col-12">
        <b>{{__('Description')}}</b> <br> <span>{{ (!empty($task->description)) ? $task->description : '-' }}</span>
        <hr/>
    </div>

    <div class="col-12 pb-4">
        <div class="progress" data-toggle="tooltip" data-original-title="{{ $task->taskProgress()['percentage'] }}">
            <div class="progress-bar event-{{ $task->taskProgress()['color'] }}" role="progressbar" aria-valuenow="{{ $task->taskProgress()['percentage'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $task->taskProgress()['percentage'] }};"></div>
        </div>
    </div>
</div>
<div class="row pb-2">
    <div class="col-6">
        @if($users = $task->users())
            @if(count($users) > 0)
                <div class="avatar-group">
                    @foreach($users as $key => $user)
                        @if($key<3)
                            <a href="#" class="avatar rounded-circle avatar-sm">
                                <img src="{{$user->getImgImageAttribute()}}" title="{{ $user->name }}">
                            </a>
                        @else
                            @break
                        @endif
                    @endforeach
                    @if(count($users) > 3)
                        <a href="#" class="avatar rounded-circle avatar-sm">
                            <img src="{{$user->getImgImageAttribute()}}" avatar="+ {{ count($users)-3 }}">
                        </a>
                    @endif
                </div>
            @else
                <p>{{__('No User Found.')}}</p>
            @endif
        @endif
    </div>
    <div class="col-6 pt-2">
        <div class="row text-center">
            <div class="col-4" data-toggle="tooltip" data-placement="bottom" data-original-title="{{__('Attachment')}}">
                <i class="ti ti-paperclip mr-2"></i>{{ count($task->taskFiles) }}
            </div>
            <div class="col-4" data-toggle="tooltip" data-placement="bottom" data-original-title="{{__('Comment')}}">
                <i class="ti ti-brand-hipchat mr-2"></i>{{ count($task->comments) }}
            </div>
            <div class="col-4" data-toggle="tooltip" data-placement="bottom" data-original-title="{{__('Checklist')}}">
                <i class="ti ti-list-check mr-2"></i>{{ $task->countTaskChecklist() }}
            </div>
        </div>
    </div>
</div>
</div>
