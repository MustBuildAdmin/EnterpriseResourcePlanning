@include('new_layouts.header')
<style>
#create {
	height: 35px !important;
	width: 12% !important;
}

#reset{
	
	width: 12% !important;
}

#search_button {
	height: 35px !important;
	width: 12% !important;
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
                {{__('Manage Consultants')}}

            </h2>
		</div>
				<!-- Page title actions -->
				<div class="col-auto ms-auto d-print-none">
					<form action="{{ route('consultants.index') }}" method="GET">
						<div class="input-group">
							{{ Form::text('search',isset($_GET['search'])?$_GET['search']:'', array('class' => 'form-control d-inline-block w-9 me-3 mt-auto','id'=>'search','placeholder'=>__('Search by Name'))) }}
							<div class="input-group-btn">
								<button type="submit" id="search_button" class="btn btn-info"><i class="fa fa-search" aria-hidden="true"></i></button>
							{!! Form::close() !!}
							@can('create consultant')
							<a href="#" class="btn btn-primary" data-size="lg" data-url="{{ route('consultants.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create New Consultant')}}" id="create" class="btn btn-primary" id="create">
								<span class="btn-inner--icon"><i class="fa fa-plus"></i></span>
							</a>
							@endcan
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
						@if(Gate::check('edit consultant') || Gate::check('delete consultant'))
						<div class="card-header-right">
							<div class="btn-group card-option float-end"> 
								
								<button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="ti ti-dots-vertical"></i> </button>
								<div class="dropdown-menu dropdown-menu-end">
									@can('edit consultant')
									<a href="#!" data-size="lg" data-url="{{ route('consultants.edit',$user->id) }}" data-ajax-popup="true" class="dropdown-item" data-bs-original-title="{{__('Edit User')}}"> <i class="ti ti-pencil"></i> <span>{{__('Edit')}}</span> </a>
									@endcan
									@can('delete consultant')
									{!! Form::open(['method' => 'DELETE', 'route' => ['consultants.destroy', $user['id']],'id'=>'delete-form-'.$user['id']]) !!}
									<a href="#!" class="dropdown-item bs-pass-para"> <i class="ti ti-archive"></i> <span> 
										@if($user->is_deleted!=1){{__('Delete')}}
										@else {{__('Restore')}}
										@endif
									</span>
									</a>
									{!! Form::close() !!}
									@endcan
									
								</div>
								
							</div>
						</div>
						@endif
						<div class="card-body p-4 text-center">
							 @if($user->gender !='female') <img src="{{(!empty($user->avatar))? $profile.\Auth::user()->avatar : asset(Storage::url("uploads/avatar/avatar.png "))}}" class="avatar avatar-xl mb-3 rounded"> 
							 @else 
							 <img src="{{(!empty($user->avatar))? $profile.\Auth::user()->avatar : asset(Storage::url(" uploads/avatar/avatar.png "))}}" class="avatar avatar-xl mb-3 rounded"> 
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
							
						</div>
						@endif
					</div>
				</div> 
				@empty
				<div class="page-body">
					<div class="container-xl d-flex flex-column justify-content-center">
						<div class="empty">
							<div class="empty-img"><img src="{{ asset('assets/images/undraw_printing_invoices_5r4r.svg') }}" height="128" alt=""> </div>
							<p class="empty-title"> {{__('No Consultants Found')}}</p>
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
