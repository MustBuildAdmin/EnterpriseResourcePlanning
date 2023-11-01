<style>
.form-check {
    margin: 8px 12px !important;
}

#project_id{
    display:none;
}
</style>
{{Form::open(array('url'=>'project_holiday','method'=>'post'))}}
<div class="modal-body">

    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <select class="form-control" required name='project_id' id="project_id">
                        @foreach($projects as $key => $value)
                            <option value="{{$value->id}}" >{{$value->project_name}}</option>
                        @endforeach
                </select>
                <br>
                {{Form::label('date',__('Date'),['class'=>'form-label'])}}
                <div class="mb-3">
                    <div class="input-icon">
                        <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon"
                             width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                            <path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M11 15h1" />
                            <path d="M12 15v3" /></svg>
                        </span>
                        <input class="form-control" placeholder="Select a date"
                         id="datepicker-icon-prepend" name="date" required/>
                        </div>
                </div>
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
                    $('#error').text('Project Name already exit');
                }else{
                    $('#error').text('');
                }
                
            },
        });
        
    }
});
</script>


<script src="{{ asset('tabler/tabler.min.js') }}"></script>
<script src="{{ asset('theme/demo-theme.min.js') }}"></script>
<script src="{{ asset('litepicker/litepicker.js') }}"></script>
<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>

<script>
    $( document ).ready(function() {
        window.Litepicker && (new Litepicker({
            element: document.getElementById('datepicker-icon-prepend'),
            buttonText: {
                previousMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none"
                d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
                
                nextMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"
                fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
            },
        }));
    });
</script>