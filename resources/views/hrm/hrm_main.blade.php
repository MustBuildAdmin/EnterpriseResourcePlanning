<style>
.wrapper {
    height: 100%;
}
.main_body{
    height: 100%;
}
 .sidebar_menu{
  	background: #3421C0;
  	width: 250px;
  	height: 100%;
  	transition: all 0.3s linear;
}
 .sidebar_menu .inner__sidebar_menu{
	position: relative;
	padding-top: 60px;
}
 .sidebar_menu ul li {
    list-style-type: none;
    padding: 5px;
}
.sidebar_menu ul li a{
  color: #ffffff;
  font-size: 14px;
  padding: 10px;
  display: block;
  white-space: nowrap;
}
.sidebar_menu ul li a .icon{
  margin-right: 8px;
}
 .sidebar_menu ul li a span{
  display: inline-block;
}
 .sidebar_menu ul li a:hover{
  background: #5343c7;
  color: #fff;
}
 .sidebar_menu ul li a.active{
  background: #22119d;
  color: #fff;
}
 .sidebar_menu .hamburger{
  position: absolute;
  top: 5px;
  right: -25px;
  width: 50px;
  height: 50px;
  background: #e8edf5;
  border-radius: 50%;
  cursor: pointer;
}
 .sidebar_menu .inner_hamburger,
.sidebar_menu .hamburger .arrow{
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%,-50%);
}
.sidebar_menu .inner_hamburger{
  width: 40px;
  border-radius: 50%;
  height: 40px;
  background: #3421C0;
}
 .sidebar_menu .hamburger .arrow{
  color: #fff;
  font-size: 20px;
}
 .sidebar_menu .hamburger  .fa-long-arrow-alt-right{
  display: none;
}
 .main-container{
	width: calc(100% - 250px);
	margin-top: 65px;
	margin-left: 50px;
	padding: 25px 40px;
	transition: all 0.3s linear;
}
.main-container .item_wrap{
	display: flex;
	margin-bottom: 20px;
}
 .main-container .item_wrap .item{
	background: #fff;
	border: 1px solid #e0e0e0;
	padding: 25px;
	font-size: 14px;
	line-height: 22px;
}
 .main-container .item_wrap .item:first-child{
	margin-right: 20px;
}
/* after adding active class */
.wrapper.active .sidebar_menu{
  width: 70px;
}
.wrapper.active .hamburger .fa-long-arrow-alt-right{
  display: block;
}
.wrapper.active .hamburger .fa-long-arrow-alt-left{
  display: none;
}
.wrapper.active .sidebar_menu ul li a .list{
  display: none;
}
.sidebar_menu .inner__sidebar_menu ul {
    padding: 0px;
}

.dropdown-menu.show {
    background-color: #3421c0;
}
</style>
<div class="wrapper container-fluid">
<div class="row">

    <div class="sidebar_menu col-2 col-md-2 col-xs-2">

        <div class="inner__sidebar_menu">
            <h4 class="p-2 text-center text-white">Human Resources</h4>
            <ul>
              <li>
                <a href="#">
                  <span class="icon">
                    <i class="ti ti-activity-heartbeat"></i></span>
                  <span class="list">Dashboard</span>
                </a>
              </li>
              <li>
                <a href="#" class="active">
                  <span class="icon"><i class="ti ti-users"></i>
                  </span>
                  <span class="list">Employees</span>
                </a>
              </li>
              <li>
                <a href="#">
                  <span class="icon"><i class="ti ti-calendar-stats"></i>
                  </span>
                  <span class="list">Leave Management</span>
                </a>
              </li>
              <li>
                <a href="#">
                  <span class="icon"><i class="ti ti-file-dollar"></i>
                  </span>
                  <span class="list">Payslips</span>
                </a>
              </li>
              <li>
                <a href="#">
                  <span class="icon"><i class="ti ti-chart-infographic"></i>
                  </span>
                  <span class="list">Reports</span>
                </a>
              </li>
            </ul>
            <h5 class="text-center text-white">Settings</h5>

            <ul>
                <li>
                  <div class="dropend">
                    <a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false" >
                      {{__('HR Admin Setup')}}
                    </a>
                    <div class="dropdown-menu">
                      @can('manage award')
                        <a href="{{url('award')}}" class="dropdown-item">
                          {{__('Award')}}
                        </a>
                      @endcan
                      @can('manage transfer')
                        <a href="{{url('transfer')}}" class="dropdown-item">
                          {{__('Transfer')}}
                        </a>
                      @endcan
                      @can('manage resignation')
                        <a href="{{url('resignation')}}" class="dropdown-item">
                          {{__('Resignation')}}
                        </a>
                      @endcan
                      @can('manage travel')
                        <a href="{{url('travel')}}" class="dropdown-item">
                          {{__('Trip')}}
                        </a>
                      @endcan
                      @can('manage promotion')
                        <a href="{{url('promotion')}}" class="dropdown-item">
                          {{__('Promotion')}}
                        </a>
                      @endcan
                      @can('manage complaint')
                        <a href="{{url('complaint')}}" class="dropdown-item">
                          {{__('Complaints')}}
                        </a>
                      @endcan
                      @can('manage warning')
                        <a href="{{url('warning')}}" class="dropdown-item">
                          {{__('Warning')}}
                        </a>
                      @endcan
                      @can('manage termination')
                        <a href="{{url('termination')}}" class="dropdown-item">
                          {{__('Termination')}}
                        </a>
                      @endcan
                      @can('manage announcement')
                        <a href="{{url('announcement')}}" class="dropdown-item">
                          {{__('Announcement')}}
                        </a>
                      @endcan
                      @can('manage holiday')
                        <a href="{{url('holiday')}}" class="dropdown-item">
                          {{__('Holidays')}}
                        </a>
                      @endcan
                    </div>
                  </div>
                </li>
                <li>
                  <a href="#" class="">
                    <span class="icon"><i class="ti ti-calendar-event"></i>

                    </span>
                    <span class="list">Event and Meetings</span>
                  </a>
                </li>
                @can('manage document')
                  <li>
                    <a href="{{url('hrm_doc_setup')}}" class="">
                      <span class="icon"><i class="ti ti-certificate"></i>
                      </span>
                      <span class="list">{{__('Document Setup')}}</span>
                    </a>
                  </li>
                @endcan
                @can('manage company policy')
                  <li>
                    <a href="{{url('hrm_company_policy')}}" class="">
                      <span class="icon">  <i class="ti ti-clipboard-text"></i>
                      </span>
                      <span class="list">{{__('Company policy')}}</span>
                    </a>
                  </li>
                @endcan
                <li>
                  <a href="#" class="">
                    <span class="icon">  <i class="ti ti-tool"></i>

                    </span>
                    <span class="list">Resource Settings</span>
                  </a>
                </li>
                <li>
                  <div class="dropend">
                    <a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false" >
                      {{__('HRM System Setup')}}
                    </a>
                    <div class="dropdown-menu">
                        <a href="{{route('branch.index')}}" class="dropdown-item">
                          {{__('Branch')}}
                        </a>
                        <a href="{{ route('department.index') }}" class="dropdown-item">
                          {{__('Department')}}
                        </a>
                        <a href="{{ route('designation.index') }}" class="dropdown-item">
                          {{__('Designation')}}
                        </a>
                        <a href="{{ route('leavetype.index') }}" class="dropdown-item">
                          {{__('Leave Type')}}
                        </a>
                        <a href="{{ route('document.index') }}" class="dropdown-item">
                          {{__('Document Type')}}
                        </a>
                        <a href="{{ route('paysliptype.index') }}" class="dropdown-item">
                          {{__('Payslip Type')}}
                        </a>
                        <a href="{{ route('allowanceoption.index') }}" class="dropdown-item">
                          {{__('Allowance Option')}}
                        </a>
                        <a href="{{ route('loanoption.index') }}" class="dropdown-item">
                          {{__('Loan Option')}}
                        </a>
                        <a href="{{ route('deductionoption.index') }}" class="dropdown-item">
                          {{__('Deduction Option')}}
                        </a>
                        <a href="{{ route('goaltype.index') }}" class="dropdown-item">
                          {{__('Goal Type')}}
                        </a>
                        <a href="{{ route('trainingtype.index') }}" class="dropdown-item">
                          {{__('Training Type')}}
                        </a>
                        <a href="{{ route('awardtype.index') }}" class="dropdown-item">
                          {{__('Award Type')}}
                        </a>
                        <a href="{{ route('terminationtype.index') }}" class="dropdown-item">
                          {{__('Termination Type')}}
                        </a>
                        <a href="{{ route('job-category.index') }}" class="dropdown-item">
                          {{__('Job Category')}}
                        </a>
                        <a href="{{ route('job-stage.index') }}" class="dropdown-item">
                          {{__('Job Stage')}}
                        </a>
                        <a href="{{ route('performanceType.index') }}" class="dropdown-item">
                          {{__('Performance Type')}}
                        </a>
                        <a href="{{ route('competencies.index') }}" class="dropdown-item">
                          {{__('Competencies')}}
                        </a>
                    </div>
                  </div>
                </li>

              </ul>

            <div class="hamburger">
                <div class="inner_hamburger">
                    <span class="arrow">
                        <i class="ti ti-arrow-narrow-left" id="toggle-icon"></i>
                    </span>
                </div>
            </div>

        </div>
    </div>

    <div class="col-10 col-md-10 col-xs-10">

<script>
    $(document).ready(function(){
        $(".hamburger").click(function(){
          $(".wrapper").toggleClass("active")
          $("#toggle-icon").toggleClass("ti-arrow-narrow-right")
        })
    });
</script>
{{-- @include('new_layouts.footer') --}}
