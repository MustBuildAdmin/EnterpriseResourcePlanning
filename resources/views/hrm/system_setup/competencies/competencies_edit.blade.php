
{{Form::model($competencies,array('route' => array('competencies.update', $competencies->id), 'method' => 'PUT')) }}
<div class="modal-body">

<div class="row ">
    <div class="col-12">
        <div class="form-group">
            {{Form::label('name',__('Name*'),['class'=>'form-label'])}}
            {{Form::text('name',null,array('class'=>'form-control get_name','required'=>'required'))}}
            <br>
            <span class="invalid-name show_duplicate_error" role="alert" style="display: none;"> 
                <strong class="text-danger">Competencies Name Already Exist!</strong>
            </span>
            @error('name')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            {{Form::label('type',__('Type*'),['class'=>'form-label'])}}
            {{Form::select('type',$performance,null,array('class'=>'form-select','required'=>'required', 'placeholder'=>'Select Type'))}}
        </div>
    </div>

</div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" id="edit_competencies" value="{{__('Update')}}" class="btn btn-primary submit_button">
</div>
{{Form::close()}}

<script> 
    $(document).ready(function(){
        $(document).on("keyup", '.get_name', function () {
            $(".show_duplicate_error").css('display','none');
            $.ajax({
                url : '{{ route("checkDuplicateRS_HRM") }}',
                type : 'GET',
                data : { 'get_id': "{{$competencies->id}}", 'get_name' : $(".get_name").val(), 'form_name' : "Competencies" },
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
        $(document).on('submit', 'form', function() {
            $('#edit_competencies').attr('disabled', 'disabled');
        });
    });
</script>