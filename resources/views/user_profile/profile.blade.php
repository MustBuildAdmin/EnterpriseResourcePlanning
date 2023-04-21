@include('new_layouts.header')
@php
$users=\Auth::user();
$profile=\App\Models\Utility::get_file('uploads/avatar/');
@endphp
<style>
#avatar{
	display:none;  
  }
</style>
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
			  {{Form::model($userDetail,array('route' => array('new_edit_profile'), 'method' => 'post', 'enctype' => "multipart/form-data"))}}
			  @csrf
			  <div class="row align-items-center">
				<div class="col-auto"><span class="avatar avatar-xl" ><img src="{{(!empty(\Auth::user()->avatar))? $profile.\Auth::user()->avatar: asset(Storage::url("uploads/avatar/avatar.png"))}}" class="img-fluid rounded-circle"></span>
				</div>
				<div class="col-auto">
					<input type="file" class="form-control file" name="profile" id="avatar" data-filename="profile_update" accept="image/png, image/jpg,image/jpeg,image/webp">
					<button type="button" class="btn" id='input_btn'>
						{{ __('Change Profile') }}
				  </button>
				</div>
				@if($get_logo->avatar!=null)
				<div class="col-auto">
					<input type="hidden" id="user_id" value="{{ $userDetail->id }}">
					<a href="#" class="btn btn-ghost-danger" id="checkdelete">
						{{ __('Delete Profile') }}
				  </a>
				</div>
				@endif
			  </div>
			  <div class="col-lg-6 col-md-6">
				<div class="form-group">
					
					<span class="text-xs text-muted">{{ __('Please upload a valid image file. Size of image should not be more than 2MB.')}}</span>
					@error('avatar')
					<span class="invalid-feedback text-danger text-xs" role="alert">{{ $message }}</span>
					@enderror
				</div>
			</div>
			  <br>
			 
			  <div class="row g-3">
				<div class="col-md">
				  <div class="form-label">{{__('Name')}}</div>
				  <input class="form-control" disabled type="text" placeholder="{{ __('Enter Your Name') }}" value="{{ $userDetail->name }}" required autocomplete="name">
				  <input class="form-control @error('name') is-invalid @enderror" hidden name="name" type="text" id="name" maxlength="120" placeholder="{{ __('Enter Your Name') }}" value="{{ $userDetail->name }}" required autocomplete="name">
				  @error('name')
				  <span class="invalid-feedback text-danger text-xs" role="alert">{{ $message }}</span> 
				  @enderror 
				</div>
				<div class="col-md">
				  <div class="form-label">{{__('Email')}}</div>
				  <input class="form-control" disabled type="text" placeholder="{{ __('Enter Your Email Address') }}" value="{{ $userDetail->email }}" >
				  <input class="form-control @error('email') is-invalid @enderror" name="email"  type="text" id="email" placeholder="{{ __('Enter Your Email Address') }}" value="{{ $userDetail->email }}"  autocomplete="email" hidden>
				  @error('email')
				  <span class="invalid-feedback text-danger text-xs" role="alert">{{ $message }}</span> 
				  @enderror
				</div>
			  </div>
			</div>
			<div class="card-footer bg-transparent mt-auto">
			  <div class="btn-list justify-content-end">
				{{-- <a class="btn" href="{{route('new_home')}}" >Back </a> --}}
				<input type="submit" value="{{__('Save Changes')}}" class="btn btn-print-invoice  btn-primary m-r-10" id="change">
			  </div>
			</div>
			{{Form::close()}}
		  </div>
		</div>
	  </div>
	</div>
  </div>
  <script>
	document.getElementById("input_btn").addEventListener('click',function(){
	document.getElementById("avatar").click();  
	},false);

	$('#checkdelete').on('click', function(e) {
  		
  		var user_id=$("#user_id").val();
  			// if (confirm("Are you sure?")) {
  			var form = $(this).closest("form");
  			const swalWithBootstrapButtons = Swal.mixin({
  				customClass: {
  					confirmButton: 'btn btn-success',
  					cancelButton: 'btn btn-danger'
  				},
  				buttonsStyling: false
  			})
  			swalWithBootstrapButtons.fire({
  				title: 'Are you sure?',
  				text: "It will delete if you take this action. Do you want to continue?",
  				icon: 'warning',
  				showCancelButton: true,
  				confirmButtonText: 'Yes',
  				cancelButtonText: 'No',
  				reverseButtons: true
  			}).then((result) => {

  				if (result.isConfirmed) {

  					

  					$.ajax({
  						url: "{{route('delete_new_profile')}}",
  						method: 'POST',
  						headers: {
  							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  						},
  						data: 'user_id=' + user_id,
  						success: function(data) {
							if (data['status'] == true) {
  								location.reload();

								  toastr.success('{{ __("Profile Picture Deleted Successfully!")}}');
							}
  							
  						},
  						error: function(data) {
  							alert(data.responseText);
  						}
  					});

  				} else if (
  					result.dismiss === Swal.DismissReason.cancel
  				) {}
  			})


  		
  	});


</script>
  @include('new_layouts.footer')
