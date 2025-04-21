@inject('helper', 'App\Http\Helper')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('_partials.header_styles')


<body>
   <div id="app" class="appp">


      <nav class="navbar  navbar-fixed-top navbar-expand-lg  navbar-transparent navbar-absolute" color-on-scroll="100" id="sectionsNav">
         @include('_partials.header', ['show_logo' => true, 'show_book' => false])
      </nav>

      <div style="background-color: #f8f5f4;" class="main  index-page">
         @yield('content')
      </div>

      @include('_partials.footer')
   </div>

   @include('_partials.modal')

   <script src="/js/popper.min.js" type="text/javascript"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
   <script src="/js/services_js.js?version={{ str_random(6) }}"></script>
   @yield('page-scripts')
   <script type="text/javascript">
      @yield('inline-scripts');
   </script>

   <script>
      let currencyDropdown = document.getElementById('currencyDropdown');
      if (currencyDropdown) {
         currencyDropdown.addEventListener('click', function() {
            this.classList.add('show');
            this.querySelector('.dropdown-menu').classList.add('show');
         });
      }
   </script>

</body>

</html>