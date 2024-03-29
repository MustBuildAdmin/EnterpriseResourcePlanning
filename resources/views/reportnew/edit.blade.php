<style>
    .form-check {
      margin: 8px 12px !important;
    }
  </style>
  <div class="modal-body">
    <div class="row">
      <div class="container">
        <h3 style="text-align: center; font-weight: 800; color: blue"> Concrete Pouring Record ( Cube Register) </h3>
        <h3 style="text-align: center; font-weight: 500"> MONTHLY REPORT BY PROJECT ENGINEERS / SITE ENGINEERS </h3>
        <form class="" action="{{ route('diary.update_concrete_pouring') }}" enctype="multipart/form-data" method="POST">
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
                <label for="InputDate">Project:</label> {{$project_name->project_name}}
              </div>
            </div>
            <div class="col-6 mb-3">
              <div class="form-group">
                <label for="InputDate">Month and Year :</label>
                <input name="month_year" value="@if($id!='' && $dairy_data->month_year!=''){{$dairy_data->month_year}}@endif" required type="month" id="month_year" class="form-control" placeholder="Enter your Month and Year" />
              </div>
            </div>
            <hr style="border: 1px solid black" />
          </div>
          <div class="row">
            <div class="col-6 mb-3">
              <div class="form-group">
                <label for="InputDate">Date of Casting:</label>
                <input name="date_of_casting" value="@if($id!='' && $dairy_data->date_of_casting!=''){{$dairy_data->date_of_casting}}@endif" id="date_of_casting" required type="date" class="form-control" placeholder="Enter your Date of Casting" />
              </div>
            </div>
            <div class="col-6 mb-3">
              <div class="form-group">
                <label for="InputElement">Element of Casting:</label>
                <input name="element_of_casting" value="@if($id!='' && $dairy_data->element_of_casting!=''){{$dairy_data->element_of_casting}}@endif" required type="text" id="element_of_casting" class="form-control" placeholder="Enter your Element of Casting " />
              </div>
            </div>
            <div class="col-md-12 mb-3">
              <div class="form-group">
                <label for="InputGrade">Grade of Concrete:</label>
                <input name="grade_of_concrete" value="@if($id!='' && $dairy_data->grade_of_concrete!=''){{$dairy_data->grade_of_concrete}}@endif" required type="text" id="grade_of_concrete" class="form-control" placeholder="Enter your Grade of Concrete" />
              </div>
            </div>
            <label style="text-align: center; font-weight: 700">Poured</label>
            <div class="col-6 mb-3">
              <div class="form-group">
                <label for="InputGrade">Theoretical:</label>
                <input name="theoretical" value="@if($id!='' && $dairy_data->theoretical!=''){{$dairy_data->theoretical}}@endif" required type="date" id="theoretical" class="form-control" placeholder="Enter your Theoretical Date" />
              </div>
            </div>
            <div class="col-6 mb-3">
              <div class="form-group">
                <label for="InputGrade">Actual:</label>
                <input name="actual" value="@if($id!='' && $dairy_data->actual!=''){{$dairy_data->actual}}@endif" required type="date" class="form-control" id="actual" name="Enter your Actual Date" />
              </div>
            </div>
            <div class="col-6 mb-3">
              <div class="form-group">
                <label for="Inputdays">7 days Testing Falls on:</label>
                <input name="testing_fall_on" value="@if($id!='' && $dairy_data->testing_fall!=''){{$dairy_data->testing_fall}}@endif" required type="date" class="form-control" id="testing_fall_on" disabled />
                <input name="testing_fall"  type="hidden" class="form-control" id="testing_fall"  />
              </div>
            </div>
            <div class="col-6 mb-3">
              <div class="form-group">
                <label for="InputAverage">Total Result (Average):</label>
                <input name="total_result" value="@if($id!='' && $dairy_data->total_result!=''){{$dairy_data->total_result}}@endif" required type="text" id="total_result" class="form-control" placeholder="Enter your Total Result (Average)" />
              </div>
            </div>
            <div class="col-6 mb-3">
              <div class="form-group">
                <label for="Inputdays">28 days Testing Falls on:</label>
                <input name="days_testing_falls_on" value="@if($id!='' && $dairy_data->days_testing_falls!=''){{$dairy_data->days_testing_falls}}@endif" required type="date" class="form-control" id="days_testing_falls_on" disabled />
                <input name="days_testing_falls"  type="hidden" class="form-control" id="days_testing_falls"  />
              </div>
            </div>
            <div class="col-6 mb-3">
              <div class="form-group">
                <label for="Inputdays">28 days Result (Average):</label>
                <input name="days_testing_result" value="@if($id!='' && $dairy_data->days_testing_result!=''){{$dairy_data->days_testing_result}}@endif" required type="text" id="days_testing_result" class="form-control" placeholder="Enter your 28 days Result (Average)" />
              </div>
            </div>
            <div class="col-md-12 mb-3">
              <div class="form-group">
                <label for="InputRemarks">Remarks:</label>
                <textarea name="remarks"  id="remarks" type="text" class="form-control" placeholder="Enter your Remarks">@if($id!='' && $dairy_data->remarks!=''){{$dairy_data->remarks}}@endif</textarea>
              </div>
            </div>
            <div class="col-md-12 mb-3">
              <input name="file_name"  type="file" id="file_name" class="form-control" name="file" />
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
  
  $("#testing_fall_on").val(seventhDate);
  $("#testing_fall").val(seventhDate);
  $("#days_testing_falls_on").val(twentyEigthData);
  $("#days_testing_falls").val(twentyEigthData);
  $("#total_result").val(seventh);
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
  
  