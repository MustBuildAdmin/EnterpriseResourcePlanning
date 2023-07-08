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
    <form method="POST" action="{{route('save_variation_scope_change')}}" enctype="multipart/form-data">
    @csrf
      <input type="hidden" name="project_id" id="project_id" value="{{$project}}">
      <div class="container">
        <div class="col-xs-12">
          <div class="form-group">
            <label for="InputLIst">{{__('Variations/Scope Change Authorization for the project of')}}:</label>
            <span>{{$project_name->project_name}}</span>
          </div>
        </div>
        <hr style="border: 1px solid black;">
        <div class="col-xs-12">
          <h3 style="text-align: center;">{{__('Variations/Scope Change Authorization')}}</h3>
        </div>
        <div class="row">
          <div class="col-6 mb-3">
            <div class="form-group">
              <label for="Input">{{__('Issued By')}}<span style='color:red;'>*</span></label>
              <input type="text" name="issued_by" class="form-control" placeholder="{{__('Issued By')}}" required>
            </div>
          </div>
          <div class="col-6 mb-3">
            <div class="form-group">
              <label for="Input">{{__('Issued Date')}} <span style='color:red;'>*</span></label>
              <input type="date" name="issued_date"  max="{{ date('Y-m-d') }}"
               class="form-control" placeholder="Text input"  required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6 mb-3">
            <div class="form-group">
              <label class="form-group">{{__('VO/SCA Reference')}} <span style='color:red;'>*</span></label>
              <textarea name="sca_reference" class="form-control"
               required placeholder="{{__('VO/SCA Reference')}}"></textarea>
            </div>
          </div>
          <div class="col-6 mb-3">
            <div class="form-group">
              <label class="form-group">{{__('VO Description')}} </label>
              <textarea name="vo_reference" class="form-control" placeholder="{{__('VO Description')}}"></textarea>
            </div>
          </div>
        </div>
        <div class="col-xs-12">
          <h4 class="text-center">{{__('Initiator')}}:</h4>
          <div class="row">
            <div class="col-6 mb-3">
              <div class="form-group">
                <label for="Input">{{__('Referene')}}</label>
                <input type="text" name="reference" class="form-control" placeholder="{{__('Referene')}}">
              </div>
            </div>
            <div class="col-6 mb-3">
              <div class="form-group">
                <label for="Input">{{__('Date')}}</label>
                <input name="vo_date" max="{{ date('Y-m-d') }}" type="date"
                 class="form-control" placeholder="Text input">
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
                <input  pattern="[^0-9]*" name="claimed_omission_cost"
                 placeholder="{{__('Omission Cost')}}" type="text" class="form-control claimed_omission_cost" >
              </div>
            </div>
            <div class="col-md-4">
              <label for="Input">{{__('Addition Cost')}}</label>
              <input name="claimed_addition_cost" placeholder="{{__('Addition Cost')}}"
               type="text" class="form-control claimed_addition_cost" >
            </div>
            <div class="col-md-4">
              <label for="Input">{{__('Net Amount')}}</label>
              <input name="" placeholder="{{__('Net Amount')}}" type="text" class="form-control claimed_net" disabled>
              <input name="claimed_net_amount" placeholder="{{__('Net Amount')}}"
               type="hidden" class="form-control claimed_net_amount" >
            </div>
          </div>
        </div>
        <div class="col-xs-12">
          <h4 class="text-center">{{__('Variation/SCA Approved Amount by Consultant')}}</h4>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="Input">{{__('Omission Cost')}}</label>
                <input name="approved_omission_cost" placeholder="{{__('Omission Cost')}}"
                 type="text" class="form-control approved_omission_cost" >
              </div>
            </div>
            <div class="col-md-4">
              <label for="Input">{{__('Addition Cost')}}</label>
              <input name="approved_addition_cost" placeholder="{{__('Addition Cost')}}"
               type="text" class="form-control approved_addition_cost">
            </div>
            <div class="col-md-4">
              <label for="Input">{{__('Net Amount')}}</label>
              <input name="" placeholder="{{__('Net Amount')}}" type="text" class="form-control approved_net" disabled>
              <input name="approved_net_cost" placeholder="{{__('Net Amount')}}"
               type="hidden" class="form-control approved_net_cost" >
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5">
            <label class="form-group">{{__('Impact/Lead Time')}}</label>
            <div class="form-group">
              <input name="impact_time" type="text" class="form-control impact_time"
               placeholder="{{__('Impact/Lead Time')}}" >
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
              <input name="granted_eot" type="text" class="form-control granted_eot"
               placeholder="{{__('Granted EOT(in days)')}}">
            </div>
          </div>
          <div class="col-md-1">
            <label class="form-group"></label>
            <div class="form-group mt-2">
              <input name="" placeholder="" value="{{__('Days')}}" type="text" class="form-control disabled" disabled>
            </div>
          </div>
        </div>
        <div class="col-xs-12">
          <label class="form-group">{{__('Remarks')}}</label>
          <div class="form-group">
            <textarea name="remarks" class="form-control" placeholder="{{__('Remarks')}}"></textarea>
          </div>
        </div>
        <div class="col-xs-6">
          <div class="form-group">
            <label for="InputATTACHMENTS:">{{__('Attachments')}}</label>
            <input type="file" name="attachment_file" class="form-control document_setup" placeholder="Text input"  accept="image/*, .png, .jpeg, .jpg , .pdf, .gif">
            <span class="show_document_error" style="color:red;"></span>
          </div>
        </div>
      </div>
      <div class="col-xs-9"></div>
      <div class="modal-footer">
        <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" id="vo_change" value="{{__('Create')}}" class="btn btn-primary add">
      </div>
    </form>
  </div>
</div>

<script src="{{ asset('assets/js/jquery.alphanum.js') }}"></script>
<script>

$(document).ready(function() {
    $(document).on('submit', 'form', function() {
        $('#vo_change').attr('disabled', 'disabled');
    });

});


$(function() {

$(".claimed_omission_cost,.claimed_addition_cost").on("keydown keyup", sum);

  function sum() {
    let omission_cost = -Math.abs($(".claimed_omission_cost").val());
    omission_cost = isNaN(omission_cost) ? '' : omission_cost;
    $(".claimed_omission_cost").val(omission_cost);
    $(".claimed_net").val(Number(omission_cost) + Number($(".claimed_addition_cost").val()));
    $(".claimed_net_amount").val(Number(omission_cost) + Number($(".claimed_addition_cost").val()));

  }

});

$(function() {

$(".approved_omission_cost,.approved_addition_cost").on("keydown keyup", sum);

  function sum() {
    let approved_omission = -Math.abs($(".approved_omission_cost").val());
    approved_omission = isNaN(approved_omission) ? '' : approved_omission;
    $(".approved_omission_cost").val(approved_omission);
    $(".approved_net").val(Number(approved_omission) + Number($(".approved_addition_cost").val()));
    $(".approved_net_cost").val(Number(approved_omission) + Number($(".approved_addition_cost").val()));

  }

});




$('.claimed_omission_cost,.claimed_net_amount,.approved_omission_cost,.approved_net_cost').alphanum({
			allow              : '(,),-',    // Allow extra characters
			allowUpper         : false,  // Allow upper case characters
			allowLower         : false,  // Allow lower case characters
			forceUpper         : false, // Convert lower case characters to upper case
			forceLower         : false, // Convert upper case characters to lower case
			allowLatin         : false,
});

$('.claimed_addition_cost,.approved_addition_cost').alphanum({
			allow              : '',    // Allow extra characters
			allowUpper         : false,  // Allow upper case characters
			allowLower         : false,  // Allow lower case characters
			forceUpper         : false, // Convert lower case characters to upper case
			forceLower         : false, // Convert upper case characters to lower case
			allowLatin         : false,
});


</script>
