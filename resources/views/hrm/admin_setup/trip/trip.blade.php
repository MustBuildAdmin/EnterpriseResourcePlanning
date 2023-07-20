@include('new_layouts.header')
@include('hrm.hrm_main')



<div class="row">
  <div class="col-md-6">
     <h2>Trip</h2>
  </div>
  <div class="col-md-6 float-end">
    @can('create travel')
        <a class="floatrght mb-3 btn  btn-primary" href="#" data-url="{{ route('travel.create') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Create New Trip')}}" data-bs-toggle="tooltip" title="{{__('Create')}}">
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
                    <th>{{__('Start Date')}}</th>
                    <th>{{__('End Date')}}</th>
                    <th>{{__('Purpose of Trip')}}</th>
                    <th>{{__('Country')}}</th>
                    <th>{{__('Description')}}</th>
                    @if(Gate::check('edit travel') || Gate::check('delete travel'))
                        <th width="200px">{{__('Action')}}</th>
                    @endif
                </tr>
            </thead>
            <tbody class="font-style">
                @foreach ($travels as $travel)
                    <tr>
                        @role('company')
                        <td>{{ !empty($travel->employee())?$travel->employee()->name:'' }}</td>
                        @endrole
                        <td>{{ \Auth::user()->dateFormat( $travel->start_date) }}</td>
                        <td>{{ \Auth::user()->dateFormat( $travel->end_date) }}</td>
                        <td>{{ $travel->purpose_of_visit }}</td>
                        <td>{{ $travel->place_of_visit }}</td>
                        <td>{{ $travel->description }}</td>
                        @if(Gate::check('edit travel') || Gate::check('delete travel'))
                            <td>
                                <div class="ms-2" style="display:flex;gap:10px;">
                                    @can('edit travel')
                                        <a href="#" class="btn btn-md bg-primary" data-url="{{ URL::to('travel/'.$travel->id.'/edit') }}" data-ajax-popup="true" data-title="{{__('Edit Trip')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                            <i class="ti ti-pencil text-white"></i>
                                        </a>
                                    @endcan
                                    @can('delete travel')
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['travel.destroy', $travel->id],'id'=>'delete-form-'.$travel->id]) !!}
                                            <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$travel->id}}').submit();">
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