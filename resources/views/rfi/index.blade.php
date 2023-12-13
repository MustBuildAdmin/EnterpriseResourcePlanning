@include('new_layouts.header')
<style>
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
            <!-- Modal comes here -->
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
                            <!-- for each -->
                            <tbody>
                                <tr>
                                    <td style="width: 100px; font-size: 15px;">{{"RFI_123"}}</td>
                                    <td style="width: 100px; font-size: 15px;">{{"Jan 12"}}</td>
                                    <td style="width: 100px; font-size: 15px;">{{"User"}}</td>
                                    <td style="width: 100px; font-size: 15px;">{{"High"}}</td>
                                </tr>
                            <!-- end for each -->
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

