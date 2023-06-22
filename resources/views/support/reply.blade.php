@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{__('Support Reply')}}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 ">{{__('Support Reply')}}</h5>
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('support.index')}}">{{__('Support')}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{__('Support Reply')}}</li>
@endsection
@section('action-btn')
@endsection
@section('filter')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">{{$support->subject}}</h6>
                </div>
                @if(!empty($support->descroption))
                    <div class="card-body py-3 flex-grow-1">
                        <p class="text-sm mb-0">
                            {{$support->descroption}}
                        </p>
                    </div>
                @endif
                <div class="card-footer py-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="form-label">{{__('Created By')}}:</span>
                                </div>
                                <div class="col-6 text-end">
                                    {{!empty($support->createdBy)?$support->createdBy->name:''}}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="form-label">{{__('Ticket Code')}}:</span>
                                </div>
                                <div class="col-6 text-end">
                                    {{$support->ticket_code}}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="form-label">{{__('Priority')}}:</span>
                                </div>
                                <div class="col-6 text-end">
                                    @if($support->priority == 0)
                                        <span class="badge bg-primary p-2 px-3 rounded">   {{ __(\App\Models\Support::$priority[$support->priority]) }}</span>
                                    @elseif($support->priority == 1)
                                        <span class="badge bg-info p-2 px-3 rounded">   {{ __(\App\Models\Support::$priority[$support->priority]) }}</span>
                                    @elseif($support->priority == 2)
                                        <span class="badge bg-warning p-2 px-3 rounded">   {{ __(\App\Models\Support::$priority[$support->priority]) }}</span>
                                    @elseif($support->priority == 3)
                                        <span class="badge bg-danger p-2 px-3 rounded">   {{ __(\App\Models\Support::$priority[$support->priority]) }}</span>
                                    @endif
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="form-label">{{__('Status')}}:</span>
                                </div>
                                <div class="col-6 text-end">
                                    @if($support->status == 'Open')
                                        <span class="badge bg-primary p-2 px-3 rounded"> {{__('Open')}}</span>
                                    @elseif($support->status == 'Close')
                                        <span class="badge bg-danger p-2 px-3 rounded">   {{ __('Closed') }}</span>
                                    @elseif($support->status == 'On Hold')
                                        <span class="badge bg-warning p-2 px-3 rounded">   {{ __('On Hold') }}</span>
                                    @endif
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <small>{{__('Start Date')}}:</small>
                                    <div class="h6 mb-0">{{\Auth::user()->dateFormat($support->created_at)}}</div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if($support->status == 'Open')
                    <h5 class="mt-0 mb-3">{{__('Comments')}}</h5>
                    {{ Form::open(array('route' => array('support.reply.answer',$support->id))) }}
                    <textarea class="form-control form-control-light mb-2" name="description" placeholder="Your comment" id="example-textarea" rows="3" required=""></textarea>
                    <div class="text-end">
                        <div class=" mb-2 ml-2">
                            {{Form::submit(__('Send'),array('class'=>'btn btn-primary'))}}
                        </div>
                    </div>
                    {{ Form::close() }}
                    @endif

                    <div class="scrollbar-inner">
                        <div class="list-group list-group-flush support-reply-box">
                            @foreach($replyes as $reply)
                              


                                 <div class="list-group-item px-0">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <a href="#" class="avatar avatar-sm ms-2">
                                <img alt="" class=" " @if(!empty($reply->users) && !empty($reply->users->avatar)) src="{{asset(Storage::url('uploads/avatar/')).'/'.$reply->users->avatar}}" @else  src="{{asset(Storage::url('uploads/avatar/')).'/avatar.png'}}" @endif>
                                </a>
                            </div>
                            <div class="col ml-n2">
                                <span class="text-dark text-sm">{{!empty($reply->users)?$reply->users->name:''}} </span>
                                <a class="d-block h6 text-sm font-weight-light mb-0">{{$reply->description}}</a>
                                <small class="d-block">{{$reply->created_at}}</small>
                            </div>
                        </div>
                    </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

