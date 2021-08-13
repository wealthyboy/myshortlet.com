<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  
  <title>{{ Config('app.name') }}  Coming soon</title>
        <meta name="author" content="AchuWorld">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="{{ isset($page_meta_description) ? $page_meta_description : '' }}">
        <meta name="keywords" content="{{ isset($settings->meta_tag_keywords) ? $settings->meta_tag_keywords : '' }}" />
        <meta name="generator" content="Social Likes: http://social-likes.js.org/">

  

  <!-- Favicon -->
  <link rel="icon" href="favicon.png" type="image/png">
  <link rel="apple-touch-icon" href="apple-touch-icon.png">
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="/maintainance/css/plugins/bootstrap.min.css">

  <!-- Font Icons -->
  <link rel="stylesheet"
        href="/maintainance/css/icons/font-awesome.css">
  <link rel="stylesheet"
        href="/maintainance/css/icons/linea.css">

  <!-- Google Fonts -->
  <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700">

  <!-- Plugins CSS -->
  <link rel="stylesheet" href="/maintainance/css/plugins/loaders.min.css">
  <link rel="stylesheet" href="/maintainance/css/plugins/photoswipe.css">
  <link rel="stylesheet" href="/maintainance/css/icons/photoswipe/icons.css">


  <!-- Custom CSS -->
  <link rel="stylesheet" href="/maintainance/css/style.css">

  <!-- Responsive CSS -->
  <link href="/maintainance/css/responsive.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>
<body data-spy="scroll" data-target=".scrollspy" class="bg-dark show-content full-info">

<!-- Preloader  -->
<div class="loader bg-dark">
  <div class="loader-inner ball-scale-ripple-multiple ball-scale-ripple-multiple-color">
    <div></div>
    <div></div>
    <div></div>
  </div>
</div>
<!-- /End Preloader  -->


<div id="page">

  <!-- ============================
       BG & Overlays
  ================================= -->

  <!-- Image BG -->
  <div class="section-overlay media page-image-full reveal scale-in"></div>
  <!-- /End Image BG -->

  <!-- Overlay BG -->
  <div class="section-overlay bg-black overlay-opacity"></div>
  <!-- /End Overlay BG -->

  <!-- Modal -->
  <div id="modal-notify" class="modal fade modal-scale" tabindex="-1" role="dialog"
       aria-labelledby="meinModalLabel">

    <!-- .modal-dialog -->
    <div class="modal-dialog" role="document">
      <div>

        <!-- .modal-content -->
        <div class="modal-content text-center bg-dark text-light">
          <button class="button-close" data-dismiss="modal" aria-label="Close"><i
              class="icon icon-lg icon-arrows-remove"></i></button>


          <!-- Headline -->
          <div class="wrap-line border-dark">
            <h3><span class="font-weight-200">Stay</span> Tuned</h3>
          </div>
          <!-- /End Headline -->

          <!-- Description -->
          <div class="p-t-b-15">
            <p>We launch our new website soon.<br>
              Please stay updated and follow.</p>
          </div>
          <!-- /End Description -->

          <div class="p-t-b-30">

            <!-- Newsletter Form:
             alternative newsletter form via email;
             write your email in newsletter-process.php and use:
             <form action="php/newsletter-process.php" id="newsletter-form" method="post"> insted of
             <form id="mc-form"> -->
            <form id="mc-form">

              <!-- Input Group -->
              <div class="input-group">
                <input type="email" id="email" class="form-control form-control-light"
                       name="email"
                       placeholder="Enter your Email here...">
                  <span class="input-group-btn">
                    <button type="submit" class="btn btn-color"><i
                        class="icon icon-sm icon-arrows-slim-right-dashed"></i>
                    </button>
                  </span>
              </div>
              <!-- /End Input Group -->

              <!-- Message Alert -->
              <div id="message-newsletter" class="message-wrapper text-white message">

                <span><i class="icon icon-sm icon-arrows-slim-right-dashed"></i><label
                    class="message-text" for="email"></label></span>
              </div>
              <!-- /End Message Alert -->

            </form>
            <!-- /End Newsletter Form -->

          </div>
        </div>

      </div>
      <!-- /End .modal-content -->
    </div>
    <!-- /End .modal-dialog -->
  </div>
  <!-- /End Modal -->

  <!-- ============================
       Header Navigation
  ================================= -->

  <header>
    <nav class="navbar navbar-fixed-top">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6 text-white col-transform">
            <div class="navbar-wrapper">

              <!-- Navbar Links -->
              <div class="navbar-links scrollspy">
                <ul class="nav">
                  <li><a class="smooth-scroll link-white" href="#about">About</a></li>
                  <li><a class="smooth-scroll link-white" href="#contact">Contact</a></li>
                </ul>
              </div>
              <!-- /End Navbar Links -->

            </div>
          </div>
        </div>
      </div>
    </nav>
  </header>

  <div class="container-fluid">
    <div class="row">


      <!-- ============================
           Info
      ================================= -->

      <div id="info" class="col-md-6 text-white text-center page-info col-transform">
        <div class="vert-middle">
          <div class="reveal scale-out">

            <!-- Count Down -->
            <!-- <div class="count-down p-t-b-15" data-end-date="May 30, 2021 00:00:00">
            </div> -->
            <!-- /End Count Down -->

            <!-- Logo -->
            <!-- <div class="p-t-b-15">
              <img src="images/logo.png" height="60" width="49" alt="">
            </div> -->
            <!-- /End Logo -->

            <div class="p-t-b-15">
              <!-- Headline & Description -->
              <h2><span class="font-weight-200">Our Website</span><br>is coming soon</h2>

              
              <!-- /End Headline & Description -->
            </div>
            <!-- Arrow -->
            <div class="p-t-b-20">
              <i class="icon icon-sm icon-arrows-slim-down-dashed"></i>
            </div>
            <!-- /End Arrow -->

            <!-- Buttons -->
            <div class="p-t-b-15 btn-row">
              <button class="btn btn-color" data-toggle="modal"
                      data-target="#modal-notify"
                      role="button">Notify me
              </button>
            </div>
            <!-- /End Buttons -->

            <!-- Social Media Links -->
            <!-- <div class="p-t-b-30">
              <p>
                <a href="https://www.facebook.com/#" class="link-white"><i
                    class="fa fa-facebook"></i></a>
                <a href="https://twitter.com/#" class="link-white"><i
                    class="fa fa-twitter"></i></a>
                
              </p>
            </div> -->
            <!-- Social Media Links -->

          </div>
        </div>
      </div>


      <!-- ============================
           Content
      ================================= -->

      <div id="content" class="page-content col-md-6 text-center bg-white-09">

        <!-- ----------------------------
             About Section
        --------------------------------- -->

        <section id="about" class="p-t-b-30">
          <div class="row">
            <div class="col-sm-8 col-sm-offset-2">

              <!-- Headline -->
              <div class="wrap-line border-dark">
                <h3><span class="font-weight-200">About</span> Us</h3>
              </div>
              <!-- /End Headline -->

              <!-- Description -->
              <div class="p-t-b-15  text-grey">
                <p>We are a privately owned hospitality real estate firm developing real  estate products for the hospitality and short-let market.  <br/>

We also broker and work with real estate developers and hospitality brands in the budget, mid-market and full service hotel sector. Seeking to establish their presence in the local market. <br/>
Our properties are developed wholly-owned or via our rent-to-use solutions.<br/>
Our backgrounds of extensive global hospitality and real estate experience and reliable access to local and international finance, helps us to engage in transactions of varying sizes and complexity and is totally committed to delivering the highest standards of service to its partners, stakeholders and clients 
<br>
                  </p>
              </div>
              <!-- /End Description -->

              <!-- Social Media Links -->
              <!-- <div class="p-t-b-15">
                <p>
                  <a href="https://www.facebook.com/#" target="_blank">
                    <i class="fa fa-facebook"></i></a>
                  <a href="https://twitter.com/#" target="_blank">
                    <i class="fa fa-twitter"></i></a>
                  <a href="https://www.instagram.com/#" target="_blank">
                    <i class="fa fa-instagram"></i></a>
                </p>
              </div> -->
              <!-- /End Social Media Links -->

            </div>
          </div>

          <!-- Gallery -->
          <div class="gallery row no-gutters p-t-b-30">

            <!-- Image 1 -->
            <figure class="col-xs-6 img-hover-effect">
              <a href="/maintainance/images/page-image-5.jpg"
                 data-size="900x600">
                <img class="img-responsive" src="/maintainance/images/page-image-5.jpg"
                     alt="Image description"/>
              </a>

              <span class="img-title"></span>
              <span class="img-description"></span>
              <span class="img-overlay"></span>
            </figure>
            <!-- /End Image 1 -->

            <!-- Image 2 -->
            <figure class="col-xs-6 img-hover-effect">
              <a href="/maintainance/images/page-image-6.jpg"
                 data-size="900x600">
                <img class="img-responsive" src="/maintainance/images/page-image-6.jpg"
                     alt="Image description"/>
              </a>

              <span class="img-title"></span>
              <span class="img-description"></span>
              <span class="img-overlay"></span>
            </figure>
            <!-- /End Image 2 -->

            <!-- Image 3 -->
            <figure class="col-xs-6 img-hover-effect">
              <a href="/maintainance/images/page-image-7.jpg"
                 data-size="900x600">
                <img class="img-responsive" src="/maintainance/images/page-image-7.jpg"
                     alt="Image description"/>
              </a>

              <span class="img-title"></span>
              <span class="img-description"></span>
              <span class="img-overlay"></span>
            </figure>
            <!-- /End Image 3 -->

            <!-- Image 4 -->
            <figure class="col-xs-6 img-hover-effect">
              <a href="/maintainance/images/page-image-4.jpg"
                 data-size="900x600">
                <img class="img-responsive" src="/maintainance/images/page-image-4.jpg"
                     alt="Image description"/>
              </a>
              <span class="img-title"></span>
              <span class="img-description"></span>
              <span class="img-overlay"></span>
            </figure>
            <!-- /End Image 4 -->

          </div>
          <!-- /End Gallery -->

        </section>


        <!-- ----------------------------
             Contact Section
        --------------------------------- -->

        <section id="contact" class="p-t-30">
          <div class="row">
            <div class="col-sm-8 col-sm-offset-2">

              <!-- Headline -->
              <div class="wrap-line border-dark">
                <h3>Contact</h3>
              </div>
              <!-- /End Headline -->

              <!-- Description -->
              <div class="p-t-b-15  text-grey">
                <p>We launch our new website soon.<br>
                  Please stay updated and follow.</p>
              </div>
              <!-- /End Description -->

              <!-- Arrow -->
              <div class="p-t-b-40">
                <i class="icon icon-sm icon-arrows-slim-down-dashed"></i>
              </div>
              <!-- /End Arrow -->

            </div>
          </div>

          <div class="row">
            <div class="col-lg-10 col-lg-offset-1 col-sm-12">
              <div class="row">
                <div class="col-sm-4 col-xs-6 p-t-b-5">

                  <!-- Icon -->
                  <div class="p-t-b-15">
                    <i class="icon icon-lg icon-basic-geolocalize-01"></i>
                  </div>
                  <!-- /End Icon -->

                  <!-- Address -->
                  <div class="p-t-b-15">
                    <h4>Address</h4>
                    <p>16b, Adewunmi Adebimpe Street Lekki Phase 1, Lagos Nigeria</p>
                  </div>
                  <!-- /End Address -->

                </div>

                <div class="col-sm-4 col-xs-6 p-t-b-5">

                  <!-- Icon -->
                  <div class="p-t-b-15">
                    <i class="icon icon-lg icon-basic-smartphone"></i>
                  </div>
                  <!-- /End Icon -->

                  <!-- Address -->
                  <div class="p-t-b-15">
                    <h4>Direct</h4>

                    <p>T. <a href="tel:+234(1)4535942">+234(1)4535942</a><br>
                  </div>
                  <!-- /End Address -->

                </div>

                <div class="col-sm-4  col-sm-offset-0 col-xs-6 col-xs-offset-3 p-t-b-5">

                  <!-- Icon -->
                  <div class="p-t-b-15">
                    <i class="icon icon-lg icon-basic-globe"></i>
                  </div>
                  <!-- /End Icon -->

                  <!-- Address -->
                  <div class="p-t-b-15">
                    <h4>Email</h4>

                    <p><a href="mailto:">info@myshortlet.com</a><br>
                  </div>
                  <!-- /End Address -->

                </div>
              </div>
            </div>
          </div>

          <div class="row no-gutters p-t-30 map">
            <div id="map" class="col-sm-12"></div>
          </div>

          <!-- Contact Alert -->
          <div id="message-contact" class="message-wrapper text-white message">
            <i class="icon icon-sm icon-arrows-slim-right-dashed"></i>
            <span class="message-text"></span>
          </div>
          <!-- /End Contact Alert -->

        </section>

      </div>
    </div>
  </div>

</div>
<!-- /#page -->
<div id="photoswipe"></div>

<!-- Scripts -->
<script src="/maintainance/js/plugins/jquery1.11.2.min.js"></script>
<script src="/maintainance/js/plugins/bootstrap.min.js"></script>
<script src="/maintainance/js/plugins/scrollreveal.min.js"></script>
<script src="/maintainance/js/plugins/contact-form.js"></script>
<script src="/maintainance/js/plugins/newsletter-form.js"></script>
<script src="/maintainance/js/plugins/jquery.ajaxchimp.min.js"></script>
<script src="/maintainance/js/plugins/photoswipe/photoswipe.min.js"></script>
<script src="/maintainance/js/plugins/photoswipe/photoswipe-ui-default.min.js"></script>
<script src="/maintainance/js/plugins/jquery.countdown.min.js"></script>
<script src="/maintainance/js/plugins/prefixfree.min.js"></script>

<!-- Custom Script -->
<script src="/maintainance/js/custom.js"></script>


<!-- Google Analytics -->
<script>
  

</script>

</body>
</html>
