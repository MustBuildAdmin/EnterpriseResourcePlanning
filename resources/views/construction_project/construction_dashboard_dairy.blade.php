@include('new_layouts.header')
<style>
.projectlifetimezone{
  display : none !important;
}
</style>
<div class="page-wrapper">
@include('construction_project.side_menu_dairy')
<?php
$delay=round($current_Planed_percentage-$actual_percentage);
if($delay<0){
  $delay=0;
}
if($delay>100){
  $delay=100;
}
?>
    <!-- Page header -->
    <div class="page-header d-print-none">
      <div class="container-fluid">
        <div class="row g-2 align-items-center">
          <div class="col-10">
            <!-- Page pre-title -->
            <div class="page-pretitle">
              Overview
            </div>
            <h2 class="page-title">
              Dashboard
            </h2>
          </div>


        </div>
      </div>
    </div>
    <!-- Page body -->
    
  </div>

@include('new_layouts.footer')
