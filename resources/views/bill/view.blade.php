@extends('layouts.admin')
@section('page-title')
    {{__('Bill Detail')}}
@endsection
@push('script-page')
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
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('bill.index')}}">{{__('Bill')}}</a></li>
    <li class="breadcrumb-item">{{ Auth::user()->billNumberFormat($bill->bill_id) }}</li>
@endsection

@section('content')

    @can('send bill')
        @if($bill->status!=4)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                    <div class="card-body">
                        <div class="row timeline-wrapper">
                            <div class="col-md-6 col-lg-4 col-xl-4">
                                <div class="timeline-icons"><span class="timeline-dots"></span>
                                    <i class="ti ti-plus text-primary"></i>
                                </div>
                                <h6 class="text-primary my-3">{{__('Create Bill')}}</h6>
                                <p class="text-muted text-sm mb-3"><i class="ti ti-clock mr-2"></i>{{__('Created on ')}}{{\Auth::user()->dateFormat($bill->bill_date)}}</p>
                                @can('edit bill')
                                    <a href="{{ route('bill.edit',\Crypt::encrypt($bill->id)) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-original-title="{{__('Edit')}}"><i class="ti ti-pencil mr-2"></i>{{__('Edit')}}</a>

                                @endcan
                            </div>
                            <div class="col-md-6 col-lg-4 col-xl-4">
                                <div class="timeline-icons"><span class="timeline-dots"></span>
                                    <i class="ti ti-mail text-warning"></i>
                                </div>
                                <h6 class="text-warning my-3">{{__('Send Bill')}}</h6>
                                <p class="text-muted text-sm mb-3">
                                    @if($bill->status!=0)
                                        <i class="ti ti-clock mr-2"></i>{{__('Sent on')}} {{\Auth::user()->dateFormat($bill->send_date)}}
                                    @else
                                        @can('send bill')
                                            <small>{{__('Status')}} : {{__('Not Sent')}}</small>
                                        @endcan
                                    @endif
                                </p>

                                @if($bill->status==0)
                                    @can('send bill')
                                            <a href="{{ route('bill.sent',$bill->id) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-original-title="{{__('Mark Sent')}}"><i class="ti ti-send mr-2"></i>{{__('Send')}}</a>
                                    @endcan
                                @endif
                            </div>
                            <div class="col-md-6 col-lg-4 col-xl-4">
                                <div class="timeline-icons"><span class="timeline-dots"></span>
                                    <i class="ti ti-report-money text-info"></i>
                                </div>
                                <h6 class="text-info my-3">{{__('Get Paid')}}</h6>
                                <p class="text-muted text-sm mb-3">{{__('Status')}} : {{__('Awaiting payment')}} </p>
                                @if($bill->status!=0)
                                    @can('create payment bill')
                                        <a href="#" data-url="{{ route('bill.payment',$bill->id) }}" data-ajax-popup="true" data-title="{{__('Add Payment')}}" class="btn btn-sm btn-info" data-original-title="{{__('Add Payment')}}"><i class="ti ti-report-money mr-2"></i>{{__('Add Payment')}}</a> <br>
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
        @if($bill->status!=0)
            <div class="row justify-content-between align-items-center mb-3">
                <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
                    @if(!empty($billPayment))
                        <div class="all-button-box mx-2">
                            <a href="#" data-url="{{ route('bill.debit.note',$bill->id) }}" data-ajax-popup="true" data-title="{{__('Add Debit Note')}}" class="btn btn-sm btn-primary">
                                {{__('Add Debit Note')}}
                            </a>
                        </div>

                    @endif
                    <div class="all-button-box mx-2">
                        <a href="{{ route('bill.resent',$bill->id) }}" class="btn btn-sm btn-primary">
                            {{__('Resend Bill')}}
                        </a>
                    </div>
                    <div class="all-button-box">
                        <a href="{{ route('bill.pdf', Crypt::encrypt($bill->id))}}" target="_blank" class="btn btn-sm btn-primary">
                            {{__('Download')}}
                        </a>
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
                                    <h4>{{__('Bill')}}</h4>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12 text-end">
                                    <h4 class="invoice-number">{{ Auth::user()->billNumberFormat($bill->bill_id) }}</h4>
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
                                                {{\Auth::user()->dateFormat($bill->bill_date)}}<br><br>
                                            </small>
                                        </div>
                                        <div>
                                            <small>
                                                <strong>{{__('Due Date')}} :</strong><br>
                                                {{\Auth::user()->dateFormat($bill->due_date)}}<br><br>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                @if(!empty($vendor->billing_name))
                                    <div class="col">
                                        <small class="font-style">
                                            <strong>{{__('Billed To')}} :</strong><br>
                                            {{!empty($vendor->billing_name)?$vendor->billing_name:''}}<br>
                                            {{!empty($vendor->billing_phone)?$vendor->billing_phone:''}}<br>
                                            {{!empty($vendor->billing_address)?$vendor->billing_address:''}}<br>
                                            {{!empty($vendor->billing_zip)?$vendor->billing_zip:''}}<br>
                                            {{!empty($vendor->billing_city)?$vendor->billing_city:'' .', '}} {{!empty($vendor->billing_state)?\App\Models\Utility::getstate_detailsonly_name($vendor->billing_country,$vendor->billing_state):'',', '}} {{!empty($vendor->billing_country)?\App\Models\Utility::getcountry_detailsonly_name($vendor->billing_country):''}}<br>
                                            <strong>{{__('Tax Number ')}} : </strong>{{!empty($vendor->tax_number)?$vendor->tax_number:''}}
                                        </small>
                                    </div>
                                @endif
                                @if(App\Models\Utility::getValByName('shipping_display')=='on')
                                    <div class="col">
                                        <small>
                                            <strong>{{__('Shipped To')}} :</strong><br>
                                            {{!empty($vendor->shipping_name)?$vendor->shipping_name:''}}<br>
                                            {{!empty($vendor->shipping_phone)?$vendor->shipping_phone:''}}<br>
                                            {{!empty($vendor->shipping_address)?$vendor->shipping_address:''}}<br>
                                            {{!empty($vendor->shipping_zip)?$vendor->shipping_zip:''}}<br>
                                            {{!empty($vendor->shipping_city)?$vendor->shipping_city:'' . ', '}} {{!empty($vendor->shipping_state)?\App\Models\Utility::getstate_detailsonly_name($vendor->billing_country,$vendor->shipping_state):'' .', '}},{{!empty($vendor->shipping_country)?\App\Models\Utility::getcountry_detailsonly_name($vendor->shipping_country):''}}<br>
                                            <strong>{{__('Tax Number ')}} : </strong>{{!empty($vendor->tax_number)?$vendor->tax_number:''}}

                                        </small>
                                    </div>
                                @endif

                                    <div class="col">
                                        <div class="float-end mt-3">

                                        {!! DNS2D::getBarcodeHTML(route('bill.link.copy',\Illuminate\Support\Facades\Crypt::encrypt($bill->id)), "QRCODE",2,2) !!}
                                        </div>
                                    </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <small>
                                        <strong>{{__('Status')}} :</strong><br>
                                        @if($bill->status == 0)
                                            <span class="badge bg-primary p-2 px-3 rounded">{{ __(\App\Models\Bill::$statues[$bill->status]) }}</span>
                                        @elseif($bill->status == 1)
                                            <span class="badge bg-warning p-2 px-3 rounded">{{ __(\App\Models\Bill::$statues[$bill->status]) }}</span>
                                        @elseif($bill->status == 2)
                                            <span class="badge bg-danger p-2 px-3 rounded">{{ __(\App\Models\Bill::$statues[$bill->status]) }}</span>
                                        @elseif($bill->status == 3)
                                            <span class="badge bg-info p-2 px-3 rounded">{{ __(\App\Models\Bill::$statues[$bill->status]) }}</span>
                                        @elseif($bill->status == 4)
                                            <span class="badge bg-success p-2 px-3 rounded">{{ __(\App\Models\Bill::$statues[$bill->status]) }}</span>
                                        @endif
                                    </small>
                                </div>
                                <div class="col">
                                    @php  
                                        $statecode=\App\Models\Utility::statecode();
                                    @endphp
                                    <small>
                                        <strong>{{__('Place Of Supply')}} :</strong><br>
                                            <span>{{!empty($vendor->shipping_state)?\App\Models\Utility::getstate_detailsonly_name($vendor->billing_country,$vendor->shipping_state):'' .', '}} 
                                            @isset($statecode[$vendor->shipping_state])
                                                ({{$statecode[$vendor->shipping_state]}})
                                            @endisset
                                            </span>
                                    </small>
                                </div>



                                @if(!empty($customFields) && count($bill->customField)>0)
                                    @foreach($customFields as $field)
                                        <div class="col text-md-end">
                                            <small>
                                                <strong>{{$field->name}} :</strong><br>
                                                {{!empty($bill->customField)?$bill->customField[$field->id]:'-'}}
                                                <br><br>
                                            </small>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="font-bold mb-2">{{__('Product Summary')}}</div>
                                    <small class="mb-2">{{__('All items here cannot be deleted.')}}</small>
                                    <div class="table-responsive mt-3">
                                        <table class="table ">
                                            <tr>
                                                <th class="text-dark" data-width="40">#</th>
                                                <th class="text-dark">{{__('Product')}}</th>
                                                <th class="text-dark">{{__('Quantity')}}</th>
                                                <th class="text-dark">{{__('HSC/SAC')}}</th>
                                                <th class="text-dark">{{__('Rate')}}</th>
                                                {{-- <th class="text-dark">{{__('Tax')}}</th> --}}
                                                <th class="text-dark">{{__('Discount')}}</th>
                                                @if($setting['indiangst']==1)
                                                    @if($gstflag==1)
                                                        <th class="text-dark">CGST</th>
                                                        @if(in_array($vendor->shipping_state, \App\Models\Utility::union_state()))
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
                                                <th></th>
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
                                                <td class="text-end">{{\Auth::user()->priceFormat($bill->getSubTotal())}}</td>
                                            </tr>

                                                <tr>
                                                    <td colspan={{$col}}></td>
                                                    <td class="text-end"><b>{{__('Discount')}}</b></td>
                                                    <td class="text-end">{{\Auth::user()->priceFormat($bill->getTotalDiscount())}}</td>
                                                </tr>

                                            @if(!empty($taxesData))
                                                @foreach($taxesData as $taxName => $taxPrice)
                                                    {{-- <tr>
                                                        <td colspan="6"></td>
                                                        <td class="text-end"><b>{{$taxName}}</b></td>
                                                        <td class="text-end">{{ \Auth::user()->priceFormat($taxPrice) }}</td>
                                                    </tr> --}}
                                                    @if($setting['indiangst']==1)
                                                    @if($gstflag==1)
                                                        <tr>
                                                            <td colspan={{$col}}></td>
                                                            <td class="text-end"><b>CGST</b></td>
                                                            <td class="text-end">{{ \Auth::user()->priceFormat($taxPrice/2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan={{$col}}></td>
                                                            @if(in_array($vendor->shipping_state, \App\Models\Utility::union_state()))
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
                                                <td class="blue-text text-end">{{\Auth::user()->priceFormat($bill->getTotal())}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan={{$col}}></td>
                                                <td class="text-end"><b>{{__('Paid')}}</b></td>
                                                <td class="text-end">{{\Auth::user()->priceFormat(($bill->getTotal()-$bill->getDue())-($bill->billTotalDebitNote()))}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan={{$col}}></td>
                                                <td class="text-end"><b>{{__('Debit Note')}}</b></td>
                                                <td class="text-end">{{\Auth::user()->priceFormat(($bill->billTotalDebitNote()))}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan={{$col}}></td>
                                                <td class="text-end"><b>{{__('Due')}}</b></td>
                                                <td class="text-end">{{\Auth::user()->priceFormat($bill->getDue())}}</td>
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
                    <h5 class=" d-inline-block mb-5">{{__('Payment Summary')}}</h5>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="text-dark">{{__('Payment Receipt')}}</th>
                                <th class="text-dark">{{__('Date')}}</th>
                                <th class="text-dark">{{__('Amount')}}</th>
                                <th class="text-dark">{{__('Account')}}</th>
                                <th class="text-dark">{{__('Reference')}}</th>
                                <th class="text-dark">{{__('Description')}}</th>
                                @can('delete payment bill')
                                    <th class="text-dark">{{__('Action')}}</th>
                                @endcan
                            </tr>
                            </thead>
                            @forelse($bill->payments as $key =>$payment)
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
                                    <td>{{!empty($payment->bankAccount)?$payment->bankAccount->bank_name.' '.$payment->bankAccount->holder_name:''}}</td>
                                    <td>{{$payment->reference}}</td>
                                    <td>{{$payment->description}}</td>
                                    <td class="text-dark">
                                        @can('delete bill product')
                                            <div class="action-btn bg-danger ms-2">
                                                {!! Form::open(['method' => 'post', 'route' => ['bill.payment.destroy',$bill->id,$payment->id],'id'=>'delete-form-'.$payment->id]) !!}
                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip"  title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$payment->id}}').submit();">
                                                        <i class="ti ti-trash text-white text-white text-white"></i>
                                                    </a>
                                                {!! Form::close() !!}
                                            </div>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-dark"><p>{{__('No Data Found')}}</p></td>
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
                    <h5 class="d-inline-block mb-5">{{__('Debit Note Summary')}}</h5>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="text-dark">{{__('Date')}}</th>
                                <th class="text-dark">{{__('Amount')}}</th>
                                <th class="text-dark">{{__('Description')}}</th>
                                @if(Gate::check('edit debit note') || Gate::check('delete debit note'))
                                    <th class="text-dark">{{__('Action')}}</th>
                                @endif
                            </tr>
                            </thead>
                            @forelse($bill->debitNote as $key =>$debitNote)
                                <tr>
                                    <td>{{\Auth::user()->dateFormat($debitNote->date)}}</td>
                                    <td>{{\Auth::user()->priceFormat($debitNote->amount)}}</td>
                                    <td>{{$debitNote->description}}</td>
                                    <td>
                                        @can('edit debit note')
                                            <a data-url="{{ route('bill.edit.debit.note',[$debitNote->bill,$debitNote->id]) }}" data-ajax-popup="true" data-title="{{__('Add Debit Note')}}" href="#" class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                                <i class="ti ti-pencil text-white"></i>
                                            </a>
                                        @endcan
                                        @can('delete debit note')
                                                <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => array('bill.delete.debit.note', $debitNote->bill,$debitNote->id),'id'=>'delete-form-'.$debitNote->id]) !!}
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip"  title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$debitNote->id}}').submit();">
                                                            <i class="ti ti-trash text-white text-white"></i>
                                                        </a>
                                                    {!! Form::close() !!}
                                                </div>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-dark"><p>{{__('No Data Found')}}</p></td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
