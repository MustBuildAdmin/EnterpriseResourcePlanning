@php
    if (Session::has('project_id')) {
        $project_id = Session::get('project_id');
    } else {
        $project_id = 0;
    }
    $project=\App\Models\Project::where('id',$project_id)
                                    ->first();
                
   
@endphp
<div class="card sticky-top" style="top:30px">
    <div class="list-group list-group-flush" id="useradd-sidenav">
        <a href="{{ route('projects.view', $project_id) }}" class="list-group-item list-group-item-action border-0
        {{ Request::route()->getName() == 'projects.view' ? 'nav-link active' : 'nav-link' }}
        ">{{__('View Project')}}
          <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        @can('delete project')
        {!! Form::open(['method' => 'DELETE',
                'route' => ['projects.destroy', $project_id]]) !!}
            <a href="#!" class="list-group-item list-group-item-action border-0 dropdown-item bs-pass-para-deleteproject">
                <span> {{ __('Delete') }}</span>
            </a>
            {!! Form::close() !!}
        @endcan
        <a href="{{ route('project_holiday.index', $project_id) }}"
         class="list-group-item list-group-item-action border-0
        {{ Request::route()->getName() == 'project_holiday.index' ? 'nav-link active' : 'nav-link' }}">
            {{__('Holidays')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>


    </div>
</div>