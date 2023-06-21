<style>
  .form-check {
    margin: 8px 12px !important;
  }
</style>
<div class="modal-body">
  <div class="row">
    <div class="container">
      <h3 style="text-align: center; font-weight: 500">{{__('MONTHLY REPORT BY PROJECT ENGINEERS / SITE ENGINEERS')}} </h3>
      <form class="" action="{{ route('concrete.update_concrete_pouring') }}" enctype="multipart/form-data" method="POST">
        @csrf

        @if(isset($get_dairy_data->diary_data))
        @if($get_dairy_data->diary_data!=null)
            @php $data=$get_dairy_data->diary_data;  @endphp
        @else
            @php $data=''; @endphp
        @endif
        @else
            @php $data=''; @endphp
        @endif

        @if($data != null)
            @php $dairy_data = json_decode($data); @endphp
        @else
            @php $dairy_data = array();  @endphp
        @endif
       
    
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <input type="hidden" name="project_id" id="project_id" value="{{$project}}">
              <input type="hidden" name="edit_id" id="edit_id" value="{{$id}}">
              <label for="InputDate">{{__('Project')}}:</label> {{$project_name->project_name}}
            </div>
          </div>
          <div class="col-6 mb-3">
            <div class="form-group">
              <label for="InputDate">{{__('Month and Year')}} <span style='color:red;'>*</span></label>
              <input name="month_year" value="@if($id!='' && $dairy_data->month_year!=''){{$dairy_data->month_year}}@endif" required type="month" id="month_year" class="form-control" placeholder="Enter your Month and Year" />
            </div>
          </div>
          <hr style="border: 1px solid black" />
        </div>
        <div class="row">
          <div class="col-6 mb-3">
            <div class="form-group">
              <label for="InputDate">{{__('Date of Casting')}} <span style='color:red;'>*</span></label>
              <select name="grade_of_concrete" class="form-control" id="grade_of_concrete">
                <option value="">{{__('Select Date of Casting')}}</option>
                <option value="M10" @if( 'M10'==$dairy_data->date_of_casting){ selected }@endif>M10</option>
                <option value="M15" @if( 'M15'==$dairy_data->date_of_casting){ selected }@endif>M15</option>
                <option value="M20" @if( 'M20'==$dairy_data->date_of_casting){ selected }@endif>M20</option>
                <option value="M25" @if( 'M25'==$dairy_data->date_of_casting){ selected }@endif>M25</option>
                <option value="M30" @if( 'M30'==$dairy_data->date_of_casting){ selected }@endif>M30</option>
                <option value="M35" @if( 'M35'==$dairy_data->date_of_casting){ selected }@endif>M35</option>
                <option value="M40" @if( 'M40'==$dairy_data->date_of_casting){ selected }@endif>M40</option>
                <option value="M45" @if( 'M45'==$dairy_data->date_of_casting){ selected }@endif>M45</option>
                <option value="M50" @if( 'M50'==$dairy_data->date_of_casting){ selected }@endif>M50</option>
              </select>
              </div>
          </div>
          <div class="col-6 mb-3">
            <div class="form-group">
              <label for="InputElement">{{__('Element of Casting')}} <span style='color:red;'>*</span></label>
              <input name="element_of_casting" value="@if($id!='' && $dairy_data->element_of_casting!=''){{$dairy_data->element_of_casting}}@endif" required type="text" id="element_of_casting" class="form-control" placeholder="Enter your Element of Casting " />
            </div>
          </div>
          <div class="col-md-12 mb-3">
            <div class="form-group">
              <label for="InputGrade">{{__('Grade of Concrete')}} <span style='color:red;'>*</span></label>
              <input name="grade_of_concrete" value="@if($id!='' && $dairy_data->grade_of_concrete!=''){{$dairy_data->grade_of_concrete}}@endif" required type="text" id="grade_of_concrete" class="form-control" placeholder="Enter your Grade of Concrete" />
            </div>
          </div>
          <label style="text-align: center; font-weight: 700">{{__('Poured')}}</label>
          <div class="col-6 mb-3">
            <div class="form-group">
              <label for="InputGrade">{{__('Theoretical')}} <span style='color:red;'>*</span></label>
              <input name="theoretical" value="@if($id!='' && $dairy_data->theoretical!=''){{$dairy_data->theoretical}}@endif" required type="date" id="theoretical" class="form-control" placeholder="Enter your Theoretical Date" />
            </div>
          </div>
          <div class="col-6 mb-3">
            <div class="form-group">
              <label for="InputGrade">{{__('Actual')}} <span style='color:red;'>*</span></label>
              <input name="actual" value="@if($id!='' && $dairy_data->actual!=''){{$dairy_data->actual}}@endif" required type="date" class="form-control" id="actual" name="Enter your Actual Date" />
            </div>
          </div>
          <div class="col-6 mb-3">
            <div class="form-group">
              <label for="Inputdays">{{__('7 days Testing Falls on')}}</label>
              <input name="testing_fall_on" value="@if($id!='' && $dairy_data->testing_fall!=''){{$dairy_data->testing_fall}}@endif"  type="date" class="form-control" id="testing_fall_on" disabled />
              <input name="testing_fall"  type="hidden" class="form-control" id="testing_fall"  value="@if($id!='' && $dairy_data->testing_fall!=''){{$dairy_data->testing_fall}}@endif" />
            </div>
          </div>
          <div class="col-6 mb-3">
            <div class="form-group">
              <label for="InputAverage">{{__('Total Result (Average)')}}</label>
              <input name="total_result" value="@if($id!='' && $dairy_data->total_result!=''){{$dairy_data->total_result}}@endif"  type="text" id="total_result" class="form-control" placeholder="Enter your Total Result (Average)" />
            </div>
          </div>
          <div class="col-6 mb-3">
            <div class="form-group">
              <label for="Inputdays">{{__('28 days Testing Falls on')}}</label>
              <input name="days_testing_falls_on" value="@if($id!='' && $dairy_data->days_testing_falls!=''){{$dairy_data->days_testing_falls}}@endif"  type="date" class="form-control" id="days_testing_falls_on" disabled />
              <input name="days_testing_falls"  type="hidden" class="form-control" id="days_testing_falls"  value="@if($id!='' && $dairy_data->days_testing_falls!=''){{$dairy_data->days_testing_falls}}@endif"  />
            </div>
          </div>
          <div class="col-6 mb-3">
            <div class="form-group">
              <label for="Inputdays">{{__('28 days Result (Average)')}}</label>
              <input name="days_testing_result" value="@if($id!='' && $dairy_data->days_testing_result!=''){{$dairy_data->days_testing_result}}@endif"  type="text" id="days_testing_result" class="form-control" placeholder="Enter your 28 days Result (Average)" />
            </div>
          </div>
          <div class="col-md-12 mb-3">
            <div class="form-group">
              <label for="InputRemarks">{{__('Remarks')}}</label>
              <textarea name="remarks"  id="remarks" type="text" class="form-control" placeholder="Enter your Remarks">@if($id!='' && $dairy_data->remarks!=''){{$dairy_data->remarks}}@endif</textarea>
            </div>
          </div>
          <div class="col-md-12 mb-3">
            <label for="InputRemarks">{{__('Attachment')}}</label>
            <input name="file_name"  type="file" id="file_name" class="form-control"  />
            <span>{{$get_dairy_data->file_name ?? ''}}</span>
      
          </div>
        </div>
        <div class="modal-footer">
          <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
          <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
        </div>
      </form>
    </div>
  </div>
</div>

<script>
$(document).on("change", '#actual', function() {

var selectedDate = this.value;
var seventhDate = moment(selectedDate).add(7, "d").format("YYYY-MM-DD");
var seventh = moment(selectedDate).add(7, "d").format("DD-MM-YYYY");
var twentyEigthData = moment(selectedDate).add(28, "d").format("YYYY-MM-DD");
var twenty = moment(selectedDate).add(28, "d").format("DD-MM-YYYY");

$("#testing_fall_on").val(seventhDate);
$("#testing_fall").val(seventhDate);
$("#days_testing_falls_on").val(twentyEigthData);
$("#days_testing_falls").val(twentyEigthData);
$("#total_result").val(seventh);
var dt = new Date();

year  = dt.getFullYear();
month = (dt.getMonth() + 1).toString().padStart(2, "0");
day   = dt.getDate().toString().padStart(2, "0");

var currentDate= day + '-' + month + '-' + year;

if(currentDate===seventh){
  $("#testing_fall_on").prop('required',true);
}else{
  $("#testing_fall_on").prop('required',false);
}

if(currentDate===twenty){
  $("#days_testing_falls_on").prop('required',true);
}else{
  $("#days_testing_falls_on").prop('required',false);
}

if(currentDate===twenty){
  $("#total_result").prop('required',true);
}else{
  $("#total_result").prop('required',false);
}

if(currentDate===twenty){
  $("#days_testing_result").prop('required',true);
}else{
  $("#days_testing_result").prop('required',false);
}

});

$("#concreteFile").dropzone({
url: "/file/post"
});

$(".chosen-select").chosen({
    disable_search_threshold: 10,
    no_results_text: "Oops, nothing found!",
    width: "95%"
});
$('#employee').trigger("chosen:updated");
</script>

