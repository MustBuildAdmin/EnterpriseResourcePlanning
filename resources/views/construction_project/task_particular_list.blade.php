
@include('new_layouts.header')
<style>
    tr.highlighted {
  padding-top: 10px;
  padding-bottom:10px
}
</style>
    <div class="page-wrapper">
        @include('construction_project.side-menu')
            <div class="row">
                <div class="col-md-6">
                    <h2 class="mb-4">{{$data['con_data']!=null ? $data['con_data']->text:'Task' }}</h2>
                </div>
            </div>

            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table style="width: 100%; border-collapse:separate; border-spacing: 40px 2em;">
                        <tr class="highlighted">
                            <td style="width: 15%; font-weight:bold;">Project Name:</td>
                            <td style="width: 35%">{{ $data['con_data']->project_name }}</td>

                            <td style="width: 15%; font-weight:bold;">Description:</td>
                            <td style="width: 35%">{{$data['con_data']->description != null ? $data['con_data']->description : '-'}}</td>
                        </tr>

                        <tr class="highlighted">
                            <td style="font-weight:bold;">Planned Start Date:</td>
                            <td style="">{{Utility::site_date_format($data['con_data']->start_date,\Auth::user()->id)}}</td>

                            <td style="font-weight:bold;">Planned End Date:</td>
                            <td style="">
                                {{ Utility::site_date_format_minus_day($data['con_data']->end_date,\Auth::user()->id,1) }}
                            </td>
                        </tr>

                        <tr class="highlighted">
                            @php
                                $actual_task_progress = $data['con_data']->progress ? $data['con_data']->progress : '0';
                                if($actual_task_progress < $current_Planed_percentage){
                                    $style = "color:red;";
                                }
                                else{
                                    $style = "";
                                }
                            @endphp
                            <td style="font-weight:bold; {{$style}}">Actual Progress:</td>
                            <td style="{{$style}}">{{$data['con_data']->progress != null ? $data['con_data']->progress : '0'}}%</td>

                            <td style="font-weight:bold;">Planned Progress</td>
                            <td style="">{{ round($current_Planed_percentage) }}%</td>
                        </tr>
                    </table>
                </div>
            </div>
            <br>
            <div class="col-auto ms-auto d-print-none float-end">
                <div class="input-group-btn">
                    @php $get_date = $data['get_date']; @endphp
                    
                    <a href="#" data-size="xl" data-url="{{ route('add_particular_task',["task_id"=>$task_id, "get_date"=>$get_date]) }}"  data-ajax-popup="true" 
                        data-title="{{$data['con_data']!=null ? $data['con_data']->text:'Task' }} Progress Update" data-bs-toggle="tooltip" title="{{__('Create')}}" class="btn btn-primary">
                        <span class="btn-inner--icon"><i class="fa fa-plus"></i></span>
                    </a>
                    <a href="{{ route('taskBoard.view',['list']) }}" class="btn btn-danger" data-bs-toggle="tooltip" title="{{ __('Back') }}">
                        <span class="btn-inner--icon"><i class="fa fa-arrow-left"></i></span>
                    </a>
                </div>
            </div>
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
                            <th scope="col">{{__('Actual Progress as per a Day')}}</th>
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
                                        @if( date('Y-m-d', strtotime($task_progress->created_at)) > date('Y-m-d') && $task_progress->percentage >= "100")
                                            <span class="badge badge-success">Incomplete</span>
                                        @elseif ($task_progress->percentage >= "100")
                                            <span class="badge badge-success" style="background-color:#3ec334;">completed</span>
                                        @else
                                            <span class="badge badge-success" style="background-color:#DC3545;">Incomplete</span>
                                        @endif
                                    </td>
                                    <td><span class="badge badge-info" style="background-color:#007bff;">{{$task_progress->percentage}}%</span></td>
                                    <td>
                                        @php
                                            $file_explode = explode(',',$task_progress->filename);
                                        @endphp
                                        @forelse ($file_explode as $file_show)
                                            @if($file_show != "")
                                                <span class="badge badge-primary" style="background-color:#007bff;margin-top: 5px;">{{$file_show}}
                                                </span>&nbsp;&nbsp;&nbsp;
                                                <span class="badge badge-primary" style="background-color:#007bff;margin-top: 5px;cursor: pointer;">
                                                    <li class="fa fa-download"></li>
                                                </span>
                                                <br>
                                            @else
                                                -
                                            @endif
                                        @empty
                                        @endforelse
                                    </td>
                                    <td>{{$task_progress->description}}</td>
                                    <td>
                                        <div class="actions">
                                            <a class="backgroundnone" data-url="{{ route('edit_particular_task',["task_progress_id"=>$task_progress->id,"task_id"=>$task_id]) }}"
                                                data-ajax-popup="true" data-size="xl" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{$data['con_data']!=null ? $data['con_data']->text:'Task' }} Progress Update">
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
