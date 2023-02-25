{{Form::open(array('url'=>'trainer','method'=>'post'))}}
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('branch',__('Branch*'),['class'=>'form-label'])}}
                {{Form::select('branch',$branches,null,array('class'=>'form-control select','required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('firstname',__('First Name*'),['class'=>'form-label'])}}
                {{Form::text('firstname',null,array('class'=>'form-control','maxlength' => 35,'required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('lastname',__('Last Name*'),['class'=>'form-label'])}}
                {{Form::text('lastname',null,array('class'=>'form-control','maxlength' => 35,'required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('contact',__('Contact*'),['class'=>'form-label'])}}<span>(with country code)</span>
                {{Form::number('contact',null,array('class'=>'form-control','maxlength' => 16,'required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('email',__('Email*'),['class'=>'form-label'])}}
                {{Form::text('email',null,array('class'=>'form-control','required'=>'required'))}}
            </div>
        </div>
        <div class="form-group col-lg-12">
            {{Form::label('expertise',__('Expertise'),['class'=>'form-label'])}}
            {{Form::textarea('expertise',null,array('class'=>'form-control','maxlength' => 200,'placeholder'=>__('Expertise')))}}
        </div>
        <div class="form-group col-lg-12">
            {{Form::label('address',__('Address'),['class'=>'form-label'])}}
            {{Form::textarea('address',null,array('class'=>'form-control','maxlength' => 200,'placeholder'=>__('Address')))}}
        </div>
    
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{Form::close()}}
