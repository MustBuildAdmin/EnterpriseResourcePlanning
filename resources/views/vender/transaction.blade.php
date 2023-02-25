@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{__('Transaction')}}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="row d-flex justify-content-end mt-2">
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                            {{ Form::open(array('route' => array('vender.transaction'),'method' => 'GET','id'=>'frm_submit')) }}
                            <div class="all-select-box">
                                <div class="btn-box">
                                    {{ Form::label('date', __('Date'),['class'=>'text-type']) }}
                                    {{ Form::text('date', isset($_GET['date'])?$_GET['date']:null, array('class' => 'form-control datepicker-range')) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="all-select-box">
                                <div class="btn-box">
                                    {{ Form::label('category', __('Category'),['class'=>'text-type']) }}
                                    {{ Form::select('category',  [''=>'All']+$category,isset($_GET['category'])?$_GET['category']:'', array('class' => 'form-control select2')) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-auto my-auto">
                            <a href="#" class="apply-btn" onclick="document.getElementById('frm_submit').submit(); return false;" data-toggle="tooltip" data-original-title="{{__('apply')}}">
                                <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                            </a>
                            <a href="{{route('vender.transaction')}}" class="reset-btn" data-toggle="tooltip" data-original-title="{{__('Reset')}}">
                                <span class="btn-inner--icon"><i class="ti ti-trash-restore-alt"></i></span>
                            </a>

                        </div>
                    </div>
                    {{ Form::close() }}
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 dataTable">
                            <thead>
                            <tr>
                                <th> {{__('Date')}}</th>
                                <th> {{__('Amount')}}</th>
                                <th> {{__('Account')}}</th>
                                <th> {{__('Type')}}</th>
                                <th> {{__('Category')}}</th>
                                <th> {{__('Description')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{  Auth::user()->dateFormat($transaction->date)}}</td>
                                    <td>{{  Auth::user()->priceFormat($transaction->amount)}}</td>
                                    <td>{{ !empty($transaction->bankAccount())? $transaction->bankAccount()->bank_name .' '.$transaction->bankAccount()->holder_name:''}}</td>
                                    <td>{{  $transaction->type}}</td>
                                    <td>{{  $transaction->category}}</td>
                                    <td>{{  $transaction->description}}</td>
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
