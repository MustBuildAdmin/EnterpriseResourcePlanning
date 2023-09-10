{{Form::open(array('url'=>'award','method'=>'post'))}}
<div class="modal-body">

    <div class="row">
        <div class="form-group col-md-6 col-lg-6 ">
            {{ Form::label('employee_id', __('Employee*'),['class'=>'form-label'])}}
            {{ Form::select('employee_id', $employees,null, array('class' => 'form-select','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6 col-lg-6">
            {{ Form::label('award_type', __('Award Type*'),['class'=>'form-label'])}}
            {{ Form::select('award_type', $awardtypes,null, array('class' => 'form-select','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6 col-lg-6">
            {{Form::label('date',__('Date*'),['class'=>'form-label'])}}
            {{Form::date('date',null,array('class'=>'form-control','required'=>'required'))}}
        </div>
        <div class="form-group col-md-6 col-lg-6">
            {{Form::label('gift',__('Gift*'),['class'=>'form-label'])}}
            {{Form::text('gift',null,array('class'=>'form-control','required'=>'required','placeholder'=>__('Enter Gift')))}}
        </div>
        <div class="form-group col-md-12">
            {{Form::label('description',__('Description'))}}<span style='color:red;'>*</span>
            {{Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Description'),'required'=>'required'))}}
        </div>
        
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>

    {{Form::close()}}
