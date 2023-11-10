<link rel="stylesheet" href="{{ asset('tokeninput/tokeninput.css') }}"/>
{{Form::open(array('url'=>'save_teammember','method'=>'POST'))}}
<div class="modal-body">
    <div class="row">
        <div class="form-group">
            {{ Form::label('seach_teammember', __('Search')) }}
            <input type="text" id="skill_input" name="teammember_id"
            value="{{ request()->get('q') }}" >
            <input type="hidden" id="skill_input" name="project_id"
            value="{{ $project_id }}" >
            <input type="hidden" id="getName" name="type"
            value="{{ Request::route()->getName() }}" >
            
            
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">{{__('Close')}}</button>
    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" id="submitinvite">{{__('Invite')}}</button>
 </div>
{{Form::close()}}
<script src="{{ asset('tokeninput/jquery.tokeninput.js') }}"></script>
<script>
    $(document).ready(function() {
        let type=window.location.href;
        let slug=type.split('/');
        let value=slug[slug.length-1].includes("consultant") ?
    "{{ __('Search a Consultant...')}}"
        : slug[slug.length-1].includes("subcontractor") ? "{{ __('Search a Sub Contractor...')}}" :
        "{{ __('Search a Member...')}}";
    // $("label[for*='seach_teammember']").html(value);
    console.log(value,"valuevalue")
    $("#skill_input").tokenInput("{{route('invite.search_teammember',$project_id)}}?type="+slug[slug.length-1], {
        propertyToSearch:"name",
        tokenValue:"id",
        tokenDelimiter:",",
        hintText: slug[slug.length-1].includes("consultant") ? "{{ __('Search a Consultant...')}}"
        : slug[slug.length-1].includes("subcontractor") ? "{{ __('Search a Sub Contractor...')}}" :
        "{{ __('Search a Member...')}}",
        noResultsText: slug[slug.length-1].includes("consultant") ? "{{ __('Consultant a not found.')}}"
        : slug[slug.length-1].includes("subcontractor") ? "{{ __('Sub Contractor not found.')}}" :
        "{{ __('Member not found.')}}",
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
