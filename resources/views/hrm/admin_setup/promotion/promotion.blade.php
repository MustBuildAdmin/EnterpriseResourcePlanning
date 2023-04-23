@include('new_layouts.header')
@include('hrm.hrm_main',['hrm_header' => 'Promotion'])

    @can('create promotion')
        <a href="#" data-url="{{ route('promotion.create') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Create New Promotion')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="mb-3 btn btn-sm btn-primary">
            {{__('Create')}} &nbsp;<i class="ti ti-plus"></i>
        </a>
    @endcan
    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    @role('company')
                    <th>{{__('Employee Name')}}</th>
                    @endrole
                    <th>{{__('Designation')}}</th>
                    <th>{{__('Promotion Title')}}</th>
                    <th>{{__('Promotion Date')}}</th>
                    <th>{{__('Description')}}</th>
                    @if(Gate::check('edit promotion') || Gate::check('delete promotion'))
                        <th width="200px">{{__('Action')}}</th>
                    @endif
                </tr>
            </thead>
            <tbody class="font-style">
                @foreach ($promotions as $promotion)
                    <tr>
                        @role('company')
                        <td>{{ !empty($promotion->employee())?$promotion->employee()->name:'' }}</td>
                        @endrole
                        <td>{{ !empty($promotion->designation())?$promotion->designation()->name:'' }}</td>
                        <td>{{ $promotion->promotion_title }}</td>
                        <td>{{  \Auth::user()->dateFormat($promotion->promotion_date) }}</td>
                        <td>{{ $promotion->description }}</td>
                        @if(Gate::check('edit promotion') || Gate::check('delete promotion'))
                            <td>
                                <div class="ms-2" style="display:flex;gap:10px;">
                                    @can('edit promotion')
                                        <a href="#" class="btn btn-md bg-primary" data-url="{{ URL::to('promotion/'.$promotion->id.'/edit') }}" data-ajax-popup="true" data-title="{{__('Edit Promotion')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                            <i class="ti ti-pencil text-white"></i>
                                        </a>
                                    @endcan
                                    @can('delete promotion')
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['promotion.destroy', $promotion->id],'id'=>'delete-form-'.$promotion->id]) !!}
                                            <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$promotion->id}}').submit();">
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