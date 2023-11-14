@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{__('Support')}}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 ">{{__('Support')}}</h5>
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Support')}}</li>
@endsection
<div class=container-fluid>
@section('action-btn')
    <div class="float-end">
        <a href="{{ route('support.grid') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{__('Grid View')}}">
            <i class="ti ti-layout-grid text-white"></i>
        </a>

       <a href="#" data-size="lg" data-url="{{ route('support.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create Support')}}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>

    </div>
@endsection

@section('content')


<div class="row">


    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mb-3 mb-sm-0">
                        <div class="d-flex align-items-center">
                            <div class="theme-avtar bg-primary">
                                <i class="ti ti-cast"></i>
                            </div>
                            <div class="ms-3">
                                <small class="text-muted">{{__('Total')}}</small>
                                <h6 class="m-0">{{__('Ticket')}}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto text-end">
                        <h3 class="m-0">{{ $countTicket }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mb-3 mb-sm-0">
                        <div class="d-flex align-items-center">
                            <div class="theme-avtar bg-info">
                                <i class="ti ti-cast"></i>
                            </div>
                            <div class="ms-3">
                                <small class="text-muted">{{__('Open')}}</small>
                                <h6 class="m-0">{{__('Ticket')}}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto text-end">
                        <h3 class="m-0">{{ $countOpenTicket }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mb-3 mb-sm-0">
                        <div class="d-flex align-items-center">
                            <div class="theme-avtar bg-warning">
                                <i class="ti ti-cast"></i>
                            </div>
                            <div class="ms-3">
                                <small class="text-muted">{{__('On Hold')}}</small>
                                <h6 class="m-0">{{__('Ticket')}}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto text-end">
                        <h3 class="m-0">{{ $countonholdTicket }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mb-3 mb-sm-0">
                        <div class="d-flex align-items-center">
                            <div class="theme-avtar bg-danger">
                                <i class="ti ti-cast"></i>
                            </div>
                            <div class="ms-3">
                                <small class="text-muted">{{__('Close')}}</small>
                                <h6 class="m-0">{{__('Ticket')}}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto text-end">
                        <h3 class="m-0">{{ $countCloseTicket }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                <table class="table datatable">
                        <thead>
                        <tr>
                            <th scope="col">{{__('Created By')}}</th>
                            <th scope="col">{{__('Ticket')}}</th>
                            <th scope="col">{{__('Code')}}</th>
                            <th scope="col">{{__('Attachment')}}</th>
                            <th scope="col">{{__('Assign User')}}</th>
                            <th scope="col">{{__('Status')}}</th>
                            <th scope="col">{{__('Created At')}}</th>
                            <th scope="col" >{{__('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        @php
                            $supportpath=\App\Models\Utility::get_file('uploads/supports');
                        @endphp
                        @foreach($supports as $support)

                            <tr>
                                <td scope="row">
                                    <div class="media align-items-center">
                                        <div>
                                            <div class="avatar-parent-child">
                                                <img alt="" class="avatar rounded-circle avatar-sm" @if(!empty($support->createdBy) && !empty($support->createdBy->avatar)) src="{{asset(Storage::url('uploads/avatar')).'/'.$support->createdBy->avatar}}" @else  src="{{asset(Storage::url('uploads/avatar')).'/avatar.png'}}" @endif>
                                                @if($support->replyUnread()>0)
                                                    <span class="avatar-child avatar-badge bg-success"></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            {{!empty($support->createdBy)?$support->createdBy->name:''}}
                                        </div>
                                    </div>
                                </td>
                                <td scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <a href="{{ route('support.reply',\Crypt::encrypt($support->id)) }}" class="name h6 mb-0 text-sm">{{$support->subject}}</a><br>
                                            @if($support->priority == 0)
                                                <span data-toggle="tooltip" data-title="{{__('Priority')}}" class="text-capitalize badge bg-primary p-2 px-3 rounded">   {{ __(\App\Models\Support::$priority[$support->priority]) }}</span>
                                            @elseif($support->priority == 1)
                                                <span data-toggle="tooltip" data-title="{{__('Priority')}}" class="text-capitalize badge bg-info p-2 px-3 rounded">   {{ __(\App\Models\Support::$priority[$support->priority]) }}</span>
                                            @elseif($support->priority == 2)
                                                <span data-toggle="tooltip" data-title="{{__('Priority')}}" class="text-capitalize badge bg-warning p-2 px-3 rounded">   {{ __(\App\Models\Support::$priority[$support->priority]) }}</span>
                                            @elseif($support->priority == 3)
                                                <span data-toggle="tooltip" data-title="{{__('Priority')}}" class="text-capitalize badge bg-danger p-2 px-3 rounded">   {{ __(\App\Models\Support::$priority[$support->priority]) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td>{{$support->ticket_code}}</td>
{{--                                <td>--}}
{{--                                    @if(!empty($support->attachment))--}}
{{--                                        <div class="action-btn bg-primary ms-2">--}}

{{--                                        <a href="{{asset(Storage::url('uploads/supports')).'/'.$support->attachment}}"
                                                download=""
                                                 class="mx-3 btn btn-sm align-items-center" target="_blank" rel="noopener">--}}

{{--                                                <i class="ti ti-download text-white" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Download') }}"></i></a>--}}
{{--                                        </div>--}}
{{--                                            <div class="action-btn bg-secondary ms-2">--}}
{{--                                            <a class="mx-3 btn btn-sm align-items-center" href="{{asset(Storage::url('uploads/supports')).'/'.$support->attachment}}" target="_blank"  >--}}
{{--                                                <i class="ti ti-crosshair text-white" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Preview') }}"></i>--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
{{--                                    @else--}}
{{--                                        ---}}
{{--                                    @endif--}}
{{--                                </td>--}}

                                <td>
                                    @if(!empty($support->attachment))
                                        <a  class="action-btn bg-primary ms-2 btn btn-sm align-items-center"
                                         href="{{ $supportpath . '/' . $support->attachment }}" download="" rel="noopener">
                                            <i class="ti ti-download text-white"></i>
                                        </a>
                                        <a href="{{ $supportpath . '/' . $support->attachment }}"
                                            class="action-btn bg-secondary ms-2 mx-3 btn btn-sm align-items-center"
                                            data-bs-toggle="tooltip" title="{{__('Download')}}" target="_blank" rel="noopener">
                                            <span class="btn-inner--icon">
                                                <i class="ti ti-crosshair text-white" ></i>
                                            </span>
                                        </a>
                                    @else
                                        -
                                    @endif

                                </td>

                                <td>{{!empty($support->assignUser)?$support->assignUser->name:'-'}}</td>

                                <td>
                                    @if($support->status == 'Open')
                                        <span class="status_badge text-capitalize badge bg-success p-2 px-3 rounded">{{ __(\App\Models\Support::$status[$support->status]) }}</span>
                                    @elseif($support->status == 'Close')
                                        <span class="status_badge text-capitalize badge bg-danger p-2 px-3 rounded">{{ __(\App\Models\Support::$status[$support->status]) }}</span>
                                    @elseif($support->status == 'On Hold')
                                        <span  class="status_badge text-capitalize badge bg-warning p-2 px-3 rounded">{{ __(\App\Models\Support::$status[$support->status]) }}</span>
                                    @endif
                                </td>



                                <td>{{\Auth::user()->dateFormat($support->created_at)}}</td>

                                <td class="Action">
                                <span>
                                    <div class="action-btn bg-warning ms-2">
                                        <a href="{{ route('support.reply',\Crypt::encrypt($support->id)) }}" data-title="{{__('Support Reply')}}" class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="{{__('Reply')}}" data-original-title="{{__('Reply')}}">
                                            <i class="ti ti-corner-up-left text-white"></i>
                                        </a>
                                    </div>
                                    @if(\Auth::user()->type=='company' || \Auth::user()->id==$support->ticket_created)
                                        <div class="action-btn bg-primary ms-2">
                                            <a href="#" data-size="lg" data-url="{{ route('support.edit',$support->id) }}" data-ajax-popup="true" data-title="{{__('Edit Support')}}" class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                <i class="ti ti-pencil text-white"></i>
                                            </a>
                                        </div>

                                            <div class="action-btn bg-danger ms-2">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['support.destroy', $support->id],'id'=>'delete-form-'.$support->id]) !!}

                                                <a href="#!" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can be delete your ticket . Do you want to continue?" title="{{__('Delete')}}" data-confirm-yes="document.getElementById('delete-form-{{$support->id}}').submit();">
                                                    <i class="ti ti-trash text-white"></i>
                                                </a>
                                            </div>
                                            {!! Form::close() !!}
                                        @endif
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
</div>
@endsection

