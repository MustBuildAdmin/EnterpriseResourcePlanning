@include('new_layouts.header')
{{-- @extends('layouts.admin') --}}
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{asset('assets/js/js/dhtmlxgantt.js?v=7.0.11')}}"></script>
<link href="{{asset('assets/js/css/skins/dhtmlxgantt_material.css?v=7.0.11')}}" rel="stylesheet">

<link rel="stylesheet" href="{{asset('assets/js/gantt/codebase/skins/dhtmlxgantt_material.css?v=7.0.11')}}">
<link rel="stylesheet" href="{{asset('assets/js/gantt/common/controls_styles.css?v=7.0.11')}}">

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto:regular,medium,thin,bold">
<link rel="stylesheet" href="./css/skins/dhtmlxgantt_material.css?v=7.0.11">

<script src="{{asset('assets/js/js/zoomingConfig.js')}}"></script>
<script src="{{asset('assets/js/js/criticalPath.js')}}"></script>
<script src="{{asset('assets/js/js/lightBox.js')}}"></script>
<script src="{{asset('assets/js/js/expandAndCollapse.js')}}"></script>
<script src="{{asset('assets/js/js/taskPostion.js')}}"></script>
<script src="{{asset('assets/js/js/slack.js')}}"></script>
<script src="{{asset('assets/js/js/dynamicProgress.js')}}"></script>
<script src="{{asset('assets/js/js/taskText.js')}}"></script>


<style>
    html,
    body,
    .gantt-container {
        height: 100%;
        padding: 0px;
        margin: 0px;
        overflow: hidden;
    }

    .status_line {
        background-color: #0ca30a;
    }

    .gantt_task_cell.week_end {
        background-color: #EFF5FD;
    }
    .gantt_cal_light{
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
    .gantt_cal_light >.gantt_cal_ltitle {
         font-size: 13px !important;
    }

</style>

@php
$holidays=array();

foreach ($project_holidays as $key => $value) {
    // $time = strtotime($value->date);
    $holidays[]= date("Y,m,d", strtotime($value->date));
}
$holidays=implode(':',$holidays);
@endphp
@include('construction_project.side-menu')
{{-- @include('construction_project.side-menu',['hrm_header' => "Gantt Chart"]) --}}
                        <div class="col d-flex flex-column">

                            <div class="align" style='display: flex'>
                                {{ Form::open(['route' => ['projects.freeze_status'], 'method' => 'POST', 'id' => 'gantt_chart_submit','style'=>'margin-top: 5px;margin-right: 6px;']) }}
                                {{ Form::hidden('project_id', $project->id, ['class' => 'form-control']) }}
                                    <a href="#" class="btn btn-outline-primary w-20 freeze_button" data-bs-toggle="tooltip" title="{{ __('Click to change freeze status') }}" data-original-title="{{ __('Delete') }}"
                                        data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}" data-confirm-yes="document.getElementById('delete-form-{{ $project->id }}').submit();">
                                        {{-- <i class="fa fa-lock" aria-hidden="true" style='margin-right: 5px;'></i> Freeze --}}
                                        Freeze
                                    </a>
                                {!! Form::close() !!}
                                <button class="btn btn-outline-primary w-20" name="undo" aria-current="page" style='height: 38px;margin-top: 4px;margin-right: 6px;'>Undo</button>
                                <button class="btn btn-outline-primary w-20" name="redo" style='height: 38px;margin-top: 4px;margin-right: 6px;'>Redo</button>
                                <button class="btn btn-outline-primary w-20" name="indent" style='height: 38px;margin-top: 4px;margin-right: 6px;'>Indent</button>
                                <button class="btn btn-outline-primary w-20" name="outdent" style='height: 38px;margin-top: 4px;margin-right: 6px;'>Outdent</button>
                                <button id="toggle_fullscreen" class="btn btn-outline-primary w-20"
                                    onclick="gantt.ext.fullscreen.toggle();" style='height: 38px;margin-top: 4px;margin-right: 6px;'>Fullscreen</button>
                                <button id="toggle_fullscreen" class="btn btn-outline-primary w-20" onclick="closeAll()" style='height: 38px;margin-top: 4px;margin-right: 6px;'>Collaspe
                                    All</button>
                                <button id="toggle_fullscreen" class="btn btn-outline-primary w-20" onclick="openAll()" style='height: 38px;margin-top: 4px;margin-right: 6px;'>Expand
                                    All</button>
                                <button id="toggle_fullscreen" class="btn btn-outline-primary w-20" onclick="zoomIn()" style='height: 38px;margin-top: 4px;margin-right: 6px;'>Zoom
                                    In</button>
                                <button id="toggle_fullscreen" class="btn btn-outline-primary w-20" onclick="zoomOut()" style='height: 38px;margin-top: 4px;margin-right: 6px;'>Zoom
                                    Out</button>
                                <button class="btn btn-outline-primary w-20" onclick="updateCriticalPath(this)" style='height: 38px;margin-top: 4px;margin-right: 6px;'>Show Critical
                                    Path</button>
                                    <select class="form-control" id="zoomscale" style='width:14%;'>
                                        <option value="">Select a option</option>
                                        <option value="day">day</option>
                                        <option value="week">week</option>
                                        <option value="month">month</option>
                                        <option value="quarter">quarter</option>
                                        <option value="year">year</option>
                                    </select>
                              </div>
                              <div class="row">
                                <div class="col-12">
                                  <div class="card card-stats border-0" id="myCover">
                                    @if($project)
                                    <input type='hidden' value='0' id='project_id'>
                                    <div class="card-body">
                                      <div id="gantt_here" style='width:100%; height:677px;' onload="script();"></div>
                                    </div>
                                    @else
                                    <h1>404</h1>
                                    <div class="page-description">
                                      {{ __('Page Not Found') }}

                                <div class="row" >
                                    <div class="col-12">
                                        <div class="card card-stats border-0">

                                            @if($project)
                                            <input type='hidden' value='0' id='project_id'>
                                            <div class="card-body">
                                            <div class="gantt_control" >

                                            </div>
                                                <div id="gantt_here" style='width:100%; height:677px;position: relative;'onload="script();"  ></div>
                                            </div>

                                            @else
                                                <h1>404</h1>
                                                <div class="page-description">
                                                    {{ __('Page Not Found') }}
                                                </div>
                                                <div class="page-search">
                                                    <p class="text-muted mt-3">{{ __("It's looking like you may have taken a wrong turn. Don't worry... it happens to the best of us. Here's a little tip that might help you get back on track.")}}</p>
                                                    <div class="mt-3">
                                                        <a class="btn-return-home badge-blue" href="{{route('home')}}"><i class="ti ti-reply"></i> {{ __('Return Home')}}</a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="page-search">
                                      <p class="text-muted mt-3">{{ __("It's looking like you may have taken a wrong turn. Don't worry... it happens to the best of us. Here's a little tip that might help you get back on track.")}}</p>
                                      <div class="mt-3">
                                        <a class="btn-return-home badge-blue" href="{{route('home')}}">
                                          <i class="ti ti-reply"></i> {{ __('Return Home')}}
                                        </a>
                                      </div>
                                    </div>
                                    @endif
                                  </div>
                                </div>
                              </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type='hidden' id='weekends' value='{{$project->non_working_days}}'>
    <input type='hidden' id='holidays' value='{{$holidays}}'>

@include('new_layouts.footer')

<script type="text/javascript">
    // check freeze status
        $( document ).ready(function() {


                // check freeze status

            var tempcsrf = '{!! csrf_token() !!}';
            $.post("{{route('projects.get_freeze_status')}}", {_token: tempcsrf,project_id: {{$project->id}}},
            function (resp, textStatus, jqXHR) {

               if(resp=='1'){
                gantt.config.readonly = true;
                $('.freeze_button').addClass('disabled');
               }else{
                gantt.config.readonly = false;
                $('.freeze_button').removeClass('disabled');
               }

            });

    // check freeze status
		//zoom

		var selectOption = document.getElementById("zoomscale");
		selectOption.onchange = function (event) {
			gantt.ext.zoom.setLevel(event.target.value)
		}


		//task position
		var els = document.getElementsByClassName("action");
		for (var i = 0; i < els.length; i++) {
			els[i].onclick = function () {
				console.log(els[i])
				gantt.performAction(this.name)
			}
		}


		gantt.templates.rightside_text = function (start, end, task) {
			if (task.type == gantt.config.types.milestone) {
				return task.text;
			}
			return "";
		};



		// 	gantt.message("Loading...");
		// });

		// gantt.attachEvent("onLoadEnd", function () {
		// 	gantt.message({
		// 		text: "Loaded " + gantt.getTaskCount() + " tasks, " + gantt.getLinkCount() + " links",
		// 		expire: 8 * 1000
		// 	});
		// })s

		gantt.i18n.setLocale({
			labels: {
				time_enable_button: 'Schedule',
				time_disable_button: 'Unschedule',
			}
		});


		gantt.config.open_tree_initially = true;

		gantt.plugins({
			quick_info: true,
			tooltip: true,
			multiselect: true,
			undo: true,
			fullscreen: true,
			marker: true,
			drag_timeline: true,
			critical_path: true,
			keyboard_navigation: true,

		});

		gantt.ext.fullscreen.getFullscreenElement = function () {
			return document.getElementById("additional_elements");
		}
		gantt.config.date_format = "%Y-%m-%d %H:%i";


		var dateToStr = gantt.date.date_to_str(gantt.config.task_date);
		var today = new Date(2018, 3, 5);
		gantt.addMarker({
			start_date: today,
			css: "today",
			text: "Today",
			title: "Today: " + dateToStr(today)
		});

		var start = new Date(2018, 2, 28);
		gantt.addMarker({
			start_date: start,
			css: "status_line",
			text: "Start project",
			title: "Start project: " + dateToStr(start)
		});
		gantt.config.scale_height = 50;
		gantt.templates.task_class = gantt.templates.grid_row_class = gantt.templates.task_row_class = function (start, end, task) {
			if (gantt.isSelectedTask(task.id))
				return "gantt_selected";
		};

		var formatter = gantt.ext.formatters.durationFormatter({
			enter: "day",
			store: "day",
			format: "auto"
		});
		var linksFormatter = gantt.ext.formatters.linkFormatter({ durationFormatter: formatter });

		var editors = {
			text: { type: "text", map_to: "text" },
			start_date: {
				type: "date", map_to: "start_date",
			},
			end_date: {
				type: "date", map_to: "end_date",
			},
			duration: {
				type: "duration", map_to: "duration",
				min: 0, max: 100, formatter: formatter
			},
			priority: {
				type: "select", map_to: "priority",
				options: gantt.serverList("priority")
			},
			predecessors: { type: "predecessor", map_to: "auto", formatter: linksFormatter }
		};

		gantt.config.columns = [
			{ name: "wbs", label: "#", width: 60, align: "center", template: gantt.getWBSCode,tree: true },
			{
				name: "text", label: "Task Name",width: 150, editor: editors.text,
				resize: true
			},
			{
				name: "start_date", label: "Start Date", width: 80, align: "center",
				editor: editors.start_date, resize: true
			},
			{
				name: "end_date", label: "End Date", width: 80, align: "center",
				editor: editors.end_date, resize: true
			},
            {
				name: "duration", label: "Duration", width: 80, align: "center",
				editor: editors.end_date, resize: true
			},

			{
				name: "place", label: "Place", width: 80, align: "center",
				editor: editors.end_date, resize: true
			},
			{
				name: "location", label: "Location", width: 80, align: "center",
				editor: editors.end_date, resize: true
			},
			{
				name: "material", label: "Material Qunatity", width: 110, align: "center",
				editor: editors.end_date, resize: true
			},
			{
				name: "predecessors", label: "Predecessors", width: 110, align: "left",
				editor: editors.predecessors, resize: true, template: function (task) {
					var links = task.$target;
					var labels = [];
					for (var i = 0; i < links.length; i++) {
						var link = gantt.getLink(links[i]);
						labels.push(linksFormatter.format(link));
					}
					return labels.join(", ")
				}
			},
			totalSlackColumn,
			freeSlackColumn,
			{ name: "add" }
		];

		gantt.templates.progress_text = function (start, end, task) {
			return "<span style='text-align:left;'>" + Math.round(task.progress * 100) + "% </span>";
		};

		gantt.templates.task_class = function (start, end, task) {
			if (task.type == gantt.config.types.project)
				return "hide_project_progress_drag";
		};

        // ###############################################
        var weekScaleTemplate = function (date) {
            var dateToStr = gantt.date.date_to_str("%d %M");
            var weekNum = gantt.date.date_to_str("(week %W)");
            var endDate = gantt.date.add(gantt.date.add(date, 1, "week"), -1, "day");
            return dateToStr(date) + " - " + dateToStr(endDate) + " " + weekNum(date);
        };

        gantt.config.scales = [
            {unit: "month", step: 1, format: "%F, %Y"},
            {unit: "week", step: 1, format: weekScaleTemplate},
            {unit: "day", step: 1, format: "%D, %d"}
        ];

        gantt.templates.timeline_cell_class = function (task, date) {
            if (!gantt.isWorkTime(date))
                return "week_end";
            return "";
        };

        // holidays end
		gantt.config.bar_height = 100;
		gantt.config.date_format = "%Y-%m-%d %H:%i";
		gantt.init("gantt_here");
		gantt.load("{{route('projects.gantt_data',[$project->id])}}");

        // holidays
            gantt.config.work_time = true;
            gantt.config.details_on_create = false;
            gantt.config.scale_unit = "day";
            gantt.config.duration_unit = "day";
            gantt.config.row_height = 30;
            gantt.config.min_column_width = 40;

                // weekdays appending
                var weekend_list=$('#weekends').val();
                var result=[0,1,2,3,4,5,6];
                result.forEach(element => {
                    if(weekend_list.includes(element)){
                        gantt.setWorkTime({ day:element, hours:false });
                    }else{
                        gantt.setWorkTime({ day:element, hours: ["8:00-17:00"] });
                    }

                });
                // ## holidays  ######
                var holidays = [];
                var holidays_list=$('#holidays').val();
                if(holidays_list!=''){
                    var result2 =holidays_list.split(':');
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
                    gantt.message("Following holidays are excluded from working time:");
                    for (var i = 0; i < holidays.length; i++) {
                        setTimeout(
                            (function (i) {
                                return function () {
                                    gantt.message(dateToStr(holidays[i]))
                                }
                            })(i)
                            ,
                            (i + 1) * 600
                        );
                    }
                }


        var dp = new gantt.dataProcessor("http://demo.mustbuildapp.com/");
        //var dp = new gantt.dataProcessor("/erpnew/public/");
            dp.init(gantt);
            dp.setTransactionMode({
                mode:"REST",
                payload:{
                "_token":tempcsrf,
                }
            });


        });
    </script>
