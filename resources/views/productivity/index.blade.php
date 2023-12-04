@extends('layouts.admin')
@section('page-title')
    {{__('Manage Projects')}}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
<ul>
    <li
    class="breadcrumb-item"><a href="{{route('productivity')}}">{{__('Dashboard')}}</a></li>
    <li
    class="breadcrumb-item">{{__('Projects')}}</li>
</ul>
@endsection
@section('action-btn')
    <div class="float-end">
            <a href="{{ route('productivity') }}"
            data-bs-toggle="tooltip"
            title="{{__('Grid View')}}" class="btn btn-sm btn-primary">
                <i class="ti ti-layout-grid"></i>
            {{-- </a>
        @endif --}}


        {{------------ Start Filter ----------------}}
                <a href="#" class="btn btn-sm btn-primary action-item"
                role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                    <i class="ti ti-filter"></i>
                </a>
                <div class="dropdown-menu  dropdown-steady" id="project_sort">
                    <a class="dropdown-item active" href="#" data-val="created_at-desc">
                        <i class="ti ti-sort-descending"></i>{{__('Newest')}}
                    </a>
                    <a class="dropdown-item" href="#" data-val="created_at-asc">
                        <i class="ti ti-sort-ascending"></i>{{__('Oldest')}}
                    </a>

                    <a class="dropdown-item" href="#" data-val="project_name-desc">
                        <i class="ti ti-sort-descending-letters"></i>{{__('From Z-A')}}
                    </a>
                    <a class="dropdown-item" href="#" data-val="project_name-asc">
                        <i class="ti ti-sort-ascending-letters"></i>{{__('From A-Z')}}
                    </a>
                </div>

            {{------------ End Filter ----------------}}

            {{------------ Start Status Filter ----------------}}
                <a href="#" class="btn btn-sm btn-primary action-item"
                role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="btn-inner--icon">{{__('Status')}}</span>
                </a>
                <div class="dropdown-menu  project-filter-actions dropdown-steady" id="project_status">
                    <a class="dropdown-item filter-action filter-show-all pl-4 active" href="#">{{__('Show All')}}</a>
                    @foreach(\App\Models\Construction_project::$project_status as $key => $val)
                        <a class="dropdown-item filter-action pl-4" href="#" data-val="{{ $key }}">{{__($val)}}</a>
                    @endforeach
                </div>
            {{------------ End Status Filter ----------------}}

    </div>
@endsection
@section('content')
    <div class="row min-750" id="project_view">
        @if(isset($projects) && !empty($projects) && count($projects) > 0)
    <div class="row">
        @foreach ($projects as $key => $project)
            <div class="col-md-6 col-xxl-3">
                <div class="card">
                    <div class="card-header border-0 pb-0">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0"><a class="text-dark"
                                href="{{ route('productivity_show',$project) }}">
                                {{ $project->name }}</a></h5>
                        </div>
                        <div class="card-header-right">
                            <div class="btn-group card-option">
                                <button type="button" class="btn dropdown-toggle"
                                data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    @can('edit project')
                                        <a href="#!" data-size="lg"
                                        data-url="{{ route('productivity_edit', $project->id) }}"
                                        data-ajax-popup="true" class="dropdown-item"
                                        data-bs-original-title="{{__('Edit User')}}">
                                            <i class="ti ti-pencil"></i>
                                            <span>{{__('Edit')}}</span>
                                        </a>
                                    @endcan
                                    @can('delete project')
                                        {!! Form::open(['method' => 'DELETE',
                                        'route' => ['productivity_destroy',$project->id]]) !!}
                                        <a href="#!" class="dropdown-item bs-pass-para">
                                            <i class="ti ti-archive"></i>
                                            <span> {{__('Delete')}}</span>
                                        </a>

                                        {!! Form::close() !!}
                                    @endcan
                                    @can('edit project')
                                        <a href="#!" data-size="lg"
                                        data-url="{{ route('invite-cons_project-member', $project->id) }}"
                                        ata-ajax-popup="true" class="dropdown-item"
                                        data-bs-original-title="{{__('Invite User')}}">
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
                            <div class="col-auto"><span
                             class="badge rounded-pill
                             bg-{{\App\Models\Construction_project::$status_color[$project->status]}}">
                            {{ __(\App\Models\Project::$project_status[$project->status]) }}</span>
                            </div>

                        </div>
                        {{-- <p class="text-muted text-sm mt-3">{{ $project->description }}</p> --}}
                        <small>{{__('MEMBERS')}}</small>
                        <div class="user-group">
                            @if(isset($project->users) && !empty($project->users) && count($project->users) > 0)
                                @foreach($project->users as $key => $user)
                                    @if($key < 3)
                                        <a href="#" class="avatar rounded-circle avatar-sm">
                                            <img alt="avatar" @if($user->avatar)
                                            src="{{asset('/storage/uploads/avatar/'.$user->avatar)}}"
                                            @else src="{{asset('/storage/uploads/avatar/avatar.png')}}"
                                            @endif  alt="image" data-bs-toggle="tooltip" title="{{ $user->name }}">
                                        </a>
                                    @else
                                        @break
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <div class="card m-0">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-6">
                                        <h6 class="mb-0
                                        {{ (strtotime($project->start_date) < time()) ? 'text-danger' : '' }}">
                                        {{ Utility::getDateFormated($project->start_date) }}</h6>
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

    </div>
@endsection

@push('script-page')
    <script>
        $(document).ready(function () {
            var sort = 'created_at-desc';
            var status = '';
            ajaxFilterProjectView('created_at-desc');
            $(".project-filter-actions").on('click', '.filter-action', function (e) {
                if ($(this).hasClass('filter-show-all')) {
                    $('.filter-action').removeClass('active');
                    $(this).addClass('active');
                } else {
                    $('.filter-show-all').removeClass('active');
                    if ($(this).hasClass('active')) {
                        $(this).removeClass('active');
                        $(this).blur();
                    } else {
                        $(this).addClass('active');
                    }
                }

                var filterArray = [];
                var url = $(this).parents('.project-filter-actions').attr('data-url');
                $('div.project-filter-actions').find('.active').each(function () {
                    filterArray.push($(this).attr('data-val'));
                });

                status = filterArray;

                ajaxFilterProjectView(sort, $('#project_keyword').val(), status);
            });

            // when change sorting order
            $('#project_sort').on('click', 'a', function () {
                sort = $(this).attr('data-val');
                ajaxFilterProjectView(sort, $('#project_keyword').val(), status);
                $('#project_sort a').removeClass('active');
                $(this).addClass('active');
            });

            // when searching by project name
            $(document).on('keyup', '#project_keyword', function () {
                ajaxFilterProjectView(sort, $(this).val(), status);
            });

            function ajaxFilterProjectView(project_sort, keyword = '', status = '') {

        }

            $(document).on('click', '.invite_usr', function () {
                var project_id = $('#project_id').val();
                var user_id = $(this).attr('data-id');

                $.ajax({
                    url: '{{ route('invite-cons_project-user-member') }}',
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
                        } else if (data.code == '404') {
                            show_toastr(data.status, data.errors, 'error')
                        }
                    }
                });
            });
        });

    </script>
@endpush
