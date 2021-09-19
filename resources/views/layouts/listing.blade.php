
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
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

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
      <div id="app"  class="app">
         <nav class="navbar  fixed-top navbar-expand-lg " id="sectionsNav">
            <div class="container">
               <div class="navbar-translate">
               <a href="/" class="navbar-brand">

                  <div class="logo-small">
                         <img src="{{ $system_settings->logo_path() }}" class="img-fluid">
                  </div>
               </a>
               <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="navbar-toggler-icon"></span>
                  <span class="navbar-toggler-icon"></span>
                  <span class="navbar-toggler-icon"></span>
               </button>
               </div>
               <div class="collapse navbar-collapse">
                  <ul class="navbar-nav ml-auto">
                     <li class="active nav-item">
                     <a href="javascript:;" class="nav-link">
                        <i class="material-icons">gite</i>
       
                        Become a host
                     </a>
                     </li>
                     <li class="nav-item">
                       <a href="javascript:;" class="nav-link">
                          <i class="material-icons">attach_money</i>
                       </a>
                     </li>
                     @guest

                     <li class="nav-item">
                        <a href="/login" class="nav-link">
                           <i class="material-icons">login</i>
                           Login
                        </a>
                     </li>
                     @endguest

                     @auth
                     <li class="dropdown nav-item">
                        <a href="#" class="profile-photo dropdown-toggle nav-link" data-toggle="dropdown">
                           <div class="profile-photo-small">
                              <img src="/images/svg/baseline_person_outline_black_24dp.png" alt="Circle Image" class="rounded-circle img-fluid">
                           </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                           <a href="/account" class="dropdown-item">Account</a>
                           <a href="/profile" class="dropdown-item">Profile</a>
                           <a href="/bookings" class="dropdown-item">Bookings</a>
                           <a href="#" onclick="event.preventDefault();
                                    document.getElementById('logout-form-nav').submit();"
                                     class="dropdown-item">
                              <i class="material-icons">logout</i>
    
                              Sign out
                           </a>
                           <form id="logout-form-nav" action="/logout" method="POST" style="display: none;">
                                    @csrf
                                </form>

                        </div>
                     </li>
                     @endauth

                  </ul>
               </div>
            </div>
         </nav>
         
         <div class="main  index-page">
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

      <script src="/js/popper.min.js" type="text/javascript"></script>
      <script src="/js/services_js.js"></script>
      @yield('page-scripts')    
      <script type="text/javascript">
        @yield('inline-scripts')
      </script>
  
   </body>

</html>

