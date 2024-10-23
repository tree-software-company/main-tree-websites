@extends('layouts.app')
<div class="continer">
    <nav class="navigation-desktop">
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
    </nav>
</div>

