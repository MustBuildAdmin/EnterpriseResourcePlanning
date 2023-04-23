@include('new_layouts.header')
@include('hrm.hrm_main',['hrm_header' => 'Employee'])
    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    <th>{{__('Employee ID')}}</th>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Email')}}</th>
                    <th>{{__('Branch') }}</th>
                    <th>{{__('Department') }}</th>
                    <th>{{__('Designation') }}</th>
                    <th>{{__('Date Of Joining') }}</th>
                    <th> {{__('Last Login')}}</th>
                    <th width="200px">{{__('Action')}}</th>
                </tr>
            </thead>
            <tbody class="font-style">
                @foreach ($employees as $employee)
                    <tr>
                        <td class="Id">
                            @can('show employee profile')
                                <a href="{{route('employee.show',\Illuminate\Support\Facades\Crypt::encrypt($employee->id))}}" class="btn btn-outline-primary">{{ \Auth::user()->employeeIdFormat($employee->employee_id) }}</a>
                            @else
                                <a href="#" class="btn btn-outline-primary">{{ \Auth::user()->employeeIdFormat($employee->employee_id) }}</a>
                            @endcan
                        </td>
                        <td class="font-style">{{ $employee->name }}</td>
                        <td>{{ $employee->email }}</td>
                        @if($employee->branch_id)
                            <td class="font-style">{{!empty(\Auth::user()->getBranch($employee->branch_id ))?\Auth::user()->getBranch($employee->branch_id )->name:''}}</td>
                        @else
                            <td>-</td>
                        @endif
                        @if($employee->department_id)
                            <td class="font-style">{{!empty(\Auth::user()->getDepartment($employee->department_id ))?\Auth::user()->getDepartment($employee->department_id )->name:''}}</td>
                        @else
                            <td>-</td>
                        @endif
                        @if($employee->designation_id)
                            <td class="font-style">{{!empty(\Auth::user()->getDesignation($employee->designation_id ))?\Auth::user()->getDesignation($employee->designation_id )->name:''}}</td>
                        @else
                            <td>-</td>
                        @endif
                        @if($employee->company_doj)
                            <td class="font-style">{{ \Auth::user()->dateFormat($employee->company_doj )}}</td>
                        @else
                            <td>-</td>
                        @endif
                        <td>
                            {{ (!empty($employee->user->last_login_at)) ? $employee->user->last_login_at : '-' }}
                        </td>
                        @if(Gate::check('edit employee') || Gate::check('delete employee'))
                            <td>
                                <div class="ms-2" style="display:flex;gap:10px;">
                                    @if($employee->is_active==1)
                                        @can('edit employee')
                                            <a href="{{route('employee.edit',\Illuminate\Support\Facades\Crypt::encrypt($employee->id))}}" class="btn btn-md bg-primary" data-bs-toggle="tooltip" title="{{__('Edit')}}"
                                                data-original-title="{{__('Edit')}}"><i class="ti ti-pencil text-white"></i>
                                            </a>
                                        @endcan
                                        @can('delete employee')
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['employee.destroy', $employee->id],'id'=>'delete-form-'.$employee->id]) !!}
                                                <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$employee->id}}').submit();"><i class="ti ti-trash text-white"></i></a>
                                            {!! Form::close() !!}
                                        @endcan
                                    @else
                                        <i class="ti ti-lock"></i>
                                    @endif
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
    </div>
@include('new_layouts.footer')