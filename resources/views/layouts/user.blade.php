

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
      <div class="wrapper dashboard-wrapper">
         <div class="d-flex flex-wrap flex-xl-nowrap">
            <div class="db-sidebar bg-white">
               <nav class="navbar navbar-expand-xl navbar-light d-block px-0 header-sticky dashboard-nav py-0">
                  <div class="sticky-area shadow-xs-1 py-3">
                     <div class="d-flex px-3 px-xl-6 w-100">
                        
                        <div class="ml-auto d-flex align-items-center ">
                           <div class="d-flex align-items-center d-xl-none">
                              <div class="dropdown px-3">
                                 <a href="/#" class="dropdown-toggle d-flex align-items-center text-heading" data-toggle="dropdown">
                                    <span class="fs-13 font-weight-500 d-none d-sm-inline ml-2">
                                    Ronald Hunter
                                    </span>
                                 </a>
                                 <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="dashboard.html#">My Profile</a>
                                    <a class="dropdown-item" href="dashboard.html#">Logout</a>
                                 </div>
                              </div>
                              <div class="dropdown no-caret py-4 px-3 d-flex align-items-center notice mr-3">
                                 <a href="#" class="dropdown-toggle text-heading fs-20 font-weight-500 lh-1" data-toggle="dropdown">
                                 <i class="far fa-bell"></i>
                                 <span class="badge badge-primary badge-circle badge-absolute font-weight-bold fs-13">1</span>
                                 </a>
                                 <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="dashboard.html#">Action</a>
                                 </div>
                              </div>
                           </div>
                           <button class="navbar-toggler border-0 px-0" type="button" data-toggle="collapse" data-target="#primaryMenuSidebar" aria-controls="primaryMenuSidebar" aria-expanded="false" aria-label="Toggle navigation">
                           <span class="navbar-toggler-icon"></span>
                           </button>
                        </div>
                     </div>
                     <div class="collapse navbar-collapse bg-white" id="primaryMenuSidebar">
                        <form class="d-block d-xl-none pt-5 px-3">
                           <div class="input-group">
                              <div class="input-group-prepend mr-0 bg-input">
                                 <button class="btn border-0 shadow-none fs-20 text-muted pr-0" type="submit"><i class="far fa-search"></i></button>
                              </div>
                              <input type="text" class="form-control border-0 form-control-lg shadow-none" placeholder="Search for..." name="search">
                           </div>
                        </form>
                        <ul class="list-group list-group-flush w-100">
                           <li class="list-group-item pt-6 pb-4">
                              <h5 class="fs-13 letter-spacing-087 text-muted mb-3 text-uppercase px-3">Main</h5>
                              <ul class="list-group list-group-no-border rounded-lg">
                                 <li class="list-group-item px-3 px-xl-4 py-2 sidebar-item">
                                    <a href="/account" class="text-heading lh-1 sidebar-link">
                                    <span class="sidebar-item-icon d-inline-block mr-3 fs-20"><i class="bi bi-gear"></i></span>
                                    <span class="sidebar-item-text">Dashboard</span>
                                    </a>
                                 </li>
                              </ul>
                           </li>
                           <li class="list-group-item pt-6 pb-4">
                              <h5 class="fs-13 letter-spacing-087 text-muted mb-3 text-uppercase px-3">Manage Listings</h5>
                              <ul class="list-group list-group-no-border rounded-lg">
                                 
                                 <li class="list-group-item px-3 px-xl-4 py-2 sidebar-item">
                                    <a href="/properties" class="text-heading lh-1 sidebar-link d-flex align-items-center">
                                       <span class="sidebar-item-icon d-inline-block mr-3 text-muted fs-20">
                                          <svg class="icon icon-my-properties">
                                             <use xlink:href="#icon-my-properties"></use>
                                          </svg>
                                       </span>
                                       <span class="sidebar-item-text">My Properties</span>
                                       <span class="sidebar-item-number ml-auto text-primary fs-15 font-weight-bold">29</span>
                                    </a>
                                 </li>
                                 <li class="list-group-item px-3 px-xl-4 py-2 sidebar-item">
                                    <a href="/favorites" class="text-heading lh-1 sidebar-link d-flex align-items-center">
                                       <span class="sidebar-item-icon d-inline-block mr-3 text-muted fs-20">
                                          <svg class="icon icon-heart">
                                             <use xlink:href="#icon-heart"></use>
                                          </svg>
                                       </span>
                                       <span class="sidebar-item-text">My Favorites</span>
                                       <span class="sidebar-item-number ml-auto text-primary fs-15 font-weight-bold">5</span>
                                    </a>
                                 </li>

                                 <li class="list-group-item px-3 px-xl-4 py-2 sidebar-item">
                                    <a href="/favorites" class="text-heading lh-1 sidebar-link d-flex align-items-center">
                                       <span class="sidebar-item-icon d-inline-block mr-3 text-muted fs-20">
                                          <svg class="icon icon-heart">
                                             <use xlink:href="#icon-heart"></use>
                                          </svg>
                                       </span>
                                       <span class="sidebar-item-text">My Reservations</span>
                                       <span class="sidebar-item-number ml-auto text-primary fs-15 font-weight-bold">5</span>
                                    </a>
                                 </li>
                              </ul>
                           </li>
                           <li class="list-group-item pt-6 pb-4">
                              <h5 class="fs-13 letter-spacing-087 text-muted mb-3 text-uppercase px-3">Manage Acount</h5>
                              <ul class="list-group list-group-no-border rounded-lg">
                                 
                                 <li class="list-group-item px-3 px-xl-4 py-2 sidebar-item">
                                    <a href="/profile" class="text-heading lh-1 sidebar-link">
                                       <span class="sidebar-item-icon d-inline-block mr-3 text-muted fs-20">
                                          <svg class="icon icon-my-profile">
                                             <use xlink:href="#icon-my-profile"></use>
                                          </svg>
                                       </span>
                                       <span class="sidebar-item-text">My Profile</span>
                                    </a>
                                 </li>
                                 <li class="list-group-item px-3 px-xl-4 py-2 sidebar-item">
                                    <a href="/change/password" class="text-heading lh-1 sidebar-link">
                                       <span class="sidebar-item-icon d-inline-block mr-3 text-muted fs-20">
                                          <svg class="icon icon-log-out">
                                             <use xlink:href="#icon-log-out"></use>
                                          </svg>
                                       </span>
                                       <span class="sidebar-item-text">Change Password</span>
                                    </a>
                                 </li>
                                 <li class="list-group-item px-3 px-xl-4 py-2 sidebar-item">
                                    <a href="#" class="text-heading lh-1 sidebar-link">
                                       <span class="sidebar-item-icon d-inline-block mr-3 text-muted fs-20">
                                          <svg class="icon icon-log-out">
                                             <use xlink:href="#icon-log-out"></use>
                                          </svg>
                                       </span>
                                       <span class="sidebar-item-text">Log Out</span>
                                    </a>
                                 </li>
                              </ul>
                           </li>
                        </ul>
                     </div>

                  </div>
               </nav>
            </div>
            <div class="page-content">
               <header class="main-header shadow-none shadow-lg-xs-1 bg-white position-relative d-none d-xl-block">
                  <div class="container-fluid">
                     <nav class="navbar navbar-light py-0 row no-gutters px-3 px-lg-0">
                        <div class="col-md-4 px-0 px-md-6 order-1 order-md-0">
                           <form>
                              <div class="input-group">
                                 <div class="input-group-prepend mr-0">
                                    <button class="btn border-0 shadow-none fs-20 text-muted p-0" type="submit"><i class="far fa-search"></i></button>
                                 </div>
                                 <input type="text" class="form-control border-0 bg-transparent shadow-none" placeholder="Search for..." name="search">
                              </div>
                           </form>
                        </div>
                        <div class="col-md-6 d-flex flex-wrap justify-content-md-end order-0 order-md-1">
                           <div class="dropdown border-md-right border-0 py-3 text-right">
                              <a href="dashboard.html#" class="dropdown-toggle text-heading pr-3 pr-sm-6 d-flex align-items-center justify-content-end" data-toggle="dropdown">
                                 <div class="mr-4 w-48px">
                                    <img src="images/testimonial-5.jpg" alt="Ronald Hunter" class="rounded-circle">
                                 </div>
                                 <div class="fs-13 font-weight-500 lh-1">
                                    Ronald Hunter
                                 </div>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right w-100">
                                 <a class="dropdown-item" href="dashboard-my-profiles.html">My Profile</a>
                                 <a class="dropdown-item" href="dashboard.html#">Logout</a>
                              </div>
                           </div>
                           <div class="dropdown no-caret py-3 px-3 px-sm-6 d-flex align-items-center justify-content-end notice">
                              <a href="dashboard.html#" class="dropdown-toggle text-heading fs-20 font-weight-500 lh-1" data-toggle="dropdown">
                              <i class="far fa-bell"></i>
                              <span class="badge badge-primary badge-circle badge-absolute font-weight-bold fs-13">1</span>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                 <a class="dropdown-item" href="dashboard.html#">Action</a>
                                 <a class="dropdown-item" href="dashboard.html#">Another action</a>
                                 <a class="dropdown-item" href="dashboard.html#">Something else here</a>
                              </div>
                           </div>
                        </div>
                     </nav>
                  </div>
               </header>
               <main id="content" class="bg-gray-01">
                  @yield('content')
               </main>
            </div>
         </div>
      </div>
      <script src="/js/services_js.js"></script>
      @include('_partials.svg')
      <div class="position-fixed pos-fixed-bottom-right p-6 z-index-10">
         <a href="home-01.html#" class="gtf-back-to-top bg-white text-primary hover-white bg-hover-primary shadow p-0 w-52px h-52 rounded-circle fs-20 d-flex align-items-center justify-content-center" title="Back To Top"><i class="fal fa-arrow-up"></i></a>
      </div>
   </body>
</html>

