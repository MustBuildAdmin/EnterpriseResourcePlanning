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
				<a href="{{route('new_profile')}}" class="list-group-item list-group-item-action d-flex align-items-center active">{{__('Personal Info')}}</a>
				<a href="{{route('view_change_password')}}" class="list-group-item list-group-item-action d-flex align-items-center">{{__('Change Password')}}</a>
			  </div>
			</div>
		  </div>
		  <div class="col d-flex flex-column">
			<div class="card-body">
			  <h2 class="mb-4">{{ __('Personal Info') }}</h2>
			  <h3 class="card-title"></h3>

			  <div class="card-body">

				<div class="row align-items-center">
					<div id="personal_info" class="">
						<div class="card-body">
							{{Form::model($userDetail,array('route' => array('new_edit_profile'), 'method' => 'post', 'enctype' => "multipart/form-data"))}}
							@csrf
							<div class="row">
								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
										<label class="col-form-label text-dark">{{__('Name')}}</label>
										<input class="form-control @error('name') is-invalid @enderror" name="name" type="text" id="name" maxlength="120" placeholder="{{ __('Enter Your Name') }}" value="{{ $userDetail->name }}" required autocomplete="name">
										@error('name')
										<span class="invalid-feedback text-danger text-xs" role="alert">{{ $message }}</span> @enderror </div>
								</div>
								<div class="col-lg-6 col-sm-6">
									<div class="form-group">
										<label for="email" class="col-form-label text-dark">{{__('Email')}}</label>
										<input class="form-control @error('email') is-invalid @enderror" name="email" type="text" id="email" placeholder="{{ __('Enter Your Email Address') }}" value="{{ $userDetail->email }}" required autocomplete="email">
										@error('email')
										<span class="invalid-feedback text-danger text-xs" role="alert">{{ $message }}</span> @enderror </div>
								</div>
								<div class="col-lg-6 col-md-6">
									<div class="form-group">
										<div class="choose-files">
											<label for="avatar">
												<br>
												<br>
												<input type="file" class="form-control file" name="profile" id="avatar" data-filename="profile_update" accept="image/png, image/jpg,image/jpeg,image/webp"> </label>
										</div>
										<span class="text-xs text-muted">{{ __('Please upload a valid image file. Size of image should not be more than 2MB.')}}</span>
										@error('avatar')
										<span class="invalid-feedback text-danger text-xs" role="alert">{{ $message }}</span>
										@enderror
									</div>
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
				<input type="submit" value="{{__('Save Changes')}}" class="btn btn-print-invoice  btn-primary m-r-10">
			  </div>
			</div>
			{{Form::close()}}
		  </div>
		</div>
	  </div>
	</div>
  </div>
  @include('new_layouts.footer')
