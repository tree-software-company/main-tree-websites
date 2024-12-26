@extends('layouts.app')

@section('content')
    <div class="search-results-container">
        <h1>{{ __('message.searchResults') }} "{{ $keyword }}"</h1>
        @if($results && count($results) > 0)
            <ul class="search-results-list">
                @foreach($results as $result)
                    <li class="search-result-item">
                        @if($result['lang']==$data['lang'])
                            <h2><a href="{{ $result['url'] }}">{{ $result['meta_title'] }}</a></h2>
                            <p>{{ $result['meta_description'] }}</p>
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <p>{{ __('message.noRecords') }}</p>
        @endif
    </div>
@endsection