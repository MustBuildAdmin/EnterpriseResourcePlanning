@if(isset($projects) && !empty($projects) && count($projects) > 0)
    <div class="row">
        @foreach ($projects as $key => $project)
            <div class="col-md-6 col-xxl-3">
                <div class="card">
                    <div class="card-header border-0 pb-0">
                        <div class="d-flex align-items-center">
                            <img {{ $project->img_image }} class="img-fluid wid-30 me-2" alt="">
                            <h5 class="mb-0"><a class="text-dark" href="{{ route('projects.show',$project) }}">{{ $project->project_name }}</a></h5>
                        </div>
                        <div class="card-header-right">
                            <div class="btn-group card-option">
                                <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    @can('edit project')
                                        <a href="#!" data-size="lg" data-url="{{ route('projects.edit', $project->id) }}" data-ajax-popup="true" class="dropdown-item" data-bs-original-title="{{__('Edit User')}}">
                                            <i class="ti ti-pencil"></i>
                                            <span>{{__('Edit')}}</span>
                                        </a>
                                    @endcan
                                    @can('delete project')
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['projects.destroy',$project->id]]) !!}
                                        <a href="#!" class="dropdown-item bs-pass-para">
                                            <i class="ti ti-archive"></i>
                                            <span> {{__('Delete')}}</span>
                                        </a>

                                        {!! Form::close() !!}
                                    @endcan
                                    @can('edit project')
                                        <a href="#!" data-size="lg" data-url="{{ route('invite.project.member.view', $project->id) }}" data-ajax-popup="true" class="dropdown-item" data-bs-original-title="{{__('Invite User')}}">
                                            <i class="ti ti-send"></i>
                                            <span>{{__('Invite User')}}</span>
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-2 justify-content-between">
                            <div class="col-auto"><span class="badge rounded-pill bg-{{\App\Models\Project::$status_color[$project->status]}}">{{ __(\App\Models\Project::$project_status[$project->status]) }}</span>
                            </div>

                        </div>
                        <p class="text-muted text-sm mt-3">{{ $project->description }}</p>
                        <small>{{__('MEMBERS')}}</small>
                        <div class="user-group">
                            @if(isset($project->users) && !empty($project->users) && count($project->users) > 0)
                                @foreach($project->users as $key => $user)
                                    @if($key < 3)
                                        <a href="#" class="avatar rounded-circle avatar-sm">
                                            <img @if($user->avatar) src="{{asset('/storage/uploads/avatar/'.$user->avatar)}}" @else src="{{asset('/storage/uploads/avatar/avatar.png')}}" @endif  alt="image" data-bs-toggle="tooltip" title="{{ $user->name }}">
                                        </a>
                                    @else
                                        @break
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <div class="card mb-0 mt-3">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-6">
                                        <h6 class="mb-0 {{ (strtotime($project->start_date) < time()) ? 'text-danger' : '' }}">{{ Utility::getDateFormated($project->start_date) }}</h6>
                                        <p class="text-muted text-sm mb-0">{{__('Start Date')}}</p>
                                    </div>
                                    <div class="col-6 text-end">
                                        <h6 class="mb-0">{{ Utility::getDateFormated($project->end_date) }}</h6>
                                        <p class="text-muted text-sm mb-0">{{__('Due Date')}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="col-xl-12 col-lg-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <h6 class="text-center mb-0">{{__('No Projects Found.')}}</h6>
            </div>
        </div>
    </div>
@endif
