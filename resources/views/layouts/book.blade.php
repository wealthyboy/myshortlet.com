

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8" />
      <title>{{ isset( $page_title) ?  $page_title .' |  '.config('app.name') :  $system_settings->meta_title  }}</title>
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta name="description" content="{{ isset($page_meta_description) ? $page_meta_description : $system_settings->meta_description }}">
      <meta name="keywords" content="{{ isset($system_settings->meta_tag_keywords) ? $system_settings->meta_tag_keywords : 'cleanse,detox,flattummy,flattummy tea ng,slimming tea' }}" />
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="canonical" href="{{ Config('app.url') }}">
      <!-- Favicone Icon -->
      <link rel="shortcut icon" type="image/x-icon" href="/img/favicon.ico">
      <link rel="icon" href="/img/favicon.ico" type="image/x-icon">
      <link rel="icon" type="image/png" href="/img/favicon-96x96.png">
      <link rel="apple-touch-icon" href="/img/favicon-96x96.png">
      <!-- CSS -->
      <!-- Main CSS File -->
      <link href="/css/services_style.css?version={{ str_random(6) }}" rel="stylesheet">
      @yield('page-css')
      <meta property="og:site_name" content="myshorlet.com">
      <meta property="og:url" content="https://myshortlet.com/">
      <meta property="og:title" content="myshortlet">
      <meta property="og:type" content="website">
      <meta property="og:description" content="{{ isset($page_meta_description) ? $page_meta_description : $system_settings->meta_description }}">
      <meta property="og:image:alt" content="">
      <meta name="twitter:site" content="@myshortlet">
      <meta name="twitter:card" content="summary_large_image">
      <meta name="twitter:title" content="{{ isset($page_meta_description) ? $page_meta_description : $system_settings->meta_description }}">
      <meta name="twitter:description" content="{{ isset($page_meta_description) ? $page_meta_description : $system_settings->meta_description }}">
      <script>
         Window.user = {
         	user: {!! auth()->check() ? auth()->user() : 0000 !!},
         	loggedIn: {!! auth()->check() ? 1 : 0 !!},
         	settings: {!! isset($system_settings) ? $system_settings : '' !!},
         	token: '{!! csrf_token() !!}'
         }
      </script>
   </head>
   <body>
      <nav class="navbar navbar-expand-md mb-5 navbar-dark  bg-dark">
         <a class="navbar-brand" href="/">MyShortLet</a>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbar">
            
            
         </div>
      </nav>
      <main id="app" role="main ">
         @yield('content')
      </main>
      <footer class="footer">
         
         <!--Footer Copyright Bar-->
         <section class="footer-bottom-area bg--primary">
            <div class="container">
               <div class="row">
                  <div class="col-md-12 text-center">
                     <p class="">© Copyright <a href="{{ Config('app.url') }}"> {{ Config('app.name') }}</a>   {{ date('Y') }}. All rights reserved.  
                        @if ( auth()->check() && auth()->user()->isAdmin() )
                        <a target="_blank" href="/admin" >Go to Admin</a>
                        @endif 
                     </p>
                  </div>
               </div>
            </div>
         </section>
      </footer>
      <script src="/js/services_js.js"></script>
   </body>
</html>

