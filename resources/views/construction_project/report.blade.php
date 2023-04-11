@include('new_layouts.header')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-x">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Construction
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page body -->
@include('construction_project.side-menu')
                        <div class="col d-flex flex-column">
                            <div class="card-body">
                                <h2 class="mb-4">Project</h2>
                                <div class="col-12">
                                    <div class="card">
                                      <div class="card-header">
                                        <h3 class="card-title">Invoices</h3>
                                      </div>
                                      <div class="card-body border-bottom py-3">
                                        <div class="d-flex">
                                          <div class="text-muted">
                                            Show
                                            <div class="mx-2 d-inline-block">
                                              <input type="text" class="form-control form-control-sm" value="8" size="3" aria-label="Invoices count">
                                            </div>
                                            entries
                                          </div>
                                          <div class="ms-auto text-muted">
                                            Search:
                                            <div class="ms-2 d-inline-block">
                                              <input type="text" class="form-control form-control-sm" aria-label="Search invoice">
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="table-responsive">
                                        <table class="table card-table table-vcenter text-nowrap datatable">
                                          <thead>
                                            <tr>
                                                <th>{{__('Projects')}}</th>
                                                <th>{{__('Start Date')}}</th>
                                                <th>{{__('Due Date')}}</th>
                                                <th>{{__('Projects Members')}}</th>
                                                <th>{{__('Completion')}}</th>
                                                <th>{{__('Status')}}</th>
                                                <th>{{__('Action')}}</th>
                                            </tr>
                                          </thead>
                                        <tbody>
                                            @if(isset($projects) && !empty($projects) && count($projects) > 0)
                                            @foreach ($projects as $key => $project)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <p class="mb-0"><a  class="name mb-0 h6 text-sm">{{ $project->project_name }}</a></p>
                                                        </div>
                                                    </td>
                                                    <td>{{ Utility::getDateFormated($project->start_date) }}</td>
                                                    <td>{{ Utility::getDateFormated($project->end_date) }}</td>
                                                    <td class="">
                                                        <div class="avatar-group" id="project_{{ $project->id }}">
                                                            @if(isset($project->users) && !empty($project->users) && count($project->users) > 0)
                                                                @foreach($project->users as $key => $user)
                                                                    @if($key < 3)
                                                                        <a href="#" class="avatar rounded-circle">
                                                                            <img @if($user->avatar) src="{{asset('/storage/uploads/avatar/'.$user->avatar)}}" @else src="{{asset('/storage/uploads/avatar/avatar.png')}}" @endif
                                                                            title="{{ $user->name }}" style="height:36px;width:36px;">
                                                                        </a>
                                                                    @else
                                                                        @break
                                                                    @endif
                                                                @endforeach
                                                                @if(count($project->users) > 3)
                                                                    <a href="#" class="avatar rounded-circle avatar-sm">
                                                                        <img avatar="+ {{ count($project->users)-3 }}" style="height:36px;width:36px;">
                                                                    </a>
                                                                @endif
                                                            @else
                                                                {{ __('-') }}
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="">
                                                        <h6 class="mb-0 text-success">{{ $project->project_progress()['percentage'] }}</h6>
                                                        <div class="progress mb-0"><div class="progress-bar bg-{{ $project->project_progress()['color'] }}" style="width: {{ $project->project_progress()['percentage'] }};"></div>
                                                        </div>
                                                    </td>
                                                    <td class="">
                                                        <span class="badge bg-{{\App\Models\Project::$status_color[$project->status]}} p-2 px-3 rounded status_badge">{{ __(\App\Models\Project::$project_status[$project->status]) }}</span>
                                                    </td>
                                                    <td class="">
                                                        @can('manage project')
                                                            <div class="action-btn bg-warning ms-2">
                                                                <a href="{{ route('project_report.show', $project->id) }}" class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="{{__('Show')}}" data-original-title="{{__('Detail')}}">
                                                                    <i class="ti ti-eye text-white"></i>
                                                                </a>
                                                            </div>
                                                        @endcan
                                                        @can('edit project')
                                                                <div class="action-btn bg-primary ms-2">
                                                                    <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-url="{{ URL::to('projects/'.$project->id.'/edit') }}" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit Project')}}">
                                                                        <i class="ti ti-pencil text-white"></i>
                                                                    </a>
                                                                </div>
                                                            @endcan
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <th scope="col" colspan="7"><h6 class="text-center">{{__('No Projects Found.')}}</h6></th>
                                            </tr>
                                        @endif
                
                                        </tbody>
                                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('new_layouts.footer')
