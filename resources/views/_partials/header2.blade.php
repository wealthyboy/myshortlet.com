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



        <div class="d-flex">
            @guest
            <a href="/login" class="align-self-center  text-white bold-3 font-weight-bold  px-3 py-1 mr-2">
                Login
            </a>
            @endguest

            @auth
            <a href="/account" class="align-self-center bold-3  text-white font-weight-bold  px-3 py-1 mr-2">
                Account
            </a>
            @endauth


            @if(isset($show_logo) && $show_logo)
            <a href="/apartments" class="align-self-center font-weight-bold  text-white px-3 py-1">
                Book Now
            </a>
            @endif


            <button class="navbar-toggler d-block text-white" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="sr-only">Toggle navigation</span>
                <span class="navbar-toggler-icon text-white white-background"></span>
                <span class="navbar-toggler-icon text-white white-background"></span>
                <span class="navbar-toggler-icon text-white white-background"></span>
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
        </ul>
    </div>
</div>
@include('_partials.svg')