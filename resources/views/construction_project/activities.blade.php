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

<section>
    @can('view activity')
    <div class="container-fluid">
        <div class="row row-cards">
            <div class="card">
                <div class="card-header">
                  <h3>{{__('Activity Log')}}</h3>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active show" id="tabs-home-7" role="tabpanel">
                            <div class="col-12">
                                <div class="card">
                                  <div class="card-header">
                                      <h4 class="card-title">{{__('Activity Log of this project')}}</h4>
                                    </div>
                                    <div class="card-body">
                                       <div class="row">
                                        <div class="col-md-2 border-end p-3">
                                        <form>
                                           <div class="col-12 mb-3">
                                            <label class="form-label required">Activity Start Date</label>
                                            <div class="input-icon">
                                                <span class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M11 15h1" /><path d="M12 15v3" /></svg>
                                                </span>
                                                <input class="form-control" placeholder="Select a Start date" id="start-date"/>
                                              </div>
                                           </div>
                                           <div class="col-12 mb-3">
                                            <label class="form-label required">Activity End Date</label>
                                            <div class="input-icon">
                                                <span class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M11 15h1" /><path d="M12 15v3" /></svg>
                                                </span>
                                                <input class="form-control" placeholder="Select a End date" id="end-date"/>
                                              </div>
                                           </div>
                                           <div class="col-md-12">
                                           <div class="mb-3">
                                            <label class="form-label">Task Action Method</label>
                                            <select type="text" class="form-select" placeholder="Select Status" id="task-status" value="" multiple>
                                              <option value="HTML">Create</option>
                                              <option value="JavaScript">Update</option>
                                              <option value="CSS">Delete</option>
                                            </select>
                                          </div>
                                        </div>
                                           <div class="col-12 mt-4">
                                            <div class="mb-3">
                                                <button class="btn btn-tabler w-100">Search</button>
                                              </div>
                                           </div>
                                        </form>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="table-responsive card p-4">
                                              <table class="table table-vcenter card-table" id="task-table">
                                                <thead>
                                                    <tr>
                                                      <th>Activity ID</th>
                                                      <th>Activity Type</th>
                                                      <th>Activity</th>
                                                      <th>Activity Date and Time</th>
                                                    </tr>
                                                  </thead>
                                                  <tbody>
                                                    @foreach($project->activities as $activity)
                                                        <tr>
                                                            <td><a href="#">{{$activity->id}}</a></td>
                                                            <td>{{ __($activity->log_type) }}</td>
                                                            <td>{!! $activity->getRemark() !!}</td>
                                                            <td>{{$activity->created_at->diffForHumans()}}</td>
                                                       </tr>
                                                       @endforeach
                                                  </tbody>
                                                </table>
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
        </div>
    </div>
    @endcan
</section>
@include('new_layouts.footer')

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'
 integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script>


 <script>
    new DataTable('#task-table', {
      pagingType: 'full_numbers'
  });
      </script>
<script>
    // @formatter:off
    document.addEventListener("DOMContentLoaded", function () {
        var el;
        window.TomSelect && (new TomSelect(el = document.getElementById('task-name'), {
                      copyClassesToDropdown: false,            plugins: ['remove_button'],
            dropdownParent: 'body',
            controlInput: '<input>',
            render:{
                item: function(data,escape) {
                    if( data.customProperties ){
                        return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                    }
                    return '<div>' + escape(data.text) + '</div>';
                },
                option: function(data,escape){
                    if( data.customProperties ){
                        return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                    }
                    return '<div>' + escape(data.text) + '</div>';
                },
            },
        }));
    });
    // @formatter:on
  </script>

<script>
    // @formatter:off
    document.addEventListener("DOMContentLoaded", function () {
        var el;
        window.TomSelect && (new TomSelect(el = document.getElementById('search-assignee'), {
                      copyClassesToDropdown: false,            plugins: ['remove_button'],
            dropdownParent: 'body',
            controlInput: '<input>',
            render:{
                item: function(data,escape) {
                    if( data.customProperties ){
                        return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                    }
                    return '<div>' + escape(data.text) + '</div>';
                },
                option: function(data,escape){
                    if( data.customProperties ){
                        return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                    }
                    return '<div>' + escape(data.text) + '</div>';
                },
            },
        }));
    });
    // @formatter:on
</script>
      <script>
        // @formatter:off
        document.addEventListener("DOMContentLoaded", function () {
            window.Litepicker && (new Litepicker({
                element: document.getElementById('start-date'),
                elementEnd: document.getElementById('end-date'),
                singleMode: false,
                allowRepick: true,
                buttonText: {
                    previousMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
                    nextMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
                },
            })).DateTime();
        });
        // @formatter:on
      </script>
       <script>
        // @formatter:off
        document.addEventListener("DOMContentLoaded", function () {
            var el;
            window.TomSelect && (new TomSelect(el = document.getElementById('task-status'), {
                          copyClassesToDropdown: false,            plugins: ['remove_button'],
                dropdownParent: 'body',
                controlInput: '<input>',
                render:{
                    item: function(data,escape) {
                        if( data.customProperties ){
                            return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                        }
                        return '<div>' + escape(data.text) + '</div>';
                    },
                    option: function(data,escape){
                        if( data.customProperties ){
                            return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                        }
                        return '<div>' + escape(data.text) + '</div>';
                    },
                },
            }));
        });
        // @formatter:on
      </script>