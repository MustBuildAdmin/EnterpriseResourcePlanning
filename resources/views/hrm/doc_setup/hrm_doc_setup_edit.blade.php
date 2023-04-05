{{Form::model($ducumentUpload,array('route' => array('document-upload.update', $ducumentUpload->id), 'method' => 'PUT','enctype' => "multipart/form-data")) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('name',__('Name*'),['class'=>'form-label'])}}
                {{Form::text('name',null,array('class'=>'form-control','required'=>'required'))}}
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
            {{Form::label('document',__('Document'),['class'=>'form-label'])}}<span style='color:red;'>*</span>
            <div class="choose-file">
                <label for="document" class="form-label">
                    <input type="file" class="form-control" name="document" id="document" data-filename="document_create" >
                    <img id="image" src="{{asset(Storage::url('uploads/documentUpload')).'/'.$ducumentUpload->document}}" class="mt-3" style="width:25%;"/>
                </label>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn btn-primary">
</div>
{{Form::close()}}

<script>
    document.getElementById('document').onchange = function () {
        var src = URL.createObjectURL(this.files[0])
        document.getElementById('image').src = src
    }
</script>

