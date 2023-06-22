@extends('layouts.admin')
@section('page-title')
    {{__('Company_type')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Company_type')}}</li>
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{__('Company_type')}}</h5>
    </div>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="#" data-size="lg" data-url="{{ route('company_type.create') }}" data-ajax-popup="true"  data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
            <div class="card-body table-border-style">
                    <div class="table-responsive">
                    <table class="table header " width="100%">
                            <tbody>
                            @if($companytype->count() > 0)
                                @foreach($companytype as $prequest)

                                <thead>
                                <tr>
                                    <th>{{__('Name')}}</th>
                                    <th>{{__('Date')}}</th>
                                    <th>{{__('Action')}}</th>

                                </tr>
                                </thead>

                                    <tr>
                                        <td>
                                            <div class="font-style ">{{ $prequest->name }}</div>
                                        </td>
                                        <td>{{ Utility::getDateFormated($prequest->created_at,true) }}</td>
                                        <td>
                                            <div style="display: flex;">
                                                <a href="#" data-size="lg" data-url="{{ route('company_type.edit',$prequest->id) }}" data-ajax-popup="true"  data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                                <div class="action-btn bg-danger ms-2">

                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['company_type.destroy', $prequest->id],'id'=>'delete-form-'.$prequest->id]) !!}
                                                        <a href="#" class="btn btn-sm btn-danger align-items-center bs-pass-para" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$prequest->id}}').submit();">
                                                            <i class="ti ti-trash text-white"></i>
                                                        </a>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <th scope="col" colspan="7"><h6 class="text-center">{{__('No Manually company type Found.')}}</h6></th>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
