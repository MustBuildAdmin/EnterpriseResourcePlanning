@extends('layouts.admin')
@section('page-title')
    {{__('Expenses')}}
@endsection

@section('action-button')
    <h5 class="h4 d-inline-block font-weight-400 mb-0 text-white">({{$total}})</h5>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table align-items-center">
                        <thead>
                        <tr>
                            <th scope="col">{{__('Attachment')}}</th>
                            <th scope="col">{{__('Project')}}</th>
                            <th scope="col">{{__('Name')}}</th>
                            <th scope="col">{{__('Date')}}</th>
                            <th scope="col">{{__('Amount')}}</th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        @if(count($expenses) > 0)
                            @foreach($expenses as $expense)
                                <tr>
                                    <th scope="row">
                                        @if(!empty($expense->attachment))
                                            <a href="{{ asset(Storage::url($expense->attachment)) }}" class="btn btn-sm btn-secondary btn-icon rounded-pill" download>
                                                <span class="btn-inner--icon"><i class="ti ti-download"></i></span>
                                            </a>
                                        @else
                                            <a href="#" class="btn btn-sm btn-secondary btn-icon rounded-pill">
                                                <span class="btn-inner--icon"><i class="ti ti-times-circle"></i></span>
                                            </a>
                                        @endif
                                    </th>
                                    <td>
                                        <span class="h6 text-sm font-weight-bold mb-0">{{ $expense->project->name }} <span class="badge badge-xs badge-{{ (\Auth::user()->checkProject($expense->project->id) == 'Owner') ? 'success' : 'warning'  }}">{{ \Auth::user()->checkProject($expense->project->id) }}</span></span>
                                    </td>
                                    <td>
                                        <span class="h6 text-sm font-weight-bold mb-0">{{ $expense->name }}</span>
                                        @if(!empty($expense->task))<span class="d-block text-sm text-muted">{{ $expense->task->name }}</span>@endif
                                    </td>
                                    <td>{{ (!empty($expense->date)) ? Utility::getDateFormated($expense->date) : '-' }}</td>
                                    <td>{{ Utility::projectCurrencyFormat($expense->project->id,$expense->amount) }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <th scope="col" colspan="5"><h6 class="text-center">{{__('No Expense Found.')}}</h6></th>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
