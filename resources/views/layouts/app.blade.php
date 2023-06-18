@inject('helper', 'App\Http\Helper')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('_partials.header_styles')

<body>
   <div id="app" class="app">
      <nav class="navbar  navbar-fixed-top navbar-expand-lg  navbar-transparent navbar-absolute" color-on-scroll="100" id="sectionsNav">
         @include('_partials.header')
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
   </script>

</body>

</html>