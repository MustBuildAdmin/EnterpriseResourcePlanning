<link rel="stylesheet" href="{{ asset('tokeninput/tokeninput.css') }}" />
{{ Form::open(['url' => 'invitation_status', 'id' => 'users_form', 'method' => 'POST']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group">
            {{ Form::label('seach_consultant', __('Search a Consultant')) }}
            <input type="text" id="skill_input" name="consulant_id" value="{{ request()->get('q') }}" required>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">{{ __('Close') }}</button>
    <button type="submit" class="btn btn-primary">{{ __('Invite Member') }}</button>
</div>
{{ Form::close() }}
<script src="{{ asset('tokeninput/jquery.tokeninput.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#users_form').validate({
            rules: {
                name: "required",
            },
            ignore: ':hidden:not("#skill_input")'
        });
        $("#skill_input").tokenInput("{{ route('consultant.seach_result') }}", {
            propertyToSearch: "name",
            tokenValue: "id",
            tokenDelimiter: ",",
            hintText: "{{ __('Search Consultant...') }}",
            noResultsText: "{{ __('Consultant not found.') }}",
            searchingText: "{{ __('Searching...') }}",
            deleteText: "&#215;",
            minChars: 2,
            tokenLimit: 4,
            zindex: 9999,
            animateDropdown: false,
            resultsLimit: 10,
            deleteText: "&times;",
            preventDuplicates: true,
            theme: "bootstrap"
        });
    });
</script>
