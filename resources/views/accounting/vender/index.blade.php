@include('new_layouts.header')
@include('accounting.side-menu')
<style>
    .ms-2 {
        background: #fff  !important;
    }
    
    .ti.ti-caret-right.text-white {
        color: #000 !important;
        font-size: 18px;
    }
    
</style>
<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet"/>
    <div class="row">
        <div class="col-md-6">
            <h2>{{__('Manage Vendor')}}</h2>
        </div>
        <div class="col-md-6 float-end">
        {{-- @can('create vender')
            <a class="floatrght btn btn-sm btn-primary gapbtn" href="#" data-size="lg" data-url="{{ route('vender.create') }}" data-ajax-popup="true" data-title="{{__('Create New Vendor')}}" data-bs-toggle="tooltip" title="{{ __('Create') }}">
                <i class="ti ti-plus"></i>
            </a>
        @endcan --}}
        </div>
    </div>

    <div class="table-responsive">
        <table class="table datatable bill">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Contact') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Balance') }}</th>
                    <th>{{ __('Last Login At') }}</th>
                    {{-- <th>{{ __('Action') }}</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($venders as $k => $Vender)
                    <tr class="cust_tr" id="vend_detail">
                        <td class="Id">
                            @can('show vender')
                                <a href="{{ route('vender.show', \Crypt::encrypt($Vender->id)) }}"
                                   class="btn btn-outline-primary">
                                    {{ AUth::user()->venderNumberFormat($Vender->id) }}
                                </a>
                            @else
                                <a href="#" class="btn btn-outline-primary">
                                    {{ AUth::user()->venderNumberFormat($Vender->id) }}
                                </a>
                            @endcan
                        </td>
                        <td>{{ $Vender->name }}</td>
                        <td>{{ $Vender->phone }}</td>
                        <td>{{ $Vender->email }}</td>
                        <td>{{ \Auth::user()->priceFormat($Vender->balance) }}</td>
                        <td>
                            {{ !empty($Vender->last_login_at) ? $Vender->last_login_at : '-' }}
                        </td>
                        {{-- <td>
                            <span>
                                @if ($Vender['is_active'] == 0)
                                    <i class="fa fa-lock" title="Inactive"></i>
                                @else
                                    @can('show vender')
                                        <div class="ms-2">
                                            <a href="{{ route('vender.show', \Crypt::encrypt($Vender['id'])) }}"
                                                class="mx-3 btn btn-sm align-items-center backgroundnone" data-bs-toggle="tooltip"
                                                title="{{ __('View') }}">
                                                <i class="ti ti-eye text-white text-white"></i>
                                            </a>
                                        </div>
                                    @endcan
                                    @can('edit vender')
                                            <div class="ms-2">
                                                <a href="#" class="mx-3 btn btn-sm align-items-center backgroundnone" data-size="lg"
                                                data-title="{{__('Edit Vendor')}}"
                                                    data-url="{{ route('vender.edit', $Vender['id']) }}"
                                                    data-ajax-popup="true" title="{{ __('Edit') }}"
                                                    data-bs-toggle="tooltip" data-original-title="{{ __('Edit') }}">
                                                    <i class="ti ti-pencil text-white"></i>
                                                </a>
                                            </div>
                                    @endcan
                                    @can('delete vender')
                                            <div class="ms-2">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['vender.destroy', $Vender['id']], 'id' => 'delete-form-' . $Vender['id']]) !!}

                                            <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para backgroundnone" data-bs-toggle="tooltip"
                                                   data-original-title="{{ __('Delete') }}" title="{{ __('Delete') }}"
                                                   data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                                                   data-confirm-yes="document.getElementById('delete-form-{{ $Vender['id'] }}').submit();">
                                                <i class="ti ti-trash text-white text-white"></i>
                                                </a>
                                                {!! Form::close() !!}
                                            </div>
                                    @endcan
                                @endif
                            </span>
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
    </div>
@include('new_layouts.footer')
<script src="{{ asset('datatable/jquery.dataTables.min.js') }}"></script>