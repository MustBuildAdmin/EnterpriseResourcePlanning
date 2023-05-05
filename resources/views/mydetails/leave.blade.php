@include('new_layouts.header')
    <div class="page-wrapper">
        <!-- Page header -->
        <!-- <div class="page-header d-print-none">
            <div >
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                        {{ __('My Details') }}
                        </h2>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- Page body -->
        <!-- <div class="page-body">
            <div class=""> -->
                <!-- <div class="card"> -->
                    <div class="row g-0">
                    @include('new_layouts.usersidebar')
                        <div class="col d-flex flex-column">
                            <div class="card-body">
                            <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                @if(\Auth::user()->type!='employee')
                                    <th>{{__('Employee')}}</th>
                                @endif
                                <th>{{__('Leave Type')}}</th>
                                <th>{{__('Applied On')}}</th>
                                <th>{{__('Start Date')}}</th>
                                <th>{{__('End Date')}}</th>
                                <th>{{__('Total Days')}}</th>
                                <th>{{__('Leave Reason')}}</th>
                                <th>{{__('status')}}</th>
                                <th width="200px">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($leaves as $leave)
                                <tr>
                                    @if(\Auth::user()->type!='employee')
                                        <td>{{ !empty(\Auth::user()->getEmployee($leave->employee_id))?\Auth::user()->getEmployee($leave->employee_id)->name:'' }}</td>
                                    @endif
                                    <td>{{ !empty(\Auth::user()->getLeaveType($leave->leave_type_id))?\Auth::user()->getLeaveType($leave->leave_type_id)->title:'' }}</td>
                                    <td>{{ \Auth::user()->dateFormat($leave->applied_on )}}</td>
                                    <td>{{ \Auth::user()->dateFormat($leave->start_date ) }}</td>
                                    <td>{{ \Auth::user()->dateFormat($leave->end_date )  }}</td>
                                    @php
                                        $startDate = new \DateTime($leave->start_date);
                                        $endDate   = new \DateTime($leave->end_date);
                                        $total_leave_days = !empty($startDate->diff($endDate))?$startDate->diff($endDate)->days:0;
                                    @endphp
                                    <td>{{ $total_leave_days }}</td>
                                    <td class="leave_reason">{{ $leave->leave_reason }}</td>
                                    <td>

                                        @if($leave->status=="Pending")
                                            <div class="status_badge badge bg-warning p-2 px-3 rounded">{{ $leave->status }}</div>
                                        @elseif($leave->status=="Approved")
                                            <div class="status_badge badge bg-success p-2 px-3 rounded">{{ $leave->status }}</div>
                                        @else($leave->status=="Reject")
                                            <div class="status_badge badge bg-danger p-2 px-3 rounded">{{ $leave->status }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if(\Auth::user()->type == 'employee')
                                            @if($leave->status == "Pending")
                                                @can('edit leave')
                                                <div>
                                                    <a href="#" data-url="{{ URL::to('leave/'.$leave->id.'/edit') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Leave')}}" class="mx-3 btn btn-sm  align-items-center" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}"><i class="ti ti-pencil text-white"></i></a>
                                                </div>
                                                @endcan
                                            @endif
                                        @else
                                        <div class="action-btn bg-warning ms-2">
                                            <a href="#" data-url="{{ URL::to('leave/'.$leave->id.'/action') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Leave Action')}}" class="mx-3 btn btn-sm  align-items-center" data-bs-toggle="tooltip" title="{{__('Leave Action')}}" data-original-title="{{__('Leave Action')}}">
                                                <i class="ti ti-caret-right text-white"></i> </a>
                                        </div>
                                            @can('edit leave')
                                            <div class="action-btn bg-primary ms-2">
                                                <a href="#" data-url="{{ URL::to('leave/'.$leave->id.'/edit') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Leave')}}" class="mx-3 btn btn-sm  align-items-center" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                <i class="ti ti-pencil text-white"></i></a>
                                            </div>
                                            @endcan
                                        @endif
                                        @can('delete leave')
                                        <div class="action-btn bg-danger ms-2">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['leave.destroy', $leave->id],'id'=>'delete-form-'.$leave->id]) !!}
                                            <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$leave->id}}').submit();">
                                            <i class="ti ti-trash text-white"></i></a>
                                            {!! Form::close() !!}
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
                <!-- </div> -->
            <!-- </div>
        </div> -->
    </div>
@include('new_layouts.footer')
<style>
td.leave_reason {
    width: 30%;
    word-break: break-all;
}
</style>