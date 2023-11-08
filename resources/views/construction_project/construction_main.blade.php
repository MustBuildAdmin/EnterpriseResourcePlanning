
@include('new_layouts.header')
<div class="container-fluid">
   <div class="card mt-5 p-4">
      <div class="card-header">
         <h3>{{ __('Projects of the Organisation') }}</h3>
         <div class="card-actions w-50">
            <div class="row">
               <div class="col-8">
                  <div class="mb-3">
                     <div class="row g-2">
                        <div class="col">
                           <form action="{{ route('construction_main') }}" method="GET" id="searchproject">
                           {{ Form::text('keyword',isset($_GET['keyword'])?$_GET['keyword']:'',
                           array('class' => 'form-control d-inline-block w-9 me-3 mt-auto',
                           'id'=>'keyword','placeholder'=>__('Search for Projects…'))) }}
                           </form>
                        </div>
                        <div class="col-auto">
                        <a href="javascript:void(0)" id="searchbtnproj" class="btn btn-icon" aria-label="Button">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                               height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                 <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                 <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                 <path d="M21 21l-6 -6"></path>
                              </svg>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
               @can('create project')
               <div class="col-4">
                  <a  href="#"  data-size="xl" data-url="{{ route('projects.create') }}" data-ajax-popup="true"
                  data-title="{{ __('Create New Project') }}" data-bs-toggle="tooltip"
                  title="{{__('Create New Project')}}" class="btn btn-primary w-100"
                   data-bs-toggle="modal" data-bs-target="#invite-Sub-Contractor">
                  {{ __('Create a Project') }}
                  </a>
               </div>
               @endcan
            </div>
         </div>
      </div>
     
      @if (isset($projects) && !empty($projects) && count($projects) > 0)
      <div class="row row-cards">
       @foreach ($projects as $key => $project)
         <div class="col-md-6 col-lg-3">
            <div class="card">
               <div class="ms-auto lh-1 p-4">
                   <div class="dropdown">
                      <a class="dropdown-toggle user-card-dropdown text-secondary" href="#"
                         data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-menu-2"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M4 6l16 0"></path>
                            <path d="M4 12l16 0"></path>
                            <path d="M4 18l16 0"></path>
                         </svg>
                      </a>
                      <div class="dropdown-menu dropdown-menu-end">
                       @php
                       $getInstance = DB::table('instance')
                           ->where('instance',$project->instance_id)
                           ->where('project_id',$project->id)
                           ->where('freeze_status',0)->first();
                       @endphp
                      
                        @if($getInstance != null)
                           @can('edit project')
                                 <a class="dropdown-item active" href="#!" data-size="xl"
                                 data-url="{{ route('projects.edit', $project->id) }}"
                                 data-ajax-popup="true"
                                 data-bs-original-title="{{ __('Edit Project') }}">{{ __('Edit') }}
                                 </a>
                           @endcan
                        @endif

                           @can('delete project')
                              {!! Form::open(['method' => 'DELETE',
                                    'route' => ['projects.destroy', $project->id]]) !!}
                              <a href="#!" class="dropdown-item bs-pass-para-deleteproject">
                                    <span> {{ __('Delete') }}</span>
                              </a>
                              {!! Form::close() !!}
                           @endcan

                           @can('edit project')
                              <a href="#!" data-size="xl"
                              data-url="{{ route('invite.project.member.view',
                                    $project->id) }}"
                                    data-ajax-popup="true" class="dropdown-item"
                                    data-bs-original-title="{{ __('Invite User') }}">
                                    <span>{{ __('Invite User') }}</span>
                              </a>
                           @endcan
                      </div>
                   </div>
                </div>
               <div class="card-body p-4 py-5 text-center">
                   <?php $color = sprintf("#%06x",random_int(0,16777215));
                   $project_image=$project->project_image;
                   ?>
                   @if($project_image!=0 && $project_image!='')
                        @php 
                        $image=\App\Models\Utility::get_file('uploads/logo').$project->project_image;
                        @endphp
                       <img id="image"  src="{{$image}}"
                        class="avatar avatar-xl mb-4 rounded" alt="">
                   @else
                       <span class="avatar avatar-xl mb-4 rounded">
                           <?= substr($project->project_name,0,2) ?>
                       </span>
                   @endif
                  <h3 class="mb-0">
               @php
                  $project_instances=\App\Models\Instance::where('project_id',$project->id)
                                    ->get();
                
               @endphp
               @if(count($project_instances)>1)
                   <a class="text-dark"  data-size="lg"
                   data-url="{{ route('projects.check_instance',$project->id) }}"
                   data-title="Choose Your Revision" data-ajax-popup="true"
                   data-bs-toggle="tooltip">{{ $project->project_name }}</a>
               @else
                   <a class="text-dark"  data-size="lg"
                   href="{{ route('projects.instance_project',
                           [$project_instances[0]['id'],$project->id,'Base']) }}"
                   data-bs-toggle="tooltip">{{ $project->project_name }}</a>
               @endif
                  </h3>
                  <p class="text-secondary mb-0">Start Date: {{ Utility::getDateFormated($project->start_date) }}</p>
                  <p class="text-secondary">End Date: {{ Utility::getDateFormated($project->end_date) }}</p>
                  <p class="mb-3">
                   @php
                   if ($project->status != ""){
                       $status_set = $project->status;
                   }
                   else{
                       $status_set = 'in_progress';
                   }
                  @endphp
                     <span class="badge bg-{{ \App\Models\Project::$status_color[$status_set] }}-lt">
                       {{ __(\App\Models\Project::$project_status[$status_set]) }}
                     </span>
                  </p>
                  <div>
                     <div class="avatar-list avatar-list-stacked">
                       @if (isset($project->users) && !empty($project->users)
                       && count($project->users) > 0)
                          @foreach ($project->users as $key => $user)
                          <?php  $short=substr($user->name, 0, 1);?>
                              @if ($key < 3)
                                  @if ($user->avatar)
                                      <a href="#" class="avatar avatar-sm rounded">
                                          <img  src="{{ asset('/storage/uploads/avatar/'
                                               . $user->avatar) }}"
                                              alt="{{strtoupper($short)}}" data-bs-toggle="tooltip"
                                              title="{{ $user->name }}" class="avatar avatar-sm rounded">
                                      </a>
                                  @else
                                      {{-- <a href="#" class="avatar rounded-circle avatar-sm"> --}}
                                         <span class="avatar avatar-sm rounded" data-bs-toggle="tooltip"
                                          title="{{ $user->name }}">{{strtoupper($short)}}</span>
                                      {{-- </a> --}}
                                  @endif
                              @else
                              @break
                          @endif
                      @endforeach
                  @endif
                     </div>
                  </div>
               </div>
               @php
               $progress=\App\Models\Con_task::where('project_id',$project->id)
               ->orderBy('main_id', 'asc')
               ->pluck ('progress')
               ->first();
               @endphp
               <div class="progress card-progress">
                  <div class="progress-bar" style="width: <?php echo $progress; ?>%" role="progressbar"
                      aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100"
                       aria-label="<?php echo $progress; ?>% Complete">
                     <span class="visually-hidden"><?php echo $progress; ?>% {{ __('Complete') }}</span>
                  </div>
               </div>
            </div>
         </div>
         @endforeach
         <div class="d-flex mt-4">
           <ul class="pagination ms-auto">
               {!! $projects->links() !!}
           </ul>
       </div>
      </div>
      @else
    <div class="page-body">
         <div class="container-xl d-flex flex-column justify-content-center">
            <div class="empty">
               <div class="empty-img">
                  <img src="{{ asset('assets/images/undraw_printing_invoices_5r4r.svg') }}" height="128" alt="">
               </div>
               <p class="empty-title"> {{__('No Projects Found')}}</p>
            </div>
         </div>
      </div>
      @endif
   </div>
</div>
</div>
</div>
<script src="{{ asset('WizardSteps/js/jquery.steps.js') }}"></script>
@include('new_layouts.footer')
<script>
   $(document).ready(function () {
      $(document).on('click','#searchbtnproj',function(){
         $('form#searchproject').submit();
      })
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
</script>
