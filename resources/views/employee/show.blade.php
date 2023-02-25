@extends('layouts.admin')

@section('page-title')
    {{__('Employee')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('employee.index')}}">{{__('Employee')}}</a></li>
    <li class="breadcrumb-item">{{$employeesId}}</li>
@endsection

@section('action-btn')
    @if(!empty($employee))
        <div class="float-end mt-3 m-2">
            @can('edit employee')

                <a href="{{route('employee.edit',\Illuminate\Support\Facades\Crypt::encrypt($employee->id))}}" data-bs-toggle="tooltip" title="{{__('Edit')}}"class="btn btn-sm btn-primary">
                    <i class="ti ti-pencil"></i>
                </a>

            @endcan
        </div>

        <div class="text-end">
            <div class="d-flex justify-content-end drp-languages">
                <ul class="list-unstyled mb-0 m-2">
                    <li class="dropdown dash-h-item status-drp">
                        <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                           role="button" aria-haspopup="false" aria-expanded="false">
                            <span class="drp-text hide-mob text-primary"> {{__('Joining Letter')}}</span>
                            <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
                        </a>
                        <div class="dropdown-menu dash-h-dropdown">
                            <a href="{{route('joiningletter.download.pdf',$employee->id)}}" class=" btn-icon dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top"  target="_blanks"><i class="ti ti-download ">&nbsp;</i>{{__('PDF')}}</a>

                            <a href="{{route('joininglatter.download.doc',$employee->id)}}" class=" btn-icon dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top"  target="_blanks"><i class="ti ti-download ">&nbsp;</i>{{__('DOC')}}</a>
                        </div>
                    </li>
                </ul>
                <ul class="list-unstyled mb-0 m-2">
                    <li class="dropdown dash-h-item status-drp">
                        <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                           role="button" aria-haspopup="false" aria-expanded="false">
                            <span class="drp-text hide-mob text-primary"> {{__('Experience Certificate')}}</span>
                            <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
                        </a>
                        <div class="dropdown-menu dash-h-dropdown">
                            <a href="{{route('exp.download.pdf',$employee->id)}}" class=" btn-icon dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top"  target="_blanks"><i class="ti ti-download ">&nbsp;</i>{{__('PDF')}}</a>

                            <a href="{{route('exp.download.doc',$employee->id)}}" class=" btn-icon dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top"  target="_blanks"><i class="ti ti-download ">&nbsp;</i>{{__('DOC')}}</a>
                        </div>
                    </li>
                </ul>
                <ul class="list-unstyled mb-0 m-2">
                    <li class="dropdown dash-h-item status-drp">
                        <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                           role="button" aria-haspopup="false" aria-expanded="false">
                            <span class="drp-text hide-mob text-primary"> {{__('NOC')}}</span>
                            <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
                        </a>
                        <div class="dropdown-menu dash-h-dropdown">
                            <a href="{{route('noc.download.pdf',$employee->id)}}" class=" btn-icon dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top"  target="_blanks"><i class="ti ti-download ">&nbsp;</i>{{__('PDF')}}</a>

                            <a href="{{route('noc.download.doc',$employee->id)}}" class=" btn-icon dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top"  target="_blanks"><i class="ti ti-download ">&nbsp;</i>{{__('DOC')}}</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    @endif
@endsection

@section('content')
    @if(!empty($employee))
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-sm-12 col-md-6">

                        <div class="card ">
                            <div class="card-body employee-detail-body fulls-card">
                                <h5>{{__('Personal Detail')}}</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info text-sm">
                                            <strong class="font-bold">{{__('EmployeeId')}} : </strong>
                                            <span>{{$employeesId}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info text-sm font-style">
                                            <strong class="font-bold">{{__('Name')}} :</strong>
                                            <span>{{!empty($employee)?$employee->name:''}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info text-sm font-style">
                                            <strong class="font-bold">{{__('Email')}} :</strong>
                                            <span>{{!empty($employee)?$employee->email:''}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info text-sm">
                                            <strong class="font-bold">{{__('Date of Birth')}} :</strong>
                                            <span>{{\Auth::user()->dateFormat(!empty($employee)?$employee->dob:'')}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info text-sm">
                                            <strong class="font-bold">{{__('Phone')}} :</strong>
                                            <span>{{!empty($employee)?$employee->phone:''}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info text-sm">
                                            <strong class="font-bold">{{__('Address')}} :</strong>
                                            <span>{{!empty($employee)?$employee->address:''}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info text-sm">
                                            <strong class="font-bold">{{__('Salary Type')}} :</strong>
                                            <span>{{!empty($employee->salaryType)?$employee->salaryType->name:''}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info text-sm">
                                            <strong class="font-bold">{{__('Basic Salary')}} :</strong>
                                            <span>{{!empty($employee)?$employee->salary:''}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">

                        <div class="card ">
                            <div class="card-body employee-detail-body fulls-card">
                                <h5>{{__('Company Detail')}}</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info text-sm">
                                            <strong class="font-bold">{{__('Branch')}} : </strong>
                                            <span>{{!empty($employee->branch)?$employee->branch->name:''}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info text-sm font-style">
                                            <strong class="font-bold">{{__('Department')}} :</strong>
                                            <span>{{!empty($employee->department)?$employee->department->name:''}}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info text-sm">
                                            <strong class="font-bold">{{__('Designation')}} :</strong>
                                            <span>{{!empty($employee->designation)?$employee->designation->name:''}}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info text-sm">
                                            <strong class="font-bold">{{__('Date Of Joining')}} :</strong>
                                            <span>{{\Auth::user()->dateFormat(!empty($employee)?$employee->company_doj:'')}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-6">

                        <div class="card ">
                            <div class="card-body employee-detail-body fulls-card">
                                <h5>{{__('Document Detail')}}</h5>
                                <hr>
                                <div class="row">
                                    @php

                                        $employeedoc = !empty($employee)?$employee->documents()->pluck('document_value',__('document_id')):[];
                                    @endphp
                                    @if(!$documents->isEmpty())
                                        @foreach($documents as $key=>$document)
                                            <div class="col-md-6">
                                                <div class="info text-sm">
                                                    <strong class="font-bold">{{$document->name }} : </strong>
                                                    <span><a href="{{ (!empty($employeedoc[$document->id])?asset(Storage::url('uploads/document')).'/'.$employeedoc[$document->id]:'') }}" target="_blank">{{ (!empty($employeedoc[$document->id])?$employeedoc[$document->id]:'') }}</a></span>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-center">
                                            No Document Type Added.!
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">

                        <div class="card ">
                            <div class="card-body employee-detail-body fulls-card">
                                <h5>{{__('Bank Account Detail')}}</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info text-sm">
                                            <strong class="font-bold">{{__('Account Holder Name')}} : </strong>
                                            <span>{{!empty($employee)?$employee->account_holder_name:''}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info text-sm font-style">
                                            <strong class="font-bold">{{__('Account Number')}} :</strong>
                                            <span>{{!empty($employee)?$employee->account_number:''}}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info text-sm">
                                            <strong class="font-bold">{{__('Bank Name')}} :</strong>
                                            <span>{{!empty($employee)?$employee->bank_name:''}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info text-sm">
                                            <strong class="font-bold">{{__('Bank Identifier Code')}} :</strong>
                                            <span>{{!empty($employee)?$employee->bank_identifier_code:''}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info text-sm">
                                            <strong class="font-bold">{{__('Branch Location')}} :</strong>
                                            <span>{{!empty($employee)?$employee->branch_location:''}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info text-sm">
                                            <strong class="font-bold">{{__('Tax Payer Id')}} :</strong>
                                            <span>{{!empty($employee)?$employee->tax_payer_id:''}}</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
