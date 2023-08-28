{{Form::model($travel,array('route' => array('travel.update', $travel->id), 'method' => 'PUT')) }}
 <div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('employee_id', __('Employee*'),['class'=>'form-label'])}}
            {{ Form::select('employee_id', $employees,null, array('class' => 'form-select','required'=>'required')) }}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('start_date',__('Start Date*'),['class'=>'form-label'])}}
            {{Form::date('start_date',null,array('class'=>'form-control','required'=>'required'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('end_date',__('End Date*'),['class'=>'form-label'])}}
            {{Form::date('end_date',null,array('class'=>'form-control','required'=>'required'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('purpose_of_visit',__('Purpose of Trip*'),['class'=>'form-label'])}}
            {{Form::text('purpose_of_visit',null,array('class'=>'form-control','required'=>'required'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('place_of_visit',__('Country*'),['class'=>'form-label'])}}
            {{Form::text('place_of_visit',null,array('class'=>'form-control','required'=>'required'))}}
        </div>
        <div class="form-group col-md-12">
            {{Form::label('description',__('Description'),['class'=>'form-label'])}}<span style='color:red;'>*</span>
            {{Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Description'),'required'=>'required'))}}
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>
{{Form::close()}}
