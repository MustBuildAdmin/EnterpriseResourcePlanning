{{Form::model($overtime,array('route' => array('overtime.update', $overtime->id), 'method' => 'PUT')) }}
<div class="modal-body">

    <div class="card-body p-0">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('title', __('Title'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
                    {{ Form::text('title',null, array('class' => 'form-control ','required'=>'required')) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('number_of_days', __('Number Of Days'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
                    {{ Form::text('number_of_days',null, array('class' => 'form-control ','required'=>'required')) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('hours', __('Hours'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
                    {{ Form::text('hours',null, array('class' => 'form-control ','required'=>'required')) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('rate', __('Rate'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
                    {{ Form::number('rate',null, array('class' => 'form-control ','required'=>'required')) }}
                </div>
            </div>
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>
{{Form::close()}}


