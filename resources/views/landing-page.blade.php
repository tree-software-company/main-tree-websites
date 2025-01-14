@extends('layouts.app')

@section('content')

<div class="landing-page">
  <div class="content">
    <div class="hero">
      <h1>{{$data['title']}}</h1>
      <p class="tagline">{{$data['subtitle']}}</p>
    </div>

    <div class="product-description">
      <h2>{{$data['title_section_1']}}</h2>
      <p>{{$data['subtitle_section_1']}}</p>
      <ul>
        @foreach($data['list_in_section_1'] as $feature)
          <li>{{$feature}}</li>
        @endforeach
      </ul>
    </div>

    <div class="photo-ads">
      <h2>{{$data['title_section_2']}}</h2>
      <div class="ads-container">
        @foreach($data['photos_src_section_2'] as $ad)
          <div class="ad">
            <img src="{{$ad[0]}}" alt="{{ $ad[1] }}">
          </div>
        @endforeach
      </div>
    </div>

    <div class="faq">
      <h2>{{$data['title_section_3']}}</h2>
      <div class="accordion">
        @foreach($data['Q&A'] as $faq)
          <div class="accordion-item">
            <button class="accordion-question">{{ $faq[0] }} <i class="icon-circle-down"></i></button>
            <div class="accordion-answer">
              <p>{!! nl2br(e($faq[1])) !!}</p>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <button class="btn-ota">{{ __('message.RegisterNow') }}</button>

    @if (session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="registration-form">
      <span class="icon-cross close-form"></span> 
      <h2>{{ __('message.Registration') }}</h2>
      <form action="{{ route('register-product.submit') }}" method="POST">
        @csrf
        <div class="form-group">
          <label for="name">{{ __('message.FullName') }}</label>
          <input type="text" name="name" id="name" required>
        </div>
        <div class="form-group">
          <label for="email">{{ __('message.Email') }}</label>
          <input type="email" name="email" id="email" required>
        </div>
        <input type="hidden" name="product" value="{{ $data['subpage_name'] }}">
        <button type="submit" class="btn-submit">{{ __('message.Register') }}</button>
      </form>
    </div>
  </div>
</div>

@endsection
