<div class="container">
    <div class="navbar-translate">
    <a href="/" class="navbar-brand">
        <div class="logo-small">
            <img src="{{ $system_settings->logo_path() }}" class="img-fluid">
        </div>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="sr-only">Toggle navigation</span>
        <span class="navbar-toggler-icon"></span>
        <span class="navbar-toggler-icon"></span>
        <span class="navbar-toggler-icon"></span>
    </button>
    </div>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li class=" nav-item">
            <a href="javascript:;" class="nav-link">
            <i class="material-icons">gite</i>

            Become a host
            </a>
            </li>
            <li class="nav-item">
            <a href="javascript:;" class="nav-link">
                <i class="material-icons">attach_money</i>
            </a>
            </li>
            @guest

            <li class="nav-item">
            <a  data-toggle="modal" href="#" data-to="login"  data-target="#loadModal" class="nav-link auth-form">
                <i class="material-icons">login</i>
                Login
            </a>
            </li>
            @endguest

            @auth
            <li class="dropdown nav-item">
            <a href="#" class="profile-photo dropdown-toggle nav-link" data-toggle="dropdown">
                <div class="profile-photo-small">
                    <img src="/images/svg/baseline_person_outline_black_24dp.png" alt="Circle Image" class="rounded-circle img-fluid">
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="/account" class="dropdown-item">Account</a>
                <a href="/profile" class="dropdown-item">Profile</a>
                <a href="/bookings" class="dropdown-item">Bookings</a>
                <a href="#" onclick="event.preventDefault();
                        document.getElementById('logout-form-nav').submit();"
                            class="dropdown-item">
                    <i class="material-icons">logout</i>

                    Sign out
                </a>
                <form id="logout-form-nav" action="/logout" method="POST" style="display: none;">
                        @csrf
                    </form>

            </div>
            </li>
            @endauth

        </ul>
    </div>
</div>
@include('_partials.svg')
