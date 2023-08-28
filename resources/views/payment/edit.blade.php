{{ Form::model($payment, array('route' => array('payment.update', $payment->id), 'method' => 'PUT','enctype' => 'multipart/form-data')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-6">
            {{ Form::label('date', __('Date'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{Form::date('date',null,array('class'=>'form-control','required'=>'required'))}}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('amount', __('Amount'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::number('amount', null, array('class' => 'form-control','required'=>'required','step'=>'0.01')) }}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('account_id', __('Account'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::select('account_id',$accounts,null, array('class' => 'form-select','required'=>'required')) }}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('vender_id', __('Vendor'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::select('vender_id', $venders,null, array('class' => 'form-select','required'=>'required')) }}
        </div>
        <div class="form-group  col-md-12">
            {{ Form::label('description', __('Description'),['class'=>'form-label']) }}
            {{ Form::textarea('description', null, array('class' => 'form-control','rows'=>3)) }}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('category_id', __('Category'),['class'=>'form-label']) }}<span class="text-danger">*</span>
            {{ Form::select('category_id', $categories,null, array('class' => 'form-select','required'=>'required')) }}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('reference', __('Reference'),['class'=>'form-label']) }}
            {{ Form::text('reference', null, array('class' => 'form-control')) }}
        </div>

        <div class="form-group col-md-6">
            {{Form::label('add_receipt',__('Payment Receipt'),['class' => 'col-form-label'])}}<span style='color:red;'>*</span><span style="font-size: 2m;font-size: 11px;color: #c71616;"> Size of image should not be more than 2MB</span>
            {{Form::file('add_receipt',array('class'=>'form-control','required'=>'required', 'id'=>'files','accept'=>"image/jpeg,image/gif,image/png,.pdf,.docx,.doc,.webp"))}}
            <img id="image" class="mt-2" src="{{asset(Storage::url('uploads/payment')).'/'.$payment->add_receipt}}" style="width:25%;"/>

        </div>

    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>
{{ Form::close() }}


<script>
    document.getElementById('files').onchange = function () {
        var src = URL.createObjectURL(this.files[0])
        document.getElementById('image').src = src
    }
</script>

