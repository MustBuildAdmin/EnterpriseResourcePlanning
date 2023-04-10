@include('new_layouts.header')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-x">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Construction
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page body -->
@include('construction_project.side-menu')
                        <div class="col d-flex flex-column">
                            <div class="card-body">
                                <h2 class="mb-4">Task calendar</h2>
                                <div class="card-body">
                                    <div id='calendar' class='calendar'></div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('new_layouts.footer')

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
               
            events:[
                @foreach ($con_task as $list)
                    {
                        title: '{!! $list->text !!}',
                        start: '{!! $list->start_date !!}',
                        end: '{!! $list->end_date !!}',
                      
                    },
                @endforeach
            ],
            eventColor: '#6fd943',
            });
            calendar.render();
        })();
    </script>
@endpush
