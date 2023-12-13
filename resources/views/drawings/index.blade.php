@include('new_layouts.header')
<style>
.green {
    background-color: #206bc4 !important;
}
.activity-scroll{
  height:700px !important;
}
.mt-5 {
  margin-top : 0px !important
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
          {{Form::open(array('url'=>'drawings','method'=>'post', 'enctype' => 'multipart/form-data'))}}
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Create Drawings Record</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {{ Form::label('name', __('Enter the Reference Number of the Drawing'),['class'=>'form-label',
                        'required'=>'required']) }}<span class="text-danger">*</span>
                      <div class="form-icon-user">
                        {{ Form::text('reference_number', '', array('class' => 'form-control',
                          'required'=>'required')) }}
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <div class="form-label">Choose a Drawing type</div>
                        <select class="form-select" id="drawing_type" name="drawing_type">
                            <option value="">Select a Drawing Type</option>
                            @foreach($drawingTypes as $drawingtype)
                              <option value="{{ $drawingtype->id }}">{{ $drawingtype->drawing_types }}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            {{Form::close()}}
          </div>
        </div>
      </div>
        <div class="card">
            <div class="card-header">
                <h3>Drawings</h3>
                <div class="card-actions">
                    <a href="#" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#modal-large">
                        Create a Drawing Record
                    </a>
                </div>

             </div>
             <div class="card-body">
                <div class="mt-5 card">
                  <div class="card-header">
                     <h3>Drawings List</h3>
                  </div>
                     <div class="card-body">
                      <div class="card-body">

                        <div class="row">
                         <div class="col-md-2 border-end p-3">
                             <form class="drawing_search" >
                             <div class="col-md-12">
                                 <div class="mb-3">
                                  <div class="form-label">Search by Drawing type</div>
                                  <select class="form-select drawing_type" id="drawing_type" name="drawing_type">
                                  <option value="">Search by Overall Drawing Status</option>
                                  @foreach($drawingTypes as $drawingtype)
                                    <option value="{{ $drawingtype->id }}">{{ $drawingtype->drawing_types }}</option>
                                  @endforeach
                                </select>
                                </div>
                              </div>
                              <div class="col-12 mb-3">
                                    <label class="form-label required">Drawing Uploaded From Date</label>
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
                                    <label class="form-label required">Drawing Uploaded To Date</label>
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

                            <div class="col-md-12">
                              <div class="mb-3">
                                <label class="form-label">Search By Referrence Id</label>
                                  <input type="text" id="skill_input" name="ref_id" value="{{ request()->get('q') }}" >
                              </div>
                            </div>
                            <div class="col-12 mt-4">
                             <div class="mb-3">
                                 <button type="submit" class="btn btn-tabler w-100"
                                 onclick="search_drawings()">Search</button>
                               </div>
                            </div>
                         </form>
                         </div>
                         <div class="col-md-10">
                             <div class="table-responsive card p-4">
                                 <table class="table table-vcenter card-table" id="task-table">
                                 <caption>Lists Drawings Index</caption>
                                     <thead>
                                         <tr>
                                           <th>Drawing reference Id</th>
                                           <th>Drawing Type</th>
                                           <th>Updated Date</th>
                                           <th>Created Date</th>
                                         </tr>
                                       </thead>
                                       @foreach ($drawings as $drawing)
                                       <tbody>
                                         <tr>
                                             <td style="width: 100px; font-size: 15px;">
                                             <a href="{{route('drawing.reference.add',[$drawing->drawing_type_id,
                                              $projectid, $drawing->reference_number])}}">
                                             {{ $drawing->reference_number }}
                                               </a></td>
                                             <td style="width:400px; font-size: 14px;">
                                             {{ $drawing->drawing_types }}
                                             </td>
                                             <td style="width:400px; font-size: 14px;">{{ $drawing->created_on }}</td>
                                             <td style="width:400px; font-size: 14px;">{{ $drawing->updated_on }}</td>
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
        $("#skill_input").tokenInput("{{route('drawing_autocomplete')}}", {
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

    function search_drawings()
    {
      drawing_type  = $(".drawing_type").val();
      start_date    = $(".start_date").val();
      end_date      = $(".end_date").val();
      ref_id       = $('input#skill_input').tokenInput('get');

      var myArray = [];
      ref_id.forEach(function(value) {

        myArray.push(value.id);
      });

      $.ajax({
            url : '{{route("drawings.search")}}',
            type : 'GET',
            data : {
                'start_date'  : start_date,
                'end_date'    : end_date,
                'drawing_type' : drawing_type,
                'ref_id' : myArray,
            },
            cache:true,
            success : function(data) {
                if(data['success'] == true){
                    //
                }
                // $(".loader_show_hide").hide();
            },
            error : function(request,error)
            {
                // alert("Request: "+JSON.stringify(request));
            }
        });
    }

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
                            return '<div><span class="dropdown-item-indicator">' + data.customProperties +
                            '</span>' + escape(data.text) + '</div>';
                        }
                        return '<div>' + escape(data.text) + '</div>';
                    },
                    option: function(data,escape){
                        if( data.customProperties ){
                            return '<div><span class="dropdown-item-indicator">' + data.customProperties +
                            '</span>' + escape(data.text) + '</div>';
                        }
                        return '<div>' + escape(data.text) + '</div>';
                    },
                },
            }));
        });
        // @formatter:on
      </script>

