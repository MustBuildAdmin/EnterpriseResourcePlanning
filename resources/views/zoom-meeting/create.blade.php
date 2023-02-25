
{{ Form::open(['route' => 'zoom-meeting.store','id'=>'store-user','method'=>'post']) }}
<div class="modal-body">

    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('title', __('Topic') ,['class'=>'form-label'])}}
            {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => __('Enter Meeting Title'), 'required' => 'required']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('projects', __('Project'),['class'=>'form-label'])}}
            {{ Form::select('project_id', $projects, null, ['class' => 'form-control select project_select', 'id' => 'project_select', 'data-toggle' => 'select']) }}
        </div>
        <div class="form-group col-md-6" id="user_div">
            {{ Form::label('projects', __('Users'),['class'=>'form-label'])}}
            <select class="form-control select employee_select" id="user_id" name="user_id[]" >
                <option value="">{{__('Select User')}}</option>

            </select>
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('datetime', __('Start Date / Time'),['class'=>'form-label'])}}
            {{ Form::date('start_date',null,['class' => 'form-control date', 'placeholder' => __('Select Date/Time'), 'required' => 'required']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('duration', __('Duration'),['class'=>'form-label'])}}
            {{ Form::number('duration',null,['class' => 'form-control', 'placeholder' => __('Enter Duration'), 'required' => 'required']) }}
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('password', __('Password ( Optional )'),['class'=>'form-label'])}}
            {{ Form::password('password',['class' => 'form-control', 'placeholder' => __('Enter Password')]) }}
        </div>
        <div class="form-group col-md-6">
            <div class=" form-switch form-switch-left">
                <input class="form-check-input" type="checkbox" name="client_id" id="client_id" checked>
                <label class="form-check-label" for="client_id">{{__('Invite Client For Zoom Meeting')}}</label>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{ Form::close() }}


<script type="text/javascript">
    $(document).on('change', '.project_select', function () {

        var project_id = $(this).val();

        getparent(project_id);
    });
    function getparent(bid) {

        $.ajax({
            url: `{{ url('zoom-meeting/projects/select')}}/${bid}`,
            type: 'GET',
            success: function (data) {
                $("#user_id").html('');
                $('#user_id').append('<select class="form-control" id="user_id" name="user_id[]"  multiple></select>');

                $.each(data, function (i, item) {

                    $('#user_id').append('<option value="' + item.id + '">' + item.name + '</option>');
                });

                var multipleCancelButton = new Choices('#user_id', {
                    removeItemButton: true,
                });

                if (data == '') {
                    $('#user_id').empty();
                }
            }
        });
    }

    $(document).ready(function () {

        $('.date').daterangepicker({
            "singleDatePicker": true,
            "timePicker": true,
            "locale": {
                "format": 'MM/DD/YYYY H:mm'
            },
            "timePicker24Hour": true,
        }, function(start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });
        getProjects($('#client_id').val());
    });

</script>







