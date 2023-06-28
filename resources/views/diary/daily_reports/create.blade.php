@include('new_layouts.header')
@include('construction_project.side-menu')
<style>
  div#choices_multiple1_chosen {
      width: 100% !important;
  }
</style>
<h2>{{__('Contractors daily construction report')}}</h2>
<div class="maindailyreport">
  <div class="row">
    <div class="row row-cards">
      <div class="col-12">
        <form class="card" action="{{ route('save_site_reports') }}" enctype="multipart/form-data" method="POST"> @csrf <div class="card-body">
            <div class="row row-cards">
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">{{__('Daily Report No')}}</label>
                  <label class="form-label form-control disabledmode">{{__('Daily Report No')}}</label>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">{{__('Contractor Name')}}</label>
                  <input type="text" class="form-control" name="contractor_name" placeholder="{{__('Contractor Name')}}" value="">
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">{{__('Date')}}</label>
                  <input type="date" name="con_date" class="form-control" id="con_date" placeholder="Email">
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">{{__('Project Name')}}</label>
                  <label class="form-label form-control disabledmode">{{$project_name->project_name}}</label>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">{{__('Weather')}}</label>
                  <div class="dropdownrpt">
                    <select name="weather[]" id='choices-multiple1' class='chosen-select' multiple>
                      <option value="" disabled>{{__('Select your option')}}</option>
                      <option value="Windy">{{__('Windy')}}</option>
                      <option value="Cool">{{__('Cool')}}</option>
                      <option value="Fog">{{__('Fog')}}</option>
                      <option value="Warm">{{__('Warm')}}</option>
                      <option value="Rain">{{__('Rain')}}</option>
                      <option value="Cold">{{__('Cold')}}</option>
                      <option value="Hot">{{__('Hot')}}</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">{{__('Site conditions')}}</label>
                  <div class="dropdownrpt">
                    <select name="site_conditions[]" id='choices-multiple1' class='chosen-select'  multiple>
                      <option value="" disabled>{{__('Select your option')}}</option>
                      <option value="Clear">{{__('Clear')}}</option>
                      <option value="Dusty">{{__('Dusty')}}</option>
                      <option value="Muddy">{{__('Muddy')}}</option>
                      <option value="Windy">{{__('Windy')}}</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">{{__('Day')}}</label>
                  <input type="text" class="form-control con_day" disabled>
                  <input type="hidden"  class="con_day" name="con_day" >
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="mb-3">
                  <label class="form-label">{{__('Temparture (Maximum)')}}</label>
                  <input name="temperature" type="text" class="form-control" placeholder="{{__('Temparture (Maximum)')}}" value="">
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="mb-3">
                  <label class="form-label">{{__('Minimum')}}</label>
                  <input name="min_input" type="text" class="form-control" placeholder="{{__('Minimum')}}">
                </div>
              </div>
              <div class="col-sm-6 col-md-2">
                <div class="mb-3">
                  <label class="form-label">&nbsp;</label>
                  <select name="degree" class="form-control addbutton" >
                    <option value="" disabled selected>{{__('Select your option')}}</option>
                    <option value="Fahrenheit">{{__('Fahrenheit')}}</option>
                    <option value="Celsius">{{__('Celsius')}}</option>
                  </select>
                </div>
              </div>
              <div class="card-footer text-end"> &nbsp; </div>
              <div class="col-md-12 l-section">
                <h2>{{__('Contractors Personnel')}}</h2>
                <br />
                <table class="table tableadd form" id="dynamicTable">
                  <thead>
                    <tr>
                    <tr>
                      <th>{{__('Position')}}</th>
                      <th>{{__('No Of Person per Position')}}</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr id="addRow">
                      <td class="col-xs-3">
                        <input name="first_position[]" class="form-control first_position" id="first_position_0" type="text" placeholder="Enter Position Name" />
                      </td>
                      <td class="col-xs-3">
                        <input name="first_person[]"  class="form-control first_person" id="first_person_0" type="text" placeholder="Enter No Of Person Per Position" />
                      </td>
                      <td class="col-xs-5">
                        <select class="form-control first_option"  id="first_option_0" name="first_option[]">
                          <option value="" disabled selected>{{__('Select your option')}}</option>
                          <option value="Direct Manpower">{{__('Direct Manpower')}}</option>
                          <option value="InDirect Manpower">{{__('InDirect Manpower')}}</option>
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
                  <label class="form-label">{{__('Total Indirect Manpower')}}: <input type="text" class="form-control" name="total_in_power_one" id="total_in_power_one"></label>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">&nbsp;</label>
                  <label class="form-label">{{__('Total Direct Manpower')}}: <input type="text" class="form-control" name="total_di_power_one" id="total_di_power_one"></label>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">&nbsp;</label>
                  <label class="form-label">{{__('Total Contractors Manpower')}}: <input type="text" class="form-control" name="total_con_power_one" id="total_con_power_one"></label>
                </div>
              </div>
            </div>
            <br />
            <div class="col-md-12 l-section">
              <h2>{{__('Sub Contractors')}}</h2>
              <br />
              <table class="table tableadd form" id="dynamicTable2">
                <thead>
                  <tr>
                    <th>{{__('Position Name')}}</th>
                    <th>{{__('No Of Person per Position')}}</th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr id="addRow2">
                    <td class="col-xs-3">
                      <input name="second_position[]" class="form-control second_position" id="second_position_0" type="text" placeholder="Enter Position Name" />
                    </td>
                    <td class="col-xs-3">
                      <input name="second_person[]"  class="form-control second_person" id="second_person_0" type="text" placeholder="Enter No Of Person Per Position" />
                    </td>
                    <td class="col-xs-5">
                      <select  class="form-control second_option" id="second_option_0"  name="second_option[]">
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
                  <label class="form-label">{{__('Total Indirect Manpower')}}: <input type="text" class="form-control" name="total_in_power_two" id="total_in_power_two"></label>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">&nbsp;</label>
                  <label class="form-label">{{__('Total Direct Manpower')}}: <input type="text" class="form-control" name="total_di_power_two" id="total_di_power_two"></label>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">&nbsp;</label>
                  <label class="form-label">{{__('Total Contractors Manpower')}}: <input type="text" class="form-control" name="total_con_power_two" id="total_con_power_two"></label>
                </div>
              </div>
            </div>
            <br />
            <div class="col-md-12 l-section">
              <h2>{{__('Major Equipment on Project')}}</h2>
              <br />
              <table class="table tableadd form" id="dynamicTable3">
                <thead>
                  <tr>
                    <th>{{__('Equipment Name')}}</th>
                    <th>{{__('No Of Equipment')}}</th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr id="addRow3">
                    <td class="col-xs-3">
                      <input name="third_position[]" class="form-control third_position" id="third_position_0" type="text" placeholder="Enter Equipment Name" />
                    </td>
                    <td class="col-xs-3">
                      <input name="third_person[]" class="form-control third_person" id="third_person_0" type="text" placeholder="Enter No Of Person Per Position" />
                    </td>
                    <td class="col-xs-5">
                      <select class="form-control third_option" id="third_option_0" name="third_option[]">
                        <option value="" disabled selected>{{__('Select your option')}}</option>
                        <option value="Direct Manpower">{{__('Direct Manpower')}}</option>
                        <option value="InDirect Manpower">{{__('InDirect Manpower')}}</option>
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
                  <input name="attachements[]" type="file" class="form-control"  id="document" data-filename="document_create"  multiple>
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
              <a href="{{ route('daily_reports') }}"  class="btn btn-light" >{{__('Cancel')}}</a>
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
  
        $("#dynamicTable").append('<tr><td><input type="text" name="first_position[]" placeholder="Enter Position Name" class="form-control first_position" id="first_position_'+i+'"/></td><td><input type="text" name="first_person[]" placeholder="Enter No Of Person Per Position" class="form-control first_person" id="first_person_'+i+'" /></td><td><select class="form-control first_option" id="first_option_'+i+'" name="first_option[]" ><option value="" disabled selected>Select your option</option><option value="Direct Manpower">Direct Manpower</option><option value="InDirect Manpower">InDirect Manpower</option></select></td><td><span class="remove-tr bttoncreate"><i class="fa fa-trash"></i></span></td></tr>');
    });
      
    $(document).on('click', '.remove-tr', function(){  
        $(this).parents('tr').remove();
    });  

    var j = 0;
    
    $(".addBtn2").click(function(){
  
        ++j;
  
        $("#dynamicTable2").append('<tr><td><input type="text" name="second_position[]" placeholder="Enter Position Name" class="form-control second_position" id="second_position_'+j+'" /></td><td><input type="text" name="second_person[]" placeholder="Enter No Of Person Per Position" class="form-control second_person" id="second_person_'+j+'" /></td><td><select id="second_option_'+i+'" class="form-control second_option" name="second_option[]" ><option value="" disabled selected>Select your option</option><option value="Direct Manpower">Direct Manpower</option><option value="InDirect Manpower">InDirect Manpower</option></select></td><td><span class="remove-ca bttoncreate"><i class="fa fa-trash"></i></span></td></tr>');
    });
      
    $(document).on('click', '.remove-ca', function(){  
        $(this).parents('tr').remove();
    });  
    var K = 0;
    $(".addBtn3").click(function(){
  
    ++K;

    $("#dynamicTable3").append('<tr><td><input type="text" name="third_position[]" placeholder="Enter Position Name" id="third_position_'+K+'" class="form-control third_position" /></td><td><input type="text" name="third_person[]" placeholder="Enter No Of Person Per Position" class="form-control third_person" id="third_person_'+K+'"/></td><td><select class="form-control third_option" id="third_option_'+K+'" name="third_option[]" ><option value="" disabled selected>Select your option</option><option value="Direct Manpower">Direct Manpower</option><option value="InDirect Manpower">InDirect Manpower</option></select></td><td><span class="remove-ba bttoncreate"><i class="fa fa-trash"></i></span></td></tr>');
    });

    $(document).on('click', '.remove-ba', function(){  
      $(this).parents('tr').remove();
    });  

 $(document).on('change', '#con_date', function() {
  var con_date=$(this).val();
  var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];

  var days = new Date(con_date);
  $('.con_day').val(weekday[days.getDay()]);

  });

//   $(function() {

// $(".first_person,first_option").on("keydown keyup change", sum);
// alert("fgfg");
//   function sum() {
   
//     var priceSum = 0;
// $('.first_person').each(function(){
//   priceSum += parseFloat(this.value);
// });

  

//     $("#total_in_power").val(priceSum);
  

//   }

// });

$(document).on('change', '.first_option', function() {


  var total = 0;
  
  $('.first_person').each(function(){
    total += parseFloat($(this).val());
  }) 
  


$(".first_option :selected").map(function(i, el) {
    return $(el).val();

    if($(el).val()=='Direct Manpower'){
      $(".first_person").closest("tr").addClass("intro");
      alert($(el).val());
      $("#total_di_power_one").val(total);
    }else{
      alert($(el).val());
      $("#total_in_power_one").val(total);
    }

}).get();




  
});



</script>
