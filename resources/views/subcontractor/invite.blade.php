<link rel="stylesheet" href="{{ asset('tokeninput/tokeninput.css') }}" />
{{ Form::open(['url' => 'subcontractor_invitation_status', 'id' => 'invitation_sub', 'method' => 'POST']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group">
            {{ Form::label('seach_subcontractor', __('Search a Sub Contractor')) }}
            <input type="text" id="skill_input" name="subcontractor_id" value="{{ request()->get('q') }}" required>
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
        $('#invitation_sub').validate({
            rules: {
                name: "required",
            },
            ignore: ':hidden:not("#skill_input")'
        });
        $("#skill_input").tokenInput("{{ route('subcontractor.seach_result') }}", {
            propertyToSearch: "name",
            tokenValue: "id",
            tokenDelimiter: ",",
            hintText: "{{ __('Search Sub Contractor...') }}",
            noResultsText: "{{ __('Sub Contractor not found.') }}",
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
