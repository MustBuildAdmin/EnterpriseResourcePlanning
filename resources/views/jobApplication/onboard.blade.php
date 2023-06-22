@extends('layouts.admin')
@section('page-title')
    {{__('Manage Job On-boarding')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Job On-boarding')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">
    @can('create interview schedule')

            <a href="#" data-url="{{ route('job.on.board.create',0)}}"  data-bs-toggle="tooltip" title="{{__('Create')}}" data-ajax-popup="true" class="btn btn-sm btn-primary" data-title="{{__('Create New Job OnBoard')}}">
            <i class="ti ti-plus"></i>
        </a>
        @endcan
    </div>

@endsection

@section('content')
    <div class="row">

        <div class="col-md-12">
            <div class="card">
            <div class="card-body table-border-style">
                    <div class="table-responsive">
                    <table class="table datatable">
                            <thead>
                            <tr>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Job')}}</th>
                                <th>{{__('Branch')}}</th>
                                <th>{{__('Applied at')}}</th>
                                <th>{{__('Joining at')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            @foreach ($jobOnBoards as $job)
                                <tr>
                                    <td>{{ !empty($job->applications)?$job->applications->name:'-' }}</td>
                                    <td>{{!empty($job->applications)?!empty($job->applications->jobs)?$job->applications->jobs->title:'-':'-'}}</td>
                                    <td>{{!empty($job->applications)?!empty($job->applications->jobs)?!empty($job->applications->jobs)?!empty($job->applications->jobs->branches)?$job->applications->jobs->branches->name:'-':'-':'-':'-'}}</td>
                                    <td>{{\Auth::user()->dateFormat(!empty($job->applications)?$job->applications->created_at:'-' )}}</td>
                                    <td>{{\Auth::user()->dateFormat($job->joining_date)}}</td>
                                    <td>
                                        @if($job->status=='pending')
                                            <span class="badge bg-warning p-2 px-3 rounded">{{\App\Models\JobOnBoard::$status[$job->status]}}</span>
                                        @elseif($job->status=='cancel')
                                            <span class="badge bg-danger p-2 px-3 rounded">{{\App\Models\JobOnBoard::$status[$job->status]}}</span>
                                        @else
                                            <span class="badge bg-success p-2 px-3 rounded">{{\App\Models\JobOnBoard::$status[$job->status]}}</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($job->status=='confirm' && $job->convert_to_employee==0)
                                        <div class="action-btn bg-warning ms-2">

                                            <a href="{{route('job.on.board.convert', $job->id)}}" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" data-original-title="{{__('Convert to Employee')}}"><i class="ti ti-exchange text-white"></i></a>
                                        </div>
                                            @elseif($job->status=='confirm' && $job->convert_to_employee!=0)
                                            <div class="action-btn bg-info ms-2">
                                                <a href="{{route('employee.show', \Crypt::encrypt($job->convert_to_employee))}}" class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="{{__('View')}}" data-original-title="{{__('Employee Detail')}}"><i class="ti ti-eye text-white"></i></a>
                                            </div>
                                            @endif

                                            <div class="action-btn bg-primary ms-2">
                                                <a href="#" data-url="{{route('job.on.board.edit', $job->id)}}" data-ajax-popup="true" class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}"><i class="ti ti-pencil text-white"></i></a>
                                            </div>

                                            <div class="action-btn bg-danger ms-2">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['job.on.board.delete', $job->id],'id'=>'delete-form-'.$job->id]) !!}
                                                <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$job->id}}').submit();"><i class="ti ti-trash text-white"></i></a>
                                                {!! Form::close() !!}
                                            </div>

                                            @if ($job->status == 'confirm' )
                                                <div class="action-btn bg-secondary ms-2">
                                                    <a href="{{route('offerlatter.download.pdf',$job->id)}}" class="mx-3 btn btn-sm  align-items-center " data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('OfferLetter PDF')}}" target="_blanks"><i class="ti ti-download text-white"></i></a>
                                                </div>
                                                <div class="action-btn bg-secondary ms-2">
                                                    <a href="{{route('offerlatter.download.doc',$job->id)}}" class="mx-3 btn btn-sm  align-items-center " data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('OfferLetter DOC')}}" target="_blanks"><i class="ti ti-download text-white"></i></a>
                                                </div>
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
@endsection
