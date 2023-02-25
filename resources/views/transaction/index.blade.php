@extends('layouts.admin')
@section('page-title')
    {{__('Transaction Summary')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Report')}}</li>
    <li class="breadcrumb-item">{{__('Transaction Summary')}}</li>
@endsection
@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
@endpush

@push('script-page')
    {{--    <script src="{{ asset('assets/js/plugins/simple-datatables.js') }}"></script>--}}
    <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
    <script src="{{ asset('js/datatable/jszip.min.js') }}"></script>
    <script src="{{ asset('js/datatable/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/datatable/vfs_fonts.js') }}"></script>
    {{--    <script src="{{ asset('js/datatable/dataTables.buttons.min.js') }}"></script>--}}
    {{--    <script src="{{ asset('js/datatable/buttons.html5.min.js') }}"></script>--}}
    {{--    <script type="text/javascript" src="{{ asset('js/datatable/buttons.print.min.js') }}"></script>--}}

    <script>
        var filename = $('#filename').val();

        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,
                filename: filename,
                image: {type: 'jpeg', quality: 1},
                html2canvas: {scale: 4, dpi: 72, letterRendering: true},
                jsPDF: {unit: 'in', format: 'A4'}
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
                        {{ Form::open(array('route' => array('transaction.index'),'method'=>'get','id'=>'transaction_report')) }}
                        <div class="row align-items-center justify-content-end">
                            <div class="col-xl-10">
                                <div class="row">

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{ Form::label('start_month', __('Start Month'),['class'=>'form-label'])}}
                                            {{Form::month('start_month',isset($_GET['start_month'])?$_GET['start_month']:date('Y-m'),array('class'=>'month-btn form-control'))}}
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{ Form::label('end_month', __('End Month'),['class'=>'form-label'])}}
                                            {{Form::month('end_month',isset($_GET['end_month'])?$_GET['end_month']:date('Y-m', strtotime("-5 month")),array('class'=>'month-btn form-control'))}}
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{ Form::label('account', __('Account'),['class'=>'form-label'])}}
                                            {{ Form::select('account', $account,isset($_GET['account'])?$_GET['account']:'', array('class' => 'form-control select')) }}
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{ Form::label('category', __('Category'),['class'=>'form-label'])}}
                                            {{ Form::select('category', $category,isset($_GET['category'])?$_GET['category']:'', array('class' => 'form-control select')) }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-auto mt-4">
                                <div class="row">
                                    <div class="col-auto">

                                        <a href="#" class="btn btn-sm btn-primary" onclick="document.getElementById('transaction_report').submit(); return false;" data-bs-toggle="tooltip" title="{{__('Apply')}}" data-original-title="{{__('apply')}}">
                                            <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                        </a>

                                        <a href="{{route('transaction.index')}}" class="btn btn-sm btn-danger " data-bs-toggle="tooltip"  title="{{ __('Reset') }}" data-original-title="{{__('Reset')}}">
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
        <div class="row">
            <div class="col">
                <input type="hidden" value="{{$filter['category'].' '.__('Category').' '.__('Transaction').' '.'Report of'.' '.$filter['startDateRange'].' to '.$filter['endDateRange']}}" id="filename">
                <div class="card p-4 mb-4">
                    <h6 class="mb-0">{{__('Report')}} :</h6>
                    <h7 class="text-sm mb-0">{{__('Transaction Summary')}}</h7>
                </div>
            </div>
            @if($filter['account']!= __('All'))
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h6 class="mb-0">{{__('Account')}} :</h6>
                        <h7 class="text-sm mb-0">{{$filter['account']}}</h7>
                    </div>
                </div>
            @endif
            @if($filter['category']!= __('All'))
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h6 class="mb-0">{{__('Category')}} :</h6>
                        <h7 class="text-sm mb-0">{{$filter['category']}}</h7>
                    </div>
                </div>
            @endif
            <div class="col">
                <div class="card p-4 mb-4">
                    <h6 class="mb-0">{{__('Duration')}} :</h6>
                    <h7 class="text-sm mb-0">{{$filter['startDateRange'].' to '.$filter['endDateRange']}}</h7>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach($accounts as $account)
                <div class="col-xl-3 col-md-6 col-lg-3">
                    <div class="card p-4 mb-4">
                        @if($account->holder_name =='Cash')
                            <h6 class="mb-0">{{$account->holder_name}}</h6>
                        @elseif(empty($account->holder_name))
                            <h6 class="mb-0">{{__('Stripe / Paypal')}}</h6>
                        @else
                            <h6 class="mb-0">{{$account->holder_name.' - '.$account->bank_name}}</h6>
                        @endif
                        <h7 class="text-sm mb-0">{{\Auth::user()->priceFormat($account->total)}}</h7>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th>{{__('Date')}}</th>
                                <th>{{__('Account')}}</th>
                                <th>{{__('Type')}}</th>
                                <th>{{__('Category')}}</th>
                                <th>{{__('Description')}}</th>
                                <th>{{__('Amount')}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ \Auth::user()->dateFormat($transaction->date)}}</td>
                                    <td>
                                        @if(!empty($transaction->bankAccount()) && $transaction->bankAccount()->holder_name=='Cash')
                                            {{$transaction->bankAccount()->holder_name}}
                                        @else
                                            {{!empty($transaction->bankAccount())?$transaction->bankAccount()->bank_name.' '.$transaction->bankAccount()->holder_name:'-'}}
                                        @endif
                                    </td>
                                    <td>{{  $transaction->type}}</td>
                                    <td>{{  $transaction->category}}</td>
                                    <td>{{  !empty($transaction->description)?$transaction->description:'-'}}</td>
                                    <td>{{\Auth::user()->priceFormat($transaction->amount)}}</td>
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
