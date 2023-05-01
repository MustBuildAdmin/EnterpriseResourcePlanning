@include('new_layouts.header')
@include('hrm.hrm_main',['hrm_header' => 'Manage Attendance List'])

    <div class="row">
        <div class="col-sm-12">
            <div class=" mt-2 " id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(array('route' => array('attendanceemployee.index'),'method'=>'get','id'=>'attendanceemployee_filter')) }}
                        <div class="row align-items-center justify-content-end">
                            <div class="col-xl-10">
                                <div class="row">
                                    <div class="col-3">
                                        <label class="form-label">{{__('Type')}}</label> <br>
                                        <div class="form-check form-check-inline form-group">
                                            <input type="radio" id="monthly" value="monthly" name="type" class="form-check-input" {{isset($_GET['type']) && $_GET['type']=='monthly' ?'checked':'checked'}}>
                                            <label class="form-check-label" for="monthly">{{__('Monthly')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline form-group">
                                            <input type="radio" id="daily" value="daily" name="type" class="form-check-input" {{isset($_GET['type']) && $_GET['type']=='daily' ?'checked':''}}>
                                            <label class="form-check-label" for="daily">{{__('Daily')}}</label>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 month">
                                        <div class="btn-box">
                                            {{Form::label('month',__('Month'),['class'=>'form-label'])}}
                                            {{Form::month('month',isset($_GET['month'])?$_GET['month']:date('Y-m'),array('class'=>'month-btn form-control month-btn'))}}
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 date">
                                        <div class="btn-box">
                                            {{ Form::label('date', __('Date'),['class'=>'form-label'])}}
                                            {{ Form::date('date',isset($_GET['date'])?$_GET['date']:'', array('class' => 'form-control month-btn')) }}
                                        </div>
                                    </div>
                                    @if(\Auth::user()->type != 'employee')
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                            <div class="btn-box">
                                                {{ Form::label('branch', __('Branch'),['class'=>'form-label'])}}
                                                {{ Form::select('branch', $branch,isset($_GET['branch'])?$_GET['branch']:'', array('class' => 'form-control select')) }}
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                            <div class="btn-box">
                                                {{ Form::label('department', __('Department'),['class'=>'form-label'])}}
                                                {{ Form::select('department', $department,isset($_GET['department'])?$_GET['department']:'', array('class' => 'form-control select')) }}
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                            <div class="col-auto mt-4">
                                <div class="row">
                                    <div class="col-auto">
                                        <a href="#" class="btn btn-sm btn-primary" onclick="document.getElementById('attendanceemployee_filter').submit(); return false;" data-bs-toggle="tooltip" title="{{__('Apply')}}" data-original-title="{{__('apply')}}">
                                            <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                        </a>
                                        <a href="{{route('attendanceemployee.index')}}" class="btn btn-sm btn-danger " data-bs-toggle="tooltip"  title="{{ __('Reset') }}" data-original-title="{{__('Reset')}}">
                                            <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                @if(\Auth::user()->type!='Employee')
                                    <th>{{__('Employee')}}</th>
                                @endif
                                <th>{{__('Date')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Clock In')}}</th>
                                <th>{{__('Clock Out')}}</th>
                                <th>{{__('Late')}}</th>
                                <th>{{__('Early Leaving')}}</th>
                                <th>{{__('Overtime')}}</th>
                                @if(Gate::check('edit attendance') || Gate::check('delete attendance'))
                                    <th>{{__('Action')}}</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($attendanceEmployee as $attendance)
                                <tr>
                                    @if(\Auth::user()->type!='Employee')
                                        <td>{{!empty($attendance->employee)?$attendance->employee->name:'' }}</td>
                                    @endif
                                    <td>{{ \Auth::user()->dateFormat($attendance->date) }}</td>
                                    <td>{{ $attendance->status }}</td>
                                    <td>{{ ($attendance->clock_in !='00:00:00') ?\Auth::user()->timeFormat( $attendance->clock_in):'00:00' }} </td>
                                    <td>{{ ($attendance->clock_out !='00:00:00') ?\Auth::user()->timeFormat( $attendance->clock_out):'00:00' }}</td>
                                    <td>{{ $attendance->late }}</td>
                                    <td>{{ $attendance->early_leaving }}</td>
                                    <td>{{ $attendance->overtime }}</td>
                                    @if(Gate::check('edit attendance') || Gate::check('delete attendance'))
                                        <td>
                                            <div class="ms-2" style="display:flex;gap:10px;">
                                                @can('edit attendance')
                                                    <a href="#" data-url="{{ URL::to('attendanceemployee/'.$attendance->id.'/edit') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Attendance')}}" class="btn btn-md bg-primary " data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                @endcan
                                                @can('delete attendance')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['attendanceemployee.destroy', $attendance->id],'id'=>'delete-form-'.$attendance->id]) !!}
                                                        <a href="#" class="btn btn-md btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}"
                                                        data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$attendance->id}}').submit();">
                                                            <i class="ti ti-trash text-white"></i>
                                                        </a>
                                                    {!! Form::close() !!}
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
        </div>
    </div>

    </div>
    </div>

@include('new_layouts.footer')

<script>
    $(document).ready(function () {
        $('.daterangepicker').daterangepicker({
            format: 'yyyy-mm-dd',
            locale: {format: 'YYYY-MM-DD'},
        });
    });
</script>

<script>
    $('input[name="type"]:radio').on('change', function (e) {
        var type = $(this).val();
        if (type == 'monthly') {
            $('.month').addClass('d-block');
            $('.month').removeClass('d-none');
            $('.date').addClass('d-none');
            $('.date').removeClass('d-block');
        } else {
            $('.date').addClass('d-block');
            $('.date').removeClass('d-none');
            $('.month').addClass('d-none');
            $('.month').removeClass('d-block');
        }
    });
    $('input[name="type"]:radio:checked').trigger('change');

</script>