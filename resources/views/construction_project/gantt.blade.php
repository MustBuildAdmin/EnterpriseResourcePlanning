@include('new_layouts.header')
{{-- @extends('layouts.admin') --}}
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/js/dhtmlxgantt.js?v=7.0.11') }}"></script>
<link href="{{ asset('assets/js/css/skins/dhtmlxgantt_material.css?v=7.0.11') }}" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('assets/js/gantt/codebase/skins/dhtmlxgantt_material.css?v=7.0.11') }}">
<link rel="stylesheet" href="{{ asset('assets/js/gantt/common/controls_styles.css?v=7.0.11') }}">
<script src="https://export.dhtmlx.com/gantt/api.js?v=7.0.11"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto:regular,medium,thin,bold">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js?v=7.0.11"></script>
<script src="{{ asset('assets/js/js/zoomingConfig.js') }}"></script>
<script src="{{ asset('assets/js/js/criticalPath.js') }}"></script>
<script src="{{ asset('assets/js/js/overlay.js') }}"></script>
<script src="{{ asset('assets/js/js/export.js') }}"></script>
<script src="{{ asset('assets/js/js/lightBox.js') }}"></script>
<script src="{{ asset('assets/js/js/expandAndCollapse.js') }}"></script>
<script src="{{ asset('assets/js/js/taskPostion.js') }}"></script>
<script src="{{ asset('assets/js/js/slack.js') }}"></script>
<script src="{{ asset('assets/js/js/dynamicProgress.js') }}"></script>
<script src="{{ asset('assets/js/js/taskText.js') }}"></script>
<script src="{{ asset('assets/js/js/highlight.js') }}"></script>
<script src="{{ asset('assets/js/js/slackrow.js') }}"></script>
<style>
    .gantt_task_line.gantt_critical_task .gantt_task_content {
        color: red !important;
    }

    html,
    body,
    .gantt-container {
        height: 100%;
        padding: 0px;
        margin: 0px;
        overflow: hidden;
        background: #fff;
    }

    .status_line {
        background-color: #0ca30a;
    }

    .gantt_task_cell.week_end {
        background-color: #EFF5FD;
    }

    .gantt_cal_light {
        height: 313px !important;
    }

    .gantt_task_row.gantt_selected .gantt_task_cell.week_end {
        background-color: #F8EC9C;
    }

    .gantt_grid .gantt_grid_scale .gantt_grid_head_cell {
        font-size: 13px;
        color: rgba(0, 0, 0, .54);
        border: none;
        text-transform: capitalize;
        font-weight: 600;
    }

    .gantt_task .gantt_task_scale .gantt_scale_cell {
        font-size: 12px;
    }

    .gantt_grid_data .gantt_cell {
        font-size: 11px;
    }

    .gantt_task_line.gantt_project {
        background-color: #25c684;
        border-color: #25c684;
    }

    .gantt_task_line {
        background-color: #4e6da0;
        border: 1px solid #4e6da0;

    }

    .gantt_cal_light>.gantt_cal_ltitle {
        font-size: 13px !important;
    }

    /* // overlay */
    .gantt_marker {
        background-color: rgba(255, 0, 0, 0.8);
    }

    .gantt_task_line,
    .gantt_task_link {
        transition: opacity 200ms;
    }

    .overlay_visible .gantt_task_line,
    .overlay_visible .gantt_task_link {
        opacity: 0.6;
    }

    .gantt_marker.today {
        background: #ffb121;
    }

    /* // overlay end */
    /* // link style */

    .gantt_task_link.start_to_start .gantt_line_wrapper div {
        background-color: #dd5640;
    }

    .gantt_task_link.start_to_start:hover .gantt_line_wrapper div {
        box-shadow: 0 0 5px 0px #dd5640;
    }

    .gantt_task_link.start_to_start .gantt_link_arrow_right {
        border-left-color: #dd5640;
    }

    .gantt_task_link.finish_to_start .gantt_line_wrapper div {
        background-color: #7576ba;
    }

    .gantt_task_link.finish_to_start:hover .gantt_line_wrapper div {
        box-shadow: 0 0 5px 0px #7576ba;
    }

    .gantt_task_link.finish_to_start .gantt_link_arrow_right {
        border-left-color: #7576ba;
    }

    .gantt_task_link.finish_to_finish .gantt_line_wrapper div {
        background-color: #55d822;
    }

    .gantt_task_link.finish_to_finish:hover .gantt_line_wrapper div {
        box-shadow: 0 0 5px 0px #55d822;
    }

    .gantt_task_link.finish_to_finish .gantt_link_arrow_left {
        border-right-color: #55d822;
    }

    /*
    // link style end */

    /* // progress text  */
    .gantt_task_progress {
        text-align: left;
        padding-left: 10px;
        box-sizing: border-box;
        color: #181717;
        /* background-color: #fdfffdb8; */
        font-weight: bold;
    }


    /* // progress tect end */

    /* highlight  */
    .drag_date {
        color: #454545;
        font-size: 13px;
        text-align: center;
        z-index: 1;
    }

    .drag_date.drag_move_start {
        margin-left: -15px;
    }

    .drag_date.drag_move_end {
        margin-left: 15px;
    }

    .drag_move_vertical,
    .drag_move_horizontal {
        background-color: #9DE19E;
        opacity: 0.7;
        box-sizing: border-box;
    }

    .drag_move_vertical {
        border-right: 1px #6AC666 solid;
        border-left: 1px #6AC666 solid;
    }

    .drag_move_horizontal {
        border-top: 1px #6AC666 solid;
        border-bottom: 1px #6AC666 solid;
    }

    /* hightlight end*/

    /* slack :start */
    .gantt_task_cell.week_end {
        background-color: #EFF5FD;
    }

    .gantt_task_row.gantt_selected .gantt_task_cell.week_end {
        background-color: #F8EC9C;
    }

    .slack {
        position: absolute;
        border-radius: 0;
        opacity: 0.7;

        border: none;
        border-right: 1px solid #b6b6b6;
        margin-left: -2px;
        background: #b6b6b6;
        background: repeating-linear-gradient(45deg, #FFFFFF,
                #FFFFFF 5px,
                #b6b6b6 5px,
                #b6b6b6 10px);
    }

    /* slack end */
</style>
<style>
    .gantt_grid_data {
        overflow: auto !important;
    }

    .normal {
        border: 2px solid green;
    }

    .low {
        border: 2px solid yellow;
    }

    .custom_row {
        background: rgb(245, 248, 245);
    }

    .gantt_control {
        display: flex;
        flex-direction: row;
        justify-content: space-evenly;
    }

    .gantt_control input,
    .gantt_control button {
        background: white;
        border-radius: 2px;
        border: none;
    }

    html,
    body {
        height: 100%;
        font-family: 'Open Sans', sans-serif !important;
    }

    .main-content {
        height: 600px;
        height: calc(100vh - 50px);
    }

    .gantt_cal_light {
        height: 440px !important;
        width: 42% !important;
    }

    .gantt_control {
        height: 50px;
        padding: 10px;
        width: 100%;
        background-color: rgb(169, 22, 214);
        display: block;
        color: rgb(99, 17, 175);
    }

    .gantt_task_progress {
        text-align: left;
        padding-left: 10px;
        box-sizing: border-box;
        color: white;
        font-weight: bold;
    }

    textarea.editor_description {
        max-width: 100%;
        height: 100px !important;
    }

    .gantt_cal_larea {
        height: 84% !important;
        overflow: visible;
    }

    .gantt_cal_chosen,
    .gantt_cal_chosen select {
        width: 400px;
    }


    .freezebtn {
        margin-right: 5px;
    }

    .gantt-fullscreen {
        position: absolute;
        bottom: 20px;
        right: 20px;
        width: 30px;
        height: 30px;
        padding: 2px;
        font-size: 32px;
        background: transparent;
        cursor: pointer;
        opacity: 0.5;
        text-align: center;
        -webkit-transition: background-color 0.5s, opacity 0.5s;
        transition: background-color 0.5s, opacity 0.5s;
    }

    .gantt-fullscreen:hover {
        background: rgba(150, 150, 150, 0.5);
        opacity: 1;
    }

    .gantt_task_cell.week_end {
        background-color: #d6d6d6;
    }

    .gantt_task_row.gantt_selected .gantt_task_cell.week_end {
        background-color: #d6d6d6;
    }
</style>
@php
    $holidays = [];

    foreach ($project_holidays as $key => $value) {
        // $time = strtotime($value->date);
        $holidays[] = date('Y,m,d', strtotime($value->date));
    }

    $holidays = implode(':', $holidays);
@endphp
@include('construction_project.side-menu')
{{-- @include('construction_project.side-menu',['hrm_header' => "Gantt Chart"]) --}}
{{ Form::open(['route' => ['projects.freeze_status'], 'method' => 'POST', 'id' => 'gantt_chart_submit']) }}

{{ Form::hidden('project_id', $project->id, ['class' => 'form-control']) }}
<button class="btn btn-sm btn-outline-primary freeze_button" style='width: 100%;' data-bs-toggle="tooltip"
    title="{{ __('Click to change Set Baseline status') }}" data-original-title="{{ __('Confirm your Planning') }}"
    data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
    data-confirm-yes="document.getElementById('delete-form-{{ $project->id }}').submit();">
    {{-- <i class="fa fa-lock" aria-hidden="true" style='margin-right: 5px;'></i> Freeze --}}
    Set Baseline
</button>
{!! Form::close() !!}
<div id="additional_elements" class="gantt-container">
    <div class="btn-group w-100">
        <button class="btn btn-sm  btn-outline-primary action w-20" name="undo" title="undo" aria-current="page">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-back-up" width="24"
                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M9 14l-4 -4l4 -4"></path>
                <path d="M5 10h11a4 4 0 1 1 0 8h-1"></path>
            </svg></button>
        <button class="btn btn-sm  btn-outline-primary action w-20" title="redo" name="redo">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-back" width="24"
                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1"></path>
            </svg></button>
        <button class="btn btn-sm  btn-outline-primary action w-20" title="Indent" name="indent">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-indent-increase" width="24"
                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M20 6l-11 0"></path>
                <path d="M20 12l-7 0"></path>
                <path d="M20 18l-11 0"></path>
                <path d="M4 8l4 4l-4 4"></path>
            </svg>
        </button>
        <button class="btn btn-sm  btn-outline-primary action w-20" name="outdent" title="Outdent">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-indent-decrease" width="24"
                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M20 6l-7 0"></path>
                <path d="M20 12l-9 0"></path>
                <path d="M20 18l-7 0"></path>
                <path d="M8 8l-4 4l4 4"></path>
            </svg></button>

        <button class="btn btn-sm  btn-outline-primary w-20" title="show slack" onclick="toggleSlack(this)">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chart-line" width="24"
                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M4 19l16 0"></path>
                <path d="M4 15l4 -6l4 2l4 -5l4 4"></path>
            </svg></button>
        <button class="btn btn-sm  btn-outline-primary w-20" onclick="toggleOverlay();">Overlay</button>
        <button id="toggle_fullscreen" class="btn btn-sm  btn-outline-primary w-20" title="fullscreen"
            onclick="gantt.ext.fullscreen.toggle();"><svg xmlns="http://www.w3.org/2000/svg"
                class="icon icon-tabler icon-tabler-arrows-maximize" width="24" height="24"
                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M16 4l4 0l0 4"></path>
                <path d="M14 10l6 -6"></path>
                <path d="M8 20l-4 0l0 -4"></path>
                <path d="M4 20l6 -6"></path>
                <path d="M16 20l4 0l0 -4"></path>
                <path d="M14 14l6 6"></path>
                <path d="M8 4l-4 0l0 4"></path>
                <path d="M4 4l6 6"></path>
            </svg></button>
        <button id="toggle_fullscreen" class="btn btn-sm  btn-outline-primary w-20" title="Collaspe All"
            onclick="closeAll()">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-bar-to-up"
                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12 10l0 10"></path>
                <path d="M12 10l4 4"></path>
                <path d="M12 10l-4 4"></path>
                <path d="M4 4l16 0"></path>
            </svg>
        </button>
        <button id="toggle_fullscreen" class="btn btn-sm  btn-outline-primary w-20" title="Expand All"
            onclick="openAll()">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-bar-to-down"
                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M4 20l16 0"></path>
                <path d="M12 14l0 -10"></path>
                <path d="M12 14l4 -4"></path>
                <path d="M12 14l-4 -4"></path>
            </svg>
        </button>

        <button class="btn btn-sm  btn-outline-primary w-20" onclick="updateCriticalPath(this)">Show
            Critical
            Path</button>
        <select class="form-control" id="zoomscale" style='width:13%;'>
            <option value="">Select Timescale</option>
            <option value="day">day</option>
            <option value="week">week</option>
            <option value="month">month</option>
            <option value="quarter">quarter</option>
            <option value="year">year</option>
        </select>
        <button class="btn btn-sm  btn-outline-primary w-20" onclick="toggleChart()">Toggle
            Main</button>
        <button class="btn btn-sm  btn-outline-primary w-20" type="button"
            onclick='gantt.exportToExcel({ callback:show_result })'>Export to
            Excel</button>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card card-stats border-0" id="myCover">
                @if ($project)
                    <input type='hidden' value='0' id='project_id'>
                    <div class="card-body" style='max-height:512px;overflow:auto;'>
                        <div id="gantt_here" style='width:100%; height:491px; position: relative;'
                            onload="script();">
                        </div>
                    </div>
                @else
                    <h1>404</h1>
                    <div class="page-description">
                        {{ __('Page Not Found') }}

                        @if ($project)
                            <input type='hidden' value='0' id='project_id'>
                            <div class="card-body" style='max-height:491px;overflow:auto;'>
                                <div class="gantt_control">

                                </div>
                                <div id="gantt_here"
                                    style='width:100%; height:677px; position: relative;'onload="script();"></div>
                            </div>
                        @else
                            <h1>404</h1>
                            <div class="page-description">
                                {{ __('Page Not Found') }}
                            </div>
                            <div class="page-search">
                                <p class="text-muted mt-3">
                                    {{ __("It's looking like you may have taken a wrong turn. Don't worry...") }}
                                </p>
                                <div class="mt-3">
                                    <a class="btn-return-home badge-blue" href="{{ route('home') }}"><i
                                            class="ti ti-reply"></i> {{ __('Return Home') }}</a>
                                </div>
                            </div>
                        @endif
                    </div>

            </div>
            <div class="page-search">
                <p class="text-muted mt-3">
                    {{ __("It's looking like you may have taken a wrong turn. Don't worry...") }}
                </p>
                <div class="mt-3">
                    <a class="btn-return-home badge-blue" href="{{ route('home') }}">
                        <i class="ti ti-reply"></i> {{ __('Return Home') }}
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

</div>
</div>
<input type='hidden' id='weekends' value='{{ $project->non_working_days }}'>
<input type='hidden' id='holidays' value='{{ $holidays }}'>

@include('new_layouts.footer')

<script type="text/javascript">
    // check freeze status
    $(document).ready(function() {

        // check freeze status

        var tempcsrf = '{!! csrf_token() !!}';
        $.post("{{ route('projects.get_freeze_status') }}", {
                _token: tempcsrf,
                project_id: {{ $project->id }}
            },
            function(resp, textStatus, jqXHR) {

                if (resp == '1') {
                    gantt.config.readonly = true;
                    $('.freeze_button').addClass('disabled');
                } else {
                    gantt.config.readonly = false;
                    $('.freeze_button').removeClass('disabled');
                }

            });

        // check freeze status

        // check gantt task count
        var tempcsrf1 = '{!! csrf_token() !!}';
        $.post("{{ route('projects.get_gantt_task_count') }}", {
                _token: tempcsrf1,
                project_id: {{ $project->id }}
            },
            function(resp, textStatus, jqXHR) {
                console.log(resp, "resprespresp")
                if (resp == 0) {
                    $('.freeze_button').addClass('disabled');
                }
                // if(resp=='1'){
                //     gantt.config.readonly = true;
                //     $('.freeze_button').addClass('disabled');
                // }
                // else{
                //     gantt.config.readonly = false;
                //     $('.freeze_button').removeClass('disabled');
                // }

            });

        // check gantt task count

        //zoom

        var selectOption = document.getElementById("zoomscale");
        selectOption.onchange = function(event) {
            gantt.ext.zoom.setLevel(event.target.value)
        }


        //task position
        var els = document.getElementsByClassName("action");
        for (var i = 0; i < els.length; i++) {
            els[i].onclick = function() {
                console.log(els[i])
                gantt.performAction(this.name)
            }
        }


        gantt.templates.rightside_text = function(start, end, task) {
            if (task.type == gantt.config.types.milestone) {
                return task.text;
            }
            return "";
        };

        function get_editon_multiselect() {
            set_data = "";
            $.ajax({
                url: '{{ route('projects.get_member') }}',
                type: 'GET',
                async: false,
                data: {
                    'project_id': "<?php echo $project->id; ?>"
                },
                success: function(data) {
                    set_data = data;
                }
            });

            return set_data;
        }

        gantt.i18n.setLocale({
            labels: {
                time_enable_button: 'Schedule',
                time_disable_button: 'Unschedule',
            }
        });


        gantt.config.open_tree_initially = true;

        gantt.plugins({
            quick_info: false,
            tooltip: false,
            multiselect: true,
            undo: true,
            fullscreen: true,
            drag_timeline: true,
            critical_path: true,
            keyboard_navigation: true,
            auto_scheduling: true
        });


        gantt.ext.fullscreen.getFullscreenElement = function() {
            return document.getElementById("additional_elements");
        }
        gantt.config.date_format = "%Y-%m-%d %H:%i";
        gantt.config.auto_scheduling = true;
        gantt.config.auto_scheduling_strict = true;
        gantt.config.auto_scheduling_compatibility = true;

        var dateToStr = gantt.date.date_to_str(gantt.config.task_date);
        var today = new Date();
        // gantt.addMarker({
        // 	start_date: today,
        // 	css: "today",
        // 	text: "Today",
        // 	title: "Today: " + dateToStr(today)
        // });

        // var start = new Date();
        // gantt.addMarker({
        // 	start_date: start,
        // 	css: "status_line",
        // 	text: "Start project",
        // 	title: "Start project: " + dateToStr(start)
        // });
        gantt.config.scale_height = 50;
        gantt.templates.task_class = gantt.templates.grid_row_class = gantt.templates.task_row_class = function(
            start, end, task) {
            if (gantt.isSelectedTask(task.id))
                return "gantt_selected";
        };

        var formatter = gantt.ext.formatters.durationFormatter({
            enter: "day",
            store: "day",
            format: "auto"
        });
        var linksFormatter = gantt.ext.formatters.linkFormatter({
            durationFormatter: formatter
        });

        var editors = {
            text: {
                type: "text",
                map_to: "text"
            },
            start_date: {
                type: "date",
                map_to: "start_date",
            },
            end_date: {
                type: "date",
                map_to: "end_date",
            },
            duration: {
                type: "duration",
                map_to: "duration",
                min: 0,
                max: 100,
                formatter: formatter
            },
            priority: {
                type: "select",
                map_to: "priority",
                options: gantt.serverList("priority")
            },
            predecessors: {
                type: "predecessor",
                map_to: "auto",
                formatter: linksFormatter
            }
        };

        gantt.config.reorder_grid_columns = true;
        gantt.config.columns = [{
                name: "wbs",
                label: "#",
                width: 60,
                align: "center",
                template: gantt.getWBSCode,
                tree: true,
                resize: true
            },
            {
                name: "text",
                label: "Task Name",
                width: 150,
                resize: true
            },
            {
                name: "start_date",
                label: "Start Date",
                width: 80,
                align: "center",
                resize: true
            },
            {
                name: "end_date",
                label: "End Date",
                width: 80,
                align: "center",
                resize: true
            },
            {
                name: "duration",
                label: "Duration",
                width: 80,
                align: "center",
                resize: true
            },
            {
                name: "predecessors",
                label: "Predecessors",
                width: 110,
                align: "left",
                editor: editors.predecessors,
                resize: true,
                template: function(task) {
                    var links = task.$target;
                    var labels = [];
                    for (var i = 0; i < links.length; i++) {
                        var link = gantt.getLink(links[i]);
                        labels.push(linksFormatter.format(link));
                    }
                    return labels.join(", ")
                }
            },
            freeSlackColumn,
            {
                name: "add"
            }
        ];

        gantt.config.scale_height = 20 * 2;
        gantt.config.min_column_width = 50;
        gantt.config.scales = [{
                unit: "month",
                step: 1,
                date: "%M, %Y"
            },
            {
                unit: "day",
                step: 1,
                date: "%d %M"
            }
        ];

        gantt.config.layout = {
            css: "gantt_container",
            cols: [{
                    width: 680,
                    min_width: 300,
                    rows: [{
                            view: "grid",
                            scrollX: "gridScroll",
                            scrollable: true,
                            scrollY: "scrollVer"
                        },
                        {
                            view: "scrollbar",
                            id: "gridScroll",
                            group: "horizontal"
                        }
                    ]
                },
                {
                    resizer: true,
                    width: 1
                },
                {
                    rows: [{
                            view: "timeline",
                            scrollX: "scrollHor",
                            scrollY: "scrollVer"
                        },
                        {
                            view: "scrollbar",
                            id: "scrollHor",
                            group: "horizontal"
                        }
                    ]
                },
                {
                    view: "scrollbar",
                    id: "scrollVer"
                }
            ]
        };

        gantt.attachEvent("onParse", function() {
            gantt.eachTask(function(task) {
                // fill 'task.user' field with random data
                task.user = Math.round(Math.random() * 3);
                //
                if (gantt.hasChild(task.id))
                    task.type = gantt.config.types.project
            });
        });


        // scale length end
        gantt.templates.task_class = function(start, end, task) {
            if (task.type == gantt.config.types.project)
                return "hide_project_progress_drag";
        };

        // ###############################################
        var weekScaleTemplate = function(date) {
            var dateToStr = gantt.date.date_to_str("%d %M");
            var weekNum = gantt.date.date_to_str("(week %W)");
            var endDate = gantt.date.add(gantt.date.add(date, 1, "week"), -1, "day");
            return dateToStr(date) + " - " + dateToStr(endDate) + " " + weekNum(date);
        };

        gantt.templates.timeline_cell_class = function(task, date) {
            if (!gantt.isWorkTime(date))
                return "week_end";
            return "";
        };
        // progress name
        gantt.templates.progress_text = function(start, end, task) {
            return "<span style='text-align:left;'>" + Math.round(task.progress) + "% </span>";
        };

        // progress end
        gantt.attachEvent("onBeforeAutoSchedule", function() {
            // gantt.message("Recalculating project schedule...");
            return true;
        });


        var task_sections = [{
                name: "description",
                height: 200,
                map_to: "text",
                type: "my_editor",
                focus: true
            },
            {
                name: "users",
                height: 80,
                type: "multiselect",
                options: gantt.serverList("people"),
                map_to: "users"
            },
            {
                name: "time",
                height: 72,
                type: "duration",
                map_to: "auto"
            }
        ];




        gantt.attachEvent("onBeforeLightbox", function(id) {
            var task = gantt.getTask(id);
            if (task.type === "project") {
                return false;
            } else if (task.type === "task") {
                console.log(task.type)
                gantt.config.lightbox.sections = task_sections;
                return true;
            }

        });



        // holidays end
        gantt.config.bar_height = 100;
        gantt.init("gantt_here");
        set_data = "";
        gantt.form_blocks["my_editor"] = {
            render: function(sns) {
                get_data = get_editon_multiselect();
                set_data = get_data['1'];
                return set_data;
            },
            set_value: function(node, value, task) {
                node.querySelector(".editor_description").value = value || "";
            },
            get_value: function(node, task) {
                return node.querySelector(".editor_description").value;
            },
            focus: function(node) {
                var a = node.querySelector(".editor_description");
                a.select();
                a.focus();
            }
        };

        gantt.form_blocks["multiselect"] = {
            render: function(sns) {
                var height = (sns.height || "50") + "px";
                var html =
                    "<div class='gantt_cal_ltext gantt_cal_chosen gantt_cal_multiselect' style='height:" +
                    height + ";'><select data-placeholder='...' class='chosen-select' multiple>";
                if (sns.options) {
                    multi_data = get_editon_multiselect();
                    $.each(multi_data['0'], function(multi_key, multi_value) {
                        html += "<option value=" + multi_value.key + ">" + multi_value.label +
                            "</option>";
                    });
                }
                html += "</select></div>";
                return html;
            },
            set_value: function(node, value, ev, sns) {
                console.log("value", value);
                node.style.overflow = "visible";
                node.parentNode.style.overflow = "visible";
                node.style.display = "inline-block";
                var select = $(node.firstChild);

                if (value) {
                    if (value != '') {
                        value = $.parseJSON(value);
                    }
                    select.val([]);
                    select.val(value);
                } else {
                    select.val([]);
                }

                select.chosen();
                if (sns.onchange) {
                    select.change(function() {
                        sns.onchange.call(this);
                    })
                }
                select.trigger('chosen:updated');
                select.trigger("change");
            },
            get_value: function(node, ev) {
                var value = $(node.firstChild).val();
                return value;
            },
            focus: function(node) {
                $(node.firstChild).focus();
            }
        };

        gantt.locale.labels.section_users = "Users";

        function findUser(id) {
            var list = gantt.serverList("people");
            for (var i = 0; i < list.length; i++) {
                if (list[i].key == id) {
                    return list[i];
                }
            }
            return null;
        }

        gantt.load("{{ route('projects.gantt_data', [$project->id]) }}");


        // holidays
        gantt.config.work_time = true;
        gantt.config.auto_types = true;
        var weekend_list = $('#weekends').val();
        var result = [0, 1, 2, 3, 4, 5, 6];
        result.forEach(element => {
            if (weekend_list.includes(element)) {
                gantt.setWorkTime({
                    day: element,
                    hours: false
                });
            } else {
                gantt.setWorkTime({
                    day: element,
                    hours: ["8:00-17:00"]
                });
            }

        });
        // ## holidays  ######
        var holidays = [];
        var holidays_list = $('#holidays').val();
        if (holidays_list != '') {
            var result2 = holidays_list.split(':');
            result2.forEach(element => {
                holidays.push(new Date(element));
            });
            for (var i = 0; i < holidays.length; i++) {
                gantt.setWorkTime({
                    date: holidays[i],
                    hours: false
                });
            }

            var dateToStr = gantt.date.date_to_str("%d %F");
        }
        var dp = new gantt.dataProcessor("https://erptest.mustbuildapp.com/");
        dp.init(gantt);
        dp.setTransactionMode({
            mode: "REST",
            payload: {
                "_token": tempcsrf,
            }
        });
        dp.attachEvent("onBeforeUpdate", function(id, state, data) {
            gantt.config.readonly = true;
            return true;
        });
        dp.attachEvent("onAfterUpdate", function(id, action, tid, response) {
            gantt.config.readonly = false;
            if (action == "inserted") {
                gantt.showLightbox(tid);
            }
        });

        gantt.templates.link_class = function(link) {
            var types = gantt.config.links;
            switch (link.type) {
                case types.finish_to_start:
                    return "finish_to_start";
                    break;
                case types.start_to_start:
                    return "start_to_start";
                    break;
                case types.finish_to_finish:
                    return "finish_to_finish";
                    break;
            }
        };
    });
</script>
