<style>
    .table-responsive{
        max-width: none;
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="mt-2 " >
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['url' => ['taskboard/list'], 'method' => 'GET', 'id' => 'project_task_submit']) }}
                        <div class="row d-flex align-items-center justify-content-center">
                            {{-- <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12 mr-2 mb-0">
                                <div class="btn-box">
                                    {{ Form::label('projects', __('Projects'),['class'=>'form-label'])}}
                                    <select class="select form-select" name="projects" id="projects">
                                        <option value="" class="">{{ __('All Project') }}</option>
                                        @foreach ($project_select as $project)
                                            <option value="{{ $project->id }}" {{isset($_GET['project_id']) && $_GET['project_id']==$project->id?'selected':''}}>{{ $project->project_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                            @if(\Auth::user()->type == 'company')
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12 mr-2 mb-0">
                                    <div class="btn-box">
                                        {{ Form::label('users', __('Users'),['class'=>'form-label'])}}
                                        <select class="select form-select" name="users" id="users">
                                            <option value="" class="">{{ __('All Users') }}</option>
                                            
                                        </select>
                                    </div>
                                </div>
                            @endif

                            @if(\Auth::user()->type == 'company')
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-0">
                                    <div class="btn-box">
                                        {{ Form::label('start_date', __('Start Date'),['class'=>'form-label'])}}
                                        {{ Form::date('start_date', isset($_GET['start_date'])?$_GET['start_date']:'', array('class' => 'form-control month-btn')) }}
                                    </div>
                                </div>
                            @endif
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                <div class="btn-box">
                                    @if(\Auth::user()->type == 'company')
                                        {{ Form::label('end_date', __('End Date'),['class'=>'form-label'])}}
                                    @else
                                        {{ Form::label('end_date', __('Date'),['class'=>'form-label'])}}
                                    @endif
                                    @php  
                                    $get_date =date('Y-m-d');
                                    if($_GET['end_date']!=''){
                                        $get_date =$_GET['end_date'];
                                    }
                                    @endphp
                                    
                                    {{ Form::date('end_date', $get_date , array('class' => 'form-control month-btn end_date')) }}

                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                <div class="btn-box">
                                    {{ Form::label('select_type', __('Select Type'),['class'=>'form-label'])}}
                                    <select class="select form-select" name="task_types" id="task_types">
                                        <option value="0" {{isset($_GET['task_types']) && $_GET['task_types']==0?'selected':''}}>{{__('None')}}</option>
                                        <option value="1" {{isset($_GET['task_types']) && $_GET['task_types']==1?'selected':''}}>{{__('Today Task')}}</option>
                                        <option value="2" {{isset($_GET['task_types']) && $_GET['task_types']==2?'selected':''}}>{{__('Pending Task')}}</option>
                                        <option value="3" {{isset($_GET['task_types']) && $_GET['task_types']==3?'selected':''}}>{{__('Completed Task')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-auto float-end ms-2 mt-4">
                                <a href="#" class="btn btn-sm btn-primary"
                                onclick="document.getElementById('project_task_submit').submit(); return false;"
                                data-toggle="tooltip" data-original-title="{{ __('apply') }}">
                                    <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                </a>
                                {{-- <a href="{{ route('project_report.index') }}" class="btn btn-sm btn-danger" data-toggle="tooltip"
                                    data-original-title="{{ __('Reset') }}">
                                        <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off"></i></span>
                                    </a> --}}
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="col-12">
                <br>
                <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">{{__('All Tasks')}}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">{{__('Main Tasks')}}</button>
                    </li>
                </ul>
                <br>
                <div class="tab-content" id="pills-tabContent">
                    {{-- All Task --}}
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="card-body table-border-style">
                            <div class="table-responsive">
                                <table class="table datatable">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('Projects')}}</th>
                                        <th scope="col">{{__('Tasks')}}</th>
                                        <th scope="col">{{__('Start Date')}}</th>
                                        <th scope="col">{{__('End Date')}}</th>
                                        <th scope="col">{{__('Assigned To')}}</th>
                                        <th scope="col">{{__('Action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody class="list">
                                        @if(count($tasks) > 0)
                                            @foreach($tasks as $task)
                                                @if($task->instance_id == $task->pro_instance_id)
                                                    @if (DB::table('con_tasks')->where('project_id',$task->project_id)->where('parent',$task->id)->exists())
                                                    @else
                                                        <tr>
                                                            <td>
                                                                <span class="d-flex text-sm text-center justify-content-between">
                                                                    <p class="m-0">{{ $task->project_name }}</p>
                                                                    <span class="me-5 badge p-2 px-3 rounded bg-{{ (\Auth::user()->checkProject($task->project_id) == 'Owner') ? 'success' : 'warning'  }}">
                                                                        {{ __(\Auth::user()->checkProject($task->project_id)) }}
                                                                    </span>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="h6 text-sm font-weight-bold mb-0">{{ $task->text }}</span>
                                                            </td>
                                                            <td class="{{ (strtotime($task->start_date) < time()) ? 'text-danger' : '' }}">{{ Utility::getDateFormated($task->start_date) }}</td>
                                                            <td class="{{ (strtotime($task->end_date) < time()) ? 'text-danger' : '' }}">{{ Utility::getDateFormated($task->end_date) }}</td>
                                                            <td>
                                                                <div class="avatar-group">
                                                                    @if($task->users()->count() > 0)
                                                                        @if($users = $task->users()) 
                                                                            @foreach($users as $key => $user)
                                                                                @if($key<3)
                                                                                    <a href="#" class="avatar rounded-circle avatar-sm">
                                                                                        <img data-original-title="{{(!empty($user)?$user->name:'')}}" @if($user->avatar) src="{{asset('/storage/uploads/avatar/'.$user->avatar)}}" @else src="{{asset('/storage/uploads/avatar/avatar.png')}}" @endif title="{{ $user->name }}" class="hweb">
                                                                                    </a>
                                                                                @else
                                                                                    @break
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                        @if(count($users) > 3)
                                                                            <a href="#" class="avatar rounded-circle avatar-sm">
                                                                                <img  data-original-title="{{(!empty($user)?$user->name:'')}}" @if($user->avatar) src="{{asset('/storage/uploads/avatar/'.$user->avatar)}}" @else src="{{asset('/storage/uploads/avatar/avatar.png')}}" @endif class="hweb">
                                                                            </a>
                                                                        @endif
                                                                    @else
                                                                        {{ __('-') }}
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td class="text-center w-15">
                                                                <div class="actions">
                                                                    <a data-size="lg" data-url="{{ route('project.taskboard.edit',['task_id'=>$task->main_id,'get_date'=>$get_date]) }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit Task')}}" class="btn btn-sm btn-primary">
                                                                        <i class="ti ti-pencil"></i>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endif
                                            @endforeach
                                        @else
                                            <tr>
                                                <th scope="col" colspan="7"><h6 class="text-center">{{__('No tasks found')}}</h6></th>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Show Parent Task --}}
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="card-body table-border-style">
                                <div class="table-responsive">
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col">{{__('Projects')}}</th>
                                                <th scope="col">{{__('Tasks')}}</th>
                                                <th scope="col">{{__('Start Date')}}</th>
                                                <th scope="col">{{__('End Date')}}</th>
                                                <th scope="col">{{__('Assigned To')}}</th>
                                                <th scope="col">{{__('Progress')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list">
                                            @if(count($show_parent_task) > 0)
                                                @foreach($show_parent_task as $show_parent)
                                                    @if (DB::table('con_tasks')->where('project_id',$show_parent->project_id)->where('parent',$show_parent->id)->exists())
                                                        <tr>
                                                            <td>
                                                                <span class="d-flex text-sm text-center justify-content-between">
                                                                    <p class="m-0">{{ $show_parent->project_name }}</p>
                                                                    <span class="me-5 badge p-2 px-3 rounded bg-{{ (\Auth::user()->checkProject($show_parent->project_id) == 'Owner') ? 'success' : 'warning'  }}">
                                                                        {{ __(\Auth::user()->checkProject($show_parent->project_id)) }}
                                                                    </span>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="h6 text-sm font-weight-bold mb-0">{{ $show_parent->text }}</span>
                                                            </td>
                                                            <td class="{{ (strtotime($show_parent->start_date) < time()) ? 'text-danger' : '' }}">{{ Utility::getDateFormated($show_parent->start_date) }}</td>
                                                            <td class="{{ (strtotime($show_parent->end_date) < time()) ? 'text-danger' : '' }}">{{ Utility::getDateFormated($show_parent->end_date) }}</td>
                                                            <td>
                                                                <div class="avatar-group">
                                                                    @if($show_parent->users()->count() > 0)
                                                                        @if($users = $show_parent->users()) 
                                                                            @foreach($users as $key => $user)
                                                                                @if($key<3)
                                                                                    <a href="#" class="avatar rounded-circle avatar-sm">
                                                                                        <img data-original-title="{{(!empty($user)?$user->name:'')}}" @if($user->avatar) src="{{asset('/storage/uploads/avatar/'.$user->avatar)}}" @else src="{{asset('/storage/uploads/avatar/avatar.png')}}" @endif title="{{ $user->name }}" class="hweb">
                                                                                    </a>
                                                                                @else
                                                                                    @break
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                        @if(count($users) > 3)
                                                                            <a href="#" class="avatar rounded-circle avatar-sm">
                                                                                <img  data-original-title="{{(!empty($user)?$user->name:'')}}" @if($user->avatar) src="{{asset('/storage/uploads/avatar/'.$user->avatar)}}" @else src="{{asset('/storage/uploads/avatar/avatar.png')}}" @endif class="hweb">
                                                                            </a>
                                                                        @endif
                                                                    @else
                                                                        {{ __('-') }}
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td>
                                                                {{ $show_parent->progress }}
                                                            </td>
                                                        </tr>
                                                    @else
                                                       
                                                    @endif
                                                @endforeach
                                            @else
                                                <tr>
                                                    <th scope="col" colspan="7"><h6 class="text-center">{{__('No tasks found')}}</h6></th>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<script>
    $('#projects').on('change', function () {
        var id_porjects = this.value;
    
        $.ajax({
            url: "{{ route('project.taskboard_get') }}",
            type : 'POST',
            data: {
                project_id: id_porjects,
                "_token": "{{ csrf_token() }}",
            },
            dataType:'json',
            success: function (result) {
                // Handle success here
                $('#users').html('<option value="">-- Select Users --</option>');
                if(result.length!=0){
                    $.each(result, function (key, value) {
                        $("#users").append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                }else{
                    $("#users").append('<option value="0" disabled>No Data Found</option>');
                }
            },
            cache: false
        }).fail(function (jqXHR, textStatus, error) {
    
        });
    });
    $('#task_types').on('change', function () {
        var get_date = "<?php echo date('Y-m-d'); ?>";
        data_type_val = $(this).val();
        if(data_type_val == 1){ //Today Task
            $(".end_date").val(get_date);
        }
    });
</script>