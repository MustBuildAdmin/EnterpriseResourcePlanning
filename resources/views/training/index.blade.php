@extends('layouts.admin')

@section('page-title')
    {{__('Manage Training')}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Training')}}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        @can('create training')
            <a href="#" data-size="lg" data-url="{{ route('training.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create New Training')}}" class="btn btn-sm btn-primary">
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
                                <th>{{__('Training Type')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Employee')}}</th>
                                <th>{{__('Trainer')}}</th>
                                <th>{{__('Training Duration')}}</th>
                                <th>{{__('Cost')}}</th>
                                <th width="200px">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            @foreach ($trainings as $training)
                                <tr>
                                    <td>{{ !empty($training->branches)?$training->branches->name:'' }}</td>
                                    <td>{{ !empty($training->types)?$training->types->name:'' }}
                                    </td>
                                    <td>
                                        @if($training->status == 0)
                                            <span class="status_badge badge bg-warning p-2 px-3 rounded">{{ __($status[$training->status]) }}</span>
                                        @elseif($training->status == 1)
                                            <span class="status_badge badge bg-primary p-2 px-3 rounded">{{ __($status[$training->status]) }}</span>
                                        @elseif($training->status == 2)
                                            <span class="status_badge badge bg-success p-2 px-3 rounded">{{ __($status[$training->status]) }}</span>
                                        @elseif($training->status == 3)
                                            <span class="status_badge badge bg-info p-2 px-3 rounded">{{ __($status[$training->status]) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ !empty($training->employees)?$training->employees->name:'' }} </td>
                                    <td>{{ !empty($training->trainers)?$training->trainers->firstname:'' }}</td>
                                    <td>{{\Auth::user()->dateFormat($training->start_date) .' to '.\Auth::user()->dateFormat($training->end_date)}}</td>
                                    <td>{{\Auth::user()->priceFormat($training->training_cost)}}</td>
                                    @if( Gate::check('edit training') ||Gate::check('delete training') || Gate::check('show training'))
                                        <td>


                                            <div class="action-btn bg-info ms-2">
                                                <a href="{{ route('training.show',\Illuminate\Support\Facades\Crypt::encrypt($training->id)) }}" class="mx-3 btn btn-sm  align-items-center" data-bs-toggle="tooltip" title="{{__('View')}}" data-original-title="{{__('View Detail')}}">
                                                    <i class="ti ti-eye text-white"></i>
                                                </a>

                                            </div>

                                            @can('edit training')
                                                <div class="action-btn bg-primary ms-2">
                                                    <a href="#" data-url="{{ route('training.edit',$training->id) }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Training')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit ')}}" class="mx-3 btn btn-sm  align-items-center">
                                                        <i class="ti ti-pencil text-white"></i></a>
                                                </div>
                                            @endcan
                                            @can('delete training')
                                                <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['training.destroy', $training->id],'id'=>'delete-form-'.$training->id]) !!}
                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$training->id}}').submit();" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}">
                                                        <i class="ti ti-trash text-white"></i></a>
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
