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

    <header class="navigation-desktop">
        <nav class="navbar">
            <div class="logo">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('storage/img/logos/logo.png') }}" alt="logo" height="35px"/>
                </a>
            </div>
            <div class="navigation-desktop">
                <a href="/software">{{ __('message.software') }}</a>
                <a href="/support">{{ __('message.support') }}</a>
                <div class="search">
                    <button class="search-button">Search</button>
                    <div class="search-dropdown">
                        <input type="text" placeholder="Search...">
                    </div>
                </div>
                <div class="account">
                    <button class="account-button">Account</button>
                    <div class="account-dropdown">
                        @if (Route::has('login'))
                        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                            @auth
                                <a href="{{ url('/home') }}" class="navigation-desktop-item home">Home</a>
                            @else
                                <a href="{{ route('login') }}" class="navigation-desktop-item log-in">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="navigation-desktop-item register">Register</a>
                                @endif
                            @endauth
                        </div>
                    @endif
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
            <span class="text">test</span>
            <div class="footer-first__links">
                
            </div>
        </div>
    </section>
    <footer class="footer-second">
        <div class="footer-links">
            <span>© 2021 Tree. All rights reserved.</span>
            <a href="/about">About Us</a>
            <a href="/privacy">{{ __('message.privacyPolicy') }}</a>
            <a href="/terms">{{ __('message.termsOfService') }}</a>
        </div>
    </footer>

</body>
</html>
