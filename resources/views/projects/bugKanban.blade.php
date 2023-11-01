@extends('layouts.admin')
@section('page-title')
    {{__('Manage Bug Report')}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('projects.index')}}">{{__('Project')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('projects.show',$project->id)}}">    {{ucwords($project->project_name)}}</a></li>
    <li class="breadcrumb-item">{{__('Bug Report')}}</li>
@endsection
@push('css-page')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/dragula.min.css') }}" id="main-style-link">
@endpush
@push('script-page')

    <script src="{{ asset('assets/js/plugins/dragula.min.js') }}"  integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script>
    <script>
        !function (a) {
            "use strict";
            var t = function () {
                this.$body = a("body")
            };
            t.prototype.init = function () {
                a('[data-plugin="dragula"]').each(function () {
                    var t = a(this).data("containers"), n = [];
                    if (t) for (var i = 0; i < t.length; i++) n.push(a("#" + t[i])[0]); else n = [a(this)[0]];
                    var r = a(this).data("handleclass");
                    r ? dragula(n, {
                        moves: function (a, t, n) {
                            return n.classList.contains(r)
                        }
                    }) : dragula(n).on('drop', function (el, target, source, sibling) {

                        var order = [];
                        $("#" + target.id).each(function () {
                            order[$(this).index()] = $(this).attr('data-id');
                        });

                        var id = $(el).attr('id');

                        var stage_id = $(target).attr('data-id');

                        $("#" + source.id).parent().find('.count').text($("#" + source.id + " > div").length);
                        $("#" + target.id).parent().find('.count').text($("#" + target.id + " > div").length);

                        $.ajax({
                            url: '{{route('bug.kanban.order')}}',
                            type: 'POST',
                            data: {bug_id: id, status_id: stage_id, order: order, "_token": $('meta[name="csrf-token"]').attr('content')},
                            success: function (data) {
                                show_toastr('success', "Bug Moved Successfully.", 'success');
                            },
                            error: function (data) {
                                data = data.responseJSON;
                                show_toastr('error', "something went wrong. ", 'error');
                            }
                        });

                    });
                })
            }, a.Dragula = new t, a.Dragula.Constructor = t
        }(window.jQuery), function (a) {
            "use strict";

            a.Dragula.init()

        }(window.jQuery);
    </script>
    <script>
        $(document).on('click', '#form-comment button', function (e) {
            var comment = $.trim($("#form-comment textarea[name='comment']").val());
            var name = '{{\Auth::user()->name}}';
            if (comment != '') {
                $.ajax({
                    url: $("#form-comment").data('action'),
                    data: {comment: comment, "_token": $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    success: function (data) {
                        data = JSON.parse(data);
                        var html = "<li class='media mb-20'>" +
                            "                    <div class='media-body'>" +
                            "                    <div class='d-flex justify-content-between align-items-end'><div>" +
                            "                        <h5 class='mt-0'>" + name + "</h5>" +
                            "                        <p class='mb-0 text-xs'>" + data.comment + "</p></div>" +
                            "                           <div class='comment-trash' style=\"float: right\">" +
                            "                               <a href='#' class='btn btn-sm red btn-danger delete-comment' data-url='" + data.deleteUrl + "' >" +
                            "                                   <i class='ti ti-trash'></i>" +
                            "                               </a>" +
                            "                           </div>" +
                            "                           </div>" +
                            "                    </div>" +
                            "                </li>";

                        $("#comments").prepend(html);
                        $("#form-comment textarea[name='comment']").val('');
                        show_toastr('{{__("success")}}', '{{ __("Comment Added Successfully!")}}', 'success');
                    },
                    error: function (data) {
                        show_toastr('{{__("error")}}', '{{ __("Some Thing Is Wrong!")}}', 'error');
                    }
                });
            } else {
                show_toastr('{{__("error")}}', '{{ __("Please write comment!")}}', 'error');
            }
        });

        $(document).on("click", ".delete-comment", function () {
            if (confirm('Are You Sure ?')) {
                var btn = $(this);
                $.ajax({
                    url: $(this).attr('data-url'),
                    type: 'DELETE',
                    data: {_token: $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'JSON',
                    success: function (data) {
                        show_toastr('{{__("Success")}}', '{{ __("Comment Deleted Successfully!")}}', 'success');
                        btn.closest('.media').remove();
                    },
                    error: function (data) {
                        data = data.responseJSON;
                        if (data.message) {
                            show_toastr('{{__("Error")}}', data.message, 'error');
                        } else {
                            show_toastr('{{__("Error")}}', '{{ __("Some Thing Is Wrong!")}}', 'error');
                        }
                    }
                });
            }
        });

        $(document).on('submit', '#form-file', function (e) {
            e.preventDefault();
            $.ajax({
                url: $("#form-file").data('url'),
                type: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    show_toastr('{{__("success")}}', '{{ __("File Added Successfully!")}}', 'success');
                    var delLink = '';

                    $('.file_update').html('');
                    $('#file-error').html('');

                    if (data.deleteUrl.length > 0) {
                        delLink = "<a href='#' class='text-danger text-muted delete-comment-file'  data-url='" + data.deleteUrl + "'>" +
                            "                                        <i class='dripicons-trash'></i>" +
                            "                                    </a>";
                    }

                    var html = '<div class="col-8 mb-2 file-' + data.id + '">' +
                        '                                    <h5 class="mt-0 mb-1 font-weight-bold text-sm"> ' + data.name + '</h5>' +
                        '                                    <p class="m-0 text-xs">' + data.file_size + '</p>' +
                        '                                </div>' +
                        '                                <div class="col-4 mb-2 file-' + data.id + '">' +
                        '                                    <div class="comment-trash" style="float: right">' +
                        '                                        <a download href="{{asset(Storage::url('bugs'))}}/' + data.file + '" class="btn btn-sm btn-primary">' +
                        '                                            <i class="ti ti-download"></i>' +
                        '                                        </a>' +
                        '                                        <a href="#" class="btn btn-sm red btn-danger delete-comment-file m-0 px-2" data-id="' + data.id + '" data-url="' + data.deleteUrl + '">' +
                        '                                            <i class="ti ti-trash"></i>' +
                        '                                        </a>' +
                        '                                    </div>' +
                        '                                </div>';

                    $("#comments-file").prepend(html);
                },
                error: function (data) {
                    data = data.responseJSON;
                    if (data.message) {
                        $('#file-error').text(data.errors.file[0]).show();
                    } else {
                        show_toastr('{{__("error")}}', '{{ __("Some Thing Is Wrong!")}}', 'error');
                    }
                }
            });
        });

        $(document).on("click", ".delete-comment-file", function () {
            if (confirm('Are You Sure ?')) {
                var btn = $(this);
                $.ajax({
                    url: $(this).attr('data-url'),
                    type: 'DELETE',
                    data: {_token: $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'JSON',
                    success: function (data) {
                        show_toastr('{{__("Success")}}', '{{ __("File Deleted Successfully!")}}', 'success');
                        $('.file-' + btn.attr('data-id')).remove();
                    },
                    error: function (data) {
                        data = data.responseJSON;
                        if (data.message) {
                            show_toastr('{{__("Error")}}', data.message, 'error');
                        } else {
                            show_toastr('{{__("Error")}}', '{{ __("Some Thing Is Wrong!")}}', 'error');
                        }
                    }
                });
            }
        });
    </script>

@endpush
@section('action-btn')
    <div class="float-end">
        @can('manage bug report')
            <a href="{{ route('task.bug',$project->id) }}" data-bs-toggle="tooltip" title="{{__('List')}}" class="btn btn-sm btn-primary">
                <i class="ti ti-list"></i>
            </a>
        @endcan
        @can('create bug report')
            <a href="#" data-size="lg" data-url="{{ route('task.bug.create',$project->id) }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create New Bug')}}" class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        @endcan
    </div>
@endsection

@section('content')
    @php
        $json = [];
        foreach ($bugStatus as $status){
            $json[] = 'task-list-'.$status->id;
        }
    @endphp
    <div class="row">
        <div class="col-sm-12">
            <div class="row kanban-wrapper horizontal-scroll-cards" data-containers='{{json_encode($json)}}' data-plugin="dragula">
                @foreach($bugStatus as $status)
                    @php $bugs = $status->bugs($project->id) @endphp
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <div class="float-end">
{{--                                    {{count($bugs)}}--}}
                                    <span class="btn btn-sm btn-primary btn-icon count">
                                        {{count($bugs)}}
                                    </span>
                                </div>
                                <h4 class="mb-0">{{$status->title}}</h4>
                            </div>
                            <div class="card-body kanban-box" id="task-list-{{$status->id}}" data-id="{{$status->id}}">
                                @foreach($bugs as $bug)
                                    <div class="card draggable-item" id="{{$bug->id}}">
                                        <div class="pt-3 ps-3">
                                            @if($bug->priority =='low')
                                                <span class="p-2 px-3 rounded badge badge-pill badge-xs bg-success">{{ ucfirst($bug->priority) }}</span>
                                            @elseif($bug->priority =='medium')
                                                <span class="p-2 px-3 rounded badge badge-pill badge-xs bg-warning">{{ ucfirst($bug->priority) }}</span>
                                            @elseif($bug->priority =='high')
                                                <span class="p-2 px-3 rounded badge badge-pill badge-xs bg-danger">{{ ucfirst($bug->priority) }}</span>
                                            @endif
                                        </div>
                                        <div class="card-header border-0 pb-0 position-relative">
                                            <h5>
                                                <a href="#" data-url="{{ route('task.bug.show',[$project->id,$bug->id]) }}" data-ajax-popup="true" data-size="lg" data-bs-original-title="{{$bug->title}}">{{$bug->title}}</a>
                                            </h5>
                                            <div class="card-header-right">
                                                <div class="btn-group card-option">
                                                    <button type="button" class="btn dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                        <i class="ti ti-dots-vertical"></i>
                                                    </button>
                                                    @if(Gate::check('edit bug report') || Gate::check('delete bug report'))
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            @can('edit project task')
                                                                <a href="#!" data-size="lg" data-url="{{ route('task.bug.edit',[$project->id,$bug->id]) }}" data-ajax-popup="true" class="dropdown-item" data-bs-original-title="{{__('Edit ').$bug->name}}">
                                                                    <i class="ti ti-pencil"></i>
                                                                    <span>{{__('Edit')}}</span>
                                                                </a>
                                                            @endcan
                                                            @can('delete project task')
                                                                {!! Form::open(['method' => 'DELETE', 'route' => ['task.bug.destroy', [$project->id,$bug->id]]]) !!}
                                                                <a href="#!" class="dropdown-item bs-pass-para">
                                                                    <i class="ti ti-archive"></i>
                                                                    <span> {{__('Delete')}} </span>
                                                                </a>
                                                                {!! Form::close() !!}
                                                            @endcan
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item d-inline-flex align-items-center" data-bs-toggle="tooltip" title="{{__('Start Date')}}">
                                                         {{ \Auth::user()->dateFormat($bug->start_date) }}
                                                    </li>

                                                </ul>
                                                <div class="user-group">
                                                    <span data-bs-toggle="tooltip" title="{{__('End Date')}}">  {{ \Auth::user()->dateFormat($bug->due_date) }}</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                @php $user = $bug->users(); @endphp

                                                <div class="user-group">
                                                    <img @if(isset($user[0]->avatar)) src="{{asset('/storage/uploads/avatar/'.$user[0]->avatar)}}" @else src="{{asset('/storage/uploads/avatar/avatar.png')}}" @endif alt="image" data-bs-toggle="tooltip" title="{{(!empty($user[0])?$user[0]->name:'')}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
