<div class="modal-body">
	<div class="row">
		<form action="{{ route('update_procurement_material') }}" enctype="multipart/form-data" method="POST">
			@csrf
			<div class="container">
				<input type="hidden" name="project_id" value="{{$project_id}}">
				<input type="hidden" name="id" value="{{$data->id}}">
				<div class="row">
					<div class="form-group">
						<label for="InputLIst"><b>PROCUREMENT, MATERIAL SUPPLIER & SUPPLY LOG STATUS</b> for the project of:</label>
							<b>{{$project_name->project_name}}</b>
					</div>
				</div>
				<hr style="border: 1px solid black;">
				<h3 style="text-align: center;">{{__('PROCUREMENT, MATERIAL SUPPLIER & SUPPLY LOG')}}</h3>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="InputLIst">{{__('Description')}} <span style='color:red;'>*</span></label>
							<input type="text" name="description" class="form-control" placeholder="{{__('Description')}}" value="{{$data->description}}" required> 
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('RAM Ref with No')}} <span style='color:red;'>*</span></label>
							<input type="text" name="ram_ref_no" value="{{$data->ram_ref_no}}" class="form-control" placeholder="{{__('RAM Ref with No')}}" required> 
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Location')}} <span style='color:red;'>*</span></label>
							<input type="text" name="location" value="{{$data->location}}" class="form-control" placeholder="{{__('Location')}}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Name of Supplier')}} <span style='color:red;'>*</span></label>
							<input type="text" name="supplier_name" value="{{$data->supplier_name}}" class="form-control" placeholder="{{__('Name of Supplier')}}" required>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Contact Person')}} <span style='color:red;'>*</span></label>
							<input type="text" name="contact_person" value="{{$data->contact_person}}" class="form-control" placeholder="{{__('Contact Person')}}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Mobile/HP')}}</label>
							<input type="text" name="mobile_hp_no" value="{{$data->mobile_hp_no}}" class="form-control number" placeholder="{{__('Mobile/HP')}}" >
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Telephone')}}</label>
							<input type="tel" maxlength="16"  name="tel" value="{{$data->tel}}"  class="form-control number" placeholder="{{__('Telephone')}}" >
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Fax')}}</label>
							<input type="text" maxlength="16" name="fax" value="{{$data->fax}}"  class="form-control number" placeholder="{{__('Fax')}}" >
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Email')}} <span style='color:red;'>*</span></label>
							<input type="text" id="email" name="email" value="{{$data->email}}" class="form-control" placeholder="{{__('Email')}}" required>
						</div>
						<span class="invalid-name email_duplicate_error" role="alert" style="display: none;">
							<span class="text-danger">{{__('Email already exist in our record.!')}}</span>
						</span>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Lead Time')}} <span style='color:red;'>*</span></label>
							<input type="text" name="lead_time"  value="{{$data->lead_time}}" class="form-control" placeholder="{{__('Lead Time')}}" required>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Target Delivery Date')}} <span style='color:red;'>*</span></label>
							<input type="date" min="{{ date('Y-m-d', strtotime("+1 day")) }}" value="{{$data->target_delivery_date}}"  name="target_delivery_date" class="form-control" placeholder="{{__('Target Delivery Date')}}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Target Date of Approval')}} <span style='color:red;'>*</span></label>
							<input type="date" min="{{ date('Y-m-d', strtotime("+1 day")) }}" value="{{$data->target_approval_date}}" name="target_approval_date" class="form-control" placeholder="{{__('Target Date of Approval')}}" required>
						</div>
					</div>
				</div>
				<br>
				<hr>
				<div class="col-md-3 pull-right">
					<button class="btn btn-primary" type="button" id="dynamic-procurement">{{__('Add Submission')}}</button>
				</div>
				
				<table class="table" id="dynamicprocurement"> 
					@forelse($pro_material_mutli as $mutli_data)
					<tr>
						<td>
							<h4 style="text-align: center;">{{__('Date Replied By Consultant:')}}</h4>
							
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="InputLIst">{{__('Submission Date')}}</label>
											<input type="date" name="submission_date[]" value="{{$mutli_data['submission_date']}}" class="form-control">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="input">{{__('Actual Reply Date')}}</label>
											<input type="date" name="actual_reply_date[]"  value="{{$mutli_data['actual_reply_date']}}"  class="form-control"> 
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="input">{{__('No of Submissions')}}</label>
											<input type="text" name=""  value="{{$mutli_data['no_of_submission']}}" placeholder="{{__('No of Submissions')}}"  class="form-control number" disabled> 
											<input type="hidden" name="no_of_submission[]"  value="{{$mutli_data['no_of_submission']}}"   class="form-control number"> 
										</div>
									</div>
								</div>
							
						</td>
					</tr>
					@empty
					<tr>
						<td>
							<h4 style="text-align: center;">{{__('Date Replied By Consultant:')}}</h4>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="InputLIst">{{__('Submission Date')}}</label>
											<input type="date" name="submission_date[]" class="form-control">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="input">{{__('Actual Reply Date')}}</label>
											<input type="date" name="actual_reply_date[]" class="form-control">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="input">{{__('No of Submissions')}}</label>
											<input type="text" name="no_of_submission[]" class="form-control number">
										</div>
									</div>
								</div>
						</td>
					</tr>
					@endforelse
					
				</table>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Status')}} <span style='color:red;'>*</span></label>
							<select class="form-select" aria-label="Default select example" name="status">
								<option selected="" disabled="">Status</option>
								<option value="Approved With Comment" @if('Approved With Comment'==$data->status){ selected } @endif>Approved With Comment</option>
								<option value="Approved" @if('Approved'==$data->status){ selected } @endif>Approved</option>
								<option value="Rejected To Resubmit" @if('Rejected To Resubmit'==$data->status){ selected } @endif>Rejected To Resubmit</option>
								<option value="Approved Subject to Additional Info" @if('Approved Subject to Additional Info'==$data->status){ selected } @endif>Approved Subject to Additional Info</option>
								<option value="Pending" @if('Pending'==$data->status){ selected } @endif>Pending</option>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Attachement')}} <span style='color:red;'>*</span></label>
							<input type="file" name="filename" class="form-control document_setup" placeholder="Text input" accept="image/*, .png, .jpeg, .jpg , .pdf, .gif">
							<span class="show_document_error" style="color:red;"></span>
							<span>{{$data->filename}}</span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="input">{{__('Remarks')}} <span style='color:red;'>*</span></label>
							<textarea name="remarks" class="form-control" placeholder="{{__('Remarks')}}" required>{{$data->remarks}}</textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
				<input type="submit" value="{{__('Update')}}" class="btn btn-primary add" id="edit_procurement"> 
			</div>
		</form>
	</div>
</div>

<script>
	$(document).ready(function(){
		$(document).on('submit', 'form', function() {
            $('#edit_procurement').attr('disabled', 'disabled');
        });
        $(document).on("keyup", '#email', function () {
            $.ajax({
                url : '{{ route("check_duplicate_diary_email") }}',
                type : 'GET',
                data : { 'get_name' : $("#email").val(),'form_name' : "procurement_material" },
                success : function(data) {
                    if(data == 1){
                        $("#edit_procurement").prop('disabled',false);
                        $(".email_duplicate_error").css('display','none');
                    }
                    else{
                        $("#edit_procurement").prop('disabled',true);
                        $(".email_duplicate_error").css('display','block');
                    }
                },
                error : function(request,error)
                {
                    // alert("Request: "+JSON.stringify(request));
                }
            });
        });

		$('.number').on('paste', function (event) {
		if (event.originalEvent.clipboardData.getData('Text').match(/[^\d]/)) {
			event.preventDefault();
		}
		});

		$(".number").on("keypress",function(event){
		if(event.which < 48 || event.which >58){
			return false;
		}
		});

    });
</script>