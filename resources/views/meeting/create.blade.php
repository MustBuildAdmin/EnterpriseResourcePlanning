{{Form::open(array('url'=>'meeting','method'=>'post'))}}
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('branch_id',__('Branch*'),['class'=>'form-label'])}}
                <select class="form-select" name="branch_id" id="branch_id" placeholder="Select Branch" required>
                    <option value="">{{__('Select Branch')}}</option>
                    <option value="0">{{__('All Branch')}}</option>
                    @foreach($branch as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group" id="department_div">
                {{Form::label('department_id',__('Department*'),['class'=>'form-label'])}}
                <select class="form-select" name="department_id[]" id="department_id" placeholder="Select Department" required>

                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group" id="employee_div">
                {{Form::label('employee_id',__('Employee*'),['class'=>'form-label'])}}
                <select class="form-select" name="employee_id[]" id="employee_id" placeholder="Select Employee" required >
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('title',__('Meeting Title*'),['class'=>'form-label'])}}
                {{Form::text('title',null,array('class'=>'form-control','required'=>'required','placeholder'=>__('Enter Meeting Title')))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('date',__('Meeting Date*'),['class'=>'form-label'])}}
                {{Form::date('date',null,array('class'=>'form-control ','required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('time',__('Meeting Time*'),['class'=>'form-label'])}}
                {{Form::time('time',null,array('class'=>'form-control timepicker','required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('note',__('Meeting Note'),['class'=>'form-label'])}}
                {{Form::textarea('note',null,array('class'=>'form-control','placeholder'=>__('Enter Meeting Note')))}}
            </div>
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{Form::close()}}

