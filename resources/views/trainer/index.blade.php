@extends('layouts.admin')
@section('page-title')
    {{__('Manage Trainer')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Trainer')}}</li>
@endsection

@section('action-btn')
    <div class="float-end">
    @can('create trainer')
    
            <a href="#" data-size="lg" data-url="{{ route('trainer.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create New Trainer')}}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
        @endcan
    </div>

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
            <div class="card-body table-border-style">
                    <div class="table-responsive">
                    <table class="table datatable">
                            <thead>
                            <tr>
                                <th>{{__('Branch')}}</th>
                                <th>{{__('Full Name')}}</th>
                                <th>{{__('Contact')}}</th>
                                <th>{{__('Email')}}</th>
                                @if( Gate::check('edit trainer') ||Gate::check('delete trainer') ||Gate::check('show trainer'))
                                    <th width="200px">{{__('Action')}}</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            @foreach ($trainers as $trainer)
                                <tr>
                                    <td>{{ !empty($trainer->branches)?$trainer->branches->name:'' }}</td>
                                    <td>{{$trainer->firstname .' '.$trainer->lastname}}</td>
                                    <td>{{$trainer->contact}}</td>
                                    <td>{{$trainer->email}}</td>
                                    @if( Gate::check('edit trainer') ||Gate::check('delete trainer') || Gate::check('show trainer'))
                                        <td>
                                            @can('show trainer')
                                            <div class="action-btn bg-info ms-2">
                                                <a href="#" data-url="{{ route('trainer.show',$trainer->id) }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Trainer Detail')}}" class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="{{__('View')}}" data-original-title="{{__('View Detail')}}">
                                                <i class="ti ti-eye text-white"></i>
                                                </a>
                                            </div>
                                                @endcan
                                            @can('edit trainer')
                                            <div class="action-btn bg-primary ms-2">
                                                <a href="#" data-url="{{ route('trainer.edit',$trainer->id) }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Trainer')}}" class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                <i class="ti ti-pencil text-white"></i>
                                                </a>
                                            </div>
                                                @endcan
                                            @can('delete trainer')
                                            <div class="action-btn bg-danger ms-2">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['trainer.destroy', $trainer->id],'id'=>'delete-form-'.$trainer->id]) !!}

                                                <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$trainer->id}}').submit();" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}">
                                                <i class="ti ti-trash text-white"></i>

                                                </a>
                                                {!! Form::close() !!}
                                            </div>
                                            @endcan
                                        </td>
                                    @endif
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
