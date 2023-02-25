    {{Form::model($event,array('route' => array('event.update', $event->id), 'method' => 'PUT')) }}
    <div class="modal-body">

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('title',__('Event Title*'),['class'=>'form-label'])}}
                {{Form::text('title',null,array('class'=>'form-control','required'=>'required','placeholder'=>__('Enter Event Title')))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('start_date',__('Event start Date*'),['class'=>'form-label'])}}
                {{Form::date('start_date',null,array('class'=>'form-control ','required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('end_date',__('Event End Date*'),['class'=>'form-label'])}}
                {{Form::date('end_date',null,array('class'=>'form-control ','required'=>'required'))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                {{ Form::label('color', __('Event Select Color'), ['class' => 'col-form-label d-block mb-3']) }}
                <div class=" btn-group-toggle btn-group-colors event-tag" data-toggle="buttons">
                    <label
                        class="btn bg-info p-3 {{ $event->color == 'event-info'
                            ? 'custom_color_radio_button
                                                                                                                        '
                            : '' }} "><input
                            type="radio" name="color" class="d-none" value="event-info"
                            {{ $event->color == 'event-info' ? 'checked' : '' }}></label>

                    <label
                        class="btn bg-warning p-3 {{ $event->color == 'event-warning' ? 'custom_color_radio_button' : '' }}"><input
                            type="radio" class="d-none" name="color" value="event-warning"
                            {{ $event->color == 'event-warning' ? 'checked' : '' }}></label>

                    <label
                        class="btn bg-danger p-3 {{ $event->color == 'event-danger' ? 'custom_color_radio_button' : '' }}"><input
                            type="radio" name="color" class="d-none" value="event-danger"
                            {{ $event->color == 'event-danger' ? 'checked' : '' }}></label>


                    <label
                        class="btn bg-success p-3 {{ $event->color == 'event-success' ? 'custom_color_radio_button' : '' }}"><input
                            type="radio" class="d-none" name="color" value="event-success"
                            {{ $event->color == 'event-success' ? 'checked' : '' }}></label>

                    <label class="btn p-3 {{ $event->color == 'event-primary' ? 'custom_color_radio_button' : '' }}"
                           style="background-color: #51459d !important"><input type="radio" class="d-none"
                                                                               name="color" value="event-primary"
                            {{ $event->color == 'event-primary' ? 'checked' : '' }}></label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('description',__('Event Description'),['class'=>'form-label'])}}
                {{Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Event Description')))}}
            </div>
        </div>

    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn btn-primary">
</div>
    {{Form::close()}}

@push('script-page')
<script>
    if ($(".datepicker").length) {
        $('.datepicker').daterangepicker({
            singleDatePicker: true,
            format: 'yyyy-mm-dd',
            locale: date_picker_locale,
        });
    }
</script>
@endpush
