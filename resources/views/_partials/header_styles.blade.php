<head>
   <meta charset="utf-8" />
   <title>{{ isset( $page_title) ?  $page_title .' |  '.config('app.name') :  optional($system_settings)->meta_title  }}</title>
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <meta name="description" content="{{ isset($page_meta_description) ? $page_meta_description : optional($system_settings)->meta_description }}">
   <meta name="keywords" content="{{ isset($system_settings->meta_tag_keywords) ? optional($system_settings)->meta_tag_keywords : 'Luxury concierge services, Luxury Service Apartments Lagos, Nigeria, personal assistants, event planning, travel arrangements, exclusive experiences, Lagos, Nigeria, 5-Star Apartments Lagos, Elegant Apartments in Lagos, Luxury Housing Lagos, Nigeria , High-End Real Estate Lagos,  Nigeria, Luxury Stay Lagos, Nigeria, Lagos Premium Housing' }}" />
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <link rel="canonical" href="{{ Config('app.url') }}">
   <!-- Favicone Icon -->
   <!-- Favicon -->
   <link rel="icon" type="image/x-icon" href="/images/favicon_io/favicon-32x32.png">
   <link rel="shortcut icon" type="image/x-icon" href="/images/favicon_io/favicon.ico">
   <link rel="icon" href="/images/favicon_io/favicon.ico" type="image/x-icon">
   <link rel="apple-touch-icon" href="/images/favicon_io/apple-touch-icon.png">
   <!-- Main CSS File -->
   <!-- CSS -->
   <!-- Main CSS File -->
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Nanum+Myeongjo&display=swap" rel="stylesheet">

   <link href="/css/services_style.css?version={{ str_random(6) }}" rel="stylesheet">
   <link href="/css/banner.css?version={{ str_random(6) }}" rel="stylesheet">
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />



   @yield('page-css')
   <meta property="og:site_name" content="avenuemontaigne.com">
   <link rel="preconnect" href="https://fonts.googleapis.com">

   <meta property="og:url" content="https://avenuemontaigne.ng/">
   <meta property="og:title" content="avenuemontaigne">
   <meta property="og:type" content="website">
   <meta property="og:description" content="{{ isset($page_meta_description) ? $page_meta_description : optional($system_settings)->meta_description }}">
   <meta property="og:image:alt" content="">
   <meta name="twitter:site" content="@avenuemontaigne">
   <meta name="twitter:card" content="summary_large_image">
   <meta name="twitter:title" content="{{ isset($page_meta_description) ? $page_meta_description : optional($system_settings)->meta_description }}">
   <meta name="twitter:description" content="{{ isset($page_meta_description) ? $page_meta_description : optional($system_settings)->meta_description }}">
   <script src="/js/popper.min.js"></script>

   <script>
      Window.user = {

      }
   </script>

   <!-- Google tag (gtag.js) -->
   <script async src="https://www.googletagmanager.com/gtag/js?id=G-HF8HXV7C7C"></script>
   <script>
      window.dataLayer = window.dataLayer || [];

      function gtag() {
         dataLayer.push(arguments);
      }
      gtag('js', new Date());

      gtag('config', 'G-HF8HXV7C7C');
   </script>


</head>