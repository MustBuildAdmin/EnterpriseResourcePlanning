<div class="modal-body">
    <div class="row text-sm">
        <div class="col-md-4">
            <div class="mb-4">
                <b>{{__('Status')}}</b>
                @if($task->status)
                    <div class="badge badge-pill badge-success mb-1">{{__(\App\Models\DealTask::$status[$task->status])}}</div>
                @else
                    <div class="badge badge-pill badge-warning mb-1">{{__(\App\Models\DealTask::$status[$task->status])}}</div>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-4">
                <b>{{__('Priority')}}</b>
                <p>{{__(\App\Models\DealTask::$priorities[$task->priority])}}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-4">
                <b>{{__('Deal Name')}}</b>
                <p>{{$deal->name}}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-4">
                <b>{{__('Date')}}</b>
                <p>{{Auth::user()->dateFormat($task->date)}}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-4">
                <b>{{__('Time')}}</b>
                <p>{{Auth::user()->timeFormat($task->time)}}</p>
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-0">
                <b>{{__('Asigned')}}</b>
                <p class="mt-2">
                    @foreach($deal->users as $user)
                        <a href="#" class="btn btn-sm mr-1 p-0 rounded-circle">
                            <img alt="image" data-toggle="tooltip" data-original-title="{{$user->name}}" title="{{$user->name}}" @if($user->avatar) src="{{asset('/storage/uploads/avatar/'.$user->avatar)}}" @else src="{{asset('/storage/uploads/avatar/avatar.png')}}" @endif class="rounded-circle" width="25" height="25">
                        </a>
                    @endforeach
                </p>
            </div>
        </div>
    </div>
</div>


