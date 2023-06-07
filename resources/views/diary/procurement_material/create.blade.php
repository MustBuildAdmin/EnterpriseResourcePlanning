<div class="modal-body">
	<div class="row">
		<form action="{{ route('save_procurement_material') }}" enctype="multipart/form-data" method="POST"> 
			@csrf
			<div class="container">
				<input type="hidden" name="project_id" value="{{$project_id}}">
				<div class="row">
					<div class="form-group">
						<label for="InputLIst">{{__('PROCUREMENT, MATERIAL SUPPLIER & SUPPLY LOG STATUS for the project of:')}}</label> {{$project_name->project_name}} 
					</div>
				</div>
				<hr style="border: 1px solid black;">
				<h3 style="text-align: center;">{{__('PROCUREMENT, MATERIAL SUPPLIER & SUPPLY LOG')}}</h3>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="InputLIst">{{__('Description')}} <span style='color:red;'>*</span></label>
							<input type="text" name="description" class="form-control" placeholder="{{__('Description')}}" required> 
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('RAM Ref with No')}} <span style='color:red;'>*</span></label>
							<input type="text" name="ram_ref_no" class="form-control" placeholder="{{__('RAM Ref with No')}}" required> 
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Location')}} <span style='color:red;'>*</span></label>
							<input type="text" name="location" class="form-control" placeholder="{{__('Location')}}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Name of Supplier')}} <span style='color:red;'>*</span></label>
							<input type="text" name="supplier_name" class="form-control" placeholder="{{__('Name of Supplier')}}" required>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Contact Person')}} <span style='color:red;'>*</span></label>
							<input type="text" name="contact_person" class="form-control" placeholder="{{__('Contact Person')}}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Mobile/HP')}} <span style='color:red;'>*</span></label>
							<input type="text" name="mobile_hp_no" class="form-control" placeholder="{{__('Mobile/HP')}}" required>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Telephone')}} <span style='color:red;'>*</span></label>
							<input type="text" name="tel" class="form-control" placeholder="{{__('Telephone')}}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Fax')}} <span style='color:red;'>*</span></label>
							<input type="text" name="fax" class="form-control" placeholder="{{__('Fax')}}" required>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Email')}} <span style='color:red;'>*</span></label>
							<input type="text" name="email" id="email" class="form-control" placeholder="{{__('Email')}}" required>
						</div>
						<span class="invalid-name email_duplicate_error" role="alert" style="display: none;">
							<span class="text-danger">{{__('Email already exist in our record.!')}}</span>
						</span> 
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Lead Time')}} <span style='color:red;'>*</span></label>
							<input type="text" name="lead_time" class="form-control" placeholder="{{__('Lead Time')}}" required>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Target Delivery Date')}} <span style='color:red;'>*</span></label>
							<input type="date" name="target_delivery_date" class="form-control" placeholder="{{__('Target Delivery Date')}}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Target Date of Approval')}} <span style='color:red;'>*</span></label>
							<input type="date" name="target_approval_date" class="form-control" placeholder="{{__('Target Date of Approval')}}" required>
						</div>
					</div>
				</div>
				<div class="col-md-3 pull-right">
					<button class="btn btn-primary" type="button" id="dynamic-procurement">{{__('Add Submission')}}</button>
				</div>
				<table class="table" id="dynamicprocurement">
					<tr>
						<td>
							<h4 style="text-align: center;">{{__('Date Replied By Consultant:')}}</h4>
							<div class="">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="InputLIst">{{__('Submission Date')}}</label>
											<input type="date" name="submission_date[]" class="form-control"> 
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="input">{{__('Actual Reply Date')}}</label>
											<input type="date" name="actual_reply_date[]" class="form-control"> 
										</div>
									</div>
								</div>
							</div>
						</td>
					</tr>
				</table>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Status')}} <span style='color:red;'>*</span></label>
							<select class="form-select" aria-label="Default select example" name="status">
								<option selected="" disabled="">Status</option>
								<option value="Comment">Approved With Comment</option>
								<option value="Approved">Approved</option>
								<option value="Rejected">Rejected To Resubmit</option>
								<option value="Subject">Approvied Subject to Additional Info</option>
								<option value="Pending">Pending</option>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Attachement')}} <span style='color:red;'>*</span></label>
							<input type="file" name="filename" class="form-control imgs" placeholder="Text input">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="input">{{__('Remarks')}} <span style='color:red;'>*</span></label>
							<textarea name="remarks" class="form-control" placeholder="{{__('Remarks')}}" required></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal" >
				<input type="submit" value="{{__('Create')}}" class="btn  btn-primary" id="create_procurement"> 
			</div>
		</form>
	</div>
</div>

<script>
	$(document).ready(function(){
        $(document).on("keyup", '#email', function () {
            $.ajax({
                url : '{{ route("check_duplicate_diary_email") }}',
                type : 'GET',
                data : { 'get_name' : $("#email").val(),'form_name' : "procurement_material" },
                success : function(data) {
                    if(data == 1){
                        $("#create_procurement").prop('disabled',false);
                        $(".email_duplicate_error").css('display','none');
                    }
                    else{
                        $("#create_procurement").prop('disabled',true);
                        $(".email_duplicate_error").css('display','block');
                    }
                },
                error : function(request,error)
                {
                    alert("Request: "+JSON.stringify(request));
                }
            });
        });
    });
</script>