@include('new_layouts.header')
@include('accounting.side-menu')
<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet"/>
<div class="row">
  <div class="col-md-6">
     <h2>{{__('Debit Note')}}</h2>
  </div>
  <div class="col-md-6 float-end floatrght">

        @can('create debit note')
            <a  class="floatrght mb-3 btn  btn-primary" href="#" data-url="{{ route('bill.custom.debit.note') }}" data-ajax-popup="true" data-title="{{__('Create New Debit Note')}}" data-bs-toggle="tooltip" title="{{__('Create')}}">
                <i class="ti ti-plus"></i>
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
                                <th> {{__('Bill')}}</th>
                                <th> {{__('Vendor')}}</th>
                                <th> {{__('Date')}}</th>
                                <th> {{__('Amount')}}</th>
                                <th> {{__('Description')}}</th>
                                <th width="10%"> {{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($bills as $bill)
                                @if(!empty($bill->debitNote))
                                    @foreach ($bill->debitNote as $debitNote)

                                        <tr class="font-style">
                                            <td class="Id">
                                                <a href="{{ route('bill.show',\Crypt::encrypt($debitNote->bill)) }}" class="btn btn-outline-primary">{{ AUth::user()->billNumberFormat($bill->bill_id) }}

                                                </a>
                                            </td>
                                            <td>{{ (!empty($bill->vender)?$bill->vender->name:'-') }}</td>
                                            <td>{{ Auth::user()->dateFormat($debitNote->date) }}</td>
                                            <td>{{ Auth::user()->priceFormat($debitNote->amount) }}</td>
                                            <td>{{!empty($debitNote->description)?$debitNote->description:'-'}}</td>

                                            <td>
                                              <div class="ms-2" style="display:flex;gap:10px;">
                                                    @can('edit payment')
                                                        <div class="action-btn  ms-2">
                                                             <a data-url="{{ route('bill.edit.debit.note',[$debitNote->bill,$debitNote->id]) }}" data-ajax-popup="true" data-title="{{__('Edit Debit Note')}}" href="#" class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        </div>
                                                    @endcan
                                                    @can('delete payment')
                                                        <div class="action-btn ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => array('bill.delete.debit.note', $debitNote->bill,$debitNote->id),'id'=>'delete-form-'.$debitNote->id]) !!}

                                                          <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$debitNote->id}}').submit();">
                                                              <i class="ti ti-trash text-white"></i>
                                                          </a>
                                                          {!! Form::close() !!}
                                                        </div>
                                                    @endcan
                                              </div>
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
