<div class="container-fluid" itemscope itemtype="https://schema.org/SiteNavigationElement">
    <div class="navbar-translate d-flex justify-content-between w-100 fixed-top">
        <a href="/luxury-service-apartments-in-lagos" class="navbar-brand" itemprop="url">
            <div class="logo-small">
                <img src="/images/logo/avnmont-white-04.png" alt="" itemprop="logo" srcset="">
                @if(isset($show_logo) && $show_logo)
                @else
                @endif
            </div>
        </a>
        <div class="d-flex justify-content-center align-items-center">
            @guest
            <a href="/login" class="d-none d-lg-block text-white bold-2 mr-4" itemprop="url">Login</a>
            @endguest
            @auth
            <a href="/account" class="d-none d-lg-block text-white bold-2 mr-4" itemprop="url">Account</a>
            @endauth
            @if ( auth()->check() && auth()->user()->isAdmin() )
            @if(isset($show_book) && !$show_book)
            @php
                $currencyOptions = [
                    'USD' => [
                        'name' => 'United States Dollar',
                        'flag' => asset('images/flags/us.svg'),
                    ],
                    'NGN' => [
                        'name' => 'Nigerian Naira',
                        'flag' => asset('images/flags/ng.svg'),
                    ],
                ];
                $activeCurrencyCode = strtoupper((string) (session('switch') ?: \App\Http\Helper::getIsoCode() ?: 'USD'));
                $activeCurrency = $currencyOptions[$activeCurrencyCode] ?? $currencyOptions['USD'];
            @endphp
            <div id="currencyDropdown" class="dropdown">
                <button class="btn bold-2 btn-secondary dropdown-toggle currency-selector" type="button" data-toggle="dropdown" aria-expanded="false" aria-label="Change currency">
                    <img class="currency-flag" src="{{ $activeCurrency['flag'] }}" alt="">
                    <span class="currency-code">{{ $activeCurrencyCode }}</span>
                </button>
                <div class="dropdown-menu bg-white currency-menu">
                    @foreach($currencyOptions as $currencyCode => $currencyOption)
                    <a class="dropdown-item currency-option my-1 border-bottom" href="?currency={{ $currencyCode }}">
                        <img class="currency-flag" src="{{ $currencyOption['flag'] }}" alt="">
                        <span>
                            <strong>{{ $currencyCode }}</strong>
                            <small>{{ $currencyOption['name'] }}</small>
                        </span>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
            @endif

            @if(isset($show_book) && $show_book)
            <a href="/apartments" class="align-self-center mr-3 d-none d-lg-block font-weight-bold btn-primary bold-3 btn text-white" itemprop="url">Book Now</a>
            @endif
            <button class="navbar-toggler d-block text-white border-none" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="sr-only">Toggle navigation</span>
                <span class="navbar-toggler-icon text-white"></span>
                <span class="navbar-toggler-icon text-white"></span>
                <span class="navbar-toggler-icon text-white"></span>
            </button>
        </div>
    </div>
    <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-center w-100 mt-5">
            <li class="w-100 py-3 font-weight-bold" itemprop="name">
                <a href="/luxury-service-apartments-in-ikoyi" itemprop="url">Apartments</a>
            </li>
            <li class="w-100 font-weight-bold" itemprop="name">
                <a href="/experience" itemprop="url">Experience & Amenities</a>
            </li>
            <li class="w-100 py-3 font-weight-bold" itemprop="name">
                <a href="/gallery" itemprop="url">Gallery</a>
            </li>
            <li class="w-100 py- font-weight-bold" itemprop="name">
                <a href="/about-us" itemprop="url">About Us</a>
            </li>
            <li class="w-100 py-3 font-weight-bold" itemprop="name">
                <a target="_blank" href="https://theluxurysale.com" itemprop="url">Shop @avm</a>
            </li>
            <li class="w-100 font-weight-bold" itemprop="name">
                <a href="/login" itemprop="url">Login</a>
            </li>
        </ul>
    </div>
</div>
@include('_partials.svg')