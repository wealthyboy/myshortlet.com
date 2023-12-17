@inject('helper', 'App\Http\Helper')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

@include('_partials.header_styles')

<body>
   <div id="app" class="app">
      <nav class="navbar  navbar-fixed-top navbar-expand-lg  navbar-transparent navbar-absolute" color-on-scroll="100" id="sectionsNav">
         @include('_partials.header', ['show_logo' => true])
      </nav>
      <div id="content" class="main  index-page">
         @yield('content')

      </div>
      @include('_partials.footer')
      </footer>
   </div>



   @include('_partials.modal')


   <div class="watsapp pt-3">
      <a class="chat-on-watsapp" target="_blank" href="https://wa.me/{{ $system_settings->store_phone }}">
         Need help? Chat with us <i class="fab fa-whatsapp fa-2x float-right mr-2"></i></a>
   </div>

   <script src="/js/services_js.js"></script>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.5/waypoints.min.js"></script>

   @yield('page-scripts')
   <script type="text/javascript">
      @yield('inline-scripts')


      jQuery(function() {
         $(".test-carousel").owlCarousel({
            margin: 1,
            nav: true,
            dots: true,
            responsive: {
               0: {
                  items: 1,
               },
               600: {
                  items: 1,
               },
               1000: {
                  items: 1,
               },
            },
         });
      });
   </script>

</body>

</html>