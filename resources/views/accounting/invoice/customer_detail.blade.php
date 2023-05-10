@if(!empty($customer))
    <div class="row">
        <div class="col-md-5">
            <h6>{{__('Bill to')}}</h6>
            <div class="bill-to">
                <small>
                    <span>{{$customer['billing_name']}}</span><br>
                    <span>{{$customer['billing_phone']}}</span><br>
                    <span>{{$customer['billing_address']}}</span><br>
                    <span>{{$customer['billing_zip']}}</span><br>
                    <span>{{$customer['billing_city'].','.$state->name.','. $country->name.'.'}}</span>
                </small>
            </div>
        </div>
        <div class="col-md-5">
            <h6>{{__('Ship to')}}</h6>
            <div class="bill-to">
                <small>
                    <span>{{$customer['shipping_name']}}</span><br>
                    <span>{{$customer['shipping_phone']}}</span><br>
                    <span>{{$customer['shipping_address']}}</span><br>
                    <span>{{$customer['shipping_zip']}}</span><br>
                    <span>{{$customer['shipping_city']. ' , '.$shipstate->name.' , '.$shipcountry->name.'.'}}</span>
                </small>
            </div>
        </div>
        <div class="col-md-2">
            <a href="#" id="remove" class="text-sm">{{__(' Remove')}}</a>
        </div>
    </div>
@endif
