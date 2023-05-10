{{ Form::open(array('route' => array('customer.import'),'method'=>'post', 'enctype' => "multipart/form-data")) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-12 mb-6">
            {{Form::label('file',__('Download sample customer CSV file'),['class'=>'form-label'])}}
            <a href="{{asset(Storage::url('uploads/sample')).'/sample-customer.csv'}}" class="btn btn-sm btn-primary">
                <i class="ti ti-download"></i> {{__('Download')}}
            </a>
        </div>
        <div class="col-md-12">
            {{Form::label('file',__('Select CSV File'),['class'=>'form-label'])}}
            <div class="choose-file form-group">
                <label for="file" class="form-label">
                    <input type="file" class="form-control" accept=".xlsx, .xls, .csv" name="file" id="file" data-filename="upload_file" required>
                </label>
                <p class="upload_file"></p>
            </div>
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Upload')}}" id="upload_customer" class="btn  btn-primary">
</div>
{{ Form::close() }}

<script>
    document.getElementById('file').onchange = function () {
        var fileInput =  document.getElementById("file");
        var fileName=fileInput.files[0].name.substring(fileInput.files[0].name.lastIndexOf('.') + 1);
        if(fileName=='csv' || fileName=='xlsx' || fileName=='xls'){
            document.getElementById('file').classList="form-control valid";
            document.getElementById('file_error').innerHTML='';
            document.getElementById('upload_customer').disabled=false;
        }
        else if(fileInput.files[0] && fileInput.files[0].size>2097152){
            document.getElementById('file').classList="form-control error";
            document.getElementById('file_error').innerHTML='Size of image should not be more than 2MB';
            document.getElementById('upload_customer').disabled=true;
        }else{
            document.getElementById('file').classList="form-control error";
            document.getElementById('file_error').innerHTML='Upload valid file';
            document.getElementById('upload_customer').disabled=true;
        }
    }
</script>