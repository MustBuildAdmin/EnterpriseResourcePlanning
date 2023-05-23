@include('new_layouts.header')
<style>
#create {
	height: 35px !important;
}

#search_button {
	height: 35px !important;
}

.dropdown-toggle::after {
    display: none;
    position: absolute;
    top: 50%;
    right: 20px;
}

</style>
@php
   // $profile=asset(Storage::url('uploads/avatar/'));
    $profile=\App\Models\Utility::get_file('uploads/avatar');
@endphp
<div class="page-wrapper">
	<!-- Page header -->



	<div class="page-header d-print-none">
		<div class="container-xl">
			<div class="row g-2 align-items-center">
				<div class="col">
				<h2 class="page-title">
                {{__('Manage User')}}

            </h2>
		</div>
				<!-- Page title actions -->
				<div class="col-auto ms-auto d-print-none">
					<form action="{{ route('users.index') }}" method="GET">
						<div class="input-group">
							{{ Form::text('search',isset($_GET['search'])?$_GET['search']:'', array('class' => 'form-control d-inline-block w-9 me-3 mt-auto','id'=>'search','placeholder'=>__('Search by Name'))) }}
							<div class="input-group-btn">
								<button type="submit" id="search_button" class="btn btn-info"><i class="fa fa-search" aria-hidden="true"></i></button>
							{!! Form::close() !!}
								<a href="#" data-size="lg" data-url="{{ route('users.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create New User')}}" id="create" class="btn btn-primary">

					<!-- Download SVG icon from http://tabler-icons.io/i/plus -->
					<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
						<path stroke="none" d="M0 0h24v24H0z" fill="none" />
						<path d="M12 5l0 14" />
						<path d="M5 12l14 0" /> </svg>{{__('Create New User')}} </a>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Page body -->
	<div class="page-body">
		<div class="container-xl">
			<div class="row row-cards">
				@forelse($users as $user)
				<div class="col-md-6 col-lg-3">
					<div class="card">
						@if(Gate::check('edit user') || Gate::check('delete user'))
						<div class="card-header-right">
							<div class="btn-group card-option float-end"> 
								@if($user->is_active==1)
								<button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="ti ti-dots-vertical"></i> </button>
								<div class="dropdown-menu dropdown-menu-end">
									@can('edit user')
									<a href="#!" data-size="lg" data-url="{{ route('users.edit',$user->id) }}" data-ajax-popup="true" class="dropdown-item" data-bs-original-title="{{__('Edit User')}}"> <i class="ti ti-pencil"></i> <span>{{__('Edit')}}</span> </a>
									@endcan
									@can('delete user')
									{!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user['id']],'id'=>'delete-form-'.$user['id']]) !!}
									<a href="#!" class="dropdown-item bs-pass-para"> <i class="ti ti-archive"></i> <span> 
										@if($user->delete_status!=0){{__('Delete')}}
										@else {{__('Restore')}}
										@endif
									</span>
									</a>
									{!! Form::close() !!}
									@endcan
									<a href="#!" data-url="{{route('users.reset',\Crypt::encrypt($user->id))}}" data-ajax-popup="true" data-size="md" class="dropdown-item" data-bs-original-title="{{__('Reset Password')}}"> <i class="ti ti-adjustments"></i> <span>  {{__('Reset Password')}}</span> </a>
								</div>
								@else
								<a href="#" class="action-item"><i class="ti ti-lock"></i></a>
								@endif
							</div>
						</div>
						@endif
						<div class="card-body p-4 text-center">
							 @if($user->gender !='female') <img src="{{(!empty($user->avatar))? $profile.\Auth::user()->avatar : asset(Storage::url(" uploads/avatar/avatar.png "))}}" class="avatar avatar-xl mb-3 rounded"> 
							 @else 
							 <img src="{{(!empty($user->avatar))? $profile.\Auth::user()->avatar : asset(Storage::url(" uploads/avatar/avatarfemale.png "))}}" class="avatar avatar-xl mb-3 rounded"> 
							 @endif
							<?php $name = strlen($user->name) > 20 ? substr($user->name,0,19)."..." : $user->name;?>
								<h3 class="m-0 mb-1"><a href="#">{{ $name }}</a></h3>
								<div class="text-muted text-center" data-bs-toggle="tooltip" title="{{__('Last Login')}}">@if(!empty($user->last_login_at)) {{ $user->last_login_at }} @else  <br> @endif</div>
								<div class="mt-3"> <span class="badge bg-purple-lt"> {{ ucfirst($user->type) }}</span> </div>
						</div>
						@if(\Auth::user()->type != 'super admin')
						<div class="d-flex">
							
							<a data-bs-toggle="tooltip" data-copy_email="{{ $user->email }}" title="{{ $user->email }}" href="#" class="card-btn" onclick="copyToClipboard(this)">
								<!-- Download SVG icon from http://tabler-icons.io/i/mail -->
								<svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
									<path stroke="none" d="M0 0h24v24H0z" fill="none" />
									<path d="M3 5m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
									<path d="M3 7l9 6l9 -6" />
								</svg>
								{{__('Email')}}
							</a>
							
							<a data-bs-toggle="tooltip" data-copy_phone="{{ $user->phone }}" title="{{ $user->phone }}" class="card-btn" onclick="copyToClipboardphone(this)">
								<!-- Download SVG icon from http://tabler-icons.io/i/phone -->
								<svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
									<path stroke="none" d="M0 0h24v24H0z" fill="none" />
									<path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
								</svg>
									{{__('Mobile')}}
							</a>
						</div>
						@else
						<div class="row justify-content-between align-items-center">
							<div class="col-6 text-center"> 
								<span class="d-block font-bold mb-0">{{!empty($user->currentPlan)?$user->currentPlan->name:''}}</span> 
							</div>
							<div class="col-6 text-center Id "> 
								<a href="#" data-url="{{ route('plan.upgrade',$user->id) }}" data-size="lg" data-ajax-popup="true" class="btn btn-outline-primary" data-title="{{__('Upgrade Plan')}}">{{__('Upgrade Plan')}}</a> 
							</div>
							<div class="col-12">
								<hr class="my-3"> 
							</div>
							<div class="col-12 text-center pb-2"> 
								<span class="text-dark text-xs">{{__('Plan Expired : ') }} {{!empty($user->plan_expire_date) ? \Auth::user()->dateFormat($user->plan_expire_date): __('Unlimited')}}</span> 
							</div>
						</div>
						<div class="d-flex">
							<a href="#" class="card-btn" title="{{__('Users')}}">
								<!-- Download SVG icon from http://tabler-icons.io/i/mail --><i class="ti ti-users card-icon-text-space"></i> {{$user->totalCompanyUser($user->id)}}</a>
							<a href="#" class="card-btn" title="{{__('Customers')}}">
								<!-- Download SVG icon from http://tabler-icons.io/i/mail --><i class="ti ti-users card-icon-text-space"></i> {{$user->totalCompanyCustomer($user->id)}}</a>
							<a href="#" class="card-btn" title="{{__('Vendors')}}">
								<!-- Download SVG icon from http://tabler-icons.io/i/phone --><i class="ti ti-users card-icon-text-space"></i> {{$user->totalCompanyVender($user->id)}}</a>
						</div>
						@endif
					</div>
				</div> 
				@empty
				<div class="page-body">
					<div class="container-xl d-flex flex-column justify-content-center">
						<div class="empty">
							<div class="empty-img"><img src="{{ asset('assets/images/undraw_printing_invoices_5r4r.svg') }}" height="128" alt=""> </div>
							<p class="empty-title"> {{__('No User Found')}}</p>
						</div>
					</div>
				</div> 
				@endforelse 
			</div>
			<div class="d-flex mt-4">
				<ul class="pagination ms-auto"> {!! $users->links() !!} </ul>
			</div>
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
