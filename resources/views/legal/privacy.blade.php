@extends('layouts.app')

@section('content')
<div class="legal-document">
    <h1>{{ __('message.privacyPolicy') }}</h1>
    <span>
        <!-- Your privacy policy text goes here -->
        {{ __('Your privacy policy content in a span.') }}
    </span>
</div>
@endsection