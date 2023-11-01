
@include('new_layouts.header')
@include('accounting.side-menu')
<style>
    #card-element {
        border: 1px solid #a3afbb !important;
        border-radius: 10px !important;
        padding: 10px !important;
    }
</style>

    <div class="row">
        <div class="col-md-6">
        <h2>{{__('Invoice Detail')}}</h2>
        </div>

        @can('send invoice')

            @if($invoice->status!=4)
                <div class="row">
                    <div class="col-12">
                        <div class="card ">
                        <div class="card-body">
                            <div class="row timeline-wrapper">
                                <div class="col-md-6 col-lg-4 col-xl-4">
                                    <div class="timeline-icons"><span class="timeline-dots"></span>
                                        <i class="ti ti-plus text-primary"></i>
                                    </div>
                                    <h6 class="text-primary my-3">{{__('Create Invoice')}}</h6>
                                    <p class="text-muted text-sm mb-3"><i class="ti ti-clock mr-2"></i>{{__('Created on ')}}{{\Auth::user()->dateFormat($invoice->issue_date)}}</p>
                                    @can('edit invoice')
                                        <a href="{{ route('invoice.edit',\Crypt::encrypt($invoice->id)) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-original-title="{{__('Edit')}}"><i class="ti ti-pencil mr-2"></i>{{__('Edit')}}</a>
                                    @endcan
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-4">
                                    <div class="timeline-icons"><span class="timeline-dots"></span>
                                        <i class="ti ti-mail text-warning"></i>
                                    </div>
                                    <h6 class="text-warning my-3">{{__('Send Invoice')}}</h6>
                                    <p class="text-muted text-sm mb-3">
                                        @if($invoice->status!=0)
                                            <i class="ti ti-clock mr-2"></i>{{__('Sent on')}} {{\Auth::user()->dateFormat($invoice->send_date)}}
                                        @else
                                            @can('send invoice')
                                                <small>{{__('Status')}} : {{__('Not Sent')}}</small>
                                            @endcan
                                        @endif
                                    </p>

                                    @if($invoice->status==0)
                                        @can('send bill')
                                            <a href="{{ route('invoice.sent',$invoice->id) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-original-title="{{__('Mark Sent')}}"><i class="ti ti-send mr-2"></i>{{__('Send')}}</a>
                                        @endcan
                                    @endif
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-4">
                                    <div class="timeline-icons"><span class="timeline-dots"></span>
                                        <i class="ti ti-report-money text-info"></i>
                                    </div>
                                    <h6 class="text-info my-3">{{__('Get Paid')}}</h6>
                                    <p class="text-muted text-sm mb-3">{{__('Status')}} : {{__('Awaiting payment')}} </p>
                                    @if($invoice->status!=0)
                                        @can('create payment invoice')
                                            <a href="#" data-url="{{ route('invoice.payment',$invoice->id) }}" data-ajax-popup="true" data-title="{{__('Add Payment')}}" class="btn btn-sm btn-info" data-original-title="{{__('Add Payment')}}"><i class="ti ti-report-money mr-2"></i>{{__('Add Payment')}}</a> <br>
                                        @endcan
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            @endif
        @endcan

        @if(\Auth::user()->type=='company')
            @if($invoice->status!=0)
                <div class="row justify-content-between align-items-center mb-3">
                    <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
                        @if(!empty($invoicePayment))
                            <div class="all-button-box mx-2 mr-2">
                                <a href="#" class="btn btn-sm btn-primary" data-url="{{ route('invoice.credit.note',$invoice->id) }}" data-ajax-popup="true" data-title="{{__('Add Credit Note')}}">
                                    {{__('Add Credit Note')}}
                                </a>
                            </div>
                        @endif
                        @if($invoice->status!=4)
                            <div class="all-button-box mr-2">
                                <a href="{{ route('invoice.payment.reminder',$invoice->id)}}" class="btn btn-sm btn-primary me-2">{{__('Receipt Reminder')}}</a>
                            </div>
                        @endif
                        <div class="all-button-box mr-2">
                            <a href="{{ route('invoice.resent',$invoice->id)}}" class="btn btn-sm btn-primary me-2">{{__('Resend Invoice')}}</a>
                        </div>
                        <div class="all-button-box">
                            <a href="{{ route('invoice.pdf', Crypt::encrypt($invoice->id))}}" target="_blank" class="btn btn-sm btn-primary">{{__('Download')}}</a>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice">
                            <div class="invoice-print">
                                <div class="row invoice-title mt-2">
                                    <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12">
                                        <h4>{{__('Invoice')}}</h4>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12 text-end">
                                        <h4 class="invoice-number">{{ AUth::user()->invoiceNumberFormat($invoice->invoice_id) }}</h4>
                                    </div>
                                    <div class="col-12">
                                        <hr>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col text-end">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <div class="me-4">
                                                <small>
                                                    <strong>{{__('Issue Date')}} :</strong><br>
                                                    {{\Auth::user()->dateFormat($invoice->issue_date)}}<br><br>
                                                </small>
                                            </div>
                                            <div>
                                                <small>
                                                    <strong>{{__('Due Date')}} :</strong><br>
                                                    {{\Auth::user()->dateFormat($invoice->due_date)}}<br><br>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    @if(!empty($customer->billing_name))
                                        <div class="col">
                                            <small class="font-style">
                                                <strong>{{__('Billed To')}} :</strong><br>
                                                {{!empty($customer->billing_name)?$customer->billing_name:''}}<br>
                                                {{!empty($customer->billing_phone)?$customer->billing_phone:''}}<br>
                                                {{!empty($customer->billing_address)?$customer->billing_address:''}}<br>
                                                {{!empty($customer->billing_zip)?$customer->billing_zip:''}}<br>
                                                {{!empty($customer->billing_city)?$customer->billing_city:'' .', '}} {{!empty($customer->billing_state)?\App\Models\Utility::getstate_detailsonly_name($customer->billing_country,$customer->billing_state):'',', '}} {{!empty($customer->billing_country)?\App\Models\Utility::getcountry_detailsonly_name($customer->billing_country):''}}<br>
                                                <strong>{{__('Tax Number ')}} : </strong>{{!empty($customer->tax_number)?$customer->tax_number:''}}

                                            </small>
                                        </div>
                                    @endif
                                    @if(App\Models\Utility::getValByName('shipping_display')=='on')
                                        <div class="col ">
                                            <small>
                                                <strong>{{__('Shipped To')}} :</strong><br>
                                                {{!empty($customer->shipping_name)?$customer->shipping_name:''}}<br>
                                                {{!empty($customer->shipping_phone)?$customer->shipping_phone:''}}<br>
                                                {{!empty($customer->shipping_address)?$customer->shipping_address:''}}<br>
                                                {{!empty($customer->shipping_zip)?$customer->shipping_zip:''}}<br>
                                                {{!empty($customer->shipping_city)?$customer->shipping_city:'' . ', '}} {{!empty($customer->shipping_state)?\App\Models\Utility::getstate_detailsonly_name($customer->billing_country,$customer->shipping_state):'' .', '}},{{!empty($customer->shipping_country)?\App\Models\Utility::getcountry_detailsonly_name($customer->shipping_country):''}}<br>
                                                <strong>{{__('Tax Number ')}} : </strong>{{!empty($customer->tax_number)?$customer->tax_number:''}}

                                            </small>
                                        </div>
                                    @endif
                                    <div class="col">
                                        <div class="float-end mt-3">
                                            {!! DNS2D::getBarcodeHTML(route('invoice.link.copy',\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)), "QRCODE",2,2) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-4">
                                        <small>
                                            <strong>{{__('Status')}} :</strong><br>
                                            @if($invoice->status == 0)
                                                <span class="badge bg-primary">{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</span>
                                            @elseif($invoice->status == 1)
                                                <span class="badge bg-warning">{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</span>
                                            @elseif($invoice->status == 2)
                                                <span class="badge bg-danger">{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</span>
                                            @elseif($invoice->status == 3)
                                                <span class="badge bg-info">{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</span>
                                            @elseif($invoice->status == 4)
                                                <span class="badge bg-success">{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</span>
                                            @endif
                                        </small>
                                    </div>
                                    <div class="col">
                                        @php  
                                            $statecode=\App\Models\Utility::statecode();
                                        @endphp
                                        <small>
                                            <strong>{{__('Place Of Supply')}} :</strong><br>
                                                <span>{{!empty($customer->shipping_state)?\App\Models\Utility::getstate_detailsonly_name($customer->billing_country,$customer->shipping_state):'' .', '}} 
                                                @isset($statecode[$customer->shipping_state])
                                                    ({{$statecode[$customer->shipping_state]}})
                                                @endisset
                                                </span>
                                        </small>
                                    </div>



                                    @if(!empty($customFields) && count($invoice->customField)>0)
                                        @foreach($customFields as $field)
                                            <div class="col text-md-right">
                                                <small>
                                                    <strong>{{$field->name}} :</strong><br>
                                                    {{!empty($invoice->customField)?$invoice->customField[$field->id]:'-'}}
                                                    <br><br>
                                                </small>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="font-weight-bold">{{__('Product Summary')}}</div>
                                        <small>{{__('All items here cannot be deleted.')}}</small>
                                        <div class="table-responsive mt-2">
                                            <table class="table mb-0 table-striped">
                                                <tr>
                                                    <th data-width="40" class="text-dark">#</th>
                                                    <th class="text-dark">{{__('Product')}}</th>
                                                    <th class="text-dark">{{__('Quantity')}}</th>
                                                    <th class="text-dark">{{__('HSC/SAC')}}</th>
                                                    <th class="text-dark">{{__('Rate')}}</th>
                                                    <th class="text-dark">{{__('Discount')}}</th>
                                                    @if($setting['indiangst']==1)
                                                        @if($gstflag==1)
                                                            <th class="text-dark">CGST</th>
                                                            @if(in_array($customer->shipping_state, \App\Models\Utility::union_state()))
                                                                <th class="text-dark">UTGST</th>
                                                            @else
                                                                <th class="text-dark">SGST</th>
                                                            @endif
                                                        
                                                        @else
                                                            <th class="text-dark">IGST</th>
                                                        @endif
                                                    @else
                                                        <th class="text-dark">{{__('Tax')}}</th>
                                                    @endif
                                                    {{-- <th class="text-dark">{{__('Description')}}</th> --}}
                                                    <th class="text-end text-dark" width="12%">{{__('Price')}}<br>
                                                        <small class="text-danger font-weight-bold">{{__('before tax & discount')}}</small>
                                                    </th>
                                                </tr>
                                                @php
                                                    $totalQuantity=0;
                                                    $totalRate=0;
                                                    $totalTaxPrice=0;
                                                    $totalDiscount=0;
                                                    $taxesData=[];
                                                @endphp
                                                @foreach($iteams as $key =>$iteam)
                                                    @if(!empty($iteam->tax))
                                                        @php
                                                            $taxes=App\Models\Utility::tax($iteam->tax);
                                                            $totalQuantity+=$iteam->quantity;
                                                            $totalRate+=$iteam->price;
                                                            $totalDiscount+=$iteam->discount;
                                                            foreach($taxes as $taxe){
                                                                $taxDataPrice=App\Models\Utility::taxRate($taxe->rate,$iteam->price,$iteam->quantity);
                                                                if (array_key_exists($taxe->name,$taxesData))
                                                                {
                                                                    $taxesData[$taxe->name] = $taxesData[$taxe->name]+$taxDataPrice;
                                                                }
                                                                else
                                                                {
                                                                    $taxesData[$taxe->name] = $taxDataPrice;
                                                                }
                                                            }
                                                        @endphp
                                                    @endif
                                                    <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{!empty($iteam->product())?$iteam->product()->name:''}}</td>
                                                        <td>{{$iteam->quantity}}</td>
                                                        <td> @isset($hsc[$iteam->id]) {{$hsc[$iteam->id]}} @endisset</td>
                                                        <td>{{\Auth::user()->priceFormat($iteam->price)}}</td>
                                                        <td>{{\Auth::user()->priceFormat($iteam->discount)}}</td>
                                                        @if($setting['indiangst']==1)
                                                                @if($gstflag==1)
                                                                {{-- // tax calucluation --}}
                                                                    @if(!empty($iteam->tax))
                                                                        @php $totalTaxRate = 0;@endphp
                                                                        @foreach($taxes as $tax)
                                                                            @php
                                                                                $taxPrice=App\Models\Utility::taxRate($tax->rate,$iteam->price,$iteam->quantity);
                                                                                $totalTaxPrice+=$taxPrice;
                                                                            @endphp
                                                                                <td>{{\Auth::user()->priceFormat($taxPrice/2)}}{{' '.' ('.$tax->rate/2 .'%)'}}</td>
                                                                                <td>{{\Auth::user()->priceFormat($taxPrice/2)}}{{' '.' ('.$tax->rate/2 .'%)'}}</td>
                                                                        @endforeach
                                                                    @else
                                                                    <td>-</td>
                                                                    @endif
                                                                @else
                                                                @if(!empty($iteam->tax))
                                                                    
                                                                        @php $totalTaxRate = 0;@endphp
                                                                        @foreach($taxes as $tax)
                                                                            @php
                                                                                $taxPrice=App\Models\Utility::taxRate($tax->rate,$iteam->price,$iteam->quantity);
                                                                                $totalTaxPrice+=$taxPrice;
                                                                            @endphp
                                                                                <td>{{\Auth::user()->priceFormat($taxPrice)}}{{' '.' ('.$tax->rate .'%)'}}</td>
                                                                        @endforeach
                                                                    @else
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    @endif
                                                                @endif

                                                        @else
                                                        <td>
                                                            @if(!empty($iteam->tax))
                                                                <table>
                                                                    @php $totalTaxRate = 0;@endphp
                                                                    @foreach($taxes as $tax)
                                                                        @php
                                                                            $taxPrice=App\Models\Utility::taxRate($tax->rate,$iteam->price,$iteam->quantity);
                                                                            $totalTaxPrice+=$taxPrice;
                                                                        @endphp
                                                                        <tr>
                                                                            <td>{{$tax->name .' ('.$tax->rate .'%)'}}</td>
                                                                            <td>{{\Auth::user()->priceFormat($taxPrice)}}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </table>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        @endif
                                                        
                                                        {{-- <td>{{!empty($iteam->description)?$iteam->description:'-'}}</td> --}}
                                                        <td class="text-end">{{\Auth::user()->priceFormat(($iteam->price*$iteam->quantity))}}</td>
                                                    </tr>
                                                @endforeach
                                                <tfoot>
                                                <tr>
                                                    <td></td>
                                                    <td><b>{{__('Total')}}</b></td>
                                                    <td><b>{{$totalQuantity}}</b></td>
                                                    <td></td>
                                                    <td><b>{{\Auth::user()->priceFormat($totalRate)}}</b></td>
                                                    <td>
                                                        <b>{{\Auth::user()->priceFormat($totalDiscount)}}</b>

                                                    </td>
                                                    {{-- //gst caluculation --}}
                                                    @php $col=6; @endphp
                                                    @if($setting['indiangst']==1)
                                                        @if($gstflag==1)
                                                        @php $col=7; @endphp
                                                                <td>{{\Auth::user()->priceFormat($totalTaxPrice/2)}}</td>
                                                                <td>{{\Auth::user()->priceFormat($totalTaxPrice/2)}}</td>
                                                        @else
                                                                <td>{{\Auth::user()->priceFormat($totalTaxPrice)}}</td>
                                                        @endif

                                                    @else
                                                        <td><b>{{\Auth::user()->priceFormat($totalTaxPrice)}}</b></td>
                                                    @endif
                                                    {{-- //gst caluculation --}}
                                                    
                                                    {{-- <td></td> --}}
                                                </tr>
                                                <tr>
                                                    <td colspan={{$col}}></td>
                                                    <td class="text-end"><b>{{__('Sub Total')}}</b></td>
                                                    <td class="text-end">{{\Auth::user()->priceFormat($invoice->getSubTotal())}}</td>
                                                </tr>

                                                

                                                @if(!empty($taxesData))
                                                    @foreach($taxesData as $taxName => $taxPrice)
                                                    {{-- gst calucluation --}}
                                                    @if($setting['indiangst']==1)
                                                        @if($gstflag==1)
                                                            <tr>
                                                                <td colspan={{$col}}></td>
                                                                <td class="text-end"><b>CGST</b></td>
                                                                <td class="text-end">{{ \Auth::user()->priceFormat($taxPrice/2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan={{$col}}></td>
                                                                @if(in_array($customer->shipping_state, \App\Models\Utility::union_state()))
                                                                    <td class="text-end"><b>UTGST</b></td>
                                                                @else
                                                                    <td class="text-end"><b>SGST</b></td>
                                                                @endif
                                                                <td class="text-end">{{ \Auth::user()->priceFormat($taxPrice/2) }}</td>
                                                            </tr>
                                                        @else
                                                            <tr>
                                                                <td colspan={{$col}}></td>
                                                                <td class="text-end"><b>IGST</b></td>
                                                                <td class="text-end">{{ \Auth::user()->priceFormat($taxPrice) }}</td>
                                                            </tr>
                                                        @endif
                                                    @else
                                                        <tr>
                                                            <td colspan={{$col}}></td>
                                                            <td class="text-end"><b>{{$taxName}}</b></td>
                                                            <td class="text-end">{{ \Auth::user()->priceFormat($taxPrice) }}</td>
                                                        </tr>
                                                    @endif
                                                    @endforeach
                                                @endif
                                                <tr>
                                                    <td colspan={{$col}}></td>
                                                    <td class="blue-text text-end"><b>{{__('Total')}}</b></td>
                                                    <td class="blue-text text-end">{{\Auth::user()->priceFormat($invoice->getTotal())}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan={{$col}}></td>
                                                    <td class="text-end"><b>{{__('Paid')}}</b></td>
                                                    <td class="text-end">{{\Auth::user()->priceFormat(($invoice->getTotal()-$invoice->getDue())-($invoice->invoiceTotalCreditNote()))}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan={{$col}}></td>
                                                    <td class="text-end"><b>{{__('Credit Note')}}</b></td>
                                                    <td class="text-end">{{\Auth::user()->priceFormat(($invoice->invoiceTotalCreditNote()))}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan={{$col}}></td>
                                                    <td class="text-end"><b>{{__('Due')}}</b></td>
                                                    <td class="text-end">{{\Auth::user()->priceFormat($invoice->getDue())}}</td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body table-border-style">
                        <h5 class=" d-inline-block  mb-5">{{__('Receipt Summary')}}</h5>

                        <div class="table-responsive">
                            <table class="table ">
                                <thead>
                                <tr>
                                    <th class="text-dark">{{__('Payment Receipt')}}</th>
                                    <th class="text-dark">{{__('Date')}}</th>
                                    <th class="text-dark">{{__('Amount')}}</th>
                                    <th class="text-dark">{{__('Payment Type')}}</th>
                                    <th class="text-dark">{{__('Account')}}</th>
                                    <th class="text-dark">{{__('Reference')}}</th>
                                    <th class="text-dark">{{__('Description')}}</th>
                                    <th class="text-dark">{{__('Receipt')}}</th>
                                    <th class="text-dark">{{__('OrderId')}}</th>
                                    @can('delete payment invoice')
                                        <th class="text-dark">{{__('Action')}}</th>
                                    @endcan
                                </tr>
                                </thead>
                                @forelse($invoice->payments as $key =>$payment)
                                    <tr>
                                        <td>
                                            @if(!empty($payment->add_receipt))
                                                <a href="{{asset(Storage::url('uploads/payment')).'/'.$payment->add_receipt}}" download="" class="btn btn-sm btn-secondary btn-icon rounded-pill" target="_blank"><span class="btn-inner--icon"><i class="ti ti-download"></i></span></a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{\Auth::user()->dateFormat($payment->date)}}</td>
                                        <td>{{\Auth::user()->priceFormat($payment->amount)}}</td>
                                        <td>{{$payment->payment_type}}</td>
                                        <td>{{!empty($payment->bankAccount)?$payment->bankAccount->bank_name.' '.$payment->bankAccount->holder_name:'--'}}</td>
                                        <td>{{!empty($payment->reference)?$payment->reference:'--'}}</td>
                                        <td>{{!empty($payment->description)?$payment->description:'--'}}</td>
                                        <td>@if(!empty($payment->receipt))<a href="{{$payment->receipt}}" target="_blank"> <i class="ti ti-file"></i></a>@else -- @endif</td>
                                        <td>{{!empty($payment->order_id)?$payment->order_id:'--'}}</td>
                                        @can('delete invoice product')
                                            <td>
                                                <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open(['method' => 'post', 'route' => ['invoice.payment.destroy',$invoice->id,$payment->id],'id'=>'delete-form-'.$payment->id]) !!}

                                                    <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para " data-bs-toggle="tooltip" title="Delete" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$payment->id}}').submit();">
                                                        <i class="ti ti-trash text-white"></i>
                                                    </a>
                                                {!! Form::close() !!}
                                            </td>
                                        @endcan
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ (Gate::check('delete invoice product') ? '9' : '8') }}" class="text-center text-dark"><p>{{__('No Data Found')}}</p></td>
                                    </tr>
                                @endforelse
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body table-border-style">
                        <h5 class=" d-inline-block  mb-5">{{__('Credit Note Summary')}}</h5>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="text-dark">{{__('Date')}}</th>
                                    <th class="text-dark" class="">{{__('Amount')}}</th>
                                    <th class="text-dark" class="">{{__('Description')}}</th>
                                    @if(Gate::check('edit credit note') || Gate::check('delete credit note'))
                                        <th class="text-dark">{{__('Action')}}</th>
                                    @endif
                                </tr>
                                </thead>
                                @forelse($invoice->creditNote as $key =>$creditNote)
                                    <tr>
                                        <td>{{\Auth::user()->dateFormat($creditNote->date)}}</td>
                                        <td class="">{{\Auth::user()->priceFormat($creditNote->amount)}}</td>
                                        <td class="">{{$creditNote->description}}</td>
                                        <td>
                                            @can('edit credit note')
                                                <div class="action-btn bg-primary ms-2">
                                                    <a data-url="{{ route('invoice.edit.credit.note',[$creditNote->invoice,$creditNote->id]) }}" data-ajax-popup="true" title="{{__('Edit')}}" data-original-title="{{__('Credit Note')}}" href="#" class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                            @endcan
                                            @can('delete credit note')
                                                <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => array('invoice.delete.credit.note', $creditNote->invoice,$creditNote->id),'id'=>'delete-form-'.$creditNote->id]) !!}
                                                    <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para " data-bs-toggle="tooltip" title="Delete" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$creditNote->id}}').submit();">
                                                        <i class="ti ti-trash text-white"></i>
                                                    </a>
                                                    {!! Form::close() !!}
                                                </div>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <p class="text-dark">{{__('No Data Found')}}</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @auth('customer')
            @if($invoice->getDue() > 0)
                <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="paymentModalLabel">{{ __('Add Payment') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card bg-none card-box">
                                    <section class="nav-tabs p-2">
                                        @if(!empty($company_payment_setting) && ($company_payment_setting['is_stripe_enabled'] == 'on' || $company_payment_setting['is_paypal_enabled'] == 'on' || $company_payment_setting['is_paystack_enabled'] == 'on' || $company_payment_setting['is_flutterwave_enabled'] == 'on' || $company_payment_setting['is_razorpay_enabled'] == 'on' || $company_payment_setting['is_mercado_enabled'] == 'on' || $company_payment_setting['is_paytm_enabled'] == 'on' ||
                                $company_payment_setting['is_mollie_enabled'] ==
                                'on' ||
                                $company_payment_setting['is_paypal_enabled'] == 'on' || $company_payment_setting['is_skrill_enabled'] == 'on' || $company_payment_setting['is_coingate_enabled'] == 'on' || $company_payment_setting['is_paymentwall_enabled'] == 'on'))
                                            <ul class="nav nav-pills  mb-3" role="tablist">
                                                @if($company_payment_setting['is_stripe_enabled'] == 'on' && !empty($company_payment_setting['stripe_key']) && !empty($company_payment_setting['stripe_secret']))
                                                    <li class="nav-item mb-2">
                                                        <a class="btn btn-outline-primary btn-sm active" data-toggle="tab" href="#stripe-payment" role="tab" aria-controls="stripe" aria-selected="true">{{ __('Stripe') }}</a>
                                                    </li>
                                                @endif

                                                @if($company_payment_setting['is_paypal_enabled'] == 'on' && !empty($company_payment_setting['paypal_client_id']) && !empty($company_payment_setting['paypal_secret_key']))
                                                    <li class="nav-item mb-2">
                                                        <a class="btn btn-outline-primary btn-sm ml-1" data-toggle="tab" href="#paypal-payment" role="tab" aria-controls="paypal" aria-selected="false">{{ __('Paypal') }}</a>
                                                    </li>
                                                @endif

                                                @if($company_payment_setting['is_paystack_enabled'] == 'on' && !empty($company_payment_setting['paystack_public_key']) && !empty($company_payment_setting['paystack_secret_key']))
                                                    <li class="nav-item mb-2">
                                                        <a class="btn btn-outline-primary btn-sm ml-1" data-toggle="tab" href="#paystack-payment" role="tab" aria-controls="paystack" aria-selected="false">{{ __('Paystack') }}</a>
                                                    </li>
                                                @endif

                                                @if(isset($company_payment_setting['is_flutterwave_enabled']) && $company_payment_setting['is_flutterwave_enabled'] == 'on')
                                                    <li class="nav-item mb-2">
                                                        <a class="btn btn-outline-primary btn-sm ml-1" data-toggle="tab" href="#flutterwave-payment" role="tab" aria-controls="flutterwave" aria-selected="false">{{ __('Flutterwave') }}</a>
                                                    </li>
                                                @endif

                                                @if(isset($company_payment_setting['is_razorpay_enabled']) && $company_payment_setting['is_razorpay_enabled'] == 'on')
                                                    <li class="nav-item mb-2">
                                                        <a class="btn btn-outline-primary btn-sm ml-1" data-toggle="tab" href="#razorpay-payment" role="tab" aria-controls="razorpay" aria-selected="false">{{ __('Razorpay') }}</a>
                                                    </li>
                                                @endif

                                                @if(isset($company_payment_setting['is_mercado_enabled']) && $company_payment_setting['is_mercado_enabled'] == 'on')
                                                    <li class="nav-item mb-2">
                                                        <a class="btn btn-outline-primary btn-sm ml-1" data-toggle="tab" href="#mercado-payment" role="tab" aria-controls="mercado" aria-selected="false">{{ __('Mercado') }}</a>
                                                    </li>
                                                @endif

                                                @if(isset($company_payment_setting['is_paytm_enabled']) && $company_payment_setting['is_paytm_enabled'] == 'on')
                                                    <li class="nav-item mb-2">
                                                        <a class="btn btn-outline-primary btn-sm ml-1" data-toggle="tab" href="#paytm-payment" role="tab" aria-controls="paytm" aria-selected="false">{{ __('Paytm') }}</a>
                                                    </li>
                                                @endif

                                                @if(isset($company_payment_setting['is_mollie_enabled']) && $company_payment_setting['is_mollie_enabled'] == 'on')
                                                    <li class="nav-item mb-2">
                                                        <a class="btn btn-outline-primary btn-sm ml-1" data-toggle="tab" href="#mollie-payment" role="tab" aria-controls="mollie" aria-selected="false">{{ __('Mollie') }}</a>
                                                    </li>
                                                @endif

                                                @if(isset($company_payment_setting['is_skrill_enabled']) && $company_payment_setting['is_skrill_enabled'] == 'on')
                                                    <li class="nav-item mb-2">
                                                        <a class="btn btn-outline-primary btn-sm ml-1" data-toggle="tab" href="#skrill-payment" role="tab" aria-controls="skrill" aria-selected="false">{{ __('Skrill') }}</a>
                                                    </li>
                                                @endif

                                                @if(isset($company_payment_setting['is_coingate_enabled']) && $company_payment_setting['is_coingate_enabled'] == 'on')
                                                    <li class="nav-item mb-2">
                                                        <a class="btn btn-outline-primary btn-sm ml-1" data-toggle="tab" href="#coingate-payment" role="tab" aria-controls="coingate" aria-selected="false">{{ __('Coingate') }}</a>
                                                    </li>
                                                @endif

                                                @if(isset($company_payment_setting['is_paymentwall_enabled']) && $company_payment_setting['is_paymentwall_enabled'] == 'on')
                                                    <li class="nav-item mb-2">
                                                        <a class="btn btn-outline-primary btn-sm ml-1" data-toggle="tab" href="#paymentwall-payment" role="tab" aria-controls="paymentwall" aria-selected="false">{{ __('PaymentWall') }}</a>
                                                    </li>
                                                @endif

                                            </ul>
                                        @endif
                                        <div class="tab-content">
                                            @if(!empty($company_payment_setting) && ($company_payment_setting['is_stripe_enabled'] == 'on' && !empty($company_payment_setting['stripe_key']) && !empty($company_payment_setting['stripe_secret'])))
                                                <div class="tab-pane fade active show" id="stripe-payment" role="tabpanel" aria-labelledby="stripe-payment">
                                                    <form method="post" action="{{ route('customer.invoice.payment',$invoice->id) }}" class="require-validation" id="payment-form">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-sm-8">
                                                                <div class="custom-radio">
                                                                    <label class="font-16 font-weight-bold">{{__('Credit / Debit Card')}}</label>
                                                                </div>
                                                                <p class="mb-0 pt-1 text-sm">{{__('Safe money transfer using your bank account. We support Mastercard, Visa, Discover and American express.')}}</p>
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="card-name-on">{{__('Name on card')}}</label>
                                                                    <input type="text" name="name" id="card-name-on" class="form-control required" placeholder="{{\Auth::user()->name}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div id="card-element">

                                                                </div>
                                                                <div id="card-errors" role="alert"></div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <br>
                                                                <label for="amount">{{ __('Amount') }}</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-prepend"><span class="input-group-text">{{ App\Models\Utility::getValByName('site_currency') }}</span></span>
                                                                    <input class="form-control" required="required" min="0" name="amount" type="number" value="{{$invoice->getDue()}}" min="0" step="0.01" max="{{$invoice->getDue()}}" id="amount">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="invalid-feedback" style="display: none;">
                                                                    <div class='alert-danger alert'>{{__('Please correct the errors and try again.')}}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <button class="btn btn-sm btn-primary rounded-pill" type="submit">{{ __('Make Payment') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            @endif

                                            @if(!empty($company_payment_setting) &&  ($company_payment_setting['is_paypal_enabled'] == 'on' && !empty($company_payment_setting['paypal_client_id']) && !empty($company_payment_setting['paypal_secret_key'])))
                                                <div class="tab-pane fade " id="paypal-payment" role="tabpanel" aria-labelledby="paypal-payment">
                                                    <form class="w3-container w3-display-middle w3-card-4 " method="POST" id="payment-form" action="{{ route('customer.pay.with.paypal',$invoice->id) }}">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label for="amount">{{ __('Amount') }}</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-prepend"><span class="input-group-text">{{ App\Models\Utility::getValByName('site_currency') }}</span></span>
                                                                    <input class="form-control" required="required" min="0" name="amount" type="number" value="{{$invoice->getDue()}}" min="0" step="0.01" max="{{$invoice->getDue()}}" id="amount">
                                                                    @error('amount')
                                                                    <span class="invalid-amount" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <button class="btn btn-sm btn-primary rounded-pill" name="submit" type="submit">{{ __('Make Payment') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            @endif

                                            @if(isset($company_payment_setting['is_paystack_enabled']) && $company_payment_setting['is_paystack_enabled'] == 'on' && !empty($company_payment_setting['paystack_public_key']) && !empty($company_payment_setting['paystack_secret_key']))
                                                <div class="tab-pane fade " id="paystack-payment" role="tabpanel" aria-labelledby="paypal-payment">
                                                    <form class="w3-container w3-display-middle w3-card-4" method="POST" id="paystack-payment-form" action="{{ route('customer.invoice.pay.with.paystack') }}">
                                                        @csrf
                                                        <input type="hidden" name="invoice_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)}}">

                                                        <div class="form-group col-md-12">
                                                            <label for="amount">{{ __('Amount') }}</label>
                                                            <div class="input-group">
                                                                <span class="input-group-prepend"><span class="input-group-text">{{App\Models\Utility::getValByName('site_currency') }}</span></span>
                                                                <input class="form-control" required="required" min="0" name="amount" type="number" value="{{$invoice->getDue()}}" min="0" step="0.01" max="{{$invoice->getDue()}}" id="amount">

                                                            </div>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <input class="btn btn-sm btn-primary rounded-pill" id="pay_with_paystack" type="button" value="{{ __('Make Payment') }}">
                                                        </div>

                                                    </form>
                                                </div>
                                            @endif

                                            @if(isset($company_payment_setting['is_flutterwave_enabled']) && $company_payment_setting['is_flutterwave_enabled'] == 'on' && !empty($company_payment_setting['paystack_public_key']) && !empty($company_payment_setting['paystack_secret_key']))
                                                <div class="tab-pane fade " id="flutterwave-payment" role="tabpanel" aria-labelledby="paypal-payment">
                                                    <form role="form" action="{{ route('customer.invoice.pay.with.flaterwave') }}" method="post" class="require-validation" id="flaterwave-payment-form">
                                                        @csrf
                                                        <input type="hidden" name="invoice_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)}}">

                                                        <div class="form-group col-md-12">
                                                            <label for="amount">{{ __('Amount') }}</label>
                                                            <div class="input-group">
                                                                <span class="input-group-prepend"><span class="input-group-text">{{ App\Models\Utility::getValByName('site_currency') }}</span></span>
                                                                <input class="form-control" required="required" min="0" name="amount" type="number" value="{{$invoice->getDue()}}" min="0" step="0.01" max="{{$invoice->getDue()}}" id="amount">

                                                            </div>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <input class="btn btn-sm btn-primary rounded-pill" id="pay_with_flaterwave" type="button" value="{{ __('Make Payment') }}">
                                                        </div>

                                                    </form>
                                                </div>
                                            @endif

                                            @if(isset($company_payment_setting['is_razorpay_enabled']) && $company_payment_setting['is_razorpay_enabled'] == 'on')
                                                <div class="tab-pane fade " id="razorpay-payment" role="tabpanel" aria-labelledby="paypal-payment">
                                                    <form role="form" action="{{ route('customer.invoice.pay.with.razorpay') }}" method="post" class="require-validation" id="razorpay-payment-form">
                                                        @csrf
                                                        <input type="hidden" name="invoice_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)}}">

                                                        <div class="form-group col-md-12">
                                                            <label for="amount">{{ __('Amount') }}</label>
                                                            <div class="input-group">
                                                                <span class="input-group-prepend"><span class="input-group-text">{{ App\Models\Utility::getValByName('site_currency') }}</span></span>
                                                                <input class="form-control" required="required" min="0" name="amount" type="number" value="{{$invoice->getDue()}}" min="0" step="0.01" max="{{$invoice->getDue()}}" id="amount">

                                                            </div>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <input class="btn btn-sm btn-primary rounded-pill" id="pay_with_razorpay" type="button" value="{{ __('Make Payment') }}">
                                                        </div>

                                                    </form>
                                                </div>
                                            @endif

                                            @if(isset($company_payment_setting['is_mercado_enabled']) && $company_payment_setting['is_mercado_enabled'] == 'on')
                                                <div class="tab-pane fade " id="mercado-payment" role="tabpanel" aria-labelledby="mercado-payment">
                                                    <form role="form" action="{{ route('customer.invoice.pay.with.mercado') }}" method="post" class="require-validation" id="mercado-payment-form">
                                                        @csrf
                                                        <input type="hidden" name="invoice_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)}}">

                                                        <div class="form-group col-md-12">
                                                            <label for="amount">{{ __('Amount') }}</label>
                                                            <div class="input-group">
                                                                <span class="input-group-prepend"><span class="input-group-text">{{ App\Models\Utility::getValByName('site_currency') }}</span></span>
                                                                <input class="form-control" required="required" min="0" name="amount" type="number" value="{{$invoice->getDue()}}" min="0" step="0.01" max="{{$invoice->getDue()}}" id="amount">

                                                            </div>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <input type="submit" id="pay_with_mercado" value="{{__('Make Payment')}}" class="btn btn-sm btn-primary rounded-pill">
                                                        </div>

                                                    </form>
                                                </div>
                                            @endif

                                            @if(isset($company_payment_setting['is_paytm_enabled']) && $company_payment_setting['is_paytm_enabled'] == 'on')
                                                <div class="tab-pane fade" id="paytm-payment" role="tabpanel" aria-labelledby="paytm-payment">
                                                    <form role="form" action="{{ route('customer.invoice.pay.with.paytm') }}" method="post" class="require-validation" id="paytm-payment-form">
                                                        @csrf
                                                        <input type="hidden" name="invoice_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)}}">

                                                        <div class="form-group col-md-12">
                                                            <label for="amount">{{ __('Amount') }}</label>
                                                            <div class="input-group">
                                                                <span class="input-group-prepend"><span class="input-group-text">{{ App\Models\Utility::getValByName('site_currency') }}</span></span>
                                                                <input class="form-control" required="required" min="0" name="amount" type="number" value="{{$invoice->getDue()}}" min="0" step="0.01" max="{{$invoice->getDue()}}" id="amount">

                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="flaterwave_coupon" class=" text-dark">{{__('Mobile Number')}}</label>
                                                                <input type="text" id="mobile" name="mobile" class="form-control mobile" data-from="mobile" placeholder="{{ __('Enter Mobile Number') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <input type="submit" id="pay_with_paytm" value="{{__('Make Payment')}}" class="btn btn-sm btn-primary rounded-pill">
                                                        </div>

                                                    </form>
                                                </div>
                                            @endif

                                            @if(isset($company_payment_setting['is_mollie_enabled']) && $company_payment_setting['is_mollie_enabled'] == 'on')
                                                <div class="tab-pane fade " id="mollie-payment" role="tabpanel" aria-labelledby="mollie-payment">
                                                    <form role="form" action="{{ route('customer.invoice.pay.with.mollie') }}" method="post" class="require-validation" id="mollie-payment-form">
                                                        @csrf
                                                        <input type="hidden" name="invoice_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)}}">

                                                        <div class="form-group col-md-12">
                                                            <label for="amount">{{ __('Amount') }}</label>
                                                            <div class="input-group">
                                                                <span class="input-group-prepend"><span class="input-group-text">{{ App\Models\Utility::getValByName('site_currency') }}</span></span>
                                                                <input class="form-control" required="required" min="0" name="amount" type="number" value="{{$invoice->getDue()}}" min="0" step="0.01" max="{{$invoice->getDue()}}" id="amount">

                                                            </div>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <input type="submit" id="pay_with_mollie" value="{{__('Make Payment')}}" class="btn btn-sm btn-primary rounded-pill">
                                                        </div>

                                                    </form>
                                                </div>
                                            @endif

                                            @if(isset($company_payment_setting['is_skrill_enabled']) && $company_payment_setting['is_skrill_enabled'] == 'on')
                                                <div class="tab-pane fade " id="skrill-payment" role="tabpanel" aria-labelledby="skrill-payment">
                                                    <form role="form" action="{{ route('customer.invoice.pay.with.skrill') }}" method="post" class="require-validation" id="skrill-payment-form">
                                                        @csrf
                                                        <input type="hidden" name="invoice_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)}}">

                                                        <div class="form-group col-md-12">
                                                            <label for="amount">{{ __('Amount') }}</label>
                                                            <div class="input-group">
                                                                <span class="input-group-prepend"><span class="input-group-text">{{ App\Models\Utility::getValByName('site_currency') }}</span></span>
                                                                <input class="form-control" required="required" min="0" name="amount" type="number" value="{{$invoice->getDue()}}" min="0" step="0.01" max="{{$invoice->getDue()}}" id="amount">

                                                            </div>
                                                        </div>
                                                        @php
                                                            $skrill_data = [
                                                                'transaction_id' => md5(date('Y-m-d') . strtotime('Y-m-d H:i:s') . 'user_id'),
                                                                'user_id' => 'user_id',
                                                                'amount' => 'amount',
                                                                'currency' => 'currency',
                                                            ];
                                                            session()->put('skrill_data', $skrill_data);

                                                        @endphp
                                                        <div class="form-group mt-3">
                                                            <input type="submit" id="pay_with_skrill" value="{{__('Make Payment')}}" class="btn btn-sm btn-primary rounded-pill">
                                                        </div>

                                                    </form>
                                                </div>
                                            @endif

                                            @if(isset($company_payment_setting['is_coingate_enabled']) && $company_payment_setting['is_coingate_enabled'] == 'on')
                                                <div class="tab-pane fade " id="coingate-payment" role="tabpanel" aria-labelledby="coingate-payment">
                                                    <form role="form" action="{{ route('customer.invoice.pay.with.coingate') }}" method="post" class="require-validation" id="coingate-payment-form">
                                                        @csrf
                                                        <input type="hidden" name="invoice_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)}}">

                                                        <div class="form-group col-md-12">
                                                            <label for="amount">{{ __('Amount') }}</label>
                                                            <div class="input-group">
                                                                <span class="input-group-prepend"><span class="input-group-text">{{ App\Models\Utility::getValByName('site_currency') }}</span></span>
                                                                <input class="form-control" required="required" min="0" name="amount" type="number" value="{{$invoice->getDue()}}" min="0" step="0.01" max="{{$invoice->getDue()}}" id="amount">

                                                            </div>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <input type="submit" id="pay_with_coingate" value="{{__('Make Payment')}}" class="btn btn-sm btn-primary rounded-pill">
                                                        </div>

                                                    </form>
                                                </div>
                                            @endif

                                            @if(!empty($company_payment_setting) && $company_payment_setting['is_paymentwall_enabled'] == 'on' && !empty($company_payment_setting['is_paymentwall_enabled']) && !empty($company_payment_setting['paymentwall_secret_key']))
                                                <div class="tab-pane " id="paymentwall_payment">
                                                    <div class="card">
                                                        <form class="w3-container w3-display-middle w3-card-4" method="POST" id="paymentwall-payment-form" action="{{ route('invoice.paymentwallpayment') }}">
                                                            @csrf
                                                            <input type="hidden" name="invoice_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)}}">

                                                            <div class="border p-3 mb-3 rounded">
                                                                <div class="row">
                                                                    <div class="col-md-10">
                                                                        <div class="form-group">
                                                                            <label for="paypal_coupon" class="form-label">{{__('Coupon')}}</label>
                                                                            <input type="text" id="paymentwall_coupon" name="coupon" class="form-control coupon" data-from="paymentwall" placeholder="{{ __('Enter Coupon Code') }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-auto my-auto">
                                                                        <a href="#" class="apply-btn apply-coupon" data-toggle="tooltip" data-title="{{__('Apply')}}"><i class="ti ti-save"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mt-3">
                                                                <div class="col-sm-12">
                                                                    <div class="text-sm-right">

                                                                        <input type="submit" id="pay_with_paymentwall" value="{{__('Pay Now')}}" class="btn-create badge-blue">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
    @endif
    @endauth
    @include('new_layouts.footer')
    <script src="https://js.stripe.com/v3/"  integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script>
    <script src="https://js.paystack.co/v1/inline.js"  integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script>
    <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"  integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"  integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"></script>
    <script type="text/javascript">
        @if($invoice->getDue() > 0  && !empty($company_payment_setting) &&  $company_payment_setting['is_stripe_enabled'] == 'on' && !empty($company_payment_setting['stripe_key']) && !empty($company_payment_setting['stripe_secret']))

        var stripe = Stripe('{{ $company_payment_setting['stripe_key'] }}');
        var elements = stripe.elements();

        // Custom styling can be passed to options when creating an Element.
        var style = {
            base: {
                // Add your base input styles here. For example:
                fontSize: '14px',
                color: '#32325d',
            },
        };

        // Create an instance of the card Element.
        var card = elements.create('card', {style: style});

        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');

        // Create a token or display an error when the form is submitted.
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            stripe.createToken(card).then(function (result) {
                if (result.error) {
                    $("#card-errors").html(result.error.message);
                    show_toastr('Error', result.error.message, 'error');
                } else {
                    // Send the token to your server.
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }

        @endif

        @if(isset($company_payment_setting['paystack_public_key']))
        $(document).on("click", "#pay_with_paystack", function () {
            $('#paystack-payment-form').ajaxForm(function (res) {
                var amount = res.total_price;
                if (res.flag == 1) {
                    var paystack_callback = "{{ url('/invoice/paystack') }}";

                    var handler = PaystackPop.setup({
                        key: '{{ $company_payment_setting['paystack_public_key']  }}',
                        email: res.email,
                        amount: res.total_price * 100,
                        currency: res.currency,
                        ref: 'pay_ref_id' + Math.floor((Math.random() * 1000000000) +
                            1
                        ), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                        metadata: {
                            custom_fields: [{
                                display_name: "Email",
                                variable_name: "email",
                                value: res.email,
                            }]
                        },

                        callback: function (response) {

                            window.location.href = paystack_callback + '/' + response.reference + '/' + '{{encrypt($invoice->id)}}' + '?amount=' + amount;
                        },
                        onClose: function () {
                            alert('window closed');
                        }
                    });
                    handler.openIframe();
                } else if (res.flag == 2) {
                    toastrs('Error', res.msg, 'msg');
                } else {
                    toastrs('Error', res.message, 'msg');
                }

            }).submit();
        });
        @endif

        @if(isset($company_payment_setting['flutterwave_public_key']))
        //    Flaterwave Payment
        $(document).on("click", "#pay_with_flaterwave", function () {
            $('#flaterwave-payment-form').ajaxForm(function (res) {

                if (res.flag == 1) {
                    var amount = res.total_price;
                    var API_publicKey = '{{ $company_payment_setting['flutterwave_public_key']  }}';
                    var nowTim = "{{ date('d-m-Y-h-i-a') }}";
                    var flutter_callback = "{{ url('/invoice/flaterwave') }}";
                    var x = getpaidSetup({
                        PBFPubKey: API_publicKey,
                        customer_email: '{{Auth::user()->email}}',
                        amount: res.total_price,
                        currency: '{{App\Models\Utility::getValByName('site_currency')}}',
                        txref: nowTim + '__' + Math.floor((Math.random() * 1000000000)) + 'fluttpay_online-' + '{{ date('Y-m-d') }}' + '?amount=' + amount,
                        meta: [{
                            metaname: "payment_id",
                            metavalue: "id"
                        }],
                        onclose: function () {
                        },
                        callback: function (response) {
                            var txref = response.tx.txRef;
                            if (
                                response.tx.chargeResponseCode == "00" ||
                                response.tx.chargeResponseCode == "0"
                            ) {
                                window.location.href = flutter_callback + '/' + txref + '/' + '{{\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)}}';
                            } else {
                                // redirect to a failure page.
                            }
                            x.close(); // use this to close the modal immediately after payment.
                        }
                    });
                } else if (res.flag == 2) {
                    toastrs('Error', res.msg, 'msg');
                } else {
                    toastrs('Error', data.message, 'msg');
                }

            }).submit();
        });
        @endif

        @if(isset($company_payment_setting['razorpay_public_key']))
        // Razorpay Payment
        $(document).on("click", "#pay_with_razorpay", function () {
            $('#razorpay-payment-form').ajaxForm(function (res) {
                if (res.flag == 1) {
                    var amount = res.total_price;
                    var razorPay_callback = '{{url('/invoice/razorpay')}}';
                    var totalAmount = res.total_price * 100;
                    var coupon_id = res.coupon;
                    var options = {
                        "key": "{{ $company_payment_setting['razorpay_public_key']  }}", // your Razorpay Key Id
                        "amount": totalAmount,
                        "name": 'Plan',
                        "currency": '{{App\Models\Utility::getValByName('site_currency')}}',
                        "description": "",
                        "handler": function (response) {
                            window.location.href = razorPay_callback + '/' + response.razorpay_payment_id + '/' + '{{\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)}}' + '?amount=' + amount;
                        },
                        "theme": {
                            "color": "#528FF0"
                        }
                    };
                    var rzp1 = new Razorpay(options);
                    rzp1.open();
                } else if (res.flag == 2) {
                    toastrs('Error', res.msg, 'msg');
                } else {
                    toastrs('Error', data.message, 'msg');
                }

            }).submit();
        });
        @endif


        $('.cp_link').on('click', function () {
            var value = $(this).attr('data-link');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(value).select();
            document.execCommand("copy");
            $temp.remove();
            show_toastr('Success', '{{__('Link Copy on Clipboard')}}', 'success')
        });
    </script>
    <script>
        $(document).on('click', '#shipping', function () {
            var url = $(this).data('url');
            var is_display = $("#shipping").is(":checked");
            $.ajax({
                url: url,
                type: 'get',
                data: {
                    'is_display': is_display,
                },
                success: function (data) {
                    // console.log(data);
                }
            });
        })
    </script>

