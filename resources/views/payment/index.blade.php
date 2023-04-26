@extends('layouts.admin')
@section('page-title')
    {{__('Manage Payments')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Payment')}}</li>
@endsection

@section('action-btn')
    <div class="float-end">

        @can('create payment')
            <a href="#" data-url="{{ route('payment.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip"  data-size="lg" data-title="{{__('Create New Payment')}}"  title="{{__('Create')}}" class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        @endcan
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class=" mt-2 " id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(array('route' => array('payment.index'),'method' => 'GET','id'=>'payment_form')) }}
                        <div class="row align-items-center justify-content-end">
                            <div class="col-xl-10">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{ Form::label('date', __('Date'),['class'=>'form-label']) }}
                                            {{ Form::date('date', isset($_GET['date'])?$_GET['date']:'', array('class' => 'form-control month-btn ','id'=>'pc-daterangepicker-1')) }}
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{ Form::label('account', __('Account'),['class'=>'form-label']) }}
                                            {{ Form::select('account',$account,isset($_GET['account'])?$_GET['account']:'', array('class' => 'form-control select' ,'id'=>'choices-multiple')) }}
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{ Form::label('vender', __('Vendor'),['class'=>'form-label']) }}
                                            {{ Form::select('vender',$vender,isset($_GET['vender'])?$_GET['vender']:'', array('class' => 'form-control select','id'=>'choices-multiple1')) }}
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{ Form::label('category', __('Category'),['class'=>'form-label']) }}
                                            {{ Form::select('category',$category,isset($_GET['category'])?$_GET['category']:'', array('class' => 'form-control select','id'=>'choices-multiple2')) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto mt-4">
                                <div class="row">
                                    <div clas="col-auto">
                                        <a href="#" class="btn btn-sm btn-primary" onclick="document.getElementById('payment_form').submit(); return false;" data-toggle="tooltip" title="{{__('Apply')}}" data-original-title="{{__('apply')}}">
                                            <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                        </a>

                                        <a href="{{ route('productservice.index') }}" class="btn btn-sm btn-danger" data-bs-toggle="tooltip"
                                           title="{{ __('Reset') }}">
                                            <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th>{{__('Date')}}</th>
                                <th>{{__('Amount')}}</th>
                                <th>{{__('Account')}}</th>
                                <th>{{__('Vendor')}}</th>
                                <th>{{__('Category')}}</th>
                                <th>{{__('Reference')}}</th>
                                <th>{{__('Description')}}</th>
                                <th>{{__('Payment Receipt')}}</th>
                                @if(Gate::check('edit payment') || Gate::check('delete payment'))
                                    <th>{{__('Action')}}</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $paymentpath=\App\Models\Utility::get_file('uploads/payment');
                            @endphp

                            @foreach ($payments as $payment)
                                <tr class="font-style">
                                    <td>{{  Auth::user()->dateFormat($payment->date)}}</td>
                                    <td>{{  Auth::user()->priceFormat($payment->amount)}}</td>
                                    <td>{{ !empty($payment->bankAccount)?$payment->bankAccount->bank_name.' '.$payment->bankAccount->holder_name:''}}</td>
                                    <td>{{  !empty($payment->vender)?$payment->vender->name:'-'}}</td>
                                    <td>{{  !empty($payment->category)?$payment->category->name:'-'}}</td>
                                    <td>{{  !empty($payment->reference)?$payment->reference:'-'}}</td>
                                    <td>{{  !empty($payment->description)?$payment->description:'-'}}</td>
{{--                                    <td>--}}

{{--                                        @if(!empty($payment->add_receipt))--}}
{{--                                            <div class="action-btn bg-primary ms-2">--}}
{{--                                                <a href="{{asset(Storage::url('uploads/payment')).'/'.$payment->add_receipt}}" download="" class="mx-3 btn btn-sm align-items-center" target="_blank">--}}

{{--                                                    <i class="ti ti-download text-white" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Download') }}"></i></a>--}}
{{--                                            </div>--}}
{{--                                        @else--}}
{{--                                            ---}}
{{--                                        @endif--}}
{{--                                        <div class="action-btn bg-secondary ms-2">--}}
{{--                                            <a class="mx-3 btn btn-sm align-items-center" href="{{asset(Storage::url('uploads/payment')).'/'.$payment->add_receipt}}" target="_blank"  >--}}
{{--                                                <i class="ti ti-crosshair text-white" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Preview') }}"></i>--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}

                                    <td>
                                        @if(!empty($payment->add_receipt))
                                            <a  class="action-btn bg-primary ms-2 btn btn-sm align-items-center" href="{{ $paymentpath . '/' . $payment->add_receipt }}" download="">
                                                <i class="ti ti-download text-white"></i>
                                            </a>
                                            <a href="{{ $paymentpath . '/' . $payment->add_receipt }}"  class="action-btn bg-secondary ms-2 mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="{{__('Download')}}" target="_blank"><span class="btn-inner--icon"><i class="ti ti-crosshair text-white" ></i></span></a>
                                        @else
                                            -
                                        @endif

                                    </td>



                                    @if(Gate::check('edit revenue') || Gate::check('delete revenue'))
                                        <td class="action text-end">
                                            @can('edit payment')
                                                <div class="action-btn bg-primary ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm align-items-center" data-url="{{ route('payment.edit',$payment->id) }}" data-ajax-popup="true" data-title="{{__('Edit Payment')}}" data-size="lg" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                            @endcan
                                            @can('delete payment')
                                                <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['payment.destroy', $payment->id],'id'=>'delete-form-'.$payment->id]) !!}
                                                    <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" data-original-title="{{__('Delete')}}" title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$payment->id}}').submit();">
                                                        <i class="ti ti-trash text-white"></i>
                                                    </a>
                                                    {!! Form::close() !!}
                                                </div>
                                            @endcan
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
