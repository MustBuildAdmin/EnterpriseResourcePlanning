@include('new_layouts.header')
<style>
</style>
<link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet"/>
<div class="page-wrapper">
@include('construction_project.side-menu')
<div class="card m-3" >

    <div class="card-header">
        <h4 class="card-title">Project Profile</h4>
        <div class="card-actions">
            @if($project->freeze_status!=1)
                  <a href="#" class="btn btn-outline-primary  w-100" data-size="lg" style="
                  float: right;" data-url="{{ route('project-holiday.create') }}" data-ajax-popup="true"
                      data-bs-toggle="tooltip" title="{{__('Create New holidays')}}">
                      {{__('Create New holidays')}}
               </a>
               @endif
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-3">
                @include('layouts.project_setup')
            </div>
            <div class="col-9">
                <div class="card">
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table" id="holiday_table">
                                <thead>
                                <tr>
                                    <th>{{__('Date')}}</th>
                                    <th>{{__('Description')}}</th>
                                    @if($project->freeze_status!=1)
                                    <th width="200px">{{__('Action')}}</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody class="font-style">
                                @foreach ($holidays as $project_each)
                                    <tr>
                                        <td>{{ $project_each->date }}</td>
                                        <td>{{ $project_each->description }}</td>
                                        @if($project->freeze_status!=1)
                                            <td class="Action text-end">
                                                <span>
                                                    <div class="btn btn-outline-primary">
                                                        <a href="#" class=""
                                                        data-url="{{ URL::to('project-holiday/'
                                                            .$project_each->id.'/edit') }}"
                                                        data-ajax-popup="true" data-title="{{__('Edit Project')}}"
                                                        data-bs-toggle="tooltip" title="{{__('Edit')}}"
                                                            data-original-title="{{__('Edit')}}">
                                                            <i class="ti ti-pencil text-white"></i></a>
                                                    </div>
                                                    <div class="btn btn-outline-primary">
                                                    {!! Form::open(['method' => 'DELETE',
                                                        'route' => ['project-holiday.destroy',
                                                        $project_each->id],'id'=>'delete-form-'.$project_each->id]) !!}
                                                        <a href="#" class="bs-pass-para" data-bs-toggle="tooltip"
                                                        title="{{__('Delete')}}" data-original-title="{{__('Delete')}}"
                                                        data-confirm="{{__('Are You Sure?').'|'.
                                                            __('This action can not be undone. Do you want to continue?')}}"
                                                        data-confirm-yes="document.getElementById('delete-form-
                                                        {{$project_each->id}}').submit();">
                                                        <i class="ti ti-trash text-white text-white"></i></a>
                                                    {!! Form::close() !!}
                                                    {{-- {!! Form::open(['method' => 'DELETE',
                                                        'route' => ['project-holiday.destroy', $project->id],
                                                        'id'=>'delete-form-'.$project->id]) !!}

                                                        <a href="#" class="" data-bs-toggle="tooltip"
                                                        title="{{__('Delete')}}" data-original-title="{{__('Delete')}}"
                                                        data-confirm="{{__('Are You Sure?').'|'
                                                            .__('This action can not be undone.
                                                            Do you want to continue?')}}"
                                                        data-confirm-yes="document.getElementById('delete-form-
                                                        {{$project->id}}').submit();">
                                                        <i class="ti ti-trash text-white text-white"></i></a>
                                                        {!! Form::close() !!} --}}
                                                    </div>

                                                </span>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="col d-flex flex-column">
        <div class="card-body">


    </div>
</div>
<script src="{{ asset('datatable/jquery.dataTables.min.js') }}"></script>
<script>
    $(function () {
        datatable2();
    });

    function datatable2(){
        new DataTable('#holiday_table', {
            pagingType: 'full_numbers',
            aaSorting: [],
            "language": {
                "sLengthMenu": "{{ __('Show _MENU_ Records') }}",
                "sZeroRecords": "{{ __('No data available in table') }}",
                "sEmptyTable": "{{ __('No data available in table') }}",
                "sInfo": "{{ __('Showing records _START_ to _END_ of a total of _TOTAL_ records') }}",
                "sInfoFiltered": "{{ __('filtering of a total of _MAX_ records') }}",
                "sSearch": "{{ __('Search') }}:",
                "oPaginate": {
                    "sFirst": "{{ __('First') }}",
                    "sLast": "{{ __('Last') }}",
                    "sNext": "{{ __('Next') }}",
                    "sPrevious": "{{ __('Previous') }}"
                },
            }
        });
    }
</script>
@include('new_layouts.footer')
