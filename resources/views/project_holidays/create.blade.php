<style>
.form-check {
    margin: 8px 12px !important;
}
</style>

{{Form::open(array('url'=>'project_holiday','method'=>'post'))}}
<div class="modal-body">

    <div class="row">
        <div class="col-12">
            <div class="form-group">
                {{Form::label('project',__('Project'),['class'=>'form-label'])}}
                <select class="form-control" required name='project_id'>
                    <option value="">{{__('Select_Project')}}</option>
                        @foreach($projects as $key => $value)
                            <option value="{{$value->id}}">{{$value->project_name}}</option>
                        @endforeach
                </select>
                <br>
                {{Form::label('date',__('Date'),['class'=>'form-label'])}}
                {{Form::date('date',null,array('class'=>'form-control','required' => 'required'))}}
                <br>
                {{Form::label('description',__('Description'),['class'=>'form-label'])}}
                {{Form::textarea('description',null,array('class'=>'form-control','required' => 'required'))}}
        
            </div>
        
                @error('name')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>  
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{Form::close()}}

<script>
var tempcsrf = '{!! csrf_token() !!}';
$(document).on("keyup", '#name', function () {
    var tt= $(this).val().length;
    if(tt>3){
        var name= $(this).val();
        $.ajax({
        url: "{{ route('construction_name_presented') }}",
        type: "GET",
            data: {
                _token: tempcsrf,
                name: name
            },
            success: function(data) {
                if(data=='in'){
                    // show_toastr('error', 'Please enter valid date');
                    $('#error').text('Project Name already exit');
                }else{
                    $('#error').text('');
                }
                
            },
        });
        
    }
});
</script>

