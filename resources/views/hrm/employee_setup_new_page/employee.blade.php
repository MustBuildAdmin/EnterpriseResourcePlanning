@include('new_layouts.header')
@include('hrm.hrm_main')
@php
$profile=\App\Models\Utility::get_file('uploads/avatar/');
@endphp
<div class="mt-3">
    <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">{{ __('Employee') }}</h3>
            <!-- <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Employee</li>
            </ul> -->
          </div>
        </div>
    </div>
    <div class="row staff-grid-row">
        @foreach ($employees as $employee)
            <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
                <div class="profile-widget">
                    <div class="profile-img">
                        <a href="#" class="avatar"><img src="{{(!empty(\Auth::user()->avatar))? $profile.\Auth::user()->avatar: asset(Storage::url("uploads/avatar/avatar.png"))}}" alt=""></a>
                    </div>      
                    <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="{{route('employee.data',\Illuminate\Support\Facades\Crypt::encrypt($employee->user_id))}}">{{!empty($employee)?$employee->name:''}}</a></h4>
                    <div class="small text-muted">{{!empty($employee)?$employee->designation_name:"Not Assigned"}}</div>
                    </div>
                </div>
        @endforeach
        </div>
    </div>
</div>