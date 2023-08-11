@include('new_layouts.header')
@php $setting  = Utility::settings(\Auth::user()->creatorId()); @endphp

<script src="
https://preview.tabler.io/dist/js/tabler.min.js?1691487027"></script>
{{-- @push('css-page') --}}
    <div class="page-wrapper">
        @include('construction_project.side-menu')
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <!-- Page pre-title -->
                        <div class="page-pretitle">
                            {{ __('Overview')}}
                        </div>
                        <h2 class="page-title">
                            {{ __('Project Dashboard') }}
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <a href="{{ route('construction_main') }}" class="btn btn-danger" data-bs-toggle="tooltip"
                            title="{{ __('Back') }}">
                            <span class="btn-inner--icon"><i class="fa fa-arrow-left mx-2"></i>{{ __('Back') }}</span>
                        </a>
                        </div>
                      </div>

                </div>
                <div class="row row-cards mt-5">
                    <div class="col-lg-6">
                        <div class="card">
                          <div class="card-body">
                            <div class="row align-items-center">
                              <div class="col-3">
                                <img src={{ $project->img_image }} alt={{$project->project_name}} class="rounded">
                              </div>
                              <div class="col">
                                <h3 class="card-title mb-1">
                                  <a href="#" class="text-reset">{{$project->project_name}}</a>
                                </h3>
                                <div class="text-secondary">
                                  Updated 2 hours ago
                                </div>
                                <div class="mt-3">
                                  <div class="row g-2 align-items-center">
                                    <div class="col-auto">
                                      {{ round($workdone_percentage) }} %
                                    </div>
                                    <div class="col">
                                      <div class="progress progress-sm">
                                        <div class="progress-bar"
                                        style="width: {{ round($workdone_percentage)}}%" role="progressbar"
                                        aria-valuenow= {{ round($workdone_percentage)}}
                                        aria-valuemin="0" aria-valuemax="100"
                                        aria-label={{ round($workdone_percentage)}}>
                                          <span class="visually-hidden">{
                                            { round($workdone_percentage) }}% Complete</span>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-auto">
                                <div class="dropdown">
                                  <a href="#" class="btn-action" data-bs-toggle="dropdown"
                                  aria-expanded="false">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/dots-vertical -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"
                                    fill="none"></path><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                    <path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                    <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path></svg>
                                  </a>
                                  <div class="dropdown-menu dropdown-menu-end" style="">
                                    <a href="#" class="dropdown-item">Import</a>
                                    <a href="#" class="dropdown-item">Export</a>
                                    <a href="#" class="dropdown-item">Download</a>
                                    <a href="#" class="dropdown-item text-danger">Delete</a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </div>
