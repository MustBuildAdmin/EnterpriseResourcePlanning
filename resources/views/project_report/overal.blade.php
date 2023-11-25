


{!! Html::style(asset('landing/css/bootstrap.min.css')) !!}

<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"> --}}
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0"/>
<style>
  body {
      font-family: sans-serif;
      font-size: 10pt;
  }

  p {
      margin: 0pt;
  }

  table.items {
      border: 0.1mm solid #e7e7e7;
  }

  td {
      vertical-align: top;
  }

  .items td {
      border-left: 0.1mm solid #e7e7e7;
      border-right: 0.1mm solid #e7e7e7;
  }

  table thead td {
      text-align: center;
      border: 0.1mm solid #e7e7e7;
  }

  .items td.blanktotal {
      background-color: #EEEEEE;
      border: 0.1mm solid #e7e7e7;
      background-color: #FFFFFF;
      border: 0mm none #e7e7e7;
      border-top: 0.1mm solid #e7e7e7;
      border-right: 0.1mm solid #e7e7e7;
  }

  .items td.totals {
      text-align: right;
      border: 0.1mm solid #e7e7e7;
  }

  .items td.cost {
      text-align: "."center;
  }
  </style>
</head>

<body>
    <table width="100%" style="font-family: sans-serif;" cellpadding="10">
        <tr>
            <td width="100%" style="padding: 0px; text-align: center;">
              <a href="#" target="_blank"><img src="https://mustbuildapp.com/assets/img/logo.jpeg" width="264" height="110" alt="Logo" align="center" border="0"></a>
            </td>
        </tr>
        <tr>
            {{-- <td width="100%" style="text-align: center; font-size: 20px; font-weight: bold; padding: 0px;">
              Report of - Date  
            </td>
            <td height="10" style="font-size: 0px; line-height: 10px; height: 10px; padding: 0px;">&nbsp;{{date('Y-m-d h:i A')}}</td> --}}
        </tr>
        <tr>
          
        </tr>
    </table>
    <table width="100%" style="font-family: sans-serif; font-size: 14px;" >
      <tr>
          <td>
              <table width="60%" align="left" style="font-family: sans-serif; font-size: 14px;" >
                  <tr>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;"><strong>Client Name</strong></td>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;">{{$client_name}}</td>
                  </tr>
                  <tr>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;"><strong>Project Name</strong></td>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;"> {{$project->project_name}}</td>
                  </tr>
                  {{-- <tr>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;"><strong>Consultant Names</strong></td>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;">XX/XX/XXXX</td>
                  </tr> --}}
                </tr>
                </table>
                <table width="40%" align="right" style="font-family: sans-serif; font-size: 14px;" >
                  <tr>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;"><strong>Report of Date</strong></td>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;">{{date('Y-m-d h:i A')}}</td>
                  </tr>
                  {{-- <tr>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;"><strong>Project Manager Name</strong></td>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;">Manager Name</td>
                  </tr> --}}
                  <tr>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;"><strong>Total Task in the Project</strong></td>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;">{{$total_task}} Task</td>
                  </tr>
                  <tr>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;"><strong>Total Completed Task in the Project</strong></td>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;">{{$all_completed}} Task</td>
                  </tr>
                  <tr>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;"><strong>Total Pending Task in the Project</strong></td>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;">{{$all_pending}} Task</td>
                  </tr>
                  <tr>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;"><strong>Total Future Task in the Project</strong></td>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;">{{$all_upcoming}} Task</td>
                  </tr>
                  <tr>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;"><strong>Acutual Project completion Percentage</strong></td>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;">{{$actual_current_progress}}%</td>
                  </tr>
                  <tr>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;"><strong>Planned Project completion Percentage</strong></td>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;">{{$current_Planed_percentage}}%</td>
                  </tr>
                  <!-- <tr>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;"><strong>Departure Date</strong></td>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;">XX/XX/XXXX</td>
                  </tr> -->
              </table>
          </td>
      </tr>
  </table>
  <br>

  <br>

  <br>

  <br>
  <h3>Summary Reports</h3>
  <table class="items" width="100%" style="font-size: 14px; border-collapse: collapse;" cellpadding="8">
      <thead>
          <tr>
              <td width="5%" style="text-align: left;"><strong>Summary Id</strong></td>
              <td width="20%" style="text-align: left;"><strong>Summary Name</strong></td>
              <td width="10%" style="text-align: left;"><strong>Summary Status</strong></td>
              <td width="10%" style="text-align: left;"><strong>Planned Summary Start-date</strong></td>
              <td width="10%" style="text-align: left;"><strong>Planned Summary End-date</strong></td>
              <td width="10%" style="text-align: left;"><strong>Actucal Summary Start-date</strong></td>
              <td width="10%" style="text-align: left;"><strong>Actucal Summary End-date</strong></td>
              <td width="10%" style="text-align: left;"><strong>Planned Summary Percentage</strong></td>
              <td width="10%" style="text-align: left;"><strong>Actucal Summary Percentage</strong></td>
              {{-- <td width="10%" style="text-align: left;"><strong>No of Tasks</strong></td> --}}
          </tr>
      </thead>
      <tbody>
        @forelse($taskdata as $key => $value)
         @if( $value['actual_percent'] < $value['percentage_as_today'])
           <tr >
            {{-- <tr style="background-color: #dc3545;color: white;"> --}}
         @else
           <tr>
         @endif
           <td>{{$value['id']}}</td>
           <td>{{$value['title']}}</td>
           <td>{{$value['status']}}</td>
           <td>{{$value['planed_start']}}</td>
           <td>{{$value['planed_end']}}</td>
           <td>{{$value['actual_start']}}</td>
           <td>{{$value['actual_end']}}</td>
           {{-- <td>{{$value['duration']}}</td> --}}
           <td>{{$value['percentage_as_today']}}%</td>
           {{-- <td>{{$value['actual_duration']}}</td> --}}
           <td>{{$value['actual_percent']}}%</td>
         </tr>
        @empty
         <tr>
           <td colspan="10" style='text-align: center;'>No Tasks are Avialable to see</td>
         </tr>
        @endforelse
   
       </tbody>
  </table>


  <h3>Task Reports</h3>
  <table class="items" width="100%" style="font-size: 14px; border-collapse: collapse;" cellpadding="8">
      <thead>
          <tr>
              <td width="5%" style="text-align: left;"><strong>Task Id</strong></td>
              <td width="20%" style="text-align: left;"><strong>Task Name</strong></td>
              <td width="10%" style="text-align: left;"><strong>Task Status</strong></td>
              <td width="10%" style="text-align: left;"><strong>Planned Task Start-date</strong></td>
              <td width="10%" style="text-align: left;"><strong>Planned Task End-date</strong></td>
              <td width="10%" style="text-align: left;"><strong>Actucal Task Start-date</strong></td>
              <td width="10%" style="text-align: left;"><strong>Actucal Task End-date</strong></td>
              <td width="10%" style="text-align: left;"><strong>Planned Task Percentage</strong></td>
              <td width="10%" style="text-align: left;"><strong>Actucal Task Percentage</strong></td>
          </tr>
      </thead>
      <tbody>
        @forelse($taskdata2 as $key => $value)
         <tr>
          <td>{{$value['id']}}</td>
           <td>{{$value['title']}}</td>
           <td>{{$value['status']}}</td>
           <td>{{$value['planed_start']}}</td>
           <td>{{$value['planed_end']}}</td>
           <td>{{$value['actual_start']}}</td>
           <td>{{$value['actual_end']}}</td>
           <td>{{$value['planned_percentage']}}</td>
           <td>{{$value['actual_percentage']}}</td>
         

         </tr>
        @empty
         <tr>
           <td colspan="10" style='text-align: center;'>No Tasks are Avialable to see</td>
         </tr>
        @endforelse
   
       </tbody>

  </table>
  <br>
  <!-- <table width="100%" style="font-family: sans-serif; font-size: 14px;" >
      <tr>
          <td>
              
              <table width="40%" align="right" style="font-family: sans-serif; font-size: 14px;" >
                  <tr>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;"><strong>Total Amount</strong></td>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;">£000.00</td>
                  </tr>
                  <tr>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;"><strong>Deposit</strong></td>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;">£000.00</td>
                  </tr>
                  <tr>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;"><strong>Commission</strong></td>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;">£000.00</td>
                  </tr>
                  <tr>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;"><strong>Remaining Balance</strong></td>
                      <td style="border: 1px #eee solid; padding: 0px 8px; line-height: 20px;">Remaining Balance</td>
                  </tr>
              </table>
          </td>
      </tr>
  </table> -->
  <br>
  <table width="100%" style="font-family: sans-serif; font-size: 14px;" >
      <br>
      <tr>
          <td>
              <!-- <table width="25%" align="left" style="font-family: sans-serif; font-size: 14px;" >
                  <tr>
                      <td style="padding: 0px; line-height: 20px;">
                          <img src="img/protected.png" alt="protected" style="display: block; margin: auto;">
                      </td>
                  </tr>
              </table> -->
              @php $country =\App\Models\Utility::getcountry_detailsonly_name($setting['company_country']);
              $state=\App\Models\Utility::getstate_detailsonly_name($setting['company_country'],$setting['company_state']);
              @endphp 
              <table width="50%" align="center" style="font-family: sans-serif; font-size: 13px; text-align: center;" >
                  <tr>
                      <td style="padding: 0px; line-height: 20px;">
                          <strong>{{$setting['company_name']}}</strong>
                          <br>
                          {{$setting['company_address']}}, {{$state}}
                          <br>
                          Tel:  {{$setting['company_telephone']}} | Email: {{$setting['company_email']}}
                          <br>
                          Company Registered in {{$country}}. Company Reg. 12121212.
                          <br>
                          VAT Registration No. 021021021 | ATOL No. 1234
                      </td>
                  </tr>
              </table>
              <!-- <table width="25%" align="right" style="font-family: sans-serif; font-size: 14px;" >
                  <tr>
                      <td style="padding: 0px; line-height: 20px;">
                          <img src="img/abtot.png" alt="abtot" style="display: block; margin: auto;">
                      </td>
                  </tr>
              </table> -->
          </td>
      </tr>
      <br>
  </table>
</body>
</html>




