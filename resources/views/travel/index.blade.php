@extends('layouts.admin')

@section('page-title')
    {{__('Manage Trip')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Trip')}}</li>
@endsection


@section('action-btn')
    <div class="float-end">
    @can('create travel')
            <a href="#" data-url="{{ route('travel.create') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Create New Trip')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
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
                                @role('company')
                                <th>{{__('Employee Name')}}</th>
                                @endrole
                                <th>{{__('Start Date')}}</th>
                                <th>{{__('End Date')}}</th>
                                <th>{{__('Purpose of Trip')}}</th>
                                <th>{{__('Country')}}</th>
                                <th>{{__('Description')}}</th>
                                @if(Gate::check('edit travel') || Gate::check('delete travel'))
                                    <th width="200px">{{__('Action')}}</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            @foreach ($travels as $travel)
                                <tr>
                                    @role('company')
                                    <td>{{ !empty($travel->employee())?$travel->employee()->name:'' }}</td>
                                    @endrole
                                    <td>{{ \Auth::user()->dateFormat( $travel->start_date) }}</td>
                                    <td>{{ \Auth::user()->dateFormat( $travel->end_date) }}</td>
                                    <td>{{ $travel->purpose_of_visit }}</td>
                                    <td>{{ $travel->place_of_visit }}</td>
                                    <td>{{ $travel->description }}</td>
                                    @if(Gate::check('edit travel') || Gate::check('delete travel'))
                                        <td>

                                            @can('edit travel')
                                                <div class="action-btn bg-primary ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm align-items-center" data-url="{{ URL::to('travel/'.$travel->id.'/edit') }}" data-ajax-popup="true" data-title="{{__('Edit Trip')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                    <i class="ti ti-pencil text-white"></i>
                                                </a>
                                                </div>
                                           @endcan


                                            @can('delete travel')
                                                <div class="action-btn bg-danger ms-2">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['travel.destroy', $travel->id],'id'=>'delete-form-'.$travel->id]) !!}
                                                        <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$travel->id}}').submit();">
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
