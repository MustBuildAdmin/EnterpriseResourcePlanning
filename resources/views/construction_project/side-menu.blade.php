<div class="page-body">
    <div class="container-l">
        <div class="card">
            <div class="row g-0">
                <div class="col-3 d-none d-md-block border-end">
                    <div class="card-body">
                        <h4 class="subheader">Construction Menu</h4>
                        <div class="list-group list-group-transparent">
                            <a href="{{route('filter.project.view')}}"
                                class="list-group-item list-group-item-action d-flex align-items-center {{ (request()->is('projects-view*') ? 'active' : '')}}">Productivity
                                </a>
                            <a href="#"
                                class="list-group-item list-group-item-action d-flex align-items-center">Diary
                                </a>
                            <a href="#"
                                class="list-group-item list-group-item-action d-flex align-items-center">Task
                                </a>
                            <a href="{{ route('task.newcalendar',['all']) }}"
                                class="list-group-item list-group-item-action d-flex align-items-center {{ (request()->is('calendar*') ? 'active' : '')}}">Task Calender</a>
                            <a href="{{route('project_report.index')}}"
                                class="list-group-item list-group-item-action d-flex align-items-center {{ (request()->is('project_report*') ? 'active' : '')}}">Project Report
                                </a>
                        </div>
                        <h4 class="subheader mt-4">Construction Setting</h4>
                        <div class="list-group list-group-transparent">
                            <a href="#" class="list-group-item list-group-item-action">Project Task Stages</a>
                        </div>
                    </div>
                </div>