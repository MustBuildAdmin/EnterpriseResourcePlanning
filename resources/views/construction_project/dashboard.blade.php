@include('new_layouts.header')
@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
    <link rel='stylesheet' href='https://unicons.iconscout.com/release/v3.0.6/css/line.css'

<div class="page-wrapper dashboard">
@include('construction_project.side-menu',['hrm_header' => "Project Dashboard"])



<div class="form-popup1-bg popupnew">
  <div class="form-container">
    <button id="btnCloseForm" class="close-button">X</button>
    <h1>Add Member</h1>
    <div class="modal-body">
  <div class="row">
    <div class="col-6 mb-4">
      <div class="list-group-item px-0">
        <div class="row ">
          <div class="col-auto">
            <img src="https://demo.rajodiya.com/erpgo/storage/uploads/avatar/user-11.jpg" class="wid-40 rounded-circle ml-3" alt="avatar image">
          </div>
          <div class="col">
            <h6 class="mb-0">Protiong</h6>
            <p class="mb-0">
              <span class="text-success">protiong@teleworm.us</span>
            </p>
          </div>
          <div class="col-auto">
            <div class="action-btn bg-info ms-2 invite_usr" data-id="25">
              <button type="button" class="mx-3 btn btn-sm  align-items-center">
                <span class="btn-inner--visible">
                  <i class="ti ti-plus text-white" id="usr_icon_25"></i>
                </span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="col-6 mb-4">
      <div class="list-group-item px-0">
        <div class="row ">
          <div class="col-auto">
            <img src="https://demo.rajodiya.com/erpgo/storage/uploads/avatar/user-11.jpg" class="wid-40 rounded-circle ml-3" alt="avatar image">
          </div>
          <div class="col">
            <h6 class="mb-0">Protiong</h6>
            <p class="mb-0">
              <span class="text-success">protiong@teleworm.us</span>
            </p>
          </div>
          <div class="col-auto">
            <div class="action-btn bg-info ms-2 invite_usr" data-id="25">
              <button type="button" class="mx-3 btn btn-sm  align-items-center">
                <span class="btn-inner--visible">
                  <i class="ti ti-plus text-white" id="usr_icon_25"></i>
                </span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>



  </div>
  <input id="project_id" name="project_id" type="hidden" value="15">
</div>
  </div>
</div>




<div class="form-popup-bg popupnew">
  <div class="form-container">
    <button id="btnCloseForm" class="close-button">X</button>
    <h1>Create MileStone</h1>
  
    <div class="modal-body">
  <div class="row">
    <div class="form-group col-md-6">
      <label for="title" class="form-label">Title</label>
      <input class="form-control" required="required" name="title" type="text" id="title">
    </div>
    <div class="form-group  col-md-6">
      <label for="status" class="form-label">Status</label>
      <select class="form-control select" required="required" id="status" name="status">
        <option value="in_progress">In Progress</option>
        <option value="on_hold">On Hold</option>
        <option value="complete">Complete</option>
        <option value="canceled">Canceled</option>
      </select>
    </div>
    <div class="form-group  col-md-6">
      <label for="start_date" class="col-form-label">Start Date</label>
      <input class="form-control" required="required" name="start_date" type="date" value="" id="start_date">
    </div>
    <div class="form-group  col-md-6">
      <label for="due_date" class="col-form-label">Due Date</label>
      <input class="form-control" required="required" name="due_date" type="date" value="" id="due_date">
    </div>
    <div class="form-group  col-md-6">
      <label for="cost" class="col-form-label">Cost</label>
      <input class="form-control" required="required" stage="0.01" name="cost" type="number" value="" id="cost">
    </div>
  </div>
  <div class="row">
    <div class="form-group  col-md-12">
      <label for="description" class="form-label">Description</label>
      <textarea class="form-control" rows="2" name="description" cols="50" id="description"></textarea>
    </div>
  </div>
<br/>
  <div class="modal-footer">
    <input type="button" value="Cancel" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="Create" class="btn  btn-primary">
</div>
</div>
  </div>
</div>

<section id="wrapper">

  <div class="p-4">

    <section class="statistics">
      <div class="row">
        <div class="col-lg-4 bgwhite">
          <div class="box d-flex rounded-2 align-items-center mb-4 mb-lg-0 p-3">
            <i class="uil-list-ul fs-2 text-center green rounded-circle"></i>
            <div class="ms-3">
              <div class="d-flex align-items-center">
                 <span class="d-block">Total Task</span>
              </div>
              <p class="fs-normal mb-0">0</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 bgwhite">
          <div class="box d-flex rounded-2 align-items-center mb-4 mb-lg-0 p-3">
            <i class="uil-dollar-alt fs-2 text-center green rounded-circle"></i>
            <div class="ms-3">
              <div class="d-flex align-items-center">
                 <span class="d-block">Total Budget</span>
              </div>
              <p class="fs-normal mb-0">$61.00</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 bgwhite">
          <div class="box d-flex rounded-2 align-items-center p-3">
            <i class="uil-dollar-alt fs-2 text-center green rounded-circle"></i>
            <div class="ms-3">
              <div class="d-flex align-items-center">
                <span class="d-block">Total Expense</span>
              </div>
              <p class="fs-normal mb-0">$0.00</p>
            </div>
          </div>
        </div>
      </div>
    </section>
<br/>



   <section class="statistics">
      <div class="row">
        <div class="col-lg-4 bgwhite">

        <div class="card">
  <div class="card-body">
    <div class="d-flex align-items-center">
      <div class="avatar me-3">
        <img avatar="India" zimmerman="" alt="" class="img-user wid-45 rounded-circle">
      </div>
      <div class="d-block  align-items-center justify-content-between w-100">
        <div class="mb-3 mb-sm-0">
          <h5 class="mb-1"> India Zimmerman</h5>
          <p class="mb-0 text-sm"></p>
          <div class="progress-wrapper">
            <span class="progress-percentage">
              <small class="font-weight-bold">Completed: : </small>0% </span>
            <div class="progress progress-xs mt-2">
              <div class="progress-bar bg-info" role="progressbar" aria-valuenow="0%" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
            </div>
          </div>
          <p></p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-10">
        <h4 class="mt-3 mb-1"></h4>
        <p> Ex quidem aliquam vo</p>
      </div>
    </div>
    <div class="card bg-primary mb-0">
      <div class="card-body">
        <div class="d-block d-sm-flex align-items-center justify-content-between">
          <div class="row align-items-center">
            <span class="text-white text-sm">Start Date</span>
            <h5 class="text-white text-nowrap">11 Sep 1992</h5>
          </div>
          <div class="row align-items-center">
            <span class="text-white text-sm">End Date</span>
            <h5 class="text-white text-nowrap">18 Oct 2011</h5>
          </div>
        </div>
        <div class="row">
          <span class="text-white text-sm">Client</span>
          <h5 class="text-white text-nowrap">Jennifer Ellison</h5>
        </div>
      </div>
    </div>
  </div>
</div>



        </div>
        <div class="col-lg-4 bgwhite">
        <div class="card">
  <div class="card-body">
    <div class="d-flex align-items-start">
      <div class="theme-avtar bg-primary">
        <i class="ti ti-clipboard-list"></i>
      </div>
      <div class="ms-3">
        <p class="text-muted mb-0">Last 7 days task done</p>
        <h4 class="mb-0">0</h4>
      </div>
    </div>
    <div id="task_chart" style="min-height: 60px;">
      <div id="apexchartsgaxjvahu" class="apexcharts-canvas apexchartsgaxjvahu apexcharts-theme-light" style="width: 279px; height: 60px;">
        <svg id="SvgjsSvg1047" width="279" height="60" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;">
          <g id="SvgjsG1049" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)">
            <defs id="SvgjsDefs1048">
              <clipPath id="gridRectMaskgaxjvahu">
                <rect id="SvgjsRect1054" width="285" height="62" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
              </clipPath>
              <clipPath id="forecastMaskgaxjvahu"></clipPath>
              <clipPath id="nonForecastMaskgaxjvahu"></clipPath>
              <clipPath id="gridRectMarkerMaskgaxjvahu">
                <rect id="SvgjsRect1055" width="283" height="64" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
              </clipPath>
              <linearGradient id="SvgjsLinearGradient1060" x1="0" y1="0" x2="0" y2="1">
                <stop id="SvgjsStop1061" stop-opacity="0.65" stop-color="rgba(255,162,29,0.65)" offset="0"></stop>
                <stop id="SvgjsStop1062" stop-opacity="0.5" stop-color="rgba(255,209,142,0.5)" offset="1"></stop>
                <stop id="SvgjsStop1063" stop-opacity="0.5" stop-color="rgba(255,209,142,0.5)" offset="1"></stop>
              </linearGradient>
            </defs>
            <line id="SvgjsLine1053" x1="45.99999999999999" y1="0" x2="45.99999999999999" y2="60" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs" x="45.99999999999999" y="0" width="1" height="60" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line>
            <g id="SvgjsG1066" class="apexcharts-xaxis" transform="translate(0, 0)">
              <g id="SvgjsG1067" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g>
            </g>
            <g id="SvgjsG1076" class="apexcharts-grid">
              <g id="SvgjsG1077" class="apexcharts-gridlines-horizontal" style="display: none;">
                <line id="SvgjsLine1079" x1="0" y1="0" x2="279" y2="0" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                <line id="SvgjsLine1080" x1="0" y1="12" x2="279" y2="12" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                <line id="SvgjsLine1081" x1="0" y1="24" x2="279" y2="24" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                <line id="SvgjsLine1082" x1="0" y1="36" x2="279" y2="36" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                <line id="SvgjsLine1083" x1="0" y1="48" x2="279" y2="48" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                <line id="SvgjsLine1084" x1="0" y1="60" x2="279" y2="60" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
              </g>
              <g id="SvgjsG1078" class="apexcharts-gridlines-vertical" style="display: none;"></g>
              <line id="SvgjsLine1086" x1="0" y1="60" x2="279" y2="60" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line>
              <line id="SvgjsLine1085" x1="0" y1="1" x2="0" y2="60" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line>
            </g>
            <g id="SvgjsG1056" class="apexcharts-area-series apexcharts-plot-series">
              <g id="SvgjsG1057" class="apexcharts-series" seriesName="Bandwidth" data:longestSeries="true" rel="1" data:realIndex="0">
                <path id="SvgjsPath1064" d="M0 60L0 60C16.274999999999995 60 30.224999999999998 60 46.49999999999999 60C62.77499999999999 60 76.725 60 92.99999999999999 60C109.27499999999999 60 123.225 60 139.5 60C155.77499999999998 60 169.725 60 185.99999999999997 60C202.27499999999998 60 216.22499999999997 60 232.49999999999997 60C248.77499999999998 60 262.72499999999997 60 279 60C279 60 279 60 279 60M279 60C279 60 279 60 279 60 " fill="url(#SvgjsLinearGradient1060)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaskgaxjvahu)" pathTo="M 0 60L 0 60C 16.274999999999995 60 30.224999999999998 60 46.49999999999999 60C 62.77499999999999 60 76.725 60 92.99999999999999 60C 109.27499999999999 60 123.225 60 139.5 60C 155.77499999999998 60 169.725 60 185.99999999999997 60C 202.27499999999998 60 216.22499999999997 60 232.49999999999997 60C 248.77499999999998 60 262.72499999999997 60 279 60C 279 60 279 60 279 60M 279 60z" pathFrom="M -1 60L -1 60L 46.49999999999999 60L 92.99999999999999 60L 139.5 60L 185.99999999999997 60L 232.49999999999997 60L 279 60"></path>
                <path id="SvgjsPath1065" d="M0 60C16.274999999999995 60 30.224999999999998 60 46.49999999999999 60C62.77499999999999 60 76.725 60 92.99999999999999 60C109.27499999999999 60 123.225 60 139.5 60C155.77499999999998 60 169.725 60 185.99999999999997 60C202.27499999999998 60 216.22499999999997 60 232.49999999999997 60C248.77499999999998 60 262.72499999999997 60 279 60C279 60 279 60 279 60 " fill="none" fill-opacity="1" stroke="#ffa21d" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMaskgaxjvahu)" pathTo="M 0 60C 16.274999999999995 60 30.224999999999998 60 46.49999999999999 60C 62.77499999999999 60 76.725 60 92.99999999999999 60C 109.27499999999999 60 123.225 60 139.5 60C 155.77499999999998 60 169.725 60 185.99999999999997 60C 202.27499999999998 60 216.22499999999997 60 232.49999999999997 60C 248.77499999999998 60 262.72499999999997 60 279 60" pathFrom="M -1 60L -1 60L 46.49999999999999 60L 92.99999999999999 60L 139.5 60L 185.99999999999997 60L 232.49999999999997 60L 279 60"></path>
                <g id="SvgjsG1058" class="apexcharts-series-markers-wrap" data:realIndex="0">
                  <g class="apexcharts-series-markers">
                    <circle id="SvgjsCircle1092" r="0" cx="46.49999999999999" cy="60" class="apexcharts-marker wx512ene6 no-pointer-events" stroke="#ffffff" fill="#ffa21d" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle>
                  </g>
                </g>
              </g>
              <g id="SvgjsG1059" class="apexcharts-datalabels" data:realIndex="0"></g>
            </g>
            <line id="SvgjsLine1087" x1="0" y1="0" x2="279" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line>
            <line id="SvgjsLine1088" x1="0" y1="0" x2="279" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line>
            <g id="SvgjsG1089" class="apexcharts-yaxis-annotations"></g>
            <g id="SvgjsG1090" class="apexcharts-xaxis-annotations"></g>
            <g id="SvgjsG1091" class="apexcharts-point-annotations"></g>
          </g>
          <rect id="SvgjsRect1052" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect>
          <g id="SvgjsG1075" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g>
          <g id="SvgjsG1050" class="apexcharts-annotations"></g>
        </svg>
        <div class="apexcharts-legend" style="max-height: 30px;"></div>
        <div class="apexcharts-tooltip apexcharts-theme-light" style="left: 57.5px; top: 25px;">
          <div class="apexcharts-tooltip-series-group apexcharts-active" style="order: 1; display: flex;">
            <span class="apexcharts-tooltip-marker" style="background-color: rgb(255, 162, 29); display: none;"></span>
            <div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
              <div class="apexcharts-tooltip-y-group">
                <span class="apexcharts-tooltip-text-y-label"></span>
                <span class="apexcharts-tooltip-text-y-value">0</span>
              </div>
              <div class="apexcharts-tooltip-goals-group">
                <span class="apexcharts-tooltip-text-goals-label"></span>
                <span class="apexcharts-tooltip-text-goals-value"></span>
              </div>
              <div class="apexcharts-tooltip-z-group">
                <span class="apexcharts-tooltip-text-z-label"></span>
                <span class="apexcharts-tooltip-text-z-value"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light">
          <div class="apexcharts-yaxistooltip-text"></div>
        </div>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="d-flex align-items-center justify-content-between mb-2">
      <div class="d-flex align-items-center">
        <span class="text-muted">Day Left</span>
      </div>
      <span>11,183/6,976</span>
    </div>
    <div class="progress mb-3">
      <div class="progress-bar bg-primary" style="width: 160%"></div>
    </div>
    <div class="d-flex align-items-center justify-content-between mb-2">
      <div class="d-flex align-items-center">
        <span class="text-muted">Open Task</span>
      </div>
      <span>3/3</span>
    </div>
    <div class="progress mb-3">
      <div class="progress-bar bg-primary" style="width: 100%"></div>
    </div>
    <div class="d-flex align-items-center justify-content-between mb-2">
      <div class="d-flex align-items-center">
        <span class="text-muted">Completed Milestone</span>
      </div>
      <span>1/1</span>
    </div>
    <div class="progress mb-3">
      <div class="progress-bar bg-primary" style="width: 100%"></div>
    </div>
  </div>
</div>


        </div>
        <div class="col-lg-4 bgwhite">
        <div class="card">
  <div class="card-body">
    <div class="d-flex align-items-start">
      <div class="theme-avtar bg-primary">
        <i class="ti ti-clipboard-list"></i>
      </div>
      <div class="ms-3">
        <p class="text-muted mb-0">Last 7 days hours spent</p>
        <h4 class="mb-0">0</h4>
      </div>
    </div>
    <div id="timesheet_chart" style="min-height: 60px;">
      <div id="apexchartslaucqv3h" class="apexcharts-canvas apexchartslaucqv3h apexcharts-theme-light" style="width: 279px; height: 60px;">
        <svg id="SvgjsSvg1001" width="279" height="60" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;">
          <g id="SvgjsG1003" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)">
            <defs id="SvgjsDefs1002">
              <clipPath id="gridRectMasklaucqv3h">
                <rect id="SvgjsRect1008" width="285" height="62" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
              </clipPath>
              <clipPath id="forecastMasklaucqv3h"></clipPath>
              <clipPath id="nonForecastMasklaucqv3h"></clipPath>
              <clipPath id="gridRectMarkerMasklaucqv3h">
                <rect id="SvgjsRect1009" width="283" height="64" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
              </clipPath>
              <linearGradient id="SvgjsLinearGradient1014" x1="0" y1="0" x2="0" y2="1">
                <stop id="SvgjsStop1015" stop-opacity="0.65" stop-color="rgba(255,162,29,0.65)" offset="0"></stop>
                <stop id="SvgjsStop1016" stop-opacity="0.5" stop-color="rgba(255,209,142,0.5)" offset="1"></stop>
                <stop id="SvgjsStop1017" stop-opacity="0.5" stop-color="rgba(255,209,142,0.5)" offset="1"></stop>
              </linearGradient>
            </defs>
            <line id="SvgjsLine1007" x1="45.99999999999999" y1="0" x2="45.99999999999999" y2="60" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs apexcharts-active" x="45.99999999999999" y="0" width="1" height="60" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line>
            <g id="SvgjsG1020" class="apexcharts-xaxis" transform="translate(0, 0)">
              <g id="SvgjsG1021" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g>
            </g>
            <g id="SvgjsG1030" class="apexcharts-grid">
              <g id="SvgjsG1031" class="apexcharts-gridlines-horizontal" style="display: none;">
                <line id="SvgjsLine1033" x1="0" y1="0" x2="279" y2="0" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                <line id="SvgjsLine1034" x1="0" y1="12" x2="279" y2="12" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                <line id="SvgjsLine1035" x1="0" y1="24" x2="279" y2="24" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                <line id="SvgjsLine1036" x1="0" y1="36" x2="279" y2="36" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                <line id="SvgjsLine1037" x1="0" y1="48" x2="279" y2="48" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
                <line id="SvgjsLine1038" x1="0" y1="60" x2="279" y2="60" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line>
              </g>
              <g id="SvgjsG1032" class="apexcharts-gridlines-vertical" style="display: none;"></g>
              <line id="SvgjsLine1040" x1="0" y1="60" x2="279" y2="60" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line>
              <line id="SvgjsLine1039" x1="0" y1="1" x2="0" y2="60" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line>
            </g>
            <g id="SvgjsG1010" class="apexcharts-area-series apexcharts-plot-series">
              <g id="SvgjsG1011" class="apexcharts-series" seriesName="Bandwidth" data:longestSeries="true" rel="1" data:realIndex="0">
                <path id="SvgjsPath1018" d="M0 60L0 60C16.274999999999995 60 30.224999999999998 60 46.49999999999999 60C62.77499999999999 60 76.725 60 92.99999999999999 60C109.27499999999999 60 123.225 60 139.5 60C155.77499999999998 60 169.725 60 185.99999999999997 60C202.27499999999998 60 216.22499999999997 60 232.49999999999997 60C248.77499999999998 60 262.72499999999997 60 279 60C279 60 279 60 279 60M279 60C279 60 279 60 279 60 " fill="url(#SvgjsLinearGradient1014)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMasklaucqv3h)" pathTo="M 0 60L 0 60C 16.274999999999995 60 30.224999999999998 60 46.49999999999999 60C 62.77499999999999 60 76.725 60 92.99999999999999 60C 109.27499999999999 60 123.225 60 139.5 60C 155.77499999999998 60 169.725 60 185.99999999999997 60C 202.27499999999998 60 216.22499999999997 60 232.49999999999997 60C 248.77499999999998 60 262.72499999999997 60 279 60C 279 60 279 60 279 60M 279 60z" pathFrom="M -1 60L -1 60L 46.49999999999999 60L 92.99999999999999 60L 139.5 60L 185.99999999999997 60L 232.49999999999997 60L 279 60"></path>
                <path id="SvgjsPath1019" d="M0 60C16.274999999999995 60 30.224999999999998 60 46.49999999999999 60C62.77499999999999 60 76.725 60 92.99999999999999 60C109.27499999999999 60 123.225 60 139.5 60C155.77499999999998 60 169.725 60 185.99999999999997 60C202.27499999999998 60 216.22499999999997 60 232.49999999999997 60C248.77499999999998 60 262.72499999999997 60 279 60C279 60 279 60 279 60 " fill="none" fill-opacity="1" stroke="#ffa21d" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMasklaucqv3h)" pathTo="M 0 60C 16.274999999999995 60 30.224999999999998 60 46.49999999999999 60C 62.77499999999999 60 76.725 60 92.99999999999999 60C 109.27499999999999 60 123.225 60 139.5 60C 155.77499999999998 60 169.725 60 185.99999999999997 60C 202.27499999999998 60 216.22499999999997 60 232.49999999999997 60C 248.77499999999998 60 262.72499999999997 60 279 60" pathFrom="M -1 60L -1 60L 46.49999999999999 60L 92.99999999999999 60L 139.5 60L 185.99999999999997 60L 232.49999999999997 60L 279 60"></path>
                <g id="SvgjsG1012" class="apexcharts-series-markers-wrap" data:realIndex="0">
                  <g class="apexcharts-series-markers">
                    <circle id="SvgjsCircle1046" r="6" cx="46.49999999999999" cy="60" class="apexcharts-marker wl7e9c82pj no-pointer-events" stroke="#ffffff" fill="#ffa21d" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle>
                  </g>
                </g>
              </g>
              <g id="SvgjsG1013" class="apexcharts-datalabels" data:realIndex="0"></g>
            </g>
            <line id="SvgjsLine1041" x1="0" y1="0" x2="279" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line>
            <line id="SvgjsLine1042" x1="0" y1="0" x2="279" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line>
            <g id="SvgjsG1043" class="apexcharts-yaxis-annotations"></g>
            <g id="SvgjsG1044" class="apexcharts-xaxis-annotations"></g>
            <g id="SvgjsG1045" class="apexcharts-point-annotations"></g>
          </g>
          <rect id="SvgjsRect1006" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect>
          <g id="SvgjsG1029" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g>
          <g id="SvgjsG1004" class="apexcharts-annotations"></g>
        </svg>
        <div class="apexcharts-legend" style="max-height: 30px;"></div>
        <div class="apexcharts-tooltip apexcharts-theme-light apexcharts-active" style="left: 57.5px; top: 25px;">
          <div class="apexcharts-tooltip-series-group apexcharts-active" style="order: 1; display: flex;">
            <span class="apexcharts-tooltip-marker" style="background-color: rgb(255, 162, 29); display: none;"></span>
            <div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
              <div class="apexcharts-tooltip-y-group">
                <span class="apexcharts-tooltip-text-y-label"></span>
                <span class="apexcharts-tooltip-text-y-value">0</span>
              </div>
              <div class="apexcharts-tooltip-goals-group">
                <span class="apexcharts-tooltip-text-goals-label"></span>
                <span class="apexcharts-tooltip-text-goals-value"></span>
              </div>
              <div class="apexcharts-tooltip-z-group">
                <span class="apexcharts-tooltip-text-z-label"></span>
                <span class="apexcharts-tooltip-text-z-value"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light">
          <div class="apexcharts-yaxistooltip-text"></div>
        </div>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="d-flex align-items-center justify-content-between mb-2">
      <div class="d-flex align-items-center">
        <span class="text-muted">Total project time spent</span>
      </div>
      <span>7/7</span>
    </div>
    <div class="progress mb-3">
      <div class="progress-bar bg-primary" style="width: 94%"></div>
    </div>
    <div class="d-flex align-items-center justify-content-between mb-2">
      <div class="d-flex align-items-center">
        <span class="text-muted">Allocated hours on task</span>
      </div>
      <span>52/52</span>
    </div>
    <div class="progress mb-3">
      <div class="progress-bar bg-primary" style="width: 100%"></div>
    </div>
    <div class="d-flex align-items-center justify-content-between mb-2">
      <div class="d-flex align-items-center">
        <span class="text-muted">User Assigned</span>
      </div>
      <span>13/13</span>
    </div>
    <div class="progress mb-3">
      <div class="progress-bar bg-primary" style="width: 100%"></div>
    </div>
  </div>
</div>
        </div>
      </div>
    </section>


   <section class="statis  text-center main2">
      <div class="row">
        <div class="col-md-6 col-lg-6 mb-6 mb-lg-0">
        <div class="card">
  <div class="card-header">
    <div class="headingnew align-items-center justify-content-between">
      <h5>Members</h5>
      <div class="float-end">
        <a href="#" id="btnOpenForm2" data-size="lg" data-url="https://demo.rajodiya.com/erpgo/invite-project-member/15" data-ajax-popup="true" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary" data-bs-original-title="Add Member">
          <i class="ti ti-plus"></i>
        </a>
      </div>
    </div>
  </div>
  <div class="card-body">
    <ul class="list-group list-group-flush list" id="project_users">
      <li class="list-group-item px-0">
        <div class="row align-items-center justify-content-between">
          <div class="col-sm-auto mb-3 mb-sm-0">
            <div class="d-flex align-items-center">
              <div class="avatar rounded-circle avatar-sm me-3">
                <img src="https://demo.rajodiya.com/erpgo/storage/uploads/avatar/avatar.png" alt="image">
              </div>
              <div class="div">
                <h5 class="m-0">Rajodiya Infotech</h5>
                <small class="text-muted">company@example.com</small>
              </div>
            </div>
          </div>
          <div class="col-sm-auto text-sm-end d-flex align-items-center">
            <div class="action-btn bg-danger ms-2">
              <form method="POST" action="https://demo.rajodiya.com/erpgo/projects/15/users/2" accept-charset="UTF-8">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="6k6CGJOh1AayZ0U4JmRQHbEOg2zlEPDBLuXycSoH">
                <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="Delete">
                  <i class="ti ti-trash text-white"></i>
                </a>
              </form>
            </div>
          </div>
        </div>
      </li>
      <li class="list-group-item px-0">
        <div class="row align-items-center justify-content-between">
          <div class="col-sm-auto mb-3 mb-sm-0">
            <div class="d-flex align-items-center">
              <div class="avatar rounded-circle avatar-sm me-3">
                <img src="https://demo.rajodiya.com/erpgo/storage/uploads/avatar/user-4.jpg" alt="image">
              </div>
              <div class="div">
                <h5 class="m-0">Mick Aston</h5>
                <small class="text-muted">accountant@example.com</small>
              </div>
            </div>
          </div>
          <div class="col-sm-auto text-sm-end d-flex align-items-center">
            <div class="action-btn bg-danger ms-2">
              <form method="POST" action="https://demo.rajodiya.com/erpgo/projects/15/users/3" accept-charset="UTF-8">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="6k6CGJOh1AayZ0U4JmRQHbEOg2zlEPDBLuXycSoH">
                <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="Delete">
                  <i class="ti ti-trash text-white"></i>
                </a>
              </form>
            </div>
          </div>
        </div>
      </li>
    </ul>
  </div>
</div>
        </div>
        <div class="col-md-6 col-lg-6 mb-6 mb-lg-0">
        <div class="card">
  <div class="card-header">
    <div class="headingnew align-items-center justify-content-between">
      <h5>Milestones (1)</h5>
      <div class="float-end">
        <a href="#" id="btnOpenForm" data-size="md" data-url="https://demo.rajodiya.com/erpgo/projects/15/milestone" data-ajax-popup="true" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary" data-bs-original-title="Create New Milestone">
          <i class="ti ti-plus"></i>
        </a>
      </div>
    </div>
  </div>
  <div class="card-body">
    <ul class="list-group list-group-flush">
      <li class="list-group-item px-0">
        <div class="row align-items-center justify-content-between">
          <div class="col-sm-auto mb-3 mb-sm-0">
            <div class="d-flex align-items-center">
              <div class="div">
                <h6 class="m-0">milestone1 <span class="badge-xs badge bg-success p-2 px-3 rounded">Complete</span>
                </h6>
                <small class="text-muted">3 Tasks</small>
              </div>
            </div>
          </div>
          <div class="col-sm-auto text-sm-end d-flex align-items-center">
            <div class="action-btn bg-warning ms-2">
              <a href="#" data-size="md" data-url="https://demo.rajodiya.com/erpgo/projects/milestone/10/show" data-ajax-popup="true" data-bs-toggle="tooltip" title="" class="btn btn-sm" data-bs-original-title="View">
                <i class="ti ti-eye text-white"></i>
              </a>
            </div>
            <div class="action-btn bg-info ms-2">
              <a href="#" data-size="md" data-url="https://demo.rajodiya.com/erpgo/projects/milestone/10/edit" data-ajax-popup="true" data-bs-toggle="tooltip" title="" class="btn btn-sm" data-bs-original-title="Edit">
                <i class="ti ti-pencil text-white"></i>
              </a>
            </div>
            <div class="action-btn bg-danger ms-2">
              <form method="POST" action="https://demo.rajodiya.com/erpgo/projects/milestone/10" accept-charset="UTF-8">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="6k6CGJOh1AayZ0U4JmRQHbEOg2zlEPDBLuXycSoH">
                <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="" data-bs-original-title="Delete" aria-label="Delete">
                  <i class="ti ti-trash text-white"></i>
                </a>
              </form>
            </div>
          </div>
        </div>
      </li>
    </ul>
  </div>
</div>
        </div>
        <div class="col-md-6 col-lg-6 mb-6 mb-md-0">
        <div class="card activity-scroll">
  <div class="card-header">
    <h5>Activity Log</h5>
    <small>Activity Log of this project</small>
  </div>
  <div class="card-body vertical-scroll-cards">
    <div class="card p-2 mb-2">
      <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
          <div class="theme-avtar bg-primary">
            <i class="ti ti-ti-plus"></i>
          </div>
          <div class="ms-3">
            <h6 class="mb-0">Create Task</h6>
            <p class="text-muted text-sm mb-0">Rajodiya Infotech Create new Task <b>Tanisha Dixon</b>
            </p>
          </div>
        </div>
        <p class="text-muted text-sm mb-0">2 weeks ago</p>
      </div>
    </div>
    <div class="card p-2 mb-2">
      <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
          <div class="theme-avtar bg-primary">
            <i class="ti ti-ti-plus"></i>
          </div>
          <div class="ms-3">
            <h6 class="mb-0">Create Task</h6>
            <p class="text-muted text-sm mb-0">Rajodiya Infotech Create new Task <b>Aquila Ferrell</b>
            </p>
          </div>
        </div>
        <p class="text-muted text-sm mb-0">2 weeks ago</p>
      </div>
    </div>
    <div class="card p-2 mb-2">
      <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
          <div class="theme-avtar bg-primary">
            <i class="ti ti-ti-plus"></i>
          </div>
          <div class="ms-3">
            <h6 class="mb-0">Create Task</h6>
            <p class="text-muted text-sm mb-0">Rajodiya Infotech Create new Task <b>test</b>
            </p>
          </div>
        </div>
        <p class="text-muted text-sm mb-0">2 weeks ago</p>
      </div>
    </div>
    <div class="card p-2 mb-2">
      <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
          <div class="theme-avtar bg-primary">
            <i class="ti ti-ti-subtask"></i>
          </div>
          <div class="ms-3">
            <h6 class="mb-0">Create Milestone</h6>
            <p class="text-muted text-sm mb-0">Rajodiya Infotech Create new milestone <b>milestone1</b>
            </p>
          </div>
        </div>
        <p class="text-muted text-sm mb-0">2 weeks ago</p>
      </div>
    </div>
  </div>
</div>
        
        </div>
        <div class="col-md-6 col-lg-6">
        <div class="card activity-scroll">
                <div class="card-header">
                    <h5>Attachments</h5>
                    <small>Attachment that uploaded in this project</small>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                                                    <div class="py-5">
                                <h6 class="h6 text-center">No Attachments Found.</h6>
                            </div>
                                            </ul>

                </div>
            </div>
        </div>
      </div>
    </section>
    



  </div>
</section>  






                </div>
            </div>
        </div>
    </div>
@include('new_layouts.footer')

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>

<script>
function closeForm() {
  $('.form-popup-bg').removeClass('is-visible');

  $('.form-popup1-bg').removeClass('is-visible');
}

$(document).ready(function($) {
  
  /* Contact Form Interactions */
  $('#btnOpenForm').on('click', function(event) {
    event.preventDefault();

    $('.form-popup-bg').addClass('is-visible');
  });
  
    //close popup when clicking x or off popup
  $('.form-popup-bg').on('click', function(event) {
    if ($(event.target).is('.form-popup-bg') || $(event.target).is('#btnCloseForm')) {
      event.preventDefault();
      $(this).removeClass('is-visible');
    }
  });
  
  

    /* Contact Form Interactions */
    $('#btnOpenForm2').on('click', function(event) {
    event.preventDefault();

    $('.form-popup1-bg').addClass('is-visible');
  });
  
    //close popup when clicking x or off popup
  $('.form-popup1-bg').on('click', function(event) {
    if ($(event.target).is('.form-popup1-bg') || $(event.target).is('#btnCloseForm')) {
      event.preventDefault();
      $(this).removeClass('is-visible');
    }
  });
  

  
  });

</script>
