@include('new_layouts.header')

@php $setting  = Utility::settings(\Auth::user()->creatorId()); @endphp
@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
    <link rel='stylesheet' href='https://unicons.iconscout.com/release/v3.0.6/css/line.css'>

<style>
    .table-responsive {
        max-width: none !important;
    }
</style>
@include('construction_project.side-menu')


<div class="row mainrow">
   <div class="col-md-6">
     <h2>Project Dashboard</h2>
   </div>
   <div class="col-md-6">

      <div class="float-end">
            <div class="float-right ">
              
            </div>
      </div>

   </div>
</div>

<div class="page-wrapper dashboard">

    @if(Auth::user()->type == 'company')
    <div class="row">
    <div class="col-sm-12">
        <div class="mt-2 " >
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => ['project_report.view_task_report',$user_project_id], 'method' => 'GET', 'id' => 'project_report_submit']) }}
                        <div class="row d-flex align-items-center">
                            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12 mr-2 mb-0">
                            <div class="btn-box">
                                {{ Form::label('project', __('Project'),['class'=>'form-label'])}}
                                <select class="select form-select" name="project_list" id="project_list" >
                                    {{-- <option value="" class="">{{ __('Select Project') }}</option> --}}
                                    @foreach ($project_title as $title)
                                        @if(Session::get('project_id')==$title->id)
                                            <option value="{{ $title->id }}" {{Session::has('project_id') && Session::get('project_id')==$title->id?'selected':''}}>{{ $title->project_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12 mr-2 mb-0">
                            <div class="btn-box">
                                {{ Form::label('users', __('Users'),['class'=>'form-label'])}}
                                <select class="select form-select" name="all_users" id="all_users">
                                @forelse ($get_user_data as $user_data)
                                    <option value="{{$user_data->id}}" {{isset($_GET['all_users']) && $_GET['all_users']==$user_data->id?'selected':''}}>{{$user_data->name}}</option>
                                @empty
                                @endforelse
                                </select>
                               
                            </div>
                        </div>

                        {{-- <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12 mr-2 mb-0">
                            <div class="btn-box">
                                {{ Form::label('task', __('Task'),['class'=>'form-label'])}}
                                <select class="select form-select" name="task_name" id="task_name">
                                    @forelse ($get_all_user_data as $user)
                                    <option value="{{$user->id}}" {{isset($_GET['task_name']) && $_GET['task_name']==$user->id?'selected':''}}>{{$user->name}}</option>
                                @empty
                                @endforelse
                                </select>
                            </div>
                        </div>
                      
                        <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                            <div class="btn-box">
                                {{ Form::label('priority', __('Priority'),['class'=>'form-label'])}}
                                {{ Form::select('priority', ['' => 'Select Priority'] + $status, isset($_GET['priority']) ? $_GET['priority'] : '', ['class' => 'form-control select']) }}
                            </div>
                        </div> --}}

                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                            <div class="btn-box">
                                {{ Form::label('start_date', __('Start Date'),['class'=>'form-label'])}}
                                {{ Form::date('start_date', isset($_GET['start_date'])?$_GET['start_date']:'', array('class' => 'form-control month-btn')) }}
                            </div>
                        </div>

                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                            <div class="btn-box">
                                {{ Form::label('end_date', __('End Date'),['class'=>'form-label'])}}
                                {{ Form::date('end_date', isset($_GET['end_date'])?$_GET['end_date']:'', array('class' => 'form-control month-btn')) }}
                            </div>
                        </div>

                        <div class="col-auto float-end ms-2 mt-4 btnmaindiv">
                            <a href="#" class="btn btn-sm btn-primary btnalginment"
                               onclick="document.getElementById('project_report_submit').submit(); return false;"
                               data-toggle="tooltip" data-original-title="{{ __('apply') }}">
                                <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                            </a>
                            <a href="{{ route('project_report.index') }}" class="btn btn-sm btn-danger btnalginment" data-toggle="tooltip"
                                   data-original-title="{{ __('Reset') }}">
                                    <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off"></i></span>
                            </a>
                            <a href="{{route('send_report_con')}}"><input type='button' class='btnalginment form-control btn-primary' name='send_report' value='Send Report' style='width: 60%;float: right;background: #206bc4;color: #fff;'></a>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
                <div>
              
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="col-xl-12 mt-3">
  <div class="card table-card">
      <div class="">
          <div class="table-responsive">
              <table class="table datatable" id="example">
                  <thead class="">
                      <tr>
                          <th>{{__('Task Name')}}</th>
                          <th>{{__('Planned Start Date')}}</th>
                          <th>{{__('Planned End Date')}}</th>
                          {{-- <th>{{__('Actual End Date')}}</th>
                          <th>{{__('Actual End Date')}}</th> --}}
                          <th>{{__('Projects Members')}}</th>
                          <th class="hide_user">{{__('Projects Members')}}</th>
                          <th>{{__('Progress')}}</th>
                        
                      </tr>
                  </thead>
                  <tbody>
                  @if(isset($projects) && !empty($projects) && count($projects) > 0)
                      @foreach ($projects as $key => $project)
                          <tr>
                              <td>
                                  <div class="d-flex align-items-center">
                                      <p class="mb-0"><a  class="name mb-0 h6 text-sm">{{ $project->text }}</a></p>
                                  </div>
                              </td>
                              <td>{{ Utility::getDateFormated($project->start_date) }}</td>
                              <td>{{ Utility::getDateFormated($project->end_date) }}</td>
                              <td>
                                  <div class="avatar-group">
                                      @if($project->users()->count() > 0)
                                          @if($users = $project->users())
                                              @foreach($users as $key => $user)
                                                  @if($key<3)
                                                      <a href="#" class="avatar rounded-circle avatar-sm">
                                                          <img data-original-title="{{(!empty($user)?$user->name:'')}}" @if($user->avatar) src="{{asset('/storage/uploads/avatar/'.$user->avatar)}}" @else src="{{asset('/storage/uploads/avatar/avatar.png')}}" @endif title="{{ $user->name }}" class="hweb">
                                                      </a>
                                                  @else
                                                      @break
                                                  @endif
                                              @endforeach
                                          @endif
                                          @if(count($users) > 3)
                                              <a href="#" class="avatar rounded-circle avatar-sm">
                                                  <img  data-original-title="{{(!empty($user)?$user->name:'')}}" @if($user->avatar) src="{{asset('/storage/uploads/avatar/'.$user->avatar)}}" @else src="{{asset('/storage/uploads/avatar/avatar.png')}}" @endif class="hweb">
                                              </a>
                                          @endif
                                      @else
                                          {{ __('-') }}
                                      @endif
                                  </div>
                              </td>
                              <td class="hide_user">
                                  @php
                                  $split_user=array();
                              @endphp
                             @if($users = $project->users())
                                  @foreach ($users as $value)
                                      @php
                                          $split_user[]=$value->name;
                                      @endphp
                                  @endforeach
                                  {{ implode(",",$split_user)}}
                              @endif
                                  
                              </td>
                             
                              <td class="">
                                  <h6 class="mb-0 text-success">{{ round($project->progress) }}%</h6>
                                  @php $color = Utility::getProgressColor(round($project->progress));@endphp
                                  <div class="progress mb-0"><div class="progress-bar bg-{{ $color }}" style="width: {{ round($project->progress) }}%;"></div>
                                  </div>
                                  {{-- <span class="badge bg-{{\App\Models\ProjectTask::$priority_color[$project->priority]}} p-2 px-3 rounded status_badge">{{ __(\App\Models\ProjectTask::$priority[$project->priority]) }}</span> --}}
                              </td>
                          
                          </tr>
                      @endforeach
                  @else
                          <tr>
                              <td></td>
                              <td></td>
                              <td><h6 class="text-center">{{__('No Task Found.')}}</h6></td>
                              <td></td>
                              <td class="hide_user"></td>
                              <td></td>
                          </tr>
                  @endif

                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>
</div>

@include('new_layouts.footer')
<script>
  $(document).ready(function() {
  
  /*--------Project list---------------*/
  // $('#project_list').on('change', function() {
      var idCountry = this.value;
  
      $.ajax({
          url: "{{ route('project_report.fetch_user_details2') }}",
          type: 'POST',
          data: {
              country_id: idCountry,
              "_token": "{{ csrf_token() }}",
          },
          dataType: 'json',
          success: function(result) {
  
              // Handle success here
              $('#all_users').html('<option value="">-- Select Users --</option>');
  
              if (result.length != 0) {
                  $.each(result, function(key, value) {
                      $("#all_users").append('<option value="' + value
                          .id + '">' + value.name + '</option>');
                      $("#user_id").val(value.id);
                  });
              } else {
                  $("#all_users").append('<option value="0" disabled>No Data Found</option>');
              }
              $('#task_name').html('<option value="">-- Select Task --</option>');
  
          },
          cache: false
      }).fail(function(jqXHR, textStatus, error) {
  
      });
  // });
  
  
  
  /*--------User list---------------*/
  
  $('#all_users').on('change', function() {
      var idState = this.value;
      var get_id = $("#project_list option:selected").val();
  
      $("#task_name").html('');
      $.ajax({
          url: "{{route('project_report.fetch_task_details')}}",
          type: "POST",
          data: {
              state_id: idState,
              get_id: get_id,
              _token: '{{csrf_token()}}'
          },
          dataType: 'json',
          success: function(res) {
  
              $('#task_name').html('<option value="">-- Select Task --</option>');
              $.each(res, function(key, value) {
                  $("#task_name").append('<option value="' + value
                      .id + '">' + value.name + '</option>');
              });
          }
      });
  });
  });
  </script>
  
  <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
  
  <script>
  $(document).ready(function() {
      $('#example2').DataTable({
          dom: 'Bfrtip',
          searching: false,
          info: false,
          paging: false,
          buttons: [
  
              {
  
                  extend: 'excelHtml5',
                  title: 'Task Report',
                  titleAttr: 'Excel',
                  text: '<i class="fa fa-file-excel-o"></i>',
  
                  exportOptions: {
                      modifier: {
                          order: 'index', // 'current', 'applied','index', 'original'
                          page: 'all', // 'all', 'current'
                          search: 'none' // 'none', 'applied', 'removed'
                      },
                      columns: [0, 1, 2, 4, 5]
                  }
              },
  
              'colvis'
          ]
      });
  });
  
  </script>

  
