@include('new_layouts.header')
{{-- @extends('layouts.admin') --}}
<link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet"/>
<div class="page-wrapper">
    @include('construction_project.side-menu')
    <div class="container-fluid" id="taskboard_view">
        <div class="p-4">
            <div class="card">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="mb-0">{{ __('Micro Planning Schedule') }}</h1>
                            <div class="card-actions">
                                <a class="btn btn-primary w-100" data-bs-toggle="modal" data-size="xl"
                                    data-url="{{ route('microprogram_create') }}" data-ajax-popup="true"
                                    data-bs-toggle="tooltip" title="{{ __('Create New Sub Contractor') }}"
                                    data-bs-original-title="{{ __('Create a New Schedule') }}">
                                    {{ __('Create a New Schedule') }}
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-vcenter card-table" id="schedule_table" aria-describedby="Sub Task">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('Schedule ID') }}</th>
                                        <th scope="col">{{ __('Schedule Name') }}</th>
                                        <th scope="col">{{ __('Schedule Duration') }}</th>
                                        <th scope="col">{{ __('Schedule Start Date') }}</th>
                                        <th scope="col">{{ __('Schedule End Date') }}</th>
                                        <th scope="col">{{ __('Schedule Status') }}</th>
                                        <th scope="col">{{ __('Schedule Goals') }}</th>
                                        <th scope="col">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @forelse ($MicroProgramScheduleModal as $microSchedule)
                                        <tr>
                                            <td>
                                                @if($microSchedule->active_status == 1)
                                                    <a href="{{route('schedule_task_show',['id'=>$microSchedule->id])}}">
                                                    {{$microSchedule->uid}}</a>
                                                @else
                                                    <a>{{$microSchedule->uid}}</a>
                                                @endif
                                            </td>
                                            <td>
                                                {{$microSchedule->schedule_name}}</a>
                                            </td>
                                            <td>{{$microSchedule->schedule_duration}}</td>
                                            <td>
                                                {{ Utility::site_date_format($microSchedule->schedule_start_date,
                                                \Auth::user()->id) }}
                                            </td>
                                            <td>
                                                {{ Utility::site_date_format($microSchedule->schedule_end_date,
                                                \Auth::user()->id) }}
                                            </td>
                                            <td>
                                                @if($microSchedule->active_status == 1)
                                                    <span class="badge bg-success me-1"></span> Active
                                                @else
                                                    <span class="badge bg-warning me-1"></span> In-schedule
                                                @endif
                                            </td>
                                            <td>{{$microSchedule->schedule_goals}}</td>
                                            <td>
                                                <input type="radio" class="schedule_change" id="schedule_change"
                                                value="{{$microSchedule->id}}"
                                                name="schedule_change"
                                                @if($microSchedule->active_status == 1) checked @endif>

                                                @if($microSchedule->active_status == 1)
                                                    Active
                                                @else
                                                    In-schedule
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                    
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('new_layouts.footer')
<script src="{{ asset('datatable/jquery.dataTables.min.js') }}"></script>
<script>
    new DataTable('#schedule_table', {
        pagingType: 'full_numbers',
        aaSorting: []
    });

    $('.schedule_change').change(function() {
        schedule_data = this.value;

        $.ajax({
            url : '{{route("change_schedule_status")}}',
            type : 'POST',
            data : {
                'schedule_data' : schedule_data,
                '_token' : '{{ csrf_token() }}',
            },
            success : function(data_check) {
                if(data_check == 1){
                    toastr.success("Schedule Status Changed");
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
                else{
                    toastr.error("Somenthing went wrong!");
                }
            },
            error : function(request,error)
            {
                alert("Request: "+JSON.stringify(request));
            }
        });
    });
</script>
