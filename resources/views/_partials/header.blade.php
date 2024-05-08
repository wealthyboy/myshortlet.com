<div class="container-fluid">

    <div class="navbar-translate d-flex justify-content-between w-100 fixed-top">
        <a href="/" class="navbar-brand">
            <div class="logo-small">

                <img src="/images/logo/avnmont-white-04.png" alt="" srcset="">

                @if(isset($show_logo) && $show_logo)
                @else
                @endif
            </div>

        </a>



        <div class="d-flex justify-content-center align-items-center">
            @guest
            <a href="/login" class="d-none d-lg-block text-white bold-2 mr-4">
                Login
            </a>
            @endguest

            @auth
            <a href="/account" class="d-none d-lg-block text-white bold-2 mr-4">
                Account
            </a>
            @endauth



            @if(isset($show_book) && !$show_book)
            <!-- <div id="currencyDropdown" class="dropdown">
                <button class="btn bold-2 btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                    ({{-- session('switch') !== null ?  session('switch') : 'NGN' --}}) Currency
                </button>
                <div class="dropdown-menu bg-white">
                    <a class="dropdown-item my-1 px-0 border-bottom " href="?currency=USD">(USD) United States Dollar</a>
                    <a class="dropdown-item my-1 px-0 border-bottom " href="?currency=NGN">(NGN) Nigerian Naira</a>
                </div>
            </div> -->
            @endif


            @if(isset($show_book) && $show_book)
            <a href="/apartments" class="align-self-center mr-3  d-none d-lg-block font-weight-bold btn-primary bold-3 btn text-white  ">
                Book Now
            </a>
            @endif



            <button class="navbar-toggler d-block text-white border-none" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="sr-only">Toggle navigation</span>
                <span class="navbar-toggler-icon text-white"></span>
                <span class="navbar-toggler-icon text-white"></span>
                <span class="navbar-toggler-icon text-white"></span>
            </button>
        </div>


    </div>

    <div class="collapse navbar-collapse ">

        <ul class="nav navbar-nav navbar-center w-100 mt-5">
            <li class="w-100 py-3 font-weight-bold">
                <a href="/apartments">Residences</a>
            </li>

            <li class="w-100  font-weight-bold">
                <a href="/experience">Experience & Amenities</a>
            </li>

            <li class="w-100  py-3 font-weight-bold">
                <a href="/gallery">Gallery</a>
            </li>

            <li class="w-100 py-  font-weight-bold">
                <a href="/about-us">About Us</a>
            </li>

            <li class="w-100 py-3  font-weight-bold">
                <a target="_blank" href="https://theluxurysale.com">Shop @avm</a>
            </li>

            <li class="w-100  font-weight-bold ">
                <a href="/login">Login</a>
            </li>
        </ul>
    </div>
</div>
@include('_partials.svg')