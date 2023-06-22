@extends('layouts.admin')
@section('page-title')
    {{__('Balance Sheet')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Balance Sheet')}}</li>
@endsection
@push('script-page')
    <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
    <script>
        var filename = $('#filename').val();

        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,
                filename: filename,
                image: {type: 'jpeg', quality: 1},
                html2canvas: {scale: 4, dpi: 72, letterRendering: true},
                jsPDF: {unit: 'in', format: 'A2'}
            };
            html2pdf().set(opt).from(element).save();
        }

    </script>
@endpush

@section('action-btn')
    <div class="float-end">


        <a href="#" class="btn btn-sm btn-primary" onclick="saveAsPDF()"data-bs-toggle="tooltip" title="{{__('Download')}}" data-original-title="{{__('Download')}}">
            <span class="btn-inner--icon"><i class="ti ti-download"></i></span>
        </a>

    </div>
@endsection


@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class=" mt-2 " id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(array('route' => array('report.balance.sheet'),'method' => 'GET','id'=>'report_bill_summary')) }}
                        <div class="row align-items-center justify-content-end">
                            <div class="col-xl-10">
                                <div class="row">

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                        </div>
                                    </div>



                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{ Form::label('start_date', __('Start Date'),['class'=>'form-label']) }}
                                            {{ Form::date('start_date',$filter['startDateRange'], array('class' => 'month-btn form-control')) }}
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{ Form::label('end_date', __('End Date'),['class'=>'form-label']) }}
                                            {{ Form::date('end_date',$filter['endDateRange'], array('class' => 'month-btn form-control')) }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="row">
                                    <div class="col-auto mt-4">

                                        <a href="#" class="btn btn-sm btn-primary" onclick="document.getElementById('report_bill_summary').submit(); return false;" data-bs-toggle="tooltip" title="{{__('Apply')}}" data-original-title="{{__('apply')}}">
                                            <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                        </a>

                                        <a href="{{route('report.balance.sheet')}}" class="btn btn-sm btn-danger " data-bs-toggle="tooltip"  title="{{ __('Reset') }}" data-original-title="{{__('Reset')}}">
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

    <div id="printableArea">
        <div class="row mt-2">
            <div class="col">
                <input type="hidden" value="{{__('Balance Sheet').' '.'Report of'.' '.$filter['startDateRange'].' to '.$filter['endDateRange']}}" id="filename">
                <div class="card p-4 mb-4">
                    <h6 class="mb-0">{{__('Report')}} :</h6>
                    <h7 class="text-sm mb-0">{{__('Balance Sheet')}}</h7>
                </div>
            </div>

            <div class="col">
                <div class="card p-4 mb-4">
                    <h6 class="mb-0">{{__('Duration')}} :</h6>
                    <h7 class="text-sm mb-0">{{$filter['startDateRange'].' to '.$filter['endDateRange']}}</h7>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach($chartAccounts as $type => $accounts)
                @php $totalNetAmount=0; @endphp

                @foreach($accounts as  $accountData)
                    @foreach($accountData['account'] as  $account)
                        @php $totalNetAmount+=$account['netAmount']; @endphp
                    @endforeach
                @endforeach
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h6 class="mb-0">{{__('Total'.' '.$type)}}</h6>
                        <h7 class="text-sm mb-0">
                            @if($totalNetAmount<0)
                                {{__('Dr').'. '.\Auth::user()->priceFormat(abs($totalNetAmount))}}
                            @elseif($totalNetAmount>0)
                                {{__('Cr').'. '.\Auth::user()->priceFormat($totalNetAmount)}}
                            @else
                                {{\Auth::user()->priceFormat(0)}}
                            @endif
                        </h7>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row mb-4">
            @foreach($chartAccounts as $type => $accounts)
                <div class="col-lg-12 mb-4">
                    <h5 class="text-muted">{{$type}}</h5>
                    <div class="row">
                        @foreach($accounts as $account)

                            <div class="col-lg-4 col-md-4 mb-4">
                                <div class="card">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th colspan="2" width="80%"><h6> {{$account['subType']}}</h6></th>
                                        </tr>
                                        <tr>
                                            <th width="80%"> {{__('Account')}}</th>
                                            <th> {{__('Amount')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody class="balance-sheet-body">
                                        @php $totalCredit=0;$totalDebit=0;@endphp
                                        @foreach($account['account'] as  $record)
                                            @php
                                                $totalCredit+=$record['totalCredit'];
                                                $totalDebit+=$record['totalDebit'];
                                            @endphp
                                            <tr>
                                                <td>{{$record['account_name']}}</td>
                                                <td>
                                                    @if($record['netAmount']<0)
                                                        {{__('Dr').'. '.\Auth::user()->priceFormat(abs($record['netAmount']))}}
                                                    @elseif($record['netAmount']>0)
                                                        {{__('Cr').'. '.\Auth::user()->priceFormat($record['netAmount'])}}
                                                    @else
                                                        {{\Auth::user()->priceFormat(0)}}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                        <thead>
                                        <tr>
                                            <th>{{__('Total').' '.$account['subType']}}</th>
                                            <th>
                                                @php $total= $totalCredit-$totalDebit; @endphp
                                                @if($total<0)
                                                    {{__('Dr').'. '.\Auth::user()->priceFormat(abs($total))}}
                                                @elseif($total>0)
                                                    {{__('Cr').'. '.\Auth::user()->priceFormat($total)}}
                                                @else
                                                    {{\Auth::user()->priceFormat(0)}}
                                                @endif
                                            </th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
