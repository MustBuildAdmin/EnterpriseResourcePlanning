@include('new_layouts.header')
@include('accounting.side-menu')
<link rel="stylesheet" href="{{ asset('assets/css/plugins/flatpickr.min.css') }}">
<div class="row">
  <div class="col-md-6">
     <h2>Bill</h2>
  </div>
  <div class="col-md-6 float-end floatrght">

        <a href="{{ route('bill.export') }}" class="floatrght btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{__('Export')}}">
            <i class="ti ti-file-export"></i> 
        </a>

        @can('create bill')
            <a href="{{ route('bill.create',0) }}" class="floatrght btn btn-sm btn-primary gapbtn" data-bs-toggle="tooltip" title="{{__('Create')}}">
                <i class="ti ti-plus"></i>
            </a>
        @endcan

  </div>
</div>


<div class="row">
        <div class="col-sm-12">
            <div class=" mt-2 " id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        @if(!\Auth::guard('vender')->check())
                            {{ Form::open(array('route' => array('bill.index'),'method' => 'GET','id'=>'frm_submit')) }}
                        @else
                            {{ Form::open(array('route' => array('vender.bill'),'method' => 'GET','id'=>'frm_submit')) }}
                        @endif                        <div class="row align-items-center justify-content-end">
                            <div class="col-xl-10">
                                <div class="row">

                                    <div class="col-3">
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 month">
                                        <div class="btn-box">
                                            {{Form::label('bill_date',__('Bill Date'),['class'=>'form-label'])}}
                                            {{ Form::text('bill_date', isset($_GET['bill_date'])?$_GET['bill_date']:null, array('placeholder'=>'Select Date','class' => 'form-control month-btn','id'=>'pc-daterangepicker-1','readonly')) }}
                                        </div>
                                    </div>
                                    @if(!\Auth::guard('vender')->check())
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 date">
                                            <div class="btn-box">
                                                {{ Form::label('vender', __('Vendor'),['class'=>'form-label'])}}
                                                {{ Form::select('vender',$vender,isset($_GET['vender'])?$_GET['vender']:'', array('class' => 'form-control select')) }}
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{ Form::label('status', __('Status'),['class'=>'form-label'])}}
                                            {{ Form::select('status', [''=>'Select Status'] + $status,isset($_GET['status'])?$_GET['status']:'', array('class' => 'form-control select')) }}
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="col-auto mt-4">
                                <div class="row">
                                    <div class="col-auto">

                                        <a href="#" class="btn btn-sm btn-primary" onclick="document.getElementById('frm_submit').submit(); return false;" data-bs-toggle="tooltip" title="{{__('Apply')}}" data-original-title="{{__('apply')}}">
                                            <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                        </a>
                                        @if (!\Auth::guard('customer')->check())
                                            <a href="{{route('bill.index')}}" class="btn btn-sm btn-danger " data-bs-toggle="tooltip"  title="{{ __('Reset') }}" data-original-title="{{__('Reset')}}">
                                                <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
                                            </a>
                                        @else
                                            <a href="{{route('vender.bill')}}" class="btn btn-sm btn-danger " data-bs-toggle="tooltip"  title="{{ __('Reset') }}" data-original-title="{{__('Reset')}}">
                                                <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
                                            </a>
                                        @endif


                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable bill">
                            <thead>
                            <tr>
                                <th> {{__('Bill')}}</th>
                                @if(!\Auth::guard('vender')->check())
                                    <th> {{__('Vendor')}}</th>
                                @endif
                                <th> {{__('Category')}}</th>
                                <th> {{__('Bill Date')}}</th>
                                <th> {{__('Due Date')}}</th>
                                <th>{{__('Status')}}</th>
                                @if(Gate::check('edit bill') || Gate::check('delete bill') || Gate::check('show bill'))
                                    <th width="15%"> {{__('Action')}}</th>
                                @endif
                                {{-- <th>
                                    <td class="barcode">
                                        {!! DNS1D::getBarcodeHTML($bill->sku, "C128",1.4,22) !!}
                                        <p class="pid">{{$bill->sku}}</p>
                                    </td>
                                </th> --}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($bills as $bill)
                                <tr>
                                    <td class="Id">
                                        @if(\Auth::guard('vender')->check())
                                            <a href="{{ route('vender.bill.show',\Crypt::encrypt($bill->id)) }}" class="btn btn-outline-primary">{{ AUth::user()->billNumberFormat($bill->bill_id) }}</a>
                                        @else
                                            <a href="{{ route('bill.show',\Crypt::encrypt($bill->id)) }}" class="btn btn-outline-primary">{{ AUth::user()->billNumberFormat($bill->bill_id) }}</a>
                                        @endif
                                    </td>
                                    @if(!\Auth::guard('vender')->check())
                                        <td> {{ (!empty( $bill->vender)?$bill->vender->name:'') }} </td>
                                    @endif
                                    <td>{{ !empty($bill->category)?$bill->category->name:''}}</td>
                                    <td>{{ Auth::user()->dateFormat($bill->bill_date) }}</td>
                                    <td>{{ Auth::user()->dateFormat($bill->due_date) }}</td>
                                    <td>
                                        @if($bill->status == 0)
                                            <span class="status_badge badge bg-secondary p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$bill->status]) }}</span>
                                        @elseif($bill->status == 1)
                                            <span class="status_badge badge bg-warning p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$bill->status]) }}</span>
                                        @elseif($bill->status == 2)
                                            <span class="status_badge badge bg-danger p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$bill->status]) }}</span>
                                        @elseif($bill->status == 3)
                                            <span class="status_badge badge bg-info p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$bill->status]) }}</span>
                                        @elseif($bill->status == 4)
                                            <span class="status_badge badge bg-primary p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$bill->status]) }}</span>
                                        @endif
                                    </td>
                                    @if(Gate::check('edit bill') || Gate::check('delete bill') || Gate::check('show bill'))
                                        <td >
                                            <span>
                                            @can('duplicate bill')
                                                    <div class="ms-2">
                                                        {!! Form::open(['method' => 'get', 'route' => ['bill.duplicate', $bill->id],'id'=>'duplicate-form-'.$bill->id]) !!}

                                                        <a href="#" class="backgroundnone mx-3 btn btn-sm align-items-center bs-pass-para-duplicate " data-bs-toggle="tooltip" data-original-title="{{__('Duplicate')}}" data-bs-toggle="tooltip"
                                                           title="{{__('Duplicate Bill')}}" data-original-title="{{__('Duplicate Bill')}}" data-confirm="You want to confirm this action. Press Yes to continue or Cancel to go back" data-confirm-yes="document.getElementById('duplicate-form-{{$bill->id}}').submit();">
                                                        <i class="ti ti-copy"></i>
                                                            {!! Form::close() !!}
                                                        </a>
                                                    </div>


                                                @endcan
                                                @can('show bill')
                                                    @if(\Auth::guard('vender')->check())
                                                        <div class="ms-2">
                                                            <a href="{{ route('vender.bill.show',\Crypt::encrypt($bill->id)) }}" class="backgroundnone mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="{{__('Show')}}" data-original-title="{{__('Detail')}}">
                                                             <i class="ti ti-eye text-white"></i>
                                                            </a>
                                                        </div>
                                                    @else
                                                        <div class="ms-2">
                                                            <a href="{{ route('bill.show',\Crypt::encrypt($bill->id)) }}" class="backgroundnone mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="{{__('Show')}}" data-original-title="{{__('Detail')}}">
                                                                <i class="ti ti-eye text-white"></i>
                                                            </a>
                                                        </div>
                                                    @endif
                                                @endcan
                                                @can('edit bill')
                                                    <div class="ms-2">
                                                        <a href="{{ route('bill.edit',\Crypt::encrypt($bill->id)) }}" class="backgroundnone mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="Edit" data-original-title="{{__('Edit')}}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                @endcan
                                                @can('delete bill')
                                                    <div class="ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['bill.destroy', $bill->id],'class'=>'delete-form-btn','id'=>'delete-form-'.$bill->id]) !!}
                                                        <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$bill->id}}').submit();">
                                                            <i class="ti ti-trash text-white"></i>
                                                        </a>
                                                        {!! Form::close() !!}
                                                    </div>
                                                @endcan
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
    <script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"  integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script>
@include('new_layouts.footer')
