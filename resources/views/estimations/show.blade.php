@extends('layouts.admin')
@section('page-title')
    {{ __("Estimation Detail") }}
@endsection

@section('action-button')
    <div class="all-button-box row d-flex justify-content-end">
        @can('Edit Estimation')
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                <a href="#" data-url="{{ URL::to('estimations/'.$estimation->id.'/edit') }}" data-ajax-popup="true" data-title="{{__('Edit Estimation')}}" class="btn btn-xs btn-white btn-icon-only width-auto"><i class="ti ti-pencil text-white"></i> {{__('Edit')}}</a>
            </div>
        @endcan
        @can('View Estimation')
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                <a href="{{ route('get.estimation',$estimation->id) }}" class="btn btn-xs btn-white btn-icon-only bg-warning width-auto" title="{{__('Print Estimation')}}" target="_blanks"><span><i class="fa fa-print"></i> {{__('Print')}}</span></a>
            </div>
        @endcan
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="invoice-title">{{ Auth::user()->estimateNumberFormat($estimation->estimation_id) }}</div>
        <div class="invoice-detail pb-2">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="address-detail">
                        <strong>{{__('From')}} :</strong>
                        {{$settings['company_name']}}<br>
                        {{$settings['company_address']}}<br>
                        {{$settings['company_city']}}
                        @if(isset($settings['company_city']) && !empty($settings['company_city'])), @endif
                        {{$settings['company_state']}}
                        @if(isset($settings['company_zipcode']) && !empty($settings['company_zipcode']))-@endif {{$settings['company_zipcode']}}<br>
                        {{$settings['company_country']}}
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    @if($client)
                        <div class="address-detail text-end float-right">
                            <strong>{{__('To')}} :</strong>
                            {{$client->name}} <br>
                            {{$client->email}}
                        </div>
                    @endif
                </div>
            </div>
            <div class="status-section">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-6">
                        <div class="text-status"><strong>{{__('Status')}} :</strong>
                            @if($estimation->status == 0)
                                <span class="badge badge-pill badge-primary">{{ __(\App\Models\Estimation::$statues[$estimation->status]) }}</span>
                            @elseif($estimation->status == 1)
                                <span class="badge badge-pill badge-danger">{{ __(\App\Models\Estimation::$statues[$estimation->status]) }}</span>
                            @elseif($estimation->status == 2)
                                <span class="badge badge-pill badge-warning">{{ __(\App\Models\Estimation::$statues[$estimation->status]) }}</span>
                            @elseif($estimation->status == 3)
                                <span class="badge badge-pill badge-success">{{ __(\App\Models\Estimation::$statues[$estimation->status]) }}</span>
                            @elseif($estimation->status == 4)
                                <span class="badge badge-pill badge-info">{{ __(\App\Models\Estimation::$statues[$estimation->status]) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-9">
                        <div class="text-status text-end">{{__('Issue Date')}}:<strong>{{ Auth::user()->dateFormat($estimation->issue_date) }}</strong></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="justify-content-between align-items-center d-flex">
                        <h4 class="h4 font-weight-400 float-left">{{__('Order Summary')}}</h4>
                        @can('Estimation Add Product')
                            <a href="#" class="btn btn-sm btn-white float-right add-small" data-url="{{ route('estimations.products.add',$estimation->id) }}" data-ajax-popup="true" data-title="{{__('Add Product')}}">
                                <i class="ti ti-plus"></i> {{__('Add Product')}}
                            </a>
                        @endcan
                    </div>
                    <div class="card">
                        <div class="table-responsive order-table">
                            <table class="table align-items-center mb-0">
                                <thead>
                                <tr>
                                    <th>{{__('Action')}}</th>
                                    <th>{{__('#')}}</th>
                                    <th>{{__('Item')}}</th>
                                    <th>{{__('Price')}}</th>
                                    <th>{{__('Quantity')}}</th>
                                    <th class="text-end">{{__('Totals')}}</th>
                                </tr>
                                </thead>
                                <tbody class="list">
                                @php
                                    $i=0;
                                @endphp
                                @foreach($estimation->getProducts as $product)
                                    <tr>
                                        <td class="Action">
                                        <span>
                                            @can('Estimation Edit Product')
                                                <a href="#" class="edit-icon" data-url="{{ route('estimations.products.edit',[$estimation->id,$product->pivot->id]) }}" data-ajax-popup="true" data-title="{{__('Edit Estimation Product')}}" data-toggle="tooltip" data-original-title="{{__('Edit')}}"><i class="ti ti-pencil text-white"></i></a>
                                            @endcan
                                            @can('Estimation Delete Product')
                                                <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$product->pivot->id}}').submit();"><i class="ti ti-trash"></i></a>
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['estimations.products.delete', $estimation->id,$product->pivot->id],'id'=>'delete-form-'.$product->pivot->id]) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        </span>
                                        </td>
                                        <td class="invoice-order">{{++$i}}</td>
                                        <td class="small-order">{{$product->name}}</td>
                                        <td class="small-order">{{Auth::user()->priceFormat($product->pivot->price)}}</td>
                                        <td class="small-order">{{$product->pivot->quantity}}</td>
                                        @php
                                            $price = $product->pivot->price * $product->pivot->quantity;
                                        @endphp
                                        <td class="invoice-order text-end">{{Auth::user()->priceFormat($price)}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row text-end">
                <div class="col-md-3">
                    @php
                        $subTotal = $estimation->getSubTotal();
                    @endphp
                    <div class="text-status"><strong>{{__('Subtotal')}} :</strong> {{Auth::user()->priceFormat($subTotal)}}</div>
                </div>
                <div class="col-md-3">
                    <div class="text-status"><strong>{{__('Discount')}} :</strong> {{Auth::user()->priceFormat($estimation->discount)}}</div>
                </div>
                <div class="col-md-3">
                    @php
                        $tax = $estimation->getTax();
                    @endphp
                    <div class="text-status"><strong>{{$estimation->tax->name}} ({{$estimation->tax->rate}} %) :</strong> {{Auth::user()->priceFormat($tax)}}</div>
                </div>
                <div class="col-md-3">
                    <div class="text-status"><strong>{{__('Total')}} :</strong> {{Auth::user()->priceFormat($subTotal-$estimation->discount+$tax)}}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
