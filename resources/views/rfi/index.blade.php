@include('new_layouts.header')
<style>
.mt-5 {
  margin-top : 0px !important
}
#tinymce_mytextarea {
    width: 70%;
    padding-bottom: 35px;
}
.hidden {
    display: none;
}
</style>
@php $setting  = Utility::settings(\Auth::user()->creatorId()); @endphp
@push('css-page')
<link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.css') }}">
<link rel="stylesheet" href="{{ asset('tokeninput/tokeninput.css') }}">
<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet"/>
    <link rel='stylesheet' href='https://unicons.iconscout.com/release/v3.0.6/css/line.css'>

<div class="page-wrapper dashboard">

@include('construction_project.side_menu_dairy')
<section>
@can('view activity')
<div class="container-fluid">
    <div class="modal modal-blur fade" id="modal-large" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form class="upload_form" id="upload_form"
              action="{{ route('add.rfi',[$projectid]) }}" enctype="multipart/form-data" method="POST">
                @csrf
          <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Create a RFI Record</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                 <form>
                  <div class="row">
                    <div class="mb-3">
                      <div class="form-label required">Select a Responding Party Type</div>
                      <div>
                        <label class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" id="party_type" name="party_type"
                          value="consultant" required onclick="get_responding_type()">
                          <span class="form-check-label">Consultant</span>
                        </label>
                        <label class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" id="party_type" name="party_type"
                          value="sub_contractor" required onclick="get_responding_type()">
                          <span class="form-check-label">Sub Contractor</span>
                        </label>
                      </div>
                    </div>
                     <div class="col-md-12">
                      <div class="mb-3">
                        <div class="form-label required">Select Responding Party</div>
                            <select class="select form-control select2-multiple" id="responding_type"
                            name="responding_type" data-toggle="select2"
                            data-placeholder="{{ __('Select Party ...') }}" required>
                                <option value="">Select Party</option>
                            </select>
                        </div>
                     </div>
                     <div class="mb-3">
                      <div class="form-label required">Select a RFI Dependency</div>
                      <div>
                        <label class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="dependency_type"
                          onclick="get_dependency()" value="tasks"  required>
                          <span class="form-check-label">Tasks</span>
                        </label>
                        <label class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="dependency_type" value="drawings"
                          onclick="get_dependency()" required>
                          <span class="form-check-label">Drawings</span>
                        </label>
                        <label class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="dependency_type" value="others"
                          onclick="get_dependency()" required>
                          <span class="form-check-label">Others</span>
                        </label>
                      </div>
                      <div class="col-md-6 mb-3">
                      <div class="col-md-12">
                              <div class="mb-3">
                                
                                  <input type="text" id="skill_input_drawing" name="ref_id" value="{{ request()->get('q') }}" >
                              </div>
                     </div>
                    </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-label">Impacts of RFI</div>
                    </div>
                    <div class="col-md-3">
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="time_impact" 
                        name="time_impact" value="1">
                        <span class="form-check-label">Time Impact</span>
                    </label>
                    </div>

                    <div class="col-md-3">
                        <label class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="cost_impact" 
                        name="cost_impact" value="1">
                        <span class="form-check-label">Cost Impact</span>
                        </label>
                    </div>

                     <div class="col-md-6">
                      <label class="form-label required">RFI Submission Deadline</label>
                      <input class="form-control mb-2" placeholder="Select a date" id="submission_date" 
                      name="submission_date" required/>
                     </div>
                     <div class="col-md-6 mb-3">
                      <div class="">
                        <div class="form-label required">Select a Priority</div>
                        <select class="form-select" id="rfi_priority" name="rfi_priority" required>
                          <option value="">Select a Priority</option>
                          @foreach($rfi_priorities as $rfi_priority)
                              <option value="{{ $rfi_priority->id }}">{{ $rfi_priority->priority_type }}</option>
                          @endforeach
                        </select>
                      </div>
                     </div>
                   
                     <div class="col-md-12 mb-3">
                        <div class="form-label">Description</div>
                        <div>
                        <textarea id="tinymce_mytextarea" name="tinymce_mytextarea"></textarea>
                        </div>
                     </div>
                  </div>
              
                 </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3>RFI</h3>
            <div class="card-actions">
                <a href="#" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#modal-large">
                        Create a RFI
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="mt-5 card">
                <div class="card-header">
                    <h3>RFI Lists</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 border-end p-3">
                            <form class="rfi_search">
                                <div class="col-12 mb-3">
                                    <label class="form-label required">RFI Subnitted From Date</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none"
                                            stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z"
                                            fill="none"/>
                                            <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0
                                            1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0
                                            1 -2 -2v-12z" />
                                            <path d="M16 3v4" /><path d="M8 3v4" />
                                            <path d="M4 11h16" /><path d="M11 15h1" />
                                            <path d="M12 15v3" /></svg>
                                        </span>
                                        <input class="form-control start_date"
                                        placeholder="Select a Start date"
                                        id="start-date" name="start_date"/>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label required">RFI Submitted To Date</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"><path stroke="none"
                                            d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2
                                            2v12a2 2 0 0 1 -2 2h-12a2 2 0 0
                                            1 -2 -2v-12z" />
                                            <path d="M16 3v4" /><path d="M8 3v4" />
                                            <path d="M4 11h16" /><path d="M11 15h1" />
                                            <path d="M12 15v3" />
                                            </svg>
                                        </span>
                                        <input class="form-control end_date"
                                        placeholder="Select a End date" id="end-date" name="end_date"/>
                                    </div>
                                </div>
                                <div class="col-12 mt-4">
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-tabler w-100"
                                        onclick="search_rfi()">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-10">
                            <div class="table-responsive card p-4">
                            <table class="table table-vcenter card-table" id="rfi-table">
                            <caption>RFI Lists</caption>
                            <thead>
                                <tr>
                                    <th>RFI Id</th>
                                    <th>RFI Submitted On</th>
                                    <th>RFI Submitted For</th>
                                    <th>RFI Status</th>
                                </tr>
                            </thead>
                            @foreach ($rfi_records as $rfi_record)
                            <tbody>
                                <tr>
                                    <td style="width: 100px; font-size: 15px;">{{$rfi_record->rfi_id}}</td>
                                    <td style="width: 100px; font-size: 15px;">{{$rfi_record->submitted_date}}</td>
                                    <td style="width: 100px; font-size: 15px;">{{$rfi_record->responder_name}}</td>
                                    <td style="width: 100px; font-size: 15px;">{{$rfi_record->rfi_status}}</td>
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
@endcan
</section>
@include('new_layouts.footer')


<script src="{{ asset('tom-select/tom-select.popular.min.js') }}"></script>
<script src="{{ asset('litepicker/litepicker.js') }}"></script>
<script src="{{ asset('tokeninput/jquery.tokeninput.js') }}"></script>
<script src="{{ asset('datatable/jquery.dataTables.min.js') }}"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'
 integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script>

<script>

$(document).ready(function() {
        $("#skill_input_drawing").tokenInput("{{route('drawing_autocomplete')}}", {
            propertyToSearch:"text",
            tokenValue:"id",
            tokenDelimiter:",",
            hintText: "Search Id...",
            noResultsText: "Reference Id not found.",
            searchingText: "Searching...",
            deleteText:"&#215;",
            minChars: 2,
            tokenLimit: 4,
            animateDropdown: false,
            resultsLimit:10,
            deleteText: "&times;",
            preventDuplicates: true,
            theme: "bootstrap"
        });
  });
    
    function get_dependency() {
        var dependency_type  = $("input[name='dependency_type']:checked").val();
        if(dependency_type == 'tasks') {
            document.getElementByClass('tasks').classList.remove('hidden');
            document.getElementByClass('skill_input_drawing').classList.add('hidden');
            document.getElementByClass('others').classList.add('hidden');
        } else if (dependency_type == 'drawings') {
            document.getElementByClass('skill_input_drawing').classList.remove('hidden');
            document.getElementByClass('tasks').classList.add('hidden');
            document.getElementByClass('others').classList.add('hidden');
        } else{
            document.getElementByClass('others').classList.remove('hidden');
            document.getElementByClass('tasks').classList.add('hidden');
            document.getElementByClass('skill_input_drawing').classList.add('hidden');
        }

    }

    function get_responding_type()
    {
      party_type  = $("input[name='party_type']:checked").val();
      $.ajax({
            url : '{{route("get.responding.party")}}',
            type : 'GET',
            data : {
                'party_type'  : party_type
            },
            success : function(data) {
                $('#responding_type').empty();
                $('#responding_type').append('<option value="">Select Party</option>');
                $.each(data, function (key, value) {
                    $('#responding_type').append('<option value="' + value + '">' + key + '</option>');
                });
            },
            error : function(request,error)
            {
                // alert("Request: "+JSON.stringify(request));
            }
        });
    }

    function get_dependency_details()
    {
        dependency_type  = $("input[name='dependency_type']:checked").val();
        alert(dependency_type)
        $.ajax({
            url : '{{route("get.dependency.details")}}',
            type : 'GET',
            data : {
                'dependency_type'  : dependency_type
            },
            success : function(data) {
                $('#dependency_id').empty();
                $('#dependency_id').append('<option value="">Select Party</option>');
                $.each(data, function (key, value) {
                    $('#dependency_id').append('<option value="' + value + '">' + key + '</option>');
                });
            },
            error : function(request,error)
            {
                // alert("Request: "+JSON.stringify(request));
            }
        });

        
    }
  document.addEventListener("DOMContentLoaded", function () {
        window.Litepicker && (new Litepicker({
            element: document.getElementById('start-date'),
            elementEnd: document.getElementById('end-date'),
            singleMode: false,
            allowRepick: true,
            buttonText: {
                previousMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"
                fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,

                nextMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"
                fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
            },
        }));
    });
    function search_rfi()
    {}
  </script>
  <script>
 // @formatter:off
        document.addEventListener("DOMContentLoaded", function () {
            window.Litepicker && (new Litepicker({
                element: document.getElementById('submission_date'),
                elementEnd: document.getElementById('submission_date'),
                singleMode: false,
                allowRepick: true,
                buttonText: {
                    previousMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
        stroke-linecap="round" stroke-linejoin="round"><path stroke="none"
        d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
                    nextMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
        stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"
        fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
                },
            })).DateTime();
        });
        // @formatter:on
      </script>

