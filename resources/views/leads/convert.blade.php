{{ Form::model($lead, array('route' => array('leads.convert.to.deal', $lead->id), 'method' => 'POST')) }}
<div class="modal-body">
    <div class="row">
        <div class="col-6 form-group">
            {{ Form::label('name', __('Deal Name'),['class'=>'form-label']) }}
            {{ Form::text('name', $lead->subject, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="col-6 form-group">
            {{ Form::label('price', __('Price'),['class'=>'form-label']) }}
            {{ Form::number('price', 0, array('class' => 'form-control','min'=>0)) }}
        </div>
        <div class="col-sm-12 col-md-12">
            <div class="d-flex radio-check">
                <div class="orm-check form-check-inline form-group col-md-6">
                    <input type="radio" name="client_check" value="new" id="new_client" class="form-check-input" @if(empty($exist_client)) checked @endif/>
                    <label class="form-check-label form-label" for="new_client">{{__('New Client')}}</label>
                </div>
                <div class="orm-check form-check-inline form-group col-md-6">
                    <input type="radio" name="client_check" value="exist" id="existing_client" class="form-check-input" @if(!empty($exist_client)) checked @endif/>
                    <label class="form-check-label form-label" for="existing_client">{{__('Existing Client')}}</label>
                </div>
            </div>
        </div>
        <div class="col-6 exist_client d-none form-group">
            {{ Form::label('clients', __('Client'),['class'=>'form-label']) }}
            <select name="clients" id="clients" class="form-control select">
                <option value="">{{ __('Select Client') }}</option>
                @foreach($clients as $client)
                    <option value="{{ $client->email }}" @if($lead->email == $client->email) selected @endif>{{ $client->name }} ({{ $client->email }})</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 new_client form-group">
            {{ Form::label('client_name', __('Client Name'),['class'=>'form-label']) }}
            {{ Form::text('client_name', $lead->name, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="col-6 new_client form-group">
            {{ Form::label('client_email', __('Client Email'),['class'=>'form-label']) }}
            {{ Form::text('client_email', $lead->email, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="col-6 new_client form-group">
            {{ Form::label('client_password', __('Client Password'),['class'=>'form-label']) }}
            {{ Form::text('client_password',null, array('class' => 'form-control','required'=>'required')) }}
        </div>
    </div>
    <div class="row px-3 text-sm">
        <div class="col-12 pl-0 pb-2 font-bold text-dark">{{__('Copy To')}}</div>
        <div class="col-3 custom-control custom-checkbox form-switch">
            {{ Form::checkbox('is_transfer[]','products',false,['class' => 'form-check-input','id'=>'is_transfer_products','checked'=>'checked']) }}
            {{ Form::label('is_transfer_products', __('Products'),['class'=>'custom-control-label']) }}
        </div>
        <div class="col-3 custom-control custom-checkbox form-switch">
            {{ Form::checkbox('is_transfer[]','sources',false,['class' => 'form-check-input','id'=>'is_transfer_sources','checked'=>'checked']) }}
            {{ Form::label('is_transfer_sources', __('Sources'),['class'=>'custom-control-label']) }}
        </div>
        <div class="col-3 custom-control custom-checkbox form-switch">
            {{ Form::checkbox('is_transfer[]','files',false,['class' => 'form-check-input','id'=>'is_transfer_files','checked'=>'checked']) }}
            {{ Form::label('is_transfer_files', __('Files'),['class'=>'custom-control-label']) }}
        </div>
        <div class="col-3 custom-control custom-checkbox form-switch">
            {{ Form::checkbox('is_transfer[]','discussion',false,['class' => 'form-check-input','id'=>'is_transfer_discussion','checked'=>'checked']) }}
            {{ Form::label('is_transfer_discussion', __('Discussion'),['class'=>'custom-control-label']) }}
        </div>
        <div class="col-3 custom-control custom-checkbox form-switch">
            {{ Form::checkbox('is_transfer[]','notes',false,['class' => 'form-check-input','id'=>'is_transfer_notes','checked'=>'checked']) }}
            {{ Form::label('is_transfer_notes', __('Notes'),['class'=>'custom-control-label']) }}
        </div>
        <div class="col-3 custom-control custom-checkbox form-switch">
            {{ Form::checkbox('is_transfer[]','calls',false,['class' => 'form-check-input','id'=>'is_transfer_calls','checked'=>'checked']) }}
            {{ Form::label('is_transfer_calls', __('Calls'),['class'=>'custom-control-label']) }}
        </div>
        <div class="col-3 custom-control custom-checkbox form-switch">
            {{ Form::checkbox('is_transfer[]','emails',false,['class' => 'form-check-input','id'=>'is_transfer_emails','checked'=>'checked']) }}
            {{ Form::label('is_transfer_emails', __('Emails'),['class'=>'custom-control-label']) }}
        </div>
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>

{{Form::close()}}

<script>
    $(document).ready(function () {
        var is_client = $("input[name='client_check']:checked").val();
        $("input[name='client_check']").click(function () {
            is_client = $(this).val();

            if (is_client == "exist") {
                $('.exist_client').removeClass('d-none');
                $('#client_name').removeAttr('required');
                $('#client_email').removeAttr('required');
                $('#client_password').removeAttr('required');
                $('.new_client').addClass('d-none');
            } else {
                $('.new_client').removeClass('d-none');
                $('#client_name').attr('required', 'required');
                $('#client_email').attr('required', 'required');
                $('#client_password').attr('required', 'required');
                $('.exist_client').addClass('d-none');
            }
        });
        if (is_client == "exist") {
            $('.exist_client').removeClass('d-none');
            $('#client_name').removeAttr('required');
            $('#client_email').removeAttr('required');
            $('#client_password').removeAttr('required');
            $('.new_client').addClass('d-none');
        } else {
            $('.new_client').removeClass('d-none');
            $('#client_name').attr('required', 'required');
            $('#client_email').attr('required', 'required');
            $('#client_password').attr('required', 'required');
            $('.exist_client').addClass('d-none');
        }
    })

</script>
