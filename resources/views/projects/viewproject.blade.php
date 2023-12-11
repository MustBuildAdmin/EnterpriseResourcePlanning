@include('new_layouts.header')
@php
    if (Session::has('project_id')) {
        $project_id = Session::get('project_id');
    } else {
        $project_id = 0;
    }

    $getInstance = DB::table('instance')
        ->where('instance',$project->instance_id)
        ->where('project_id',$project_id)
        ->where('freeze_status',0)->first();
@endphp
<style>
</style>
<link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet"/>
<div class="page-wrapper">
@include('construction_project.side-menu')
<div class="card m-3" >

    <div class="card-header">
        <h4 class="card-title">Project Profile</h4>
        <div class="card-actions">
        @if($getInstance != null)
            @can('edit project')
            <button class="btn btn-primary">
                <a class="dropdown-item active btn btn-primary" href="#!" data-size="xl"
                    data-url="{{ route('projects.edit', $project->id) }}"
                    data-ajax-popup="true"
                    data-bs-original-title="{{ __('Edit Project') }}">{{ __('Edit') }}
                    </a>
            </button>
            @endcan
        @endif
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-3">
                @include('layouts.project_setup')
            </div>
            <div class="col-9">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('Project Details')}}</h3>
                    </div>
                    <div class="card-body">
                        <div class="datagrid mb-3">
                            <div class="datagrid-item">
                                <div class="datagrid-title">{{__('Project Name')}}</div>
                                <div class="datagrid-content">{{$project->project_name}}</div>
                            </div>


                            <div class="datagrid-item">
                                <div class="datagrid-title">{{__('Client')}}</div>
                                @foreach($clients as $key => $value)
                                    @if($key == $project->client_id)
                                        <div class="datagrid-content">{{$value}}</div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">{{__('Manager')}}</div>
                                @foreach($repoter as $key => $value)
                                    @if($key == $project->report_to)
                                        <div class="datagrid-content">{{$value}}</div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="datagrid mb-3">
                            <div class="datagrid-item">
                                <div class="datagrid-title">{{__('Country')}}</div>
                                @foreach($country as $key => $value)
                                    @if($value->iso2 == $project->country)
                                        <div class="datagrid-content">{{$value->name}}</div>
                                    @endif
                                @endforeach
                            </div>

                            <div class="datagrid-item">
                                <div class="datagrid-title">{{__('State')}}</div>
                                @foreach($statelist as $key => $value)
                                    @if($value->iso2 == $project->state)
                                        <div class="datagrid-content">{{$value->name}}</div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">{{__('City')}}</div>
                                <div class="datagrid-content">{{$project->city}}</div>
                            </div>
                        </div>
                        <div class="datagrid mb-3">
                            <div class="datagrid-item">
                                <div class="datagrid-title">{{__('Other Address Details')}}</div>
                                <div class="datagrid-content">{{$project->otheraddress}}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">{{__('Latitude')}}</div>
                                <div class="datagrid-content">{{$project->latitude}}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">{{__('Longitude')}}</div>
                                <div class="datagrid-content">{{$project->longitude}}</div>
                            </div>
                        </div>
                        <div class="datagrid mb-3">
                            <div class="datagrid-item">

                                <div class="datagrid-title">{{__('Zip Code')}}</div>
                                <div class="datagrid-content">{{$project->zipcode}}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">{{__('Start Date')}}</div>
                                <div class="datagrid-content">{{$project->start_date}}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">{{__('End Date')}}</div>
                                <div class="datagrid-content">{{$project->end_date}}</div>
                            </div>
                        </div>
                        <div class="datagrid mb-3">
                            <div class="datagrid-item">
                                <div class="datagrid-title">{{__('Estimated Days')}}</div>
                                <div class="datagrid-content">{{$project->estimated_days}}</div>
                            </div>

                            <div class="datagrid-item">
                                <div class="datagrid-title">{{__('Non Working Days')}}</div>
                                <div class="datagrid-content">{{implode(", ",$weekendVal)}}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">{{__('Look-a-head')}}</div>
                                <div class="datagrid-content">{{ $project->micro_program == 1 ? 'Enabled':'Disabled'}}
                                </div>
                            </div>
                        </div>
                        <div class="datagrid">
                            <div class="datagrid-item">
                                <div class="datagrid-title">{{__('Report Time')}}</div>
                                <div class="datagrid-content">{{\App\Models\Utility::utc_to_originaltime
                                    ($project->report_time,$setting)}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="col d-flex flex-column">
        <div class="card-body">


    </div>
</div>
<script src="{{ asset('datatable/jquery.dataTables.min.js') }}"></script>

@include('new_layouts.footer')
