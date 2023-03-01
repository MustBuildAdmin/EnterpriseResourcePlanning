@extends('layouts.admin')
<script src="{{asset('assets/js/gantt/codebase/dhtmlxgantt.js')}}"></script>
<link href="{{asset('assets/js/gantt/codebase/dhtmlxgantt.css')}}" rel="stylesheet">
<script src="{{ asset('js/jquery.min.js') }}"></script>
<link rel="stylesheet" href="{{asset('assets/js/gantt/codebase/skins/dhtmlxgantt_material.css?v=7.0.11')}}">
<link rel="stylesheet" href="{{asset('assets/js/gantt/common/controls_styles.css?v=7.0.11')}}">
    
<style>
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
    textarea.editor_description {
        max-width: 100%;
        height: 100px !important;
    }
    .gantt_cal_larea {
        height: 84% !important;
        overflow:visible;
    }
    .gantt_cal_chosen,
    .gantt_cal_chosen select{
        width: 400px;
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

    <div class="row">
        <div class="col-12">
            <div class="card card-stats border-0">
               
                @if($project)
                <input type='hidden' value='0' id='project_id'>
                <div class="card-body">
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
    </div>
@endsection

<script type="text/javascript">
    window.addEventListener("load", () => {
        var tempcsrf = '{!! csrf_token() !!}';
        let main = document.getElementById("gantt_here");
        // gantt.config.order_branch = true;
        // gantt.config.order_branch_free = true;
        gantt.init(main);
        gantt.templates.parse_date = function(date) { 
            return new Date(date);
        };

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
            {name: "text", label: "Name", tree: true, width: 200, resize: true},
            {name: "duration", label: "Duration", width:80, align: "center", resize: true},
            {name: "start_date", label: "Start", width:80, align: "center", resize: true},
            {name: "end_date", label: "Finish", width:80, align: "center", resize: true},
            {name: "predecessors", label: "Predecessors", width:80, align: "center", resize: true},
            {name: "float", label: "float", width:80, align: "center", resize: true}
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
</body>