{{Form::model($leave,array('route' => array('leave.update', $leave->id), 'method' => 'PUT')) }}
<div class="modal-body">
 
<div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('employee_id',__('Employee') ,['class'=>'form-label'])}}<span style='color:red;'>*</span>
                {{Form::select('employee_id',$employees,null,array('class'=>'form-control select','required'=>'required','placeholder'=>__('Select Employee')))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('leave_type_id',__('Leave Type'),['class'=>'form-label'])}}<span class="text-danger pl-1">*</span>
                {{Form::select('leave_type_id',$leavetypes,null,array('class'=>'form-control select','placeholder'=>__('Select Leave Type')))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('start_date',__('Start Date'),['class'=>'form-label'])}}<span class="text-danger pl-1">*</span>
                {{Form::date('start_date',null,array('class'=>'form-control ','required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('end_date',__('End Date'),['class'=>'form-label'])}}<span class="text-danger pl-1">*</span>
                {{Form::date('end_date',null,array('class'=>'form-control ','required'=>'required'))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('leave_reason',__('Leave Reason'),['class'=>'form-label'])}}<span class="text-danger pl-1">*</span>
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
    @role('Company')
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('status',__('Status'))}}
                <select name="status" id="" class="form-control select2">
                    <option value="">{{__('Select Status')}}</option>
                    <option value="pending" @if($leave->status=='Pending') selected="" @endif>{{__('Pending')}}</option>
                    <option value="approval" @if($leave->status=='Approval') selected="" @endif>{{__('Approval')}}</option>
                    <option value="reject" @if($leave->status=='Reject') selected="" @endif>{{__('Reject')}}</option>
                </select>
            </div>
        </div>
    </div>
    @endrole

</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>
    {{Form::close()}}

