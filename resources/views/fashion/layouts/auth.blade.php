@include('fashion._partials.header_styles')

<body>
	<div id="app" class="page-wrapper">
		

		<main class="main bg--gray">
		   <div class="header-middle d-flex ">
				<div class="container">
					<div class="header-center justify-content-center order-first order-lg-0 ml-0 mt-3">
						<a href="/" class="logo">
							<img src="{{ $system_settings->logo_path() }}" alt="{{ Config('app.name') }} Logo">
						</a>
					</div><!-- End .header-center -->
				</div><!-- End .container -->
			</div><!-- End .header-middle -->
			
          @yield('content')
        </main> 
        <footer>
            <div class="footer-bottom">
				<div class="container d-flex justify-content-center align-items-center flex-wrap">
					<p class="footer-copyright py-3 pr-4 mb-0">© {{ config('app.name') }}. 2020. All Rights Reserved</p>
				</div><!-- End .container -->
			</div><!-- End .footer-bottom -->
        </footer>
    </div><!-- End .page-wrapper -->

	<div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->


	

	

	<a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>

	<!-- Plugins JS File -->
    <script src="/f/js/app.js?version={{ str_random(6) }}" type="text/javascript"></script>
	<!-- Main JS File -->
    @yield('page-scripts')
    <script type="text/javascript">
        @yield('inline-scripts')
    </script>
</body>
</html>










