
{{Form::model($jobCategory,array('route' => array('job-category.update', $jobCategory->id), 'method' => 'PUT')) }}
<div class="modal-body">

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {{Form::label('title',__('Title*'),['class'=>'form-label'])}}
            {{Form::text('title',null,array('class'=>'form-control','required'=>'required','placeholder'=>__('Enter category title')))}}
        </div>
    </div>

</div>
</div>

<div class="modal-footer">
<input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
<input type="submit" value="{{__('Update')}}" class="btn btn-primary">
</div>
{{Form::close()}}

