@include('new_layouts.header')
<style>
.green {
    background-color: #206bc4 !important;
}
.activity-scroll{
  height:700px !important;
}
th.sorting_disabled{
    color:white !important;
}

</style>
@php $setting  = Utility::settings(\Auth::user()->creatorId()); @endphp
@push('css-page')

<link rel="stylesheet" href="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.css') }}">
<link rel="stylesheet" href="{{ asset('tokeninput/tokeninput.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
<link rel='stylesheet' href='https://unicons.iconscout.com/release/v3.0.6/css/line.css'>
<script src="{{ asset('tom-select/tom-select.popular.min.js') }}"></script>
<script src="{{ asset('litepicker/litepicker.js') }}"></script>
<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet"/>
<div class="page-wrapper dashboard">

@include('construction_project.side-menu')
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
                                    <div class="card-body p-0">
                                       <div class="row">
                                        <div class="col-md-2 border-end p-3">
                                            <div class="col-12 mb-3">
                                                <label class="form-label required">Activity Start Date</label>
                                                <div class="input-icon">
                                                    <span class="input-icon-addon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                     height="24" viewBox="0 0 24 24" stroke-width="2"
                                                      stroke="currentColor"
                                                      fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2
                                                         0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                                        <path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" />
                                                        <path d="M11 15h1" /><path d="M12 15v3" /></svg>
                                                    </span>
                                                    <input class="form-control" name="start_date"
                                                    placeholder="Select a Start date"
                                                     id="start-date"/>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                            <label class="form-label required">Activity End Date</label>
                                            <div class="input-icon">
                                                <span class="input-icon-addon">
                                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                   height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2
                                                     2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                                    <path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" />
                                                    <path d="M11 15h1" /><path d="M12 15v3" /></svg>
                                                </span>
                                                <input class="form-control" placeholder="Select a End date"
                                                name="end_date" id="end-date"/>
                                              </div>
                                           </div>
                                           <div class="col-md-12">
                                           <div class="mb-3">
                                            <label class="form-label">Task Action Method</label>
                                            <select type="text" class="form-select" placeholder="Select Status"
                                             id="task-status" name="task_status" value="" multiple>
                                              <option value="Create">Create</option>
                                              <option value="Update">Update</option>
                                              <option value="Delete">Delete</option>
                                            </select>
                                          </div>
                                        </div>
                                           <div class="col-12 mt-4">
                                            <div class="mb-3">
                                                <button class="btn btn-tabler w-100"
                                                onclick="searchResult()">Search</button>
                                            </div>
                                            <div class="mb-3">
                                                <button class="btn btn-default w-100">Reset</button>
                                            </div>
                                           </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="table-responsive card p-2">
                                              <table class="table table-vcenter card-table"
                                               id="activity-table">
                                                <thead>
                                                    <tr>
                                                      <th>Activity ID</th>
                                                      <th>Activity Type</th>
                                                      <th>Activity</th>
                                                      <th>Activity Done By</th>
                                                      <th>Activity Date and Time</th>
                                                    </tr>
                                                  </thead>
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
<script src="{{ asset('tom-select/tom-select.popular.min.js') }}"></script>
<script src="{{ asset('litepicker/litepicker.js') }}"></script>
<script src="{{ asset('tokeninput/jquery.tokeninput.js') }}"></script>
<script src="{{ asset('datatable/jquery.dataTables.min.js') }}"></script>
{{-- <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'
 integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script> --}}

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            activity_datatable(null, null, null);
        });

        function activity_datatable(start_date, end_date, task_status){
            $('#activity-table').dataTable().fnDestroy();
            $('#activity-table').DataTable({
                processing: true,
                serverSide: true,
                pagingType: 'full_numbers',
                aaSorting: [],
                "language": {
                    "sLengthMenu": "{{ __('Show _MENU_ Records') }}",
                    "sZeroRecords": "{{ __('No data available in table') }}",
                    "sEmptyTable": "{{ __('No data available in table') }}",
                    "sInfo": "{{ __('Showing records _START_ to _END_ of a total of _TOTAL_ records') }}",
                    "sInfoFiltered": "{{ __('filtering of a total of _MAX_ records') }}",
                    "sSearch": "{{ __('Search') }}:",
                    "oPaginate": {
                        "sFirst": "{{ __('First') }}",
                        "sLast": "{{ __('Last') }}",
                        "sNext": "{{ __('Next') }}",
                        "sPrevious": "{{ __('Previous') }}"
                    },
                },
                ajax: {
                    url: "{{ route('project.activitieslog', $project_id) }}",
                    type: "POST",
                    data: function (data) {
                        data.start_date = start_date;
                        data.end_date = end_date;
                        data.task_status = task_status;
                    }
                },
                order: [],
                columnDefs: [ { orderable: true, targets: [0,1,3,4]}],
                pageLength: 10,
                searching: true,
                aoColumns: [
                    {data: 'activitylogID'},
                    {data: 'log_type'},
                    {data: 'activity'},
                    {data: 'name'},
                    {data: 'activity_date'}
                ]
            });
        }

        function capitalize(s)
        {
            return s[0].toUpperCase() + s.slice(1);
        }

        function searchResult(start_date, end_date, task_status){
            start_date  = $('#start-date').val();
            end_date    = $('#end-date').val();
            task_status = $('#task-status').val();
            activity_datatable(start_date, end_date, task_status);
        }

        function resetActivity(){
            $("#start-date").val("");
            $("#end-date").val("");
            document.querySelector('select#task-status').tomselect.setValue("");
            activity_datatable(null,null,null);
        }

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
                        return '<div><span class="dropdown-item-indicator">'
                         + data.customProperties + '</span>' + escape(data.text) + '</div>';
                    }
                    return '<div>' + escape(data.text) + '</div>';
                },
                option: function(data,escape){
                    if( data.customProperties ){
                        return '<div><span class="dropdown-item-indicator">'
                         + data.customProperties + '</span>' + escape(data.text) + '</div>';
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
                        return '<div><span class="dropdown-item-indicator">'
                         + data.customProperties + '</span>' + escape(data.text) + '</div>';
                    }
                    return '<div>' + escape(data.text) + '</div>';
                },
                option: function(data,escape){
                    if( data.customProperties ){
                        return '<div><span class="dropdown-item-indicator">'
                         + data.customProperties + '</span>' + escape(data.text) + '</div>';
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
                    previousMonth: `
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
         stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
          stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/>
          <path d="M15 6l-6 6l6 6" /></svg>`,
                    nextMonth: `
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24
        " viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
         stroke-linecap="round" stroke-linejoin="round"><path stroke="none"
          d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
                },
            })).DateTime();
        });
        // @formatter:on
      </script>
       <script>
        // @formatter:off
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
                                return '<div><span class="dropdown-item-indicator">'
                                 + data.customProperties + '</span>' + escape(data.text) + '</div>';
                            }
                            return '<div>' + escape(data.text) + '</div>';
                        },
                        option: function(data,escape){
                            if( data.customProperties ){
                                return '<div><span class="dropdown-item-indicator">'
                                 + data.customProperties + '</span>' + escape(data.text) + '</div>';
                            }
                            return '<div>' + escape(data.text) + '</div>';
                        },
                    },
                }));
            });

      </script>
