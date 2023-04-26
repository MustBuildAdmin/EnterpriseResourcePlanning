@extends('layouts.admin')
@section('page-title')
    {{__('Journal Detail')}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('journal-entry.index')}}">{{__('Journal Entry')}}</a></li>
    <li class="breadcrumb-item">{{ Auth::user()->journalNumberFormat($journalEntry->journal_id) }}</li>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice">
                        <div class="invoice-print">
                            <div class="row invoice-title mt-2">
                                <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12">
                                    <h2>{{__('Journal')}}</h2>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12 text-end">
                                    <h3 class="invoice-number">{{ \AUth::user()->journalNumberFormat($journalEntry->journal_id) }}</h3>
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="font-style">
                                        <strong>{{__('To')}} :</strong><br>
                                        {{!empty($settings['company_name'])?$settings['company_name']:''}}<br>
                                        {{!empty($settings['company_telephone'])?$settings['company_telephone']:''}}<br>
                                        {{!empty($settings['company_address'])?$settings['company_address']:''}}<br>
                                        {{!empty($settings['company_city'])?$settings['company_city']:'' .', '}}  {{!empty($settings['company_state'])?$settings['company_state']:'' .', '}}  {{!empty($settings['company_country'])?$settings['company_country']:'' .'.'}}
                                    </small>
                                </div>
                                <div class="col-md-6 text-end">
                                    <small>
                                        <strong>{{__('Journal No')}} :</strong>
                                        {{\Auth::user()->journalNumberFormat($journalEntry->journal_id)}}
                                    </small><br>
                                    <small>
                                        <strong>{{__('Journal Ref')}} :</strong>
                                        {{$journalEntry->reference}}
                                    </small> <br>
                                    <small>
                                        <strong>{{__('Journal Date')}} :</strong>
                                        {{\Auth::user()->dateFormat($journalEntry->date)}}
                                    </small>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="font-weight-bold">{{__('Journal Account Summary')}}</div>
                                    <div class="table-responsive mt-2">
                                        <table class="table mb-0 ">
                                            <tr>
                                                <th data-width="40" class="text-dark">#</th>
                                                <th class="text-dark">{{__('Account')}}</th>
                                                <th class="text-dark" width="25%">{{__('Description')}}</th>
                                                <th class="text-dark">{{__('Debit')}}</th>
                                                <th class="text-dark">{{__('Credit')}}</th>
                                                <th class="text-dark text-end">{{__('Amount')}}</th>
                                            </tr>

                                            @foreach($accounts as $key =>$account)

                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{!empty($account->accounts)?$account->accounts->code.' - '.$account->accounts->name:''}}</td>
                                                    <td>{{!empty($account->description)?$account->description:'-'}}</td>
                                                    <td>{{\Auth::user()->priceFormat($account->debit)}}</td>
                                                    <td>{{\Auth::user()->priceFormat($account->credit)}}</td>
                                                    <td class="text-end">
                                                        @if($account->debit!=0)
                                                            {{\Auth::user()->priceFormat($account->debit)}}
                                                        @else
                                                            {{\Auth::user()->priceFormat($account->credit)}}
                                                        @endif
                                                    </td>
                                                </tr>

                                            @endforeach

                                            <tfoot>

                                            <tr>
                                                <td colspan="4"></td>
                                                <td class="text-end"><b>{{__('Total Credit')}}</b></td>
                                                <td class="text-end">{{\Auth::user()->priceFormat($journalEntry->totalCredit())}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"></td>
                                                <td class="text-end"><b>{{__('Total Debit')}}</b></td>
                                                <td class="text-end">{{\Auth::user()->priceFormat($journalEntry->totalDebit())}}</td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="font-weight-bold">
                                        {{__('Description')}} : <br>
                                    </div>
                                    <small>{{$journalEntry->description}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
