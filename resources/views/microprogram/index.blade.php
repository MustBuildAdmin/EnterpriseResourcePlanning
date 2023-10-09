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
                                        <th scope="col">{{ __('Schedule Name') }}</th>
                                        <th scope="col">{{ __('Schedule Duration') }}</th>
                                        <th scope="col">{{ __('Schedule Start Date') }}</th>
                                        <th scope="col">{{ __('Schedule End Date') }}</th>
                                        <th scope="col">{{ __('Schedule Goals') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach ($MicroProgramScheduleModal as $microSchedule)
                                        <tr>
                                            <td> <a href="{{route('schedule_task_show',['id'=>$microSchedule->id])}}">{{$microSchedule->schedule_name}}</a></td>
                                            <td>{{$microSchedule->schedule_duration}}</td>
                                            <td>
                                                {{ Utility::site_date_format($microSchedule->schedule_start_date,
                                                \Auth::user()->id) }}
                                            </td>
                                            <td>
                                                {{ Utility::site_date_format($microSchedule->schedule_end_date,
                                                \Auth::user()->id) }}
                                            </td>
                                            <td>{{$microSchedule->schedule_goals}}</td>
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

@include('new_layouts.footer')
<script src="{{ asset('datatable/jquery.dataTables.min.js') }}"></script>
<script>
    new DataTable('#schedule_table', {
        pagingType: 'full_numbers',
        aaSorting: []
    });
</script>
