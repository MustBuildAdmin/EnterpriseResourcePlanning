
<div class="modal-body">
    <div class="row">
        <div class="container">
            <form action="{{route('con_taskupdate')}}" method="POST" enctype="multipart/form-data">
                @csrf 
                <div class="row min-750" id="taskboard_view">
                    <div class="col-6">
                        <div class="form-group">
                            {{ Form::label('name', __('Planned Start to End Date'),['class' => 'form-label']) }}<span class="text-danger">*</span>
                            {{ Form::date('get_date', $data['get_date'], array('class' => 'form-control month-btn','id' => 'get_date', 
                                'min' => date('Y-m-d',strtotime($data['con_data']->start_date)),
                                'max' => date('Y-m-d',strtotime($data['con_data']->end_date))
                                )) 
                            }}
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            {{ Form::label('name', __('Actual Workdone % as of Today'),['class' => 'form-label']) }}
                            <span class="text-danger">*</span>
                            {{ Form::number('percentage', $data['percentage'], ['class' => 'form-control','id' => 'percentage','required'=>'required','max'=>'100','min'=>'1']) }}
                            {{ Form::hidden('task_id', $task_id, ['class' => 'form-control','id'=>'task_id']) }}
                            {{ Form::hidden('user_id', \Auth::user()->id, ['class' => 'form-control']) }}
                        </div>
                    </div>
                    </div>
                   <div class="row min-750" id="taskboard_view">
                        <div class="col-6">
                            <label for="input">{{__('Attachments')}}</label>
                            <input id="upload_file" type="file" class="form-control" name="attachment_file_name[]" multiple>
                            {{ Form::hidden('existing_file_id', $data['file_id'], ['class' => 'form-control', 'id' => 'existing_file_id']) }}
                            <div class="file_name_show">
                                @php
                                    if($data['filename'] != ""){
                                        $files = explode(',',$data['filename']);
                                    }
                                    else{
                                        $files = array();
                                    }
                                @endphp
                                @foreach ($files as $file)
                                    <span class="badge badge-primary" style="background-color:#007bff;margin-top: 5px;">{{$file}}</span> <br>
                                @endforeach
                            </div>
                            <br>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                {{ Form::label('description', __('Description'),['class' => 'form-label']) }} <span style='color:red;'>*</span>
                                {{ Form::textarea('description', $data['description'], ['class' => 'form-control','id' => 'description','rows'=>'3','data-toggle' => 'autosize','required'=>'required']) }}
                            </div>
                        </div>
                   </div>
                    <div class="row">
                        <div class="modal-footer">
                            <input type="submit" value="{{__('Submit')}}" class="btn  btn-primary">
                            <a data-bs-dismiss="modal" class="btn btn-danger">{{__('Close')}}</a>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
