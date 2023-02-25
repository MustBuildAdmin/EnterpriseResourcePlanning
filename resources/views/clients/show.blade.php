@extends('layouts.admin')
@php
    //$profile=asset(Storage::url('uploads/avatar/'));
    $profile=\App\Models\Utility::get_file('uploads/avatar/');
@endphp
@section('page-title')
    {{__('Manage Client')}}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('clients.index')}}">{{__('Client')}}</a></li>
    <li class="breadcrumb-item">  {{ ucwords($client->name).__("'s Detail") }}</li>
@endsection
@section('action-btn')

@endsection

@section('content')

    <div class="row">
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <small class="text-muted">{{__('Total Estimate')}}</small>
                            <h3 class="m-0">{{ $cnt_estimation['total'] }} / {{$cnt_estimation['cnt_total']}}</h3>
                        </div>
                        <div class="col-auto">
                            <div class="theme-avtar bg-info">
                                <i class="ti ti-coin"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <small class="text-muted">{{__('This Month Total Estimate')}}</small>
                            <h3 class="m-0">{{ $cnt_estimation['this_month'] }} / {{$cnt_estimation['cnt_this_month']}}</h3>
                        </div>
                        <div class="col-auto">
                            <div class="theme-avtar bg-primary">
                                <i class="ti ti-coin"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <small class="text-muted">{{__('This Week Total Estimate')}}</small>
                            <h3 class="m-0">{{ $cnt_estimation['this_week'] }} / {{$cnt_estimation['cnt_this_week']}}</h3>
                        </div>
                        <div class="col-auto">
                            <div class="theme-avtar bg-warning">
                                <i class="ti ti-coin"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <small class="text-muted">{{__('Last 30 Days Total Estimate')}}</small>
                            <h3 class="m-0">{{ $cnt_estimation['last_30days'] }} / {{$cnt_estimation['cnt_last_30days']}}</h3>
                        </div>
                        <div class="col-auto">
                            <div class="theme-avtar bg-danger">
                                <i class="ti ti-coin"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>

                                <th>{{__('Estimate')}}</th>
                                <th>{{__('Client')}}</th>
                                <th>{{__('Issue Date')}}</th>
                                <th>{{__('Value')}}</th>
                                <th>{{__('Status')}}</th>
                                @if(Auth::user()->type != 'client')
                                    <th width="250px">{{__('Action')}}</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($estimations as $estimate)
                                <tr>
                                    <td class="Id">
                                        @can('View Estimation')
                                            <a href="{{route('estimations.show',$estimate->id)}}"> <i class="ti ti-file-estimate"></i> {{ Auth::user()->estimateNumberFormat($estimate->estimation_id) }}</a>
                                        @else
                                            {{ Auth::user()->estimateNumberFormat($estimate->estimation_id) }}
                                        @endcan
                                    </td>
                                    <td>{{ $estimate->client->name }}</td>
                                    <td>{{ Auth::user()->dateFormat($estimate->issue_date) }}</td>
                                    <td>{{ Auth::user()->priceFormat($estimate->getTotal()) }}</td>
                                    <td>
                                        @if($estimate->status == 0)
                                            <span class="badge badge-pill badge-primary">{{ __(\App\Models\Estimation::$statues[$estimate->status]) }}</span>
                                        @elseif($estimate->status == 1)
                                            <span class="badge badge-pill badge-danger">{{ __(\App\Models\Estimation::$statues[$estimate->status]) }}</span>
                                        @elseif($estimate->status == 2)
                                            <span class="badge badge-pill badge-warning">{{ __(\App\Models\Estimation::$statues[$estimate->status]) }}</span>
                                        @elseif($estimate->status == 3)
                                            <span class="badge badge-pill badge-success">{{ __(\App\Models\Estimation::$statues[$estimate->status]) }}</span>
                                        @elseif($estimate->status == 4)
                                            <span class="badge badge-pill badge-info">{{ __(\App\Models\Estimation::$statues[$estimate->status]) }}</span>
                                        @endif
                                    </td>
                                    @if(Auth::user()->type != 'client')
                                        <td class="Action">
                                        <span>
                                        @can('View Estimation')
                                                <a href="{{route('estimations.show',$estimate->id)}}" class="edit-icon bg-warning" data-bs-toggle="tooltip" data-original-title="{{ __('View') }}"><i class="ti ti-eye"></i></a>
                                            @endcan
                                            @can('Edit Estimation')
                                                <a href="#" data-url="{{ URL::to('estimations/'.$estimate->id.'/edit') }}" data-ajax-popup="true" data-title="{{__('Edit Estimation')}}" class="edit-icon" data-bs-toggle="tooltip" data-original-title="{{__('Edit')}}"><i class="ti ti-pencil text-white"></i></a>
                                            @endcan
                                            @can('Delete Estimation')
                                                <a href="#" class="delete-icon" data-bs-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$estimate->id}}').submit();"><i class="ti ti-trash"></i></a>
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['estimations.destroy', $estimate->id],'id'=>'delete-form-'.$estimate->id]) !!}
                                                {!! Form::close() !!}
                                            @endif
                                        </span>
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
