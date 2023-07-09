<style>
    div#choices_multiple1_chosen {
        width: 100% !important;
    }
    div.name_of_consulatant {
        width: 100% !important;
    }
    div#choices_multiple2_chosen{
        width: 100% !important;
    }
</style>
<div class="modal-body">
	<div class="row">
		<form id="edit_rfi" action="{{ route('update_rfi_info_status') }}" enctype="multipart/form-data" method="POST">
			@csrf
			<div class="container">
				<input type="hidden" name="project_id" value="{{$project}}" />
				<input type="hidden" name="edit_id" id="edit_id" value="{{$getdairy->id}}">
				<div class="row">
                    @if($getdairy != null)
                        @if($getdairy->consulatant_data != null)
                        @php $consulatant_data=json_decode($getdairy->consulatant_data); @endphp
                        @else
                        @php $consulatant_data=array(); @endphp
                        @endif
                    @else
                        @php $consulatant_data=array(); @endphp
                    @endif
					<div class="form-group">
						<label for="InputLIst"><b>REQUEST FOR INFORMATION (RFI) STATUS</b> for the project of:</label>
						<b>{{$project->project_name}}</b>
					</div>
					<div class="form-group">
						<div class="col-md-4">
							<label for="InputLIst">{{__('Contractor')}}</label>
							<input type="text" name="contractor_name" class="form-control"
							 placeholder="{{__('Contractor')}}" value="{{$getdairy->contractor_name}}" />
                        </div>
					</div>
				</div>
				<hr style="border: 1px solid black;" />
				<h3 style="text-align: center;">{{__('REQUEST FOR INFORMATION (RFI) STATUS')}}</h3>
				<div class="row">
					<div class="form-group">
						<label for="InputLIst">{{__('Enter Type of Consultants List to send RFI:')}}</label>
					</div>
				</div>
				<div class="row">
                    @php $con_row=1; @endphp
                    @forelse ($consulatant_data as $conkey =>$con)
					<div class="col-md-4">
						<div class="form-group">
							<label for="InputLIst">{{__('Consultant No.')}}{{$con_row}}
								@if($loop->iteration==1) <span style='color:red;'>*</span> @endif</label>
							<input type="text" name="data[{{$conkey}}]" class="form-control {{$conkey}}"
							 value="{{$con}}" placeholder="{{__('Consultant No.')}} {{$con_row}}" @if($loop->iteration==1) required @endif/>
                        </div>
					</div>
					@php $con_row++; @endphp
					@empty
					@endforelse
					
				</div>
				<button class="btn btn-primary float-end" type="button" id="dynamic-procure">{{__('Add Consultant')}}</button>
				
				<table class="table" id="dynamicprocure"> </table>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="Input">{{__('RFI Reference No')}}</label>
							<input type="text" name="reference_no" value="{{$getdairy->reference_no  ?? ''}}"
							 class="form-control" placeholder="{{__('RFI Reference No')}}" />
                        </div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="Input">{{__('Requested Date')}}</label>
							<input type="date" name="requested_date" value="{{$getdairy->requested_date  ?? ''}}"
							 class="form-control" placeholder="{{__('Referene')}}" />
                        </div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="Input">{{__('Required Date')}}</label>
							<input type="date" name="required_date" value="{{$getdairy->required_date  ?? ''}}"
							 class="form-control" placeholder="{{__('RFI Reference No')}}" />
                        </div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="Input">{{__('Priority')}}</label>
							<select name="priority" class="form-control">
								<option value="">{{__('Select Priority')}}</option>
								<option value="High" @if( 'High'==$getdairy[ 'priority']){ selected }@endif>{{__('High')}}</option>
								<option value="Normal" @if( 'Normal'==$getdairy[ 'priority']){ selected }@endif>{{__('Normal')}}</option>
								<option value="Unknown" @if( 'Unknown'==$getdairy[ 'priority']){ selected }@endif>{{__('Unknown')}}</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="Input">{{__('Cost Impact')}}</label>
							<select name="cost_impact" class="form-control">
								<option value="">{{__('Select Cost Impact')}}</option>
								<option value="Yes" @if( 'Yes'==$getdairy[ 'cost_impact']){ selected }@endif>{{__('Yes')}}</option>
								<option value="No" @if( 'No'==$getdairy[ 'cost_impact']){ selected }@endif>{{__('No')}}</option>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="Input">{{__('Time impact')}}</label>
							<select name="time_impact" class="form-control">
								<option value="">{{__('Select Time impact')}}</option>
								<option value="Yes" @if( 'Yes'==$getdairy[ 'cost_impact']){ selected }@endif>{{__('Yes')}}</option>
								<option value="No" @if( 'No'==$getdairy[ 'cost_impact']){ selected }@endif>{{__('No')}}</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="Input">{{__('Description')}}</label>
							<textarea name="description" class="form-control"
							 row="3" placeholder="{{__('Description')}}">{{$getdairy->description ?? ''}}</textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 mt-2">
						<div class="form-group">
							<label for="Input">{{__('Select the Consultants')}}</label>
							<select name="select_the_consultants[]" id="choices-multiple1" class='chosen-select' required multiple>
								<option value="" disabled>{{__('Select the Consultants')}}</option>
                                @foreach ($consulatant_data as $conkey =>$con)
								<option @if(str_contains($getdairy->select_the_consultants,$con)) selected @endif
								value="{{$con}}">{{$con}}</option>
                                @endforeach
                            </select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="Input">{{__('Attachments')}}</label>
							<input type="file" id="attachment_one" name="attachment_one" class="form-control">
							<div>{{$getdairy->attachment_one}}</div>
						</div>
					</div>
				</div>
                @php $key_count=1; @endphp
                @forelse ($getcontent as $key => $mutli_data)
				<h4 style="text-align: center;font-weight:700;">{{__('Date Replied by the Consultants')}}</h4>
				<hr>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="Input">{{__('Name of Consultant')}}</label>
							<select name="name_of_consulatant{{$key_count}}[]" id="choices-multiple2"
							 class="chosen-select" required multiple>
								<option value="" disabled>{{__('Select Name of Consultant')}}</option>
                                @foreach ($consulatant_data as $con =>$co)
								<option @if(str_contains($mutli_data->name_of_consultant ?? '',$co)) selected @endif
								value="{{$co}}">{{$co}}</option>
                                @endforeach
                            </select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="Input">{{__('Replied Date')}}</label>
							<input type="date" name="replied_date{{$key_count}}" class="form-control"
							 value="{{$mutli_data->replied_date ?? ''}}" />
                        </div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="Input">{{__('Status')}}</label>
							@if($getsubtable==null)
							<select name="status{{$key_count}}" class="form-control">
								<option value="">{{__('Select Status')}}</option>
								<option value="Clear">{{__('Clear')}}</option>
								<option value="Close">{{__('Close')}}</option>
								<option value="Pending">{{__('Pending')}}</option>
								<option value="Rejected">{{__('Rejected')}}</option>
								<option value="Withdrawn">{{__('Withdrawn')}}</option>
							</select>
							@else
							<select name="status{{$key_count}}" class="form-control">
								<option value="">{{__('Select Status')}}</option>
								<option value="Clear" @if( 'Clear'==$mutli_data[ 'status'] ?? ''){ selected } @endif>{{__('Clear')}}</option>
								<option value="Close" @if( 'Close'==$mutli_data[ 'status'] ?? ''){ selected } @endif>{{__('Close')}}</option>
								<option value="Pending"
								 @if( 'Pending'==$mutli_data[ 'status'] ?? ''){ selected } @endif>{{__('Pending')}}</option>
								<option value="Rejected" @if( 'Rejected'==$mutli_data[ 'status'] ?? ''){ selected } @endif>
									{{__('Rejected')}}
								</option>
								<option value="Withdrawn"
								@if( 'Withdrawn'==$mutli_data[ 'status'] ?? ''){ selected } @endif>
								{{__('Withdrawn')}}
								</option>
							</select>
                            @endif
                        </div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="Input">{{__('Remarks')}}</label>
							<textarea name="remarks{{$key_count}}" class="form-control">{{$mutli_data->remarks ?? ''}}</textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="Input">{{__('Attachments')}}</label>
							<input type="file" name="attachments_two{{$key_count}}"
							class="form-control" accept="image/*, .png, .jpeg, .jpg , .pdf, .gif">
							<span>{{$mutli_data->attachments_two ?? ''}}</span>
                        </div>
					</div>
				</div>
                @php $key_count++; @endphp
				<br>
				<br>
                @empty
				<h4 style="text-align: center;font-weight:700;">{{__('Date Replied by the Consultants')}}</h4>
				<hr>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="Input">{{__('Name of Consultant')}}</label>
							<select name="name_of_consulatant1[]" id="choices-multiple2" class="chosen-select" required multiple>
								<option value="" disabled>{{__('Select Name of Consultant')}}</option>
                                @foreach ($consulatant_data as $con =>$co)
								<option
								@if(str_contains($mutli_data->name_of_consultant ?? '',$co)) selected @endif
								value="{{$co}}">{{$co}}</option>
                                @endforeach
                            </select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="Input">{{__('Replied Date')}}</label>
							<input type="date" name="replied_date1" class="form-control"
							 value="{{$getsubtable->replied_date ?? ''}}" />
                        </div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="Input">{{__('Status')}}</label>
							<select name="status1" class="form-control">
								<option value="">{{__('Select Status')}}</option>
								<option value="Clear">{{__('Clear')}}</option>
								<option value="Close">{{__('Close')}}</option>
								<option value="Pending">{{__('Pending')}}</option>
								<option value="Rejected">{{__('Rejected')}}</option>
								<option value="Withdrawn">{{__('Withdrawn')}}</option>
							</select>
                        </div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="Input">{{__('Remarks')}}</label>
							<textarea name="remarks1" class="form-control"></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="Input">{{__('Attachments')}}</label>
							<input type="file" name="attachments_two1" class="form-control document_setup"
							 value="" accept="image/*, .png, .jpeg, .jpg , .pdf, .gif">
							<span class="show_document_error" style="color:red;"></span>
                        </div>
					</div>
				</div>
				@endforelse
				<button class="btn btn-primary float-end" type="button" id="dynamic-rfi">{{__('Add More')}}</button>
				<br><br>
				<div class="row">
					<table class="table" id="dynamic_add_rfi" aria-describedby="rfi table">
						<th></th>
						<tr id="rfi_create">
					</table>
				</div>
				<input type="hidden" id="multi_total_count" name="multi_total_count" value="{{$key_count}}">
			</div>
			<br><br>
			<div class="modal-footer">
				<input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal" />
				<input type="submit" value="{{__('Update')}}" class="btn btn-primary" id="edit_rfi_button"/> </div>
		</form>
	</div>
</div>
<script type="text/javascript">
    $(document).on("click", ".remove-input-field", function () {
        $(this).parents("tr").remove();
    });

    $('.get_reportto').on('change', function() {
        get_val = $(this).val();
        
        if(get_val != ""){
            $("#reportto-error").hide();
        }
        else{
            $("#reportto-error").show();
        }
    });
    
    $(".chosen-select").chosen({
        placeholder_text:"{{ __('Reporting to') }}"
    });

   $(document).ready(function() {
        var i = $('#multi_total_count').val();
        $("#edit_rfi").on('click', '#dynamic-rfi', function() {
          
            $.ajax({
                url: '{{ route("get_name_of_consultant") }}',
                type: 'GET',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': $('#edit_id').val()
                },
                success: function(data) {
                    ++i;
                    $("#multi_total_count").val(i);
                    $("#dynamic_add_rfi").append(
						'<tr>'+
                        '<td>'+
                            '<h4 style="text-align: center; font-weight: 700">Date Replied by the Consultants</h4>'+
							'<hr>'+
							'<div class="row">'+
                            	'<div class="col-md-4">'+
									'<div class="form-group">'+
										'<label for="Input">Name of Consultant</label>'+
										'<select name="name_of_consulatant' + i + '[]"'+
										   'class="chosen-select name_of_consulatant_' + i + '" multiple style="width: 309px;">'+
											'<option value="Select the Consultants" >Select the Consultants</option>"'+data+'"'+
										'</select>'+
                            		'</div>'+
								'</div>'+
									'<div class="col-md-4">'+
										'<div class="form-group">'+
											'<label for="Input">Replied Date</label>'+
											'<input type="date" name="replied_date' + i + '" class="form-control" />'+
										'</div>'+
									'</div>'+
									'<div class="col-md-4">'+
										'<div class="form-group">'+
											'<label for="Input">Status</label>'+
											'<select name="status' + i + '" class="form-control">'+
												'<option value="">Select Status</option>'+
												'<option value="Clear">Clear</option>'+
												'<option value="Close">Close</option>'+
												'<option value="Pending">Pending</option>'+
												'<option value="Rejected">Rejected</option>'+
												'<option value="Withdrawn">Withdrawn</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
							'</div>'+
                            '<div class="row">'+
								'<div class="col-md-6">'+
									'<div class="form-group">'+
										'<label for="Input">Remarks</label>'+
                                		'<textarea name="remarks' + i + '" class="form-control"></textarea>'+
                            		'</div>'+
								'</div>'+
								'<div class="col-md-6">'+
									'<div class="form-group">'+
										'<label for="Input">Attachments</label>'+
										'<input type="file" name="attachments_two' + i + '"'+
										 'class="form-control document_setup" accept="image/*, .png, .jpeg, .jpg , .pdf, .gif">'+
										'<span class="show_document_error" style="color:red;"></span>'+
									'</div>'+
								'</div>'+
							'</div>'+
                            '<button class="btn btn-danger remove-input-field float-end" type="button">Delete</button>'+
                        '</td>'+
                    '</tr>');

            
                    setTimeout(function() {
                        $myid = $('.name_of_consulatant_' + i);
                        $myid.show().chosen();
                    }, 10);

                },
                error: function(request, error) {

                    // alert("Request: "+JSON.stringify(request));
                }
            });
        });

        $(document).on('click', '.remove-input-field', function() {
            var count=$('#multi_total_count').val();
            $('#multi_total_count').val(count-1);
            $(this).parents('tr').remove();
        });

       
    var j = 12;
    var k = 12;
    var g = 12;
    $(document).on("click", "#dynamic-procure", function () {
       
        $("#dynamicprocure").append(
			'<tr>'+
				'<td>'+
					'<div class="">'+
						'<div class="row">'+
							'<div class="col-md-4">'+
								'<div class="form-group">'+
									'<label for="InputLIst">Consultant No.'+  ++k +'</label>'+
									'<input type="text" name="data[consultant_'+ ++j +']" class="form-control"'+
									'placeholder="Consultant No. '+ ++g +'" value="">'+
								'</div>'+
							'</div>'+
							'<div class="col-md-4">'+
								'<div class="form-group">'+
									'<label for="input">Consultant No. '+ ++k +'</label>'+
									'<input type="text" name="data[consultant_' + ++j + ']"'+
									'placeholder="Consultant No. '+ ++g +'" class="form-control" value="">'+
								'</div>'+
							'</div>'+
							'<div class="col-md-4">'+
								'<div class="form-group">'+
									'<label for="input">Consultant No. '+ ++k +'</label>'+
									'<input type="text" name="data[consultant_' + ++j + ']" class="form-control"'+
									 'placeholder="Consultant No. '+ ++g +'" value="">'+
								'</div>'+
							'</div>'+
						'</div>'+
						'<button class="btn btn-secondary float-end" type="button"'+
						 'id="removedynamicprocure"> Remove Consultant </button>'+
					'</div>'+
			'</td>'+
			'</tr>'
													);
    });
    $(document).on('click', '#removedynamicprocure', function () {
        $(this).parents('tr').remove();
    });
    
	$(document).on('submit', 'form', function() {
        $('#edit_rfi_button').attr('disabled', 'disabled');
    });

	$(document).on('change', '.document_setup', function(){
          var fileExtension = ['jpeg', 'jpg', 'png', 'pdf', 'gif'];
          if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
              $(".show_document_file").hide();
              $(".show_document_error").html("Upload only pdf, jpeg, jpg, png, gif");
              $("#edit_rfi_button").prop('disabled',true);
              return false;
          } else{
              $(".show_document_file").show();
              $(".show_document_error").hide();
              $("#edit_rfi_button").prop('disabled',false);
              return true;
          }

    });

    });
  </script>