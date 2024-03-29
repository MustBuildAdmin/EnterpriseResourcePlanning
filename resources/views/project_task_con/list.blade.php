@include('new_layouts.header')
{{-- @extends('layouts.admin') --}}
<link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.css') }}">
<style>
    .wrappers{
        display: flex;
        justify-content: center;
    }
    .cards {
        display: flex;
        padding: 24px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .loader{
        border-radius: 50%;
        position: relative;
        display: inline-block;
        height: 0px;
        width: 0px;
    }

    .loader span{
        position: absolute;
        display: block;
        background: #ddd;
        height: 15px;
        width: 15px;
        border-radius: 50%;
        top: -20px;
        perspective: 100000px;
    }
    .loader span:nth-child(1) {
        left:30px;
        animation: bounce2 1s cubic-bezier(0.04, 0.35, 0, 1) infinite;
        animation-delay: 0s;
        background: #ff756f;
    }
    .loader span:nth-child(2) {
        left:6px;
        animation: bounce2 1s cubic-bezier(0.04, 0.35, 0, 1) infinite;
        animation-delay: .2s;
        background: #ffde6f;
    }
    .loader span:nth-child(3) {
        left:-20px;
        animation: bounce2 1s cubic-bezier(0.04, 0.35, 0, 1) infinite;
        animation-delay: .4s;
        background: #01de6f;
    }
    .loader span:nth-child(4) {
        left: -44px;
        animation: bounce2 1s cubic-bezier(0.04, 0.35, 0, 1) infinite;
        animation-delay: .6s;
        background: #6f75ff;
    }

    @keyframes bounce2 {
        0%, 56%, 100% {
            transform: translateY(0px);
        }
        25% {
            transform: translateY(-30px);
        }
    }
</style>
    <div class="page-wrapper">
        @include('construction_project.side-menu')
        <div class="row">
            <div class="row min-750" id="taskboard_view">
                <div class="col-md-12">
                    <div class="card">
                        <div class="col-12">
                            <br>
                            <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button onclick="alltask();" class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">{{__('All Tasks')}}</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button onclick="maintask();" class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">{{__('Main Tasks')}}</button>
                                </li>
                            </ul>
                            <br>
                            <div class="page page-center">
                                <div class="container container-slim py-4">
                                    <div class="text-center">
                                    <div class="mb-3">
                                        <a href="." class="navbar-brand navbar-brand-autodark"><img src="./static/logo-small.svg" height="36" alt=""></a>
                                    </div>
                                    <div class="text-secondary mb-3">Please Wait...</div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar progress-bar-indeterminate"></div>
                                    </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-content" id="pills-tabContent">
                                {{-- All Task --}}
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                    <div class="card-body" id="show_search_function">
                                        <div class="row d-flex align-items-center justify-content-center">
                                            @if(\Auth::user()->type == 'company')
                                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12 mr-2 mb-0">
                                                    <div class="btn-box">
                                                        {{ Form::label('users', __('Users'),['class'=>'form-label'])}}
                                                        <select class="select form-select" name="users" id="users">
                                                            <option value="" class="">{{ __('All Users') }}</option>
                                                            @foreach ($user_data as $users)
                                                                <option value="{{$users->id}}">{{$users->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @endif
                
                                            @if(\Auth::user()->type == 'company')
                                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12 mr-0">
                                                    <div class="btn-box">
                                                        {{ Form::label('start_date', __('Planned Start Date'),['class'=>'form-label'])}}
                                                        {{ Form::date('start_date', null, array('class' => 'form-control month-btn start_date')) }}
                                                    </div>
                                                </div>
                                            @endif
                
                                            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12 mr-2">
                                                <div class="btn-box">
                                                    @if(\Auth::user()->type == 'company')
                                                        {{ Form::label('end_date', __('Planned End Date'),['class'=>'form-label'])}}
                                                    @else
                                                        {{ Form::label('end_date', __('Planned Start Date'),['class'=>'form-label'])}}
                                                    @endif
                                                    
                                                    {{ Form::date('end_date', date('Y-m-d') , array('class' => 'form-control month-btn end_date')) }}
                
                                                </div>
                                            </div>
                                            <div class="col-auto float-end ms-2 mt-4">
                                                <a href="#" class="btn btn-sm btn-primary" onclick="submit_button();">
                                                    <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body table-border-style">
                                        <div class="table-responsive" id="all_task_append">
                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                        <div class="card-body table-border-style">
                                            <div class="table-responsive" id="main_task_append">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@include('new_layouts.footer')

<script>
    $(function () {
        alltask();
    });

    function alltask(start_date,end_date,user_id){
        $(".loader_show_hide").show();
        $("#show_search_function").show();
        $("#all_task_append").html("");
        $.ajax({
            url : '{{route("get_all_task")}}',
            type : 'GET',
            data : {
                'start_date' : start_date,
                'end_date'   : end_date,
                'user_id'    : user_id
            },
            cache:true,
            success : function(data) {
                if(data['success'] == true){
                    $("#all_task_append").html(data['all_task']);
                }
                $(".loader_show_hide").hide();
            },
            error : function(request,error)
            {
                alert("Request: "+JSON.stringify(request));
            }
        });
    }

    function submit_button(){
        start_date = $(".start_date").val();
        end_date   = $(".end_date").val();
        user_id    = $("#users").val();

        alltask(start_date,end_date,user_id);
    }

    function maintask(){
        $(".loader_show_hide").show();
        $("#show_search_function").hide();
        $("#main_task_append").html("");  
        $.ajax({
            url : '{{route("main_task_list")}}',
            type : 'GET',
            data : {
            },
            cache:true,
            success : function(data) {     
                if(data['success'] == true){
                    $("#main_task_append").html(data['main_task']);
                }
                $(".loader_show_hide").hide();
            },
            error : function(request,error)
            {
                alert("Request: "+JSON.stringify(request));
            }
        });
    }
</script>