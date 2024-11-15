@extends('layouts.app')

@section('content')
    <div class="contact-page">
        <h1>Contact Us</h1>

        @if (session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif

        <form action="#" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                @error('name') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                @error('message') <p class="error">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="btn-submit">Send</button>
        </form>
    </div>
@endsection