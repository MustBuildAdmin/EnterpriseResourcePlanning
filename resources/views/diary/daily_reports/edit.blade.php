@include('new_layouts.header')
@include('construction_project.side-menu')
<style>
  div#choices_multiple1_chosen {
      width: 100% !important;
  }
</style>
<h2>{{__('Contractors Daily Construction Report')}}</h2>
<div class="maindailyreport">
  <div class="row">
    <div class="row row-cards">
      <div class="col-12">
        <form class="card" action="{{ route('update_site_reports') }}" enctype="multipart/form-data" method="POST">
          @csrf
          @if(isset($data->id))
          @if($data->id!=null)
          <input type="hidden" name="edit_id" value="{{$data->id ?? ''}}">
          @endif
          @endif
          <div class="card-body">
            <div class="row row-cards">
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">{{__('Daily Report No')}}</label>
                  <label class="form-label form-control disabledmode">
                    {{__('Daily Report No')}}  {{$data->id ?? ''}}</label>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">{{__('Contractor Name')}}</label>
                  <input type="text" class="form-control" name="contractor_name"
                   placeholder="Username" value="{{$data->contractor_name ?? ''}}">
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">{{__('Date')}}</label>
                  <input type="date" name="con_date" class="form-control"
                   id="con_date" placeholder="Email" value="{{$data->con_date ?? ''}}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">{{__('Project Name')}}</label>
                  <label class="form-label form-control disabledmode">{{$projectname->project_name}}</label>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">{{__('Weather')}}</label>
                  <div class="dropdownrpt">
                   @if(isset($data->weather))
                    <select name="weather[]" id='choices-multiple1' class='chosen-select' multiple>
                      <option value="" disabled>{{__('Select your option')}}</option>
                      <option @if(str_contains($data->weather,'Clear')) selected @endif
                         value="Windy">{{__('Clear')}}
                      </option>
                      <option @if(str_contains($data->weather,'Windy')) selected @endif
                         value="Windy">{{__('Windy')}}
                      </option>
                      <option @if(str_contains($data->weather,'Cool')) selected @endif
                         value="Cool">{{__('Cool')}}
                      </option>
                      <option @if(str_contains($data->weather,'Overcast')) selected @endif
                         value="Overcast">{{__('Overcast')}}
                      </option>
                      <option @if(str_contains($data->weather,'Fog')) selected @endif
                         value="Fog">{{__('Fog')}}
                      </option>
                      <option @if(str_contains($data->weather,'Warm')) selected @endif
                         value="Warm">{{__('Warm')}}
                      </option>
                      <option @if(str_contains($data->weather,'Rain')) selected @endif
                         value="Rain">{{__('Rain')}}
                      </option>
                      <option @if(str_contains($data->weather,'Cold')) selected @endif
                         value="Cold">{{__('Cold')}}
                      </option>
                      <option @if(str_contains($data->weather,'Hot')) selected @endif
                         value="Hot">{{__('Hot')}}
                      </option>
                    </select>
                    @else
                    <select name="weather[]" id='choices-multiple1' class='chosen-select' multiple>
                      <option value="" disabled>{{__('Select your option')}}</option>
                      <option value="Clear">{{__('Clear')}}</option>
                      <option value="Windy">{{__('Windy')}}</option>
                      <option value="Cool">{{__('Cool')}}</option>
                      <option value="Overcast">{{__('Overcast')}}</option>
                      <option value="Fog">{{__('Fog')}}</option>
                      <option value="Warm">{{__('Warm')}}</option>
                      <option value="Rain">{{__('Rain')}}</option>
                      <option value="Cold">{{__('Cold')}}</option>
                      <option value="Hot">{{__('Hot')}}</option>
                    </select>
                    @endif
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">{{__('Site conditions')}}</label>
                  <div class="dropdownrpt">
                    @if(isset($data->site_conditions))
                    <select name="site_conditions[]" id='choices-multiple1' class='chosen-select'  multiple>
                      <option value="" disabled>{{__('Select your option')}}</option>
                      <option @if(str_contains($data->site_conditions,'Clear')) selected @endif
                        value="Clear">{{__('Clear')}}
                      </option>
                      <option @if(str_contains($data->site_conditions,'Dusty')) selected @endif
                         value="Dusty">{{__('Dusty')}}
                      </option>
                      <option @if(str_contains($data->site_conditions,'Muddy')) selected @endif
                        value="Muddy">{{__('Muddy')}}
                      </option>
                    </select>
                    @else
                    <select name="site_conditions[]" id='choices-multiple1' class='chosen-select'  multiple>
                      <option value="" disabled>{{__('Select your option')}}</option>
                      <option value="Clear">{{__('Clear')}}</option>
                      <option value="Dusty">{{__('Dusty')}}</option>
                      <option value="Muddy">{{__('Muddy')}}</option>
                    </select>
                    @endif
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">{{__('Day')}}</label>
                  <input type="text" class="form-control con_day" value="{{$data->con_day ?? ''}}" disabled>
                  <input type="hidden"  class="con_day" name="con_day" value="{{$data->con_day ?? ''}}">
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="mb-3">
                  <label class="form-label">{{__('Temperature (Minimum)')}}</label>
                  <input name="min_input" type="text" class="form-control minimum"
                   placeholder="{{__('Temperature (Minimum)')}}"  value="{{$data->min_input ?? ''}}">
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="mb-3">
                  <label class="form-label">{{__('Temperature (Maximum)')}}</label>
                  <input name="temperature" type="text" class="form-control temperature"
                   placeholder="{{__('Temperature (Maximum)')}}" value="{{$data->temperature ?? ''}}">
                </div>
              </div>
              <div class="col-sm-6 col-md-2">
                <div class="mb-3">
                  <label class="form-label">&nbsp;</label>
                  @if(isset($data->degree))
                  <select name="degree" class="form-control addbutton" >
                    <option value="" disabled selected>{{__('Select your option')}}</option>
                    <option @if('Fahrenheit'==$data->degree){ selected }@endif value="Fahrenheit">
                      {{__('Fahrenheit')}}
                    </option>
                    <option @if('Celsius'==$data->degree){ selected }@endif value="Celsius">{{__('Celsius')}}</option>
                  </select>
                  @else
                  <select name="degree" class="form-control addbutton" >
                    <option value="" disabled selected>{{__('Select your option')}}</option>
                    <option value="Fahrenheit">{{__('Fahrenheit')}}</option>
                    <option value="Celsius">{{__('Celsius')}}</option>
                  </select>
                  @endif
                </div>
              </div>
              <div class="card-footer text-end"> &nbsp; </div>
              <div class="col-md-12 l-section">
                <h2>{{__('Contractors Personnel')}}</h2>
                <br />
           
                <table class="table tableadd form" id="dynamicTable" aria-describedby="Contractors Personnel">
                  <thead>
                    <tr>
                      <th>{{__('Position')}}</th>
                      <th>{{__('No Of Person per Position')}}</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($datasub as $sub_key=>$display_sub)
                    <tr id="addRow">
                      <td class="col-xs-3">
                        <input name="first_position[]" class="form-control first_position_0"
                         type="text" placeholder="{{__('Enter Position Name')}}"
                          value="{{$display_sub['position_name'] ?? ''}}"/>
                      </td>
                      <td class="col-xs-3">
                        <input name="first_person[]"  class="form-control first_person_0"
                         type="text" placeholder="{{__('Enter No Of Person Per Position')}}"
                          value="{{$display_sub['no_of_persons'] ?? ''}}" />
                      </td>
                      <td class="col-xs-5">
                        <select class="form-control first_option_0"  name="first_option[]">
                          <option value="" disabled selected>{{__('Select your option')}}</option>
                          <option value="Direct Manpower"
                          @if( 'Direct Manpower'==$display_sub[ 'option_method']){ selected } @endif>
                          {{__('Direct Manpower')}}
                          </option>
                          <option value="InDirect Manpower"
                           @if( 'InDirect Manpower'==$display_sub[ 'option_method']){ selected } @endif>
                           {{__('InDirect Manpower')}}
                          </option>
                        </select>
                      </td>
                      @if ($sub_key == 0)
                        <td class="col-xs-1 text-center">
                          <span class="addBtn bttoncreate">
                            <i class="fa fa-plus"></i>
                          </span>
                        </td>
                      @else
                        <td class="col-xs-1 text-center">
                          <span class="remove-tr bttoncreate">
                            <i class="fa fa-trash"></i>
                          </span>
                        </td>
                      @endif
                      
                    </tr>
                    @endforeach
                  </tbody>
                </table>
               
             
              </div>
              <div class="card-footer text-end"> &nbsp; </div>
            </div>
            <div class="row totalcount">
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">&nbsp;</label>
                  <label class="form-label">{{__('Total Direct Manpower')}}:
                    <input type="text" placeholder="{{__('Total Direct Manpower')}}"
                     class="form-control" name="" id="total_di_power_one_dis"
                      value="{{$data->total_di_power_one ?? ''}}" disabled>
                    <input type="hidden" class="form-control" name="total_di_power_one"
                     id="total_di_power_one" value="{{$data->total_di_power_one ?? ''}}"></label>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">&nbsp;</label>
                  <label class="form-label">{{__('Total Indirect Manpower')}}:
                    <input type="text" placeholder="{{__('Total Contractors Manpower')}}" class="form-control"
                     name="" id="total_in_power_one_dis" value="{{$data->total_in_power_one ?? ''}}" disabled>
                    <input type="hidden" class="form-control" name="total_in_power_one" id="total_in_power_one"
                     value="{{$data->total_in_power_one ?? ''}}">
                  </label>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">&nbsp;</label>
                  <label class="form-label">{{__('Total Contractors Manpower')}}:
                    <input type="text" placeholder="{{__('Total Contractors Manpower')}}" class="form-control"
                     name="" id="total_con_power_one_dis" value="{{$data->total_con_power_one ?? ''}}" disabled>
                    <input type="hidden" class="form-control" name="total_con_power_one"
                      id="total_con_power_one" value="{{$data->total_con_power_one ?? ''}}">
                  </label>
                </div>
              </div>
            </div>
            <br />
            <div class="col-md-12 l-section">
              <h2>{{__('Sub Contractors')}}</h2>
              <br />
              <table class="table tableadd form" id="dynamicTable2" aria-describedby="Sub Contractors">
                <th></th>
                <thead>
                  <tbody>
                    @foreach ($datasub1 as $sub_con_key=> $display_sub_con)
                    <tr id="">
                      <td class="col-xs-3">
                        <input name="second_position[]" class="form-control second_position_0" type="text"
                         placeholder="{{__('Enter Position Name')}}"
                         value="{{$display_sub_con['position_name'] ?? ''}}"/>
                      </td>
                      <td class="col-xs-3">
                        <input name="second_person[]"  class="form-control second_person_0" type="text"
                         placeholder="{{__('Enter No Of Person Per Position')}}"
                         value="{{$display_sub_con['no_of_persons'] ?? ''}}"/>
                      </td>
                      <td class="col-xs-5">
                        <select  class="form-control second_option_0"  name="second_option[]">
                          <option value="" disabled selected>{{__('Select your option')}}</option>
                          <option value="Direct Manpower"
                          @if( 'Direct Manpower'==$display_sub_con[ 'option_method']){ selected } @endif>
                          {{__('Direct Manpower')}}
                        </option>
                          <option value="InDirect Manpower"
                          @if( 'InDirect Manpower'==$display_sub_con[ 'option_method']){ selected } @endif>
                          {{__('InDirect Manpower')}}
                          </option>
                        </select>
                      </td>
                      @if ($sub_con_key == 0)
                      <td class="col-xs-1 text-center">
                        <span class="addBtn2 bttoncreate">
                          <i class="fa fa-plus"></i>
                        </span>
                      </td>
                      @else
                      <td class="col-xs-1 text-center">
                        <span class="remove-ca bttoncreate">
                          <i class="fa fa-trash"></i>
                        </span>
                      </td>
                      @endif
                    </tr>
                    @endforeach
                  </tbody>
              </table>
              <div class="card-footer text-end"> &nbsp; </div>
            </div>
            <div class="row totalcount">
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">&nbsp;</label>
                  <label class="form-label">{{__('Total Direct Manpower')}}:
                    <input type="text" placeholder="{{__('Total Direct Manpower')}}" class="form-control" name=""
                    id="total_di_power_two_dis" value="{{$data->total_di_power_two ?? ''}}" disabled>
                    <input type="hidden" class="form-control" name="total_di_power_two"
                     id="total_di_power_two" value="{{$data->total_di_power_two ?? ''}}">
                    </label>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">&nbsp;</label>
                  <label class="form-label">{{__('Total Indirect Manpower')}}:
                  <input type="text" placeholder="{{__('Total Indirect Manpower')}}" class="form-control"
                   name="" id="total_in_power_two_dis" value="{{$data->total_in_power_two ?? ''}}" disabled>
                   <input type="hidden" class="form-control" name="total_in_power_two"
                    id="total_in_power_two" value="{{$data->total_in_power_two ?? ''}}">
                  </label>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                  <label class="form-label">&nbsp;</label>
                  <label class="form-label">{{__('Total Contractors Manpower')}}:
                    <input placeholder="{{__('Total Contractors Manpower')}}" type="text" class="form-control"
                     name="" id="total_con_power_two_dis" value="{{$data->total_con_power_two ?? ''}}" disabled>
                     <input type="hidden" class="form-control" name="total_con_power_two"
                      id="total_con_power_two" value="{{$data->total_con_power_two ?? ''}}">
                  </label>
                </div>
              </div>
            </div>
            <br />
            <div class="col-md-12 l-section">
              <h2>{{__('Major Equipment on Project')}}</h2>
              <br />
            
              <table class="table tableadd form" id="dynamicTable3" aria-describedby="Major Equipment on Project">
                <thead>
                  <tr>
                    <th>{{__('Equipment Name')}}</th>
                    <th>{{__('No Of Equipment')}}</th>
                    <th>{{__('Hour/Day')}}</th>
                    <th>{{__('Total Hours/Day')}}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($datasub2 as $key =>$display_major_equi)
                  <tr id="">
                    <td class="col-xs-3">
                      <input name="third_position[]" class="form-control third_position_0" type="text"
                       placeholder="{{__('Enter Equipment Name')}}"
                       value="{{$display_major_equi['position_name'] ?? ''}}"/>
                    </td>
                    <td class="col-xs-3">
                      <input name="third_person[]" class="form-control third_person_0" type="text"
                       placeholder="{{__('Enter No Of Person Per Position')}}"
                       value="{{$display_major_equi['no_of_persons'] ?? ''}}"/>
                    </td>
                    <td class="col-xs-5">
                      <input name="hours[]" class="form-control hours" id="hours_0" type="text"
                       placeholder="{{__('Enter No Of Hours/Day')}}"
                       value="{{$display_major_equi['hours'] ?? ''}}"/>
                    </td>
                    <td class="col-xs-3">
                      <input class="form-control total_hours_sub" id="total_hours_sub_0" type="text"
                       placeholder="{{__('Enter No of Hours/Day')}}"
                       value="{{$display_major_equi['total_hours'] ?? ''}}" disabled/>
                       <input name="total_hours[]" class="form-control total_hours" id="total_hours_0"
                        type="hidden" placeholder="Enter Total Hours/Day"
                        value="{{$display_major_equi['total_hours'] ?? ''}}"/>
                    </td>
                    @if($key == 0)
                      <td class="col-xs-1 text-center">
                        <span class="addBtn3 bttoncreate">
                          <i class="fa fa-plus"></i>
                        </span>
                      </td>
                    @else
                      <td class="col-xs-1 text-center">
                        <span class="remove-ba bttoncreate">
                          <i class="fa fa-trash"></i>
                        </span>
                      </td>
                    @endif
                    
                  </tr>
                  @endforeach
                </tbody>
              </table>
           
            </div>
            <div class="col-md-4 form-group">
              <label name="document" for="" class="form-label">{{__('Document')}}
              </label>
              <div class="choose-file ">
                <label for="document" class="form-label">
                  <input name="attachements[]" type="file" class="form-control" name="document"
                   id="document" data-filename="document_create"  multiple>
                  <input type="hidden" name="existing_file_id" value="{{$data->file_id ?? ''}}">
                  @php
                      $file_explode = explode(',',$data->file_name);
                  @endphp
                  @forelse ($file_explode as $file_show)
                      @if($file_show != "")
                          <span class="badge badge-primary" style="background-color:#007bff;margin-top: 5px;">
                            {{$file_show}}
                          </span>
                          <br>
                      @else
                          -
                      @endif
                  @empty
                  @endforelse
                  <br>
                  <span class="show_document_file" style="color:green;"></span>
                </label>
              </div>
            </div>
            <div class="col-md-12">
              {{Form::label('Remarks',__('Remarks'),array('class'=>'form-label')) }}
              <textarea name="remarks" placeholder="{{__('Remarks')}}" class="form-control"
               rows="5" style="height: 200px;">{{$data->remarks ?? ''}}
              </textarea>
            </div>
            <div class="row">
            <div class="col-md-6">
              {{Form::label('Prepared By',__('Prepared By'),array('class'=>'form-label')) }}
              <input name="prepared_by" placeholder="{{__('Prepared By')}}" class="form-control"
               type="text" value="{{$data->prepared_by ?? ''}}"/>
            </div>
            <div class="col-md-6">
              {{Form::label('Title',__('Title'),array('class'=>'form-label')) }}
              <input name="title" placeholder="{{__('Title')}}" class="form-control"
               type="text" value="{{$data->title ?? ''}}" />
            </div>
            </div>
            <br />
            <div class="card-footer text-end">
              <button type="submit" class="btn btn-primary" id="update_daily_report">{{__('Update')}}</button>
              <a href="{{ route('daily_reports') }}"  class="btn btn-light" >{{__('Back')}}</a>
            </div>
        </form>
      </div>
    </div>
  </div>
  <hr />
</div>


@include('new_layouts.footer')

<script src="{{ asset('assets/js/jquery.alphanum.js') }}"  integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script>
<script>
    $(document).ready(function() {
        $(".chosen-select").chosen();

      $(document).on('submit', 'form', function() {
        $('#update_daily_report').attr('disabled', 'disabled');
      });

    });

    var i = 0;
    
    $(".addBtn").click(function(){
  
        ++i;
  
        $("#dynamicTable").append(
          '<tr>'+
            '<td>'+
              '<input type="text" name="first_position[]" placeholder="Enter Position Name"'+
               'class="form-control first_position" id="first_position_'+i+'"/>'+
            '</td>'+
            '<td>'+
              '<input type="text" name="first_person[]" placeholder="Enter No Of Person Per Position"'+
              'class="form-control first_person" id="first_person_'+i+'" />'+
            '</td>'+
            '<td>'+
              '<select class="form-control first_option" id="first_option_'+i+'" name="first_option[]">'+
                '<option value="" disabled selected>Select your option</option>'+
                '<option value="Direct Manpower">Direct Manpower</option>'+
                '<option value="InDirect Manpower">InDirect Manpower</option>'+
              '</select>'+
            '</td>'+
            '<td>'+
              '<span class="remove-tr bttoncreate">'+
                '<i class="fa fa-trash"></i>'+
              '</span>'+
            '</td>'+
          '</tr>');
    });
      
    $(document).on('click', '.remove-tr', function(){
        $(this).parents('tr').remove();
    });

    var j = 0;
    
    $(".addBtn2").click(function(){
  
        ++j;
  
        $("#dynamicTable2").append(
          '<tr>'+
            '<td>'+
                '<input type="text" name="second_position[]" placeholder="Enter Position Name"'+
                 'class="form-control second_position" id="second_position_'+j+'" />'+
            '</td>'+
            '<td>'+
                '<input type="text" name="second_person[]" placeholder="Enter No Of Person Per Position"'+
                 'class="form-control second_person" id="second_person_'+j+'" />'+
            '</td>'+
            '<td>'+
                '<select id="second_option_'+i+'" class="form-control second_option" name="second_option[]" >'+
                '<option value="" disabled selected>Select your option</option>'+
                '<option value="Direct Manpower">Direct Manpower</option>'+
                '<option value="InDirect Manpower">InDirect Manpower</option>'+
                '</select>'+
            '</td>'+
            '<td>'+
                '<span class="remove-ca bttoncreate">'+
                '<i class="fa fa-trash"></i>'+
                '</span>'+
            '</td>'+
          '</tr>');
    });
      
    $(document).on('click', '.remove-ca', function(){
        $(this).parents('tr').remove();
    });
    var K = 0;
    $(".addBtn3").click(function(){
  
    ++K;

    $("#dynamicTable3").append(
      '<tr>'+
        '<td>'+
            '<input type="text" name="third_position[]" placeholder="Enter Position Name"'+
             'id="third_position_'+K+'" class="form-control third_position" />'+
        '</td>'+
        '<td>'+
            '<input type="text" name="third_person[]" placeholder="Enter No Of Person Per Position"'+
             'class="form-control third_person" id="third_person_'+K+'"/>'+
        '</td>'+
        '<td>'+
          '<input type="text" name="hours[]" placeholder="Enter No Of Hours/Day" class="form-control hours"'+
           'id="hours'+K+'"/>'+
        '</td>'+
        '<td>'+
          '<input type="text" name="" placeholder="Enter Total No Of Hours/Day" '+
           ' class="form-control total_hours_sub" id="total_hours_sub'+K+'" disabled/>'+
           '<input type="hidden" name="total_hours[]" placeholder="Enter Total No Of Hours/Day"'+
            'class="form-control total_hours" id="total_hours'+K+'"/>'+
        '</td>'+
        '<td>'+
            '<span class="remove-ba bttoncreate">'+
            '<i class="fa fa-trash"></i>'+
            '</span>'+
        '</td>'+
      '</tr>');
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

  
  function add_personal() {
          var a = parseInt($("#total_di_power_one").val());
          a = isNaN(a) ? '' : a;
          var b = parseInt($("#total_in_power_one").val());
          b = isNaN(b) ? '' : b;
          var c = a + b;
          c = isNaN(c) ? '' : c;
          $("#total_con_power_one").val(c);
          $("#total_con_power_one_dis").val(c);
    };

    $(document).on('change', '.first_option', function() {

      var total = 0;
      var direct_val=0;
      var indirect_val=0;
      var direct_val_total=0;
      var indirect_val_total=0;
      $('#total_di_power_one_dis').val(0);
      $('#total_in_power_one_dis').val(0);
      $('#total_in_power_one').val(0);
      $('#total_di_power_one').val(0);
        $(".first_option :selected").each(function(index) {
            first_option = $(this).val();
            if(first_option == "Direct Manpower"){
              direct_val =  $(this).closest("tr").find(".first_person").val();
              direct_val_total += parseFloat(direct_val);
              direct_val_total = isNaN(direct_val_total) ? '' : direct_val_total;
              $('#total_di_power_one').val(direct_val_total);
              $('#total_di_power_one_dis').val(direct_val_total);
            
            }
            else if(first_option == "InDirect Manpower"){
                indirect_val =  $(this).closest("tr").find(".first_person").val();
                indirect_val_total += parseFloat(indirect_val);
                indirect_val_total = isNaN(indirect_val_total) ? '' : indirect_val_total;
                $('#total_in_power_one').val(indirect_val_total);
                $('#total_in_power_one_dis').val(indirect_val_total);
              
            }
            add_personal();
        });
    });


    function add_sub_contract() {
          var d = parseInt($("#total_di_power_two").val());
          d = isNaN(d) ? '' : d;
          var e = parseInt($("#total_in_power_two").val());
          e = isNaN(e) ? '' : e;
          var f  = d + e;
          f = isNaN(f) ? '' : f;
          $("#total_con_power_two").val(f);
          $("#total_con_power_two_dis").val(f);
    };


    $(document).on('change', '.second_option', function() {

    var total_two = 0;
    var direct_val_two=0;
    var indirect_val_two=0;
    var direct_val_total_two=0;
    var indirect_val_total_two=0;
    $('#total_di_power_two').val(0);
    $('#total_di_power_two_dis').val(0);
    $('#total_in_power_one').val(0);
    $('#total_in_power_two_dis').val(0);
      $(".second_option :selected").each(function(index) {
          second_option = $(this).val();
          if(second_option == "Direct Manpower"){
            direct_val_two =  $(this).closest("tr").find(".second_person").val();
            direct_val_total_two += parseFloat(direct_val_two);
            direct_val_total_two = isNaN(direct_val_total_two) ? '' : direct_val_total_two;
            $('#total_di_power_two').val(direct_val_total_two);
            $('#total_di_power_two_dis').val(direct_val_total_two);
          
          }
          else if(second_option == "InDirect Manpower"){
            indirect_val_two =  $(this).closest("tr").find(".second_person").val();
            indirect_val_total_two += parseFloat(indirect_val_two);
            indirect_val_total_two = isNaN(indirect_val_total_two) ? '' : indirect_val_total_two;
            $('#total_in_power_two').val(indirect_val_total_two);
            $('#total_in_power_two_dis').val(indirect_val_total_two);
            
          }
          add_sub_contract();
      });
    });


  $('.first_person,.second_person,.third_person,.minimum,.temperature,.hours').alphanum({
        allow              : '',    // Allow extra characters
        allowUpper         : false,  // Allow upper case characters
        allowLower         : false,  // Allow lower case characters
        forceUpper         : false, // Convert lower case characters to upper case
        forceLower         : false, // Convert upper case characters to lower case
        allowLatin         : false,
  });


    $(document).on('keyup', '.third_person,.hours', function() {
          
          var third_person=0;
      
          var third_person = $(this).closest("tr").find(".third_person").val();
          var hours =  $(this).closest("tr").find(".hours").val();
      
          var mul_val=third_person*hours;
      
          $(this).closest("tr").find(".total_hours").val(mul_val);
          $(this).closest("tr").find(".total_hours_sub").val(mul_val);
      
    });

</script>
