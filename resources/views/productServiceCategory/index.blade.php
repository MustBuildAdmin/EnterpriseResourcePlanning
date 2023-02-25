@extends('layouts.admin')
@section('page-title')
    {{__('Manage Product-Service & Income-Expense Category')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Category')}}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        @can('create constant category')
            <a href="#" data-url="{{ route('product-category.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" title="{{__('Create')}}" data-title="{{__('Create New Category')}}"  class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        @endcan
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-3">
            @include('layouts.account_setup')
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th> {{__('Category')}}</th>
                                <th> {{__('Type')}}</th>
                                <th width="10%"> {{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td class="font-style">{{ $category->name }}</td>
                                    <td class="font-style">
                                        {{ __(\App\Models\ProductServiceCategory::$categoryType[$category->type]) }}
                                    </td>
                                    <td class="Action">
                                        <span>
                                        @can('edit constant category')
                                                <div class="action-btn bg-primary ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm align-items-center" data-url="{{ route('product-category.edit',$category->id) }}" data-ajax-popup="true" data-title="{{__('Edit Product Category')}}" data-bs-toggle="tooltip" title="{{__('Create')}}" data-original-title="{{__('Edit')}}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                            @endcan
                                            @can('delete constant category')
                                                <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['product-category.destroy', $category->id],'id'=>'delete-form-'.$category->id]) !!}
                                                    <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$category->id}}').submit();">
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
