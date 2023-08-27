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
		  <form action="" id="myForm">
			<div class="p-1 bg-light rounded rounded-pill shadow-sm mb-4">
			  <div class="input-group">
				<input type="search" id="scott_search" name="search" value="{{ request()->get('search') }}" placeholder="Search Consultant Name or Email or Mobile" aria-describedby="button-addon1" class="form-control border-0 bg-light">
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
	
	<div id="content_id">
	</div>
	</div>
  </div>
  </div>
</div>
</div>
@include('new_layouts.footer')
<script>
	$(document).on('keyup', '#scott_search', function () {
		console.log("1",1);

	var tempcsrf = '{!! csrf_token() !!}';

	var search = $(this).val();

	if ($('input[name="search"]').val().length >= 3) {
		console.log("2",2);
	$.ajax({

		type: "POST",
		url: "{{ route('consultant.scott-result') }}",
		data: {
			_token: tempcsrf,
			search: search,
		},
		cache: false,
		success: function(data) {

			// $('form#myForm').submit();
			$("#content_id").html(data.html);
	console.log("fhhhf",data.html);

		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			alert("Error: " + errorThrown);
		}
	});
}

	});
	</script>


