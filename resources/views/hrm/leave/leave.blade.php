@include('new_layouts.header')

<style>
.ms-2 {
    background: #fff  !important;
}

.ti.ti-caret-right.text-white {
    color: #000 !important;
    font-size: 18px;
}

</style>

@include('hrm.hrm_main')
    <div class="row">
        <div class="col-md-6">
           <h2>Manage Leave</h2>
        </div>
        <div class="col-md-6 float-end">
           @can('create leave')
              <a href="#" class="btn btn-sm btn-primary mb-3 floatrght" data-size="lg" data-url="{{ route('leave.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create Leave')}}" >
                  <i class="ti ti-plus"></i>
              </a>
           @endcan
        </div>
    </div>

    <div class="table-responsive">
        <table class="table datatable">
            <thead>
                <tr>
              
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
            <tbody class="font-style">
                @foreach ($leaves as $leave)
                    <tr>
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
                        <td>{{ $leave->leave_reason }}</td>
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
                            <div class="ms-2" style="display:flex;gap:10px;">
                                @if(\Auth::user()->type == 'employee')
                                    @if($leave->status == "Pending")
                                        @can('edit leave')
                                        @if($showedit==0)
                                            <a href="#" data-url="{{ URL::to('leave/'.$leave->id.'/edit') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Leave')}}" class="btn btn-md bg-primary" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}"><i class="ti ti-pencil text-white"></i></a>
                                       @endif
                                            @endcan
                                    @endif
                                @else
                                    <a href="#" data-url="{{ URL::to('leave/'.$leave->id.'/action') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Leave Action')}}" class="btn btn-md bg-primary" data-bs-toggle="tooltip" title="{{__('Leave Action')}}" data-original-title="{{__('Leave Action')}}">
                                            <i class="ti ti-caret-right text-white"></i> 
                                    </a>
                                    @can('edit leave')
                                    @if($showedit==0)
                                            <a href="#" data-url="{{ URL::to('leave/'.$leave->id.'/edit') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Leave')}}" class="btn btn-md bg-primary" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                <i class="ti ti-pencil text-white"></i>
                                            </a>
                                            @endif
                                    @endcan
                                @endif

                                @can('delete leave')
                                @if($showedit==0)
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['leave.destroy', $leave->id],'id'=>'delete-form-'.$leave->id]) !!}
                                        <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$leave->id}}').submit();">
                                            <i class="ti ti-trash text-white"></i>
                                        </a>
                                    {!! Form::close() !!}
                                    @endif
                                @endif
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
<script>
    $(document).on('change', '#employee_id', function () {
        var employee_id = $(this).val();

        $.ajax({
            url: '{{route('leave.jsoncount')}}',
            type: 'POST',
            data: {
                "employee_id": employee_id, "_token": "{{ csrf_token() }}",
            },
            success: function (data) {

                $('#leave_type_id').empty();
                $('#leave_type_id').append('<option value="">{{__('Select Leave Type')}}</option>');

                $.each(data, function (key, value) {

                    if (value.total_leave >= value.days) {
                        $('#leave_type_id').append('<option value="' + value.id + '" disabled>' + value.title + '&nbsp(' + value.total_leave + '/' + value.days + ')</option>');
                    } else {
                        $('#leave_type_id').append('<option value="' + value.id + '">' + value.title + '&nbsp(' + value.total_leave + '/' + value.days + ')</option>');
                    }
                });

            }
        });
    });
</script>
<style>
    .ms-2 {
    background: blue;
}
</style>