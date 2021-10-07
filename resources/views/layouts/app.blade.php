
@inject('helper', 'App\Http\Helper')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   @include('_partials.header_styles')
   <body>
      <div id="app"  class="app">
         <nav class="navbar navbar-color-on-scroll fixed-top navbar-expand-lg navbar-transparent" color-on-scroll="100" id="sectionsNav">
            @include('_partials.header')
         </nav>
         <div class="main  index-page">
            @yield('content')
         </div>
         @include('_partials.footer')

      </footer>
      </div>

   

      @include('_partials.modal')


       

      <script src="/js/popper.min.js" type="text/javascript"></script>
      <script src="/js/services_js.js"></script>

      @yield('page-scripts')    
      <script type="text/javascript">
        @yield('inline-scripts')
      </script>
  
   </body>

</html>

