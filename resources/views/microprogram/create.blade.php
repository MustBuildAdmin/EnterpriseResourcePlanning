<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css"/>
<style>
    .input-icon-addon {
        max-height: 2.2em;
    }
</style>
{{ Form::open([
    'url' => "schedule_store",
    'method' => 'post',
    'id' => 'subcontractorCreate',
    'enctype' => 'multipart/form-data',
]) }}
<div class="modal-body">
    <div class="mb-3">
        <label class="form-label required">{{__('Schedule Name')}}</label>
        <input type="hidden" id="setScheduleDate" class="setScheduleDate" value="{{$all_dates}}">
        <input type="text" class="form-control" name="schedule_name" required id="schedule_name"
            placeholder="{{__('Enter your Schedule Name')}}">
    </div>
    {{-- <div class="mb-3">
        <label class="form-label required">Schedule Duration</label>
        <input type="text" class="form-control" name="schedule_duration" required
            id="schedule_duration"
            placeholder="Enter your Schedule Duration">
    </div> --}}
    <div class="mb-3">
        <label class="form-label required">{{__('Schedule Start Date')}}</label>
        <div class="input-icon">
            <span class="input-icon-addon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                    <path d="M16 3v4" />
                    <path d="M8 3v4" />
                    <path d="M4 11h16" />
                    <path d="M11 15h1" />
                    <path d="M12 15v3" />
                </svg>
            </span>
            <input name="schedule_start_date" class="form-control" autocomplete="off"
             placeholder="{{__('Select a start date')}}" id="schedule_start_date" required />
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label required">{{__('Schedule End Date')}}</label>
        <div class="input-icon">
            <span class="input-icon-addon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                    <path d="M16 3v4" />
                    <path d="M8 3v4" />
                    <path d="M4 11h16" />
                    <path d="M11 15h1" />
                    <path d="M12 15v3" />
                </svg>
            </span>
            <input name="schedule_end_date" class="form-control" autocomplete="off"
            placeholder="{{__('Select a End date')}}" id="schedule_end_date" required />
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label required">{{ __('Schedule Goals') }}</label>
        <textarea class="form-control" name="schedule_goals" rows="6" placeholder="{{ __('Content..') }}" required></textarea>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn btn-primary" id="create_subcontractor">
</div>
{{ Form::close() }}
<script src="{{ asset('litepicker/litepicker.js') }}"></script>
<script>
    $(function () {
        var getScheduleDate  = JSON.parse($("#setScheduleDate").val());
       
        const picker = new Litepicker({ 
            element: document.getElementById('schedule_start_date'),
            elementEnd: document.getElementById('schedule_end_date'),
            singleMode: false,
            allowRepick: true,
            lockDays: getScheduleDate,
            buttonText: {
                previousMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"
                fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,

                nextMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"
                fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
            },
            setup: (picker) => {
                picker.on('before:click', () => {
                    
                });

            },
        });

        var form = $("#subcontractorCreate");

        form.validate({
            rules: {
                schedule_name: {
                    required: true,
                    remote: {
                        url: '{{ route("checkschedulename") }}',
                        data: { 'form_name' : "scheduleCreate" },
                        type: "GET"
                    }
                }
            },
            messages: {
                schedule_name: {
                    remote: "Sorry, Schedule name already exists!"
                }
            }
        });
    });
</script>
