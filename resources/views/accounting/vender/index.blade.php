@include('new_layouts.header')
<div class="page-wrapper"> 
    @include('accounting.side-menu', ['hrm_header' => 'Manage Vendors'])
	<div class="col d-flex flex-column">
		<div class="card-body">
			<div class="col-xl-12 col-lg-12 col-sm-12">
				<div class="card">
					<div class="card-body">
						<h6 class="text-center mb-0">{{ __('content1') }}</h6> </div>
				</div>
			</div>
		</div>
	</div> 
</div>