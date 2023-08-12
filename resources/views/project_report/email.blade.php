


{!! Html::style(asset('landing/css/bootstrap.min.css')) !!}

<style>

.mr-n2 {
    margin-right: -.75em !important;
  }
</style>

@php
$start = $project->start_date;
$end = $project->end_date;


$startDate = new DateTime($start);
$endDate = new DateTime($end);
$currentDate = new DateTime();

$date1 = strtotime($start);
$date2 = strtotime($end);
$cur= date('Y-m-d');


$current = strtotime($cur);
############### days finding ################
$date1=date_create($start);
$date2=date_create($end);

$diff=date_diff($date1,$date2);
$no_working_days=$diff->format("%a");
// $no_working_days=$no_working_days;// include the last day
############### END ##############################

############### Remaining days ###################
$date1=date_create($cur);
$date2=date_create($end);

$diff=date_diff($date1,$date2);
$remaining_working_days=$diff->format("%a");
// $remaining_working_days=$remaining_working_days;// include the last day
############### Remaining days ##################

$completed_days=$no_working_days-$remaining_working_days;

// percentage calculator
$perday=100/$no_working_days;

// $date1=date_create($start);
// $date2=date_create($cur);

// $diff=date_diff($date1,$date2);
// $no_days_completed=$diff->format("%a");
// $no_days_completed=$no_days_completed+1;
$current_percentage=round($completed_days*$perday);
$remaing_percenatge=round(100-$current_percentage);



// percentage caluclator end



// $totalTime = $endDate->getTimestamp() - $startDate->getTimestamp();
// $elapsedTime = $currentDate->getTimestamp() - $startDate->getTimestamp();
// echo "Total project time = " . $totalTime . "<br/>";
// echo "Elapsed project time = " . $elapsedTime  . "<br/>";
// $current_percentage=round(($elapsedTime / $totalTime) * 100.0);
// $remaing_percenatge=round(100-$current_percentage);

@endphp

<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"> --}}
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0"/>
<style>
.bg-warning {
    background-color: #ffc107!important;
}
.bg-danger{
  background-color: #ff0b0b!important;
}
.page-break {
    page-break-after: always;
}

.container {
    max-width: inherit !important;
}
    .mr-n2 {
  margin-right: -.75em !important;
}
.tx {
    text-align: center;
}
.line{
    width: 25%;
    height: 1px;
    background: #000;
}
p.t1{
font-size: 14px;
}
.right-txt {
    margin-right: 1px;
    border-right: 1px solid;
}
.lef {
    margin-left: 1px;
}
h5.sm {
    font-size: 14px;
}
.two-div {
    margin-bottom: 5%;
}
.row {
    margin-left: -7px!important;
}
</style>
</head>
<body>

<h3 style="
    text-align: center;
    padding: 2px 2px;
    ">{{$project->project_name}} - {{date('Y-m-d h:i A')}}</h3>


<h3 style="
text-align: center;
padding: 2px 2px;
background-color: #cfcfcf;
"> Main Task List</h3>
<table class="table">
    <thead class="thead-dark">
      <tr>
        <th scope="col">Title</th>
        <th scope="col">Planned Start Date</th>
        <th scope="col">Planned Finish</th>
        <th scope="col">Duration</th>
        <th scope="col">Planned % as of today</th>
        <th scope="col">Planned Value</th>
        <th scope="col">Actual Start Date</th>
        <th scope="col">Actual Finish</th>
        <th scope="col">Actual Duration</th>
        <th scope="col">Actual % as of Today</th>
        <th scope="col">Earned Value</th>
      </tr>
    </thead>
    <tbody>
     @forelse($taskdata as $key => $value)
      @if( $value['actual_percent'] < $value['percentage_as_today'])
        <tr style="background-color: #dc3545;color: white;">
      @else
        <tr>
      @endif
        <td>{{$value['title']}}</td>
        <td>{{$value['planed_start']}}</td>
        <td>{{$value['planed_end']}}</td>
        <td>{{$value['duration']}}</td>
        <td>{{$value['percentage_as_today']}}%</td>
        <td>Planned Value</td>
        <td>{{$value['actual_start']}}</td>
        <td>{{$value['actual_end']}}</td>
        <td>{{$value['actual_duration']}}</td>
        <td>{{$value['actual_percent']}}%</td>
        <td>Earned Value</td>
      </tr>
     @empty
      <tr>
        <td colspan="10" style='text-align: center;'>No Record</td>
      </tr>
     @endforelse

    </tbody>
  </table>
  <div class="page-break"></div>
  <h3 style="
text-align: center;
padding: 2px 2px;
background-color: #cfcfcf;
"> Today Updated Task List</h3>
<table class="table">
    <thead class="thead-dark">
      <tr>
        <th scope="col">Title</th>
        <th scope="col">Planned Start Date</th>
        <th scope="col">Planned Finish</th>
        <th scope="col">Duration</th>
        <th scope="col">Percentage</th>
        <th scope="col">Progress Updated Date</th>
        <th scope="col">Description</th>
        <th scope="col">User Name</th>
        <th scope="col">user Email</th>
      </tr>
    </thead>
    <tbody>
     @forelse($taskdata2 as $key => $value)
      <tr>
        <td>{{$value['title']}}</td>
        <td>{{$value['planed_start']}}</td>
        <td>{{$value['planed_end']}}</td>
        <td>{{$value['duration']}}</td>
        <td>{{$value['percentage']}}</td>
        <td>{{$value['progress_updated_date']}}</td>
        <td>{{$value['description']}}</td>
        <td>{{$value['user']}}</td>
        <td>{{$value['email']}}</td>
      </tr>
     @empty
      <tr>
        <td colspan="10" style='text-align: center;'>No Record</td>
      </tr>
     @endforelse

    </tbody>
  </table>

</section>
</body>
</html>


