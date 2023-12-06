<div class="modal-body">
    <?php //echo "<pre>"; print_r($get_project_instances); exit; ?>
        <div class="row">
            @php $row=0; @endphp
            @foreach ($get_project_instances as $key => $project)

                <div class="col-md-6 col-xxl-6 divstyle">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header border-0 pb-0">
                                <div class="d-flex justify-content-between">
                                    @if($key==0)
                                         @php  $name='Main'; @endphp
                                        <h5 class="mb-0"><a class="text-dark"
                                        href="{{ route('projects.instance_project',
                                             [$project->id,$project->project_id,$name]) }}">Main</a></h5>
                                    @else
                                        @php $row=$row+1;
                                        $name='Revision'.$row; @endphp
                                        <h5 class="mb-0"><a class="text-dark"
                                        href="{{ route('projects.instance_project',
                                             [$project->id,$project->project_id,$name]) }}">Revision {{$row}}</a></h5>
                                    @endif
                                    @php
                                        if ($lastInstance->id == $project->id){
                                            $status_set = 'complete';
                                        }
                                        else{
                                            $status_set = 'on_hold';
                                        }
                                    @endphp
                                    <span class="badge bg-{{ \App\Models\Project::$status_color[$status_set] }}-lt">
                                    {{ __(\App\Models\Project::$freeze_status[$status_set]) }}
                                    </span>
                                </div>
                                
                            </div>
                        </div>
                        <div class="card m-0">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-6">
                                        <h6
                                            class="mb-0
                                            {{ strtotime($project->start_date) < time() ? 'text-danger' : '' }}">
                                            {{ Utility::getDateFormated($project->start_date) }}</h6>
                                        <p class="text-muted text-sm mb-0">{{ __('Start Date') }}</p>
                                    </div>
                                    <div class="col-6 text-end">
                                        <h6 class="mb-0">
                                            {{ Utility::getDateFormated($project->end_date) }}</h6>
                                        <p class="text-muted text-sm mb-0">{{ __('Due Date') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
