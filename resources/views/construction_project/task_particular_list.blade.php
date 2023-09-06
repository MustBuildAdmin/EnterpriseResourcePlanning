@include('new_layouts.header')
<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet"/>
<style>
    tr.highlighted {
        padding-top: 10px;
        padding-bottom: 10px
    }
</style>
<div class="page-wrapper">
    @include('construction_project.side-menu')

    @php
        $actual_task_progress = $data['con_data']->progress ? $data['con_data']->progress : '0';
        if ($actual_task_progress < $current_Planed_percentage) {
            $style = 'color:red;';
        } else {
            $style = '';
        }
    @endphp

    <div class="container-fluid m-3">
        <div class="row row-cards">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        {{$data['con_data']->id}}-{{ $data['con_data'] != null ? 
                        $data['con_data']->text : 'Task' }} Progress Details
                    </h3>
                </div>
                <div class="card-body">
                    <div class="datagrid">
                        <div class="datagrid-item">
                            <div class="datagrid-title">Task Name</div>
                            <div class="datagrid-content">{{ $data['con_data'] != null ? $data['con_data']->text : 'Task' }}
                            </div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Description</div>
                            <div class="datagrid-content">
                                {{ $data['con_data']->description != null ? $data['con_data']->description : '–' }}
                            </div>
                        </div>

                        <div class="datagrid-item">
                            @php
                                $users_data = $data['con_data']->users != "" ? json_decode($data['con_data']->users) : array();
                            @endphp
                            <div class="datagrid-title">Avatars list</div>
                            <div class="datagrid-content">
                                <div class="avatar-list avatar-list-stacked">
                                    @forelse ($users_data as $key => $get_user)
                                        @php
                                            $user_db = DB::table('users')->where('id',$get_user)->first();
                                        @endphp
                                        @if($key<3)
                                            <span class="avatar avatar-xs rounded" title="{{$user_db->name}}">{{ substr($user_db->name, 0, 1) }}</span>
                                        @else
                                            <?php  $short=substr($user_db->name, 0, 1);?>
                                            <span class="avatar avatar-xs rounded">+{{strtoupper($short)}}</span>
                                        @endif
                                    @empty
                                        {{ __('Not Assigned') }}
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="datagrid-item">
                            <div class="datagrid-title">Task Creator</div>
                            <div class="datagrid-content">Third Party</div>
                        </div>
                        <div class="datagrid-item">

                            <div class="datagrid-title">Planned Start Date</div>
                            <div class="datagrid-content">
                                {{ Utility::site_date_format($data['con_data']->start_date, \Auth::user()->id) }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Planned End Date</div>
                            <div class="datagrid-content">
                                {{ Utility::site_date_format_minus_day($data['con_data']->end_date, \Auth::user()->id, 1) }}
                            </div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Actucal Start Date</div>
                            <div class="datagrid-content">–</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Actucal End Date</div>
                            <div class="datagrid-content">–</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Planned Progress</div>
                            <div class="datagrid-content">{{ round($current_Planed_percentage) }}%</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Actual Progress</div>
                            <div class="datagrid-content">
                                {{ $data['con_data']->progress != null ? $data['con_data']->progress : '0' }}%</div>
                        </div>

                        <div class="datagrid-item">
                            <div class="datagrid-title">Age</div>
                            <div class="datagrid-content">{{ $data['con_data']->duration }} days</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Status</div>
                            <div class="datagrid-content">
                                <span class="status status-green">
                                    Active
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-actions">
                        <a href="#" class="btn btn-success float-end" data-bs-toggle="modal"
                            data-bs-target="#modal-large">
                            Progress Update
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="modal modal-blur fade" id="modal-large" tabindex="-1" role="dialog"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">TaskID-Task Name Progress Update</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="row row-cards">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Actual Date</label>
                                                    <div class="input-icon">
                                                        <span
                                                            class="input-icon-addon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon"
                                                                width="24" height="24" viewBox="0 0 24 24"
                                                                stroke-width="2" stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path
                                                                    d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                                                <path d="M16 3v4" />
                                                                <path d="M8 3v4" />
                                                                <path d="M4 11h16" />
                                                                <path d="M11 15h1" />
                                                                <path d="M12 15v3" />
                                                            </svg>
                                                        </span>
                                                        <input class="form-control" placeholder="Select a date"
                                                            id="datepicker-icon-prepend" value="2020-06-20" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Planned Date</label>
                                                    <input type="number" min="0.1" max="100"
                                                        class="form-control" name="example-text-input"
                                                        placeholder="Planned Start Date">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Description</label>
                                                    <textarea id="tinymce-mytextarea"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <form id="dropzone-multiple">
                                                        <label class="form-label">Upload your Files</label>
                                                        <input name="file" type="file" multiple />
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save
                                        changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive card p-4">
                        <table class="table table-vcenter card-table" id="task-progress">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('Planned Date') }}</th>
                                    <th scope="col">{{ __('Actual Date') }}</th>
                                    <th scope="col">{{ __('Status') }}</th>
                                    <th scope="col">{{ __('Actual Progress as per a Day') }}</th>
                                    <th scope="col">{{ __('FileName') }}</th>
                                    <th scope="col">{{ __('Description') }}</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $documentPath = \App\Models\Utility::get_file('uploads/task_particular_list');
                                @endphp
                                @forelse ($data['get_task_progress'] as $task_progress)
                                    <tr>
                                        <td>{{ Utility::site_date_format($task_progress->created_at, \Auth::user()->id) }}
                                        </td>
                                        <td>{{ Utility::site_date_format($task_progress->record_date, \Auth::user()->id) }}
                                        </td>
                                        <td>
                                            @if (date('Y-m-d', strtotime($task_progress->created_at)) > date('Y-m-d') && $task_progress->percentage >= '100')
                                                <span class="badge badge-success">Incomplete</span>
                                            @elseif ($task_progress->percentage >= '100')
                                                <span class="badge badge-success"
                                                    style="background-color:#3ec334;">completed</span>
                                            @else
                                                <span class="badge badge-success"
                                                    style="background-color:#DC3545;">Incomplete</span>
                                            @endif
                                        </td>
                                        <td><span class="badge badge-info"
                                                style="background-color:#007bff;">{{ $task_progress->percentage }}%</span>
                                        </td>
                                        <td>
                                            @php
                                                $file_explode = explode(',', $task_progress->filename);
                                            @endphp
                                            @forelse ($file_explode as $file_show)
                                                @if ($file_show != '')
                                                    <span class="badge badge-primary"
                                                        style="background-color:#007bff;margin-top: 5px;">{{ $file_show }}
                                                    </span>&nbsp;&nbsp;&nbsp;
                                                    <a href="{{ route('task_file_download', [$task_progress->task_id, "$file_show"]) }}"
                                                        class="badge badge-primary"
                                                        style="background-color:#007bff;
                                            margin-top: 5px;cursor: pointer;">
                                                        <i class="fa fa-download"></i>
                                                    </a>
                                                    <br>
                                                @else
                                                    -
                                                @endif
                                            @empty
                                            @endforelse
                                        </td>
                                        <td>{{ $task_progress->description }}</td>
                                        <td>
                                            <div class="actions">
                                                <a class="backgroundnone"
                                                    data-url="{{ route('edit_particular_task', ['task_progress_id' => $task_progress->id, 'task_id' => $task_id]) }}"
                                                    data-ajax-popup="true" data-size="xl" data-bs-toggle="tooltip"
                                                    title="{{ __('Edit') }}"
                                                    data-title="{{ $data['con_data'] != null ? $data['con_data']->text : 'Task' }} Progress Update">
                                                    <i class="ti ti-pencil text-white"></i>
                                                </a>
                                            </div>
                                        </td>
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
    @include('new_layouts.footer')
    <script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('dropzone/dropzone-min.js') }}"></script>
    <script src="{{ asset('tom-select/tom-select.popular.min.js') }}"></script>
    <script src="{{ asset('litepicker/litepicker.js') }}"></script>
    <script src="{{ asset('tokeninput/jquery.tokeninput.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        new DataTable('#task-progress', {
            pagingType: 'full_numbers',
            aaSorting: []
        });
    
        document.addEventListener("DOMContentLoaded", function() {
            window.Litepicker && (new Litepicker({
                element: document.getElementById('datepicker-icon-prepend'),
                buttonText: {
                    previousMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
                    nextMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
                },
            }));
        });
    
        document.addEventListener("DOMContentLoaded", function() {
            let options = {
                selector: '#tinymce-mytextarea',
                height: 300,
                menubar: false,
                statusbar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat',
                content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; -webkit-font-smoothing: antialiased; }'
            }
            if (localStorage.getItem("tablerTheme") === 'dark') {
                options.skin = 'oxide-dark';
                options.content_css = 'dark';
            }
            tinyMCE.init(options);
        })
      
        document.addEventListener("DOMContentLoaded", function() {
            new Dropzone("#dropzone-multiple")
        })
    </script>
