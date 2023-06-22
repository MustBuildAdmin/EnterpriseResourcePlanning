{{ Form::open(['route' => ['projects.tasks.create',$project_id,$stage_id],'id' => 'create_task']) }}
<div class="row">
    <div class="col-8">
        <div class="form-group">
            {{ Form::label('name', __('Task name'),['class' => 'form-label']) }}
            {{ Form::text('name', null, ['class' => 'form-control','required'=>'required']) }}
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            {{ Form::label('milestone_id', __('Milestone'),['class' => 'form-label']) }}
            <select class="form-control" name="milestone_id" id="milestone_id">
                <option value="0"></option>
                @foreach($project->milestones as $m_val)
                    <option value="{{ $m_val->id }}">{{ $m_val->title }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            {{ Form::label('description', __('Description'),['class' => 'form-label']) }}
            <small class="form-text text-muted mb-2 mt-0">{{__('This textarea will autosize while you type')}}</small>
            {{ Form::textarea('description', null, ['class' => 'form-control','rows'=>'1','data-toggle' => 'autosize']) }}
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            {{ Form::label('estimated_hrs', __('Estimated Hours'),['class' => 'form-label']) }}
            <small class="form-text text-muted mb-2 mt-0">{{__('Total hrs of project ').$hrs['total'].__(' & allocated total ').$hrs['allocated'].__(' hrs in other tasks')}}</small>
            {{ Form::number('estimated_hrs', null, ['class' => 'form-control','required' => 'required','min'=>'0','maxlength' => '8']) }}
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            {{ Form::label('priority', __('Priority'),['class' => 'form-label']) }}
            <small class="form-text text-muted mb-2 mt-0">{{__('Set Priority of your task')}}</small>
            <select class="form-control" name="priority" id="priority" required>
                @foreach(\App\Models\ProjectTask::$priority as $key => $val)
                    <option value="{{ $key }}">{{ __($val) }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            {{ Form::label('start_date', __('Start Date'),['class' => 'form-label']) }}
            {{ Form::date('start_date', null, ['class' => 'form-control']) }}
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            {{ Form::label('end_date', __('End Date'),['class' => 'form-label']) }}
            {{ Form::date('end_date', null, ['class' => 'form-control']) }}
        </div>
    </div>
</div>

<div class="form-group">
    <label class="form-label">{{__('Task members')}}</label>
    <small class="form-text text-muted mb-2 mt-0">{{__('Below users are assigned in your project.')}}</small>
</div>
<div class="list-group list-group-flush mb-4">
    <div class="row">
        @foreach($project->users as $user)
            <div class="col-6">
                <div class="list-group-item px-0">
                    <div class="row align-items-center">
                        <div class="col-auto ml-3">
                            <a href="#" class="avatar avatar-sm rounded-circle">
                                <img {{$user->img_avatar}} />
                            </a>
                        </div>
                        <div class="col ml-n2">
                            <p class="d-block h6 text-sm mb-0">{{ $user->name }}</p>
                            <p class="card-text text-sm text-muted mb-0">{{ $user->email }}</p>
                        </div>
                        <div class="col-auto text-end add_usr" data-id="{{ $user->id }}">
                            <button type="button" class="btn btn-xs btn-animated btn-primary rounded-pill btn-animated-y mr-3">
                            <span class="btn-inner--visible">
                              <i class="ti ti-plus" id="usr_icon_{{$user->id}}"></i>
                            </span>
                                <span class="btn-inner--hidden" id="usr_txt_{{$user->id}}">{{__('Add')}}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ Form::hidden('assign_to', null) }}
</div>
<div class="text-end">
    {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-sm btn-primary rounded-pill']) }}
</div>
{{ Form::close() }}
