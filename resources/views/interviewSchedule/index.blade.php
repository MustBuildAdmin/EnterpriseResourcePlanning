@extends('layouts.admin')

@section('page-title')
    {{__('Manage Interview Schedule')}}
@endsection
@push('css-page')
{{--    <link rel="stylesheet" href="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.css') }}">--}}
@endpush

@push('script-page')
    <script src="{{ asset('assets/js/plugins/main.min.js') }}"></script>

    <script type="text/javascript">

        (function () {
            var etitle;
            var etype;
            var etypeclass;
            var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridDay,timeGridWeek,dayGridMonth'
                },
                buttonText: {
                    timeGridDay: "{{__('Day')}}",
                    timeGridWeek: "{{__('Week')}}",
                    dayGridMonth: "{{__('Month')}}"
                },
                themeSystem: 'bootstrap',
                initialDate: '{{ $transdate }}',
                slotDuration: '00:10:00',
                navLinks: true,
                droppable: true,
                selectable: true,
                selectMirror: true,
                editable: true,
                dayMaxEvents: true,
                handleWindowResize: true,
                events:{!! $arrSchedule !!},
            });
            calendar.render();
        })();
    </script>

@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Interview Schedule')}}</li>
@endsection


@section('action-btn')
    <div class="float-end">
        @can('create interview schedule')
            <a href="#" data-url="{{ route('interview-schedule.create') }}" data-bs-toggle="tooltip" title="{{__('Create')}}" data-ajax-popup="true" data-title="{{__('Create New Interview Schedule')}}" class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        @endcan
    </div>
@endsection


@section('content')

    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Calendar') }}</h5>
                </div>
                <div class="card-body">
                    <div id='calendar' class='calendar'></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">{{__('Schedule List')}}</h4>
                    <ul class="event-cards list-group list-group-flush mt-3 w-100">
                        <li class="list-group-item card mb-3">
                            <div class="row align-items-center justify-content-between">
                                <div class=" align-items-center">
                                        @if(!$schedules->isEmpty())
                                            @foreach ($schedules as $schedule)
                                                <div class="card mb-3 border shadow-none">
                                                    <div class="px-3">
                                                        <div class="row align-items-center">
                                                            <div class="col ml-n2">
                                                                <h5 class="text-sm mb-0">
                                                                    <a href="#!">{{!empty($schedule->applications) ? !empty($schedule->applications->jobs) ? $schedule->applications->jobs->title : '' : ''}}</a>
                                                                </h5>
                                                                <p class="card-text small text-muted">
                                                                    {{ !empty($schedule->applications)?$schedule->applications->name:'' }}
                                                                </p>
                                                                <p class="card-text small text-muted">
                                                                    {{  \Auth::user()->dateFormat($schedule->date).' '. \Auth::user()->timeFormat($schedule->time) }}
                                                                </p>
                                                            </div>
                                                            <div class="col-auto text-right">
                                                                @can('edit interview schedule')
                                                                    <div class="action-btn bg-primary ms-2">
                                                                        <a href="#" data-url="{{ route('interview-schedule.edit',$schedule->id) }}" data-title="{{__('Edit Interview Schedule')}}" data-ajax-popup="true" class="mx-3 btn btn-sm  align-items-center" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}"><i class="ti ti-pencil text-white"></i></a>
                                                                    </div>
                                                                @endcan
                                                                @can('delete interview schedule')
                                                                        <div class="action-btn bg-danger ms-2">
                                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['interview-schedule.destroy', $schedule->id],'id'=>'delete-form-'.$schedule->id]) !!}
                                                                            <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$schedule->id}}').submit();"><i class="ti ti-trash text-white"></i></a>
                                                                        {!! Form::close() !!}
                                                                        </div>
                                                                @endcan
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="text-center">
                                                {{__('No Interview Scheduled!')}}
                                            </div>
                                        @endif
                                    </div>
                            </div>

                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>


@endsection
