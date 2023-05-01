@include('new_layouts.header')
<div class="page-wrapper"> 
    @include('crm.side-menu', ['hrm_header' => 'Manage Contract'])
	<div class="col d-flex flex-column">
		<div class="card-body">
			<div class="col-xl-12 col-lg-12 col-sm-12">
				<div class="card">
					<div class="card-body">
						<h6 class="text-center mb-0">{{ __('content') }}</h6> </div>
				</div>
			</div>
		</div>
	</div> 
    {{-- @include('new_layouts.footer') --}}