{{ Form::model($revenue, array('route' => array('revenue.update', $revenue->id), 'method' => 'PUT','enctype' => 'multipart/form-data')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-6">
            {{ Form::label('date', __('Date'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{Form::date('date',null,array('class'=>'form-control','required'=>'required'))}}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('amount', __('Amount'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{ Form::number('amount', null, array('class' => 'form-control','required'=>'required','step'=>'0.01')) }}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('account_id', __('Account'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{ Form::select('account_id',$accounts,null, array('class' => 'form-select','required'=>'required')) }}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('customer_id', __('Customer'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{ Form::select('customer_id', $customers,null, array('class' => 'form-select','required'=>'required')) }}
        </div>
        <div class="form-group  col-md-12">
            {{ Form::label('description', __('Description'),['class'=>'form-label']) }}
            {{ Form::textarea('description', null, array('class' => 'form-control','rows'=>3)) }}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('category_id', __('Category'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{ Form::select('category_id', $categories,null, array('class' => 'form-select','required'=>'required')) }}
        </div>

        <div class="form-group  col-md-6">
            {{ Form::label('reference', __('Reference'),['class'=>'form-label']) }}
            {{ Form::text('reference', null, array('class' => 'form-control')) }}

        </div>


        <div class="form-group col-md-6">

            {{Form::label('add_receipt',__('Payment Receipt'),['class' => 'col-form-label'])}}<span style='color:red;'>*</span>
            {{Form::file('add_receipt',array('class'=>'form-control','required'=>'required', 'id'=>'files'))}}
            <img id="image" src="{{asset(Storage::url('uploads/revenue')).'/'.$revenue->add_receipt}}" class="mt-2" style="width:25%;"/>
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
