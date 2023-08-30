{{Form::model($companyPolicy,array('route' => array('company-policy.update', $companyPolicy->id), 'method' => 'PUT','enctype' => "multipart/form-data")) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('branch',__('Branch*'),['class'=>'form-label'])}}
                {{Form::select('branch',$branch,null,array('class'=>'form-select','required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('title',__('Title*'),['class'=>'form-label'])}}
                {{Form::text('title',null,array('class'=>'form-control','required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('description', __('Description'),['class'=>'form-label'])}}
                {{ Form::textarea('description',null, array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="col-md-12">
            {{Form::label('attachment',__('Attachment'),['class'=>'form-label'])}}
            <div class="choose-file form-group">
                <label for="attachment" class="form-label">
                    @php
                        $policyPath=\App\Models\Utility::get_file('uploads/companyPolicy/');
                        $logo=\App\Models\Utility::get_file('uploads/companyPolicy/');
                    @endphp
{{--                    <input type="file" class="form-control" name="attachment" id="attachment" data-filename="attachment_create">--}}
                    <input type="file" class="form-control " name="attachment" id="attachment" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" accept=".jpeg,.png,.jpg,.pdf,.doc">

{{--                    <img id="image" class="mt-3" style="width:25%;"/>--}}
                    <img id="image"  width="25%;" class="mt-3" src="@if($companyPolicy->attachment){{$policyPath.$companyPolicy->attachment}}@else{{$logo.'user-2_1654779769.jpg'}}@endif" />


                </label>
            </div>
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>
{{Form::close()}}


<script>
    document.getElementById('attachment').onchange = function () {
        var src = URL.createObjectURL(this.files[0])
        document.getElementById('image').src = src
    }
</script>



