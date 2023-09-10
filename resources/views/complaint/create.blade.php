{{Form::open(array('url'=>'complaint','method'=>'post'))}}
<div class="modal-body">
    <div class="row">
        @if(\Auth::user()->type !='employee')
            <div class="form-group col-md-6 col-lg-6 ">
                {{ Form::label('complaint_from', __('Complaint From*'),['class'=>'form-label'])}}
                {{ Form::select('complaint_from', $employees,null, array('class' => 'form-control  select','required'=>'required')) }}
            </div>
        @endif
        <div class="form-group col-md-6 col-lg-6">
            {{Form::label('complaint_against',__('Complaint Against*'),['class'=>'form-label'])}}
            {{Form::select('complaint_against',$employees,null,array('class'=>'form-select','required'=>'required'))}}
        </div>
        <div class="form-group col-md-6 col-lg-6">
            {{Form::label('title',__('Title*'),['class'=>'form-label'])}}
            {{Form::text('title',null,array('class'=>'form-control','required'=>'required'))}}
        </div>
        <div class="form-group col-md-6 col-lg-6">
            {{Form::label('complaint_date',__('Complaint Date*'),['class'=>'form-label'])}}
            {{Form::date('complaint_date',null,array('class'=>'form-control','required'=>'required'))}}
        </div>
        <div class="form-group col-md-12">
            {{Form::label('description',__('Description'),['class'=>'form-label'])}}<span style='color:red;'>*</span>
            {{Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Description'),'required'=>'required'))}}
        </div>
        
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>

{{Form::close()}}
