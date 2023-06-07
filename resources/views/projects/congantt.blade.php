@extends('layouts.admin')
<script src="{{asset('assets/js/gantt/codebase/dhtmlxgantt.js')}}"></script>
<link href="{{asset('assets/js/gantt/codebase/dhtmlxgantt.css')}}" rel="stylesheet">
<script src="{{ asset('js/jquery.min.js') }}"></script>
<link rel="stylesheet" href="{{asset('assets/js/gantt/codebase/skins/dhtmlxgantt_material.css?v=7.0.11')}}">
<link rel="stylesheet" href="{{asset('assets/js/gantt/common/controls_styles.css?v=7.0.11')}}">
    
<style>
    .gantt_control {
        display: flex;
        flex-direction: row;
        justify-content: space-evenly;
    }
    .gantt_control input ,.gantt_control button{
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
	.status_line {
			background-color: #0ca30a;
		}

		.gantt_task_cell.week_end {
			background-color: #EFF5FD;
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
@section('page-title') {{__('Gantt Chart')}} @endsection

@section('breadcrumb')

    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('projects.index')}}">{{__('Project')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('projects.show',$project->id)}}">{{ucwords($project->project_name)}}</a></li>
    <li class="breadcrumb-item">{{__('Gantt Chart')}}</li>

@endsection

@section('content')

<div class="align">
    {{ Form::open(['route' => ['projects.freeze_status'], 'method' => 'POST', 'id' => 'gantt_chart_submit']) }}
    {{ Form::hidden('project_id',$project->id, ['class' => 'form-control']) }}
    <a href="#" class="btn btn-sm btn-danger freeze_button text-end freezebtn" data-bs-toggle="tooltip" title="{{__('Click to change freeze status')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{ $project->id}}').submit();">
      <i class="fa fa-lock" aria-hidden="true"></i> Freeze </a> {!! Form::close() !!}
    <div>
    <input type='button'  class="btn btn-sm btn-danger" id='default' onclick="toggleChart()" value="Toggle Main Timeline">
    <button class="zoom_toggle btn btn-sm btn-danger" onclick="toggleMode(this)">Zoom to Fit</button>
    <input type=button value="Zoom In" class="btn btn-sm btn-danger" onclick="gantt.ext.zoom.zoomIn();">
    <input type=button value="Zoom Out"  class="btn btn-sm btn-danger" onclick="gantt.ext.zoom.zoomOut();">	
    <button id="toggle_fullscreen"  class="btn btn-sm btn-danger" onclick="gantt.ext.fullscreen.toggle();">Toggle Full Screen</button>
    <button onclick="updateCriticalPath(this)" class="btn btn-sm btn-danger">Expand critical tasks</button>
    </div>
    <!-- <input value="Undo" type="button" onclick='gantt.undo()'>
    <input value="Redo" type="button" onclick='gantt.redo()'> -->
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
                    <div id="gantt_here" style='width:100%; height:677px;'onload="script();" ></div>
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
  @endsection

@push('script-page')
<script type="text/javascript">
// check freeze status
    $( document ).ready(function() {
        var tempcsrf = '{!! csrf_token() !!}';
        $.post("{{route('projects.get_freeze_status')}}", {_token: tempcsrf,project_id: {{$project->id}}},
        function (resp, textStatus, jqXHR) {
          
           if(resp['freeze_status']=='1'){
            gantt.config.readonly = true;
            $('.freeze_button').addClass('disabled');
           }else{
            gantt.config.readonly = false;
            $('.freeze_button').removeClass('disabled');
           }

        });
    });
// check freeze status 

// success toater alert
    @if(Session::has('message'))
      toastr.options =
      {
          "closeButton" : true,
          "progressBar" : true
      }
    toastr.success("{{ session('message') }}");
    @endif
// success toater alert
</script>

<script type="text/javascript">
    
gantt.plugins({
		critical_path: true,
        auto_scheduling: true,
		undo: true
	});
	function updateCriticalPath(toggle) {
		toggle.enabled = !toggle.enabled;
		if (toggle.enabled) {
			toggle.innerHTML = "Hide Critical Path";
			gantt.config.highlight_critical_path = true;
			gantt.eachTask(function (task) {
				if (this.isCriticalTask(task) && !this.isTaskVisible(task)) {
					var parent;
					while (gantt.isTaskExists(task.parent)) {
						parent = this.getTask(task.parent);
						if (this.isTaskVisible(parent.id)) {
							parent.$open = true;
							break;
						} else {
							if (!parent.open)
								parent.$open = true;
							parent = this.getTask(parent.parent);
						}
					}
				}
			});
		} else {
			toggle.innerHTML = "Expand critical tasks";
			gantt.config.highlight_critical_path = false;
		}
		gantt.render();
	}

	gantt.config.work_time = true;
	gantt.config.details_on_create = false;
	gantt.config.scale_unit = "day";
	gantt.config.duration_unit = "day";
	gantt.config.row_height = 30;
	gantt.config.min_column_width = 40;
	gantt.templates.timeline_cell_class = function (task, date) {
		if (!gantt.isWorkTime(date))
			return "week_end";
		return "";
	};
	function toggleMode(toggle) {
		gantt.$zoomToFit = !gantt.$zoomToFit;
		if (gantt.$zoomToFit) {
			toggle.innerHTML = "Set default Scale";
			//Saving previous scale state for future restore
			saveConfig();
			zoomToFit();
		} else {

			toggle.innerHTML = "Zoom to Fit";
			//Restore previous scale state
			restoreConfig();
			gantt.render();
		}
	}

	var cachedSettings = {};

	function saveConfig() {
		var config = gantt.config;
		cachedSettings = {};
		cachedSettings.scales = config.scales;
		cachedSettings.start_date = config.start_date;
		cachedSettings.end_date = config.end_date;
		cachedSettings.scroll_position = gantt.getScrollState();
	}

	function restoreConfig() {
		applyConfig(cachedSettings);
	}

	function applyConfig(config, dates) {

		gantt.config.scales = config.scales;

		// restore the previous scroll position
		if (config.scroll_position) {
			setTimeout(function(){
				gantt.scrollTo(config.scroll_position.x, config.scroll_position.y)
			},4)
		}
	}


	function zoomToFit() {
		var project = gantt.getSubtaskDates(),
			areaWidth = gantt.$task.offsetWidth,
			scaleConfigs = zoomConfig.levels;

		for (var i = 0; i < scaleConfigs.length; i++) {
			var columnCount = getUnitsBetween(project.start_date, project.end_date, scaleConfigs[i].scales[scaleConfigs[i].scales.length-1].unit, scaleConfigs[i].scales[0].step);
			if ((columnCount + 2) * gantt.config.min_column_width <= areaWidth) {
				break;
			}
		}


		if (i == scaleConfigs.length) {
			i--;
		}

		gantt.ext.zoom.setLevel(scaleConfigs[i].name);
		applyConfig(scaleConfigs[i], project);
	}

	// get number of columns in timeline
	function getUnitsBetween(from, to, unit, step) {
		var start = new Date(from),
			end = new Date(to);
		var units = 0;
		while (start.valueOf() < end.valueOf()) {
			units++;
			start = gantt.date.add(start, step, unit);
		}
		return units;
	}
    gantt.plugins({
			fullscreen: true
		});
		gantt.ext.fullscreen.getFullscreenElement = function() {
			return document.getElementById("myCover");
		}
	function toggleChart(){
		gantt.config.show_chart = !gantt.config.show_chart;
		gantt.render()
	}
    var zoomConfig = {
		levels: [
			{
				name: "day",
				scale_height: 27,
				min_column_width: 80,
				scales: [
					{ unit: "day", step: 1, format: "%d %M" }
				]
			},
			{
				name: "week",
				scale_height: 50,
				min_column_width: 50,
				scales: [
					{
						unit: "week", step: 1, format: function (date) {
							var dateToStr = gantt.date.date_to_str("%d %M");
							var endDate = gantt.date.add(date, -6, "day");
							var weekNum = gantt.date.date_to_str("%W")(date);
							return "#" + weekNum + ", " + dateToStr(date) + " - " + dateToStr(endDate);
						}
					},
					{ unit: "day", step: 1, format: "%j %D" }
				]
			},
			{
				name: "month",
				scale_height: 50,
				min_column_width: 120,
				scales: [
					{ unit: "month", format: "%F, %Y" },
					{ unit: "week", format: "Week #%W" }
				]
			},
			{
				name: "quarter",
				height: 50,
				min_column_width: 90,
				scales: [
					{ unit: "month", step: 1, format: "%M" },
					{
						unit: "quarter", step: 1, format: function (date) {
							var dateToStr = gantt.date.date_to_str("%M");
							var endDate = gantt.date.add(gantt.date.add(date, 3, "month"), -1, "day");
							return dateToStr(date) + " - " + dateToStr(endDate);
						}
					}
				]
			},
			{
				name: "year",
				scale_height: 50,
				min_column_width: 30,
				scales: [
					{ unit: "year", step: 1, format: "%Y" }
				]
			}
		]
	};

	gantt.ext.zoom.init(zoomConfig);
	gantt.ext.zoom.setLevel("week");

	function zoomIn() {
		gantt.ext.zoom.zoomIn();
	}
	function zoomOut() {
		gantt.ext.zoom.zoomOut()
	}


    window.addEventListener("load", () => {
        var tempcsrf = '{!! csrf_token() !!}';
        let main = document.getElementById("gantt_here");
        // gantt.config.order_branch = true;
        // gantt.config.order_branch_free = true;

        gantt.init(main);
        // For Full Screen 
        // gantt.plugins({
        //     fullscreen: true
        // });

        // gantt.attachEvent("onTemplatesReady", function () {
        //     var toggle = document.createElement("i");
        //     toggle.className = "fa fa-expand gantt-fullscreen";
        //     gantt.toggleIcon = toggle;
        //     gantt.$container.appendChild(toggle);
        //     toggle.onclick = function() {
        //         gantt.ext.fullscreen.toggle();
        //     };
        // });
        // gantt.attachEvent("onExpand", function () {
        //     var icon = gantt.toggleIcon;
        //     if (icon) {
        //         icon.className = icon.className.replace("fa-expand", "fa-compress");
        //     }

        // });
        // gantt.attachEvent("onCollapse", function () {
        //     var icon = gantt.toggleIcon;
        //     if (icon) {
        //         icon.className = icon.className.replace("fa-compress", "fa-expand");
        //     }
        // });
        gantt.templates.parse_date = function(date) { 
        return new Date(date);
        };
        gantt.templates.progress_text = function (start, end, task) {
		    return "<span style='text-align:left;'>" + Math.round(task.progress) + "% </span>";
	    };
        gantt.plugins({
                grouping: true
        });
        gantt.init(main);


        set_data = "";

        gantt.form_blocks["my_editor"] = {
            render: function (sns) {
                $.ajax({
                    url : '{{route("projects.get_member")}}',
                    type : 'GET',
                    async: false,
                    data : {
                        'project_id' : "<?php echo $project->id; ?>"
                    },
                    success : function(data) {      
                        set_data += data['1'];
                    }
                });
                return set_data;
            },
            set_value: function (node, value, task) {
                node.querySelector(".editor_description").value = value || "";
            },
            get_value: function (node, task) {
                return node.querySelector(".editor_description").value;
            },
            focus: function (node) {
                var a = node.querySelector(".editor_description");
                a.select();
                a.focus();
            }
        };

        gantt.form_blocks["multiselect"] = {
            render: function (sns) {
                var height = (sns.height || "23") + "px";
                var html = "<div class='gantt_cal_ltext gantt_cal_chosen gantt_cal_multiselect' style='height:" + height + ";'><select data-placeholder='...' class='chosen-select' multiple>";
                if (sns.options) {
                    $.ajax({
                        url : '{{route("projects.get_member")}}',
                        type : 'GET',
                        async: false,
                        data : {
                            'project_id' : "<?php echo $project->id; ?>"
                        },
                        success : function(multi_data) {     
                            $.each(multi_data['0'], function(multi_key, multi_value) { 
                                html += "<option value='" + multi_value.key + "'>" + multi_value.label + "</option>";
                            });
                        }
                    });
                }
                html += "</select></div>";
                return html;
            },
            set_value: function (node, value, ev, sns) {
                node.style.overflow = "visible";
                node.parentNode.style.overflow = "visible";
                node.style.display = "inline-block";
                var select = $(node.firstChild);
                
                if (value) {
                    value = (value + "").split(",");
                    
                    select.val(value);
                }
                else {
                    select.val([]);
                }

                select.chosen();
                if(sns.onchange){
                    select.change(function(){
                        sns.onchange.call(this);
                    })
                }
                select.trigger('chosen:updated');
                select.trigger("change");
            },
            get_value: function (node, ev) {
                var value = $(node.firstChild).val();
                return value;
            },
            focus: function (node) {
                $(node.firstChild).focus();
            }
        };

        gantt.locale.labels.section_users = "Users";

        function findUser(id){
            var list = gantt.serverList("people");
            for(var i = 0; i < list.length; i++){
                if(list[i].key == id){
                    return list[i];
                }
            }
            return null;
        }

        gantt.config.columns = [
            {name: "id", label: "Id", tree: true, width: 200, resize: true},
            {name: "text", label: "Name", tree: true, width: 500, resize: true},
            {name: "duration", label: "Duration", width:80, align: "center", resize: true},
            {name: "start_date", label: "Start", width:80, align: "center", resize: true},
            {name: "end_date", label: "Finish", width:80, align: "center", resize: true},
            {name: "predecessors", label: "Predecessors", width:80, align: "center", resize: true},
            {name: "float", label: "float", width:80, align: "center", resize: true},
            {name: "add", width: 44}
        ];

        gantt.load("{{route('projects.gantt_data',[$project->id])}}");

        gantt.config.lightbox.sections = [
            { name:"description", height:200, map_to:"text", type:"my_editor", focus:true},
            { name:"users",height:60, type:"multiselect", options:gantt.serverList("people"), map_to:"users"},
            { name:"time", height:72, type:"duration", map_to:"auto"}
        ];

        var dp = new gantt.dataProcessor("/erp");
        dp.init(gantt);
        dp.setTransactionMode({
            mode:"REST",
            payload:{
            "_token":tempcsrf,
            }
        });
    });
</script>
@endpush
</body>