<style>
    .form-check {
        margin: 8px 12px !important;
    }
</style>
    
{{Form::model(null,array('route' => array('update_assigned_to', $con_task->main_id), 'method' => 'PUT')) }}
    <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    
                    <div class="card-body table-border-style">
                        <div class="table-responsive" style="height: 280px;">
                            <table style="width: 100%; border-collapse:separate; border-spacing: 40px 2em;">
                                <tr class="highlighted">
                                    <td style="width: 15%; font-weight:bold;">Project Name:</td>
                                    <td style="width: 35%">{{ $con_task->project_name }}</td>
        
                                    <td style="width: 15%; font-weight:bold;">Description:</td>
                                    <td style="width: 35%">{{$con_task->description != null ? $con_task->description : '-'}}</td>
                                </tr>
        
                                <tr class="highlighted">
                                    <td style="font-weight:bold;">Task Start Date:</td>
                                    <td style="">{{Utility::site_date_format($con_task->start_date,\Auth::user()->id)}}</td>
        
                                    <td style="font-weight:bold;">Task End Date:</td>
                                    <td style="">{{Utility::site_date_format($con_task->end_date,\Auth::user()->id)}}</td>
                                </tr>
        
                                <tr class="highlighted">
                                    <td style="font-weight:bold;">Task Overall Percentage:</td>
                                    <td style="">{{ $total_pecentage }}%</td>
        
                                    <td style="font-weight:bold;">Assigned To</td>
                                    <td style="">
                                        <select class="select form-select users chosen-select" name="users[]" id="users" multiple>
                                            <option value="" class="" disabled>{{ __('Assigned To') }}</option>
                                            @foreach ($assigned_to as $users)
                                                <option value="{{$users->id}}" @if(str_contains($con_task->users,$users->id)) selected @endif>{{$users->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    @error('name')
                        <span class="invalid-name" role="alert">
                            <strong class="text-danger">{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>  
        </div>
    </div>
    <div class="modal-footer">
        <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
    </div>
{{Form::close()}}

<script>
    $(".chosen-select").chosen({
        disable_search_threshold: 10,
        no_results_text: "Oops, nothing found!",
        width: "95%"
    });
</script>

