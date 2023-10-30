<link rel="stylesheet" href="{{ asset('tokeninput/tokeninput.css') }}"/>
{{Form::open(array('url'=>'save_teammember','method'=>'POST'))}}
<div class="modal-body">
    <div class="row">
        <div class="form-group">
            {{ Form::label('seach_teammember', __('Search a Member')) }}
            <input type="text" id="skill_input" name="teammember_id"
            value="{{ request()->get('q') }}" >
            <input type="hidden" id="skill_input" name="project_id"
            value="{{ $project_id }}" >
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">{{__('Close')}}</button>
    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">{{__('Invite a Member')}}</button>
 </div>
{{Form::close()}}
<script src="{{ asset('tokeninput/jquery.tokeninput.js') }}"></script>
<script>
    $(document).ready(function() {
    $("#skill_input").tokenInput("{{route('invite.search_teammember',$project_id)}}", {
        propertyToSearch:"name",
        tokenValue:"id",
        tokenDelimiter:",",
        hintText: "{{ __('Search a Member...')}}",
        noResultsText: "{{ __('Member not found.')}}",
        searchingText: "{{ __('Searching...')}}",
        deleteText:"&#215;",
        minChars: 2,
        tokenLimit: 4,
        zindex: 9999,
        animateDropdown: false,
        resultsLimit:10,
        deleteText: "&times;",
        preventDuplicates: true,
        theme: "bootstrap"
    });
});
</script>
