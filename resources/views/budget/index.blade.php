@extends('layouts.admin')
@section('page-title')
    {{__('Manage Budget Planner')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Budget Planner')}}</li>
@endsection

@section('action-btn')
    @can('create budget plan')
        <div class="float-end">
            <a href="{{ route('budget.create',0) }}" data-bs-toggle="tooltip" title="{{__('Create')}}" class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        </div>
    @endcan
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th> {{__('Name')}}</th>
                                <th> {{__('From')}}</th>
                                {{--                                <th> {{__('To')}}</th>--}}
                                <th> {{__('Budget Period')}}</th>
                                <th width="10%"> {{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($budgets as $budget)
                                <tr>
                                    <td class="font-style">{{ $budget->name }}</td>
                                    <td class="font-style">{{ $budget->from }}</td>
                                    {{--                                    <td class="font-style">{{ $budget->to }}</td>--}}
                                    <td class="font-style">{{ __(\App\Models\Budget::$period[$budget->period]) }}</td>
                                    <td class="Action">
                                        <span>
                                            @can('edit budget plan')
                                                <div class="action-btn bg-primary ms-2">
                                                 <a href="{{ route('budget.edit',Crypt::encrypt($budget->id)) }}" class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                    <i class="ti ti-pencil text-white"></i>
                                                </a>
                                            </div>
                                            @endcan
                                            @can('view budget plan')
                                                <div class="action-btn bg-info ms-2">
                                                    <a href="{{ route('budget.show',\Crypt::encrypt($budget->id)) }}" class="mx-3 btn btn-sm align-items-center " data-bs-toggle="tooltip" title="{{__('View')}}" data-original-title="{{__('Detail')}}">
                                                        <i class="ti ti-eye text-white"></i>
                                                    </a>
                                            </div>
                                            @endcan
                                            @can('delete budget plan')
                                                <div class="action-btn bg-danger ms-2">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['budget.destroy', $budget->id],'id'=>'delete-form-'.$budget->id]) !!}

                                                <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$budget->id}}').submit();">
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
