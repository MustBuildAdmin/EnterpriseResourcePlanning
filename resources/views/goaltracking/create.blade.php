{{Form::open(array('url'=>'goaltracking','method'=>'post'))}}
<div class="modal-body">

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('branch',__('Branch'),['class'=>'form-control-label'])}}<span class="text-danger pl-1">*</span>
                {{Form::select('branch',$brances,null,array('class'=>'form-select','required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('goal_type',__('GoalTypes'),['class'=>'form-control-label'])}}<span class="text-danger pl-1">*</span>
                {{Form::select('goal_type',$goalTypes,null,array('class'=>'form-select','required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('start_date',__('Start Date'),['class'=>'form-control-label'])}}<span class="text-danger pl-1">*</span>
                {{Form::date('start_date',null,array('class' => 'form-control ','required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('end_date',__('End Date'),['class'=>'form-control-label'])}}<span class="text-danger pl-1">*</span>
                {{Form::date('end_date',null,array('class' => 'form-control ','required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('subject',__('Subject'),['class'=>'form-control-label'])}}<span class="text-danger pl-1">*</span>
                {{Form::text('subject',null,array('class'=>'form-control','required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('target_achievement',__('Target Achievement'),['class'=>'form-control-label'])}}
                {{Form::text('target_achievement',null,array('class'=>'form-control'))}}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('description',__('Description'),['class'=>'form-control-label'])}}
                {{Form::textarea('description',null,array('class'=>'form-control'))}}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('status',__('Status'),['class'=>'form-control-label'])}}
                {{Form::select('status',$status,null,array('class'=>'form-select'))}}
            </div>
        </div>

        <div class="col-md-12">
            <fieldset id='demo1' class="rating">
                <input class="stars" type="radio" id="rating-5" name="rating" value="5" >
                <label class="full" for="rating-5" title="Awesome - 5 stars"></label>
                <input class="stars" type="radio" id="rating-4" name="rating" value="4" >
                <label class="full" for="rating-4" title="Pretty good - 4 stars"></label>
                <input class="stars" type="radio" id="rating-3" name="rating" value="3" >
                <label class="full" for="rating-3" title="Meh - 3 stars"></label>
                <input class="stars" type="radio" id="rating-2" name="rating" value="2" >
                <label class="full" for="rating-2" title="Kinda bad - 2 stars"></label>
                <input class="stars" type="radio" id="technical-1" name="rating" value="1" >
                <label class="full" for="technical-1" title="Sucks big time - 1 star"></label>
            </fieldset>
        </div>



    </div>
    <div class="modal-footer">
        <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
    </div>
    </div>

{{Form::close()}}
