@extends('layouts.app')

@section('content')
<div class="legal-documents">
    <h1>{{ __('message.websiteTerms') }}</h1>
    <ul>
        <li><a href="/{{ app()->getLocale() }}/legal/privacy">{{ __('message.privacyPolicy') }}</a></li>
    </ul>
</div>
@endsection