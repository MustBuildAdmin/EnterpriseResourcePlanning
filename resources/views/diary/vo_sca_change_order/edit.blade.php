<style>
  .mt-2 {
    margin-top: 0.8rem !important;
  }
  .disabled{
    background-color: #fff !important;
  }
  </style>
<div class="modal-body">
  <div class="row">
    <form method="POST" action="{{route('update_variation_scope_change')}}" enctype="multipart/form-data"> 
      @csrf 
      @if(isset($get_dairy_data->data)) 
        @if($get_dairy_data->data!=null) 
          @php $data=$get_dairy_data->data; @endphp 
        @else 
          @php $data=''; @endphp @endif 
      @else 
          @php $data=''; @endphp @endif 
        @if($data != null) 
          @php $dairy_data = json_decode($data); @endphp 
        @else
          @php $dairy_data = array(); @endphp 
      @endif 
      <input type="hidden" name="id" id="id" value="{{$id}}">
      <input type="hidden" name="project_id" id="project_id" value="{{$project}}">
      <div class="container">
        <div class="col-xs-12">
          <div class="form-group">
            <label for="InputLIst">{{__('VARIATIONS/SCOPE CHANGE AUTHORIZATION for the project of')}}:</label>
            <span>{{$project_name->project_name}}</span>
          </div>
        </div>
        <hr style="border: 1px solid black;">
        <div class="col-xs-12">
          <h3 style="text-align: center;">{{__('VARIATIONS/SCOPE CHANGE AUTHORIZATION')}}</h3>
        </div>
        <div class="row">
          <div class="col-6 mb-3">
            <div class="form-group">
              <label for="Input">{{__('Issued By')}} <span style='color:red;'>*</span></label>
              <input type="text" value="@if($id!='' && $dairy_data->issued_by!=''){{$dairy_data->issued_by}}@endif" name="issued_by" class="form-control" placeholder="{{__('Issued By')}}" required>
            </div>
          </div>
          <div class="col-6 mb-3">
            <div class="form-group">
              <label for="Input">{{__('Issued Date')}} <span style='color:red;'>*</span></label>
              <input type="date" value="@if($id!='' && $dairy_data->issued_date!=''){{$dairy_data->issued_date}}@endif" name="issued_date" class="form-control" placeholder="Text input" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6 mb-3">
            <div class="form-group">
              <label class="form-group">{{__('VO/SCA Reference')}} <span style='color:red;'>*</span></label>
              <textarea name="sca_reference" class="form-control" placeholder="{{__('VO/SCA Reference')}}" required>@if($id!='' && $dairy_data->sca_reference!=''){{$dairy_data->sca_reference}}@endif</textarea>
            </div>
          </div>
          <div class="col-6 mb-3">
            <div class="form-group">
              <label class="form-group">{{__('VO Description')}}</label>
              <textarea name="vo_reference" class="form-control" placeholder="{{__('VO Description')}}">@if($id!='' && $dairy_data->vo_reference!=''){{$dairy_data->vo_reference}}@endif</textarea>
            </div>
          </div>
        </div>
        <div class="col-xs-12">
          <h4 class="text-center">{{__('Initiator')}}</h4>
          <div class="row">
            <div class="col-6 mb-3">
              <div class="form-group">
                <label for="Input">{{__('Reference')}} <span style='color:red;'>*</span></label>
                <input type="text" value="@if($id!='' && $dairy_data->reference!=''){{$dairy_data->reference}}@endif" name="reference" class="form-control" placeholder="{{__('Reference')}}" required>
              </div>
            </div>
            <div class="col-6 mb-3">
              <div class="form-group">
                <label for="Input">{{__('Date')}} <span style='color:red;'>*</span></label>
                <input name="vo_date" value="@if($id!='' && $dairy_data->vo_date!=''){{$dairy_data->vo_date}}@endif" type="date" class="form-control" placeholder="Text input" required>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xs-12">
          <h4 class="text-center">{{__('Variation/SCA Claimed Amount More by Contractor')}}</h4>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="Input">{{__('Omission Cost')}}</label>
                <input name="claimed_omission_cost" placeholder="{{__('Omission Cost')}}" value="@if($id!='' && $dairy_data->claimed_omission_cost!=''){{$dairy_data->claimed_omission_cost}}@endif" type="text" class="form-control claimed_omission_cost" >
              </div>
            </div>
            <div class="col-md-4">
              <label for="Input">{{__('Addition Cost')}}</label>
              <input name="claimed_addition_cost" placeholder="{{__('Addition Cost')}}" value="@if($id!='' && $dairy_data->claimed_addition_cost!=''){{$dairy_data->claimed_addition_cost}}@endif" type="text" class="form-control claimed_addition_cost" >
            </div>
            <div class="col-md-4">
              <label for="Input">{{__('Net Amount')}}</label>
              <input name="claimed_net_amount" placeholder="{{__('Net Amount')}}" value="@if($id!='' && $dairy_data->claimed_net_amount!=''){{$dairy_data->claimed_net_amount}}@endif" type="text" class="form-control claimed_net_amount" >
            </div>
          </div>
        </div>
        <div class="col-xs-12">
          <h4 class="text-center">{{__('Variation/SCA Approved Amount by Consultant')}}</h4>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="Input">{{__('Omission Cost')}}</label>
                <input name="approved_omission_cost" placeholder="{{__('Omission Cost')}}"  value="@if($id!='' && $dairy_data->approved_omission_cost!=''){{$dairy_data->approved_omission_cost}}@endif" type="text" class="form-control approved_omission_cost" >
              </div>
            </div>
            <div class="col-md-4">
              <label for="Input">{{__('Addition Cost')}}</label>
              <input name="approved_addition_cost" placeholder="{{__('Addition Cost')}}" value="@if($id!='' && $dairy_data->approved_addition_cost!=''){{$dairy_data->approved_addition_cost}}@endif" type="text" class="form-control approved_addition_cost" >
            </div>
            <div class="col-md-4">
              <label for="Input">{{__('Net Amount')}}</label>
              <input name="approved_net_cost" placeholder="{{__('Net Amount')}}" value="@if($id!='' && $dairy_data->approved_net_cost!=''){{$dairy_data->approved_net_cost}}@endif" type="text" class="form-control approved_net_cost" >
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5">
            <label class="form-group">{{__('Impact/Lead Time')}}</label>
            <div class="form-group">
              <input name="impact_time" placeholder="{{__('Impact/Lead Time')}}" value="@if($id!='' && $dairy_data->impact_time!=''){{$dairy_data->impact_time}}@endif" type="text" class="form-control impact_time" >
            </div>
          </div>
          <div class="col-md-1">
            <label class="form-group"></label>
            <div class="form-group mt-2">
              <input name="" placeholder="" value="{{__('Days')}}" type="text" class="form-control disabled" disabled>
            </div>
          </div>
          <div class="col-md-5">
            <label class="form-group">{{__('Granted EOT(in days)')}}</label>
            <div class="form-group">
              <input name="granted_eot" value="@if($id!='' && $dairy_data->granted_eot!=''){{$dairy_data->granted_eot}}@endif" type="text" class="form-control impact_time" placeholder="{{__('Granted EOT(in days)')}}">
            </div>
          </div>
          <div class="col-md-1">
            <label class="form-group"></label>
            <div class="form-group mt-2">
              <input name="impact_time" placeholder="" value="{{__('Days')}}" type="text" class="form-control disabled" disabled>
            </div>
          </div>
        </div>
        <div class="col-xs-12">
          <label class="form-group">{{__('Remarks)')}}</label>
          <div class="form-group">
            <textarea name="remarks" class="form-control" placeholder="{{__('Remarks')}}">@if($id!='' && $dairy_data->remarks!=''){{$dairy_data->remarks}}@endif</textarea>
          </div>
        </div>
        <div class="col-xs-6">
          <div class="form-group">
            <label for="InputATTACHMENTS:">{{__('Attachments)')}}</label>
            <input type="file" name="attachment_file" class="form-control imgs" placeholder="Text input">
            <span>{{$get_dairy_data->attachment_file}}</span>
          </div>
        </div>
      </div>
      <div class="col-xs-9"></div>
      <div class="modal-footer">
        <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
      </div>
    </form>
  </div>
</div>