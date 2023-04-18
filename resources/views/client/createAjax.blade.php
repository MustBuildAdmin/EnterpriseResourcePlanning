<div class="card bg-none card-box">
    {{ Form::open(array('url' => 'clients')) }}
    <div class="row">
        <div class="col-6 form-group">
            {{ Form::label('name', __('Name'),['class'=>'form-label']) }}
            {{ Form::text('name', null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="col-6 form-group">
            {{ Form::label('email', __('E-Mail Address'),['class'=>'form-label']) }}
            {{ Form::email('email', null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="col-6 form-group">
            {{ Form::label('password', __('Password'),['class'=>'form-label']) }}
            {{ Form::password('password', null, array('class' => 'form-control','required'=>'required')) }}
        </div>

        <div class="form-group mt-4 mb-0">
            {{ Form::hidden('ajax',true) }}
            <input type="submit" value="{{__('Create')}}" class="btn-create badge-blue">
        </div>
    </div>
    {{ Form::close() }}
</div>
