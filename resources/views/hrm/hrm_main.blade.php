@include('new_layouts.header')
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
                      HR Admin Setup
                    </a>
                    <div class="dropdown-menu">
                      <a href="{{url('award')}}" class="dropdown-item">
                        Award
                      </a>
                      <a href="{{url('transfer')}}" class="dropdown-item">
                        Transfer
                      </a>
                      <a href="{{url('resignation')}}" class="dropdown-item">
                        Resignation
                      </a>
                      <a href="{{url('travel')}}" class="dropdown-item">
                        Trip
                      </a>
                      <a href="{{url('promotion')}}" class="dropdown-item">
                        Promotion
                      </a>
                      <a href="{{url('complaint')}}" class="dropdown-item">
                        Complaints
                      </a>
                      <a href="{{url('warning')}}" class="dropdown-item">
                        Warning
                      </a>
                      <a href="{{url('termination')}}" class="dropdown-item">
                        Termination
                      </a>
                      <a href="{{url('announcement')}}" class="dropdown-item">
                        Announcement
                      </a>
                      <a href="{{url('holiday')}}" class="dropdown-item">
                        Holidays
                      </a>
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
                <li>
                    <a href="{{url('hrm_doc_setup')}}" class="">
                      <span class="icon"><i class="ti ti-certificate"></i>
                      </span>
                      <span class="list">Document Setup</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{url('hrm_company_policy')}}" class="">
                      <span class="icon">  <i class="ti ti-clipboard-text"></i>
                      </span>
                      <span class="list">Company Policy</span>
                    </a>
                  </li>
                  <li>
                    <a href="#" class="">
                      <span class="icon">  <i class="ti ti-tool"></i>

                      </span>
                      <span class="list">Resource Settings</span>
                    </a>
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
