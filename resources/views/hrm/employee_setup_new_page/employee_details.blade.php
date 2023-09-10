@include('new_layouts.header')
@include('hrm.hrm_main')
<div class="mt-3">
    <h3 class="card-title">{{ __('Profile') }}</h3>          
    <!-- <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Profile</li>
    </ul> -->
    <div class="card-employee mb-0">
        <div class="card-body-employee">
            <div class="row-employee">
                <div class="col-md-12 row-emp">
                    <div class="profile-view">
                        <div class="profile-img-wrap">
                            <div class="profile-img">
                                <a href="#"><img alt="" src="https://smarthr.dreamguystech.com/codeigniter/template/orange/public/assets/img/profiles/avatar-02.jpg"></a>
                            </div>
                        </div>
                        <div class="profile-basic">
                            <div class="row">
                                <div class="col-md-5 row-user">
                                    <div class="profile-info-left">
                                        <h3 class="user-name m-t-0 mb-0">{{$user_details->name}}</h3>
                                        <h6 class="designation_name">UI/UX Design Team</h6>
                                        <small class="des_name">{{$user_details->designation_name}}</small>
                                        <div class="staff-id">{{ \Auth::user()->employeeIdFormat($user_details->employee_id) }}</div>
                                            <div class="small doj">Date of Join : 1st Jan 2013</div>
                                                <div class="staff-msg"><a class="btn btn-custom" href="apps-chat">Send Message</a></div>
                                                </div>
                                            </div>
                                            <div class="col-md-7 per_class">
                                                <ul class="personal-info">
                                                    <li>
                                                        <div class="title">Phone:</div>
                                                            <div class="text"><a href="">{{$user_details->phone}}</a></div>
                                                    </li>
                                                    <li>
                                                        <div class="title">Email:</div>
                                                            <div class="text"><a href="">{{$user_details->email}}</a></div>
                                                    </li>
                                                    <li>
                                                        <div class="title">Birthday:</div>
                                                        <div class="text">24th July</div>
                                                    </li>
                                                    <li>
                                                        <div class="title">Address:</div>
                                                        <div class="text">1861 Bayonne Ave, Manchester Township, NJ, 08759</div>
                                                    </li>
                                                    <li>
                                                        <div class="title">Gender:</div>
                                                        <div class="text">{{$user_details->gender}}</div>
                                                    </li>
                                                    <li>
                                                        <div class="title">Reports to:</div>
                                                        <div class="text">
                                                            <div class="avatar-box">
                                                                <div class="avatar avatar-xs">
                                                                    <img src="https://smarthr.dreamguystech.com/codeigniter/template/orange/public/assets/img/profiles/avatar-16.jpg" alt="">
                                                                </div>
                                                            </div>
                                                            <a href="profile">Jeffery Lalor</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pro-edit"><a data-bs-target="#profile_info" data-bs-toggle="modal" class="edit-icon" href="#"><i class="ti ti-pencil"></i></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
