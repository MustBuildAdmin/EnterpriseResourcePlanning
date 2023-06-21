@if (!empty($sales) && count($sales) > 0)

    <div class="container">
        <div class="row align-items-center mb-4 invoice mt-2">
            <div class="col invoice-details">
                <h1 class="invoice-id h6">{{ $details['pos_id'] }}</h1>
                <div class="date"><b>{{ __('Date') }}: </b>{{ $details['date'] }}</div>
            </div>
            <div class="col d-flex justify-content-end">
                <div class="text-dark mb-0 mt-2"><b>{{ __('Warehouse Name') }}: </b>{!! $details['warehouse']['details'] !!}</div>
{{--                <span class="clearfix" style="clear: both; display: block;"></span>--}}
            </div>
        </div>
        <div class="row invoice mt-2">
            <div class="col contacts d-flex justify-content-between pb-4">
                <div class="invoice-to">
                    <div class="text-dark h6"><b>{{ __('Billed To :') }}</b></div>
                    {!! $details['customer']['details'] !!}
                </div>
                @if(!empty( $details['customer']['shippdetails']))
                <div class="invoice-to">
                    <div class="text-dark h6"><b>{{ __('Shipped To :') }}</div>
                    {!! $details['customer']['shippdetails'] !!}
                </div>
                @endif
                <div class="company-details">
                    <div class="text-dark h6"><b>{{ __('From:') }}</b></div>
                    {!! $details['user']['details'] !!}
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12">
                <div class="invoice-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-left">{{ __('Items') }}</th>
                                <th>{{ __('Quantity') }}</th>
                                <th class="text-right">{{ __('Price') }}</th>
                                <th class="text-right">{{ __('Tax') }}</th>
                                {{-- <th class="text-right">{{ __('Tax Amount') }}</th> --}}
                                <th class="text-right">{{ __('Total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales['data'] as $key => $value)
                                <tr>
                                    <td class="cart-summary-table text-left">
                                        {{ $value['name'] }}
                                    </td>
                                    <td class="cart-summary-table">
                                        {{ $value['quantity'] }}
                                    </td>
                                    <td class="text-right cart-summary-table">
                                        {{ $value['price'] }}
                                    </td>
                                    <td class="text-right cart-summary-table">
                                        {{ $value['tax'] }}
                                    </td>
                                    {{-- <td class="text-right cart-summary-table">
                                        {{ $value['tax_amount'] }}
                                    </td> --}}
                                    <td class="text-right cart-summary-table">
                                        {{ $value['subtotal'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                              @if($setting['indiangst']==1)
                                    @if($gstflag==1)
                                        <tr>
                                            <td class="text-left font-weight-bold">CGST</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            {{-- <td></td> --}}
                                            <td class="text-right font-weight-bold">{{ Auth::user()->priceFormat($value['tax_amount']/2)}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-left font-weight-bold">SGST</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            {{-- <td></td> --}}
                                            <td class="text-right font-weight-bold">{{ Auth::user()->priceFormat($value['tax_amount']/2) }}</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td class="text-left font-weight-bold">IGST</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            {{-- <td></td> --}}
                                            <td class="text-right font-weight-bold">{{ Auth::user()->priceFormat($value['tax_amount'] )}}</td>
                                        </tr>
                                    @endif
                                
                            @endif
                                        
                            <tr>
                                <td class="text-left font-weight-bold">{{ __('Total') }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                {{-- <td></td> --}}
                                <td class="text-right font-weight-bold">{{ $sales['total'] }}</td>
                            </tr>

                        </tfoot>
                    </table>
                </div>
                @if ($details['pay'] == 'show')
                    {{-- <button class="btn btn-primary btn-sm btn-done-payment text-right float-right mb-3 "
                        data-url="{{ route('sales.store') }}">{{ __('Done Payment') }}</button>  --}}
                        <a href="#" class="btn btn-success btn-done-payment rounded mb-3 float-right"
                        data-url="{{ route('pos.data.store') }}">{{ __('Cash Payment') }}</a>


                @endif
            </div>

    </div>

@endif
