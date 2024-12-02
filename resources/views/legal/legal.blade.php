@extends('layouts.app')

@section('content')
<div class="legal-documents">
    <h1>{{ __('message.websiteTerms') }}</h1>
    <ul>
        @if($page)
            @foreach($page as $legal)
                @if($legal['lang'] == $data['lang'] && $legal['controller_name'] == 'legal.documents')
                    <li><a href="/{{$legal['url']}}">{{ $legal['subpage_name'] }}</a></li>
                @endif
            @endforeach
        @endif
    </ul>
</div>
@endsection