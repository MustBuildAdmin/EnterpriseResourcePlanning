@if(!empty($vender))
    <div class="row">
        <div class="col-md-5">
            <h6>{{__('Bill to')}}</h6>
            <div class="bill-to">
                <small>
                    <span>{{$vender['billing_name']}}</span><br>
                    <span>{{$vender['billing_phone']}}</span><br>
                    <span>{{$vender['billing_address']}}</span><br>
                    <span>{{$vender['billing_zip']}}</span><br>
                    <span>{{$vender['billing_country'] . ' , '.$vender['billing_city'].' , '.$vender['billing_state'].'.'}}</span>
                </small>
            </div>
        </div>
        <div class="col-md-5">
            <h6>{{__('Ship to')}}</h6>
            <div class="bill-to">
                <small>
                    <span>{{$vender['shipping_name']}}</span><br>
                    <span>{{$vender['shipping_phone']}}</span><br>
                    <span>{{$vender['shipping_address']}}</span><br>
                    <span>{{$vender['shipping_zip']}}</span><br>
                    <span>{{$vender['shipping_country'] . ' , '.$vender['shipping_state'].' , '.$vender['shipping_city'].'.'}}</span>
                </small>
            </div>
        </div>
        <div class="col-md-2">
            <a href="#" id="remove" class="text-sm">{{__(' Remove')}}</a>
        </div>
    </div>
@endif
