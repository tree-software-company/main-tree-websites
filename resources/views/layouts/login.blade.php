<?php
    $favicon = 'logo-background.jpeg';
    $faviconUrl = Storage::disk('s3')->url($favicon);
?>

<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ $faviconUrl }}" type="image/x-icon">
    <title>Tree</title>

    @viteReactRefresh
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="{{ app()->getLocale() }} light">

    <header class="navigation-desktop">
        <nav class="navbar">
            <div class="logo">
                <a href="/{{ app()->getLocale() }}/">
                    <img src="{{ $logoUrl }}" alt="logo" height="35px"/>
                </a>
            </div>
            <div class="navigation-desktop">
                <div class="software">
                    <button class="software-button">{{ __('message.software') }}</button>
                    <div class="software-dropdown">
                        <a href="/{{ app()->getLocale() }}/beauty-booking">{{ __('message.beautyBooking') }}</a>
                        <a href="/{{ app()->getLocale() }}/beauty-booking-pro">{{ __('message.beautyBookingPro') }}</a>
                    </div>
                </div>
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
                            <a href="{{ url('/logout') }}" class="navigation-desktop-item home">{{ __('message.singOut') }}</a>
                            @else
                                <a href="{{ route('login') }}" class="navigation-desktop-item log-in">{{ __('message.singIn') }}</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="navigation-desktop-item register">{{ __('message.Register') }}</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <header class="navigation-mobile">
        <nav class="navbar">
            <div class="logo-mobile">
                <a href="/{{ app()->getLocale() }}/">
                    <img src="{{ $logoUrl }}" alt="logo" height="35px"/>
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
                                <a href="{{ url('/logout') }}" class="navigation-desktop-item home">{{ __('message.singOut') }}</a>
                                @else
                                    <a href="{{ route('login') }}" class="navigation-desktop-item log-in">{{ __('message.singIn') }}</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="navigation-desktop-item register">{{ __('message.Register') }}</a>
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
                        </div>
                        <div class="menu-dropdown-mobile">
                            <i class="icon-cross close"></i>
                            <div class="dropdown__items">
                                <div class="accordion-navigation">
                                    <div class="accordion-navigation__items">
                                        <div class="accordion-header-navigation">
                                            <span class="text">{{ __('message.software') }}</span>
                                            <i class="icon-circle-down"></i>
                                        </div>
                                        <div class="accordion-content-navigation">
                                            <a class="accordion-navigation__item" href="/{{ app()->getLocale() }}/beauty-booking">{{ __('message.beautyBooking') }}</a>
                                            <a class="accordion-navigation__item" href="/{{ app()->getLocale() }}/beauty-booking-pro">{{ __('message.beautyBookingPro') }}</a>
                                        </div>
                                    </div>
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
                    <div classAccount
                    ="footer-first__header accordion-header">
                        <i class="icon-circle-down"></i>
                        <h2 class="title"> {{ __('message.account') }}</h2>
                    </div>
                    <div class="footer-first__links accordion-content">
                        <a href="/user/edit">{{ __('message.manageAccount') }}</a>
                    </div>
                </div>
                <div class="footer-first__column">
                    <div class="footer-first__header accordion-header">
                        <i class="icon-circle-down"></i>
                        <h2 class="title accordion-header"> {{ __('message.software') }}</h2>
                    </div>
                    <div class="footer-first__links accordion-content">
                        <a href="/{{ app()->getLocale() }}/beauty-booking">{{ __('message.beautyBooking') }}</a>
                        <a href="/{{ app()->getLocale() }}/beauty-booking-pro">{{ __('message.beautyBookingPro') }}</a>
                    </div>
                </div>
                <div class="footer-first__column">
                    <div class="footer-first__header accordion-header">
                        <i class="icon-circle-down"></i>
                        <h2 class="title accordion-header"> {{ __('message.forBusiness') }}</h2>
                    </div>
                    <div class="footer-first__links accordion-content">
                        <a href="/{{ app()->getLocale() }}/business">{{ __('message.treeForBusiness') }}</a>
                    </div>
                </div>
                <div class="footer-first__column">
                    <div class="footer-first__header accordion-header">
                        <i class="icon-circle-down"></i>
                        <h2 class="title accordion-header"> {{ __('message.forEducation') }}</h2>
                    </div>
                    <div class="footer-first__links accordion-content">
                        <a href="/{{ app()->getLocale() }}/education">{{ __('message.treeForEducation') }}</a>
                    </div>
                </div>
                <div class="footer-first__column">
                    <div class="footer-first__header accordion-header">
                        <i class="icon-circle-down"></i>
                        <h2 class="title accordion-header"> {{ __('message.aboutUs') }}</h2>
                    </div>
                    <div class="footer-first__links accordion-content">
                        <a href="/{{ app()->getLocale() }}/contact">{{ __('message.contactUs') }}</a>
                    </div>
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
                <a href="/{{ app()->getLocale() }}/legal/privacy">{{ __('message.privacyPolicy') }}</a>
                <a href="/{{ app()->getLocale() }}/legal">{{ __('message.legal') }}</a>
                <a href="/{{ app()->getLocale() }}/sitemap">{{ __('message.sitemap') }}</a>
            </div>
            <div class="footer-links-third__column">
                <a href="/choose-country-region">{{ __('message.region') }}</a>
            </div>
        </div>
    </footer>

</body>
</html>
