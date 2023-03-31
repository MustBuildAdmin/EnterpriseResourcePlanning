<footer class="footer footer-transparent d-print-none">
	<div class="container-xl">
		<div class="row text-center align-items-center flex-row-reverse">
			<ul class="list-inline list-inline-dots mb-0">
				<li class="list-inline-item"> {{(Utility::getValByName('footer_text')) ? Utility::getValByName('footer_text') :  __('Copyright ERPGO') }} {{ date('Y') }}
					<a href="." class="link-secondary"></a>
				</li>
			</ul>
		</div>
	</div>
</footer>
</div>
</div>
<!-- Libs JS -->

<!-- Libs JS -->
<script>
feather.replace();
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
</body>

</html>