@inject('helper', 'App\Http\Helper')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   @include('_partials.header_styles')

   <body>
      <div id="app"  class="appp">
         <nav class="navbar   navbar-expand-lg " id="sectionsNav">
            @include('_partials.header')

         </nav>
         
         <div style="background-color: #f8f5f4;" class="main  index-page">
            @yield('content')
         </div>
         @include('_partials.footer')
      </div>

      @include('_partials.modal')

      <script
         src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_map.key') }}&v=weekly&channel=2"  async ></script>

      <script src="/js/popper.min.js" type="text/javascript"></script>
      <script src="/js/services_js.js?version={{ str_random(6) }}"></script>
      @yield('page-scripts')    
      <script type="text/javascript">
        @yield('inline-scripts')
      </script>
  
   </body>

</html>

