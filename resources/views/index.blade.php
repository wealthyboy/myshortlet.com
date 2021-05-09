@include('fashion._partials.header_styles')



<body class="">
   <div id="app" class="page-wrapper">
      <header class="header  fixed-top">
         <div class="header-middle ">
            <div class="container">
               <div class="header-left w-lg-max ml-auto ml-lg-0">
                  <div class="header-icon header-search header-search-inline header-search-category">
                     <a href="#" class="search-toggle mr-1" role="button"><i class="icon-search-3 "></i></a>
                     <form action="/search" method="get">
                        <div class="header-search-wrapper">
                        </div>
                        <!-- End .header-search-wrapper -->
                     </form>
                  </div>
                  <!-- End .header-search -->
               </div>
               <!-- End .header-left -->
               <div class="header-center order-first order-lg-0 ml-0 ml-lg-auto">
                  <button class="mobile-menu-toggler" type="button">
                  <i class="icon-menu"></i>
                  </button>
                  <a href="/" class="logo">
                  <img src="{{ $system_settings->logo_path() }}" alt="{{ Config('app.name') }} Logo">
                  </a>
               </div>
               <!-- End .header-center -->
               <div class="header-right w-lg-max ml-0 ml-lg-auto"></div>
            </div>
            <!-- End .container -->
         </div>
         <!-- End .header-middle -->
         <div class="header-bottom sticky-header d-none d-lg-block">
            <div class="container">
               <nav class="main-nav d-flex w-lg-max mt-2 justify-content-center">
                  <ul class="menu">
                     <li>
                        <a href="">Fashion</a>
                     </li>
                     <li>
                        <a href="">Apartments</a>
                     </li>
                  </ul>
               </nav>
            </div>
            <!-- End .container -->
         </div>
         <!-- End .header-bottom -->
      </header>
      <!-- End .header -->
      <main class="main main-page">
        <div class="container-fliud mt-3">
          <div  class="row align-items-start ">
              <div class="col-md-6 col-12    p-0 pr-1 pl-1  mb-1  p-0 text-center">
                  <div class="banner-box">
                      <a class="portfolio-thumb" href="/fashion">
                          <img src="https://avenuemontaigne.ng/uploads/LbTofMzhmOJE9MkpDGTba2uCmB7Y2yYtGew0uZPJ.jpg" alt="" />
                      </a>
                  </div>
              </div> 
              <div class="col-md-6 col-12   p-0 pr-1 pl-1  mb-1  p-0 text-center">
                  <div class="banner-box">
                      <a class="portfolio-thumb" href="/services">
                          <img src="https://avenuemontaigne.ng/uploads/3ljHDEzjFhTKex6vIwz7B404M0Xxu1SvW024cDEt.jpg" alt="" />
                      </a>
                  </div>
              </div>
          </div>
        </div>
      </main>
      <footer class="footer">
         <div class="footer-bottom text-center">
            <div class="container d-flex justify-content-center align-items-center flex-wrap">
               <p class="footer-copyright py-3 pr-4 mb-0">©.AvenueMontaigne {{ date('Y') }}. All Rights Reserved</p>
            </div>
            <!-- End .container -->
         </div>
         <!-- End .footer-bottom -->
      </footer>
   </div>
   <!-- End .page-wrapper -->
   <div class="mobile-menu-overlay"></div>
   <!-- End .mobil-menu-overlay -->
   <div class="mobile-menu-container">
      <div class="mobile-menu-wrapper">
         <span class="mobile-menu-close"><i class="icon-cancel"></i></span>
         <nav class="mobile-nav">
            <ul class="mobile-menu">
               <li>
                  <a href="">Fashion</a>
               </li>
               <li>
                  <a href="">Apartments</a>
               </li>
            </ul>
         </nav>
         <!-- End .mobile-nav -->
      </div>
      <!-- End .mobile-menu-wrapper -->
   </div>
   <!-- End .mobile-menu-container -->



	



	<!-- Plugins JS File -->
	<script src="/f/js/app.js?version={{ str_random(6) }}" type="text/javascript"></script>
</body>
</html>










