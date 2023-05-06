                   

@include('new_layouts.header')
    <div class="card">
        <div class="row g-0">
        @include('new_layouts.usersidebar')
            <div class="col d-flex flex-column">
                <div class="card-body">
                <div class="card-header">
                        <h4>{{__('Mark Attandance')}}</h4>
                    </div>
                    <div class="card-body dash-card-body">
                        <p class="text-muted pb-0-5">{{__('My Office Time: '.$officeTime['startTime'].' to '.$officeTime['endTime'])}}</p>
                        <center>
                            <div class="row">
                                <div class="col-md-6 float-right border-right">
                                    {{Form::open(array('url'=>'attendanceemployee/attendance','method'=>'post'))}}
                                    @if(empty($employeeAttendance) || $employeeAttendance->clock_out != '00:00:00')
                                        <button type="submit" value="0" name="in" id="clock_in" class="btn-create badge-success">{{__('CLOCK IN')}}</button>
                                    @else
                                        <button type="submit" value="0" name="in" id="clock_in" class="btn-create badge-success disabled" disabled>{{__('CLOCK IN')}}</button>
                                    @endif
                                    {{Form::close()}}
                                </div>
                                <div class="col-md-6 float-left">
                                    @if(!empty($employeeAttendance) && $employeeAttendance->clock_out == '00:00:00')
                                        {{Form::model($employeeAttendance,array('route'=>array('attendanceemployee.update',$employeeAttendance->id),'method' => 'PUT')) }}
                                        <button type="submit" value="1" name="out" id="clock_out" class="btn-create badge-danger">{{__('CLOCK OUT')}}</button>
                                    @else
                                        <button type="submit" value="1" name="out" id="clock_out" class="btn-create badge-danger disabled" disabled>{{__('CLOCK OUT')}}</button>
                                    @endif
                                    {{Form::close()}}
                                </div>
                            </div>
                        </center>

                    </div>
                </div>
            </div>
        </div>
    </div>
@include('new_layouts.footer')
<style>
.btn-create.badge-danger{
    color: #ffffff;
    background-color: #ff3a6e;
    border-color: #ff3a6e;
    display: inline-block;
    font-weight: 500;
    line-height: 1.5;
    /* color: #293240; */
    text-align: center;
    vertical-align: middle;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    /* background-color: transparent; */
    /* border: 1px solid transparent; */
    padding: 0.575rem 1.3rem;
    font-size: 0.875rem;
    border-radius: 6px;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
.btn-create.badge-success.disabled{
    color: #ffffff;
    background-color: #6fd943;
    border-color: #6fd943;
    pointer-events: none;
    opacity: 0.65;
}
.btn-create.badge-danger.disabled {
    color: #ffffff;
    background-color: #ff3a6e;
    border-color: #ff3a6e;
    pointer-events: none;
    opacity: 0.65;
}
.btn-create.badge-success{
    color: #ffffff;
    background-color: #6fd943;
    border-color: #6fd943;
    display: inline-block;
    font-weight: 500;
    line-height: 1.5;
    /* color: #293240; */
    text-align: center;
    vertical-align: middle;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    /* background-color: transparent; */
    /* border: 1px solid transparent; */
    padding: 0.575rem 1.3rem;
    font-size: 0.875rem;
    border-radius: 6px;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
</style>