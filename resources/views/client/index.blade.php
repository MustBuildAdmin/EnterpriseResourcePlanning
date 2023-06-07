@include('new_layouts.header')
<style>
	#create {
		height: 35px !important;
		width: 12% !important;
	}
	
	#search_button {
		height: 35px !important;
		width: 12% !important;
	}
	#reset{
		width: 12% !important;
	}
</style>
@include('crm.side-menu')


<div class="row">
  <div class="col-md-6">
     <h2>Manage Client</h2>
  </div>
  <div class="col-md-6 float-end">

        <form action="{{ route('clients.index') }}" method="GET">
            <div class="input-group"> 
              {{ Form::text('search',isset($_GET['search'])?$_GET['search']:'', array('class' => 'form-control d-inline-block w-9 me-3 mt-auto','id'=>'search','placeholder'=>__('Search by Name or Email'))) }}
              <div class="input-group-btn">
				
					<button type="submit" id="search_button" class="btn btn-info"><i class="fa fa-search" aria-hidden="true"></i></button>
				
			  {!! Form::close() !!}
		<a href="{{ route('clients.index') }}" id="reset" class="btn btn-danger" data-bs-toggle="tooltip" title="{{ __('Reset') }}">
			<span class="btn-inner--icon"><i class="ti ti-arrow-back"></i></span>
		</a>
		<a href="#" class="btn btn-primary" data-size="xl" data-url="{{ route('clients.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" id="create">
			<span class="btn-inner--icon"><i class="fa fa-plus"></i></span>
		</a>
       

  </div>
</div>
</div>


	<!-- Page body -->
	<div class="page-body">
		<div class="container-xl">
			<div class="row row-cards clients"> 
        @forelse($clients as $client)
				<div class="col-md-6 col-lg-3">
					<div class="card"> 
            @if(Gate::check('edit user') || Gate::check('delete user'))
						<div class="card-header-right">
							<div class="btn-group card-option float-end">
								<button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="ti ti-dots-vertical"></i> </button>
								<div class="dropdown-menu dropdown-menu-end">
									<a href="{{ route('clients.show',$client->id) }}" class="dropdown-item" data-bs-original-title="{{__('View')}}"> <i class="ti ti-eye"></i> <span>{{__('Show')}}</span> </a> 
										@can('edit client')
											<a href="#!" data-size="xl" data-url="{{ route('clients.edit',$client->id) }}" data-ajax-popup="true" class="dropdown-item" data-bs-original-title="{{__('Edit User')}}"> <i class="ti ti-pencil"></i> 
												<span>{{__('Edit')}}</span> 
											</a> 
										@endcan 
										@can('delete client') 
										{!! Form::open(['method' => 'DELETE', 'route' => ['clients.destroy', $client['id']],'id'=>'delete-form-'.$client['id']]) !!}
										<a href="#!" class="dropdown-item bs-pass-para"> <i class="ti ti-archive"></i> 
										<span> 
											@if($client->delete_status!=0)
											{{__('Delete')}} 
											@else 
											{{__('Restore')}}
											@endif
										</span> 
										</a> 
										{!! Form::close() !!} 
    								    @endcan
									<a href="#!" data-url="{{route('clients.reset',\Crypt::encrypt($client->id))}}" data-ajax-popup="true" class="dropdown-item" data-bs-original-title="{{__('Reset Password')}}"> <i class="ti ti-adjustments"></i> <span>  {{__('Reset Password')}}</span> </a>
								</div>
							</div>
						</div>
             @endif
						<div class="card-body p-4 text-center"> 
              <img src="{{(!empty($client->avatar))? asset(Storage::url(" uploads/avatar/ ".$client->avatar)): asset(Storage::url("uploads/avatar/avatar.png "))}}" class="avatar avatar-xl mb-3 rounded">
							<?php $name = strlen($client->name) > 20 ? substr($client->name,0,19)."..." : $client->name;?>
								<h3 class="m-0 mb-1"><a href="#">{{ $name }}</a></h3>
								<h5 class="m-0 mb-1">{{ $client->email }}</h5> </div>
						<div class="d-flex">
							<a data-bs-toggle="tooltip" title="@if($client->clientDeals){{$client->clientDeals->count()}}@endif" href="#" class="card-btn">
								<!-- Download SVG icon from http://tabler-icons.io/i/mail -->
								<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
									<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
									<path d="M21 10h-18"></path>
									<path d="M3 4m0 4a4 4 0 0 1 4 -4h10a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-10a4 4 0 0 1 -4 -4z"></path>
									<path d="M7 10v1.5a1.5 1.5 0 0 0 1.5 1.5h7a1.5 1.5 0 0 0 1.5 -1.5v-1.5"></path>
								</svg> {{__('Deals')}}</a>
							<a data-bs-toggle="tooltip" title="@if($client->clientProjects){{ $client->clientProjects->count() }}@endif" class="card-btn">
								<!-- Download SVG icon from http://tabler-icons.io/i/phone -->
								<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
									<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
									<path d="M12 4l-8 4l8 4l8 -4l-8 -4"></path>
									<path d="M4 12l8 4l8 -4"></path>
									<path d="M4 16l8 4l8 -4"></path>
								</svg> {{__('Projects')}}</a>
						</div>
					</div>
				</div> 
        @empty
				<div class="page-body">
					<div class="container-xl d-flex flex-column justify-content-center">
						<div class="empty">
							<div class="empty-img"><img src="{{ asset('assets/images/undraw_printing_invoices_5r4r.svg') }}" height="128" alt=""> </div>
							<p class="empty-title"> {{__('No results found')}}</p>
						</div>
					</div>
				</div> 
        @endforelse 
      </div>
			<div class="d-flex mt-4">
				<ul class="pagination ms-auto"> {!! $clients->links() !!} </ul>
			</div>
		</div>
	</div>
</div> 
@include('new_layouts.footer')