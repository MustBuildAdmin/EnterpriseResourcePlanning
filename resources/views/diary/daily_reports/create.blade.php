@include('new_layouts.header')
@include('construction_project.side-menu')
<style>
  div#choices_multiple1_chosen {
      width: 100% !important;
  }
</style>
<h2>Contractor's daily construction report</h2>
<div class="maindailyreport">
  <div class="row">
    <div class="row row-cards">
      <div class="col-12">
        <form class="card" action="{{ route('save_site_reports') }}" enctype="multipart/form-data" method="POST"> @csrf <div class="card-body">
            <div class="row row-cards">
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Daily Report No</label>
                  <label class="form-label form-control disabledmode">Daily Report No</label>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">Contractor Name</label>
                  <input type="text" class="form-control" name="contractor_name" placeholder="Username" value="">
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">Date</label>
                  <input type="date" name="con_date" class="form-control" id="con_date" placeholder="Email">
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Project Name</label>
                  <label class="form-label form-control disabledmode">construction report</label>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">weather</label>
                  <div class="dropdownrpt">
                    <select name="weather[]" id='choices-multiple1' class='chosen-select' multiple>
                      <option value="" disabled>Select your option</option>
                      <option value="Clear">Clear</option>
                      <option value="Dusty">Dusty</option>
                      <option value="Muddy">Muddy</option>
                      <option value="Windy">Windy</option>
                      <option value="Cool">Cool</option>
                      <option value="Fog">Fog</option>
                      <option value="Warm">Warm</option>
                      <option value="Rain">Rain</option>
                      <option value="Cold">Cold</option>
                      <option value="Hot">Hot</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">Site conditions</label>
                  <div class="dropdownrpt">
                    <select name="site_conditions[]" id='choices-multiple1' class='chosen-select'  multiple>
                      <option value="" disabled>Select your option</option>
                      <option value="Clear">Clear</option>
                      <option value="Dusty">Dusty</option>
                      <option value="Muddy">Muddy</option>
                      <option value="Windy">Windy</option>
                      <option value="Cool">Cool</option>
                      <option value="Fog">Fog</option>
                      <option value="Warm">Warm</option>
                      <option value="Rain">Rain</option>
                      <option value="Cold">Cold</option>
                      <option value="Hot">Hot</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Day</label>
                  <input type="text" class="form-control con_day" disabled>
                  <input type="hidden"  class="con_day" name="con_day" >
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="mb-3">
                  <label class="form-label">Temparture (Maximum)</label>
                  <input name="temperature" type="text" class="form-control" placeholder="Maximum" value="">
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="mb-3">
                  <label class="form-label">Minimum</label>
                  <input name="min_input" type="text" class="form-control" placeholder="Minimum">
                </div>
              </div>
              <div class="col-sm-6 col-md-2">
                <div class="mb-3">
                  <label class="form-label">&nbsp;</label>
                  <select name="degree" class="form-control addbutton" >
                    <option value="" disabled selected>Select your option</option>
                    <option value="Fahrenheit">Fahrenheit</option>
                    <option value="Celsius">Celsius</option>
                  </select>
                </div>
              </div>
              <div class="card-footer text-end"> &nbsp; </div>
              <div class="col-md-12 l-section">
                <h2>Contractors Personnel</h2>
                <br />
                <table class="table tableadd form" id="dynamicTable">
                  <thead>
                    <tr>
                    <tr>
                      <th>Position</th>
                      <th>No Of Person per Position</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr id="addRow">
                      <td class="col-xs-3">
                        <input name="first_position[]" class="form-control first_position_0" type="text" placeholder="Enter Position Name" />
                      </td>
                      <td class="col-xs-3">
                        <input name="first_person[]"  class="form-control first_person_0" type="text" placeholder="Enter No Of Person Per Position" />
                      </td>
                      <td class="col-xs-5">
                        <select class="form-control first_option_0"  name="first_option[]">
                          <option value="" disabled selected>Select your option</option>
                          <option value="Direct Manpower">Direct Manpower</option>
                          <option value="InDirect Manpower">InDirect Manpower</option>
                        </select>
                      </td>
                      <td class="col-xs-1 text-center">
                        <!-- <span class="c-link"><i class="bttoncreate fa fa-edit  js-toggleForm"></i></span> -->
                        <span class="addBtn bttoncreate">
                          <i class="fa fa-plus"></i>
                        </span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="card-footer text-end"> &nbsp; </div>
            </div>
            <div class="row totalcount">
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">&nbsp;</label>
                  <label class="form-label">Total Indirect Manpower: 45</label>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">&nbsp;</label>
                  <label class="form-label">Total Direct Manpower: 45</label>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">&nbsp;</label>
                  <label class="form-label">Total Contractor's Manpower: 22</label>
                </div>
              </div>
            </div>
            <br />
            <div class="col-md-12 l-section">
              <h2>Sub Contractors</h2>
              <br />
              <table class="table tableadd form">
                <thead>
                  <tr>
                    <th>Position Name</th>
                    <th>No Of Person per Position</th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr id="addRow2">
                    <td class="col-xs-3">
                      <input name="position[]" class="form-control addMain2" type="text" placeholder="Enter Position Name" />
                    </td>
                    <td class="col-xs-3">
                      <input name="no_of_persons[]"  class="form-control addPrefer2" type="text" placeholder="Enter No Of Person Per Position" />
                    </td>
                    <td class="col-xs-5">
                      <select  class="form-control addbutton addCommon2"  name="option_method[]">
                        <option value="" disabled selected>Select your option</option>
                        <option value="Direct Manpower">Direct Manpower</option>
                        <option value="InDirect Manpower">InDirect Manpower</option>
                      </select>
                    </td>
                    <td class="col-xs-1 text-center">
                      <span class="addBtn2 bttoncreate">
                        <i class="fa fa-plus"></i>
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="card-footer text-end"> &nbsp; </div>
            </div>
            <div class="row totalcount">
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">&nbsp;</label>
                  <label class="form-label">Total Indirect Manpower: 45</label>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">&nbsp;</label>
                  <label class="form-label">Total Direct Manpower: 45</label>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">&nbsp;</label>
                  <label class="form-label">Total Contractor's Manpower: 22</label>
                </div>
              </div>
            </div>
            <br />
            <div class="col-md-12 l-section">
              <h2>Major Equipment on Project</h2>
              <br />
              <table class="table tableadd form">
                <thead>
                  <tr>
                    <th>Equipment Name</th>
                    <th>No Of Equipment</th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr id="addRow3">
                    <td class="col-xs-3">
                      <input name="position_name[]" class="form-control addMain3" type="text" placeholder="Enter Equipment Name" />
                    </td>
                    <td class="col-xs-3">
                      <input name="no_of_persons[]" class="form-control addPrefer3" type="text" placeholder="Enter No Of Person Per Position" />
                    </td>
                    <td class="col-xs-5">
                      <select class="form-control addbutton addCommon3" name="option_method[]">
                        <option value="" disabled selected>Select your option</option>
                        <option value="Direct Manpower">Direct Manpower</option>
                        <option value="InDirect Manpower">InDirect Manpower</option>
                      </select>
                    </td>
                    <td class="col-xs-1 text-center">
                      <span class="addBtn3 bttoncreate">
                        <i class="fa fa-plus"></i>
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-md-4 form-group">
              <label name="document" for="" class="form-label">{{__('Document')}}
              </label>
              <div class="choose-file ">
                <label for="document" class="form-label">
                  <input name="attachements" type="file" class="form-control" name="document" id="document" data-filename="document_create"  multiple>
                  <br>
                  <span class="show_document_file" style="color:green;"></span>
                </label>
              </div>
            </div>
            <div class="col-md-12">
              {{Form::label('Remarks',__('Remarks'),array('class'=>'form-label')) }}
              <textarea name="remarks" class="form-control" rows="5" style="height: 200px;"></textarea>
            </div>
            <div class="col-md-12">
              {{Form::label('Prepared By',__('Prepared By'),array('class'=>'form-label')) }}
              <input name="prepared_by" class="form-control" type="textbox" />
            </div>
            <div class="col-md-12">
              {{Form::label('Title',__('Title'),array('class'=>'form-label')) }}
              <input name="title" class="form-control" type="textbox" />
            </div>
            <br />
            <div class="card-footer text-end">
              <button type="submit" class="btn btn-primary" id="daily_report_create">{{__('Save')}}</button>
              <input type="button" value="{{__('Cancel')}}" class="btn btn-light" >
            </div>
        </form>
      </div>
    </div>
  </div>
  <hr />
</div>


@include('new_layouts.footer')

<script>
    $(document).ready(function() {
        $(".chosen-select").chosen();

      $(document).on('submit', 'form', function() {
        $('#daily_report_create').attr('disabled', 'disabled');
      });

    });
</script>


<script type="text/javascript">
  var i = 0;
    
    $(".addBtn").click(function(){
  
        ++i;
  
        $("#dynamicTable").append('<tr><td><input type="text" name="first_position[]" placeholder="Enter Position Name" class="form-control first_position_'+i+'" /></td><td><input type="text" name="first_person[]" placeholder="Enter No Of Person Per Position" class="form-control first_person_'+i+'" /></td><td><select class="form-control first_option_'+i+'" name="first_option[]" ><option value="" disabled selected>Select your option</option><option value="Direct Manpower">Direct Manpower</option><option value="InDirect Manpower">InDirect Manpower</option></select></td><td><span class="remove-tr bttoncreate"><i class="fa fa-trash"></i></span></td></tr>');
    });
      
    $(document).on('click', '.remove-tr', function(){  
        $(this).parents('tr').remove();
    });  

 $(document).on('change', '#con_date', function() {
  var con_date=$(this).val();
  var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];

var days = new Date(con_date);
$('.con_day').val(weekday[days.getDay()]);

});

</script>
