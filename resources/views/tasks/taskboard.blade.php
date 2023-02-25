@extends('layouts.admin')

@section('page-title')
    {{__('Tasks')}}
@endsection

@section('action-button')
    @if($view == 'grid')
        <a href="{{ route('taskBoard.view', 'list') }}" class="btn btn-sm bg-white btn-icon rounded-pill mr-2 m-0">
            <span class="btn-inner--text text-dark">{{__('List View')}}</span>
        </a>
    @else
        <a href="{{ route('taskBoard.view', 'grid') }}" class="btn btn-sm bg-white btn-icon rounded-pill mr-2 m-0">
            <span class="btn-inner--text text-dark">{{__('Card View')}}</span>
        </a>
    @endif
    <div class="bg-neutral rounded-pill d-inline-block">
        <div class="input-group input-group-sm input-group-merge input-group-flush">
            <div class="input-group-prepend">
                <span class="input-group-text bg-transparent"><i class="ti ti-search"></i></span>
            </div>
            <input type="text" id="task_keyword" class="form-control form-control-flush" placeholder="{{__('Search by Name')}}">
        </div>
    </div>
    <div class="dropdown btn btn-sm btn-white btn-icon-only rounded-circle ml-2 m-0">
        <a href="#" class="action-item text-dark" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ti ti-filter"></i>
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
    </div>
    <div class="dropdown btn btn-sm btn-white btn-icon-only rounded-circle ml-2 m-0">
        <a href="#" class="action-item text-dark" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ti ti-flag"></i>
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
