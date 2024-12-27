@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $data['title'] }}</h1>
    <span>
        {!! nl2br(e($data['legal_document'])) !!}
    </span>
</div>
@endsection