{{Form::model($ducumentUpload,array('route' => array('document-upload.update', $ducumentUpload->id), 'class'=>'forms_doc','method' => 'PUT','enctype' => "multipart/form-data")) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('name',__('Name*'),['class'=>'form-label'])}}
                {{Form::text('name',null,array('class'=>'form-control get_name','required'=>'required'))}}
                <br>
                <span class="invalid-name show_duplicate_error" role="alert" style="display: none;"> 
                    <strong class="text-danger">Branch Name Already Exist!</strong>
                </span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('role',__('Role'),['class'=>'form-label'])}}
                {{Form::select('role',$roles,null,array('class'=>'form-control select'))}}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('description', __('Description'),['class'=>'form-label']) }}
                {{ Form::textarea('description',null, array('class' => 'form-control','rows'=> 3)) }}
            </div>
        </div>
        <div class="col-md-6 form-group">
            <label name="document" for="" class="form-label">{{__('Document')}} <span style='color:red;'>*</span></label>
            <div class="choose-file">
                <label for="document" class="form-label">
                    <input name="inputimage" type="file" class="form-control" name="document" id="document" data-filename="document_create" >
                    {{-- <img id="image" src="{{asset(Storage::url('uploads/documentUpload')).'/'.$ducumentUpload->document}}" class="mt-3" style="width:25%;"/> --}}
                    <br>
                    <span class="show_document_file" style="color:green;">{{ $ducumentUpload->document }}</span>
                </label>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn btn-primary submit_button">
</div>
{{Form::close()}}

<script>
    $(document).ready(function(){
        $(document).on("keyup", '.get_name', function () {
            $.ajax({
                url : '{{ route("checkDuplicateRS_HRM") }}',
                type : 'GET',
                data : { 'get_id': "{{$ducumentUpload->id}}", 'get_name' : $(".get_name").val(), 'form_name' : "DocumentSetup" },
                success : function(data) {
                    if(data == 1){
                        $(".submit_button").prop('disabled',false);
                        $(".show_duplicate_error").css('display','none');
                    }
                    else{
                        $(".submit_button").prop('disabled',true);
                        $(".show_duplicate_error").css('display','block');
                    }
                },
                error : function(request,error)
                {
                    alert("Request: "+JSON.stringify(request));
                }
            });
        });
    });

    document.getElementById('document').onchange = function () {
        $(".show_document_file").show();
        $(".show_document_file").html(this.files[0].name);
        // var src = URL.createObjectURL(this.files[0])
        // document.getElementById('image').src = src
    }

    $('.forms_doc').validate({
        rules: { inputimage: { required: true, accept: "png|jpeg|jpg|doc|pdf|exls", filesize: 100000  }},
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

