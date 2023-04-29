@include('new_layouts.header')

@php $setting  = Utility::settings(\Auth::user()->creatorId()); @endphp
@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
    <link rel='stylesheet' href='https://unicons.iconscout.com/release/v3.0.6/css/line.css'>

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
                 <span class="d-block">{{__('Total Task')}}</span>
              </div>
              <p class="fs-normal mb-0">{{$project_data['task']['total'] }}</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 bgwhite">
          <div class="box d-flex rounded-2 align-items-center mb-4 mb-lg-0 p-3">
            <i class="uil-dollar-alt fs-2 text-center green rounded-circle"></i>
            <div class="ms-3">
              <div class="d-flex align-items-center">
                 <span class="d-block">{{__('Total')}} {{__('Budget')}}</span>
              </div>
              <p class="fs-normal mb-0">{{ \Auth::user()->priceFormat($project->budget)}}</p>
            </div>
          </div>
        </div>
        @if(Auth::user()->type !='client')
        <div class="col-lg-4 bgwhite">
          <div class="box d-flex rounded-2 align-items-center p-3">
            <i class="uil-dollar-alt fs-2 text-center green rounded-circle"></i>
            <div class="ms-3">
              <div class="d-flex align-items-center">
                <span class="d-block">{{__('Total')}} {{__('Expense')}}</span>
              </div>
              <p class="fs-normal mb-0">{{ \Auth::user()->priceFormat($project_data['expense']['total']) }}</p>
            </div>
          </div>
        </div>
        @else
          <div class="col-lg-4 col-md-6"></div>
        @endif
      </div>
    </section>
<br/>



<div class="row">


<div class="col-lg-6 bgwhite">

<div class="card" style="height: 354px;">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div class="avatar me-3">
                <img {{ $project->img_image }} alt="" class="img-user wid-45 rounded-circle">
            </div>
            <div class="d-block  align-items-center justify-content-between w-100">
                <div class="mb-3 mb-sm-0">
                    <h5 class="mb-1"> {{$project->project_name}}</h5>
                    <p class="mb-0 text-sm">
                    <div class="progress-wrapper">
                        <span class="progress-percentage"><small class="font-weight-bold">{{__('Completed:')}} : </small>{{ $project->project_progress()['percentage'] }}</span>
                        <div class="progress progress-xs mt-2">
                            <div class="progress-bar bg-info" role="progressbar" aria-valuenow="{{ $project->project_progress()['percentage'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $project->project_progress()['percentage'] }};"></div>
                        </div>
                    </div>
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <h4 class="mt-3 mb-1"></h4>
                <p> {{ $project->description }}</p>
            </div>
        </div>
        <div class="card bg-primary mb-0">
            <div class="card-body">
                <div class="d-block d-sm-flex align-items-center justify-content-between">
                    <div class="row align-items-center">
                        <span class="text-white text-sm">{{__('Start Date')}}</span>
                        <h5 class="text-white text-nowrap">{{ Utility::getDateFormated($project->start_date) }}</h5>
                    </div>
                    <div class="row align-items-center">
                        <span class="text-white text-sm">{{__('End Date')}}</span>
                        <h5 class="text-white text-nowrap">{{ Utility::getDateFormated($project->end_date) }}</h5>
                    </div>

                </div>
                <div class="row">
                    <span class="text-white text-sm">{{__('Client')}}</span>
                    <h5 class="text-white text-nowrap">{{ (!empty($project->client)?$project->client->name:'-') }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>

</div>



   
<div class="col-lg-6 bgwhite">
        <div class="card">
          <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="theme-avtar bg-primary">
                        <i class="ti ti-clipboard-list"></i>
                    </div>
                    <div class="ms-3">
                        <p class="text-muted mb-0">{{__('Last 7 days task done')}}</p>
                        <h4 class="mb-0">{{ $project_data['task_chart']['total'] }}</h4>

                    </div>
                </div>
                <div id="task_chart"></div>
            </div>

            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center">
                        <span class="text-muted">{{__('Day Left')}}</span>
                    </div>
                    <span>{{ $project_data['day_left']['day'] }}</span>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar bg-primary" style="width: {{ $project_data['day_left']['percentage'] }}%"></div>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center">

                        <span class="text-muted">{{__('Open Task')}}</span>
                    </div>
                    <span>{{ $project_data['open_task']['tasks'] }}</span>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar bg-primary" style="width: {{ $project_data['open_task']['percentage'] }}%"></div>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center">
                        <span class="text-muted">{{__('Completed Milestone')}}</span>
                    </div>
                    <span>{{ $project_data['milestone']['total'] }}</span>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar bg-primary" style="width: {{ $project_data['milestone']['percentage'] }}%"></div>
                </div>
            </div>
        </div>
  </div>
 </div>



</div>



   <section class="statistics">
      <div class="row">

        <div class="col-lg-6 bgwhite">
          <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="theme-avtar bg-primary">
                        <i class="ti ti-clipboard-list"></i>
                    </div>
                    <div class="ms-3">
                        <p class="text-muted mb-0">{{__('Last 7 days hours spent')}}</p>
                        <h4 class="mb-0">{{ $project_data['timesheet_chart']['total'] }}</h4>

                    </div>
                </div>
                <div id="timesheet_chart"></div>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center">
                        <span class="text-muted">{{__('Total project time spent')}}</span>
                    </div>
                    <span>{{ $project_data['time_spent']['total'] }}</span>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar bg-primary" style="width: {{ $project_data['time_spent']['percentage'] }}%"></div>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center">

                        <span class="text-muted">{{__('Allocated hours on task')}}</span>
                    </div>
                    <span>{{ $project_data['task_allocated_hrs']['hrs'] }}</span>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar bg-primary" style="width: {{ $project_data['task_allocated_hrs']['percentage'] }}%"></div>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center">
                        <span class="text-muted">{{__('User Assigned')}}</span>
                    </div>
                    <span>{{ $project_data['user_assigned']['total'] }}</span>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar bg-primary" style="width: {{ $project_data['user_assigned']['percentage'] }}%"></div>
                </div>
            </div>
        </div>


        </div>
        

        <div class="col-md-6">

<div class="card" style="height: 328px;">
  <div class="card-header">
    <div class="headingnew align-items-center justify-content-between">
      <h5>{{__('Members')}}</h5>
                        @can('edit project')
                            <div class="float-end">
                                <a href="#" data-size="lg" data-url="{{ route('invite.project.member.view', $project->id) }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary" data-bs-original-title="{{__('Add Member')}}">
                                    <i class="ti ti-plus"></i>
                                </a>
                            </div>
                        @endcan
    </div>
  </div>
  <div class="card-body">
    <ul class="list-group list-group-flush list" id="project_users">
    </ul>
</div>
</div>
</div>



      </div>
    </section>


   <section class="statis  text-center main2">
      <div class="row">
        <div class="col-md-6 col-lg-6 mb-6 mb-lg-0">

        </div>

        <div class="col-md-6 col-lg-6 mb-6 mb-md-0">
     
        
        </div>

      </div>

<div class="row">

<div class="col-md-12 col-lg-12 mb-12 mb-lg-0">
        @can('view activity')
 
 <div class="card activity-scroll">
     <div class="card-header">
         <h5>{{__('Activity Log')}}</h5>
         <small>{{__('Activity Log of this project')}}</small>
     </div>
     <div class="card-body vertical-scroll-cards">
         @foreach($project->activities as $activity)
             <div class="card p-2 mb-2">
                 <div class="d-flex align-items-center justify-content-between">
                     <div class="d-flex align-items-center">
                         <div class="theme-avtar bg-primary">
                             <i class="ti ti-{{$activity->logIcon($activity->log_type)}}"></i>
                         </div>
                         <div class="ms-3">
                             <h6 class="mb-0">{{ __($activity->log_type) }}</h6>
                             <p class="text-muted text-sm mb-0">{!! $activity->getRemark() !!}</p>
                         </div>
                     </div>
                     <p class="text-muted text-sm mb-0">{{$activity->created_at->diffForHumans()}}</p>
                 </div>
             </div>
         @endforeach
     </div>
 </div>
@endcan
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

    <script>
        (function () {
            var options = {
                chart: {
                    type: 'area',
                    height: 60,
                    sparkline: {
                        enabled: true,
                    },
                },
                colors: ["#ffa21d"],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2,
                },
                series: [{
                    name: 'Bandwidth',
                    data:{{ json_encode(array_map('intval',$project_data['timesheet_chart']['chart'])) }}
                }],

                tooltip: {
                    followCursor: false,
                    fixed: {
                        enabled: false
                    },
                    x: {
                        show: false
                    },
                    y: {
                        title: {
                            formatter: function (seriesName) {
                                return ''
                            }
                        }
                    },
                    marker: {
                        show: false
                    }
                }
            }
            var chart = new ApexCharts(document.querySelector("#timesheet_chart"), options);
            chart.render();
        })();

        (function () {
            var options = {
                chart: {
                    type: 'area',
                    height: 60,
                    sparkline: {
                        enabled: true,
                    },
                },
                colors: ["#ffa21d"],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2,
                },
                series: [{
                    name: 'Bandwidth',
                    data:{{ json_encode($project_data['task_chart']['chart']) }}
                }],

                tooltip: {
                    followCursor: false,
                    fixed: {
                        enabled: false
                    },
                    x: {
                        show: false
                    },
                    y: {
                        title: {
                            formatter: function (seriesName) {
                                return ''
                            }
                        }
                    },
                    marker: {
                        show: false
                    }
                }
            }
            var chart = new ApexCharts(document.querySelector("#task_chart"), options);
            chart.render();
        })();

        $(document).ready(function () {
            loadProjectUser();
            $(document).on('click', '.invite_usr', function () {
                var project_id = $('#project_id').val();
                var user_id = $(this).attr('data-id');

                $.ajax({
                    url: '{{ route('invite.project.user.member') }}',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        'project_id': project_id,
                        'user_id': user_id,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        if (data.code == '200') {
                            show_toastr(data.status, data.success, 'success')
                            location.reload();
                            loadProjectUser();
                        } else if (data.code == '404') {
                            show_toastr(data.status, data.errors, 'error')
                        }
                    }
                });
            });
        });

        function loadProjectUser() {
            var mainEle = $('#project_users');
            var project_id = '{{$project->id}}';

            $.ajax({
                url: '{{ route('project.user') }}',
                data: {project_id: project_id},
                beforeSend: function () {
                    $('#project_users').html('<tr><th colspan="2" class="h6 text-center pt-5">{{__('Loading...')}}</th></tr>');
                },
                success: function (data) {
                    mainEle.html(data.html);
                    $('[id^=fire-modal]').remove();
                    loadConfirm();
                }
            });
        }

    </script>
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
