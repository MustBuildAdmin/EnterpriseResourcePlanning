<div class="modal-body">
	<div class="row">
		<form action="{{ route('save_procurement_material') }}" enctype="multipart/form-data" method="POST">
			@csrf
			<div class="container">
				<input type="hidden" name="project_id" value="{{$projectid}}">
				<div class="row">
					<div class="form-group">
						<label for="InputLIst"><b>PROCUREMENT, MATERIAL SUPPLIER & SUPPLY LOG STATUS</b> for the project of:</label>
						<b>{{$projectname->project_name}}</b>
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
							<label for="input">{{__('Mobile/HP')}}</label>
							<input type="text" name="mobile_hp_no" class="form-control number" placeholder="{{__('Mobile/HP')}}">
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Telephone')}}</label>
							<input type="text" name="tel" class="form-control number" placeholder="{{__('Telephone')}}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Fax')}}</label>
							<input type="text" name="fax" class="form-control number" placeholder="{{__('Fax')}}">
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
							<input type="date" min="{{ date('Y-m-d', strtotime("+1 day")) }}"
							 name="target_delivery_date" class="form-control" placeholder="{{__('Target Delivery Date')}}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Target Date of Approval')}} <span style='color:red;'>*</span></label>
							<input type="date" min="{{ date('Y-m-d', strtotime("+1 day")) }}"
							 name="target_approval_date" class="form-control" placeholder="{{__('Target Date of Approval')}}" required>
						</div>
					</div>
				</div>
				<h4 style="text-align: center;">{{__('Date Replied By Consultant')}}</h4>
				<div class="table-responsive">
					<table class="table table-bordered" aria-describedby="procuremnt material">
					   <thead>
						  <tr>
							 <th class="text-center">{{__('Submission Date')}}</th>
							 <th class="text-center">{{__('Actual Reply Date')}}</th>
							 <th class="text-center">{{__('No of Submissions')}}</th>
							 <th class="text-center">{{__('Delete')}}</th>
						  </tr>
						  </tr>
					   </thead>
					   <tbody id="tbody">
						  <tr id="R1">
							 <td class="row-index text-center" >
								<input type="date" name="submission_date[]" class="form-control">
							 </td>
							 <td class="row-index text-center" >
								<input type="date" name="actual_reply_date[]" class="form-control">
							 </td>
							 <td class="row-index text-center" >
								<input type="text" name="" placeholder="{{__('No of Submissions')}}"
								   class="form-control number" value="1" disabled>
								<input type="hidden" name="no_of_submission[]" class="form-control number" value="1" >
							 </td>
							 <td class="text-center">
								<button class="btn btn-danger remove"
								   type="button">{{__('Delete')}}</button>
							 </td>
						  </tr>
					   </tbody>
					</table>
				 </div>
				 <br>

				 <button class="btn btn-md btn-primary float-end" id="addBtn" type="button">
					{{__('Add Submission')}}
				 </button>
				 <br>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Status')}} <span style='color:red;'>*</span></label>
							<select class="form-select" aria-label="Default select example" name="status">
								<option selected="" disabled="">{{__('Select Status')}}</option>
								<option value="Approved With Comment">{{__('Approved With Comment')}}</option>
								<option value="Approved">{{__('Approved')}}</option>
								<option value="Rejected">{{__('Rejected To Resubmit')}}</option>
								<option value="Subject">{{__('Approved Subject to Additional Info')}}</option>
								<option value="Pending">{{__('Pending')}}</option>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Attachement')}} <span style='color:red;'>*</span></label>
							<input type="file" name="filename"
							 class="form-control document_setup" accept="image/*, .png, .jpeg, .jpg , .pdf, .gif" placeholder="Text input">
							<span class="show_document_error" style="color:red;"></span>
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
				<input type="submit" value="{{__('Create')}}" class="btn btn-primary add" id="create_procurement">
			</div>
		</form>
	</div>
</div>

<script>
	$(document).ready(function(){
		$(document).on('submit', 'form', function() {
            $('#create_procurement').attr('disabled', 'disabled');
        });
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

		var rowIdx = 1;

	// jQuery button click event to add a row

	$(document).on("click", "#addBtn", function () {
	// Adding a row inside the tbody.
	$('#tbody').append(`<tr id="R${++rowIdx}">
		<td class="row-index text-center">
			<input type="date" name="submission_date[]" class="form-control">
		</td>
		<td class="row-index text-center">
			<input type="date" name="actual_reply_date[]" class="form-control">
		</td>
		<td class="row-index text-center">
		<input type="text" name="" placeholder="{{__('No of Submissions')}}"
		class="form-control number" value="${rowIdx}" disabled>
		<input type="hidden" name="no_of_submission[]" class="form-control number" value="${rowIdx}">
		</td>
		<td class="text-center">
			<button class="btn btn-danger remove" type="button">{{__('Delete')}}</button>
		</td>
	</tr>`);
	});
	$('#tbody').on('click', '.remove', function () {

	// Getting all the rows next to the row
	// containing the clicked button
	var child = $(this).closest('tr').nextAll();

	// Iterating across all the rows
	// obtained to change the index
	child.each(function () {

	// Getting <tr> id.
	var id = $(this).attr('id');

	// Getting the <p> inside the .row-index class.
	var idx = $(this).children('.row-index').children('p');
	var idxx = $(this).children('.row-index').children('.number');

	// Gets the row number from <tr> id.
	var dig = parseInt(id.substring(1));

	// Modifying row index.
	idx.html(`Row ${dig - 1}`);

	idxx.val(`${dig - 1}`);


	// Modifying row id.
	$(this).attr('id', `R${dig - 1}`);
	});

	if(rowIdx==1){
		toastr.error("{{Config::get('constants.ONE_ROW')}}");
 		return false;
	}
	// Removing the current row.
	$(this).closest('tr').remove();

	// Decreasing total number of rows by 1.
	rowIdx--;
	});
    });

</script>