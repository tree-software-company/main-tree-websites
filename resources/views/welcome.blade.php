@extends('layouts.app')

@section('content')
        <div class="banners">
            @if(isset($data['Banners'][0]))
                <a href="{{$data['Banners'][0][1]}}" class="banner">
                    <img src="{{$data['Banners'][0][0]}}" width="100%" height="auto" alt="{{$data['Banners'][0][2]}}" />
                    <div class="banner-text">{{ __('message.learnMore') }}</div>
                </a>
            @endif

            @if(isset($data['Banners'][1]))
                <a href="{{$data['Banners'][1][1]}}" class="banner">
                    <img src="{{$data['Banners'][1][0]}}" width="100%" height="auto" loading="lazy" alt="{{$data['Banners'][1][2]}}" />
                    <div class="banner-text">{{ __('message.learnMore') }}</div>
                </a>
            @endif

            @if(isset($data['Banners'][2]))
                <a href="{{$data['Banners'][2][1]}}" class="banner">
                    <img src="{{$data['Banners'][2][0]}}" width="100%" height="auto" loading="lazy" alt="{{$data['Banners'][2][2]}}" />
                    <div class="banner-text">{{ __('message.learnMore') }}</div>
                </a>
            @endif
        </div>
    
    <div class="products">
        <div class="row">
            @if(isset($data['Banners'][3]))
                <a href="{{$data['Banners'][3][1]}}" class="column">
                    <img src="{{$data['Banners'][3][0]}}" width="100%" height="auto" loading="lazy" alt="{{$data['Banners'][3][2]}}" />
                    <div class="column-text">{{ __('message.learnMore') }}</div>
                </a>
            @endif
            @if(isset($data['Banners'][4]))
                <a href="{{$data['Banners'][4][1]}}" class="column">
                    <img src="{{$data['Banners'][4][0]}}" width="100%" height="auto" loading="lazy" alt="{{$data['Banners'][4][2]}}" />
                    <div class="column-text">{{ __('message.learnMore') }}</div>
                </a>
            @endif
        </div>
        <div class="row">
            @if(isset($data['Banners'][5]))
                <a href="{{$data['Banners'][5][1]}}" class="column">
                    <img src="{{$data['Banners'][5][0]}}" width="100%" height="auto" loading="lazy" alt="{{$data['Banners'][5][2]}}" />
                    <div class="column-text">{{ __('message.learnMore') }}</div>
                </a>
            @endif
            @if(isset($data['Banners'][6]))
                <a href="{{$data['Banners'][6][1]}}" class="column">
                    <img src="{{$data['Banners'][6][0]}}" width="100%" height="auto" loading="lazy" alt="{{$data['Banners'][6][2]}}" />
                    <div class="column-text">{{ __('message.learnMore') }}</div>
                </a>
            @endif
        </div>
        <div class="row">
            @if(isset($data['Banners'][7]))
                <a href="{{$data['Banners'][7][1]}}" class="column">
                    <img src="{{$data['Banners'][7][0]}}" width="100%" height="auto" loading="lazy" alt="{{$data['Banners'][7][2]}}" />
                    <div class="column-text">{{ __('message.learnMore') }}</div>
                </a>
            @endif
            @if(isset($data['Banners'][8]))
                <a href="{{$data['Banners'][8][1]}}" class="column">
                    <img src="{{$data['Banners'][8][0]}}" width="100%" height="auto" loading="lazy"  alt="{{$data['Banners'][8][2]}}" />
                    <div class="column-text">{{ __('message.learnMore') }}</div>
                </a>
            @endif
        </div>
    </div>

    <div class="sliders">
        <div class="slider short-slider">
            @if(isset($data['short_slider']))
                @foreach($data['short_slider'] as $slider)
                    <a href="{{$slider[0]}}" class="slider-item">
                        <img src="{{$slider[1]}}" loading="lazy" alt="{{$slider[2]}}" />
                    </a>
                @endforeach
            @endif
        </div>
        <div class="slider long-slider">
            @if(isset($data['long_slider']))
                @foreach($data['long_slider'] as $slider)
                    <a href="{{$slider[0]}}" class="slider-item">
                        <img src="{{$slider[1]}}"  loading="lazy"alt="{{$slider[2]}}" />
                    </a>
                @endforeach
            @endif
        </div>
    </div>
@endsection

@section('Footercontent')
    <span class="text">{!! nl2br(e($data['footer_content'])) !!}</span>
@endsection
