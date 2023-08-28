{{ Form::model($employee, array('route' => array('employee.salary.update', $employee->id), 'method' => 'POST')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('salary_type', __('Payslip Type'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::select('salary_type',$payslip_type,null, array('class' => 'form-select','required'=>'required')) }}
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('salary', __('Salary'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{ Form::number('salary',null, array('class' => 'form-control ','required'=>'required')) }}
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Save Change')}}" class="btn  btn-primary">
</div>
{{ Form::close() }}
