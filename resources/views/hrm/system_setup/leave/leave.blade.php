@include('new_layouts.header')
@include('hrm.hrm_main')




<div class="row">
  <div class="col-md-6">
     <h2>Leave Type</h2>
  </div>
  <div class="col-md-6 float-end floatrght">

    @can('create leave type')
        <a class="floatrght mb-3 btn btn-sm btn-primary" href="#" data-url="{{ route('leavetype.create') }}" data-ajax-popup="true" data-title="{{__('Create New Leave Type')}}" data-bs-toggle="tooltip" title="{{__('Create')}}">
            {{__('Create')}} &nbsp;<i class="ti ti-plus"></i>
        </a>
    @endcan

  </div>
</div>


    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    <th>{{__('Leave Type')}}</th>
                    <th>{{__('Days / Year')}}</th>
                    <th width="200px">{{__('Action')}}</th>
                </tr>
            </thead>
            <tbody class="font-style">
                @foreach ($leavetypes as $leavetype)
                    <tr>
                        <td>{{ $leavetype->title }}</td>
                        <td>{{ $leavetype->days}}</td>

                        <td>
                            <div class="ms-2" style="display:flex;gap:10px;">
                                @can('edit leave type')
                                    <a href="#" class="btn btn-md bg-primary" data-url="{{ URL::to('leavetype/'.$leavetype->id.'/edit') }}" data-ajax-popup="true" data-title="{{__('Edit Leave Type')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                        <i class="ti ti-pencil text-white"></i>
                                    </a>
                                @endcan

                                @can('delete leave type')
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['leavetype.destroy', $leavetype->id],'id'=>'delete-form-'.$leavetype->id]) !!}
                                        <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$leavetype->id}}').submit();">
                                            <i class="ti ti-trash text-white"></i>
                                        </a>
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