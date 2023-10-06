@include('new_layouts.header')
@include('accounting.side-menu')
<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet"/>
<div class="row">
  <div class="col-md-6">
     <h2>{{__('Credit Notes')}}</h2>
  </div>
  <div class="col-md-6 float-end">

         @can('create credit note')
            <a class="btn btn-sm btn-primary floatrght" href="#" data-url="{{ route('invoice.custom.credit.note') }}"data-bs-toggle="tooltip" title="{{__('Create')}}" data-ajax-popup="true" data-title="{{__('Create New Credit Note')}}" >
                <i class="ti ti-plus"></i>
            </a>
        @endcan

  </div>
</div>


<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style mt-2">
                    <h5></h5>
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th> {{__('Invoice')}}</th>
                                <th> {{__('Customer')}}</th>
                                <th> {{__('Date')}}</th>
                                <th> {{__('Amount')}}</th>
                                <th> {{__('Description')}}</th>
                                <th width="10%">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($invoices as $invoice)
                                @if(!empty($invoice->creditNote))
                                    @foreach ($invoice->creditNote as $creditNote)
                                        <tr>
                                            <td class="Id">
                                                <a href="{{ route('invoice.show',\Crypt::encrypt($creditNote->invoice)) }}" class="btn btn-outline-primary">{{ AUth::user()->invoiceNumberFormat($invoice->invoice_id) }}</a>
                                            </td>
                                            <td>{{ (!empty($invoice->customer)?$invoice->customer->name:'-') }}</td>
                                            <td>{{ Auth::user()->dateFormat($creditNote->date) }}</td>
                                            <td>{{ Auth::user()->priceFormat($creditNote->amount) }}</td>
                                            <td>{{!empty($creditNote->description)?$creditNote->description:'-'}}</td>
                                            <td>
                                                @can('edit credit note')
                                                    <div class="action-btn bg-primary ms-2">
                                                        <a data-url="{{ route('invoice.edit.credit.note',[$creditNote->invoice,$creditNote->id]) }}" data-ajax-popup="true" data-title="{{__('Edit Credit Note')}}" href="#" class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                @endcan
                                                @can('edit credit note')
                                                        <div class="action-btn bg-danger ms-2">
                                                            {!! Form::open(['method' => 'DELETE', 'route' => array('invoice.delete.credit.note', $creditNote->invoice,$creditNote->id),'class'=>'delete-form-btn','id'=>'delete-form-'.$creditNote->id]) !!}
                                                                <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$creditNote->id}}').submit();">
                                                                    <i class="ti ti-trash text-white"></i>
                                                                </a>
                                                            {!! Form::close() !!}
                                                        </div>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
      </div>
</div>
@include('new_layouts.footer')
<script src="{{ asset('datatable/jquery.dataTables.min.js') }}"></script>
