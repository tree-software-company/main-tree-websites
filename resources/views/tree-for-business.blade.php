@extends('layouts.app')

@section('content')
    <div class="cooperation-section">
        <div class="container">
            <h1>{{ $data['title'] }}</h1>
            <p>
                {{ $data['short_description_1'] }}
            </p>
            <h2>{{ $data['title_section_1'] }}</h2>
            <ul>
                @if($data['list_section_1'])
                    @foreach($data['list_section_1'] as $list)
                        <li>{{ $list }}</li>
                    @endforeach
                @endif
            </ul>
            <p>
                {{ $data['short_description_2'] }}
            </p>
            <div class="cta-button">
                <a href="{{ $data['lang'] }}/contact" class="btn-primary">{{ __('message.contactUsToLearnMore') }}</a>
            </div>
        </div>
    </div>
@endsection