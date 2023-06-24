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
		<form id="edit_rfi" action="{{ route('update_rfi_info_status') }}" enctype="multipart/form-data" method="POST"> @csrf
			<div class="container">
				<input type="hidden" name="project_id" value="{{$project}}" />
				<input type="hidden" name="edit_id" id="edit_id" value="{{$get_dairy->id}}">
				<div class="row"> 
                    @if($get_dairy != null) 
                        @if($get_dairy->consulatant_data != null) 
                        @php $consulatant_data=json_decode($get_dairy->consulatant_data); @endphp 
                        @else 
                        @php $consulatant_data=array(); @endphp 
                        @endif 
                    @else 
                        @php $consulatant_data=array(); @endphp 
                    @endif
					<div class="form-group">
						<label for="InputLIst">{{__('REQUEST FOR INFORMATION (RFI) STATUS for the project of:')}}</label> {{$project->project_name}} </div>
					<div class="form-group">
						<div class="col-md-4">
							<label for="InputLIst">{{__('Contractor')}}</label>
							<input type="text" name="contractor_name" class="form-control" placeholder="{{__('Contractor')}}" value="{{$get_dairy->contractor_name}}" /> 
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
							<label for="InputLIst">{{__('Consultant No.')}}{{$con_row}} @if($loop->iteration==1) <span style='color:red;'>*</span> @endif</label>
							<input type="text" name="data[{{$conkey}}]" class="form-control {{$conkey}}" value="{{$con}}" placeholder="{{__('Consultant No.')}} {{$con_row}}" @if($loop->iteration==1) required @endif/> 
                        </div>
					</div> 
                    @php $con_row++; @endphp 
                    @empty 
                    @endforelse
					<div class="col-md-3 pull-right">
						<button class="btn btn-primary" type="button" id="dynamic-procure">{{__('Add Consultant')}}</button>
					</div>
					<table class="table" id="dynamicprocure"> </table>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="Input">{{__('RFI Reference No')}}</label>
							<input type="text" name="reference_no" value="{{$get_dairy->reference_no  ?? ''}}" class="form-control" placeholder="{{__('RFI Reference No')}}" /> 
                        </div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="Input">{{__('Requested Date')}}</label>
							<input type="date" name="requested_date" value="" class="form-control" placeholder="{{__('Referene')}}" /> 
                        </div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="Input">{{__('Required Date')}}</label>
							<input type="date" name="required_date" value="" class="form-control" placeholder="{{__('RFI Reference No')}}" /> 
                        </div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="Input">{{__('Priority')}}</label>
							<select name="priority" class="form-control">
								<option value="">{{__('Select Priority')}}</option>
								<option value="High">{{__('High')}}</option>
								<option value="Normal">{{__('Normal')}}</option>
								<option value="Unknown">{{__('Unknown')}}</option>
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
								<option value="Yes">{{__('Yes')}}</option>
								<option value="No">{{__('No')}}</option>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="Input">{{__('Time impact')}}</label>
							<select name="time_impact" class="form-control">
								<option value="">{{__('Select Time impact')}}</option>
								<option value="Yes">{{__('Yes')}}</option>
								<option value="No">{{__('No')}}</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="Input">{{__('Description')}}</label>
							<textarea name="description" class="form-control" row="3" placeholder="{{__('Description')}}"></textarea>
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
								<option value="{{$con}}">{{$con}}</option> 
                                @endforeach 
                            </select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="Input">{{__('Attachments')}}</label>
							<input type="file" id="attachment_one" name="attachment_one" class="form-control">
						</div>
					</div>
				</div> 
                @php $key_count=1; @endphp 
				<h4 style="text-align: center;font-weight:700;">{{__('Date Replied by the Consultants')}}</h4>
				<hr>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="Input">{{__('Name of Consultant')}}</label>
							<select name="name_of_consulatant{{$key_count}}[]" id="choices-multiple2" class="chosen-select" required multiple>
								<option value="" disabled>{{__('Select Name of Consultant')}}</option> 
                                @foreach ($consulatant_data as $con =>$co)
								<option value="{{$co}}">{{$co}}</option> 
                                @endforeach 
                            </select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="Input">{{__('Replied Date')}}</label>
							<input type="date" name="replied_date{{$key_count}}" class="form-control" /> 
                        </div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="Input">{{__('Status')}}</label> 
							<select name="status{{$key_count}}" class="form-control">
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
							<textarea name="remarks{{$key_count}}" class="form-control"></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="Input">{{__('Attachments')}}</label>
							<input type="file" name="attachments_two{{$key_count}}" class="form-control"> 
                        </div>
					</div>
				</div> 
              
				<div class="row">
					<table class="table" id="dynamic_add_rfi">
						<tr id="rfi_create">
					</table>
				</div>
				<input type="hidden" id="multi_total_count" name="multi_total_count" value="{{$key_count}}">
				<div class="col-md-12 mt-3 float-end floatrght">
					<button type="button" name="add" id="dynamic-rfi" class="btn btn-outline-primary">{{__('Add More')}}</button>
				</div>
			</div>
			<div class="modal-footer">
				<input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal" />
				<input type="submit" value="{{__('Update')}}" class="btn btn-primary" /> </div>
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
                    $("#dynamic_add_rfi").append('<tr>'+
                        '<td>'+
                            '<h4 style="text-align: center; font-weight: 700">Date Replied by the Consultants</h4><hr><div class="row">'+
                            '<div class="col-md-4"><div class="form-group"><label for="Input">Name of Consultant</label>'+
                                '<select name="name_of_consulatant' + i + '[]"   class="chosen-select name_of_consulatant_' + i + '" multiple style="width: 343px;">'+
                                    '<option value="Select the Consultants" >Select the Consultants</option>"'+data+'"'+
                                '</select>'+
                            '</div></div>'+
                            '<div class="col-md-4"><div class="form-group"><label for="Input">Replied Date</label>'+
                                '<input type="date" name="replied_date' + i + '" class="form-control" />'+
                            '</div></div>'+
                            '<div class="col-md-4"><div class="form-group"><label for="Input">Status</label>'+
                                '<select name="status' + i + '" class="form-control">'+
                                    '<option value="">Select Status</option>'+
                                    '<option value="Clear">Clear</option>'+
                                    '<option value="Close">Close</option>'+
                                    '<option value="Pending">Pending</option>'+
                                    '<option value="Rejected">Rejected</option>'+
                                    '<option value="Withdrawn">Withdrawn</option>'+
                                '</select>'+
                            '</div></div></div>'+
                            '<div class="row"><div class="col-md-6"><div class="form-group"><label for="Input">Remarks</label>'+
                                '<textarea name="remarks' + i + '" class="form-control"></textarea>'+
                            '</div></div>'+
                            '<div class="col-md-6"><div class="form-group"><label for="Input">Attachments</label>'+
                                '<input type="file" name="attachments_two' + i + '" class="form-control">'+
                            '</div></div></div>'+
                            '<div class="col-md-12 mt-3">'+
                                '<button type="button" class="btn btn-outline-danger remove-input-field">Delete</button>'+
                            '</div>'+
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
       
        $("#dynamicprocure").append('<tr><td><div class=""><div class="row"><div class="col-md-4"><div class="form-group"><label for="InputLIst">Consultant No.'+  ++k +'</label><input type="text" name="data[consultant_'+ ++j +']" class="form-control" placeholder="Consultant No. '+ ++g +'" value=""></div></div><div class="col-md-4"><div class="form-group"><label for="input">Consultant No. '+ ++k +'</label><input type="text" name="data[consultant_' + ++j + ']" placeholder="Consultant No. '+ ++g +'" class="form-control" value=""></div></div><div class="col-md-4"><div class="form-group"><label for="input">Consultant No. '+ ++k +'</label><input type="text" name="data[consultant_' + ++j + ']" class="form-control" placeholder="Consultant No. '+ ++g +'" value=""></div></div></div><div class="col-md-3 pull-right"><button class="btn btn-secondary" type="button" id="removedynamicprocure"> Remove Consultant </button></div></div></td></tr>');
    });
    $(document).on('click', '#removedynamicprocure', function () {
        $(this).parents('tr').remove();
    });
    

    });
  </script>