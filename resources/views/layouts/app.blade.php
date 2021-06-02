

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
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark mb-3">
         <a class="navbar-brand" href="/">MyShortLet</a>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav ml-auto">
               <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">NGN</a>
                  <div class="dropdown-menu" aria-labelledby="dropdown01">
                     <a class="dropdown-item" href="#">USD</a>
                     <a class="dropdown-item" href="#">GBP</a>
                     <a class="dropdown-item" href="#">EUR</a>
                  </div>
               </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
               <a href="/listings" target="_blank" class="btn btn-outline-success my-2 my-sm-0" type="submit">List your property</a>
               @if ( !auth()->check() )
                  <a href="/login" class="btn btn-outline-success my-2 my-sm-0" type="submit">Login</a>
                  <a href="/register" class="btn btn-outline-success my-2 my-sm-0" type="submit">Register</a>
               @else
                 <ul class="nav navbar-nav ml-auto">
                     <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Account</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown01">
                           <a class="dropdown-item" href="/account">
                           <span class="sidebar-item-icon d-inline-block mr-3 text-muted fs-10">
                              <i class="bi bi-box-arrow-in-right"></i>
                           </span>
                           
                           Profile</a>
                           <a class="dropdown-item"
                           onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                              <span class="sidebar-item-icon d-inline-block mr-3 text-muted fs-20">
                                                <i class="bi bi-box-arrow-in-right"></i>
                                             </span>                                            
                                            Logout
                                        </a>
                                        <form id="logout-form" action="/logout" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                        </div>
                     </li>
                  </ul>
               @endif
            </form>
         </div>
      </nav>
      <main role="main">
         @yield('content')
      </main>
      <footer class="footer">
         <div class="footer-middle">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-lg-12 col-md-8">
                     <div class="row pt-3">
                        @foreach($footer_info as $info)
                        <div class="col-sm-3 col-6 col-lg-3">
                           <div class="widget">
                              <h4 class="widget-title">{{ title_case($info->title) }}</h2>
                              @if($info->children->count())
                              <ul class="">
                                 @foreach($info->children as $info)
                                 <li>
                                    <a href="{{ $info->link }}">
                                    {{ $info->title }}
                                    </a>
                                 </li>
                                 @endforeach
                              </ul>
                              @endif
                           </div>
                           <!-- End .widget -->
                        </div>
                        <!-- End .col-sm-6 -->
                        @endforeach
                     </div>
                     <!-- End .row -->
                  </div>
                  <!-- End .col-lg-9 -->
               </div>
               <!-- End .row -->
            </div>
            <!-- End .container -->
         </div>
         <!-- End .footer-middle -->
        
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

