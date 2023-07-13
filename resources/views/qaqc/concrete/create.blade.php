<style>
  .form-check {
    margin: 8px 12px !important;
  }
  .disable{
    background-color: unset !important;
    color:black !important;
    font-weight:bold;
  }
</style>
<div class="modal-body">
  <div class="row">
    <div class="container">
      <h3 style="text-align: center; font-weight: 500">
        {{__('MONTHLY REPORT BY PROJECT ENGINEERS / SITE ENGINEERS')}}
      </h3>
     
      <form class="" action="{{ route('concrete.save_concrete_pouring') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <input type="hidden" name="project_id" id="project_id" value="{{$project}}">
              <label for="InputDate">{{__('Project')}}:</label>
              <b>{{$projectname->project_name}}</b>
            </div>
          </div>
          <div class="col-6 mb-3">
            <div class="form-group">
              <label for="InputDate">{{__('Month and Year')}} <span style='color:red;'>*</span></label>
              <input name="month_year" value="" required type="month"
               id="month_year" class="form-control" placeholder="Enter your Month and Year" />
            </div>
          </div>
          <hr style="border: 1px solid black" />
        </div>
        <div class="row">
          <div class="col-6 mb-3">
            <div class="form-group">
              <label for="InputDate">{{__('Date of Casting')}} <span style='color:red;'>*</span></label>
              <input name="date_of_casting" value="" id="date_of_casting"
               required type="date" class="form-control" placeholder="Enter your Date of Casting" />
            </div>
          </div>
          <div class="col-6 mb-3">
            <div class="form-group">
              <label for="InputElement">{{__('Element of Casting')}} <span style='color:red;'>*</span></label>
              <input name="element_of_casting" value="" required type="text"
               id="element_of_casting" class="form-control" placeholder="Enter your Element of Casting " />
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="form-group">
              <label for="InputGrade">{{__('Grade of Concrete')}} <span style='color:red;'>*</span></label>
              <select name="grade_of_concrete" class="form-control" id="grade_of_concrete" required>
                <option value="">{{__('Select Grade of Concrete')}}</option>
                <option value="M10">M10</option>
                <option value="M15">M15</option>
                <option value="M20">M20</option>
                <option value="M25">M25</option>
                <option value="M30">M30</option>
                <option value="M35">M35</option>
                <option value="M40">M40</option>
                <option value="M45">M45</option>
                <option value="M50">M50</option>
              </select>
            </div>
          </div>
          <label style="text-align: center; font-weight: 700">{{__('Poured')}}</label>
          <div class="col-6 mb-3">
            <div class="form-group">
              <label for="InputGrade">{{__('Theoretical')}} <span style='color:red;'>*</span></label>
              <input name="theoretical" value="" required type="date"
               id="theoretical" class="form-control" placeholder="Enter your Theoretical Date" />
            </div>
          </div>
          <div class="col-6 mb-3">
            <div class="form-group">
              <label for="InputGrade">{{__('Actual')}} <span style='color:red;'>*</span></label>
              <input name="actual" value="" required type="date"
               class="form-control" id="actual" name="Enter your Actual Date" />
            </div>
          </div>
          <div class="col-6 mb-3">
            <div class="form-group">
              <label for="Inputdays">{{__('7 days Testing Falls on')}}</label>
              <input name="testing_fall_on" value=""  type="date" class="form-control" id="testing_fall_on" disabled />
              <input name="testing_fall"  type="hidden" class="form-control" id="testing_fall"  />
            </div>
          </div>
         
          <div class="col-5 mb-3">
            <div class="form-group">
              <label for="InputAverage">{{__('Total Result (Average)')}}</label>
              <input name="" value=""  type="text" id="total_result"
               class="form-control total_result" placeholder="{{__('Total Result (Average)')}}" />
              <input name="total_result" value=""  type="hidden"
               id="total_result_back" class="form-control total_result"
                placeholder="{{__('Total Result (Average)')}}" />
            </div>
          </div>
          <div class="col-1 mb-3">
            <div class="form-group">
              <label for="Inputdays"></label>
              <input disabled id=""  type="text"class="form-control disable" placeholder="{{__('N/mm2')}}" />
            </div>
          </div>
          <div class="col-6 mb-3">
            <div class="form-group">
              <label for="Inputdays">{{__('28 days Testing Falls on')}}</label>
              <input name="days_testing_falls_on" value=""  type="date"
               class="form-control" id="days_testing_falls_on" disabled/>
              <input name="days_testing_falls"  type="hidden" class="form-control" id="days_testing_falls"  />
            </div>
          </div>
          <div class="col-5 mb-3">
            <div class="form-group">
              <label for="Inputdays">{{__('28 days Result (Average)')}}</label>
              <input name=""  value=""  type="text"  id="days_testing_result"
               class="form-control days_testing_result" placeholder="Enter your 28 days Result (Average)" />
              <input name="days_testing_result"  value=""
               id="days_testing_result_back"  type="hidden"
               class="form-control days_testing_result" placeholder="Enter your 28 days Result (Average)" />
            </div>
          </div>
          <div class="col-1 mb-3">
            <div class="form-group">
              <label for="Inputdays"></label>
              <input disabled id=""  type="text"class="form-control disable" placeholder="{{__('N/mm2')}}" />
            </div>
          </div>
          <div class="col-md-12 mb-3">
            <div class="form-group">
              <label for="InputRemarks">{{__('Remarks')}}</label>
              <textarea name="remarks"  id="remarks" type="text"
              class="form-control" placeholder="Enter your Remarks" ></textarea>
            </div>
          </div>
          <div class="col-md-12 mb-3">
            <label for="InputRemarks">{{__('Attachment')}}</label>
            <input name="file_name"  type="file" id="file_name"
             class="form-control document_setup" accept="image/*, .png, .jpeg, .jpg ,.pdf,.gif"/>
            <span class="show_document_error" style="color:red;"></span>
          </div>
        </div>
        <div class="modal-footer">
          <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
          <input type="submit" id="create_concrete" value="{{__('Create')}}" class="btn  btn-primary">
        </div>
      </form>
    </div>
  </div>
</div>

<script>

  $(document).ready(function() {
    $(document).on('submit', 'form', function() {
          $('#create_concrete').attr('disabled', 'disabled');
    });
    $("#total_result").attr("disabled", "disabled");
    $("#days_testing_result").attr("disabled", "disabled");
  });

  $(document).on("change", '#actual', function() {

    var selectedDate = this.value;
    var seventhDate = moment(selectedDate).add(7, "d").format("YYYY-MM-DD");
    var seventh = moment(selectedDate).add(7, "d").format("DD-MM-YYYY");
    var twentyEigthData = moment(selectedDate).add(28, "d").format("YYYY-MM-DD");
    var twentyEigth = moment(selectedDate).add(28, "d").format("DD-MM-YYYY");

    $("#testing_fall_on").val(seventhDate);
    $("#testing_fall").val(seventhDate);
    $("#days_testing_falls_on").val(twentyEigthData);
    $("#days_testing_falls").val(twentyEigthData);


    var dt = new Date();

    year  = dt.getFullYear();
    month = (dt.getMonth() + 1).toString().padStart(2, "0");
    day   = dt.getDate().toString().padStart(2, "0");

    var currentDate= day + '-' + month + '-' + year;

    if(currentDate===seventh){
        $("#total_result").removeAttr("disabled");
    }else{
        $("#total_result").attr("disabled", "disabled");
    }

    if(currentDate===twentyEigth){
      $("#days_testing_result").removeAttr("disabled");
    }else{
      $("#days_testing_result").attr("disabled", "disabled");
    }

  });

  $(document).on("keyup", '#days_testing_result', function() {
    var copy_val= $('#days_testing_result').val();
    $('#days_testing_result_back').val(copy_val);
  });

  $(document).on("keyup", '#total_result', function() {
    var copy_value= $('#total_result').val();
    $('#total_result_back').val(copy_value);
  });

  $(document).on("change", '#month_year', function() {

  var month=$('#month_year').val();
  // $('#date_of_casting').val("");
  var datee = new Date(month+'-01');

  var get_month = month.slice(5);
  var get_year  = month.slice(0,-3);

  var date = new Date(), y = datee.getFullYear(), m = datee.getMonth();
  var firstDay = new Date(y, m, 1);
  var lastDay = new Date(y, m + 1, 0);
  var firstDayvalue=moment(firstDay).format("YYYY-MM-DD");
  var lastDayvalue=moment(lastDay).format("YYYY-MM-DD");
  $('#date_of_casting').attr("min",firstDayvalue);
  $('#date_of_casting').attr("max",lastDayvalue);
  $('#date_of_casting').val(firstDayvalue);

  });

  $(document).on('change', '.document_setup', function(){
      var fileExtension = ['jpeg', 'jpg', 'png', 'pdf','gif'];
      if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
          $(".show_document_file").hide();
          $(".show_document_error").html("Upload only pdf, jpeg, jpg, png, gif");
          $("#create_concrete").prop('disabled',true);
          return false;
      } else{
          $(".show_document_file").show();
          $(".show_document_error").hide();
          $("#create_concrete").prop('disabled',false);
          return true;
      }

  });

</script>
<script src="{{ asset('assets/js/jquery.alphanum.js') }}"></script>
<script>
$('.total_result,.days_testing_result').alphanum({
			allow              : '',    // Allow extra characters
			allowUpper         : false,  // Allow upper case characters
			allowLower         : false,  // Allow lower case characters
			forceUpper         : false, // Convert lower case characters to upper case
			forceLower         : false, // Convert upper case characters to lower case
			allowLatin         : false,
});
</script>

