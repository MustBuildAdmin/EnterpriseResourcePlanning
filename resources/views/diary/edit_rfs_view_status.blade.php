<div class="modal-body">
	<div class="row">
		<div class="modal-body">
			<div class="row">
				<form action="{{route('update_rfi_info_status')}}" enctype="multipart/form-data" method="POST"> @csrf
					<div class="container">
						<input type="hidden" name="project_id" value="{{$project_id}}">
						<input type="hidden" name="id" value="{{$data->id}}">
						<div class="row">
							<div class="form-group">
								<label for="InputLIst">REQUEST FOR INFORMATION (RFI) STATUS for the project of:</label> {{$project_name->project_name}} </div>
						</div>
						<hr style="border: 1px solid black;">
						<h3 style="text-align: center;">REQUEST FOR INFORMATION (RFI) STATUS</h3>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="InputLIst">RFI Reference No :</label>
									<input type="text" name="reference_no" class="form-control" placeholder="Text input" value="{{$data->reference_no}}"> </div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="input">Issue Date :</label>
									<input type="date" name="issue_date" class="form-control" placeholder="Text input" value="{{$data->issue_date}}"> </div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="input">Description:</label>
									<textarea name="description" class="form-control" type="text">{{$data->description}}</textarea>
								</div>
							</div>
						</div>
						<hr />
						<table class="table" id="dynamicaddrfi"> 
							@forelse($rfs_dir_multi as $mutli_data)
							<tr>
								<td>
									<h4 style="text-align: center;">Date Replied By Consultant :</h4>
									<div class="">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="InputLIst">Submit Date :</label>
													<input type="date" name="submit_date[]" class="form-control" value="{{$mutli_data['submit_date']}}"> </div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="input">Return Date :</label>
													<input type="date" name="return_date[]" class="form-control" value="{{$mutli_data['return_date']}}"> </div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="Input">Status of Return :</label>
													<select class="form-control" name="status_of_return[]">
														<option selected disabled>Status</option>
														<option value="Exception" @if( 'Exception'==$mutli_data[ 'status_of_return']){ selected }@endif>No Exception Taken (NET) (OR) Approved /with comment</option>
														<option value="Resubmission" @if( 'Resubmission'==$mutli_data[ 'status_of_return']){ selected }@endif>Revise No Resubmission Requried (RNRR)</option>
														<option value="Revise" @if( 'Revise'==$mutli_data[ 'status_of_return']){ selected }@endif>Revise and Resubmit (RR)</option>
														<option value="Submit" @if( 'Revise'==$mutli_data[ 'status_of_return']){ selected }@endif>Submit Specified Item (SSI)</option>
														<option value="Rejected" @if( 'Rejected'==$mutli_data[ 'status_of_return']){ selected }@endif>Rejected</option>
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="InputDate">Remarks :</label>
													<textarea class="form-control" name="remarks[]">{{$mutli_data['remarks']}}</textarea>
												</div>
											</div>
										</div>
										
									</div>
								</td>
							</tr> 
							@empty
							<tr>
								<td>
									<h4 style="text-align: center;">Date Replied By Consultant :</h4>
									<div class="">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="InputLIst">Submit Date :</label>
													<input type="date" name="submit_date[]" class="form-control" value=""> </div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="input">Return Date :</label>
													<input type="date" name="return_date[]" class="form-control" value=""> </div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="Input">Status of Return :</label>
													<select class="form-control" name="status_of_return[]">
														<option selected disabled>Status</option>
														<option value="Exception">No Exception Taken (NET) (OR) Approved /with comment</option>
														<option value="Resubmission">Revise No Resubmission Requried (RNRR)</option>
														<option value="Revise">Revise and Resubmit (RR)</option>
														<option value="Submit">Submit Specified Item (SSI)</option>
														<option value="Rejected" >Rejected</option>
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="InputDate">Remarks :</label>
													<textarea class="form-control" name="remarks[]"></textarea>
												</div>
											</div>
										</div>
										
									</div>
								</td>
							</tr> 
							@endforelse 
							<div class="col-md-3 pull-right">
								<button class="btn btn-primary" type="button" id="dynamic-rfi"> Add Submission </button>
							</div>
						</table>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="Input">Consultant-1 :</label>
									<input type="date" name="consultant_date1" class="form-control" value="{{$data->consultant_date1}}">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="Input">Consultant-2 :</label>
									<input type="date" name="consultant_date2" class="form-control" value="{{$data->consultant_date2}}">
								 </div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="Input">Consultant-3 :</label>
									<input type="date" name="consultant_date3" class="form-control" value="{{$data->consultant_date3}}"> 
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="Input">Consultant-4 :</label>
									<input type="date" name="consultant_date4" class="form-control" value="{{$data->consultant_date4}}"> 
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="Input">Consultant-5 :</label>
									<input type="date" name="consultant_date5" class="form-control" value="{{$data->consultant_date5}}"> 
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="Input">Consultant-6 :</label>
									<input type="date" name="consultant_date6" class="form-control" value="{{$data->consultant_date6}}"> 
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<h4>Status :</h4>
							<select class="form-select" aria-label="Default select example" name="rfi_status">
								<option selected disabled>Status</option>
								<option value="Clear" @if( 'Clear'==$data->rfi_status){ selected }@endif>Clear</option>
								<option value="Pending" @if( 'Pending'==$data->Pending){ selected }@endif>Pending</option>
								<option value="Rejected" @if( 'Rejected'==$data->Rejected){ selected }@endif>Rejected</option>
								<option value="Withdrawn" @if( 'Withdrawn'==$data->Withdrawn){ selected }@endif>Withdrawn</option>
							</select>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-group">Remarks:</label>
								<textarea class="form-control" type="text" name="remark1">{{$data->remark1}}</textarea>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="InputATTACHMENTS:">ATTACHMENTS:</label>
								<input type="file" name="attachment_file" class="form-control imgs" placeholder="Text input"> <span>{{$data->attachment_file}}</span> </div>
						</div>
					</div>
					<div class="col-xs-9"></div>
					<div class="modal-footer">
						<input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
						<input type="submit" value="{{__('Update')}}" class="btn  btn-primary"> </div>
				</form>
			</div>
		</div>
	</div>
</div>