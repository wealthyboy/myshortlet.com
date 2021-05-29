

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
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
         <a class="navbar-brand" href="/">Navbar</a>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav ml-auto">
               <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                  <div class="dropdown-menu" aria-labelledby="dropdown01">
                     <a class="dropdown-item" href="#">Action</a>
                     <a class="dropdown-item" href="#">Another action</a>
                     <a class="dropdown-item" href="#">Something else here</a>
                  </div>
               </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
               <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Login</button>
               <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Register</button>
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
                              <h2 class="widget-title">{{ title_case($info->title) }}</h2>
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
         <section class="footer-widget-area">
            <div class="container">
               <div class="row">
                  <div class="footer-widget col-5 col-lg-6  mb-lg-0 mb-3">
                     <h5 class=" widget-title  text-uppercase ">Follow Us</h5>
                     <div class="social-icons">
                        <a  href="{{ $system_settings->facebook_link }}"><i class="fab fa-facebook-f fa-2x mr-5"></i></a>
                        <a  href="{{  $system_settings->instagram_link }}"><i class="fab fa-instagram fa-2x mr-5"></i></a>
                        <a  href="{{  $system_settings->twitter_link}} "><i class="fab fa-twitter fa-2x"></i></a>
                     </div>
                  </div>
                  <div class="footer-widget  col-7  col-lg-6 mb-lg-0 mb-3">
                     <h5 class="widget-title text-uppercase">Payments</h5>
                     <ul class="payment-icons  icons">
                        <li class="mastercard">
                           <img   src="{{ asset('img/business.png') }}" alt="Master card" /> 
                        </li>
                        <li class="visa">
                           <img  src="{{ asset('img/visa.png') }}" alt="visa card" />
                        </li>
                        <li class="verve">
                           <img  src="{{ asset('img/verve1.png') }}" alt="verve card" /> 
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </section>
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

