
<div class="modal-body">
    <div class="row">
        <div class="container">
            <form action="{{route('con_taskupdate')}}" method="POST" enctype="multipart/form-data">
                @csrf 
                <div class="row min-750" id="taskboard_view">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="hidden" id="setHoliday" value="{{$get_all_dates}}">
                            <input type="hidden" id="setWeekend"
                            value="{{ $nonWorkingDay != null ? $nonWorkingDay->non_working_days : ''}}">
                            {{ Form::label('name', __('Planned Start to End Date'),
                            ['class' => 'form-label']) }}<span class="text-danger">*</span>

                            <div class="input-icon">
                                <span
                                    class="input-icon-addon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon"
                                        width="24" height="24" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2
                                            0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                        <path d="M16 3v4" />
                                        <path d="M8 3v4" />
                                        <path d="M4 11h16" />
                                        <path d="M11 15h1" />
                                        <path d="M12 15v3" />
                                    </svg>
                                </span>
                                {{ Form::text('get_date', date('Y-m-d',strtotime($data['con_data']->start_date)),
                                    array('class' => 'form-control month-btn','id' => 'datepicker-icon-prepend'))
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            {{ Form::label('name', __('Actual Workdone % as of Today'),['class' => 'form-label']) }}
                            <span class="text-danger">*</span>
                            {{ Form::number('percentage', null, ['class' => 'form-control',
                            'id' => 'percentage','required'=>'required','max'=>'100','min'=>'1']) }}
                            {{ Form::hidden('task_id', $task_id, ['class' => 'form-control','id'=>'task_id']) }}
                            {{ Form::hidden('user_id', \Auth::user()->id, ['class' => 'form-control']) }}
                        </div>
                    </div>
                    
                    <div class="col-6">
                        <label for="input">{{__('Attachments')}}</label>
                        <input type="file" class="form-control" name="attachment_file_name[]" multiple>
                        <div class="file_name_show"></div>
                    </div>

                    <div class="col-12">
                        <br>
                        <div class="form-group">
                            {{ Form::label('description', __('Description'),['class' => 'form-label']) }}
                            <span style='color:red;'>*</span>
                            {{ Form::textarea('description', null, ['class' => 'form-control',
                            'id' => 'tinymce-mytextarea','rows'=>'3','data-toggle' => 'autosize',
                            'required'=>'required']) }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="modal-footer">
                            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                            <input type="submit" value="Save changes" class="btn btn-primary">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('tabler/tabler.min.js') }}"></script>
<script src="{{ asset('theme/demo-theme.min.js') }}"></script>
<script src="{{ asset('litepicker/litepicker.js') }}"></script>
<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>

<script>
    $( document ).ready(function() {
        start_range = "{{date('Y-m-d',strtotime($data['con_data']->start_date))}}";
        end_range   = "{{date('Y-m-d',strtotime($data['con_data']->end_date . '-1 day'))}}";
        var getHoliday  = JSON.parse($("#setHoliday").val());
        var setWeekend  = $("#setWeekend").val();
        
        if(setWeekend != ''){
            var splitWeekend = setWeekend.split(',').map(Number);
        }
        else{
            splitWeekend = [];
        }
        
        window.Litepicker && (new Litepicker({
            element: document.getElementById('datepicker-icon-prepend'),
            minDate: start_range,
            maxDate: end_range,
            lockDays: getHoliday,
            lockDaysFilter: (day) => {
                const d = day.getDay();
                return splitWeekend.includes(d);
            },
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
    
    $( document ).ready(function() {
        let options = {
            selector: '#tinymce-mytextarea',
            height: 300,
            menubar: false,
            statusbar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont,'+
            'San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;'+
            'font-size: 14px; -webkit-font-smoothing: antialiased; }'
        }
        if (localStorage.getItem("tablerTheme") === 'dark') {
            options.skin = 'oxide-dark';
            options.content_css = 'dark';
        }
        tinyMCE.init(options);
    })
</script>
