@include('new_layouts.header')
    <div class="page-wrapper">
        @include('construction_project.side-menu')
            <div class="row">
                <div class="col-md-6">
                    <h2 class="mb-4">{{$data['con_data']!=null ? $data['con_data']->text:'Task' }}</h2>
                </div>
            </div>

            <div class="col-md-6 float-end floatrght">
                @php
                    $get_date = $data['get_date'];
                @endphp
                <a href="#" data-size="xl" data-url="{{ route('add_particular_task',["task_id"=>$task_id, "get_date"=>$get_date]) }}" 
                    data-ajax-popup="true" data-title="{{__('Create Consultants Directions Summary')}}" data-bs-toggle="tooltip" title="{{__('Create')}}" class="floatrght btn btn-primary mb-3">
                    <i class="ti ti-plus"></i>
                </a>
            </div>
            <br>
            <br>
            <br>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table" id="example2">
                        <thead>
                        <tr>
                            <th scope="col">{{__('Planned Date')}}</th>
                            <th scope="col">{{__('Actual Date')}}</th>
                            <th scope="col">{{__('Status')}}</th>
                            <th scope="col">{{__('Percentage')}}</th>
                            <th scope="col">{{__('FileName')}}</th>
                            <th scope="col">{{__('Description')}}</th>
                            <th scope="col">{{__('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @php
                                $documentPath=\App\Models\Utility::get_file('uploads/task_particular_list');
                            @endphp
                            @forelse ($data['get_task_progress'] as $task_progress)
                                <tr>
                                    <td>{{Utility::site_date_format($task_progress->created_at,\Auth::user()->id)}}</td>
                                    <td>{{Utility::site_date_format($task_progress->record_date,\Auth::user()->id)}}</td>
                                    <td>
                                        @if ($task_progress->date_status == "As Per Time")
                                            <span class="badge badge-success" style="background-color:#007bff;">{{$task_progress->date_status}}</span>
                                        @elseif($task_progress->date_status == "Overdue")
                                            <span class="badge badge-success" style="background-color:#DC3545;">{{$task_progress->date_status}}</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td><span class="badge badge-info" style="background-color:#007bff;">{{$task_progress->percentage}} %</span></td>
                                    <td>
                                        @php
                                            $file_explode = explode(',',$task_progress->filename);
                                        @endphp
                                        @forelse ($file_explode as $file_show)
                                            <span class="badge badge-primary" style="background-color:#007bff;margin-top: 5px;">{{$file_show}}</span> <br>
                                        @empty
                                        @endforelse
                                    </td>
                                    <td>{{$task_progress->description}}</td>
                                    <td>
                                        <div class="actions">
                                            <a class="btn btn-md bg-primary backgroundnone" data-url="{{ route('edit_particular_task',["task_progress_id"=>$task_progress->id,"task_id"=>$task_id]) }}" 
                                                data-ajax-popup="true" data-size="xl" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit Consultants Directions Summary')}}">
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
@include('new_layouts.footer')

<script>
    $(document).ready(function() {
        $('#example2').DataTable({
            dom: 'Bfrtip',
            searching: true,
            info: true,
            paging: true,
        });
    });
</script>