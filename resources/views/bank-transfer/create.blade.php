
{{ Form::open(array('url' => 'bank-transfer')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-6">
            {{ Form::label('from_account', __('From Account'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            <select name="from_account" class="form-control select from_account" required>
                <option value="">Select Account</option>
                @foreach($bankAccount as $account)
                    <option value="{{$account['id']}}">{{$account['name']}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('to_account', __('To Account'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            <select name="to_account" class="form-control select to_account" required>
                <option value="">Select Account</option>
            </select>  
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('amount', __('Amount'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{ Form::number('amount', '', array('class' => 'form-control','required'=>'required','step'=>'0.01', 'min'=>0)) }}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('date', __('Date'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            <input type="date" name="date" class="form-control" required="required" max="<?php echo date("Y-m-d"); ?>">
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('reference', __('Reference'),['class'=>'form-label']) }}
            {{ Form::text('reference', '', array('class' => 'form-control')) }}
        </div>
        <div class="form-group  col-md-12">
            {{ Form::label('description', __('Description'),['class'=>'form-label']) }}
            {{ Form::textarea('description', '', array('class' => 'form-control','rows'=>3)) }}
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{ Form::close() }}




<script>
$(document).ready(function() {
    var jqueryarray = <?php echo json_encode($bankAccount); ?>;

    $(".from_account").change(function(){
        var val = $(this).find('option:selected').attr('value');
        $(".to_account").empty();
        $(".to_account").append($("<option></option>").val("").html("Select Account"));
        $.each(jqueryarray, function (key, value) {
            $(".to_account").append('<option value="' + value.id + '">' + value.name + '</option>');
            });       
        $(".to_account option[value="+val+"]").remove();
        });
});
</script>

