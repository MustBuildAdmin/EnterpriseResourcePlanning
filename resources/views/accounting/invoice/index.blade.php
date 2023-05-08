@include('new_layouts.header')
@include('accounting.side-menu')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="mt-2 " id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        @if (!\Auth::guard('customer')->check())
                            {{ Form::open(['route' => ['invoice.index'], 'method' => 'GET', 'id' => 'customer_submit']) }}
                        @else
                            {{ Form::open(['route' => ['customer.invoice'], 'method' => 'GET', 'id' => 'customer_submit']) }}
                        @endif
                        <div class="row d-flex align-items-center justify-content-end">
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                <div class="btn-box">
                                    {{ Form::label('issue_date', __('Issue Date'),['class'=>'form-label'])}}
                                    {{ Form::date('issue_date', isset($_GET['issue_date'])?$_GET['issue_date']:'', array('placeholder'=>'Select Date','class' => 'form-control month-btn','id'=>'pc-daterangepicker-1')) }}


                                </div>
                            </div>
                            @if (!\Auth::guard('customer')->check())
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                    <div class="btn-box">
                                        {{ Form::label('customer', __('Customer'),['class'=>'form-label'])}}
                                        {{ Form::select('customer', $customer, isset($_GET['customer']) ? $_GET['customer'] : '', ['class' => 'form-control select']) }}
                                    </div>
                                </div>
                            @endif
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                <div class="btn-box">
                                    {{ Form::label('status', __('Status'),['class'=>'form-label'])}}
                                    {{ Form::select('status', [''=>'Select Status'] + $status,isset($_GET['status'])?$_GET['status']:'', array('class' => 'form-control select')) }}

                                </div>
                            </div>
                            <div class="col-auto float-end ms-2 mt-4">

                                <a href="#" class="btn btn-sm btn-primary"
                                   onclick="document.getElementById('customer_submit').submit(); return false;"
                                   data-toggle="tooltip" data-original-title="{{ __('apply') }}">
                                    <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                </a>

                                @if (!\Auth::guard('customer')->check())
                                    <a href="{{ route('invoice.index') }}" class="btn btn-sm btn-danger" data-toggle="tooltip"
                                       data-original-title="{{ __('Reset') }}">
                                        <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off"></i></span>
                                    </a>
                                @else
                                    <a href="{{ route('customer.index') }}" class="btn btn-sm btn-primary" data-toggle="tooltip"
                                       data-original-title="{{ __('Reset') }}">
                                        <span class="btn-inner--icon"><i class="ti ti-trash text-white-off"></i></span>
                                    </a>
                                @endif
                            </div>

                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <h5></h5>
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th> {{ __('Invoice') }}</th>
                                @if (!\Auth::guard('customer')->check())
                                    <th>{{ __('Customer') }}</th>
                                @endif
                                <th>{{ __('Issue Date') }}</th>
                                <th>{{ __('Due Date') }}</th>
                                <th>{{ __('Due Amount') }}</th>
                                <th>{{ __('Status') }}</th>
                                @if (Gate::check('edit invoice') || Gate::check('delete invoice') || Gate::check('show invoice'))
                                    <th>{{ __('Action') }}</th>
                                @endif
                                {{-- <th>
                                <td class="barcode">
                                    {!! DNS1D::getBarcodeHTML($invoice->sku, "C128",1.4,22) !!}
                                    <p class="pid">{{$invoice->sku}}</p>
                                </td>
                            </th> --}}
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td class="Id">
                                        @if (\Auth::guard('customer')->check())
                                            <a href="{{ route('customer.invoice.show', \Crypt::encrypt($invoice->id)) }}" class="btn btn-outline-primary">{{ AUth::user()->invoiceNumberFormat($invoice->invoice_id) }}</a>
                                        @else
                                            <a href="{{ route('invoice.show', \Crypt::encrypt($invoice->id)) }}" class="btn btn-outline-primary">{{ AUth::user()->invoiceNumberFormat($invoice->invoice_id) }}</a>
                                        @endif
                                    </td>
                                    @if (!\Auth::guard('customer')->check())
                                        <td> {{ !empty($invoice->customer) ? $invoice->customer->name : '' }} </td>


                                    @endif
                                    <td>{{ Auth::user()->dateFormat($invoice->issue_date) }}</td>
                                    <td>
                                        @if ($invoice->due_date < date('Y-m-d'))
                                            <p class="text-danger">
                                                {{ \Auth::user()->dateFormat($invoice->due_date) }}</p>
                                        @else
                                            {{ \Auth::user()->dateFormat($invoice->due_date) }}
                                        @endif
                                    </td>
                                    <td>{{ \Auth::user()->priceFormat($invoice->getDue()) }}</td>
                                    <td>
                                        @if ($invoice->status == 0)
                                            <span
                                                class="status_badge badge bg-secondary p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</span>
                                        @elseif($invoice->status == 1)
                                            <span
                                                class="status_badge badge bg-warning p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</span>
                                        @elseif($invoice->status == 2)
                                            <span
                                                class="status_badge badge bg-danger p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</span>
                                        @elseif($invoice->status == 3)
                                            <span
                                                class="status_badge badge bg-info p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</span>
                                        @elseif($invoice->status == 4)
                                            <span
                                                class="status_badge badge bg-primary p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</span>
                                        @endif
                                    </td>
                                    @if (Gate::check('edit invoice') || Gate::check('delete invoice') || Gate::check('show invoice'))
                                        <td class="Action">
                                                <span>
                                                @php $invoiceID= Crypt::encrypt($invoice->id); @endphp

                                                    @can('copy invoice')
                                                        <div class="action-btn bg-warning ms-2">
                                                            <a href="#" id="{{ route('invoice.link.copy',[$invoiceID]) }}" class="mx-3 btn btn-sm align-items-center"   onclick="copyToClipboard(this)" data-bs-toggle="tooltip" data-original-title="{{__('Click to copy')}}"><i class="ti ti-link text-white"></i></a>
                                                        </div>
                                                    @endcan
                                                    @can('duplicate invoice')
                                                        <div class="action-btn bg-success ms-2">
                                                           {!! Form::open(['method' => 'get', 'route' => ['invoice.duplicate', $invoice->id], 'id' => 'duplicate-form-' . $invoice->id]) !!}
                                                           {!! Form::open(['method' => 'get', 'route' => ['invoice.duplicate', $invoice->id], 'id' => 'duplicate-form-' . $invoice->id]) !!}

                                                            <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para-duplicate" data-toggle="tooltip"
                                                               data-original-title="{{ __('Duplicate Invoice') }}" data-bs-toggle="tooltip" title="Duplicate Invoice"
                                                               data-original-title="{{ __('Duplicate Invoice') }}"
                                                               data-confirm="You want to confirm this action. Press Yes to continue or Cancel to go back"
                                                               data-confirm-yes="document.getElementById('duplicate-form-{{ $invoice->id }}').submit();">
                                                                <i class="ti ti-copy text-white"></i>
                                                            </a>
                                                            {!! Form::close() !!}

                                                        </div>
                                                    @endcan
                                                    @can('show invoice')
                                                        @if (\Auth::guard('customer')->check())
                                                            <div class="action-btn bg-info ms-2">
                                                                    <a href="{{ route('customer.invoice.show', \Crypt::encrypt($invoice->id)) }}"
                                                                       class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="Show "
                                                                       data-original-title="{{ __('Detail') }}">
                                                                        <i class="ti ti-eye text-white"></i>
                                                                    </a>
                                                                </div>
                                                        @else
                                                            <div class="action-btn bg-info ms-2">
                                                                    <a href="{{ route('invoice.show', \Crypt::encrypt($invoice->id)) }}"
                                                                       class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="Show "
                                                                       data-original-title="{{ __('Detail') }}">
                                                                        <i class="ti ti-eye text-white"></i>
                                                                    </a>
                                                                </div>
                                                        @endif
                                                    @endcan
                                                    @can('edit invoice')
                                                        <div class="action-btn bg-primary ms-2">
                                                                <a href="{{ route('invoice.edit', \Crypt::encrypt($invoice->id)) }}"
                                                                   class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="Edit "
                                                                   data-original-title="{{ __('Edit') }}">
                                                                    <i class="ti ti-pencil text-white"></i>
                                                                </a>
                                                            </div>
                                                    @endcan
                                                    @can('delete invoice')
                                                        <div class="action-btn bg-danger ms-2">
                                                                {!! Form::open(['method' => 'DELETE', 'route' => ['invoice.destroy', $invoice->id], 'id' => 'delete-form-' . $invoice->id]) !!}
                                                                    <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para " data-bs-toggle="tooltip" title="{{__('Delete')}}"
                                                                       data-original-title="{{ __('Delete') }}"
                                                                       data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                                                                       data-confirm-yes="document.getElementById('delete-form-{{ $invoice->id }}').submit();">
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
@endsection




<div class="row">
  <div class="col-md-6">
     <h2>Invoice</h2>
  </div>
  <div class="col-md-6 float-end floatrght">

    @can('create transfer')
        <a class="floatrght mb-3 btn btn-sm btn-primary"  href="#" data-size="lg" data-url="{{ route('transfer.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create New Transfer')}}">
            {{__('Create')}} &nbsp;<i class="ti ti-plus"></i>
    </a>
    @endcan

  </div>
</div>


    <div class="row">
   
        <div class="col-md-12">
            <div class="card">
            <div class="card-body table-border-style">
                    <div class="table-responsive">
                    <table class="table datatable">
                            <thead>
                            <tr>
                                <th>{{__('Invoice')}}</th>
                                <th>{{__('Issue Date')}}</th>
                                <th>{{__('Due Amount')}}</th>
                                <th>{{__('Status')}}</th>
                                <th width="200px">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                           
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                      <div class="ms-2" style="display:flex;gap:10px;">
                                        <a href="http://localhost/musterpnew/public/employee/eyJpdiI6IkJ3dGYxOW1rUnhsV1ZKdjhFOUdscUE9PSIsInZhbHVlIjoiSUNVZUtYQitNTzZaZDVIRmp3SzlHZz09IiwibWFjIjoiMzliNmIwODM5NTdhYjEwMzk3YWIzZWE5ZjFhYWY4ODk4YWFkNDgxZmZmZmQxODUxNjFlNTI2YjkzM2YyMDg5NSIsInRhZyI6IiJ9/edit" class="btn btn-md bg-primary" data-bs-toggle="tooltip" data-original-title="Edit" aria-label="Edit" data-bs-original-title="Edit">
                                          <i class="ti ti-pencil text-white"></i>
                                        </a>
                                        <form method="POST" action="http://localhost/musterpnew/public/employee/129" accept-charset="UTF-8" id="delete-form-129">
                                          <input name="_method" type="hidden" value="DELETE">
                                          <input name="_token" type="hidden" value="tETQcqzxpcfwciWVlZTuvTuLhj9IEudc3K08xH5Z">
                                          <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" data-original-title="Delete" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-129').submit();" aria-label="Delete" data-bs-original-title="Delete">
                                            <i class="ti ti-trash text-white"></i>
                                          </a>
                                        </form>
                                      </div>
                                    </td>
                                </tr>
                           
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>





@include('new_layouts.footer')
