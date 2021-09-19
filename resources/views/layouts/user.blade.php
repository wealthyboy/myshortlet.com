@inject('helper', 'App\Http\Helper')
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Material Dashboard by Creative Tim
  </title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

      <!-- Main CSS File -->
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

   <link href="/css/account_styles.css?version={{ str_random(6) }}" rel="stylesheet">
  </head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="white" data-image="../assets/img/sidebar-1.jpg">
      <div class="logo">
         <a href="/" class="simple-text logo-normal">
           <div class="logo-small">
               <img width="100" height="100" src="{{ $system_settings->logo_path() }}" class="img-fluid">
            </div>
         </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
         <li class="nav-item {{ $helper->active_link(['account']) }} ">
            <a class="nav-link" href="/account">
              <i class="material-icons">dashboard</i>
              <p>Dashboard</p>
            </a>
         </li>
         <li class="nav-item {{ $helper->active_link(['reservations']) }} ">
            <a class="nav-link" href="/reservations">
              <i class="material-icons">holiday_village</i>
              <p>My Bookings</p>
            </a>
         </li>
         <li class="nav-item {{ $helper->active_link(['properties']) }} ">
            <a class="nav-link" href="/properties">
              <i class="material-icons">apartment</i>
              <p>Listings</p>
            </a>
          </li>

          <li class="nav-item {{ $helper->active_link(['change']) }} ">
            <a class="nav-link" href="/change/password">
              <i class="material-icons">password</i>
              <p>Change Password</p>
            </a>
          </li>
          
          <li class="nav-item {{ $helper->active_link(['profile']) }} ">
            <a class="nav-link" href="/profile">
              <i class="material-icons">person_outline</i>
              <p>Profile</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="/rents">
              <i class="material-icons">receipt</i>
              <p>Rents</p>
            </a>
          </li>


          <li class="nav-item ">
            <a class="nav-link" href="/saved">
              <i class="material-icons">favorite</i>
              <p>Saved</p>
            </a>
          </li>
          
          <li class="nav-item ">
            <a class="nav-link" 
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form-nav').submit();" href="#">
              <i class="material-icons">logout</i>
              <p>Logout</p>
            </a>
            <form id="logout-form-nav" action="/logout" method="POST" style="display: none;">
                                    @csrf
                                </form>

          </li>

          
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:;">Dashboard</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
           
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="javascript:;">
                  <i class="material-icons">dashboard</i>
                  <p class="d-lg-none d-md-block">
                    Stats
                  </p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">notifications</i>
                  <span class="notification">5</span>
                  <p class="d-lg-none d-md-block">
                    Some Actions
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#"></a>
                 
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">person</i>
                  <p class="d-lg-none d-md-block">
                    Account
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <a href="#"  class="dropdown-item"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                Log out
                                </a>
                                <form id="logout-form" action="/logout" method="POST" style="display: none;">
                                    @csrf
                                </form>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
          @yield('content')
      </div>
      <footer class="footer">
        <div class="container-fluid">
          <nav class="float-left">
            <ul>
              <li>
                <a href="">
                  About Us
                </a>
              </li>
             
            </ul>
          </nav>
          <div class="copyright float-right">
            © Copyright <a href="{{ Config('app.url') }}"> {{ Config('app.name') }}</a>  {{ date('Y') }}. All rights reserved.
          </div>
        </div>
      </footer>
    </div>
  </div>
  

   <script src="/js/popper.min.js" type="text/javascript"></script>
   <script src="/js/services_js.js"></script>
 
</body>

</html>