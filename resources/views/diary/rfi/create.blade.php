
<style>
 div#choices_multiple2_chosen{
     width: 100% !important;
}
 div#reporting_toerr {
     display: flex;
     flex-direction: column-reverse;
}
</style>
<div class="modal-body">
	<div class="row">
		<form action="{{ route('rfi_info_main_save') }}" method="POST" id="create_rfi">
			@csrf
			<div class="container">
				<input type="hidden" name="project_id" value="{{$project}}">
				<div class="row">
					<div class="form-group">
						<label for="InputLIst"><b>REQUEST FOR INFORMATION (RFI) STATUS</b> for the project of:</label>
						<b>{{$projectname->project_name}}</b>
                    </div>
					<div class="form-group">
						<div class="col-md-4">
							<label for="InputLIst">{{__('Contractor:')}}</label>
							<input type="text" name="contractor_name" class="form-control"
							placeholder="{{__('Contractor')}}" >
                        </div>
					</div>
				</div>
				<hr style="border: 1px solid black;">
				<h3 style="text-align: center;">{{__('REQUEST FOR INFORMATION (RFI) STATUS')}}</h3>
				<div class="row">
					<div class="form-group">
						<label for="InputLIst">{{__('Enter Type of Consultants List to send RFI:')}}</label>
					</div>
				</div>
				<div class="row">
					<label for="Input">{{__('Select the Consultants')}}</label>
					<div class="form-icon-user" id="consultant_toerr">
						<select name="rfijson[]" id="choices-multiple2" class="chosen-select get_consultant" required multiple>
							<option value="" disabled>{{__('Select the Consultants')}}</option>
							@foreach ($getconsultant as $conkey =>$con)
							<option
							value="{{$con->name}}">{{$con->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
				<input type="submit" value="{{__('Create')}}" class="btn  btn-primary" id="create_rfi">
            </div>
		</form>
	</div>
</div>
<script>
$(document).ready(function() {
	$(document).on('submit', 'form', function() {
		$('#create_rfi').attr('disabled', 'disabled');
	});
	$(".chosen-select").chosen({
		placeholder_text: "{{ __('Select Consultant') }}"
	});
	$('#create_rfi').validate({
		rules: {
			reportto: "required",
		},
		ignore: ':hidden:not("#choices-multiple2")'
	});

	$('.get_consultant').on('change', function() {
		get_val = $(this).val();
		

		if (get_val != "") {
			$("#consultant_toerr").hide();
		} else {
			$("#consultant_toerr").show();
		}

	});
});
</script>