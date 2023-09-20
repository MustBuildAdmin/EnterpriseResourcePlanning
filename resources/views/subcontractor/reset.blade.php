{{ Form::model($user, ['route' => ['subContractor.password.update', $user->id], 'method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group">
            {{ Form::label('password', __('Password')) }}
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password" required autocomplete="new-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('password_confirmation', __('Confirm Password')) }}
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                autocomplete="new-password">
        </div>
        <div id="not_match" style="display:none;color:red;">{{ __("Passwords Don't Match") }}</div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn  btn-primary" id="resetbutton">
</div>
{{ Form::close() }}
<script>
    $(document).on('keyup', '#password-confirm', function() {
        var password = $("#password").val();
        confirm_password = $(this).val();

        if (password != confirm_password) {
            $("#not_match").css('display', 'block');
            $("#resetbutton").prop('disabled', true);
            return false;
        } else {
            $("#not_match").css('display', 'none');
            $("#resetbutton").prop('disabled', false);
            return true;
        }
    });
</script>
