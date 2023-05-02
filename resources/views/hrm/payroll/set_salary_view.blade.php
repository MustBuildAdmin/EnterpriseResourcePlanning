@include('new_layouts.header')
@include('hrm.hrm_main',['hrm_header' => 'Employee Salary'])

    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
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
            <tbody class="font-style">
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
                        <div class="ms-2" style="display:flex;gap:10px;">
                            <a href="{{route('setsalary.show',$employee->id)}}" class="btn btn-md bg-primary" data-bs-toggle="tooltip" title="{{__('Set Salary')}}" data-original-title="{{__('View')}}">
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

@include('new_layouts.footer')