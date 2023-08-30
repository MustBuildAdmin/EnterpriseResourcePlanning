
{{Form::open(array('url'=>'training','method'=>'post'))}}
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('branch',__('Branch*'),['class'=>'form-label'])}}
                {{Form::select('branch',$branches,null,array('class'=>'form-select','required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('trainer_option',__('Trainer Option*'),['class'=>'form-label'])}}
                {{Form::select('trainer_option',$options,null,array('class'=>'form-select','required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('training_type',__('Training Type*'),['class'=>'form-label'])}}
                {{Form::select('training_type',$trainingTypes,null,array('class'=>'form-select','required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('trainer',__('Trainer*'),['class'=>'form-label'])}}
                {{Form::select('trainer',$trainers,null,array('class'=>'form-select','required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('training_cost',__('Training Cost*'),['class'=>'form-label'])}} ({{$setting['site_currency_symbol']}})
                {{Form::number('training_cost',null,array('class'=>'form-control','step'=>'0.01','required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('employee',__('Employee*'),['class'=>'form-label'])}}
                {{Form::select('employee',$employees,null,array('class'=>'form-select','required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('start_date',__('Start Date*'),['class'=>'form-label'])}}
                {{Form::date('start_date',null,array('class'=>'form-control ','required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('end_date',__('End Date*'),['class'=>'form-label'])}}
                {{Form::date('end_date',null,array('class'=>'form-control ','required'=>'required'))}}
            </div>
        </div>
        <div class="form-group col-lg-12">
            {{Form::label('description',__('Description'),['class'=>'form-label'])}}
            {{Form::textarea('description',null,array('class'=>'form-control','maxlength' => 200,'placeholder'=>__('Description')))}}
        </div>
    
    
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
    
{{Form::close()}}
