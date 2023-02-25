@extends('layouts.admin')

@section('page-title')
    {{__('Manage Loan Option')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Loan Option')}}</li>
@endsection


@section('action-btn')
    <div class="float-end">
        @can('create loan option')
            <a href="#" data-url="{{ route('loanoption.create') }}" data-ajax-popup="true" data-title="{{__('Create New Loan Option')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
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
                                <th>{{__('Loan Option')}}</th>
                                <th width="200px">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            @foreach ($loanoptions as $loanoption)
                                <tr>
                                    <td>{{ $loanoption->name }}</td>
                                    <td>
                                        @can('edit loan option')
                                            <div class="action-btn bg-primary ms-2">
                                                <a href="#" class="mx-3 btn btn-sm align-items-center" data-url="{{ URL::to('loanoption/'.$loanoption->id.'/edit') }}" data-ajax-popup="true" data-title="{{__('Edit Loan Option')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                    <i class="ti ti-pencil text-white"></i>
                                                </a>
                                            </div>
                                        @endcan
                                        @can('delete loan option')
                                            <div class="action-btn bg-danger ms-2">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['loanoption.destroy', $loanoption->id],'id'=>'delete-form-'.$loanoption->id]) !!}
                                                <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}"><i class="ti ti-trash text-white text-white"></i></a>
                                                {!! Form::close() !!}
                                            </div>
                                        @endcan

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div
        </div>
    </div>


@endsection
