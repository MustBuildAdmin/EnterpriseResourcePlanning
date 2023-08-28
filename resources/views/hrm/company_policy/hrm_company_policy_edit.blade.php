{{Form::model($companyPolicy,array('route' => array('company-policy.update', $companyPolicy->id), 'method' => 'PUT','class'=>'forms_doc','enctype' => "multipart/form-data")) }}
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
                    {{-- <input type="file" class="form-control" name="attachment" id="attachment" data-filename="attachment_create"> --}}
                    <input type="file" class="form-control " name="attachment" id="attachment" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" accept=".jpeg,.png,.jpg,.pdf,.doc">
                    {{-- <img id="image"  width="25%;" class="mt-3" src="@if($companyPolicy->attachment){{$policyPath.$companyPolicy->attachment}}@else{{$logo.'user-2_1654779769.jpg'}}@endif" /> --}}
                    <br>
                    <span class="show_document_file" style="color:green;">{{$companyPolicy->file}}</span>
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
        $(".show_document_file").show();
        $(".show_document_file").html(this.files[0].name);
        // var src = URL.createObjectURL(this.files[0])
        // document.getElementById('image').src = src
    }

    $('.forms_doc').validate({
        rules: { attachment: { required: true, accept: "png|jpeg|jpg|doc|pdf|exls", filesize: 100000  }},
    });

    jQuery.validator.addMethod("filesize", function(value, element, param) {
        var fileSize = element.files[0].size;
        var size = Math.round((fileSize / 1024));

        /* checking for less than or equals to 20MB file size */
        if (size <= 20*1024) {
            return true;
        } else {
            $(".show_document_file").hide();
            return false;
        }   
    }, "Invalid file size, please select a file less than or equal to 20mb size");

    jQuery.validator.addMethod("accept", function(value, element, param) {
        var extension = value.substr(value.lastIndexOf("."));
        var allowedExtensionsRegx = /(\.jpg|\.jpeg|\.png|\.doc|\.pdf|\.exls)$/i;
        var isAllowed = allowedExtensionsRegx.test(extension);

        if(isAllowed){
            return true;
        }else{
            $(".show_document_file").hide();
            return false;
        }
    }, "File must be png|jpeg|jpg|doc|pdf|exls");
</script>



