@extends('layouts.admin')
@section('page-title')
    {{__('Manage Contract')}}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Contract')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="{{ route('contract.index') }}" data-bs-toggle="tooltip" title="{{__('List View')}}" class="btn btn-sm btn-primary">
            <i class="ti ti-list"></i>
        </a>
        @if(\Auth::user()->type == 'company')
            <a href="#" data-size="md" data-url="{{ route('contract.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create New Contract')}}" class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        @endif
    </div>
@endsection

@section('content')
    <div class="row">
        @foreach ($contracts as $contract)
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <a href="{{route('contract.show',$contract->id)}}" class="mb-0">{{ $contract->subject}}</a>
                    @if(\Auth::user()->type == 'company')
                            <div class="card-header-right">
                                <div class="btn-group card-option">
                                    <button type="button" class="btn dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="#!" data-size="md" data-url="{{ route('contract.edit',$contract->id) }}" data-ajax-popup="true" class="dropdown-item" data-bs-original-title="{{__('Edit User')}}">
                                            <i class="ti ti-pencil"></i>
                                            <span>{{__('Edit')}}</span>
                                        </a>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['contract.destroy', $contract->id]]) !!}
                                        <a href="#!" class="dropdown-item bs-pass-para">
                                            <i class="ti ti-archive"></i>
                                            <span> {{__('Delete')}}</span>
                                        </a>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-body py-3 flex-grow-1">
                        <p class="text-sm mb-0">
                            {{ $contract->description}}
                        </p>
                    </div>
                    <div class="card-footer py-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <span class="form-label">{{__('Contract Type')}}:</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <span class="badge bg-secondary p-2 px-3 rounded">{{ !empty($contract->types)?$contract->types->name:'' }}</span>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item px-0">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <span class="form-label">{{__('Contract Value')}}:</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <span class="badge bg-secondary p-2 px-3 rounded">{{ \Auth::user()->priceFormat($contract->value) }}</span>
                                    </div>
                                </div>
                            </li>
                            @if(\Auth::user()->type!='client')
                                <li class="list-group-item px-0">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <span class="form-label">{{__('Client')}}:</span>
                                        </div>
                                        <div class="col-6 text-end">
                                            {{ !empty($contract->clients)?$contract->clients->name:'' }}
                                        </div>
                                    </div>
                                </li>
                            @endif
                            <li class="list-group-item px-0">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <small>{{__('Start Date')}}:</small>
                                        <div class="h6 mb-0">{{  \Auth::user()->dateFormat($contract->start_date )}}</div>
                                    </div>
                                    <div class="col-6">
                                        <small>{{__('End Date')}}:</small>
                                        <div class="h6 mb-0">{{  \Auth::user()->dateFormat($contract->end_date )}}</div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
