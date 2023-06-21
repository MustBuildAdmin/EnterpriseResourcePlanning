@if(isset($users) && !empty($users) && count($users) > 0)
    @foreach($users as $user)
        <div class="col-lg-3 col-sm-6">
            <div class="card hover-shadow-lg">
                <div class="card-body text-center">
                    <div class="avatar-parent-child">
                        <img {{ $user->img_avatar }} class="avatar rounded-circle avatar-lg">
                    </div>
                    <h5 class="h6 mt-4 mb-0">
                        <p>{{ $user->name }}</p>
                    </h5>
                    <p class="d-block text-sm text-muted mb-3">{{ $user->email }}</p>
                </div>
                <div class="card-body border-top">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-6 text-center">
                            <span class="d-block h4 mb-0">{{ count($user->contacts) }}</span>
                            <span class="d-block text-sm text-muted">{{__('Contacts')}}</span>
                        </div>
                        <div class="col-6 text-center">
                            <span class="d-block h4 mb-0">{{ $user->projects->count() }}</span>
                            <span class="d-block text-sm text-muted">{{__('Projects')}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="col-xl-12 col-lg-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <h6 class="text-center mb-0">{{__('No User Found.')}}</h6>
            </div>
        </div>
    </div>
@endif
