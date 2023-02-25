@extends('layouts.admin')

@section('page-title')
    {{__('Tasks')}}
@endsection


@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('projects.index')}}">{{__('Project')}}</a></li>
    <li class="breadcrumb-item">{{__('Task')}}</li>
@endsection

@section('action-btn')
<div class="float-end">

        <a href="#" class="btn btn-primary btn-sm" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="btn-inner--icon"><i class="ti ti-filter"></i></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-steady" id="task_sort">
            <a class="dropdown-item active" href="#" data-val="created_at-desc">
                <i class="ti ti-sort-amount-down"></i>{{__('Newest')}}
            </a>
            <a class="dropdown-item" href="#" data-val="created_at-asc">
                <i class="ti ti-sort-amount-up"></i>{{__('Oldest')}}
            </a>
            <a class="dropdown-item" href="#" data-val="name-asc">
                <i class="ti ti-sort-alpha-down"></i>{{__('From A-Z')}}
            </a>
            <a class="dropdown-item" href="#" data-val="name-desc">
                <i class="ti ti-sort-alpha-up"></i>{{__('From Z-A')}}
            </a>
        </div>


        <a href="#" class="btn btn-primary btn-sm" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="btn-inner--icon">{{__('Status')}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right task-filter-actions dropdown-steady" id="task_status">
            <a class="dropdown-item filter-action filter-show-all pl-4" href="#">{{__('Show All')}}</a>
            <hr class="my-0">
            <a class="dropdown-item filter-action pl-4 active" href="#" data-val="see_my_tasks">{{ __('See My Tasks') }}</a>
            <hr class="my-0">
            @foreach(\App\Models\ProjectTask::$priority as $key => $val)
                <a class="dropdown-item filter-action pl-4" href="#" data-val="{{ $key }}">{{__($val)}}</a>
            @endforeach
            <hr class="my-0">
            <a class="dropdown-item filter-action filter-other pl-4" href="#" data-val="due_today">{{ __('Due Today') }}</a>
            <a class="dropdown-item filter-action filter-other pl-4" href="#" data-val="over_due">{{ __('Over Due') }}</a>
            <a class="dropdown-item filter-action filter-other pl-4" href="#" data-val="starred">{{ __('Starred') }}</a>
        </div>

    @if($view == 'grid')
        <a href="{{ route('taskBoard.view', 'list') }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" title="{{__('List View')}}">
            <span class="btn-inner--text"><i class="ti ti-list"></i>{{__('List View')}}</span>
        </a>
    @else
        <a href="{{ route('taskBoard.view', 'grid') }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" title="{{__('Grid View')}}">
            <span class="btn-inner--text"><i class="ti ti-table"></i></span>
        </a>
    @endif

</div>

@endsection

@section('content')
    <div class="row min-750" id="taskboard_view"></div>
@endsection

@push('script-page')
    <script>
        // ready
        $(function () {
            var sort = 'created_at-desc';
            var status = '';
            ajaxFilterTaskView('created_at-desc', '', ['see_my_tasks']);

            // when change status
            $(".task-filter-actions").on('click', '.filter-action', function (e) {
                if ($(this).hasClass('filter-show-all')) {
                    $('.filter-action').removeClass('active');
                    $(this).addClass('active');
                } else {

                    $('.filter-show-all').removeClass('active');
                    if ($(this).hasClass('filter-other')) {
                        $('.filter-other').removeClass('active');
                    }
                    if ($(this).hasClass('active')) {
                        $(this).removeClass('active');
                        $(this).blur();
                    } else {
                        $(this).addClass('active');
                    }
                }

                var filterArray = [];
                var url = $(this).parents('.task-filter-actions').attr('data-url');
                $('div.task-filter-actions').find('.active').each(function () {
                    filterArray.push($(this).attr('data-val'));
                });
                status = filterArray;
                ajaxFilterTaskView(sort, $('#task_keyword').val(), status);
            });

            // when change sorting order
            $('#task_sort').on('click', 'a', function () {
                sort = $(this).attr('data-val');
                ajaxFilterTaskView(sort, $('#task_keyword').val(), status);
                $('#task_sort a').removeClass('active');
                $(this).addClass('active');
            });

            // when searching by task name
            $(document).on('keyup', '#task_keyword', function () {
                ajaxFilterTaskView(sort, $(this).val(), status);
            });
        });

        // For Filter
        function ajaxFilterTaskView(task_sort, keyword = '', status = '') {
            var mainEle = $('#taskboard_view');
            var view = '{{$view}}';
            var data = {
                view: view,
                sort: task_sort,
                keyword: keyword,
                status: status,
            }

            $.ajax({
                url: '{{ route('project.taskboard.view') }}',
                data: data,
                success: function (data) {
                    mainEle.html(data.html);
                }
            });
        }
    </script>
@endpush
