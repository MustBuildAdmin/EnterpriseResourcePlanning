@include('new_layouts.header')
<style>
.img-fluid {
    max-width: 26% !important;
    height: auto;
}
.page-wrapper{
    margin:20px;
}
.user-initial {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #e0e0e0;
    color: #333;
    font-size: 18px;
    text-align: center;
    line-height: 43px;
    margin: 1px;
}
</style>
<script src="{{ asset('WizardSteps/js/jquery.steps.js') }}"></script>
<div class="page-wrapper">




  <div class="row">
      <div class="col-md-6">
         <h2>{{ __('Project') }}</h2>
      </div>
      <div class="col-md-6">

        <div class="col-auto ms-auto d-print-none float-end">
            <div class="input-group-btn">
                @can('create project')
                <a href="#" data-size="xl"
                data-url="{{ route('projects.create') }}" data-ajax-popup="true"
                data-title="{{ __('Create New Project') }}" data-bs-toggle="tooltip"
                title="{{__('Create New Project')}}" class="btn btn-primary">
                <span class="btn-inner--icon"><i class="fa fa-plus"></i></span>
                </a>
                @endcan
                <a href="{{ route('new_home') }}"  class="btn btn-danger"
                 data-bs-toggle="tooltip" title="{{ __('Back') }}">
                  <span class="btn-inner--icon"><i class="fa fa-arrow-left"></i></span>
                </a>
            </div>
        </div>


      </div>

  </div>

    <div class="row">
        <h2 class="mb-4">

        </h2>
    </div>
    <div class="col d-flex flex-column">
        <div class="card-body">


            @if (isset($projects) && !empty($projects) && count($projects) > 0)

                <div class="row">
                    @foreach ($projects as $key => $project)
                        <div class="col-md-3 col-xxl-3 divstyle">
                            <div class="card">
                                <div class="card-header border-0 pb-0">
                                    <div class="d-flex align-items-center">
                                        <img {{ $project->img_image }} class="img-fluid wid-30 me-2" alt="">
                                        <h5 class="mb-0"><a class="text-dark"
                                                href="{{ route('projects.show', $project) }}">{{ $project->project_name }}</a>
                                        </h5>
                                    </div>
                                    <div class="card-header-right">
                                        <div class="btn-group card-option">
                                            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                @if($project->freeze_status!=1)
                                                    @can('edit project')
                                                        <a href="#!" data-size="xl"
                                                            data-url="{{ route('projects.edit', $project->id) }}"
                                                            data-ajax-popup="true" class="dropdown-item"
                                                            data-bs-original-title="{{ __('Edit User') }}">
                                                            <i class="ti ti-pencil"></i>
                                                            <span>{{ __('Edit') }}</span>
                                                        </a>
                                                    @endcan
                                               
                                                    @can('delete project')
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['projects.destroy', $project->id]]) !!}
                                                        <a href="#!" class="dropdown-item bs-pass-para">
                                                            <i class="ti ti-archive"></i>
                                                            <span> {{ __('Delete') }}</span>
                                                        </a>
                                                        {!! Form::close() !!}
                                                    @endcan
                                                @endif
                                                
                                                @can('edit project')
                                                    <a href="#!" data-size="xl"
                                                        data-url="{{ route('invite.project.member.view', $project->id) }}"
                                                        data-ajax-popup="true" class="dropdown-item"
                                                        data-bs-original-title="{{ __('Invite User') }}">
                                                        <i class="ti ti-send"></i>
                                                        <span>{{ __('Invite User') }}</span>
                                                    </a>
                                                @endcan
                                                {{-- <a href="{{ url('project_holiday') }}"   data-url=""
                                                    data-ajax-popup="true" class="dropdown-item"
                                                    data-bs-original-title="{{ __('Invite User') }}">
                                                        <i class="ti ti-pencil"></i>
                                                        <span>{{ __('Holidays') }}</span>
                                                </a> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row g-2 justify-content-between">
                                        <div class="col-auto">
                                            @php
                                                if ($project->status != ""){
                                                    $status_set = $project->status;
                                                }
                                                else{
                                                    $status_set = 'in_progress';
                                                }
                                            @endphp
                                            <span class="badge rounded-pill bg-{{ \App\Models\Project::$status_color[$status_set] }}">{{ __(\App\Models\Project::$project_status[$status_set]) }}</span>
                                        </div>

                                    </div>
                                    <p class="text-muted text-sm mt-3">{{ $project->description }}</p>
                                    <small>{{ __('MEMBERS') }}</small>
                                    <div class="user-group" style='display: flex;'>
                                        @if (isset($project->users) && !empty($project->users) && count($project->users) > 0)
                                            @foreach ($project->users as $key => $user)
                                            <?php  $short=substr($user->name, 0, 1);?>
                                                @if ($key < 3)
                                                    @if ($user->avatar)
                                                        <a href="#" class="avatar rounded-circle avatar-sm">
                                                            <img  src="{{ asset('/storage/uploads/avatar/' . $user->avatar) }}"
                                                                alt="image" data-bs-toggle="tooltip"
                                                                title="{{ $user->name }}" class="user-initial">
                                                        </a>
                                                    @else
                                                        {{-- <a href="#" class="avatar rounded-circle avatar-sm"> --}}
                                                            <div class="user-initial" data-bs-toggle="tooltip"
                                                            title="{{ $user->name }}">{{strtoupper($short)}}</div>
                                                        {{-- </a> --}}
                                                    @endif

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
                                                <h6
                                                    class="mb-0 {{ strtotime($project->start_date) < time() ? 'text-danger' : '' }}">
                                                    {{ Utility::getDateFormated($project->start_date) }}</h6>
                                                <p class="text-muted text-sm mb-0">{{ __('Start Date') }}</p>
                                            </div>
                                            <div class="col-6 text-end">
                                                <h6 class="mb-0">
                                                    {{ Utility::getDateFormated($project->end_date) }}</h6>
                                                <p class="text-muted text-sm mb-0">{{ __('Due Date') }}</p>
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
                        <h6 class="text-center mb-0">{{ __('No Projects Found.') }}</h6>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@include('new_layouts.footer')

<script>
         $(document).ready(function () {
            $(document).on('click', '.invite_usr', function () {
                var project_id = $('#project_id').val();
                var user_id = $(this).attr('data-id');

                $.ajax({
                    url: '{{ route('invite.project.user.member') }}',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        'project_id': project_id,
                        'user_id': user_id,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        if (data.code == '200') {
                            show_toastr(data.status, data.success, 'success')
                            location.reload();
                            loadProjectUser();
                        } else if (data.code == '404') {
                            show_toastr(data.status, data.errors, 'error')
                        }
                    }
                });
            });
        });
</script>
