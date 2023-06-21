@if(isset($call))
    {{ Form::model($call, array('route' => array('leads.calls.update', $lead->id, $call->id), 'method' => 'PUT')) }}
@else
    {{ Form::open(array('route' => ['leads.calls.store',$lead->id])) }}
@endif
<div class="modal-body">
    <div class="row">
        <div class="col-6 form-group">
            {{ Form::label('subject', __('Subject'),['class'=>'form-label']) }}
            {{ Form::text('subject', null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="col-6 form-group">
            {{ Form::label('call_type', __('Call Type'),['class'=>'form-label']) }}
            <select name="call_type" id="call_type" class="form-control " required>
                <option value="outbound" @if(isset($call->call_type) && $call->call_type == 'outbound') selected @endif>{{__('Outbound')}}</option>
                <option value="inbound" @if(isset($call->call_type) && $call->call_type == 'inbound') selected @endif>{{__('Inbound')}}</option>
            </select>
        </div>
        <div class="col-12 form-group">
            {{ Form::label('duration', __('Duration'),['class'=>'form-label']) }} <small class="font-weight-bold">{{ __(' (Format h:m:s i.e 00:35:20 means 35 Minutes and 20 Sec)') }}</small>
            {{ Form::time('duration', null, array('class' => 'form-control','placeholder'=>'00:35:20','step'=>'2')) }}
        </div>
        <div class="col-12 form-group">
            {{ Form::label('user_id', __('Assignee'),['class'=>'form-label']) }}
            <select name="user_id" id="user_id" class="form-control " required>
                @foreach($users as $user)
                    <option value="{{ $user->getLeadUser->id }}" @if(isset($call->user_id) && $call->user_id == $user->getLeadUser->id) selected @endif>{{ $user->getLeadUser->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 form-group">
            {{ Form::label('description', __('Description'),['class'=>'form-label']) }}
            {{ Form::textarea('description', null, array('class' => 'form-control')) }}
        </div>
        <div class="col-12 form-group">
            {{ Form::label('call_result', __('Call Result'),['class'=>'form-label']) }}
            {{ Form::textarea('call_result', null, array('class' => 'summernote-simple','id'=>'summernote')) }}

        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    @if(isset($call))
        <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
    @else
        <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
    @endif
</div>
{{Form::close()}}

