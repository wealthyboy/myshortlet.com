@inject('helper', 'App\Http\Helper')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

@include('_partials.header_styles')

<body>
   <div id="app" class="appp">
      <nav class="navbar main-background  navbar-expand-lg " id="sectionsNav">
         @include('_partials.header2')
      </nav>

      <div class="main  index-page">
         @yield('content')


      </div>



      <footer class="      pt-8 pb-6 footer text-muted position-absolute bottom-0 w-100">
         <div class="container container-xxl">

            <div class="mt-0 mt-md-10 row">
               <div class="col-md-12 text-center">
                  <ul class="pull-center">
                     @foreach($footer_info as $info)
                     <li>
                        <a href="/pages/{{ $info->slug }}">
                           {{ title_case($info->title) }}
                        </a>
                     </li>
                     @endforeach
                  </ul>
               </div>
               <div class="col-md-12 copyright text-center">
                  <p class="">© Copyright Avenue Montaigne {{ date('Y') }}. All rights reserved.
                     @if ( auth()->check() && auth()->user()->isAdmin() )
                     <a target="_blank" class="text-white" href="/admin">Go to Admin</a>
                     @endif
                  </p>
               </div>
            </div>
         </div>
      </footer>

   </div>

   @include('_partials.modal')

   <script src="/js/popper.min.js" type="text/javascript"></script>
   <script src="/js/services_js.js?version={{ str_random(6) }}"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

   @yield('page-scripts')
   <script type="text/javascript">
      @yield('inline-scripts');
   </script>

</body>

</html>