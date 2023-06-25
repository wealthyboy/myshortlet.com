<div class="container-fluid">

    <div class="navbar-translate d-flex justify-content-between w-100 fixed-top">
        <a href="/" class="navbar-brand">
            <div class="logo-small">
                <img src="{{ $system_settings->logo_path() }}" class="img-fluid">
            </div>
        </a>

        <div class="d-flex">
            @if(isset($show_logo) && $show_logo)
            <a href="/apartments" class="align-self-center text-white  bg-dark px-3 py-1">
                <i class="fal fa-sign-in"></i>
                Book Now
            </a>
            @endif


            <button class="navbar-toggler d-block text-white" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="sr-only">Toggle navigation</span>
                <span class="navbar-toggler-icon text-white"></span>
                <span class="navbar-toggler-icon text-white"></span>
                <span class="navbar-toggler-icon text-white"></span>
            </button>
        </div>


    </div>

    <div class="collapse navbar-collapse ">

        <ul class="nav navbar-nav navbar-center w-100 mt-5">
            <li class="w-100 py-3">
                <a href="/apartments">Residences</a>
            </li>
            <li class="w-100 ">
                <a href="/about-us">About Us</a>
            </li>
            <li class="w-100 py-3">
                <a href="/experience">Experience</a>
            </li>

            <li class="w-100 py-3">
                <a target="_blank" href="https://theluxurysale.com">Shop @avm</a>
            </li>
        </ul>
    </div>
</div>
@include('_partials.svg')