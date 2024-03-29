@extends('layouts.admin')
@section('page-title')
    {{__('Manage Branch')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Project')}}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        {{-- @can('create branch') --}}
            <a href="#" data-url="{{ route('construction_asign.create') }}"
            data-ajax-popup="true" data-title="{{__('Create New Project')}}"
             data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        {{-- @endcan --}}
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-3">
            @include('layouts.construction_setup')
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-body table-border-style">

                    <div class="table-responsive">
                        <table description="create" class="table datatable">
                            <thead>
                            <tr>
                                <th>{{__('Project')}}</th>
                                <th width="200px">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            @foreach ($projects as $project)
                                <tr>
                                    <td>@isset($project->project_name->name)
                                        {{ $project->project_name->name }}
                                        @endisset </td>
                                    <td class="Action text-end">
                                        <span>

                                            <div class="action-btn bg-primary ms-2">

                                                <a href="#"
                                                class="mx-3 btn btn-sm align-items-center"
                                                data-url="{{ URL::to('construction_asign/'.$project->id.'/edit') }}"
                                                data-ajax-popup="true" data-title="{{__('Edit Project')}}"
                                                data-bs-toggle="tooltip" title="{{__('Edit')}}"
                                                data-original-title="{{__('Edit')}}">
                                                <i class="ti ti-pencil text-white"></i></a>
                                            </div>
                                            <div class="action-btn bg-primary ms-2">

                                                <a href="#" class="mx-3 btn btn-sm align-items-center"
                                                data-url="{{ URL::to('construction_asign/'.$project->id.'/show') }}"
                                                data-ajax-popup="true" data-title="{{__('View Assigned Employee')}}"
                                                data-bs-toggle="tooltip" title="{{__('view')}}"
                                                data-original-title="{{__('view')}}">
                                                <i class="ti ti-eye text-white"></i></a>
                                            </div>

                                            <div class="action-btn bg-danger ms-2">
                                            {!! Form::open(['method' => 'DELETE',
                                            'route' => ['construction_asign.destroy', $project->id],'id'=>'delete-form-'.$project->id]) !!}

                                                <a href="#"
                                                class="mx-3 btn btn-sm align-items-center bs-pass-para"
                                                data-bs-toggle="tooltip" title="{{__('Delete')}}"
                                                data-original-title="{{__('Delete')}}"
                                                data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$project->id}}').submit();"><i class="ti ti-trash text-white text-white"></i></a>
                                            {!! Form::close() !!}
                                            </div>

                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
