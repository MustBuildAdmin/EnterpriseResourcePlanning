@include('new_layouts.header')
@include('hrm.hrm_main',['hrm_header' => 'Award Type'])
    @can('create award type')
        <a href="#" data-url="{{ route('awardtype.create') }}" data-ajax-popup="true" data-title="{{__('Create New Award Type')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="mb-3 btn btn-sm btn-primary">
            {{__('Create')}} &nbsp;<i class="ti ti-plus"></i>
        </a>
    @endcan
    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    <th>{{__('Award Type')}}</th>
                    <th width="200px">{{__('Action')}}</th>
                </tr>
            </thead>
            <tbody class="font-style">
                @foreach ($awardtypes as $awardtype)
                    <tr>
                        <td>{{ $awardtype->name }}</td>
                        <td>
                            <div class="ms-2" style="display:flex;gap:10px;">
                                @can('edit award type')
                                    <a href="#" class="btn btn-md bg-primary" data-url="{{ URL::to('awardtype/'.$awardtype->id.'/edit') }}" data-ajax-popup="true" data-title="{{__('Edit Award Type')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                        <i class="ti ti-pencil text-white"></i>
                                    </a>
                                @endcan

                                @can('delete award type')
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['awardtype.destroy', $awardtype->id],'id'=>'delete-form-'.$awardtype->id]) !!}
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