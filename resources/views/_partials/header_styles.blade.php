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


   <style>
      #currencyDropdown {
         position: relative;
      }

      #currencyDropdown .currency-selector {
         display: inline-flex;
         align-items: center;
         justify-content: center;
         gap: 0.55rem;
         min-width: 122px;
         padding: 0.9rem 1rem;
         text-transform: none;
         white-space: nowrap;
         border-radius: 10px;
      }

      #currencyDropdown .currency-flag {
         width: 24px;
         height: 16px;
         object-fit: cover;
         border-radius: 2px;
         flex: 0 0 auto;
         box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.08);
      }

      #currencyDropdown .currency-code {
         font-size: 1rem;
         font-weight: 700;
         letter-spacing: 0.02em;
      }

      #currencyDropdown .currency-menu {
         min-width: 0;
         width: 280px;
         max-width: calc(100vw - 32px);
         margin-top: 0.65rem;
         padding: 0.35rem 0.5rem;
         border-radius: 12px;
         border: 1px solid rgba(0, 0, 0, 0.08);
         box-shadow: 0 18px 36px rgba(0, 0, 0, 0.16);
         left: 0 !important;
         right: auto !important;
         top: 100% !important;
         transform: none !important;
         z-index: 1060;
      }

      #currencyDropdown .currency-option {
         display: flex;
         align-items: center;
         gap: 0.7rem;
         padding: 0.7rem 0.5rem !important;
      }

      #currencyDropdown .currency-option > span {
         display: flex;
         flex-direction: column;
         line-height: 1.15;
      }

      #currencyDropdown .currency-option small {
         display: block;
         margin-top: 0.2rem;
         opacity: 0.72;
      }

      @media (max-width: 575.98px) {
         #currencyDropdown .currency-selector {
            min-width: 118px;
            padding: 0.85rem 0.95rem;
         }

         #currencyDropdown .currency-menu {
            width: min(280px, calc(100vw - 32px));
            max-width: calc(100vw - 32px);
         }
      }
   </style>

   @include('_partials.browser_currency_detection')

</head>