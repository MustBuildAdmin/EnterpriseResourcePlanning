{{Form::open(array('url'=>'leave','method'=>'post'))}}
    <div class="modal-body">

    @if(\Auth::user()->type !='employee')
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {{Form::label('employee_id',__('Employee') ,['class'=>'form-label'])}}<span style='color:red;'>*</span>
                    {{Form::select('employee_id',$employees,null,array('class'=>'form-select','id'=>'employee_id', 'required'=>'required','placeholder'=>__('Select Employee')))}}
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('leave_type_id',__('Leave Type') ,['class'=>'form-label'])}}<span class="text-danger pl-1">*</span>
                <select name="leave_type_id" id="leave_type_id" class="form-select" required>
                    @foreach($leavetypes as $leave)
                        <option value="{{ $leave->id }}">{{ $leave->title }} (<p class="float-right pr-5">{{ $leave->days }}</p>)</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('start_date', __('Start Date'),['class'=>'form-label']) }}<span class="text-danger pl-1">*</span>
                {{Form::date('start_date',null,array('class'=>'form-control','required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('end_date', __('End Date'),['class'=>'form-label']) }}<span class="text-danger pl-1">*</span>
                {{Form::date('end_date',null,array('class'=>'form-control','required'=>'required'))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('leave_reason',__('Leave Reason') ,['class'=>'form-label'])}}<span class="text-danger pl-1">*</span>
                {{Form::textarea('leave_reason',null,array('class'=>'form-control','maxlength' => 80 ,'required'=>'required','placeholder'=>__('Leave Reason')))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('remark',__('Remark'),['class'=>'form-label'])}}<span class="text-danger pl-1">*</span>
                {{Form::textarea('remark',null,array('class'=>'form-control','maxlength' => 80 ,'required'=>'required','placeholder'=>__('Leave Remark')))}}
            </div>
        </div>
       
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{Form::close()}}
