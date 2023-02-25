@extends('layouts.admin')
@php
    $dir = asset(Storage::url('uploads/plan'));
@endphp
@section('page-title')
    {{__('Manage Plan')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{__('Plan')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        @can('create plan')
            @if(isset($admin_payment_setting) && !empty($admin_payment_setting))
                @if($admin_payment_setting['is_stripe_enabled'] == 'on' || $admin_payment_setting['is_paypal_enabled'] == 'on' || $admin_payment_setting['is_paystack_enabled'] == 'on' || $admin_payment_setting['is_flutterwave_enabled'] == 'on'|| $admin_payment_setting['is_razorpay_enabled'] == 'on' || $admin_payment_setting['is_mercado_enabled'] == 'on'|| $admin_payment_setting['is_paytm_enabled'] == 'on'  || $admin_payment_setting['is_mollie_enabled'] == 'on'||
                $admin_payment_setting['is_skrill_enabled'] == 'on' || $admin_payment_setting['is_coingate_enabled'] == 'on')


                    <a href="#" data-size="lg" data-url="{{ route('plans.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create New Plan')}}" class="btn btn-sm btn-primary">
                        <i class="ti ti-plus"></i>
                    </a>
                @endif
            @endif
        @endcan
    </div>
@endsection
@section('content')
    <div class="row">
        @foreach($plans as $plan)
            <div class="plan_card">
                <div class="card price-card price-1 wow animate__fadeInUp" data-wow-delay="0.2s" style="
                   visibility: visible;
                   animation-delay: 0.2s;
                   animation-name: fadeInUp;
                   ">
                    <div class="card-body">
                        <span class="price-badge bg-primary">{{ $plan->name }}</span>
                        @if (\Auth::user()->type == 'company' && \Auth::user()->plan == $plan->id)
                            <div class="d-flex flex-row-reverse m-0 p-0">
                                 <span class=" align-items-right">
                                    <i class="f-10 lh-1 fas fa-circle text-success"></i>
                                    <span class="ms-2">{{ __('Active') }}</span>
                                </span>
                            </div>

                        @endif
                        <h1 class="mb-4 f-w-600 ">{{(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$')}}{{ number_format($plan->price) }}<small class="text-sm">/{{__('Month')}}</small></h1>
                        <p class="mb-0">
                            {{__('Duration : ').__(\App\Models\Plan::$arrDuration[$plan->duration])}}<br/>
                        </p>

                        <div class="row ">
                            <div class="col-6">
                                <ul class="list-unstyled my-5">
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i class="text-primary ti ti-circle-plus"></i></span>{{($plan->max_users==-1)?__('Unlimited'):$plan->max_users}} {{__('Users')}}</li>
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i class="text-primary ti ti-circle-plus"></i></span>{{($plan->max_customers==-1)?__('Unlimited'):$plan->max_customers}} {{__('Customers')}}</li>
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i class="text-primary ti ti-circle-plus"></i></span>{{($plan->max_venders==-1)?__('Unlimited'):$plan->max_venders}} {{__('Vendors')}}</li>
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i class="text-primary ti ti-circle-plus"></i></span>{{($plan->max_clients==-1)?__('Unlimited'):$plan->max_clients}} {{__('Clients')}}</li>
                                </ul>
                            </div>
                            <div class="col-6">
                                <ul class="list-unstyled my-5">
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i class="text-primary ti ti-circle-plus"></i></span>{{($plan->account==1)?__('Enable'):__('Disable')}} {{__('Account')}}</li>
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i class="text-primary ti ti-circle-plus"></i></span>{{($plan->crm==1)?__('Enable'):__('Disable')}} {{__('CRM')}}</li>
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i class="text-primary ti ti-circle-plus"></i></span>{{($plan->hrm==1)?__('Enable'):__('Disable')}} {{__('HRM')}}</li>
                                    <li class="white-sapce-nowrap"><span class="theme-avtar"><i class="text-primary ti ti-circle-plus"></i></span>{{($plan->project==1)?__('Enable'):__('Disable')}} {{__('Project')}}</li>
                                </ul>
                            </div>
                        </div>

                        @if(\Auth::user()->type =='super admin')
                            <div class="col-4">
                                <a title="{{__('Edit Plan')}}" href="#" class="btn btn-primary btn-icon m-1" data-url="{{ route('plans.edit',$plan->id) }}" data-ajax-popup="true" data-title="{{__('Edit Plan')}}" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                    <i class="ti ti-edit"></i>
                                </a>
                            </div>
                        @endif

                        @if(isset($admin_payment_setting) && !empty($admin_payment_setting))
                            @if($admin_payment_setting['is_stripe_enabled'] == 'on' || $admin_payment_setting['is_paypal_enabled'] == 'on' || $admin_payment_setting['is_paystack_enabled'] == 'on' || $admin_payment_setting['is_flutterwave_enabled'] == 'on'|| $admin_payment_setting['is_razorpay_enabled'] == 'on' || $admin_payment_setting['is_mercado_enabled'] == 'on'|| $admin_payment_setting['is_paytm_enabled'] == 'on'  || $admin_payment_setting['is_mollie_enabled'] == 'on'||
                            $admin_payment_setting['is_skrill_enabled'] == 'on' || $admin_payment_setting['is_coingate_enabled'] == 'on')
                                @if(\Auth::user()->type != 'super admin')

                                    @if($plan->id != \Auth::user()->plan)
                                        @if($plan->price > 0)
                                            <a href="{{route('stripe',\Illuminate\Support\Facades\Crypt::encrypt($plan->id))}}" class="btn btn-primary btn-icon m-1">{{__('Buy Plan')}}</a>
{{--                                        @else--}}
{{--                                            <a href="#" class="btn btn-primary btn-icon m-1">{{__('Free')}}</a>--}}
                                        @endif
                                    @endif
                                    @if($plan->id != 1 && $plan->id != \Auth::user()->plan)
                                        @if(\Auth::user()->requested_plan != $plan->id)
                                            <a href="{{ route('send.request',[\Illuminate\Support\Facades\Crypt::encrypt($plan->id)])}}" class="btn btn-primary btn-icon m-1" data-title="{{__('Send Request')}}" data-bs-toggle="tooltip" title="{{__('Send Request')}}">
                                                <span class="btn-inner--icon"><i class="ti ti-corner-up-right"></i></span>
                                            </a>
                                        @else
                                            <a href="{{ route('request.cancel',\Auth::user()->id) }}" class="btn btn-danger btn-icon m-1" data-title="{{__('`Cancle Request')}}" data-bs-toggle="tooltip" title="{{__('Cancle Request')}}">
                                                <span class="btn-inner--icon"><i class="ti ti-x"></i></span>
                                            </a>
                                        @endif
                                    @endif
                                @endif
                            @endif
                        @endif


                        @if(\Auth::user()->type =='company' && \Auth::user()->plan == $plan->id)
                            <p class="display-total-time text-dark mb-0">
                                {{__('Plan Expired : ') }} {{!empty(\Auth::user()->plan_expire_date) ? \Auth::user()->dateFormat(\Auth::user()->plan_expire_date):'unlimited'}}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
