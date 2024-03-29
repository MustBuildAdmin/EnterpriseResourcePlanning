@include('new_layouts.header')
@include('hrm.hrm_main')


<div class="row">
  <div class="col-md-6">
     <h2>Resignation</h2>
  </div>
  <div class="col-md-6 float-end">

    @can('create resignation')
        <a class="floatrght mb-3 btn  btn-primary" href="#" data-size="lg" data-url="{{ route('resignation.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create New Resignation')}}" >
            {{__('Create')}} &nbsp;<i class="ti ti-plus"></i>
        </a>
    @endcan

  </div>
</div>


    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    @role('company')
                    <th>{{__('Employee Name')}}</th>
                    @endrole
                    <th>{{__('Resignation Date')}}</th>
                    <th>{{__('Last Working Date')}}</th>
                    <th>{{__('Reason')}}</th>
                    @if(Gate::check('edit resignation') || Gate::check('delete resignation'))
                        <th width="200px">{{__('Action')}}</th>
                    @endif
                </tr>
            </thead>
            <tbody class="font-style">
                @foreach ($resignations as $resignation)
                    <tr>
                        @role('company')
                        <td>{{ !empty($resignation->employee())?$resignation->employee()->name:'' }}</td>
                        @endrole
                        <td>{{  \Auth::user()->dateFormat($resignation->notice_date) }}</td>
                        <td>{{  \Auth::user()->dateFormat($resignation->resignation_date) }}</td>
                        <td>{{ $resignation->description }}</td>
                        @if(Gate::check('edit resignation') || Gate::check('delete resignation'))
                            <td>
                                <div class="ms-2" style="display:flex;gap:10px;">
                                    @can('edit resignation')
                                        <a href="#" class="btn btn-md bg-primary" data-size="lg" data-url="{{ URL::to('resignation/'.$resignation->id.'/edit') }}" data-ajax-popup="true" data-title="{{__('Edit Resignation')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                            <i class="ti ti-pencil text-white"></i>
                                        </a>
                                    @endcan

                                    @can('delete resignation')
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['resignation.destroy', $resignation->id],'id'=>'delete-form-'.$resignation->id]) !!}
                                            <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$resignation->id}}').submit();">
                                                <i class="ti ti-trash text-white"></i>
                                            </a>
                                        {!! Form::close() !!}
                                    @endcan
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
    </div>
@include('new_layouts.footer')