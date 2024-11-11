<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('storage/img/logos/favicon.jpeg') }}" type="image/x-icon">
    <title>Tree</title>

    <!-- Scripts -->
    @viteReactRefresh
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="{{ app()->getLocale() }}">
    <!-- desktop header -->
    <header class="navigation-desktop">
        <nav class="navbar">
            <div class="logo">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('storage/img/logos/logo.png') }}" alt="logo" height="35px"/>
                </a>
            </div>
            <div class="navigation-desktop">
                <div class="software">
                    <button class="software-button">{{ __('message.software') }}</button>
                    <div class="software-dropdown">
                        <a href="/beauty-booking">{{ __('message.beautyBooking') }}</a>
                        <a href="/beauty-booking-pro">{{ __('message.beautyBookingPro') }}</a>
                    </div>
                </div>
                <a href="/support">{{ __('message.support') }}</a>
                <div class="search">
                    <button class="search-button">
                        <i class="icon-search"></i>
                    </button>
                    <div class="search-dropdown">
                        <input type="text" placeholder="Search...">
                    </div>
                </div>
                <div class="account">
                    <button class="account-button">
                        <i class="icon-user"></i>
                    </button>
                    <div class="account-dropdown">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/home') }}" class="navigation-desktop-item home">Home</a>
                            @else
                                <a href="{{ route('login') }}" class="navigation-desktop-item log-in">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="navigation-desktop-item register">Register</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- mobile header -->

    <header class="navigation-mobile">
        <nav class="navbar">
            <div class="logo-mobile">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('storage/img/logos/logo.png') }}" alt="logo" height="35px"/>
                </a>
            </div>
            <div class="navigation-mobile">
                <div class="search mobile-nav__link">
                    <div class="search-button-mobile">
                        <i class="icon-search"></i>
                    </div>
                    <div class="search-dropdown-mobile">
                        <i class="icon-cross close"></i>
                        <div class="dropdown__items">
                            <input type="text" placeholder="Search...">
                        </div>
                    </div>
                </div>
                <div class="account mobile-nav__link">
                    <div class="account-button-mobile">
                        <i class="icon-user"></i>
                    </div>
                    <div class="account-dropdown-mobile">
                        <i class="icon-cross close"></i>
                        <div class="dropdown__items">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/home') }}" class="navigation-desktop-item home">Home</a>
                                @else
                                    <a href="{{ route('login') }}" class="navigation-desktop-item log-in">Log in</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="navigation-desktop-item register">Register</a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>
                </div>
                <div class="show-more mobile-nav__link">
                    <div class="menu-show-more">
                        <div class="menu-button-mobile">
                            <i class="icon-menu"></i>
                            <div class="menu-dropdown-mobile">
                                <i class="icon-cross close"></i>
                                <div class="dropdown__items">
                                    <button class="software-button">{{ __('message.software') }}</button>
                                    <div class="software-dropdown">
                                        <a href="/beauty-booking">{{ __('message.beautyBooking') }}</a>
                                        <a href="/beauty-booking-pro">{{ __('message.beautyBookingPro') }}</a>
                                    </div>
                                    <a href="/support">{{ __('message.support') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>
    <section class="footer-first">
        <div class="footer-first__text">
            @yield('Footercontent')
            <div class="footer-first__columns">
                <div class="footer-first__column">
                    <h2 class="title">{{ __('message.account') }}</h2>
                </div>
                <div class="footer-first__column">
                    <h2 class="title">{{ __('message.software') }}</h2>
                </div>
                <div class="footer-first__column">
                    <h2 class="title">{{ __('message.treeStore') }}</h2>
                </div>
                <div class="footer-first__column">
                    <h2 class="title">{{ __('message.forBusiness') }}</h2>
                    <h2 class="title">{{ __('message.forEducation') }}</h2>
                </div>
                <div class="footer-first__column">
                    <h2 class="title">{{ __('message.aboutUs') }}</h2>
                </div>
            </div>
        </div>
    </section>
    <footer class="footer-second">
        <div class="footer-links">
            <div class="footer-links-first__column">
                <span class="text">{{ __('message.copyright') }}</span>
            </div>
            <div class="footer-links-second__column">
                <a href="/privacy">{{ __('message.privacyPolicy') }}</a>
                <a href="/legal">{{ __('message.legal') }}</a>
                <a href="/sitemap">{{ __('message.sitemap') }}</a>
            </div>
            <div class="footer-links-third__column">
                <a href="/contact">{{ __('message.region') }}</a>
            </div>
        </div>
    </footer>

</body>
</html>
