<div class="modal-body">
	<div class="row">
		<form action="{{ route('rfi_info_main_save') }}" method="POST"> @csrf
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
					<div class="col-md-4">
						<div class="form-group">
							<label for="InputLIst">{{__('Consultant No. 1')}}</label><span style='color:red;'>*</span>
							<input type="text" name="rfijson[consultant_1]" class="form-control consultant_1"
							 placeholder="{{__('Consultant No. 1')}}" required>
                         </div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="input">{{__('Consultant No. 2')}}</label>
							<input type="text" name="rfijson[consultant_2]" class="form-control consultant_2"
							 placeholder="{{__('Consultant No. 2')}}">
                        </div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="input">{{__('Consultant No. 3')}}</label>
							<input type="text" name="rfijson[consultant_3]" class="form-control consultant_3"
							 placeholder="{{__('Consultant No. 3')}}">
                        </div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="InputLIst">{{__('Consultant No. 4')}}</label>
							<input type="text" name="rfijson[consultant_4]" class="form-control consultant_4"
							 placeholder="{{__('Consultant No. 4')}}">
                         </div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="input">{{__('Consultant No. 5')}}</label>
							<input type="text" name="rfijson[consultant_5]" class="form-control consultant_5"
							 placeholder="{{__('Consultant No. 5')}}">
                         </div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="input">{{__('Consultant No. 6')}}</label>
							<input type="text" name="rfijson[consultant_6]" class="form-control consultant_6"
							 placeholder="{{__('Consultant No. 6')}}">
                        </div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="InputLIst">{{__('Consultant No. 7')}}</label>
							<input type="text" name="rfijson[consultant_7]" class="form-control consultant_7"
							 placeholder="{{__('Consultant No. 7')}}">
                         </div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="input">{{__('Consultant No. 8')}}</label>
							<input type="text" name="rfijson[consultant_8]" class="form-control consultant_8"
							  placeholder="{{__('Consultant No. 8')}}">
                        </div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="input">{{__('Consultant No. 9')}}</label>
							<input type="text" name="rfijson[consultant_9]" class="form-control consultant_9"
							 placeholder="{{__('Consultant No. 9')}}">
                        </div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="InputLIst">{{__('Consultant No. 10')}}</label>
							<input type="text"  name="rfijson[consultant_10]" class="form-control consultant_10"
							  placeholder="{{__('Consultant No. 10')}}">
                        </div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="input">{{__('Consultant No. 11')}}</label>
							<input type="text"  name="rfijson[consultant_11]" class="form-control consultant_11"
							  placeholder="{{__('Consultant No. 11')}}">
                        </div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="input">{{__('Consultant No. 12')}}</label>
							<input type="text" name="rfijson[consultant_12]" class="form-control consultant_12"
							 placeholder="{{__('Consultant No. 12')}}">
                        </div>
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
});
</script>