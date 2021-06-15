

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
      <div id="app" class="app">
      <header class="main-header navbar-light header-sticky header-sticky-smart header-mobile-xl">
         <div class="sticky-area">
            <div class="container container-xxl">
               <nav class="navbar navbar-expand-xl px-0 w-100">
                  <a class="navbar-brand mr-7" href="/">
                  <img src="{{ $system_settings->logo_path() }}" alt="myshortlet logo" class="d-none d-xl-inline-block">
                  <img src="{{ $system_settings->logo_path() }}" alt="myshortlet logo" class="d-inline-block d-xl-none">
                  </a>
                  <div class="d-flex d-xl-none ml-auto">
                     <a class="d-block mr-4 position-relative text-white p-2" href="/">
                     <i class="fal fa-heart fs-large-4"></i>
                     <span class="badge badge-primary badge-circle badge-absolute">1</span>
                     </a>
                     <button class="navbar-toggler border-0 px-0 ml-0" type="button" data-toggle="collapse" data-target="#primaryMenu05" aria-controls="primaryMenu05" aria-expanded="false" aria-label="Toggle navigation">
                     <span class="text-white fs-24"><i class="fal fa-bars"></i></span>
                     </button>
                  </div>
                  <div class="collapse navbar-collapse mt-3 mt-xl-0 flex-grow-0" id="primaryMenu05">
                     <ul class="navbar-nav hover-menu main-menu px-0 mx-xl-n4"> 
                     </ul>
                     <div class="d-block d-xl-none">
                        <ul class="navbar-nav flex-row ml-auto align-items-center justify-content-lg-end flex-wrap py-2">
                           <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle mr-md-2 pr-2 pl-0 pl-lg-2" href="home-07.html#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              ENG
                              </a>
                              
                           </li>
                           <li class="nav-item mr-2">
                              <a class="btn btn-lg text-heading border bg-hover-primary border-hover-primary hover-white d-none d-lg-block mr-2" href="/listing">
                              Add listing
                              </a>
                           </li>
                           <li class="nav-item ">
                              <a class="btn btn-lg text-heading border bg-hover-primary border-hover-primary hover-white d-none d-lg-block mr-2" href="/login">
                              Login
                              </a>
                           </li>
                           <li class="nav-item">
                              <a class="btn btn-lg text-heading border bg-hover-primary border-hover-primary hover-white d-none d-lg-block" href="/register">
                              Register
                              </a>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="ml-auto d-none d-xl-block">
                     <ul class="navbar-nav flex-row ml-auto align-items-center justify-content-lg-end flex-wrap py-2">
                        <li class="nav-item dropdown">
                           <a class="nav-link dropdown-toggle mr-md-2 pr-2 pl-0 pl-lg-2" href="home-07.html#" id="bd-versions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           NGN
                           </a>
                           <div class="dropdown-menu dropdown-sm dropdown-menu-right" aria-labelledby="bd-versions">
                              <a class="dropdown-item" href="home-07.html#">VN</a>
                              <a class="dropdown-item active" href="home-07.html#">ENG</a>
                              <a class="dropdown-item" href="home-07.html#">ARB</a>
                              <a class="dropdown-item" href="home-07.html#">KR</a>
                              <a class="dropdown-item" href="home-07.html#">JN</a>
                           </div>
                           
                        </li>
                        <li class="nav-item">
                           <a class="btn btn-lg text-heading border bg-hover-primary border-hover-primary hover-white d-none d-lg-block mr-2" href="/listings">
                           <i class="fal fa-building"></i> Add listing
                           </a>
                        </li>
                        <li class="nav-item">
                           <a class="btn btn-lg text-heading border bg-hover-primary border-hover-primary hover-white d-none d-lg-block mr-2" href="/login">
                           <i class="fal fa-sign-in"></i> Login
                           </a>
                        </li>
                        <li class="nav-item">
                           <a class="btn btn-lg text-heading border bg-hover-primary border-hover-primary hover-white d-none d-lg-block" href="/register">
                           <i class="fal fa-user-plus"></i> Register
                           </a>
                        </li>
                     </ul>
                  </div>
               </nav>
            </div>
         </div>
      </header>
      <main id="content">
         @yield('content')
      </main>
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
            
      <script src="/js/services_js.js"></script>
      <script src="/js/app.js"></script>
      @include('_partials.svg')
      <div class="position-fixed pos-fixed-bottom-right p-6 z-index-10">
         <a href="home-01.html#" class="gtf-back-to-top bg-white text-primary hover-white bg-hover-primary shadow p-0 w-52px h-52 rounded-circle fs-20 d-flex align-items-center justify-content-center" title="Back To Top"><i class="fal fa-arrow-up"></i></a>
      </div>
   </body>
</html>

