@include('new_layouts.header')
    <div class="page-wrapper">
        @include('construction_project.side-menu')
            <div class="row">
                <div class="col-md-6">
                    <h2 class="mb-4">{{$data['con_data']!=null ? $data['con_data']->text:'Task' }}</h2>
                </div>
            </div>

            <form action="{{route('con_taskupdate')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row min-750" id="taskboard_view">
                    <div class="col-2">
                        <div class="form-group">
                            {{ Form::label('name', __('Date'),['class' => 'form-label']) }}<span class="text-danger">*</span>
                            {{ Form::date('get_date', $data['get_date'], array('class' => 'form-control month-btn','id' => 'get_date')) }}
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group">
                            {{ Form::label('name', __('Percentage'),['class' => 'form-label']) }}<span class="text-danger">*</span>
                            {{ Form::number('percentage', null, ['class' => 'form-control','id' => 'percentage','required'=>'required','max'=>'100','min'=>'1']) }}
                            {{ Form::hidden('task_id', $task_id, ['class' => 'form-control','id'=>'task_id']) }}
                            {{ Form::hidden('user_id', \Auth::user()->id, ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="col-4">
                        <label for="input">{{__('Attachments')}}</label>
                        <input type="file" class="form-control" name="attachment_file_name">
                        <div class="file_name_show"></div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            {{ Form::label('description', __('Description'),['class' => 'form-label']) }} <span style='color:red;'>*</span>
                            {{ Form::textarea('description', null, ['class' => 'form-control','id' => 'description','rows'=>'3','data-toggle' => 'autosize','required'=>'required']) }}
                        </div>
                    </div>
                </div>
                <center>
                    <input type="submit" value="{{__('Submit')}}" class="btn btn-primary">
                    <a href="{{url('taskboard/list')}}" class="btn btn-danger">Back</a>
                </center>
            </form>
            <br>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table" id="example2">
                        <thead>
                        <tr>
                            <th scope="col">{{__('Projects')}}</th>
                            <th scope="col">{{__('Record Date')}}</th>
                            <th scope="col">{{__('Percentage')}}</th>
                            <th scope="col">{{__('Description')}}</th>
                            <th scope="col">{{__('FileName')}}</th>
                            <th scope="col">{{__('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @php
                                $documentPath=\App\Models\Utility::get_file('uploads/task_particular_list');
                            @endphp
                            @forelse ($data['get_task_progress'] as $task_progress)
                            <tr>
                                <td>{{$task_progress->project_name}}</td>
                                <td>{{Utility::site_date_format($task_progress->created_at,\Auth::user()->id)}}</td>
                                <td>{{$task_progress->percentage}}</td>
                                <td>{{$task_progress->description}}</td>
                                <td>{{$task_progress->filename}}</td>
                                <td>
                                    <div class="actions">
                                        <a title="{{__('Edit')}}" class="btn btn-sm btn-primary" onclick="taskprogress_edit(this,{{$task_progress->id}});">
                                            <i class="ti ti-pencil"></i>
                                        </a>
                                        @if ($task_progress->filename != null)
                                            <a href="{{ $documentPath . '/' . $task_progress->filename }}"  title="{{__('Edit')}}" download class="btn btn-sm btn-primary">
                                                <i class="ti ti-download"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                                
                            @empty
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>{{__('No Task Entered')}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@include('new_layouts.footer')

<script>
    $(document).ready(function() {
        $('#example2').DataTable({
            dom: 'Bfrtip',
            searching: true,
            info: true,
            paging: true,
        });
    });

    function taskprogress_edit(get_this,taskprogress_id){
        $.ajax({
            url : '{{route("edit_task_progress")}}',
            type : 'GET',
            data : { "_token": "{{ csrf_token() }}", 'task_id' : $("#task_id").val(), 'get_date' : $("#get_date").val(), 'taskprogress_id':taskprogress_id },
            success : function(data_get) {
                if(data_get != null){
                    $("#percentage").val(data_get['percentage']);
                    $("#description").val(data_get['description']);
                    $("#get_date").val(data_get['get_date']);
                    $(".file_name_show").html(data_get['filename']);
                }
            },
            error : function(request,error)
            {
                alert("Request: "+JSON.stringify(request));
            }
        });
    }
</script>