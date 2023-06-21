@extends('layouts.admin')
@section('page-title')
    {{__('Warehouse')}}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Warehouse')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">

        <a href="#" data-size="lg" data-url="{{ route('warehouse.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create Warehouse')}}"  class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>

    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Address')}}</th>
                                <th>{{__('City')}}</th>
                                <th>{{__('Zip Code')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($warehouses as $warehouse)
                                <tr class="font-style">
                                    <td>{{ $warehouse->name}}</td>
                                    <td>{{ $warehouse->address }}</td>
                                    <td>{{ $warehouse->city }}</td>
                                    <td>{{ $warehouse->city_zip }}</td>

                                    @if(Gate::check('show warehouse') || Gate::check('edit warehouse') || Gate::check('delete warehouse'))
                                        <td class="Action">
                                            @can('show warehouse')
                                                <div class="action-btn bg-warning ms-2">

                                                    <a href="{{ route('warehouse.show',$warehouse->id) }}" class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                       data-bs-toggle="tooltip" title="{{__('View')}}"><i class="ti ti-eye text-white"></i></a>

                                                </div>
                                            @endcan
                                            @can('edit warehouse')
                                                <div class="action-btn bg-info ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center" data-url="{{ route('warehouse.edit',$warehouse->id) }}" data-ajax-popup="true"  data-size="lg " data-bs-toggle="tooltip" title="{{__('Edit')}}"  data-title="{{__('Edit Warehouse')}}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                            @endcan
                                            @can('delete warehouse')
                                                <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['warehouse.destroy', $warehouse->id],'id'=>'delete-form-'.$warehouse->id]) !!}
                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" ><i class="ti ti-trash text-white"></i></a>
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
