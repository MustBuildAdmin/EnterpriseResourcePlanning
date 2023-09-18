@include('new_layouts.header')
<style>
.green {
    background-color: #206bc4 !important;
}
.activity-scroll{
  height:700px !important;
}
</style>
@php $setting  = Utility::settings(\Auth::user()->creatorId()); @endphp
@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
    <link rel='stylesheet' href='https://unicons.iconscout.com/release/v3.0.6/css/line.css'>

<div class="page-wrapper dashboard">

@include('construction_project.side-menu')
<section class="container">
  @can('view activity')
    <div class="card activity-scroll">
        <div class="card-header">
            <h5>{{__('Activity Log')}}</h5>
            <small>{{__('Activity Log of this project')}}</small>
        </div>
        <div class="card-body vertical-scroll-cards">
            @foreach($project->activities as $activity)
                <div class="card p-2 mb-2">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="theme-avtar bg-primary">
                                <i class="ti ti-{{$activity->logIcon($activity->log_type)}}"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0">{{ __($activity->log_type) }}</h6>
                                <p class="text-muted text-sm mb-0">{!! $activity->getRemark() !!}</p>
                            </div>
                        </div>
                        <p class="text-muted text-sm mb-0">{{$activity->created_at->diffForHumans()}}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
  @endcan
</section>
@include('new_layouts.footer')

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js' integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script>
