@extends('layouts.admin')
@section('page-title')
    {{__('Invoice Summary')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Invoice Summary')}}</li>
@endsection

@push('theme-script')
    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
@endpush

@push('script-page')
    <script>
        (function () {
            var chartBarOptions = {
                series: [
                    {
                        name: '{{ __("Invoice") }}',
                        data:  {!! json_encode($invoiceTotal) !!},

                    },
                ],

                chart: {
                    height: 300,
                    type: 'bar',
                    // type: 'line',
                    dropShadow: {
                        enabled: true,
                        color: '#000',
                        top: 18,
                        left: 7,
                        blur: 10,
                        opacity: 0.2
                    },
                    toolbar: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                title: {
                    text: '',
                    align: 'left'
                },
                xaxis: {
                    categories: {!! json_encode($monthList) !!},
                    title: {
                        text: '{{ __("Months") }}'
                    }
                },
                colors: ['#6fd944', '#6fd944'],


                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: false,
                },
                // markers: {
                //     size: 4,
                //     colors: ['#ffa21d', '#FF3A6E'],
                //     opacity: 0.9,
                //     strokeWidth: 2,
                //     hover: {
                //         size: 7,
                //     }
                // },
                yaxis: {
                    title: {
                        text: '{{ __("Invoice") }}'
                    },

                }

            };
            var arChart = new ApexCharts(document.querySelector("#chart-sales"), chartBarOptions);
            arChart.render();
        })();

    </script>
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

        $(document).ready(function () {
            var filename = $('#filename').val();
            $('#report-dataTable').DataTable({
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: filename
                    },
                    {
                        extend: 'pdf',
                        title: filename
                    }, {
                        extend: 'csv',
                        title: filename
                    }
                ]
            });
        });
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
                    {{ Form::open(array('route' => array('report.invoice.summary'),'method' => 'GET','id'=>'report_invoice_summary')) }}
                        <div class="row align-items-center justify-content-end">
                            <div class="col-xl-10">
                                <div class="row">

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                        {{ Form::label('start_month', __('Start Month'),['class'=>'form-label']) }}

                                        {{ Form::month('start_month',isset($_GET['start_month'])?$_GET['start_month']:'', array('class' => 'month-btn form-control')) }}

                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                        {{ Form::label('end_month', __('End Month'),['class'=>'form-label']) }}

                                        {{ Form::month('end_month',isset($_GET['end_month'])?$_GET['end_month']:'', array('class' => 'month-btn form-control')) }}

                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                        {{ Form::label('customer', __('Customer'),['class'=>'form-label']) }}

                                        {{ Form::select('customer',$customer,isset($_GET['customer'])?$_GET['customer']:'', array('class' => 'form-control select')) }}

                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                        {{ Form::label('status', __('Status'),['class'=>'form-label']) }}

                                        {{ Form::select('status', [''=>'Select Status']+$status,isset($_GET['status'])?$_GET['status']:'', array('class' => 'form-control select')) }}
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="row">
                                    <div class="col-auto mt-4">

                                        <a href="#" class="btn btn-sm btn-primary" onclick="document.getElementById('report_invoice_summary').submit(); return false;" data-bs-toggle="tooltip" title="{{__('Apply')}}" data-original-title="{{__('apply')}}">
                                            <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                        </a>

                                        <a href="{{route('report.invoice.summary')}}" class="btn btn-sm btn-danger " data-bs-toggle="tooltip"  title="{{ __('Reset') }}" data-original-title="{{__('Reset')}}">
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
        <div class="row mt-3">
            <div class="col">
                <input type="hidden" value="{{$filter['status'].' '.__('Invoice').' '.'Report of'.' '.$filter['startDateRange'].' to '.$filter['endDateRange'].' '.__('of').' '.$filter['customer']}}" id="filename">
                <div class="card p-4 mb-4">
                    <h7 class="report-text gray-text mb-0">{{__('Report')}} :</h7>
                    <h6 class="report-text mb-0">{{__('Invoice Summary')}}</h6>
                </div>
            </div>
            @if($filter['customer']!= __('All'))
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h7 class="report-text gray-text mb-0">{{__('Customer')}} :</h7>
                        <h6 class="report-text mb-0">{{$filter['customer'] }}</h6>
                    </div>
                </div>
            @endif
            @if($filter['status']!= __('All'))
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h7 class="report-text gray-text mb-0">{{__('Status')}} :</h7>
                        <h6 class="report-text mb-0">{{$filter['status'] }}</h6>
                    </div>
                </div>
            @endif
            <div class="col">
                <div class="card p-4 mb-4">
                    <h7 class="report-text gray-text mb-0">{{__('Duration')}} :</h7>
                    <h6 class="report-text mb-0">{{$filter['startDateRange'].' to '.$filter['endDateRange']}}</h6>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4 col-md-6 col-lg-4">
                <div class="card p-4 mb-4">
                    <h7 class="report-text gray-text mb-0">{{__('Total Invoice')}}</h7>
                    <h6 class="report-text mb-0">{{Auth::user()->priceFormat($totalInvoice)}}</h6>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-lg-4">
                <div class="card p-4 mb-4">
                    <h7 class="report-text gray-text mb-0">{{__('Total Paid')}}</h7>
                    <h6 class="report-text mb-0">{{Auth::user()->priceFormat($totalPaidInvoice)}}</h6>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-lg-4">
                <div class="card p-4 mb-4">
                    <h7 class="report-text gray-text mb-0">{{__('Total Due')}}</h7>
                    <h6 class="report-text mb-0">{{Auth::user()->priceFormat($totalDueInvoice)}}</h6>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12" id="invoice-container">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between w-100">

                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="profile-tab3" data-bs-toggle="pill" href="#summary" role="tab" aria-controls="pills-summary" aria-selected="true">{{__('Summary')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab4" data-bs-toggle="pill" href="#invoices" role="tab" aria-controls="pills-invoice" aria-selected="false">{{__('Invoices')}}</a>
                                </li>

                            </ul>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="tab-content" id="myTabContent2">
                                    <div class="tab-pane fade fade" id="invoices" role="tabpanel" aria-labelledby="profile-tab3">
                                        <table class="table table-flush" id="report-dataTable">
                                            <thead>
                                            <tr>
                                                <th> {{__('Invoice')}}</th>
                                                <th> {{__('Date')}}</th>
                                                <th> {{__('Customer')}}</th>
                                                <th> {{__('Category')}}</th>
                                                <th> {{__('Status')}}</th>
                                                <th> {{__('	Paid Amount')}}</th>
                                                <th> {{__('Due Amount')}}</th>
                                                <th> {{__('Payment Date')}}</th>
                                                <th> {{__('Amount')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($invoices as $invoice)
                                                <tr>
                                                    <td class="Id">
{{--                                                        <a href="{{ route('invoice.show', \Crypt::encrypt($invoice->id)) }}">{{ Auth::user()->invoiceNumberFormat($invoice->invoice_id) }}</a>--}}
                                                        <a href="{{ route('invoice.show',\Crypt::encrypt($invoice->id)) }}" class="btn btn-outline-primary">{{ Auth::user()->invoiceNumberFormat($invoice->id) }}</a>                                                    </td>


                                                    </td>
                                                    <td>{{\Auth::user()->dateFormat($invoice->send_date)}}</td>
                                                    <td>{{!empty($invoice->customer)? $invoice->customer->name:'-' }} </td>
                                                    <td>{{!empty($invoice->category)?$invoice->category->name:'-'}}</td>
                                                    <td>
                                                        @if($invoice->status == 0)
                                                            <span class="badge bg-primary p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</span>
                                                        @elseif($invoice->status == 1)
                                                            <span class="badge bg-warning p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</span>
                                                        @elseif($invoice->status == 2)
                                                            <span class="badge bg-danger p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</span>
                                                        @elseif($invoice->status == 3)
                                                            <span class="badge bg-info p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</span>
                                                        @elseif($invoice->status == 4)
                                                            <span class="badge bg-success p-2 px-3 rounded">{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</span>
                                                        @endif
                                                    </td>
                                                    <td> {{\Auth::user()->priceFormat($invoice->getTotal()-$invoice->getDue())}}</td>
                                                    <td> {{\Auth::user()->priceFormat($invoice->getDue())}}</td>
                                                    <td>{{!empty($invoice->lastPayments)?\Auth::user()->dateFormat($invoice->lastPayments->date):''}}</td>
                                                    <td> {{\Auth::user()->priceFormat($invoice->getTotal())}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="tab-pane fade fade show active" id="summary" role="tabpanel" aria-labelledby="profile-tab3">
                                        <div class="col-sm-12">
                                            <div class="scrollbar-inner">
                                                <div id="chart-sales" data-color="primary" data-type="bar" data-height="300" ></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
