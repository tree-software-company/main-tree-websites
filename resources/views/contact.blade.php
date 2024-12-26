@extends('layouts.app')

@section('content')
    <div class="contact-page">
        <h1>{{ $data['title'] }}</h1>

        @if (session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif

        <form action="{{ route('contact.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">{{ __('message.FullName') }}:</label>
                <input type="text" id="name" name="name" required>
                @error('name') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="email">{{ __('message.Email') }}:</label>
                <input type="email" id="email" name="email" required>
                @error('email') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="message">{{ __('message.message') }}:</label>
                <textarea id="message" name="message" rows="5" required></textarea>
                @error('message') <p class="error">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="btn-submit">Send</button>
        </form>
    </div>
@endsection
