<style>
.user-initial {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background-color: #e0e0e0;
  color: #333;
  font-size: 24px;
  text-align: center;
  line-height: 50px;
}
</style>
@forelse($project->users as $user)
    @if($user->type!='company')
    <div class="col-md-6 col-lg-3">
        <div class="card">
            <div class="card-body p-4 text-center">
            @if($user->avatar)
            <span class="avatar avatar-xl mb-3 rounded"
                    style="background-image: url({{asset('/storage/uploads/avatar/'.$user->avatar)}})"></span>
            @else
                <?php  $short=substr($user->name, 0, 2);?>
                <span class="avatar avatar-xl mb-3 rounded">{{strtoupper($short)}}</span>
            @endif
            <h3 class="m-0 mb-1"><a href="#">{{$user->name }}</a></h3>
            <div class="mt-3">
                <span class="badge bg-purple-lt">{{$user->type}}</span>
            </div>
            </div>
            <div class="d-flex">
            <a data-bs-toggle="tooltip" data-copy_email="{{ $user->email }}" title="{{ $user->email }}"
                href="#" class="card-btn" onclick="copyToClipboard(this)">
                <!-- Download SVG icon from http://tabler-icons.io/i/mail -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24"
                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M3 5m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                    <path d="M3 7l9 6l9 -6" />
                </svg>
                {{__('Email')}}
            </a>
            
            <a data-bs-toggle="tooltip" data-copy_phone="{{ $user->phone }}" title="{{ $user->phone }}"
                class="card-btn" onclick="copyToClipboardphone(this)">
                <!-- Download SVG icon from http://tabler-icons.io/i/phone -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24"
                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16
                    0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                </svg>
                    {{__('Call')}}
            </a>
            </div>
        </div>
    </div>
    @endif
@empty
<div class="empty">
    <p class="empty-title">Invite Member</p>
    <p class="empty-subtitle text-secondary">
    No Members are available for the project,please click below to invite members
    </p>
    <div class="empty-action">
        @can('edit project') 
            <div class="float-end">
                <a href="#" data-size="lg" data-url="{{ route('invite.project.member.view', $project->id) }}"
                data-ajax-popup="true" data-bs-toggle="tooltip" title="" class="btn  btn-primary"
                >
                {{__(' Invite a Member')}}
                </a>
            </div>
        @endcan
    </div>
</div>
@endforelse


<!-- <li class="list-group-item px-0">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-auto mb-3 mb-sm-0">
                <div class="d-flex align-items-center">
                    
                        @if($user->avatar)
                            <img  src="{{asset('/storage/uploads/avatar/'.$user->avatar)}}"
                            alt="image" class="user-initial">
                        @else
                        <?php  //$short=substr($user->name, 0, 1);?>
                            <span class="user-initial">{{strtoupper($short)}}</span>
                        @endif
                
                    <div class="div" style='margin-left: 10px;'>
                        <h5 class="m-0">{{ $user->name }}</h5>
                        <small class="text-muted">{{ $user->email }}</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-auto text-sm-end d-flex align-items-center">
                <div class="action-btn bg-danger ms-2">
                    {!! Form::open(['method' => 'DELETE',
                        'route' => ['projects.user.destroy',  [$project->id,$user->id]]]) !!}
                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip"
                    title="{{__('Delete')}}"><i class="ti ti-trash text-white"></i></a>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
</li> -->