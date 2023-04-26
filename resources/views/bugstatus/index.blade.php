@extends('layouts.admin')
@section('page-title')
    {{__('Manage Project Bug Status')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Project Bug Status')}}</li>
@endsection
@push('script-page')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    @if(\Auth::user()->type=='company')
        <script>
            $(function () {
                $(".sortable").sortable();
                $(".sortable").disableSelection();
                $(".sortable").sortable({
                    stop: function () {
                        var order = [];
                        $(this).find('li').each(function (index, data) {
                            order[index] = $(data).attr('data-id');
                        });

                        $.ajax({
                            url: "{{route('bugstatus.order')}}",
                            data: {order: order, _token: $('meta[name="csrf-token"]').attr('content')},
                            type: 'POST',
                            success: function (data) {
                            },
                            error: function (data) {
                                data = data.responseJSON;
                                toastr('Error', data.error, 'error')
                            }
                        })
                    }
                });
            });
        </script>
    @endif
@endpush


@section('action-btn')
    @can('create bug status')
        <div class="float-end">
            <a href="#" data-url="{{ route('bugstatus.create') }}"  data-bs-toggle="tooltip" title="{{__('Create')}}" class="btn btn-sm btn-primary" data-ajax-popup="true" data-title="{{__('Create Bug Stage')}}">
                <i class="ti ti-plus"></i>

            </a>

        </div>
    @endcan
@endsection


@section('content')
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-10 col-xxl-8">
            <div class="card mt-5">
                <div class="card-body">
                    <div class="tab-content" id="pills-tabContent">
                        @php($i=0)
                        @foreach ($bugStatus as $key => $bug)

                            <div class="tab-pane fade show  @if($i==0) active @endif" role="tabpanel">
                                <ul class="list-group sortable">
                                    @foreach ($bugStatus as $bug)
                                        <li class="list-group-item" data-id="{{$bug->id}}">
                                            <span class="text-sm text-dark">{{$bug->title}}</span>
                                            <span class="float-end">
                                            @can('edit bug status')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" data-url="{{ URL::to('bugstatus/'.$bug->id.'/edit') }}" data-ajax-popup="true"  data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit Bug Status')}}" class="mx-3 btn btn-sm d-inline-flex align-items-center">
                                                          <i class="ti ti-pencil text-white"></i>
                                                      </a>
                                                    </div>
                                                @endcan
                                            @can('delete bug status')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['bugstatus.destroy', $bug->id],'id'=>'delete-form-'.$bug->id]) !!}
                                                              <a href="#!" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$bug->id}}').submit();">
                                                                    <i class="ti ti-trash text-white"></i>
                                                              </a>
                                                        {!! Form::close() !!}
                                                    </div>

                                                @endcan
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            @php($i++)
                        @endforeach
                    </div>
                    <p class="text-muted mt-4"><strong>{{__('Note')}} : </strong>{{__('You can easily change order of project Bug status using drag & drop.')}}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
