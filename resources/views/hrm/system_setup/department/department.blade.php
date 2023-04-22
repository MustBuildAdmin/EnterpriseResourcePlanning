@include('new_layouts.header')
@include('hrm.hrm_main',['hrm_header' => 'Department'])

    @can('create department')
        <a href="#" data-url="{{ route('department.create') }}" data-ajax-popup="true" data-title="{{__('Create New Department')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary mb-3">
            {{__('Create')}} &nbsp;<i class="ti ti-plus"></i>
        </a>
    @endcan
    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    <th>{{__('Branch')}}</th>
                    <th>{{__('Department')}}</th>
                    <th width="200px">{{__('Action')}}</th>
                </tr>
            </thead>
            <tbody class="font-style">
                @foreach ($departments as $department)
                    <tr>
                        <td>{{ !empty($department->branch)?$department->branch->name:'' }}</td>
                        <td>{{ $department->name }}</td>

                        <td class="Action">
                            <div class="ms-2" style="display:flex;gap:10px;">
                                @can('edit department')
                                <a href="#" data-url="{{ URL::to('department/'.$department->id.'/edit') }}"  data-ajax-popup="true" data-title="{{__('Edit Department')}}" class="btn btn-md bg-primary
                                    " data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                    <i class="ti ti-pencil text-white"></i>
                                </a>
                                @endcan
                                @can('delete department')
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['department.destroy', $department->id],'id'=>'delete-form-'.$department->id]) !!}
                                        <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$department->id}}').submit();"><i class="ti ti-trash text-white"></i></a>
                                    {!! Form::close() !!}
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
    </div>
@include('new_layouts.footer')