@extends('layouts.admin')
@section('page-title')
    {{__('Dashboard')}}
@endsection
{{--{{dd($billChartData['data'])}}--}}
@push('script-page')
    <script>
        var options = {
            series: [
                {
                    name: "{{__('Unpaid')}}",
                    data: {!! json_encode($billChartData['data']['unpaid']) !!}
                }, {
                    name: "{{__('Paid')}}",
                    data: {!! json_encode($billChartData['data']['paid']) !!}
                }, {
                    name: "{{__('Partial Paid')}}",
                    data: {!! json_encode($billChartData['data']['partial']) !!}
                }, {
                    name: "{{__('Due')}}",
                    data: {!! json_encode($billChartData['data']['due']) !!}
                },

            ],
            chart: {
                height: 350,
                type: 'line',
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
            colors: ['#FF5630', '#36B37E', '#00B8D9', '#FFAB00'],
            dataLabels: {
                enabled: true,
            },
            stroke: {
                curve: 'smooth'
            },
            title: {
                text: '',
                align: 'left'
            },
            grid: {
                borderColor: '#e7e7e7',
                row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
            },
            markers: {
                size: 1
            },
            xaxis: {
                categories: {!! json_encode($billChartData['month']) !!},
                title: {
                    text: 'Month'
                }
            },
            yaxis: {
                title: {
                    text: '{{__('Amount')}}'
                },

            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                floating: true,
                offsetY: -25,
                offsetX: -5
            }
        };
        var chart = new ApexCharts(document.querySelector("#chart-sales"), options);
        chart.render();
    </script>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <div class="list-group list-group-flush">
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="flex-fill text-limit">
                                            <h6 class="progress-text mb-1 text-sm d-block text-limit">   {{  number_format($billChartData['progressData']['unpaidPr'], Utility::getValByName('decimal_number'), '.', '').'%'}}</h6>
                                            <div class="progress progress-xs mb-0">
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{$billChartData['progressData']['unpaidPr']}}%;" aria-valuenow="{{$billChartData['progressData']['unpaidPr']}}%" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="d-flex justify-content-between text-xs text-muted text-end mt-1">
                                                <div>
                                                    <span class="font-weight-bold text-danger">{{__('Unpaid')}}</span>
                                                </div>
                                                <div>
                                                    {{$billChartData['progressData']['totalBill'] .'/'.$billChartData['progressData']['totalUnpaidBill']}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col">
                            <div class="list-group list-group-flush">
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="flex-fill text-limit">
                                            <h6 class="progress-text mb-1 text-sm d-block text-limit"> {{number_format($billChartData['progressData']['paidPr'], Utility::getValByName('decimal_number'), '.', '') .' %'}}</h6>
                                            <div class="progress progress-xs mb-0">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: {{$billChartData['progressData']['paidPr']}}%;" aria-valuenow="{{$billChartData['progressData']['paidPr']}}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="d-flex justify-content-between text-xs text-muted text-end mt-1">
                                                <div>
                                                    <span class="font-weight-bold text-success">{{__('Paid')}}</span>
                                                </div>
                                                <div>
                                                    {{$billChartData['progressData']['totalBill'] .'/'.$billChartData['progressData']['totalPaidBill']}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col">
                            <div class="list-group list-group-flush">
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="flex-fill text-limit">
                                            <h6 class="progress-text mb-1 text-sm d-block text-limit"> {{  number_format($billChartData['progressData']['partialPr'], Utility::getValByName('decimal_number'), '.', '').'%'}}</h6>
                                            <div class="progress progress-xs mb-0">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: {{$billChartData['progressData']['partialPr']}}%;" aria-valuenow="{{$billChartData['progressData']['partialPr']}}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="d-flex justify-content-between text-xs text-muted text-end mt-1">
                                                <div>
                                                    <span class="font-weight-bold text-info">{{__('Partial Paid')}}</span>
                                                </div>
                                                <div>
                                                    {{$billChartData['progressData']['totalBill'] .'/'.$billChartData['progressData']['totalPartialBill']}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col">
                            <div class="list-group list-group-flush">
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="flex-fill text-limit">
                                            <h6 class="progress-text mb-1 text-sm d-block text-limit"> {{  number_format($billChartData['progressData']['duePr'], Utility::getValByName('decimal_number'), '.', '').'%'}}</h6>
                                            <div class="progress progress-xs mb-0">
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{$billChartData['progressData']['duePr']}}%;" aria-valuenow="{{$billChartData['progressData']['duePr']}}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="d-flex justify-content-between text-xs text-muted text-end mt-1">
                                                <div>
                                                    <span class="font-weight-bold text-warning">{{__('Due')}}</span>
                                                </div>
                                                <div>
                                                    {{$billChartData['progressData']['totalBill'] .'/'.$billChartData['progressData']['totalDueBill']}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6>{{__('Current year').' - '.date('Y')}}</h6>
                    <div class="scrollbar-inner">
                        <div id="chart-sales" height="300"></div>
                    </div>
                </div>
            </div>
        </div>
@endsection


