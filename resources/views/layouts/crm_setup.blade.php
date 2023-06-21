<div class="card sticky-top" style="top:30px">
    <div class="list-group list-group-flush" id="useradd-sidenav">
        <a href="{{route('pipelines.index')}}" class="list-group-item list-group-item-action border-0 {{ (Request::route()->getName() == 'pipelines.index' ) ? ' active' : '' }}">{{__('Pipeline')}} <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="{{ route('lead_stages.index') }}" class="list-group-item list-group-item-action border-0 {{ (Request::route()->getName() == 'lead_stages.index' ) ? 'active' : '' }}">{{__('Lead Stages')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="{{ route('stages.index') }}" class="list-group-item list-group-item-action border-0 {{ (Request::route()->getName() == 'stages.index' ) ? ' active' : '' }}">{{__('Deal Stages')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="{{ route('sources.index') }}" class="list-group-item list-group-item-action border-0 {{ (Request::route()->getName() == 'sources.index' ) ? 'active' : '' }}   ">{{__('Sources')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="{{ route('labels.index') }}" class="list-group-item list-group-item-action border-0 {{ (Request::route()->getName() == 'labels.index' ) ? 'active' : '' }}   ">{{__('Labels')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="{{ route('contractType.index') }}" class="list-group-item list-group-item-action border-0 {{ (Request::route()->getName() == 'contractType.index' ) ? 'active' : '' }}   ">{{__('Contract Type')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

    </div>
</div>
