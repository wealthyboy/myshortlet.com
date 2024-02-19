@inject('helper', 'App\Http\Helper')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

@include('_partials.header_styles')

<body>
   <div id="app" class="appp">
      <nav class="navbar   navbar-expand-lg " id="sectionsNav">
         @include('_partials.header2')
      </nav>

      <div class="main  index-page">
         @yield('content')


      </div>



      @include('_partials.footer')
   </div>

   @include('_partials.modal')
   <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_map.map') }}&v=weekly&channel=2" async></script>

   <script src="/js/popper.min.js" type="text/javascript"></script>
   <script src="/js/services_js.js?version={{ str_random(6) }}"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

   @yield('page-scripts')
   <script type="text/javascript">
      @yield('inline-scripts');
   </script>

</body>

</html>