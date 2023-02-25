@extends('layouts.admin')

@section('page-title')
    {{__('Manage Complain')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Complain')}}</li>
@endsection

@section('action-btn')
    <div class="float-end">
    @can('create complaint')
            <a href="#" data-url="{{ route('complaint.create') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Create New Complaint')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
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
                                <th>{{__('Complaint From')}}</th>
                                <th>{{__('Complaint Against')}}</th>
                                <th>{{__('Title')}}</th>
                                <th>{{__('Complaint Date')}}</th>
                                <th>{{__('Description')}}</th>
                                @if(Gate::check('edit complaint') || Gate::check('delete complaint'))
                                    <th>{{__('Action')}}</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            @foreach ($complaints as $complaint)

                                <tr>
                                    <td>{{!empty( $complaint->complaintFrom($complaint->complaint_from))? $complaint->complaintFrom($complaint->complaint_from)->name:'' }}</td>
                                    <td>{{ !empty($complaint->complaintAgainst($complaint->complaint_against))?$complaint->complaintAgainst($complaint->complaint_against)->name:'' }}</td>
                                    <td>{{ $complaint->title }}</td>
                                    <td>{{ \Auth::user()->dateFormat( $complaint->complaint_date) }}</td>
                                    <td>{{ $complaint->description }}</td>
                                    @if(Gate::check('edit complaint') || Gate::check('delete complaint'))
                                        <td>

                                            @can('edit complaint')
                                                <div class="action-btn bg-primary ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm align-items-center" data-url="{{ URL::to('complaint/'.$complaint->id.'/edit') }}" data-ajax-popup="true" data-title="{{__('Edit Complaint')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                    <i class="ti ti-pencil text-white"></i>
                                                </a>
                                                </div>
                                           @endcan


                                            @can('delete complaint')
                                                <div class="action-btn bg-danger ms-2">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['complaint.destroy', $complaint->id],'id'=>'delete-form-'.$complaint->id]) !!}
                                                    <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$complaint->id}}').submit();">
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
