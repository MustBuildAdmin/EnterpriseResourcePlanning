<div class="modal-body">
<?php //echo "<pre>"; print_r($get_project_instances); ?>
    <div class="row">
        @foreach ($get_project_instances as $key => $project)
            <div class="col-md-6 col-xxl-6 divstyle">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header border-0 pb-0">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0"><a class="text-dark" href="{{ route('projects.instance_project', [$project->id,$project->project_id]) }}">Revision {{$key+1}}</a></h5>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-0 mt-3">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-6">
                                    <h6
                                        class="mb-0 {{ strtotime($project->start_date) < time() ? 'text-danger' : '' }}">
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