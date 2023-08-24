@include('new_layouts.header')

<style>


.form-control:focus {
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
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

.form-control::placeholder {
  font-size: 0.95rem;
  color: #aaa;
  font-style: italic;
}
.avatar.avatar-xl.mb-3.user-initial {
	border-radius: 50%;
	color: #FFF;
}

.avatar-xl {
	--tblr-avatar-size: 6.2rem;
}
</style>

@php
    $profile=\App\Models\Utility::get_file('uploads/avatar/');
@endphp
<div class="container">
	<!-- For demo purpose -->
	<div class="row py-5">
	  <div class="col-lg-9 mx-auto text-white text-center">
	
	  </div>
	</div>
	<!-- End -->
  
  
	<div class="row mb-5">
	  <div class="col-lg-8 mx-auto">
	
		<div class="bg-white p-5 rounded">
  
		  <!-- Custom rounded search bars with input group -->
		  <form action="">
			<div class="p-1 bg-light rounded rounded-pill shadow-sm mb-4">
			  <div class="input-group">
				<input type="search" name="search"
				value="{{ request()->get('search') }}" placeholder="Search Consultant Name or Email" aria-describedby="button-addon1" class="form-control border-0 bg-light">
				<div class="input-group-append">
				  <button id="button-addon1" type="submit" class="btn btn-link text-primary"><i class="fa fa-search"></i></button>
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
			@forelse($users as $user)
			<div class="col-md-6 col-lg-3">
				<div class="card">
					@if(Gate::check('edit consultant') || Gate::check('delete consultant'))
					<div class="card-header-right">
						<div class="btn-group card-option float-end">
							<button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown"
							 aria-haspopup="true" aria-expanded="false">
								<i class="ti ti-dots-vertical"></i>
							</button>
								@if ($user->color_code!=null || $user->color_code!='')
										@php $color_co =$user->color_code; @endphp
								@else
										@php $color_co =Utility::rndRGBColorCode(); @endphp
								@endif
							<div class="dropdown-menu dropdown-menu-end">
								@can('edit consultant')
								<a href="#!" data-size="lg" data-url="{{ route('consultants.edit.new',[$user->id,$color_co]) }}"
									 data-ajax-popup="true" class="dropdown-item" data-bs-original-title="{{__('Edit Consultant')}}">
									 <i class="ti ti-pencil"></i>
									 <span>{{__('Edit')}}</span>
									</a>
								@endcan
								<a href="#!" data-url="{{route('consultants.reset',\Crypt::encrypt($user->id))}}"
									 data-ajax-popup="true" data-size="md" class="dropdown-item"
									 data-bs-original-title="{{__('Reset Password')}}">
									 <i class="ti ti-adjustments"></i>
									 <span>  {{__('Reset Password')}}</span>
								</a>
							</div>
						</div>
					</div> @endif
					<div class="card-body p-4 text-center">
						<?php  $short=substr($user->name, 0, 1);?>
							<?php  $short_lname=substr($user->lname, 0, 1);?>
							 @if(!empty($user->avatar))
								 <img src="{{(!empty($user->avatar))? $profile.\Auth::user()->avatar :
								 asset(Storage::url(" uploads/avatar/avatar.png "))}}" class="avatar avatar-xl mb-3 rounded" alt="">
							  @else
									
									<div class="avatar avatar-xl mb-3 user-initial" style='background-color:{{$color_co}}'>
										{{strtoupper($short)}}{{strtoupper($short_lname)}}
									</div>
							  @endif
								<?php $name = strlen($user->name) > 20 ? substr($user->name,0,19)."..." : $user->name;?>
									<h3 class="m-0 mb-1">
								<a href="#">{{ $name }}</a>
							</h3>
						</div>
						@if(\Auth::user()->type != 'super admin')
					<div class="d-flex">
						<a data-bs-toggle="tooltip" data-copy_email="{{ $user->email }}" title="{{ $user->email }}"
							 href="#" class="card-btn" onclick="copyToClipboard(this)">
							<!-- Download SVG icon from http://tabler-icons.io/i/mail -->
							<svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24"
							 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
							  stroke-linecap="round" stroke-linejoin="round">
								<path stroke="none" d="M0 0h24v24H0z" fill="none" />
								<path d="M3 5m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
								<path d="M3 7l9 6l9 -6" /> </svg> {{__('Email')}} </a>
						<a data-bs-toggle="tooltip" data-copy_phone="{{ $user->phone }}" title="{{ $user->phone }}"
							 class="card-btn" onclick="copyToClipboardphone(this)">
							<!-- Download SVG icon from http://tabler-icons.io/i/phone -->
							<svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24"
							 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
							  stroke-linecap="round" stroke-linejoin="round">
								<path stroke="none" d="M0 0h24v24H0z" fill="none" />
								<path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15
								 -15a2 2 0 0 1 2 -2" /> </svg> {{__('Mobile')}}
						</a>
					</div>
					@else
					<div class="row justify-content-between align-items-center"> </div>
					@endif
				</div>
			</div>
			@empty
			<div class="page-body">
				<div class="container-xl d-flex flex-column justify-content-center">
					<div class="empty">
						<div class="empty-img">
							<img src="{{ asset('assets/images/undraw_printing_invoices_5r4r.svg') }}" height="128" alt="">
						</div>
						<p class="empty-title"> {{__('No Consultants Found')}}</p>
					</div>
				</div>
			</div> @endforelse </div>
	
	</div>
  
	</div>
  </div>
@include('new_layouts.footer')
<script>
function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  copy_email = $(element).data('copy_email');
  $temp.val(copy_email).select();
  document.execCommand("copy");
  $temp.remove();
  toastr.info("Copying to clipboard was successful!");
}
function copyToClipboardphone(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  copy_phone = $(element).data('copy_phone');
  $temp.val(copy_phone).select();
  document.execCommand("copy");
  $temp.remove();
  toastr.success("Copying to clipboard was successful!");
}

$(document).on('keypress', function (e) {
        if (e.which == 13) {
            swal.closeModal();
        }
});
</script>
