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
								<label for="InputLIst">{{__('REQUEST FOR INFORMATION (RFI) STATUS for the project of:')}}</label> {{$project_name->project_name}} 
							</div>
						</div>
						<hr style="border: 1px solid black;">
						<h3 style="text-align: center;">{{__('REQUEST FOR INFORMATION (RFI) STATUS')}}</h3>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="InputLIst">{{__('RFI Reference No')}} <span style='color:red;'>*</span></label>
									<input type="text" name="reference_no" class="form-control" placeholder="{{__('RFI Reference No')}}" value="{{$data->reference_no}}" required> 
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="input">{{__('Issue Date')}} <span style='color:red;'>*</span></label>
									<input type="date" name="issue_date" class="form-control" placeholder="Text input" value="{{$data->issue_date}}" required> 
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="input">{{__('Description')}} <span style='color:red;'>*</span></label>
									<textarea name="description" class="form-control"  placeholder="{{__('Description')}}" required>{{$data->description}}</textarea>
								</div>
							</div>
						</div>
						<hr />
						<table class="table" id="dynamicaddrfi"> 
							@forelse($rfs_dir_multi as $mutli_data)
							<tr>
								<td>
									<h4 style="text-align: center;">{{__('Date Replied By Consultant :')}}</h4>
									<div class="">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="InputLIst">{{__('Submit Date')}}</label>
													<input type="date" name="submit_date[]" class="form-control" value="{{$mutli_data['submit_date']}}" required> 
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="input">{{__('Return Date')}}</label>
													<input type="date" name="return_date[]" class="form-control" value="{{$mutli_data['return_date']}}" required> 
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="Input">{{__('Status of Return')}}</label>
													<select class="form-control" name="status_of_return[]" required>
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
													<label for="InputDate">{{__('Remarks')}}</label>
													<textarea class="form-control" name="remarks[]" required>{{$mutli_data['remarks']}}</textarea>
												</div>
											</div>
										</div>
										
									</div>
								</td>
							</tr> 
							@empty
							<tr>
								<td>
									<h4 style="text-align: center;">{{__('Date Replied By Consultant :')}}</h4>
									<div class="">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="InputLIst">{{__('Submit Date')}}</label>
													<input type="date" name="submit_date[]" class="form-control" value=""> </div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="input">{{__('Return Date')}}</label>
													<input type="date" name="return_date[]" class="form-control" value=""> </div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="Input">{{__('Status of Return')}}</label>
													<select class="form-control" name="status_of_return[]" required>
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
													<label for="InputDate">{{__('Remarks')}}</label>
													<textarea class="form-control" name="remarks[]" required placeholder="{{__('Remarks')}}"></textarea>
												</div>
											</div>
										</div>
										
									</div>
								</td>
							</tr> 
							@endforelse 
							<div class="col-md-3 pull-right">
								<button class="btn btn-primary" type="button" id="dynamic-rfi">{{__('Add Submission ')}}</button>
							</div>
						</table>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="Input">{{__('Consultant-1')}}</label>
									<input type="date" name="consultant_date1" class="form-control" value="{{$data->consultant_date1}}">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="Input">{{__('Consultant-2')}}</label>
									<input type="date" name="consultant_date2" class="form-control" value="{{$data->consultant_date2}}">
								 </div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="Input">{{__('Consultant-3')}}</label>
									<input type="date" name="consultant_date3" class="form-control" value="{{$data->consultant_date3}}"> 
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="Input">{{__('Consultant-4')}}</label>
									<input type="date" name="consultant_date4" class="form-control" value="{{$data->consultant_date4}}"> 
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="Input">{{__('Consultant-5')}}</label>
									<input type="date" name="consultant_date5" class="form-control" value="{{$data->consultant_date5}}"> 
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="Input">{{__('Consultant-6')}}</label>
									<input type="date" name="consultant_date6" class="form-control" value="{{$data->consultant_date6}}"> 
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<h4>{{__('Status')}}<span style='color:red;'>*</span></h4>
							<select class="form-select" aria-label="Default select example" name="rfi_status" required>
								<option selected disabled>Status</option>
								<option value="Clear" @if( 'Clear'==$data->rfi_status){ selected }@endif>Clear</option>
								<option value="Pending" @if( 'Pending'==$data->Pending){ selected }@endif>Pending</option>
								<option value="Rejected" @if( 'Rejected'==$data->Rejected){ selected }@endif>Rejected</option>
								<option value="Withdrawn" @if( 'Withdrawn'==$data->Withdrawn){ selected }@endif>Withdrawn</option>
							</select>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-group">{{__('Remarks')}} <span style='color:red;'>*</span></label>
								<textarea class="form-control" type="text" name="remark1" required>{{$data->remark1}}</textarea>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="InputATTACHMENTS:">{{__('Attachments')}} <span style='color:red;'>*</span></label>
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