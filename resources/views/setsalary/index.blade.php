@extends('layouts.admin')
@section('page-title')
    {{__('Manage Employee Salary')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Employee Salary')}}</li>
@endsection
@section('content')
    <div class="row">
    <div class="col-xl-12">
            <div class="card">
            <div class="card-body table-border-style">
                    <div class="table-responsive">
                    <table class="table datatable">
                            <thead>
                            <tr>
                                <th>{{__('Employee Id')}}</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Payroll Type') }}</th>
                                <th>{{__('Salary') }}</th>
                                <th>{{__('Net Salary') }}</th>
                                <th width="200px">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($employees as $employee)
                                <tr>
                                    <td class="Id">
                                        <a href="{{route('setsalary.show',$employee->id)}}" class="btn btn-outline-primary" data-toggle="tooltip" data-original-title="{{__('View')}}">
                                            {{ \Auth::user()->employeeIdFormat($employee->employee_id) }}
                                        </a>
                                    </td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->salary_type() }}</td>
                                    <td>{{  \Auth::user()->priceFormat($employee->salary) }}</td>
                                    <td>{{  !empty($employee->get_net_salary()) ?\Auth::user()->priceFormat($employee->get_net_salary()):'' }}</td>
                                    <td>
                                    <div class="action-btn bg-success ms-2">
                                        <a href="{{route('setsalary.show',$employee->id)}}" class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="{{__('Set Salary')}}" data-original-title="{{__('View')}}">
                                            <i class="ti ti-eye text-white"></i>
                                        </a>
                                    </div>
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


