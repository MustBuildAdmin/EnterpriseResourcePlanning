@extends('layouts.admin')
@section('page-title')
    {{ucwords($project->project_name).__("'s Tasks")}}
@endsection

@push('css-page')
    <link rel="stylesheet" href="{{asset('css/summernote/summernote-lite.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/dragula.min.css') }}" id="main-style-link">
@endpush
@push('script-page')
    <script src="{{asset('css/summernote/summernote-lite.js')}}"></script>
    <script src="{{ asset('assets/js/plugins/dragula.min.js') }}"></script>
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
                        var sort = [];
                        $("#" + target.id + " > div").each(function () {
                            sort[$(this).index()] = $(this).attr('id');
                        });

                        var id = el.id;
                        var old_stage = $("#" + source.id).data('status');
                        var new_stage = $("#" + target.id).data('status');
                        var project_id = '{{$project->id}}';

                        $("#" + source.id).parent().find('.count').text($("#" + source.id + " > div").length);
                        $("#" + target.id).parent().find('.count').text($("#" + target.id + " > div").length);
                        $.ajax({
                            url: '{{route('tasks.update.order',[$project->id])}}',
                            type: 'PATCH',
                            data: {id: id, sort: sort, new_stage: new_stage, old_stage: old_stage, project_id: project_id, "_token": "{{ csrf_token() }}"},
                            success: function (data) {
                            }
                        });
                    });
                })
            }, a.Dragula = new t, a.Dragula.Constructor = t
        }(window.jQuery), function (a) {
            "use strict";
            a.Dragula.init()
        }(window.jQuery);

        $(document).ready(function () {
            /*Set assign_to Value*/
            $(document).on('click', '.add_usr', function () {
                var ids = [];
                $(this).toggleClass('selected');
                var crr_id = $(this).attr('data-id');
                $('#usr_txt_' + crr_id).html($('#usr_txt_' + crr_id).html() == 'Add' ? '{{__('Added')}}' : '{{__('Add')}}');
                if ($('#usr_icon_' + crr_id).hasClass('fa-plus')) {
                    $('#usr_icon_' + crr_id).removeClass('fa-plus');
                    $('#usr_icon_' + crr_id).addClass('fa-check');
                } else {
                    $('#usr_icon_' + crr_id).removeClass('fa-check');
                    $('#usr_icon_' + crr_id).addClass('fa-plus');
                }
                $('.selected').each(function () {
                    ids.push($(this).attr('data-id'));
                });
                $('input[name="assign_to"]').val(ids);
            });

            $(document).on("click", ".del_task", function () {
                var id = $(this);
                $.ajax({
                    url: $(this).attr('data-url'),
                    type: 'DELETE',
                    dataType: 'JSON',
                    data: {"_token": "{{ csrf_token() }}"},
                    success: function (data) {
                        $('#' + data.task_id).remove();
                        show_toastr('{{__('success')}}', '{{ __("Task Deleted Successfully!")}}');
                    },
                });
            });

            /*For Task Comment*/
            $(document).on('click', '#comment_submit', function (e) {
                var curr = $(this);

                var comment = $.trim($("#form-comment textarea[name='comment']").val());
                if (comment != '') {
                    $.ajax({
                        url: $("#form-comment").data('action'),
                        data: {comment: comment, "_token": "{{ csrf_token() }}"},
                        type: 'POST',
                        success: function (data) {
                            data = JSON.parse(data);
                          
                            var html = "<div class='list-group-item px-0'>" +
                                "                    <div class='row align-items-center'>" +
                                "                        <div class='col-auto'>" +
                                "                            <a href='#' class='avatar avatar-sm rounded-circle ms-2'>" +
                                "                                <img src="+data.default_img+" alt='' class='avatar-sm rounded-circle'>" +
                                "                            </a>" +
                                "                        </div>" +
                                "                        <div class='col ml-n2'>" +
                                "                            <p class='d-block h6 text-sm font-weight-light mb-0 text-break'>" + data.comment + "</p>" +
                                "                            <small class='d-block'>"+data.current_time+"</small>" +
                                "                           </div>" +
                                "                        <div class='action-btn bg-danger me-4'><div class='col-auto'><a href='#' class='mx-3 btn btn-sm  align-items-center delete-comment' data-url='" + data.deleteUrl + "'><i class='ti ti-trash text-white'></i></a></div></div>" +
                                "                    </div>" +
                                "                </div>";

                            $("#comments").prepend(html);
                            $("#form-comment textarea[name='comment']").val('');
                            load_task(curr.closest('.task-id').attr('id'));
                            show_toastr('{{__('success')}}', '{{ __("Comment Added Successfully!")}}');
                        },
                        error: function (data) {
                            show_toastr('error', '{{ __("Some Thing Is Wrong!")}}');
                        }
                    });
                } else {
                    show_toastr('error', '{{ __("Please write comment!")}}');
                }
            });
            $(document).on("click", ".delete-comment", function () {
                var btn = $(this);

                $.ajax({
                    url: $(this).attr('data-url'),
                    type: 'DELETE',
                    dataType: 'JSON',
                    data: {"_token": "{{ csrf_token() }}"},
                    success: function (data) {
                        load_task(btn.closest('.task-id').attr('id'));
                        show_toastr('{{__('success')}}', '{{ __("Comment Deleted Successfully!")}}');
                        btn.closest('.list-group-item').remove();
                    },
                    error: function (data) {
                        data = data.responseJSON;
                        if (data.message) {
                            show_toastr('error', data.message);
                        } else {
                            show_toastr('error', '{{ __("Some Thing Is Wrong!")}}');
                        }
                    }
                });
            });

            /*For Task Checklist*/
            $(document).on('click', '#checklist_submit', function () {
                var name = $("#form-checklist input[name=name]").val();
                if (name != '') {
                    $.ajax({
                        url: $("#form-checklist").data('action'),
                        data: {name: name, "_token": "{{ csrf_token() }}"},
                        type: 'POST',
                        success: function (data) {
                            data = JSON.parse(data);
                          
                            load_task($('.task-id').attr('id'));
                            show_toastr('{{__('success')}}', '{{ __("Checklist Added Successfully!")}}');
                            var html = '<div class="card border shadow-none checklist-member">' +
                                '                    <div class="px-3 py-2 row align-items-center">' +
                                '                        <div class="col">' +
                                '                            <div class="form-check form-check-inline">' +
                                '                                <input type="checkbox" class="form-check-input" id="check-item-' + data.id + '" value="' + data.id + '" data-url="' + data.updateUrl + '">' +
                                '                                <label class="form-check-label h6 text-sm" for="check-item-' + data.id + '">' + data.name + '</label>' +
                                '                            </div>' +
                                '                        </div>' +
                                '                        <div class="col-auto"> <div class="action-btn bg-danger ms-2">' +
                                '                            <a href="#" class="mx-3 btn btn-sm  align-items-center delete-checklist" role="button" data-url="' + data.deleteUrl + '">' +
                                '                                <i class="ti ti-trash text-white"></i>' +
                                '                            </a>' +
                                '                        </div></div>' +
                                '                    </div>' +
                                '                </div>'

                            $("#checklist").append(html);
                            $("#form-checklist input[name=name]").val('');
                            $("#form-checklist").collapse('toggle');
                        },
                        error: function (data) {
                            data = data.responseJSON;
                            show_toastr('error', data.message);
                        }
                    });
                } else {
                    show_toastr('error', '{{ __("Please write checklist name!")}}');
                }
            });
            $(document).on("change", "#checklist input[type=checkbox]", function () {
                $.ajax({
                    url: $(this).attr('data-url'),
                    type: 'POST',
                    dataType: 'JSON',
                    data: {"_token": "{{ csrf_token() }}"},
                    success: function (data) {
                        load_task($('.task-id').attr('id'));
                        show_toastr('{{__('Success')}}', '{{ __("Checklist Updated Successfully!")}}', 'success');
                    },
                    error: function (data) {
                        data = data.responseJSON;
                        if (data.message) {
                            show_toastr('error', data.message);
                        } else {
                            show_toastr('error', '{{ __("Some Thing Is Wrong!")}}');
                        }
                    }
                });
            });
            $(document).on("click", ".delete-checklist", function () {
                var btn = $(this);
                $.ajax({
                    url: $(this).attr('data-url'),
                    type: 'DELETE',
                    dataType: 'JSON',
                    data: {"_token": "{{ csrf_token() }}"},
                    success: function (data) {
                        load_task($('.task-id').attr('id'));
                        show_toastr('{{__('success')}}', '{{ __("Checklist Deleted Successfully!")}}');
                        btn.closest('.checklist-member').remove();
                    },
                    error: function (data) {
                        data = data.responseJSON;
                        if (data.message) {
                            show_toastr('error', data.message);
                        } else {
                            show_toastr('error', '{{ __("Some Thing Is Wrong!")}}');
                        }
                    }
                });
            });

            /*For Task Attachment*/
            $(document).on('click', '#file_attachment_submit', function () {
                var file_data = $("#task_attachment").prop("files")[0];
                if (file_data != '' && file_data != undefined) {
                    var formData = new FormData();
                    formData.append('file', file_data);
                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: $("#file_attachment_submit").data('action'),
                        type: 'POST',
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            $('#task_attachment').val('');
                            $('.attachment_text').html('{{__('Choose a file…')}}');
                            data = JSON.parse(data);
                            load_task(data.task_id);
                            show_toastr('{{__('success')}}', '{{ __("File Added Successfully!")}}');

                            var delLink = '';
                            if (data.deleteUrl.length > 0) {
                                delLink = ' <div class="action-btn bg-danger "><a href="#" class="action-item delete-comment-file" role="button" data-url="' + data.deleteUrl + '">' +
                                    '                                        <i class="ti ti-trash text-white"></i>' +
                                    '                                    </a></div>';
                            }

                            var html = '<div class="card mb-3 border shadow-none task-file">' +
                                '                    <div class="px-3 py-3">' +
                                '                        <div class="row align-items-center">' +
                                '                            <div class="col ml-n2">' +
                                '                                <h6 class="text-sm mb-0">' +
                                '                                    <a href="#">' + data.name + '</a>' +
                                '                                </h6>' +
                                '                                <p class="card-text small text-muted">' + data.file_size + '</p>' +
                                '                           </div>' +
                                '                            <div class="col-auto"> <div class="action-btn bg-secondary ">' +
                                '                                <a href="{{asset(Storage::url('tasks'))}}/' + data.file + '" download class="action-item" role="button">' +
                                '                                    <i class="ti ti-download text-white"></i>' +
                                '                                </a>' +
                                '                            </div></div>' +
                                delLink +
                                '                        </div>' +
                                '                    </div>' +
                                '                </div>'

                            $("#comments-file").prepend(html);
                        },
                        error: function (data) {
                            data = data.responseJSON;
                          
                            if (data.message) {
                                show_toastr('error', data.errors.file[0]);
                                $('#file-error').text(data.errors.file[0]).show();
                            } else {
                                show_toastr('error', '{{ __("Some Thing Is Wrong!")}}');
                            }
                        }
                    });
                } else {
                    show_toastr('error', '{{ __("Please select file!")}}');
                }
              
            });
            $(document).on("click", ".delete-comment-file", function () {
                var btn = $(this);
                $.ajax({
                    url: $(this).attr('data-url'),
                    type: 'DELETE',
                    dataType: 'JSON',
                    data: {"_token": "{{ csrf_token() }}"},
                    success: function (data) {
                        load_task(btn.closest('.task-id').attr('id'));
                        show_toastr('{{__('success')}}', '{{ __("File Deleted Successfully!")}}');
                        btn.closest('.task-file').remove();
                    },
                    error: function (data) {
                        data = data.responseJSON;
                        if (data.message) {
                            show_toastr('error', data.message);
                        } else {
                            show_toastr('error', '{{ __("Some Thing Is Wrong!")}}');
                        }
                    }
                });
            });

            /*For Favorite*/
            $(document).on('click', '#add_favourite', function () {
                $.ajax({
                    url: $(this).attr('data-url'),
                    type: 'POST',
                    data: {"_token": "{{ csrf_token() }}"},
                    success: function (data) {
                        if (data.fav == 1) {
                            $('#add_favourite').addClass('action-favorite');
                        } else if (data.fav == 0) {
                            $('#add_favourite').removeClass('action-favorite');
                        }
                    }
                });
            });

            /*For Complete*/
            $(document).on('change', '#complete_task', function () {
                $.ajax({
                    url: $(this).attr('data-url'),
                    type: 'POST',
                    data: {"_token": "{{ csrf_token() }}"},
                    success: function (data) {
                        if (data.com == 1) {
                            $("#complete_task").prop("checked", true);
                        } else if (data.com == 0) {
                            $("#complete_task").prop("checked", false);
                        }
                        $('#' + data.task).insertBefore($('#task-list-' + data.stage + ' .empty-container'));
                        load_task(data.task);
                    }
                });
            });

            /*Progress Move*/
            $(document).on('change', '#task_progress', function () {
                var progress = $(this).val();
                $('#t_percentage').html(progress);
                $.ajax({
                    url: $(this).attr('data-url'),
                    data: {progress: progress, "_token": "{{ csrf_token() }}"},
                    type: 'POST',
                    success: function (data) {
                        load_task(data.task_id);
                    }
                });
            });
        });

        function load_task(id) {
            $.ajax({
                url: "{{route('projects.tasks.get','_task_id')}}".replace('_task_id', id),
                dataType: 'html',
                data: {"_token": "{{ csrf_token() }}"},
                success: function (data) {
                    $('#' + id).html('');
                    $('#' + id).html(data);
                }
            });
        }

    </script>

@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('projects.index')}}">{{__('Project')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('projects.show',$project->id)}}">{{ucwords($project->project_name)}}</a></li>
    <li class="breadcrumb-item">{{__('Task')}}</li>
@endsection
@section('action-btn')
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="row kanban-wrapper horizontal-scroll-cards" data-containers='{{json_encode($stageClass)}}' data-plugin="dragula">
                @foreach($stages as $stage)
                    @php($tasks = $stage->tasks)
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                @can('create project task')
                                    <div class="float-end">
                                        <a href="#" data-size="lg" data-url="{{ route('projects.tasks.create',[$project->id,$stage->id]) }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Add Task in ').$stage->name}}" class="btn btn-sm btn-primary">
                                            <i class="ti ti-plus"></i>
                                        </a>
                                    </div>
                                @endcan
                                <h4 class="mb-0">{{$stage->name}}</h4>
                            </div>
                            <div class="card-body kanban-box" id="task-list-{{$stage->id}}" data-status="{{$stage->id}}">
                                @foreach($tasks as $taskDetail)
                                    <div class="card draggable-item" id="{{$taskDetail->id}}">
                                        <div class="pt-3 ps-3">
                                            <div class="badge-xs badge bg-{{\App\Models\ProjectTask::$priority_color[$taskDetail->priority]}} p-2 px-3 rounded">{{ __(\App\Models\ProjectTask::$priority[$taskDetail->priority]) }}</div>
                                        </div>
                                        <div class="card-header border-0 pb-0 position-relative">
                                            <h5>
                                                <a href="#" data-url="{{ route('projects.tasks.show',[$project->id,$taskDetail->id]) }}" data-ajax-popup="true" data-size="lg" data-bs-original-title="{{$taskDetail->name}}">{{$taskDetail->name}}</a>
                                            </h5>
                                            <div class="card-header-right">
                                                <div class="btn-group card-option">
                                                    <button type="button" class="btn dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                        <i class="ti ti-dots-vertical"></i>
                                                    </button>

                                                    <div class="dropdown-menu dropdown-menu-end">

                                                        @can('view project task')
                                                            <a href="#!" data-size="md" data-url="{{ route('projects.tasks.show',[$project->id,$taskDetail->id]) }}" data-ajax-popup="true" class="dropdown-item" data-bs-original-title="{{__('View')}}">
                                                                <i class="ti ti-bookmark"></i>
                                                                <span>{{__('View')}}</span>
                                                            </a>
                                                        @endcan
                                                        @can('edit project task')
                                                            <a href="#!" data-size="lg" data-url="{{ route('projects.tasks.edit',[$project->id,$taskDetail->id]) }}" data-ajax-popup="true" class="dropdown-item" data-bs-original-title="{{__('Edit ').$taskDetail->name}}">
                                                                <i class="ti ti-pencil"></i>
                                                                <span>{{__('Edit')}}</span>
                                                            </a>
                                                        @endcan
                                                        @can('delete project task')
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['projects.tasks.destroy', [$project->id,$taskDetail->id]]]) !!}
                                                            <a href="#!" class="dropdown-item bs-pass-para">
                                                                <i class="ti ti-archive"></i>
                                                                <span> {{__('Delete')}} </span>
                                                            </a>
                                                            {!! Form::close() !!}
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item d-inline-flex align-items-center" data-bs-toggle="tooltip" title="{{__('Files')}}">
                                                        <i class="f-16 text-primary ti ti-file"></i> {{ count($taskDetail->taskFiles) }}
                                                    </li>
                                                    <li class="list-inline-item d-inline-flex align-items-center" data-bs-toggle="tooltip" title="{{__('Task Progress')}}">
                                                        @if(str_replace('%','',$taskDetail->taskProgress()['percentage']) > 0)<span class="text-md">{{ $taskDetail->taskProgress()['percentage'] }}</span>@endif
                                                    </li>
                                                </ul>
                                                <div class="user-group">
                                                    @if(!empty($taskDetail->end_date) && $taskDetail->end_date != '0000-00-00')<span data-bs-toggle="tooltip" title="{{__('End Date')}}" @if(strtotime($taskDetail->end_date) < time())class="text-danger"@endif>{{ Utility::getDateFormated($taskDetail->end_date) }}</span>@endif
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <ul class="list-inline mb-0">

                                                    <li class="list-inline-item d-inline-flex align-items-center" data-bs-toggle="tooltip" title="{{__('Comments')}}">
                                                        <i class="f-16 text-primary ti ti-message"></i> {{ count($taskDetail->comments) }}
                                                    </li>

                                                    <li class="list-inline-item d-inline-flex align-items-center" data-bs-toggle="tooltip" title="{{__('Task Checklist')}}">
                                                        <i class="f-16 text-primary ti ti-list"></i>{{ $taskDetail->countTaskChecklist() }}
                                                    </li>
                                                </ul>
                                                <div class="user-group">
                                                    @foreach($taskDetail->users() as $user)
                                                        <img @if($user->avatar) src="{{asset('/storage/uploads/avatar/'.$user->avatar)}}" @else src="{{asset('/storage/uploads/avatar/avatar.png')}}" @endif alt="image" data-bs-toggle="tooltip" title="{{(!empty($user)?$user->name:'')}}">
                                                    @endforeach
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
