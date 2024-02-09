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
            <a href="/login" class="align-self-center font-weight-bold btn-primary bold-3 btn text-white px-3 py-1 rounded ">
                <i class="fal fa-sign-in"></i>
                Login
            </a>
            @endguest

            @auth
            <a href="/account" class="align-self-center font-weight-bold btn-primary bold-3 btn text-white px-3 py-1 rounded ">
                <i class="fal fa-sign-in"></i>
                Account
            </a>
            @endauth

            <a href="/login" class="align-self-center font-weight-bold btn-primary bold-3 btn text-white px-5 py-1 rounded ">
                <i class="fal fa-sign-in"></i>
                Book Now
            </a>

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
                <a href="/experience">Experience</a>
            </li>

            <li class="w-100 py-3  font-weight-bold">
                <a href="/about-us">About Us</a>
            </li>

            <li class="w-100   font-weight-bold">
                <a target="_blank" href="https://theluxurysale.com">Shop @avm</a>
            </li>
        </ul>
    </div>
</div>
@include('_partials.svg')