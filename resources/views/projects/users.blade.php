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
<?php
 $key=0;
 ?>
@forelse($user_contact as $user)
<?php ?>
    @if($user->projectUsers->type!='company')
        <?php $key=$key+1; ?>
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body p-4 text-center">
                @if($user->projectUsers->avatar)
                <span class="avatar avatar-xl mb-3 rounded"
                  style="background-image: url({{asset('/storage/uploads/avatar/'.$user->projectUsers->avatar)}})">
                </span>
                @else
                    <?php  $short=substr($user->projectUsers->name, 0, 2);?>
                    <span class="avatar avatar-xl mb-3 rounded">{{strtoupper($short)}}</span>
                @endif
                <h3 class="m-0 mb-1"><a href="#">{{$user->projectUsers->name }}</a></h3>
                <div class="mt-3">
                    <span class="badge bg-purple-lt">{{$user->projectUsers->type}}</span>
                </div>
                <div class="mt-3">
                    @if($user->invite_status!='')
                        <span class="badge bg-purple-lt">{{$user->invite_status}}</span>
                    @else
                        <span class="badge bg-purple-lt">Invited</span>
                    @endif
                </div>
                </div>
                <div class="d-flex">
                <a data-bs-toggle="tooltip" data-copy_email="{{ $user->projectUsers->email }}"
                title="{{ $user->projectUsers->email }}"
                    href="#" class="card-btn" onclick="copyToClipboard(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 5m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                        <path d="M3 7l9 6l9 -6" />
                    </svg>
                    {{__('Email')}}
                </a>
                <a data-bs-toggle="tooltip" 
                    data-copy_phone="{{ $user->projectUsers->phone }}" 
                    title="{{ $user->projectUsers->phone }}"
                    class="card-btn" onclick="copyToClipboardphone(this)">
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
@endforelse
@if($key==0)
    @if($type=='teammember')
    <div class="empty">
        <p class="empty-title">Invite Member</p>
        <p class="empty-subtitle text-secondary">
        No Members are available for the project,please click below to invite members
        </p>
        <div class="empty-action">
            @can('edit project')
                <div class="float-end">
                    <a href="#" data-size="lg"
                    data-url="{{ route('invite.project.invite_teammember', $project->id) }}"
                    data-ajax-popup="true" data-bs-toggle="tooltip" title="" class="btn  btn-primary"
                    >
                    {{__(' Invite a Member')}}
                    </a>
                </div>
            @endcan
        </div>
    </div>
    @endif
    @if($type=='consultant')
    <div class="empty">
        <p class="empty-title">Invite Consultant</p>
        <p class="empty-subtitle text-secondary">
        No consultants are available for the project,please click below to invite consultants
        </p>
        <div class="empty-action">
            @can('edit project')
                <div class="float-end">
                    <a href="#" data-size="lg" data-url="{{ route('invite.project.invite_teammember', $project->id) }}"
                    data-ajax-popup="true" data-bs-toggle="tooltip" title="" class="btn  btn-primary"
                    >
                    {{__(' Invite a Consultant')}}
                    </a>
                </div>
            @endcan
        </div>
    </div>
    @endif
    @if($type=='subcontractor')
    <div class="empty">
        <p class="empty-title">Invite Sub Contractors</p>
        <p class="empty-subtitle text-secondary">
        No Sub Contractors are available for the project,please click below to invite sub contractors
        </p>
        <div class="empty-action">
            @can('edit project')
                <div class="float-end">
                    <a href="#" data-size="lg" data-url="{{ route('invite.project.invite_teammember', $project->id) }}"
                    data-ajax-popup="true" data-bs-toggle="tooltip" title="" class="btn  btn-primary"
                    >
                    {{__(' Invite a Sub Contractor')}}
                    </a>
                </div>
            @endcan
        </div>
    </div>
    @endif
@endif
