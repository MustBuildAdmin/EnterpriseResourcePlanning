@extends('layouts.admin')
@section('page-title')
    {{ $formBuilder->name.__("'s Form Field") }}
@endsection
@push('script-page')

@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('form_builder.index')}}">{{__('Form Builder')}}</a></li>
    <li class="breadcrumb-item">{{__('Add Field')}}</li>
@endsection
@section('action-btn')
    @can('create form field')
        <div class="float-end">
            <a href="#" data-size="md" data-url="{{ route('form.field.create',$formBuilder->id) }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create New Filed')}}" class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        </div>
    @endcan
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
                                <th>{{__('Type')}}</th>
                                <th class="text-end" width="200px">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($formBuilder->form_field->count())
                                @foreach ($formBuilder->form_field as $field)
                                    <tr>
                                        <td>{{ $field->name }}</td>
                                        <td>{{ ucfirst($field->type) }}</td>
                                        <td class="text-end">
                                            @can('edit form builder')
                                                <div class="action-btn bg-info ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-url="{{ route('form.field.edit',[$formBuilder->id,$field->id]) }}" data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Form Builder Edit')}}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                            @endcan
                                            @can('delete form builder')
                                                <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['form.field.destroy', [$formBuilder->id,$field->id]]]) !!}
                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}"><i class="ti ti-trash text-white"></i></a>
                                                    {!! Form::close() !!}
                                                </div>
                                            @endcan

                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
