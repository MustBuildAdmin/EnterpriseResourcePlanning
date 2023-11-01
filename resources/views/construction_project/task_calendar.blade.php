@include('new_layouts.header')
{{-- @extends('layouts.admin') --}}
<link rel="stylesheet" href="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.css') }}">
    <div class="page-wrapper">
        <!-- Page header -->

        <!-- Page body -->
@include('construction_project.side-menu',['hrm_header' => "Task calendar"])
                        <div class="col d-flex flex-column">
                            <div class="card-body">
                                <h2 class="mb-4"></h2>
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
<script src="{{ asset('assets/js/plugins/main.min.js') }}"  integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script>
<script src="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.js') }}"  integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script>

<script>
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
