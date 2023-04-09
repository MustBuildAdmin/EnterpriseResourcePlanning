@include('new_layouts.header')
@php
$profile=\App\Models\Utility::get_file('uploads/avatar/');
@endphp
<div class="page-body">
	<div class="container-xl">
	  <div class="card">
		<div class="row g-0">
		  <div class="col-3 d-none d-md-block border-end">
			<div class="card-body">
			  <h4 class="subheader">{{ __('Profile') }}</h4>
			  <div class="list-group list-group-transparent">
				<a href="{{route('new_profile')}}" class="list-group-item list-group-item-action d-flex align-items-center">{{__('Personal Info')}}</a>
				<a href="{{route('view_change_password')}}" class="list-group-item list-group-item-action d-flex align-items-center active">{{__('Change Password')}}</a>
			  </div>
			</div>
		  </div>
		  <div class="col d-flex flex-column">
			<div class="card-body">
			  <h2 class="mb-4">{{ __('Change Password') }}</h2>
			  <h3 class="card-title"></h3>

			  <div class="card-body">

				<div class="row align-items-center">
					<div id="personal_info" class="">
						<div class="card-body">
							<form method="post" action="{{route('newpassword')}}">
								@csrf
							<div class="row g-3">
							  <div class="col-md">
								<div class="form-label">{{ __('Old Password') }}</div>
								<input class="form-control @error('old_password') is-invalid @enderror" name="old_password" type="password" id="old_password" required autocomplete="old_password" placeholder="{{ __('Enter Old Password') }}"> @error('old_password')
									<span class="invalid-feedback text-danger text-xs" role="alert">{{ $message }}</span> @enderror
							  </div>
							  <div class="col-md">
								<div class="form-label">{{ __('New Password') }}</div>
								<input class="form-control @error('password') is-invalid @enderror" name="password" type="password" required autocomplete="new-password" id="password" placeholder="{{ __('Enter Your Password') }}"> @error('password')
									<span class="invalid-feedback text-danger text-xs" role="alert">{{ $message }}</span> @enderror
							  </div>
							  <div class="col-md">
								<div class="form-label">{{ __('New Confirm Password') }}</div>
								<input class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" type="password" required autocomplete="new-password" id="password_confirmation" placeholder="{{ __('Enter Your Password') }}">
							  </div>
							</div>

						</div>
					</div>
				</div>
			</div>

			</div>
			<div class="card-footer bg-transparent mt-auto">
			  <div class="btn-list justify-content-end">
				{{-- <a class="btn" href="{{route('new_home')}}" >Back </a> --}}
				<input type="submit" value="{{__('Change Password')}}" class="btn btn-print-invoice  btn-primary m-r-10">
			  </div>
			</div>
		</form>
		  </div>
		</div>
	  </div>
	</div>
  </div>
  @include('new_layouts.footer')
