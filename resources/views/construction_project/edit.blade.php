<style>
    .form-check {
        margin: 8px 12px !important;
    }
    </style>
    
{{Form::model($projects,array('route' => array('construction_project.update', $projects->id), 'method' => 'PUT')) }}
<div class="modal-body">

    <div class="row">
        <div class="col-12">
            <div class="form-group">
                {{Form::label('name',__('Name'),['class'=>'form-label'])}}<span class="text-danger">*</span>
                {{Form::text('name',null,array('class'=>'form-control','required' => 'required','placeholder'=>__('Enter Project Name')))}}
                <br>
                {{Form::label('project_location',__('Project_Location'),['class'=>'form-label'])}}<span class="text-danger">*</span>
                {{Form::text('project_location',null,array('class'=>'form-control','required' => 'required','placeholder'=>__('Enter Project Location')))}}
                <br>
                {{Form::label('start_date',__('Start Date'),['class'=>'form-label'])}}<span class="text-danger">*</span>
                {{Form::date('start_date',null,array('class'=>'form-control','required' => 'required'))}}
                <br>
                {{Form::label('end_date',__('End Date'),['class'=>'form-label'])}}<span class="text-danger">*</span>
                {{Form::date('end_date',null,array('class'=>'form-control','required' => 'required'))}}
                <br>
                {{Form::label('project_budget',__('Project Budget'),['class'=>'form-label'])}}<span class="text-danger">*</span>
                {{Form::number('project_budget',null,array('class'=>'form-control','min'=>1,'required' => 'required'))}}
                <br>
                {{ Form::label('client', __('Client'),['class'=>'form-label']) }}<span class="text-danger">*</span>
                {!! Form::select('client', $clients, $projects->client_id,array('class' => 'form-control select2','id'=>'choices-multiple1','required'=>'required')) !!}
                <br>
                {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
                <select name="status" id="status" class="form-control main-element select2" >
                    @foreach(\App\Models\Construction_project::$project_status as $k => $v)
                        <option value="{{$k}}" {{ ($projects->status == $k) ? 'selected' : ''}}>{{__($v)}}</option>
                    @endforeach
                </select>
                <br>
                {{Form::label('non_working_days',__('non_working_days'),['class'=>'form-label'])}}<span class="text-danger">*</span>
                <br>
                <div style='display:flex;flex-wrap: wrap;align-content: stretch;'>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" name='non_working_days[]' id='monday' @if(str_contains($projects->non_working_days, '1')) checked @endif>
                    <label class="form-check-label" for="monday">
                    Monday
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="2" name='non_working_days[]' id='tuesday' @if(str_contains($projects->non_working_days, '2')) checked @endif>
                    <label class="form-check-label" for="tuesday">
                    Tuesday
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="3" name='non_working_days[]' id='wednesday' @if(str_contains($projects->non_working_days, '3')) checked @endif>
                    <label class="form-check-label" for="wednesday">
                        Wednesday
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="4" name='non_working_days[]' id='thursday' @if(str_contains($projects->non_working_days, '4')) checked @endif>
                    <label class="form-check-label" for="thursday">
                        Thursday
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="5" name='non_working_days[]' id='friday' @if(str_contains($projects->non_working_days, '5')) checked @endif>
                    <label class="form-check-label" for="friday">
                        Friday
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="6" name='non_working_days[]' id='saturday' @if(str_contains($projects->non_working_days, '6')) checked @endif>
                    <label class="form-check-label" for="saturday">
                        Saturday
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="7" name='non_working_days[]' id='sunday' @if(str_contains($projects->non_working_days, '7')) checked @endif>
                    <label class="form-check-label" for="sunday">
                        Sunday
                    </label>
                </div>
                </div>
                {{Form::label('holidays',__('holiday_status'),['class'=>'form-label'])}}<span class="text-danger">*</span>
                <div style='display:flex;flex-wrap: wrap;align-content: stretch;'>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name='holidays' id='monday'@if($projects->holidays==1) checked @endif>
                        <label class="form-check-label" for="monday">
                            {{__('holidays')}}
                        </label>
                    </div>
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

