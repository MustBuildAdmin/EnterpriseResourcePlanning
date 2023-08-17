<footer class="footer footer-transparent d-print-none">
	<div class="container-xl">
		<div class="row text-center align-items-center flex-row-reverse">
			<ul class="list-inline list-inline-dots mb-0">
				<li class="list-inline-item"> {{(Utility::getValByName('footer_text')) ? Utility::getValByName('footer_text') :  __('Copyright Must BuildApp') }} {{ date('Y') }}
					<a href="." class="link-secondary"></a>
				</li>
			</ul>
		</div>
	</div>
</footer>
</div>
</div>
<!-- Libs JS -->
<script src="{{ asset('assets/dist/js/demo-theme.min.js?1674944402') }}"></script>
<script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap.min.js"></script>
<script src="{{ asset('assets/js/chosenjquery/chosen.jquery.js') }}"></script>
<script src="{{ asset('js/jquery.validate.js') }}"></script>

<script>
// 	var oTable = $('.datatable').dataTable( {
//     "aoColumnDefs": [
//         { "bSortable": false, "aTargets": [ 1, 2, 3 ] }, 
//         { "bSearchable": false, "aTargets": [ 0, 1, 2, 3 ] }
//     ]
// }); 
</script>
<!-- Libs JS -->
<script>
// feather.replace();
</script>
<script>
(function($) {
	"use strict";
	var fullHeight = function() {
		$('.js-fullheight').css('height', $(window).height());
		$(window).resize(function() {
			$('.js-fullheight').css('height', $(window).height());
		});
	};
	fullHeight();
	$('#sidebarCollapse').on('click', function() {
		$('#sidebar').toggleClass('active');
	});
})(jQuery);
</script>
<script src="{{ asset('assets/dist/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/dist/libs/jsvectormap/dist/js/jsvectormap.min.js') }}"></script>
<script src="{{ asset('assets/dist/libs/jsvectormap/dist/maps/world.js') }}"></script>
<script src="{{ asset('assets/dist/libs/jsvectormap/dist/maps/world-merc.js') }}"></script>
<!-- Tabler Core -->
<script src="{{ asset('assets/dist/js/tabler.min.js') }}"></script>
<script src="{{ asset('assets/dist/js/demo.min.js') }}"></script>
<!-- <script src='https://kit.fontawesome.com/a076d05399.js'></script> -->

<script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>

@if (App\Models\Utility::getValByName1('gdpr_cookie') == 'on')
    <script type="text/javascript">
        var defaults = {
            'messageLocales': {
                /*'en': 'We use cookies to make sure you can have the best experience on our website. If you continue to use this site we assume that you will be happy with it.'*/
                'en': "{{ App\Models\Utility::getValByName1('cookie_text') }}"
            },
            'buttonLocales': {
                'en': 'Ok'
            },
            'cookieNoticePosition': 'bottom',
            'learnMoreLinkEnabled': false,
            'learnMoreLinkHref': '/cookie-banner-information.html',
            'learnMoreLinkText': {
                'it': 'Saperne di più',
                'en': 'Learn more',
                'de': 'Mehr erfahren',
                'fr': 'En savoir plus'
            },
            'buttonLocales': {
                'en': 'Ok'
            },
            'expiresIn': 30,
            'buttonBgColor': '#d35400',
            'buttonTextColor': '#fff',
            'noticeBgColor': '#000000',
            'noticeTextColor': '#fff',
            'linkColor': '#009fdd'
        };
        
    </script>
    <script src="{{ asset('js/cookie.notice.js') }}"></script>
@endif
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
@if(Session::has('success'))
<script>

  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.success("{{ session('success') }}");

</script>
@endif

@if(Session::has('error'))
<script>
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.error("{{ session('error') }}");
</script>
@endif
<script>
    toastr.options = {
  "closeButton": true,
  "progressBar": true,
  };


  jQuery.validator.addMethod("validate_email", function(value, element) {

if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
    return true;
} else {
    return false;
}

}, "Please enter a valid Email.");

jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
phone_number = phone_number.replace(/\s+/g, "");
return this.optional(element) || phone_number.length > 9 ;
}, "Please specify a valid phone number");

$(document).on("click", 'input[type=submit]', function () {

$(this).closest('form').validate({
rules: {
    email: {
        validate_email: true
    },
    company_email: {
        validate_email: true
    },
    contact: {
            phoneUS: true
    },
    phone: {
            phoneUS: true
    },
}
});
});

$(document).on("keyup", 'input[type=date]', function () {
var tt= $(this).val().length;
if(tt>10){
        $(this).val('');
        show_toastr('error', 'Please enter valid date');
        // Swal.fire({
        //     position: 'top-end',
        //     icon: 'error',
        //     title: 'Oops...',
        //     text: 'Please enter a valid date!'
        // })
}
setTimeout(
    function()
    {
            $('#error').text('');
    }, 8000);
});
</script>

<style>
li.select2-search.select2-search--inline {
    display: none;
}
</style>
</body>
</html>
