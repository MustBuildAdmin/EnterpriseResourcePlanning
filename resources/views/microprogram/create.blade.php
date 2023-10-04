{{ Form::open([
    'url' => $url,
    'method' => 'post',
    'id' => 'subcontractorCreate',
    'enctype' => 'multipart/form-data',
]) }}
<div class="modal-body">
    <div class="text-secondary mb-3">Required fields are marked with an asterisk *</div>
    <div class="mb-3">
        <label class="form-label">Schedule Name</label>
        <input type="text" class="form-control" name="example-text-input" required
            placeholder="Enter your Schedule Name">
    </div>
    <div class="mb-3">
        <label class="form-label">Schedule Duration</label>
        <input type="text" class="form-control" name="example-text-input" required
            placeholder="Enter your Schedule Duration">
    </div>
    <div class="mb-3">
        <label class="form-label required"> Schedule Start Date</label>
        <div class="input-icon">
            <span class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                    <path d="M16 3v4" />
                    <path d="M8 3v4" />
                    <path d="M4 11h16" />
                    <path d="M11 15h1" />
                    <path d="M12 15v3" />
                </svg>
            </span>
            <input class="form-control" placeholder="Select a End date" id="schedule-start-date" />
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label required"> Schedule End Date</label>
        <div class="input-icon">
            <span class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                    <path d="M16 3v4" />
                    <path d="M8 3v4" />
                    <path d="M4 11h16" />
                    <path d="M11 15h1" />
                    <path d="M12 15v3" />
                </svg>
            </span>
            <input class="form-control" placeholder="Select a End date" id="schedule-end-date" />
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Schedule Goals<span class="form-label-description">56/100</span></label>
        <textarea class="form-control" name="example-textarea-input" rows="6" placeholder="Content..">Oh! Come and see the violence inherent in the system! Help, help, I'm being repressed! We shall say 'Ni' again to you, if you do not appease us. I'm not a witch. I'm not a witch. Camelot!</textarea>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn btn-primary" id="create_subcontractor">
</div>
{{ Form::close() }}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"
    integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC" crossorigin="anonymous">
</script>
