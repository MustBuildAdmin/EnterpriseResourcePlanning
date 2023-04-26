<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
@php
    $plan = $data['plan_id'];
    $plan_id = \Illuminate\Support\Facades\Crypt::decrypt($plan);
    $plan   = App\Models\Plan::find($plan_id);

@endphp

{{-- {{ dd( $admin_payment_setting) }} --}}
<script src="https://api.paymentwall.com/brick/build/brick-default.1.5.0.min.js"> </script>
<div id="payment-form-container"> </div>
<script>
var brick = new Brick({
  public_key: '{{ $admin_payment_setting['paymentwall_public_key'] }}', // please update it to Brick live key before launch your project
  amount: '{{$plan->price }}' ,
  currency: '{{App\Models\Utility::getValByName('site_currency')}}',
  container: 'payment-form-container',
  action: '{{route("plan.pay.with.paymentwall",[$data["plan_id"],$data["coupon"]])}}',
  form: {
    merchant: 'Paymentwall',
    product: '{{$plan->name}}',
    pay_button: 'Pay',
    show_zip: true, // show zip code
    show_cardholder: true // show card holder name
  }
});
brick.showPaymentForm(function(data) {
    if(data.flag == 1){
      window.location.href ='{{route("error.plan.show",1)}}';
    }else{
      window.location.href ='{{route("error.plan.show",2)}}';
    }
  }, function(errors) {
    if(errors.flag == 1){
      window.location.href ='{{route("error.plan.show",1)}}';
    }else{
      window.location.href ='{{route("error.plan.show",2)}}';
    }
  });
</script>
