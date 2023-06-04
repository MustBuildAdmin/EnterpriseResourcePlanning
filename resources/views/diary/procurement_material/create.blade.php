<div class="modal-body">
	<div class="row">
		<form action="{{ route('save_procurement_material') }}" method="POST"> @csrf
			<div class="container">
				<input type="hidden" name="project_id" value="{{$project_id}}">
				<div class="row">
					<div class="form-group">
						<label for="InputLIst">{{__('PROCUREMENT, MATERIAL SUPPLIER & SUPPLY LOG STATUS for the project of:')}}</label> {{$project_name->project_name}} </div>
				</div>
				<hr style="border: 1px solid black;">
				<h3 style="text-align: center;">{{__('PROCUREMENT, MATERIAL SUPPLIER & SUPPLY LOG')}}</h3>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="InputLIst">{{__('Description')}} <span style='color:red;'>*</span></label>
							<input type="text" name="description" class="form-control" placeholder="{{__('Description')}}" required> </div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('RAM Ref with No')}} <span style='color:red;'>*</span></label>
							<input type="text" name="ram_ref_no" class="form-control" placeholder="{{__('RAM Ref with No')}}" required> </div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Location')}} <span style='color:red;'>*</span></label>
							<textarea name="location" class="form-control" placeholder="{{__('Location')}}" required></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Name of Supplier')}} <span style='color:red;'>*</span></label>
							<textarea name="supplier_name" class="form-control" placeholder="{{__('Name of Supplier')}}" required></textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Contact Person')}} <span style='color:red;'>*</span></label>
							<textarea name="contact_person" class="form-control" placeholder="{{__('Contact Person')}}" required></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Mobile/HP')}} <span style='color:red;'>*</span></label>
							<textarea name="mobile_hp_no" class="form-control" placeholder="{{__('Mobile/HP')}}" required></textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Contact Person')}} <span style='color:red;'>*</span></label>
							<textarea name="contact_person" class="form-control" placeholder="{{__('Contact Person')}}" required></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Mobile/HP')}} <span style='color:red;'>*</span></label>
							<textarea name="mobile_hp_no" class="form-control" placeholder="{{__('Mobile/HP')}}" required></textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Telephone')}} <span style='color:red;'>*</span></label>
							<textarea name="contact_person" class="form-control" placeholder="{{__('Telephone')}}" required></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Fax')}} <span style='color:red;'>*</span></label>
							<textarea name="mobile_hp_no" class="form-control" placeholder="{{__('Fax')}}" required></textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Email')}} <span style='color:red;'>*</span></label>
							<textarea name="contact_person" class="form-control" placeholder="{{__('Email')}}" required></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="input">{{__('Lead Time')}} <span style='color:red;'>*</span></label>
							<textarea name="mobile_hp_no" class="form-control" placeholder="{{__('Lead Time')}}" required></textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="input">{{__('Target Delivery Date')}} <span style='color:red;'>*</span></label>
							<textarea name="target_delivery_date" class="form-control" placeholder="{{__('Target Delivery Date')}}" required></textarea>
						</div>
					</div>
				</div>
				<table class="table" id="dynamicprocurement">
					<tr>
						<td>
							<h4 style="text-align: center;">Submission:</h4>
							<div class="">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="InputLIst">Submission Date</label>
											<input type="date" name="submission_date[]" class="form-control"> 
                                        </div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="input">Actual Reply Date</label>
											<input type="date" name="actual_reply_date[]" class="form-control"> 
                                        </div>
									</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 pull-right">
                                        <div class="form-group">
											<button class="btn btn-primary pull-right" type="button" id="dynamic-procurement"> Add Submission </button>
                                        </div>
									</div>
								</div>
                            </div>
							</div>
						</td>
					</tr>
				</table>
				<div class="col-md-3 pull-right">
					<button class="btn btn-primary" type="button" id="dynamic-procurement"> Add Submission </button>
				</div>
			</div>
			<div class="modal-footer">
				<input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
				<input type="submit" value="{{__('Create')}}" class="btn  btn-primary"> 
            </div>
		</form>
	</div>
</div>