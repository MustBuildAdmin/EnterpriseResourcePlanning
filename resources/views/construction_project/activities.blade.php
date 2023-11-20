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
<link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
<link rel='stylesheet' href='https://unicons.iconscout.com/release/v3.0.6/css/line.css'>
<script src="{{ asset('tabler/tabler.min.js') }}"></script>
<script src="{{ asset('theme/demo-theme.min.js') }}"></script>
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
                                  <div class="card-header">
                                      <h4 class="card-title">{{__('Activity Log of this project')}}</h4>
                                    </div>
                                    <div class="card-body">
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
                                           </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="table-responsive card p-4">
                                              <table class="table table-vcenter card-table"
                                               id="task-table">
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
<script src="{{ asset('datatable/jquery.dataTables.min.js') }}"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'
 integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script>

      <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            
      $('#task-table').DataTable({
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
                        data.start_date = $('#start-date').val();
                        data.end_date = $('#end-date').val();
                        data.task_status=$('#task-status').val();


                    }
                },
                order: [],
                columnDefs: [ { orderable: true, targets: [0,1,2,3,4]}],
                pageLength: 10,
                searching: true,
                aoColumns: [
                    {
                        data: 'activitylogID',
                    },
                    {
                        data: 'log_type',
                        render: function(data, type, row) {
                            let log_type=data;
                            if (data == 'Added New Task') {
                                log_type = "{{__('Create')}}";
                            } else if (data == 'Updated Task') {
                                log_type = "{{__('Update')}}";
                            } else if (data == 'Deleted Task') {
                                log_type = "{{__('Delete')}}";
                            }
                            return log_type;
                        }
                    },
                    {
                        data: 'remark',
                        render: function(data, type, row) {
                            data=JSON.parse(data);
                            console.log(data);
                            if (row['log_type'] == 'Invite User') {
                                return "{{__('has invited')}}"+' - <b>'+data['title']+'</b>';
                            }
                            else if (row['log_type'] == 'Added New Task') {
                                return "{{__('Added New Task')}}"+' - <b>'+data['title']+'</b>';
                            }
                            else if (row['log_type'] == 'User Assigned to the Task') {
                                return "{{__('has assigned task ')}}"+' - <b>'+data['task_name']
                                +'</b> '+"{{__(' to')}}"+
                                ' - <b>'+data['member_name']+'</b>';
                            }else if (row['log_type'] == 'User Removed from the Task') {
                                return "{{__('has removed ')}}"+' - <b>'+data['member_name']
                                +'</b>'+"{{__(' from task')}}"+
                                ' - <b>'+data['task_name']+'</b>';
                            } else if (row['log_type'] == 'Upload File') {
                                return "{{__('Upload new file')}}"+' - <b>'+data['file_name']+'</b>';
                            } else if (row['log_type'] == 'Create Bug') {
                                return "{{__('Created new bug')}}"+' - <b>'+data['title']+'</b>';
                            } else if (row['log_type'] == 'Create Milestone') {
                                return "{{__('Create new milestone')}}"+' - <b>'+data['title']+'</b>';
                            } else if (row['log_type'] == 'Create Task') {
                                return "{{__('Create new Task')}}"+' - <b>'+data['title']+'</b>';
                            } else if (row['log_type'] == 'Create Expense') {
                                return "{{__('Create new Expense')}}"+' - <b>'+data['title']+'</b>';
                            } else if (row['log_type'] == 'Add Product') {
                                return "{{__('Add new Products')}}"+' - <b>'+data['title']+'</b>';
                            } else if (row['log_type'] == 'Update Sources') {
                                return "{{__('Update Sources')}}";
                            } else if (row['log_type'] == 'Create Deal Call') {
                                return "{{__('Create new Deal Call')}}";
                            } else if (row['log_type'] == 'Create Deal Email') {
                                return "{{__('Create new Deal Email')}}";
                            }else if (row['log_type'] == 'Added New Consultant') {
                                return "{{__('Added new Consultant')}}"+' - <b>'+data['title']+'</b>';
                            } else if (row['log_type'] == 'Updated Consultant') {
                                return "{{__('Updated Consultant')}}"+' - <b>'+data['title']+'</b>';
                            } else if (row['log_type'] == 'Deleted Consultant') {
                                return "{{__('Deleted Consultant')}}"+' - <b>'+data['title']+'</b>';
                            } else if (row['log_type'] == 'Added New RFIStatus') {
                                return "{{__('Added New RFIStatus')}}"+' - <b>'+data['title']+'</b>';
                            } else if (row['log_type'] == 'Updated RFIStatus') {
                                return "{{__('Updated RFIStatus')}}"+' - <b>'+data['title']+'</b>';
                            } else if (row['log_type'] == 'Deleted RFIStatus') {
                                return "{{__('Deleted RFIStatus')}}"+' - <b>'+data['title']+'</b>';
                            } else if (row['log_type'] == 'Added New ProjectSpecification') {
                                return "{{__('Added New ProjectSpecification')}}"+' - <b>'+data['title']+'</b>';
                            } else if (row['log_type'] == 'Updated ProjectSpecification') {
                                return "{{__('Updated ProjectSpecification')}}"+' - <b>'+data['title']+'</b>';
                            } else if (row['log_type'] == 'Added New Variation Scope') {
                                return "{{__('Added New Variation Scope')}}"+' - <b>'+data['title']+'</b>';
                            } else if (row['log_type'] == 'Updated Variation Scope') {
                                return "{{__('Updated Variation Scope')}}"+' - <b>'+data['title']+'</b>';
                            } else if (row['log_type'] == 'Deleted Variation Scope') {
                                return "{{__('Deleted Variation Scope')}}"+' - <b>'+data['title']+'</b>';
                            } else if (row['log_type'] == 'Added New ProcurementMaterial') {
                                return "{{__('Added New ProcurementMaterial')}}"+' - <b>'+data['title']+'</b>';
                            } else if (row['log_type'] == 'Updated ProcurementMaterial') {
                                return "{{__('Updated ProcurementMaterial')}}"+' - <b>'+data['title']+'</b>';
                            } else if (row['log_type'] == 'Deleted ProcurementMaterial') {
                                return "{{__('Deleted ProcurementMaterial')}}"+' - <b>'+data['title']+'</b>';
                            } else if (row['log_type'] == 'Added New SiteReport') {
                                return "{{__('Added New SiteReport')}}"+' - <b>'+data['title']+'</b>';
                            } else if (row['log_type'] == 'Updated SiteReport') {
                                return "{{__('Updated SiteReport')}}"+' - <b>'+data['title']+'</b>';
                            } else if (row['log_type'] == 'Deleted SiteReport') {
                                return "{{__('Deleted SiteReport')}}"+' - <b>'+data['title']+'</b>';
                            } else if (row['log_type'] == 'Added New ConcretePouring') {
                                return "{{__('Added New ConcretePouring')}}"+' - <b>'+data['title']+'</b>';
                            } else if (row['log_type'] == 'Updated ConcretePouring') {
                                return "{{__('Updated ConcretePouring')}}"+' - <b>'+data['title']+'</b>';
                            } else if (row['log_type'] == 'Deleted ConcretePouring') {
                                return "{{__('Deleted ConcretePouring')}}"+' - <b>'+data['title']+'</b>';
                            } else if (row['log_type'] == 'Updated Task') {
                                return "{{__('Updated Task')}}"+' - <b>'+data['title']+'</b>';
                            } else if (row['log_type'] == 'Deleted Task') {
                                return "{{__('Deleted Task')}}"+' - <b>'+data['title']+'</b>';
                            }else if (row['log_type'] == 'Move Task') {
                                return "{{__('Moved the Task')}}"+' - <b>'+data['title']+'</b> '+"{{__('from')}}"+' '+
                                data['old_stage'].toUpperCase()+' '+"{{__('to')}}"+' '+data['new_stage'].toUpperCase();
                            } else if (row['log_type'] == 'Move') {
                                return "{{__('Moved the deal')}}"+' - <b>'+data['title']+'</b> '+"{{__('from')}}"+' '
                                + data['old_status'].toUpperCase()+' '+"{{__('to')}}"+' '
                                +data['new_status'].toUpperCase();
                            } else {
                                return data.toUpperCase();
                            }
                        

                        }
                    },
                    {
                        data: 'user_id',
                        render: function(data, type, row) {
                          return capitalize(row['name']);
                        }
                    },
                    {
                        data: 'activitylogcreatedAt',
                        render: function(data, type, row) {
                            // return data;
                          return new Date(data).toDateString()+" "+new Date(data).toLocaleTimeString();
                        }
                    }
                ]
            });
           
        });

        function capitalize(s)
        {
            return s[0].toUpperCase() + s.slice(1);
        }
        function searchResult(){
            console.log("searchResult")
            $('#task-table').DataTable().ajax.reload();
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