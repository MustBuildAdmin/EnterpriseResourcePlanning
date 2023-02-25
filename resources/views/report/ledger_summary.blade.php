@extends('layouts.admin')
@section('page-title')
    {{__('Ledger Summary')}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Ledger Summary')}}</li>
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
        {{--        <a class="btn btn-sm btn-primary" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1" data-bs-toggle="tooltip" title="{{__('Filter')}}">--}}
        {{--            <i class="ti ti-filter"></i>--}}
        {{--        </a>--}}

        <a href="#" class="btn btn-sm btn-primary" onclick="saveAsPDF()"data-bs-toggle="tooltip" title="{{__('Download')}}" data-original-title="{{__('Download')}}">
            <span class="btn-inner--icon"><i class="ti ti-download"></i></span>
        </a>

    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="mt-2 " id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(array('route' => array('report.ledger'),'method' => 'GET','id'=>'report_ledger')) }}
                        <div class="row align-items-center justify-content-end">
                            <div class="col-xl-10">
                                <div class="row">

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

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{ Form::label('account', __('Account'),['class'=>'form-label']) }}
                                            {{ Form::select('account',$accounts,isset($_GET['account'])?$_GET['account']:'', array('class' => 'form-control select')) }}                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="row">
                                    <div class="col-auto mt-4">

                                        <a href="#" class="btn btn-sm btn-primary" onclick="document.getElementById('report_ledger').submit(); return false;" data-bs-toggle="tooltip" title="{{__('Apply')}}" data-original-title="{{__('apply')}}">
                                            <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                        </a>

                                        <a href="{{route('report.ledger')}}" class="btn btn-sm btn-danger " data-bs-toggle="tooltip"  title="{{ __('Reset') }}" data-original-title="{{__('Reset')}}">
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
                <input type="hidden" value="{{__('Ledger').' '.'Report of'.' '.$filter['startDateRange'].' to '.$filter['endDateRange']}}" id="filename">
                <div class="card p-4 mb-4">
                    <h6 class="mb-0">{{__('Report')}} :</h6>
                    <h7 class="text-sm mb-0">{{__('Ledger Summary')}}</h7>
                </div>
            </div>

            <div class="col">
                <div class="card p-4 mb-4">
                    <h6 class="mb-0">{{__('Duration')}} :</h6>
                    <h7 class="text-sm mb-0">{{$filter['startDateRange'].' to '.$filter['endDateRange']}}</h7>
                </div>
            </div>
        </div>
        @if(!empty($account))
            <div class="row mt-2">
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h6 class="mb-0">{{__('Account Name')}} :</h6>
                        <h7 class="text-sm mb-0">{{$account->name}}</h7>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-4 mb-4">
                        <h6 class="mb-0">{{__('Account Code')}} :</h6>
                        <h7 class="text-sm mb-0">{{$account->code}}</h7>
                    </div>
                </div>
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h6 class="mb-0">{{__('Total Debit')}} :</h6>
                        <h7 class="text-sm mb-0">{{\Auth::user()->priceFormat($filter['debit'])}}</h7>
                    </div>
                </div>
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h6 class="mb-0">{{__('Total Credit')}} :</h6>
                        <h7 class="text-sm mb-0">{{\Auth::user()->priceFormat($filter['credit'])}}</h7>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-4 mb-4">
                        <h6 class="mb-0">{{__('Balance')}} :</h6>
                        <h7 class="text-sm mb-0">{{($filter['balance']>0)?__('Cr').'. '.\Auth::user()->priceFormat(abs($filter['balance'])):__('Dr').'. '.\Auth::user()->priceFormat(abs($filter['balance']))}}</h7>
                    </div>
                </div>
            </div>
        @endif
        <div class="row mb-4">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th> #</th>
                                    <th> {{__('Transaction Date')}}</th>
                                    <th> {{__('Create At')}}</th>
                                    <th> {{__('Description')}}</th>
                                    <th> {{__('Debit')}}</th>
                                    <th> {{__('Credit')}}</th>
                                    <th> {{__('Balance')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $balance=0;$debit=0;$credit=0; @endphp
                                @foreach($journalItems as  $item)
                                    <tr>
                                        <td class="Id">
                                            <a href="{{ route('journal-entry.show',$item->journal) }}" class="btn btn-outline-primary">{{ AUth::user()->journalNumberFormat($item->journal_id) }}</a>
                                        </td>

                                        <td>{{\Auth::user()->dateFormat($item->transaction_date)}}</td>
                                        <td>{{\Auth::user()->dateFormat($item->created_at)}}</td>
                                        <td>{{!empty($item->description)?$item->description:'-'}}</td>
                                        <td>{{\Auth::user()->priceFormat($item->debit)}}</td>
                                        <td>{{\Auth::user()->priceFormat($item->credit)}}</td>
                                        <td>
                                            @if($item->debit>0)
                                                @php $debit+=$item->debit @endphp
                                            @else
                                                @php $credit+=$item->credit @endphp
                                            @endif

                                            @php $balance= $credit-$debit @endphp
                                            @if($balance>0)
                                                {{__('Cr').'. '.\Auth::user()->priceFormat($balance)}}

                                            @elseif($balance<0)
                                                {{__('Dr').'. '.\Auth::user()->priceFormat(abs($balance))}}
                                            @else
                                                {{\Auth::user()->priceFormat(0)}}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
