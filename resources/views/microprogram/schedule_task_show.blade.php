@include('new_layouts.header')
<link rel="stylesheet" href="{{ asset('tokeninput/tokeninput.css') }}">
<style>
   ul.token-input-list-bootstrap {
      margin-top: 7px !important;
   }
</style>
<div class="page-wrapper">
   @include('construction_project.side-menu')
   <div class="container-fluid" id="taskboard_view">
      <div class="p-4">
         <div class="col-12">
            <div class="card">
               <div class="card-header">
                  <h1 class="mb-0">{{"(".$scheduleGet->uid.")".$scheduleGet->schedule_name}}
                     @if($scheduleGet->active_status == 1)
                     <span style="color: rgb(47, 179, 68)"> {{ __('Active') }}</span>
                     @elseif($scheduleGet->active_status == 2)
                     <span style="color: rgb(212, 56, 77)">{{ __('Completed') }}</span>
                     @else
                     <span style="color: rgb(247, 103, 7)">{{ __('In-schedule') }}</span>
                     @endif
                  </h1>
                  @if (Auth::user()->type != "consultant" && Auth::user()->type != "sub_contractor")
                  <div class="card-actions">
                     @can('schedule lookahead schedule')
                        @if($scheduleGet->active_status == 1)
                           <button class="btn btn-primary pull-right" type="button" onclick="scheduleComplete()">
                              {{ __('Complete the Schedule') }}
                           </button>
                        @elseif($scheduleGet->active_status == 2)
                           <button class="btn btn-primary pull-right" type="button" disabled>
                              {{ __('Completed') }}
                           </button>
                        @elseif($scheduleCheck == null)
                           <button class="btn btn-primary pull-right" type="button" onclick="scheduleStart()">
                              {{ __('Active the Schedule') }}
                           </button>
                        @else
                           <button class="btn btn-primary pull-right" type="button" onclick="scheduleDraftSave()">
                              {{ __('Save to the draft') }}
                           </button>
                        @endif
                     @endcan
                  </div>
                  @endif
               </div>
               <div class="card-body">
                  <div class="accordion" id="accordion-example">
                     <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-1">
                           <button class="accordion-button" type="button" data-bs-toggle="collapse"
                              data-bs-target="#collapse-1" aria-expanded="true">
                           </button>
                        </h2>
                        <div id="collapse-1" class="accordion-collapse collapse show"
                           data-bs-parent="#accordion-example">
                           <div class="accordion-body pt-0">
                              <div class="card p-3 mb-3 ">
                                 <div class="row w-100">
                                    <div class="col-3 p-4">
                                       <input type="hidden" name="schedule_id" id="schedule_id"
                                          value="{{$scheduleGet->id}}">
                                       <span>
                                       <b> {{ __('Schedule Duration') }}:</b> {{$intervalDays}} {{__('days') }}
                                       </span>
                                    </div>
                                    <div class="col-4 p-4">
                                       <span>
                                       <b>{{ __('Holiday Duration') }}:</b> {{$holidayCount}} {{__('days') }}
                                       </span>
                                    </div>
                                    {{-- <div class="col-4  p-4">
                                       <b>{{ __('Planned Percentage') }}:</b>
                                       {{$current_Planed_percentage}}
                                    </div> --}}
                                    <div class="col-5 p-4">
                                       <span><b>{{ __('Schedule Start Date') }}:</b>
                                       {{ Utility::site_date_format($scheduleGet->schedule_start_date,
                                       \Auth::user()->id) }}
                                       - <b>
                                       {{ __('Schedule End Date') }}:</b>
                                       {{ Utility::site_date_format($scheduleGet->schedule_end_date,
                                       \Auth::user()->id) }}
                                       </span>
                                    </div>
                                 </div>
                                 <div class="card-body">
                                    <div class="group__goals sortable_microschedule">
                                       @forelse ($microSchedule as $key_sort => $microschedule)
                                       @php $key_sort++; @endphp
                                       <div class="card" data-task_id="{{ $microschedule->task_id }}"
                                          data-sortnumber="{{$key_sort}}" data-con_main_id="{{ $microschedule->con_main_id }}">
                                          <div class="row">
                                             <div
                                                class="col-md-1 py-3  border-end bg-primary text-white">
                                                <div class="datagrid-title text-white">
                                                   {{ __('Micro Id') }}
                                                </div>
                                                <div class="datagrid-content">
                                                   {{ $microschedule->task_id }}
                                                </div>
                                             </div>
                                             <div class="col-md-5 p-3">
                                                <div class="datagrid-title ">
                                                   {{ __('Task Name') }}
                                                </div>
                                                <div class="datagrid-content">
                                                   {{ $microschedule->text }}
                                                </div>
                                             </div>
                                             <div class="col-md-2 p-3">
                                                <div class="datagrid-title">
                                                   {{ __('Start Date') }}
                                                </div>
                                                <div class="datagrid-content">
                                                   {{ Utility::site_date_format($microschedule->start_date,
                                                   \Auth::user()->id) }}
                                                </div>
                                             </div>
                                             <div class="col-md-2 p-3">
                                                <div class="datagrid-title">
                                                   {{ __('End date') }}
                                                </div>
                                                <div class="datagrid-content">
                                                   {{ Utility::site_date_format($microschedule->end_date,
                                                   \Auth::user()->id) }}
                                                </div>
                                             </div>
                                             <div class="col-md-2 p-3">
                                                <div class="datagrid-title">
                                                   {{ __('Assignees') }}
                                                </div>
                                                @php
                                                   $users_data_micro = array();
                                                   if ($microschedule->users != '') {
                                                      $users_data_micro[] = $microschedule->users;
                                                      // $users_data_micro = json_decode($microschedule->users);
                                                   }
                                                @endphp
                                                <div class="datagrid-content">
                                                   <div
                                                      class="avatar-list avatar-list-stacked">
                                                      @forelse ($users_data_micro as $key => $get_user)
                                                      @php
                                                      $user_db = DB::table('users')
                                                      ->where('id', $get_user)
                                                      ->first();
                                                      @endphp
                                                      @if ($key < 3)
                                                      @if ($user_db->avatar)
                                                      <a href="#"
                                                         class="avatar rounded-circle avatar-sm">
                                                      @if ($user_db->avatar)
                                                      <span
                                                         class="avatar avatar-xs rounded"
                                                         style="background-image:
                                                         url({{ asset('/storage/uploads/avatar/'.$user_db->avatar) }})">
                                                      </span>
                                                      @else
                                                      <span
                                                         class="avatar avatar-xs rounded"
                                                         style="background-image:
                                                         url({{ asset('/storage/uploads/avatar/avatar.png') }})">
                                                      </span>
                                                      @endif
                                                      </a>
                                                      @else
                                                      <?php $short = substr($user_db->name, 0, 1); ?>
                                                      <span
                                                         class="avatar avatar-xs rounded">
                                                         {{ strtoupper($short) }}
                                                      </span>
                                                      @endif
                                                      @endif
                                                      @empty
                                                      {{ __('Not Assigned') }}
                                                      @endforelse
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       @empty
                                       @endforelse
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-12">
            <div class="card">
               <div class="card-header">
                  <h1 class="mb-0">{{ __('Week Task List') }}</h1>
               </div>
               <div class="card-body">
                  <div class="accordion" id="accordion-example">
                     <div id="collapse-2" class="accordion-collapse collapse show"
                        data-bs-parent="#accordion-example">
                        <div class="accordion-body pt-0">
                           <div class="card p-3 mb-3 ">
                              {{-- <div class="row w-100">
                                 <div class="col-5 p-4">
                                    <span><b>{{ __('Week Start Date') }}:</b>
                                    {{ Utility::site_date_format($weekStartDate, \Auth::user()->id) }}
                                    - <b>
                                    {{ __('Week End Date') }}:</b>
                                    {{ Utility::site_date_format($weekEndDate, \Auth::user()->id) }}
                                    </span>
                                 </div>
                              </div> --}}
                              <div class="card p-4">
                                 <form action="{{ route('schedule_task_show',['id' => $secheduleId])}}" method="POST">
                                    @csrf
                                    <div class="row px-5">
                                       <div class="col-3">
                                          <div class="mb-3">
                                             <label class="form-label">{{ __('Search By Task Name or Id') }}</label>
                                             <input type="text" id="skill_input" value="{{ request()->get('q') }}" style="margin-top: 15px !important;">
                                          </div>
                                       </div>

                                       <div class="col-3">
                                          <div class="mb-3">
                                             <label class="form-label">Task Planned Start Date</label>
                                             <div class="input-icon">
                                                <span class="input-icon-addon">
                                                   <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M11 15h1" /><path d="M12 15v3" /></svg>
                                                </span>
                                                <input name="start_date" class="form-control start_date" placeholder="Select a Start date" id="start-date" value="{{$start_date}}">
                                             </div>
                                          </div>
                                       </div>

                                       <div class="col-3">
                                          <div class="mb-3">
                                             <label class="form-label">Task Planned End Date</label>
                                             <div class="input-icon">
                                                <span class="input-icon-addon">
                                                   <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M11 15h1" /><path d="M12 15v3" /></svg>
                                                </span>
                                                <input name="end_date" class="form-control end_date" placeholder="Select a End date" id="end-date" value="{{$end_date}}">
                                             </div>
                                          </div>
                                       </div>

                                       <div class="col-3">
                                          <div class="mb-3">
                                             <label class="form-label">{{ __('Task Status') }}</label>
                                             <select name="task_status" type="text" class="form-select task_status" placeholder="Task Status" id="task-status" value="">
                                                <option value="">{{ __('Select Status') }}</option>
                                                <option value="3" @if($task_status == 3) selected @endif>{{ __('Pending') }}</option>
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row px-5">
                                       <div class="flex text-center">
                                          <button type="button" class="btn btn-primary" id="search_task" onclick="con_page_record()">Search</button>
                                          <button type="button" class="btn btn-warning" id="reset_task">Reset</button>
                                       </div>
                                    </div>
                                 </form>
                              </div>
                                <div class="append_search_page">
                                    <div class="card-body">
                                        <div class="pt-3 group__goals sortable_task">
                                            @forelse ($weekSchedule as $key_sort => $schedule)
                                                @php $key_sort++; @endphp
                                                <div class="card" data-task_id="{{ $schedule->id }}"
                                                    data-sortnumber="{{$key_sort}}" data-con_main_id="{{ $schedule->main_id }}">
                                                    <div class="row">
                                                        <div class="col-md-1 py-3  border-end bg-primary text-white">
                                                            <div class="datagrid-title text-white">
                                                                {{ __('Task Id') }}
                                                            </div>
                                                            <div class="datagrid-content">
                                                                {{ $schedule->id }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5 p-3">
                                                            <div class="datagrid-title ">{{ __('Task Name') }}</div>
                                                            <div class="datagrid-content">
                                                                {{ $schedule->text }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 p-3">
                                                            <div class="datagrid-title">{{ __('Start Date') }}</div>
                                                            <div class="datagrid-content">
                                                                {{ Utility::site_date_format($schedule->start_date,
                                                                \Auth::user()->id) }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 p-3">
                                                            <div class="datagrid-title">{{ __('End date') }}</div>
                                                            <div class="datagrid-content">
                                                                {{ Utility::site_date_format($schedule->end_date, \Auth::user()->id) }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 p-3">
                                                            <div class="datagrid-title">{{ __('Assignees') }}</div>
                                                            @php
                                                                $users_data = array();
                                                                if ($schedule->users != '') {
                                                                $user_set[] = $schedule->users;
                                                                // $users_data = json_decode($user_set);
                                                                }
                                                            @endphp
                                                            <div class="datagrid-content">
                                                                <div class="avatar-list avatar-list-stacked">
                                                                    @forelse ($users_data as $key => $get_user)
                                                                        @php
                                                                            $user_db = DB::table('users')->where('id', $get_user)
                                                                                ->first();
                                                                        @endphp
                                                                        @if ($key < 3)
                                                                            @if ($user_db->avatar)
                                                                                <a href="#" class="avatar rounded-circle avatar-sm">
                                                                                @if ($user_db->avatar)
                                                                                    <span
                                                                                        class="avatar avatar-xs rounded"
                                                                                        style="background-image:
                                                                                        url({{ asset('/storage/uploads/avatar/' . $user_db->avatar) }})">
                                                                                    </span>
                                                                                @else
                                                                                    <span
                                                                                        class="avatar avatar-xs rounded"
                                                                                        style="background-image:
                                                                                        url({{ asset('/storage/uploads/avatar/avatar.png') }})">
                                                                                    </span>
                                                                                @endif
                                                                                </a>
                                                                            @else
                                                                                <?php $short = substr($user_db->name, 0, 1); ?>
                                                                                <span
                                                                                class="avatar avatar-xs rounded">{{ strtoupper($short) }}</span>
                                                                            @endif
                                                                        @endif
                                                                    @empty
                                                                        {{ __('Not Assigned') }}
                                                                    @endforelse
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                            
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="d-flex mt-4">
                                        <ul class="pagination ms-auto">
                                            {!! $weekSchedule->links() !!}
                                        </ul>
                                    </div>
                                </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@include('new_layouts.footer')
<script src="{{ asset('tom-select/tom-select.popular.min.js') }}"></script>
<script src="{{ asset('litepicker/litepicker.js') }}"></script>
<script src="{{ asset('tokeninput/jquery.tokeninput.js') }}"></script>
<script src="{{ asset('assets/js/js/Sortable.min.js') }}">
</script>
<script>
   var tempcsrf = '{!! csrf_token() !!}';

   $("#reset_task").click(function(){
      $('input#skill_input').tokenInput('clear');
      $(".start_date").val("");
      $(".end_date").val("");
      $(".task_status").val("");
      location.replace(window.location.href);
   });

   $(document).ready(function() {
      $("#skill_input").tokenInput("{{route('schedule_task_autocomplete')}}", {
         propertyToSearch:"text",
         tokenValue:"id",
         tokenDelimiter:",",
         hintText: "{{ __('Search Task...') }}",
         noResultsText: "{{ __('Task not found.') }}",
         searchingText: "{{ __('Searching...') }}",
         deleteText:"&#215;",
         minChars: 2,
         tokenLimit: 4,
         animateDropdown: false,
         resultsLimit:10,
         deleteText: "&times;",
         preventDuplicates: true,
         theme: "bootstrap"
      });
   });

   document.addEventListener("DOMContentLoaded", function() {
       window.Litepicker && (new Litepicker({
           element: document.getElementById('start-date'),
           elementEnd: document.getElementById('end-date'),
           singleMode: false,
           allowRepick: true,
           buttonText: {
               previousMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
               height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
               stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"
               fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
   
               nextMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
               height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
               stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"
               fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
           },
       }));
   });
   
   document.querySelectorAll(".sortable_task").forEach(node => {
       new Sortable(node, {
           group: 'scoreboard',
           direction: 'vertical',
           animation: 250,
           scroll: true,
           bubbleScroll: true,
           onMove: function(evt, originalEvent) {
               if (
                   evt.dragged.classList.contains("group") &&
                   evt.to.classList.contains("group__goals")
               ) {
                   return false;
               }
           },
           update: function(event, ui) {
             
           },
           receive : function (event, ui) {
             
           },
       });
   });
   
   document.querySelectorAll(".sortable_microschedule").forEach(node => {
       new Sortable(node, {
           group: 'scoreboard',
           direction: 'vertical',
           animation: 250,
           scroll: true,
           bubbleScroll: true,
           onMove: function(evt, originalEvent) {
               if (
                   evt.dragged.classList.contains("group") &&
                   evt.to.classList.contains("group__goals")
               ) {
                   return false;
               }
   
           },
           onAdd: function (/**Event*/evt) {
               
           },
           onSort: function (/**Event*/evt) {
         
               $(".sortable_microschedule .card").each(function(index) {
                   index++;
                   $(this).attr('data-sortnumber',index);
               });
           }
       });
   });
   
   function scheduleStart(){
       schedule_id   = $("#schedule_id").val();
       schedulearray = getData();
   
       const swalWithBootstrapButtons = Swal.mixin({
           customClass: {
               confirmButton: 'btn btn-success',
               cancelButton: 'btn btn-danger'
           },
           buttonsStyling: false
       })
       swalWithBootstrapButtons.fire({
           title: 'Are you sure?',
           text: "Active this Schedule! Once Activated you cannot modify",
           icon: 'info',
           showCancelButton: true,
           confirmButtonText: 'Yes',
           cancelButtonText: 'No',
           reverseButtons: true
       }).then((result) => {
           if (result.isConfirmed) {
               $.ajax({
                   url : '{{route("mainschedule_store")}}',
                   type : 'POST',
                   data : {
                       'schedulearray' : schedulearray,
                       'schedule_id' : schedule_id,
                       'schedule_type': 'save_active',
                       '_token' : '{{ csrf_token() }}',
                   },
                   success : function(data_check) {
                       if(data_check[0] == "0"){
                           toastr.warning(data_check[1]);
                       }
                       else if(data_check[0] == "1"){
                           toastr.success(data_check[1]);
                           location.reload();
                       }
                       else{
                           toastr.error("Somenthing went wrong!");
                       }
                   },
                   error : function(request,error)
                   {
                       toastr.error("Somenthing went wrong!.");
                   }
               });
           }
           else if (result.dismiss === Swal.DismissReason.cancel) {
           }
       });
   }

   function scheduleDraftSave(){
      schedule_id   = $("#schedule_id").val();
      schedulearray = getData();

      const swalWithBootstrapButtons = Swal.mixin({
         customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
         },
         buttonsStyling: false
      })
      swalWithBootstrapButtons.fire({
         title: 'Are you sure?',
         text: "Schedule save in the draft",
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            reverseButtons: true
         }).then((result) => {
            if (result.isConfirmed) {
               $.ajax({
                  url : '{{route("mainschedule_store")}}',
                  type : 'POST',
                  data : {
                     'schedulearray' : schedulearray,
                     'schedule_id' : schedule_id,
                     'schedule_type': 'save_draft',
                     '_token' : '{{ csrf_token() }}',
                  },
                  success : function(data_check) {
                     if(data_check[0] == "0"){
                        toastr.warning(data_check[1]);
                     }
                     else if(data_check[0] == "1"){
                        toastr.success(data_check[1]);
                        location.reload();
                     }
                     else{
                        toastr.error("Somenthing went wrong!");
                     }
                  },
                  error : function(request,error)
                  {
                     toastr.error("Somenthing went wrong!.");
                  }
               });
           }
           else if (result.dismiss === Swal.DismissReason.cancel) {
           }
      });
   }
   
   function scheduleComplete(){
       schedule_id   = $("#schedule_id").val();
   
       const swalWithBootstrapButtons = Swal.mixin({
           customClass: {
               confirmButton: 'btn btn-success',
               cancelButton: 'btn btn-danger'
           },
           buttonsStyling: false
       })
       swalWithBootstrapButtons.fire({
           title: 'Are you sure?',
           text: "Complete the Schedule?",
           icon: 'info',
           showCancelButton: true,
           confirmButtonText: 'Yes',
           cancelButtonText: 'No',
           reverseButtons: true
       }).then((result) => {
           if (result.isConfirmed) {
               $.ajax({
                   url : '{{route("schedule_complete")}}',
                   type : 'GET',
                   data : {
                       'schedule_id' : schedule_id,
                       '_token' : '{{ csrf_token() }}',
                   },
                   success : function(data_check) {
                       if(data_check[0] == "1"){
                           toastr.success(data_check[1]);
                           location.reload();
                       }
                       else{
                           toastr.error("Somenthing went wrong!");
                       }
                   },
                   error : function(request,error)
                   {
                       toastr.error("Somenthing went wrong!.");
                   }
               });
           }
           else if (result.dismiss === Swal.DismissReason.cancel) {
           }
       });
   }

    $(document).on('click','.pagination a', function(e){
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1]
        con_page_record(page)
    });

   function con_page_record(page){
        if(page == undefined){
            page = 1;
        }
        var task_id_arr = [];
        schedule_id = $("#schedule_id").val();
        task_id     = $('input#skill_input').tokenInput('get');
        start_date  = $(".start_date").val();
        end_date    = $(".end_date").val();
        status_task = $(".task_status").val();

        $.each(task_id, function(i, obj){
            task_id_arr.push(obj.id);
        });

        $.ajax({
            url:"{{ route('mainschedule_drag_con') }}?page="+page,
            data: {
                start_date  : start_date,
                end_date    : end_date,
                status_task : status_task,
                task_id_arr : task_id_arr,
                schedule_id : schedule_id
            },
            success:function(res){
                if(res['success'] == true){
                    $('.append_search_page').html(res['all_task']);

                    document.querySelectorAll(".sortable_task").forEach(node => {
                        new Sortable(node, {
                            group: 'scoreboard',
                            direction: 'vertical',
                            animation: 250,
                            scroll: true,
                            bubbleScroll: true,
                            onMove: function(evt, originalEvent) {
                                if (evt.dragged.classList.contains("group") && evt.to.classList.contains("group__goals"))
                                {
                                    return false;
                                }
                            },
                            update: function(event, ui) { },
                            receive : function (event, ui) { },
                        });
                    });
                }
            }
        });
    }
   
   function getData(){
       schedulearray = [];
       innerarray    = [];
      
       $(".sortable_microschedule .card").each(function(index) {
           order_number = $(this).data('sortnumber');
           task_id      = $(this).data('task_id');
           con_main_id  = $(this).data('con_main_id');

           console.log("con_main_id",con_main_id);
   
           innerarray = {'sort_number':order_number,'task_id':task_id, 'con_main_id':con_main_id};
           schedulearray.push(innerarray);
       });
   
       return schedulearray;
   }
</script>
