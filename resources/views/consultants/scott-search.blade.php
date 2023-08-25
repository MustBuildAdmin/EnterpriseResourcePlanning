@include('new_layouts.header')
<style>
.page-wrapper {
	margin: 20px;
}

#invite {
	height: 35px !important;
	width: 12% !important;
}

#search_button {
	height: 35px !important;
	width: 12% !important;
}

.avatar.avatar-xl.mb-3.user-initial {
	border-radius: 50%;
	color: #FFF;
}

.avatar-xl {
	--tblr-avatar-size: 6.2rem;
}

form-control:focus {
	box-shadow: none;
}

.form-control-underlined {
	border-width: 0;
	border-bottom-width: 1px;
	border-radius: 0;
	padding-left: 0;
}

.fa {
	display: inline-block;
	font: normal normal normal 14px;
	font-size: inherit;
	text-rendering: auto;
	margin-top: 8px;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
}

.form-control::placeholder {
	font-size: 0.95rem;
	color: #aaa;
	font-style: italic;
}
</style>
@php
    $profile=\App\Models\Utility::get_file('uploads/avatar/');
@endphp

<div class="page-wrapper">
  <div class="row">
    <div class="col-md-6">
      <h2>{{ __('Invite Consultants') }}</h2>
    </div>
    <div class="col-md-6">
      <div class="col-auto ms-auto d-print-none float-end">
        <div class="input-group-btn">
          <a id="invite" href="{{ route('consultants.index') }}" class="btn btn-danger" data-bs-toggle="tooltip" title="{{ __('Back') }}">
            <span class="btn-inner--icon">
              <i class="fa fa-arrow-left"></i>
            </span>
          </a>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
	<!-- For demo purpose -->
	
	<!-- End -->
	<div class="row mb-5">
	  <div class="col-lg-8 mx-auto">
		<div class="bg-white p-5 rounded">
		  <!-- Custom rounded search bars with input group -->
		  <form action="">
			<div class="p-1 bg-light rounded rounded-pill shadow-sm mb-4">
			  <div class="input-group">
				<input type="search" name="search" value="{{ request()->get('search') }}" placeholder="Search Consultant Name or Email or Mobile" aria-describedby="button-addon1" class="form-control border-0 bg-light">
				<div class="input-group-append">
				  <button id="button-addon1" type="submit" class="btn btn-link text-primary">
					<i id="search_icon" class="fa fa-search"></i>
				  </button>
				</div>
			  </div>
			</div>
		  </form>
		  <!-- End -->
		</div>
	  </div>
	</div>
	<div class="container-xl">
	  <div class="row row-cards"> 
		@forelse($users as $user) <div class="col-md-6 col-lg-3">
		  <div class="card"> 
			@if ($user->color_code!=null || $user->color_code!='') 
			@php $color_co =$user->color_code; @endphp 
			@else 
			@php $color_co =Utility::rndRGBColorCode(); @endphp 
			@endif <div class="card-body p-4 text-center"> <?php  $short=substr($user->name, 0, 1);?> <?php  $short_lname=substr($user->lname, 0, 1);?> @if(!empty($user->avatar)) <img src="{{(!empty($user->avatar))? $profile.\Auth::user()->avatar :
								   asset(Storage::url(" uploads/avatar/avatar.png "))}}" class="avatar avatar-xl mb-3 rounded" alt=""> @else <div class="avatar avatar-xl mb-3 user-initial" style='background-color:{{$color_co}}'>
				{{strtoupper($short)}}{{strtoupper($short_lname)}}
			  </div> @endif <?php $name = strlen($user->name) > 20 ? substr($user->name,0,19)."..." : $user->name;?> <h3 class="m-0 mb-1">
				<a href="#">{{ $name }}</a>
			  </h3>
			</div> @if(\Auth::user()->type != 'super admin') <div class="d-flex">
			  <a data-bs-toggle="tooltip" data-copy_email="{{ $user->email }}" title="{{ $user->email }}" href="#" class="card-btn" onclick="copyToClipboard(this)">
				<!-- Download SVG icon from http://tabler-icons.io/i/mail -->
				<svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
				  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
				  <path d="M3 5m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
				  <path d="M3 7l9 6l9 -6" />
				</svg> {{__('Email')}}
			  </a>
			  <a data-bs-toggle="tooltip" data-copy_phone="{{ $user->phone }}" title="{{ $user->phone }}" class="card-btn" onclick="copyToClipboardphone(this)">
				<!-- Download SVG icon from http://tabler-icons.io/i/phone -->
				<svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
				  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
				  <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15
								   -15a2 2 0 0 1 2 -2" />
				</svg> {{__('Mobile')}}
			  </a>
			</div>
			@else
			<div class="row justify-content-between align-items-center"></div>
			@endif 
		</div>
		</div>
		@empty
		
		@endforelse
	</div>
	</div>
  </div>
  </div>
</div>
</div>
@include('new_layouts.footer')

