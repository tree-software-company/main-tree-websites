@extends('layouts.login')

@section('content')
    <div class="container">
        <h1>Edytuj swoje dane</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('user.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user['email']['S'] ?? '') }}">
            </div>

            <div class="form-group">
                <label for="phone">Telefon</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user['phone']['S'] ?? '') }}">
            </div>

            <div class="form-group">
                <label for="first_name">Imię</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $user['first_name']['S'] ?? '') }}">
            </div>

            <div class="form-group">
                <label for="last_name">Nazwisko</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $user['last_name']['S'] ?? '') }}">
            </div>

            <div class="form-group">
                <label for="birthday">Data urodzenia</label>
                <input type="date" class="form-control" id="birthday" name="birthday" value="{{ old('birthday', $user['birthday']['S'] ?? '') }}">
            </div>

            <div class="form-group">
                <label for="country">Kraj</label>
                <input type="text" class="form-control" id="country" name="country" value="{{ old('country', $user['country']['S'] ?? '') }}">
            </div>

            <!-- Password typically shouldn't be displayed in plain text -->
            <div class="form-group">
                <label for="password">Nowe hasło</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
        </form>
    </div>
@endsection
