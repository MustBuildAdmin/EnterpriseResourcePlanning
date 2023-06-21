@extends('layouts.admin')
@section('page-title')
    {{__('Manage Zoom Meeting')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Zoom Meeting')}}</li>
@endsection


@push('script-page')
    <script src="{{url('assets/js/daterangepicker.js')}}"></script>
    <script type="text/javascript">

        $(document).on("click", '.member_remove', function () {
            var rid = $(this).attr('data-id');
            $('.confirm_yes').addClass('m_remove');
            $('.confirm_yes').attr('uid', rid);
            $('#cModal').modal('show');
        });
        $(document).on('click', '.m_remove', function (e) {
            var id = $(this).attr('uid');
            var p_url = "{{url('zoom-meeting')}}"+'/'+id;
            var data = {id: id};
            deleteAjax(p_url, data, function (res) {
                toastrs(res.flag, res.msg);
                if(res.flag == 1){
                    location.reload();
                }
                $('#cModal').modal('hide');
            });
        });
    </script>
@endpush


@section('action-btn')
    <div class="float-end">

        <a href="{{ route('zoom-meeting.calender') }}"  data-original-title="{{__('Calendar View')}}" class="btn btn-sm btn-primary">
            <i class="ti ti-calendar"></i> {{__('Calendar View')}}
        </a>

       <a href="#" data-size="lg" data-url="{{ route('zoom-meeting.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create  New Meeting')}}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>

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
                                <th> {{ __('Title') }} </th>
                                <th> {{ __('Project') }}  </th>
                                <th> {{ __('User') }}  </th>
                                <th> {{ __('Client') }}  </th>
                                <th >{{ __('Meeting Time') }}</th>
                                <th >{{ __('Duration') }}</th>
                                <th >{{ __('Join URL') }}</th>
                                <th >{{ __('Status') }}</th>
                                <th class="text-end"> {{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>

                            @forelse ($meetings as $item)

                                <tr>
                                    <td>{{$item->title}}</td>
                                    <td>{{ !empty($item->projectName)?$item->projectName:'' }}</td>
{{--                                    <td>{{ !empty($item->userName)?$item->userName->name:'' }}</td>--}}
                                <td>
                                    <div class="avatar-group">
                                        @foreach($item->users($item->user_id) as $projectUser)
                                            <a href="#" class="avatar rounded-circle avatar-sm avatar-group">
                                                <img alt="" @if(!empty($users->avatar)) src="{{$profile.'/'.$projectUser->avatar}}" @else  avatar="{{(!empty($projectUser)?$projectUser->name:'')}}" @endif data-original-title="{{(!empty($projectUser)?$projectUser->name:'')}}" data-toggle="tooltip" data-original-title="{{(!empty($projectUser)?$projectUser->name:'')}}" class="">
                                            </a>
                                        @endforeach
                                    </div>

                                </td>


                                @if(\Auth::user()->type == 'company')
                                        <td>{{$item->client_name}}</td>
                                    @endif
                                    <td>{{$item->start_date}}</td>
                                    <td>{{$item->duration}} {{__("Minutes")}}</td>

                                    <td>
                                        @if($item->created_by == \Auth::user()->id && $item->checkDateTime())

                                            <a href="{{$item->start_url}}" target="_blank"> {{__('Start meeting')}} <i class="ti ti-external-link-square-alt "></i></a>
                                        @elseif($item->checkDateTime())
                                            <a href="{{$item->join_url}}" target="_blank"> {{__('Join meeting')}} <i class="ti ti-external-link-square-alt "></i></a>
                                        @else
                                            -
                                        @endif

                                    </td>
                                    <td>
                                        @if($item->checkDateTime())
                                            @if($item->status == 'waiting')
                                                <span class="badge bg-info p-2 px-3 rounded">{{ucfirst($item->status)}}</span>
                                            @else
                                                <span class="badge bg-success p-2 px-3 rounded">{{ucfirst($item->status)}}</span>
                                            @endif
                                        @else
                                            <span class="badge bg-danger p-2 px-3 rounded">{{__("End")}}</span>
                                        @endif
                                    </td>
                                    @if(\Auth::user()->type == 'company')
                                        <td class="text-end">
                                        <div class="action-btn bg-danger ms-2">
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['zoom-meeting.destroy', $item->id],'id'=>'delete-form-'.$item->id]) !!}

                                            <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$item->id}}').submit();"><i class="ti ti-trash text-white"></i></a>
                                            {!! Form::close() !!}
                                        </div>

                                        </td>
                                    @endif
                                </tr>
                            @empty

                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


