@extends('layouts.admin')
@section('page-title')
    {{__('Manage Designation')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Designation')}}</li>
@endsection


@section('action-btn')
    <div class="float-end">
        @can('create designation')
            <a href="#" data-url="{{ route('designation.create') }}" data-ajax-popup="true" data-title="{{__('Create New Designation')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        @endcan
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-3">
            @include('layouts.hrm_setup')
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th>{{__('Department')}}</th>
                                <th>{{__('Designation')}}</th>
                                <th width="200px">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            @foreach ($designations as $designation)
                                @php
                                    $department = \App\Models\Department::where('id', $designation->department_id)->first();
                                @endphp
                                <tr>
                                    <td>{{ !empty($department->name)?$department->name:'' }}</td>
                                    <td>{{ $designation->name }}</td>

                                    <td class="Action">
                                        <span>

                                            @can('edit designation')
                                                <div class="action-btn bg-primary ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm align-items-center" data-url="{{route('designation.edit',$designation->id) }}" data-ajax-popup="true" data-title="{{__('Edit Designation')}}" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                            @endcan

                                            @can('delete designation')
                                                <div class="action-btn bg-danger ms-2">

                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['designation.destroy', $designation->id],'id'=>'delete-form-'.$designation->id]) !!}
                                                        <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$designation->id}}').submit();">
                                                            <i class="ti ti-trash text-white"></i>
                                                        </a>
                                                    {!! Form::close() !!}
                                                </div>
                                            @endcan

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
