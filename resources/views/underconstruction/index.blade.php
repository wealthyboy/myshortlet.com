<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>{{ Config('app.name') }} Coming soon</title>
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
  <link rel="stylesheet" href="/maintainance/css/icons/font-awesome.css">
  <link rel="stylesheet" href="/maintainance/css/icons/linea.css">

  <!-- Google Fonts -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700">

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

<body data-spy="scroll" data-target=".scrollspy" class="bg-dark">

  <!-- Preloader  -->
  <div class="loader bg-dark">
    <div class="loader-inner ball-scale-ripple-multiple ball-scale-ripple-multiple-bw">
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
    <div class="overlay" />
    <!-- Image BG -->
    <div class="section-overlay media page-image-bw reveal scale-in"></div>
    <!-- /End Image BG -->

    <!-- Overlay BG -->
    <div class="section-overlay bg-black page-image-bw overlay-opacity-3"></div>
    <!-- /End Overlay BG -->

    <!-- Modal -->
    <div id="modal-notify" class="modal fade modal-scale" tabindex="-1" role="dialog" aria-labelledby="meinModalLabel">

      <!-- .modal-dialog -->
      <div class="modal-dialog" role="document">
        <div>

          <!-- .modal-content -->
          <div class="modal-content text-center bg-dark text-light">
            <button class="button-close" data-dismiss="modal" aria-label="Close"><i class="icon icon-lg icon-arrows-remove"></i></button>


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

              <form id="mc-form">

                <!-- Input Group -->
                <div class="input-group">
                  <input type="email" id="email" class="form-control form-control-light" name="email" placeholder="Enter your Email here...">
                  <span class="input-group-btn">
                    <button type="submit" class="btn btn-white"><i class="icon icon-sm icon-arrows-slim-right-dashed"></i>
                    </button>
                  </span>
                </div>
                <!-- /End Input Group -->

                <!-- Message Alert -->
                <div id="message-newsletter" class="message-wrapper text-white message">

                  <span><i class="icon icon-sm icon-arrows-slim-right-dashed"></i><label class="message-text" for="email"></label></span>
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
            <div class="col-md-12 text-white col-transform">
              <div class="navbar-wrapper">

                <!-- Navbar Button -->
                <button class="navbar-button show-info" data-href="#content">
                  <span></span>
                  <span></span>
                  <span></span>
                </button>
                <!-- /End Navbar Button -->

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

        <div id="info" class="col-md-12 text-white text-center page-info col-transform">
          <div class="vert-middle">
            <div class="reveal scale-out">

              <!-- Logo -->
              <div class="p-t-b-15">
                <img src="https://drive.google.com/thumbnail?id=1eQ_hLe9Th_2Oew3Qoew_qQKhuGBpHGZm&sz=w2000" height="86" width="70" alt="">
              </div>
              <!-- /End Logo -->

              <div class="p-t-b-15">
                <!-- Headline & Description -->
                <h2><span class="font-weight-200">We're launching our</span><br>new Website</h2>

                <p><br>We're
                  working hard to give you the best experience!<br>
                </p>
                <!-- /End Headline & Description -->
              </div>
              <!-- Arrow -->
              <div class="p-t-b-20">
                <i class="icon icon-sm icon-arrows-slim-down-dashed"></i>
              </div>
              <!-- /End Arrow -->

              <!-- Buttons -->
              <div class="p-t-b-15 btn-row">
                <button class="btn btn-white" data-toggle="modal" data-target="#modal-notify" role="button">Notify me
                </button>
                <a class="btn btn-border-white show-info" role="button" data-href="#content">
                  More info
                </a>
              </div>
              <!-- /End Buttons -->

              <!-- Social Media Links -->
              <div class="p-t-b-30">
                <p>
                  <a href="https://www.facebook.com/" class="link-white"><i class="fa fa-facebook"></i></a>
                  <a href="https://twitter.com/egotype" class="link-white"><i class="fa fa-twitter"></i></a>
                </p>
              </div>
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
                  <p>Our mission is to provide our customers with the highest level of quality service of any Real Estate company at a very affordable rate thereby ensuring that properties are sold or leased in a flawless manner. We strive to deliver professional services to clients and customers so that transactions are completed to the satisfaction of all concerned.”</p>
                </div>
                <!-- /End Description -->

                <!-- Social Media Links -->
                <div class="p-t-b-15">
                  <p>
                    <a href="#" target="_blank">
                      <i class="fa fa-facebook"></i></a>
                    <a href="#" target="_blank">
                      <i class="fa fa-twitter"></i></a>
                    <a href="https://www.instagram.com/royalbnbproperties" target="_blank">
                      <i class="fa fa-instagram"></i></a>
                  </p>
                </div>
                <!-- /End Social Media Links -->

              </div>
            </div>

            <!-- Gallery -->
            <div class="gallery row no-gutters p-t-b-30">


              <!-- /End Image 1 -->

              <!-- Image 2 -->
              <figure class="col-xs-6 img-hover-effect">
                <a href="https://royalbnbproperties.com/uploads/tlsu10XUQd7Qf4lDZ4pmsSQcc3pzalSRxEKZi9hs.jpg" data-size="900x600">
                  <img class="img-responsive" src="https://royalbnbproperties.com/uploads/tlsu10XUQd7Qf4lDZ4pmsSQcc3pzalSRxEKZi9hs.jpg" alt="Image description" />
                </a>

              </figure>
              <!-- /End Image 2 -->

              <!-- Image 3 -->
              <figure class="col-xs-6 img-hover-effect">
                <a href="https://royalbnbproperties.com/uploads/d42Yqh18SeNtH7p41BOePzmk63Y85xxSr1J4VVwJ.jpg" data-size="900x600">
                  <img class="img-responsive" src="https://royalbnbproperties.com/uploads/d42Yqh18SeNtH7p41BOePzmk63Y85xxSr1J4VVwJ.jpg" alt="Image description" />
                </a>

              </figure>
              <!-- /End Image 3 -->


            </div>
            <!-- /End Gallery -->

          </section>


          <!-- ----------------------------
             Contact Section
        --------------------------------- -->

          <section id="contact" class="p-t-b-30">
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

                      <p>37 cooper road ikoyi, Lagos<br>
                      </p>
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

                      <p>T. <a href="#">Tel: +234 701 897 1322</a><br>
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

                      <p><a href="mailto:">info@thecentralavenue.ng</a><br>
                    </div>
                    <!-- /End Address -->

                  </div>
                </div>
              </div>
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