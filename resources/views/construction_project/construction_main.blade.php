
@include('new_layouts.header')
<style>
a.text-dark {
   cursor: pointer !important;
}
</style>
@php
   $profile=\App\Models\Utility::get_file('uploads/avatar/');
@endphp
<div class="container-fluid">
   <div class="card mt-4 p-3">
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
      
         
      @can('manage project')
      @if (isset($projects) && !empty($projects) && count($projects) > 0)
      <div class="row row-cards mt-2">
       @foreach ($projects as $key => $project)
         <div class="col-md-6 col-lg-2">
            <div class="card">
               <div class="card-body p-2 text-center">

                   <?php $color = sprintf("#%06x",random_int(0,16777215));
                   $project_image=$project->project_image;
                   ?>
                   @if($project_image!=0 && $project_image!='')
                        @php
                        $image=\App\Models\Utility::get_file($project->project_image);
                        @endphp
                       <img id="image"  src="{{$image}}"
                        class="avatar avatar-xl mb-2 rounded" alt="">
                   @else
                       <span class="avatar avatar-xl mb-2 rounded">
                           <?= substr($project->project_name,0,2) ?>
                       </span>
                   @endif
                  <h3 class="mb-0">
               @php
                  $project_instances=\App\Models\Instance::where('project_id',$project->id)
                                    ->get();

               @endphp
               @if(count($project_instances)>1)
                   <a class="text-dark text-capitalize"  data-size="lg"
                   data-url="{{ route('projects.check_instance',$project->id) }}"
                   data-title="Choose Your Revision Planning" data-ajax-popup="true"
                   data-bs-toggle="tooltip">{{ $project->project_name }}{{$project->project_id}}
                  </a>
               @else
                   <a class="text-dark text-capitalize"  data-size="lg"
                   href="{{ route('projects.instance_project',
                           [$project_instances[0]['id'],$project->id,'Base']) }}"
                   data-bs-toggle="tooltip">{{ $project->project_name }}{{$project->project_id}}
                  </a>
               @endif
                  </h3>
                  <p class="text-secondary mb-0"><small style="font-size:10.5px;font-weight: 600">
                    Start Date: {{ Utility::getDateFormated($project->start_date) }}
                    - End Date: {{ Utility::getDateFormated($project->end_date) }}</small></p>
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
                        @php
                           $projectmembers=\App\Models\Project::project_member($project->id);
                        @endphp
                       @if (isset($projectmembers) && !empty($projectmembers)
                       && count($projectmembers) > 0)
                          @foreach ($projectmembers as $key => $user)
                          @php
                           $name_r=\App\Models\Project::get_user_name($user->user_id);
                           $short=substr($name_r->name ?? '', 0, 1);
                          @endphp
                              @if ($key < 3)
                                  @if ($name_r->avatar?? '')

                                      <a href="#" class="">
                                          <img  src="{{(!empty(\Auth::user()->avatar))? $profile.$name_r->avatar :
                                                asset(Storage::url("uploads/avatar/avatar.png"))}}"
                                              alt="{{strtoupper($short)}}" data-bs-toggle="tooltip"
                                              title="{{ $name_r->name }}" class="avatar avatar-sm rounded">
                                      </a>
                                  @else
                                      {{-- <a href="#" class="avatar rounded-circle avatar-sm"> --}}
                                         <span class="avatar avatar-sm rounded" data-bs-toggle="tooltip"
                                          title="{{ $name_r->name?? '' }}">{{strtoupper($short)}}</span>
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
                  $progress=\App\Models\Project::actual_progress($project->id);
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
      @endcan
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
