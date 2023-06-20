@extends('layouts.admin')
@section('page-title')
    {{__('POS Summary')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('POS Summary')}}</li>
@endsection
@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
@endpush

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
    <div id="printableArea">

    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{__('POS ID')}}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Customer') }}</th>
                                <th>{{ __('Warehouse') }}</th>
                                <th>{{ __('Amount') }}</th>

                            </tr>
                            </thead>

                            <tbody>

                            @forelse ($posPayments as $posPayment)
                                <tr>

                                    <td>
                                        <a href="#" class="btn btn-outline-primary">{{ AUth::user()->posNumberFormat($posPayment->pos_id) }}</a>
                                    </td>
                                    <td>{{ Auth::user()->dateFormat($posPayment->created_at)}}</td>
                                    @if($posPayment->customer_id == 0)
                                        <td class="">{{__('Walk-in Customer')}}</td>
                                    @else
                                        <td>{{ !empty($posPayment->customer) ? $posPayment->customer->name : '' }} </td>

                                    @endif
                                    <td>{{ !empty($posPayment->warehouse) ? $posPayment->warehouse->name : '' }} </td>
                                    <td>{{!empty($posPayment->posPayment)? $posPayment->posPayment->amount:0}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-dark"><p>{{__('No Data Found')}}</p></td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
