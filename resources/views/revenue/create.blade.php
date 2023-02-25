{{ Form::open(array('url' => 'revenue','enctype' => 'multipart/form-data')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('date', __('Date'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{Form::date('date',null,array('class'=>'form-control','required'=>'required'))}}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('amount', __('Amount'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{ Form::number('amount', '', array('class' => 'form-control','required'=>'required','step'=>'0.01')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('account_id', __('Account'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{ Form::select('account_id',$accounts,null, array('class' => 'form-control select','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6"
            {{ Form::label('customer_id', __('Customer'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{ Form::select('customer_id', $customers,null, array('class' => 'form-control select','required'=>'required')) }}
        </div>
        <div class="form-group  col-md-12">
            {{ Form::label('description', __('Description'),['class'=>'form-label']) }}
            {{ Form::textarea('description', '', array('class' => 'form-control','rows'=>3)) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('category_id', __('Category'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{ Form::select('category_id', $categories,null, array('class' => 'form-control select','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('reference', __('Reference'),['class'=>'form-label']) }}
            {{ Form::text('reference', '', array('class' => 'form-control')) }}
        </div>

{{--        <div class="col-md-6">--}}
{{--            {{ Form::label('add_receipt', __('Payment Receipt'), ['class' => 'form-label']) }}--}}
{{--            <div class="choose-file form-group">--}}
{{--                <label for="file" class="form-label">--}}
{{--                    <input type="file" name="add_receipt" id="image" class="form-control" accept="image/*, .txt, .rar, .zip" >--}}
{{--                </label>--}}
{{--                <p class="upload_file"></p>--}}

{{--            </div>--}}
{{--        </div>--}}

    <div class="form-group col-md-6">

        {{Form::label('add_receipt',__('Payment Receipt'),['class' => 'col-form-label'])}}<span style='color:red;'>*</span>
        {{Form::file('add_receipt',array('class'=>'form-control','required'=>'required', 'id'=>'files'))}}
        <img id="image" class="mt-3" style="width:25%;"/>
    </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{ Form::close() }}

<script>
    document.getElementById('files').onchange = function () {
        var src = URL.createObjectURL(this.files[0])
        document.getElementById('image').src = src
    }
</script>
