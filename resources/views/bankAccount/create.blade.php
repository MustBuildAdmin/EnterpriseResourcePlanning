{{ Form::open(array('url' => 'bank-account')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('holder_name', __('Bank Holder Name'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            <div class="form-icon-user">
                <span><i class="ti ti-address-card"></i></span>
                <input type="text" name="holder_name" id="holder_name" value="" class="form-control" required ="required" onkeydown="return /[a-z]/i.test(event.key)">
            </div>
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('bank_name', __('Bank Name'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            <div class="form-icon-user">
                <span><i class="ti ti-university"></i></span>
                <input type="text" name="bank_name" id="bank_name" value="" class="form-control" required ="required" onkeydown="return /[a-z]/i.test(event.key)">
            </div>
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('account_number', __('Account Number'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            <div class="form-icon-user">
                <span><i class="ti ti-notes-medical"></i></span>
                <input type="text" name="account_number" id="account_number" value="" class="form-control" required ="required" onkeydown="return /[0-9]/i.test(event.key)">
            </div>
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('opening_balance', __('Opening Balance'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            <div class="form-icon-user">
                <span><i class="ti ti-dollar-sign"></i></span>
                {{ Form::number('opening_balance', '', array('class' => 'form-control','required'=>'required','step'=>'0.01', 'min'=>0)) }}
            </div>
        </div>
        <div class="form-group col-md-6">
            <div class="form-group">
                {{Form::label('contact_number',__('Contact Number'),array('class'=>'form-label')) }}<span style='color:red;'>*</span>
                <div class="form-icon-user">
                    <input class="form-control" name="contact_number" type="number" id="contact_number" required maxlength="16" placeholder="+91 111 111 1111" min=0>
                </div>
            </div>
        </div>
        <!-- <div class="form-group  col-md-12">
            {{ Form::label('contact_number', __('Contact Number'),['class'=>'form-label']) }}
            <div class="form-icon-user">
                <span><i class="ti ti-mobile-alt"></i></span>
                {{ Form::number('contact_number', '', array('class' => 'form-control','required'=>'required')) }}
            </div>
        </div> -->
        <div class="form-group  col-md-12">
            {{ Form::label('bank_address', __('Bank Address'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{ Form::textarea('bank_address', '', array('class' => 'form-control','rows'=>3,'required'=>'required')) }}
        </div>
        @if(!$customFields->isEmpty())
            <div class="col-md-12">
                <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                    @include('customFields.formBuilder')
                </div>
            </div>
        @endif

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{ Form::close() }}

