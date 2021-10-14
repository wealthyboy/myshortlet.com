@inject('helper', 'App\Http\Helper')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   @include('_partials.header_styles')

   <body>
      <div id="app"  class="app">
         <nav class="navbar   navbar-expand-lg " id="sectionsNav">
            @include('_partials.header')
         </nav>
         
         <div style="background-color: #f8f5f4;" class="main  index-page">
            @yield('content')
         </div>
         <footer class="bg-dark pt-8 pb-6 footer text-muted">
         <div class="container container-xxl">
            <div class="row">
               @foreach($footer_info as $info)
               <div class="col-md-6 col-lg-2 mb-6 mb-md-0">
                  <h4 class="text-white fs-16 my-4 font-weight-500">{{ title_case($info->title) }}</h4>
                  @if($info->children->count())
                     <ul class="list-group list-group-flush list-group-no-border">
                        @foreach($info->children as $info)
                        <li class="list-group-item bg-transparent p-0">
                           <a href="home-01.html#" class="text-muted lh-26 font-weight-500 hover-white">{{ $info->title }}</a>
                        </li>
                        @endforeach
                     </ul>
                  @endif

               </div>
               @endforeach
            </div>
            <div class="mt-0 mt-md-10 row">
               <div class="col-md-12 text-center">
                  <p class="">© Copyright <a href="{{ Config('app.url') }}"> {{ Config('app.name') }}</a>   {{ date('Y') }}. All rights reserved.  
                     @if ( auth()->check() && auth()->user()->isAdmin() )
                     <a target="_blank" href="/admin" >Go to Admin</a>
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
      @yield('page-scripts')    
      <script type="text/javascript">
        @yield('inline-scripts')
      </script>
  
   </body>

</html>

