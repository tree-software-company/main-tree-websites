@extends('layouts.app')

@section('content')
<div class="sitemap">
    <h1>{{ __('message.sitemap') }}</h1>
    <ul>
        @if($page)
            @foreach ($page as $item)
                @if($item['lang'] == $data['lang'] && $item['subpage_name'])
                    <li><a href="/{{ $item['url'] }}">{{ $item['subpage_name'] }}</a></li>
                @endif
            @endforeach
        @endif
    </ul>
</div>
@endsection