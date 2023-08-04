
{{Form::model($project_holiday,array('route' => array('project_holiday.update', $project_holiday->id), 'method' => 'PUT')) }}
        <div class="modal-body">
        
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        {{Form::label('project',__('Project'),['class'=>'form-label'])}}
                        <select class="form-control" required name='project_id'>
                                @foreach($projects as $key => $value)
                                    <option value="{{$value->id}}" @if($project_holiday->project_id==$value->id) selected  @endif>{{$value->project_name}}</option>
                                @endforeach
                        </select>
                        <br>
                        {{Form::label('date',__('Date'),['class'=>'form-label'])}}
                        {{Form::date('date',null,array('class'=>'form-control','required' => 'required'))}}
                        <br>
                        {{Form::label('description',__('Description'),['class'=>'form-label'])}}
                        {{Form::textarea('description',null,array('class'=>'form-control','required' => 'required'))}}
                
                    </div>
                
                        @error('name')
                        <span class="invalid-name" role="alert">
                            <strong class="text-danger">{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>  
            </div>
        </div>
        <div class="modal-footer">
            <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
            <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
        </div>
        {{Form::close()}}
     