@include('new_layouts.header')
@include('hrm.hrm_main',['hrm_header' => 'Warning'])

    @can('create warning')
        <a href="#" data-url="{{ route('warning.create') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Create New Warning')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="mb-3 btn btn-sm btn-primary">
            {{__('Create')}} &nbsp;<i class="ti ti-plus"></i>
        </a>
    @endcan
    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    <th>{{__('Warning By')}}</th>
                    <th>{{__('Warning To')}}</th>
                    <th>{{__('Subject')}}</th>
                    <th>{{__('Warning Date')}}</th>
                    <th>{{__('Description')}}</th>
                    @if(Gate::check('edit warning') || Gate::check('delete warning'))
                        <th width="200px">{{__('Action')}}</th>
                    @endif
                </tr>
            </thead>
            <tbody class="font-style">
                @foreach ($warnings as $warning)
                    <tr>
                        <td>{{!empty( $warning->WarningBy($warning->warning_by))? $warning->WarningBy($warning->warning_by)->name:'' }}</td>
                        <td>{{ !empty($warning->warningTo($warning->warning_to))?$warning->warningTo($warning->warning_to)->name:'' }}</td>
                        <td>{{ $warning->subject }}</td>
                        <td>{{  \Auth::user()->dateFormat($warning->warning_date) }}</td>
                        <td>{{ $warning->description }}</td>
                        @if(Gate::check('edit warning') || Gate::check('delete warning'))
                            <td>
                                <div class="ms-2" style="display:flex;gap:10px;">
                                    @can('edit warning')
                                        <a href="#" class="btn btn-md bg-primary" data-size="lg" data-url="{{ URL::to('warning/'.$warning->id.'/edit') }}" data-ajax-popup="true" data-title="{{__('Edit Warning')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                            <i class="ti ti-pencil text-white"></i>
                                        </a>
                                    @endcan

                                    @can('delete warning')
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['warning.destroy', $warning->id],'id'=>'delete-form-'.$warning->id]) !!}
                                            <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$warning->id}}').submit();">
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