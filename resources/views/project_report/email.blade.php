
<link rel="stylesheet" href="{{ asset('landing/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/plugins/main.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/plugins/datepicker-bs5.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/plugins/style.css') }}">
<!-- font css -->
<link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap-switch-button.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
<link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
<link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

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
$no_working_days=$no_working_days+1;// include the last day
############### END ##############################

############### Remaining days ###################
$date1=date_create($cur);
$date2=date_create($end);

$diff=date_diff($date1,$date2);
$remaining_working_days=$diff->format("%a");
$remaining_working_days=$remaining_working_days;// include the last day
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
    <section id="project">
        <div style="max-width: 1210px;margin: 0 auto;">
    <h5 class="sm">PROJECT OVERALL PROGRAM STATUS</h5>
    <div class="mb-3" style="margin: 0 5%;display: -ms-flexbox;
    display: flex;height: 1rem;overflow: hidden;font-size: .75rem;background-color: #e9ecef;border-radius: 0.25rem;">
      <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">{{$no_working_days}} Days</div>
      {{-- <div class="progress-bar bg-warning" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">15 Days</div> --}}
      <!-- <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">20%</div> -->
    </div>
   

    <div class="mb-3" style="margin: 0 5%;background-color: transparent;display: -ms-flexbox;
    display: flex;height: 1rem;overflow: hidden;font-size: .75rem;background-color: #e9ecef;border-radius: 0.25rem;">
    <div class="progress-bar" role="progressbar" style="width: 100%; background-color: blue;color: #fff;    text-align: start;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">Program Start Date ({{ date("d-m-Y", strtotime($end)) }})</div>
    {{-- <div class="progress-bar" role="progressbar" style="width: 30%; background-color: transparent;color: #000;    text-align: end;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">Rev-1 Program End Date (30-9-2021)</div> --}}
</div>


    <div class="mb-3" style="margin: 0 5%;background-color: transparent;display: -ms-flexbox;
    display: flex;height: 1rem;overflow: hidden;font-size: .75rem;background-color: #e9ecef;border-radius: 0.25rem;">
    <div class="progress-bar" role="progressbar" style="width: 100%; background-color: blue;color: #fff;    text-align: end;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">Program End Date ({{ date("d-m-Y", strtotime($end)) }})</div>
    {{-- <div class="progress-bar" role="progressbar" style="width: 30%; background-color: transparent;color: #000;    text-align: end;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">Rev-1 Program End Date (30-9-2021)</div> --}}
</div>


<div class="row">

<div class="col-md-12 b1">
            <h5 class="sm">DURATION IN NO OF DAYS</h5>
            <div class="mb-3" style="margin: 0 5%;display: -ms-flexbox; display: flex;height: 1rem;overflow: hidden;font-size: .75rem;background-color: #e9ecef;border-radius: 0.25rem;">
            <div class="bg-success" role="progressbar" style="width:100%;display: -ms-flexbox;display: flex;-ms-flex-direction: column;flex-direction: column;-ms-flex-pack: center;justify-content: center;color: #fff;
    text-align: center;white-space: nowrap;background-color: #007bff;transition: width .6s ease;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">{{$no_working_days}} Days</div>
            {{-- <div class="progress-bar bg-warning" role="progressbar" style="width: {{$remaing_percenatge}}%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">{{$remaining_working_days}}</div> --}}
            </div>
            <div class="" style="margin: 0 5%;display: -ms-flexbox;display: flex;-ms-flex-wrap: wrap;lex-wrap: wrap;">
                <div class="col-md-6 tx row right-txt" style="margin: 0 5%;align-items: center;max-width: 50%;    margin-right: 1px;
    "><div class="" style=""></div><p class="t1" style="width: 50%;margin-bottom: 0;">WORKING DAYS</p><div class="" style=""></div></div>
                <div class="col-md-6 tx row lef" style="margin: 0 5%;align-items: center;max-width: 50%;"><div class="" style=""></div><p class="t1" style="width: 50%;margin-bottom: 0;">REAMINING DAYS</p><div class=""></div></div>
                </div>
        </div>


</div>

    <hr  />
    <br/>

<div class="col-md-12 b1">
            <h5 class="sm">DURATION IN PERCENTAGE</h5>
            <div class="mb-3" style="margin: 0 5%;display: -ms-flexbox; display: flex;height: 1rem;overflow: hidden;font-size: .75rem;background-color: #e9ecef;border-radius: 0.25rem;">
            <div class="bg-success" role="progressbar" style="width:100%;display: -ms-flexbox;display: flex;-ms-flex-direction: column;flex-direction: column;-ms-flex-pack: center;justify-content: center;color: #fff;
    text-align: center;white-space: nowrap;background-color: #007bff;transition: width .6s ease;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">{{$no_working_days}} Days</div>
            {{-- <div class="progress-bar bg-warning" role="progressbar" style="width: {{$remaing_percenatge}}%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">{{$remaining_working_days}}</div> --}}
            </div>
            <div class="" style="margin: 0 5%;display: -ms-flexbox;display: flex;-ms-flex-wrap: wrap;lex-wrap: wrap;">
                <div class="col-md-6 tx row right-txt" style="margin: 0 5%;align-items: center;max-width: 50%;    margin-right: 1px;
    "><div class="" ></div><p class="t1" style="width: 50%;margin-bottom: 0;">WORKING DAYS</p><div class="" ></div></div>
                <div class="col-md-6 tx row lef" style="margin: 0 5%;align-items: center;max-width: 50%;"><div class="" ></div><p class="t1" style="width: 50%;margin-bottom: 0;">REAMINING DAYS</p><div class=""></div></div>
                </div>
        </div>
        <hr  />

        <br/>

        <div class="col-md-12 b1">
            <h5 class="sm">PLANNED PROGRESS IN PERCENTAGE</h5>
            <div class=" mb-3" style="margin: 0 5%;display: -ms-flexbox;display: flex;height: 1rem;overflow: hidden;font-size: .75rem; background-color: #e9ecef;border-radius: 0.25rem;">
                <div class="" role="progressbar" style="width: {{$current_percentage}}%;    display: -ms-flexbox;
    display: flex; -ms-flex-direction: column;flex-direction: column; -ms-flex-pack: center;justify-content: center;
    color: #fff; text-align: center; white-space: nowrap;background-color: #007bff;transition: width .6s ease;background-color: #28a745!important;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">{{$current_percentage}}%</div>
                <div class="" role="progressbar" style="width: {{$remaing_percenatge}}% ;display: -ms-flexbox;
    display: flex; -ms-flex-direction: column;flex-direction: column; -ms-flex-pack: center;justify-content: center;
    color: #fff; text-align: center; white-space: nowrap;background-color: #007bff;transition: width .6s ease;background-color: #ffc107!important;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">{{$remaing_percenatge}}%</div>
                </div>
                <div class="row" style="margin: 0 5%;">
                    <div class="col-md-6 tx row right-txt" style="align-items: center;justify-content: center;"><p class="t1" style="margin-bottom: 0;">WORKING DAYS</p></div>
                    <div class="col-md-6 tx row lef" style="align-items: center;justify-content: center;"><p class="t1" style="width: 50%;margin-bottom: 0;">REAMINING DAYS</p></div>
                    </div>
        </div>

        <br/>

  <div class="div-thre">
    <h5 class="sm">ACTUAL PROGRESS IN PERCENTAGE</h5>
    <div class="mb-3" style="margin: 0 5%;display: -ms-flexbox;
    display: flex;height: 1rem;overflow: hidden;font-size: .75rem; background-color: #e9ecef;border-radius: 0.25rem;">
    <div style="display: -ms-flexbox;
    display: flex;-ms-flex-direction: column;flex-direction: column;-ms-flex-pack: center;justify-content: center;color: #fff;
    text-align: center; white-space: nowrap;background-color: #007bff;transition: width .6s ease;" class="progress-bar bg-success" role="progressbar" style="width: {{$actual_current_progress}}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">ACTUAL PROGRESS {{$actual_current_progress}}%</div>
    @php
    $delay=0;
    @endphp
    @if(round($actual_current_progress)!=$current_percentage)
      @php 
        $delay=round($current_percentage-$actual_current_progress);
      @endphp
      <div style="width:100%;display: -ms-flexbox;
    display: flex;-ms-flex-direction: column;flex-direction: column;-ms-flex-pack: center;justify-content: center;color: #fff;
    text-align: center; white-space: nowrap;background-color: #007bff;transition: width .6s ease;" class="progress-bar bg-danger" role="progressbar" style="width: {{$delay}}%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">DELAY {{$delay}}%</div>
    @endif
    
      <div style="width:100%;display: -ms-flexbox;
    display: flex;-ms-flex-direction: column;flex-direction: column;-ms-flex-pack: center;justify-content: center;color: #fff;
    text-align: center; white-space: nowrap;background-color: #007bff;transition: width .6s ease;" class=" bg-warning" role="progressbar" style="width: {{$actual_remaining_progress-$delay}}%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">REMAINING PROGRESS {{$actual_remaining_progress-$delay}}%</div>

    <!-- <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">20%</div> -->
  </div>
<br/><br/>
</div>
</div>



</div>



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
      @if($value['percentage_as_today'] != $value['actual_percent'])
        <tr style="background-color: #dc3545;color: white;">
      @else{
        <tr> 
      }
      @endif
        <td>{{$value['title']}}</td>
        <td>{{$value['planed_start']}}</td>
        <td>{{$value['planed_end']}}</td>
        <td>{{$value['duration']}}</td>
        <td>{{$value['percentage_as_today']}}</td>
        <td>Planned Value</td>
        <td>{{$value['actual_start']}}</td>
        <td>{{$value['actual_end']}}</td>
        <td>{{$value['actual_duration']}}</td>
        <td>{{$value['actual_percent']}}</td>
        <td>Earned Value</td>
      </tr>
     @empty
      <tr>
        <td colspan="10" style='text-align: center;'>No Record</td>
      </tr>
     @endforelse

    </tbody>
  </table>
</div>
</section>
</body>
</html>