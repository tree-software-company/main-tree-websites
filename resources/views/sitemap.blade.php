@extends('layouts.app')

@section('content')
<div class="sitemap">
    <h1>{{ __('message.sitemap') }}</h1>
    <ul>
        <li><a href="/{{ app()->getLocale() }}/">{{ __('message.homePage') }}</a></li>
        <li><a href="/{{ app()->getLocale() }}/business">{{ __('message.treeForBusiness') }}</a></li>
        <li><a href="/{{ app()->getLocale() }}/education">{{ __('message.treeForEducation') }}</a></li>
        <li><a href="/{{ app()->getLocale() }}/contact">{{ __('message.contactUs') }}</a></li>
        <li><a href="/{{ app()->getLocale() }}/legal">{{ __('message.legal') }}</a></li>
        <li><a href="/{{ app()->getLocale() }}/legal/privacy">{{ __('message.privacyPolicy') }}</a></li>
    </ul>
</div>
@endsection