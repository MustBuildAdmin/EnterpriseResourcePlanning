@include('new_layouts.header')
@include('hrm.hrm_main',['hrm_header' => 'Competencies'])

    @can('Create Competencies')
        <a href="#" data-url="{{ route('competencies.create') }}" data-ajax-popup="true" data-title="{{__('Create New Competencies')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="mb-3 btn btn-sm btn-primary">
            {{__('Create')}} &nbsp;<i class="ti ti-plus"></i>
        </a>
    @endcan
    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Type')}}</th>
                    <th width="200px">{{__('Action')}}</th>
                </tr>
            </thead>
            <tbody class="font-style">
                @foreach ($competencies as $competency)
                    <tr>
                        <td>{{ $competency->name }}</td>
                        <td>{{ !empty($competency->performance)?$competency->performance->name:'' }}</td>
                        <td class="Action">
                            <div class="ms-2" style="display:flex;gap:10px;">
                                @can('edit document type')
                                    <a href="#" class="btn btn-md bg-primary" data-url="{{ URL::to('competencies/'.$competency->id.'/edit') }}" data-ajax-popup="true" data-title="{{__('Edit Competencies')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                        <i class="ti ti-pencil text-white"></i>
                                    </a>
                                @endcan

                                @can('Delete Competencies')
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['competencies.destroy', $competency->id],'id'=>'delete-form-'.$competency->id]) !!}
                                        <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}"><i class="ti ti-trash text-white text-white"></i></a>
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