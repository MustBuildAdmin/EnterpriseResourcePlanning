<style>
#project_id{
    display:none;
}
.mt-3.submitholiday {
    margin-top: 1.2rem !important;
}
</style>
{{Form::model($project_holiday,array('route' => array('project-holiday.update',
     $project_holiday->id), 'method' => 'PUT')) }}
        <div class="modal-body">
        
        <div class="row row-cards">
                        <select class="form-control" required name='project_id' id="project_id">
                                @foreach($projects as $key => $value)
                                    <option value="{{$value->id}}" @if($project_holiday->project_id==$value->id)
                                         selected  @endif>{{$value->project_name}}</option>
                                @endforeach
                        </select>
                        <div class="col-md-4">
                        {{Form::label('date',__('Holiday Date'),['class'=>'form-label'])}}
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
                         id="datepicker-icon-prepend" name="date" value={{$project_holiday->date}} required/>
                        </div>
                </div>
                </div>
        <div class="col-md-4">
            <div class="mb-3">
                        {{Form::label('description',__('Holiday Name'),['class'=>'form-label'])}}
                        {{Form::text('description',null,array('class'=>'form-control','required' => 'required',
                            'placeholder'=>"Enter Holiday Name"))}}
                    </div>
                
                        @error('name')
                        <span class="invalid-name" role="alert">
                            <strong class="text-danger">{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
        <div class="col-md-2">
            <div class="mt-3 submitholiday">
                <input type="submit" value="{{__('Update Holiday')}}" class="btn  btn-primary">
                </div>
            </div>
        </div>
        </div>
        {{Form::close()}}
     
<script src="{{ asset('tabler/tabler.min.js') }}"></script>
<script src="{{ asset('theme/demo-theme.min.js') }}"></script>
<script src="{{ asset('litepicker/litepicker.js') }}"></script>
<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>

<script>
    $( document ).ready(function() {
        $('.modal-title').html("Edit Holiday")
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