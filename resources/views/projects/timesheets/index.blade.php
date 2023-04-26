@extends('layouts.admin')

@section('page-title')
    {{$project->project_name.__("'s Timesheet")}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('projects.index')}}">{{__('Project')}}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('projects.show',$project->id) }}">{{ucwords($project->project_name)}}</a></li>
    <li class="breadcrumb-item">{{__('Timesheet')}}</li>
@endsection

@section('action-button')
    <a href="{{ route('projects.show',$project->id) }}" class="btn btn-xs btn-white btn-icon-only width-auto">
        <span class="btn-inner--icon"><i class="ti ti-arrow-left"></i>{{__('Back')}}</span>
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 weekly-dates-div pt-1">
                            <a href="#" class="action-item previous"><i class="ti ti-arrow-left"></i></a>
                            <span class="weekly-dates"></span>
                            <input type="hidden" id="weeknumber" value="0">
                            <input type="hidden" id="selected_dates">
                            <a href="#" class="action-item next"><i class="ti ti-arrow-right"></i></a>
                        </div>

                        @can('create timesheet')
                            <div class="col text-end project_tasks_select">
                                <div class="dropdown btn btn-sm p-0">
                                    <a class=" btn btn-primary add-small " role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <i class="ti ti-plus mr-2"></i>{{__('Add Task on Timesheet')}}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right tasks-box" x-placement="bottom-end">
                                        <div class="scrollbar-inner">
                                            <div class="mh-280">
                                                <div class="tasks-list"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
                <div class="card-wrapper project-timesheet overflow-auto"></div>
                <div class="text-center notfound-timesheet">
                    <div class="empty-project-text text-center p-3 min-h-300">
                        <h5 class="pt-5">{{ __("We couldn't find any data") }}</h5>
                        <p class="m-0">{{ __("Sorry we can't find any timesheet records on this week.") }}</p>
                        <p class="m-0">{{ __("To add timesheet record go to Add Task on Timesheet") }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css-page')
    <style type="text/css">
        .task-name{
            padding: 1.5rem 1.5rem !important;
        }



        .table thead th {
            border-bottom: 1px solid #000 !important;

            background: #fff !important;
        }

        .day-time, .total-value, .value {
            /* display: inline-block; */
            border: 1px solid #000 !important;
            /* padding: 3px 19px !important;*/
            border-radius: 30px !important;
            width: 80px !important;
            text-align: center !important;
        }
    </style>
@endpush
@push('script-page')
    <script>
        function ajaxFilterTimesheetTableView() {
            var mainEle = $('.project-timesheet');
            var notfound = $('.notfound-timesheet');
            var week = parseInt($('#weeknumber').val());
            var project_id = '{{ $project->id }}';
            var isowner = '';
            var data = {
                week: week,
                project_id: project_id,
            }



            $.ajax({
                url: '{{ route('filter.timesheet.table.view') }}',
                data: data,
                success: function (data) {

                    // console.log(data);
                    $('.weekly-dates-div .weekly-dates').text(data.onewWeekDate);
                    $('.weekly-dates-div #selected_dates').val(data.selectedDate);

                    $('.project_tasks_select .tasks-list .dropdown-item').remove();

                    $.each(data.sectiontasks, function (i, item) {

                        var optionhtml = '';

                        if (item.section_id != 0 && item.section_name != '' && item.tasks.length > 0) {
                            optionhtml += `<a href="#" class="dropdown-item select-sub-heading" data-tasks-count="` + item.tasks.length + `">` + item.section_name + `</a>`;
                        }
                        $.each(item.tasks, function (ji, jitem) {
                            optionhtml += `<a href="#" class="dropdown-item select-task" data-task-id="` + jitem.task_id + `">` + jitem.task_name + `</a>`;
                        });
                        $('.project_tasks_select .tasks-list').append(optionhtml);
                    });

                    if (data.totalrecords == 0) {
                        mainEle.hide();
                        notfound.css('display', 'block');
                    } else {
                        notfound.hide();
                        mainEle.show();
                    }
                    mainEle.html(data.html);
                }
            });
        }

        $(function () {
            ajaxFilterTimesheetTableView();
        });

        $(document).on('click', '.weekly-dates-div .action-item', function () {
            var weeknumber = parseInt($('#weeknumber').val());
            if ($(this).hasClass('previous')) {
                weeknumber--;
                $('#weeknumber').val(weeknumber);
            } else if ($(this).hasClass('next')) {
                weeknumber++;
                $('#weeknumber').val(weeknumber);
            }
            ajaxFilterTimesheetTableView();
        });

        $(document).on('click', '[data-ajax-timesheet-popup="true"]', function (e) {
            e.preventDefault();

            var data = {};
            var url = $(this).data('url');
            var type = $(this).data('type');
            var date = $(this).data('date');
            var task_id = $(this).data('task-id');
            var user_id = $(this).data('user-id');

            data.date = date;
            data.task_id = task_id;

            if (user_id != undefined) {
                data.user_id = user_id;
            }
            if (type == 'create') {
                var title = '{{ __("Create Timesheet") }}';
                data.project_id = '{{ $project->id }}';
            } else if (type == 'edit') {
                var title = '{{ __("Edit Timesheet") }}';
            }

            $("#commonModal .modal-title").html(title + ` <small>(` + moment(date).format("ddd, Do MMM YYYY") + `)</small>`);
            $.ajax({
                url: url,
                data: data,
                dataType: 'html',
                success: function (data) {
                    $('#commonModal .body').html(data);
                    $('#commonModal').modal('show');

                    if ($('#date').length > 0) {
                        $('#date').daterangepicker({
                            singleDatePicker: true,
                            locale: {
                                format: 'YYYY-MM-DD'
                            }
                        });
                    }

                    $('#commonModal').modal({backdrop: 'static', keyboard: false});
                }
            });
        });

        $('.project_tasks_select .tasks-box').on('click', '.select-task', function (e) {
            e.preventDefault();
            e.stopPropagation();

            var mainEle = $('.project-timesheet');
            var notfound = $('.notfound-timesheet');

            var task_id = $(this).attr('data-task-id');
            var selected_dates = $('#selected_dates').val();

            $.ajax({
                url: '{{route('append.timesheet.task.html')}}',
                data: {
                    project_id: '{{ $project->id }}',
                    task_id: task_id,
                    selected_dates: selected_dates,
                },
                success: function (data) {
                    notfound.hide();
                    mainEle.show();
                    $('.project-timesheet tbody').append(data.html);
                    $('.project_tasks_select .tasks-list .select-task[data-task-id="' + task_id + '"]').remove();
                }
            });
        });

        $(document).on('change', '#time_hour, #time_minute', function () {

            var hour = $('#time_hour').children("option:selected").val();
            var minute = $('#time_minute').children("option:selected").val();
            var total = $('#totaltasktime').val().split(':');

            if (hour == '00' && minute == '00') {
                $(this).val('');
                return;
            }

            hour = hour != '' ? hour : 0;
            hour = parseInt(hour) + parseInt(total[0]);

            minute = minute != '' ? minute : 0;
            minute = parseInt(minute) + parseInt(total[1]);

            if (minute > 50) {
                minute = minute - 60;
                hour++;
            }

            hour = hour < 10 ? '0' + hour : hour;
            minute = minute < 10 ? '0' + minute : minute;

            $('.display-total-time small').text('{{ __("Total Time worked on this task") }} : ' + hour + ' {{ __("Hours") }} ' + minute + ' {{ __("Minutes") }}');
        });


    </script>
@endpush


