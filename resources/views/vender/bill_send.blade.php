<div class="card bg-none card-box">
    {{ Form::open(array('route' => array('vender.bill.send.mail',$bill_id))) }}
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('email', __('Email')) }}
            {{ Form::text('email', '', array('class' => 'form-control','required'=>'required')) }}
            @error('email')
            <span class="invalid-email" role="alert">
            <strong class="text-danger">{{ $message }}</strong>
        </span>
            @enderror
        </div>
    </div>
    <div class="col-md-12 px-0">
        <input type="submit" value="{{__('Create')}}" class="btn-create badge-blue">
        <input type="button" value="{{__('Cancel')}}" class="btn-create bg-gray" data-dismiss="modal">
    </div>
    {{ Form::close() }}

</div>
